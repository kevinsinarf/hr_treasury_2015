<?php
@session_start();
if($_SESSION["sys_user_test"]=='1'){
	include($path."include/config_test.php");
}else{
	include($path."include/config.php");
}
include($path.'include/include.php');
include($path.'include/config_web.php');
include($path.'include/func.php');
include($path.'include/paging.php');

if($_GET){
	foreach($_GET as $key => $param){
		$arrParam = @explode("&",url2param($key));
		if($arrParam){
			foreach($arrParam as $index => $var){
				$arrVar = explode("=",$var);
				${$arrVar[0]} = $arrVar[1];
			}	
		}
	}
}

if($_POST || $_GET){
	foreach($_POST as $key => $value){
		${$key} = $value;
	}
	foreach($_GET as $key => $value){
		${$key} = $value;
	}
}
/*session*/
if($NoChk!=1){//fix $NoChk=1 ไม่เช็ค
	if($_SESSION['sys_id'] == ""){//กรณี session หลุดหรือเข้าทาง path
		echo "<script>alert('คุณไม่ได้ล็อคอิน กรุณา เข้าสู่ระบบใหม่  (Please Login Before)');window.location='".$serv_index."';</script>";
	}else{ 
		//echo count($_POST)."=".count($_GET);exit;
		if($menu_id == ""){//กรณี enter ทาง link หรือ $menu_id หาย ไปหน้าแรก
			if(count($_POST) == 0 && count($_GET) == 0 && $eform!=1){//กรณี enter ทาง link หรือ $menu_id หาย ไปหน้าแรก
				echo "<script>window.location='".$serv_index."';</script>";
			}
		}
	}
}
/*session*/

/*เก็บ LOG หน้า process*/
if($path=='../../../' && ($proc=='add' || $proc=='edit' || $proc=='del')){
	log_aut($proc,$_SESSION['sys_id'],$menu_sub_id,$USER_BY,$TIMESTAMP);
}

//สิด menu
$sqlAccess = "with recursive_menber as (
	select menu_id , menu_parent_id , menu_group , menu_level from aut_menu_setting where menu_id = '".$menu_sub_id."' and active_status='1'
	
	union all
	
	select a.menu_id , a.menu_parent_id , a.menu_group , a.menu_level  from aut_menu_setting a
	join recursive_menber b on b.menu_parent_id = a.menu_id
)
select * from recursive_menber order by menu_group asc , menu_level asc ";
$queryAccess = $db->query($sqlAccess);
while($recA = $db->db_fetch_array($queryAccess)){
	$recA = array_change_key_case($recA,CASE_LOWER);
	${"menu_lv".$recA["menu_level"]} = $recA["menu_id"];
	$stack = $recA["menu_level"];
}
switch($stack){
	case 0 : $arrAccess = $_SESSION["sys_group_menu"][$menu_lv0]; break;
	case 1 : $arrAccess = $_SESSION["sys_group_menu"][$menu_lv0][$menu_lv1]; break;
	case 2 : $arrAccess = $_SESSION["sys_group_menu"][$menu_lv0][$menu_lv1][$menu_lv2]; break;
	case 3 : $arrAccess = $_SESSION["sys_group_menu"][$menu_lv0][$menu_lv1][$menu_lv2][$menu_lv3]; break;
	case 4 : $arrAccess = $_SESSION["sys_group_menu"][$menu_lv0][$menu_lv1][$menu_lv2][$menu_lv3][$menu_lv4]; break;
}
?>