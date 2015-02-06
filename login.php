<?php
session_start();
header ('Content-type: text/html; charset=utf-8');
$path = "";
$NoChk=1;
try{
	$user_test = $_POST["user_test"];
	if(isset($user_test)){
		$_SESSION["sys_user_test"] = $user_test;
	}
	include($path."include/config_header_top.php");
	
	$username = $_POST["username"];
	$password = $_POST["password"];
	$code_txt = 'e7e88ee56be19147f175b818275d6657';
	$code_pass = hash_hmac('md5',$password,$code_txt);
	
	//แสดงข้อมูลชื่อ 
	function Showname2($prefix_id, $fname, $mname, $lname, $lang='th'){
		global $db;
		
		$field=($lang=='th'?"PREFIX_NAME_TH":"PREFIX_NAME_EN");
		
		$data_fix=$db->db_fetch_array($db->query("select ".$field."+(case SPACE_STATUS when '1' then '&nbsp;' else '' end) as PREFIX_NAME from SETUP_PREFIX where PREFIX_ID='".$prefix_id."'")); 
	
		return iconv("tis-620","utf-8",trim($data_fix['PREFIX_NAME']).trim($fname).(trim($mname)?"&nbsp;".$mname:"").(trim($lname)?"&nbsp;&nbsp;".$lname:""));
	}
	////
	
	if($username != "" & $password != ""){
		
		$sqlChk = sprintf("select * 
						  from aut_user a
						  join aut_user_group b on a.aut_user_id = b.aut_user_id
						  join PER_PROFILE c on a.AUT_PER_ID = c.PER_ID
						  where a.aut_username = '%s' and a.aut_password = '%s' ",$username,$code_pass);
		$queryChk = $db->query($sqlChk);
		$nums = $db->db_num_rows($queryChk);
		$arrSet = array();
		if($nums){
			$rec = $db->db_fetch_array($queryChk);
			$rec = array_change_key_case($rec,CASE_LOWER);
			//$_SESSION["sys_id"] = $rec["aut_user_id"];
			//$_SESSION["sys_username"] = $rec["aut_username"];
			$_SESSION["sys_id"] = $rec["per_id"];
			
			////
			$data_fix=$db->db_fetch_array($db->query("select PREFIX_NAME_TH+(case SPACE_STATUS when '1' then '&nbsp;' else '' end) as PREFIX_NAME from SETUP_PREFIX where PREFIX_ID='".$rec['prefix_id']."'")); 
			$_SESSION["sys_name"] = text(trim($data_fix['PREFIX_NAME']).trim($rec["per_firstname_th"]).(trim($rec["per_midname_th"])?"&nbsp;".$rec["per_midname_th"]:"").(trim($rec["per_lastname_th"])?"&nbsp;&nbsp;".$rec["per_lastname_th"]:""));
			////
			
			$_SESSION["sys_group_id"] = $rec["user_group_id"];
			
			$sqlMenu = "select * from aut_group_menu where user_group_id = '".$rec["user_group_id"]."' order by menu_id asc";
			$queryMenu = $db->query($sqlMenu);
			while($recMenu = $db->db_fetch_array($queryMenu)){
				$recMenu = array_change_key_case($recMenu,CASE_LOWER);
				$sqlRecur = "with recursive_menber as (
					select menu_id , menu_parent_id , menu_group , menu_level , menu_desc from aut_menu_setting where menu_id = '".$recMenu["menu_id"]."'
					
					union all
					
					select a.menu_id , a.menu_parent_id , a.menu_group , a.menu_level , a.menu_desc from aut_menu_setting a
					join recursive_menber b on b.menu_parent_id = a.menu_id
				)
				select * from recursive_menber order by menu_group asc , menu_level asc ";
				$queryRecur = $db->query($sqlRecur);
				while($recRe = $db->db_fetch_array($queryRecur)){
					$recRe = array_change_key_case($recRe,CASE_LOWER);
					if($recRe["menu_level"] == 0){
						$id = (int)$recRe["menu_id"];
					}elseif($recRe["menu_level"] == 1){		
						$id1 = (int)$recRe["menu_id"];
						if($id1 == $recMenu["menu_id"]){
							$arrMenu1[$id][$id1]["add"] = $recMenu["user_add"];
							$arrMenu1[$id][$id1]["edit"] = $recMenu["user_edit"];
							$arrMenu1[$id][$id1]["delete"] = $recMenu["user_delete"];
						}
						$arrMenu[$id] = $arrMenu1[$id];
					}elseif($recRe["menu_level"] == 2){
						$id2 = (int)$recRe["menu_id"];
						if($id2 == $recMenu["menu_id"]){
							$arrMenu2[$id][$id1][$id2]["add"] = $recMenu["user_add"];
							$arrMenu2[$id][$id1][$id2]["edit"] = $recMenu["user_edit"];
							$arrMenu2[$id][$id1][$id2]["delete"] = $recMenu["user_delete"];
						}
						$arrMenu1[$id][$id1] = $arrMenu2[$id][$id1];
						$arrMenu[$id] = $arrMenu1[$id];
					}elseif($recRe["menu_level"] == 3){
						$id3 = (int)$recRe["menu_id"];
						if($id3 == $recMenu["menu_id"]){
							$arrMenu3[$id][$id1][$id2][$id3]["add"] = $recMenu["user_add"];
							$arrMenu3[$id][$id1][$id2][$id3]["edit"] = $recMenu["user_edit"];
							$arrMenu3[$id][$id1][$id2][$id3]["delete"] = $recMenu["user_delete"];
						}
						$arrMenu2[$id][$id1][$id2] = $arrMenu3[$id][$id1][$id2];
						$arrMenu1[$id][$id1] = $arrMenu2[$id][$id1];
						$arrMenu[$id] = $arrMenu1[$id];
					}elseif($recRe["menu_level"] == 4){
						$id4 = (int)$recRe["menu_id"];
						if($id4 == $recMenu["menu_id"]){
							$arrMenu4[$id][$id1][$id2][$id3][$id4]["add"] = $recMenu["user_add"];
							$arrMenu4[$id][$id1][$id2][$id3][$id4]["edit"] = $recMenu["user_edit"];
							$arrMenu4[$id][$id1][$id2][$id3][$id4]["delete"] = $recMenu["user_delete"];
						}
						$arrMenu3[$id][$id1][$id2][$id3] = $arrMenu4[$id][$id1][$id2][$id3];
						$arrMenu2[$id][$id1][$id2] = $arrMenu3[$id][$id1][$id2];
						$arrMenu1[$id][$id1] = $arrMenu2[$id][$id1];
						$arrMenu[$id] = $arrMenu1[$id];
					}
				}
			}
			$_SESSION["sys_group_menu"] = $arrMenu;
			//$_SESSION["sys_id"] = '1';
		    //header("location:main.php");
			echo "<script>
				self.location.href='main.php';
			</script>";
		}else{
			session_destroy();
			echo "<script>
				alert(\"ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง\");
				self.location.href='index.php';
			</script>";
		}
	}else{
		session_destroy();
		echo "<script>
			alert(\"ชื่อผู้ใช้ หรือ รหัสผ่าน ไม่ถูกต้อง\");
			self.location.href='index.php';
		</script>";
	}
}catch(Exception $e){
	session_destroy();
	echo "<script>
			alert(\"เกิดข้อผิดพลาด ไม่สามารถเข้าใช้งานระบบได้\");
			self.location.href='index.php';
		</script>";
	//$text=$e->getMessage();
}
?>