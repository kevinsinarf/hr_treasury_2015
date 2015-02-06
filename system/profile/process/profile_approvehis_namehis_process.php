<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$TABLE_ID = $_POST['TABLE_ID'];
$REQUEST_ID=$_POST['REQUEST_ID'];

$PER_ID = $_POST['PER_ID'];
$NAMEHIS_ID = $_POST['NAMEHIS_ID'];
$NAMEHIS_NOTICEDATE = $_POST['NAMEHIS_NOTICEDATE'];
$NAMEHIS_CHANGEDATE = $_POST['NAMEHIS_CHANGEDATE'];
$NAMEHIS_DETAIL_1 = $_POST['NAMEHIS_DETAIL_1'];
$NAMEHIS_DETAIL_2 = $_POST['NAMEHIS_DETAIL_2'];
$NAMEHIS_DETAIL_3 = $_POST['NAMEHIS_DETAIL_3'];
$NAMEHIS_DETAIL_4 = $_POST['NAMEHIS_DETAIL_4'];
$NAMEHIS_BECAUSE_1 = $_POST['NAMEHIS_BECAUSE_1'];
$NAMEHIS_BECAUSE_2 = $_POST['NAMEHIS_BECAUSE_2'];
$NAMEHIS_BECAUSE_3 = $_POST['NAMEHIS_BECAUSE_3'];
$NAMEHIS_BECAUSE_4 = $_POST['NAMEHIS_BECAUSE_4'];
$NAMEHIS_BECAUSE_5 = $_POST['NAMEHIS_BECAUSE_5'];
$NAMEHIS_BECAUSE_6 = $_POST['NAMEHIS_BECAUSE_6'];
$NAMEHIS_BECAUSE_7 = $_POST['NAMEHIS_BECAUSE_7'];
$NAMEHIS_BECAUSE_8 = $_POST['NAMEHIS_BECAUSE_8'];
$NAMEHIS_BECAUSE_9 = $_POST['NAMEHIS_BECAUSE_9'];
$NAMEHIS_BECAUSE_10 = $_POST['NAMEHIS_BECAUSE_10'];
$NAMEHIS_BECAUSE_DESC = $_POST['NAMEHIS_BECAUSE_DESC'];
$NAMEHIS_FILE = $_FILES['NAMEHIS_FILE'];
$OLD_NAMEHIS_FILE = $_POST['OLD_NAMEHIS_FILE'];
$NAMEHIS_NOTE = $_POST['NAMEHIS_NOTE'];

for($i=1;$i<=9;$i++){
	${"PROV_ID_".$i} = $_POST['PROV_ID_'.$i];
	${"AMRP_ID_".$i} = $_POST['AMRP_ID_'.$i];
	${"NAMEDESC_NO_".$i} = $_POST['NAMEDESC_NO_'.$i];
	${"NAMEDESC_DATE_".$i} = $_POST['NAMEDESC_DATE_'.$i];
	${"NAMEDESC_FILE_".$i} = $_FILES['NAMEDESC_FILE_'.$i];
}
$NAMEHIS_NEW_PREFIX_ID = $_POST['NAMEHIS_NEW_PREFIX_ID'];
$NAMEHIS_NEW_FIRSTNAME_TH = $_POST['NAMEHIS_NEW_FIRSTNAME_TH'];
$NAMEHIS_NEW_MIDNAME_TH = $_POST['NAMEHIS_NEW_MIDNAME_TH'];
$NAMEHIS_NEW_LASTNAME_TH = $_POST['NAMEHIS_NEW_LASTNAME_TH'];
$NAMEHIS_NEW_FIRSTNAME_EN = $_POST['NAMEHIS_NEW_FIRSTNAME_EN'];
$NAMEHIS_NEW_MIDNAME_EN = $_POST['NAMEHIS_NEW_MIDNAME_EN'];
$NAMEHIS_NEW_LASTNAME_EN = $_POST['NAMEHIS_NEW_LASTNAME_EN'];

$REQUEST_DATETIME = $_POST['REQUEST_DATETIME'];
$REQUEST_RESULT = $_POST['REQUEST_RESULT'];
$REQUEST_APP_DATE = $_POST['REQUEST_APP_DATE'];

$path_a = $path.'fileupload/profile_his/';
$table = "PER_NAMEHIS";
$table2 = "PER_NAMEHIS_DESC";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"PER_ID" => $PER_ID,
				"REQUEST_TABLE_ID" => $TABLE_ID,
				"REQUEST_DATETIME" => conv_date_db($REQUEST_DATETIME),
				"REQUEST_STATUS" => '1',
				"REQUEST_RESULT" => '1',
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" =>$USER_BY,
				"CREATE_DATE"=>$TIMESTAMP,
				"UPDATE_DATE" =>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			);
			$db->db_insert("PER_REQUEST",$fields);
			$REQUEST_ID = $db->get_data_field("select (case when MAX(REQUEST_ID)>0 then MAX(REQUEST_ID) else '0' end) as REQUEST_ID  from PER_REQUEST where PER_ID = '".$PER_ID."' and REQUEST_TABLE_ID = '".$TABLE_ID."' and REQUEST_STATUS = '1' and REQUEST_RESULT = '1' ","REQUEST_ID");
			
			$sql = "SELECT (case when MAX(NAMEHIS_SEQ)>0 then (MAX(NAMEHIS_SEQ)+1) else '1' end) AS NAMEHIS_SEQ FROM PER_NAMEHIS WHERE PER_ID = '".$PER_ID."' ";
			$query = $db->query($sql);
			$data = $db->db_fetch_array($query);
			
			$rec_info = $db->get_data_rec("SELECT PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, PER_FIRSTNAME_EN, PER_MIDNAME_EN, PER_LASTNAME_EN FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."'");
			if($NAMEHIS_BECAUSE_10 == 1){
				$NAMEHIS_BECAUSE_DESC = $NAMEHIS_BECAUSE_DESC;	
			}else{
				$NAMEHIS_BECAUSE_DESC = '';	
			}
			
			$C_NAMEHIS_FILE = 'NULL';
			if(!empty($NAMEHIS_FILE['name'])){
				$C_NAMEHIS_FILE = getFilenameUplaod($NAMEHIS_FILE, $path_a, $OLD_NAMEHIS_FILE);
			}
			
			unset($fields);
			$fields["PER_ID"] = $PER_ID;
			$fields["NAMEHIS_SEQ"] = $data['NAMEHIS_SEQ'];
			$fields["NAMEHIS_CHANGEDATE"] = conv_date_db($NAMEHIS_CHANGEDATE);
			$fields["NAMEHIS_NOTICEDATE"] = conv_date_db($REQUEST_DATETIME);
			$fields["NAMEHIS_DETAIL_1"] = $NAMEHIS_DETAIL_1;
			$fields["NAMEHIS_DETAIL_2"] = $NAMEHIS_DETAIL_2;
			$fields["NAMEHIS_DETAIL_3"] = $NAMEHIS_DETAIL_3;
			$fields["NAMEHIS_DETAIL_4"] = $NAMEHIS_DETAIL_4;
			$fields["NAMEHIS_BECAUSE_1"] = $NAMEHIS_BECAUSE_1;
			$fields["NAMEHIS_BECAUSE_2"] = $NAMEHIS_BECAUSE_2;
			$fields["NAMEHIS_BECAUSE_3"] = $NAMEHIS_BECAUSE_3;
			$fields["NAMEHIS_BECAUSE_4"] = $NAMEHIS_BECAUSE_4;
			$fields["NAMEHIS_BECAUSE_5"] = $NAMEHIS_BECAUSE_5;
			$fields["NAMEHIS_BECAUSE_6"] = $NAMEHIS_BECAUSE_6;
			$fields["NAMEHIS_BECAUSE_7"] = $NAMEHIS_BECAUSE_7;
			$fields["NAMEHIS_BECAUSE_8"] = $NAMEHIS_BECAUSE_8;
			$fields["NAMEHIS_BECAUSE_9"] = $NAMEHIS_BECAUSE_9;
			$fields["NAMEHIS_BECAUSE_10"] = $NAMEHIS_BECAUSE_10;
			$fields["NAMEHIS_BECAUSE_DESC"] = $NAMEHIS_BECAUSE_DESC;
			$fields["NAMEHIS_LAST_PREFIX_ID"] = $rec_info['PREFIX_ID'];
			$fields["NAMEHIS_LAST_FIRSTNAME_TH"] = $rec_info['PER_FIRSTNAME_TH'];
			$fields["NAMEHIS_LAST_MIDNAME_TH"] = $rec_info['PER_MIDNAME_TH'];
			$fields["NAMEHIS_LAST_LASTNAME_TH"] = $rec_info['PER_LASTNAME_TH'];
			$fields["NAMEHIS_LAST_FIRSTNAME_EN"] = $rec_info['PER_FIRSTNAME_EN'];
			$fields["NAMEHIS_LAST_MIDNAME_EN"] = $rec_info['PER_MIDNAME_EN'];
			$fields["NAMEHIS_LAST_LASTNAME_EN"] = $rec_info['PER_LASTNAME_EN'];

			if($NAMEHIS_DETAIL_1 == 1){
				$fields["NAMEHIS_NEW_PREFIX_ID"] = $NAMEHIS_NEW_PREFIX_ID;
			}
			if($NAMEHIS_DETAIL_2 == 1){
				$fields["NAMEHIS_NEW_FIRSTNAME_TH"] = ctext($NAMEHIS_NEW_FIRSTNAME_TH);
				$fields["NAMEHIS_NEW_FIRSTNAME_EN"] = ctext($NAMEHIS_NEW_FIRSTNAME_EN);
			}
			if($NAMEHIS_DETAIL_3 == 1){
				$fields["NAMEHIS_NEW_MIDNAME_TH"] = ctext($NAMEHIS_NEW_MIDNAME_TH);
				$fields["NAMEHIS_NEW_MIDNAME_EN"] = ctext($NAMEHIS_NEW_MIDNAME_EN);
			}
			if($NAMEHIS_DETAIL_4 == 1){
				$fields["NAMEHIS_NEW_LASTNAME_TH"] = ctext($NAMEHIS_NEW_LASTNAME_TH);
				$fields["NAMEHIS_NEW_LASTNAME_EN"] = ctext($NAMEHIS_NEW_LASTNAME_EN);
			}
			$fields["NAMEHIS_NOTE"] = ctext($NAMEHIS_NOTE);
			$fields["NAMEHIS_FILE"] = $C_NAMEHIS_FILE;
			$fields["REQUEST_ID"] = ctext($REQUEST_ID);
			$fields["REQUEST_RESULT"] = '1';
			$fields["REQUEST_STATUS"] = '1';
			$fields["ACTIVE_STATUS"] = 0;
			$fields["CREATE_BY"] = $USER_BY;
			$fields["UPDATE_BY"] = $USER_BY;
			$fields["CREATE_DATE"] = $TIMESTAMP;
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$fields["DELETE_FLAG"] = '0';
			$db->db_insert($table,$fields);
			
			$NAMEHIS_ID = $db->get_data_field("SELECT MAX(NAMEHIS_ID) AS NAMEHIS_ID FROM ".$table." WHERE NAMEHIS_SEQ = '".$data['NAMEHIS_SEQ']."' AND PER_ID = '".$PER_ID."'", "NAMEHIS_ID");
			
			for($i=1;$i<=9;$i++){
				if(${"NAMEHIS_BECAUSE_".$i} == 1){
					
					${"C_NAMEDESC_FILE_".$i} = 'NULL';
					if(!empty(${"NAMEDESC_FILE_".$i}['name'])){
						${"C_NAMEDESC_FILE_".$i} = getFilenameUplaod(${"NAMEDESC_FILE_".$i}, $path_a, ${"OLD_NAMEDESC_FILE_".$i});
					}
					unset($field_desc);
					$field_desc = array(
						"NAMEHIS_ID" => $NAMEHIS_ID,
						"NAMEDESC_TYPE" => $i,
						"PROV_ID" => ${"PROV_ID_".$i},
						"AMRP_ID" => ${"AMRP_ID_".$i},
						"NAMEDESC_NO" => ctext(${"NAMEDESC_NO_".$i}),
						"NAMEDESC_DATE" => conv_date_db(${"NAMEDESC_DATE_".$i}),
						"NAMEDESC_FILE" => ${"C_NAMEDESC_FILE_".$i},
						"CREATE_BY" => $USER_BY,
						"UPDATE_BY" => $USER_BY,
						"CREATE_DATE" => $TIMESTAMP,
						"UPDATE_DATE" => $TIMESTAMP,
					);	
					$db->db_insert($table2, $field_desc);
				}
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "approve" : 
		try{
			if($REQUEST_RESULT == '2'){
				unset($fields);
				$fields = array("ACTIVE_STATUS" => '0');
				$db->db_update($table,$fields," PER_ID = '".$PER_ID."' ");
				
				$rec = $db->get_data_rec("SELECT NAMEHIS_DETAIL_1, NAMEHIS_DETAIL_2, NAMEHIS_DETAIL_3, NAMEHIS_DETAIL_4 FROM PER_NAMEHIS WHERE REQUEST_ID = '".$REQUEST_ID."'");
				unset($fields);
				if($rec['NAMEHIS_DETAIL_1'] == 1){
					$fields["PREFIX_ID"] = $NAMEHIS_NEW_PREFIX_ID;
				}
				if($rec['NAMEHIS_DETAIL_2'] == 1){
					$fields["PER_FIRSTNAME_TH"] = ctext($NAMEHIS_NEW_FIRSTNAME_TH);
					$fields["PER_FIRSTNAME_EN"] = ctext($NAMEHIS_NEW_FIRSTNAME_EN);
				}
				if($rec['NAMEHIS_DETAIL_3'] == 1){
					$fields["PER_MIDNAME_TH"] = ctext($NAMEHIS_NEW_MIDNAME_TH);
					$fields["PER_MIDNAME_EN"] = ctext($NAMEHIS_NEW_MIDNAME_EN);
				}
				if($rec['NAMEHIS_DETAIL_4'] == 1){
					$fields["PER_LASTNAME_TH"] = ctext($NAMEHIS_NEW_LASTNAME_TH);
					$fields["PER_LASTNAME_EN"] = ctext($NAMEHIS_NEW_LASTNAME_EN);
				}
				$db->db_update("PER_PROFILE", $fields, " PER_ID = '".$PER_ID."' "); 
			}
			
			unset($fields);
			$fields = array(
				"REQUEST_STATUS" => '2',
				"REQUEST_RESULT" => ctext($REQUEST_RESULT),
				"ACTIVE_STATUS" => $REQUEST_RESULT == '2'?'1':'0',
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table, $fields," REQUEST_ID = '".$REQUEST_ID."' AND PER_ID = '".$PER_ID."' ");		
			
			unset($fields);
			$fields = array(
				"REQUEST_APP_DATE" => conv_date_db($REQUEST_APP_DATE),
				"REQUEST_STATUS" => '2',
				"REQUEST_RESULT" => ctext($REQUEST_RESULT),
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update("PER_REQUEST", $fields, " REQUEST_ID = '".$REQUEST_ID."' ");
			$text="บันทึกการเปลี่ยนแปลงประวัติเรียบร้อย";
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," REQUEST_ID = '".$REQUEST_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_approvehis.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
