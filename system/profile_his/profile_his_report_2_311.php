<?php 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 38; 
$menu_num = "36".$number_subfix;
if($postype_id_is > 0){
	if($postype_id_is==5){
$menu_name = 51; 
	}
} 

$arr_org = array();
$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
}
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");  

  
   $sql_type = "select TYPE_ID, TYPE_NAME_TH ";
   $sql_type .= " from SETUP_POS_TYPE WHERE POSTYPE_ID = ".$postype_id_is." AND ACTIVE_STATUS = 1   "; 
 
    $sql_type .= " ORDER BY TYPE_NAME_TH ASC";
	$query_type = $db->query($sql_type); 

   //echo $sql_type; 
// เลือกเฉพาะที่มีอยู่จริง 
   $sql_line = "select DISTINCT a.LINE_ID,b.LINE_NAME_TH,a.POSTYPE_ID from POSITION_FRAME a 
left join setup_pos_line b on a.line_id = b.line_id
where a.ACTIVE_STATUS = 1 AND a.POSTYPE_ID = ".$postype_id_is."
  "; 
 
    $sql_line .= " ORDER BY b.LINE_NAME_TH ASC";
	$query_line = $db->query($sql_line); 

  

   $sql_level = "select LEVEL_ID, LEVEL_NAME_TH ";
   $sql_level .= " from SETUP_POS_LEVEL  WHERE ACTIVE_STATUS = 1  AND POSTYPE_ID = ".$postype_id_is." "; 
 
    $sql_level .= " ORDER BY LEVEL_NAME_TH ASC";
	$query_level = $db->query($sql_level); 

?>
 

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทพนักงานราชการ :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="ทั้งหมด "     >   
                      <option value=""></option>
                      <?php 
					   $arr_org3 = array();
					   while($rec1 = $db->db_fetch_array($query_type)){
                       $arr_org3[$rec1['TYPE_ID']] = text($rec1['TYPE_NAME_TH']);
					  ?>
                        <option value="<?php echo $rec1['TYPE_ID']?>"   <?php echo ($rec1['TYPE_ID'] == $TYPE_ID?"selected":"");?>  >
                        <?php echo text($rec1['TYPE_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
 
 <?php echo btn_do_center("$('#SEARCH_TYPE').val(3);searchData();","a"); ?>
			</div>
        </div>
        


		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทกลุ่มงาน :</div>
			<div class="col-xs-12 col-sm-3">

                    
                    <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox form-control" placeholder="ทั้งหมด"     >   
                      <option value=""></option>
                      <?php 
					    $arr_org1 = array();
					    while($rec2 = $db->db_fetch_array($query_level)){
                        $arr_org1[$rec2['LEVEL_ID']] = text($rec2['LEVEL_NAME_TH']);
						?>
                        <option value="<?php echo $rec2['LEVEL_ID']?>"  <?php echo ($rec2['LEVEL_ID'] == $LEVEL_ID?"selected":"");?>  >
                        <?php echo text($rec2['LEVEL_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
                    
                    		
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
 
  <?php echo btn_do_center("$('#SEARCH_TYPE').val(1);searchData();","a"); ?>
			</div>
        </div>
 
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ตำแหน่ง :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ทั้งหมด"     >   
                      <option value=""></option>
                      <?php 
					   $arr_org2 = array();
					   while($rec1 = $db->db_fetch_array($query_line)){
                        $arr_org2[$rec1['LINE_ID']] = text($rec1['LINE_NAME_TH']);
					   ?>
                        <option value="<?php echo $rec1['LINE_ID']?>"   <?php echo ($rec1['LINE_ID'] == $LINE_ID?"selected":"");?>   >
                        <?php echo text($rec1['LINE_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"></div>
			<div class="col-xs-12 col-sm-2">
     <?php echo btn_do_center("$('#SEARCH_TYPE').val(2);searchData();","a"); ?>
              
			</div>
        </div>
 
<?php  
   $filed_add = "  ,b.PER_FIRSTNAME_TH,b.PER_LASTNAME_TH,b.PER_IDCARD ";
   $q_where = '';
   $title_is = "ประเภทพนักงานราชการ";
   
   if($SEARCH_TYPE==2){ 
		$title_is = "ตำแหน่ง";
		$svalue = "a.LINE_ID";
		$arr_org = $arr_org2;  
   		if($LINE_ID>0){
		   $q_where = ' AND a.LINE_ID = '.$LINE_ID.' ';
		   $arr_org = array();
		   $arr_org[$LINE_ID] = $arr_org2[$LINE_ID]; 
		}  
	}// if
	
   if($SEARCH_TYPE==1){ 
		$arr_org = $arr_org1;
		$title_is = "ประเภทกลุ่มงาน";
		$svalue = "a.LEVEL_ID";
   		if($LEVEL_ID>0){ 
		   $q_where = ' AND a.LEVEL_ID = '.$LEVEL_ID.' ';
		   $arr_org = array();
		   $arr_org[$LEVEL_ID] = $arr_org1[$LEVEL_ID]; 
		}
		 
	}// if
	

	 
   if($SEARCH_TYPE==3){ 
		$arr_org = $arr_org3;
		$title_is = "ประเภทพนักงานราชการ";
		$svalue = "a.TYPE_ID";
   		if($TYPE_ID>0){
		   $q_where = ' AND a.TYPE_ID = '.$TYPE_ID.' ';
		   $arr_org = array();
		   $arr_org[$TYPE_ID] = $arr_org3[$TYPE_ID]; 
		}
		 
	}// if
	 
 	 $html_start   =  html_report_header($menu_name,$title_is); 
	 
	 // basic SQL
	 $sql = " SELECT  count(a.PER_ID) as num_people FROM PER_PROFILE a WHERE   a.ACTIVE_STATUS = 1 AND a.DELETE_FLAG = 0  AND a.POSTYPE_ID = ".$postype_id_is."  AND a.PER_STATUS_CIVIL = 2 ".$q_where;
	 
 
	 
	foreach ($arr_org as $key => $value) {
            
		    $query_m = $db->query($sql."  and a.PER_GENDER = 1   AND ".$svalue."  = '".$key."'  "); 
		    $m_data = $db->db_fetch_array($query_m);
			$m_value = (int)$m_data['num_people'];
			
		    $query_w = $db->query($sql."  and a.PER_GENDER = 2   AND ".$svalue."  = '".$key."'  "); 
		    $w_data = $db->db_fetch_array($query_w);
			$w_value = (int)$w_data['num_people'];
			
			$all_value = (int)($m_value + $w_value);
				
			$html  .= "<tr  style='height:0.7cm; padding-left:3px;'> 
				 <td CENTER_TOP  >".$start_no."</td> 
				 <td LEFT_TOP   >".$value." </td>
			 	 <td CENTER_TOP ><strong>".number_format($m_value,0)."&nbsp; &nbsp;</strong></td> 
			     <td CENTER_TOP ><strong>".number_format($w_value,0)."&nbsp; &nbsp;</strong></td> 
			     <td CENTER_TOP ><strong>".number_format($all_value,0)."&nbsp; &nbsp;</strong></td> 	 
				 ";
				 
			$html  .= " </tr>";
			$start_no++;	
			$m_value_sum = $m_value_sum + $m_value;	
			$w_value_sum = $w_value_sum + $w_value;	
			}
			$all_sum =$m_value_sum+$w_value_sum;
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>รวมจำนวน  </strong></div></td> 
			 <td CENTER_TOP ><strong>".number_format($m_value_sum,0)."&nbsp; &nbsp;</strong></td> 
			 <td CENTER_TOP ><strong>".number_format($w_value_sum,0)."&nbsp; &nbsp;</strong></td> 
			 <td CENTER_TOP ><strong>".number_format($all_sum,0)."&nbsp; &nbsp;</strong></td> 	 
		 </tr>";		 

		//} //foreach 
  // } // $arr_org; 


include_once("inc_report_bottom.php"); 
// End report 1
?>