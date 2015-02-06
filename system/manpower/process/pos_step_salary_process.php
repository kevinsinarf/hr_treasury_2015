<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$TYPE_ID=$_POST['TYPE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$LEVEL_ID=$_POST['LEVEL_ID'];
$ARR_SALARYTITLE_ID = $_POST['SALARYTITLE_ID'];


$url_back="../pos_step_salary_form.php";
$TB = "SETUP_POS_STEP_SALARY";
switch($proc){
	case "add" :
		try{
			$db->db_delete($TB," TYPE_ID = '".$TYPE_ID."' AND LEVEL_ID = '".$LEVEL_ID."' ");
			if(count($ARR_SALARYTITLE_ID) > 0){
				foreach($ARR_SALARYTITLE_ID as $index => $val){
					$fields = array(
								  
								   "TYPE_ID" => $TYPE_ID,
								   "LEVEL_ID" => $LEVEL_ID,
								   "SALARYTITLE_ID" => $val,
								   "ACTIVE_STATUS" => 1,
								   "CREATE_BY" => $USER_BY,
								   "CREATE_DATE" => $TIMESTAMP,
								   "DELETE_FLAG" => '0'
								   );	
					$db->db_insert($TB,$fields);
				}
			}
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_level" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 }
	break;
	
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input name="TYPE_ID" type="hidden" id="TYPE_ID" value="<?php echo $TYPE_ID; ?>">
    <input name="LEVEL_ID" type="hidden" id="LEVEL_ID" value="<?php echo $LEVEL_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>