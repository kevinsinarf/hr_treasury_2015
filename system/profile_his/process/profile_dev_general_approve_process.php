<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//page back
$table = $_POST['TABLE_TRANSFER'];

switch($proc){
	case "transfer" : 
		try{
			unset($fields);
			
			$fields['TRANSFER_STATUS'] = 1;
			$db->db_update($table, $fields," ".$_POST['FIELD_TRANSFER']." = '".$_POST['USER_REGIS_ID']."' ");
			
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back = "";
?>
<form name="form_back" method="post" action="../profile_dev_general_approve.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="ACT" name="ACT" value="<?php echo $_POST['ACT']; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
