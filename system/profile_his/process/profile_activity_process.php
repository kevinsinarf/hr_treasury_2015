<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$ACT_ID=$_POST['ACT_ID'];
$EDU_ID=$_POST['EDU_ID'];
$PER_ID=$_POST['PER_ID'];
$ACT_DESC=$_POST['ACT_DESC'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="PER_ACTIVITYHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$sql="select (case when MAX(ACT_SEQ)>0 then (MAX(ACT_SEQ)+1) else '1' end) as ACT_SEQ  from PER_ACTIVITYHIS where PER_ID='".$PER_ID."' ";
							$query = $db->query($sql);
							$data = $db->db_fetch_array($query);
					$fields = array(
					"EDU_ID" => $EDU_ID,
					"PER_ID" => $PER_ID,
					"ACT_SEQ" =>$data['ACT_SEQ'],
					"ACT_DESC"=>ctext($ACT_DESC),
					"REQUEST_RESULT" => '1',
					"REQUEST_STATUS" => '1',
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
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
					"ACT_DESC"=>ctext($ACT_DESC),
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
				    $db->db_update($table,$fields," ACT_ID = '".$ACT_ID."' "); 
					
					$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," ACT_ID = '".$ACT_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_activity_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
