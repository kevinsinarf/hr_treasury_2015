<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

switch($proc){
	
	case "getTitle" :
		$sql_title= $db->query("select * from SETUP_PREFIX where PREFIX_ID='".$_POST['PREFIX_ID']."' ");
		$num_title = $db->db_num_rows($sql_title);
		$data_title = $db->db_fetch_array($sql_title);
		
		echo $data_title['PREFIX_NAME_EN'];
	break;
}

?>