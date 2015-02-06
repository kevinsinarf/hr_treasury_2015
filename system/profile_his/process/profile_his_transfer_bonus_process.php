<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PER_ID =$_POST['PER_ID'];
$BONUS_COM_ID = $_POST['BONUS_COM_ID']; 
$BONUS_ID = $_POST['BONUS_ID'];
$PT_ID = $_POST['PT_ID'];
$ACT = $_POST['ACT'];

//page back
$TB = "PER_BONUSHIS";

switch($proc){
	case "transfer" : 
		try{
			unset($fields);
			$sql = "SELECT * FROM BONUS_ADJUST  WHERE BONUS_COM_ID = '".$BONUS_COM_ID."' ";
			$query = $db->query($sql);
			while($rec = $db->db_fetch_array($query)){
			$rec_com = $db->get_data_rec("SELECT * FROM BONUS_COMMAND  WHERE BONUS_COM_ID = '".$BONUS_COM_ID."' ");
			$total_bonus = ($rec['BONUS_M1'] + $rec['BONUS_M2']);
			$fields = array(
				'PER_ID' => $rec['PER_ID'],
				'COM_NO' => $rec_com['COM_NO'],
				'COM_DATE' => $rec_com['COM_DATE'],
				'COM_SDATE' => $rec_com['COM_SDATE'],
				'CT_ID' => $rec_com['CT_ID'],
				'MOVEMENT_ID' => $rec_com['MOVEMENT_ID'],
				'POS_NO' => $rec['POS_NO'],
				'TYPE_ID' => $rec['TYPE_ID'],
				'LEVEL_ID' => $rec['LEVEL_ID'],
				'LG_ID' => $rec['LG_ID'],
				'LINE_ID' => $rec['LINE_ID'],
				'MANAGE_ID' => $rec['MANAGE_ID'],
				'ORG_ID_1' => $rec['ORG_ID_1'],
				'ORG_ID_2' => $rec['ORG_ID_2'],
				'ORG_ID_3' => $rec['ORG_ID_3'],
				'ORG_ID_4' => $rec['ORG_ID_4'],
				'COMPENSATION_5' => $total_bonus,
				'BONUS_ID' => $BONUS_ID,
				'ACTIVE_STATUS' => 1,
				'CREATE_BY' => $USER_BY,
				'CREATE_DATE' => $TIMESTAMP,
				'DELETE_FLAG' => 0				
			);
			$db->db_insert($TB, $fields);
			unset($fields);
			}
			$db->db_update('BONUS_COMMAND', array('TRANSFER_STATUS' => 1)," BONUS_COM_ID = '".$BONUS_COM_ID."' "); 
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}

?>
<form name="form_back" method="post" action="../profile_his_bonus_disp.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
    <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
