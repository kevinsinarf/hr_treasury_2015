<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$sqlEdit = "select * from aut_group_menu where user_group_id = '".$user_group_id."' ";
$queryEdit = $db->query($sqlEdit);
while($recEdit = $db->db_fetch_array($queryEdit)){
	$recEdit = array_change_key_case($recEdit,CASE_LOWER);
	$arrChk[$recEdit["menu_id"]]["add"] = $recEdit["user_add"];
	$arrChk[$recEdit["menu_id"]]["edit"] = $recEdit["user_edit"];
	$arrChk[$recEdit["menu_id"]]["delete"] = $recEdit["user_delete"];
       
}

$sqlMenuList = "
	with recursive_member as (
		select menu_id , menu_desc , menu_url , menu_img , menu_parent_id , menu_level , menu_group , menu_order from aut_menu_setting where menu_level = '0' 
	
		union all
	
		select a.menu_id , a.menu_desc , a.menu_url , a.menu_img , a.menu_parent_id , a.menu_level , a.menu_group , a.menu_order from aut_menu_setting a inner join recursive_member b on a.menu_parent_id = b.menu_id
	)
	select * from recursive_member order by menu_order, menu_level asc
";
$queryMeu = $db->query($sqlMenuList);
while($recMenu = $db->db_fetch_array($queryMeu)){
	$recMenu = array_change_key_case($recMenu,CASE_LOWER);
	if($recMenu["menu_parent_id"] != ""){
		if($recMenu["menu_level"] == 1){
			$menu1[$recMenu["menu_parent_id"]][] = array("menu_id"=>$recMenu["menu_id"],"desc"=>text($recMenu["menu_desc"]),"url"=>$recMenu["menu_url"]);
		}elseif($recMenu["menu_level"] == 2){
			$menu2[$recMenu["menu_parent_id"]][] = array("menu_id"=>$recMenu["menu_id"],"desc"=>text($recMenu["menu_desc"]),"url"=>$recMenu["menu_url"]);
		}elseif($recMenu["menu_level"] == 3){
			$menu3[$recMenu["menu_parent_id"]][] = array("menu_id"=>$recMenu["menu_id"],"desc"=>text($recMenu["menu_desc"]),"url"=>$recMenu["menu_url"]);
		}elseif($recMenu["menu_level"] == 4){
			$menu4[$recMenu["menu_parent_id"]][] = array("menu_id"=>$recMenu["menu_id"],"desc"=>text($recMenu["menu_desc"]),"url"=>$recMenu["menu_url"]);
		}
	}else{		
		$menu0[] = array("menu_id"=>$recMenu["menu_id"],"desc"=>text($recMenu["menu_desc"]),"url"=>$recMenu["menu_url"]);
	}
}
	
foreach($menu0 as $key => $val){
	$arrData[$key] = array("title"=>$val["desc"],"key"=>"c_id".$val["menu_id"],"icon"=>false);
	if(count($menu1[$val["menu_id"]]) > 0){
		$a=0;
		foreach($menu1[$val["menu_id"]] as $key1 => $val1){
			$arr1[$key][$a] = array("title"=>$val1["desc"],"key"=>"c_id".$val["menu_id"].".".$val1["menu_id"],"icon"=>false,);
			if(count($menu2[$val1["menu_id"]]) > 0){
				$b=0;
				unset($arr2);
				foreach($menu2[$val1["menu_id"]] as $key2 => $val2){
					$arr2[$key1][$b] = array("title"=>$val2["desc"],"key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"],"icon"=>false,);
					if(count($menu3[$val2["menu_id"]]) > 0){
						$c=0;
						unset($arr3);
						foreach($menu3[$val2["menu_id"]] as $key3 => $val3){
							$arr3[$key2][$c] = array("title"=>$val3["desc"],"key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"],"icon"=>false,);
							if(count($menu4[$val3["menu_id"]]) > 0){
								$d=0;
								unset($arr4);
								foreach($menu4[$val3["menu_id"]] as $key4 => $val4){
									$arr4[$key3][$d] = array(
										"title"=>$val4["desc"],
										"key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".".$val4["menu_id"],
										"icon"=>false,
										"children" => array(
											array("title"=>"เพิ่มข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".".$val4["menu_id"].".add","icon"=>false,"select"=>($arrChk[$val4["menu_id"]]["add"] == 1) ? true:false),
											array("title"=>"แก้ไขข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".".$val4["menu_id"].".edit","icon"=>false,"select"=>($arrChk[$val4["menu_id"]]["edit"] == 1) ? true:false),
											array("title"=>"ลบข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".".$val4["menu_id"].".delete","icon"=>false,"select"=>($arrChk[$val4["menu_id"]]["delete"] == 1) ? true:false),
										)
									);
									$arr3[$key2][$c]["children"] = $arr4[$key3];
									$d++;
								}
							}else{
								$arr3[$key2][$c]["children"] = array(
									array("title"=>"เพิ่มข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".add","icon"=>false,"select"=>($arrChk[$val3["menu_id"]]["add"] == 1) ? true:false),
									array("title"=>"แก้ไขข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".edit","icon"=>false,"select"=>($arrChk[$val3["menu_id"]]["edit"] == 1) ? true:false),
									array("title"=>"ลบข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".".$val3["menu_id"].".delete","icon"=>false,"select"=>($arrChk[$val3["menu_id"]]["edit"] == 1) ? true:false),
								);
								$arr2[$key1][$b]["children"] = $arr3[$key2];
							}
							$arr2[$key1][$b]["children"] = $arr3[$key2];
							$c++;
						}
					}else{
						$arr2[$key1][$b]["children"] = array(
							array("title"=>"เพิ่มข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".add","icon"=>false,"select"=>($arrChk[$val2["menu_id"]]["add"] == 1) ? true:false),
							array("title"=>"แก้ไขข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".edit","icon"=>false,"select"=>($arrChk[$val2["menu_id"]]["edit"] == 1) ? true:false),
							array("title"=>"ลบข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".".$val2["menu_id"].".delete","icon"=>false,"select"=>($arrChk[$val2["menu_id"]]["delete"] == 1) ? true:false),							
						);
						$arr1[$key][$a]["children"] = $arr2[$key1];
					}
					$arr1[$key][$a]["children"] = $arr2[$key1];
					$b++;
				}
			}else{
				$arr1[$key][$a]["children"] = array(
					array("title"=>"เพิ่มข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".add","icon"=>false,"select"=>($arrChk[$val1["menu_id"]]["add"] == 1) ? true:false),
					array("title"=>"แก้ไขข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".edit","icon"=>false,"select"=>($arrChk[$val1["menu_id"]]["edit"] == 1) ? true:false),
					array("title"=>"ลบข้อมูล","key"=>"c_id".$val["menu_id"].".".$val1["menu_id"].".delete","icon"=>false,"select"=>($arrChk[$val1["menu_id"]]["delete"] == 1) ? true:false),
				);
				$arrData[$key]["children"] = $arr1[$key];
			}
			$arrData[$key]["children"] = $arr1[$key];
			$a++;
		}
	}		
}
$treeData = json_encode($arrData);
//โชว์ชื่อกลุ่มสิทธิ์การใช้งาน
$txt_menu = $db->get_data_field("SELECT GROUP_NAME FROM AUT_GROUP WHERE USER_GROUP_ID = '".$user_group_id."'","GROUP_NAME");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<link href="<?php echo $path; ?>lib/dynatree/src/skin/ui.dynatree.css" rel="stylesheet">	
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>lib/jquery-ui/jquery-ui-1.10.0.custom.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>lib/dynatree/dist/jquery.dynatree.min.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/disp_menu_group.js?<?php echo rand(); ?>"></script>
<script>
	$(document).ready(function(){
		test_tree(<?php echo $treeData; ?>);
	});
</script>
</head>
<body <?php echo $remove;?>>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div style="height:45em;">
		<div class="col-xs-12 col-sm-12">
			<ol class="breadcrumb">
			  <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			  <li><a href="disp_group.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>">กลุ่มสิทธิการใช้งาน </a></li>
			  <li class="active">เมนูกลุ่มสิทธิ์การใช้งาน (<?php echo text($txt_menu);?>)</li>
			</ol>
		</div>
		<div id="content"  class="col-xs-12 col-sm-12">
			<div  class="groupdata" >
				<form id="frm-search" method="post" action="process/process_group.php">
					<input name="proc" type="hidden" id="proc" value="user_group">
					<input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
					<input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
					<input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
					<input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
					<input name="user_group_id" type="hidden" id="user_group_id" value="<?php echo $user_group_id; ?>">
					<div class="col-xs-12 col-sm-12">
						<div id="menu_tree"></div>
					</div>
					<div id="allHidden"></div>
					<div class="clearfix"></div><br>
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="submit" class="btn btn-primary">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='disp_group.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id); ?>';">ยกเลิก</button>
					</div>
					<div class="clearfix"></div><br>
				</form>
			</div>
		</div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>