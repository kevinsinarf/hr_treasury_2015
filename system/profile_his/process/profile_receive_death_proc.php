<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$FAMILY_ID = $_POST['FAMILY_ID'];
$PER_ID=$_POST['PER_ID'];
$FAMILY_DATE = conv_date_db($_POST['FAMILY_DATE']);
$FAMILY_IDTYPE = $_POST['FAMILY_IDTYPE'];
$FAMILY_BIRTHDATE = conv_date_db($_POST['FAMILY_BIRTHDATE']);
$FAMILY_PREFIX_ID = $_POST['FAMILY_PREFIX_ID'];
$FAMILY_FIRSTNAME_TH = ctext($_POST['FAMILY_FIRSTNAME_TH']);
$FAMILY_FIRSTNAME_EN = ctext($_POST['FAMILY_FIRSTNAME_EN']);
$FAMILY_MIDNAME_TH = ctext($_POST['FAMILY_MIDNAME_TH']);
$FAMILY_MIDNAME_EN = ctext($_POST['FAMILY_MIDNAME_EN']);
$FAMILY_LASTNAME_TH = ctext($_POST['FAMILY_LASTNAME_TH']);
$FAMILY_LASTNAME_EN = ctext($_POST['FAMILY_LASTNAME_EN']);
$FAMILY_GENDER = $_POST['FAMILY_GENDER'];
$FAMILY_NATION_ID = $_POST['FAMILY_NATION_ID'];
$FAMILY_RACE_NATION_ID = $_POST['FAMILY_RACE_NATION_ID'];
$FAMILY_RELIGION_ID = $_POST['FAMILY_RELIGION_ID'];
$FAMILY_JOB_ID = $_POST['FAMILY_JOB_ID'];
$FAMILY_JOB_OTHER = ctext($_POST['FAMILY_JOB_OTHER']);
$FAMILY_STATUS = $_POST['FAMILY_STATUS'];
$FAMILY_FILE = $_FILES['FAMILY_FILE'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];
$ADDRESS_COUNTRY_ID = $_POST['ADDRESS_COUNTRY_ID'];
$ADDRESS_CITY = ctext($_POST['ADDRESS_CITY']);
$ADDRESS_ROOM_NO = ctext($_POST['ADDRESS_ROOM_NO']);
$ADDRESS_FLOOR = ctext($_POST['ADDRESS_FLOOR']);
$ADDRESS_BUILDING = ctext($_POST['ADDRESS_BUILDING']);
$ADDRESS_HOME_NO = ctext($_POST['ADDRESS_HOME_NO']);
$ADDRESS_MOO = ctext($_POST['ADDRESS_MOO']);
$ADDRESS_VILLAGE = ctext($_POST['ADDRESS_VILLAGE']);
$ADDRESS_SOI = ctext($_POST['ADDRESS_SOI']);
$ADDRESS_ROAD = ctext($_POST['ADDRESS_ROAD']);
$ADDRESS_PROV_ID = $_POST['ADDRESS_PROV_ID'];
$ADDRESS_AMPR_ID = $_POST['ADDRESS_AMPR_ID'];
$ADDRESS_TAMB_ID = $_POST['ADDRESS_TAMB_ID'];
$ADDRESS_POSTCODE = $_POST['ADDRESS_POSTCODE'];
$ADDRESS_TEL = $_POST['ADDRESS_TEL'];
$ADDRESS_TEL_EXT = $_POST['ADDRESS_TEL_EXT'];
$ADDRESS_FAX = $_POST['ADDRESS_FAX'];
$ADDRESS_FAX_EXT = $_POST['ADDRESS_FAX_EXT'];
$ADDRESS_MOBILE = $_POST['ADDRESS_MOBILE'];
$ADDRESS_EMAIL = $_POST['ADDRESS_EMAIL'];

if($_POST['FAMILY_IDCARD1']!=""){
	$FAMILY_IDCARD = $_POST['FAMILY_IDCARD1'];
}else{
	$FAMILY_IDCARD = $_POST['FAMILY_IDCARD2'];
}

$table="PER_FAMILY";
$path_a = $path.'fileupload/profile_his/';

switch($proc){
	case "add" : 
		try{
			if($ACTIVE_STATUS == 1){
				unset($fields2);
				$fields2 = array('ACTIVE_STATUS' => 0);
				$db->db_update('PER_FAMILY', $fields2," PER_ID = '".$PER_ID."' AND FAMILY_RELATIONSHIP = '6'"); 
			}			
			
			$C_FAMILY_FILE = 'NULL';
			if(!empty($FAMILY_FILE['name'])){
				$C_FAMILY_FILE = getFilenameUplaod($FAMILY_FILE, $path_a, $OLD_FAMILY_FILE);
			}
			$fields = array(
				'PER_ID' => $PER_ID,
				'FAMILY_DATE' => $FAMILY_DATE,
				'FAMILY_IDTYPE' => $FAMILY_IDTYPE,
				'FAMILY_IDCARD' => str_replace("-","",$FAMILY_IDCARD),
				'FAMILY_BIRTHDATE' => $FAMILY_BIRTHDATE,
				'FAMILY_PREFIX_ID' => $FAMILY_PREFIX_ID,
				'FAMILY_FIRSTNAME_TH' => $FAMILY_FIRSTNAME_TH,
				'FAMILY_FIRSTNAME_EN' => $FAMILY_FIRSTNAME_EN,
				'FAMILY_MIDNAME_TH' => $FAMILY_MIDNAME_TH,
				'FAMILY_MIDNAME_EN' => $FAMILY_MIDNAME_EN,
				'FAMILY_LASTNAME_TH' => $FAMILY_LASTNAME_TH,
				'FAMILY_LASTNAME_EN' => $FAMILY_LASTNAME_EN,
				'FAMILY_RELATIONSHIP' => '6',
				'FAMILY_GENDER' => $FAMILY_GENDER,
				'FAMILY_NATION_ID' => $FAMILY_NATION_ID,
				'FAMILY_RACE_NATION_ID' => $FAMILY_RACE_NATION_ID,
				'FAMILY_RELIGION_ID' => $FAMILY_RELIGION_ID,
				'FAMILY_JOB_ID' => $FAMILY_JOB_ID,
				'FAMILY_JOB_OTHER' => $FAMILY_JOB_OTHER,
				'FAMILY_STATUS' => $FAMILY_STATUS,
				'FAMILY_FILE' => $C_FAMILY_FILE,
				'ACTIVE_STATUS' =>$ACTIVE_STATUS,
				'ADDRESS_COUNTRY_ID' => $ADDRESS_COUNTRY_ID,
				'ADDRESS_CITY' => $ADDRESS_CITY,
				'ADDRESS_ROOM_NO' => $ADDRESS_ROOM_NO,
				'ADDRESS_FLOOR' => $ADDRESS_FLOOR,
				'ADDRESS_BUILDING' => $ADDRESS_BUILDING,
				'ADDRESS_HOME_NO' => $ADDRESS_HOME_NO,
				'ADDRESS_MOO' => $ADDRESS_MOO,
				'ADDRESS_VILLAGE' => $ADDRESS_VILLAGE,
				'ADDRESS_SOI' => $ADDRESS_SOI,
				'ADDRESS_ROAD' => $ADDRESS_ROAD,
				'ADDRESS_PROV_ID' => $ADDRESS_PROV_ID,
				'ADDRESS_AMPR_ID' => $ADDRESS_AMPR_ID,
				'ADDRESS_TAMB_ID' => $ADDRESS_TAMB_ID,
				'ADDRESS_POSTCODE' => $ADDRESS_POSTCODE,
				'ADDRESS_TEL' => str_replace("-","",$ADDRESS_TEL),
				'ADDRESS_TEL_EXT' => str_replace("-","",$ADDRESS_TEL_EXT),
				'ADDRESS_FAX' => str_replace("-","",$ADDRESS_FAX),
				'ADDRESS_FAX_EXT' => str_replace("-","",$ADDRESS_FAX_EXT),
				'ADDRESS_MOBILE' => str_replace("-","",$ADDRESS_MOBILE),
				'ADDRESS_EMAIL' => $ADDRESS_EMAIL,
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
			if($ACTIVE_STATUS == 1){
				unset($fields2);
				$fields2 = array('ACTIVE_STATUS' => 0);
				$db->db_update('PER_FAMILY', $fields2," PER_ID = '".$PER_ID."' AND FAMILY_RELATIONSHIP = '6'"); 
			}
			
			$C_FAMILY_FILE = 'NULL';
			$C_FAMILY_FILE = getFilenameUplaod($FAMILY_FILE, $path_a, $OLD_FAMILY_FILE);
			
			unset($fields);
			$fields = array(
				'PER_ID' => $PER_ID,
				'FAMILY_DATE' => $FAMILY_DATE,
				'FAMILY_IDTYPE' => $FAMILY_IDTYPE,
				'FAMILY_IDCARD' => str_replace("-","",$FAMILY_IDCARD),
				'FAMILY_BIRTHDATE' => $FAMILY_BIRTHDATE,
				'FAMILY_PREFIX_ID' => $FAMILY_PREFIX_ID,
				'FAMILY_FIRSTNAME_TH' => $FAMILY_FIRSTNAME_TH,
				'FAMILY_FIRSTNAME_EN' => $FAMILY_FIRSTNAME_EN,
				'FAMILY_MIDNAME_TH' => $FAMILY_MIDNAME_TH,
				'FAMILY_MIDNAME_EN' => $FAMILY_MIDNAME_EN,
				'FAMILY_LASTNAME_TH' => $FAMILY_LASTNAME_TH,
				'FAMILY_LASTNAME_EN' => $FAMILY_LASTNAME_EN,
				'FAMILY_RELATIONSHIP' => '6',
				'FAMILY_GENDER' => $FAMILY_GENDER,
				'FAMILY_NATION_ID' => $FAMILY_NATION_ID,
				'FAMILY_RACE_NATION_ID' => $FAMILY_RACE_NATION_ID,
				'FAMILY_RELIGION_ID' => $FAMILY_RELIGION_ID,
				'FAMILY_JOB_ID' => $FAMILY_JOB_ID,
				'FAMILY_JOB_OTHER' => $FAMILY_JOB_OTHER,
				'FAMILY_STATUS' => $FAMILY_STATUS,
				'FAMILY_FILE' => $C_FAMILY_FILE,
				'ACTIVE_STATUS' =>$ACTIVE_STATUS,
				'ADDRESS_COUNTRY_ID' => $ADDRESS_COUNTRY_ID,
				'ADDRESS_CITY' => $ADDRESS_CITY,
				'ADDRESS_ROOM_NO' => $ADDRESS_ROOM_NO,
				'ADDRESS_FLOOR' => $ADDRESS_FLOOR,
				'ADDRESS_BUILDING' => $ADDRESS_BUILDING,
				'ADDRESS_HOME_NO' => $ADDRESS_HOME_NO,
				'ADDRESS_MOO' => $ADDRESS_MOO,
				'ADDRESS_VILLAGE' => $ADDRESS_VILLAGE,
				'ADDRESS_SOI' => $ADDRESS_SOI,
				'ADDRESS_ROAD' => $ADDRESS_ROAD,
				'ADDRESS_PROV_ID' => $ADDRESS_PROV_ID,
				'ADDRESS_AMPR_ID' => $ADDRESS_AMPR_ID,
				'ADDRESS_TAMB_ID' => $ADDRESS_TAMB_ID,
				'ADDRESS_POSTCODE' => $ADDRESS_POSTCODE,
				'ADDRESS_TEL' => $ADDRESS_TEL,
				'ADDRESS_EMAIL' => $ADDRESS_EMAIL,
				'ADDRESS_TEL' => str_replace("-","",$ADDRESS_TEL),
				'ADDRESS_TEL_EXT' => str_replace("-","",$ADDRESS_TEL_EXT),
				'ADDRESS_FAX' => str_replace("-","",$ADDRESS_FAX),
				'ADDRESS_FAX_EXT' => str_replace("-","",$ADDRESS_FAX_EXT),
				'ADDRESS_MOBILE' => str_replace("-","",$ADDRESS_MOBILE),
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" =>$USER_BY,
				"CREATE_DATE"=>$TIMESTAMP,
				"UPDATE_DATE" =>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			);
			$db->db_update($table,$fields," FAMILY_ID = '".$FAMILY_ID."' "); 
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{	
			$db->db_delete($table," FAMILY_ID = '".$FAMILY_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "rampr" : //อำเภอ
		try{
		$v_ampr=$_POST['v_ampr'];
		$sql = "Select AMPR_ID , AMPR_NAME_TH From SETUP_AMPR WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND PROV_ID = '".$v_ampr."' ORDER BY AMPR_NAME_TH ";
		$query = $db->query($sql);
		$obj = array();
		$option = "<select id=\"ADDRESS_AMPR_ID\" name=\"ADDRESS_AMPR_ID\" class=\"selectbox form-control\" placeholder=\"อำเภอ/เขต\"  onchange=\"getStamb(this.value);\">";
		$option .= "<option value=\"\" ></option>";
		while($rec = $db->db_fetch_array($query)){
/*			$row['ID'] = $rec['AMPR_ID'];
			$row['VALUE'] = text($rec['AMPR_NAME_TH']);*/
			$option .= "<option value=\"".$rec['AMPR_ID']."\" >".text($rec['AMPR_NAME_TH'])."</option>";
		}
		$option .= "</select>";
		echo $option; 
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "tamb" : //อำเภอ
		try{
		$v_Stamb=$_POST['v_Stamb'];
		$sql = "Select TAMB_ID , TAMB_NAME_TH From SETUP_TAMB WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND AMPR_ID  = '".$v_Stamb."' ORDER BY TAMB_NAME_TH ";
		$query = $db->query($sql);
		$obj = array();
		$option = "<select id=\"ADDRESS_TAMB_ID\" name=\"ADDRESS_TAMB_ID\" class=\"selectbox form-control\" placeholder=\"ตำบล\" onChange=\"getZipcode(this.value);\">";
		$option .= "<option value=\"\" ></option>";
		while($rec = $db->db_fetch_array($query)){
/*			$row['ID'] = $rec['AMPR_ID'];
			$row['VALUE'] = text($rec['AMPR_NAME_TH']);*/
			$option .= "<option value=\"".$rec['TAMB_ID']."\" >".text($rec['TAMB_NAME_TH'])."</option>";
		}
		$option .= "</select>";
		echo $option; 
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "zipcode" : //อำเภอ
		try{
		$v_Stamb=$_POST['zipcond'];
		$sql = "Select TAMB_ID , TAMB_ZIPCODE From SETUP_TAMB WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND TAMB_ID  = '".$v_Stamb."' ORDER BY TAMB_ZIPCODE ";
		$query = $db->query($sql);
		$rec = $db->db_fetch_array($query);
		$row['TAMB_ZIPCODE'] = $rec['TAMB_ZIPCODE'];
		echo json_encode($row);
		exit();
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "rampr2" : //อำเภอ
		try{
			$v_ampr2=$_POST['v_ampr'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$name_tamb=$_POST['name_tamb'];
			$val=$_POST['val'];
			
			$arr_amprr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_EN", "SETUP_AMPR", "PROV_ID='".$v_ampr2."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_EN");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_amprr,'อำเภอ/เขต',$val,'onchange="getStamb(this.id,this.value,\''.$name_tamb.'\')"','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_receive_death_disp.php";
if($proc=='rampr'||$proc=='tamb'){
		
}else{
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
<?php }	?>