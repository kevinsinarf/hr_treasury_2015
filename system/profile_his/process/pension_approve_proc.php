<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PENSION_ID = $_POST['PENSION_ID'];

$table = "PENSION_MAIN";

switch($proc){
	case "approve" : 
		try{
/*			unset($fields);
			$fields = array(
				"PENSION_TYPE_REQUEST_CIVIL" => $PENSION_TYPE_REQUEST_CIVIL,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table, $fields, " PENSION_IDCARD = '".$S_PENSION_IDCARD."' "); 
			$text=$save_proc;
*/		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;	
}
$url_back="../pension_approve_disp.php";
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
