<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
 
switch($proc){
	case "add" : 
		try{
			$fields = array(
			   "OT_ID" => $ot_id,
			   "OL_ID" => $ol_id,
			   "ORG_PARENT_ID" => $org_id1,
			   "ORG_NAME_TH" => ctext($org_name_th),
			   "ORG_NAME_EN" => ctext($org_name_en),
			   "ORG_SHORTNAME_TH" => ctext($org_shortname_th),
			   "ORG_SHORTNAME_EN" => ctext($org_shortname_en),
			   "ORG_SEQ" => ctext($ORG_SEQ),
			   "ORG_YEAR" => $org_year,
			   "ORG_ADDRESS" => ctext($org_address),
			   "ORG_TAMB_ID" => ctext($tamb_id),
			   "ORG_AMPR_ID" => ctext($ampr_id),
			   "ORG_PROV_ID" => ctext($prov_id),
			   "ORG_TEL" => ctext($org_tel),
			   "ORG_EXT" => ctext($org_ext),
			   "ORG_FAX" => ctext($org_fax),
			   "ORG_TYPE" => 1,
			   "CT_ID" => $CT_ID,
			   "ORG_NOTICE_DATE" => conv_date_db($ORG_NOTICE_DATE),
			   "ORG_NOTICE_SDATE" => conv_date_db($ORG_NOTICE_SDATE),
			   "ORG_NOTICE_TITLE" => ctext($ORG_NOTICE_TITLE),
			   "ORG_GAZETTE_BOOK" => ctext($ORG_GAZETTE_BOOK),
			   "ORG_GAZETTE_PART" => ctext($ORG_GAZETTE_PART),
			   "ORG_GAZETTE_DATE" => conv_date_db($ORG_GAZETTE_DATE),
			   "ORG_GAZETTE_PAGE" => ctext($ORG_GAZETTE_PAGE),
			   "ORG_GAZETTE_SDATE" => conv_date_db($ORG_GAZETTE_SDATE),
			   "ACTIVE_STATUS" => $active_status,
			   "DELETE_FLAG" => 0,
			   "CREATE_BY" => $_SESSION["sys_id"],
			   "CREATE_DATE" => $TIMESTAMP,
			   "UPDATE_BY" => $_SESSION["sys_id"],
			   "UPDATE_DATE" => $TIMESTAMP,
			);
			
			$db->db_insert("setup_org",$fields); unset($fields);
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
			   "OT_ID" => $ot_id,
			   "OL_ID" => $ol_id,
			   "ORG_NAME_TH" => ctext($org_name_th),
			   "ORG_NAME_EN" => ctext($org_name_en),
			   "ORG_SHORTNAME_TH" => ctext($org_shortname_th),
			   "ORG_SHORTNAME_EN" => ctext($org_shortname_en),
			   "ORG_SEQ" => ctext($ORG_SEQ),
			   "ORG_YEAR" => $org_year,
			   "ORG_ADDRESS" => ctext($org_address),
			   "ORG_TAMB_ID" => ctext($tamb_id),
			   "ORG_AMPR_ID" => ctext($ampr_id),
			   "ORG_PROV_ID" => ctext($prov_id),
			   "ORG_TEL" => ctext($org_tel),
			   "ORG_EXT" => ctext($org_ext),
			   "ORG_FAX" => ctext($org_fax),
			   "CT_ID" => $CT_ID,
			   "ORG_NOTICE_DATE" => conv_date_db($ORG_NOTICE_DATE),
			   "ORG_NOTICE_SDATE" => conv_date_db($ORG_NOTICE_SDATE),
			   "ORG_NOTICE_TITLE" => ctext($ORG_NOTICE_TITLE),
			   "ORG_GAZETTE_BOOK" => ctext($ORG_GAZETTE_BOOK),
			   "ORG_GAZETTE_PART" => ctext($ORG_GAZETTE_PART),
			   "ORG_GAZETTE_DATE" => conv_date_db($ORG_GAZETTE_DATE),
			   "ORG_GAZETTE_PAGE" => ctext($ORG_GAZETTE_PAGE),
			   "ORG_GAZETTE_SDATE" => conv_date_db($ORG_GAZETTE_SDATE),
			   "ACTIVE_STATUS" => $active_status,
			   "UPDATE_BY" => $_SESSION["sys_id"],
			   "UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update("setup_org",$fields," org_id = '".$org_id."' "); unset($fields);
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
    case "edit1" : 
		try{
			unset($fields);
			$fields = array(
			   "ORG_ADDRESS" => ctext($org_address),
			   "ORG_TAMB_ID" => ctext($tamb_id),
			   "ORG_AMPR_ID" => ctext($ampr_id),
			   "ORG_PROV_ID" => ctext($prov_id),
			   "UPDATE_BY" => $_SESSION["sys_id"],
			   "UPDATE_DATE" => $TIMESTAMP,
			);
			
			$db->db_update("setup_org",$fields," org_id = '".$org_id."' "); unset($fields);
			
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
			$db->db_update("setup_org",$fields," org_id = '".$org_id."' ");
			
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
if($proc!='chk_dup1' && $proc!='chk_dup2'){
?>
<form name="form_back" method="post" action="../disp_gov_within.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php
}
?>