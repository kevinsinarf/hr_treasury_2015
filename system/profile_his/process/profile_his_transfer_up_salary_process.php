<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc;
$PER_ID =$_POST['PER_ID'];
$SAL_UP_ID = $_POST['SAL_UP_ID']; 
$SAL_COM_ID = $_POST['SAL_COM_ID'];
$PT_ID = $_POST['PT_ID'];
$ACT = $_POST['ACT'];
$rec_com = $db->get_data_rec("SELECT * FROM SAL_COMMAND  WHERE SAL_COM_ID = '".$SAL_COM_ID."'");


if($rec_com['MOVEMENT_ID']==15||$rec_com['MOVEMENT_ID']==22||$rec_com['MOVEMENT_ID']==26){
		$filter = "  SAL_COM_ID = ".$SAL_COM_ID; 
		
}
if($rec_com['MOVEMENT_ID']==17||$rec_com['MOVEMENT_ID']==23||$rec_com['MOVEMENT_ID']==45){
		$filter = "  SAL_COM_TEMP = ".$SAL_COM_ID; 
}

if($rec_com['MOVEMENT_ID']==16||$rec_com['MOVEMENT_ID']==44||$rec_com['MOVEMENT_ID']==27){
		$filter = "  SAL_COM_SPE =  ".$SAL_COM_ID; 

}

//page back
$TB = "PER_SALARYHIS";
$TB1 = "PER_PROFILE";

switch($proc){
	case "transfer" : 
		try{
			$db->query('BEGIN TRANSACTION');
			$query = $db->query("SELECT * FROM SAL_UP_SALARY WHERE ".$filter);
			while($rec_sal = $db->db_fetch_array($query)){
			
			$SALHIS_TYPE = "";
			$SALHIS_UP = "";
			$POSTYPE_ID = $rec_sal['POSTYPE_ID'];
			$query_score_level = $db->query("SELECT LV_SCORE_ID FROM SAL_SCORE WHERE SCORE_ID = '".$rec_sal['SCORE_ID']."' ");
			$rec_score = $db->db_fetch_array($query_score_level);
			$LV_SCORE_ID = $rec_score['LV_SCORE_ID'];
			
			if($rec_com['MOVEMENT_ID']==15||$rec_com['MOVEMENT_ID']==22||$rec_com['MOVEMENT_ID']==26){ //เลื่อน
				if($POSTYPE_ID==1||$POSTYPE_ID==3){
					$SALHIS_TYPE = 1;
					$SALHIS_UP = $rec_sal['SCORE_PERCENT'];
				}else{
					$SALHIS_TYPE = 2;
					$SALHIS_UP = $rec_sal['STEP_UP'];
				}
					
				
					$SALARY_NEW = $rec_sal['SALARY_NEW']; 
					$SALARY_SPE_NEW = 0;
					$SAL_COMPENSATION_4 = 0;
			}
			if($rec_com['MOVEMENT_ID']==17||$rec_com['MOVEMENT_ID']==23||$rec_com['MOVEMENT_ID']==45){ //เงินเพิ่มค่าครองชีพชั่วคราว
					$SALARY_NEW = 0; 
					$SALARY_SPE_NEW = 0;
					$SAL_COMPENSATION_4 = $rec_sal['SAL_COMPENSATION_4'];
					
			}
			
			if($rec_com['MOVEMENT_ID']==16||$rec_com['MOVEMENT_ID']==44||$rec_com['MOVEMENT_ID']==27){ //ค่าตอบแทนพิเศษ
					$SALARY_NEW = 0; 
					$SAL_COMPENSATION_4 = 0;
					$SALARY_SPE_NEW = $rec_sal['SALARY_SPE_UP'];
					
			}
			
			
			$fields = array(
				'PER_ID' => $rec_sal['PER_ID'],
				'MOVEMENT_ID' => $rec_com['MOVEMENT_ID'],
				'COM_NO' => $rec_com['COM_NO'],
				'COM_DATE' => $rec_com['COM_DATE'],
				'COM_SDATE' => $rec_com['COM_SDATE'],
				'POSTYPE_ID' => $rec_sal['POSTYPE_ID'],
				'POS_NO' => $rec_sal['POS_NO'] ,
				'POS_YEAR' => $rec_sal['POS_YEAR'],
				'TYPE_ID' => $rec_sal['TYPE_ID'],
				'LEVEL_ID' => $rec_sal['LEVEL_ID'],
				'LINE_ID' => $rec_sal['LINE_ID'],
				'LG_ID' => $rec_sal['LG_ID'],
				'CT_ID' => $rec_com['CT_ID'],
				'MOVEMENT_ID' => $rec_com['MOVEMENT_ID'],
				'MANAGE_ID' => $rec_sal['MANAGE_ID'],
				'ORG_ID_1' => $rec_sal['ORG_ID_1'],
				'ORG_ID_2' => $rec_sal['ORG_ID_2'],
				'ORG_ID_3' => $rec_sal['ORG_ID_3'],
				'ORG_ID_4' => $rec_sal['ORG_ID_4'],
				'SAL_COM_ID' => $SAL_COM_ID,
				'SALARY' => $SALARY_NEW,
				'COMPENSATION_2' =>$SALARY_SPE_NEW,
				'COMPENSATION_4' => $SAL_COMPENSATION_4,
				'SALHIS_UP'  => $SALHIS_UP,
				'SALHIS_TYPE' => $SALHIS_TYPE,
				'LV_SCORE_ID' => $LV_SCORE_ID,
				'ACTIVE_STATUS' => 1,
				'CREATE_BY' => $USER_BY,
				'CREATE_DATE' => $TIMESTAMP,
				'DELETE_FLAG' => 0				
			);
			$db->db_insert($TB, $fields);
			
			if($rec_com['MOVEMENT_ID']==15||$rec_com['MOVEMENT_ID']==22||$rec_com['MOVEMENT_ID']==26){
				$fields = array(
					'PER_SALARY' => $SALARY_NEW,
					'PER_STEP' => $rec_sal['STEP_UP'],
					'UPDATE_BY' => $USER_BY,
					'UPDATE_DATE' => $TIMESTAMP,
				);
			}
			
			if($rec_com['MOVEMENT_ID']==17||$rec_com['MOVEMENT_ID']==23||$rec_com['MOVEMENT_ID']==45){
				$fields = array(
					'PER_COMPENSATION_4' => $SAL_COMPENSATION_4,
					'PER_STEP' => $rec_sal['STEP_UP'],
					'UPDATE_BY' => $USER_BY,
					'UPDATE_DATE' => $TIMESTAMP,
				);
			}
			
			if($rec_com['MOVEMENT_ID']==16||$rec_com['MOVEMENT_ID']==44||$rec_com['MOVEMENT_ID']==27){
				$fields = array(
					'PER_COMPENSATION_2' => $SALARY_SPE_NEW ,
					'PER_STEP' => $rec_sal['STEP_UP'],
					'UPDATE_BY' => $USER_BY,
					'UPDATE_DATE' => $TIMESTAMP,
				);
			}
			$db->db_update($TB1, $fields," PER_ID = '".$rec_sal['PER_ID']."' "); 
			
			}
			unset($fields);
			
			$db->db_update('SAL_COMMAND', array('TRANSFER_STATUS' => 1)," SAL_COM_ID = '".$SAL_COM_ID."' "); 
			$db->query('COMMIT TRANSACTION');
			
			$text=$save_proc;
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
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
