<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$TYPE_NAME_TH=$_POST['TYPE_NAME_TH'];
$TYPE_SEQ = $_POST['TYPE_SEQ'];
$TYPE_NAME_EN=$_POST['TYPE_NAME_EN'];
$TYPE_SHORTNAME_TH=$_POST['TYPE_SHORTNAME_TH'];
$TYPE_SHORTNAME_EN=$_POST['TYPE_SHORTNAME_EN'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="SETUP_POS_TYPE";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					"POSTYPE_ID"=>'5',
					"TYPE_NAME_TH"=>ctext($TYPE_NAME_TH),
					"TYPE_SEQ" => $TYPE_SEQ, 
					"TYPE_NAME_EN"=>ctext($TYPE_NAME_EN),
					"TYPE_SHORTNAME_TH"=>ctext($TYPE_SHORTNAME_TH),
					"TYPE_SHORTNAME_EN"=>ctext($TYPE_SHORTNAME_EN),
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
				"TYPE_NAME_TH"=>ctext($TYPE_NAME_TH),
				"TYPE_SEQ" => $TYPE_SEQ, 
				"TYPE_NAME_EN"=>ctext($TYPE_NAME_EN),
				"TYPE_SHORTNAME_TH"=>ctext($TYPE_SHORTNAME_TH),
				"TYPE_SHORTNAME_EN"=>ctext($TYPE_SHORTNAME_EN),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" =>$USER_BY,
				"UPDATE_DATE" =>$TIMESTAMP,
				);
			$db->db_update($table,$fields," TYPE_ID = '".$TYPE_ID."' "); 
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
			$db->db_update($table,$fields," TYPE_ID = '".$TYPE_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../pos_type_setup_disp.php";
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
