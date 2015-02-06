<?php
//header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	//$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	//$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	//$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

//echo "On Debuging <pre>"; print_r($_POST); 

//POST
$PER_ID=(int)$_POST['PER_ID'];
//$POSHIS_ID=$_POST['POSHIS_ID'];
$PUN_ID = (int)$_POST['PUN_ID'];
 
 
 
 $arr_year = array(  
               '2557'=>'2557',
               '2556'=>'2556',	
			   '2555'=>'2555',
			   '2554'=>'2554',
			   '2553'=>'2553',
			   '2552'=>'2552',	
			   '2551'=>'2551'	  
 );
 
 
$txt = "ดูข้อมูล"; 
$LEAVEHIS_ID = $_POST['LEAVEHIS_ID'];
//MAIN
$sql = "SELECT * from PER_LEAVEHIS WHERE LEAVEHIS_ID = '".$LEAVEHIS_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

 //echo "<pre>"; print_r($rec); 
 
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
<script src="js/profile_absenthis.js?<?php echo rand(); ?>"></script>
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
		<input type="hidden" id="flagDup1" name="flagDup1">
 		<input type="hidden" id="LEAVEHIS_ID" name="LEAVEHIS_ID" value="<?php echo $LEAVEHIS_ID; ?>">       
        
         
          <div class="row ">
    
                    <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                           
                                  	ข้อมูลปีงบประมาณที่จัดเก็บการลา
                                
                            </div>
                        </div>
                        
                        
                        

        <div class="row formSep">
        	<div class="col-md-4" style="white-space:nowrap;">ปีงบประมาณ :&nbsp; &nbsp;</div>
            <div class="col-md-4" style="white-space:nowrap;">				
                <div class="input-group">
                 <?php echo $rec['LEAVEHIS_YEAR']; ?>
 <?php  
     			echo "<input type='hidden' name='OLD_ID_is' id='OLD_ID_is' value='".$rec['LEAVEHIS_YEAR']."' >";
  
		?>
 
  <span id="chkDup1" class="col-sm-4 hidden-xs label"></span>
                </div> 
                </div>
          <div class="col-md-4" style="white-space:nowrap;"> รอบ    <?php echo $rec['ROUND_YEAR']; ?></div>
            
                </div>


                    <div class="panel-group" id="accordion">
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
          
                                  <?php echo $rec["LEAVEHIS_SICK_TIME"]==''?0:number_format($rec["LEAVEHIS_SICK_TIME"],0); ?>
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_SICK_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_SICK_DAY"],2); ?>
                            </div>      
        
        </div>
         
         
        <div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาป่วยจำเป็น
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                <?php echo $rec["LEAVEHIS_IMPORTANT_SICK_TIME"]; ?>
                                
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
   								 <?php echo $rec["LEAVEHIS_IMPORTANT_SICK_DAY"]; ?>
                            </div>      
        
        </div>
         
         

<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาคลอดบุตร
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_BIRTH_TIME"]==''?0:number_format($rec["LEAVEHIS_BIRTH_TIME"],0); ?>
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_BIRTH_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_BIRTH_DAY"],2); ?>
                            </div>      
        
        </div>




<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาไปช่วยเหลือภริยาที่คลอดบุตร
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_HELP_TIME"]==''?0:number_format($rec["LEAVEHIS_HELP_TIME"],0); ?>
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_HELP_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_HELP_DAY"],2); ?>
                            </div>      
        
        </div>




<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลากิจส่วนตัว
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_PRIVATE_TIME"]==''?0:number_format($rec["LEAVEHIS_PRIVATE_TIME"],0); ?>
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_PRIVATE_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_PRIVATE_DAY"],2); ?>
                            </div>      
        
        </div>



<div class="row formSep">
        
  
                            <div class="col-md-4" style="white-space:nowrap;">
          
                                  	ลาพักผ่อน
                                
                            </div>
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_RELAX_TIME"]==''?0:number_format($rec["LEAVEHIS_RELAX_TIME"],0); ?>
                            </div>
                            
                            
                            <div class="col-md-4" style="white-space:nowrap;">
          <?php echo $rec["LEAVEHIS_RELAX_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_RELAX_DAY"],2); ?>
                            </div>      
        
        </div>



<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาอุปสมบทหรือลาไปประกอบพิธีฮัจย์
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_REGION_TIME"]==''?0:number_format($rec["LEAVEHIS_REGION_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_REGION_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_REGION_DAY"],2); ?></div>      
 </div>

<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาเข้ารับการตรวจเลือกหรือเข้ารับการเตรียมพล
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_SOLDIER_TIME"]==''?0:number_format($rec["LEAVEHIS_SOLDIER_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_SOLDIER_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_SOLDIER_DAY"],2); ?></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาไปศึกษา ฝึกอบรม ปฏิบัติการวิจัย หรือดูงาน
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"> <?php echo $rec["LEAVEHIS_STUDY_TIME"]==''?0:number_format($rec["LEAVEHIS_STUDY_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_STUDY_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_STUDY_DAY"],2); ?></div>      
 </div>

<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาไปปฏิบัติงานในองค์การระหว่างประเทศ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_WORK_TIME"]==''?0:number_format($rec["LEAVEHIS_WORK_TIME"],0); ?></div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_WORK_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_WORK_DAY"],2); ?></div>      
 </div>



<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาติดตามคู่สมรส
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_MARRIED_TIME"]==''?0:number_format($rec["LEAVEHIS_MARRIED_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_MARRIED_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_MARRIED_DAY"],2); ?></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาไปฟื้นฟูสมรรถภาพด้านอาชีพ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_COMPLETENCY_TIME"]==''?0:number_format($rec["LEAVEHIS_COMPLETENCY_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_COMPLETENCY_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_COMPLETENCY_DAY"],2); ?></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	ลาอื่น ๆ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_OTHER_TIME"]==''?0:number_format($rec["LEAVEHIS_OTHER_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_OTHER_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_OTHER_DAY"],2); ?></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	การขาดราชการ
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_WITHOUT_TIME"]==''?0:number_format($rec["LEAVEHIS_WITHOUT_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_WITHOUT_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_WITHOUT_DAY"],2); ?></div>      
 </div>


<div class="row formSep">
 <div class="col-md-4" style="white-space:nowrap;">
                                  	มาสาย
 </div> 
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_LATE_TIME"]==''?0:number_format($rec["LEAVEHIS_LATE_TIME"],0); ?> </div>                  
                            <div class="col-md-4" style="white-space:nowrap;"><?php echo $rec["LEAVEHIS_LATE_DAY"]==''?number_format(0,2):number_format($rec["LEAVEHIS_LATE_DAY"],2); ?></div>      
 </div>


       

</div>
</div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>


</body>
</html>