<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$LG_ID=$_POST['LG_ID'];

$LG_NAME_TH=trim($_POST['LG_NAME_TH']);
$LG_NAME_EN=trim($_POST['LG_NAME_EN']);

$LG_SHORTNAME_TH=trim($_POST['LG_SHORTNAME_TH']);
$LG_SHORTNAME_EN=trim($_POST['LG_SHORTNAME_EN']);

$POSTYPE_ID=trim($_POST['POSTYPE_ID']);
$TYPE_ID=trim($_POST['TYPE_ID']);


$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];
/*echo'<pre>';
echo print_r($_POST);
echo'</pre>';*/

$url_back="../pos_line_group_emp_disp.php";
$table="SETUP_POS_LINE_GROUP";

switch($proc){
	case "add" : 
		try{
			$fields = array(
			"LG_NAME_TH" => ctext($LG_NAME_TH),
			"LG_NAME_EN" => ctext($LG_NAME_EN),
			"LG_SHORTNAME_TH" => ctext($LG_SHORTNAME_TH),
			"LG_SHORTNAME_EN" => ctext($LG_SHORTNAME_EN),
			"POSTYPE_ID" => '5',
			"TYPE_ID" => $TYPE_ID,
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
						   "LG_NAME_TH" => ctext($LG_NAME_TH),
						   "LG_NAME_EN" => ctext($LG_NAME_EN),
						   "LG_SHORTNAME_TH" => ctext($LG_SHORTNAME_TH),
						   "LG_SHORTNAME_EN" => ctext($LG_SHORTNAME_EN),
						   "POSTYPE_ID" => '5',
						   "TYPE_ID" => $TYPE_ID,
						   "ACTIVE_STATUS" => $ACTIVE_STATUS,
						   "CREATE_BY" =>ctext($USER_BY),
						   "UPDATE_BY" =>ctext($USER_BY),
						   "CREATE_DATE" => $TIMESTAMP,
						   "UPDATE_DATE" => $TIMESTAMP,
						   );		
			$db->db_update($table,$fields," LG_ID = '".$LG_ID."' "); //unset($fields);
			
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
			$db->db_update($table,$fields," LG_ID = '".$LG_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($LG_NAME_TH != ""){
			$filter = " and LEVEL_ID != '".$LEVEL_ID ."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where LG_NAME_TH = '".ctext($LG_NAME_TH)."' {$filter} ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
					 );
		echo json_encode($arr);
	break;
	
	case "chk_dup2" : 
	
		$filter = "";
		if($LG_NAME_EN != ""){
			$filter = " and LG_ID != '".$LG_ID."' ";
		}
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where LG_NAME_EN = '".ctext($LG_NAME_EN)."' {$filter} ","nums");
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