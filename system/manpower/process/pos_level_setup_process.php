<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$TYPE_ID=$_POST['TYPE_ID'];
$LEVEL_NAME_TH=$_POST['LEVEL_NAME_TH'];
$LEVEL_NAME_EN=$_POST['LEVEL_NAME_EN'];
$LEVEL_SHORTNAME_TH=$_POST['LEVEL_SHORTNAME_TH'];
$LEVEL_SHORTNAME_EN=$_POST['LEVEL_SHORTNAME_EN'];
$GROUP = $_POST['GROUP'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="SETUP_POS_LEVEL";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					"POSTYPE_ID"=>'5',
					"TYPE_ID"=>$TYPE_ID,
					"LEVEL_SEQ" => $GROUP,
					"LEVEL_NAME_TH"=>ctext($LEVEL_NAME_TH),
					"LEVEL_NAME_EN"=>ctext($LEVEL_NAME_EN),
					"LEVEL_SHORTNAME_TH"=>ctext($LEVEL_SHORTNAME_TH),
					"LEVEL_SHORTNAME_EN"=>ctext($LEVEL_SHORTNAME_EN),
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
				"TYPE_ID"=>$TYPE_ID,
				"LEVEL_SEQ" => $GROUP,
				"LEVEL_NAME_TH"=>ctext($LEVEL_NAME_TH),
				"LEVEL_NAME_EN"=>ctext($LEVEL_NAME_EN),
				"LEVEL_SHORTNAME_TH"=>ctext($LEVEL_SHORTNAME_TH),
				"LEVEL_SHORTNAME_EN"=>ctext($LEVEL_SHORTNAME_EN),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" =>$USER_BY,
				"UPDATE_DATE" =>$TIMESTAMP,
				);
			$db->db_update($table,$fields," LEVEL_ID = '".$LEVEL_ID."' "); 
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
			$db->db_update($table,$fields," LEVEL_ID = '".$LEVEL_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../pos_level_setup_disp.php";
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
