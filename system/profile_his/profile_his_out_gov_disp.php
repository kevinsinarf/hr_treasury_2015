<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 5;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);

$S_COM_SDATE =  $_POST['S_COM_SDATE'];
$S_COM_DATE =  $_POST['S_COM_DATE'];
$S_COM_NO =  $_POST['S_COM_NO'];
if(!empty($S_COM_SDATE)){
	$filter .= " and COM_SDATE = '".conv_date_db($S_COM_SDATE)."'";	
}
if(!empty($S_COM_DATE)){
	$filter .= " and COM_DATE = '".conv_date_db($S_COM_DATE)."'";	
}
if(!empty($S_COM_NO)){
	$filter .= " and COM_NO = '".$S_COM_NO."'";	
}

$field="COM_NO,COM_DATE,COM_TITLE,COM_ID,COM_SDATE,MOVEMENT_ID,RETYPE_TYPE,RETIRE_ID";
$table = "RETIRE_COMMAND";
$pk_id = "RETIRE_ID";
 $wh = "DELETE_FLAG = 0 AND (TRANSFER_STATUS = 0 OR TRANSFER_STATUS IS NULL)   {$filter}";
$orderby = "ORDER BY RETIRE_ID";
$groupby = "";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh."".$orderby.") ".$groupby." ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin ;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh."".$groupby));


$arr_data_status = array(
	"1"=>'รับเรื่อง',
	"2"=>'มีผลการสอบสวนข้อเท็จริงแล้ว',
	"3"=>'มีผลการให้พักราชการไว้ก่อน',
	"4"=>'มีผลการให้ออกจากราชการไว้ก่อน',
	"5"=>'มีผลการสอบสวนทางวินัยแล้ว',
	"6"=>'มีคำสั่งลงโทษทางวินัยแล้ว',
	"7"=>'มีผลการพิจารณา ก.พ. แล้ว',
	"8"=>'มีคำสั่งล้างมลทินแล้ว',
	"9"=>'สิ้นสุดกระบวนงานโดยไม่มีโทษทางวินัย',
);

//ประเภทคำสั่ง
$arr_ct = GetSqlSelectArray( "CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "CT_NAME_TH" ); 

//ประเภทความเคลื่อนไหว
$arr_mov = GetSqlSelectArray("MOVEMENT_ID" , "MOVEMENT_NAME_TH" ,"SETUP_MOVEMENT","ACTIVE_STATUS = 1 AND DELETE_FLAG= 0 AND MOVEMENT_TYPE = 7","MOVEMENT_NAME_TH");

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
<script src="js/profile_his_out_gov_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li class="active"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการออกจากราชการ)</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
        <?php //include("tab_info.php");?>
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>">
        <input type="hidden" id="COM_ID" name="COM_ID" value="">
        <input type="hidden" id="RETYPE_TYPE" name="RETYPE_TYPE" value="">
           <input type="hidden" id="RETIRE_ID" name="RETIRE_ID" value="">
        
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
        	    <div class="row">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :&nbsp;<span style="color:red;"></span>&nbsp;</div>   
                    <div class="col-xs-12 col-md-2">
                       <input type="text" id="S_COM_NO" name="S_COM_NO" class="form-control" placeholder="เลขคำสั่ง" maxlength="100"  value="<?php echo $S_COM_NO;?>" >	
                    </div>
                    </div>	
                <div class="row">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ลงวันที่ : </div>
        	    <div class="col-xs-12 col-sm-2">
            	<div class="input-group">
                    <input type="text" id="S_COM_DATE" name="S_COM_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo $S_COM_DATE;?>">
                    <span class="input-group-addon datepicker" for="S_COM_DATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันทีมีผล : </div>
        	    <div class="col-xs-12 col-sm-2">
            	<div class="input-group">
                    <input type="text" id="S_COM_SDATE" name="S_COM_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo $S_COM_SDATE;?>">
                    <span class="input-group-addon datepicker" for="S_COM_SDATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
            </div>
                  </div>
			
                <div class="row">
                            <div class="col-xs-5 col-md-5"></div>
                            <div class="col-xs-5 col-md-2">
                                <button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
                            </div>
                        </div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table width="397" class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="5%"><div align="center">เลขที่คำสั่ง</div></th>
                  <th width="9%"><div align="center"><strong>ลงวันที่</strong></div></th>
                  <th width="25%"><div align="center"><strong>เรื่อง</strong> </div></th>
                  <th width="8%"><div align="center"><strong>วันที่มีผล</strong></div></th>
                  <th width="8%"><div align="center"><strong>จัดการ</strong></div></th>
                </tr>
              </thead>
			  <tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						$view = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"viewData( '".$rec['RETIRE_ID']."','".$rec["COM_ID"]."','".$rec['RETYPE_TYPE']."');\">".$img_view." ดูรายละเอียด</a> ";
						$name = Showname($rec['INFORM_BY_PREFIX_ID'],$rec['INFORM_BY_FIRSTNAME_TH'],$rec['INFORM_BY_MIDNAME_TH'],$rec['INFORM_BY_LASTNAME_TH']);
						?>
						<tr bgcolor="#FFFFFF">
						  <td align="center"><?php echo $i;?>.</td>
						  <td align="left"><?php echo text($rec["COM_NO"]); ?></td>
						  <td align="center"><?php echo conv_date($rec['COM_DATE'],'short'); ?></td>
						  <td align="left"><?php echo text($rec['COM_TITLE']); ?></td>
						  <td align="center"><?php echo conv_date($rec["COM_SDATE"],'short');?></td>
						  <td align="center"><?php echo $view; ?></td>
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
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>