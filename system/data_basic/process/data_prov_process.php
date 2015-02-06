<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PROV_ID=$_POST['PROV_ID'];
$PROV_TH_NAME=trim($_POST['PROV_TH_NAME']);
$PROV_EN_NAME=trim($_POST['PROV_EN_NAME']);
$ZONE_ID=$_POST['ZONE_ID'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$url_back="../data_prov.php";
$table="SETUP_PROV";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"PROV_TH_NAME" => ctext($PROV_TH_NAME),
				"PROV_EN_NAME" => strtoupper(ctext($PROV_EN_NAME)),
				"ZONE_ID" => ctext($ZONE_ID),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
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
				"PROV_TH_NAME" => ctext($PROV_TH_NAME),
				"PROV_EN_NAME" => strtoupper(ctext($PROV_EN_NAME)),
				"ZONE_ID" => ctext($ZONE_ID),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," PROV_ID = '".$PROV_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," PROV_ID = '".$PROV_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($PROV_ID != ""){
			$filter = " and PROV_ID != '".$PROV_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where PROV_TH_NAME = '".ctext($PROV_TH_NAME)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($PROV_ID != ""){
			$filter = " and PROV_ID != '".$PROV_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where PROV_EN_NAME = '".ctext($PROV_EN_NAME)."' {$filter} ","nums");
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
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>