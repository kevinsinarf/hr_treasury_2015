<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$CHS_FAMILY_INCOME	 = str_replace(",", "", $_POST['CHS_FAMILY_INCOME']);
$CHS_FAMILY_PAYMENT	 = str_replace(",", "", $_POST['CHS_FAMILY_PAYMENT']);
$CHS_SCHOLAR_MONEY	 = str_replace(",", "", $_POST['CHS_SCHOLAR_MONEY']);

$ACTIVE_STATUS	 = $_POST['ACTIVE_STATUS'];

$table="PER_CHILD_SCHOLAR";
switch($proc){
	case "add" : 
		try{		
			$sql="select (case when MAX(CHS_SEQ)>0 then (MAX(CHS_SEQ)+1) else '1' end) as NUM_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$NUM_SEQ = $db->get_data_field($sql,"NUM_SEQ");
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"CHS_SEQ"	 => $NUM_SEQ,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				
				"PMARRY_ID"	 => $PMARRY_ID,
				"FAMILY_ID"	 => $FAMILY_ID,
				"CHS_ACADEMIC_YEAR"	 => $CHS_ACADEMIC_YEAR,
				"EL_ID"	 => $EL_ID,
				"INS_ID"	 => $INS_ID,
				"PROV_ID"	 => $COUNTRY_ID==$default_country_id?$PROV_ID:"0",
				"COUNTRY_ID"	 => $COUNTRY_ID,
				"CHS_GPA"	 => $CHS_GPA,
				"CHS_CHILD_AGE"	 => $CHS_CHILD_AGE,
				"CHS_EFFECTIVE_DATE"	 => conv_date_db($CHS_EFFECTIVE_DATE),
				"CHS_FAMILY_INCOME"	 => $CHS_FAMILY_INCOME,
				"CHS_FAMILY_PAYMENT"	 => $CHS_FAMILY_PAYMENT,
				"CHS_SCHOLAR_MONEY"	 => $CHS_SCHOLAR_MONEY,

				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"CREATE_BY" => ctext($USER_BY),
				"UPDATE_BY" => ctext($USER_BY),
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
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LINE_ID"	 => $LINE_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				
				"PMARRY_ID"	 => $PMARRY_ID,
				"FAMILY_ID"	 => $FAMILY_ID,
				"CHS_ACADEMIC_YEAR"	 => $CHS_ACADEMIC_YEAR,
				"EL_ID"	 => $EL_ID,
				"INS_ID"	 => $INS_ID,
				"PROV_ID"	 => $COUNTRY_ID==$default_country_id?$PROV_ID:"0",
				"COUNTRY_ID"	 => $COUNTRY_ID,
				"CHS_GPA"	 => $CHS_GPA,
				"CHS_CHILD_AGE"	 => $CHS_CHILD_AGE,
				"CHS_EFFECTIVE_DATE"	 => conv_date_db($CHS_EFFECTIVE_DATE),
				"CHS_FAMILY_INCOME"	 => $CHS_FAMILY_INCOME,
				"CHS_FAMILY_PAYMENT"	 => $CHS_FAMILY_PAYMENT,
				"CHS_SCHOLAR_MONEY"	 => $CHS_SCHOLAR_MONEY,
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			
			$db->db_update($table,$fields," CHS_ID = '".$CHS_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," CHS_ID = '".$CHS_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_child_scholar.php";
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
