<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$NATION_ID=$_POST['NATION_ID'];
$NATION_NAME_TH=trim($_POST['NATION_NAME_TH']);
$NATION_NAME_EN=trim($_POST['NATION_NAME_EN']);
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];


$url_back="../data_nation.php";
$table="SETUP_NATION";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"NATION_NAME_TH" => ctext($NATION_NAME_TH),
				"NATION_NAME_EN" => strtoupper(ctext($NATION_NAME_EN)),
				
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
				"NATION_NAME_TH" => ctext($NATION_NAME_TH),
				"NATION_NAME_EN" => strtoupper(ctext($NATION_NAME_EN)),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," NATION_ID = '".$NATION_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," NATION_ID = '".$NATION_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($NATION_ID != ""){
			$filter = " and NATION_ID != '".$NATION_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where NATION_NAME_TH = '".ctext($NATION_NAME_TH)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($NATION_ID != ""){
			$filter = " and NATION_ID != '".$NATION_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where NATION_NAME_EN = '".ctext($NATION_NAME_EN)."' {$filter} ","nums");
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