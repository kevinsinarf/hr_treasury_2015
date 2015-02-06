<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 20;
if($postype_id_is > 0){
	if($postype_id_is==3){
	 
	}
	if($postype_id_is==5){
		$menu_name = 60; 
	}
	if($postype_id_is==51){
		$menu_name = 62; 
	}
} 

$headline_title =  $report_menu[$menu_name]['name']; 
   $html  = "";
   $start_no = 1;
   // POST Value;
   $AGE_IS = (int)$_POST['AGE_IS']; 
   $type_is = (int)$_POST['type_is'];  
 
   
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
            <li class="active"><?php echo $headline_title; ?></li>
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
                      <option value=""></option>
                      <?php	
					  $this_year = date(" Y ")+543;
					  $next_tenyear = $this_year+20;
					  $next_5year = $this_year+5;
					  //$this_5year_ago = $this_year-5;
					  if($menu_name==20){ $this_year = $next_5year; }
					  if($menu_name==62){ 
                          for($i=$this_year;$i<=$next_tenyear;$i++)
						  {
						    if($AGE_IS>0)
							{
								 $arr_org1 = array();
								 $arr_org1[$AGE_IS] = $AGE_IS;
							}
							 echo '<option value="'.$i.'" '.($AGE_IS == $i?"selected":"").' > '.$i.'</option>';
						  }
					  }else{
						  for($i=$this_year;$i>2540;$i--)
						  {
									$j = 2014;$j--;
							  if($AGE_IS>0)
							  {
								 $arr_org1 = array();
								 $arr_org1[$AGE_IS] = $AGE_IS;
							  }//if 
							  echo '<option value="'.$i.'" '.($AGE_IS == $i?"selected":"").' > '.$i.'</option>';
						  }
					  }// if $menu_name == 62
 
					  ?>
 
                    
                    </select>				
            </div>
            <div style="display:none;" >
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	ระบุประเภท :		<div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
                  <select id="type_is" name="type_is" class="selectbox form-control"   placeholder="ระบุประเภท"  >  
                        <?php if($menu_name==20){ ?><option value="1" <?php echo ($type_is == 1?"selected":"");?>   >ข้าราชการ</option><?php } ?>
                        <?php if($menu_name>=49){ ?><option value="5" <?php echo ($type_is == 5?"selected":"");?>  >ลูกจ้างประจำ</option><?php } ?>
                        <!--option value="3" <?php echo ($type_is == 3?"selected":"");?> >พนักงานราชการ</option-->                                          
                    </select>	
			</div>
            </div>
            
        </div>
        
 <div class="row" style="margin:0 auto;"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button></div>
 
 
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
					$q_where = officer_year_between($AGE_IS,"a.PER_DATE_RETIRE");
			}else{
					$q_where = officer_year_between($key,"a.PER_DATE_RETIRE");
			}  
		}
 
	    $sql_get_value = " SELECT  a.PER_IDCARD,d.PREFIX_NAME_TH,a.PER_FIRSTNAME_TH,a.PER_LASTNAME_TH,a.PER_DATE_RETIRE 
		FROM PER_PROFILE a 
LEFT JOIN SETUP_PREFIX d ON a.PREFIX_ID = d.PREFIX_ID
WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2  ";
 
         //echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = ".$type_is."     ".$q_where; exit();
		$query_who = $db->query($sql_get_value." and a.PT_ID = ".$type_is."     ".$q_where."  ORDER BY a.PER_DATE_RETIRE ASC "); 
		$sum_all = $db->db_num_rows($query_who); 
             while($rec1 = $db->db_fetch_array($query_who)){
		       $html  .= "<tr  style='height:0.7cm;'> 
					 <td CENTER_TOP  >".$start_no."</td> 
					 <td CENTER_TOP   >&nbsp;&nbsp;".$value."</td> 
					 <td CENTER_TOP   >&nbsp;&nbsp;".get_idCard(text($rec1['PER_IDCARD']))."</td>
					 <td LEFT_TOP   >&nbsp;&nbsp;".text($rec1['PREFIX_NAME_TH'])." ".text($rec1['PER_FIRSTNAME_TH'])." ".text($rec1['PER_LASTNAME_TH'])."</td> 
					 <td CENTER_TOP   >&nbsp;&nbsp;".conv_date($rec1['PER_DATE_RETIRE'],'short')."</td>	 
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
    
    