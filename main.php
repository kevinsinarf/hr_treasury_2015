<?php
$path = "";
$menu_id="0";
include($path."include/config_header_top.php");

if($_SESSION["sys_group_menu"]){
	foreach($_SESSION["sys_group_menu"] as $key0 => $arrVal0){
		$menu0_list .= $key0.",";
	}
	$menu0_list = substr($menu0_list,0,-1);
}else{
	$menu0_list = 0;
}

$sqlMenu0 = "select * from aut_menu_setting where menu_level = '0' and menu_id in ($menu0_list) order by menu_order asc ";
$queryMenu0 = $db->query($sqlMenu0);
while($recMenu0 = $db->db_fetch_array($queryMenu0)){
	$recMenu0 = array_change_key_case($recMenu0,CASE_LOWER);
	$dataMenu0[] = array(
		"menu_id"=>$recMenu0["menu_id"],
		"desc"=>text($recMenu0["menu_desc"]),
		"order"=>text($recMenu0["menu_order"])
	);
}

$sql = " select * from aut_menu_setting where menu_level = '1' order by menu_order asc ";
$query = $db->query($sql);
while($rec = $db->db_fetch_array($query)){
	$rec = array_change_key_case($rec);
	$dataMenu[$rec["menu_parent_id"]][$rec["menu_id"]] = array("menu_id"=>$rec["menu_id"],"desc"=>text($rec["menu_desc"]),"url"=>text($rec["menu_url"]),"img"=>text($rec["menu_img"]));
}

$link = "r=home";  /// for mobile
$paramlink = url2code($link);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div><br>
    <div id="content" class="col-xs-12 col-sm-12">
	<?php
		if($dataMenu0){
			foreach($dataMenu0 as $key => $arrVal){
				//danger
				//info
				//primary
					//warning
					//default
				//success
				if($arrVal['order']==1){
					$panel_color="primary";
				}elseif($arrVal['order']==2){
					$panel_color="info";
				}elseif($arrVal['order']==3){
					$panel_color="success";
				}elseif($arrVal['order']==4){
					$panel_color="warning";
				}elseif($arrVal['order']==5){
					$panel_color="danger";
				}
			?>
			<div class="panel panel-<?php echo $panel_color;?>">
				<!--<div class="panel-heading" align="center" style="background:url(<?php echo $path; ?>images/bar_01.jpg)"><h3 class="panel-title"><span style="position:relative; top:-10px; z-index:5; color:#FFF;"><?php echo $arrVal["desc"]?></span></h3></div>-->
				<div class="panel-heading" align="center">
					<h3 class="panel-title"><span style="position:relative; top:-10px; z-index:5; color:#FFF;"><?php echo $arrVal["desc"]?></span></h3>
				</div>
				<div align="center" style="position:relative; top:-47px;"><img src="<?php echo $path; ?>images/brand_01.gif"></div>
				<div class="panel-body">
					<?php  
						$i = 1;
						$m = 1;
						$w = 1; 
						foreach($dataMenu[$arrVal["menu_id"]] as $key1 => $val){
							if(array_key_exists($key1,$_SESSION["sys_group_menu"][$arrVal["menu_id"]])){
								$i = $m = ($m > 2) ? "1":$m;
								$i = $w = ($w > 5) ? "1":$w;
							
								$offset = ($i == 1) ? "col-sm-offset-1":"";
								$spaceM = ($m == 2) ? "<div class=\"visible-xs\"><div class=\"clearfix\"></div><br></div>":"";
								$spaceW = ($w == 5) ? "<div class=\"hidden-xs\"><div class=\"clearfix\"></div><br></div>":"";
								$url = ($val["url"] == "") ? "javascript:void(0);":$val["url"]."?".url2code($link."&menu_id=".$val["menu_id"]);
								?>
								<div class="col-xs-6 col-sm-2 <?php echo $offset; ?>">
									<a href="<?php echo $url; ?>" class="thumbnail">
										<?php if(trim($val["img"]) != ""){?>
											<img src="<?php echo $val["img"];?>" width="64px" height="64px" class="img-responsive">
										<?php }else{?>
											<img data-src="holder.js/175x65" width="64px" height="64px" class="img-responsive">
										<?php }?>
									</a>
									<div class="caption" align="center"><h5><?php echo $val["desc"]; ?></h5></div>
								</div>
								<?php 
								echo $spaceM;
								echo $spaceW;
								$m++;
								$w++;
							}
						} 
					?>
				</div>
			</div>
			<div class="clearfix"></div><br>
			<?php 
			}
		}
	?>
    </div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>