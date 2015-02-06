<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$TYPE_ID=$_POST['TYPE_ID'];
$LG_ID = $_POST['LG_ID'];
$LEVEL_ID=$_POST['LEVEL_ID'];
$LINE_NAME_TH=trim($_POST['LINE_NAME_TH']);
$LINE_NAME_EN=trim($_POST['LINE_NAME_EN']);
$LINE_SHORTNAME_TH=trim($_POST['LINE_SHORTNAME_TH']);
$LINE_SHORTNAME_EN=trim($_POST['LINE_SHORTNAME_EN']);
$LINE_MIN_LEVEL_ID=$_POST['LINE_MIN_LEVEL_ID'];
$LINE_MAX_LEVEL_ID=$_POST['LINE_MAX_LEVEL_ID'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$url_back="../pos_line_disp.php";
$table = "SETUP_POS_LINE";
switch($proc){
	case "add" :
		try{
			$fields = array(
						   "POSTYPE_ID" => '1',
						   "TYPE_ID" => $TYPE_ID,
						   "LG_ID" => $LG_ID,
						   "LINE_NAME_TH" => ctext($LINE_NAME_TH),
						   "LINE_NAME_EN" => ctext($LINE_NAME_EN),
						   "LINE_SHORTNAME_TH" => ctext($LINE_SHORTNAME_TH),
						   "LINE_SHORTNAME_EN" => ctext($LINE_SHORTNAME_EN),
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
						   "TYPE_ID" => $TYPE_ID,
						    "LG_ID" => $LG_ID,
						   "LINE_NAME_TH" => ctext($LINE_NAME_TH),
						   "LINE_NAME_EN" => ctext($LINE_NAME_EN),
						   "LINE_SHORTNAME_TH" => ctext($LINE_SHORTNAME_TH),
						   "LINE_SHORTNAME_EN" => ctext($LINE_SHORTNAME_EN),
						  
						   "ACTIVE_STATUS" => $ACTIVE_STATUS,
						   "CREATE_BY" =>ctext($USER_BY),
						   "UPDATE_BY" =>ctext($USER_BY),
						   "CREATE_DATE" => $TIMESTAMP,
						   "UPDATE_DATE" => $TIMESTAMP,
						   "DELETE_FLAG" => '0'
						   );		
			$db->db_update($table,$fields," LINE_ID = '".$LINE_ID."' "); //unset($fields);
			
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
			$db->db_update($table,$fields," LINE_ID = '".$LINE_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_ed" :
		
		$sql_ed = "SELECT * FROM SETUP_EDU_DEGREE WHERE EL_ID = '".$el_id."' ";
		$query = $db->query($sql_ed);
		$obj = array();
		while($rec=$db->db_fetch_array($query)){
			$row['ed_id'] = $rec['ED_ID'];
			$row['ed_name_th'] = text($rec['ED_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	exit;
	break;
	break;
	case "chk_dup1" : 
	
		$filter = "";
		if($LINE_NAME_TH != ""){
			$filter = " and LINE_ID != '".$LINE_ID ."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where LINE_NAME_TH = '".ctext($LINE_NAME_TH)."' {$filter} ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
					 );
		echo json_encode($arr);
	break;
	
	case "chk_dup2" : 
	
		$filter = "";
		if($LINE_NAME_EN != ""){
			$filter = " and LINE_ID != '".$LINE_ID."' ";
		}
		$chk = $db->get_data_field("select count(*) as nums from ".$table.
		" where LINE_NAME_EN = '".ctext($LINE_NAME_EN)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
	break;
	case "get_line_group" : 
		$sql = "Select LG_ID , LG_NAME_TH From SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LG_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LG_ID'];
			$row['VALUE'] = text($rec['LG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
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