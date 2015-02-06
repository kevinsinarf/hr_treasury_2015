<?php
 
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
$url_back="../profile_absent.php";
$table="PER_LEAVEHIS"; 
 
if(empty($_POST['LEAVEHIS_SICK_TIME'])){ $LEAVEHIS_SICK_TIME = 0; }else{ $LEAVEHIS_SICK_TIME = $_POST['LEAVEHIS_SICK_TIME'];}
if(empty($_POST['LEAVEHIS_SICK_DAY'])){ $LEAVEHIS_SICK_DAY = 0; }else{ $LEAVEHIS_SICK_DAY = $_POST['LEAVEHIS_SICK_DAY'];}
if(empty($_POST['LEAVEHIS_BIRTH_TIME'])){ $LEAVEHIS_BIRTH_TIME = 0; }else{ $LEAVEHIS_BIRTH_TIME = $_POST['LEAVEHIS_BIRTH_TIME'];}
if(empty($_POST['LEAVEHIS_BIRTH_DAY'])){ $LEAVEHIS_BIRTH_DAY = 0; }else{ $LEAVEHIS_BIRTH_DAY = $_POST['LEAVEHIS_BIRTH_DAY'];}
if(empty($_POST['LEAVEHIS_HELP_TIME'])){ $LEAVEHIS_HELP_TIME = 0; }else{ $LEAVEHIS_HELP_TIME = $_POST['LEAVEHIS_HELP_TIME'];}
if(empty($_POST['LEAVEHIS_HELP_DAY'])){ $LEAVEHIS_HELP_DAY = 0; }else{ $LEAVEHIS_HELP_DAY = $_POST['LEAVEHIS_HELP_DAY'];}
if(empty($_POST['LEAVEHIS_PRIVATE_TIME'])){ $LEAVEHIS_PRIVATE_TIME = 0; }else{ $LEAVEHIS_PRIVATE_TIME = $_POST['LEAVEHIS_PRIVATE_TIME'];}
if(empty($_POST['LEAVEHIS_PRIVATE_DAY'])){ $LEAVEHIS_PRIVATE_DAY = 0; }else{ $LEAVEHIS_PRIVATE_DAY = $_POST['LEAVEHIS_PRIVATE_DAY'];}
if(empty($_POST['LEAVEHIS_RELAX_TIME'])){ $LEAVEHIS_RELAX_TIME = 0; }else{ $LEAVEHIS_RELAX_TIME = $_POST['LEAVEHIS_RELAX_TIME'];} 
if(empty($_POST['LEAVEHIS_RELAX_DAY'])){ $LEAVEHIS_RELAX_DAY = 0; }else{ $LEAVEHIS_RELAX_DAY = $_POST['LEAVEHIS_RELAX_DAY'];} 
if(empty($_POST['LEAVEHIS_REGION_TIME'])){ $LEAVEHIS_REGION_TIME = 0; }else{ $LEAVEHIS_REGION_TIME = $_POST['LEAVEHIS_REGION_TIME'];} 
if(empty($_POST['LEAVEHIS_REGION_DAY'])){ $LEAVEHIS_REGION_DAY = 0; }else{ $LEAVEHIS_REGION_DAY = $_POST['LEAVEHIS_REGION_DAY'];} 
if(empty($_POST['LEAVEHIS_SOLDIER_TIME'])){ $LEAVEHIS_SOLDIER_TIME = 0; }else{ $LEAVEHIS_SOLDIER_TIME = $_POST['LEAVEHIS_SOLDIER_TIME'];}
if(empty($_POST['LEAVEHIS_SOLDIER_DAY'])){ $LEAVEHIS_SOLDIER_DAY = 0; }else{ $LEAVEHIS_SOLDIER_DAY = $_POST['LEAVEHIS_SOLDIER_DAY'];}  
if(empty($_POST['LEAVEHIS_STUDY_TIME'])){ $LEAVEHIS_STUDY_TIME = 0; }else{ $LEAVEHIS_STUDY_TIME = $_POST['LEAVEHIS_STUDY_TIME'];}  
if(empty($_POST['LEAVEHIS_STUDY_DAY'])){ $LEAVEHIS_STUDY_DAY = 0; }else{ $LEAVEHIS_STUDY_DAY = $_POST['LEAVEHIS_STUDY_DAY'];}  
if(empty($_POST['LEAVEHIS_WORK_TIME'])){ $LEAVEHIS_WORK_TIME = 0; }else{ $LEAVEHIS_WORK_TIME = $_POST['LEAVEHIS_WORK_TIME'];}
if(empty($_POST['LEAVEHIS_WORK_DAY'])){ $LEAVEHIS_WORK_DAY = 0; }else{ $LEAVEHIS_WORK_DAY = $_POST['LEAVEHIS_WORK_DAY'];}
if(empty($_POST['LEAVEHIS_MARRIED_TIME'])){ $LEAVEHIS_MARRIED_TIME = 0; }else{ $LEAVEHIS_MARRIED_TIME = $_POST['LEAVEHIS_MARRIED_TIME'];}
if(empty($_POST['LEAVEHIS_MARRIED_DAY'])){ $LEAVEHIS_MARRIED_DAY = 0; }else{ $LEAVEHIS_MARRIED_DAY = $_POST['LEAVEHIS_MARRIED_DAY'];}
if(empty($_POST['LEAVEHIS_COMPLETENCY_TIME'])){ $LEAVEHIS_COMPLETENCY_TIME = 0; }else{ $LEAVEHIS_COMPLETENCY_TIME = $_POST['LEAVEHIS_COMPLETENCY_TIME'];}
if(empty($_POST['LEAVEHIS_COMPLETENCY_DAY'])){ $LEAVEHIS_COMPLETENCY_DAY = 0; }else{ $LEAVEHIS_COMPLETENCY_DAY = $_POST['LEAVEHIS_COMPLETENCY_DAY'];}
if(empty($_POST['LEAVEHIS_OTHER_TIME'])){ $LEAVEHIS_OTHER_TIME = 0; }else{ $LEAVEHIS_OTHER_TIME = $_POST['LEAVEHIS_OTHER_TIME'];}
if(empty($_POST['LEAVEHIS_OTHER_DAY'])){ $LEAVEHIS_OTHER_DAY = 0; }else{ $LEAVEHIS_OTHER_DAY = $_POST['LEAVEHIS_OTHER_DAY'];}
if(empty($_POST['LEAVEHIS_WITHOUT_TIME'])){ $LEAVEHIS_WITHOUT_TIME = 0; }else{ $LEAVEHIS_WITHOUT_TIME = $_POST['LEAVEHIS_WITHOUT_TIME'];}
if(empty($_POST['LEAVEHIS_WITHOUT_DAY'])){ $LEAVEHIS_WITHOUT_DAY = 0; }else{ $LEAVEHIS_WITHOUT_DAY = $_POST['LEAVEHIS_WITHOUT_DAY'];}
if(empty($_POST['LEAVEHIS_LATE_TIME'])){ $LEAVEHIS_LATE_TIME = 0; }else{ $LEAVEHIS_LATE_TIME = $_POST['LEAVEHIS_LATE_TIME'];}
if(empty($_POST['LEAVEHIS_LATE_DAY'])){ $LEAVEHIS_LATE_DAY = 0; }else{ $LEAVEHIS_LATE_DAY = $_POST['LEAVEHIS_LATE_DAY'];}
 
$LEAVEHIS_ID = $_POST['LEAVEHIS_ID'];
 

switch($proc){
	case "add" : 
		try{
		

			$sql_chk = "select count(*) as nums from ".$table." where LEAVEHIS_YEAR = '".$_POST['LEAVEHIS_YEAR']."' and PER_ID = ".$PER_ID."  ";  
			$chk = $db->get_data_field($sql_chk,"nums");   
			if($chk==1){
			/*
				 echo '<script>alert("ปีงบประมาณนี้ ท่านเคยทำการระบุแล้วค่ะ");form_back.submit();</script>';
				 exit();
				 */
			}
		
		
		
			unset($fields);
			$fields = array(
				"LEAVEHIS_YEAR" => (int)$_POST['LEAVEHIS_YEAR'],
				"LEAVEHIS_SICK_TIME" => (int)$LEAVEHIS_SICK_TIME,
 				"LEAVEHIS_SICK_DAY" =>  $LEAVEHIS_SICK_DAY,		
 				"LEAVEHIS_BIRTH_TIME" => (int)$LEAVEHIS_BIRTH_TIME,	
			    "LEAVEHIS_BIRTH_DAY" => $LEAVEHIS_BIRTH_DAY,	
			    "LEAVEHIS_HELP_TIME" => (int)$LEAVEHIS_HELP_TIME,					
			    "LEAVEHIS_HELP_DAY" => $LEAVEHIS_HELP_DAY,	
			    "LEAVEHIS_PRIVATE_TIME" => (int)$LEAVEHIS_PRIVATE_TIME,	
			    "LEAVEHIS_PRIVATE_DAY" => $LEAVEHIS_PRIVATE_DAY,					
				"LEAVEHIS_RELAX_TIME" => (int)$LEAVEHIS_RELAX_TIME,													
				"LEAVEHIS_RELAX_DAY" => $LEAVEHIS_RELAX_DAY,		
				"LEAVEHIS_REGION_TIME" => (int)$LEAVEHIS_REGION_TIME,	
				"LEAVEHIS_REGION_DAY" => $LEAVEHIS_REGION_DAY,	
				"LEAVEHIS_SOLDIER_TIME" => (int)$LEAVEHIS_SOLDIER_TIME,	
				"LEAVEHIS_SOLDIER_DAY" => $LEAVEHIS_SOLDIER_DAY,									
				"LEAVEHIS_STUDY_TIME" => (int)$LEAVEHIS_STUDY_TIME,
				"LEAVEHIS_STUDY_DAY" => $LEAVEHIS_STUDY_DAY,
				"LEAVEHIS_WORK_TIME" => (int)$LEAVEHIS_WORK_TIME,
				"LEAVEHIS_WORK_DAY" => $LEAVEHIS_WORK_DAY,	
				"LEAVEHIS_MARRIED_TIME" => (int)$LEAVEHIS_MARRIED_TIME,			
				"LEAVEHIS_MARRIED_DAY" => $LEAVEHIS_MARRIED_DAY,	
				"LEAVEHIS_COMPLETENCY_TIME" => (int)$LEAVEHIS_COMPLETENCY_TIME,							
				"LEAVEHIS_COMPLETENCY_DAY" => $LEAVEHIS_COMPLETENCY_DAY,							
				"LEAVEHIS_OTHER_TIME" => (int)$LEAVEHIS_OTHER_TIME,	
				"LEAVEHIS_OTHER_DAY" => $LEAVEHIS_OTHER_DAY,					
				"LEAVEHIS_WITHOUT_TIME" => (int)$LEAVEHIS_WITHOUT_TIME,	
				"LEAVEHIS_WITHOUT_DAY" => $LEAVEHIS_WITHOUT_DAY,	
				"LEAVEHIS_LATE_TIME" => (int)$LEAVEHIS_LATE_TIME,				
				"LEAVEHIS_LATE_DAY" => $LEAVEHIS_LATE_DAY,				
																								
								
				"PER_ID" => $PER_ID,
				"DELETE_FLAG" => '0',
				"CREATE_BY" => $USER_BY,
				"CREATE_DATE" => $TIMESTAMP,
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	//echo "<pre>"; print_r($fields); exit();
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
				"LEAVEHIS_YEAR" => (int)$_POST['LEAVEHIS_YEAR'],
				"LEAVEHIS_SICK_TIME" => (int)$LEAVEHIS_SICK_TIME,
 				"LEAVEHIS_SICK_DAY" =>  $LEAVEHIS_SICK_DAY,		
 				"LEAVEHIS_BIRTH_TIME" => (int)$LEAVEHIS_BIRTH_TIME,	
			    "LEAVEHIS_BIRTH_DAY" => $LEAVEHIS_BIRTH_DAY,	
			    "LEAVEHIS_HELP_TIME" => (int)$LEAVEHIS_HELP_TIME,					
			    "LEAVEHIS_HELP_DAY" => $LEAVEHIS_HELP_DAY,	
			    "LEAVEHIS_PRIVATE_TIME" => (int)$LEAVEHIS_PRIVATE_TIME,	
			    "LEAVEHIS_PRIVATE_DAY" => $LEAVEHIS_PRIVATE_DAY,					
				"LEAVEHIS_RELAX_TIME" => (int)$LEAVEHIS_RELAX_TIME,													
				"LEAVEHIS_RELAX_DAY" => $LEAVEHIS_RELAX_DAY,		
				"LEAVEHIS_REGION_TIME" => (int)$LEAVEHIS_REGION_TIME,	
				"LEAVEHIS_REGION_DAY" => $LEAVEHIS_REGION_DAY,	
				"LEAVEHIS_SOLDIER_TIME" => (int)$LEAVEHIS_SOLDIER_TIME,	
				"LEAVEHIS_SOLDIER_DAY" => $LEAVEHIS_SOLDIER_DAY,									
				"LEAVEHIS_STUDY_TIME" => (int)$LEAVEHIS_STUDY_TIME,
				"LEAVEHIS_STUDY_DAY" => $LEAVEHIS_STUDY_DAY,
				"LEAVEHIS_WORK_TIME" => (int)$LEAVEHIS_WORK_TIME,
				"LEAVEHIS_WORK_DAY" => $LEAVEHIS_WORK_DAY,	
				"LEAVEHIS_MARRIED_TIME" => (int)$LEAVEHIS_MARRIED_TIME,			
				"LEAVEHIS_MARRIED_DAY" => $LEAVEHIS_MARRIED_DAY,	
				"LEAVEHIS_COMPLETENCY_TIME" => (int)$LEAVEHIS_COMPLETENCY_TIME,							
				"LEAVEHIS_COMPLETENCY_DAY" => $LEAVEHIS_COMPLETENCY_DAY,							
				"LEAVEHIS_OTHER_TIME" => (int)$LEAVEHIS_OTHER_TIME,	
				"LEAVEHIS_OTHER_DAY" => $LEAVEHIS_OTHER_DAY,					
				"LEAVEHIS_WITHOUT_TIME" => (int)$LEAVEHIS_WITHOUT_TIME,	
				"LEAVEHIS_WITHOUT_DAY" => $LEAVEHIS_WITHOUT_DAY,	
				"LEAVEHIS_LATE_TIME" => (int)$LEAVEHIS_LATE_TIME,				
				"LEAVEHIS_LATE_DAY" => $LEAVEHIS_LATE_DAY,		
				"UPDATE_BY" => $USER_BY,
				"UPDATE_DATE" => $TIMESTAMP,
			);	//echo $LEAVEHIS_ID."<pre>"; print_r($fields); exit();
			$db->db_update($table,$fields," LEAVEHIS_ID = '".$LEAVEHIS_ID."' "); 
			
			$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	//echo "xx".$LEAVEHIS_ID; exit();
			$db->db_delete($table," LEAVEHIS_ID = '".$LEAVEHIS_ID."' ");
			
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
	<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>" />
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>