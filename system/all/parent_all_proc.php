<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");

//POST
$proc=$_POST['proc'];
$span=$_POST['span'];
$name=$_POST['name'];
$i=$_POST['i'];

$f_id=$_POST['f_id'];
$f_name=$_POST['f_name'];
$table=$_POST['table'];
$cond=$_POST['cond'];
$order=$_POST['order'];
$title=$_POST['title'];
$t_parent=$_POST['t_parent'];

if($cond=='DEF_ID=' && $name=='s_dec'){
    $cond="DEC_ID=57";
    $title='';
}

if($cond){
	$_wh="";
	$detail=explode("&",$cond);
	foreach($detail as $k => $v){
		$detail2=@explode("=",$v);
		if(count($detail2)>1){
			$_wh.=" and ".$detail2[0]."='".$detail2[1]."'";
		}else{
			$_wh.=" and {$v}";
		}		
	}
	$_wh.=" and ACTIVE_STATUS='1' and DELETE_FLAG='0'";
}
//array
//echo "select {$f_id},{$f_name} from {$table} where 1=1 {$_wh} order by {$order} ";exit;
$arr_parent=GetSqlSelectArray($f_id, $f_name, $table, "1=1 ".$_wh, $order);

$onchange='';
if($t_parent=='group_pos'){//กรณีมี 3 ระดับ fix ของ กลุ่มประเภทตำแหน่ง/กลุ่มตำแหน่ง /ตำแหน่ง 
	//$onchange='getParent(\'parent2\',\'s_pos\',\'\',\'SPPOS_ID\',\'SPPOS_NAME_TH\',\'SP_POSITION\',\'SPGROUP_ID=\'+$(this).val(),\''.$order.'\',\''.($title?$title:$arr_txt['sp_pos']).'\', \'group_pos_cond\');';
	$onchange='getParent(\'parent2\',\'s_pos\',\'\',\'SPPOS_ID\',\'SPPOS_NAME_TH\',\'SP_POSITION\',\'SPGROUP_ID=\'+$(this).val(),\'SPPOS_NAME_TH\',\''.$arr_txt['sp_pos'].'\', \'group_pos_cond\');';
}elseif($t_parent=='group_pos_cond'){
	$onchange='getSalary(this.value);';
}elseif($t_parent=='ss_tamb'){//กรณีมี 3 ระดับ fix ของ จังหวัด/อำเภอ /ตำบล 
	$onchange='getParent(\'ss_tamb\',\'s_tamb\',\'\',\'TAMB_ID\',\'TAMB_NAME_TH\',\'SETUP_TAMB\',\'AMPR_ID=\'+$(this).val(),\'TAMB_NAME_TH\',\'ตำบล/แขวง\', \'\');';
}
//select
echo GetHtmlSelect($name.$i,$name.($i?"[".$i."]":""),$arr_parent,($title?$title:''),'','onchange="'.$onchange.'"','','1');
?>