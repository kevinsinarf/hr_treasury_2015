<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PER_ID =$_POST['PER_ID'];
$SAL_UP_ID = $_POST['SAL_UP_ID']; 
$SAL_COM_ID = $_POST['SAL_COM_ID'];
$PT_ID = $_POST['PT_ID'];
$ACT = $_POST['ACT'];

//page back
$TB = "PER_SALARYHIS";
$TB1 = "PER_PROFILE";

switch($proc){
	case "transfer" : 
		try{
			unset($fields);
			$query = $db->query("SELECT A.*, B.POS_NO, B.POS_YEAR FROM SAL_UP_SALARY A LEFT JOIN POSITION_FRAME B ON A.POS_ID = B.POS_ID  WHERE A.SAL_COM_ID = '".$SAL_COM_ID."'");
			while($rec_sal = $db->db_fetch_array($query)){
			$rec_com = $db->get_data_rec("SELECT * FROM SAL_COMMAND  WHERE SAL_COM_ID = '".$rec_sal['SAL_COM_ID']."'");
			$fields = array(
				'PER_ID' => $rec_sal['PER_ID'],
				'MOVEMENT_ID' => 17,
				'COM_NO' => $rec_com['COM_NO'],
				'COM_DATE' => $rec_com['COM_DATE'],
				'COM_SDATE' => $rec_com['COM_SDATE'],
				'POSTYPE_ID' => $rec_sal['POSTYPE_ID'],
				'POS_NO' => $rec_sal['POS_NO'] ,
				'POS_YEAR' => $rec_sal['POS_YEAR'],
				'TYPE_ID' => $rec_sal['TYPE_ID'],
				'LEVEL_ID' => $rec_sal['LEVEL_ID'],
				'LINE_ID' => $rec_sal['LINE_ID'],
				'CT_ID' => $rec_com['CT_ID'],
				'MOVEMENT_ID' => $rec_com['MOVEMENT_ID'],
				'MANAGE_ID' => $rec_sal['MANAGE_ID'],
				'ORG_ID_1' => $rec_sal['ORG_ID_1'],
				'ORG_ID_2' => $rec_sal['ORG_ID_2'],
				'ORG_ID_3' => $rec_sal['ORG_ID_3'],
				'ORG_ID_4' => $rec_sal['ORG_ID_4'],
				'SALARY' => $rec_sal['SALARY_NEW'],
				'SAL_COM_ID' => $SAL_COM_ID,
				'COMPENSATION_2' => $rec_sal['SALARY_SPE_NEW'], 
				'ACTIVE_STATUS' => 1,
				'CREATE_BY' => $USER_BY,
				'CREATE_DATE' => $TIMESTAMP,
				'DELETE_FLAG' => 0				
			);
			$db->db_insert($TB, $fields);
			
			$fields = array(
				'PER_SALARY' => $rec_sal['SALARY_NEW'],
				'PER_COMPENSATION_2' => $rec_sal['SALARY_SPE_NEW'],
				'PER_STEP' => $rec_sal['STEP_UP'],
				'UPDATE_BY' => $USER_BY,
				'UPDATE_DATE' => $TIMESTAMP,
			);
			$db->db_update($TB1, $fields," PER_ID = '".$rec_sal['PER_ID']."' "); 
			}
			unset($fields);
			
			$db->db_update('SAL_COMMAND', array('TRANSFER_STATUS' => 1)," SAL_COM_ID = '".$SAL_COM_ID."' "); 
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}

?>
<form name="form_back" method="post" action="../profile_his_up_salary_disp.php">
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
