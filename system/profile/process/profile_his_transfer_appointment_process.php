<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$ROTCOM_ID = $_POST['ROTCOM_ID']; 
$ACT = $_POST['ACT'];

//page back
$TB = "PER_POSITIONHIS";
$TB2 = "PER_PROFILE";
$TB3 = "POSITION_FRAME";

switch($proc){
	case "transfer" : 
		try{
			$rec_com = $db->get_data_rec("SELECT * FROM ROTATE_COMMAND WHERE ROTCOM_ID = '".$ROTCOM_ID."' ");
			
			$sql = "SELECT * FROM ROTATE_DESC WHERE ROTCOM_ID = '".$ROTCOM_ID."'";
			$query = $db->query($sql);
			while($rec = $db->db_fetch_array($query)){
				
				// Update POSITION_FRAME -------------
				$sql_pos_new = "SELECT * FROM POSITION_FRAME WHERE POS_ID ='".$rec['ROTDESC_NEW_POS_ID']."' ";
				$query_new = $db->query($sql_pos_new);
				$rec_new = $db->db_fetch_array($query_new);
				
				$sql_pos_old = "SELECT * FROM POSITION_FRAME WHERE POS_ID ='".$rec['ROTDESC_LAST_POS_ID']."' ";
				$query_old = $db->query($sql_pos_old);
				$rec_old = $db->db_fetch_array($query_old);
				
				// update ตำแหน่งเก่า //-------------------------------------------
				unset($fields);
				if(($rec['ROTDESC_TYPE_BUDGET'] == 2)){ // สับเปลี่ยนอัตราเงินเดือน
					$fields["POS_FRAME_SALARY"] = $rec_new['POS_FRAME_SALARY'];
					$fields["POS_FRAME_POSITION_SALARY"] = $rec_new['POS_FRAME_POSITION_SALARY'];
					$fields["POS_FRAME_COMPENSATION_1"] = $rec_new['POS_FRAME_COMPENSATION_1'];
					$fields["POS_FRAME_COMPENSATION_2"] = $rec_new['POS_FRAME_COMPENSATION_2'];
					$fields["POS_FRAME_COMPENSATION_3"] = $rec_new['POS_FRAME_COMPENSATION_3'];
					$fields["POS_FRAME_COMPENSATION_4"] = $rec_new['POS_FRAME_COMPENSATION_4'];
					$fields["POS_TRUE_SALARY"] = $rec_new['POS_TRUE_SALARY'];
					$fields["POS_TRUE_POSITION_SALARY"] = $rec_new['POS_TRUE_POSITION_SALARY'];
					$fields["POS_TRUE_COMPENSATION_1"] = $rec_new['POS_TRUE_COMPENSATION_1'];
					$fields["POS_TRUE_COMPENSATION_2"] = $rec_new['POS_TRUE_COMPENSATION_2'];
					$fields["POS_TRUE_COMPENSATION_3"] = $rec_new['POS_TRUE_COMPENSATION_3'];
					$fields["POS_TRUE_COMPENSATION_4"] = $rec_new['POS_TRUE_COMPENSATION_4'];
				}
				if($rec_old['POS_STATUS'] == 3 && $rec_new['POS_STATUS'] == 3){
					$POS_STATUS = 3;
				}else{
					$POS_STATUS = $rec_new['POS_STATUS'];
				}
				$fields["POS_STATUS"] = $POS_STATUS;
				$fields["UPDATE_BY"] = $USER_BY;
				$fields["UPDATE_DATE"] = $TIMESTAMP;
				$db->db_update($TB3, $fields, " POS_ID = '".$rec['ROTDESC_LAST_POS_ID']."' ");// TABLE POSITION_FRAME	
				
				// update ตำแหน่งใหม่ //-------------------------------------------
				unset($fields);
				if($rec['ROTDESC_TYPE_BUDGET'] == 1){ // อาศัยเบิก
					$fields["POS_TRUE_SALARY"] = $rec_old['POS_FRAME_SALARY'];
				}else if(($rec['ROTDESC_TYPE_BUDGET'] == 2)){ // สับเปลี่ยนอัตราเงินเดือน
					$fields["POS_FRAME_SALARY"] = $rec_old['POS_FRAME_SALARY'];
					$fields["POS_FRAME_POSITION_SALARY"] = $rec_old['POS_FRAME_POSITION_SALARY'];
					$fields["POS_FRAME_COMPENSATION_1"] = $rec_old['POS_FRAME_COMPENSATION_1'];
					$fields["POS_FRAME_COMPENSATION_2"] = $rec_old['POS_FRAME_COMPENSATION_2'];
					$fields["POS_FRAME_COMPENSATION_3"] = $rec_old['POS_FRAME_COMPENSATION_3'];
					$fields["POS_FRAME_COMPENSATION_4"] = $rec_old['POS_FRAME_COMPENSATION_4'];
					$fields["POS_TRUE_SALARY"] = $rec_old['POS_TRUE_SALARY'];
					$fields["POS_TRUE_POSITION_SALARY"] = $rec_old['POS_TRUE_POSITION_SALARY'];
					$fields["POS_TRUE_COMPENSATION_1"] = $rec_old['POS_TRUE_COMPENSATION_1'];
					$fields["POS_TRUE_COMPENSATION_2"] = $rec_old['POS_TRUE_COMPENSATION_2'];
					$fields["POS_TRUE_COMPENSATION_3"] = $rec_old['POS_TRUE_COMPENSATION_3'];
					$fields["POS_TRUE_COMPENSATION_4"] = $rec_old['POS_TRUE_COMPENSATION_4'];
				}
				$fields["POS_STATUS"] = 3;
				$fields["UPDATE_BY"] = $USER_BY;
				$fields["UPDATE_DATE"] = $TIMESTAMP;
				$db->db_update($TB3, $fields, " POS_ID = '".$rec['ROTDESC_NEW_POS_ID']."' ");// TABLE POSITION_FRAME
				
				// Update PER_PERFILE -------------
				unset($fields);
				$fields = array(
					'POS_ID' => $rec['ROTDESC_NEW_POS_ID'],
					'TYPE_ID' => $rec['ROTDESC_NEW_TYPE_ID'],
					'LEVEL_ID' => $rec['ROTDESC_NEW_LEVEL_ID'],
					'LINE_ID' => $rec['ROTDESC_NEW_LINE_ID'],
					'MANAGE_ID' => $rec['ROTDESC_NEW_MANAGE_ID'],
					'ORG_ID_1' => $rec['ROTDESC_NEW_ORG_ID_1'],
					'ORG_ID_2' => $rec['ROTDESC_NEW_ORG_ID_2'],
					'ORG_ID_3' => $rec['ROTDESC_NEW_ORG_ID_3'],
					'ORG_ID_4' => $rec['ROTDESC_NEW_ORG_ID_4'],
					'ORG_ID_5' => $rec['ROTDESC_NEW_ORG_ID_5'],
					'PER_SALARY' => $rec_new['POS_TRUE_SALARY'],
					'PER_SALARY_POSITION' => $rec_new['POS_TRUE_POSITION_SALARY'],
					'PER_COMPENSATION_1' => $rec_new['POS_TRUE_COMPENSATION_1'],
					'PER_COMPENSATION_2' => $rec_new['POS_TRUE_COMPENSATION_2'],
					'PER_COMPENSATION_3' => $rec_new['POS_TRUE_COMPENSATION_3'],
					'PER_COMPENSATION_4' => $rec_new['POS_TRUE_COMPENSATION_4']
				);
				$db->db_update($TB2, $fields," PER_ID = '".$rec['ROTDESC_PER_ID']."'");
				
				// Insert PER_POSITIONHIS -------------
				$db->db_update($TB, array('ACTIVE_STATUS' => 0)," PER_ID = '".$rec['ROTDESC_PER_ID']."'");
				unset($fields);
				$fields = array(
					'PER_ID' => $rec['ROTDESC_PER_ID'],
					'MOVEMENT_ID' => $rec_com['MOVEMENT_ID'],
					'CT_ID' => $rec_com['CT_ID'],
					'COM_NO' => $rec_com['ROTCOM_NO'],
					'COM_DATE' => $rec_com['ROTCOM_DATE'],
					'COM_SDATE' => $rec_com['ROTCOM_SDATE'],
					'POSTYPE_ID' => 1,
					'POS_NO' => $rec['ROTDESC_NEW_POS_NO'] ,
					'TYPE_ID' => $rec['ROTDESC_NEW_TYPE_ID'],
					'LEVEL_ID' => $rec['ROTDESC_NEW_LEVEL_ID'],
					'LG_ID' => $rec_new['LG_ID'],
					'MT_ID' => $rec_new['MT_ID'],
					'LINE_ID' => $rec['ROTDESC_NEW_LINE_ID'],
					'MANAGE_ID' => $rec['ROTDESC_NEW_MANAGE_ID'],
					'ORG_ID_1' => $rec['ROTDESC_NEW_ORG_ID_1'],
					'ORG_ID_2' => $rec['ROTDESC_NEW_ORG_ID_2'],
					'ORG_ID_3' => $rec['ROTDESC_NEW_ORG_ID_3'],
					'ORG_ID_4' => $rec['ROTDESC_NEW_ORG_ID_4'],
					'ORG_ID_5' => $rec['ROTDESC_NEW_ORG_ID_5'],
					'SALARY' => $rec_new['POS_TRUE_SALARY'],
					'SALARY_POSITION' => $rec_new['POS_TRUE_POSITION_SALARY'],
					'COMPENSATION_1' => $rec_new['POS_TRUE_COMPENSATION_1'],
					'COMPENSATION_2' => $rec_new['POS_TRUE_COMPENSATION_2'],
					'COMPENSATION_3' => $rec_new['POS_TRUE_COMPENSATION_3'],
					'COMPENSATION_4' => $rec_new['POS_TRUE_COMPENSATION_4'],
					'TYPE_LIVE' => $rec['ROTDESC_TYPE_LIVE'],
					'POSHIS_DATE' => $date_now_db,
					'POSHIS_NOTE' => $rec['ROTDESC_NOTE'],
					'ACTIVE_STATUS' => 1,
					'CREATE_BY' => $USER_BY,
					'CREATE_DATE' => $TIMESTAMP,
					'UPDATE_BY' => $USER_BY,
					'UPDATE_DATE' => $TIMESTAMP,
					'DELETE_FLAG' => 0,
					'ROTDESC_ID' => $rec['ROTDESC_ID']
				);
				$db->db_insert($TB, $fields);
			}
			$db->db_update('ROTATE_COMMAND', array('TRANSFER_STATUS' => 1)," ROTCOM_ID = '".$ROTCOM_ID."'"); 
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
?>
<form name="form_back" method="post" action="../profile_his_appointment_disp.php">
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
