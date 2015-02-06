<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$ORG_ID_3 = $_POST['ORG_ID_3'];
$T_SAL_UP_ID = $_POST['T_SAL_UP_ID'];
$T_ORG_ID_3 = $_POST['T_ORG_ID_3'];
$SAL_UP_ID = $_POST['SAL_UP_ID'];

$url_back="../setup_per_group_gov_disp.php";
$TB = "SAL_UP_SALARY";

switch($proc){	
	case 'AddAllMg' :
		try{
				$db->query('BEGIN TRANSACTION');
				$query_per = $db->query("SELECT PER_ID, PREFIX_ID, PER_FIRSTNAME_TH,  PER_MIDNAME_TH, PER_LASTNAME_TH, POS_ID, POS_NO, ORG_ID_1, ORG_ID_2,  ORG_ID_3, ORG_ID_4, TYPE_ID, LEVEL_ID, LG_ID, LINE_ID, MT_ID,  MANAGE_ID, POSTYPE_ID, PER_SALARY FROM PER_PROFILE WHERE POSTYPE_ID = 1 AND PER_STATUS_CIVIL = 2 AND LEVEL_ID IN(4,5,6,1,2) ");
				
				while($rec = $db->db_fetch_array($query_per)){
				  $PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);	
				  $query_num = $db->query("SELECT SAL_UP_ID FROM SAL_UP_SALARY WHERE  POSTYPE_ID = 1 AND  YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND PER_ID = '".$rec['PER_ID']."' ");
				  $nums = $db->db_num_rows($query_num);
				  $rec_num = $db->db_fetch_array($query_num);
				
				$SAL_UP_ID = $rec_num['SAL_UP_ID'];
				 if($nums > 0){
					  $fields = array(
						  "PER_ID" => $rec['PER_ID'],
						  "POSTYPE_ID" => 1,
						  "YEAR_BDG" => $S_YEAR_BDG,
						  "ROUND" => $S_ROUND,
						  "POS_ID" => $rec['POS_ID'],
						  "POS_NO" => $rec['POS_NO'],
						  "NAME" => ctext($PER_NAME),
						  "TYPE_ID" => $rec['TYPE_ID'],
						  "LG_ID" => $rec['LG_ID'],
						  "LEVEL_ID" => $rec['LEVEL_ID'],
						  "LINE_ID" => $rec['LINE_ID'],
						  "MANAGE_ID" => $rec['MANAGE_ID'],
						  "MT_ID" => $rec['MT_ID'],
						  "ORG_ID_1" => $rec['ORG_ID_1'],
						  "ORG_ID_2" => $rec['ORG_ID_2'],
						  "ORG_ID_3" => $rec['ORG_ID_3'],
						  "ORG_ID_4" => $rec['ORG_ID_4'],
						  "SALARY_NOW" => $rec['PER_SALARY'],
						  "CONFIRM_TYPE" => 1,
						  "UPDATE_BY" => $USER_BY,
						  "UPDATE_DATE" => $TIMESTAMP,
					  );	
					  $db->db_update($TB,$fields," SAL_UP_ID = '".$SAL_UP_ID."' "); 	
				  }else{
					  $fields = array(
						"PER_ID" => $rec['PER_ID'],
						"POSTYPE_ID" => 1,
						"YEAR_BDG" => $S_YEAR_BDG,
						"ROUND" => $S_ROUND,
						"POS_ID" => $rec['POS_ID'],
						"POS_NO" => $rec['POS_NO'],
						"NAME" => ctext($PER_NAME),
						"TYPE_ID" => $rec['TYPE_ID'],
						"LG_ID" => $rec['LG_ID'],
						"LEVEL_ID" => $rec['LEVEL_ID'],
						"LINE_ID" => $rec['LINE_ID'],
						"MANAGE_ID" => $rec['MANAGE_ID'],
						"MT_ID" => $rec['MT_ID'],
						"ORG_ID_1" => $rec['ORG_ID_1'],
						"ORG_ID_2" => $rec['ORG_ID_2'],
						"ORG_ID_3" => $rec['ORG_ID_3'],
						"ORG_ID_4" => $rec['ORG_ID_4'],
						"SALARY_NOW" => $rec['PER_SALARY'],
						"SAL_UP_TYPE" => 2,
						"CONFIRM_TYPE" => 1,
						"CREATE_BY" => $USER_BY,
						"CREATE_DATE" => $TIMESTAMP,
					);	
					$db->db_insert($TB,$fields);
				}
			}
			
			$db->query("COMMIT TRANSACTION");
	
			$text=$save_proc;
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case 'AddAll' :
		try{
				$db->query('BEGIN TRANSACTION');
				$query_per = $db->query("SELECT PER_ID, PREFIX_ID, PER_FIRSTNAME_TH,  PER_MIDNAME_TH, PER_LASTNAME_TH, POS_ID, POS_NO, ORG_ID_1, ORG_ID_2,  ORG_ID_3, ORG_ID_4, TYPE_ID, LEVEL_ID, LG_ID, LINE_ID, MT_ID,  MANAGE_ID, POSTYPE_ID, PER_SALARY FROM PER_PROFILE WHERE POSTYPE_ID = 1 AND PER_STATUS_CIVIL = 2 AND LEVEL_ID NOT IN(4,5,6,1,2) ");
				
				while($rec = $db->db_fetch_array($query_per)){
				  $PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);	
				  $query_num = $db->query("SELECT SAL_UP_ID FROM SAL_UP_SALARY WHERE  POSTYPE_ID = 1 AND  YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND PER_ID = '".$rec['PER_ID']."' ");
				  $nums = $db->db_num_rows($query_num);
				  $rec_num = $db->db_fetch_array($query_num);
				
				$SAL_UP_ID = $rec_num['SAL_UP_ID'];
				 if($nums > 0){
					  $fields = array(
						  "PER_ID" => $rec['PER_ID'],
						  "POSTYPE_ID" => 1,
						  "YEAR_BDG" => $S_YEAR_BDG,
						  "ROUND" => $S_ROUND,
						  "POS_ID" => $rec['POS_ID'],
						  "POS_NO" => $rec['POS_NO'],
						  "NAME" => ctext($PER_NAME),
						  "TYPE_ID" => $rec['TYPE_ID'],
						  "LG_ID" => $rec['LG_ID'],
						  "LEVEL_ID" => $rec['LEVEL_ID'],
						  "LINE_ID" => $rec['LINE_ID'],
						  "MANAGE_ID" => $rec['MANAGE_ID'],
						  "MT_ID" => $rec['MT_ID'],
						  "ORG_ID_1" => $rec['ORG_ID_1'],
						  "ORG_ID_2" => $rec['ORG_ID_2'],
						  "ORG_ID_3" => $rec['ORG_ID_3'],
						  "ORG_ID_4" => $rec['ORG_ID_4'],
						  "SALARY_NOW" => $rec['PER_SALARY'],
						  "CONFIRM_TYPE" => 1,
						  "UPDATE_BY" => $USER_BY,
						  "UPDATE_DATE" => $TIMESTAMP,
					  );	
					  $db->db_update($TB,$fields," SAL_UP_ID = '".$SAL_UP_ID."' "); 	
				  }else{
					  $fields = array(
						"PER_ID" => $rec['PER_ID'],
						"POSTYPE_ID" => 1,
						"YEAR_BDG" => $S_YEAR_BDG,
						"ROUND" => $S_ROUND,
						"POS_ID" => $rec['POS_ID'],
						"POS_NO" => $rec['POS_NO'],
						"NAME" => ctext($PER_NAME),
						"TYPE_ID" => $rec['TYPE_ID'],
						"LG_ID" => $rec['LG_ID'],
						"LEVEL_ID" => $rec['LEVEL_ID'],
						"LINE_ID" => $rec['LINE_ID'],
						"MANAGE_ID" => $rec['MANAGE_ID'],
						"MT_ID" => $rec['MT_ID'],
						"ORG_ID_1" => $rec['ORG_ID_1'],
						"ORG_ID_2" => $rec['ORG_ID_2'],
						"ORG_ID_3" => $rec['ORG_ID_3'],
						"ORG_ID_4" => $rec['ORG_ID_4'],
						"SALARY_NOW" => $rec['PER_SALARY'],
						"SAL_UP_TYPE" => 1,
						"CONFIRM_TYPE" => 1,
						"CREATE_BY" => $USER_BY,
						"CREATE_DATE" => $TIMESTAMP,
					);	
					$db->db_insert($TB,$fields);
				}
			}
			
			$db->query("COMMIT TRANSACTION");
	
			$text=$save_proc;
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case 'AddTransfer' :
		try{
			$db->query('BEGIN TRANSACTION');
	 		$query = $db->query("SELECT * FROM SAL_UP_SALARY  WHERE SAL_UP_ID = '".$T_SAL_UP_ID."' ");
			$rec = $db->db_fetch_array($query);
			$S_YEAR_BDG = $rec['YEAR_BDG'];
			$S_ROUND = $rec['ROUND'];
			
		  $fields = array(
					"PER_ID" => $rec['PER_ID'],
					"POSTYPE_ID" => 1,
					"YEAR_BDG" => $S_YEAR_BDG,
					"ROUND" => $S_ROUND,
					"POS_ID" => $rec['POS_ID'],
					"POS_NO" => $rec['POS_NO'],
					"NAME" => $rec['NAME'],
					"TYPE_ID" => $rec['TYPE_ID'],
					"LG_ID" => $rec['LG_ID'],
					"LEVEL_ID" => $rec['LEVEL_ID'],
					"LINE_ID" => $rec['LINE_ID'],
					"MANAGE_ID" => $rec['MANAGE_ID'],
					"MT_ID" => $rec['MT_ID'],
					"ORG_ID_1" => $rec['ORG_ID_1'],
					"ORG_ID_2" => $rec['ORG_ID_2'],
					"ORG_ID_3" => $T_ORG_ID_3,
					"SALARY_NOW" => $rec['SALARY_NOW'],
					"SAL_UP_TYPE" => 1,
					"CONFIRM_TYPE" => 1,
					"CREATE_BY" => $USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
				);	
			
			$db->db_insert($TB,$fields);
			$db->db_delete($TB," SAL_UP_ID = '".$T_SAL_UP_ID."' ");
			
			$db->query("COMMIT TRANSACTION");
			$text=$save_proc;
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case 'Confirm':
		try{	
		   $db->query('BEGIN TRANSACTION');
		   
		   $query_all = $db->query("SELECT COUNT(PER_ID) AS COUNT_PER FROM SAL_UP_SALARY WHERE  POSTYPE_ID = 1 AND CONFIRM_TYPE >= 2  AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' ");
			$rec_all = $db->db_fetch_array($query_all);
			$num_all = (int)$rec_all['COUNT_PER'];
		   if($num_all == 0){
		   		$db->db_update($TB,array('CONFIRM_TYPE' => 2)," POSTYPE_ID = 1 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' "); 
				$text= text('อนุมัติการจัดกลุ่มเพื่อกำหนดกรอบเลื่อนเงินเดือน เรียบร้อยแล้ว');
		   }else{
			   $text= text('ไม่สามารถอนุมัติการจัดกลุ่มเพื่อกำหนดกรอบเลื่อนเงินเดือนได้ เนื่องจากมีการยืนยันแล้ว');
		   }
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case 'delete':
		try{	
			$db->db_delete($TB," SAL_UP_ID = '".$SAL_UP_ID."' ");
			$url_back="../setup_per_group_gov_form.php";
	        $text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_level" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
		exit;
	 }
	 case "get_line_group" : 
		$sql = "Select LG_ID , LG_NAME_TH From SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LG_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LG_ID'];
			$row['VALUE'] = text($rec['LG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
		exit;
	break;
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LG_ID = ".$lg_id." AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
		exit;
	}
	break;
	
}
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="search" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="S_YEAR_BDG" name="S_YEAR_BDG" value="<?php echo $S_YEAR_BDG;?>" />
	<input type="hidden" id="S_ROUND" name="S_ROUND" value="<?php echo $S_ROUND;?>" />
    <input id="OGR_ID_3" type="hidden" value="<?php echo $ORG_ID_3; ?>" name="ORG_ID_3">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
