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

<?php // echo made_rowhead_form("รายงานทะเบียนประวัติ",1); ?>
 
				<div id="collapse1" class="collapse in">
                        <?php  
						     
						     echo menu_profilehis_report2(1,$i,$report_menu[201],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report2(1,$i,$report_menu[202],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report2(1,$i,$report_menu[206],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report2(1,$i,$report_menu[207],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report2(1,$i,$report_menu[208],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report2(1,$i,$report_menu[210],"postype_id=1&".$paramlink,2); $i++;
						     echo menu_profilehis_report2(1,$i,$report_menu[203],"postype_id=1&".$paramlink,1); $i++;
                             echo menu_profilehis_report2(1,$i,$report_menu[211],"postype_id=1&".$paramlink,2); $i++;
							?>
 
				</div>
 
                 

		</div> <?php /* End groupdata */ ?>
        					<br/><br/>
                             <?php /********************************************************จบข้าราชการ********************************************************************/ ?>
<div class="groupdata">                          
 <?php echo made_panel_heading($arrCompenFor[2]); ?>   
 
<?php // echo made_rowhead_form("รายงานทะเบียนประวัติ",51); ?>
 
				<div id="collapse51" class="collapse in">
                        <?php 
						
						     echo menu_profilehis_report2(1,$i,$report_menu[204],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report2(1,$i,$report_menu[205],"postype_id=3&".$paramlink,2); $i++; 
						
						
						/*
						     echo menu_profilehis_report(1,$i,$report_menu[36],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[37],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(2,$i,$report_menu[38],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(2,$i,$report_menu[39],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(2,$i,$report_menu[40],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(2,$i,$report_menu[41],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[42],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[43],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[44],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[45],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[46],"postype_id=3&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[47],"postype_id=3&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[48],"postype_id=3&".$paramlink,1); $i++;
							 echo '</div>';
							 */
							?>
				</div>
 
 
 
</div> <?php /* End groupdata */ ?>
        					<br/><br/>    
                            
                             <?php /*********************************************************จบพนักงานราชการ*******************************************************************/ ?>     
                            
<div class="groupdata">                          
 <?php echo made_panel_heading($arrCompenFor[3]); ?>   
 
<?php // echo made_rowhead_form("รายงานทะเบียนประวัติ",61); ?>
 
				<div id="collapse61" class="collapse in">
                        <?php 
						
						
						     echo menu_profilehis_report2(1,$i,$report_menu[301],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report2(1,$i,$report_menu[302],"postype_id=5&".$paramlink,2); $i++; 
						
						
						/*
						     echo menu_profilehis_report(1,$i,$report_menu[49],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[50],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(2,$i,$report_menu[51],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(2,$i,$report_menu[52],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(2,$i,$report_menu[53],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[54],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(2,$i,$report_menu[55],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[56],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[57],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[58],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[59],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[60],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[61],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[62],"postype_id=51&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[63],"postype_id=5&".$paramlink,1); $i++;
                             echo menu_profilehis_report(1,$i,$report_menu[64],"postype_id=5&".$paramlink,2); $i++;
						     echo menu_profilehis_report(1,$i,$report_menu[65],"postype_id=5&".$paramlink,1); $i++;
							  echo '</div>';
							  */
							?>
 
				</div>
 
 
</div> <?php /* End groupdata */ ?>
        					<br/><br/>                    
                            
                             <?php /***********************************************************จบลูกจ้าง*****************************************************************/ ?>    

	</div> <?php /* End start_content_menu_report */ ?>
			</form>
</div> 

<div class="hidden-xs" style="height:10em;"></div>
<div class="row"  height:51px; padding-top:8px; color:#FFF">
	<?php // include_once("report_footer2.php"); ?>

</body>
</html>