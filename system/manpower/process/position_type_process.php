<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$POSTYPE_ID=$_POST['POSTYPE_ID'];
$POSTYPE_NAME_TH=trim($_POST['POSTYPE_NAME_TH']);
$POSTYPE_NAME_EN=trim($_POST['POSTYPE_NAME_EN']);
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$url_back="../position_type_disp.php";
$table="SETUP_POSITION_TYPE ";

switch($proc){
	case "add" : 
		try{
			$fields = array(
						   "POSTYPE_NAME_TH" => ctext($POSTYPE_NAME_TH),
						   "POSTYPE_NAME_EN" => ctext($POSTYPE_NAME_EN),
						   "ACTIVE_BY" => $ACTIVE_STATUS,
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
						   "POSTYPE_NAME_TH" => ctext($POSTYPE_NAME_TH),
						   "POSTYPE_NAME_EN" => ctext($POSTYPE_NAME_EN),
						   "ACTIVE_BY" => $ACTIVE_STATUS,
						   "CREATE_BY" =>ctext($USER_BY),
						   "UPDATE_BY" =>ctext($USER_BY),
						   "CREATE_DATE" => $TIMESTAMP,
						   "UPDATE_DATE" => $TIMESTAMP,
						   "DELETE_FLAG" => '0'
						   );		
			$db->db_update($table,$fields," POSTYPE_ID = '".$POSTYPE_ID."' "); //unset($fields);
			
			
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
			$db->db_update($table,$fields," POSTYPE_ID = '".$POSTYPE_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($POSTYPE_NAME_TH != ""){
			$filter = " and POSTYPE_ID != '".$POSTYPE_ID ."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where POSTYPE_NAME_TH = '".ctext($POSTYPE_NAME_TH)."' {$filter} ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
					 );
		echo json_encode($arr);
	break;
	
	case "chk_dup2" : 
	
		$filter = "";
		if($POSTYPE_NAME_EN != ""){
			$filter = " and POSTYPE_ID != '".$POSTYPE_ID."' ";
		}
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where POSTYPE_NAME_EN = '".ctext($POSTYPE_NAME_EN)."' {$filter} ","nums");
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
    <input name="LINE_ID" type="hidden" id="LINE_ID" value="<?php echo $LINE_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>