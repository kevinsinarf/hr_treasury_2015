<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$MAN_BDG_ID = $_POST['MAN_BDG_ID'];
$MAN_BDG_NAME_TH = ctext($_POST['MAN_BDG_NAME_TH']);
$proc = $_POST['proc'];
 
switch($proc){
	case "add" : 
		try{
			$fields = array(
			   "MAN_BDG_NAME_TH" => $MAN_BDG_NAME_TH,
			   "ACTIVE_STATUS" => 1,
			   "DELETE_FLAG" => 0,
			   "CREATE_BY" => $_SESSION["sys_id"],
			   "CREATE_DATE" => $TIMESTAMP,
			   "UPDATE_BY" => $_SESSION["sys_id"],
			   "UPDATE_DATE" => $TIMESTAMP,
			);
			
			$db->db_insert("SETUP_MANPOWER_BUDGET",$fields); unset($fields);
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
			   "MAN_BDG_NAME_TH" => $MAN_BDG_NAME_TH,
			   "ACTIVE_STATUS" => 1,
			   "UPDATE_BY" => $_SESSION["sys_id"],
			   "UPDATE_DATE" => $TIMESTAMP,
			);
			
			$db->db_update("SETUP_MANPOWER_BUDGET",$fields," MAN_BDG_ID = '".$MAN_BDG_ID."' "); unset($fields);
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
		unset($fields);
				$fields = array(
				"DELETE_FLAG"=>'1'
				);
			$db->db_update("SETUP_MANPOWER_BUDGET",$fields," MAN_BDG_ID = '".$MAN_BDG_ID."' ");
			
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}

if($proc!='chk_dup1' && $proc!='chk_dup2'){
?>
<form name="form_back" method="post" action="../man_budget_disp.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php
}
?>