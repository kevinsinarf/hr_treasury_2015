<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$LV_SCORE_ID = $_POST['LV_SCORE_ID'];
$SCORE_S = $_POST['SCORE_S'];
$SCORE_E = $_POST['SCORE_E'];
$PERCENT_SAL_E = $_POST['PERCENT_SAL_E'];
$PERCENT_SAL = $_POST['PERCENT_SAL'];
$SCORE_TYPE = $_POST['SCORE_TYPE'];

$url_back="../set_level_salary3_disp.php";
$table = "SAL_SCORE";

switch($proc){	
	case 'save' :
		try{
			$db->db_delete($table," POSTYPE_ID= '5' AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."'  AND SCORE_STATUS = 1 ");
			if(count($LV_SCORE_ID) > 0){
				
					foreach($LV_SCORE_ID as $key => $lv_score_val){
						$fields = array(
							"POSTYPE_ID" => 5,
							"YEAR_BDG" => $S_YEAR_BDG,
							"ROUND" => $S_ROUND,
							"PERCENT_SAL_E" => $PERCENT_SAL_E[$key],
							"LV_SCORE_ID" => $lv_score_val,
							"SCORE_S" => $SCORE_S[$key],
							"SCORE_E" => $SCORE_E[$key],
							"PERCENT_SAL" => $PERCENT_SAL[$key],
							"SCORE_TYPE" => $SCORE_TYPE,
							"SCORE_STATUS" => 1,
							"CONFIRM_TYPE" => 1,
							"CREATE_BY" => $USER_BY,
							"CREATE_DATE" => $TIMESTAMP,
							"UPDATE_BY" => $USER_BY,
							"UPDATE_DATE" => $TIMESTAMP,
						);	
						$db->db_insert($table,$fields);
					}
			
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'ConfirmEmp':
		try{	
		   $db->query('BEGIN TRANSACTION');
		   
		 
		   $db->db_update($table,array('CONFIRM_TYPE' => 2)," POSTYPE_ID = 5  AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND SCORE_STATUS = 1 "); 
		   $text= text('อนุมัติเกณฑ์การประเมิน เรียบร้อยแล้ว');
		  
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	
	
	case "getOrgParent" : 
		// กลุ่มงาน
		$q_org4 = $db->query("SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$org_id."' AND ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' ORDER BY ORG_NAME_TH");
		while($r_org4 = $db->db_fetch_array($q_org4)){
			$arr_org4[$r_org4['ORG_ID']] = text($r_org4['ORG_NAME_TH']);
		}
		echo GetHtmlSelect('S_ORG4','S_ORG4',$arr_org4,'เลือกกลุ่มงาน',$S_ORG4,'','','1','','2');
		exit;
	break;
	
	case 'getLevel' :
		   $q_lv = $db->query("SELECT LV_SCORE_ID, LEVEL_NAME FROM SAL_LEVEL_SCORE WHERE ACTIVE_STATUS='1' ORDER BY LV_SEQ ASC");
			$obj = array();
            while($r_lv = $db->db_fetch_array($q_lv)){
               $row['ID'] = $r_lv['LV_SCORE_ID'];
			   $row['VALUE'] = text($r_lv['LEVEL_NAME']);
               array_push($obj, $row);
             
            }
           echo json_encode($obj);
		exit;
	break;
}
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="search" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="S_YEAR_BDG" name="S_YEAR_BDG" value="<?php echo $S_YEAR_BDG;?>" />
	<input type="hidden" id="S_ROUND" name="S_ROUND" value="<?php echo $S_ROUND;?>" />
    <input type="hidden" id="S_SCORE_TYPE" name="S_SCORE_TYPE" value="<?php echo $SCORE_TYPE;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
