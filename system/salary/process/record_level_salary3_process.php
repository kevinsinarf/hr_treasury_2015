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
$STEP_UP = $_POST['STEP_UP'];
$PERCENT_SPE = $_POST['PERCENT_SPE'];
$SALARY_CAL = $_POST['SALARY_CAL'];
$SALARY_UP = $_POST['SALARY_UP'];
$SALARY_SPE_UP = $_POST['SALARY_SPE_UP'];
$SALARY_NEW = $_POST['SALARY_NEW'];
$SALARY_SPE_NEW = $_POST['SALARY_SPE_NEW'];
$REMARKS = $_POST['REMARKS'];

$url_back="../record_level_salary3_form.php";
$table = "SAL_UP_SALARY";

switch($proc){	
	case 'save' :
		try{
			if(count($PER_ID) > 0){
				foreach($PER_ID as $key => $perId){
					
						$fields = array(
							"SCORE" => $SCORE[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"STEP_UP" => $STEP_UP[$key],
							"PERCENT_SPE" => str_replace(",", "", $PERCENT_SPE[$key]),
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
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
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'ConfirmCom':
		try{	
		   $db->query('BEGIN TRANSACTION');
		   
		 
		   $db->db_update($table,array('CONFIRM_TYPE' => 3)," POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND SAL_UP_TYPE = 1 AND ORG_ID_3 = '".$ORG_ID."' "); 
		   $text= 'อนุมัติการเลื่อนค่าจ้าง เรียบร้อยแล้ว';
		  
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case 'getPercent' :
		$MIN = "";
		$MAX = "";
		$SCORE_MID = '';
		$PRECENT_S = '';
		$PRECENT_E = '' ;
		$result = "";
		$score = $_POST['score'];
	    $LEVEL_ID = $_POST['LEVEL_ID'];
	    $LINE_ID = $_POST['LINE_ID'];
		
		$sql_max = "SELECT MAX(A.SAL_MONTH) AS LEVEL_SALARY_MAX 
		FROM SETUP_POS_STEP_EMP_GOV_SALARY A 
		WHERE A.LEVEL_ID = '".$LEVEL_ID."' AND  A.LINE_ID = '".$LINE_ID."' ";
		$sql_min = "SELECT MIN(A.SAL_MONTH) AS LEVEL_SALARY_MIN 
		FROM SETUP_POS_STEP_EMP_GOV_SALARY A 
		WHERE A.LEVEL_ID = '".$LEVEL_ID."' AND A.LINE_ID = '".$LINE_ID."' ";
		$query_level_max = $db->query($sql_max);
		$rec_max = $db->db_fetch_array($query_level_max);
		
		$query_level_min = $db->query($sql_min);
		$rec_levle_min = $db->db_fetch_array($query_level_min);
		
		$MAX =  $rec_max['LEVEL_SALARY_MAX'];
		$MIN =  $rec_levle_min['LEVEL_SALARY_MIN'];
		
		$query = $db->query("SELECT DISTINCT(SCORE_TYPE) AS SCORE_TYPE, SCORE_ID, SCORE_S,SCORE_E, PERCENT_SAL,PERCENT_SAL_E FROM SAL_SCORE WHERE POSTYPE_ID = '5' AND SCORE_STATUS = 1  AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND '".$score."' BETWEEN SCORE_S AND SCORE_E");
		$rec = $db->db_fetch_array($query);
		
		if($rec['SCORE_TYPE']==1){ 
		    $PRECENT_S = $rec['PERCENT_SAL'];
			$PRECENT_E = $rec['PERCENT_SAL_E'];
		    $SCORE_MID = ($rec['SCORE_S']+$rec['SCORE_E'])/2;
			$SCORE_MID = round($SCORE_MID,0);
			if($score <= $SCORE_MID){
				$result = $PRECENT_S;
			}
			if($score > $SCORE_MID){
				$result = $PRECENT_E;
			}
		}
		
		$row['SCORE_ID'] = $rec['SCORE_ID'];
		$row['STEP'] = $result ;
		$row['SALARY_MAX'] = $MAX;
		$row['SALARY_MIN']  = $MIN;
		echo json_encode($row);
		
		exit;
	break;
	
	case 'getSalaryCal' :
	    $SALARY_UP = '';
		$UP_STATUS = '';
	    $STEP = '';
	    $STEP_CAL = '';
		$STEP_DIFF = 0;
	    $MAX_STEP = '';
	    $SALARY_NOW = $_POST['SALARY_NOW'];
	    $LEVEL_ID = $_POST['LEVEL_ID'];
		$LINE_ID = $_POST['LINE_ID'];
		$STEP_UP = $_POST['STEP_UP'];
		
	    $query_now = $db->query("SELECT STEP_SEQ FROM SETUP_POS_STEP_EMP_GOV_SALARY WHERE LEVEL_ID = '".$LEVEL_ID."' AND LINE_ID = '".$LINE_ID."' AND SAL_MONTH = '".$SALARY_NOW."' ");
		$rec_now = $db->db_fetch_array($query_now);
		$STEP_NOW = (float)$rec_now['STEP_SEQ'];
		
		if($STEP_NOW > 0){
			$query_max = $db->query("SELECT  MAX(STEP_SEQ) AS MAX_SEQ FROM SETUP_POS_STEP_EMP_GOV_SALARY WHERE LEVEL_ID = '".$LEVEL_ID."' AND LINE_ID = '".$LINE_ID."' ");
			$rec_max = $db->db_fetch_array($query_max);
			$MAX_STEP = $rec_max['MAX_SEQ'];
			$STEP = $STEP_NOW+$STEP_UP;
			
			if($STEP <= $MAX_STEP){
				$STEP_CAL = $STEP;
				$UP_STATUS = 1;
				$query_up = $db->query("SELECT STEP_SEQ, SAL_MONTH FROM SETUP_POS_STEP_EMP_GOV_SALARY WHERE LEVEL_ID = '".$LEVEL_ID."' AND LINE_ID = '".$LINE_ID."' AND STEP_SEQ = ".$STEP_CAL." ");
				$rec_up = $db->db_fetch_array($query_up);
			}else if($STEP > $MAX_STEP){
				$UP_STATUS = 2;
				$STEP_CAL = $MAX_STEP;
				$STEP_DIFF = $STEP - $MAX_STEP;
				$query_up = $db->query("SELECT STEP_SEQ, SAL_MONTH FROM SETUP_POS_STEP_EMP_GOV_SALARY WHERE LEVEL_ID = '".$LEVEL_ID."' AND LINE_ID = '".$LINE_ID."' AND STEP_SEQ = ".$STEP_CAL." ");
				$rec_up = $db->db_fetch_array($query_up);
				
			}
			$SALARY_UP = $rec_up['SAL_MONTH']; 
		}
	  
		$row['STEP'] =  $STEP_CAL;
		$row['UP_STATUS'] = $UP_STATUS;
		$row['STEP_DIFF'] = $STEP_DIFF;
		$row['SALARY_UP'] = $SALARY_UP;
		echo json_encode($row); 
		//echo;
		exit;
	break;
	case "get_level" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC ";
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
	case "get_co_level" : 
		$sql_co = " SELECT A.CO_ID, A.TYPE_ID, B.LEVEL_SEQ AS LEVEL_SEQ_MIN, C.LEVEL_SEQ AS LEVEL_SEQ_MAX 
					FROM SETUP_POS_CO_LEVEL A
               		JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID_MIN = B.LEVEL_ID AND A.TYPE_ID = B.TYPE_ID
			   		JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID_MAX = C.LEVEL_ID AND A.TYPE_ID = C.TYPE_ID 
               		WHERE A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0 AND B.POSTYPE_ID = '".$postype_id."' AND  C.POSTYPE_ID = '".$postype_id."' AND A.TYPE_ID = '".$type_id."' ";
			  $query_co = $db->query($sql_co);
			  $i = 0;
			  while($rec_co = $db->db_fetch_array($query_co)){
				  $query_co_level = $db->query("SELECT LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_SEQ BETWEEN '".$rec_co['LEVEL_SEQ_MIN']."' AND '".$rec_co['LEVEL_SEQ_MAX']."' AND POSTYPE_ID = 1 AND ACTIVE_STATUS =1 AND DELETE_FLAG = 0 ORDER BY LEVEL_SEQ ASC   ");
				  $arr_co_id[] = trim($rec_co['CO_ID']);
				  while($rec_co_level = $db->db_fetch_array($query_co_level)){
					  $arr_co[trim($rec_co['CO_ID'])][$i] = text($rec_co_level['LEVEL_NAME_TH']);
					  $i++;
				  }
			  }
			  
			 $obj = array();
			 if(count($arr_co_id) > 0){
			  foreach($arr_co_id as $index => $val){
				  $text = @implode(' / ', $arr_co[$val]);
				  $row['ID'] = $val;
				  $row['VALUE'] = $text;
				  array_push($obj,$row);
			  }
			  echo json_encode($obj);
		  }
		  exit;
	break;
	case "get_line_group" : 
		$sql = "Select LG_ID , LG_NAME_TH From SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LG_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LG_ID'];
			$row['VALUE'] = text($rec['LG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
		exit;
	break;
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LG_ID = ".$lg_id." AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
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
	case "get_manage" : {
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 AND MT_ID = '".$mt_id."' ORDER BY MANAGE_ID ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['MANAGE_ID'];
			$row['VALUE'] = text($rec['MANAGE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}
		exit;
	break;
	
	case "get_org_4" : 
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_parent_id."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"S_ORG_ID_4\" name=\"S_ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
			echo "<option value=\"\"></option>";
			while($rec = $db->db_fetch_array($query)){
				echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
			}
		echo "</select>";
		exit;
	break;
	
	
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
