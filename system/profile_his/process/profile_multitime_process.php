<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$proc = $_POST['proc'];
$PT_ID	= $_POST['PT_ID'];
$PER_ID		= $_POST['PER_ID'];
$MULTI_ID	= $_POST['MULTI_ID'];
$TYPE_ID	 = $_POST['TYPE_ID'];
$LEVEL_ID	 = $_POST['LEVEL_ID'];
$LINE_ID	 = $_POST['LINE_ID'];
$LG_ID = $_POST['LG_ID'];
$MANAGE_ID	 = $_POST['MANAGE_ID'];
$ORG_ID_1	 = $_POST['GOV_ORG_ID_1'];
$ORG_ID_2	 = $_POST['GOV_ORG_ID_2'];
$ORG_ID_3	 = $_POST['GOV_ORG_ID_3'];
$ORG_ID_4	 = $_POST['GOV_ORG_ID_4'];
$ORG_ID_5	 = $_POST['GOV_ORG_ID_5'];
$MULTIME_ID	 = $_POST['MULTIME_ID'];
$MULTI_FRAC	 = $_POST['MULTI_FRAC'];
$MULTI_BALANCE	 = $_POST['MULTI_BALANCE'];
$MULTI_NOTE	 = $_POST['MULTI_NOTE'];
$MULTI_YEAR	 = $_POST['MULTI_YEAR'];
$MULTI_MONTH	 = $_POST['MULTI_MONTH'];
$MULTI_DAY	 = $_POST['MULTI_DAY'];
$ACTIVE_STATUS	 = $_POST['ACTIVE_STATUS'];
$MT_ID	 = $_POST['MT_ID'];
$POS_NO	 = $_POST['POS_NO'];

$table="PER_MULTITIME";
switch($proc){
	case "add" : 
		try{		
			$sql="select (case when MAX(MULTI_SEQ)>0 then (MAX(MULTI_SEQ)+1) else '1' end) as NUM_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$NUM_SEQ = $db->get_data_field($sql,"NUM_SEQ");
			unset($fields);
			$fields = array(
			
				"PER_ID"	 => $PER_ID,
				"MULTI_SEQ"	 => $NUM_SEQ,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"MT_ID"	 => $MT_ID,
				"POS_NO"	 => $POS_NO,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"LG_ID" => $LG_ID,
				"MULTIME_ID"	 => $MULTIME_ID,
				"MULTI_FRAC"	 => $MULTI_FRAC,
				"MULTI_BALANCE"	 => $MULTI_BALANCE,
				"MULTI_NOTE"	 => ctext($MULTI_NOTE),
				"POS_YEAR" => $POS_YEAR,
				"MULTI_YEAR"	 => $MULTI_YEAR,
				"MULTI_MONTH"	 => $MULTI_MONTH,
				"MULTI_DAY"	 => $MULTI_DAY,
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => ctext($USER_BY),
				"UPDATE_BY" => ctext($USER_BY),
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_DATE" => $TIMESTAMP,
				"DELETE_FLAG" => '0'	
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
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"MT_ID"	 => $MT_ID,
				"LG_ID" => $LG_ID,
				"POS_NO"	 => $POS_NO,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"MULTIME_ID"	 => $MULTIME_ID,
				"MULTI_FRAC"	 => $MULTI_FRAC,
				"MULTI_BALANCE"	 => $MULTI_BALANCE,
				"MULTI_NOTE"	 => ctext($MULTI_NOTE),
				"POS_YEAR" => $POS_YEAR,
				"MULTI_YEAR"	 => $MULTI_YEAR,
				"MULTI_MONTH"	 => $MULTI_MONTH,
				"MULTI_DAY"	 => $MULTI_DAY,
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);
			
			$db->db_update($table,$fields," MULTI_ID = '".$MULTI_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," MULTI_ID = '".$MULTI_ID."' ");
			
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
	
	case "get_line_group" :
		$sql = "SELECT LG_ID, LG_NAME_TH FROM SETUP_POS_LINE_GROUP  WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TYPE_ID = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LG_NAME_TH  ASC ";
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
		$sql = "SELECT LINE_ID, LINE_NAME_TH FROM SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ".$name." = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
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
	
	case "get_manage" : 
	    $type_id = trim($_POST['type_id']);
		$mt_id = trim($_POST['mt_id']);
		$cond = "";
		if($type_id != ''){
			$cond .= " AND TYPE_ID = ".$type_id;
		}
		if($mt_id != ''){
			$cond .= " AND MT_ID = ".$mt_id;
		}
	
		$sql = "SELECT MANAGE_ID, MANAGE_NAME_TH FROM SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' ".$cond." ORDER BY MANAGE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['MANAGE_ID'];
			$row['VALUE'] = text($rec['MANAGE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
		exit;
	break;
}
$url_back="../profile_multitime.php";
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
