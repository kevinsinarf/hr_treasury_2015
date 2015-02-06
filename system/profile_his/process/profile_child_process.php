<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID=$_POST['PT_ID'];
$PER_ID=$_POST['PER_ID'];
$PCHILD_ID=$_POST['PCHILD_ID'];
$PCHILD_PREFIX_ID=$_POST['PREFIX_ID'];
$PCHILD_FIRSTNAME_TH=$_POST['PCHILD_FIRSTNAME_TH'];
$PCHILD_LASTNAME_TH=$_POST['PCHILD_LASTNAME_TH'];
$PCHILD_IDCARD=$_POST['PCHILD_IDCARD'];
$PCHILD_BIRTHDATE=$_POST['PCHILD_BIRTHDATE'];
$PCHILD_STATUS=$_POST['PCHILD_STATUS'];
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];
$ID_CARD = str_replace("-","",$PCHILD_IDCARD); 

$table="PER_CHILD";


switch($proc){
	case "add" : 
		try{
			unset($fields);
					$sql="select (case when MAX(PCHILD_SEQ)>0 then (MAX(PCHILD_SEQ)+1) else '1' end) as PCHILD_SEQ  from PER_CHILD where PER_ID='".$PER_ID."' ";
					$query = $db->query($sql);
					$data = $db->db_fetch_array($query);
					$fields = array(
					"PER_ID" => $PER_ID,
					"PCHILD_PREFIX_ID"=>$PCHILD_PREFIX_ID,
					"PCHILD_SEQ"=> $data['PCHILD_SEQ'],
					"PCHILD_IDCARD"=>ctext($ID_CARD),
					"PCHILD_BIRTHDATE" => conv_date_db($PCHILD_BIRTHDATE),
					"PCHILD_FIRSTNAME_TH"=>ctext($PCHILD_FIRSTNAME_TH),
					"PCHILD_MIDNAME_TH"=>ctext($PCHILD_MIDNAME_TH),
					"PCHILD_LASTNAME_TH"=>ctext($PCHILD_LASTNAME_TH),
					"PCHILD_FIRSTNAME_EN"=>strtoupper(ctext($PCHILD_FIRSTNAME_EN)),
					"PCHILD_MIDNAME_EN"=>strtoupper(ctext($PCHILD_MIDNAME_EN)),
					"PCHILD_LASTNAME_EN" => strtoupper(ctext($PCHILD_LASTNAME_EN)),
					"PCHILD_STATUS"=>$PCHILD_STATUS,
					"REQUEST_STATUS"=>'1',
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
					$db->db_insert($table,$fields);
						/*echo '<pre>';
						print_r($fields);
						echo '</pre>';	
						echo'-----------<br>';*/
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edit" : 
		try{
			unset($fields);
			$fields = array(
					"PCHILD_PREFIX_ID"=>$PCHILD_PREFIX_ID,
					"PCHILD_SEQ"=> $data['PCHILD_SEQ'],
					"PCHILD_IDCARD"=>ctext($ID_CARD),
					"PCHILD_BIRTHDATE" => conv_date_db($PCHILD_BIRTHDATE),
					"PCHILD_FIRSTNAME_TH"=>ctext($PCHILD_FIRSTNAME_TH),
					"PCHILD_MIDNAME_TH"=>ctext($PCHILD_MIDNAME_TH),
					"PCHILD_LASTNAME_TH"=>ctext($PCHILD_LASTNAME_TH),
					"PCHILD_FIRSTNAME_EN"=>strtoupper(ctext($PCHILD_FIRSTNAME_EN)),
					"PCHILD_MIDNAME_EN"=>strtoupper(ctext($PCHILD_MIDNAME_EN)),
					"PCHILD_LASTNAME_EN" => strtoupper(ctext($PCHILD_LASTNAME_EN)),
					"PCHILD_STATUS"=>$PCHILD_STATUS,
					"ACTIVE_STATUS" => $ACTIVE_STATUS,
					"CREATE_BY" => $USER_BY,
					"UPDATE_BY" =>$USER_BY,
					"CREATE_DATE"=>$TIMESTAMP,
					"UPDATE_DATE" =>$TIMESTAMP,
					"DELETE_FLAG" =>'0'
					);
				    $db->db_update($table,$fields," PCHILD_ID = '".$PCHILD_ID."' "); 
					
					$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," PCHILD_ID = '".$PCHILD_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
$url_back="../profile_child_disp.php";
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
