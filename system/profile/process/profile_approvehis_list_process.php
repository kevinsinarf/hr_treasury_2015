<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$TABLE_ID = $_POST["TABLE_ID"];

//url ข้อมูลที่ขอเปลี่ยนแปลง
$arr_url=array(
	"" => "profile_approvehis_form.php" ,
	"PER_ADDRESS" => "profile_approvehis_address_form.php" ,
	"PER_EDUCATEHIS" => "profile_approvehis_educatehis_form.php" ,
	"PER_MARRYHIS" => "profile_approvehis_marryhis_form.php" ,
	"PER_NAMEHIS" => "profile_approvehis_namehis_form.php" ,
	);

switch($proc){
	case "getTablename" :
		try{
			$table_name = $db->get_data_field("select TABLE_NAME from PER_TABLE_LIST where TABLE_ID = '".$TABLE_ID."' ","TABLE_NAME");
			
			echo $arr_url[$table_name];
			
		}catch(Exception $e){
			
		}
	break;
}