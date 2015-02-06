<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$arr_min = $_POST['min_money'];
$arr_max = $_POST['max_money'];

$table="SETUP_POS_LEVEL_SALARY";

/*echo "<pre>";
print_r($arr_min);
echo "</pre>";
exit;*/
switch($proc){
	case "add" : 
		try{
			$db->db_delete($table," POSTYPE_ID = 3 ");
			foreach($arr_max as $index => $value){
				$LEVEL_SALARY_MID = (str_replace(',','',$arr_min[$index])+str_replace(',','',$value))/2;
				$fields = array(
					"LEVEL_ID"=> $index,
					"LEVEL_SALARY_MIN" => str_replace(',','',$arr_min[$index]),
					"LEVEL_SALARY_MAX" => str_replace(',','',$value),
					"LEVEL_SALARY_MID" => $LEVEL_SALARY_MID,
					"ACTIVE_STATUS" => 1,
					"POSTYPE_ID" => 3,
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
$url_back="../pos_employess_salary_disp.php";
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
