<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
  //echo "<pre>"; print_r($_POST); exit();
$POSTYPE_ID = $_POST['POSTYPE_ID'];
$POSHIS_ID = $_POST['POSHIS_ID'];
$PER_ID = $_POST['PER_ID'];
$CT_ID  = $_POST['CT_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];
$COM_NO = ctext($_POST['COM_NO']);
$COM_DATE = conv_date_db($_POST['COM_DATE']);
$POSHIS_DATE = conv_date_db($_POST['POSHIS_DATE']);
$COM_SDATE = conv_date_db($_POST['COM_SDATE']);
$TYPE_LIVE = $_POST['TYPE_LIVE'];
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];
$POS_NO = ctext($_POST['POS_NO']);
$POSHIS_NOTE = ctext($_POST['POSHIS_NOTE']);
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
$SALARY = str_replace(",","",$_POST['SALARY']);
$SALARY_POSITION = str_replace(",","",$_POST['SALARY_POSITION']);
$COMPENSATION_1 = str_replace(",","",$_POST['COMPENSATION_1']);
$COMPENSATION_2 = str_replace(",","",$_POST['COMPENSATION_2']);
$COMPENSATION_3 = str_replace(",","",$_POST['COMPENSATION_3']);
$COMPENSATION_4 = str_replace(",","",$_POST['COMPENSATION_4']);
$COMPENSATION_5 = str_replace(",","",$_POST['COMPENSATION_5']);
$SALHIS_TYPE = $_POST['SALHIS_TYPE'];
$SALHIS_UP = $_POST['SALHIS_UP'];

//-------พนักงานราชการ
if($POSTYPE_ID==3){
$POS_YEAR = $_POST['POS_YEAR'];
}

 //echo "<pre>"; print_r($_POST); exit();

$table="PER_POSITIONHIS";
switch($proc){
	case "add" : 
		try{		
			//$sql="select (case when MAX(POSHIS_SEQ)>0 then (MAX(POSHIS_SEQ)+1) else '1' end) as POSHIS_SEQ  from ".$table." where PER_ID='".$PER_ID."' ";
			//$POSHIS_SEQ = $db->get_data_field($sql,"POSHIS_SEQ");
			unset($fields);
			$fields = array(
				"PER_ID"	 => $PER_ID,
				"CT_ID"	 => $CT_ID,
				'POS_YEAR' => $POS_YEAR,
				"MOVEMENT_ID" => $MOVEMENT_ID,
				'COM_NO' => $COM_NO,
				'COM_DATE' => $COM_DATE,
				'POSHIS_DATE' => $POSHIS_DATE,
				'COM_SDATE' => $COM_SDATE,
				'TYPE_LIVE' => $TYPE_LIVE,
				'ACTIVE_STATUS' => $ACTIVE_STATUS,
				'POS_NO' => $POS_NO,
				'POSHIS_NOTE' => $POSHIS_NOTE,
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
				'SALARY' => $SALARY,
				'SALARY_POSITION' =>  $SALARY_POSITION,
				'COMPENSATION_1' =>  $COMPENSATION_1,
				'COMPENSATION_2' =>  $COMPENSATION_2,
				'COMPENSATION_3' =>  $COMPENSATION_3,
				'COMPENSATION_4' =>  $COMPENSATION_4,
				'COMPENSATION_5' =>  $COMPENSATION_5,
				'CREATE_BY' => $USER_BY,
				'CREATE_DATE' => $TIMESTAMP,
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
				'POS_YEAR' => $POS_YEAR,
				"MOVEMENT_ID" => $MOVEMENT_ID,
				'COM_NO' => $COM_NO,
				'COM_DATE' => $COM_DATE,
				'POSHIS_DATE' => $POSHIS_DATE,
				'COM_SDATE' => $COM_SDATE,
				'TYPE_LIVE' => $TYPE_LIVE,
				'ACTIVE_STATUS' => $ACTIVE_STATUS,
				'POS_NO' => $POS_NO,
				'POSHIS_NOTE' => $POSHIS_NOTE,
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
				'SALARY' => $SALARY,
				'SALARY_POSITION' =>  $SALARY_POSITION,
				'COMPENSATION_1' =>  $COMPENSATION_1,
				'COMPENSATION_2' =>  $COMPENSATION_2,
				'COMPENSATION_3' =>  $COMPENSATION_3,
				'COMPENSATION_4' =>  $COMPENSATION_4,
				'COMPENSATION_5' =>  $COMPENSATION_5,
				"UPDATE_BY" =>$USER_BY,
				"UPDATE_DATE" =>$TIMESTAMP,
				"DELETE_FLAG" =>'0'
			);
			$db->db_update($table,$fields," POSHIS_ID = '".$POSHIS_ID."' "); 		
			$text=$edit_proc;	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete($table," POSHIS_ID = '".$POSHIS_ID."' ");
			
	$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "getlevel" :
	    $obj = array();
		$sql =  "SELECT LEVEL_ID ,  LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE TYPE_ID = '".$TYPE_ID."' AND DELETE_FLAG = 0 AND POSTYPE_ID ='".$POSTYPE_ID."' order by LEVEL_SEQ ASC ";
		$query = $db->query($sql);
		
		while($rec=$db->db_fetch_array($query)){
			$row['ID'] = $rec['LEVEL_ID'];
			$row['VALUE'] = text($rec['LEVEL_NAME_TH']);
			array_push($obj, $row);
		}
		echo json_encode($obj);
	exit();
	break;
	case "getLineGroup" :
	    $sql = "SELECT LG_ID , LG_NAME_TH FROM SETUP_POS_LINE_GROUP WHERE TYPE_ID = '".$TYPE_ID."' AND DELETE_FLAG = 0 AND POSTYPE_ID ='".$POSTYPE_ID."' ORDER BY LG_NAME_TH ASC ";
		$query = $db->query($sql);
		$obj = array();
		while($rec=$db->db_fetch_array($query)){
				$row['ID'] = $rec['LG_ID'];
				$row['VALUE'] = text($rec['LG_NAME_TH']);
				array_push($obj,$row);
		}
		echo json_encode($obj);
		exit();
	break;
	case "GetLineGov" :
		$obj = array();
		$sql = "SELECT LINE_ID , LINE_NAME_TH FROM SETUP_POS_LINE WHERE LG_ID = '".$LG_ID."' AND DELETE_FLAG = 0 AND POSTYPE_ID ='".$POSTYPE_ID."' ORDER BY LINE_NAME_TH ASC ";
		$query = $db->query($sql);
		
		while($rec=$db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
			
		}
		echo json_encode($obj);
		
	exit();		
	break;
	case "GetManage" : {
		$sql = " Select a.MANAGE_ID , a.MANAGE_NAME_TH From SETUP_POS_MANAGE a  LEFT JOIN SETUP_POS_MANAGE_TYPE b ON a.MT_ID = b.MT_ID  WHERE a.DELETE_FLAG = '0'  AND a.MT_ID = '".$MT_ID."' ORDER BY MT_SEQ ASC   ";
		$query = $db->query($sql);
		$obj = array();
		while($rec = $db->db_fetch_array($query)){
			$row['ID'] = $rec['MANAGE_ID'];
			$row['VALUE'] = text($rec['MANAGE_NAME_TH']);
			array_push($obj,$row);
		}
		echo json_encode($obj); 
	}
	
	exit();
	break;
	case "GetLineEmp" :
		$obj = array();
		$sql = "SELECT LINE_ID , LINE_NAME_TH FROM SETUP_POS_LINE WHERE LEVEL_ID = '".$LEVEL_ID."' AND DELETE_FLAG = 0 AND POSTYPE_ID ='".$POSTYPE_ID."'";
		$query = $db->query($sql);
		
		while($rec=$db->db_fetch_array($query)){
			$row['ID'] = $rec['LINE_ID'];
			$row['VALUE'] = text($rec['LINE_NAME_TH']);
			array_push($obj,$row);
			
		}
		echo json_encode($obj);
		
	exit();		
	break;
	case "get_org" :  
		$PARENT_ID = $_POST['ORG_PARENT_ID'];	
		$obj = array();
		$sql = "SELECT a.ORG_ID,a.ORG_NAME_TH FROM SETUP_ORG as a
				  WHERE a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
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
$url_back="../profile_positionhis.php";
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
