<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PENALTY_ID = $_POST['PENALTY_ID']; 
$PT_ID = $_POST['PT_ID'];
$ACT = $_POST['ACT'];

//page back
$table = "PER_PUNISHMENT";

switch($proc){
	case "transfer" : 
		try{
			$query = $db->query("SELECT PUN_ID FROM PER_PUNISHMENT WHERE PENALTY_ID = '".$PENALTY_ID."'");
			$nums = $db->db_num_rows($query);
			$rec = $db->get_data_rec("SELECT * FROM PENALTY_PETITION_FORM WHERE PENALTY_ID = '".$PENALTY_ID."'");

			if($nums == 0){
				$rec_info = $db->get_data_rec("SELECT POSTYPE_ID, TYPE_ID, LEVEL_ID, LINE_ID, MANAGE_ID, ORG_ID_1, ORG_ID_2, ORG_ID_3, ORG_ID_4, ORG_ID_5 FROM PER_PROFILE WHERE PER_ID = '".$rec['INFORM_TO_PER_ID']."'");
				
				unset($fields);
				$fields['PER_ID'] = $rec['INFORM_TO_PER_ID'];
				$fields['POSTYPE_ID'] = $rec_info['POSTYPE_ID'];
				$fields['TYPE_ID'] = $rec_info['TYPE_ID'];
				$fields['LEVEL_ID'] = $rec_info['LEVEL_ID'];
				$fields['LINE_ID'] = $rec_info['LINE_ID'];
				$fields['MANAGE_ID'] = $rec_info['MANAGE_ID'];
				$fields['ORG_ID_1'] = $rec_info['ORG_ID_1'];
				$fields['ORG_ID_2'] = $rec_info['ORG_ID_2'];
				$fields['ORG_ID_3'] = $rec_info['ORG_ID_3'];
				$fields['ORG_ID_4'] = $rec_info['ORG_ID_4'];
				$fields['ORG_ID_5'] = $rec_info['ORG_ID_5'];
				$fields['INFORM_BY_PER_ID'] = $rec['INFORM_BY_PER_ID'];
				$fields['INFORM_NO'] = $rec['INFORM_NO'];
				$fields['INFORM_DATE'] = (!empty($rec['INFORM_DATE'])) ? $rec['INFORM_DATE'] : 'NULL';
				$fields['INFORM_CRIME_ID'] = $rec['INFORM_CRIME_ID'];
				
				$fields['BOARD_CT_ID'] = $rec['BOARD_CT_ID'];
				$fields['BOARD_NO'] = $rec['BOARD_NO'];
				$fields['BOARD_DATE'] = (!empty($rec['BOARD_DATE'])) ? $rec['BOARD_DATE'] : 'NULL';
				$fields['BOARD_DATE_RESULT'] = (!empty($rec['BOARD_DATE_RESULT'])) ? $rec['BOARD_DATE_RESULT'] : 'NULL';
				$fields['BOARD_RESULT'] = $rec['BOARD_RESULT'];
				$fields['BOARD_DETAIL'] = $rec['BOARD_DETAIL'];
				
				$fields['PAUSE_CT_ID'] = $rec['PAUSE_CT_ID'];
				$fields['PAUSE_NO'] = $rec['PAUSE_NO'];
				$fields['PAUSE_DATE'] = (!empty($rec['PAUSE_DATE'])) ? $rec['PAUSE_DATE'] : 'NULL';
				$fields['PAUSE_TITLE'] = $rec['PAUSE_TITLE'];
				$fields['PAUSE_SDATE'] = (!empty($rec['PAUSE_SDATE'])) ? $rec['PAUSE_SDATE'] : 'NULL';
				$fields['PAUSE_EDATE'] = (!empty($rec['PAUSE_EDATE'])) ? $rec['PAUSE_EDATE'] : 'NULL';
				$fields['PAUSE_SALARY'] = $rec['PAUSE_SALARY'];
				
				$fields['RESIGN_CT_ID'] = $rec['RESIGN_CT_ID'];
				$fields['RESIGN_NO'] = $rec['RESIGN_NO'];
				$fields['RESIGN_DATE'] = (!empty($rec['RESIGN_DATE'])) ? $rec['RESIGN_DATE'] : 'NULL';
				$fields['RESIGN_TITLE'] = $rec['RESIGN_TITLE'];
				$fields['RESIGN_SDATE'] = (!empty($rec['RESIGN_SDATE'])) ? $rec['RESIGN_SDATE'] : 'NULL';
				$fields['RESIGN_EDATE'] = (!empty($rec['RESIGN_EDATE'])) ? $rec['RESIGN_EDATE'] : 'NULL';
				$fields['RESIGN_SALARY'] = $rec['RESIGN_SALARY'];
				
				$fields['RESULT_CT_ID'] = $rec['RESULT_CT_ID'];
				$fields['RESULT_NO'] = $rec['RESULT_NO'];
				$fields['RESULT_DATE_ORDER'] = (!empty($rec['RESULT_DATE_ORDER'])) ? $rec['RESULT_DATE_ORDER'] : 'NULL';
				$fields['RESULT_RDATE'] = (!empty($rec['RESULT_RDATE'])) ? $rec['RESULT_RDATE'] : 'NULL';
				$fields['RESULT_DATE_RESULT'] = (!empty($rec['RESULT_DATE_RESULT'])) ? $rec['RESULT_DATE_RESULT'] : 'NULL';
				$fields['RESULT_FINAL'] = $rec['RESULT_FINAL'];
				$fields['RESULT_PUNISH_TYPE'] = $rec['RESULT_PUNISH_TYPE'];
				$fields['RESULT_PUNISH_ID'] = $rec['RESULT_PUNISH_ID'];
				$fields['PERCENT_PUNISH'] = $rec['PERCENT_PUNISH'];
				$fields['RESULT_SDATE'] = (!empty($rec['RESULT_SDATE'])) ? $rec['RESULT_SDATE'] : 'NULL';
				$fields['RESULT_EDATE'] = (!empty($rec['RESULT_EDATE'])) ? $rec['RESULT_EDATE'] : 'NULL';
				$fields['RESULT_DETAIL'] = $rec['RESULT_DETAIL'];
				
				$fields['FINAL_CT_ID'] = $rec['FINAL_CT_ID'];
				$fields['FINAL_NO'] = $rec['FINAL_NO'];
				$fields['FINAL_DATE'] = (!empty($rec['FINAL_DATE'])) ? $rec['FINAL_DATE'] : 'NULL';
				$fields['FINAL_TITLE'] = $rec['FINAL_TITLE'];
				$fields['FINAL_PUNISH_ID'] = $rec['FINAL_PUNISH_ID'];
				$fields['FINAL_PERCENTAGE'] = $rec['FINAL_PERCENTAGE'];
				$fields['FINAL_SDATE'] = (!empty($rec['FINAL_SDATE'])) ? $rec['FINAL_SDATE'] : 'NULL';
				$fields['FINAL_EDATE'] = (!empty($rec['FINAL_EDATE'])) ? $rec['FINAL_EDATE'] : 'NULL';
				
				$fields['REPORT_MEETING_TIME'] = $rec['REPORT_MEETING_TIME'];
				$fields['REPORT_MEETING_DATE'] = (!empty($rec['REPORT_MEETING_DATE'])) ? $rec['REPORT_MEETING_DATE'] : 'NULL';
				$fields['REPORT_MEETING_DATE'] = (!empty($rec['REPORT_MEETING_DATE'])) ? $rec['REPORT_MEETING_DATE'] : 'NULL';
				$fields['KRST_COM_CT_ID'] = $rec['KRST_COM_CT_ID'];
				$fields['KRST_COM_NO'] = $rec['KRST_COM_NO'];
				$fields['KRST_COM_DATE'] = (!empty($rec['KRST_COM_DATE'])) ? $rec['KRST_COM_DATE'] : 'NULL';
				$fields['KRST_COM_TITLE'] = $rec['KRST_COM_TITLE'];
				$fields['KRST_PUNISH_ID'] = $rec['KRST_PUNISH_ID'];
				$fields['KRST_PUNISH_PERCENTAGE'] = $rec['KRST_PUNISH_PERCENTAGE'];
				$fields['KRST_COM_SDATE'] = (!empty($rec['KRST_COM_SDATE'])) ? $rec['KRST_COM_SDATE'] : 'NULL';
				$fields['KRST_COM_EDATE'] = (!empty($rec['KRST_COM_EDATE'])) ? $rec['KRST_COM_EDATE'] : 'NULL';
				
				$fields['BOOK_NO'] = $rec['BOOK_NO'];
				$fields['BOOK_DATE'] = (!empty($rec['BOOK_DATE'])) ? $rec['BOOK_DATE'] : 'NULL';
				$fields['BOOK_TITLE'] = $rec['BOOK_TITLE'];
				$fields['KR_TIME'] = $rec['KR_TIME'];
				$fields['KR_DATE'] = (!empty($rec['KR_DATE'])) ? $rec['KR_DATE'] : 'NULL';
				$fields['END_COM_CT_ID'] = $rec['END_COM_CT_ID'];
				$fields['END_COM_NO'] = $rec['END_COM_NO'];
				$fields['END_COM_DATE'] = (!empty($rec['END_COM_DATE'])) ? $rec['END_COM_DATE'] : 'NULL';
				$fields['END_COM_TITLE'] = $rec['END_COM_TITLE'];
				$fields['END_PUNISH_ID'] = $rec['END_PUNISH_ID'];
				$fields['END_PUNISH_PERCENTAGE'] = $rec['END_PUNISH_PERCENTAGE'];
				$fields['END_COM_SDATE'] = (!empty($rec['END_COM_SDATE'])) ? $rec['END_COM_SDATE'] : 'NULL';
				$fields['END_COM_EDATE'] = (!empty($rec['END_COM_EDATE'])) ? $rec['END_COM_EDATE'] : 'NULL';
				
				$fields['CANCEL_YEAR'] = $rec['CANCEL_YEAR'];
				$fields['CANCEL_DATE'] = (!empty($rec['CANCEL_DATE'])) ? $rec['CANCEL_DATE'] : 'NULL';
				$fields['CANCEL_GAZZETTE_BOOK'] = $rec['CANCEL_GAZZETTE_BOOK'];
				$fields['CANCEL_GAZZETTE_PART'] = $rec['CANCEL_GAZZETTE_PART'];
				$fields['CANCEL_GAZZETTE_DATE'] = $rec['CANCEL_GAZZETTE_DATE'];
				$fields['CANCEL_GAZZETTE_PAGE'] = $rec['CANCEL_GAZZETTE_PAGE'];
				
				$fields['PENALTY_STATUS'] = $rec['PENALTY_STATUS'];
				$fields['PENALTY_ID'] = $PENALTY_ID;
				$fields['CREATE_BY'] = $USER_BY;
				$fields['CREATE_DATE'] = $TIMESTAMP;
				$fields['UPDATE_BY'] = $USER_BY;
				$fields['UPDATE_DATE'] = $TIMESTAMP;
				$fields['DELETE_FLAG'] = 0;
				$db->db_insert("PER_PUNISHMENT", $fields);
			}else{
				unset($fields);
				$fields['INFORM_BY_PER_ID'] = $rec['INFORM_BY_PER_ID'];
				$fields['INFORM_NO'] = $rec['INFORM_NO'];
				$fields['INFORM_DATE'] = (!empty($rec['INFORM_DATE'])) ? $rec['INFORM_DATE'] : 'NULL';
				$fields['INFORM_CRIME_ID'] = $rec['INFORM_CRIME_ID'];
				
				$fields['BOARD_CT_ID'] = $rec['BOARD_CT_ID'];
				$fields['BOARD_NO'] = $rec['BOARD_NO'];
				$fields['BOARD_DATE'] = (!empty($rec['BOARD_DATE'])) ? $rec['BOARD_DATE'] : 'NULL';
				$fields['BOARD_DATE_RESULT'] = (!empty($rec['BOARD_DATE_RESULT'])) ? $rec['BOARD_DATE_RESULT'] : 'NULL';
				$fields['BOARD_RESULT'] = $rec['BOARD_RESULT'];
				$fields['BOARD_DETAIL'] = $rec['BOARD_DETAIL'];
				
				$fields['PAUSE_CT_ID'] = $rec['PAUSE_CT_ID'];
				$fields['PAUSE_NO'] = $rec['PAUSE_NO'];
				$fields['PAUSE_DATE'] = (!empty($rec['PAUSE_DATE'])) ? $rec['PAUSE_DATE'] : 'NULL';
				$fields['PAUSE_TITLE'] = $rec['PAUSE_TITLE'];
				$fields['PAUSE_SDATE'] = (!empty($rec['PAUSE_SDATE'])) ? $rec['PAUSE_SDATE'] : 'NULL';
				$fields['PAUSE_EDATE'] = (!empty($rec['PAUSE_EDATE'])) ? $rec['PAUSE_EDATE'] : 'NULL';
				$fields['PAUSE_SALARY'] = $rec['PAUSE_SALARY'];
				
				$fields['RESIGN_CT_ID'] = $rec['RESIGN_CT_ID'];
				$fields['RESIGN_NO'] = $rec['RESIGN_NO'];
				$fields['RESIGN_DATE'] = (!empty($rec['RESIGN_DATE'])) ? $rec['RESIGN_DATE'] : 'NULL';
				$fields['RESIGN_TITLE'] = $rec['RESIGN_TITLE'];
				$fields['RESIGN_SDATE'] = (!empty($rec['RESIGN_SDATE'])) ? $rec['RESIGN_SDATE'] : 'NULL';
				$fields['RESIGN_EDATE'] = (!empty($rec['RESIGN_EDATE'])) ? $rec['RESIGN_EDATE'] : 'NULL';
				$fields['RESIGN_SALARY'] = $rec['RESIGN_SALARY'];
				
				$fields['RESULT_CT_ID'] = $rec['RESULT_CT_ID'];
				$fields['RESULT_NO'] = $rec['RESULT_NO'];
				$fields['RESULT_DATE_ORDER'] = (!empty($rec['RESULT_DATE_ORDER'])) ? $rec['RESULT_DATE_ORDER'] : 'NULL';
				$fields['RESULT_RDATE'] = (!empty($rec['RESULT_RDATE'])) ? $rec['RESULT_RDATE'] : 'NULL';
				$fields['RESULT_DATE_RESULT'] = (!empty($rec['RESULT_DATE_RESULT'])) ? $rec['RESULT_DATE_RESULT'] : 'NULL';
				$fields['RESULT_FINAL'] = $rec['RESULT_FINAL'];
				$fields['RESULT_PUNISH_TYPE'] = $rec['RESULT_PUNISH_TYPE'];
				$fields['RESULT_PUNISH_ID'] = $rec['RESULT_PUNISH_ID'];
				$fields['PERCENT_PUNISH'] = $rec['PERCENT_PUNISH'];
				$fields['RESULT_SDATE'] = (!empty($rec['RESULT_SDATE'])) ? $rec['RESULT_SDATE'] : 'NULL';
				$fields['RESULT_EDATE'] = (!empty($rec['RESULT_EDATE'])) ? $rec['RESULT_EDATE'] : 'NULL';
				$fields['RESULT_DETAIL'] = $rec['RESULT_DETAIL'];
				
				$fields['FINAL_CT_ID'] = $rec['FINAL_CT_ID'];
				$fields['FINAL_NO'] = $rec['FINAL_NO'];
				$fields['FINAL_DATE'] = (!empty($rec['FINAL_DATE'])) ? $rec['FINAL_DATE'] : 'NULL';
				$fields['FINAL_TITLE'] = $rec['FINAL_TITLE'];
				$fields['FINAL_PUNISH_ID'] = $rec['FINAL_PUNISH_ID'];
				$fields['FINAL_PERCENTAGE'] = $rec['FINAL_PERCENTAGE'];
				$fields['FINAL_SDATE'] = (!empty($rec['FINAL_SDATE'])) ? $rec['FINAL_SDATE'] : 'NULL';
				$fields['FINAL_EDATE'] = (!empty($rec['FINAL_EDATE'])) ? $rec['FINAL_EDATE'] : 'NULL';
				
				$fields['REPORT_MEETING_TIME'] = $rec['REPORT_MEETING_TIME'];
				$fields['REPORT_MEETING_DATE'] = (!empty($rec['REPORT_MEETING_DATE'])) ? $rec['REPORT_MEETING_DATE'] : 'NULL';
				$fields['REPORT_MEETING_DATE'] = (!empty($rec['REPORT_MEETING_DATE'])) ? $rec['REPORT_MEETING_DATE'] : 'NULL';
				$fields['KRST_COM_CT_ID'] = $rec['KRST_COM_CT_ID'];
				$fields['KRST_COM_NO'] = $rec['KRST_COM_NO'];
				$fields['KRST_COM_DATE'] = (!empty($rec['KRST_COM_DATE'])) ? $rec['KRST_COM_DATE'] : 'NULL';
				$fields['KRST_COM_TITLE'] = $rec['KRST_COM_TITLE'];
				$fields['KRST_PUNISH_ID'] = $rec['KRST_PUNISH_ID'];
				$fields['KRST_PUNISH_PERCENTAGE'] = $rec['KRST_PUNISH_PERCENTAGE'];
				$fields['KRST_COM_SDATE'] = (!empty($rec['KRST_COM_SDATE'])) ? $rec['KRST_COM_SDATE'] : 'NULL';
				$fields['KRST_COM_EDATE'] = (!empty($rec['KRST_COM_EDATE'])) ? $rec['KRST_COM_EDATE'] : 'NULL';
				
				$fields['BOOK_NO'] = $rec['BOOK_NO'];
				$fields['BOOK_DATE'] = (!empty($rec['BOOK_DATE'])) ? $rec['BOOK_DATE'] : 'NULL';
				$fields['BOOK_TITLE'] = $rec['BOOK_TITLE'];
				$fields['KR_TIME'] = $rec['KR_TIME'];
				$fields['KR_DATE'] = (!empty($rec['KR_DATE'])) ? $rec['KR_DATE'] : 'NULL';
				$fields['END_COM_CT_ID'] = $rec['END_COM_CT_ID'];
				$fields['END_COM_NO'] = $rec['END_COM_NO'];
				$fields['END_COM_DATE'] = (!empty($rec['END_COM_DATE'])) ? $rec['END_COM_DATE'] : 'NULL';
				$fields['END_COM_TITLE'] = $rec['END_COM_TITLE'];
				$fields['END_PUNISH_ID'] = $rec['END_PUNISH_ID'];
				$fields['END_PUNISH_PERCENTAGE'] = $rec['END_PUNISH_PERCENTAGE'];
				$fields['END_COM_SDATE'] = (!empty($rec['END_COM_SDATE'])) ? $rec['END_COM_SDATE'] : 'NULL';
				$fields['END_COM_EDATE'] = (!empty($rec['END_COM_EDATE'])) ? $rec['END_COM_EDATE'] : 'NULL';
				
				$fields['CANCEL_YEAR'] = $rec['CANCEL_YEAR'];
				$fields['CANCEL_DATE'] = (!empty($rec['CANCEL_DATE'])) ? $rec['CANCEL_DATE'] : 'NULL';
				$fields['CANCEL_GAZZETTE_BOOK'] = $rec['CANCEL_GAZZETTE_BOOK'];
				$fields['CANCEL_GAZZETTE_PART'] = $rec['CANCEL_GAZZETTE_PART'];
				$fields['CANCEL_GAZZETTE_DATE'] = $rec['CANCEL_GAZZETTE_DATE'];
				$fields['CANCEL_GAZZETTE_PAGE'] = $rec['CANCEL_GAZZETTE_PAGE'];
				
				$fields['PENALTY_STATUS'] = $rec['PENALTY_STATUS'];
				$fields['UPDATE_BY'] = $USER_BY;
				$fields['UPDATE_DATE'] = $TIMESTAMP;
				$db->db_update($table, $fields," PENALTY_ID = '".$PENALTY_ID."' ");
			}	
			
			unset($fields);
			if($rec['PENALTY_STATUS'] >= 2){
				$fields['BOARD_TRANSFER_STATUS'] = 1;
			}
			if($rec['PENALTY_STATUS'] >= 3){
				$fields['PAUSE_TRANSFER_STATUS'] = 1;
			}
			if($rec['PENALTY_STATUS'] >= 4){
				$fields['RESIGN_TRANSFER_STATUS'] = 1;
			}
			if($rec['PENALTY_STATUS'] >= 5){
				$fields['RESULT_TRANSFER_STATUS'] = 1;	
			}
			if($rec['PENALTY_STATUS'] >= 6){
				$fields['FINAL_TRANSFER_STATUS'] = 1;	
			}
			if($rec['PENALTY_STATUS'] >= 7){
				$fields['REPORT_TRANSFER_STATUS'] = 1;	
			}
			if($rec['PENALTY_STATUS'] >= 8){
				$fields['END_TRANSFER_STATUS'] = 1;	
			}
			if($rec['PENALTY_STATUS'] >= 9){
				$fields['CANCEL_TRANSFER_STATUS'] = 1;	
			}
			$db->db_update("PENALTY_PETITION_FORM", $fields," PENALTY_ID = '".$PENALTY_ID."' ");
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back = "";
?>
<form name="form_back" method="post" action="../profile_his_trans_rule_disp.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
