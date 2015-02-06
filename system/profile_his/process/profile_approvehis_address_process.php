<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$menu_id=$_POST['menu_id'];
$PER_ID =$_POST['PER_ID'];
$PT_ID=$_POST['PT_ID'];

$PADD_PROV_ID=$_POST['PADD_PROV_ID'];
$s_prov =$_POST['s_prov'];
$s_ampar =$_POST['s_ampar'];
$s_tamb =$_POST['s_tamb'];


//ที่อยู่ปัจจุบัน
$TABLE_ID=$_POST['TABLE_ID'];
$PER_ID=$_POST['PER_ID'];
$REQUEST_ID=$_POST['REQUEST_ID'];

$checkbox = $_POST['checkbox'];

$REQUEST_DATETIME=$_POST['REQUEST_DATETIME'];
$REQUEST_RESULT=$_POST['REQUEST_RESULT'];
$REQUEST_APP_DATE=$_POST['REQUEST_APP_DATE'];

$table="PER_ADDRESS";

switch($proc){
	case "add" :
		try{
			unset($fields);
			$fields = array(
				"PER_ID" => $PER_ID,
				"REQUEST_TABLE_ID" => $TABLE_ID,
				"REQUEST_DATETIME" => conv_date_db($REQUEST_DATETIME),
				"REQUEST_STATUS" => '1',
				"REQUEST_RESULT" => '1',
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_DATE" => $TIMESTAMP,
				"DELETE_FLAG" => '0'
			);
			$db->db_insert("PER_REQUEST",$fields);
			
			$sql="select (case when MAX(REQUEST_ID)>0 then MAX(REQUEST_ID) else '0' end) as REQUEST_ID  from PER_REQUEST where PER_ID = '".$PER_ID."' and REQUEST_TABLE_ID = '".$TABLE_ID."' and REQUEST_STATUS = '1' and REQUEST_RESULT = '1' ";
			$REQUEST_ID = $db->get_data_field($sql,"REQUEST_ID");
			
			foreach($checkbox as $i => $key){
				
				unset($fields);
				$fields["PER_ID"] = $PER_ID;
				$fields["PADD_DATE"] = conv_date_db($_POST['REQUEST_DATETIME']);
				$fields["PADD_TYPE"] = $key;
				$fields["PADD_COUNTRY_ID"]= ctext($_POST['S_COUNTRY'.$key]);
				$fields["PADD_CITY"] = ctext($_POST['PADD_CITY'.$key]);
				$fields["PADD_ROOM_NO"] = ctext($_POST['S_ROOM_NO'.$key]);
				$fields["PADD_FLOOR"] = ctext($_POST['S_FLOOR'.$key]);
				$fields["PADD_BUILDING"] = ctext($_POST['S_BUILDING'.$key]);
				$fields["PADD_HOME_NO"] = ctext($_POST['S_HOME_NO'.$key]);
				$fields["PADD_MOO"] = ctext($_POST['S_MOO'.$key]);
				$fields["PADD_VILLAGE"] = ctext($_POST['S_VILLAGE'.$key]) ;
				$fields["PADD_SOI"] = ctext($_POST['S_SOI'.$key]);
				$fields["PADD_ROAD"] = ctext($_POST['S_ROAD'.$key]);
				
				if($_POST['S_COUNTRY'.$key]!=$default_country_id){
					$fields["PADD_CITY"] = ctext($_POST['S_CITY']);
					$fields["PADD_TAMB_ID"] = NULL;
					$fields["PADD_AMPR_ID"] = NULL;
					$fields["PADD_PROV_ID"] = NULL;
					$fields["PADD_POSTCODE"] = NULL;
				}else{
					$fields["PADD_CITY"] =  NULL;
					$fields["PADD_TAMB_ID"] = ctext($_POST['s_tamb'.$key]);
					$fields["PADD_AMPR_ID"] = ctext($_POST['s_ampr'.$key]);
					$fields["PADD_PROV_ID"] = ctext($_POST['s_prov'.$key]);
					$fields["PADD_POSTCODE"] = ctext($_POST['PADD_ZIPCODE'.$key]);
				}
				
				$fields["PADD_TEL"] = ctext(str_replace("-","",$_POST['S_TEL'.$key]));
				$fields["PADD_TEL_EXT"] = ctext($_POST['S_TEL_EXT'.$key]);
				$fields["PADD_FAX"] = ctext(str_replace("-","",$_POST['S_FAX'.$key]));
				$fields["PADD_FAX_EXT"] = ctext($_POST['S_FAX_EXT'.$key]);
				$fields["PADD_MOBILE"] = str_replace("-","",$_POST['S_MOBILE'.$key]);
				$fields["PADD_EMAIL"] = ctext($_POST['S_EMAIL'.$key]);
				$fields["REQUEST_ID"] = ctext($REQUEST_ID);
				$fields["REQUEST_STATUS"] = '1';
				$fields["REQUEST_RESULT"] = '1';
				$fields["ACTIVE_STATUS"] = '0';
				$fields["CREATE_BY"] = $USER_BY;
				$fields["UPDATE_BY"] = $USER_BY;
				$fields["CREATE_DATE"] = $TIMESTAMP;
				$fields["UPDATE_DATE"] = $TIMESTAMP;
				$fields["DELETE_FLAG"] = '0';
				$db->db_insert($table,$fields);	
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMePADDge();
		}
	break;
	
	case "approve" : 
		try{
			if(trim($ADDRESS_CHANGE) != ""){
				$Cond = " AND PADD_TYPE IN (".stripslashes($ADDRESS_CHANGE).") ";
			}
			if($REQUEST_RESULT == '2'){
				unset($fields);
				$fields = array("ACTIVE_STATUS" => '0');
				$db->db_update($table, $fields," PER_ID = '".$PER_ID."' ".$Cond); 
			}
			
			unset($fields);
			$fields = array(
				"REQUEST_STATUS" => '2',
				"REQUEST_RESULT" => ctext($REQUEST_RESULT),
				"ACTIVE_STATUS" => $REQUEST_RESULT=='2'?'1':'0',
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table,$fields," REQUEST_ID = '".$REQUEST_ID."' AND PER_ID = '".$PER_ID."' ".$Cond);
			
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
?>
<form name="form_back" method="post" action="../profile_approvehis.php">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>