<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if($s_date != ""){
	$filter .= " and a.REQUEST_DATETIME = '".conv_date_db($s_date)."' ";
}
if($s_name != ""){
	$filter .= " and (c.PER_FIRSTNAME_TH like '%".ctext($s_name)."%' OR c.PER_MIDNAME_TH like '%".ctext($s_name)."%' OR c.PER_LASTNAME_TH like '%".ctext($s_name)."%') ";
}
if($s_table_id != ""){
	$filter .= " and a.REQUEST_TABLE_ID = '".ctext($s_table_id)."' ";
}
if($s_status != ""){
	$filter .= " and a.REQUEST_STATUS = '".ctext($s_status)."' ";
}

$field=" a.REQUEST_ID, a.PER_ID, c.PREFIX_ID, c.PER_FIRSTNAME_TH, c.PER_MIDNAME_TH, c.PER_LASTNAME_TH, CONVERT(DATE,a.REQUEST_DATETIME) as REQUEST_DATETIME, a.REQUEST_TABLE_ID, a.REQUEST_APP_DATE, a.REQUEST_STATUS, a.REQUEST_RESULT, b.TABLE_NAME, b.TABLE_DESCRIPTION";
$table="PER_REQUEST a
		LEFT JOIN PER_TABLE_LIST b ON a.REQUEST_TABLE_ID = b.TABLE_ID 
		INNER JOIN PER_PROFILE c ON a.PER_ID = c.PER_ID";
$pk_id="REQUEST_ID";
$wh=" a.DELETE_FLAG='0' {$filter}";
$orderby="order by  a.REQUEST_STATUS ASC, a.REQUEST_DATETIME DESC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

//ประเภทบุคลากร
$arr_personal_type=GetSqlSelectArray("PT_ID", "PT_NAME_TH", "PERSONAL_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PT_NAME_TH");
//ข้อมูลที่ขอเปลี่ยนแปลง
$arr_request_table=GetSqlSelectArray("TABLE_ID", "TABLE_DESCRIPTION", "PER_TABLE_LIST", " 1=1 ", "TABLE_DESCRIPTION");
//คำนำหน้าชื่อ
$arr_fix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "SETUP_PREFIX", "ACTIVE_STATUS = '1' and DELETE_FLAG='0'", "PREFIX_ID  ,PREFIX_NAME_TH");
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
<script src="js/profile_approvehis.js?<?php echo rand(); ?>"></script>
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
		<input type="hidden" id="REQUEST_ID" name="REQUEST_ID" value="">
        <input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
                <div class="row ">
                    <div class="col-xs-12 col-sm-2 " style="white-space:nowrap;">วันที่ขอเปลี่ยนแปลง&nbsp;&nbsp;</div>
                    <div class="col-xs-12 col-sm-2">
                        <div class="input-group">
                            <input type="text" id="s_date" name="s_date" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo  $s_date;?>">
                            <span class="input-group-addon datepicker" for="s_date" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>						
                    </div>
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อ-สกุล&nbsp;:&nbsp;</div>
                    <div class="col-xs-12 col-sm-3">
                        <input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['fname']; ?>" maxlength="100" value="<?php echo $s_name; ?>">
                    </div>
                </div>  
                
                <div class="row ">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ข้อมูลที่ขอเปลี่ยนแปลง&nbsp;&nbsp;</div>
                    <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('s_table_id','s_table_id',$arr_request_table,'ข้อมูลที่ขอเปลี่ยนแปลง',$s_table_id,'','','1');?></div>
                    <div class="col-xs-12 col-sm-1"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สถานะ&nbsp;:&nbsp;&nbsp;</div>
                    <div class="col-xs-12 col-sm-2">
                        <select id="s_status" name="s_status" class="selectbox form-control" placeholder="--ทั้งหมด--">
                       		<option value=""></option>
                            <?php foreach($arr_request_status as $key => $val){?>
                            <option value="<?php echo $key?>" <?php echo ($s_status==$key && $s_status!=''?"selected":"");?>><?php echo $val?></option>
                            <?php }?>
                     	</select>
                    </div>
                    <div class="col-xs-12 col-sm-1"></div>
                    
                </div>  
                
                <div class="row ">
                    <div class="col-xs-12 col-sm-12" align="center"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
                </div>
				 
                <div class="row">
                <?php echo @(ceil($total_record/$page_size) > 1) ? startPaging("frm-search",$total_record):""; ?>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12"> 
                        <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="#" onClick="addData();">
                        <?php echo $img_save;?> เพิ่มข้อมูล</a> 
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr class="bgHead"> 
                                       <th width="5%"><div align="center"><strong><?php echo "ลำดับ";?></strong></div></th>
                                       <th width="20%" ><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                                   	   <th width="13%" ><div align="center"><strong>วันที่ขอเปลี่ยนแปลง</strong></div></th>
                                       <th width="25%" ><div align="center"><strong>ข้อมูลที่ขอเปลี่ยนแปลง</strong></div></th>
                                       <th width="12%" ><div align="center"><strong>สถานะ</strong></div></th>
                                       <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($nums > 0){
                                        $i=1;
                                        while($rec = $db->db_fetch_array($query)){
											//$rec = array_change_key_case($rec,CASE_LOWER);
											$approve = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"#\" onClick=\"approveData('".$rec["REQUEST_ID"]."','".$rec["REQUEST_TABLE_ID"]."');\"><span class=\"glyphicon glyphicon-saved\"></span> อนุมัติ</a> ";
											?>
											<tr bgcolor="#FFFFFF">
												<td align="center"><?php echo $i+$goto; ?></td>
												<td align="left" style="padding-left:10px"><?php echo  Showname($rec["PREFIX_ID"], $rec["PER_FIRSTNAME_TH"], $rec["PER_MIDNAME_TH"], $rec["PER_LASTNAME_TH"]); ?></td>
												 <td align="center"><?php echo conv_date($rec["REQUEST_DATETIME"],'short'); ?></td>
												 <td align="left" style="padding-left:10px"><?php echo  text($arr_request_table[$rec["REQUEST_TABLE_ID"]]); ?></td>
												<td align="center"><?php echo $arr_request_result[$rec["REQUEST_RESULT"]]; ?></td>
												<td align="center"><?php echo $rec["REQUEST_RESULT"]==1?$approve:"-"; ?></td>
											</tr>
											<?php 
                                       		$i++;
                                        }
                                    }else{
                                        echo "<tr><td align=\"center\" colspan=\"7\">".$arr_txt['data_not_found']."</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
               		</div> 
             	</div>
                <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
            </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>

</body>
</html>