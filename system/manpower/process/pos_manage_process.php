<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$MANAGE_ID = $_POST['MANAGE_ID'];
$MT_ID = $_POST['MT_ID'];
$TYPE_ID = $_POST['TYPE_ID'];
$MANAGE_NAME_TH = trim($_POST['MANAGE_NAME_TH']);
$MANAGE_NAME_EN = trim($_POST['MANAGE_NAME_EN']);
$MANAGE_SHORTNAME_TH = trim($_POST['MANAGE_SHORTNAME_TH']);
$MANAGE_SHORTNAME_EN = trim($_POST['MANAGE_SHORTNAME_EN']);
$ORG_ID_3 = $_POST['ORG_ID_3'];
$ORG_ID_4 = $_POST['ORG_ID_4'];
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];
	if(trim($ORG_ID_3) !="" && trim($ORG_ID_4) !=""){
		$ORG_ID = $ORG_ID_4 ;
	}else if(trim($ORG_ID_3) !=""){
		$ORG_ID = $ORG_ID_3 ;
	}else if(trim($ORG_ID_4) !=""){
		$ORG_ID = $ORG_ID_4 ;
	}
$url_back="../pos_manage_disp.php";
$table = "SETUP_POS_MANAGE";

switch($proc){
	case "add" : 
		try{
			$fields = array(
				"MT_ID" => $MT_ID,
				"ORG_ID" => $ORG_ID,
				"TYPE_ID" => $TYPE_ID,
				"MANAGE_NAME_TH" => ctext($MANAGE_NAME_TH),
				"MANAGE_NAME_EN" => ctext($MANAGE_NAME_EN),
				"MANAGE_SHORTNAME_TH" => ctext($MANAGE_SHORTNAME_TH),
				"MANAGE_SHORTNAME_EN" => ctext($MANAGE_SHORTNAME_EN),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"POSTYPE_ID" => 1,
				"CREATE_BY" =>ctext($USER_BY),
				"UPDATE_BY" =>ctext($USER_BY),
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_DATE" => $TIMESTAMP,
				"DELETE_FLAG" => '0'
			);	
			$db->db_insert($table,$fields);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			$fields = array(
				"MT_ID" => $MT_ID,
				"ORG_ID" => $ORG_ID,
				"TYPE_ID" => $TYPE_ID,
				"MANAGE_NAME_TH" => ctext($MANAGE_NAME_TH),
				"MANAGE_NAME_EN" => ctext($MANAGE_NAME_EN),
				"MANAGE_SHORTNAME_TH" => ctext($MANAGE_SHORTNAME_TH),
				"MANAGE_SHORTNAME_EN" => ctext($MANAGE_SHORTNAME_EN),
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" =>$USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);
			$db->db_update($table,$fields," MANAGE_ID = '".$MANAGE_ID."' "); //unset($fields);
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "delete" : 
		try{
			$fields = array("DELETE_FLAG"=>'1');
			$db->db_update($table, $fields, " MANAGE_ID = '".$MANAGE_ID."' ");
			$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case 'getType' :
		if($mg_type_id == 1 || $mg_type_id == 2){ // เลขา กับ รองเลขา
			$cond_type = " AND TYPE_ID = '4'";	
		}else if($mg_type_id == 3){ // ผู้อำนวยการ
			$cond_type = " AND TYPE_ID = '3'";	
		}else if($mg_type_id == 4){ // ผู้บังคับบัญชา
			$cond_type = " AND TYPE_ID IN (1,2)";	
		}else if($mg_type_id == 24){ // ที่ปรึกษา
			$cond_type = " AND TYPE_ID = '2'";	
		}
		$arr_type = GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", " ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' ".$cond_type." ", "TYPE_NAME_TH");
		echo GetHtmlSelect("TYPE_ID","TYPE_ID",$arr_type, 'ประเภทตำแหน่ง', '','',"onchange=\"getOrg(this.value);\"",'1');
		exit;
		
	break;

	case 'getOrg' :
	
		if($mg_type_id == 4){ // ผู้บังคับบัญชา
			$cond_org = " AND O4.ORG_TYPE = '1'";
			$q_org = $db->query("SELECT O4.ORG_ID, O3.ORG_NAME_TH+' '+O4.ORG_NAME_TH AS ORG_NAME FROM SETUP_ORG O3 JOIN SETUP_ORG O4 ON O4.ORG_PARENT_ID = O3.ORG_ID WHERE O4.ACTIVE_STATUS = '1' AND O4.DELETE_FLAG = '0' ".$cond_org." ORDER BY O3.ORG_NAME_TH");
			while($r_org = $db->db_fetch_array($q_org)){
				$arr_org[$r_org['ORG_ID']] = $r_org['ORG_NAME'];	
			}
		}else{
			if(($type_id == 4 && ($mg_type_id == 1 || $mg_type_id == 2)) || ($type_id == 2 && $mg_type_id == 24)){ //บริหาร
				$cond_org = " AND ORG_ID = '15'";
			}else if($type_id == 3){ // อำนวยการ
				$cond_org = " AND ORG_PARENT_ID = '15'";
			}else if($type_id == 2 || $type_id == 1){ // วิชาการ
				$cond_org = " AND (OL_ID = '17' OR ORG_ID = '15')";
			}
			$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' ".$cond_org." ", "ORG_NAME_TH");
		}
		echo GetHtmlSelect("ORG_ID","ORG_ID",$arr_org, 'หน่วยงานที่สังกัด', '','','','1');
		exit;
	break;
		case "get_org_4" : 
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_parent_id."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"S_ORG_ID_4\" name=\"S_ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
			echo "<option value=\"\"></option>";
			while($rec = $db->db_fetch_array($query)){
				echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
			}
		echo "</select>";
		exit;
	break;
	
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input name="MT_ID" type="hidden" id="MT_ID" value="<?php echo $MT_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>