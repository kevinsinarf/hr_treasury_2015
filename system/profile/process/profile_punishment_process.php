<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
$url_back="../profile_punishment_disp.php";   //echo "<pre>"; print_r($_POST); exit();
//POST
/*
    [proc] => add
    [menu_id] => 10
    [menu_sub_id] => 156
    [page] => 1
    [page_size] => 20
    [PER_ID] => 1
    [POSHIS_ID] => 
    [POSTYPE_ID] => 1
    [PT_ID] => 
    [ACT] => 3
    [CT_ID] => 4
    [MOVEMENT_ID] => 14
    [COM_NO] => 232
    [COM_DATE] => 16/07/2557
    [POSHIS_DATE] => 17/07/2557
    [COM_SDATE] => 07/07/2557
    [PUNISH_ID] => 6
    [ACTIVE_STATUS] => 1
    [POSHIS_NOTE] => ทดสอบ

*/
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
 
if($PER_ID>0){

}else{

}
 

$table="PER_PUNISHMENT";
 
 
switch($proc){
	case "add" : 
		try{
			unset($fields);
			
			$sql = "select * from PER_PROFILE where PER_ID = ".$PER_ID." ";  
			$query_pen = $db->query($sql);
			$rec = $db->db_fetch_array($query_pen);

			
			$fields = array(
				 
				"PER_ID" => strtoupper(ctext($PER_ID)),
				"POSTYPE_ID" => strtoupper(ctext($POSTYPE_ID)),

					
				"FINAL_CT_ID" => strtoupper(ctext($CT_ID)),
				"FINAL_MOVEMENT_ID" => strtoupper(ctext($MOVEMENT_ID)),
				"FINAL_NO" => strtoupper(ctext($FINAL_NO)),
 				"FINAL_DATE" => conv_date_db($COM_DATE),		
 				"FINAL_SDATE" => conv_date_db($POSHIS_DATE),					
 				"FINAL_EDATE" => conv_date_db($COM_SDATE),			
 				"FINAL_PUNISH_ID" => strtoupper(ctext($PUNISH_ID)),	
 				"FINAL_PUNISH_NOTE" => strtoupper(ctext($POSHIS_NOTE)),		
				
				"ORG_ID_1" => $rec['ORG_ID_1'],		
				"ORG_ID_2" => $rec['ORG_ID_2'],		
				"ORG_ID_3" => $rec['ORG_ID_3'],		
				"ORG_ID_4" => $rec['ORG_ID_4'],									 
				"ORG_ID_5" => $rec['ORG_ID_5'],		
				"LINE_ID" => $rec['LINE_ID'],	
				"MANAGE_ID" => $rec['MANAGE_ID'],	
				"LEVEL_ID" => $rec['LEVEL_ID'],					
				"TYPE_ID" => $rec['TYPE_ID'],	
				"POSTYPE_ID" => $rec['POSTYPE_ID'],						
																		
				 
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP 
			);	  //echo "<pre>"; print_r($fields); exit();
			$db->db_insert($table,$fields);
			
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			unset($fields);
			$fields = array(
			 
				"PER_ID" => strtoupper(ctext($PER_ID)),
				"POSTYPE_ID" => strtoupper(ctext($POSTYPE_ID)),

					
				"FINAL_CT_ID" => strtoupper(ctext($CT_ID)),
				"FINAL_MOVEMENT_ID" => strtoupper(ctext($MOVEMENT_ID)),
				"FINAL_NO" => strtoupper(ctext($FINAL_NO)),
 				"FINAL_DATE" => conv_date_db($COM_DATE),		
 				"FINAL_SDATE" => conv_date_db($POSHIS_DATE),					
 				"FINAL_EDATE" => conv_date_db($COM_SDATE),			
 				"FINAL_PUNISH_ID" => strtoupper(ctext($PUNISH_ID)),	
 				"FINAL_PUNISH_NOTE" => strtoupper(ctext($POSHIS_NOTE)),					
				
								 
				
				 
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP 
			);	
			$db->db_update($table,$fields," PUN_ID = '".$PUN_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," PUN_ID = '".$PUN_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup1" : 
	    //echo "test"; exit();
		$filter = "";
		if($PUN_ID != ""){
			//$filter = " and FINAL_NO != '".$FINAL_NO."' ";
		}
		$sql_chk = "select count(*) as nums from ".$table." where FINAL_NO = '".ctext($FINAL_NO)."'  ";  
		$chk = $db->get_data_field($sql_chk,"nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	case "chk_dup2" : 
	
		$filter = "";
		if($CERTIFICATE_ID != ""){
			$filter = " and CERTIFICATE_ID != '".$CERTIFICATE_ID."' ";
		}
	
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where CERTIFICATE_NAME_EN = '".ctext($CERTIFICATE_NAME_EN)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
	break;
	
	case "chk_dup3" : 
	
		$filter = "";
		if($CERTIFICATE_ID != ""){
			$filter = " and CERTIFICATE_ID != '".$CERTIFICATE_ID."' ";
		}
		
		$chk = $db->get_data_field("select count(*) as nums from ".$table." where CERTIFICATE_CODE = '".ctext($CERTIFICATE_NAME_TH)."' {$filter} ","nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
	
	
}


?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="HEIR_ID" name="HEIR_ID" value="<?php echo $HEIR_ID; ?>">
    
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>

