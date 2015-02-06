<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$INS_ID=$_POST['INS_ID'];
$INS_NAME_TH=trim($_POST['INS_NAME_TH']);
$INS_NAME_EN=trim($_POST['INS_NAME_EN']);
$INS_TYPE=trim($_POST['INS_TYPE']);
$PROV_ID=trim($_POST['PROV_ID']);
$COUNTRY_ID=trim($_POST['COUNTRY_ID']);
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];
$INS_DEGREE=trim($_POST['INS_DEGREE']);

$url_back="../edu_ins.php";
$table="SETUP_EDU_INSTITUTE";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"INS_NAME_TH" => ctext($INS_NAME_TH),
				"INS_NAME_EN" => strtoupper(ctext($INS_NAME_EN)),
				"INS_TYPE" => ctext($INS_TYPE),
				"PROV_ID" => ctext($PROV_ID),
				"COUNTRY_ID" => ctext($COUNTRY_ID),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
				"INS_DEGREE" => $INS_DEGREE,
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
				"INS_NAME_TH" => ctext($INS_NAME_TH),
				"INS_NAME_EN" => strtoupper(ctext($INS_NAME_EN)),
				"INS_TYPE" => ctext($INS_TYPE),
				"PROV_ID" => ctext($PROV_ID),
				"COUNTRY_ID" => ctext($COUNTRY_ID),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
				"INS_DEGREE" => $INS_DEGREE,
			);	
			$db->db_update($table,$fields," INS_ID = '".$INS_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," INS_ID = '".$INS_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($INS_ID != ""){
			$filter = " and INS_ID != '".$INS_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where INS_NAME_TH = '".ctext($INS_NAME_TH)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($INS_ID != ""){
			$filter = " and INS_ID != '".$INS_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where INS_NAME_EN = '".ctext($INS_NAME_EN)."' {$filter} ","nums");
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