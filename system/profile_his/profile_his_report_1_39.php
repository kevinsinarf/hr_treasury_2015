 <?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 191;
$menu_num = "19".$number_subfix;
 
 

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
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> <?php echo $arr_txt['budget_year_fill']; ?> : </div>
			<div class="col-xs-12 col-sm-3"> 
    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="ทั้งหมด"  style="width:200px"   >   
                      <option value=""></option>
                      <?php 
					  $this_month =  date('m', time());  
					  $this_year =  date('Y', time());
					  $this_year_temp = $this_year;
					  if($this_year < 2300){
					      $this_year = $this_year + 543;
					  }  
					 //if($this_month >= 10){
					      $this_year  = $this_year+1;
					 // } 
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
                        <option value="<?php echo $i;?>"  <?php echo ($AGE_IS == $i?"selected":"");?>    >
                        <?php echo $i;?></option>
                      <?php }?>
                    </select>	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  ประเภทการถือครอง :  </div>
			<div class="col-xs-12 col-sm-2">
<?php
$arr_poshis_live = array(  
									 
										'2' => 'ปฏิบัติราชการแทน',
										'3' => 'รักษาราชการแทน',
										'4' => 'ช่วยราชการภายในสำนักงานฯ',
										'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
								);

?>  <?php  echo GetHtmlSelect('TYPE_LIVE','TYPE_LIVE',$arr_poshis_live,'ทั้งหมด',$_POST['TYPE_LIVE'],'','','1','','2');?>	
			</div>
        </div>
 
<?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();");  
	
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
   
      $sql = " SELECT a.per_id ,i.PER_IDCARD,i.PER_SALARY, i.PREFIX_ID, i.PER_FIRSTNAME_TH, i.PER_MIDNAME_TH, i.PER_LASTNAME_TH, 
	  a.POS_NO,b.LINE_NAME_TH,a.COM_SDATE ,  d.ORG_NAME_TH,e.OT_NAME_TH ,f.CT_NAME_TH,a.COM_NO,a.COM_DATE,g.LEVEL_NAME_TH,
a.MOVEMENT_ID,h.MOVEMENT_NAME_TH ,a.TYPE_LIVE ,a.COM_SDATE
				from PER_POSITIONHIS  a
LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID 
LEFT JOIN SETUP_ORG d ON a.ORG_ID_3 = d.org_id
LEFT JOIN SETUP_ORG_TYPE e ON d.OT_ID = e.OT_ID
LEFT JOIN SETUP_COMMAND_TYPE f ON a.CT_ID = f.CT_ID
LEFT JOIN SETUP_POS_LEVEL g ON a.LEVEL_id = g.LEVEL_id
LEFT JOIN SETUP_MOVEMENT h ON a.MOVEMENT_ID = h.MOVEMENT_ID
LEFT JOIN PER_PROFILE i ON a.per_id = i.per_id 
WHERE a.TYPE_LIVE not in (1) ";
if($TYPE_LIVE > 1){ 
		$sql .= " AND  a.TYPE_LIVE = '".$TYPE_LIVE."' ";
} //echo $sql 
	   if($AGE_IS>0){
	    if($AGE_IS > 2300){ $AGE_IS = $AGE_IS-543; }
		$sql .= " and a.COM_SDATE between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".($AGE_IS)."') ";
			 
		}   //echo $sql;exit();
		$query_who = $db->query($sql); 
 
             while($rec_per = $db->db_fetch_array($query_who)){
			 
	         $PER_NAME = Showname($rec_per["PREFIX_ID"],$rec_per["PER_FIRSTNAME_TH"],$rec_per["PER_MIDNAME_TH"],$rec_per["PER_LASTNAME_TH"]);
				$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
					 <td CENTER_TOP   >".get_idCard(text($rec_per['PER_IDCARD']))."</td> 
					 <td LEFT_TOP >".$PER_NAME."</td> 
					 <td CENTER_TOP > ".$rec_per['POS_NO']."&nbsp;&nbsp;</td> 

					 
					 <td LEFT_TOP > ".text($rec_per['LINE_NAME_TH'])."</td>  
					 <td LEFT_TOP > ".text($rec_per['LEVEL_NAME_TH'])."</td> 
					 <td LEFT_TOP > ".text($rec_per['MANAGE_NAME_TH'])."</td> 
				      <td CENTER_TOP >".conv_date($rec_per['COM_SDATE'],'short')."</td> 
			 
					 <td CENTER_TOP >".$arr_poshis_live[$rec_per['TYPE_LIVE']]."</td>  
					 

				 </tr>";
				$start_no++;
	         }
   }
 
	 
     
	
		$html_end   = "</table>   ";
		include_once("inc_print_btn_and_output.php"); ?>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    