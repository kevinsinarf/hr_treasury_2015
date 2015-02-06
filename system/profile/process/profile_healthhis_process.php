<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
$HEALTH_DATE=$_POST['HEALTH_DATE'];
$HEALTH_BLOOD=$_POST['HEALTH_BLOOD'];
$HEALTH_ALLERGIC=$_POST['HEALTH_ALLERGIC'];
$HEALTH_CONGENITAL=$_POST['HEALTH_CONGENITAL'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="PER_HEALTHHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$sql="select (case when MAX(HEALTH_SEQ)>0 then (MAX(HEALTH_SEQ)+1) else '1' end) as HEALTH_SEQ  from PER_HEALTHHIS where PER_ID='".$PER_ID."' ";
							$query = $db->query($sql);
							$data = $db->db_fetch_array($query);
					$fields = array(
					"PER_ID" => $PER_ID,
					"HEALTH_SEQ" =>$data['HEALTH_SEQ'],
					"HEALTH_DATE"=> conv_date_db($HEALTH_DATE),
					"HEALTH_BLOOD"=>ctext($HEALTH_BLOOD),
					"HEALTH_ALLERGIC"=>ctext($HEALTH_ALLERGIC),
					"HEALTH_CONGENITAL"=>ctext($HEALTH_CONGENITAL),
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
					"HEALTH_DATE"=> conv_date_db($HEALTH_DATE),
					"HEALTH_BLOOD"=>ctext($HEALTH_BLOOD),
					"HEALTH_ALLERGIC"=>ctext($HEALTH_ALLERGIC),
					"HEALTH_CONGENITAL"=>ctext($HEALTH_CONGENITAL),
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
				    $db->db_update($table,$fields," HEALTH_ID = '".$HEALTH_ID."' "); 
					
					$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," HEALTH_ID = '".$HEALTH_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_healthhis_disp.php";
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
