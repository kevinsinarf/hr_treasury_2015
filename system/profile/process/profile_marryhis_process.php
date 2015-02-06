<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$table="PER_MARRYHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			if($ACTIVE_STATUS == '1'){
				$fields = array(
						"ACTIVE_STATUS" => '0',
						);
				 $db->db_update($table,$fields," PER_ID = '".$PER_ID."' ");
			}
			unset($fields);
			$sql="select (case when MAX(PMARRY_SEQ)>0 then (MAX(PMARRY_SEQ)+1) else '1' end) as PMARRY_SEQ  from PER_MARRYHIS where PER_ID='".$PER_ID."' ";
			$query = $db->query($sql);
			$data = $db->db_fetch_array($query);
			$fields = array(
				"PER_ID" => $PER_ID,
				"PMARRY_SEQ" =>$data['PMARRY_SEQ'],
				"PMARRY_TYPE" =>$PMARRY_TYPE ,
				"PMAARY_IDCARD" =>str_replace("-","",$PMAARY_IDCARD) ,
				"PMARRY_PREFIX_ID" =>ctext($PMARRY_PREFIX_ID) ,
				"PMARRY_FIRSTNAME_TH" =>ctext($PMARRY_FIRSTNAME_TH) ,
				"PMARRY_MIDNAME_TH" =>ctext($PMARRY_MIDNAME_TH) ,
				"PMARRY_LASTNAME_TH" =>ctext($PMARRY_LASTNAME_TH) ,
				"PMARRY_FIRSTNAME_EN" =>ctext($PMARRY_FIRSTNAME_EN) ,
				"PMARRY_MIDNAME_EN" =>ctext($PMARRY_MIDNAME_EN) ,
				"PMARRY_LASTNAME_EN" =>ctext($PMARRY_LASTNAME_EN) ,
				"PMARRY_O_LASTNAME_TH" =>ctext($PMARRY_O_LASTNAME_TH) ,
				"PMARRY_O_LASTNAME_EN" =>ctext($PMARRY_O_LASTNAME_EN) ,
				"PMARRY_STATUS" => $PMARRY_STATUS,
				"REQUEST_RESULT" => '2',
				"REQUEST_STATUS" => '2',
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" => $USER_BY,
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
			unset($fields);
			if($ACTIVE_STATUS == '1'){
				$fields = array(
						"ACTIVE_STATUS" => '0',
						);
				 $db->db_update($table,$fields," PER_ID = '".$PER_ID."' ");
			}
			unset($fields);
			$fields = array(
				"PMARRY_TYPE" =>$PMARRY_TYPE ,
				"PMAARY_IDCARD" =>str_replace("-","",$PMAARY_IDCARD) ,
				"PMARRY_PREFIX_ID" =>ctext($PMARRY_PREFIX_ID) ,
				"PMARRY_FIRSTNAME_TH" =>ctext($PMARRY_FIRSTNAME_TH) ,
				"PMARRY_MIDNAME_TH" =>ctext($PMARRY_MIDNAME_TH) ,
				"PMARRY_LASTNAME_TH" =>ctext($PMARRY_LASTNAME_TH) ,
				"PMARRY_FIRSTNAME_EN" =>ctext($PMARRY_FIRSTNAME_EN) ,
				"PMARRY_MIDNAME_EN" =>ctext($PMARRY_MIDNAME_EN) ,
				"PMARRY_LASTNAME_EN" =>ctext($PMARRY_LASTNAME_EN) ,
				"PMARRY_O_LASTNAME_TH" =>ctext($PMARRY_O_LASTNAME_TH) ,
				"PMARRY_O_LASTNAME_EN" =>ctext($PMARRY_O_LASTNAME_EN) ,
				"PMARRY_STATUS" => $PMARRY_STATUS,
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," PMARRY_ID = '".$PMARRY_ID."' "); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," PMARRY_ID = '".$PMARRY_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_marryhis_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID?>">
    <input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
