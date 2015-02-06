<?php 
$menu_name = 202;
$menu_num = "2".$number_subfix;
$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
}
if($ROUND == 1){
   $title_1 = " 1 ตุลาคม ".($year_fillter_is - 1);
}
if($ROUND == 2){
      $title_1 = " 1 เมษายน ".$year_fillter_is;
}

// filter area
include_once("inc_report_top.php");
?>
<script>
function year_select_please(){
       var year_val = $("#AGE_IS option").filter(":selected").val();
       var round_val = $("#ROUND option").filter(":selected").val();
	   if(round_val==""){
		   alert('กรุณา<?php echo $arr_txt['spec_me']; ?>รอบก่อนค่ะ');
		   
		   return false;
		   exit();
	   }
   searchData();
}
</script>


	<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ปีงบประมาณ : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-2">
                <select name="AGE_IS" id="AGE_IS" class="selectbox form-control" placeholder="ปีงบประมาณ">
						<?php 
                        for($y=$YEAR_BUDGET;$y>=$YEAR_BUDGET_PREV;$y--){
                            ?>
                            <option value="<?php echo $y;?>" <?php if($y == $AGE_IS){ echo "selected";} ?>><?php echo $y;?></option>
                            <?php	
                        }
                        ?>
                   </select>			
			</div>
			
			<div class="col-xs-12 col-sm-2 col-sm-offset-2" style="white-space:nowrap;">รอบ : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-3">
				<select name="ROUND" id="ROUND" class="selectbox form-control" placeholder="รอบ">
                    <option value=""></option>
		 
                       <option value="1" <?php if(1 == $ROUND){ echo "selected"; }?>> รอบที่ 1 (1 ตุลาคม - 31 มีนาคม) </option>
                       <option value="2" <?php if(2 == $ROUND){ echo "selected"; }?>> รอบที่ 2 (1 เมษายน - 30 กันยายน) </option>       
                </select>
			</div>
			<div class="col-xs-12 col-sm-2">
	  				
			</div>

            
            <br/><br/><br/>
             <div align="center" ><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);return year_select_please();">ค้นหา</button> </div>
 
		</div><?php  
   $arr_org = array();
   $sql_org = "select ORG_ID, ORG_NAME_TH ";
   $sql_org .= " from SETUP_ORG  "; 
   $sql_org .= " WHERE OL_ID IN ( 6,16 ) AND OT_ID = 6 ";
   $sql_org .= " ORDER BY ORG_SEQ ASC";
	$query_org = $db->query($sql_org); 
	$num_rows = $db->db_num_rows($query_org);

	while($rec_org = $db->db_fetch_array($query_org)){
	     $arr_org[$rec_org['ORG_ID']] = text($rec_org['ORG_NAME_TH']);
	}
	$all_people = 0;
    $all_people_sum = 0;
	$all_salary = 0;
	$all_salary_sum = 0;
	$salary_slide = 0;
	$salary_slide_sum = 0;	
	//$salary_set = 0;
	//$salary_set_sum = 0;
	//$salary_cut = 0;
	//$salary_cut_sum = 0;
	foreach ($arr_org as $key => $value) {
	if($AGE_IS > 0){
	$sql_salary = " select NUM_PER,SALARY_NOW from SAL_FRAME   where ORG_ID_3 =".$key."   AND CONFIRM_TYPE = 2   AND ROUND = '".$ROUND."' AND YEAR_BDG = '".$AGE_IS."'   ";   //echo $sql; exit();
         
			$query_salary = $db->query($sql_salary);
			$rec_salary = $db->db_fetch_array($query_salary);
			$all_salary = (int)$rec_salary['SALARY_NOW'];
			$all_people = (int)$rec_salary['NUM_PER'];
			$all_salary_sum = $all_salary_sum + $all_salary;
			 
			$all_people_sum = $all_people_sum +  $all_people;	
			$salary_slide_sum = $salary_slide_sum + $salary_slide;
			$salary_set_sum = $salary_set_sum + $salary_set;
			$salary_cut_sum = $salary_cut_sum + $salary_cut;
			
		    $salary_slide = ($all_salary*0.03);	
		}      
		
		$html  .= "<tr  ".$tr_detail_style." >";
		$html  .= "<td CENTER_TOP  >".toThaiNumber($start_no)."</td>"; 
		$html  .= "<td LEFT_TOP   >&nbsp;&nbsp;".toThaiNumber($value)."</td>";
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($all_people,0))."&nbsp;</td>"; 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($all_salary,2))."&nbsp;</td>"; 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($salary_slide,2))."&nbsp;</td>"; 
 
		$html  .= "</tr>";
		 $start_no++;
	}
    if($all_people_sum>0){
		$html  .= "<tr  ".$tr_detail_style." >";
		$html  .= "<td CENTER_TOP  > </td>"; 
		$html  .= "<td LEFT_TOP   >&nbsp;&nbsp;รวม</td>";
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($all_people_sum,0))."&nbsp;</td>"; 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($all_salary_sum,2))."&nbsp;</td>"; 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($salary_slide_sum,2))."&nbsp;</td>"; 
 
		$html  .= "</tr>";
		}
$SEARCH_TYPE = $title_1; // pass label year-date to report.
include_once("inc_report_bottom.php"); 
// End report 1
?>