<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$SKILLSET_YEAR=$_POST['SKILLSET_YEAR'];
$SKILLTITLE_ID=$_POST['SKILLTITLE_ID'];
$SKILLSET_EXPECT=$_POST['SKILLSET_EXPECT'];
$TYPE_ID=$_POST['TYPE_ID'];
$LEVEL_ID=$_POST['LEVEL_ID'];
$LINE_ID=$_POST['LINE_ID'];

$table="SKILL_SET";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					"SKILLSET_YEAR"=>ctext($SKILLSET_YEAR),
					"SKILLTITLE_ID"=>ctext($SKILLTITLE_ID),
					"SKILLSET_EXPECT"=>ctext($SKILLSET_EXPECT),
					"TYPE_ID"=>ctext($TYPE_ID),
					"LEVEL_ID"=>ctext($LEVEL_ID),
					"LINE_ID"=>ctext($LINE_ID),
					"SKILL_SET_TYPE" => 1,
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
					"SKILLSET_YEAR"=>ctext($SKILLSET_YEAR),
					"SKILLTITLE_ID"=>ctext($SKILLTITLE_ID),
					"SKILLSET_EXPECT"=>ctext($SKILLSET_EXPECT),
					"TYPE_ID"=>ctext($TYPE_ID),
					"LEVEL_ID"=>ctext($LEVEL_ID),
					"LINE_ID"=>ctext($LINE_ID),
					"SKILL_SET_TYPE" => 1,
					"UPDATE_BY" =>$USER_BY,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
				    $db->db_update($table,$fields," SKILLSET_ID = '".$SKILLSET_ID."' "); 
					
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
			$db->db_update($table,$fields," SKILLSET_ID = '".$SKILLSET_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../skill_year_disp.php";
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
