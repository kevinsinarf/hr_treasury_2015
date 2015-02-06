<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_POST['proc'];
$MOVEMENT_ID=$_POST['MOVEMENT_ID'];
$MOVEMENT_OTHER_TH=ctext($_POST['MOVEMENT_OTHER_TH']);
$MOVEMENT_OTHER_EN=$_POST['MOVEMENT_OTHER_EN'];
$MOVEMENT_GROUP = $_POST['MOVEMENT_GROUP'];
$MOVEMENT_TYPE = $_POST['MOVEMENT_TYPE'];
$MOVE_PROCESS_ID = $_POST['MOVE_PROCESS_ID'];

if($proc=='edit'){
	$url_back="../data_profile_history_form.php";
}else{
	$url_back="../data_profile_history_disp.php";
}
$table="SETUP_MOVEMENT";

switch($proc){
	case "edit" : 
		try{
			unset($fields);
			$fields = array(
				"MOVEMENT_OTHER_TH" => $MOVEMENT_OTHER_TH,
				"MOVEMENT_OTHER_EN" => $MOVEMENT_OTHER_EN,
				"MOVEMENT_GROUP" => $MOVEMENT_GROUP,
				"MOVEMENT_TYPE" => $MOVEMENT_TYPE,
				"MOVE_PROCESS_ID" => $MOVE_PROCESS_ID,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," MOVEMENT_ID = '".$MOVEMENT_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
		unset($fields);
			$fields = array(
				"DELETE_FLAG" => 1,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
				);
			$db->db_update($table,$fields," MOVEMENT_ID = '".$MOVEMENT_ID."' "); 
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "getProcess":
		$sql = "SELECT MOVE_PROCESS_ID , MOVE_PROCESS_NAME FROM SETUP_MOVEMENT_PROCESS WHERE MOVE_PROCESS_GROUP = '".$MOVE_PROCESS_GROUP."' AND DELETE_FLAG = 0 ";
		$query = $db->query($sql);
		$obj = array();
		while($rec=$db->db_fetch_array($query)){
				$row['id'] = $rec['MOVE_PROCESS_ID'];
				$row['value'] = text($rec['MOVE_PROCESS_NAME']);
				array_push($obj,$row);
		}
		echo json_encode($obj);
		exit();

	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($COUNTRY_ID != ""){
			$filter = " and COUNTRY_ID != '".$COUNTRY_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where COUNTRY_NAME_TH = '".ctext($COUNTRY_NAME_TH)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($COUNTRY_ID != ""){
			$filter = " and COUNTRY_ID != '".$COUNTRY_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where COUNTRY_NAME_EN = '".ctext($COUNTRY_NAME_EN)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
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
    <input type="hidden" id="MOVEMENT_ID" name="MOVEMENT_ID" value="<?php echo $MOVEMENT_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php } ?>