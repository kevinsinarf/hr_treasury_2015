<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$OL_SEQ=$_POST['OL_SEQ'];
$OL_NAME_TH=$_POST['OL_NAME_TH'];
$OL_NAME_EN=$_POST['OL_NAME_EN'];
$OL_TYPE=$_POST['OL_TYPE'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="SETUP_ORG_LEVEL";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					"OL_SEQ"=>$OL_SEQ,
					"OL_NAME_TH"=>ctext($OL_NAME_TH),
					"OL_NAME_EN"=>ctext($OL_NAME_EN),
					"OL_TYPE"=>ctext($OL_TYPE),
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
					"OL_SEQ"=>ctext($OL_SEQ),
					"OL_NAME_TH"=>ctext($OL_NAME_TH),
					"OL_NAME_EN"=>ctext($OL_NAME_EN),
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"OL_TYPE"=>ctext($OL_TYPE),
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
					);
				    $db->db_update($table,$fields," OL_ID = '".$OL_ID."' "); 
					
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
			$db->db_update($table,$fields," OL_ID = '".$OL_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../setup_org_level_disp.php";
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
