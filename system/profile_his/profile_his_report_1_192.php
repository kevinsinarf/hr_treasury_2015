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
$menu_num = "16".$number_subfix;
 
$LINE_ID = (int)$_POST['LINE_ID'];

$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = (int)$_POST['AGE_IS']; 
   $type_is = 1;// (int)$_POST['type_is'];  
  ///  
   
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
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>">   
        
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
            <div class="col-xs-12 col-sm-1"></div>
						<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['org_label_name']; ?> :</div>
			<div class="col-xs-12 col-sm-2">
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control"  placeholder="<?php echo $arr_txt['show_all']; ?>"       >   
                      <option value=""></option>
                      <?php 
   $sql_org = "select ORG_ID, ORG_NAME_TH ";
   $sql_org .= " from SETUP_ORG  "; 
   $sql_org .= " WHERE ".ORG_basic_where();
 
 
 
   $sql_org .= "  ORDER BY ORG_SEQ ASC";
	$query_org = $db->query($sql_org); 
					  while($rec1 = $db->db_fetch_array($query_org)){
					        $arr_org[$rec1['ORG_ID']] = text($rec1['ORG_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec1['ORG_ID']?>"  <?php echo ($rec1['ORG_ID'] ==$LINE_ID?"selected":"");?>    >
                        <?php echo text($rec1['ORG_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
			</div>
        </div>
        
        
 		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">   </div>
			<div class="col-xs-12 col-sm-3">
 
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
					$q_where = officer_year_between($AGE_IS,"b.COM_SDATE");
			}else{
					$q_where = officer_year_between($key,"b.COM_SDATE");
			}  
		}
 
							$sql_get_value = "  SELECT a.PER_IDCARD,d.PREFIX_NAME_TH,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH, 
							c.MOVEMENT_GROUP,b.POS_NO,b.ORG_ID_3 as new_position,a.ORG_ID_3 as old_position,
b.ORG_ID_4,a.ORG_ID_4,c.MOVEMENT_NAME_TH 
							,a.POS_NO as N_POS_NO ,e.TYPE_NAME_TH as TYPE_NAME_NEW, g.LINE_NAME_TH as LINE_NAME_NEW, i.LEVEL_NAME_TH as LEVEL_NAME_NEW, k.MANAGE_NAME_TH as M_NAME_NEW ,m.ORG_NAME_TH as ORG_NAME_NEW
							,b.POS_NO  as O_POS_NO ,f.TYPE_NAME_TH as TYPE_NAME_OLD , h.LINE_NAME_TH as LINE_NAME_OID , j.LEVEL_NAME_TH as LEVEL_NAME_OID, l.MANAGE_NAME_TH as M_NAME_OLD ,n.ORG_NAME_TH as ORG_NAME_OLD
,a.TYPE_ID
					FROM PER_POSITIONHIS b 
					LEFT JOIN PER_PROFILE a ON b.PER_ID = a.PER_ID
					LEFT JOIN SETUP_MOVEMENT c ON b.MOVEMENT_ID = c.MOVEMENT_ID
					LEFT JOIN SETUP_PREFIX d ON a.PREFIX_ID = d.PREFIX_ID
	
					LEFT JOIN SETUP_POS_TYPE e ON a.TYPE_ID = e.TYPE_ID 
					LEFT JOIN SETUP_POS_TYPE f ON b.TYPE_ID = f.TYPE_ID 
					LEFT JOIN SETUP_POS_LINE g ON a.LINE_ID = g.LINE_ID 
					LEFT JOIN SETUP_POS_LINE h ON b.LINE_ID  = h.LINE_ID
					LEFT JOIN SETUP_POS_LEVEL i ON a.LEVEL_ID = i.LEVEL_ID 
					LEFT JOIN SETUP_POS_LEVEL j ON b.LEVEL_ID = j.LEVEL_ID 
					LEFT JOIN SETUP_POS_MANAGE k ON a.MANAGE_ID = k.MANAGE_ID
					LEFT JOIN SETUP_POS_MANAGE l ON b.MANAGE_ID = l.MANAGE_ID
					LEFT JOIN SETUP_ORG m ON a.ORG_ID_3 = m.ORG_ID
					LEFT JOIN SETUP_ORG n ON b.ORG_ID_3 = n.ORG_ID	
					WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 
					AND c.MOVEMENT_GROUP = 1 
					AND b.ORG_ID_3 <> a.ORG_ID_3 ";
                    if($LINE_ID > 0){
					  $sql_get_value .= " AND a.ORG_ID_3 = '".$LINE_ID."' ";
					}
		 
                    //AND  ((ISNULL(NULLIF(a.LG_ID, ''), 0) <> b.LG_ID)    )    ";
 
 
        // echo $sql_get_value." and a.PT_ID = ".$type_is."     ".$q_where; exit();
		$query_who = $db->query($sql_get_value." and a.PT_ID = ".$type_is."     ".$q_where); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
		       $html  .= "<tr  style='height:0.7cm;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
													 
					 <td CENTER_TOP   >&nbsp;&nbsp;".get_idCard($rec1['PER_IDCARD'])."</td>  
					 <td LEFT_TOP   >&nbsp;&nbsp;".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td> 
					  <td LEFT_TOP   >&nbsp;&nbsp; ".$arr_txt['pos_no']." ".$rec1['O_POS_NO']."<br/>
					  &nbsp;&nbsp;".$arr_txt['type_pos']." ".text($rec1['TYPE_NAME_OLD'])."<br/>
					  &nbsp;&nbsp;ตำแหน่งในสายงาน ".text($rec1['LINE_NAME_OID'])."<br/>
					  &nbsp;&nbsp;ระดับ ".text($rec1['LEVEL_NAME_OID'])."<br/>
					  &nbsp;&nbsp;ตำแหน่งในการบริหาร  ".text($rec1['M_NAME_OLD'])."<br/>
					  &nbsp;&nbsp;สังกัด / กอง  ".text($rec1['ORG_NAME_OLD'])."<br/>
					  
					  </td> 	 
					  <td LEFT_TOP   >&nbsp;&nbsp; ".$arr_txt['pos_no']." ".$rec1['N_POS_NO']."<br/>
					  &nbsp;&nbsp;".$arr_txt['type_pos']." ".text($rec1['TYPE_NAME_NEW'])."<br/>
					  &nbsp;&nbsp;ตำแหน่งในสายงาน ".text($rec1['LINE_NAME_NEW'])."<br/>
					  &nbsp;&nbsp;ระดับ ".text($rec1['LEVEL_NAME_NEW'])."<br/>
					  &nbsp;&nbsp;ตำแหน่งในการบริหาร   ".text($rec1['M_NAME_NEW'])."<br/>
					  &nbsp;&nbsp;สังกัด / กอง    ".text($rec1['ORG_NAME_NEW'])."<br/>
					  
					  
					  </td> 	 
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
    
    