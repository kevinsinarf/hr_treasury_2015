<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$s_org_4 = $_POST['s_org_4'];

$filter = "";

if($s_idcard != ""){
	$filter .= " and PER_IDCARD like '%".ctext(str_replace("-","",$s_idcard))."%' ";
}
if($s_name != ""){
	$filter .= " and (PER_FIRSTNAME_TH like '%".ctext($s_name)."%' OR PER_MIDNAME_TH like '%".ctext($s_name)."%' OR PER_LASTNAME_TH like '%".ctext($s_name)."%') ";
}
if($s_status != ""){
	$filter .= " and a.ACTIVE_STATUS = '".ctext($s_status)."' ";
}
if($s_org_3 != ""){
	$filter .= " and a.ORG_ID_3 = '".$s_org_3."' ";
}
if($s_org_4 != ""){
	$filter .= " and a.ORG_ID_4 = '".$s_org_4."' ";
}
$POSTYPE_ID=3;
$PT_ID = 2;
$field=" a.PER_ID, a.PER_IDCARD, a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH, a.PREFIX_ID, b.LINE_NAME_TH, c.ORG_NAME_TH, a.ACTIVE_STATUS";
$table="PER_PROFILE a 
		LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID 
		LEFT JOIN SETUP_ORG c ON a.ORG_ID_4 = c.ORG_ID ";
$pk_id=" a.PER_ID";
$wh=" a.DELETE_FLAG='0' AND  a.POSTYPE_ID='".$POSTYPE_ID."' {$filter}";
$orderby="order by a.ACTIVE_STATUS DESC, a.PER_FIRSTNAME_TH , a.PER_MIDNAME_TH, a.PER_LASTNAME_TH  ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

//ประเภทบุคลากร
$arr_personal_type=GetSqlSelectArray("PT_ID", "PT_NAME_TH", "PERSONAL_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PT_NAME_TH");


$arr_setup_org3=GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND ORG_PARENT_ID = 15", "ORG_SEQ");//ORG
$cond_org4 = ($S_ORG_ID_3 != '') ? " AND ORG_PARENT_ID = '".$S_ORG_ID_3."'" : "";
$arr_setup_org4=GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  ".$cond_org4, "ORG_SEQ");//ORG
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
<script src="js/profile_his_empser.js?<?php echo rand(); ?>"></script>
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
        <input type="hidden" id="PER_ID" name="PER_ID" value="">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['name'];?> :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>"></div>
        </div>
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['idcard'];?> :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_idcard" name="s_idcard" class="form-control " placeholder="<?php echo $arr_txt['idcard'];?>" maxlength="13" value="<?php echo $s_idcard; ?>"></div>
			<div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['active'];?> :</div>
			<div class="col-xs-12 col-sm-2">
			    <select id="s_status" name="s_status" class="selectbox form-control" placeholder="--ทั้งหมด--">
			      <option value=""></option>
			      <?php foreach($arr_act_status as $key => $val){?>
			      <option value="<?php echo $key?>" <?php echo ($s_status==$key && $s_status!=''?"selected":"");?>><?php echo $val?></option>
			      <?php }?>
		        </select>
			</div>
        </div>
        
         <div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สำนัก :</div>
			<div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('S_ORG_ID_3', 'S_ORG_ID_3',$arr_setup_org3 , 'สำนัก' ,$S_ORG_ID_3,' onChange="get_org_4(this); " ' , '1', '', ''); ?></div>     
			<div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กลุ่มงาน :</div>
			<div class="col-xs-12 col-sm-2">
              <span id='ss_org4'><?php echo GetHtmlSelect('S_ORG_ID_4', 'S_ORG_ID_4',$arr_setup_org4, 'กลุ่มงาน' ,$S_ORG_ID_4,'', '1', '', '');?></span>
			</div>
            <div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
        </div>

        <div class="row">
			<div class="col-sm-12"><a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> </div>
        </div>
        
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table width="397" class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="10%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="20%"><div align="center"><strong><?php echo $arr_txt['idcard']?> </strong> </div></th>
                  <th width="20%"><div align="center"><strong><?php echo $arr_txt['name']?></strong> </div></th>
                  <th width="15%"><div align="center"><strong>ตำแหน่งในสายงาน</strong> </div></th>
                  <th width="15%"><div align="center"><strong>ระดับส่วน/กลุ่มงาน</strong></div></th>
                  <th width="10%"><div align="center"><strong>สถานะ</strong></div></th>
                  <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                </tr>
				</thead>
				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						//$rec = array_change_key_case($rec,CASE_LOWER);
						$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["PER_ID"]."');\">".$img_edit." ประวัติ</a> ";
						$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["PER_ID"]."');\">".$img_del." ลบ</a> ";
				?>
                <tr bgcolor="#FFFFFF">
                  <td align="center"><?php echo $i+$goto; ?>.</td>
                  <td align="center"><?php echo get_idCard($rec["PER_IDCARD"]); ?></td>
                  <td align="left"><?php echo  text($arr_prefix[$rec["PREFIX_ID"]]).' '.text($rec["PER_FIRSTNAME_TH"]).' '.text($rec["PER_MIDNAME_TH"]).' '.text($rec["PER_LASTNAME_TH"]); ?></td>
                  <td align="left"><?php echo text($rec["LINE_NAME_TH"]); ?></td>
                  <td align="left"><?php echo text($rec["ORG_NAME_TH"]);?></td>
                  <td align="center"><?php echo $arr_act_status[$rec["ACTIVE_STATUS"]]; ?></td>
                  <td align="center"><?php echo $edit.$delete; ?></td>
                </tr>
                <?php 
                        $i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"7\">ไม่พบข้อมูล</td></tr>";
				}
				?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
      </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>