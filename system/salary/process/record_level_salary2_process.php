<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$SAL_UP_ID = $_POST['SAL_UP_ID'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$ORG_ID = $_POST['ORG_ID'];
$PER_ID = $_POST['PER_ID'];
$SCORE = $_POST['SCORE'];
$SCORE_ID = $_POST['SCORE_ID'];
$LEVEL_SALARY_MID = $_POST['LEVEL_SALARY_MID'];
$SCORE_PERCENT = $_POST['SCORE_PERCENT'];
$PERCENT_SPE = $_POST['PERCENT_SPE'];
$SALARY_CAL = $_POST['SALARY_CAL'];
$SALARY_SPE_CAL = $_POST['SALARY_SPE_CAL'];
$SALARY_UP = $_POST['SALARY_UP'];
$SALARY_SPE_UP = $_POST['SALARY_SPE_UP'];
$SALARY_NEW = $_POST['SALARY_NEW'];
$SALARY_SPE_NEW = $_POST['SALARY_SPE_NEW'];
$LEVEL_SALARY_MAX = $_POST['LEVEL_SALARY_MAX'];
$REMARKS = $_POST['REMARKS'];

$ARR_SCORE_1 = $_POST['SCORE_1'];
$ARR_SCORE_2 = $_POST['SCORE_2'];


$url_back="../record_level_salary2_form.php";
$table = "SAL_UP_SALARY";

switch($proc){	
	case 'save' :
		try{
			if(count($PER_ID) > 0){
				foreach($PER_ID as $key => $perId){
				
						$fields = array(
							"SCORE_1" => $ARR_SCORE_1[$key],
							"SCORE_2" => $ARR_SCORE_2[$key],
							"SCORE" => $SCORE[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"SCORE_PERCENT" => $SCORE_PERCENT[$key],
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
							"SALARY_SPE_CAL" => str_replace(",", "", $SALARY_SPE_CAL[$key]),
							"SALARY_UP" => str_replace(",","",$SALARY_UP[$key]),
							"SALARY_SPE_UP" => str_replace(",","",$SALARY_SPE_UP[$key]),
							"SALARY_NEW" => str_replace(",","",$SALARY_NEW[$key]),
							"SALARY_SPE_NEW" => str_replace(",","",$SALARY_SPE_NEW[$key]),
							"LEVEL_SALARY_MAX" => str_replace(",","",$LEVEL_SALARY_MAX[$key]),
							"REMARKS" => ctext($REMARKS[$key]),
							"UPDATE_BY" => $USER_BY,
							"UPDATE_DATE" => $TIMESTAMP,
						);	
						$db->db_update($table, $fields, " SAL_UP_ID = '".$SAL_UP_ID[$key]."'");
				
				}
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'ConfirmCom':
		try{	
		   $db->query('BEGIN TRANSACTION');
		   
		 
		   $db->db_update($table,array('CONFIRM_TYPE' => 3)," POSTYPE_ID = 3 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND SAL_UP_TYPE = 1 AND ORG_ID_3 = '".$ORG_ID."' "); 
		   $text= text('อนุมัติเกณฑ์การประเมิน เรียบร้อยแล้ว');
		  
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case 'getPercent' :
		$LEVEL_ID = $_POST['LEVEL_ID'];
		$SCORE = $_POST['score'];
		$query_level = $db->query("SELECT LEVEL_SALARY_MIN, LEVEL_SALARY_MAX FROM SETUP_POS_LEVEL_SALARY  WHERE POSTYPE_ID = 3  AND LEVEL_ID = '".$LEVEL_ID."' ");
		$rec_level = $db->db_fetch_array($query_level);
		
		$MAX = $rec_level['LEVEL_SALARY_MAX'];
		$MIN = $rec_level['LEVEL_SALARY_MIN'];
	
		$query = $db->query("SELECT SCORE_ID,  SCORE_TYPE, SCORE_S,SCORE_E, PERCENT_SAL, PERCENT_SAL_E FROM SAL_SCORE WHERE POSTYPE_ID = '3' AND SCORE_STATUS = 1 AND CONFIRM_TYPE = 2  AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ".$SCORE."  BETWEEN SCORE_S AND SCORE_E");
		$rec = $db->db_fetch_array($query);
		
		  if($rec['SCORE_TYPE']==1){ 
			  $result = (($score-$rec['SCORE_S'])* (($rec['PERCENT_SAL_E']-$rec['PERCENT_SAL']) / ($rec['SCORE_E']-$rec['SCORE_S'])))+$rec['PERCENT_SAL'];
		  }else if($rec['SCORE_TYPE']==2){
			  $result = $rec['PERCENT_SAL'];
		  }else if($rec['SCORE_TYPE']==3){
			  $total = ($rec['SCORE_E'] - $rec['SCORE_S'])/2;
			  $total1 = $rec['SCORE_S']+$total;
			  
			  if($score<$total1){
				  $result = $rec['PERCENT_SAL'];
			  }else if($score>=$total1){
				  $result = $rec['PERCENT_SAL_E'];
			  }
		  }
		  $row['SCORE_ID'] = $rec['SCORE_ID'];
		  $row['PERCENT'] = number_format($result,5);
		  $row['SALARY_MAX'] = $MAX;
		  $row['SALARY_MIN']  = $MIN;
		  
		echo json_encode($row);
		exit;
	break;
	
	case 'getSalaryCal' :
		$PER_STEP = $db->get_data_field("SELECT PER_STEP FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."'", "PER_STEP");		
		$STEP_UP+=$PER_STEP;
		
		$SAL_MONTH = $db->get_data_field("SELECT SAL_MONTH FROM SAL_STEP JOIN SAL_STEP_DETAIL ON SAL_STEP_DETAIL.STEP_ID = SAL_STEP.STEP_ID WHERE LEVEL_SEQ = '".$LEVEL_SEQ."' AND STEP_NO = '".$STEP_UP."'", "SAL_MONTH");
		echo $SAL_MONTH;
		exit;
	break;
	
	case "get_level" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TYPE_ID = ".$type_id." AND POSTYPE_ID = '".$postype_id."' ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 }
	 exit;
	break;
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LEVEL_ID = '".$level_id."'  AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
		exit;
	}break;
}
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="search" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="S_YEAR_BDG" name="S_YEAR_BDG" value="<?php echo $S_YEAR_BDG;?>" />
	<input type="hidden" id="S_ROUND" name="S_ROUND" value="<?php echo $S_ROUND;?>" />
	<input type="hidden" id="ORG_ID" name="ORG_ID" value="<?php echo $ORG_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
