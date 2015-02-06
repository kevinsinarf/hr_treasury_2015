<?php
$path = "../../";
include($path."include/config_header_top.php");
if($_SESSION['sys_self']=='1'){//self_service
	include($path."include/config_show_alert_self.php");//ข้อความแจ้งเตือน
}else{//เจ้าหน้าที่
	include($path."include/config_show_alert.php");//ข้อความแจ้งเตือน
}
ini_set("max_execution_time" , 160);
$page = $_REQUEST['page'];
//print_r($_SESSION);

if($_SESSION["sys_group_menu"]!=''){
	foreach($_SESSION["sys_group_menu"] as $key0 => $arrVal0){
		if($key0){
			$menu0_list .= $key0.",";
		}
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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo ($menu_id!='0')?$path:""; ?>bootstrap/css/chosen.css" rel="stylesheet">
<script src="<?php echo ($menu_id!='0')?$path:""; ?>bootstrap/js/chosen.jquery.js"></script>
<script type="text/javascript"  >
	function searchpopup(){ 
		var file="alert_popup.php";
		if('<?php echo $menu_id;?>'!='0'){
			var url ='../../system/all/'+file;
		}else{
			var url ='system/all/'+file;
		}
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {span:'show_alert',s_file:file,page:'1',menu_id:'<?php echo $menu_id;?>',P_MENU_ID:$('#P_MENU_ID').val(),TYPE:'<?php echo $TYPE;?>'},
			async: false,
			success: function(data) {
				$("#show_alert").html(data);
				$(".selectbox").chosen();
			} 
		});
	}
</script>
</head>
<body>
<?php if($_SESSION['sys_self']!='1'){?>
<div class="row">
	<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระบบหลัก :</div>
	<div class="col-xs-12 col-sm-8" style="white-space:nowrap;">
		<select id="P_MENU_ID" name="P_MENU_ID" class="selectbox form-control" placeholder="ทั้งหมด" >
		<option value=""></option>
		<?php
			if($dataMenu0){
				foreach($dataMenu0 as $key0 => $val0){
					?>
					<optgroup label="<?php echo $val0['desc'];?>">
						<?php
						$sql_pro_type = "SELECT a.MENU_ID,a.MENU_DESC, a.MENU_GROUP 
						FROM AUT_MENU_SETTING a
						WHERE a.MENU_LEVEL in (1) and a.MENU_GROUP not in (4) and a.MENU_PARENT_ID='".$val0['menu_id']."' AND ACTIVE_STATUS='1'
						and MENU_ID in (select b.MENU_PARENT_ID from AUT_GROUP_MENU a join AUT_MENU_SETTING b on a.MENU_ID=b.MENU_ID and b.MENU_LEVEL='2' where USER_GROUP_ID='".$_SESSION['sys_group_id']."')
						order by (case a.MENU_GROUP when '5' then '2' when '2' then '3' when '3' then '4' else a.MENU_GROUP end) , a.MENU_LEVEL, a.MENU_ORDER asc   ";
						$query_pro_type = $db->query($sql_pro_type);
						$group="";
						while($rs_pro_type = $db->db_fetch_array($query_pro_type)){
							?><option value="<?php echo $rs_pro_type['MENU_ID'];?>" <?php echo ($rs_pro_type['MENU_ID']==$P_MENU_ID?"selected":"");?>><?php echo text($rs_pro_type['MENU_DESC']);?></option><?php 
						}
						?>
					</optgroup>
				<?php 
				}
			}
		?>
		</select>
	</div>
	<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">
	<button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>
	</div>
</div>
<?php }?>
<div class="row" >
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr class="info">
					<th width="5%"><div align="center"><small>ลำดับ</small></div></th>
					<?php if($_SESSION['sys_self']!='1'){?><th width="35%"><div align="center"><small>ระบบหลัก</small></div></th><?php }?> 
					<th width="45%"><div align="center"><small>เรื่อง</small></div></th>
					<th width="10%"><div align="center"><small>จำนวนรายการ</small></div></th>
				</tr>
			</thead>
			<tbody id="tb-load" >
			<?php
			/*echo "<pre>";
			print_r($res_pop);
			echo "</pre>";*/
			
			
			if(count($res_pop)>0){
				foreach($res_pop as $key => $val){
					if($val['count']>0){//จำนวนมากกว่า 0
						if(($P_MENU_ID=='') || ($P_MENU_ID!='' && $P_MENU_ID==$val['menu_id'])){//ค้นหา
							$res_pop2[$key]=$val;
						}
					}
				}
			}
			
			$i=1;
			if(count($res_pop2)>0){
				$aList  = array_chunk($res_pop2, 10);
				list($pagination,$exc,$total_pages)=$db->pageTable2($aList, $res_pop2, $page, "page", "&P_MENU_ID=".$P_MENU_ID."&menu_id=".$menu_id,$s_file,$span,$TYPE);
				foreach($aList[$page-1] as $key => $val){
					if($_SESSION['sys_self']=='1'){//self_service
						$link=$val['link']."?".url2code("self=1".($val['cond']?'&'.$val['cond']:""));
					}else{
						$link=$val['link']."?".url2code("menu_id=".$val['menu_id']."&menu_sub_id=".$val['menu_sub_id'].($val['cond']?'&'.$val['cond']:""));
					} 
					?>
					<tr>
						<!--<td align="center"><small><?php echo $val['date'];?></small></td>-->
						<td align="center"><small><?php echo ((($page-1)*10)+$i);?></small></td>
						<?php if($_SESSION['sys_self']!='1'){?><td align="left"><small><?php echo Showmenu($val['menu_id']);?></small></td><?php }?>
						<td align="left"><small><?php echo $val['label'];?></small></td>
						<td align="center"><small><b><a href="<?php echo $link;?>"><?php echo $val['count'];?></a></b></small></td>
					</tr>
					<?php 
					$i++;
				}
			}else{
				echo "<tr><td align=\"center\" colspan=\"4\">".$arr_txt['data_not_found']."</td></tr>";
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<div><?php echo $pagination;?></div>
</body>
</html>
<?php $db->db_close();?>