<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_POST['proc'];
$POSCOM_ID = $_POST['POSCOM_ID'];

$sql = "SELECT  *  FROM POSITION_MOVEUP  WHERE POSCOM_ID = '".$POSCOM_ID."'";
$query = $db->query($sql);

$query_com = $db->query("SELECT * FROM POSITION_COMMAND WHERE POSCOM_ID = '".$POSCOM_ID."' ");
$rec_com = $db->db_fetch_array($query_com);

$table="PER_PROFILE";

switch($proc){
	case "transfer" : 
		try{
			 while($rec = $db->db_fetch_array($query)){
					$field_per = array(
						"TYPE_ID" => $rec['POSMOVE_NEW_TYPE_ID'],
						"LEVEL_ID" => $rec['POSMOVE_NEW_LEVEL_ID'],
						"PER_STATUS_MOVEUP" => 0,
					    "UPDATE_BY" => $USER_BY,	
						"UPDATE_DATE" => $TIMESTAMP
					);
					$db->db_update("PER_PROFILE", $field_per, " PER_ID = '".$rec['POSMOVE_PER_ID']."' ");
					#####################################################
					unset($fields_pos);
					$fields_pos = array(
						"TYPE_ID" => $rec['POSMOVE_NEW_TYPE_ID'],
						"LEVEL_ID" =>$rec['POSMOVE_NEW_LEVEL_ID'],
						"UPDATE_BY" => $USER_BY,
						"UPDATE_DATE" => $TIMESTAMP
					);
					$db->db_update("POSITION_FRAME", $fields_pos, " POS_ID = '".$rec['POSMOVE_PER_ID']."' ");
                  
					#####################################################
				 $db->db_update("PER_POSITIONHIS", array('ACTIVE_STATUS' => 0), " PER_ID = '".$rec['POSMOVE_PER_ID']."' ");
				  $rec_pos = $db->get_data_rec("SELECT A.*, B.LINE_NAME_TH, B.LINE_NAME_EN FROM PER_PROFILE A LEFT JOIN SETUP_POS_LINE B ON A.LINE_ID = B.LINE_ID  WHERE A.PER_ID = '".$rec['POSMOVE_PER_ID']."' ");
					unset($field_poshis);
					$ARR_SDATE = explode('-',conv_date_db($POSCOM_SDATE));
					$field_poshis = array(
						"PER_ID" => $rec_pos['PER_ID'],
						"POS_NO" => $rec_pos['POS_NO'],
						"MOVEMENT_ID" => $rec_com['MOVEMENT_ID'],
						"CT_ID" => $rec_com['CT_ID'],
						"COM_NO" => $rec_com['POSCOM_NO'],
						"COM_DATE" => $rec_com['POSCOM_DATE'],
						"COM_SDATE" => $rec_com['POSCOM_SDATE'],
						"POSTYPE_ID" => $rec_pos['POSTYPE_ID'],
						"POS_YEAR" => $rec_pos['POS_YEAR'],
						"TYPE_ID" => $rec_pos['TYPE_ID'],
						"LEVEL_ID" => $rec_pos['LEVEL_ID'],
						"LG_ID" => $rec_pos['LG_ID'],
						"LINE_ID" => $rec_pos['LINE_ID'],
						"MT_ID" => $rec_pos['MT_ID'],
						"MANAGE_ID" => $rec_pos['MANAGE_ID'],
						"ORG_ID_1" => $rec_pos['ORG_ID_1'],
						"ORG_ID_2" => $rec_pos['ORG_ID_2'],
						"ORG_ID_3" => $rec_pos['ORG_ID_3'],
						"ORG_ID_4" => $rec_pos['ORG_ID_4'],
						"ORG_ID_5" => $rec_pos['ORG_ID_5'],
						"POSCOM_ID" => $POSCOM_ID,
						"POSHIS_TITLE_NAME_TH" => $rec_pos['LINE_NAME_TH'],
						"POSHIS_TITLE_NAME_EN" => $rec_pos['LINE_NAME_EN'],
						"TYPE_LIVE" => 1,
						"ACTIVE_STATUS" => 1,
						"CREATE_BY" => $USER_BY,
						"CREATE_DATE" => $TIMESTAMP,
						"DELETE_FLAG" => 0
					);
					$db->db_insert("PER_POSITIONHIS",$field_poshis);
					
					#####################################################
					unset($fields_com);
					$fields_com = array(
						"TRANSFER_STATUS" => 1,
					    "UPDATE_BY" => $USER_BY,
						"UPDATE_DATE" => $TIMESTAMP,
					);
					$db->db_update("POSITION_COMMAND", $fields_com, " POSCOM_ID = '".$POSCOM_ID."' ");
			
			}
		
	   $text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_his_slip_position_disp.php";
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
