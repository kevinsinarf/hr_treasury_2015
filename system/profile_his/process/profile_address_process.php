<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$menu_id = $_POST['menu_id'];
$PT_ID = $_POST['PT_ID'];
$PER_ID = $_POST['PER_ID'];
$PADD_ID = $_POST['PADD_ID'];
$PADD_PROV_ID = $_POST['PADD_PROV_ID'];
$s_prov = $_POST['s_prov'];
$s_ampar = $_POST['s_ampar'];
$s_tamb = $_POST['s_tamb'];

//ที่อยู่ปัจจุบัน
$S_HOMENO1 = $_POST['S_HOMENO1']; 
$S_MOO1 = $_POST['S_MOO1'];
$S_VILLAGE1 = $_POST['S_VILLAGE1'];
$S_BUILDING1 = $_POST['S_BUILDING1'];
$S_ROOM1 = $_POST['S_ROOM1'];
$S_SOI1 = $_POST['S_SOI1'];
$S_ROAD1 = $_POST['S_ROAD1'];
$s_prov1 = $_POST['s_prov1'];
$s_ampr1 = $_POST['s_ampr1'];
$s_tamb1 = $_POST['s_tamb1'];
$S_POSTCODE1 = $_POST['S_POSTCODE1'];
$S_TEL1 = $_POST['S_TEL1'];
$S_FAX1 = $_POST['S_FAX1'];
$S_MOBILE1 = $_POST['S_MOBILE1'];
$S_EMAIL1 = $_POST['S_EMAIL1'];

$table="PER_ADDRESS";

switch($proc){
	case "add" :
		try{
			unset($fields);
			$fields = array(
				"ACTIVE_STATUS" => '0',
			);
			$db->db_update($table, $fields, " PER_ID = '".$PER_ID."' and PADD_TYPE = '".$PADD_TYPE."' "); 
			
			unset($fields);
			$fields["PER_ID"] = $PER_ID;	
			$fields["PADD_DATE"] = conv_date_db($PADD_DATE);
			$fields["PADD_TYPE"] = $PADD_TYPE;
			$fields["PADD_COUNTRY_ID"] = ctext($_POST['S_COUNTRY']);
			$fields["PADD_ROOM_NO"] = ctext($_POST['S_ROOM']);
			$fields["PADD_FLOOR"] = ctext($_POST['S_FLOOR']);
			$fields["PADD_BUILDING"] = ctext($_POST['S_BUILDING']);
			$fields["PADD_HOME_NO"] = ctext($_POST['S_HOMENO']); 
			$fields["PADD_MOO"] = ctext($_POST['S_MOO']);
			$fields["PADD_VILLAGE"] = ctext($_POST['S_VILLAGE']) ;
			$fields["PADD_SOI"] = ctext($_POST['S_SOI']);
			$fields["PADD_ROAD"] = ctext($_POST['S_ROAD']);
			
			if($_POST['S_COUNTRY'] != $default_country_id){
				$fields["PADD_CITY"] = ctext($_POST['S_CITY']);
				$fields["PADD_TAMB_ID"] = NULL;
				$fields["PADD_AMPR_ID"] = NULL;
				$fields["PADD_PROV_ID"] = NULL;
				$fields["PADD_POSTCODE"] = NULL;
			}else{
				$fields["PADD_CITY"] =  NULL;
				$fields["PADD_TAMB_ID"] = ctext($_POST['s_tamb']);
				$fields["PADD_AMPR_ID"] = ctext($_POST['s_ampr']);
				$fields["PADD_PROV_ID"] = ctext($_POST['s_prov']);
				$fields["PADD_POSTCODE"] = ctext($_POST['PADD_POSTCODE']);
			}
			
			$fields["PADD_TEL"] = str_replace("-","",$_POST['S_TEL']);
			$fields["PADD_TEL_EXT"] = ctext($_POST['S_TEL_EXT']);
			$fields["PADD_FAX"] = str_replace("-","",$_POST['S_FAX']);
			$fields["PADD_FAX_EXT"] = ctext($_POST['PADD_FAX_EXT']);
			$fields["PADD_MOBILE"] = str_replace("-","",$_POST['S_MOBILE']);
			$fields["PADD_EMAIL"] = ctext($_POST['S_EMAIL']);
			$fields["CREATE_BY"] = ctext($USER_BY);
			$fields["CREATE_DATE"] = $TIMESTAMP;
			$fields["UPDATE_BY"] = ctext($USER_BY);
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$fields["REQUEST_ID"] = "";
			$fields["REQUEST_RESULT"] = "2";
			$fields["REQUEST_STATUS"] = "2";
			$fields["ACTIVE_STATUS"] = '1';
			$fields["DELETE_FLAG"] = '0';
			$db->db_insert($table,$fields);	
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMePADDge();
		}
	break;

	case "edit" :
		try{
			$fields = array(
				"ACTIVE_STATUS" => '0',
			);
			$db->db_update($table, $fields, " PER_ID = '".$PER_ID."' and PADD_TYPE = '".$PADD_TYPE."' "); 
			
			unset($fields);
			$fields["PADD_DATE"] = conv_date_db($PADD_DATE);
			$fields["PADD_TYPE"] = $PADD_TYPE;
			$fields["PADD_COUNTRY_ID"] = ctext($_POST['S_COUNTRY']);
			$fields["PADD_ROOM_NO"] = ctext($_POST['S_ROOM']);
			$fields["PADD_FLOOR"] = ctext($_POST['S_FLOOR']);
			$fields["PADD_BUILDING"] = ctext($_POST['S_BUILDING']);
			$fields["PADD_HOME_NO"] = ctext($_POST['S_HOMENO']); 
			$fields["PADD_MOO"] = ctext($_POST['S_MOO']);
			$fields["PADD_VILLAGE"] = ctext($_POST['S_VILLAGE']) ;
			$fields["PADD_SOI"] = ctext($_POST['S_SOI']);
			$fields["PADD_ROAD"] = ctext($_POST['S_ROAD']);
			
			if($_POST['S_COUNTRY'] != $default_country_id){
				$fields["PADD_CITY"] = ctext($_POST['S_CITY']);
				$fields["PADD_TAMB_ID"] = NULL;
				$fields["PADD_AMPR_ID"] = NULL;
				$fields["PADD_PROV_ID"] = NULL;
				$fields["PADD_POSTCODE"] = NULL;
			}else{
				$fields["PADD_CITY"]=  NULL;
				$fields["PADD_TAMB_ID"] = ctext($_POST['s_tamb']);
				$fields["PADD_AMPR_ID"] = ctext($_POST['s_ampr']);
				$fields["PADD_PROV_ID"] = ctext($_POST['s_prov']);
				$fields["PADD_POSTCODE"] = ctext($_POST['PADD_POSTCODE']);
			}
			
			$fields["PADD_TEL"] = str_replace("-","",$_POST['S_TEL']);
			$fields["PADD_TEL_EXT"] = ctext($_POST['S_TEL_EXT']);
			$fields["PADD_FAX"] = str_replace("-","",$_POST['S_FAX']);
			$fields["PADD_FAX_EXT"] = ctext($_POST['PADD_FAX_EXT']);
			$fields["PADD_MOBILE"] = str_replace("-","",$_POST['S_MOBILE']);
			$fields["PADD_EMAIL"] = ctext($_POST['S_EMAIL']);
			$fields["ACTIVE_STATUS"] = '1';
			$fields["UPDATE_BY"] = ctext($USER_BY);
			$fields["UPDATE_DATE"] = $TIMESTAMP;
			$db->db_update("PER_ADDRESS", $fields, "  PADD_ID ='".$PADD_ID."'  "); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMePADDge();
		}
	break;
}
?>
<form name="form_back" method="post" action="../profile_address.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
	<input type="hidden" id="PADD_ID" name="PADD_ID" value="<?php echo $PADD_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>