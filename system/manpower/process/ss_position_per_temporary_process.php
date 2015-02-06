<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$url_back = "../ss_position_per_temporary_disp.php";

$TB = "POSITION_FRAME";

$REMARK_ID = $_POST['REMARK_ID'];
$REMARK_DETAIL = ctext($_POST['REMARK_DETAIL']);
$MAN_BDG_ID = $_POST['MAN_BDG_ID'];
$CANCEL_POS_DATE = conv_date_db($_POST['CANCEL_POS_DATE']);
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
					"POSTYPE_ID" => 17,
					"POS_NO" => $POS_NO,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LG_ID" => $LG_ID,
					"LINE_ID" => $LINE_ID,
					"ORG_ID_2" => 15,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,				
					"REMARK_ID" => $REMARK_ID,
					"REMARK_DETAIL" => $REMARK_DETAIL,
					"MAN_BDG_ID" => $MAN_BDG_ID,
					"CANCEL_POS_DATE" => $CANCEL_POS_DATE,
					"POS_DATE_SALARY" => conv_date_db($POS_DATE_SALARY),
					"POS_DATE_EFFECTIVE" => conv_date_db($POS_DATE_EFFECTIVE),
					"POS_FRAME_SALARY" => str_replace(',','',$POS_FRAME_SALARY),
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
					"POSTYPE_ID" => 17,
					"POS_NO" => $POS_NO,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LG_ID" => $LG_ID,
					"LINE_ID" => $LINE_ID,
					"ORG_ID_2" => 15,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,										
					"REMARK_ID" => $REMARK_ID,
					"REMARK_DETAIL" => $REMARK_DETAIL,
					"MAN_BDG_ID" => $MAN_BDG_ID,
					"CANCEL_POS_DATE" => $CANCEL_POS_DATE,
					"POS_DATE_SALARY" => conv_date_db($POS_DATE_SALARY),
					"POS_DATE_EFFECTIVE" => conv_date_db($POS_DATE_EFFECTIVE),
					"POS_FRAME_SALARY" => str_replace(',','',$POS_FRAME_SALARY),
					"POS_STATUS" => $POS_STATUS,
					"POS_STATUS_REQUEST" => $POS_STATUS_REQUEST,
					"ACTIVE_STATUS" => 1,
					"DELETE_FLAG" => 0,
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
	break;
	
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LG_ID = '".$lg_id."' AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}break;
	case "get_org_4" : {
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_parent_id."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"S_ORG_ID_4\" name=\"S_ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
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