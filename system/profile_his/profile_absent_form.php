<?php
//header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;



//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
	$round_arr = $arr_emp_round;
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
	$round_arr = $arr_emp_gov_round;
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
	$round_arr = $arr_round;
}



//POST
$PER_ID=(int)$_POST['PER_ID'];
$PUN_ID = (int)$_POST['PUN_ID'];
$LEAVEHIS_YEAR = $_POST['LEAVEHIS_YEAR'];
$ROUND_YEAR = $_POST['ROUND_YEAR'];
 
 $arr_year = array();
 $YEAR_PRESENT_PLUS = YEAR_PRESENT - 20;
 for($i=$YEAR_PRESENT;$i>=$YEAR_PRESENT_PLUS;$i--){
      $arr_year[$i] = $i;
 }
 
 
 
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
$LEAVEHIS_ID = $_POST['LEAVEHIS_ID'];
//MAIN
if($proc == 'edit'){
	$sql = "SELECT * from PER_LEAVEHIS WHERE LEAVEHIS_ID = '".$LEAVEHIS_ID."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_array($query);
	$LEAVEHIS_YEAR = $rec['LEAVEHIS_YEAR'];
	$ROUND_YEAR = $rec['ROUND_YEAR'];
}




?>

 
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
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
<script src="js/profile_absenthis_form.js?<?php echo rand(); ?>"></script>
</head>
<body>


<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li><a href="profile_absent.php?<?php echo url2code($link2); ?>">ประวัติการลา</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
     <div class="clearfix"></div>
   	 <form id="frm-input" method="post" action="process/profile_absent_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="PUN_ID" name="PUN_ID" value="<?php echo $PUN_ID?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID;?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
		<input type="hidden" id="LEAVEHIS_YEAR" name="LEAVEHIS_YEAR" value="<?php echo $LEAVEHIS_YEAR; ?>">
        <input type="hidden" id="ROUND_YEAR" name="ROUND_YEAR" value="<?php echo $ROUND_YEAR; ?>">
 		<input type="hidden" id="LEAVEHIS_ID" name="LEAVEHIS_ID" value="<?php echo $LEAVEHIS_ID; ?>">
                 
        <div class="row head-form"> ข้อมูลปีงบประมาณที่จัดเก็บการลา</div>
        <div class="row">
        	<div class="col-xs-12 col-sm-2" >ปีงบประมาณ :</div>
            <div class="col-xs-12 col-sm-2"><?php echo $LEAVEHIS_YEAR; ?></div>
            <div class="col-xs-12 col-sm-2" >รอบ : </div>
            <div class="col-xs-12 col-sm-3" ><?php echo $round_arr[$ROUND_YEAR]; ?> </div>
         </div>
                        

                           <div class="row head-form">
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ประเภทการลา
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	จำนวนครั้งที่ลา
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	จำนวนวันที่ลา
                                
                            </div>
                            
                        </div>
                        

        <div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาป่วย
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_SICK_TIME" name="LEAVEHIS_SICK_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_SICK_TIME"]==''?0:number_format($rec["LEAVEHIS_SICK_TIME"],0); ?>"  onBlur="NumberFormat(this,0);">
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_SICK_DAY" name="LEAVEHIS_SICK_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_SICK_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_SICK_DAY"],2); ?>" onBlur="NumberFormat(this,2);" >
                                
                            </div>      
        
        </div>
         
         
        <div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาป่วยจำเป็น
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_IMPORTANT_SICK_TIME" name="LEAVEHIS_IMPORTANT_SICK_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_IMPORTANT_SICK_TIME"]==''?0:number_format($rec["LEAVEHIS_IMPORTANT_SICK_TIME"],0); ?>"  onBlur="NumberFormat(this,0);">
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_IMPORTANT_SICK_DAY" name="LEAVEHIS_IMPORTANT_SICK_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_IMPORTANT_SICK_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_IMPORTANT_SICK_DAY"],2); ?>" onBlur="NumberFormat(this,2);" >
                                
                            </div>      
        
        </div>
         
         
         
         

<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาคลอดบุตร
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_BIRTH_TIME" name="LEAVEHIS_BIRTH_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_BIRTH_TIME"]==''?0:number_format($rec["LEAVEHIS_BIRTH_TIME"],0); ?>" onBlur="NumberFormat(this,0);" >
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_BIRTH_DAY" name="LEAVEHIS_BIRTH_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_BIRTH_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_BIRTH_DAY"],2); ?>" onBlur="NumberFormat(this,2);" >
                                
                            </div>      
        
        </div>




<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาไปช่วยเหลือภริยาที่คลอดบุตร
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_HELP_TIME" name="LEAVEHIS_HELP_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_HELP_TIME"]==''?0:number_format($rec["LEAVEHIS_HELP_TIME"],0); ?>" onBlur="NumberFormat(this,0);" >
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_HELP_DAY" name="LEAVEHIS_HELP_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_HELP_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_HELP_DAY"],2); ?>"  onBlur="NumberFormat(this,2);">
                                
                            </div>      
        
        </div>




<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลากิจส่วนตัว
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_PRIVATE_TIME" name="LEAVEHIS_PRIVATE_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_PRIVATE_TIME"]==''?0:number_format($rec["LEAVEHIS_PRIVATE_TIME"],0); ?>" onBlur="NumberFormat(this,0);" >
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_PRIVATE_DAY" name="LEAVEHIS_PRIVATE_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_PRIVATE_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_PRIVATE_DAY"],2); ?>" onBlur="NumberFormat(this,2);" >
                                
                            </div>      
        
        </div>



<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาพักผ่อน
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_RELAX_TIME" name="LEAVEHIS_RELAX_TIME" class="form-control" placeholder="0" maxlength="5"  value="<?php echo $rec["LEAVEHIS_RELAX_TIME"]==''?0:number_format($rec["LEAVEHIS_RELAX_TIME"],0); ?>"  onBlur="NumberFormat(this,0);">
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  <input type="text" id="LEAVEHIS_RELAX_DAY" name="LEAVEHIS_RELAX_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_RELAX_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_RELAX_DAY"],2); ?>"  onBlur="NumberFormat(this,2);" >
                                
                            </div>      
        
        </div>



<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาอุปสมบทหรือลาไปประกอบพิธีฮัจย์
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_REGION_TIME" name="LEAVEHIS_REGION_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_REGION_TIME"]==''?0:number_format($rec["LEAVEHIS_REGION_TIME"],0); ?>"  onBlur="NumberFormat(this,0);"> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_REGION_DAY" name="LEAVEHIS_REGION_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_REGION_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_REGION_DAY"],2); ?>" onBlur="NumberFormat(this,2);"></div>      
 </div>

<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาเข้ารับการตรวจเลือกหรือเข้ารับการเตรียมพล
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_SOLDIER_TIME" name="LEAVEHIS_SOLDIER_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_SOLDIER_TIME"]==''?0:number_format($rec["LEAVEHIS_SOLDIER_TIME"],0); ?>"  onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_SOLDIER_DAY" name="LEAVEHIS_SOLDIER_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_SOLDIER_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_SOLDIER_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาไปศึกษา ฝึกอบรม ปฏิบัติการวิจัย หรือดูงาน
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_STUDY_TIME" name="LEAVEHIS_STUDY_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_STUDY_TIME"]==''?0:number_format($rec["LEAVEHIS_STUDY_TIME"],0); ?>" onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_STUDY_DAY" name="LEAVEHIS_STUDY_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_STUDY_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_STUDY_DAY"],2); ?>"  onBlur="NumberFormat(this,2);"  ></div>      
 </div>

<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาไปปฏิบัติงานในองค์การระหว่างประเทศ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_WORK_TIME" name="LEAVEHIS_WORK_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_WORK_TIME"]==''?0:number_format($rec["LEAVEHIS_WORK_TIME"],0); ?>" onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_WORK_DAY" name="LEAVEHIS_WORK_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_WORK_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_WORK_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>



<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาติดตามคู่สมรส
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_MARRIED_TIME" name="LEAVEHIS_MARRIED_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_MARRIED_TIME"]==''?0:number_format($rec["LEAVEHIS_MARRIED_TIME"],0); ?>" onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_MARRIED_DAY" name="LEAVEHIS_MARRIED_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_MARRIED_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_MARRIED_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาไปฟื้นฟูสมรรถภาพด้านอาชีพ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_COMPLETENCY_TIME" name="LEAVEHIS_COMPLETENCY_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_COMPLETENCY_TIME"]==''?0:number_format($rec["LEAVEHIS_COMPLETENCY_TIME"],0); ?>" onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_COMPLETENCY_DAY" name="LEAVEHIS_COMPLETENCY_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_COMPLETENCY_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_COMPLETENCY_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาอื่น ๆ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_OTHER_TIME" name="LEAVEHIS_OTHER_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_OTHER_TIME"]==''?0:number_format($rec["LEAVEHIS_OTHER_TIME"],0); ?>" onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_OTHER_DAY" name="LEAVEHIS_OTHER_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_OTHER_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_OTHER_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	การขาดราชการ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_WITHOUT_TIME" name="LEAVEHIS_WITHOUT_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_WITHOUT_TIME"]==''?0:number_format($rec["LEAVEHIS_WITHOUT_TIME"],0); ?>" onBlur="NumberFormat(this,0);" > </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_WITHOUT_DAY" name="LEAVEHIS_WITHOUT_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_WITHOUT_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_WITHOUT_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	มาสาย
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_LATE_TIME" name="LEAVEHIS_LATE_TIME" class="form-control" placeholder="0" maxlength="5" value="<?php echo $rec["LEAVEHIS_LATE_TIME"]==''?0:number_format($rec["LEAVEHIS_LATE_TIME"],0); ?>" onBlur="NumberFormat(this,0);"> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><input type="text" id="LEAVEHIS_LATE_DAY" name="LEAVEHIS_LATE_DAY" class="form-control" placeholder="0.0" maxlength="5" value="<?php echo $rec["LEAVEHIS_LATE_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_LATE_DAY"],2); ?>" onBlur="NumberFormat(this,2);" ></div>      
 </div>


                   
        <br>
          <div class="row">
        <div class="col-xs-12 col-sm-12" align="center">
			<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			<button type="button" class="btn btn-default" onClick="self.location.href='profile_absent.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        </div>
        <br>
    </form>

</div>
</div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>


</body>
</html>