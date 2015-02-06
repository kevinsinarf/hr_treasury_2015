<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$ARR_APP_ID = $_POST['APP_ID'];

$$FILE_PIC_NEW = $_POST['$FILE_PIC_NEW'];
$TB = "PER_PROFILE";
$TB1 = "PER_POSITIONHIS";
$TB2 = "PER_JOBHIS";
$TB3 = "PER_ADDRESS";
$TB4 = "PER_EDUCATEHIS";
$TB5 = "APPLIED";



switch($proc){
	case "transfer" : 
		try{	
		
			if(count($ARR_APP_ID) > 0){
				$db->query('BEGIN TRANSACTION');
				foreach($ARR_APP_ID as $index => $val){
										
					$FILE_PIC_OLD = $FILE_PIC_NEW[$index];
					if(trim($FILE_PIC_OLD)!=""){
							list($FILE_NEW, $FILE_LAST) = explode(".",$FILE_PIC_OLD);
							$FILE_PIC_NE = $prefix.rand(10,99).date('Ymdhis').".".$FILE_LAST;
							$file =  $path."fileupload/file_applicant/".$FILE_PIC_OLD;
							$newfile = $path."fileupload/profile_his/".$FILE_PIC_NE;
							@copy($file,$newfile);
					}
					
					$rec_app = $db->get_data_rec("SELECT CAN_ID, POS_ID, APPOINT_ID FROM APPLIED WHERE APP_ID = '".$val."' ");
					$rec_com = $db->get_data_rec("SELECT * FROM APPOINT_COMMAND  WHERE  APPOINT_ID = '".$rec_app['APPOINT_ID']."' AND DELETE_FLAG = 0 ");
					$rec_fram = $db->get_data_rec("SELECT * FROM POSITION_FRAME  WHERE POS_ID = '".$rec_app['POS_ID']."' "); 
					$rec_profile = $db->get_data_rec("SELECT * FROM CANDIDATE_PROFILE  WHERE CAN_ID = '".$rec_app['CAN_ID']."' "); 	
					$query_jobhis = $db->query("SELECT * FROM CANDIDATE_JOBHIS  WHERE  CAN_ID = '".$rec_app['CAN_ID']."' AND DELETE_FLAG = 0 "); 
					$query_address = $db->query("SELECT * FROM CANDIDATE_ADDRESS  WHERE  CAN_ID = '".$rec_app['CAN_ID']."' AND DELETE_FLAG = 0 "); 
					$query_edu = $db->query("SELECT * FROM CANDIDATE_EDUCATEHIS  WHERE  CAN_ID = '".$rec_app['CAN_ID']."' AND DELETE_FLAG = 0 ");  
					
					//INSERT PER_PROFILE
					$fields = array(
						'PT_ID' => 2,
						'POSTYPE_ID' => 3,
						'PER_IDCARD' => $rec_profile['CAN_IDCARD'],
						'PREFIX_ID' => $rec_profile['PREFIX_ID'],
						'PER_FIRSTNAME_TH' => $rec_profile['CAN_FIRSTNAME_TH'],
						'PER_MIDNAME_TH' => $rec_profile['CAN_MIDNAME_TH'],
						'PER_LASTNAME_TH' => $rec_profile['CAN_LASTNAME_TH'],
						'PER_FIRSTNAME_EN' =>$rec_profile['CAN_FIRSTNAME_EN'],
						'PER_MIDNAME_EN' => $rec_profile['CAN_MIDNAME_EN'],
						'PER_LASTNAME_EN' => $rec_profile['CAN_LASTNAME_EN'],
						'PER_GENDER' => $rec_profile['CAN_GENDER'],
						'PER_BLOOD_TYPE' => $rec_profile['CAN_BLOOD_TYPE'],
						'RELIGION_ID' => $rec_profile['RELIGION_ID'],
						'NATION_ID' => $rec_profile['NATION_ID'],
						'PER_WEIGHT' => $rec_profile['CAN_WEIGHT'],
						'PER_HEIGHT' => $rec_profile['CAN_HEIGHT'],
						'RACE_NATION_ID' => $rec_profile['RACE_NATION_ID'],
						'POS_ID' => $rec_app['POS_ID'],
						'TYPE_ID' => $rec_fram['TYPE_ID'],
						'LEVEL_ID' => $rec_fram['LEVEL_ID'],
						'LINE_ID' => $rec_fram['LINE_ID'],
						'MANAGE_ID' => $rec_fram['MANAGE_ID'],
						'ORG_ID_1' => $rec_fram['ORG_ID_1'],
						'ORG_ID_2' => $rec_fram['ORG_ID_2'],
						'ORG_ID_3' => $rec_fram['ORG_ID_3'],
						'ORG_ID_4' => $rec_fram['ORG_ID_4'],
						'ORG_ID_5' => $rec_fram['ORG_ID_5'],
						'PER_SALARY' => $rec_fram['POS_FRAME_SALARY'],
						'PER_SALARY_POSITION' => $rec_fram['POS_FRAME_POSITION_SALARY'],
						'PER_COMPENSATION_1' => $rec_fram['POS_FRAME_COMPENSATION_1'],
						'PER_COMPENSATION_2' => $rec_fram['POS_FRAME_COMPENSATION_2'],
						'PER_DATE_BIRTH' => $rec_profile['CAN_BRITH_DATE'],
						'POS_NO' => $rec_fram['POS_NO'],
						'POS_YEAR' => $rec_fram['POS_YEAR'],
						'MT_ID' => $rec_fram['MT_ID'],
						'LG_ID' => $rec_fram['LG_ID'],
						"PER_FILE_PIC" =>$FILE_PIC_NE,
						'PER_STATUS' => 1,
						'PER_STATUS_PROBATION' => 0,
						'PER_STATUS_CIVIL' => 2,
						'ACTIVE_STATUS' => 1,
					   'CREATE_BY' => $USER_BY,
					   'CREATE_DATE' => $TIMESTAMP,
					   'DELETE_FLAG' => 0							
					);
					$db->db_insert($TB,$fields);		
					$rec_max = $db->get_data_rec("SELECT MAX(PER_ID) AS MAX_PER FROM PER_PROFILE  ");
					$PER_ID = $rec_max['MAX_PER'];
					
					//INSERT PER_POSITIONHIS
					$fields = array(
						'PER_ID' => $PER_ID,
						'MOVEMENT_ID' =>  1,
						'CT_ID' => $rec_com['CT_ID'],
						'COM_NO' => $rec_com['APPOINT_NO'],
						'COM_DATE' => $rec_com['APPOINT_DATE'],
						'POSTYPE_ID'=> 3,
						'POS_NO' => $rec_fram['POS_NO'],
						'TYPE_ID' => $rec_fram['TYPE_ID'],
						'LEVEL_ID' => $rec_fram['LEVEL_ID'],
						'LG_ID' => $rec_fram['LG_ID'],
						'LINE_ID' => $rec_fram['LINE_ID'],
						'MT_ID' => $rec_fram['MT_ID'],
						'MANAGE_ID' => $rec_fram['MANAGE_ID'],
						'ORG_ID_1' => $rec_fram['ORG_ID_1'],
						'ORG_ID_2' => $rec_fram['ORG_ID_2'],
						'ORG_ID_3' => $rec_fram['ORG_ID_3'],
						'ORG_ID_4' => $rec_fram['ORG_ID_4'],
						'ORG_ID_5' => $rec_fram['ORG_ID_5'],
						'SALARY' => $rec_fram['POS_FRAME_SALARY'],
						'SALARY_POSITION' => $rec_fram['POS_FRAME_POSITION_SALARY'],
						'COMPENSATION_1' => $rec_fram['POS_FRAME_COMPENSATION_1'],
						'COMPENSATION_3' => $rec_fram['POS_FRAME_COMPENSATION_2'],
				        'ACTIVE_STATUS' => 1,
						'CREATE_BY' => $USER_BY,
						'CREATE_DATE'  =>  $TIMESTAMP,
						'DELETE_FLAG' => 0
					);	
					$db->db_insert($TB1,$fields);	
					
					//INSERT PER_JOBHIS
					while($rec_jobhis = $db->db_fetch_array($query_jobhis)){
						$fields = array(
							'PER_ID' => $PER_ID,
							'JOH_SEQ' => $rec_jobhis['CJOH_SEQ'],
							'JOH_JOB_TYPE' => $rec_jobhis['CJOH_STATUS_CIVIL'],
							'JOB_EJOB_NAME' => $rec_jobhis['CJOB_EJOB_NAME'],
							'CV_ID' => $rec_jobhis['CV_ID'],
							'ORG_ID_1' => $rec_jobhis['ORG_ID_1'],
							'ORG_ID_2' => $rec_jobhis['ORG_ID_2'],
							'ORG_ID_3' => $rec_jobhis['ORG_ID_3'],
							'ORG_ID_4' => $rec_jobhis['ORG_ID_4'],
							'ORG_ID_5' => $rec_jobhis['ORG_ID_5'],
							'TYPE_ID' => $rec_jobhis['TYPE_ID'],
							'LEVEL_ID' => $rec_jobhis['LEVEL_ID'],
							'LG_ID' => $rec_jobhis['LG_ID'],
							'LINE_ID' => $rec_jobhis['LINE_ID'],
							'JOH_SDATE' => $rec_jobhis['CJOH_SDATE'],
							'JOH_EDATE' => $rec_jobhis['CJOH_EDATE'],
							'JOB_ID' => $rec_jobhis['JOB_ID'],
							'JOH_POS_NAME' => $rec_jobhis['CJOH_POS_NAME'],
							'JOH_ORG_NAME' => $rec_jobhis['CJOH_ORG_NAME'],
							'JOH_MISSION' => $rec_jobhis['CJOH_MISSION'],
							'JOH_SALARY' => $rec_jobhis['CJOH_SALARY'],
							'REQUEST_RESULT' => 2,
							'REQUEST_STATUS' => 2,
							'ACTIVE_STATUS' => 1,
							'DELETE_FLAG' => 0,
							'CREATE_BY' => $USER_BY,
							'CREATE_DATE'  =>  $TIMESTAMP,
						);
						$db->db_insert($TB2,$fields);	 
					}
					//INSERT PER_ADDRESS
					while($rec_address = $db->db_fetch_array($query_address)){
						$fields = array(
							'PER_ID' => $PER_ID,
							'PADD_TYPE' => $rec_address['CANA_TYPE'],
							'PADD_ROOM_NO' => $rec_address['CANA_ROOM_NO'],
							'PADD_BUILDING' => $rec_address['CANA_BUILDING'],
							'PADD_HOME_NO' => $rec_address['CANA_HOMENO'],
							'PADD_MOO' => $rec_address['CANA_MOO'],
							'PADD_VILLAGE' => $rec_address['CANA_VILLAGE'],
							'PADD_SOI' => $rec_address['CANA_SOI'],
							'PADD_ROAD' => $rec_address['CANA_ROAD'],
							'PADD_TAMB_ID' => $rec_address['TAMB_ID'],
							'PADD_AMPR_ID' => $rec_address['AMPR_ID'],
							'PADD_PROV_ID' => $rec_address['PROV_ID'],
							'PADD_POSTCODE' => $rec_address['CANA_ZIPCODE'],
							'PADD_TEL' => $rec_address['CANA_TEL'],
							'PADD_FAX' => $rec_address['CANA_FAX'],
							'PADD_MOBILE' => $rec_address['CANA_MOBILE'],
							'REQUEST_RESULT' => 2,
							'REQUEST_STATUS' => 2,
							'ACTIVE_STATUS' => 1,
							'DELETE_FLAG' => 0,
							'CREATE_BY' => $USER_BY,
							'CREATE_DATE'  =>  $TIMESTAMP,
						);
						$db->db_insert($TB3,$fields);	 
					}
					//INSERT PER_EDUCATEHIS
					while($rec_edu = $db->db_fetch_array($query_edu)){
							$fields = array(
								'PER_ID' => $PER_ID,
								'EL_ID' => $rec_edu['EL_ID'],
								'ED_ID' => $rec_edu['ED_ID'],
								'EM_ID' => $rec_edu['EM_ID'],
								'INS_ID' => $rec_edu['INS_ID'],
								'COUNTRY_ID' => $rec_edu['COUNTRY_ID'],
								'EDU_GPA' => $rec_edu['CEDU_GPA'],
								'EDU_HORNOR' => $rec_edu['CEDU_HORNOR'],
								'EDU_SDATE' => $rec_edu['CEDU_SDATE'],
								'EDU_EDATE' => $rec_edu['CEDU_EDATE'],
								'EDU_SCHOLARSHIP' => $rec_edu['CEDU_SCHOLARSHIP'],
								'EDU_NOTE' => $rec_edu['CEDU_NOTE'],
								'REQUEST_RESULT' => 2,
								'REQUEST_STATUS' => 2,
								'ACTIVE_STATUS' => 1,
								'DELETE_FLAG' => 0,
								'CREATE_BY' => $USER_BY,
								'CREATE_DATE'  =>  $TIMESTAMP,
							); 
							$db->db_insert($TB4,$fields);	
					}
					$db->db_update($TB5,array('TRANSFER_STATUS' => 1)," APP_ID = '".$val."' ");
				}
				
				$db->query("COMMIT TRANSACTION");
				$text=$save_proc;
			}
		}catch(Exception $e){
			$db->query('ROLLBACK TRANSACTION');
			$text=$e->getMessage();
		}
	
	break;
	case "get_org" : 
	    $ORG_ID = $_POST['ORG_ID'];
		$obj = array();
		$sql = "SELECT ORG_ID, ORG_NAME_TH FROM  SETUP_ORG WHERE ORG_PARENT_ID = '".$ORG_ID."' ";
		$query = $db->query($sql);
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['ORG_ID'];
		    $row['VALUE'] = text($rec['ORG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
		exit;
	
	break;
	
}
$url_back="../profile_his_new_gov_disp.php";
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
