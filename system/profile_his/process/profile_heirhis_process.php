<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
$url_back="../profile_heirhis_disp.php";
//POST
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
$HEIR_ID=$_POST['HEIR_ID'];
$HEIRDESC_ID = $_POST['HEIRDESC_ID'];
$HEIR_WRITE = ctext($_POST['HEIR_WRITE']);
$HEIR_SDATE = conv_date_db($_POST['HEIR_SDATE']);
$HEIR_TYPE_FORM = $_POST['HEIR_TYPE_FORM'];
$HEIR_TYPE_SALARY = $_POST['HEIR_TYPE_SALARY'];
$HEIR_SALARY = str_replace(',','',$_POST['HEIR_SALARY']);
$HEIR_TOTAL = $_POST['HEIR_TOTAL'];

//DETAIL
$HEIRDESC_IDTYPE = $_POST['HEIRDESC_IDTYPE'];
if($HEIRDESC_IDTYPE == 1){
	$HEIRDESC_IDCARD = str_replace('-','',$_POST['HEIRDESC_IDCARD1']);
}else{
	$HEIRDESC_IDCARD = str_replace('-','',$_POST['HEIRDESC_IDCARD2']);
}
$HEIRDESC_BIRTHDATE = conv_date_db($_POST['HEIRDESC_BIRTHDATE']);
$PREFIX_ID = $_POST['PREFIX_ID'];
$HEIRDESC_FIRSTNAME_TH = ctext($_POST['HEIRDESC_FIRSTNAME_TH']);
$HEIRDESC_MIDNAME_TH = ctext($_POST['HEIRDESC_MIDNAME_TH']);
$HEIRDESC_LASTNAME_TH = ctext($_POST['HEIRDESC_LASTNAME_TH']);
$HEIRDESC_FIRSTNAME_EN = ctext($_POST['HEIRDESC_FIRSTNAME_EN']);
$HEIRDESC_MIDNAME_EN = ctext($_POST['HEIRDESC_MIDNAME_EN']);
$HEIRDESC_LASTNAME_EN = ctext($_POST['HEIRDESC_LASTNAME_EN']);
$HEIRDESC_GENDER = $_POST['HEIRDESC_GENDER'];
$HEIRDESC_NATION_ID  = $_POST['HEIRDESC_NATION_ID'];
$HEIRDESC_RACE_NATION_ID = $_POST['HEIRDESC_RACE_NATION_ID'];
$HEIRDESC_RELIGION_ID = $_POST['HEIRDESC_RELIGION_ID'];
$HEIRDESC_PART = $_POST['HEIRDESC_PART'];
$HEIR_FILLE = $_FILES['HEIR_FILLE'];
$ADDRESS_COUNTRY_ID = $_POST['ADDRESS_COUNTRY_ID'];
$ADDRESS_CITY = ctext($_POST['ADDRESS_CITY']);
$ADDRESS_ROOM_NO = ctext($_POST['ADDRESS_ROOM_NO']);
$ADDRESS_FLOOR = ctext($_POST['ADDRESS_FLOOR']);
$ADDRESS_BUILDING = ctext($_POST['ADDRESS_BUILDING']);
$ADDRESS_HOME_NO = $_POST['ADDRESS_HOME_NO'];
$ADDRESS_MOO = $_POST['ADDRESS_MOO'];
$ADDRESS_VILLAGE = ctext($_POST['ADDRESS_VILLAGE']);
$ADDRESS_SOI = ctext($_POST['ADDRESS_SOI']);
$ADDRESS_ROAD = ctext($_POST['ADDRESS_ROAD']);
$ADDRESS_TAMB_ID = $_POST['ADDRESS_TAMB_ID'];
$ADDRESS_AMPR_ID = $_POST['ADDRESS_AMPR_ID'];
$ADDRESS_PROV_ID = $_POST['ADDRESS_PROV_ID'];
$ADDRESS_ZIPCODE = $_POST['ADDRESS_ZIPCODE'];
$ADDRESS_TEL = str_replace('-','',$_POST['ADDRESS_TEL']);
$ADDRESS_TEL_EXT = $_POST['ADDRESS_TEL_EXT'];
$ADDRESS_FAX = str_replace('-','',$_POST['ADDRESS_FAX']);
$ADDRESS_FAX_EXT = $_POST['ADDRESS_FAX_EXT'];
$ADDRESS_MOBILE = str_replace('-','',$_POST['ADDRESS_MOBILE']);
$ADDRESS_EMAIL = $_POST['ADDRESS_EMAIL'];

$TB="PER_HEIRHIS";
$TB1 = "PER_HEIRHIS_DESC";
$path_a = $path.'fileupload/profile_his/';

switch($proc){
	case 'add_head' :
	
	$C_HEIR_FILLE = 'NULL';
	if(!empty($HEIR_FILLE['name'])){
		$C_HEIR_FILLE = getFilenameUplaod($HEIR_FILLE, $path_a, $OLD_HEIR_FILLE);
	}
	if($HEIR_TYPE_FORM == 2){
		$query_old = $db->query("SELECT TOP 1 HEIR_ID, HEIR_SDATE  FROM PER_HEIRHIS WHERE PER_ID = '".$PER_ID."' ORDER BY HEIR_ID DESC ");
		$rec_old  = $db->db_fetch_array($query_old);
		$HEIR_ID_OLD = $rec_old['HEIR_ID'];
		$fields = array(
			'PER_ID' => $PER_ID,
			'HEIR_WRITE' => $HEIR_WRITE,
			'HEIR_SDATE' => $HEIR_SDATE,
			'HEIR_TYPE_SALARY' => $HEIR_TYPE_SALARY,
			'HEIR_TYPE_FORM' => $HEIR_TYPE_FORM,
			'HEIR_SALARY' => $HEIR_SALARY,
			'HEIR_TOTAL' => $HEIR_TOTAL,
			'HEIR_SDATE_REPLACE' => $rec_old['HEIR_SDATE'], 
			'HEIR_FILLE' => $C_HEIR_FILLE,
			'DELETE_FLAG' => 0,
			'ACTIVE_STATUS' => 1,
			"CREATE_BY" => $USER_BY,
			"CREATE_DATE" => $TIMESTAMP
		);
		$db->db_insert($TB,$fields);
	}else{
		 $fields = array(
	  		'PER_ID' => $PER_ID,
			'HEIR_WRITE' => $HEIR_WRITE,
			'HEIR_SDATE' => $HEIR_SDATE,
			'HEIR_TYPE_SALARY' => $HEIR_TYPE_SALARY,
			'HEIR_TYPE_FORM' => $HEIR_TYPE_FORM,
			'HEIR_SALARY' => $HEIR_SALARY,
			'HEIR_TOTAL' => $HEIR_TOTAL,
			'HEIR_FILLE' => $C_HEIR_FILLE,
			'DELETE_FLAG' => 0,
			'ACTIVE_STATUS' => 1,
			"CREATE_BY" => $USER_BY,
			"CREATE_DATE"=>$TIMESTAMP
	   );
		$db->db_insert($TB,$fields);
	}
	
	 
	  $query = $db->query("SELECT MAX(HEIR_ID) AS HEIR_MAX FROM PER_HEIRHIS ");
	  $rec = $db->db_fetch_array($query);
	  $HEIR_ID = $rec['HEIR_MAX'];
	  if($HEIR_TYPE_FORM == 2){
		  $query_per = $db->query("SELECT * FROM PER_HEIRHIS_DESC WHERE HEIR_ID = '".$HEIR_ID_OLD."' ");
		  $db->db_update($TB, array('ACTIVE_STATUS' => '0'), " HEIR_ID = '".$HEIR_ID_OLD."' "); 
		  
		  while($rec_per = $db->db_fetch_array($query_per)){
			   $fields = array(
				  'HEIR_ID' => $HEIR_ID,
				  'HEIRDESC_IDTYPE' => $rec_per['HEIRDESC_IDTYPE'],
				  'HEIRDESC_IDCARD' => $rec_per['HEIRDESC_IDCARD'],
				  'PREFIX_ID' => $rec_per['PREFIX_ID'],
				  'HEIRDESC_BIRTHDATE' => $rec_per['HEIRDESC_BIRTHDATE'],
				  'HEIRDESC_FIRSTNAME_TH' => $rec_per['HEIRDESC_FIRSTNAME_TH'],
				  'HEIRDESC_MIDNAME_TH' => $rec_per['HEIRDESC_MIDNAME_TH'],
				  'HEIRDESC_LASTNAME_TH' => $rec_per['HEIRDESC_LASTNAME_TH'],
				  'HEIRDESC_FIRSTNAME_EN' => $rec_per['HEIRDESC_FIRSTNAME_EN'],
				  'HEIRDESC_MIDNAME_EN' => $rec_per['HEIRDESC_MIDNAME_EN'],
				  'HEIRDESC_LASTNAME_EN' => $rec_per['HEIRDESC_LASTNAME_EN'],
				  'HEIRDESC_GENDER' => $rec_per['HEIRDESC_GENDER'],
				  'HEIRDESC_NATION_ID' => $rec_per['HEIRDESC_NATION_ID'],
				  'HEIRDESC_RACE_NATION_ID' => $rec_per['HEIRDESC_RACE_NATION_ID'],
				  'HEIRDESC_RELIGION_ID' => $rec_per['HEIRDESC_RELIGION_ID'],
				  'HEIRDESC_PART' => $rec_per['HEIRDESC_PART'],
				  'ADDRESS_COUNTRY_ID' => $rec_per['ADDRESS_COUNTRY_ID'],
				  'ADDRESS_CITY' => $rec_per['ADDRESS_CITY'],
				  'ADDRESS_ROOM_NO' => $rec_per['ADDRESS_ROOM_NO'],
				  'ADDRESS_FLOOR' => $rec_per['ADDRESS_FLOOR'],
				  'ADDRESS_BUILDING' => $rec_per['ADDRESS_BUILDING'],
				  'ADDRESS_HOME_NO' => $rec_per['ADDRESS_HOME_NO'],
				  'ADDRESS_MOO' => $rec_per['ADDRESS_MOO'],
				  'ADDRESS_VILLAGE' => $rec_per['ADDRESS_VILLAGE'],
				  'ADDRESS_SOI' => $rec_per['ADDRESS_SOI'],
				  'ADDRESS_ROAD' => $rec_per['ADDRESS_ROAD'],
				  'ADDRESS_TAMB_ID' => $rec_per['ADDRESS_TAMB_ID'],
				  'ADDRESS_AMPR_ID' => $rec_per['ADDRESS_AMPR_ID'],
				  'ADDRESS_PROV_ID' => $rec_per['ADDRESS_PROV_ID'],
				  'ADDRESS_ZIPCODE' => $rec_per['ADDRESS_ZIPCODE'],
				  'ADDRESS_TEL' => $rec_per['ADDRESS_TEL'],
				  'ADDRESS_TEL_EXT' => $rec_per['ADDRESS_TEL_EXT'],
				  'ADDRESS_FAX' => $rec_per['ADDRESS_FAX'],
				  'ADDRESS_FAX_EXT' => $rec_per['ADDRESS_FAX_EXT'],
				  'ADDRESS_MOBILE' => $rec_per['ADDRESS_MOBILE'],
				  'ADDRESS_EMAIL' => $rec_per['ADDRESS_EMAIL'],
				  "CREATE_BY" => $USER_BY,
				  "CREATE_DATE"=>$TIMESTAMP
			);
			$db->db_insert($TB1,$fields);
		  }

	  }
	  
	  $url_back="../profile_heirhis_form.php";
	  $text=$save_proc;
	break;
	case 'add_per' :
	try{	
		  $fields = array(
		      'HEIR_ID' => $HEIR_ID,
			  'HEIRDESC_IDTYPE' => $HEIRDESC_IDTYPE,
			  'HEIRDESC_IDCARD' => $HEIRDESC_IDCARD,
			  'PREFIX_ID' => $PREFIX_ID,
			  'HEIRDESC_BIRTHDATE' => $HEIRDESC_BIRTHDATE,
			  'HEIRDESC_FIRSTNAME_TH' => $HEIRDESC_FIRSTNAME_TH,
			  'HEIRDESC_MIDNAME_TH' => $HEIRDESC_MIDNAME_TH,
			  'HEIRDESC_LASTNAME_TH' => $HEIRDESC_LASTNAME_TH,
			  'HEIRDESC_FIRSTNAME_EN' => $HEIRDESC_FIRSTNAME_EN,
			  'HEIRDESC_MIDNAME_EN' => $HEIRDESC_MIDNAME_EN,
			  'HEIRDESC_LASTNAME_EN' => $HEIRDESC_LASTNAME_EN,
			  'HEIRDESC_GENDER' => $HEIRDESC_GENDER,
			  'HEIRDESC_NATION_ID' => $HEIRDESC_NATION_ID,
			  'HEIRDESC_RACE_NATION_ID' => $HEIRDESC_RACE_NATION_ID,
			  'HEIRDESC_RELIGION_ID' => $HEIRDESC_RELIGION_ID,
			  'HEIRDESC_PART' => $HEIRDESC_PART,
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
			  'ADDRESS_TAMB_ID' => $ADDRESS_TAMB_ID,
			  'ADDRESS_AMPR_ID' => $ADDRESS_AMPR_ID,
			  'ADDRESS_PROV_ID' => $ADDRESS_PROV_ID,
			  'ADDRESS_ZIPCODE' => $ADDRESS_ZIPCODE,
			  'ADDRESS_TEL' => $ADDRESS_TEL,
			  'ADDRESS_TEL_EXT' => $ADDRESS_TEL_EXT,
			  'ADDRESS_FAX' => $ADDRESS_FAX,
			  'ADDRESS_FAX_EXT' => $ADDRESS_FAX_EXT,
			  'ADDRESS_MOBILE' => $ADDRESS_MOBILE,
			  'ADDRESS_EMAIL' => $ADDRESS_EMAIL,
			  "CREATE_BY" => $USER_BY,
			  "CREATE_DATE"=>$TIMESTAMP
		  );
		  $db->db_insert($TB1,$fields);
		  $url_back="../profile_heirhis_form.php";
	  	  $text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'edit_per':
	try{	
		$fields = array(
			  'HEIRDESC_IDTYPE' => $HEIRDESC_IDTYPE,
			  'HEIRDESC_IDCARD' => $HEIRDESC_IDCARD,
			  'PREFIX_ID' => $PREFIX_ID,
			  'HEIRDESC_BIRTHDATE' => $HEIRDESC_BIRTHDATE,
			  'HEIRDESC_FIRSTNAME_TH' => $HEIRDESC_FIRSTNAME_TH,
			  'HEIRDESC_MIDNAME_TH' => $HEIRDESC_MIDNAME_TH,
			  'HEIRDESC_LASTNAME_TH' => $HEIRDESC_LASTNAME_TH,
			  'HEIRDESC_FIRSTNAME_EN' => $HEIRDESC_FIRSTNAME_EN,
			  'HEIRDESC_MIDNAME_EN' => $HEIRDESC_MIDNAME_EN,
			  'HEIRDESC_LASTNAME_EN' => $HEIRDESC_LASTNAME_EN,
			  'HEIRDESC_GENDER' => $HEIRDESC_GENDER,
			  'HEIRDESC_NATION_ID' => $HEIRDESC_NATION_ID,
			  'HEIRDESC_RACE_NATION_ID' => $HEIRDESC_RACE_NATION_ID,
			  'HEIRDESC_RELIGION_ID' => $HEIRDESC_RELIGION_ID,
			  'HEIRDESC_PART' => $HEIRDESC_PART,
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
			  'ADDRESS_TAMB_ID' => $ADDRESS_TAMB_ID,
			  'ADDRESS_AMPR_ID' => $ADDRESS_AMPR_ID,
			  'ADDRESS_PROV_ID' => $ADDRESS_PROV_ID,
			  'ADDRESS_ZIPCODE' => $ADDRESS_ZIPCODE,
			  'ADDRESS_TEL' => $ADDRESS_TEL,
			  'ADDRESS_TEL_EXT' => $ADDRESS_TEL_EXT,
			  'ADDRESS_FAX' => $ADDRESS_FAX,
			  'ADDRESS_FAX_EXT' => $ADDRESS_FAX_EXT,
			  'ADDRESS_MOBILE' => $ADDRESS_MOBILE,
			  'ADDRESS_EMAIL' => $ADDRESS_EMAIL,
			  "UPDATE_BY" => $USER_BY,
			  "UPDATE_DATE"=>$TIMESTAMP
		  );
		  $db->db_update($TB1, $fields, " HEIRDESC_ID = '".$HEIRDESC_ID."' "); 
		   $url_back="../profile_heirhis_form.php";
	  	  $text=$edit_proc;
	}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'edit_head' :
	try{	
	
		$C_HEIR_FILLE = 'NULL';
		$C_HEIR_FILLE = getFilenameUplaod($HEIR_FILLE, $path_a, $OLD_HEIR_FILLE);
		  $fields = array(
			  'HEIR_WRITE' => $HEIR_WRITE,
			  'HEIR_SDATE' => $HEIR_SDATE,
			  'HEIR_TYPE_SALARY' => $HEIR_TYPE_SALARY,
			  'HEIR_TYPE_FORM' => $HEIR_TYPE_FORM,
			  'HEIR_SALARY' => $HEIR_SALARY,
			  'HEIR_TOTAL' => $HEIR_TOTAL,
			  'HEIR_FILLE' => $C_HEIR_FILLE,
			  "UPDATE_BY" => $USER_BY,
			  "UPDATE_DATE"=>$TIMESTAMP
	   );
	   $db->db_update($TB, $fields, " HEIR_ID = '".$HEIR_ID."' "); 
	   $url_back="../profile_heirhis_form.php";
	   $text=$edit_proc;
	 }catch(Exception $e){
			$text=$e->getMessage();
	}
	break;
	case "delete_per" : 
		try{	
			$db->db_delete($TB1," HEIRDESC_ID = '".$HEIRDESC_ID."' ");
			$text=$del_proc;
			$url_back="../profile_heirhis_form.php";
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," HEIR_ID = '".$HEIR_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'getApmr' :
	  $PROV_ID = $_POST['prov_id'];
	  $obj = array();
	  $query = $db->query("SELECT AMPR_ID, AMPR_NAME_TH FROM SETUP_AMPR WHERE PROV_ID= '".$PROV_ID."' AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY AMPR_NAME_TH ASC ");
	  while($rec = $db->db_fetch_array($query)){
		  $row['ID'] = $rec['AMPR_ID'];
		  $row['VALUE'] = text($rec['AMPR_NAME_TH']);
		  array_push($obj,$row);
	  }
	  echo json_encode($obj);
	  exit;
	break;
	case 'getTamb' :
	  $AMPR_ID = $_POST['ampr_id'];
	  $obj = array();
	  $query = $db->query("SELECT TAMB_ID, TAMB_NAME_TH FROM SETUP_TAMB WHERE AMPR_ID= '".$AMPR_ID."' AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY TAMB_NAME_TH ASC ");
	  while($rec = $db->db_fetch_array($query)){
		  $row['ID'] = $rec['TAMB_ID'];
		  $row['VALUE'] = text($rec['TAMB_NAME_TH']);
		  array_push($obj,$row);
	  }
	  echo json_encode($obj);
	  exit;
	break;
	case 'getZipcode' :
	  $TAMB_ID = $_POST['tamb_id'];
	  $query = $db->query("SELECT TAMB_ZIPCODE FROM SETUP_TAMB WHERE TAMB_ID = '".$TAMB_ID."' AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY TAMB_NAME_TH ASC ");
	  while($rec = $db->db_fetch_array($query)){
		  $row['VALUE'] = text($rec['TAMB_ZIPCODE']);
	  }
	  echo json_encode($row);
	  exit;
	break;
	
}

?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="HEIR_ID" name="HEIR_ID" value="<?php echo $HEIR_ID; ?>">
    
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>

