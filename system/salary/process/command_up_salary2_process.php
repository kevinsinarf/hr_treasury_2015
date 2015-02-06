<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$COM_NO=$_POST['COM_NO'];
$COM_DATE=trim($_POST['COM_DATE']);
$COM_TITLE=trim($_POST['COM_TITLE']);
$COM_SDATE=$_POST['COM_SDATE'];
$CT_ID = $_POST['CT_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];

$url_back="../command_up_salary2_disp.php";
$table = "SAL_COMMAND";
$table2 = "PER_UPSALARY";
$table3 = "SAL_UP_SALARY";

switch($proc){
	case "add" : 
		try{
			$fields = array(
						   "YEAR_BDG" => ctext($YEAR_BDG),
						   "ROUND" => ctext($ROUND),
						   "COM_NO" => ctext($COM_NO),
						   "CT_ID" => $CT_ID,
						   "MOVEMENT_ID" => $MOVEMENT_ID,
						   "COM_DATE" =>conv_date_db($COM_DATE),
						   "COM_TITLE" =>ctext($COM_TITLE),
						   "COM_SDATE" => conv_date_db($COM_SDATE),
						   "CREATE_BY" => $USER_BY,
						   "CREATE_DATE" => $TIMESTAMP,
						   "POSTYPE_ID" => '1',
						   "DELETE_FLAG" => '0'
						   );	
			$db->db_insert($table,$fields);
			
			//Update SAL_UP_SALARY
			$sql ="SELECT MAX(SAL_COM_ID) AS MAX_SAL FROM SAL_COMMAND";
			$query=$db->query($sql);
			$rec = $db->db_fetch_array($query);
			$max_sal=$rec['MAX_SAL'];
			
			$sql_person = "SELECT A.SAL_UP_ID,  A.PER_ID, A.TYPE_ID, A.LEVEL_ID, A.LINE_ID, A.MANAGE_ID, A.ORG_ID_1, A.ORG_ID_2, A.ORG_ID_3, A.ORG_ID_4,  A.MANAGE_ID, 
			 A.SALARY_NOW, A.SALARY_NEW, A.YEAR_BDG, A.ROUND
			FROM SAL_UP_SALARY A
			WHERE  A.POSTYPE_ID = '1' AND A.YEAR_BDG = '".$YEAR_BDG."' AND A.ROUND = '".$ROUND."'  AND A.MANAGE_ID <= 0 ";
			$query_person = $db->query($sql_person);

			while ($rec_per= $db->db_fetch_array($query_person)){
			  $max_up = "SELECT MAX(UPS_SEQ) AS MAX_SEQ FROM PER_UPSALARY WHERE PER_ID ='".$rec_per['PER_ID']."' ";
			  $query_up = $db->query($max_up);
			  $rec_up = $db->db_fetch_array($query_up);
			  $max = $rec_up['MAX_SEQ']+1;
			  
			   $fields = array(
			  		"SAL_COM_ID" => $max_sal,
			        "UPDATE_BY" => $USER_BY,
					"UPDATE_DATE" => $TIMESTAMP  
			  );
		    $db->db_update($table3,$fields," SAL_UP_ID = '".$rec_per['SAL_UP_ID']."' ");
		
			$fields2 = array(
									"PER_ID" => $rec_per['PER_ID'],
									"TYPE_ID" => $rec_per['TYPE_ID'],
									"LEVEL_ID" => $rec_per['LEVEL_ID'],
									"LINE_ID" => $rec_per['LINE_ID'],
									"ORG_ID_1" => $rec_per['ORG_ID_1'],
									"ORG_ID_2" => $rec_per['ORG_ID_2'],
									"ORG_ID_3" => $rec_per['ORG_ID_3'],
									"ORG_ID_4" => $rec_per['ORG_ID_4'],
									"UPS_SEQ" => $max,
									"UPS_EFFECTIVE_DATE" => conv_date_db($COM_SDATE),
									"UPS_SALARY_LAST" => $rec_per['SALARY_NOW'],
									"UPS_SALARY_NEW" => $rec_per['SALARY_NEW'],
									"ACTIVE_STATUS" => '1',
									"CREATE_BY" => $USER_BY,
									"CREATE_DATE" => $TIMESTAMP,
									"DELETE_FLAG" =>'0'
									);
				
					$db->db_insert($table2,$fields2);
				}
						$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
						   "COM_NO" => ctext($COM_NO),
						   "COM_DATE" =>conv_date_db($COM_DATE),
						   "COM_TITLE" =>ctext($COM_TITLE),
						    "CT_ID" => $CT_ID,
						   "MOVEMENT_ID" => $MOVEMENT_ID,
						   "COM_SDATE" => conv_date_db($COM_SDATE),
						   "UPDATE_BY" => $USER_BY,
						   "UPDATE_DATE" => $TIMESTAMP,	
					 );		
			$db->db_update($table,$fields," SAL_COM_ID = '".$SAL_COM_ID."' "); //unset($fields);
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
		unset($fields);
				$fields = array(
				"DELETE_FLAG"=>'1'
				);
			$db->db_update($table,$fields," SAL_COM_ID = '".$SAL_COM_ID."' ");
			
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
    <input name="COMMAND_ID" type="hidden" id="COMMAND_ID" value="<?php echo $COMMAND_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>