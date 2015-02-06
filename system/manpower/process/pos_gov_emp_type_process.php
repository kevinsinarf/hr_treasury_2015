<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$TYPE_ID=$_POST['TYPE_ID'];
$TYPE_NAME_TH=trim($_POST['TYPE_NAME_TH']);
$TYPE_SHORTNAME_TH = trim($_POST['TYPE_SHORTNAME_TH']);
$TYPE_NAME_EN = trim($_POST['TYPE_NAME_EN']);
$TYPE_SHORTNAME_EN = trim($_POST['TYPE_SHORTNAME_EN']);
$TYPE_SEQ = trim($_POST['TYPE_SEQ']);
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$url_back="../pos_gov_emp_type_disp.php";
$table="SETUP_POS_TYPE ";

switch($proc){
	case "add" : 
		try{
			$fields = array(
						  "POSTYPE_ID" => '3',
						   "TYPE_NAME_TH" => ctext($TYPE_NAME_TH),
						   "TYPE_NAME_EN" => ctext($TYPE_NAME_EN),
						   "TYPE_SHORTNAME_TH" => ctext($TYPE_SHORTNAME_TH),
						   "TYPE_SHORTNAME_EN" => ctext($TYPE_SHORTNAME_EN),
						   "TYPE_SEQ" => $TYPE_SEQ,
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
					 "TYPE_NAME_TH" => ctext($TYPE_NAME_TH),
					 "TYPE_NAME_EN" => ctext($TYPE_NAME_EN),
					 "TYPE_SHORTNAME_TH" => ctext($TYPE_SHORTNAME_TH),
					  "TYPE_SHORTNAME_EN" => ctext($TYPE_SHORTNAME_EN),
					  "TYPE_SEQ" => $TYPE_SEQ,
					 "ACTIVE_STATUS" => $ACTIVE_STATUS,
					 "CREATE_BY" =>ctext($USER_BY),
					 "UPDATE_BY" =>ctext($USER_BY),
					 "CREATE_DATE" => $TIMESTAMP,
					 "UPDATE_DATE" => $TIMESTAMP,
					 "DELETE_FLAG" => '0'
					 );		
			$db->db_update($table,$fields," TYPE_ID = '".$TYPE_ID."' "); //unset($fields);
			
			
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
			$db->db_update($table,$fields," TYPE_ID = '".$TYPE_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($TYPE_NAME_TH != ""){
			$filter = " and TYPE_ID != '".$TYPE_ID ."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where TYPE_NAME_TH = '".ctext($TYPE_NAME_TH)."' {$filter} ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
					 );
		echo json_encode($arr);
	break;
	
	case "chk_dup2" : 
	
		$filter = "";
		if($TYPE_NAME_EN != ""){
			$filter = " and TYPE_ID != '".$TYPE_ID."' ";
		}
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where TYPE_NAME_EN = '".ctext($TYPE_NAME_EN)."' {$filter} ","nums");
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
    <input name="TYPE_ID" type="hidden" id="TYPE_ID" value="<?php echo $TYPE_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>