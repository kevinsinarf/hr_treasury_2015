<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
 
//echo $prco; exit;
 
//POST
$PER_IDCARD =$_POST['PER_IDCARD'];
$PER_IDCARD = str_replace("-","",$PER_IDCARD); 
$SALARY = str_replace(",","",$_POST['SALARY']);
$SALARY_POSITION = str_replace(",","",$_POST['SALARY_POSITION']);
$COMPENSATION_1 = str_replace(",","",$_POST['COMPENSATION_1']);
$COMPENSATION_2 = str_replace(",","",$_POST['COMPENSATION_2']);
$PER_COMPENSATION_3 = str_replace(",","",$_POST['PER_COMPENSATION_3']);
$PER_COMPENSATION_4 = str_replace(",","",$_POST['PER_COMPENSATION_4']);
$PER_COMPENSATION_5 = str_replace(",","",$_POST['PER_COMPENSATION_5']);
$PER_STEP = str_replace(",","",$_POST['PER_STEP']);
$CV_ID = $_POST['CV_ID'];
//ไฟล
$PER_FILE_PIC=$_FILES["PER_FILE_PIC"];

$OLD_FILE_PIC =$_POST['OLD_FILE_PIC'];
$PER_FILE_GPF=$_FILES["PER_FILE_GPF"];
$OLD_FILE_GPF =$_POST['OLD_FILE_GPF'];
$PER_FILE_SECRET=$_FILES["PER_FILE_SECRET"];
$OLD_FILE_SECRET =$_POST['OLD_FILE_SECRET'];
$PER_FILE_MAIN=$_FILES["PER_FILE_MAIN"];
$OLD_FILE_MAIN =$_POST['OLD_FILE_MAIN'];
$path_a=$path.'fileupload/profile_his/';

$RETYPE_ID = $_POST['PER_STATUS_RETYPE_IDCIVIL'];
 
 

//echo "on debuging :<pre>"; print_r($_POST); exit();
//echo conv_date_db($DATE_RETIRE); exit();
//page back
if($proc == 'delete'){
	if($PT_ID=="2"){
		$url_back = "../profile_his_empser.php";
	}elseif($PT_ID=="3"){
		$url_back = "../profile_his_emp.php";
	}else{
		$url_back = "../profile_his_disp.php";
	}
}else{
	$url_back = "../profile_his_form.php";
}

$table="PER_PROFILE";
 
switch($proc){
	case "add" : 
		$sql = "SELECT * FROM POSITION_FRAME WHERE  POS_ID = '".$POS_ID."' ";
		$query = $db->query($sql);
		$rec = $db->db_fetch_array($query);
		
		try{
			$db->query("BEGIN TRANSACTION");
			unset($fields);
			$V_FILE_PIC='NULL';
			if($PER_FILE_PIC['name']!=''||$PER_FILE_PIC['name']!=NULL){
				$V_FILE_PIC=getFilenameUplaod($PER_FILE_PIC,$path_a,$OLD_FILE_PIC);
			}
			$V_FILE_GPF='NULL';
			if($PER_FILE_GPF['name']!=''||$PER_FILE_GPF['name']!=NULL){
				$V_FILE_GPF=getFilenameUplaod($PER_FILE_GPF,$path_a,$OLD_FILE_GPF);
			}
			$V_FILE_SECRET='NULL';
			if($PER_FILE_SECRET['name']!=''||$PER_FILE_SECRET['name']!=NULL){
				$V_FILE_SECRET=getFilenameUplaod($PER_FILE_SECRET,$path_a,$OLD_FILE_SECRET);
			}
			$V_FILE_MAIN='NULL';
			if($PER_FILE_MAIN['name']!=''||$PER_FILE_MAIN['name']!=NULL){
				$V_FILE_MAIN=getFilenameUplaod($PER_FILE_MAIN,$path_a,$OLD_FILE_MAIN);
			}
			unset($fields);
			$fields["PER_IDCARD"]=$PER_IDCARD;
			$fields["PER_FILE_PIC"]=$V_FILE_PIC;
			$fields["PER_FILE_GPF"]=$V_FILE_GPF;
			$fields["PER_FILE_SECRET"]=$V_FILE_SECRET;
			$fields["PER_FILE_MAIN"]=$V_FILE_MAIN;
			$fields["PT_ID"]=$PT_ID;
			$fields["PREFIX_ID"]=$PREFIX_ID;
			$fields["PER_FIRSTNAME_TH"]=ctext($fname_th);
			$fields["PER_MIDNAME_TH"]=ctext($mname_th);
			$fields["PER_LASTNAME_TH"]=ctext($lname_th);
			$fields["PER_FIRSTNAME_EN"]=strtoupper(ctext($fname_en));
			$fields["PER_MIDNAME_EN"]=strtoupper(ctext($mname_en));
			$fields["PER_LASTNAME_EN"]=strtoupper(ctext($lname_en));
			$fields["PER_GENDER"]=$GENDER ;
			$fields["PER_BLOOD_TYPE"]=ctext($BLOOD_TYPE);
			$fields["PER_DATE_BIRTH"]= conv_date_db($DATE_BIRTH);
			$fields["PER_DATE_ENTRANCE"]=conv_date_db($DATE_ENTRANCE);
			$fields["PER_DATE_OCCUPLY"]=conv_date_db($DATE_OCCUPLY);
			$fields["PER_DATE_RESIGN"]=conv_date_db($DATE_RESIGN);
			$fields["PER_DATE_RETIRE"]=conv_date_db($DATE_RETIRE);
			$fields["PER_DATE_PRO1"] = conv_date_db($PER_DATE_PRO1);
			$fields["PER_DATE_PRO2"] = conv_date_db($PER_DATE_PRO2);
			$fields["PER_DATE_PRO3"] = conv_date_db($PER_DATE_PRO3);
			$fields["PER_DATE_POSITION"] = conv_date_db($PER_DATE_POSITION);
			$fields["PER_DATE_LEVEL"] = conv_date_db($PER_DATE_LEVEL);
			$fields["RELIGION_ID"]=$RELIGION_ID;
			$fields["NATION_ID"]=$NATION_ID;
			$fields["RACE_NATION_ID"]=$RACE_NATION_ID;
			$fields["PER_SKIN_COLOR"]=ctext($SKIN_COLOR);
			$fields["PER_SKIN_MARKUP"]=ctext($SKIN_MARKUP);
			$fields["PER_WEIGHT"]=$WEIGHT;
			$fields["PER_HEIGHT"]=$HEIGHT;
			$fields["POS_ID"]=$POS_ID;
			$fields["POS_NO"]=$rec['POS_NO'];
			$fields["POS_YEAR"]=$rec['POS_YEAR'];
			$fields["TYPE_ID"]=$rec['TYPE_ID'];
			$fields["LEVEL_ID"]=$rec['LEVEL_ID'];
			$fields["LINE_ID"]=$rec['LINE_ID'];
			$fields["MT_ID"] = $rec['MT_ID'];
			$fields["LG_ID"] = $rec['LG_ID'];
			$fields["MANAGE_ID"]= $rec['MANAGE_ID'];
			$fields["ORG_ID_1"] = $ORG_ID_1;
			$fields["ORG_ID_2"]=$ORG_ID_2;
			$fields["ORG_ID_3"]=$ORG_ID_3;
			$fields["ORG_ID_4"]=$ORG_ID_4;
			$fields["ORG_ID_5"]='';
			$fields["RETYPE_ID"]=$RETYPE_ID;
			$fields["PER_SALARY"]=$SALARY;
			$fields["PER_SALARY_POSITION"]=$SALARY_POSITION;
			$fields["PER_COMPENSATION_1"]=$COMPENSATION_1;
			$fields["PER_COMPENSATION_2"]=$COMPENSATION_2;
			$fields["PER_COMPENSATION_3"]=$PER_COMPENSATION_3;
			$fields["PER_COMPENSATION_4"]=$PER_COMPENSATION_4;
			$fields['PER_COMPENSATION_5'] = $PER_COMPENSATION_5;
			$fields["POSTYPE_ID"]=$POSTYPE_ID;
			$fields["PER_STATUS"]=$PER_STATUS;
			$fields["PER_STATUS_MILITARY"] = $PER_STATUS_MILITARY;
			$fields["PER_STATUS_MARRY"] = $PER_STATUS_MARRY;
 			$fields["GPF_STATUS"] = $GPF_STATUS;
			$fields["PER_STATUS_MOVEUP"] = $PER_STATUS_MOVEUP;
			$fields["PER_STATUS_PROBATION"] = $PER_STATUS_PROBATION;
			$fields["PER_STATUS_PENALTY"] = $PER_STATUS_PENALTY;
			$fields["PENSION_STATUS"] = $PENSION_STATUS;
			$fields["PER_STATUS_CIVIL"] = $PER_STATUS_CIVIL;
			$fields["PER_STEP"]=$PER_STEP;
			$fields["CV_ID"]=$CV_ID;
			$fields["ACTIVE_STATUS"]=$ACTIVE_STATUS;
			$fields["CREATE_BY"]=$USER_BY;
			$fields["CREATE_DATE"]= $TIMESTAMP;
			$fields["DELETE_FLAG"]='0'; // echo "<pre>"; print_r($_POST); echo "<pre>"; print_r($fields);exit();
			$db->db_insert($table,$fields);
			
			unset($fields);
			$fields["POS_STATUS"] = '3';
			$db->db_update("POSITION_FRAME",$fields," POS_ID = '".$POS_ID."' "); 
			$PER_ID = $db->get_data_field("SELECT MAX(PER_ID) AS PER_ID FROM ".$table." WHERE PER_IDCARD = '".$PER_IDCARD."' ","PER_ID");
			
			$proc = 'edit';
			$db->query("COMMIT TRANSACTION");
			$text=$save_proc;
		}catch(Exception $e){
			$db->query("ROLLBACK TRANSACTION");
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
			$sql = "SELECT * FROM POSITION_FRAME WHERE  POS_ID = '".$POS_ID."' ";
			$query = $db->query($sql);
			$rec = $db->db_fetch_array($query);
		try{
			 
			$db->query("BEGIN TRANSACTION");  
			if((int)$PER_STATUS_CIVIL == 2){				 
				if($POS_ID_OLD != $POS_ID){
					unset($fields);
					$fields["POS_STATUS"] = '2';
					$fields["UPDATE_BY"]=$USER_BY;
					$fields["UPDATE_DATE"]= $TIMESTAMP;
					$db->db_update("POSITION_FRAME",$fields," POS_ID = '".$POS_ID_OLD."' "); 
				}
			}
			
			unset($fields);
			if((int)$PER_STATUS_CIVIL == 3 or (int)$PER_STATUS_CIVIL == 4){					
				    $fields["POS_STATUS"] = '2';
					$fields["UPDATE_BY"]=$USER_BY;
					$fields["UPDATE_DATE"]= $TIMESTAMP;
					$db->db_update("POSITION_FRAME",$fields," POS_ID = '".$POS_ID_OLD."' "); 
					unset($fields);
					$fields["POS_ID"] = 'NULL';
					$db->db_update($table,$fields," PER_ID = '".$PER_ID."' ");
					unset($fields);
			}else{
				    $fields["POS_ID"] = $POS_ID;
					$fields["POS_NO"] = $rec['POS_NO'];
					$fields["POS_YEAR"]=$rec['POS_YEAR'];
					$fields["TYPE_ID"]=$rec['TYPE_ID'];
					$fields["LEVEL_ID"]=$rec['LEVEL_ID'];
					$fields["LINE_ID"]=$rec['LINE_ID'];
					$fields["MT_ID"] = $rec['MT_ID'];
					$fields["LG_ID"] = $rec['LG_ID'];
					$fields["MANAGE_ID"] = $rec['MANAGE_ID'];
					$db->db_update($table,$fields," PER_ID = '".$PER_ID."' ");
			}
			
			$V_FILE_PIC=getFilenameUplaod($PER_FILE_PIC,$path_a,$OLD_FILE_PIC);
			$fields["PER_FILE_PIC"]=$V_FILE_PIC;
			
			$V_FILE_GPF=getFilenameUplaod($PER_FILE_GPF,$path_a,$OLD_FILE_GPF);
			$fields["PER_FILE_GPF"]=$V_FILE_GPF;
			
			$V_FILE_SECRET=getFilenameUplaod($PER_FILE_SECRET,$path_a,$OLD_FILE_SECRET);
			$fields["PER_FILE_SECRET"]=$V_FILE_SECRET;
			
			$V_FILE_MAIN=getFilenameUplaod($PER_FILE_MAIN,$path_a,$OLD_FILE_MAIN);
			
			$fields["PER_FILE_MAIN"]=$V_FILE_MAIN;
			
			$fields["PER_IDCARD"]=$PER_IDCARD;
			$fields["PT_ID"]=$PT_ID;
			$fields["PREFIX_ID"]=$PREFIX_ID;
			$fields["PER_FIRSTNAME_TH"]=ctext($fname_th);
			$fields["PER_MIDNAME_TH"]=ctext($mname_th);
			$fields["PER_LASTNAME_TH"]=ctext($lname_th);
			$fields["PER_FIRSTNAME_EN"]=strtoupper(ctext($fname_en));
			$fields["PER_MIDNAME_EN"]=strtoupper(ctext($mname_en));
			$fields["PER_LASTNAME_EN"]=strtoupper(ctext($lname_en));
			$fields["PER_GENDER"]=$GENDER ;
			$fields["PER_BLOOD_TYPE"]=ctext($BLOOD_TYPE);
			$fields["PER_DATE_BIRTH"]= conv_date_db($DATE_BIRTH);
			$fields["PER_DATE_ENTRANCE"]=conv_date_db($DATE_ENTRANCE);
			$fields["PER_DATE_OCCUPLY"]=conv_date_db($DATE_OCCUPLY);
			$fields["PER_DATE_RESIGN"]=conv_date_db($DATE_RESIGN);
			$fields["PER_DATE_RETIRE"]=conv_date_db($DATE_RETIRE);
			$fields["PER_DATE_PRO1"] = conv_date_db($PER_DATE_PRO1);
			$fields["PER_DATE_PRO2"] = conv_date_db($PER_DATE_PRO2);
			$fields["PER_DATE_PRO3"] = conv_date_db($PER_DATE_PRO3);
			$fields["PER_DATE_POSITION"] = conv_date_db($PER_DATE_POSITION);
			$fields["PER_DATE_LEVEL"] = conv_date_db($PER_DATE_LEVEL);
			$fields["RELIGION_ID"]=$RELIGION_ID;
			$fields["NATION_ID"]=$NATION_ID;
			$fields["RACE_NATION_ID"]=$RACE_NATION_ID;
			$fields["PER_SKIN_COLOR"]=ctext($SKIN_COLOR);
			$fields["PER_SKIN_MARKUP"]=ctext($SKIN_MARKUP);
			$fields["PER_WEIGHT"]=$WEIGHT;
			$fields["PER_HEIGHT"]=$HEIGHT;
			$fields["ORG_ID_1"]= $ORG_ID_1;
			$fields["ORG_ID_2"]=$ORG_ID_2;
			$fields["ORG_ID_3"]=$ORG_ID_3;
			$fields["ORG_ID_4"]=$ORG_ID_4;
			$fields["ORG_ID_5"]='';
			$fields["PER_SALARY"]=$SALARY;
			$fields["PER_SALARY_POSITION"]=$SALARY_POSITION;
			$fields["PER_COMPENSATION_1"]=$COMPENSATION_1;
			$fields["PER_COMPENSATION_2"]=$COMPENSATION_2;
			$fields["PER_COMPENSATION_3"]=$PER_COMPENSATION_3;
			$fields["PER_COMPENSATION_4"]=$PER_COMPENSATION_4;
			$fields['PER_COMPENSATION_5'] = $PER_COMPENSATION_5;
			$fields["RETYPE_ID"]=$RETYPE_ID;
			$fields["PER_STATUS"]=$PER_STATUS;
			$fields["PER_STATUS_MILITARY"] = $PER_STATUS_MILITARY;
			$fields["PER_STATUS_MARRY"] = $PER_STATUS_MARRY;
 			$fields["GPF_STATUS"] = $GPF_STATUS;
			$fields["PER_STATUS_MOVEUP"] = $PER_STATUS_MOVEUP;
			$fields["PER_STATUS_PROBATION"] = $PER_STATUS_PROBATION;
			$fields["PER_STATUS_PENALTY"] = $PER_STATUS_PENALTY;
			$fields["PENSION_STATUS"] = $PENSION_STATUS;
			$fields["PER_STATUS_CIVIL"] = $PER_STATUS_CIVIL;
			$fields["PER_STEP"]=$PER_STEP;
			$fields["ACTIVE_STATUS"]=$ACTIVE_STATUS;
			$fields["UPDATE_BY"]=$USER_BY;
			$fields["UPDATE_DATE"]= $TIMESTAMP;
			$fields["CV_ID"]=$CV_ID;       // echo "<pre>"; print_r($fields); exit();
			$db->db_update($table,$fields," PER_ID = '".$PER_ID."' ");
			 
			if((int)$PER_STATUS_CIVIL == 2){
			  unset($fields);
			  $fields["POS_STATUS"] = '3';
			  $db->db_update("POSITION_FRAME",$fields," POS_ID = '".$POS_ID."' "); 
			}
			$db->query("COMMIT TRANSACTION");
			$text=$edit_proc;
		}catch(Exception $e){
			$db->query("ROLLBACK TRANSACTION");
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$sql="SELECT PER_FILE_PIC,PER_FILE_GPF,PER_FILE_SECRET,PER_FILE_MAIN, POS_ID FROM PER_PROFILE WHERE PER_ID='".$PER_ID."'";
			$data_n =$db->get_data_rec($sql);
			
			if(!empty($data_n['PER_FILE_PIC'])){
				unlink(@$path_a.$data_n['PER_FILE_PIC']);
			}
			if(!empty($data_n['PER_FILE_GPF'])){
				unlink(@$path_a.$data_n['PER_FILE_GPF']);
			}
			if(!empty($data_n['PER_FILE_SECRET'])){
				unlink(@$path_a.$data_n['PER_FILE_SECRET']);
			}
			if(!empty($data_n['PER_FILE_MAIN'])){
				unlink(@$path_a.$data_n['PER_FILE_MAIN']);
			}
			
			$POS_ID = $data_n["POS_ID"];
			if(!empty($POS_ID)){
				unset($fields);
				$fields["POS_STATUS"] = '2';
				$fields["UPDATE_BY"]=$USER_BY;
				$fields["UPDATE_DATE"]= $TIMESTAMP;
				$db->db_update("POSITION_FRAME",$fields," POS_ID = '".$POS_ID."' "); 
			}
			
			$db->db_delete($table," PER_ID = '".$PER_ID."' ");
			$text=$del_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_org" :  
	$PARENT_ID = $_POST['ORG_PARENT_ID'];	
	$obj = array();
	$sql = "SELECT a.ORG_ID,a.ORG_NAME_TH FROM SETUP_ORG as a
			  WHERE a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
			  ORDER BY case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ ASC";
	$query = $db->query($sql);	
	while($rec  = $db->db_fetch_array($query)){
		$row['ID'] = $rec['ORG_ID'];
		$row['VALUE'] = text($rec['ORG_NAME_TH']);
		array_push($obj, $row);
	}
	echo json_encode($obj);
    exit();
	break;
}

if($proc=='add' || $proc=='edit' || $proc=='delete'){
	$proc = $proc=='add'?'edit':$proc;
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