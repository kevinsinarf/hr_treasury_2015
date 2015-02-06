<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$menu_name = 17;
$menu_num  = "15".$number_subfix;
$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = $_POST['AGE_IS']; 
   $type_is = 1; //(int)$_POST['type_is'];  
   
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
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "  style="width:300px"   >   
                     
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
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	<?php echo $arr_txt['type_pos']; ?> :		<div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
                    <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"    onChange=" call_level(this.value);"    >   
                     <option value=""  ></option>
                      <?php
					   $sql_type = "select TYPE_ID, TYPE_NAME_TH ";
					   $sql_type .= " from SETUP_POS_TYPE WHERE POSTYPE_ID = 1 AND ACTIVE_STATUS = 1  "; 
					 
						$sql_type .= " ORDER BY TYPE_SEQ ASC";
						$query_type = $db->query($sql_type); 
					   while($rec1 = $db->db_fetch_array($query_type)){?>
                        <option value="<?php echo $rec1['TYPE_ID']?>"   <?php echo ($rec1['TYPE_ID'] == $TYPE_ID?"selected":"");?>  >
                        <?php echo text($rec1['TYPE_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
			</div>
        </div>
        
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระดับที่ได้เลื่อน :</div>
			<div class="col-xs-12 col-sm-3">
 
                        <div id="LEVEL_AREA" NAME="LEVEL_AREA" >
                    <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['show_all']; ?>"  style="width:300px;">   
                    <option value=""  ></option>
                      <?php


					   $sql_level = "select LEVEL_ID, LEVEL_NAME_TH ";
					   $sql_level .= " from SETUP_POS_LEVEL  WHERE ACTIVE_STATUS = 1  AND  POSTYPE_ID = 1 "; 
					 
						$sql_level .= " ORDER BY LEVEL_NAME_TH ASC";
						$query_level = $db->query($sql_level); 
					   while($rec2 = $db->db_fetch_array($query_level)){?>
                        <option value="<?php echo $rec2['LEVEL_ID']?>"  <?php echo ($rec2['LEVEL_ID'] == $LEVEL_ID?"selected":"");?>  >
                        <?php echo text($rec2['LEVEL_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
                  </div>	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	 <div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();"); 
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
       $arr_org = $arr_org1;
	   
	   if($AGE_IS>0){
 
			 $q_where = ' and year(a.PER_DATE_ENTRANCE) = '.$AGE_IS.'   ';		 
		}else{
		    exit();
		}   
   }else{
       exit();
   }

	foreach ($arr_org as $key => $value) {
        if($SEARCH_TYPE==1){ 
		    if($AGE_IS>0){
					$q_where = officer_year_between($AGE_IS,"a.PER_DATE_ENTRANCE");
			}else{
					$q_where = officer_year_between($key,"a.PER_DATE_ENTRANCE");
			}  
		}
 
	    $sql_get_value = "  SELECT a.PER_IDCARD,b.PREFIX_NAME_TH,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH ,c.MOVEMENT_ID ,
a.POS_ID,a.LINE_ID, e.LINE_NAME_TH,a.PER_SALARY as SALARY, a.LEVEL_ID as new_level,c.LEVEL_ID  as OLD_LEVEL,f.LEVEL_NAME_TH as New_Level,g.LEVEL_NAME_TH as Old_Level,a.PER_DATE_LEVEL ,h.ORG_NAME_TH
FROM PER_PROFILE a  
LEFT JOIN SETUP_PREFIX b ON a.PREFIX_ID = b.PREFIX_ID   
LEFT JOIN PER_POSITIONHIS c ON a.per_id = c.per_id
LEFT JOIN SETUP_MOVEMENT d ON c.MOVEMENT_ID = d.MOVEMENT_ID
LEFT JOIN SETUP_POS_LINE e ON a.LINE_ID = e.LINE_ID 
LEFT JOIN SETUP_POS_LEVEL f ON a.LEVEL_ID = f.LEVEL_ID  
LEFT JOIN SETUP_POS_LEVEL g ON c.LEVEL_ID = g.LEVEL_ID  
LEFT JOIN SETUP_ORG h ON a.ORG_ID_3 = h.ORG_ID 
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1  AND a.PER_STATUS_CIVIL = 2  AND d.MOVE_PROCESS_ID = 5    ";  // MOVE_PROCESS_ID = 5   
if($TYPE_ID > 0){
	    $sql_get_value .= "  AND a.TYPE_ID = '".$TYPE_ID."'  ";
}
if($LEVEL_ID > 0){
	    $sql_get_value .= "  AND a.LEVEL_ID = '".$LEVEL_ID."'  ";
}


 

//  AND a.PER_STATUS_CIVIL = 2  AND d.MOVE_PROCESS_ID = 5   

		$query_who = $db->query($sql_get_value." and a.PT_ID = ".$type_is."    ".$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
		       $html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
 
					 <td CENTER_TOP   >".get_idCard(text($rec1['PER_IDCARD']))."</td> 
					 <td CENTER_TOP   >".$rec1['POS_ID']."</td>
					 <td LEFT_TOP   >".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td> 	 
					 <td CENTER_TOP   >".text($rec1['LINE_NAME_TH'])."</td>
				 <td CENTER_TOP >".number_format($rec1['SALARY'],2)."&nbsp;</td> 
					 <td CENTER_TOP   >".text($rec1['Old_Level'])."</td>
					 <td CENTER_TOP   >".text($rec1['New_Level'])."</td>
					 <td CENTER_TOP   >".conv_date($rec_pos['PER_DATE_LEVEL'],'short')."</td>
					 <td CENTER_TOP   >".text($rec['ORG_NAME_TH'])."</td>
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
    
    