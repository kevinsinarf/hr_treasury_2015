
<?php
$path = "../../";
include($path."include/config_header_top.php");
 //echo "test: "; print_r($_POST); exit();
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$CERTIFICATE_ID=$_POST['CERTIFICATE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"; 

//DATA
$CERTHIS_ID = (int)$_POST['CERTHIS_ID'];
if($proc=="edit"){     

	$sql = "select CERTHIS_NO,CERTHIS_DATE,CERTIFICATE_ID,CERTHIS_ID,CERTIFICATE_BY  from PER_CERTIFICATEHIS WHERE CERTHIS_ID = ".$CERTHIS_ID."    "; 
	$query = $db->query($sql);
	$rec_edit = $db->db_fetch_array($query);

	$sql = "select CERTIFICATE_ID, CERTIFICATE_NAME_TH, CERTIFICATE_BY from SETUP_CERTIFICATE  ";
}
if($proc=="add"){
	$rec_edit = array();
	$sql = "select CERTIFICATE_ID, CERTIFICATE_NAME_TH, CERTIFICATE_BY from SETUP_CERTIFICATE WHERE SETUP_CERTIFICATE.CERTIFICATE_ID NOT IN (SELECT CERTIFICATE_ID FROM PER_CERTIFICATEHIS)
   ";
}
$query_cert_list = $db->query($sql);
$rec = $db->db_fetch_array($query_cert_list);

//echo count($rec);
 
 
//$rec = @array_change_key_case($rec,CASE_LOWER);
/*
 $cert_arr = array();
 while($rec2 = $db->db_fetch_array($query_cert_list)){ 
     //echo $rec1['CERTIFICATE_ID']."<br/>";
	 $cert_arr[$rec2['CERTIFICATE_ID']] = $rec2['CERTIFICATE_BY'];
 }
 */
 
 

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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/data_profess_licensing.js?<?php echo rand(); ?>"></script>


</head>
<body>  
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
			<!--<div class="row heading"><?php echo $txt;?></div>-->
            <form id="frm-input" method="post" action="process/data_process_licensing_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
<?php if($proc=="edit"){    ?>
                <input type="hidden" id="CERTHIS_ID" name="CERTHIS_ID" value="<?php echo $rec_edit['CERTHIS_ID']; ?>">
<?php } ?>
                <input type="hidden" id="flagDup1" name="flagDup1">
                <input type="hidden" id="flagDup2" name="flagDup2">
 

                 
                
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					ใบประกอบวิชาชีพ (<?php echo $arr_txt['th'];?>)&nbsp;&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                     
                      <?php /*  onChange="chkDup('chkDup1','flagDup1','CERTIFICATE_ID','CERTIFICATE_ID','SETUP_CERTIFICATE','');" */ ?>
                      <?php while($rec1 = $db->db_fetch_array($query_cert_list)){
					      if(($rec1['CERTIFICATE_ID'] == $rec_edit['CERTIFICATE_ID'])){
						     echo text($rec1['CERTIFICATE_NAME_TH']);
						  }
						  }
					  ?>
                                                
                    
					<?php
                    if($proc=="edit"){     ?>
                    <input type="hidden" id="OLD_ID_is" name="OLD_ID_is" class="form-control"   value="<?php echo $rec_edit['CERTIFICATE_ID']; ?>" maxlength="20"   >
                    <?php   
                    }
                    ?>
    
                    
                    </div> 
                    <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
				</div>
 
 
 
			 	<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					หน่วยงานที่ออกให้ &nbsp;&nbsp;&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <?php echo $rec_edit['CERTIFICATE_BY']; ?>
                    </div>   
                    <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
				</div>
 
		  
  
			 	<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					เลขที่ใบอุนุญาติ &nbsp;&nbsp;&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    
                    <?php echo $rec_edit['CERTHIS_NO']; ?>
                    </div>   
                    <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
				</div>
                
                

 
 
			 	<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					วันที่มีผลบังคับใช้ &nbsp;&nbsp;&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                     <div class="input-group">
                      <?php 
							function thaiDateFromUnix() {
							
								if (func_num_args()) { // have timestamp
									$timestamp = func_get_arg(0);
								} else { // no argument
									$timestamp = mktime();
								}
							
								setlocale(LC_TIME, "th");
								$be = strftime("%Y", $timestamp) + 543;
								return strftime("%#d/%m/", $timestamp) . $be;
							
							}			  
							function thaiDateFromString() {
							
								if (func_num_args()) { // have time string e.g. "yyyy-mm-dd"
									$timestamp = strtotime(func_get_arg(0));
								} else { // no argument
									$timestamp = mktime();
								}
							
								return thaiDateFromUnix($timestamp);
							
							}
					       //echo date(thaiDateFromString($rec_edit['CERTHIS_DATE'])) . "<br/>";
						   // echo date('d/m/Y', strtotime($rec_edit['CERTHIS_DATE']));
							if($proc=="edit"){   
						   		$date_value = date(thaiDateFromString($rec_edit['CERTHIS_DATE']));
							}else{
								$date_value = '';
							}
					  
					  ?>
                      <?php echo $date_value; ?>
                       
                       </div>                   
                    </div> 
                    
                    <span id="chkDup3" class="col-sm-2 hidden-xs label"></span>
				</div>
 
                
                    
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->