<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$menu_name = 5; 
$headline_title =  $report_menu[$menu_name]['name'];


   $html  = "";
   $start_no = 1;
   $s_POST_ID = (int)$_POST['s_POST_ID'];
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();   
   $arr_org3 = array();     
 
   $EL_ID = $_POST['EL_ID'];
   $INS_ID = $_POST['INS_ID'];
   $COUNTRY_ID = $_POST['COUNTRY_ID'];
     
    
   
   $sql_line = "select EL_ID, EL_NAME_TH ";
   $sql_line .= " from SETUP_EDU_LEVEL  "; 
 
    $sql_line .= " ORDER BY EL_SEQ ASC";
	$query_line = $db->query($sql_line); 
    //echo $sql_line; exit();

   $sql_level = "select INS_ID, INS_NAME_TH+''+INS_NAME_EN as UNAME ";
   $sql_level .= " from SETUP_EDU_INSTITUTE  "; 
 
    $sql_level .= " ORDER BY UNAME ASC";
	$query_level = $db->query($sql_level); 
	
   $sql_country = "select COUNTRY_ID, COUNTRY_NAME_TH ";
   $sql_country .= " from SETUP_COUNTRY  "; 
 
    $sql_country .= " ORDER BY COUNTRY_NAME_TH ASC";
	$query_country = $db->query($sql_country); 
	
	 
   
   
   
	
//echo $sql_org;
?><!DOCTYPE html>
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


 		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระดับการศึกษา :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="EL_ID" name="EL_ID" class="selectbox form-control" placeholder="ระดับการศึกษา "     >   
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_line)){
					        $arr_org1[$rec1['EL_ID']] = text($rec1['EL_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec1['EL_ID']?>"   >
                        <?php echo text($rec1['EL_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			<div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
        
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">มหาวิทยาลัย :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="INS_ID" name="INS_ID" class="selectbox form-control" placeholder="มหาวิทยาลัย "     >   
                      <option value=""></option>
                      <?php while($rec2 = $db->db_fetch_array($query_level)){
					            $arr_org2[$rec2['INS_ID']] = text($rec2['UNAME']);
					  ?>
                        <option value="<?php echo $rec2['INS_ID']?>"   >
                        <?php echo text($rec2['UNAME'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  			<div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(2);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
        
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเทศที่สำเร็จการศึกษา :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="COUNTRY_ID" name="COUNTRY_ID" class="selectbox form-control" placeholder="ประเทศที่สำเร็จการศึกษา "     >   
                      <option value=""></option>
                      <?php while($rec3 = $db->db_fetch_array($query_country)){
					        $arr_org2[$rec3['COUNTRY_ID']] = text($rec3['COUNTRY_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec3['COUNTRY_ID']?>"   >
                        <?php echo text($rec3['COUNTRY_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			<div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(3);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
        

			    
          
 <?php

 
	
 
	//echo $sql_org;
     ?>

     
     <?php  
 
	
	$html_start   =  html_report_header($menu_name);
	
   $q_where = '';	
   if($SEARCH_TYPE==1){ 
   		if($EL_ID>0){ echo "test"; exit();
		   $q_where = ' AND a.EL_ID = '.$EL_ID.' ';
		   
			 $sql_line = "select a.EL_ID, a.EL_NAME_TH ";
			 $sql_line .= " from SETUP_EDU_LEVEL a WHERE a.ACTIVE_STATUS = 1  ".$q_where; 
		 
			$sql_line .= " ORDER BY a.EL_NAME_TH ASC";  //echo $sql_line; exit();
			$query_line = $db->query($sql_line); 
		 
			
			while($rec_org = $db->db_fetch_array($query_line)){
				 $arr_org[$rec_org['EL_ID']] = text($rec_org['EL_NAME_TH']);
			} //while
		}else{
		    $arr_org = $arr_org1;
		
		}
 
	}// if
	
   if($SEARCH_TYPE==2){ 
   
   		if($INS_ID>0){
		   
		   $q_where = ' AND a.INS_ID = '.$INS_ID.' ';
		}
		 $sql_line = "select a.INS_ID, a.INS_NAME_TH+''+a.INS_NAME_EN as UNAME ";
		 $sql_line .= " from SETUP_EDU_INSTITUTE a  WHERE  a.ACTIVE_STATUS = 1   ".$q_where; 
	 
		$sql_line .= " ORDER BY UNAME ASC"; //echo $sql_line; exit();
		$query_line = $db->query($sql_line); 
	
		
		while($rec_org = $db->db_fetch_array($query_line)){
			 $arr_org[$rec_org['INS_ID']] = text($rec_org['UNAME']);
		}
	}// if
	
	
	 
   if($SEARCH_TYPE==3){ 
   
   		if($COUNTRY_ID>0){
		   
		   $q_where = ' AND a.COUNTRY_ID = '.$COUNTRY_ID.' ';
		}
		 $sql_line = "select a.COUNTRY_ID, a.COUNTRY_NAME_TH ";
		 $sql_line .= " from SETUP_COUNTRY a  WHERE a.ACTIVE_STATUS = 1      ".$q_where; 
	 
		$sql_line .= " ORDER BY a.COUNTRY_NAME_TH ASC";  // echo $sql_line; exit();
		$query_line = $db->query($sql_line); 
	
		
		while($rec_org = $db->db_fetch_array($query_line)){
			 $arr_org[$rec_org['COUNTRY_ID']] = text($rec_org['COUNTRY_NAME_TH']);
		}
	}// if
	
	 
	
	
 
		$officer_num = 0;
		$officer_sum =0;
		$regular_emp_num = 0;
		$regular_emp_sum = 0;
		$temp_emp_num = 0;	
		$temp_emp_sum = 0;	
		
		$officer_num_m = 0;
		$officer_sum_m =0;
		$regular_emp_num_m = 0;
		$regular_emp_sum_m = 0;
		$temp_emp_num_m = 0;	
		$temp_emp_sum_m = 0;	
		
		$officer_num_w = 0;
		$officer_sum_w =0;
		$regular_emp_num_w = 0;
		$regular_emp_sum_w = 0;
		$temp_emp_num_w = 0;	
		$temp_emp_sum_w = 0;	
		
	foreach ($arr_org as $key => $value) {
	

	
		//echo "$key$value<br/>";

		if($s_ORG_NAME_TH>0){
		   $search_org_id = $s_ORG_NAME_TH; 
		   }else{
		    $search_org_id = (int)$key;
		   }
		     if($s_POST_ID>0){
			    $table_get = 'b'; 
			 }else{
			    $table_get = 'a';
			 }
		   
		     if($key==1){
			   $sql_get_value .= ' AND ( ('.$table_get.'.ORG_ID_1 = '.$search_org_id.') OR ('.$table_get.'.ORG_ID_2 = '.$search_org_id.')   ) ';
			 }else{
			   $sql_get_value .= ' AND ( ('.$table_get.'.ORG_ID_3 = '.$search_org_id.') OR ('.$table_get.'.ORG_ID_4 = '.$search_org_id.') OR ('.$table_get.'.ORG_ID_5 = '.$search_org_id.')  ) ';
			 }
		      
		 //echo "on dev ".$sql_get_value; exit();
		$query_get_officer_m = $db->query($sql_get_value." and a.PT_ID = 1  and a.PER_GENDER = 1   "); 
		$query_get_regular_m = $db->query($sql_get_value." and a.PT_ID = 3   and a.PER_GENDER = 1   ");
		$query_get_emp_m  = $db->query($sql_get_value." and a.PT_ID = 2   and a.PER_GENDER = 1  ");
		
		$query_get_officer_w = $db->query($sql_get_value." and a.PT_ID = 1  and a.PER_GENDER = 2   "); 
		$query_get_regular_w = $db->query($sql_get_value." and a.PT_ID = 3   and a.PER_GENDER = 2  ");
		$query_get_emp_w  = $db->query($sql_get_value." and a.PT_ID = 2  and a.PER_GENDER = 2   ");
		
	    $officer_num_m = $db->db_num_rows($query_get_officer_m);  
			$officer_sum_m = $officer_sum_m + $officer_num_m;
		$regular_emp_num_m = $db->db_num_rows($query_get_regular_m);
		    $regular_emp_sum_m = $regular_emp_sum_m + $regular_emp_num_m; 
		$temp_emp_num_m =  $db->db_num_rows($query_get_emp_m);
            $temp_emp_sum_m = $temp_emp_sum_m + $temp_emp_num_m;
		 
		
		
	    $officer_num_w = $db->db_num_rows($query_get_officer_w);  
			$officer_sum_w = $officer_sum_w + $officer_num_w;
		$regular_emp_num_w = $db->db_num_rows($query_get_regular_w);
		    $regular_emp_sum_w = $regular_emp_sum_w + $regular_emp_num_w; 
		$temp_emp_num_w =  $db->db_num_rows($query_get_emp_w);
            $temp_emp_sum_w = $temp_emp_sum + $temp_emp_num_w;
		$all_emp_num = $officer_num_m+$regular_emp_num_m+$temp_emp_num_m+$officer_num_w+$regular_emp_num_w+$temp_emp_num_w;
		
		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td CENTER_TOP >".number_format($officer_num_m,0)."</td> 
			 <td CENTER_TOP >".number_format($officer_num_w,0)."</td> 
			 <td CENTER_TOP >".number_format($regular_emp_num_m,0)."</td> 
			 <td CENTER_TOP >".number_format($regular_emp_num_w,0)."</td>
			 <td CENTER_TOP >".number_format($temp_emp_num_m,0)."</td> 	
			 <td CENTER_TOP >".number_format($temp_emp_num_w,0)."</td> 	
			 <td CENTER_TOP >".number_format($all_emp_num,0)."</td> 
			  
		 </tr>";
		$start_no++;
	}
	
	reset($arr_org);
	    // summery 
	$sum_all = $officer_sum_m+$regular_emp_sum_m+$temp_emp_sum_m+$officer_sum_w+$regular_emp_sum_w+$temp_emp_sum_w;
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>รวมจำนวน ( อัตรา )</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format($officer_sum_m,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format($officer_sum_w,0)."</strong></div></td>
			 <td CENTER_TOP ><div align='center'><strong>".number_format($regular_emp_sum_m,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format($regular_emp_sum_w,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format($temp_emp_sum_m,0)."</strong></div></td> 	
			 <td CENTER_TOP ><div align='center'><strong>".number_format($temp_emp_sum_w,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format($sum_all,0)."</strong></div></td> 
			 
		 </tr>";
	
		$html_end   = "</table>";


if($sum_all > 0){ ?>
</form>   
<?php  



?>

<?php echo print_btn($menu_name,$html); ?>
    
<?php } 


	$html =  str_replace("CENTER_TOP",$CENTER_TOP,$html);
	$html =  str_replace("LEFT_TOP",$LEFT_TOP,$html);		
?><div class="col-xs-12 col-sm-12">
<?php
	echo $html_start.$html.$html_end;	
 ?> </div>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    