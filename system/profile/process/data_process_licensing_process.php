<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
  
//POST

 //echo "<pre>"; print_r($_POST);exit();
/*
Array
(
    [proc] => add
    [menu_id] => 10
    [menu_sub_id] => 156
    [page] => 1
    [page_size] => 20
    [PER_ID] => 1
    [flagDup1] => 
    [flagDup2] => 
    [CERTIFICATE_ID] => 3
    [CERTHIS_NO] => 23333
    [CERTHIS_DATE] => 09/07/2557
)
*/

$CERTIFICATE_ID=(int)$_POST['CERTIFICATE_ID']; //echo $_POST['PER_ID']."<br/>";
$PER_ID = (int)$_POST['PER_ID'];

$url_back="../professional_licensing.php";
$table="PER_CERTIFICATEHIS";

//$date = '05/Feb/2014:14:00:01';
//$format = '@^(?P<day>\d{2})/(?P<month>[A-Z][a-z]{2})/(?P<year>\d{4}):(?P<hour>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})$@';
//preg_match($format, $date, $CERTHIS_DATE);
switch($proc){
	case "add" : 
		try{
			unset($fields);
			$fields = array(
				 
				"CERTIFICATE_ID" => strtoupper(ctext($CERTIFICATE_ID)),
 				"PER_ID" => strtoupper(ctext($PER_ID)),		
 				"CERTHIS_NO" => strtoupper(ctext($CERTHIS_NO)), 	 			 	
 				"CERTHIS_DATE" =>  conv_date_db($CERTHIS_DATE ),				 
 				"CERTIFICATE_BY" =>  ($_POST['CERTIFICATE_BY'] ),				 

 				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	//echo "<pre>"; print_r($fields);exit();
			$db->db_insert($table,$fields);
			
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			unset($fields);
			//-529-07-17
			// 2014-07-17
			$fields = array(
			     
				"CERTIFICATE_ID" => strtoupper(ctext($CERTIFICATE_ID)),
 				"PER_ID" => strtoupper(ctext($PER_ID)),		
 				"CERTHIS_NO" => strtoupper(ctext($CERTHIS_NO)), 	 			 	
 				"CERTHIS_DATE" =>  conv_date_db($CERTHIS_DATE ),				 
 				"CERTIFICATE_BY" =>  ($_POST['CERTIFICATE_BY'] ),	
 				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	  //echo ":".$CERTHIS_ID."<pre>"; print_r($fields); exit();
			$db->db_update($table,$fields," CERTHIS_ID = '".$CERTHIS_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	//echo "test : ".$CERTHIS_ID; exit();
			$db->db_delete($table," CERTHIS_ID = '".$CERTHIS_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
 
	case "chk_dup1" : 
	
		$filter = "";
		if($CERTIFICATE_ID != ""){
			$filter = " and CERTIFICATE_ID != '".$CERTIFICATE_ID."' ";
		}
		$chk_sql = "select count(*) as nums from PER_CERTIFICATEHIS where CERTIFICATE_ID = '".ctext($CERTIFICATE_ID)."' and PER_ID = ".$PER_ID." ";
		echo $chk_sql; exit();
		$chk = $db->get_data_field($chk_sql  ,"nums");
		$arr = array(
			"flag"=> (!$chk) ? 0:1,
			"detail"=> (!$chk) ? "สามารถใช้ข้อมูลนี้ได้":"ข้อมูลซ้ำ",
		);
		echo json_encode($arr);
		
	break;
 
	
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){   //echo "test:".$PER_ID; exit();
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>