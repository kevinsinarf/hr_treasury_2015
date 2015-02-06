<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$RETIRE_ID=$_POST['RETIRE_ID'];
$proc = $_POST['proc'];

$sql = "SELECT  B.PER_ID FROM PER_PROFILE A INNER JOIN RETIRE B ON A.PER_ID = B.PER_ID WHERE B.RETIRE_ID = '".$RETIRE_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);



$table="PER_PROFILE";
$table1 = "RETIRE_COMMAND";

switch($proc){
	case "transfer" : 
		try{
			$DATE_RESIGN = $db->get_data_field("SELECT DATE_RESIGN FROM RETIRE WHERE RETIRE_ID = '".$RETIRE_ID."'", "DATE_RESIGN");
			unset($fields);
			$fields = array(
					"PER_STATUS_CIVIL "=> '4',
					"PER_DATE_RESIGN" => $DATE_RESIGN,
					"RETIRE_ID" => $RETIRE_ID,
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
					);
				    $db->db_update($table,$fields," PER_ID = '".$rec['PER_ID']."' "); 
					
			$fields1 = array(
					"TRANSFER_STATUS" => 1,
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
				);
				 $db->db_update($table1,$fields1," RETIRE_ID = '".$RETIRE_ID."' "); 
				 $text=$edit_proc;

		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_his_out_gov_disp.php";
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
