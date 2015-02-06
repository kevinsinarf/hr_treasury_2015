<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$MULTIME_ID=$_POST['MULTIME_ID'];
$MULTIME_NAME_TH=trim($_POST['MULTIME_NAME_TH']);
$MULTIME_NAME_EN=trim($_POST['MULTIME_NAME_EN']);
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];
$MULTITIME_DAY =(int)$_POST['MULTITIME_DAY'];
$MULTITIME_MONTH =(int)$_POST['MULTITIME_MONTH'];
$MULTITIME_YEAR =(int)$_POST['MULTITIME_YEAR'];



$url_back="../data_multitime.php";
$table="SETUP_MULTITIME";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"MULTIME_NAME_TH" => ctext($MULTIME_NAME_TH),
				"MULTIME_NAME_EN" => strtoupper(ctext($MULTIME_NAME_EN)),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"MULTITIME_DAY"=>$MULTITIME_DAY,
				"MULTITIME_MONTH"=>$MULTITIME_MONTH,				
				"MULTITIME_YEAR"=>$MULTITIME_YEAR,
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
				"MULTIME_NAME_TH" => ctext($MULTIME_NAME_TH),
				"MULTIME_NAME_EN" => strtoupper(ctext($MULTIME_NAME_EN)),
				"MULTITIME_DAY"=>$MULTITIME_DAY,
				"MULTITIME_MONTH"=>$MULTITIME_MONTH,				
				"MULTITIME_YEAR"=>$MULTITIME_YEAR,				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," MULTIME_ID = '".$MULTIME_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," MULTIME_ID = '".$MULTIME_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($MULTIME_ID != ""){
			$filter = " and MULTIME_ID != '".$MULTIME_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where MULTIME_NAME_TH = '".ctext($MULTIME_NAME_TH)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($MULTIME_ID != ""){
			$filter = " and MULTIME_ID != '".$MULTIME_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where MULTIME_NAME_EN = '".ctext($MULTIME_NAME_EN)."' {$filter} ","nums");
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