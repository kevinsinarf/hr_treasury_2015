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
$POSHIS_ID=$_POST['POSHIS_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"); 
//MAIN
$sql = "SELECT A.ORG_ID_1,A.ORG_ID_2,A.ORG_ID_3,A.ORG_ID_4,A.ORG_ID_5,B.CT_ID, B.CT_NAME_TH, C.MOVEMENT_NAME_TH ,C.MOVEMENT_ID,A.COM_NO ,A.COM_DATE ,A.POSHIS_DATE, A.COM_SDATE ,A.TYPE_LIVE,A.ACTIVE_STATUS,A.POSHIS_NOTE,A.POS_NO,D.ORG_NAME_TH,E.LG_NAME_TH,F.LINE_NAME_TH,G.MT_NAME_TH,H.MANAGE_NAME_TH ,A.SALARY ,A.SALARY_POSITION, A.COMPENSATION_1 ,A.COMPENSATION_2, A.COMPENSATION_3,A.COMPENSATION_5 ,A.TYPE_ID ,A.LEVEL_ID,A.LG_ID,A.LINE_ID,A.MT_ID,A.MANAGE_ID,A.POS_NO,A.POS_YEAR
FROM PER_POSITIONHIS A 
LEFT JOIN SETUP_COMMAND_TYPE  B ON  A.CT_ID = B.CT_ID
LEFT JOIN SETUP_MOVEMENT C ON  A.MOVEMENT_ID = C.MOVEMENT_ID
LEFT JOIN SETUP_ORG D  ON  A.ORG_ID_1 = D.ORG_ID 
LEFT JOIN SETUP_POS_LINE_GROUP E ON E.LG_ID = A.LG_ID
LEFT JOIN SETUP_POS_LINE F ON F.LINE_ID = A.LINE_ID
LEFT JOIN SETUP_POS_MANAGE_TYPE G ON G.MT_ID = A.MT_ID
LEFT JOIN SETUP_POS_MANAGE H ON H.MANAGE_ID = A.MANAGE_ID
WHERE POSHIS_ID = '".$POSHIS_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
if($POSTYPE_ID==1||$POSTYPE_ID==5){
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
}else{
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'   AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
}
if($POSTYPE_ID==1||$POSTYPE_ID==5){
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LG_ID = '".$rec['LG_ID']."'", "LINE_NAME_TH");
}else{
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."'", "LINE_NAME_TH");	
}
if($POSTYPE_ID==3){
	//ตำแหน่งพนักงานราชการ
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LEVEL_ID = '".$rec['LEVEL_ID']."'", "LINE_NAME_TH");
}
if($POSTYPE_ID==5){
	$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");
}
//สายงาน
$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LG_NAME_TH");

$sql_manage_name='';
if(!empty($rec['TYPE_ID'])){
	$sql_manage_name .= " OR TYPE_ID = ".$rec['TYPE_ID'];
}

$arr_manage=GetSqlSelectArray(
"MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "DELETE_FLAG='0' AND POSTYPE_ID = '1' AND MT_ID = '".$rec['MT_ID']."' ");

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
//org2
if(trim($rec['ORG_ID_1']) != ''){
	$org_id_1 = $rec['ORG_ID_1']; 
}else{
	$org_id_1 = 405;
}
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$org_id_1."' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ ");
//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");

$arr_org5=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.ACTIVE_STATUS='1'  AND a.ORG_PARENT_ID='".$rec['ORG_ID_4']."'  ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
//ประเภทการเคลื่อนไหว
$arr_mov_type = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND  MOVEMENT_TYPE = 5 ","MOVEMENT_NAME_TH");
$arr_type_mt = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ", "MT_SEQ"); 
//ประเภทการถือครอง
$arr_poshis_live = array(  
										'1' => 'ปกติ',
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);
$arr_sarary  = array( '1' => 'ร้อยละ', '2' => 'ขั้น');
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
<script src="js/profile_positionhis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	 
	  <li><a href="profile_positionhis.php?<?php echo url2code($link2); ?>"><?php echo $arr_txt['profile_history']; ?></a></li>
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
		<input type="hidden" id="POSHIS_ID" name="POSHIS_ID" value="<?php echo $POSHIS_ID?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID;?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
          <div class="row ">
    
                    <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                                    <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                                  	<?php echo $arr_txt['profile_history']; ?>
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse1" class="collapse in">
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภท :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('CT_ID','CT_ID',$arr_ct_type1,'ประเภท',$rec['CT_ID'],'"','','1');?></div> 
                <div class="col-xs-12 col-sm-1"></div>
            	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทการเคลื่อนไหว : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('MOVEMENT_ID','MOVEMENT_ID',$arr_mov_type,'ประเภทการเคลื่อนไหว',$rec['MOVEMENT_ID'],'','','1');?></div> 
        </div>
        <div class="row formSep">
        	    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่  :  &nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php echo text($rec['COM_NO']); ?></div><div class="col-xs-12 col-md-1"></div>		
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                           <?php echo $rec["COM_DATE"]==''?'':conv_date(text($rec["COM_DATE"]),''); ?>
                     
                </div>
                </div>
        </div>
        <div class="row formSep">
        	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่บันทึก :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <?php echo $rec["POSHIS_DATE"]==''?'':conv_date(text($rec["POSHIS_DATE"]),''); ?>
                     
                </div>
                </div>
                 <div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่มีผล :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <?php echo $rec["COM_SDATE"]==''?'':conv_date(text($rec["COM_SDATE"]),''); ?>
                 
                </div>
                </div>
                </div>
                <div class="row formSep">
                	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทการถือครอง : <span style="color:red;"></span></div>
            		<div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v2('TYPE_LIVE','TYPE_LIVE',$arr_poshis_live,'ประเภทการถือครอง',$rec['TYPE_LIVE'],'','','1','','2');?></div><div class="col-xs-12 col-sm-1"></div>
            		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถานะของการบันทึก :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                    <div class="col-xs-6 col-md-1"><label ><input type="radio" disabled id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> ปกติ</label></div>
                    <div class="col-xs-6 col-md-1"><label ><input type="radio" disabled id="ACTIVE_STATUS2" name="ACTIVE_STATUS" value="2" <?php echo ($rec['ACTIVE_STATUS']=='2'?"checked":"")?> > ยกเลิก</label></div>
                 </div>
                 <div class="row formSep">
                 		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมายเหตุ :</div>
                        <div class="col-xs-12 col-sm-8"><?php echo  text(trim($rec["POSHIS_NOTE"]));?></div> 		
                 </div>
				</div>
                 <div class="row head-form">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                              <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                              <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
                              ข้อมูลตำแหน่ง
                          </a>
                      </div>
                   </div>           
        <div id="collapse2" class="collapse in">    
          <!--ข้าราชการ-----------------------------------> 
        <?PHP if($POSTYPE_ID==1){?>
        <div class="row formSep">   
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['pos_no']; ?>  :  &nbsp;</div>
            <div class="col-xs-12 col-md-3">
                <?php  echo text($rec["POS_NO"]); ?>
          	</div>
             <div class="col-xs-12 col-md-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('ORG_ID_1','ORG_ID_1',$arr_org1,'ระดับกระทรวง',$rec['ORG_ID_1'],'onchange="getORG(this);"','','');?></div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'ระดับกรม',$rec['ORG_ID_2'],'onchange="getORG(this);"','','');?></span></div> 
             <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">กอง/สำนัก/กลุ่ม : </div>

            <div class="col-xs-12 col-md-3"><span id='ss_org3'><?php echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$rec['ORG_ID_3'],'onchange="getORG(this);"','','1');?></span></div> 
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">กลุ่มงาน/ส่วน : </div>
            <div class="col-xs-12 col-md-3"><span id='ss_org4'><?php  echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$rec['ORG_ID_4'],'onchange="getORG(this);" ','','1');?></span></div>
            <div class="col-xs-12 col-md-1"></div> 
              <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ฝ่าย  :  </div>
            <div class="col-xs-12 col-md-3"><span id='ss_org5_1'>
                <?php  echo GetHtmlSelect_v('ORG_ID_5','ORG_ID_5',$arr_org5,'ฝ่าย ',$rec['ORG_ID_5'],'','','1');?></span>
          	</div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('TYPE_ID','TYPE_ID',$arr_pos_type,'ประเภทตำแหน่ง',$rec['TYPE_ID'],'onchange="getlevel(this.value,\''.$POSTYPE_ID.'\'); getLineGroup(this.value,\''.$POSTYPE_ID.'\');"','','1');?></div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ระดับตำแหน่ง',$rec['LEVEL_ID'],'','','1');?></div> 
        </div>	
        <div class="row formSep">
          <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สายงาน : </div>
         <div class="col-xs-12 col-sm-3">
		 <?php echo GetHtmlSelect_v('LG_ID','LG_ID',$arr_pos_lg,'สายงาน',$rec['LG_ID'],'onChange="GetLineGov(this.value,1);"','','1');?></div>
            <div class="col-xs-12 col-sm-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'><?php  echo GetHtmlSelect_v('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$rec['LINE_ID'],'','','1');?></span></div>
         </div>	
        <div class="row formSep">
        <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('MT_ID','MT_ID',$arr_type_mt,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=GetManage(this.value,1);','','1');?></div> 
             <div class="col-xs-12 col-sm-1"></div>
           <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_manage'><?php  echo GetHtmlSelect_v('MANAGE_ID','MANAGE_ID',$arr_manage,'ตำแหน่งทางการบริหาร',$rec['MANAGE_ID'],'','','1');?></span></div>
            
        </div>
        <?php }?>
       <!--พนักงานราชการ-----------------------------------> 
       <?php if($POSTYPE_ID==3){?>
          <?PHP if($PT_ID==2){ ?>
         <div class="row formSep">   
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['pos_no']; ?>  :  &nbsp;</div>
            <div class="col-xs-12 col-md-3">
                 <?php  echo text($rec["POS_NO"]); ?>
          	</div>
             <div class="col-xs-12 col-md-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('ORG_ID_1','ORG_ID_1',$arr_org1,'ระดับกระทรวง',$rec['ORG_ID_1'],'onchange="getORG(this);"','','');?></div>
        </div>
        <?php if($PT_ID=="2"){ ?>
        <div class="row formSep">
           	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีกรอบ  :  &nbsp;</div>
            <div class="col-xs-12 col-md-3"> <?php echo text($rec['POS_YEAR']); ?></div>
        </div>
        <?php } ?>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'ระดับกรม',$rec['ORG_ID_2'],'onchange="getORG(this);"','','');?></span></div> 
             <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">กอง/สำนัก/กลุ่ม :  </div>

            <div class="col-xs-12 col-md-3"><span id='ss_org3'><?php echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$rec['ORG_ID_3'],'onchange="getORG(this);"','','1','300');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">กลุ่มงาน/ส่วน :  </div>
            <div class="col-xs-12 col-md-3"><span id='ss_org4'><?php  echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$rec['ORG_ID_4'],'onchange="getORG(this);" ','','');?></span></div>
            <div class="col-xs-12 col-md-1"></div> 
              <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ฝ่าย  :  </div>
            <div class="col-xs-12 col-md-3"><span id='ss_org5_1'>
                <?php  echo GetHtmlSelect_v('ORG_ID_5','ORG_ID_5',$arr_org5,'ฝ่าย ',$rec['ORG_ID_5'],'','','1');?></span>
          	</div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทพนักงานราชการ : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('TYPE_ID','TYPE_ID',$arr_pos_type,'ประเภทตำแหน่ง',$rec['TYPE_ID'],'onchange="getlevel(this.value,\''.$POSTYPE_ID.'\');"','',$POSTYPE_ID);?></div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทกลุ่มงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_lv'>
			<?php  echo GetHtmlSelect_v('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ประเภทกลุ่มงาน',$rec['LEVEL_ID'],'onchange="GetLineEmp(this.value,\''.$POSTYPE_ID.'\');"','','1');?></span></div> 
        </div>	
         <div class="row formSep">
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line2'><?php  echo GetHtmlSelect_v('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่ง',$rec['LINE_ID'],'','','1');?></span></div>
         </div>		
          <?php }?>
          <?php }?>
      <!--ลูกจ้างประจำ----------------------------------->
      <?PHP if($PT_ID==3){ ?>
         <div class="row formSep">   
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['pos_no']; ?>  :  &nbsp;</div>
            <div class="col-xs-12 col-md-3">
			<?php  echo text($rec["POS_NO"]); ?>
          	</div>
             <div class="col-xs-12 col-md-1"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('ORG_ID_1','ORG_ID_1',$arr_org1,'ระดับกระทรวง',$rec['ORG_ID_1'],'onchange="getORG(this);"','','');?></div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'ระดับกรม',$rec['ORG_ID_2'],'onchange="getORG(this);"','','');?></span></div> 
             <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">กอง/สำนัก/กลุ่ม :  </div>

            <div class="col-xs-12 col-md-3"><span id='ss_org3'><?php echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$rec['ORG_ID_3'],'onchange="getORG(this);"','','1');?></span></div> 
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">กลุ่มงาน/ส่วน :  </div>
            <div class="col-xs-12 col-md-3"><span id='ss_org4'><?php  echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$rec['ORG_ID_4'],'onchange="getORG(this); " ','','1');?></span></div>
            <div class="col-xs-12 col-md-1"></div> 
              <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ฝ่าย  : </div>
            <div class="col-xs-12 col-md-3"><span id='ss_org5_1'>
                <?php  echo GetHtmlSelect_v('ORG_ID_5','ORG_ID_5',$arr_org5,'ฝ่าย ',$rec['ORG_ID_5'],'','','1');?></span>
          	</div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กลุ่ม : <sspan style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('TYPE_ID','TYPE_ID',$arr_pos_type,'กลุ่ม',$rec['TYPE_ID'],'onChange="getlevel(this.value,\''.$POSTYPE_ID.'\'); getLineGroup(this.value,\''.$POSTYPE_ID.'\'); "','','1');?></div> 
               <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สายงาน : </div>
         <div class="col-xs-12 col-sm-3">
		 	<?php echo GetHtmlSelect_v('LG_ID','LG_ID',$arr_pos_lg,'สายงาน',$rec['LG_ID'],'onChange="GetLineGov(this.value,\''.$POSTYPE_ID.'\');"','','1');?></span></div>
        </div>
	    <div class="row formSep">
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_line'><?php  echo GetHtmlSelect_v('LINE_ID','LINE_ID',$arr_pos_line,'ตำแหน่งในสายงาน',$rec['LINE_ID'],'','','1');?></span></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_pos_lv'><?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ระดับตำแหน่ง' ,$rec['LEVEL_ID'] ,'', '', '1'); ?></span></div> 
        </div>
        <?php }?>
    <!-- //-------------------------------------------------------------- -->
        </div>
        </div>
                 <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                                    <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" >
                                   รายได้ประจำ
                                </a>
                            </div>
                   </div>           
                   <div id="collapse3" class="collapse in">     
                   <div class="row formSep">
                   		<div class="col-xs-12 col-md-3" style="white-space:nowrap;">เงินเดือน  :  &nbsp;</div>
            <div class="col-xs-12 col-md-2"> <?php echo number_format($rec['SALARY'],2); ?></div><div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือนประจำตำแหน่ง  :  &nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php echo number_format($rec['SALARY_POSITION'],2); ?></div>
                  
                   </div>
                    <div class="row formSep">
                    		  <div class="col-xs-12 col-md-3" style="white-space:nowrap;">เงินค่าตอบแทนนอกเหนือจากเงินเดือน  :  &nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php echo number_format($rec['COMPENSATION_1'],2); ?></div>
            <div class="col-xs-12 col-md-1"></div>
             <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ค่าตอบแทนพิเศษ (เงินเดือนเต็มขั้น)  :  &nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php echo number_format($rec['COMPENSATION_2'],2); ?></div>
                    </div>
                  <div class="row formSep">
                    		  <div class="col-xs-12 col-md-3" style="white-space:nowrap;">เงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.)  :  &nbsp;</div>
            <div class="col-xs-12 col-md-2"><?php echo number_format($rec['COMPENSATION_1'],2); ?></div>
            <div class="col-xs-12 col-md-1"></div>
             <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเพิ่มค่าครองชีพชั่วคราว   :  &nbsp;</div>
            <div class="col-xs-12 col-md-2 number"><?php echo number_format($rec['COMPENSATION_2'],2); ?></div>
                    </div>
        		</div>
                </div>
                             
            
</div>
</div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>