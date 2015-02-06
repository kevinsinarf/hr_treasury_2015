<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$DEH_SALARY	 = str_replace(",", "", $_POST['DEH_SALARY']);
$DEH_SALARY_POSITION 	 = str_replace(",", "", $_POST['DEH_SALARY_POSITION']);

$table="PER_DECORATEHIS";
switch($proc){
	case "add" : 
		try{		
			unset($fields);
			$sql="select (case when MAX(DEH_SEQ)>0 then (MAX(DEH_SEQ)+1) else '1' end) as DEH_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$query = $db->query($sql);
			$data = $db->db_fetch_array($query);
			
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"PMARRY_ID"	 => $PMARRY_ID,
				"DEH_SEQ"	 => $data['DEH_SEQ'],
				"DEF_ID"	 => $DEF_ID,
				"DEC_ID"	 => $DEC_ID,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LG_ID" => $LG_ID,
				"LINE_ID"	 => $LINE_ID,
				'MT_ID' => $MT_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"ORG_ID_5"	 => $ORG_ID_5,
				"DEH_SALARY"	 => $DEH_SALARY,
				"DEH_SALARY_POSITION "	 => $DEH_SALARY_POSITION ,
				"DEH_GAZZETTE_DATE"	 => conv_date_db($DEH_GAZZETTE_DATE),
				"DEH_GAZZETTE_BOOK"	 => $DEH_GAZZETTE_BOOK,
				"DEH_GAZZETTE_PART"	 => $DEH_GAZZETTE_PART,
				"DEH_GAZZETTE_PAGE"	 => $DEH_GAZZETTE_PAGE,
				"DEH_RECEIVE_DATE"	 => conv_date_db($DEH_RECEIVE_DATE),
				"DEH_RETURN_DATE"	 => conv_date_db($DEH_RETURN_DATE),
				"DEH_NOTE"	 => ctext($DEH_NOTE),
				
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
				"PMARRY_ID"	 => $PMARRY_ID,
				"DEF_ID"	 => $DEF_ID,
				"DEC_ID"	 => $DEC_ID,
				"TYPE_ID"	 => $TYPE_ID,
				"LEVEL_ID"	 => $LEVEL_ID,
				"LG_ID" => $LG_ID,
				"LINE_ID"	 => $LINE_ID,
				'MT_ID' => $MT_ID,
				"MANAGE_ID"	 => $MANAGE_ID,
				"ORG_ID_1"	 => $ORG_ID_1,
				"ORG_ID_2"	 => $ORG_ID_2,
				"ORG_ID_3"	 => $ORG_ID_3,
				"ORG_ID_4"	 => $ORG_ID_4,
				"DEH_SALARY"	 => $DEH_SALARY,
				"DEH_SALARY_POSITION "	 => $DEH_SALARY_POSITION ,
				"DEH_GAZZETTE_DATE"	 => conv_date_db($DEH_GAZZETTE_DATE),
				"DEH_GAZZETTE_BOOK"	 => $DEH_GAZZETTE_BOOK,
				"DEH_GAZZETTE_PART"	 => $DEH_GAZZETTE_PART,
				"DEH_GAZZETTE_PAGE"	 => $DEH_GAZZETTE_PAGE,
				"DEH_RECEIVE_DATE"	 => conv_date_db($DEH_RECEIVE_DATE),
				"DEH_RETURN_DATE"	 => conv_date_db($DEH_RETURN_DATE),
				"DEH_NOTE"	 => ctext($DEH_NOTE),
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => ctext($USER_BY),
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			
			$db->db_update($table,$fields," DEH_ID = '".$DEH_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," DEH_ID = '".$DEH_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_decoratehis.php";
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
