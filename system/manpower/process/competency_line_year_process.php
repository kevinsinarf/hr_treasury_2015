<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$COMSET_YEAR=$_POST['COMSET_YEAR'];
$COMTITLE_ID=$_POST['COMTITLE_ID'];
$COMSET_EXPECT=$_POST['COMSET_EXPECT'];
$TYPE_ID=$_POST['TYPE_ID'];
$LEVEL_ID=$_POST['LEVEL_ID'];
$LINE_ID=$_POST['LINE_ID'];

$table="COMPETENCY_SET";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$fields = array(
					"COMSET_YEAR"=>ctext($COMSET_YEAR),
					"COMTITLE_ID"=>ctext($COMTITLE_ID),
					"COMSET_EXPECT"=>ctext($COMSET_EXPECT),
					"TYPE_ID"=>ctext($TYPE_ID),
					"LEVEL_ID"=>ctext($LEVEL_ID),
					"LINE_ID"=>ctext($LINE_ID),
					"COMSET_TYPE"=>'2',
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
					"COMSET_YEAR"=>ctext($COMSET_YEAR),
					"COMTITLE_ID"=>ctext($COMTITLE_ID),
					"COMSET_EXPECT"=>ctext($COMSET_EXPECT),
					"TYPE_ID"=>ctext($TYPE_ID),
					"LEVEL_ID"=>ctext($LEVEL_ID),
					"LINE_ID"=>ctext($LINE_ID),
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
}
$url_back="../competency_line_year_disp.php";
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
