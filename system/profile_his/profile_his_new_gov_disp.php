<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
/*$file =  $path."fileupload/file_applicant/4820140618034358.jpg";
$newfile = $path."fileupload/test/4820140618034358.jpg";

copy($file,$newfile);*/



$filter = "";
if($s_idcard != ""){
	$filter .= " AND C.CAN_IDCARD like '%".ctext(str_replace(" ","",$s_idcard))."%' ";
}
if($s_name != ""){
	$filter .= " AND (C.CAN_FIRSTNAME_TH like '%".ctext($s_name)."%' OR C.CAN_MIDNAME_TH like '%".ctext($s_name)."%' OR C.CAN_LASTNAME_TH like '%".ctext($s_name)."%') ";
}
if($s_org_3 != ""){
	$filter .= " AND D.ORG_ID_3 = '".$s_org_3."' ";
}
if(trim($s_org_4) != "" and trim($s_org_4) != 0 ){
	$filter .= " AND D.ORG_ID_4 = '".$s_org_4."' ";
}

$field=" A.APPOINT_NO, B.APP_ID, C.CAN_IDCARD, C.PREFIX_ID, C.CAN_FIRSTNAME_TH, C.CAN_MIDNAME_TH, C.CAN_LASTNAME_TH,C.FILE_PIC, E.LINE_NAME_TH, G.ORG_NAME_TH, H.LEVEL_NAME_TH ";
$table=" APPOINT_COMMAND A JOIN APPLIED B ON A.APPOINT_ID = B.APPOINT_ID
JOIN CANDIDATE_PROFILE C ON B.CAN_ID = C.CAN_ID
JOIN POSITION_FRAME D ON B.POS_ID = D.POS_ID
LEFT JOIN SETUP_POS_LINE E ON D.LINE_ID = E.LINE_ID
LEFT JOIN SETUP_ORG G ON D.ORG_ID_4 = G.ORG_ID
LEFT JOIN SETUP_POS_LEVEL H ON D.LEVEL_ID = H.LEVEL_ID";

$wh=" A.DELETE_FLAG='0' AND A.APPOINT_TYPE_PERSON = 1 AND TRANSFER_STATUS = 0 {$filter}";
$groupby = " GROUP BY A.APPOINT_NO, B.APP_ID, C.CAN_IDCARD, C.PREFIX_ID, C.CAN_FIRSTNAME_TH, C.CAN_MIDNAME_TH, C.CAN_LASTNAME_TH, E.LINE_NAME_TH, G.ORG_NAME_TH, H.LEVEL_NAME_TH,C.FILE_PIC ";
$orderby="order by C.CAN_FIRSTNAME_TH ";
 $sql = "select  ".$field." from ".$table." where ".$wh.$groupby.$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='15'  ", "case when ORG_SEQ is null then 1 else 0 end, ORG_SEQ ASC");
//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$s_org_3."'  ", "ORG_SEQ");
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_new_gov_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li class="active"><?php echo Showmenu($menu_sub_id);?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata">
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="APP_ID" name="APP_ID" value="">
		
		<div class="row">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['idcard'];?> :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_idcard" name="s_idcard" class="form-control " placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $s_idcard; ?>" style=" width:300px;"></div>
			<div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['name'];?> :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>" style=" width:300px;" ></div>
        </div>
          
        <div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สำนัก :</div>
			<div class="col-xs-12 col-sm-3">
           		<?php  echo GetHtmlSelect('s_org_3','s_org_3',$arr_org3,'สำนัก',$s_org_3," onChange='getOrg(this);' ",'','1');?>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กลุ่มงาน :</div>
			<div class="col-xs-12 col-sm-3">
              <?php  echo GetHtmlSelect('s_org_4','s_org_4',$arr_org4,'กลุ่มงาน',$s_org_4,'','','1');?>
			</div>
        </div>
       <div class="col-xs-12 col-sm-12" style="text-align:center; margin:10px;">
       	<button type="button" class="btn btn-primary"  onClick="searchData();">ค้นหา</button>
       </div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table width="397" class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="4%"><div align="center"><input id="chkAll" name="chkAll" type="checkbox" value=""  onClick="chkAllCheck(this);"></div></th>
                  <th width="12%"><div align="center"><strong><?php echo $arr_txt['idcard']?> </strong> </div></th>
                  <th width="18%"><div align="center"><strong><?php echo $arr_txt['name']?></strong> </div></th>
                  <th width="13%"><div align="center"><strong>ระดับตำแหน่ง</strong> </div></th>
                  <th width="15%"><div align="center"><strong>ตำแหน่งในสายงาน</strong> </div></th>
                  <th width="15%"><div align="center"><strong>ระดับส่วน/กลุ่มงาน</strong></div></th>
                  <th width="10%"><div align="center"><strong>เลขที่คำสั่งบรรจุ</strong></div></th>
                </tr>
				</thead>
				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						?>
						<tr bgcolor="#FFFFFF">
						  <td align="center"><input name="APP_ID[]" type="checkbox" value="<?php echo $rec['APP_ID']; ?>"></td>
						  <td align="center"><?php echo (get_idCard($rec["CAN_IDCARD"])); ?></td>
						  <td align="left"><?php echo  text($arr_prefix[$rec["PREFIX_ID"]]).' '.text($rec["CAN_FIRSTNAME_TH"]).' '.text($rec["CAN_MIDNAME_TH"]).' '.text($rec["CAN_LASTNAME_TH"]); ?></td>
						  <td align="left"><?php echo text($rec["LEVEL_NAME_TH"]); ?></td>
                          <td align="left"><?php echo text($rec["LINE_NAME_TH"]); ?></td>
						  <td align="left"><?php echo text($rec["ORG_NAME_TH"]);?></td>
                          <td align="center"><?php echo text($rec["APPOINT_NO"]);?><input type="hidden" name="FILE_PIC_NEW[]" id="FILE_PIC_NEW_<?php echo $rec['APP_ID']; ?>"   value="<?php echo !empty($rec["FILE_PIC"])?text($rec["FILE_PIC"]):""; ?>"></td>
						  
						</tr>
						<?php 
                        $i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"8\">ไม่พบข้อมูล</td></tr>";
				}
				?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-xs-12 col-sm-12" align="center">
            <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
        </div>
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>