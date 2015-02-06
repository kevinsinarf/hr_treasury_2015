<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$COMPEN_ID=$_POST['COMPEN_ID'];
$url_back="../pos_compensation_disp.php";
$table="SETUP_POS_COMPENSATION ";

switch($proc){
	case "add" : 
		try{
			$fields = array(
							"COMPEN_CODE" => ctext($COMPEN_CODE),
							"COMPEN_TITLE" => ctext($COMPEN_TITLE),
							"LEVEL_ID" => ctext($LEVEL_ID),
							"LINE_ID" => ctext($LINE_ID),
							"COMPEN_YEAR" => ctext($COMPEN_YEAR),
							"COMPEN_MANAGE_STATUS" => ctext($COMPEN_MANAGE_STATUS),
							"COMPEN_SALARY_POSITION" => ctext($COMPEN_SALARY_POSITION),
							"COMPEN_COMPENSATION_1" => ctext($COMPEN_COMPENSATION_1),
							"COMPEN_COMPENSATION_2" => ctext($COMPEN_COMPENSATION_2),
							"COMPEN_FOR" => ctext($COMPEN_FOR),
							"ACTIVE_STATUS" => $ACTIVE_STATUS,
							"CREATE_BY" =>ctext($USER_BY),
							"UPDATE_BY" =>ctext($USER_BY),
							"CREATE_DATE" => $TIMESTAMP,
							"UPDATE_DATE" => $TIMESTAMP,
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
							"COMPEN_CODE" => ctext($COMPEN_CODE),
							"COMPEN_TITLE" => ctext($COMPEN_TITLE),
							"LEVEL_ID" => ctext($LEVEL_ID),
							"LINE_ID" => ctext($LINE_ID),
							"COMPEN_YEAR" => ctext($COMPEN_YEAR),
							"COMPEN_MANAGE_STATUS" => ctext($COMPEN_MANAGE_STATUS),
							"COMPEN_SALARY_POSITION" => ctext($COMPEN_SALARY_POSITION),
							"COMPEN_COMPENSATION_1" => ctext($COMPEN_COMPENSATION_1),
							"COMPEN_COMPENSATION_2" => ctext($COMPEN_COMPENSATION_2),
							"COMPEN_FOR" => ctext($COMPEN_FOR),
							"ACTIVE_STATUS" => $ACTIVE_STATUS,
							"CREATE_BY" =>ctext($USER_BY),
							"UPDATE_BY" =>ctext($USER_BY),
							"CREATE_DATE" => $TIMESTAMP,
							"UPDATE_DATE" => $TIMESTAMP,
							"DELETE_FLAG" => '0'
						   );		
			$db->db_update($table,$fields," COMPEN_ID = '".$COMPEN_ID."' "); //unset($fields);
			
			
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
			$db->db_update($table,$fields," COMPEN_ID = '".$COMPEN_ID."' ");
			
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
    <input name="COMPEN_ID" type="hidden" id="COMPEN_ID" value="<?php echo $COMPEN_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>