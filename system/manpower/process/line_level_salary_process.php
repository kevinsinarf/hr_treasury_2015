<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$TYPE_ID = $_POST['TYPE_ID'];
$LINE_ID = $_POST['LINE_ID'];
$LG_ID = $_POST['LG_ID'];
$arr_min = $_POST['min_money'];
$arr_max = $_POST['max_money'];
$arr_avg = $_POST['avg_money'];


$TB="SETUP_POS_LINE_SALARY";


switch($proc){
	case "add" : 
		try{
			$db->db_delete($TB," LINE_ID = '".$LINE_ID."' ");
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
				"LG_ID" => $LG_ID,
				"LINE_ID" => $LINE_ID,
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
			  $db->db_insert($TB,$fields);
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'TransferNormal' :
	try{
		  $sql_step = "SELECT * FROM SETUP_POS_LEVEL_SALARY
							   WHERE TYPE_ID = '".$TYPE_ID."' AND SALARYTITLE_ID IN(1,2,6,7)";
		  $query_step = $db->query($sql_step);
		  $db->db_delete($TB," LINE_ID = '".$LINE_ID."' ");
		  while($rec = $db->db_fetch_array($query_step)){
			   $fields = array(
				  "TYPE_ID"=> $TYPE_ID,
				  "LEVEL_ID"=> $rec['LEVEL_ID'],
				  "LG_ID" => $LG_ID,
				  "LINE_ID" => $LINE_ID,
				  "SALARYTITLE_ID"=> $rec['SALARYTITLE_ID'],
				  "LEVEL_SALARY_MIN" => $rec['LEVEL_SALARY_MIN'],
				  "LEVEL_SALARY_MID" => $rec['LEVEL_SALARY_MID'],
				  "LEVEL_SALARY_MAX" => $rec['LEVEL_SALARY_MAX'],
				  "ACTIVE_STATUS" => 1,
				  "POSTYPE_ID" => 1,
				  "CREATE_BY" => $USER_BY,
				  "CREATE_DATE"=>$TIMESTAMP,
				  "DELETE_FLAG" =>'0'
			  );
			  $db->db_insert($TB,$fields);
		  }
		  
		  
		  $text=text("นำเข้าขั้นเงินเดือนเรียบร้อยแล้ว");
		}catch(Exception $e){
			$text=$e->getMessage();
		}
		
	break;
	case 'TransferSpecial' :
	try{
		  $sql_step = "SELECT * FROM SETUP_POS_LEVEL_SALARY
							   WHERE TYPE_ID = '".$TYPE_ID."' AND SALARYTITLE_ID IN(1,2,4,5)";
		  $query_step = $db->query($sql_step);
		  $db->db_delete($TB," LINE_ID = '".$LINE_ID."' ");
		  while($rec = $db->db_fetch_array($query_step)){
			   $fields = array(
				  "TYPE_ID"=> $TYPE_ID,
				  "LEVEL_ID"=> $rec['LEVEL_ID'],
				  "LG_ID" => $LG_ID,
				  "LINE_ID" => $LINE_ID,
				  "SALARYTITLE_ID"=> $rec['SALARYTITLE_ID'],
				  "LEVEL_SALARY_MIN" => $rec['LEVEL_SALARY_MIN'],
				  "LEVEL_SALARY_MID" => $rec['LEVEL_SALARY_MID'],
				  "LEVEL_SALARY_MAX" => $rec['LEVEL_SALARY_MAX'],
				  "ACTIVE_STATUS" => 1,
				  "POSTYPE_ID" => 1,
				  "CREATE_BY" => $USER_BY,
				  "CREATE_DATE"=>$TIMESTAMP,
				  "DELETE_FLAG" =>'0'
			  );
			  $db->db_insert($TB,$fields);
		  }
		  
		  
		  $text=text("นำเข้าขั้นเงินเดือนเรียบร้อยแล้ว");
		}catch(Exception $e){
			$text=$e->getMessage();
		}
		
	break;
}
$url_back="../line_level_salary_form.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input type="hidden" id="TYPE_ID" name="TYPE_ID" value="<?php echo $TYPE_ID;?>" />
    <input type="hidden" id="LINE_ID" name="LINE_ID" value="<?php echo $LINE_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
