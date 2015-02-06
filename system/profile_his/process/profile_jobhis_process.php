<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
$JOB_ID=$_POST['JOB_ID'];
$JOH_SEQ=$_POST['JOH_SEQ'];
$JOH_JOB_TYPE= $_POST['JOH_JOB_TYPE'];
$CV_ID = $_POST['CV_ID'];
$JOH_SDATE = conv_date_db($_POST['JOH_SDATE']);
$JOH_EDATE = conv_date_db($_POST['JOH_EDATE']);
//---------------------------------------------------------------------------------------
$GOV_ORG_ID_1 = $_POST['GOV_ORG_ID_1'];
$GOV_ORG_ID_2 = $_POST['GOV_ORG_ID_2'];
$GOV_ORG_ID_3 = $_POST['GOV_ORG_ID_3'];
$GOV_ORG_ID_4 = $_POST['GOV_ORG_ID_4'];
$GOV_ORG_ID_5 = $_POST['GOV_ORG_ID_5'];
$GOV_TYPE_ID = $_POST['GOV_TYPE_ID'];
$GOV_LG_ID = $_POST['GOV_LG_ID'];
$GOV_LINE_ID = $_POST['GOV_LINE_ID'];
$GOV_LEVEL_ID = $_POST['GOV_LEVEL_ID'];
$GOV_CJOH_SDATE = $_POST['GOV_CJOH_SDATE'];
$GOV_CJOH_EDATE = $_POST['GOV_CJOH_EDATE'];
$GOV_CJOH_SALARY = $_POST['GOV_CJOH_SALARY'];

$GOV_EMP_ORG_ID_1 = $_POST['GOV_EMP_ORG_ID_1'];
$GOV_EMP_ORG_ID_2 = $_POST['GOV_EMP_ORG_ID_2'];
$GOV_EMP_ORG_ID_3 = $_POST['GOV_EMP_ORG_ID_3'];
$GOV_EMP_TYPE_ID = $_POST['GOV_EMP_TYPE_ID'];
$GOV_EMP_LEVEL_ID = $_POST['GOV_EMP_LEVEL_ID'];
$GOV_EMP_LINE_ID = $_POST['GOV_EMP_LINE_ID'];
$GOV_EMP_CJOH_SDATE = $_POST['GOV_EMP_CJOH_SDATE'];
$GOV_EMP_CJOH_EDATE = $_POST['GOV_EMP_CJOH_EDATE'];
$GOV_EMP_CJOH_SALARY = $_POST['GOV_EMP_CJOH_SALARY'];

$EMP_ORG_ID_1 = $_POST['EMP_ORG_ID_1'];
$EMP_ORG_ID_2 = $_POST['EMP_ORG_ID_2'];
$EMP_ORG_ID_3 = $_POST['EMP_ORG_ID_3'];
$EMP_ORG_ID_4 = $_POST['EMP_ORG_ID_4'];
$EMP_ORG_ID_5 = $_POST['EMP_ORG_ID_5'];
$EMP_TYPE_ID = $_POST['EMP_TYPE_ID'];
$EMP_LINE_ID = $_POST['EMP_LINE_ID'];
$EMP_CJOH_SALARY = $_POST['EMP_CJOH_SALARY'];
$EMP_CJOH_SDATE = $_POST['EMP_CJOH_SDATE'];
$EMP_CJOH_EDATE = $_POST['EMP_CJOH_EDATE'];

$JOB_ID = $_POST['JOB_ID'];
$CJOH_POS_NAME = $_POST['CJOH_POS_NAME'];
$CJOH_ORG_NAME = $_POST['CJOH_ORG_NAME'];
$OTH_CJOH_SDATE = $_POST['OTH_CJOH_SDATE'];
$OTH_CJOH_EDATE = $_POST['OTH_CJOH_EDATE'];
$OTH_CJOH_SALARY = $_POST['OTH_CJOH_SALARY'];
$JOB_EJOB_NAME = $_POST['JOB_EJOB_NAME'];


if($JOH_JOB_TYPE == 1){
	$JOB_ID = '';
	$CV_ID = $CV_ID;
	$ORG_ID_1 = $GOV_ORG_ID_1;
	$ORG_ID_2 = $GOV_ORG_ID_2;
	$ORG_ID_3 = $GOV_ORG_ID_3;
	$ORG_ID_4 = $GOV_ORG_ID_4;
	$ORG_ID_5 = $GOV_ORG_ID_5;
	$TYPE_ID = $GOV_TYPE_ID;
	$LEVEL_ID = $GOV_LEVEL_ID;
	$LG_ID = $GOV_LG_ID;
	$LINE_ID = $GOV_LINE_ID;
	$JOB_EJOB_NAME = '';
	$JOH_SDATE = $GOV_CJOH_SDATE;
	$JOH_EDATE = $GOV_CJOH_EDATE;
	$JOH_ORG_NAME = '';
	$JOH_POS_NAME = '';
	$JOH_SALARY = $GOV_CJOH_SALARY;
}else if($JOH_JOB_TYPE == 2){
	$JOB_ID = '';
	$CV_ID = '';
	$ORG_ID_1 = $GOV_EMP_ORG_ID_1;
	$ORG_ID_2 = $GOV_EMP_ORG_ID_2;
	$ORG_ID_3 = $GOV_EMP_ORG_ID_3;
	$TYPE_ID = $GOV_EMP_TYPE_ID;
	$LEVEL_ID = $GOV_EMP_LEVEL_ID;
	$LG_ID = '';
	$LINE_ID = $GOV_EMP_LINE_ID;
	$JOB_EJOB_NAME = '';
	$JOH_SDATE = $GOV_EMP_CJOH_SDATE;
	$JOH_EDATE = $GOV_EMP_CJOH_EDATE;
	$JOH_ORG_NAME = '';
	$JOH_POS_NAME = '';
	$JOH_SALARY = $GOV_EMP_CJOH_SALARY;
}else if($JOH_JOB_TYPE == 3){
	$JOB_ID = '';
	$CV_ID = '';
	$ORG_ID_1 = $EMP_ORG_ID_1;
	$ORG_ID_2 = $EMP_ORG_ID_2;
	$ORG_ID_3 = $EMP_ORG_ID_3;
	$ORG_ID_4 = $EMP_ORG_ID_4;
	$ORG_ID_5 = $EMP_ORG_ID_5;
	$TYPE_ID = $EMP_TYPE_ID;
	$LEVEL_ID = $EMP_LEVEL_ID;
	$LG_ID = '';
	$LINE_ID = $EMP_LINE_ID;
	$JOB_EJOB_NAME = '';
	$JOH_SDATE = $EMP_CJOH_SDATE;
	$JOH_EDATE = $EMP_CJOH_EDATE;
	$JOH_ORG_NAME = '';
	$JOH_POS_NAME = '';
	$JOH_SALARY = $EMP_CJOH_SALARY;
}
else if($JOH_JOB_TYPE == 4){
	$JOB_ID = '';
	$CV_ID = '';
	$ORG_ID_1 = $EMP_ORG_ID_1;
	$ORG_ID_2 = $EMP_ORG_ID_2;
	$ORG_ID_3 = $EMP_ORG_ID_3;
	$ORG_ID_4 = $EMP_ORG_ID_4;
	$ORG_ID_5 = $EMP_ORG_ID_5;
	$TYPE_ID = $EMP_TYPE_ID;
	$LEVEL_ID = $EMP_LEVEL_ID;
	$LG_ID = '';
	$LINE_ID = $EMP_LINE_ID;
	$JOB_EJOB_NAME = '';
	$JOH_SDATE = $EMP_CJOH_SDATE;
	$JOH_EDATE = $EMP_CJOH_EDATE;
	$JOH_ORG_NAME = '';
	$JOH_POS_NAME = '';
	$JOH_SALARY = $EMP_CJOH_SALARY;
}
else if($JOH_JOB_TYPE == 5){
	$JOB_ID = '';
	$CV_ID = '';
	$ORG_ID_1 = $EMP_ORG_ID_1;
	$ORG_ID_2 = $EMP_ORG_ID_2;
	$ORG_ID_3 = $EMP_ORG_ID_3;
	$ORG_ID_4 = $EMP_ORG_ID_4;
	$ORG_ID_5 = $EMP_ORG_ID_5;
	$TYPE_ID = $EMP_TYPE_ID;
	$LEVEL_ID = $EMP_LEVEL_ID;
	$LG_ID = '';
	$LINE_ID = $EMP_LINE_ID;
	$JOB_EJOB_NAME = '';
	$JOH_SDATE = $EMP_CJOH_SDATE;
	$JOH_EDATE = $EMP_CJOH_EDATE;
	$JOH_ORG_NAME = '';
	$JOH_POS_NAME = '';
	$JOH_SALARY = $EMP_CJOH_SALARY;
}else if($JOH_JOB_TYPE == 6){
		if($JOH_JOB_TYPE == 6){
		$JOH_OTHER_JOB = $CJOH_OTHER_JOB;
	}else{
		$JOH_OTHER_JOB = '';	
	}
	$JOB_ID = $JOB_ID;
	$CV_ID = '';
	$ORG_ID_1 = '';
	$ORG_ID_2 = '';
	$ORG_ID_3 = '';
	$ORG_ID_4 = '';
	$ORG_ID_5 = '';
	$TYPE_ID = '';
	$LEVEL_ID = '';
	$LG_ID = '';
	$LINE_ID = '';
	if($JOB_ID == '999999'){
		$JOB_EJOB_NAME = $CJOB_EJOB_NAME;
	}else{
		$JOB_EJOB_NAME = '';
	}
	$JOH_SDATE = $OTH_CJOH_SDATE;
	$JOH_EDATE = $OTH_CJOH_EDATE;
	$JOH_ORG_NAME = $CJOH_ORG_NAME;
	$JOH_POS_NAME = $CJOH_POS_NAME;
	$JOH_SALARY = $OTH_CJOH_SALARY;
}
else if($JOH_JOB_TYPE == 8){
		if($JOH_JOB_TYPE == 8){
		$JOH_OTHER_JOB = $CJOH_OTHER_JOB;
	}else{
		$JOH_OTHER_JOB = '';	
	}
	$JOB_ID = $JOB_ID;
	$CV_ID = '';
	$ORG_ID_1 = '';
	$ORG_ID_2 = '';
	$ORG_ID_3 = '';
	$ORG_ID_4 = '';
	$ORG_ID_5 = '';
	$TYPE_ID = '';
	$LEVEL_ID = '';
	$LG_ID = '';
	$LINE_ID = '';
	if($JOB_ID == '999999'){
		$JOB_EJOB_NAME = $CJOB_EJOB_NAME;
	}else{
		$JOB_EJOB_NAME = '';
	}
	$JOH_SDATE = $OTH_CJOH_SDATE;
	$JOH_EDATE = $OTH_CJOH_EDATE;
	$JOH_ORG_NAME = $CJOH_ORG_NAME;
	$JOH_POS_NAME = $CJOH_POS_NAME;
	$JOH_SALARY = $OTH_CJOH_SALARY;
}else if($JOH_JOB_TYPE == 6){
		if($JOH_JOB_TYPE == 6){
		$JOH_OTHER_JOB = $CJOH_OTHER_JOB;
	}else{
		$JOH_OTHER_JOB = '';	
	}
	$JOB_ID = $JOB_ID;
	$CV_ID = '';
	$ORG_ID_1 = '';
	$ORG_ID_2 = '';
	$ORG_ID_3 = '';
	$ORG_ID_4 = '';
	$ORG_ID_5 = '';
	$TYPE_ID = '';
	$LEVEL_ID = '';
	$LG_ID = '';
	$LINE_ID = '';
	if($JOB_ID == '999999'){
		$JOB_EJOB_NAME = $CJOB_EJOB_NAME;
	}else{
		$JOB_EJOB_NAME = '';
	}
	$JOH_SDATE = $OTH_CJOH_SDATE;
	$JOH_EDATE = $OTH_CJOH_EDATE;
	$JOH_ORG_NAME = $CJOH_ORG_NAME;
	$JOH_POS_NAME = $CJOH_POS_NAME;
	$JOH_SALARY = $OTH_CJOH_SALARY;
}
else if($JOH_JOB_TYPE == 10){
	$JOH_OTHER_JOB = $CJOH_OTHER_JOB;
	$JOB_EJOB_NAME = $_POST['JOB_EJOB_NAME'];
		$JOB_ID = $JOB_ID;
	$CV_ID = '';
	$ORG_ID_1 = '';
	$ORG_ID_2 = '';
	$ORG_ID_3 = '';
	$ORG_ID_4 = '';
	$ORG_ID_5 = '';
	$TYPE_ID = '';
	$LEVEL_ID = '';
	$LG_ID = '';
	$LINE_ID = '';
	$JOH_SDATE = $OTH_CJOH_SDATE;
	$JOH_EDATE = $OTH_CJOH_EDATE;
	$JOH_ORG_NAME = $CJOH_ORG_NAME;
	$JOH_POS_NAME = $CJOH_POS_NAME;
	$JOH_SALARY = $OTH_CJOH_SALARY;
}
else{
	if($JOH_JOB_TYPE == 10){
		$JOH_OTHER_JOB = $CJOH_OTHER_JOB;
		$JOB_EJOB_NAME = $_POST['JOB_EJOB_NAME'];;
	}else{
		$JOH_OTHER_JOB = '';	
	}
	$JOB_ID = $JOB_ID;
	$CV_ID = '';
	$ORG_ID_1 = '';
	$ORG_ID_2 = '';
	$ORG_ID_3 = '';
	$ORG_ID_4 = '';
	$ORG_ID_5 = '';
	$TYPE_ID = '';
	$LEVEL_ID = '';
	$LG_ID = '';
	$LINE_ID = '';
	if($JOB_ID == '999999'){
		$JOB_EJOB_NAME = $CJOB_EJOB_NAME;
	}else{
		$JOB_EJOB_NAME = '';
	}
	$JOH_SDATE = $OTH_CJOH_SDATE;
	$JOH_EDATE = $OTH_CJOH_EDATE;
	$JOH_ORG_NAME = $CJOH_ORG_NAME;
	$JOH_POS_NAME = $CJOH_POS_NAME;
	$JOH_SALARY = $OTH_CJOH_SALARY;
}
//---------------------------------------------------------------------------------------
$table="PER_JOBHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$sql="select (case when MAX(JOH_SEQ)>0 then (MAX(JOH_SEQ)+1) else '1' end) as JOH_SEQ  from PER_JOBHIS where PER_ID='".$PER_ID."' ";
					$query = $db->query($sql);
					$data = $db->db_fetch_array($query);
					$fields = array(
					"PER_ID" => $PER_ID,
					"JOH_JOB_TYPE"=>$JOH_JOB_TYPE,
					"CV_ID" => $CV_ID,
					"JOH_SEQ" =>$JOH_SEQ,
					"CV_ID" => $CV_ID,
					"ORG_ID_1" => $ORG_ID_1,
					"ORG_ID_2" => $ORG_ID_2,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,
					"ORG_ID_5" => $ORG_ID_5,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LG_ID" => $LG_ID,
					"LINE_ID" => $LINE_ID,
					"JOH_SALARY" => str_replace(",","",$JOH_SALARY),
					"JOB_EJOB_NAME" => ctext($JOB_EJOB_NAME),
					"JOH_SDATE" => conv_date_db($JOH_SDATE),
					"JOH_EDATE" => conv_date_db($JOH_EDATE),
					"JOH_ORG_NAME" => ctext($JOH_ORG_NAME),
					"JOH_POS_NAME" => ctext($JOH_POS_NAME),					
					"JOH_MISSION" => ctext($JOH_MISSION),
					"JOB_ID"=>ctext($JOB_ID),
					"JOH_ORG_NAME"=>ctext($JOH_ORG_NAME),
					"JOH_MISSION"=>ctext($JOH_MISSION),
					"REQUEST_RESULT" => '1',
					"REQUEST_STATUS" => '1',
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
					$db->db_insert($table,$fields);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			unset($fields);
			$fields = array(
					"PER_ID" => $PER_ID,
					"JOH_JOB_TYPE"=>$JOH_JOB_TYPE,
					"CV_ID" => $CV_ID,
					"JOH_SEQ" =>$JOH_SEQ,
					"CV_ID" => $CV_ID,
					"ORG_ID_1" => $ORG_ID_1,
					"ORG_ID_2" => $ORG_ID_2,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,
					"ORG_ID_5" => $ORG_ID_5,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LG_ID" => $LG_ID,
					"LINE_ID" => $LINE_ID,
					"JOH_SALARY" => str_replace(",","",$JOH_SALARY),
					"JOB_EJOB_NAME" => ctext($JOB_EJOB_NAME),
					"JOH_SDATE" => conv_date_db($JOH_SDATE),
					"JOH_EDATE" => conv_date_db($JOH_EDATE),
					"JOH_ORG_NAME" => ctext($JOH_ORG_NAME),
					"JOH_POS_NAME" => ctext($JOH_POS_NAME),					
					"JOH_MISSION" => ctext($JOH_MISSION),
					"JOB_ID"=>ctext($JOB_ID),
					"JOH_ORG_NAME"=>ctext($JOH_ORG_NAME),
					"JOH_MISSION"=>ctext($JOH_MISSION),
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
				    $db->db_update($table,$fields," JOH_ID = '".$JOH_ID."' "); 
					
					$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," JOH_ID = '".$JOH_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "get_org" : 
		$sql = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_id."' ORDER BY ORG_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['ORG_ID'];
			$row['VALUE'] = text($rec['ORG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
		exit;
	break;
		
	case "get_line_group" : 
		$sql = "SELECT LG_ID, LG_NAME_TH FROM SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." ORDER BY LG_NAME_TH ASC ";
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

	case "get_level" :
		$sql = "SELECT LEVEL_ID, LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TYPE_ID = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 	exit;
	break;

	case "get_line" : 
		$sql = "SELECT LINE_ID, LINE_NAME_TH FROM SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LG_ID = '".$lg_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
		exit;
	break;
	
	case 'get_line_gov_emp' :
		$sql = "SELECT LINE_ID, LINE_NAME_TH FROM SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LEVEL_ID = '".$level_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
		exit;
	break;

	case 'get_line_emp' :
		$sql = "SELECT LINE_ID, LINE_NAME_TH FROM SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TYPE_ID = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
		exit;
	break;
}
$url_back="../profile_jobhis_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
