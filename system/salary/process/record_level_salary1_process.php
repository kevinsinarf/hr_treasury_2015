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
$SALARY_NOW = $_POST['SALARY_NOW'];
$SALARY_SPE_NOW = $_POST['SALARY_SPE_NOW'];
$SCORE = $_POST['SCORE'];
$SCORE_ID = $_POST['SCORE_ID'];
$LEVEL_SALARY_MID = $_POST['LEVEL_SALARY_MID'];
$SCORE_PERCENT = $_POST['SCORE_STEP'];
$PERCENT_SPE = $_POST['PERCENT_SPE'];
$SALARY_CAL = $_POST['SALARY_CAL'];
$SALARY_SPE_CAL = $_POST['SALARY_SPE_CAL'];
$SALARY_UP = $_POST['SALARY_UP'];
$SALARY_SPE_UP = $_POST['SALARY_SPE_UP'];
$SALARY_NEW = $_POST['SALARY_NEW'];
$SALARY_SPE_NEW = $_POST['SALARY_SPE_NEW'];
$REMARKS = $_POST['REMARKS'];

$ARR_SCORE_1 = $_POST['SCORE_1'];
$ARR_SCORE_2 = $_POST['SCORE_2'];


$url_back="../record_level_salary1_form.php";
$table = "SAL_UP_SALARY";

switch($proc){	
	case 'save' :
		try{
			if(count($PER_ID) > 0){
				foreach($PER_ID as $key => $perId){
					$q_per = $db->query("SELECT POS_ID, TYPE_ID, LEVEL_ID, LINE_ID, MANAGE_ID, ORG_ID_1, ORG_ID_2, ORG_ID_3, ORG_ID_4 FROM PER_PROFILE WHERE PER_ID = '".$perId."'");
					$r_per = $db->db_fetch_array($q_per);
					
					if($SAL_UP_ID[$key] == ''){
						$fields = array(
							"YEAR_BDG" => $S_YEAR_BDG,
							"ROUND" => $S_ROUND,
							"PER_ID" => $perId,
							"POS_ID" => $r_per['POS_ID'],
							"POSTYPE_ID" => '3',
							"TYPE_ID" => $r_per['TYPE_ID'],
							"LEVEL_ID" => $r_per['LEVEL_ID'],
							"LINE_ID" => $r_per['LINE_ID'],
							"MANAGE_ID" => $r_per['MANAGE_ID'],
							"ORG_ID_1" => $r_per['ORG_ID_1'],
							"ORG_ID_2" => $r_per['ORG_ID_2'],
							"ORG_ID_3" => $r_per['ORG_ID_3'],
							"ORG_ID_4" => $r_per['ORG_ID_4'],
							"SAL_TYPE" =>2,
							"SALARY_NOW" => str_replace(",","",$SALARY_NOW[$key]),
							"SALARY_SPE_NOW" => str_replace(",", "", $SALARY_SPE_NOW[$key]),
							"SCORE" => $SCORE[$key],
							"SCORE_1" => $ARR_SCORE_1[$key],
							"SCORE_2" => $ARR_SCORE_2[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"LEVEL_SALARY_MID" => str_replace(",", "", $LEVEL_SALARY_MID[$key]),
							"SCORE_PERCENT" => $SCORE_PERCENT[$key],
							"PERCENT_SPE" => str_replace(",", "", $PERCENT_SPE[$key]),
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
							"SALARY_SPE_CAL" => str_replace(",", "", $SALARY_SPE_CAL[$key]),
							"SALARY_UP" => str_replace(",","",$SALARY_UP[$key]),
							"SALARY_SPE_UP" => str_replace(",","",$SALARY_SPE_UP[$key]),
							"SALARY_NEW" => str_replace(",","",$SALARY_NEW[$key]),
							"SALARY_SPE_NEW" => str_replace(",","",$SALARY_SPE_NEW[$key]),
							"REMARKS" => ctext($REMARKS[$key]),
							"CREATE_BY" => $USER_BY,
							"CREATE_DATE" => $TIMESTAMP,
							"UPDATE_BY" => $USER_BY,
							"UPDATE_DATE" => $TIMESTAMP,
						);	
						$db->db_insert($table,$fields);
					}else{
						$fields = array(
							"PER_ID" => $perId,
							"POS_ID" => $r_per['POS_ID'],
							"TYPE_ID" => $r_per['TYPE_ID'],
							"LEVEL_ID" => $r_per['LEVEL_ID'],
							"LINE_ID" => $r_per['LINE_ID'],
							"MANAGE_ID" => $r_per['MANAGE_ID'],
							"ORG_ID_1" => $r_per['ORG_ID_1'],
							"ORG_ID_2" => $r_per['ORG_ID_2'],
							"ORG_ID_3" => $r_per['ORG_ID_3'],
							"ORG_ID_4" => $r_per['ORG_ID_4'],
							"SALARY_NOW" => str_replace(",","",$SALARY_NOW[$key]),
							"SALARY_SPE_NOW" => str_replace(",", "", $SALARY_SPE_NOW[$key]),
							"SCORE_1" => $ARR_SCORE_1[$key],
							"SCORE_2" => $ARR_SCORE_2[$key],
							"SCORE" => $SCORE[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"LEVEL_SALARY_MID" => str_replace(",", "", $LEVEL_SALARY_MID[$key]),
							"SCORE_PERCENT" => $SCORE_PERCENT[$key],
							"PERCENT_SPE" => str_replace(",", "", $PERCENT_SPE[$key]),
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
							"SALARY_SPE_CAL" => str_replace(",", "", $SALARY_SPE_CAL[$key]),
							"SALARY_UP" => str_replace(",","",$SALARY_UP[$key]),
							"SALARY_SPE_UP" => str_replace(",","",$SALARY_SPE_UP[$key]),
							"SALARY_NEW" => str_replace(",","",$SALARY_NEW[$key]),
							"SALARY_SPE_NEW" => str_replace(",","",$SALARY_SPE_NEW[$key]),
							"REMARKS" => ctext($REMARKS[$key]),
							"UPDATE_BY" => $USER_BY,
							"UPDATE_DATE" => $TIMESTAMP,
						);	
						$db->db_update($table, $fields, " SAL_UP_ID = '".$SAL_UP_ID[$key]."'");
					}
				}
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	/*case 'getPercent' :
		$query = $db->query("SELECT SCORE_ID, PERCENT_SAL, PERCENT_SAL_SPE FROM SAL_SCORE WHERE PT_ID = '2' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND LEVEL_ID = '".$LEVEL_ID."' AND '".$score."' BETWEEN SCORE_S AND SCORE_E");
		$rec = $db->db_fetch_array($query);
		echo $rec['SCORE_ID'].'@'.number_format($rec['PERCENT_SAL'],2).'@'.number_format($rec['PERCENT_SAL_SPE'],2);
		exit;
	break;*/
	case 'getStep':
		$query = $db->query("SELECT SCORE_ID,STEP_SAL,PERCENT_SAL_SPE FROM SAL_SCORE WHERE PT_ID = 2 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND LEVEL_ID = '".$LEVEL_ID."' AND '".$score."' BETWEEN SCORE_S AND SCORE_E");
		$rec = $db->db_fetch_array($query);
		echo $rec['SCORE_ID'].'@'.number_format($rec['STEP_SAL'],2).'@'.number_format($rec['PERCENT_SAL_SPE'],2);
		exit;
	break;
	
	case 'getStepSal':
		$query = $db->query("SELECT * FROM SAL_STEP_DETAIL WHERE STEP_NO = '".$step_up_sal."' ");
		$rec = $db->db_fetch_array($query);
		echo $rec['SAL_MONTH'];
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
