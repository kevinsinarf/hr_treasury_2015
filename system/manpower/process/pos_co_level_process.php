<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$CO_ID=$_POST['CO_ID'];
$CO_CODE=$_POST['CO_CODE'];
$TYPE_ID=$_POST['TYPE_ID'];
$LEVEL_ID_MIN=$_POST['LEVEL_ID_MIN'];
$LEVEL_ID_MAX=$_POST['LEVEL_ID_MAX'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$url_back="../pos_co_level_disp.php";
$table = "SETUP_POS_CO_LEVEL";
switch($proc){
	case "add" :
		try{
			$fields = array(
						   "CO_CODE" => $CO_CODE,
						   "TYPE_ID" => $TYPE_ID,
						   "LEVEL_ID_MIN" => $LEVEL_ID_MIN,
						   "LEVEL_ID_MAX" => $LEVEL_ID_MAX,
						   "ACTIVE_STATUS" => $ACTIVE_STATUS,
						   "CREATE_BY" => ctext($USER_BY),
						   "UPDATE_BY" => ctext($USER_BY),
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
						   "CO_CODE" => $CO_CODE,
						   "TYPE_ID" => $TYPE_ID,
						   "LEVEL_ID_MIN" => $LEVEL_ID_MIN,
						   "LEVEL_ID_MAX" => $LEVEL_ID_MAX,
						   "ACTIVE_STATUS" => $ACTIVE_STATUS,
						   "CREATE_BY" => ctext($USER_BY),
						   "UPDATE_BY" => ctext($USER_BY),
						   "CREATE_DATE" => $TIMESTAMP,
						   "UPDATE_DATE" => $TIMESTAMP,
						   "DELETE_FLAG" => '0'
						   );		
			$db->db_update($table,$fields," CO_ID = '".$CO_ID."' "); //unset($fields);
			
			
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
			$db->db_update($table,$fields," CO_ID = '".$CO_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup" : 
	
		$filter = "";
		if($aut_user_id != ""){
			$filter = " and aut_user_id != '".$aut_user_id."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from aut_user where aut_username = '".ctext($username)."' $filter ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ username นี้ได้":"ไม่สามารถใช้ username นี้ได้",
					 );
		echo json_encode($arr);
	break;
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input name="CO_ID" type="hidden" id="CO_ID" value="<?php echo $CO_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>