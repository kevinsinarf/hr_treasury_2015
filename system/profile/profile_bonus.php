<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

if(!empty($_POST['S_ORG_ID_3'])){
	$filter_1 .= " and a.ORG_ID_3 = '".$_POST['S_ORG_ID_3']."'";	
}
if(!empty($_POST['S_ORG_ID_4'])){
	$filter_1 .= " and a.ORG_ID_4 = '".$_POST['S_ORG_ID_4']."'";	
}
if(!empty($_POST['TYPE_ID'] )){
	$filter .= " and a.TYPE_ID = '".$_POST['TYPE_ID']."'";	
}
if(!empty($_POST['S_LINE_ID'])){
	$filter_1 .= " and a.LINE_ID = '".$_POST['S_LINE_ID']."'";	
}
if(!empty($_POST['S_LEVEL_ID'])) {
	$filter_1 .= " and a.LEVEL_ID = '".$_POST['S_LEVEL_ID']."'";	
}
if(!empty($_POST['S_LG_ID'])) {
	$filter_1 .= " and a.S_LG_ID = '".$_POST['S_LG_ID']."'";	
}
if(!empty($_POST['MT_ID'])) {
	$filter_1 .= " and a.MT_ID = '".$_POST['MT_ID']."'";	
}
if(!empty($_POST['MOVEMENT_ID'])) {
	$filter_1.= " and a.MOVEMENT_ID = '".$_POST['MOVEMENT_ID']."'";	
}
//tab active
$ACT=3;

//ประเภทการถือครอง
$arr_poshis_live = array(  
										'1' => 'ปกติ',
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);


$cond_level = ($TYPE_ID != '') ? "AND TYPE_ID = '".$TYPE_ID."'" : "";
$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  ".$cond_level, "LEVEL_SEQ");//ORG
//ประเภทตำแหน่ง
$arr_pos_type =GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = 1", "TYPE_SEQ");


$arr_setup_org3=GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND ORG_PARENT_ID = 15", "ORG_SEQ");//ORG
$cond_org4 = ($S_ORG_ID_3 != '') ? " AND ORG_PARENT_ID = '".$S_ORG_ID_3."'" : "";
$arr_setup_org4=GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  ".$cond_org4, "ORG_SEQ");//ORG

//ประเภทบุคลากร
$arr_personal_type = GetSqlSelectArray("PT_ID", "PT_NAME_TH", "PERSONAL_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PT_NAME_TH");

//ตำแหน่งในสายงาน
$cond_line = ($TYPE_ID != '') ? " AND TYPE_ID = '".$TYPE_ID."'" : "";
$arr_pos_line = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$cond_line."  ", "LINE_NAME_TH");

//ประเภทการเคลื่อนไหว
$arr_mov_type = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND MOVEMENT_GROUP = 3  ", "MOVEMENT_NAME_TH");

$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LG_NAME_TH");


$field = "*";
$table = " PER_BONUSHIS  A ";
$pk_id = "A.BOUNUSHIS_ID";
$wh = "A.DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."' {$filter}";
$orderby = "";
$groupby = "";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh."".$orderby.") ".$groupby." ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin ;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_bonus.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	 
      <li class="active">ประวัติการได้รับเงินรางวัลประจำปี</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <?php include("tab_profile.php");?>
    <div class="grouptab">
      <?php include("tab_info.php");?>
      <div class="clearfix"></div>
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="BOUNUSHIS_ID" name="BOUNUSHIS_ID" value="">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
 <!--       <div class="row">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap">สำนัก/กลุ่ม :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                    <div class="col-xs-12 col-md-3">
                        <?php echo GetHtmlSelect('S_ORG_ID_3', 'S_ORG_ID_3',$arr_setup_org3 , 'สำนัก' ,$S_ORG_ID_3,' onChange="get_org_4_1(this); " ' , '1', '', ''); ?>	
                    </div>
                     <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap">กลุ่มงาน :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                    <div class="col-xs-12 col-md-3">
                        <?php echo GetHtmlSelect('S_ORG_ID_4', 'S_ORG_ID_4',$arr_setup_org4, 'กลุ่มงาน' ,$S_ORG_ID_4,'', '1', '', ''); ?>	
                    </div>    
                    </div>
        <div class="row">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทตำแหน่ง :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                    <div class="col-xs-12 col-md-3">
                        <?php echo GetHtmlSelect('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทตำแหน่ง' ,$TYPE_ID,' onChange="get_line_1(this) ;get_level_1(this);get_lg_1(this);" ', '1', '', ''); ?>	
                    </div>
                     <div class="col-xs-12 col-md-1"></div>
                           <div class="col-xs-12 col-md-2" style="white-space:nowrap">ระดับ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                    <div class="col-xs-12 col-md-3">
                        <?php echo GetHtmlSelect('S_LEVEL_ID', 'S_LEVEL_ID',$arr_level , 'ระดับ' ,$S_LEVEL_ID,'', '1', '', ''); ?>	
                    </div>      
                    </div>
        <div class="row">
        		<div class="col-xs-12 col-md-2" style="white-space:nowrap">สายงาน :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                    <div class="col-xs-12 col-md-3">
                     <?php echo GetHtmlSelect('S_LG_ID', 'S_LG_ID',$arr_pos_line , 'สายงาน' ,$S_LG_ID ,'', '1', '', '');  ?>	
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตำแหน่งในสายงาน :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                      
                    <div class="col-xs-12 col-md-3">
                        <?php echo GetHtmlSelect('S_LINE_ID', 'S_LINE_ID',$arr_pos_line , 'ตำแหน่งในสายงาน' ,$S_LINE_ID ,'', '1', '', '');  ?>	
                    </div>
                   
        </div>       
        <div class="row">
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('MT_ID','MT_ID',$arr_type_mt,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=get_manage(this.value,1);','','1');?></div>  <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_manage'><?php  echo GetHtmlSelect('MANAGE_ID','MANAGE_ID',$arr_type_manage,'ตำแหน่งทางการบริหาร',$rec['MANAGE_ID'],'','','1');?></span></div>       
                    </div>  
        <div class="row">
                    		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทการเคลื่อนไหว : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('MOVEMENT_ID','MOVEMENT_ID',$arr_mov_type,'ประเภทการเคลื่อนไหว',$rec['MOVEMENT_ID'],'','','1');?></div> 
                    </div>-->
                            <!--<div class="row">
                 <div class="col-xs-5 col-md-5"></div>
                            <div class="col-xs-5 col-md-2">
                                <button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
                            </div>
                        </div>-->
         
        
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                  <tr class="bgHead">
                    <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
					<th width="9%"><div align="center"><strong>เลขที่คำสั่ง/ลงวันที่</strong></div></th>
                    <th width="10%"><div align="center"><strong>ประเภทความเคลื่อนไหว</strong></div></th>
                    <th width="13%"><div align="center"><strong>ประเภทการถือครอง</strong></div></th>
                    <th width="8%"><div align="center"><strong>วันที่มีผล</strong></div></th>
					<th width="20%"><div align="center"><strong>ตำแหน่ง</strong></div></th> 
                    <th width="8%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                  </tr>
                </thead>
                <tbody>
			  	<?php
               	if($nums > 0){
                    $i=1;
                    while($rec = $db->db_fetch_array($query)){
                        if($rec['POSHIS_DEFAULT']!="1"){
                            $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["BOUNUSHIS_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
                          
							$position = "<strong>".$arr_txt['pos_no'].": </strong>".$rec['POS_NO']."</br>";
							$position .= "<strong>ประเภทตำแหน่ง: </strong>".text($arr_pos_type[$rec['TYPE_ID']])."</br>";
							$position .= "<strong>ตำแหน่งในสายงาน: </strong>".text($arr_pos_lg[$rec['LG_ID']])."</br>";
							$position .= "<strong>ระดับ: </strong>".text($arr_level[$rec['LEVEL_ID']])."</br>";
							$position .= "<strong>เงินเดือน: </strong>".number_format($rec['SALARY'])."</br>";
                        }
						 ?>
						  <tr bgcolor="#FFFFFF">
							<td align="center"><?php echo $i+$goto; ?>.</td>
							<td align="center"><?php echo "คำสั่ง".text($rec["COM_NO"])."/".conv_date($rec['COM_DATE'],'short'); ?></td>
							<td align="left"><?php echo text($arr_mov_type[$rec['MOVEMENT_ID']]); ?></td>
							<td align="left"><?php echo $arr_poshis_live[$rec["TYPE_LIVE"]]; ?></td>
							<td align="center"><?php echo conv_date($rec["COM_SDATE"], 'short'); ?></td>
							<td align="left"><?php echo $position; ?></td>
							<td align="center" nowrap><?php echo $edit; ?></td>
						  </tr>
						  <?php 				
						  $i++;
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"10\">ไม่พบข้อมูล</td></tr>";
					}
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>