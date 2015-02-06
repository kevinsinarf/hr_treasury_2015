<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$SAL_UP_ID = $_POST['SAL_UP_ID'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$PER_ID = $_POST['PER_ID'];
$SCORE = $_POST['SCORE'];
$SCORE_ID = $_POST['SCORE_ID'];
$SALARY_NOW = $_POST['SALARY_NOW'];
$SALARY_SPE_NOW = $_POST['SALARY_SPE_NOW'];
$LEVEL_SALARY_MID = $_POST['LEVEL_SALARY_MID'];
$LEVEL_SALARY_MAX = $_POST['LEVEL_SALARY_MAX'];
$SCORE_PERCENT = $_POST['SCORE_PERCENT'];
$SALARY_CAL = $_POST['SALARY_CAL'];
$SALARY_UP = $_POST['SALARY_UP'];
$SALARY_SPE_UP = $_POST['SALARY_SPE_UP'];
$SALARY_NEW = $_POST['SHW_NEW'];
$SALARY_SPE_NEW = $_POST['SALARY_SPE_NEW'];
$REMARKS = $_POST['REMARKS'];

$url_back="../record_up_salary_mg_form.php";
$table = "SAL_UP_SALARY";

switch($proc){	
	case 'save' :
		try{
			
			if(count($PER_ID) > 0){
				foreach($PER_ID as $key => $perId){
						$fields = array(
							"SCORE" => $SCORE[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"SALARY_SPE_NOW" => str_replace(",", "", $SALARY_SPE_NOW[$key]),
							"SCORE_PERCENT" => $SCORE_PERCENT[$key],
							"LEVEL_SALARY_MID" => str_replace(",", "", $LEVEL_SALARY_MID[$key]),
							"LEVEL_SALARY_MAX" => str_replace(",", "", $LEVEL_SALARY_MAX[$key]),
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
							"SALARY_UP" => str_replace(",","",$SALARY_UP[$key]),
							"SALARY_SPE_UP" => str_replace(",","",$SALARY_SPE_UP[$key]),
							"SALARY_NEW" => str_replace(",","",$SALARY_NEW[$key]),
							"SALARY_SPE_NEW" => str_replace(",","",$SALARY_SPE_NEW[$key]),
							"REMARKS" => str_replace("\n", "<br>",ctext($REMARKS[$key])),
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
		   
		 
		   $db->db_update($table,array('CONFIRM_TYPE' => 3)," YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND SAL_UP_TYPE = 2 AND LEVEL_ID = '".$LEVEL_ID."' "); 
		   $text= text('อนุมัติเกณฑ์การประเมิน เรียบร้อยแล้ว');
		  
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
		case 'getPercent' :
		$MIN = "";
		$MAX = "";
		$TYPE_ID = $_POST['TYPE_ID'];
		$LEVEL_ID = $_POST['LEVEL_ID'];
		$LINE_ID = $_POST['LINE_ID'];
		
		$sql_max = "SELECT MAX(A.LEVEL_SALARY_MAX) AS LEVEL_SALARY_MAX 
		FROM SETUP_POS_LINE_SALARY A 
		WHERE  A.POSTYPE_ID = '1' AND A.LEVEL_ID = '".$LEVEL_ID."' 
		AND A.TYPE_ID = '".$TYPE_ID."' AND A.LINE_ID = '".$LINE_ID."'  AND A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0 ";
		
		$sql_min = "SELECT MIN(A.LEVEL_SALARY_MIN) AS LEVEL_SALARY_MIN 
		FROM SETUP_POS_LINE_SALARY A 
		WHERE  A.POSTYPE_ID = '1' AND A.LEVEL_ID = '".$LEVEL_ID."' 
		AND A.TYPE_ID = '".$TYPE_ID."' AND A.LINE_ID = '".$LINE_ID."'  AND A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0 ";
		$query_level_max = $db->query($sql_max);
		$rec_max = $db->db_fetch_array($query_level_max);
		
		$query_level_min = $db->query($sql_min);
		$rec_levle_min = $db->db_fetch_array($query_level_min);
		
		$MAX =  $rec_max['LEVEL_SALARY_MAX'];
		$MIN =  $rec_levle_min['LEVEL_SALARY_MIN'];
		
		$query = $db->query("SELECT DISTINCT(SCORE_TYPE) AS SCORE_TYPE, SCORE_ID, SCORE_S,SCORE_E, PERCENT_SAL,PERCENT_SAL_E FROM SAL_SCORE WHERE POSTYPE_ID = '1' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND SCORE_STATUS = 2  AND '".$score."' BETWEEN SCORE_S AND SCORE_E");
		
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
		
		//echo $rec['SCORE_ID'].'@'.number_format($result,2);
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
	

	case "get_level_salary":
		$sql_co = "SELECT A.CO_ID, A.TYPE_ID, B.LEVEL_SEQ AS LEVEL_SEQ_MIN, C.LEVEL_SEQ AS LEVEL_SEQ_MAX FROM SETUP_POS_CO_LEVEL A
               JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID_MIN = B.LEVEL_ID AND A.TYPE_ID = B.TYPE_ID
			   JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID_MAX = C.LEVEL_ID AND A.TYPE_ID = C.TYPE_ID 
               WHERE A.CO_ID = '".$co_id."' ";
			  $query_co = $db->query($sql_co);
			  $rec_co = $db->db_fetch_array($query_co);
			  $query_co_level = $db->query("SELECT LEVEL_ID, LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_SEQ BETWEEN '".$rec_co['LEVEL_SEQ_MIN']."' AND '".$rec_co['LEVEL_SEQ_MAX']."' AND POSTYPE_ID = 1 ORDER BY LEVEL_SEQ ASC   ");
		
			while($rec_level = $db->db_fetch_array($query_co_level)){
				$sql_salary = "SELECT SALARYTITLE_ID, LEVEL_SALARY_MIN, LEVEL_SALARY_MAX FROM SETUP_POS_LEVEL_SALARY WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_ID = '".$rec_level['LEVEL_ID']."' AND POSTYPE_ID = '".$postype_id."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ORDER BY SALARYTITLE_ID DESC ";
				$query_salary = $db->query($sql_salary);
				
			$html .= " <div class='col-xs-12 col-md-1'>
					   <div class='row'>
						<div class='col-xs-12 col-md-2 ' style='white-space:nowrap;'>".text($rec_level['LEVEL_NAME_TH'])."</div>
						</div> ";
				 
			 while($rec_salary = $db->db_fetch_array($query_salary)){
				 
				 $money = 0;
				 if($rec_salary['SALARYTITLE_ID'] == 2){
					 $money = number_format($rec_salary['LEVEL_SALARY_MIN'],2);
				 }else if($rec_salary['SALARYTITLE_ID'] == 1){
					  $money = number_format($rec_salary['LEVEL_SALARY_MAX'],2);
				 }
				 
			 $html .= "<div class='row'>
						 <div class='col-xs-12 col-md-2 ' style='white-space:nowrap;'>".$money."</div>
						 </div>";
						 
			 }
		 $html .= " </div> ";	
		}
	   echo $html;
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
	<input type="hidden" id="LEVEL_ID" name="LEVEL_ID" value="<?php echo $LEVEL_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
