<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST

$proc = $_POST['proc'];
$CT_ID = $_POST['CT_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];
$YEAR_BDG = $_POST['YEAR_BDG'];
$ROUND = $_POST['ROUND'];
$SAL_COM_ID = $_POST['SAL_COM_ID'];
$COM_NO = ctext($_POST['COM_NO']);
$COM_DATE = conv_date_db($_POST['COM_DATE']);
$COM_TITLE = ctext($_POST['COM_TITLE']);
$COM_SDATE = conv_date_db($_POST['COM_SDATE']);


$ARR_SAL_UP_ID = $_POST['SAL_UP_ID'];
$ARR_SAL_COMPENSATION_4 = $_POST['SAL_COMPENSATION_4'];

$url_back="../command_temp_salary_emp_disp.php";
$TB = "SAL_COMMAND";
$TB1 = "SAL_UP_SALARY";

switch($proc){
	case "add" : 
		try{
			$fields = array(
				 "YEAR_BDG" => $YEAR_BDG,
				 "ROUND" => $ROUND,
				 "COM_NO" => $COM_NO,
				 "CT_ID" => $CT_ID,
				 "MOVEMENT_ID" => $MOVEMENT_ID,
				 "COM_DATE" => $COM_DATE,
				 "COM_TITLE" => $COM_TITLE,
				 "COM_SDATE" => $COM_SDATE,
				 "CREATE_BY" => $USER_BY,
				 "CREATE_DATE" => $TIMESTAMP,
				 "POSTYPE_ID" => '3',
				 "CONFIRM_TYPE" => 1,
				 "DELETE_FLAG" => '0'
			 );	
		   $db->db_insert($TB,$fields);
			
			$max_sal_id = "SELECT MAX(SAL_COM_ID) AS SAL_MAX FROM SAL_COMMAND";
			$query_max_sal = $db->query($max_sal_id);
			$rec_sal_max = $db->db_fetch_array($query_max_sal);
			
			if(count($ARR_SAL_UP_ID)>0){
				foreach($ARR_SAL_UP_ID as $key => $val){
						$fields2 = array(
									"SAL_COM_TEMP" => $rec_sal_max['SAL_MAX'],
									"SAL_COMPENSATION_4" => str_replace(',','',$ARR_SAL_COMPENSATION_4[$val]),
									"UPDATE_BY" => $USER_BY,
									"UPDATE_DATE" => $TIMESTAMP,
						);	
						$db->db_update($TB1,$fields2," SAL_UP_ID = '".$val."'");		
				}
			}
					
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
					"COM_NO" => $COM_NO,
				   "CT_ID" => $CT_ID,
				   "COM_DATE" => $COM_DATE,
				   "COM_TITLE" => $COM_TITLE,
				   "COM_SDATE" => $COM_SDATE,
				   "UPDATE_BY" => $USER_BY,
				   "UPDATE_DATE" => $TIMESTAMP,	
			 );		
			$db->db_update($TB,$fields," SAL_COM_ID = '".$SAL_COM_ID."' "); 
			$db->db_update($TB1,array("SAL_COM_TEMP" => '')," SAL_COM_TEMP = '".$SAL_COM_ID."' ");
			if(count($ARR_SAL_UP_ID)>0){
				foreach($ARR_SAL_UP_ID as $key => $val){
						$fields2 = array(
									"SAL_COM_TEMP" => $SAL_COM_ID,
									"SAL_COMPENSATION_4" => str_replace(',','',$ARR_SAL_COMPENSATION_4[$val]),
									"CREATE_BY" => $USER_BY,
									"CREATE_DATE" => $TIMESTAMP,
						);	
						$db->db_update($TB1,$fields2," SAL_UP_ID = '".$val."'");			
				}
			}
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case 'ConfirmCom':
		try{	
		
		   $db->query('BEGIN TRANSACTION');
		   $db->db_update($TB,array('CONFIRM_TYPE' => 2,'UPDATE_BY' => $USER_BY, 'UPDATE_DATE' => $TIMESTAMP )," SAL_COM_ID = '".$SAL_COM_ID."' "); 
		   $text= text('อนุมัติออกคำสั่ง เรียบร้อยแล้ว');
		  
		   $db->query("COMMIT TRANSACTION");
	      
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($TB," SAL_COM_ID = '".$SAL_COM_ID."' ");
			$db->db_update($TB1,array("SAL_COM_TEMP" => '')," SAL_COM_ID = '".$SAL_COM_ID."' ");
			
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}

?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input type="hidden" id="YEAR_BDG" name="YEAR_BDG" value="<?php echo $YEAR_BDG ;?>" />
    <input type="hidden" id="ROUND" name="ROUND" value="<?php echo $ROUND ;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
