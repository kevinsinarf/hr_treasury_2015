<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$PT_ID	= $_POST['PT_ID'];
$PER_ID		= $_POST['PER_ID'];
$TRAV_ID	= $_POST['TRAV_ID'];
$TYPE_ID	 = $_POST['TYPE_ID'];
$LEVEL_ID	 = $_POST['LEVEL_ID'];
$LINE_ID	 = $_POST['LINE_ID'];
$MANAGE_ID	 = $_POST['MANAGE_ID'];
$ORG_ID_1	 = $_POST['ORG_ID_1'];
$ORG_ID_2	 = $_POST['ORG_ID_2'];
$ORG_ID_3	 = $_POST['ORG_ID_3'];
$ORG_ID_4	 = $_POST['ORG_ID_4'];
$ORG_ID_5	 = $_POST['ORG_ID_5'];
$COUNTRY_ID	 = $_POST['COUNTRY_ID'];
$TRAV_SDATE	 = $_POST['TRAV_SDATE'];
$TRAV_EDATE	 = $_POST['TRAV_EDATE'];
$TRAV_BENEFIT	 = $_POST['TRAV_BENEFIT'];
$TRAV_COST	 = $_POST['TRAV_COST'];
$TRAV_NOTE	 = $_POST['TRAV_NOTE'];
$ACTIVE_STATUS	 = $_POST['ACTIVE_STATUS'];

$table="PER_TRAVELHIS";
switch($proc){
	case "add" : 
		try{		
			$sql="select (case when MAX(TRAV_SEQ)>0 then (MAX(TRAV_SEQ)+1) else '1' end) as NUM_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$NUM_SEQ = $db->get_data_field($sql,"NUM_SEQ");
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"TRAV_SEQ"	 => $NUM_SEQ,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"COUNTRY_ID"	 => $COUNTRY_ID,
				"TRAV_SDATE"	 => conv_date_db($TRAV_SDATE),
				"TRAV_EDATE"	 => conv_date_db($TRAV_EDATE),
				"TRAV_BENEFIT"	 => ctext($TRAV_BENEFIT),
				"TRAV_COST"	 => ctext($TRAV_COST),
				"TRAV_NOTE"	 => ctext($TRAV_NOTE),
				
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
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"COUNTRY_ID"	 => $COUNTRY_ID,
				"TRAV_SDATE"	 => conv_date_db($TRAV_SDATE),
				"TRAV_EDATE"	 => conv_date_db($TRAV_EDATE),
				"TRAV_BENEFIT"	 => ctext($TRAV_BENEFIT),
				"TRAV_COST"	 => ctext($TRAV_COST),
				"TRAV_NOTE"	 => ctext($TRAV_NOTE),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			
			$db->db_update($table,$fields," TRAV_ID = '".$TRAV_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," TRAV_ID = '".$TRAV_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_travelhis.php";
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
