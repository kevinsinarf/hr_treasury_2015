<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//echo "test:".trim($_POST['CERTIFICATE_NAME_TH']); exit();
//POST



$CERTIFICATE_ID=$_POST['CERTIFICATE_ID'];
$CERTIFICATE_NAME_TH=trim($_POST['CERTIFICATE_NAME_TH']);
$CERTIFICATE_NAME_EN=trim($_POST['CERTIFICATE_NAME_EN']);
$CERTIFICATE_BY = trim($_POST['CERTIFICATE_BY']);
$ACTIVE_STATUS=$_POST['ACTIVE_STATUS'];

//echo "test : ".$CERTIFICATE_BY."<br/>";
//echo iconv( "tis-620", "utf-8",$CERTIFICATE_BY ); exit();


 //echo "<pre>"; print_r($_POST); exit();

$url_back="../professional_licensing.php";
$table="PER_CERTIFICATEHIS";

switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				 
				"CERTIFICATE_NAME_TH" => strtoupper(ctext($CERTIFICATE_NAME_TH)),
				"CERTIFICATE_NAME_EN" => strtoupper(ctext($CERTIFICATE_NAME_EN)),	
				"CERTIFICATE_SHORTNAME_TH" => strtoupper(ctext($CERTIFICATE_SHORTNAME_TH)),
				"CERTIFICATE_SHORTNAME_EN" => strtoupper(ctext($CERTIFICATE_SHORTNAME_EN)),	
				"CERTIFICATE_BY" => strtoupper(ctext($CERTIFICATE_BY)),			
				
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
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
			 
				"CERTIFICATE_NAME_TH" => strtoupper(ctext($CERTIFICATE_NAME_TH)),
				"CERTIFICATE_NAME_EN" => strtoupper(ctext($CERTIFICATE_NAME_EN)),	
				"CERTIFICATE_SHORTNAME_TH" => strtoupper(ctext($CERTIFICATE_SHORTNAME_TH)),
				"CERTIFICATE_SHORTNAME_EN" => strtoupper(ctext($CERTIFICATE_SHORTNAME_EN)),	
				"CERTIFICATE_BY" => strtoupper(ctext($CERTIFICATE_BY)),	
				"ACTIVE_STATUS" => $ACTIVE_STATUS,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	
			$db->db_update($table,$fields," CERTIFICATE_ID = '".$CERTIFICATE_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," CERTIFICATE_ID = '".$CERTIFICATE_ID."' ");
			
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
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>