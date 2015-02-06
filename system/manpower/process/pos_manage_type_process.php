<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$MT_ID=$_POST['MT_ID'];
$MT_TYPE = $_POST['MT_TYPE'];
$MT_NAME_TH=trim($_POST['MT_NAME_TH']);
$MT_SHORTNAME_TH = trim($_POST['MT_SHORTNAME_TH']);
$MT_NAME_EN = trim($_POST['MT_NAME_EN']);
$MT_SHORTNAME_EN = trim($_POST['MT_SHORTNAME_EN']);
$MT_SEQ = trim($_POST['MT_SEQ']);
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];

$url_back="../pos_manage_type_disp.php";
$table="SETUP_POS_MANAGE_TYPE ";

switch($proc){
	case "add" : 
		try{
			$fields = array(
						   "MT_NAME_TH" => ctext($MT_NAME_TH),
						   "MT_TYPE" => $MT_TYPE,
						   "MT_NAME_EN" => ctext($MT_NAME_EN),
						   "MT_SHORTNAME_TH" => ctext($MT_SHORTNAME_TH),
						   "MT_SHORTNAME_EN" => ctext($MT_SHORTNAME_EN),
						   "MT_SEQ" => $MT_SEQ,
						   "ACTIVE_STATUS" => $ACTIVE_STATUS,
						   "CREATE_BY" =>ctext($USER_BY),
						   "CREATE_DATE" => $TIMESTAMP,
						   "DELETE_FLAG" => '0'
						   );	
			$db->db_insert($table,$fields);
			
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
					 "MT_NAME_TH" => ctext($MT_NAME_TH),
					 "MT_TYPE" => $MT_TYPE,
					 "MT_NAME_EN" => ctext($MT_NAME_EN),
					 "MT_SHORTNAME_TH" => ctext($MT_SHORTNAME_TH),
					 "MT_SHORTNAME_EN" => ctext($MT_SHORTNAME_EN),
					 "MT_SEQ" => $MT_SEQ,
					 "ACTIVE_STATUS" => $ACTIVE_STATUS,
					 "UPDATE_BY" =>ctext($USER_BY),
					 "UPDATE_DATE" => $TIMESTAMP,
					 "DELETE_FLAG" => '0'
					 );		
			$db->db_update($table,$fields," MT_ID = '".$MT_ID."' "); //unset($fields);
			
			
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
			$db->db_update($table,$fields," MT_ID = '".$MT_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input name="MT_ID" type="hidden" id="MT_ID" value="<?php echo $MT_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>