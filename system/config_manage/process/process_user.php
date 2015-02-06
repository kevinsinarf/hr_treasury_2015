<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

//POST
$code_pass = "";
$code_txt = "";
$PER_ID = trim($_POST['PER_ID']);
$IDCARD = str_replace('-','',$_POST['PER_IDCARD']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$email = ctext($_POST['email']);
$ACTIVE_STATUS = $_POST['ACTIVE_STATUS'];
$code_txt = 'e7e88ee56be19147f175b818275d6657';
$code_pass = hash_hmac('md5',$password,$code_txt);


switch($proc){
	case "add" : 
		try{
			$fields = array(
						   "aut_username" => $username,
						   "aut_password" => $code_pass,
						   "IDCARD" => $IDCARD,
						   'AUT_PER_ID' => $PER_ID,
						   "EMAIL" => $email,
						   "active_status" => $ACTIVE_STATUS,
						   "createby" => $USER_BY,
						   "create_timestamp" => $TIMESTAMP,
						    "DELETE_FLAG" => '0'
						   );	
			$db->db_insert("aut_user",$fields); unset($fields);
			
			$arr = $db->db_fetch_array($db->query("SELECT IDENT_CURRENT('aut_user')"));
			$max_id = $arr[0];
			
			$fields = array(
							"aut_user_id" => $max_id,
							"user_group_id" => $user_group_id,
							);
			$db->db_insert("aut_user_group",$fields); unset($fields);
			
				$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
						   "EMAIL" => $email,
						   "IDCARD" => $IDCARD,
						   "active_status" => $ACTIVE_STATUS,
						   "updateby" => $USER_BY,
						   "update_timestamp" => $TIMESTAMP,
						   "DELETE_FLAG" => '0'
						   );	
			$db->db_update("aut_user",$fields," aut_user_id = '".$aut_user_id."' "); unset($fields);
			
			$chk = $db->get_data_field("select count(*) as nums from aut_user_group where aut_user_id = '".$aut_user_id."' ","nums");
			$fields = array(
							"aut_user_id" => $aut_user_id,
							"user_group_id" => $user_group_id,
							);
			if(!$chk){
				$db->db_insert("aut_user_group",$fields); unset($fields);
			}else{
				$db->db_update("aut_user_group",$fields," aut_user_id = '".$aut_user_id."' "); unset($fields);
			}
			
				$text=$edit_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete("aut_user"," aut_user_id = '".$aut_user_id."' ");
			
		$text=$del_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "chk_dup" : 
	
		$filter = "";
		if($aut_user_id != ""){
			$filter = " and aut_user_id != '".$aut_user_id."' ";
		}
	//echo "select count(*) as nums from aut_user where aut_username = '".ctext($_POST['val'])."' $filter ";
		$chk = $db->get_data_field("select count(*) as nums from aut_user where aut_username = '".ctext($_POST['val'])."' $filter ","nums");
		$arr = array(
					 "flag"=> (!$chk) ? 0:1,
					 "detail"=> (!$chk) ? "สามารถใช้ username นี้ได้":"ไม่สามารถใช้ username นี้ได้",
					 );
		echo json_encode($arr);
	break;
	case "chk_idcard" : 
	$flag = "";
		
	$sql="SELECT PER_ID from PER_PROFILE where PER_STATUS_CIVIL = 2 AND DELETE_FLAG='0' AND PER_IDCARD = '".$_POST['val']."' ";
	$query = $db->query($sql);
	$data = $db->db_fetch_array($query);
	$query_aut = $db->query("SELECT COUNT(*) AS COUNT_AUT FROM AUT_USER WHERE IDCARD = '".$_POST['val']."' ");
	$rec_aut = $db->db_fetch_array($query_aut);
	if(trim($data['PER_ID']) != '' and (int)$rec_aut['COUNT_AUT'] == 0 ){
		$flag  = '0';
	}else{
		$flag = 1;
	}
	
	 
		$arr = array(
					 "flag"=> $flag,
					 "per_id"=> $data['PER_ID'],
					 "detail"=> ($data['PER_ID']!='') ? "สามารถใช้ ".$arr_txt['idcard']." นี้ได้":"ไม่สามารถใช้ ".$arr_txt['idcard']." นี้ได้",
					 );
		echo json_encode($arr);
		break;
		case "ChkEmail" :
			$email = trim($_POST['email']);
			$query = $db->query("SELECT COUNT(AUT_USER_ID) AS NUM_USER FROM AUT_USER WHERE EMAIL = '".$email."' ");
			$rec = $db->db_fetch_array($query);
			if((int)$rec['NUM_USER'] > 0){
				echo 1;
			}else if((int)$rec['NUM_USER'] == 0){
				echo '0';
			}
			
		exit;
		break;
}

$url_back="../disp_user.php";
if($proc!='chk_dup' && $proc!='chk_idcard'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
	<input type="hidden" id="SS_ID" name="SS_ID" value="<?php echo $SS_ID?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php } ?>