<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$TABLE_ID = $_POST['TABLE_ID'];
$PER_ID = $_POST['PER_ID'];
$REQUEST_ID = $_POST['REQUEST_ID'];

$EL_ID = $_POST['EL_ID'];
$ED_ID = $_POST['ED_ID'];
$EM_ID = $_POST['EM_ID'];
$INS_ID = $_POST['INS_ID'];
$COUNTRY_ID = $_POST['COUNTRY_ID'];
$EDU_GPA = $_POST['EDU_GPA'];
$EDU_HORNOR = $_POST['EDU_HORNOR'];
$EDU_SDATE = $_POST['EDU_SDATE'];
$EDU_EDATE = $_POST['EDU_EDATE'];
$EDU_SCHOLARSHIP = $_POST['EDU_SCHOLARSHIP'];
$EDU_TYPE = $_POST['EDU_TYPE'];
$EDU_NOTE = $_POST['EDU_NOTE'];

$REQUEST_DATETIME = $_POST['REQUEST_DATETIME'];
$REQUEST_RESULT = $_POST['REQUEST_RESULT'];
$REQUEST_APP_DATE = $_POST['REQUEST_APP_DATE'];

$table="PER_EDUCATEHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				"PER_ID" => $PER_ID,
				"REQUEST_TABLE_ID" => $TABLE_ID,
				"REQUEST_DATETIME" => conv_date_db($REQUEST_DATETIME),
				"REQUEST_STATUS" => '1',
				"REQUEST_RESULT"=>'1',
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" =>$USER_BY,
				"CREATE_DATE"=>$TIMESTAMP,
				"UPDATE_DATE" =>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			);
			$db->db_insert("PER_REQUEST",$fields);
						
			$sql="select (case when MAX(REQUEST_ID)>0 then MAX(REQUEST_ID) else '0' end) as REQUEST_ID  from PER_REQUEST where PER_ID = '".$PER_ID."' and REQUEST_TABLE_ID = '".$TABLE_ID."' and REQUEST_STATUS = '1' and REQUEST_RESULT = '1' ";
			$REQUEST_ID = $db->get_data_field($sql,"REQUEST_ID");
			
			$sql="select (case when MAX(EDU_SEQ)>0 then (MAX(EDU_SEQ)+1) else '1' end) as EDU_SEQ  from PER_EDUCATEHIS where PER_ID='".$PER_ID."' ";
			$EDU_SEQ = $db->get_data_field($sql,"EDU_SEQ");
			
			unset($fields);
			$fields = array(
				"PER_ID" => $PER_ID,
				"EDU_SEQ" => $EDU_SEQ,
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
				"REQUEST_ID" => ctext($REQUEST_ID),
				"REQUEST_STATUS" => '1',
				"REQUEST_RESULT" => '1',
				"ACTIVE_STATUS" => '0',
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
	
	case "approve" : 
		try{
			unset($fields);
			$fields = array(
				"REQUEST_STATUS" => '2',
				"REQUEST_RESULT" => ctext($REQUEST_RESULT),
				"ACTIVE_STATUS" => $REQUEST_RESULT == '2'?'1':'0',
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table,$fields," REQUEST_ID = '".$REQUEST_ID."' AND PER_ID='".$PER_ID."' ");
			
			unset($fields);
			$fields = array(
				"REQUEST_APP_DATE" => conv_date_db($REQUEST_APP_DATE),
				"REQUEST_STATUS" => '2',
				"REQUEST_RESULT" => ctext($REQUEST_RESULT),
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update("PER_REQUEST",$fields," REQUEST_ID = '".$REQUEST_ID."' ");
			$text="บันทึกการเปลี่ยนแปลงประวัติเรียบร้อย";
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," REQUEST_ID = '".$REQUEST_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back = "../profile_approvehis.php";
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
