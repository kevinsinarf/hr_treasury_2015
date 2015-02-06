<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$MISS_LAST_SALARY = str_replace(",", "", $_POST['MISS_LAST_SALARY']);
$MISS_NEW_SALARY = str_replace(",", "", $_POST['MISS_NEW_SALARY']);

$table="PER_MISSSALHIS";
switch($proc){
	case "add" : 
		try{		
			$PER_PROFILE = $db->get_data_rec("SELECT * FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."' ");
			$sql="select (case when MAX(MISS_SEQ)>0 then (MAX(MISS_SEQ)+1) else '1' end) as MISS_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$MISS_SEQ = $db->get_data_field($sql,"MISS_SEQ");
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"MISS_SEQ"	 => $MISS_SEQ,
				"TYPE_ID"	 => $PER_PROFILE["TYPE_ID"],
				"LEVEL_ID"	 => $PER_PROFILE["LEVEL_ID"],
				"LINE_ID"	 => $PER_PROFILE["LINE_ID"],
				"MANAGE_ID"	 => $PER_PROFILE["MANAGE_ID"],
				"ORG_ID_1"	 => $PER_PROFILE["ORG_ID_1"],
				"ORG_ID_2"	 => $PER_PROFILE["ORG_ID_2"],
				"ORG_ID_3"	 => $PER_PROFILE["ORG_ID_3"],
				"ORG_ID_4"	 => $PER_PROFILE["ORG_ID_4"],
				"ORG_ID_5"	 => $PER_PROFILE["ORG_ID_5"],
				"MISS_TYPE"	 => $MISS_TYPE,
				"MISS_SDATE"	 => conv_date_db($MISS_SDATE),
				"MISS_EDATE"	 => conv_date_db($MISS_EDATE),
				"MISS_LAST_SALARY"	 => $MISS_LAST_SALARY,
				"MISS_NEW_SALARY"	 => $MISS_NEW_SALARY,
				"MISS_NOTE"	 => ctext($MISS_NOTE),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => ($USER_BY),
				"UPDATE_BY" => ($USER_BY),
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_DATE" => $TIMESTAMP,
				"DELETE_FLAG" => '0'	
			);	
			//print_r($fields); exit;
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
				"MISS_TYPE"	 => $MISS_TYPE,
				"MISS_SDATE"	 => conv_date_db($MISS_SDATE),
				"MISS_EDATE"	 => conv_date_db($MISS_EDATE),
				"MISS_LAST_SALARY"	 => $MISS_LAST_SALARY,
				"MISS_NEW_SALARY"	 => $MISS_NEW_SALARY,
				"MISS_NOTE"	 => ctext($MISS_NOTE),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);
			
			$db->db_update($table,$fields," MISS_ID = '".$MISS_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," MISS_ID = '".$MISS_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_missalhis_disp.php";
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
