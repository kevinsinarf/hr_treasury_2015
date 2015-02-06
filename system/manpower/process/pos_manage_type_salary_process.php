<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$arr_min = $_POST['min_money'];
$arr_max = $_POST['max_money'];
$arr_avg = $_POST['avg_money'];

$table="SETUP_POS_LEVEL_SALARY";

/*echo "<pre>";
print_r($arr_min);
echo "</pre>";
exit;*/
switch($proc){
	case "add" : 
		try{
			$db->db_delete($table," POSTYPE_ID = 1 ");
			foreach($arr_max as $index => $value){
				$min = str_replace(",","",$arr_min[$index]);
				$mid = str_replace(",","",$arr_avg[$index]);
				$max = str_replace(",","",$value);
				$arr_id = explode("/",$index);
				$type_id  = $arr_id[0];
				$level_id = $arr_id[1];
				$salary_id = $arr_id[2];
			  $fields = array(
				"TYPE_ID"=> $type_id,
				"LEVEL_ID"=> $level_id,
				"SALARYTITLE_ID"=> $salary_id,
				"LEVEL_SALARY_MIN" => $min,
				"LEVEL_SALARY_MID" => $mid,
				"LEVEL_SALARY_MAX" => $max,
				"ACTIVE_STATUS" => 1,
				"POSTYPE_ID" => 1,
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE"=>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			  );
			  $db->db_insert($table,$fields);
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
}
$url_back="../pos_level_salary_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
