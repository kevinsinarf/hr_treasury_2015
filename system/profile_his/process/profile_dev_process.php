<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$menu_id = $_POST['menu_id'];
$PT_ID = $_POST['PT_ID'];
$PER_ID = $_POST['PER_ID'];

$table = "PER_TRAINHIS";

switch($proc){
	case "add" :
		try{
			$rec = $db->get_data_rec("SELECT POSTYPE_ID, POS_NO,POS_YEAR FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."'");
			unset($fields);
			if($_POST['S_COUNTRY'] != $default_country_id){
				$fields["TRAINHIS_CITY"] = ctext($_POST['S_CITY']);
				$fields["PROV_ID"] = '';
			}else{
				$fields["TRAINHIS_CITY"] = '';
				$fields["PROV_ID"]=  ctext($_POST['s_prov']);
			}
			$fields["PER_ID"] = $PER_ID;	
			$fields["POSTYPE_ID"] = $rec['POSTYPE_ID'];
			$fields["POS_NO"] = $rec['POS_NO'];
			$fields["POS_YEAR"] = $rec['POS_YEAR'];
			$fields["TYPE_ID"] = ctext($_POST['TYPE_ID']);
			$fields["LEVEL_ID"] = ctext($_POST['LEVEL_ID']);			
			$fields["LINE_ID"] = ctext($_POST['LINE_ID']);
			$fields['MT_ID']  = $_POST['MT_ID'];
			$fields['LG_ID'] = $_POST['LG_ID'];
			$fields["MANAGE_ID"] = ctext($_POST['MANAGE_ID']);
			$fields["ORG_ID_1"] = ctext($_POST['GOV_ORG_ID_1']);
			$fields["ORG_ID_2"] = ctext($_POST['GOV_ORG_ID_2']);
			$fields["ORG_ID_3"] = ctext($_POST['GOV_ORG_ID_3']);
			$fields["ORG_ID_4"] = ctext($_POST['GOV_ORG_ID_4']);
			$fields["ORG_ID_5"] = ctext($_POST['GOV_ORG_ID_5']);
			$fields["TRAINHIS_PROJECT_NAME"] = ctext($_POST['TRAINHIS_PROJECT_NAME']);
			$fields["TRAINHIS_COURSE_NAME"] = ctext($_POST['TRAINHIS_COURSE_NAME']);
			$fields["TRAINHIS_GEN_NAME"] = ctext($_POST['TRAINHIS_GEN_NAME']);
			$fields["TRAINHIS_GEN_NO"] = ctext($_POST['TRAINHIS_GEN_NO']); 
			$fields["TRAINHIS_TYPE_DEV"] = ctext($_POST['TRAINHIS_TYPE_DEV']);
			$fields["TRAINHIS_TYPE_ACT"] = ctext($_POST['TRAINHIS_TYPE_ACT']) ;
			$fields["TRAINHIS_TYPE_PLACE"] = ctext($_POST['TRAINHIS_TYPE_PLACE']);
			$fields["TRAINHIS_TYPE_ORG"] = ctext($_POST['TRAINHIS_TYPE_ORG']);
			$fields["TRAINHIS_TYPE_ATTEND"] = ctext($_POST['TRAINHIS_TYPE_ATTEND']);
			$fields["COUNTRY_ID"] = ctext($_POST['S_COUNTRY']);
			$fields["TRAINHIS_ORG_NAME"] = ctext($_POST['TRAINHIS_ORG_NAME']);
			$fields["TRAINHIS_PLACE_NAME"] = ctext($_POST['TRAINHIS_PLACE_NAME']);
			$fields["TRAINHIS_SDATE"] = conv_date_db($TRAINHIS_SDATE);
			$fields["TRAINHIS_EDATE"] = conv_date_db($TRAINHIS_EDATE);
			$fields["TRAINHIS_RESULT"] = ctext($_POST['TRAINHIS_RESULT']);
			$fields["CREATE_BY"] = $USER_BY;
			$fields["CREATE_DATE"] = $TIMESTAMP;
			$fields["UPDATE_BY"] = ctext($USER_BY);
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$fields["DELETE_FLAG"] = '0';
			$db->db_insert($table,$fields);	
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMePADDge();
		}
	break;

	case "edit" :
		try{
			unset($fields);
			if($_POST['S_COUNTRY'] != $default_country_id){
				$fields["TRAINHIS_CITY"] = ctext($_POST['S_CITY']);
				$fields["PROV_ID"] = '';
			}else{
				$fields["TRAINHIS_CITY"] = '';
				$fields["PROV_ID"] = ctext($_POST['s_prov']);
			}
			$fields["POS_YEAR"] = $rec['POS_YEAR'];
			$fields["TYPE_ID"] = ctext($_POST['TYPE_ID']);
			$fields["LEVEL_ID"] = ctext($_POST['LEVEL_ID']);			
			$fields["LINE_ID"] = ctext($_POST['LINE_ID']);
			$fields["MANAGE_ID"] = ctext($_POST['MANAGE_ID']);
			$fields['MT_ID']  = $_POST['MT_ID'];
			$fields['LG_ID'] = $_POST['LG_ID'];
			$fields["ORG_ID_1"] = ctext($_POST['GOV_ORG_ID_1']);
			$fields["ORG_ID_2"] = ctext($_POST['GOV_ORG_ID_2']);
			$fields["ORG_ID_3"] = ctext($_POST['GOV_ORG_ID_3']);
			$fields["ORG_ID_4"] = ctext($_POST['GOV_ORG_ID_4']);
			$fields["ORG_ID_5"] = ctext($_POST['GOV_ORG_ID_5']);
			$fields["TRAINHIS_PROJECT_NAME"] = ctext($_POST['TRAINHIS_PROJECT_NAME']);
			$fields["TRAINHIS_COURSE_NAME"] = ctext($_POST['TRAINHIS_COURSE_NAME']);
			$fields["TRAINHIS_GEN_NAME"] = ctext($_POST['TRAINHIS_GEN_NAME']);
			$fields["TRAINHIS_GEN_NO"] = ctext($_POST['TRAINHIS_GEN_NO']); 
			$fields["TRAINHIS_TYPE_DEV"] = ctext($_POST['TRAINHIS_TYPE_DEV']);
			$fields["TRAINHIS_TYPE_ACT"] = ctext($_POST['TRAINHIS_TYPE_ACT']) ;
			$fields["TRAINHIS_TYPE_PLACE"] = ctext($_POST['TRAINHIS_TYPE_PLACE']);
			$fields["TRAINHIS_TYPE_ORG"] = ctext($_POST['TRAINHIS_TYPE_ORG']);
			$fields["TRAINHIS_TYPE_ATTEND"] = ctext($_POST['TRAINHIS_TYPE_ATTEND']);
			$fields["COUNTRY_ID"] = ctext($_POST['S_COUNTRY']);
			$fields["TRAINHIS_ORG_NAME"] = ctext($_POST['TRAINHIS_ORG_NAME']);
			$fields["TRAINHIS_PLACE_NAME"] = ctext($_POST['TRAINHIS_PLACE_NAME']);
			$fields["TRAINHIS_SDATE"] = conv_date_db($TRAINHIS_SDATE);
			$fields["TRAINHIS_EDATE"] = conv_date_db($TRAINHIS_EDATE);
			$fields["TRAINHIS_RESULT"] = ctext($_POST['TRAINHIS_RESULT']);
			$fields["UPDATE_BY"] = $USER_BY;
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$db->db_update("PER_TRAINHIS", $fields, "  TRAINHIS_ID ='".$TRAINHIS_ID."'  "); 
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMePADDge();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," TRAINHIS_ID = '".$TRAINHIS_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "get_org" : 
		$sql = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_id."' ORDER BY ORG_SEQ ASC ";
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
		$sql = "SELECT LEVEL_ID, LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE DELETE_FLAG = '0' AND TYPE_ID = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LEVEL_SEQ ASC ";
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
		$sql = "SELECT LG_ID, LG_NAME_TH FROM SETUP_POS_LINE_GROUP  WHERE  DELETE_FLAG = '0' AND TYPE_ID = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LG_NAME_TH  ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 	exit;
	break;

	case "get_line" : 
		$sql = "SELECT LINE_ID, LINE_NAME_TH FROM SETUP_POS_LINE WHERE DELETE_FLAG = '0' AND ".$name." = '".$type_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
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
		$mt_id = trim($_POST['mt_id']);
		$sql = "SELECT MANAGE_ID, MANAGE_NAME_TH FROM SETUP_POS_MANAGE WHERE   DELETE_FLAG = '0' AND MT_ID = ".$mt_id." ORDER BY MANAGE_NAME_TH ASC ";
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
?>
<form name="form_back" method="post" action="../profile_dev.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
	<input type="hidden" id="PADD_ID" name="TRAINHIS_ID" value="<?php echo $TRAINHIS_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>