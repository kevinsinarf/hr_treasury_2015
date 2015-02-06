<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$url_back = "../ss_position_other_per_office_disp.php";

$TB = "POSITION_FRAME";
$REMARK_ID = $_POST['REMARK_ID'];
$REMARK_DETAIL = ctext($_POST['REMARK_DETAIL']);

//ไฟล
$POS_FILE=$_FILES["POS_FILE"];
$OLD_FILE_PIC =$_POST['OLD_FILE_PIC'];
//$path_a = '../fileupload/profile_his/';
$path_img=$path.'fileupload/file_position_frame/';


switch($proc){
	case "add" : {
		try{
			unset($fields);
			$V_FILE_PIC='NULL';
			if($POS_FILE['name']!=''||$POS_FILE['name']!=NULL){
				$V_FILE_PIC=getFilenameUplaod($POS_FILE,$path_img,$OLD_FILE_PIC);
			}
			
			$fields = array(
					"POS_FILE" => $V_FILE_PIC,
					"POSTYPE_ID" => 1,
					"POS_NO" => $POS_NO,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LG_ID" => $LG_ID,
					"LINE_ID" => $LINE_ID,
					"MT_ID" => $MT_ID,
					"MANAGE_ID" => $MANAGE_ID,
					"CO_ID" => $CO_ID,
					"ORG_ID_2" => 17,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,
					"EL_ID" => $EL_ID,
					"REMARK_ID" => $REMARK_ID,
					"REMARK_DETAIL" => $REMARK_DETAIL,
					"POS_FRAME_SALARY" => str_replace(',','',$POS_FRAME_SALARY),
					"POS_FRAME_POSITION_SALARY" => str_replace(',','',$POS_FRAME_POSITION_SALARY),
					"POS_FRAME_COMPENSATION_1" => str_replace(',','',$POS_FRAME_COMPENSATION_1),
					"POS_FRAME_COMPENSATION_2" => str_replace(',','',$POS_FRAME_COMPENSATION_2),
					"POS_DATE_EFFECTIVE" => conv_date_db($POS_DATE_EFFECTIVE),
					"POS_DATE_SALARY" => conv_date_db($POS_DATE_SALARY),
					"POS_STATUS" => $POS_STATUS,
					"POS_STATUS_REQUEST" => 1,
					"ACTIVE_STATUS" => 1,
					"CREATE_BY" =>$USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE" => $TIMESTAMP,
					"UPDATE_DATE" => $TIMESTAMP,
					"DELETE_FLAG" => 0,
				);	
			
			$db->db_insert($TB,$fields);
			
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}break;
	case "edit" : {
		try{
		$V_FILE_PIC=getFilenameUplaod($POS_FILE,$path_img,$OLD_FILE_PIC);
			$fields = array(
					"POS_FILE" => $V_FILE_PIC,
					"POSTYPE_ID" => 1,
					"POS_NO" => $POS_NO,
					"TYPE_ID" => $TYPE_ID,
					"LEVEL_ID" => $LEVEL_ID,
					"LG_ID" => $LG_ID,
					"LINE_ID" => $LINE_ID,
					"MT_ID" => $MT_ID,
					"MANAGE_ID" => $MANAGE_ID,
					"CO_ID" => $CO_ID,
					"ORG_ID_2" => 17,
					"ORG_ID_3" => $ORG_ID_3,
					"ORG_ID_4" => $ORG_ID_4,
					"EL_ID" => $EL_ID,
					"REMARK_ID" => $REMARK_ID,
					"REMARK_DETAIL" => $REMARK_DETAIL,
					"POS_FRAME_SALARY" => str_replace(',','',$POS_FRAME_SALARY),
					"POS_FRAME_POSITION_SALARY" => str_replace(',','',$POS_FRAME_POSITION_SALARY),
					"POS_FRAME_COMPENSATION_1" => str_replace(',','',$POS_FRAME_COMPENSATION_1),
					"POS_FRAME_COMPENSATION_2" => str_replace(',','',$POS_FRAME_COMPENSATION_2),
					"POS_DATE_EFFECTIVE" => conv_date_db($POS_DATE_EFFECTIVE),
					"POS_DATE_SALARY" => conv_date_db($POS_DATE_SALARY),
					"POS_STATUS" => $POS_STATUS,
					"UPDATE_BY" =>$USER_BY, 
					"UPDATE_DATE" => $TIMESTAMP, 
				);
			
			$db->db_update($TB,$fields," POS_ID = '".$POS_ID."' ");
			
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
			$db->db_update($TB,$fields," POS_ID = '".$POS_ID."' ");
			
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	}
    break;
	
	case "get_level" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 }
	 exit;
	break;
	
	case "get_co_level" : 
		$sql_co = "SELECT A.CO_ID, A.TYPE_ID, B.LEVEL_SEQ AS LEVEL_SEQ_MIN, C.LEVEL_SEQ AS LEVEL_SEQ_MAX FROM SETUP_POS_CO_LEVEL A
               JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID_MIN = B.LEVEL_ID AND A.TYPE_ID = B.TYPE_ID
			   JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID_MAX = C.LEVEL_ID AND A.TYPE_ID = C.TYPE_ID 
               WHERE A.ACTIVE_STATUS =1 AND A.DELETE_FLAG = 0 AND B.POSTYPE_ID = '".$postype_id."' AND  C.POSTYPE_ID = '".$postype_id."' AND A.TYPE_ID = '".$type_id."' ";
			  $query_co = $db->query($sql_co);
			  $i = 0;
			  while($rec_co = $db->db_fetch_array($query_co)){
				  $query_co_level = $db->query("SELECT LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_SEQ BETWEEN '".$rec_co['LEVEL_SEQ_MIN']."' AND '".$rec_co['LEVEL_SEQ_MAX']."' AND POSTYPE_ID = 1 AND ACTIVE_STATUS =1 AND DELETE_FLAG = 0  ORDER BY LEVEL_SEQ ASC   ");
				  $arr_co_id[] = trim($rec_co['CO_ID']);
				  while($rec_co_level = $db->db_fetch_array($query_co_level)){
					  $arr_co[trim($rec_co['CO_ID'])][$i] = text($rec_co_level['LEVEL_NAME_TH']);
					  $i++;
				  }
			  }
			  
			 $obj = array();
			 if(count($arr_co_id) > 0){
			  foreach($arr_co_id as $index => $val){
				  $text = @implode(' / ', $arr_co[$val]);
				  $row['ID'] = $val;
				  $row['VALUE'] = $text;
				  array_push($obj,$row);
			  }
			  echo json_encode($obj);
		  }
	break;
	case "get_line_group" : 
		$sql = "Select LG_ID , LG_NAME_TH From SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LG_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LG_ID'];
			$row['VALUE'] = text($rec['LG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	break;
	case "get_line" : {
		$sql = "Select LINE_ID , LINE_NAME_TH From SETUP_POS_LINE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND LG_ID = ".$lg_id." AND POSTYPE_ID = ".$postype_id." ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}break;
	
	case "get_manage" : {
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND MT_ID = '".$mt_id."' ORDER BY MANAGE_ID ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['MANAGE_ID'];
			$row['VALUE'] = text($rec['MANAGE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}
	break;
	case "get_org_4" : {
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_parent_id."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"S_ORG_ID_4\" name=\"S_ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
	}break;
	case "get_level_salary":
		
		$sql_co = "SELECT A.CO_ID, A.TYPE_ID, B.LEVEL_SEQ AS LEVEL_SEQ_MIN, C.LEVEL_SEQ AS LEVEL_SEQ_MAX FROM SETUP_POS_CO_LEVEL A
               JOIN SETUP_POS_LEVEL B ON A.LEVEL_ID_MIN = B.LEVEL_ID AND A.TYPE_ID = B.TYPE_ID
			   JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID_MAX = C.LEVEL_ID AND A.TYPE_ID = C.TYPE_ID 
               WHERE A.CO_ID = '".$co_id."' ";
			  $query_co = $db->query($sql_co);
			  $rec_co = $db->db_fetch_array($query_co);
			  $query_co_level = $db->query("SELECT LEVEL_ID, LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_SEQ BETWEEN '".$rec_co['LEVEL_SEQ_MIN']."' AND '".$rec_co['LEVEL_SEQ_MAX']."' AND POSTYPE_ID = 1 ORDER BY LEVEL_SEQ ASC   ");
		
			while($rec_level = $db->db_fetch_array($query_co_level)){
				$sql_salary = "SELECT SALARYTITLE_ID, LEVEL_SALARY_MIN, LEVEL_SALARY_MAX FROM SETUP_POS_LEVEL_SALARY WHERE TYPE_ID = '".$rec_co['TYPE_ID']."' AND LEVEL_ID = '".$rec_level['LEVEL_ID']."' AND POSTYPE_ID = '".$postype_id."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ORDER BY SALARYTITLE_ID DESC ";
				$query_salary = $db->query($sql_salary);
				
			$html .= " <div class='col-xs-12 col-md-1'>
					   <div class='row'>
						<div class='col-xs-12 col-md-2 ' style='white-space:nowrap;'>".text($rec_level['LEVEL_NAME_TH'])."</div>
						</div> ";
				 
			 while($rec_salary = $db->db_fetch_array($query_salary)){
				 
				 $money = 0;
				 if($rec_salary['SALARYTITLE_ID'] == 2){
					 $money = number_format($rec_salary['LEVEL_SALARY_MIN'],2);
				 }else if($rec_salary['SALARYTITLE_ID'] == 1){
					  $money = number_format($rec_salary['LEVEL_SALARY_MAX'],2);
				 }
				 
			 $html .= "<div class='row'>
						 <div class='col-xs-12 col-md-2 ' style='white-space:nowrap;'>".$money."</div>
						 </div>";
						 
			 }
		 $html .= " </div> ";	
		}
	   echo $html;
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