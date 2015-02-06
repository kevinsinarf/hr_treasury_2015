<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$PT_ID=$_POST['PT_ID'];
$PIC_ID=$_POST['PIC_ID'];
$PER_ID=$_POST['PER_ID'];
$PIC_DATE =$_POST['PIC_DATE'];
$PIC_REMARK =$_POST['PIC_REMARK'];
$PIC_DEFAULT =$_POST['PIC_DEFAULT'];
$ACTIVE_STATUS =$_POST['ACTIVE_STATUS'];

$OLD_FILENAME =$_POST['OLD_FILENAME'];
$OLD_FILEPATH =$_POST['OLD_FILEPATH'];

//ไฟล
$PIC_FILENAME=$_FILES["PIC_FILENAME"];

$path_a=$path.'fileupload/profile_his/';

//page back
$url_back = "../profile_picture.php";

$table="PER_PICTURE";

switch($proc){
	case "add" : 
		try{
			unset($fields);

			$V_FILE_PIC='NULL';
			if($PIC_FILENAME['name']!='' && $PIC_FILENAME['name']!=NULL){
				$V_FILE_PIC=getFilenameUplaod($PIC_FILENAME,$path_a,$ODL_FILE_PIC);
				
				$fields["PIC_FILENAME"]		= text($PIC_FILENAME['name']);
				$fields["PIC_FILEPATH"]		= $V_FILE_PIC;
			
			}else{
				$fields["PIC_FILENAME"]		= text($OLD_FILENAME);
				$fields["PIC_FILEPATH"]		= $OLD_FILEPATH;
			}
							
			$fields["PER_ID"]			= $PER_ID;
			
			$sql="select (case when MAX(PIC_SEQ)>0 then (MAX(PIC_SEQ)+1) else '1' end) as PIC_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			$PIC_SEQ = $db->get_data_field($sql,"PIC_SEQ");
			$fields["PIC_SEQ"]			= $PIC_SEQ;
			
			$fields["PIC_DATE"]			= conv_date_db($PIC_DATE);
			
			$fields["PIC_DEFAULT"]		= $PIC_DEFAULT;
			$fields["PIC_REMARK"]		= ctext($PIC_REMARK);
			$fields["REQUEST_RESULT"]	= '1';
			$fields["REQUEST_ID"]		= '1';
			$fields["REQUEST_STATUS"]	= '1';
			$fields["ACTIVE_STATUS"]	= $ACTIVE_STATUS;
			$fields["CREATE_BY"]		= $USER_BY;
			$fields["UPDATE_BY"]		= $USER_BY;
			$fields["UPDATE_DATE"]		= $TIMESTAMP;
			$fields["CREATE_DATE"]		= $TIMESTAMP;
			$fields["DELETE_FLAG"]		='0';
			
			if($PIC_DEFAULT == "1" && $ACTIVE_STATUS=="1"){
				$db->db_update($table,array("PIC_DEFAULT"=>"2")," PER_ID = '".$PER_ID."' "); 
			}
			
			$db->db_insert($table,$fields);
			
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
		
			unset($fields);
			$V_FILE_PIC='NULL';
			if($PIC_FILENAME['name']!='' && $PIC_FILENAME['name']!=NULL){	
				$V_FILE_PIC=getFilenameUplaod($PIC_FILENAME,$path_a,$ODL_FILE_PIC);
				
				$fields["PIC_FILENAME"]		= text($PIC_FILENAME['name']);
				$fields["PIC_FILEPATH"]		= $V_FILE_PIC;
			
			}else{
				$fields["PIC_FILENAME"]		= text($OLD_FILENAME);
				$fields["PIC_FILEPATH"]		= $OLD_FILEPATH;
			}
			
			$fields["PER_ID"]			= $PER_ID;
			$fields["PIC_DATE"]			= conv_date_db($PIC_DATE);

			$fields["PIC_DEFAULT"]		= $PIC_DEFAULT;
			$fields["PIC_REMARK"]		= ctext($PIC_REMARK);
			$fields["REQUEST_RESULT"]	= '1';
			$fields["REQUEST_ID"]		= '1';
			$fields["REQUEST_STATUS"]	= '1';
			$fields["ACTIVE_STATUS"]	= $ACTIVE_STATUS;
			$fields["UPDATE_BY"]		= $USER_BY;
			$fields["UPDATE_DATE"]		= $TIMESTAMP;
			$fields["DELETE_FLAG"]		='0';
			
			if($PIC_DEFAULT == "1" && $ACTIVE_STATUS=="1"){
				$db->db_update($table,array("PIC_DEFAULT"=>"2")," PER_ID = '".$PER_ID."' "); 
			}
			
			$db->db_update($table,$fields," PIC_ID = '".$PIC_ID."' "); 
				
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$sql="SELECT PIC_FILEPATH FROM PER_PICTURE WHERE PIC_ID='".$PIC_ID."'";
			$query = $db->query($sql);
			$data_n =$db->db_fetch_array($query);
			
			if($data_n['PIC_FILEPATH']!=''||$data_n['PIC_FILEPATH']!=NULL){
				 unlink(@$path_a.$data_n['PIC_FILEPATH']);	
			}
						
			$db->db_delete($table," PIC_ID = '".$PIC_ID."' ");
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
	<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
    <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>