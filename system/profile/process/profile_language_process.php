<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
$COUNTRY_ID=$_POST['COUNTRY_ID'];

$LANGHIS_DATE = conv_date_db($_POST['LANGHIS_DATE_1']);
$LANGHIS_LISTEN=$_POST['LANGHIS_LISTEN'];
$LANGHIS_SPEAKING=$_POST['LANGHIS_SPEAKING'];
$LANGHIS_READING=$_POST['LANGHIS_READING'];
$LANGHIS_WRITING=$_POST['LANGHIS_WRITING'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="PER_LANGUAGE";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"PER_ID" => $PER_ID,
				"LANG_ID"=>ctext($COUNTRY_ID),
				"LANGHIS_DATE" =>$LANGHIS_DATE,
				"LANGHIS_LISTEN" =>$LANGHIS_LISTEN,
				"LANGHIS_SPEAKING" =>$LANGHIS_SPEAKING,
				"LANGHIS_READING"=> $LANGHIS_READING,
				"LANGHIS_WRITING" =>$LANGHIS_WRITING,
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
				"LANG_ID"=>$COUNTRY_ID,
				"LANGHIS_DATE" =>$LANGHIS_DATE,
				"LANGHIS_LISTEN" =>$LANGHIS_LISTEN,
				"LANGHIS_SPEAKING" =>$LANGHIS_SPEAKING,
				"LANGHIS_READING"=> $LANGHIS_READING,
				"LANGHIS_WRITING" =>$LANGHIS_WRITING,					
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" =>$USER_BY,
				"CREATE_DATE"=>$TIMESTAMP,
				"UPDATE_DATE" =>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			);
			$db->db_update($table,$fields," LANGHIS_ID = '".$LANGHIS_ID."' "); 
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," LANGHIS_ID = '".$LANGHIS_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_language_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
