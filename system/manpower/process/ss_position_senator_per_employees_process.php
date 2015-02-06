<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$url_back = "../ss_position_senator_per_employees_disp.php";

$TB = "POSITION_FRAME";
$REMARK_ID = $_POST['REMARK_ID'];
$REMARK_DETAIL = ctext($_POST['REMARK_DETAIL']);

//ไฟล
$POS_FILE=$_FILES["POS_FILE"];
$OLD_FILE_PIC =$_POST['OLD_FILE_PIC'];
//$path_a = '../fileupload/profile_his/';
$path_img=$path.'fileupload/file_position_frame/';

switch($proc){
	case "add" : {
		try{
			unset($fields);
			$V_FILE_PIC='NULL';
			if($POS_FILE['name']!=''||$POS_FILE['name']!=NULL){
				$V_FILE_PIC=getFilenameUplaod($POS_FILE,$path_img,$OLD_FILE_PIC);
			}
			$fields = array(
				"POS_FILE" => $V_FILE_PIC,
					"POSTYPE_ID" => 3,
					"POS_NO" => $POS_NO,
					"POS_YEAR" => $POS_YEAR,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LINE_ID" => $LINE_ID,
					"ORG_ID_2" => 16,
					"ORG_ID_3" => $ORG_ID_3,
					"REMARK_ID" => $REMARK_ID,
					"REMARK_DETAIL" => $REMARK_DETAIL,
					"POS_FRAME_SALARY" => str_replace(',','',$POS_FRAME_SALARY),
					"POS_DATE_EFFECTIVE" => conv_date_db($POS_DATE_EFFECTIVE),
					"POS_DATE_SALARY" => conv_date_db($POS_DATE_SALARY),
					"POS_STATUS" => $POS_STATUS,
					"POS_STATUS_REQUEST" => $POS_STATUS_REQUEST,
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" =>$USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => 0,
				);	
			
			$db->db_insert($TB,$fields);
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}break;
	case "edit" : {
		try{
			$V_FILE_PIC=getFilenameUplaod($POS_FILE,$path_img,$OLD_FILE_PIC);
			$fields = array(
					"POS_FILE" => $V_FILE_PIC,
					"POSTYPE_ID" => 3,
					"POS_NO" => $POS_NO,
					"POS_YEAR" => $POS_YEAR,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LINE_ID" => $LINE_ID,
					"ORG_ID_2" => 16,
					"ORG_ID_3" => $ORG_ID_3,
					"REMARK_ID" => $REMARK_ID,
					"REMARK_DETAIL" => $REMARK_DETAIL,
					"POS_FRAME_SALARY" => str_replace(',','',$POS_FRAME_SALARY),
					"POS_DATE_EFFECTIVE" => conv_date_db($POS_DATE_EFFECTIVE),
					"POS_DATE_SALARY" => conv_date_db($POS_DATE_SALARY),
					"POS_STATUS" => $POS_STATUS,
					"POS_STATUS_REQUEST" => $POS_STATUS_REQUEST,
					"UPDATE_BY" =>$USER_BY, 
					"UPDATE_DATE" => $TIMESTAMP, 
				);
			
			$db->db_update($TB,$fields," POS_ID = '".$POS_ID."' ");
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}break;
	case "delete" : {
		try{	
		unset($fields);
				$fields = array(
				"DELETE_FLAG"=>'1'
				);
			$db->db_update($TB,$fields," POS_ID = '".$POS_ID."' ");
			
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
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
	 }
	break;
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LEVEL_ID = '".$level_id."'  AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}break;
	
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name='form_back' method="post" action="<?php echo $url_back; ?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>" />
    <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>" />
    <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id ?>" />
</form>
<script>
	alert('<?php echo $text; ?>');
	form_back.submit();
</script>
<?php }?>