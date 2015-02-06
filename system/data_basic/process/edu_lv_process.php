<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$EL_ID=$_POST['EL_ID'];
$EL_NAME_TH=trim($_POST['EL_NAME_TH']);
$EL_NAME_EN=trim($_POST['EL_NAME_EN']);
$EL_SHORTNAME_TH=trim($_POST['EL_SHORTNAME_TH']);
$EL_SHORTNAME_EN=trim($_POST['EL_SHORTNAME_EN']);
$EL_TYPE=$_POST['EL_TYPE'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];


$url_back="../edu_lv.php";
$table="SETUP_EDU_LEVEL";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"EL_NAME_TH" => ctext($EL_NAME_TH),
				"EL_NAME_EN" => strtoupper(ctext($EL_NAME_EN)),
				"EL_SHORTNAME_TH" => ctext($EL_SHORTNAME_TH),
				"EL_SHORTNAME_EN" => strtoupper(ctext($EL_SHORTNAME_EN)),
				"EL_TYPE" => $EL_TYPE,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"DELETE_FLAG" => '0',
				"CREATE_BY" => ctext($USER_BY),
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => ctext($USER_BY),
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
				"EL_NAME_TH" => ctext($EL_NAME_TH),
				"EL_NAME_EN" => strtoupper(ctext($EL_NAME_EN)),
				"EL_SHORTNAME_TH" => ctext($EL_SHORTNAME_TH),
				"EL_SHORTNAME_EN" => strtoupper(ctext($EL_SHORTNAME_EN)),
				"EL_TYPE" => $EL_TYPE,
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," EL_ID = '".$EL_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," EL_ID = '".$EL_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($EL_ID != ""){
			$filter = " and EL_ID != '".$EL_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where EL_NAME_TH = '".ctext($EL_NAME_TH)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($EL_ID != ""){
			$filter = " and EL_ID != '".$EL_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where EL_NAME_EN = '".ctext($EL_NAME_EN)."' {$filter} ","nums");
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