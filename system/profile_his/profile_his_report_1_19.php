<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 18;
$menu_num = "";
if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 44;
		$menu_num = "42".$number_subfix;
	}
	if($postype_id_is==5){
		$menu_name = 59;
		$menu_num = "57".$number_subfix;
	}
} 


$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = (int)$_POST['AGE_IS']; 
   $type_is = (int)$_POST['type_is'];  
   $out_for_is = (int)$_POST['out_for_is'];
   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_report_1_4.js?<?php echo rand(); ?>"></script>

</head>
<body <?php echo $remove;?>> <?php  ///echo "<pre>"; print_r($_POST);  ?>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="profile_his_report_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
            <?php active_title($menu_num.$headline_title); ?>
		</ol>
	</div>
    
    
	<div class="col-xs-12 col-md-12" id="content">
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
                <input type="hidden" id="SEARCH_TYPE" name="SEARCH_TYPE" value="" >
                <input type="hidden" id="SEARCH_F" name="SEARCH_F" value="" >
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>">   
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "     >   
                   
                      <?php	
					  $this_year = date(" Y ")+543;
					  //$this_5year_ago = $this_year-5;
					  for($i=$this_year;$i>2540;$i--){
					            $j = 2014;$j--;
					      if($AGE_IS>0){
						     $arr_org1 = array();
					     	 $arr_org1[$AGE_IS] = $AGE_IS;
						  }else{
					     	 //$arr_org1[$i] = $i; 	
						  }	
					  
					  ?>
                        <option value="<?php echo $i;?>"  <?php echo ($AGE_IS == $i?"selected":"");?>    >
                        <?php echo $i;?></option>
                      <?php }?>
                    </select>				
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	 รูปแบบการย้าย :		<div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
                  <select id="out_for_is" name="out_for_is" class="selectbox form-control"   placeholder="เลือกรูปแบบการย้าย" >  
                   
                  
                        <option value="1"  <?php echo ($out_for_is == 1?"selected":"");?>  >ย้ายออกระหว่างกอง</option>
                        <option value="2"  <?php echo ($out_for_is == 2?"selected":"");?> >ย้ายออกระหว่างสายงาน</option>    
                                                              
                    </select>	
			</div>
        </div>
        
   <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();","c"); ?>
        
 
 
 <?php
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
       $arr_org = $arr_org1;
	   
	   if($AGE_IS>0){
 
			 $q_where = ' and year(a.PER_DATE_RESIGN) = '.$AGE_IS.'   ';		 
		}else{
		    exit();
		}   
   }else{
       exit();
   }

		
	foreach ($arr_org as $key => $value) {
        if($SEARCH_TYPE==1){ 
		    if($AGE_IS>0){
					$q_where = officer_year_between($AGE_IS,"b.COM_SDATE");
			}else{
					$q_where = officer_year_between($key,"b.COM_SDATE");
			}  
		}
    if($out_for_is>0){
	    if($out_for_is==1){ // ย้ายออกระหว่างกอง
							$sql_get_value = " SELECT a.PER_IDCARD,d.PREFIX_NAME_TH,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH, c.MOVEMENT_GROUP,b.POS_NO,
							b.ORG_ID_3 as new_position,
							a.ORG_ID_3 as old_position,a.POS_NO ,
							b.ORG_ID_4,a.ORG_ID_4,c.MOVEMENT_NAME_TH ,e.LINE_NAME_TH  
					FROM PER_POSITIONHIS b 
					LEFT JOIN PER_PROFILE a ON b.PER_ID = a.PER_ID
					LEFT JOIN SETUP_MOVEMENT c ON b.MOVEMENT_ID = c.MOVEMENT_ID
					LEFT JOIN SETUP_PREFIX d ON a.PREFIX_ID = d.PREFIX_ID
					LEFT JOIN SETUP_POS_LINE e ON a.LINE_ID = e.LINE_ID 
					WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
					AND c.MOVEMENT_GROUP = 1 
					AND b.ORG_ID_3 <> a.ORG_ID_3 ";
		}else{ // ย้ายออกระหว่างสายงาน
		
	   					 $sql_get_value = " SELECT  a.PER_IDCARD,d.PREFIX_NAME_TH,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH,  c.MOVEMENT_GROUP,b.POS_NO,
						 b.LG_ID as new_position, 
						 a.LG_ID as old_position ,a.POS_NO
						 ,b.ORG_ID_4,a.ORG_ID_4,c.MOVEMENT_NAME_TH ,e.LINE_NAME_TH 
						 FROM PER_POSITIONHIS b 
						 LEFT JOIN PER_PROFILE a ON b.PER_ID = a.PER_ID 
						 LEFT JOIN SETUP_MOVEMENT c ON b.MOVEMENT_ID = c.MOVEMENT_ID 
						 LEFT JOIN SETUP_PREFIX d ON a.PREFIX_ID = d.PREFIX_ID
						 LEFT JOIN SETUP_POS_LINE e ON a.LINE_ID = e.LINE_ID 
						 WHERE a.PER_STATUS =2 
AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 AND c.MOVEMENT_GROUP = 1 
AND  ((ISNULL(NULLIF(a.LG_ID, ''), 0) <> b.LG_ID)    )    ";
		}
	}else{
	   exit();
	}
 
         //echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = ".$type_is."     ".$q_where; exit();
		$query_who = $db->query($sql_get_value." and a.POSTYPE_ID = ".$POSTYPE_ID_is."     ".$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
		       $html  .= "<tr  style='height:0.7cm;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
			 
					 <td CENTER_TOP   >&nbsp;&nbsp;".text($rec1['PER_IDCARD'])."</td>  
					 <td CENTER_TOP   >&nbsp;&nbsp;".text($rec1['POS_NO'])."</td>  
					 <td LEFT_TOP   >&nbsp;&nbsp;".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td> 	 
					 <td CENTER_TOP   >&nbsp;&nbsp;".text($rec1['LINE_NAME_TH'])."</td>  
					 <td CENTER_TOP   >&nbsp;&nbsp;".text($rec1['old_position'])."</td>  
					 <td CENTER_TOP   >&nbsp;&nbsp;".text($rec1['new_position'])."</td>  
				  </tr>";
			$start_no++;
	  }
	}
 
		$html_end   = "</table>";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    