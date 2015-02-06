<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$POSTYPE_ID = $_POST['POSTYPE_ID'];
$PER_ID = $_POST['PER_ID'];
$REWHIS_ID = $_POST['REWHIS_ID'];
$POS_YEAR = $_POST['POS_YEAR'];
$REWARD_ORG_TYPE = $_POST['REWARD_ORG_TYPE'];
$REWARD_ORG_NAME = ctext($_POST['REWARD_ORG_NAME']);
$REWHIS_ORG_ID_1 = $_POST['REWHIS_ORG_ID_1'];
$REWHIS_ORG_ID_2 = $_POST['REWHIS_ORG_ID_2'];
$REWHIS_ORG_ID_3 = $_POST['REWHIS_ORG_ID_3'];
$REWARD_TITLE = ctext($_POST['REWARD_TITLE']);
$REWARD_ID = $_POST['REWARD_ID'];
$REWARD_DATE = conv_date_db($_POST['REWARD_DATE']);
$POS_NO = $_POST['POS_NO'];
$ORG_ID_1 = $_POST['ORG_ID_1'];
$ORG_ID_2 = $_POST['ORG_ID_2'];
$ORG_ID_3 = $_POST['ORG_ID_3'];
$ORG_ID_4 = $_POST['ORG_ID_4'];
$ORG_ID_5 = $_POST['ORG_ID_5'];
$TYPE_ID = $_POST['TYPE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$LG_ID = $_POST['LG_ID'];
$LINE_ID = $_POST['LINE_ID'];
$MT_ID = $_POST['MT_ID'];
$MANAGE_ID =  $_POST['MANAGE_ID'];

$table="PER_REWARDHIS";
switch($proc){
	case "add" : 
		try{	
			$fields = array(
				'PER_ID' => $PER_ID,
				'REWHIS_ORG_TYPE' => $REWARD_ORG_TYPE,
				'REWHIS_ORG_ID_1' => $REWHIS_ORG_ID_1,
				'REWHIS_ORG_ID_2' => $REWHIS_ORG_ID_2,
				'REWHIS_ORG_ID_3' => $REWHIS_ORG_ID_3,
				'REWHIS_ORG_NAME' => $REWARD_ORG_NAME,
				'REWHIS_TITLE' => $REWARD_TITLE,
				'REWARD_ID' => $REWARD_ID,
				'REWARD_DATE' => $REWARD_DATE,
				'POSTYPE_ID' => $POSTYPE_ID,
				'POS_NO' => $POS_NO,
				'POS_YEAR' => $POS_YEAR,
				'TYPE_ID' => $TYPE_ID,
				'LEVEL_ID' => $LEVEL_ID,
				'LG_ID' => $LG_ID,
				'LINE_ID'  => $LINE_ID,
				'MT_ID' => $MT_ID,
				'MANAGE_ID' => $MANAGE_ID,				
				'ORG_ID_1' => $ORG_ID_1,
				'ORG_ID_2' => $ORG_ID_2,
				'ORG_ID_3' => $ORG_ID_3,
				'ORG_ID_4' => $ORG_ID_4,
				'ORG_ID_5' => $ORG_ID_5,
				"ACTIVE_STATUS" =>1,
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
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
			$fields = array(
				'REWHIS_ORG_TYPE' => $REWARD_ORG_TYPE,
				'REWHIS_ORG_ID_1' => $REWHIS_ORG_ID_1,
				'REWHIS_ORG_ID_2' => $REWHIS_ORG_ID_2,
				'REWHIS_ORG_ID_3' => $REWHIS_ORG_ID_3,
				'REWHIS_ORG_NAME' => $REWARD_ORG_NAME,
				'REWHIS_TITLE' => $REWARD_TITLE,
				'REWARD_ID' => $REWARD_ID,
				'REWARD_DATE' => $REWARD_DATE,
				'POS_NO' => $POS_NO,
				'POS_YEAR' => $POS_YEAR,
				'TYPE_ID' => $TYPE_ID,
				'LEVEL_ID' => $LEVEL_ID,
				'LG_ID' => $LG_ID,
				'LINE_ID'  => $LINE_ID,
				'MT_ID' => $MT_ID,
				'MANAGE_ID' => $MANAGE_ID,				
				'ORG_ID_1' => $ORG_ID_1,
				'ORG_ID_2' => $ORG_ID_2,
				'ORG_ID_3' => $ORG_ID_3,
				'ORG_ID_4' => $ORG_ID_4,
				'ORG_ID_5' => $ORG_ID_5,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			
			$db->db_update($table,$fields," REWHIS_ID = '".$REWHIS_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," REH_ID = '".$REH_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_org":
	$ORG_PARENT_ID = $_POST['ORG_PARENT_ID'];
	$obj = array();
	$sql = "SELECT * FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$ORG_PARENT_ID."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ORDER BY ORG_SEQ ASC ";
	$query =$db->query($sql);
	while($rec = $db->db_fetch_array($query)){
		$row['ID'] = $rec['ORG_ID'];
		$row['VALUE'] = text($rec['ORG_NAME_TH']);
		array_push($obj, $row);
	}
	echo json_encode($obj);
	exit();
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
$url_back="../profile_rewardhis.php";
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
