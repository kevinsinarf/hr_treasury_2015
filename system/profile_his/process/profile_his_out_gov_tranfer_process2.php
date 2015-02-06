<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
 $COM_ID=$_POST['COM_ID'];
 $proc = $_POST['proc'];


$table="PER_PROFILE";
$table1 = "RETIRE_COMMAND_DESC";
$table2 = "RETIRE_COMMAND";

switch($proc){
	case "transfer" : 
		try{
		 	$sql = "SELECT A.PER_ID, A.COMDESC_ID,B.COM_SDATE FROM RETIRE_COMMAND_DESC A JOIN RETIRE_COMMAND B ON A.COM_ID = B.COM_ID WHERE A.COM_ID = '".$COM_ID."'";
			$query = $db->query($sql);
			while($rec= $db->db_fetch_array($query)){
			unset($fields);
			$fields = array(
					"PER_STATUS_CIVIL"=> '4',
					"PER_DATE_RESIGN" => $rec['COM_SDATE'],
					"COMDESC_ID" =>$rec['COMDESC_ID'],
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
					);
				    $db->db_update($table,$fields," PER_ID = '".$rec['PER_ID']."' ");
			}
			$fields1 = array(
					"TRANSFER_STATUS" => 1,
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
				);
				 $db->db_update($table2,$fields1," COM_ID = '".$COM_ID."' "); 
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
