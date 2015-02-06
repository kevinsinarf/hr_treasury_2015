<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

//POST
$table=trim($_POST['table']);
$pk_name=$_POST['pk_name'];
$pk_val=$_POST['pk_val'];
$data_name=$_POST['data_name']; 
$data_val=$_POST['data_val'];
$detail_data=trim($_POST['detail_data']);
if($detail_data){
	$_wh="";
	$detail=explode("&",$detail_data);
	foreach($detail as $k => $v){
		$_wh.=" and {$v}";
	}
}

$filter = "";
if($pk_val != ""){
	$filter = " and ".$pk_name." != '".ctext($pk_val)."' ";
}

//$aa= "select count(*) as nums from ".$table." where ".$data_name." = '".ctext($data_val)."' ".$_wh.$filter;
$sql_test = "select count(*) as nums from ".$table." where ".$data_name." = '".ctext($data_val)."' ".$_wh.$filter;   echo json_encode($sql_test); exit();
$chk = $db->get_data_field($sql_test,"nums");
$arr = array(
	"flag"=> (!$chk) ? 0:1,
	"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
	"sql"=>$sql_test
	//"aa"=>$aa
);
echo json_encode($arr);
?>