<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$SPECHIS_ID = $_POST['SPECHIS_ID'];

$CT_ID = $_POST['CT_ID'];
$PER_ID		= $_POST['PER_ID'];
$TYPE_ID	 = $_POST['TYPE_ID'];
$LEVEL_ID	 = $_POST['LEVEL_ID'];
$LINE_ID	 = $_POST['LINE_ID'];
$POS_NO = $_POST['POS_NO'];
$LG_ID = $_POST['LG_ID'];
$MT_ID = $_POST['MT_ID'];
$MANAGE_ID	 = $_POST['MANAGE_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];
$ORG_ID_1	 = $_POST['ORG_ID_1'];
$ORG_ID_2	 = $_POST['ORG_ID_2'];
$ORG_ID_3	 = $_POST['ORG_ID_3'];
$ORG_ID_4	 = $_POST['ORG_ID_4'];
$ORG_ID_5	 = $_POST['ORG_ID_5'];
$COM_NO = $_POST['COM_NO'];
$COM_DATE = conv_date_db($_POST['COM_DATE']);
$COM_SDATE = conv_date_db($_POST['COM_SDATE']);
$SPECHIS_PROJECT = $_POST['SPECHIS_PROJECT'];
$SPECHIS_TYPE = $_POST['SPECHIS_TYPE'];
$SPECIAL_ID = $_POST['SPECIAL_ID'];
$SPECHIS_ETYPE = $_POST['SPECHIS_ETYPE'];
$SPECHIS_EDATE  = conv_date_db($_POST['SPECHIS_EDATE']);
$SPECIAL_ID = $_POST['SPECIAL_ID'];

	/*	echo $CT_ID." ";
	    echo $MOVEMENT_ID;
		exit();*/

$table="PER_SPECIALHIS";
switch($proc){
	case "add" : 
		try{		
	
			/*$sql="select (case when MAX(SEH_SEQ)>0 then (MAX(SEH_SEQ)+1) else '1' end) as NUM_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$NUM_SEQ = $db->get_data_field($sql,"NUM_SEQ");*/
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"CT_ID" => $CT_ID,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"LG_ID"  => $LG_ID,
				"MT_ID" => $MT_ID,
				"POS_NO" => $POS_NO,
				"MANAGE_ID"	 => $MANAGE_ID,
				"MOVEMENT_ID" => $MOVEMENT_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"COM_NO" => $COM_NO,
				"COM_DATE" => $COM_DATE,
				"COM_SDATE" => $COM_SDATE,
				"SPECHIS_PROJECT" => $SPECHIS_PROJECT,
				"SPECHIS_TYPE" => $SPECHIS_TYPE,
				"SPECIAL_ID" => $SPECIAL_ID,
				"SPECHIS_ETYPE" => $SPECHIS_ETYPE,
				"SPECHIS_EDATE"  => $SPECHIS_EDATE,
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
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"CT_ID" => $CT_ID,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"LG_ID"  => $LG_ID,
				"MT_ID" => $MT_ID,
				"POS_NO" => $POS_NO,
				"COM_NO" => $COM_NO,
				"COM_DATE" => $COM_DATE,
				"COM_SDATE" => $COM_SDATE,
				"MOVEMENT_ID" => $MOVEMENT_ID,
				"SPECHIS_PROJECT" => $SPECHIS_PROJECT,
				"SPECHIS_TYPE" => $SPECHIS_TYPE,
				"SPECIAL_ID" => $SPECIAL_ID,
				"SPECHIS_ETYPE" => $SPECHIS_ETYPE,
				"SPECHIS_EDATE"  => $SPECHIS_EDATE,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," SPECHIS_ID = '".$SPECHIS_ID."'"); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," SPECHIS_ID = '".$SPECHIS_ID."' ");
			
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
	case 'getPosition' :
		try{
			$arr_special = GetSqlSelectArray("SPECIAL_ID", "SPECIAL_NAME_TH", "PER_SETUP_SPECIAL", "ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND SPECIAL_TYPE = '".$SPECIAL_TYPE."'", "SPECIAL_SEQ");
			echo GetHtmlSelect('SPECIAL_ID', 'SPECIAL_ID', $arr_special, 'ตำแหน่ง', '', '', '', '1');
			exit;
		}catch(Exception $e){
			$text = $e->getMessage();
		}
	break;
}
$url_back="../profile_servicehis.php";
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
