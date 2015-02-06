<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$url_back = "../ss_position_per_disp.php";

$table = "POSITION_FRAME";

switch($proc){
	case "add" : {
		try{
			$fields = array(
					"POSTYPE_ID" => $POSTYPE_ID,
					"POS_NO" => $POS_NO,
					"POS_YEAR" => $POS_LIVE_YEAR,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"CL_ID" => $CL_ID,
					"LEVEL_SALARY_ID" => $LEVEL_SALARY_ID,
					"LINE_ID" => $LINE_ID,
					"MANAGE_ID" => $MANAGE_ID,
					"ORG_ID_2" => $ORG_ID_2,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,
					
					"POS_FRAME_SALARY" => str_replace(",","",$POS_FRAME_SALARY),
					"POS_FRAME_POSITION_SALARY" => str_replace(",","",$POS_FRAME_POSITION_SALARY),
					"POS_FRAME_COMPENSATION_1" => str_replace(",","",$POS_FRAME_COMPENSATION_1),
					"POS_FRAME_COMPENSATION_2" => str_replace(",","",$POS_FRAME_COMPENSATION_2),									
					
					"POS_TRUE_SALARY" => str_replace(",","",$POS_TRUE_SALARY),
					"POS_TRUE_POSITION_SALARY" => str_replace(",","",$POS_TRUE_POSITION_SALARY),
					"POS_TRUE_COMPENSATION_1" => str_replace(",","",$POS_TRUE_COMPENSATION_1),
					"POS_TRUE_COMPENSATION_2" => str_replace(",","",$POS_TRUE_COMPENSATION_2),									
					
					
					"POS_DATE_EFFECTIVE" => !empty($POS_DATE_EFFECTIVE) ? conv_date_db($POS_DATE_EFFECTIVE) : '',
					"POS_DATE_SALARY" => !empty($POS_DATE_SALARY) ? conv_date_db($POS_DATE_SALARY) : '',
					"POS_STATUS" => $POS_STATUS,									
					"POS_STATUS_REQUEST" => $POS_STATUS_REQUEST,
			
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" =>$USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => 0,
				);	
			
			$db->db_insert($table,$fields);
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}break;
	case "edit" : {
		try{
			$fields = array(
					"POSTYPE_ID" => $POSTYPE_ID,
					"POS_NO" => $POS_NO,
					"POS_YEAR" => $POS_LIVE_YEAR,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"CL_ID" => $CL_ID,
					"LEVEL_SALARY_ID" => $LEVEL_SALARY_ID,
					"LINE_ID" => $LINE_ID,
					"MANAGE_ID" => $MANAGE_ID,
					"ORG_ID_2" => $ORG_ID_2,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,
					
					"POS_FRAME_SALARY" => str_replace(",","",$POS_FRAME_SALARY),
					"POS_FRAME_POSITION_SALARY" => str_replace(",","",$POS_FRAME_POSITION_SALARY),
					"POS_FRAME_COMPENSATION_1" => str_replace(",","",$POS_FRAME_COMPENSATION_1),
					"POS_FRAME_COMPENSATION_2" => str_replace(",","",$POS_FRAME_COMPENSATION_2),									
					
					"POS_TRUE_SALARY" => str_replace(",","",$POS_TRUE_SALARY),
					"POS_TRUE_POSITION_SALARY" => str_replace(",","",$POS_TRUE_POSITION_SALARY),
					"POS_TRUE_COMPENSATION_1" => str_replace(",","",$POS_TRUE_COMPENSATION_1),
					"POS_TRUE_COMPENSATION_2" => str_replace(",","",$POS_TRUE_COMPENSATION_2),									
					
					
					"POS_DATE_EFFECTIVE" => !empty($POS_DATE_EFFECTIVE) ? conv_date_db($POS_DATE_EFFECTIVE) : '',
					"POS_DATE_SALARY" => !empty($POS_DATE_SALARY) ? conv_date_db($POS_DATE_SALARY) : '',
					"POS_STATUS" => $POS_STATUS,									
					"POS_STATUS_REQUEST" => $POS_STATUS_REQUEST,
			 
					"UPDATE_BY" =>$USER_BY, 
					"UPDATE_DATE" => $TIMESTAMP, 
				);
			
			$db->db_update($table,$fields," POS_ID = '".$POS_ID."' ");
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}break;
	case "delete" : {
		try{	
		unset($fields);
				$fields = array(
				"DELETE_FLAG"=>'1'
				);
			$db->db_update($table,$fields," POS_ID = '".$POS_ID."' ");
			
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}break;
	case "chk_dup" : {
	
		$filter = "";
		if($aut_user_id != ""){
			$filter = " and aut_user_id != '".$aut_user_id."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from aut_user where aut_username = '".ctext($username)."' $filter ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ username นี้ได้":"ไม่สามารถใช้ username นี้ได้",
					 );
		echo json_encode($arr);
	}break;
	case "get_level" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		echo '<option value=""></option>';
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['LEVEL_ID']).'">'.text($rec['LEVEL_NAME_TH']).'</option>';
		}
	}break;
	case "get_org_4" : {
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND ORG_PARENT_ID = ".$org_parent_id;
		$query = $db->query($sql);
		echo "<select id=\"S_ORG_ID_4\" name=\"S_ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
	}break;
	
	case 'getLine' :
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND LEVEL_ID = ".$level_id." AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		echo '<option value=""></option>';
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['LINE_ID']).'">'.text($rec['LINE_NAME_TH']).'</option>';
		}
		exit;
	break;
	
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		echo '<option value=""></option>';
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['LINE_ID']).'">'.text($rec['LINE_NAME_TH']).'</option>';
		}
		exit;
	}break;
	case "get_manage" : {
		$wh = " AND TYPE_ID = ".$type_id;
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 ".$wh." ORDER BY MANAGE_ID ";
		$query = $db->query($sql);
		echo '<option value=""></option>';
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['MANAGE_ID']).'">'.text($rec['MANAGE_NAME_TH']).'</option>';
		}
		exit;
	}break;
	
	case 'getFrame' :
		$arr_level = GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "LEVEL_NAME_TH");
		
		$sql = "Select CO_ID , convert(varchar,LEVEL_ID_MIN)+'|'+convert(varchar,LEVEL_ID_MAX) as CO_NAME From SETUP_POS_CO_LEVEL WHERE ACTIVE_STATUS = 1 and DELETE_FLAG='0' AND TYPE_ID = '".$type_id."' ORDER BY CO_ID ";
		$query = $db->query($sql);
		echo '<option value=""></option>';
		while($rec = $db->db_fetch_array($query)){
			$cl_name=@explode("|",$rec['CO_NAME']);
			echo '<option value="'.text($rec['CO_ID']).'">'.text($arr_level[$cl_name[0]]."/".$arr_level[$cl_name[1]]).'</option>';
		}
		exit;
	break;
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name='form_back' method="post" action="<?php echo $url_back; ?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>" />
    <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>" />
    <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id ?>" />
</form>
<script>
	alert('<?php echo $text; ?>');
	form_back.submit();
</script>
<?php }?>