<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc=  $_POST['proc'];
$CT_ID = $_POST['CT_ID'];
$LT_ID = $_POST['LT_ID'];
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];
$CT_NAME_TH = ctext($_POST['CT_NAME_TH']);
$CT_NAME_EN = ctext($_POST['CT_NAME_EN']);

$url_back="../data_law_type_disp.php";
$table="SETUP_COMMAND_TYPE";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"LT_ID" => $LT_ID,
				"CT_NAME_TH" => $CT_NAME_TH,
				"CT_NAME_EN" => $CT_NAME_EN,
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"DELETE_FLAG" => 0,
				"ACTIVE_STATUS" => $ACTIVE_STATUS
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
				"LT_ID" => $LT_ID,
				"CT_NAME_TH" => $CT_NAME_TH,
				"CT_NAME_EN" => $CT_NAME_EN,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
				"ACTIVE_STATUS" => $ACTIVE_STATUS
			);	
			$db->db_update($table,$fields," CT_ID = '".$CT_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_update($table,array("DELETE_FLAG" => 1)," CT_ID = '".$CT_ID."' "); 
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}

?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
