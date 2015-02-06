<?php 
 

$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 41;
if($postype_id_is > 0){
	if($postype_id_is==5){
		$menu_name = 55; 
	}
} 

 if($menu_name==41){
      $wh_pt_id = " AND  a.PT_ID = 2  ";
 
 }
 if($menu_name==55){
     $wh_pt_id = " AND  a.PT_ID = 3  ";
 
 }
 
$sum_all = 1;
$year_fillter_is = '';
   // POST Value;
   $AGE_IS = $_POST['AGE_IS'];   
   
   // array 
   $arr_org = array();
   $arr_org1 = array();
   $arr_org2 = array();
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");  
 

?>
 
      
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['budget_year_fill']; ?> :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['budget_year']; ?> "     >   
                      <option value=""></option>
                      <?php for($i=2557;$i>2540;$i--){
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
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			<div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
 
<?php  
 	
	$html_start   =  html_report_header($menu_name);
 
    $q_where = '';	
   if($SEARCH_TYPE==1){   
       $arr_org = $arr_org1;
	   if($AGE_IS>0){
			 //$q_where = ' and year(a.PER_DATE_RESIGN) = '.$AGE_IS.'   ';
			 $q_where = " and a.PER_DATE_RESIGN between convert(datetime,'10/01/".($AGE_IS-1)."') and convert(datetime,'09/30/".$AGE_IS."') ";
		}   
   }
		$officer_num = 0;
		$officer_sum =0;
		
		$officer_num_m = 0;
		$officer_sum_m =0;
		
		$officer_num_w = 0;
		$officer_sum_w =0;
		//echo "<pre>"; print_r($arr_org);
		
	foreach ($arr_org as $key => $value) {
 
	     
        if($SEARCH_TYPE==1){ 
		    if($AGE_IS>0){
			        $AGE_IS2 = $AGE_IS-543;

					$q_where = officer_year_between($AGE_IS,"a.PER_DATE_RESIGN");
					$q_where2 = be_user_until($AGE_IS);
			}else{
					$AGE_IS2 = $key-543;

					$q_where = officer_year_between($key,"a.PER_DATE_RESIGN");
					$q_where2 = be_user_until($key);
			}
		}
	
 
	    $sql_get_value = " SELECT  PER_ID FROM PER_PROFILE a   WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1   ";
	 

	          //echo $key.$q_where."<br/>".$sql_get_value." and a.PT_ID = 2     ".$q_where; exit();
		$query_get_officer = $db->query($sql_get_value.$wh_pt_id.$q_where); 
               //echo $sql_get_value." and a.PT_ID = 2  ".$q_where2; exit();
		$query_get_officer_all = $db->query($sql_get_value.$wh_pt_id.$q_where2); 

		
	    $officer_num = $db->db_num_rows($query_get_officer);  
			$officer_sum = $officer_sum + $officer_num;

 

	    $officer_all_num = $db->db_num_rows($query_get_officer_all);  
			$officer_all_sum = $officer_all_sum + $officer_all_num;

			if($officer_all_num>0){
				$officer_rato = ($officer_num/$officer_all_num)*100;
				}else{
				  $officer_rato =  0;
				}

 
		//$all_emp_num = $officer_num_m+$regular_emp_num_m+$temp_emp_num_m+$officer_num_w+$regular_emp_num_w+$temp_emp_num_w;

		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td CENTER_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td CENTER_TOP >".number_format($officer_num,0)."</td> 
			 <td CENTER_TOP >".number_format($officer_all_num,0)."</td> 
			 <td CENTER_TOP >".number_format($officer_rato,0)." %</td>
		 </tr>";
		$start_no++;
	}



include_once("inc_report_bottom.php"); 
// End report 1
?>