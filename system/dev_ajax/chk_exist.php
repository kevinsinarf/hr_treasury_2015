<?php
// chk_exist.php
// return exist or not to ajax 

 
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

//$url_back="../profile_absent.php";
//$table="PER_LEAVEHIS"; 

$table = $_POST['table_is'];
$wh_f1 = $_POST['wh_f1'];
$wh_v1 = $_POST['wh_v1'];
$wh_f2 = $_POST['wh_f2'];
$wh_v2 = $_POST['wh_v2'];

if($table=="1"){
	$table="PER_LEAVEHIS";
}

if($table=="2"){
	$table="PER_CERTIFICATEHIS";
}

$sql_chk = "select count(*) as nums from ".$table." ";
$sql_chk .= "  where "; 
if(isset($wh_f1)){
	$sql_chk .= "  {$wh_f1} = '{$wh_v1}' ";
}
if(isset($wh_f2)){
	$sql_chk .= " AND  {$wh_f2} = '{$wh_v2}' ";
} 
if(isset($wh_f3)){
    $sql_chk .= " AND {$wh_f3} NOT IN ( {$wh_v3} )";
	   
}
  //echo $sql_chk; exit();
$chk = $db->get_data_field($sql_chk,"nums");   
echo (int)$chk; exit();
/*
$arr = array(
	"flag"=> (!$chk) ? 0:1,
	"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
);
echo json_encode($arr); exit();
echo (int)$chk; exit();
*/
if($chk==1){
 
 
}else{

}
// 192.168.0.223/disaster/system/dev_ajax/chk_exist.php?bWVudV9pZCUzRDEwJTI2bWVudV9zdWJfaWQlM0Q1NTY=
?>