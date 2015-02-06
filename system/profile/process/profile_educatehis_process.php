<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
$EL_ID=$_POST['EL_ID'];
$ED_ID=$_POST['ED_ID'];
$EM_ID=$_POST['EM_ID'];
$INS_ID=$_POST['INS_ID'];
$COUNTRY_ID=$_POST['COUNTRY_ID'];
$EDU_GPA=$_POST['EDU_GPA'];
$EDU_HORNOR=$_POST['EDU_HORNOR'];
$EDU_SDATE=$_POST['EDU_SDATE'];
$EDU_EDATE=$_POST['EDU_EDATE'];
$EDU_SCHOLARSHIP=$_POST['EDU_SCHOLARSHIP'];
$EDU_TYPE=$_POST['EDU_TYPE'];
$EDU_NOTE=$_POST['EDU_NOTE'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

$table="PER_EDUCATEHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$sql="select (case when MAX(EDU_SEQ)>0 then (MAX(EDU_SEQ)+1) else '1' end) as EDU_SEQ  from PER_EDUCATEHIS where PER_ID='".$PER_ID."' ";
			$query = $db->query($sql);
			$data = $db->db_fetch_array($query);
			$fields = array(
				"PER_ID" => $PER_ID,
				"EDU_SEQ" => $data['EDU_SEQ'],
				"EL_ID" => ctext($EL_ID),
				"ED_ID" => ctext($ED_ID),
				"EM_ID" => ctext($EM_ID),
				"INS_ID" => ctext($INS_ID),
				"COUNTRY_ID" => ctext($COUNTRY_ID),
				"EDU_GPA" => ctext($EDU_GPA),
				"EDU_HORNOR" => ctext($EDU_HORNOR),
				"EDU_SDATE" => conv_date_db($EDU_SDATE),
				"EDU_EDATE" => conv_date_db($EDU_EDATE),
				"EDU_SCHOLARSHIP" =>ctext($EDU_SCHOLARSHIP),
				"EDU_TYPE" => ctext($EDU_TYPE),
				"EDU_NOTE" => ctext($EDU_NOTE),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_DATE" => $TIMESTAMP,
				"DELETE_FLAG" => '0',
				"REQUEST_STATUS" => '2',
				"REQUEST_RESULT" => '2'
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
				"EL_ID" => ctext($EL_ID),
				"ED_ID" => ctext($ED_ID),
				"EM_ID" => ctext($EM_ID),
				"INS_ID" => ctext($INS_ID),
				"COUNTRY_ID" => ctext($COUNTRY_ID),
				"EDU_GPA" => ctext($EDU_GPA),
				"EDU_HORNOR" => ctext($EDU_HORNOR),
				"EDU_SDATE" => conv_date_db($EDU_SDATE),
				"EDU_EDATE" => conv_date_db($EDU_EDATE),
				"EDU_SCHOLARSHIP" => ctext($EDU_SCHOLARSHIP),
				"EDU_TYPE" => ctext($EDU_TYPE),
				"EDU_NOTE" => ctext($EDU_NOTE),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" =>$TIMESTAMP,
			);
			$db->db_update($table,$fields," EDU_ID = '".$EDU_ID."' "); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," EDU_ID = '".$EDU_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_educatehis_disp.php";
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
