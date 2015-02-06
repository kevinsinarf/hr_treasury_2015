<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
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
//POST
$PER_ID=$_POST['PER_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"); 
//MAIN
$sql = "SELECT * FROM PER_SPECIALHIS a WHERE a.DELETE_FLAG='0' AND  SPECHIS_ID = '".$SPECHIS_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);



$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND CT_TYPE = '1' ", "CT_NAME_TH");
$arr_movement = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", "ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND MOVEMENT_GROUP = '1'", "MOVEMENT_SEQ");
$arr_special = GetSqlSelectArray("SPECIAL_ID", "SPECIAL_NAME_TH", "PER_SETUP_SPECIAL", "ACTIVE_STATUS = '1' AND DELETE_FLAG = '0'", "SPECIAL_SEQ");


//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");

if($POSTYPE_ID==1||$POSTYPE_ID==5){
	$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '".$POSTYPE_ID."' ", "LG_NAME_TH");

}
if($POSTYPE_ID==1 || $POSTYPE_ID== 5 ){
//ตำแหน่งในสายงาน
	$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0' AND ACTIVE_STATUS = 1 AND LG_ID = '".$rec['LG_ID']."'", "LINE_NAME_TH");
}else{
	$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND ACTIVE_STATUS = 1  AND LEVEL_ID = '".$rec['LEVEL_ID']."'", "LINE_NAME_TH");
}


$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND MT_ID = '".$rec['MT_ID']."' ");
//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_SEQ");

//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_1']."' ", "ORG_SEQ");

//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "ORG_SEQ");
//สำหรับส่วนราบการ
$arr_org1_type =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_SEQ");

//org2
$arr_org2_type =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['REWHIS_ORG_ID_1']."' ", "ORG_SEQ");

//org3
$arr_org3_type =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['REWHIS_ORG_ID_2']."' ", "ORG_SEQ");


//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "ORG_SEQ");
//org5
$arr_org5=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.ACTIVE_STATUS='1'  AND a.ORG_PARENT_ID='".$rec['ORG_ID_4']."'  ", "ORG_SEQ");

//โครงการที่ให้บริการราชการพิเศษ
$arr_service_title=GetSqlSelectArray("STI_ID", "STI_NAME_TH", "SETUP_SERVICE_TITLE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "STI_NAME_TH");

//ตำแหน่งที่ให้บริการราชการ
$arr_service_type=GetSqlSelectArray("STY_ID", "STY_NAME_TH", "SETUP_SERVICE_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "STY_NAME_TH");
$arr_type_mt = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ", "MT_SEQ"); 
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
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
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
<script src="js/profile_servicehis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  
	  <li><a href="profile_servicehis.php?<?php echo url2code($link2); ?>">ประวัติการปฏิบัติราชการพิเศษ</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
    <div class="clearfix"></div>

        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="SPECHIS_ID" name="SPECHIS_ID" value="<?php echo $SPECHIS_ID?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID; ?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
   		<?php if($proc=="add"){
				unset($rec);
			}?>
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                        <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                         ข้อมูลคำสั่ง
                    </a>
                </div>
            </div>
            
            <div id="collapse1" class="collapse in">
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทคำสั่ง : </div>
                    <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('CT_ID','CT_ID',$arr_command_type,'ประเภทคำสั่ง',$rec['CT_ID'],'','','1');?></div> 
                    <div class="col-xs-12 col-sm-1"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทความเคลื่อนไหว : </div>
                    <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('MOVEMENT_ID','MOVEMENT_ID',$arr_movement,'ประเภทความเคลื่อนไหว',$rec['MOVEMENT_ID'],'','','1');?></div> 
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เลขที่คำสั่ง : <span style="color:red;"></span></div>
                    <div class="col-xs-12 col-sm-2"><?php echo $rec['COM_NO'];?></div> 
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ลงวันที่ : </div>
                    <div class="col-xs-12 col-sm-2">
                    	<div class="input-group">
                             <?php echo conv_date($rec["COM_DATE"]);?>
                             
                        </div>
                    </div> 
                </div>
                
                <div class="row formSep">
                <!--  <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่บันทึก : </div>
                    <div class="col-xs-12 col-sm-2">
                    	<div class="input-group">
                            <input type="text" id="X" name="X" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec["X"]);?>">
                            <span class="input-group-addon datepicker" for="XS" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>
                    </div> 
                    <div class="col-xs-12 col-sm-2"></div>-->
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่มีผล : </div>
                    <div class="col-xs-12 col-sm-2">
                    	<div class="input-group">
								<?php echo conv_date($rec["COM_SDATE"]);?>
                             
                        </div>
                    </div> 
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">โครงการ : </div>
                    <div class="col-xs-12 col-sm-6"><?php echo $rec['SPECHIS_PROJECT'];?></div> 
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทการให้บริการราชการพิเศษ : </div>
                    <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect_v2('SPECHIS_TYPE','SPECHIS_TYPE',$arr_special_type,'ประเภทการให้บริการราชการพิเศษ',$rec['SPECHIS_TYPE'],'onchange="getPosition(this.value);"','','1','','2');?></div> 
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่ง :  </div>
                    <div class="col-xs-12 col-sm-3"><span id="shw_pos"><?php echo GetHtmlSelect_v2('SPECIAL_ID','SPECIAL_ID',$arr_special,'ตำแหน่ง',$rec['SPECIAL_ID'],'','','1','','1');?></span></div> 
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถานะของการปฏิบัติราชการพิเศษ : </div>
                    <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v2('SPECHIS_ETYPE','SPECHIS_ETYPE',$arr_special_etype,'สถานะของการปฏิบัติราชการพิเศษ',$rec['SPECHIS_ETYPE'],'','','1','','2');?></div> 
                    <div class="col-xs-12 col-sm-1"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่แล้วเสร็จ/สิ้นสุด : </div>
                    <div class="col-xs-12 col-sm-2">
                  		<div class="input-group">
                             <?php echo conv_date($rec["SPECHIS_EDATE"]);?>
                            
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                        <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
                         ข้อมูลตำแหน่งขณะปฏิบัติราชการพิเศษ
                    </a>
                </div>
            </div>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['pos_no']; ?>  :  </div>
            <div class="col-xs-12 col-md-3">
                 <?php  echo text($rec["POS_NO"]); ?>
          	</div>
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง : </div>
            <div class="col-xs-12 col-sm-3">
				<?php  echo GetHtmlSelect_v('ORG_ID_1','ORG_ID_1',$arr_org1,'กระทรวง',$rec['ORG_ID_1'], " onchange='getORG(this);' ",'','');?>
            </div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม/สำนักงาน : </div>
            <div class="col-xs-12 col-sm-3">
				<?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'กรม/สำนักงาน',$rec['ORG_ID_2'],"onchange='getORG(this);' ",'','');?>
            </div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สำนัก/กอง/กลุ่ม : </div>
            <div class="col-xs-12 col-sm-3">
     			<?php echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'สำนัก/กอง/กลุ่ม',$rec['ORG_ID_3'],"onchange='getORG(this);'",'','1');?>
            </div> 
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กลุ่มงาน/ส่วน : </div>
            <div class="col-xs-12 col-sm-3">
     			<?php echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'กลุ่มงาน/ส่วน',$rec['ORG_ID_4'],"onchange='getORG(this);' ",'','1');?>
            </div> 
            <div class="col-xs-12 col-md-1"></div>
           <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ฝ่าย : </div>
            <div class="col-xs-12 col-sm-3">
     			<?php echo GetHtmlSelect_v('ORG_ID_5','ORG_ID_5',$arr_org5,'ฝ่าย',$rec['ORG_ID_5'],"onchange='getORG(this);' ",'','1');?>
            </div>
        </div>
         <!------------ข้าราชการ---------------------------------------------------------------->  
          <?php if($POSTYPE_ID == 1){ ?>
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทตำแหน่ง : </div>
                        <div class="col-xs-12 col-md-3">
                        	<?php echo GetHtmlSelect_v('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทตำแหน่ง' ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); get_manage(this); ' ",'', '', '300', '1'); ?>
                           
                    	</div>
                    	<div class="col-xs-12 col-md-2 col-md-offset-1" >ระดับตำแหน่ง : </div>
                    	<div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ระดับ' ,$rec['LEVEL_ID'] ,'','', '', '300', '1'); ?></div>
                    </div>
                    
                     <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >สายงาน : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onChange='get_line(this);' ", '', '', '300', '1'); ?></div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่งในสายงาน : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('LINE_ID', 'LINE_ID',$arr_pos_line, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ประเภทตำแหน่งทางการบริหาร : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php  echo GetHtmlSelect_v('MT_ID','MT_ID',$arr_type_mt,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=get_manage(this);','','1');?></div>
                        
                        <div class="col-xs-12 col-md-2 col-md-offset-1" >ตำแหน่งทางการบริหาร : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('MANAGE_ID', 'MANAGE_ID', $arr_manage, 'ตำแหน่งทางการบริหาร' ,$rec['MANAGE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div> 
                       
       
                <?php } ?>
                <!-- พนักงานราชการ -->
                <?php if($POSTYPE_ID == 3){ ?>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2 " >ปีที่อนุมัติกรอบ : </div>
                  <div class="col-xs-12 col-md-3">
							<?php echo $rec['POS_YEAR']; ?>
                  </div>
                   <div class="col-xs-12 col-md-2 col-md-offset-1" >ประเภทพนักงานราชการ : </div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect_v('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทพนักงานราชการ' ,$rec['TYPE_ID'] ," onChange='get_level(this); ' ",'', '', '300', '1'); ?>
                  </div>
                 </div>
                 
                  <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >ประเภทกลุ่มงาน : </div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ประเภทกลุ่มงาน' ,$rec['LEVEL_ID'] ," onChange='get_line(this); ' ",'', '', '300', '1'); ?>
                        </div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่ง : &nbsp;</div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect_v('LINE_ID', 'LINE_ID',$arr_pos_line, 'ตำแหน่ง' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if($POSTYPE_ID == 5){ ?>
                 <div class="row formSep">
                  <div class="col-xs-12 col-md-2 " >กลุ่ม : </div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect_v('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'กลุ่ม' ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); ' ",'', '', '300', '1'); ?>
                  </div>
                  <div class="col-xs-12 col-md-2 col-md-offset-1 " >สายงาน : </div>
                  <div class="col-xs-12 col-md-3">
                  <?php echo $rec['LG_ID'];?>
				  	<?php echo GetHtmlSelect_v('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onChange='get_line(this);' ", '', '', '300', '1'); ?>
                  </div>
                </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2  " >ตำแหน่งในสายงาน : &nbsp;</div>
                  <div class="col-xs-12 col-md-3">
				  	<?php echo GetHtmlSelect_v('LINE_ID', 'LINE_ID',$arr_pos_line, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?>
                  </div>
                  <div class="col-xs-12 col-md-2 col-md-offset-1 " >ระดับตำแหน่ง : &nbsp;</div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ระดับตำแหน่ง' ,$rec['LEVEL_ID'] ," ",'', '', '300', '1'); ?>
                  </div>
                 </div>
              <?php } ?>
         
</div>
</div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>