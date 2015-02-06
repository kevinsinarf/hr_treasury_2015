<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}

$rc = (int)$_GET['rc'];
if($rc==0){
	$rc = (int)$_POST['rc'];
}


$menu_name = 16;
$menu_num = "14".$number_subfix;
 
if($postype_id_is > 0){
	if($postype_id_is==3){
		$menu_name = 43; 
		$menu_num = "41".$number_subfix;
	}
	
	if($postype_id_is==5){
	    if($rc==55){
			$menu_name = 55; 
		    $menu_num = "53".$number_subfix;
		}
	    if($rc==58){
			$menu_name = 58; 
			$menu_num = "56".$number_subfix;
		}
	}
} 


$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = (int)$_POST['AGE_IS']; 
   $AGE_IS_gen = $AGE_IS; // for print data.
   $RETIRE_ID = (int)$_POST['RETIRE_ID'];
   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
   $arr_retype2 = GetSqlSelectArray("RETYPE_ID","RETYPE_NAME_TH","RETIRE_SETUP_TYPE"," ACTIVE_STATUS=1 and DELETE_FLAG='0' ","RETYPE_NAME_TH" );
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
  <?php echo report_breadcrumb($paramlink,showMenu($menu_sub_id),$menu_num.$headline_title); ?>
    
    
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
                <input type="hidden" id="rc" name="rc" value="<?php echo $rc; ?>">   
                  
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "  style="width:200px"   >   
                     
                      <?php 
					  $this_month =  date('m', time());  
					  $this_year =  date('Y', time());
					  $this_year_temp = $this_year;
					  if($this_year < 2300){
					      $this_year = $this_year + 543;
					  }  
					  if($this_month >= 10){
					      $this_year  = $this_year+1;
					  } 
					  if($AGE_IS > 0){
					  	$search_year = $AGE_IS;
					  }else{
					  	$search_year = $this_year;
					  }
					   for($i=$this_year;$i>2540;$i--){
					            $j = 2014;$j--;
					      if($AGE_IS>0){
						     $arr_org1 = array();
					     	 $arr_org1[$AGE_IS] = $AGE_IS;
						  }else{
					     	 $arr_org1[$i] = $i; 	
						  }	
						  

						  
						  
					  ?>
                        <option value="<?php echo $i;?>"  <?php echo ($search_year == $i?"selected":"");?>    >
                        <?php echo $i;?></option>
                      <?php }?>
                    </select>						
            </div>
            
            <?php
			if($menu_name!=55){ ?>
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	 สถานะ :		<div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
             	<?php  echo GetHtmlSelect('RETYPE_ID','RETYPE_ID',$arr_retype2,'ทั้งหมด',$RETYPE_ID,'','','1');?>			</div>
          <?php }?>
            
            
        </div>
        
        
 		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">   </div>
			<div class="col-xs-12 col-sm-3">
          
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	
    
            <div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
        
 
     <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 
     
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
					$q_where = officer_year_between($AGE_IS,"a.PER_DATE_RESIGN");
			}else{
					$q_where = officer_year_between($key,"a.PER_DATE_RESIGN");
			}  
		}
 
	    $sql_get_value = " SELECT a.PER_IDCARD,b.PREFIX_NAME_TH,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH ,a.POS_NO, 
a.RETIRE_ID ,a.LINE_ID ,c.LINE_NAME_TH ,d.LEVEL_NAME_TH ,a.MT_ID,MT_NAME_TH,a.PER_SALARY,a.ORG_ID_3,f.ORG_NAME_TH,a.POS_ID
,g.ORG_NAME_TH as frame_name 
FROM PER_PROFILE a  
LEFT JOIN SETUP_PREFIX b ON a.PREFIX_ID = b.PREFIX_ID  
LEFT JOIN SETUP_POS_LINE c ON a.LINE_ID =  c.LINE_ID
LEFT JOIN SETUP_POS_LEVEL d ON a.LEVEL_ID = d.LEVEL_ID
LEFT JOIN SETUP_POS_MANAGE_TYPE e ON a.MT_ID = e.MT_ID 
LEFT JOIN SETUP_ORG f ON a.ORG_ID_3 = f.ORG_ID 
LEFT JOIN POSITION_FRAME h ON a.POS_ID = h.POS_ID 
LEFT JOIN SETUP_ORG g ON h.ORG_ID_3 = g.ORG_ID 

WHERE a.POSTYPE_ID =  '".$postype_id_is."'  ";

		$query_who = $db->query($sql_get_value."   and a.RETYPE_ID = '".$RETYPE_ID."'    ".$q_where); //  
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
		       $html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
					 <td CENTER_TOP   >".get_idCard(text($rec1['PER_IDCARD']))."</td> 
					 <td CENTER_TOP   > ".$rec1['POS_NO']."</td> 
					 <td LEFT_TOP   >".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td> 	
					 <td LEFT_TOP   >".text($rec1['LINE_NAME_TH'])."&nbsp;&nbsp;  </td> 
					 <td CENTER_TOP   >".text($rec1['LEVEL_NAME_TH'])."&nbsp;&nbsp;  </td>
					 <td CENTER_TOP   >".text($rec1['MT_NAME_TH'])."&nbsp;&nbsp;  </td>  
					 <td RIGHT_TOP   >".number_format($rec1['PER_SALARY'],2)."&nbsp;&nbsp;  </td>  
					 <td CENTER_TOP   >".text($rec1['frame_name'])."&nbsp;&nbsp;  </td>  
					 <td LEFT_TOP   >".text($rec1['ORG_NAME_TH'])."&nbsp;&nbsp;  </td>  
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
    
    