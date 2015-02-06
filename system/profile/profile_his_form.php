<?php
$path = "../../";
include($path."include/config_header_top.php");
 //echo $PER_ID;
$PER_ID =  $_SESSION['sys_id'];
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$path_img='../fileupload/profile_his/';
//POST
$ATTENTYPE_ID=$_POST['ATTENTYPE_ID'];
$proc = empty($proc)?'edit':$proc;
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"; 
//tab active
$ACT = 1;
//page back
//echo $PT_ID ;
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

//DATA
$sql = "select CAST(a.PER_SALARY_POSITION as VARCHAR(19)) as PER_SALARY_POSITION, CAST(a.PER_SALARY as VARCHAR(19)) as PER_SALARYV, CAST(a.PER_COMPENSATION_1 as VARCHAR(19)) as PER_COMPENSATION_1V, a.*, b.POS_NO FROM PER_PROFILE a LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID where a.PER_ID = '".$PER_ID."' ";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

//ประเภทบุคลากร
$arr_personal_type=GetSqlSelectArray("PT_ID", "PT_NAME_TH", "PERSONAL_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PT_NAME_TH");
//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LEVEL_NAME_TH");
//สายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LINE_NAME_TH");
//ตำแหน่งในการบริหาร
$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "MANAGE_NAME_TH");

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "ORG_NAME_TH");
//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ORG_ID='15' ", "ORG_NAME_TH");			
//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='15' ", "ORG_NAME_TH");
//org4
$arr_org4=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$data['ORG_ID_3']."'  ", "ORG_NAME_TH");
//org5
$arr_org5=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "ORG_NAME_TH");

//org5
$arr_org6=GetSqlSelectArray("a.CV_ID", "a.CV_NAME_TH", "ANNOUNCE_SETUP_CIVIL_TYPE as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "CV_NAME_TH");
$arr_snation=GetSqlSelectArray("NATION_ID", "NATION_NAME_TH", "SETUP_NATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "NATION_NAME_TH");//สัญชาติ
$arr_sreligion=GetSqlSelectArray("RELIGION_ID", "RELIGION_NAME_TH", "SETUP_RELIGION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "RELIGION_CODE");//ศาสนา
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
<link href="css/main_view.css" rel="stylesheet">
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
<script src="js/profile_his_disp.js?<?php echo rand(); ?>"></script>
<script src="js/all_view.js"></script>
<style>
 
.col-sm-2 {
	/*width:18.666667%;*/
}
</style> 
</head>
<body <?php echo $remove;?> onLoad="$(':input').removeAttr('placeholder');" >
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          
          <li class="active"><?php echo $txt.text($arr_personal_type[$PT_ID]);?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <?php 
		//if(!empty($PER_ID)){
		include("tab_profile.php");?>
        <div class="grouptab">
        <?php // }   
  ?>
                <div class="row ">
    
                    <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                                    <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลทั่วไป
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse1" class="collapse in">
                            
                            <div class="col-xs-12 col-sm-10" >
                                <div class="row formSep visible-xs">
                                    <div class="col-xs-12 col-md-6 col-sm-offset-2">
                                        <div class="col-xs-6 col-md-6"><?php echo showPic_per($data['PER_FILE_PIC']);?></div>
                                    </div>
                                </div>
                                
                                <div class="row formSep">
                                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"  ><?php echo $arr_txt['idcard'];?> : &nbsp;</div>
                                    <div class="col-xs-12 col-sm-2"><?php echo $data['PER_IDCARD']; ?></div> 
                                </div>
                                             
                                <div class="row formSep">
                                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['title'];?> : &nbsp;</div>
                                    <div class="col-xs-12 col-sm-2"><?php echo GetHtmlSelect_v('PREFIX_ID','PREFIX_ID',$arr_prefix,$arr_txt['title']." (".$arr_txt['th'].")",$data['PREFIX_ID'],'','','1'); ?></div>
                                    <div class="col-xs-12 col-sm-2"></div>
                                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">เพศ :&nbsp;&nbsp;</div>
                                    <div class="col-xs-6 col-md-1">      <?php   if($data['PER_GENDER']==1){ echo "ชาย"; } ?> </div>
                                    <div class="col-xs-6 col-md-1">
                                    <?php if($data['PER_GENDER']==2){ echo "หญิง"; } ?> 
                                    </div>
                                </div>
                                
                                

                                
                                
                                
                            </div>
                            <!-- -->
                            <div class="col-xs-12 col-sm-2 visible-lg"  >
                                <div class="col-xs-12 col-sm-12"><?php echo showPic_per($data['PER_FILE_PIC']);?></div>
                            </div>
                            <div class="row"></div>
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['fname'].$arr_txt['th']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo text($data['PER_FIRSTNAME_TH']) ;?></div> 
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['mname'].$arr_txt['th']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo text($data['PER_MIDNAME_TH']) ;?></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['lname'].$arr_txt['th']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo text($data['PER_LASTNAME_TH']) ;?></div>							
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['fname'].$arr_txt['en']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo text($data['PER_FIRSTNAME_EN']) ;?></div> 
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['mname'].$arr_txt['en']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo text($data['PER_MIDNAME_EN']) ;?></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['lname'].$arr_txt['en']; ?> : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo text($data['PER_LASTNAME_EN']) ;?></div>							
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">หมู่โลหิต : </div>
                                <div class="col-xs-12 col-sm-2">
                                <?php
								 foreach ($arr_blood as $key => $value){ 
									   if($data['PER_BLOOD_TYPE'] == $key){
										 echo $value;
									   }
								   }
								   ?>
                                   <?php /*
                                    <select id="BLOOD_TYPE" name="BLOOD_TYPE" class="selectbox form-control" placeholder="หมู่โลหิต">
                                        <option value="" ></option>
                                        <?php foreach ($arr_blood as $key => $value){  ?>
                                        <option value="<?php echo $key ; ?>" <?php echo ($data['PER_BLOOD_TYPE'] == $key?"selected":"");?>><?php echo $value;?></option>
                                        <?php }?>
                                    </select>	*/ ?>					
                                </div> 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันเดือนปีเกิด :  </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <?php $PER_BIRTHDATE_is = conv_date($data["PER_DATE_BIRTH"],'short') ?>
 <?php echo  $PER_BIRTHDATE_is;?>       
                                        
<?php

							function thaiDateFromUnix60() {
							
								if (func_num_args()) { // have timestamp
									$timestamp = func_get_arg(0);
								} else { // no argument
									$timestamp = mktime();
								}
							     
								setlocale(LC_TIME, "th");
								//$atoms = explode('-',$timestamp);
								//print_r($timestamp);
								$month_r =  (int)strftime("%m", $timestamp) ;
								$day_r =  (int)strftime("%d", $timestamp) ;
								$normal_add = (int)603;
								$extra_add = (int)604;
								
								if($month_r <= 9){
									$be = strftime("%Y", $timestamp) + $normal_add;
								}else{
								      if(($month_r == 10)&&($day_r==1)){ // if ตุลา
									  	 $be = strftime("%Y", $timestamp) + $normal_add;
									  }else{
									     $be = strftime("%Y", $timestamp) + $extra_add;	
									  }
															
								}
								return strftime("%#d/%m/", $timestamp) . $be;
							
							}			  
							function thaiDateFromString() {
							
								if (func_num_args()) { // have time string e.g. "yyyy-mm-dd"
									$timestamp = strtotime(func_get_arg(0));
								} else { // no argument
									$timestamp = mktime();
								}
							
								return thaiDateFromUnix60($timestamp);
							
							}
									$date60 = '';
					    		if(isset($data["PER_DATE_BIRTH"])){
						   			//$date60 = date(thaiDateFromString($data["PER_DATE_BIRTH"]));
									$date60 =  thaiDateFromString($data["PER_DATE_BIRTH"]) ;
								}
								 
					 
							
							?>
                                        
                                        
                                        
                                        <span class="input-group-addon datepicker" for="DATE_BIRTH" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>	
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สัญชาติ :  </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect_v('NATION_ID','NATION_ID',$arr_snation,'สัญชาติ',empty($data['NATION_ID'])?$default_nation_id:$data['NATION_ID'],'','','1');?></div> 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">เชื้อชาติ :  </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect_v('RACE_NATION_ID','RACE_NATION_ID',$arr_snation,'เชื้อชาติ',empty($data['RACE_NATION_ID'])?$default_nation_id:$data['RACE_NATION_ID'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ศาสนา :  </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect_v('RELIGION_ID','RELIGION_ID',$arr_sreligion,'ศาสนา',empty($data['RELIGION_ID'])?$default_religion_id:$data['RELIGION_ID'],'','','1');?></div>							
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สีผิว :</div>
                                <div class="col-xs-12 col-sm-2"><?php echo  text($data["PER_SKIN_COLOR"]);?></div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ส่วนสูง (ซ.ม.) : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo  text($data["PER_HEIGHT"]);?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">น้ำหนัก (ก.ก.) : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo  text($data["PER_WEIGHT"]);?></div>							
                            </div>	
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">รอยตำหนิ :</div>
                                <div class="col-xs-12 col-sm-8"><?php echo  text(trim($data["PER_SKIN_MARKUP"]));?></div> 		
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
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['pos_no']; ?> : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <div class="input-group" id="ss_name_out"><?php echo $data["POS_NO"]; ?>
                                    </div>
                                </div> 
                            </div>	
                            
                            
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ประเภทข้าราชการ : </div>
                                <div class="col-xs-12 col-sm-3">
<?php  echo GetHtmlSelect_v('CV_ID','CV_ID',$arr_org6,"ประเภทข้าราชการ"." (".$arr_txt['th'].")",$data['CV_ID'],'','','1');  ?>                          </div> 
                            </div>	
                            
                            
                            
 
                            
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ประเภทตำแหน่ง : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="TYPE_NAME_TH"><?php  echo text($arr_pos_type[$data['TYPE_ID']]);?></label>
                                    <input type="hidden" id="TYPE_ID" name="TYPE_ID" value="<?php  echo $data['TYPE_ID'];?>" >
                                </div> 
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ระดับตำแหน่ง : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="LEVEL_NAME_TH"><?php  echo text($arr_pos_level[$data['LEVEL_ID']]);?></label>
                                    <input type="hidden" id="LEVEL_ID" name="LEVEL_ID" value="<?php  echo $data['LEVEL_ID'];?>" >
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ตำแหน่งในสายงาน : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="LINE_NAME_TH"><?php  echo text($arr_pos_line[$data['LINE_ID']]);?></label>
                                    <input type="hidden" id="LINE_ID" name="LINE_ID" value="<?php  echo $data['LINE_ID'];?>" >
                                </div> 
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ตำแหน่งทางการบริหาร :</div>
                                <div class="col-xs-12 col-sm-3">
                                    <label id="MANAGE_NAME_TH"><?php  echo text($arr_manage[$data['MANAGE_ID']]);?></label>
                                    <input type="hidden" id="MANAGE_ID" name="MANAGE_ID" value="<?php  echo $data['MANAGE_ID'];?>" >
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ระดับกรม : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'',$data['ORG_ID_2']==''?'15':$data['ORG_ID_2'],'onchange="getORG2(this.value,\'ORG_ID_3\');"','','');?>
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ระดับกอง/สำนัก/กลุ่ม : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <span id='ss_org3'>
                                    <?php  echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$data['ORG_ID_3'],'onchange="getORG3(this.value,\'ORG_ID_4\');"','','1');?>
                                    </span>
                                </div> 
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ระดับส่วน/กลุ่มงาน : </div>
                                <div class="col-xs-12 col-sm-3">
                                    <span id='ss_org4'>
                                    <?php  echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'ระดับส่วน/กลุ่มงาน ',$data['ORG_ID_4'],'','','1');?>
                                    </span>
                                </div> 
                            </div>
                        </div>
                        
                        
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                                    <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลรายได้
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse3" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเดือน/ค่าตอบแทน/ค่าจ้าง : </div>
                                <div class="col-xs-12 col-sm-3"><?php echo  number_format($data["PER_SALARYV"],2);?></div> 
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินประจำตำแหน่ง :</div>
                                <div class="col-xs-12 col-sm-3"><?php echo  number_format($data["PER_SALARY_POSITION"],2);?></div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินค่าตอบแทนนอกเหนือจากเงินเดือน :</div>
                                <div class="col-xs-12 col-sm-3"><?php echo  number_format($data["PER_COMPENSATION_1V"],2);?></div> 
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินค่าตอบแทนพิเศษ (เงินเดือนเต็มขั้น) : </div>
                                <div class="col-xs-12 col-sm-3"><?php echo  number_format($data["PER_COMPENSATION_2"],2);?></div> 
                            </div>
                            
                            <?php if($POSTYPE_ID == 5){ ?>
                            <div class="row formSep" id="postype_id_5">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">ขั้นเงินเดือน : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo  number_format($data["PER_STEP"],2);?></div> 
                            </div>
                            <?php } ?>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.) :</div>
                                <div class="col-xs-12 col-sm-3"><?php echo  number_format($data["PER_COMPENSATION_3"],2);?></div> 
                                <div class="col-xs-12 col-sm-3" style="white-space:nowrap;font-weight:bold;">เงินเพิ่มค่าครองชีพชั่วคราว : </div>
                                <div class="col-xs-12 col-sm-2"><?php echo  number_format($data["PER_COMPENSATION_4"],2);?></div> 
                            </div>
                        </div>
                        
                        
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
                                    <img class="switchPic4" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลช่วงเวลาที่สำคัญในการรับราชการ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse4" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่บรรจุ :  </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
<?php echo  conv_date($data["PER_DATE_ENTRANCE"],'short');?>                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่เข้าส่วนราชการ : </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group"> <?php echo  conv_date($data["PER_DATE_OCCUPLY"],'short');?>
                                    </div>	
                                </div> 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">กำหนดวันเกษียณราชการ : </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <?php   echo  conv_date($data["PER_DATE_RETIRE"],'short');?> 
                                    </div>	
                                </div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ประเมินการทดลองฯ ครั้งที่ 1 :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                       <?php echo  conv_date($data["PER_DATE_PRO1"],'short');?> 
                                    </div>
                                </div>                                 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ประเมินการทดลองฯ ครั้งที่ 2 :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                         <?php echo  conv_date($data["PER_DATE_PRO2"],'short');?> 
                                    </div>
                                </div>                                 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ประเมินการทดลองฯ ครั้งที่ 3 :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                        <?php echo  conv_date($data["PER_DATE_PRO3"],'short');?> 
                                    </div>
                                </div>                                 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ถือครองตำแหน่งปัจจุบัน :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
 <?php echo  conv_date($data["PER_DATE_POSITION"],'short');?> 
                                    </div>
                                </div>                                 
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่เริ่มถือครองระดับปัจจุบัน :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
 <?php echo  conv_date($data["PER_DATE_LEVEL"],'short');?> 
                                    </div>
                                </div>                                 
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">วันที่ออกจากราชการ :</div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="input-group">
                                         <?php echo  conv_date($data["PER_DATE_RESIGN"],'short');?> 
                                    </div>
                                </div> 
                            </div>
                        </div>
                        
                        <!--<div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();">
                                    <img class="switchPic5" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic5" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลส่วนของบำเหน็จบำนาญ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse5" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ปีงบประมาณที่ครบเกษียณ : </div>
                                <div class="col-xs-12 col-sm-4"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ปีงบประมาณที่ขอจริง : </div>
                                <div class="col-xs-12 col-sm-4"></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สิทธิการขอบำเหน็จบำนาญ : </div>
                                <div class="col-xs-12 col-sm-4"></div>
                            </div>
                        </div>-->
                        
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();">
                                    <img class="switchPic6" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic6" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลสถานะต่างๆ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse6" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของบุคคล : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PER_STATUS','PER_STATUS',$arr_per_status,'สถานะของบุคคล',$data['PER_STATUS'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะรับราชการทหาร : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PER_STATUS_MILITARY','PER_STATUS_MILITARY',$arr_per_status_military,'สถานะรับราชการทหาร',$data['PER_STATUS_MILITARY'],'','','1');?></div>
                            </div> 
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานภาพการสมรส : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PER_STATUS_MARRY','PER_STATUS_MARRY',$arr_smarry_type_status,'สถานภาพการสมรส',$data['PER_STATUS_MARRY'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">การเป็นสมาชิก กบข. : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('GPF_STATUS','GPF_STATUS',$arr_gpf,'การเป็นสมาชิก กบข.',$data['GPF_STATUS'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการเลื่อนระดับ : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PER_STATUS_MOVEUP','PER_STATUS_MOVEUP',$arr_status_moveup,'สถานะของการเลื่อนระดับ',$data['PER_STATUS_MOVEUP'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการทดลองปฏิบัติราชการ : </div>
                                <div class="col-xs-12 col-sm-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo GetHtmlSelectNoConv_v('PER_STATUS_PROBATION','PER_STATUS_PROBATION',$arr_status_probation,'สถานะของการทดลองปฏิบัติราชการ',$data['PER_STATUS_PROBATION'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการสอบสวนทางวินัย : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PER_STATUS_PENALTY','PER_STATUS_PENALTY',$arr_status_penalty,'สถานะของการสอบสวนทางวินัย',$data['PER_STATUS_PENALTY'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการขอบำเหน็จบำนาญ : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PENSION_STATUS','PENSION_STATUS',$arr_status_pension,'สถานะของการขอบำเหน็จบำนาญ',$data['PENSION_STATUS'],'','','1');?></div>
                            </div>
                            
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">สถานะของการรับราชการ : </div>
                                <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelectNoConv_v('PER_STATUS_CIVIL','PER_STATUS_CIVIL',$arr_status_civil,'สถานะของการรับราชการ',$data['PER_STATUS_CIVIL'],'','','1');?></div>
                                <div class="col-xs-12 col-sm-2"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;"><?php echo $arr_txt['active'];?> :&nbsp;&nbsp;</div>
                                <div class="col-xs-6 col-md-1">
                                
                                <?php if($data['ACTIVE_STATUS']==1){ echo "ใช้งาน"; }else{ echo "ไม่ใช่งาน"; } ?>
                                 </div>
                            </div>						
                        </div>
                        
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onClick="$('.switchPic7').toggle();">
                                    <img class="switchPic7" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic7" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลไฟล์แนบ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse7" class="collapse in">
                        	<div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">นำเข้าไฟล์รูปภาพ :&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group">
                                        <input type="file" id="PER_FILE_PIC" name="PER_FILE_PIC" class="form-control"  value="<?php echo text($data["PER_FILE_PIC"]);?>" onChange="checkfile(this);" style="display:none;" >
               
 <?php  
                            display_download_me($path_img,$data['PER_FILE_PIC'],$arr_txt['download']);
 
?>       
                                        
                                    </div>		
                                    <input type="hidden" id="OLD_FILE_PIC" name="OLD_FILE_PIC"   value="<?php echo !empty($data["PER_FILE_PIC"])?text($data["PER_FILE_PIC"]):""; ?>">
                                </div>
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ไฟล์แบบฟอร์มสมาชิก กบข :&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group"  >
                                        <input style="display:none;"  type="file" id="PER_FILE_GPF" name="PER_FILE_GPF" class="form-control"  value="<?php echo text($data["PER_FILE_GPF"]);?>" >
          
 <?php  
                            display_download_me($path_img,$data['PER_FILE_GPF'],$arr_txt['download']);
 
?>                                     
                                        
                        
                                    </div>	
                                    <input type="hidden" id="OLD_FILE_GPF" name="OLD_FILE_GPF"   value="<?php echo !empty($data["PER_FILE_GPF"])?text($data["PER_FILE_GPF"]):""; ?>"> 
                                </div>
                            </div>	
                                
                            <div class="row formSep">
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ไฟล์แบบฟอร์มชั้นความลับ รปภ 1:&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group"  >
                                        <input style="display:none;"  type="file" id="PER_FILE_SECRET" name="PER_FILE_SECRET" class="form-control"  value="<?php echo text($data["PER_FILE_SECRET"]);?>" >   
                                        
 <?php  
                            display_download_me($path_img,$data['PER_FILE_SECRET'],$arr_txt['download']);
 
?>
                                        
                  
                                    </div>
                                    <input type="hidden" id="OLD_FILE_SECRET" name="OLD_FILE_SECRET"   value="<?php echo !empty($data["PER_FILE_SECRET"])?text($data["PER_FILE_SECRET"]):""; ?>">
                                </div>
                                <div class="col-xs-12 col-sm-1"></div>
                                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;font-weight:bold;">ไฟล์ ก.พ. 7:&nbsp;</div>
                                <div class="col-xs-12 col-sm-3">
                                     <div class="input-group"  >
                                        <input style="display:none;"  type="file" id="PER_FILE_MAIN" name="PER_FILE_MAIN" class="form-control"  value="<?php echo text($data["PER_FILE_MAIN"]);?>" >
                                        
<?php 
                            display_download_me($path_img,$data['PER_FILE_MAIN'],$arr_txt['download']);
 
?>                             
                                        
 
                                    </div>
                                    <input type="hidden" id="OLD_FILE_MAIN" name="OLD_FILE_MAIN"   value="<?php echo !empty($data["PER_FILE_MAIN"])?text($data["PER_FILE_MAIN"]):""; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 
		</div> 
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</div>
</body>
</html>
<!-- Modal -->
<?php echo form_model('myModal','เลือก'.$arr_txt['pos_no'],'show_display2');?>
<!-- /.modal -->
 
 
 

