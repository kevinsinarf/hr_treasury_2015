<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$BONUSHIS_ID = $_POST['BONUSHIS_ID'];
$PER_ID = $_POST['PER_ID'];
$CT_ID  = $_POST['CT_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];
$COM_NO = ctext($_POST['COM_NO']);
$COM_DATE = conv_date_db($_POST['COM_DATE']);
$BOUNUSHIS_DATE = conv_date_db($_POST['BOUNUSHIS_DATE']);
$COM_SDATE = conv_date_db($_POST['COM_SDATE']);
$TYPE_LIVE = $_POST['TYPE_LIVE'];
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];
$POS_NO = ctext($_POST['POS_NO']);
$BOUNUSHIS_NOTE = ctext($_POST['BOUNUSHIS_NOTE']);
$ORG_ID_1 = $_POST['ORG_ID_1'];
$ORG_ID_2 = $_POST['ORG_ID_2'];
$ORG_ID_3 = $_POST['ORG_ID_3'];
$ORG_ID_4 = $_POST['ORG_ID_4'];
$ORG_ID_5 = $_POST['ORG_ID_5'];
$TYPE_ID  = $_POST['TYPE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$LG_ID = $_POST['LG_ID'];
$LINE_ID = $_POST['LINE_ID'];
$MT_ID = $_POST['MT_ID'];
$MANAGE_ID = $_POST['MANAGE_ID'];
$SALARY = $_POST['SALARY'];
$SALARY_POSITION = $_POST['SALARY_POSITION'];
$COMPENSATION_1 = $_POST['COMPENSATION_1'];
$COMPENSATION_2 = $_POST['COMPENSATION_2'];
$COMPENSATION_3 = $_POST['COMPENSATION_3'];
$COMPENSATION_4 = $_POST['COMPENSATION_4'];
$COMPENSATION_5 = $_POST['COMPENSATION_5'];
$BONUSHIS_TYPE = $_POST['BONUSHIS_TYPE'];
$BONUSHIS_UP = $_POST['BONUSHIS_UP'];

$table="PER_BONUSHIS";
switch($proc){
	case "add" : 
		try{		
			//$sql="select (case when MAX(POSHIS_SEQ)>0 then (MAX(POSHIS_SEQ)+1) else '1' end) as POSHIS_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			//$POSHIS_SEQ = $db->get_data_field($sql,"POSHIS_SEQ");
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"CT_ID"	 => $CT_ID,
				"MOVEMENT_ID" => $MOVEMENT_ID,
				'COM_NO' => $COM_NO,
				'COM_DATE' => $COM_DATE,
				'BOUNUSHIS_DATE' => $BOUNUSHIS_DATE,
				'COM_SDATE' => $COM_SDATE,
				'TYPE_LIVE' => $TYPE_LIVE,
				'ACTIVE_STATUS' => $ACTIVE_STATUS,
				'POS_NO' => $POS_NO,
				'BOUNUSHIS_NOTE' => $BOUNUSHIS_NOTE,
				'ORG_ID_1' => $ORG_ID_1,
				'ORG_ID_2' => $ORG_ID_2,
				'ORG_ID_3' => $ORG_ID_3,
				'ORG_ID_4' => $ORG_ID_4,
				'ORG_ID_5' => $ORG_ID_5,
				'TYPE_ID'  => $TYPE_ID,
				'LEVEL_ID' => $LEVEL_ID,
				'LG_ID' => $LG_ID,
				'LINE_ID' => $LINE_ID,
				'MT_ID' => $MT_ID,
				'MANAGE_ID' => $MANAGE_ID,
				'SALARY' => str_replace(",","",$SALARY),
				'SALARY_POSITION' => str_replace(",","",$SALARY_POSITION),
				'COMPENSATION_1' =>  str_replace(",","",$COMPENSATION_1),
				'COMPENSATION_5' =>  str_replace(",","",$COMPENSATION_5),
				'CREATE_BY' => ctext($USER_BY),
				'UPDATE_BY' => ctext($USER_BY),
				'CREATE_DATE' => $TIMESTAMP,
				'UPDATE_DATE' => $TIMESTAMP,
				'DELETE_FLAG' => '0'
			);
			$db->db_insert($table,$fields);
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit":
			try{
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"CT_ID"	 => $CT_ID,
				"MOVEMENT_ID" => $MOVEMENT_ID,
				'COM_NO' => $COM_NO,
				'COM_DATE' => $COM_DATE,
				'BOUNUSHIS_DATE' => $BOUNUSHIS_DATE,
				'COM_SDATE' => $COM_SDATE,
				'TYPE_LIVE' => $TYPE_LIVE,
				'ACTIVE_STATUS' => $ACTIVE_STATUS,
				'POS_NO' => $POS_NO,
				'BOUNUSHIS_NOTE' => $BOUNUSHIS_NOTE,
				'ORG_ID_1' => $ORG_ID_1,
				'ORG_ID_2' => $ORG_ID_2,
				'ORG_ID_3' => $ORG_ID_3,
				'ORG_ID_4' => $ORG_ID_4,
				'ORG_ID_5' => $ORG_ID_5,
				'TYPE_ID'  => $TYPE_ID,
				'LEVEL_ID' => $LEVEL_ID,
				'LG_ID' => $LG_ID,
				'LINE_ID' => $LINE_ID,
				'MT_ID' => $MT_ID,
				'MANAGE_ID' => $MANAGE_ID,
				'SALARY' => str_replace(",","",$SALARY),
				'SALARY_POSITION' => str_replace(",","",$SALARY_POSITION),
				'COMPENSATION_1' =>  str_replace(",","",$COMPENSATION_1),
				'COMPENSATION_5' =>  str_replace(",","",$COMPENSATION_5),
				"CREATE_BY" => $USER_BY,
				"UPDATE_BY" =>$USER_BY,
				"CREATE_DATE"=>$TIMESTAMP,
				"UPDATE_DATE" =>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			);
			$db->db_update($table,$fields," BOUNUSHIS_ID = '".$BOUNUSHIS_ID."' "); 		
			$text=$edit_proc;	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," BOUNUSHIS_ID = '".$BOUNUSHIS_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_manage" :
	$sql = "SELECT MANAGE_ID , MANAGE_NAME_TH FROM SETUP_POS_MANAGE WHERE  MT_ID = '".$MT_ID."' ";
		$query = $db->query($sql);
		echo "<select id=\"MANAGE_ID\" name=\"MANAGE_ID\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\"> ";
		echo '<option value=""></option>';
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['MANAGE_ID']).'">'.text($rec['MANAGE_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit();
	break;
	case "getOrg" :
		try{
			$org=$_POST['org'];	
			$parent_id=$_POST['parent_id'];	
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];	
			$onchange=$_POST['onchange'];
			$key_index=$_POST['key_index'];	
			$span_id=$_POST['span_id'];	
			if($org != 2){
				$Cond .= " AND a.ORG_PARENT_ID = '".$parent_id."' AND a.ORG_PARENT_ID IS NOT NULL ";
			}
			$org_name = array(
				'2' => "ระดับกรม",
				'3' => "ระดับกอง/สำนัก/กลุ่ม",
				'4' => "ระดับส่วน/กลุ่มงาน",
			);
			$arr_org=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ".$Cond, "ORG_NAME_TH");
			$arr_json["org"] = $org;
			$arr_json["key_index"] = $key_index;
			$arr_json["selectbox"] = GetHtmlSelect($z_id.$org.$key_index, $z_name.$org.$key_index, $arr_org,$org_name[$org], '' ,'onchange="changeORG(\''.($org+1).'\', this.value, \''.$z_id.'\', \''.$span_id.'\', \''.$onchange.'\', \''.$key_index.'\');"','','');
			echo json_encode($arr_json);
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "org_2" :    //org2
		try{
		$PARENT_ID=$_POST['PARENT_ID'];	
		$oncharng=$_POST['oncharng'];		
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		$sql_org2 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org2 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'getORG2(this.value,\''.$oncharng.'\')',
				's_placeholder'=>'ระดับกรม',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "org_3" :    //org3
		try{
		$PARENT_ID=$_POST['PARENT_ID'];	
		$oncharng=$_POST['oncharng'];		
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		 $sql_org3 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org3 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'getORG3(this.value,\''.$oncharng.'\')',
				's_placeholder'=>'ระดับกอง/สำนัก/กลุ่ม',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "org_4" :    //org4
		try{
		$PARENT_ID=$_POST['PARENT_ID'];			
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		$sql_org4 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org4 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'getORG5(this.value,\''.$oncharng.'\')',
				's_placeholder'=>'ระดับส่วน/กลุ่มงาน',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_org_4" : {
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$PARENT_ID."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"ORG_ID_4\" name=\"ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\" onchange=\"getORG5(this.value,ORG_ID_5);\" >";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
	}break;
	case "get_org_5" : {
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$PARENT_ID."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"ORG_ID_5\" name=\"ORG_ID_5\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
	}break;
	
case "org_5" :    //org5
		try{
		$PARENT_ID=$_POST['PARENT_ID'];			
		echo $PARENT_ID;
		exit();
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		$sql_org4 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org5 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'ระดับฝ่าย',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_manage_1" : {
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND MT_ID = '".$mt_id."' ORDER BY MANAGE_ID ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['MANAGE_ID'];
			$row['VALUE'] = text($rec['MANAGE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}
	break;
	case "get_org_4_1" : {
		$sql = "select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$org_parent_id."' ORDER BY ORG_SEQ ASC";
		$query = $db->query($sql);
		echo "<select id=\"S_ORG_ID_4\" name=\"S_ORG_ID_4\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['ORG_ID']).'">'.text($rec['ORG_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
	}break;
	case "get_line_1" : {
$sql = "SELECT LINE_ID , LINE_NAME_TH From SETUP_POS_LINE
 WHERE  (LG_ID = '".$lg_id."' OR TYPE_ID = '".$type_id."')  AND  DELETE_FLAG = '0'   AND POSTYPE_ID = '1' ORDER BY LINE_NAME_TH ASC";
		$query = $db->query($sql);
			echo "<select id=\"LINE_ID\" name=\"LINE_ID\" class=\"selectbox form-control\" placeholder=\"-ทั้งหมด-\">";
		echo "<option value=\"\"></option>";
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['LINE_ID']).'">'.text($rec['LINE_NAME_TH']).'</option>';
		}
		echo "</select>";
		exit;
	}break;
		case "get_level_1" : {
		$sql = "Select LEVEL_ID , LEVEL_NAME_TH From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 }
	 exit;
	break;
	case "get_lg_1" : {
		$sql = "Select LG_ID , LG_NAME_TH From SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS = 1 AND TYPE_ID = ".$type_id." AND POSTYPE_ID = ".$postype_id." AND DELETE_FLAG = '0' ORDER BY LG_ID ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['LG_ID'];
			$row['VALUE'] = text($rec['LG_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj);
	 }
	 exit;
	break;
	case "get_manage_1" : {
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND MT_ID = '".$mt_id."' ORDER BY MANAGE_ID ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['MANAGE_ID'];
			$row['VALUE'] = text($rec['MANAGE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}
	break;
	case "get_position_1" :
	 $SQL = "SELECT A.PER_SALARY, J.POS_NO, B.TYPE_NAME_TH, C.MANAGE_NAME_TH, D.LINE_NAME_TH,  E.LEVEL_NAME_TH, G.ORG_NAME_TH AS ORG_NAME_3, H.ORG_NAME_TH AS ORG_NAME_4
	             FROM PER_PROFILE A
				 LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
				 LEFT JOIN SETUP_POS_MANAGE C ON A.MANAGE_ID = C.MANAGE_ID
				 LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
				 LEFT JOIN SETUP_POS_LEVEL E ON A.LEVEL_ID = E.LEVEL_ID
				 LEFT JOIN SETUP_ORG G ON A.ORG_ID_3 = G.ORG_ID
				 LEFT JOIN SETUP_ORG H ON A.ORG_ID_4 = H.ORG_ID
				 LEFT JOIN POSITION_FRAME J ON A.POS_ID = J.POS_ID 
				 WHERE PER_ID = '".$PER_ID."' ";
		$query = $db->query($SQL);
		$rec = $db->db_fetch_array($query);
		$html = "<table width='100%' border='0' cellspacing='0' cellpadding='0'  >
                    <tbody style=' background-color:transparent;' >
                      <tr height='10px;' >
                        <td align='left' width='40%'>&nbsp;</td>
                        <td width='40%' align='left'>&nbsp;</td>
                      </tr>
                      <tr  >
                        <td align='left' >เลขที่ตำแหน่ง : ".$rec['POS_NO']."</td>
                        <td align='left' ></td>
                        
                      </tr>
					    <tr>
                        <td align='left' >ตำแหน่งทางการบริหาร : ".text($rec['MANAGE_NAME_TH'])."</td>
                        <td align='left' ></td>
                        <td align='left' ></td>
                      </tr>
					  		  <tr>
                        <td align='left' >ประเภทตำแหน่ง : ".text($rec['TYPE_NAME_TH'])."</td>
                        <td align='left' ></td>
                      </tr>
					  <tr>
                        <td align='left' >ตำแหน่งในสายงาน : ".text($rec['LINE_NAME_TH'])."</td>
                        <td align='left' ></td>
                        <td align='left' ></td>
                      </tr>
					  <tr>
                        <td align='left' >ระดับ : ".text($rec['LEVEL_NAME_TH'])."</td>
                      </tr>
					  <tr>
              			<td align='left' >กลุ่มงาน : ".text($rec['ORG_NAME_4'])."</td>
                      </tr>
					  	  <tr>
						<td align='left' >สำนัก/กลุ่ม : ".text($rec['ORG_NAME_3'])."</td>
                      </tr>
                     </tbody>
                    </table>";
     echo $html;
	 exit;
	break;
	
}
$url_back="../profile_bonus.php";
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
