<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$COMSET_ID = $_POST['COMSET_ID'];
$COMSET_YEAR = $_POST['COMSET_YEAR'];
$COMTITLE_ID = $_POST['COMTITLE_ID'];
$COMSET_EXPECT = $_POST['COMSET_EXPECT'];
$TYPE_ID = $_POST['TYPE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$table="COMPETENCY_SET";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					  "COMSET_YEAR"=>$COMSET_YEAR,
					  "COMTITLE_ID"=>$COMTITLE_ID,
					  "COMSET_TYPE"=>'1',
					  "COMSET_EXPECT" => $COMSET_EXPECT,
					  "TYPE_ID" => $TYPE_ID,
					  "LEVEL_ID" => $LEVEL_ID,
					  "CREATE_BY" => $USER_BY,
					  "CREATE_DATE"=>$TIMESTAMP,
					  "DELETE_FLAG" =>'0'
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
					"COMSET_YEAR"=>$COMSET_YEAR,
					"COMTITLE_ID"=>$COMTITLE_ID,
					"COMSET_TYPE"=>'1',
					 "TYPE_ID" => $TYPE_ID,
					 "LEVEL_ID" => $LEVEL_ID,
					"COMSET_EXPECT" => $COMSET_EXPECT,
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
				    $db->db_update($table,$fields," COMSET_ID = '".$COMSET_ID."' "); 
					
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
			$db->db_update($table,$fields," COMSET_ID = '".$COMSET_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "ChkLevel":
	$arr_pos_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = 1 AND TYPE_ID = '".$TYPE_ID."'  ", "LEVEL_NAME_TH");
	echo json_encode(convert_text($arr_pos_level));
	exit;
	break;
}
$url_back="../competency_main_year_disp.php";
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
