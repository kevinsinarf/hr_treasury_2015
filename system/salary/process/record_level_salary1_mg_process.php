<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$SAL_UP_ID = $_POST['SAL_UP_ID'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$MANAGE_ID = $_POST['MANAGE_ID'];
$PER_ID = $_POST['PER_ID'];
$SCORE = $_POST['SCORE'];
$SCORE_ID = $_POST['SCORE_ID'];
$SALARY_NOW = $_POST['SALARY_NOW'];
$SALARY_SPE_NOW = $_POST['SALARY_SPE_NOW'];
$LEVEL_SALARY_MID = $_POST['LEVEL_SALARY_MID'];
$SCORE_PERCENT = $_POST['SCORE_PERCENT'];
$SALARY_CAL = $_POST['SALARY_CAL'];
$SALARY_UP = $_POST['SALARY_UP'];
$SALARY_SPE_UP = $_POST['SALARY_SPE_UP'];
$SALARY_NEW = $_POST['SHW_NEW'];
$SALARY_SPE_NEW = $_POST['SALARY_SPE_NEW'];
$REMARKS = $_POST['REMARKS'];

$url_back="../record_level_salary1_mg_form.php";
$table = "SAL_UP_SALARY";



switch($proc){	
	case 'save' :
		try{
			
			if(count($PER_ID) > 0){
				foreach($PER_ID as $key => $perId){
					$q_per = $db->query("SELECT POS_ID, TYPE_ID, LEVEL_ID, LINE_ID, MANAGE_ID, MT_ID, ORG_ID_1, ORG_ID_2, ORG_ID_3, ORG_ID_4 FROM PER_PROFILE WHERE PER_ID = '".$perId."'");
					$r_per = $db->db_fetch_array($q_per);
					
					if($SAL_UP_ID[$key] == ''){
						$fields = array(
							"YEAR_BDG" => $S_YEAR_BDG,
							"ROUND" => $S_ROUND,
							"PER_ID" => $perId,
							"POS_ID" => $r_per['POS_ID'],
							"POSTYPE_ID" => '1',
							"TYPE_ID" => $r_per['TYPE_ID'],
							"LINE_ID" => $r_per['LINE_ID'],
							"LEVEL_ID" => $r_per['LEVEL_ID'],
							"MT_ID" => $rec_per['MT_ID'],
							"MANAGE_ID" => $r_per['MANAGE_ID'],
							"ORG_ID_1" => $r_per['ORG_ID_1'],
							"ORG_ID_2" => $r_per['ORG_ID_2'],
							"ORG_ID_3" => $r_per['ORG_ID_3'],
							"ORG_ID_4" => $r_per['ORG_ID_4'],
							"SCORE" => $SCORE[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"SALARY_NOW" => str_replace(",","",$SALARY_NOW[$key]),
							"SALARY_SPE_NOW" => str_replace(",", "", $SALARY_SPE_NOW[$key]),
							"SCORE_PERCENT" => $SCORE_PERCENT[$key],
							"LEVEL_SALARY_MID" => str_replace(",", "", $LEVEL_SALARY_MID[$key]),
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
							"SALARY_UP" => str_replace(",","",$SALARY_UP[$key]),
							"SALARY_SPE_UP" => str_replace(",","",$SALARY_SPE_UP[$key]),
							"SALARY_NEW" => str_replace(",","",$SALARY_NEW[$key]),
							"SALARY_SPE_NEW" => str_replace(",","",$SALARY_SPE_NEW[$key]),
							"REMARKS" => text($REMARKS[$key]),
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
							'MT_ID' => $r_per['MT_ID'],
							"MANAGE_ID" => $r_per['MANAGE_ID'],
							"ORG_ID_1" => $r_per['ORG_ID_1'],
							"ORG_ID_2" => $r_per['ORG_ID_2'],
							"ORG_ID_3" => $r_per['ORG_ID_3'],
							"ORG_ID_4" => $r_per['ORG_ID_4'],
							"SCORE" => $SCORE[$key],
							"SCORE_ID" => $SCORE_ID[$key],
							"SALARY_NOW" => str_replace(",","",$SALARY_NOW[$key]),
							"SALARY_SPE_NOW" => str_replace(",", "", $SALARY_SPE_NOW[$key]),
							"SCORE_PERCENT" => $SCORE_PERCENT[$key],
							"LEVEL_SALARY_MID" => str_replace(",", "", $LEVEL_SALARY_MID[$key]),
							"SALARY_CAL"=> str_replace(",", "", $SALARY_CAL[$key]),
							"SALARY_UP" => str_replace(",","",$SALARY_UP[$key]),
							"SALARY_SPE_UP" => str_replace(",","",$SALARY_SPE_UP[$key]),
							"SALARY_NEW" => str_replace(",","",$SALARY_NEW[$key]),
							"SALARY_SPE_NEW" => str_replace(",","",$SALARY_SPE_NEW[$key]),
							"REMARKS" => text($REMARKS[$key]),
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
	
	case 'getPercent' :
		$MIN = "";
		$MAX = "";
		$query_per = $db->query( "SELECT PER_ID , ORG_ID_3, ORG_ID_4,LEVEL_ID,TYPE_ID,POSTYPE_ID  FROM PER_PROFILE WHERE  PER_ID  = '".$PER_ID."' ");
		$rec_per = $db->db_fetch_array($query_per);
		$query_level_salary = $db->query("SELECT LEVEL_SALARY_MIN, LEVEL_SALARY_MAX , SALARYTITLE_ID FROM SETUP_POS_LEVEL_SALARY WHERE  POSTYPE_ID = '".$rec_per['POSTYPE_ID']."' AND LEVEL_ID = '".$rec_per['LEVEL_ID']."' AND TYPE_ID = '".$rec_per['TYPE_ID']."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ");
		while($rec_level_salary = $db->db_fetch_array($query_level_salary)){
			//$rec_level_salary
			if($rec_level_salary['SALARYTITLE_ID']==1){
				$MAX =  $rec_level_salary['LEVEL_SALARY_MAX'];
			}else if($rec_level_salary['SALARYTITLE_ID']==2){
				$MIN =  $rec_level_salary['LEVEL_SALARY_MIN'];
			}
		}
		
		$query = $db->query("SELECT DISTINCT(SCORE_TYPE) AS SCORE_TYPE,SCORE_S,SCORE_E, PERCENT_SAL,PERCENT_SAL_E FROM SAL_SCORE WHERE PT_ID = '1' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec_per['ORG_ID_3']."' AND ORG_ID_4 = '".$rec_per['ORG_ID_4']."' AND '".$score."' BETWEEN SCORE_S AND SCORE_E");
		$rec = $db->db_fetch_array($query);
		if($rec['SCORE_TYPE']==1){
			$result = (($score-$rec['SCORE_S'])* (($rec['PERCENT_SAL_E']-$rec['PERCENT_SAL']) / ($rec['SCORE_E']-$rec['SCORE_S'])))+$rec['PERCENT_SAL'];
		}else if($rec['SCORE_TYPE']==2){
			$result = $rec['PERCENT_SAL'];
		}else if($rec['SCORE_TYPE']==3){
			$total = ($rec['SCORE_E'] - $rec['SCORE_S'])/2;
		   	$total1 = $rec['SCORE_S']+$total;
			//$query_1 = $db->query("SELECT DISTINCT(SCORE_TYPE) AS SCORE_TYPE,SCORE_S,SCORE_E, PERCENT_SAL,PERCENT_SAL_E FROM SAL_SCORE WHERE PT_ID = '1' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$ORG_ID."' AND ORG_ID_4 = '".$ORG_ID_4."' AND '".$score."' BETWEEN '".$total1."' AND SCORE_E");
			//$row = $db->db_num_rows($query_1);
			if($score<$total1){
				$result = $rec['PERCENT_SAL'];
			}else if($score>=$total1){
				$result = $rec['PERCENT_SAL_E'];
			}
		}
		
		$row['SCORE_ID'] = $rec['SCORE_ID'];
		$row['PERCENT'] = number_format($result,2);
		$row['SALARY_MAX'] = $MAX;
		$row['SALARY_MIN']  = $MIN;
		echo json_encode($row);
		
		//echo $rec['SCORE_ID'].'@'.number_format($result,2);
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
	<input type="hidden" id="MANAGE_ID" name="MANAGE_ID" value="<?php echo $MANAGE_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
