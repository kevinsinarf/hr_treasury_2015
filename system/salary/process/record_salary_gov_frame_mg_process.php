<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$proc = $_REQUEST['proc'];
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$SALARY_NOW = $_POST['SALARY_NOW'];
$SALARY_FRAME = $_POST['SALARY_FRAME'];
$NUM_PER = $_POST['NUM_PER'];
$NUM1 = $_POST['NUM1'];

$url_back="../record_salary_gov_frame_mg_disp.php";
$table = "SAL_FRAME_MG";

switch($proc){	
	case 'save' :
		try{
			$db->db_delete("SAL_EVAL"," YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND POSTYPE_ID  = 1 AND EVAL_TYPE = 2  ");
			$fields_eval = array(
				"YEAR_BDG" => $S_YEAR_BDG,
				"ROUND" => $S_ROUND,
				"NUM1" => $NUM1,
				"POSTYPE_ID" => 1,
				"EVAL_TYPE" => 2,
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_insert("SAL_EVAL",$fields_eval);
			
			$db->db_delete($table," YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' ");
			if(count($LEVEL_ID) > 0){
				foreach($LEVEL_ID as $key => $LEVEL_ID){
					$fields = array(
						"YEAR_BDG" => $S_YEAR_BDG,
						"ROUND" => $S_ROUND,
						"LEVEL_ID" => $LEVEL_ID,
						"SALARY_NOW" => str_replace(",","",$SALARY_NOW[$key]),
						"SALARY_FRAME" => str_replace(",","",$SALARY_FRAME[$key]),
						"NUM_PER" => str_replace(",","",$NUM_PER[$key]),
						"CONFIRM_TYPE" => 1,
						"CREATE_BY" => $USER_BY,
						"CREATE_DATE" => $TIMESTAMP,						
					);	
					$db->db_insert($table,$fields);
				}
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'ConfirmMg':
		try{	
		   $db->query('BEGIN TRANSACTION');
		   
		 
		   $db->db_update($table,array('CONFIRM_TYPE' => 2)," YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' "); 
		   $text= text('อนุมัติกรอบวงเงิน เรียบร้อยแล้ว');
		  
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
}
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="search" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="S_YEAR_BDG" name="S_YEAR_BDG" value="<?php echo $S_YEAR_BDG;?>" />
	<input type="hidden" id="S_ROUND" name="S_ROUND" value="<?php echo $S_ROUND;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
