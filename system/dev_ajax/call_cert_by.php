<?php
// chk_exist.php
// return exist or not to ajax 

 
 header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 

$id= (int)$_POST['id'];


$sql = "select   CERTIFICATE_BY from SETUP_CERTIFICATE WHERE CERTIFICATE_ID = '".$id."' ";
$query_cert_list = $db->query($sql);
 while($rec2 = $db->db_fetch_array($query_cert_list)){
     echo text($rec2['CERTIFICATE_BY']);
 } 
?>