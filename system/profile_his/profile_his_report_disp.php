<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$count_num = 1;
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
<script src="js/profile_his_report_disp.js?<?php echo rand(); ?>"></script>

</head>
<body <?php echo $remove;?>>

			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">

<div  class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><?php echo showMenu($menu_sub_id); ?></li>
		</ol>
	</div>
    
    
	<div id="start_content_menu_report" class="col-xs-12 col-md-12" >
<div class="groupdata">

<?php $i = 1; ?>              
     
<?php echo made_panel_heading($arrCompenFor[1]); ?>

<?php echo made_rowhead_form("รายงานทะเบียนประวัติ",1); ?>
 
				<div id="collapse1" class="collapse in">
                        <?php  
						     echo menu_profilehis_report(1,$i,$report_menu[1],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[2],"postype_id=1&".$paramlink,2); $i++;
							?>
 
				</div>
<?php echo made_rowhead_form("รายงานโครงสร้างกำลังคน",2); ?>
 
				<div id="collapse2" class="collapse in">
 
                        <?php 
						     echo menu_profilehis_report(1,$i,$report_menu[3],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[4],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[5],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[7],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[8],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[9],"postype_id=1&".$paramlink,2); $i++;
							?>  
				</div>       

<?php echo made_rowhead_form("รายงานการเคลื่อนไหวของข้าราชการ",3); ?>  
 
				<div id="collapse3" class="collapse in">
                        <?php 
						     echo menu_profilehis_report(1,$i,$report_menu[10],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[11],"postype_id=1&".$paramlink,2); $i++;
 						     echo menu_profilehis_report(1,$i,$report_menu[12],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[13],"postype_id=1&".$paramlink,2); $i++;
 						     echo menu_profilehis_report(1,$i,$report_menu[14],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[16],"postype_id=1&".$paramlink,2); $i++; 
						     echo menu_profilehis_report(1,$i,$report_menu[17],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[18],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[19],"postype_id=1&al=19&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[20],"postype_id=1&al=20&".$paramlink,2); $i++;
							?>
				</div> 
                

<?php echo made_rowhead_form("รายงานการอื่นๆ",4); ?>  
				<div id="collapse4" class="collapse in">
                        <?php 
						     echo menu_profilehis_report(1,$i,$report_menu[191],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[21],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[22],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[23],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[24],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[25],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[26],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[27],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[28],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[29],"postype_id=1&".$paramlink,2); $i++;
 						     echo menu_profilehis_report(1,$i,$report_menu[30],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[31],"postype_id=1&".$paramlink,2); $i++; 
 						     echo menu_profilehis_report(1,$i,$report_menu[32],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[33],"postype_id=1&".$paramlink,2); $i++;
 						     //echo menu_profilehis_report(1,$i,$report_menu[34],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[35],"postype_id=1&".$paramlink,1); $i++;
							 echo '</div>';
							 
							?>    
			</div>                 

		</div> <?php /* End groupdata */ ?>
        					<br/><br/>
                             <?php /********************************************************จบข้าราชการ********************************************************************/ ?>
<div class="groupdata">                          
 <?php echo made_panel_heading($arrCompenFor[2]); ?>   
 
<?php echo made_rowhead_form("รายงานทะเบียนประวัติ",51); ?>
 
				<div id="collapse51" class="collapse in">
                        <?php 
						     echo menu_profilehis_report(1,$i,$report_menu[36],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[37],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(2,$i,$report_menu[38],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[39],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[40],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[41],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[42],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[43],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[44],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[45],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[46],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[47],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[48],"postype_id=3&".$paramlink,1); $i++;
							 echo '</div>';
							?>
				</div>
 
 
 
</div> <?php /* End groupdata */ ?>
        					<br/><br/>    
                            
                             <?php /*********************************************************จบพนักงานราชการ*******************************************************************/ ?>     
                            
<div class="groupdata">                          
 <?php echo made_panel_heading($arrCompenFor[3]); ?>   
 
<?php echo made_rowhead_form("รายงานทะเบียนประวัติ",61); ?>
 
				<div id="collapse61" class="collapse in">
                        <?php 
						     echo menu_profilehis_report(1,$i,$report_menu[49],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[50],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[51],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[52],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[53],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[54],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[55],"postype_id=5&rc=55&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[56],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[57],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[58],"postype_id=5&rc=58&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[59],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[60],"postype_id=5&al=60&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[61],"postype_id=5&".$paramlink,1); $i++;
                             //echo menu_profilehis_report(1,$i,$report_menu[62],"postype_id=51&".$paramlink,2); $i++;
							 echo menu_profilehis_report(1,$i,$report_menu[62],"postype_id=5&al=62&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[63],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[64],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[65],"postype_id=5&".$paramlink,1); $i++;
							  echo '</div>';
							?>
 
				</div>
 
 
</div> <?php /* End groupdata */ ?>
        					<br/><br/>                    
                            
                             <?php /***********************************************************จบลูกจ้าง*****************************************************************/ ?>    

	</div> <?php /* End start_content_menu_report */ ?>
			</form>
</div> 

<div class="hidden-xs" style="height:10em;"></div>
 
	<?php include_once("report_footer2.php"); ?>

</body>
</html>