<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$TYPE_ID=$_POST['TYPE_ID'];
$LG_ID = $_POST['LG_ID'];
$LINE_NAME_TH=$_POST['LINE_NAME_TH'];
$LINE_NAME_EN=$_POST['LINE_NAME_EN'];
$LINE_SHORTNAME_TH=$_POST['LINE_SHORTNAME_TH'];
$LINE_SHORTNAME_EN=$_POST['LINE_SHORTNAME_EN'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="SETUP_POS_LINE";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					"POSTYPE_ID"=>'5',
					"TYPE_ID" =>$_POST['TYPE_ID'],
					"LG_ID" => $_POST['LG_ID'],
					"LINE_NAME_TH"=>ctext($LINE_NAME_TH),
					"LINE_NAME_EN"=>ctext($LINE_NAME_EN),
					"LINE_SHORTNAME_TH"=>ctext($LINE_SHORTNAME_TH),
					"LINE_SHORTNAME_EN"=>ctext($LINE_SHORTNAME_EN),
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
					$db->db_insert($table,$fields);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			unset($fields);
				$fields = array(
				"TYPE_ID" =>$_POST['TYPE_ID'],
				"LG_ID" => $_POST['LG_ID'],
				"LINE_NAME_TH"=>ctext($LINE_NAME_TH),
				"LINE_NAME_EN"=>ctext($LINE_NAME_EN),
				"LINE_SHORTNAME_TH"=>ctext($LINE_SHORTNAME_TH),
				"LINE_SHORTNAME_EN"=>ctext($LINE_SHORTNAME_EN),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" =>$USER_BY,
				"UPDATE_DATE" =>$TIMESTAMP,
				);
			$db->db_update($table,$fields," LINE_ID = '".$LINE_ID."' "); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
		unset($fields);
				$fields = array(
				"DELETE_FLAG"=>'1'
				);
			$db->db_update($table,$fields," LINE_ID = '".$LINE_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
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
		exit;
	break;
}
$url_back="../pos_line_setup_temporary_disp.php";
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
