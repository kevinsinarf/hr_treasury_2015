<?php
include($path."include/config_show_alert.php");//ข้อความแจ้งเตือน

//echo $menu_id."====".$menu_sub_id;

//data_per
$sql_per="select * from PER_PROFILE where PER_ID='".$_SESSION["sys_id"]."'";
$query_per = $db->query($sql_per);
$data_per = $db->db_fetch_array($query_per);

/*เก็บ LOG การใช้งานในแต่ละหน้า*/
log_aut('view', $_SESSION['sys_id'],$menu_sub_id,$USER_BY,$TIMESTAMP);

//sum จำนวนข้อความแจ้งเตือน
//print_r($result);exit;
$num_alert_all=0;
if($res_pop){
	foreach($res_pop as $key => $val){
		$num_alert_all+=$val['count'];
	}
}
$css_class = ($num_alert_all > 0) ? "badge_alert" : "badge";
?>
<div>
	<div class="hidden-xs" style="background:url(<?php echo $path; ?>images/top/bg-top.png); background-repeat:repeat-x;"><img src="<?php echo $path; ?>images/top/logo-top.png"></div>

	<div class="visible-xs" align="center">
		<div > </div>  
	</div>
</div>

<div class="col-sm-12 hidden-xs" style="position:absolute; right:0em; top:1em;margin-top:-5px">
	<div class="row"> 
		<div class="col-sm-4 col-sm-push-8" style="background-color:rgba(222,222,222,0.5); border:thin solid #cbc9c8; right:2em;  border-radius:10px;">
			<div align="left"> 
				<div class="col-sm-4" style="padding-top:2px;padding-bottom:2px;">
                <a href="#" class="thumbnail"><?php
				  if($data_per['PER_FILE_PIC']!=""){
					if (file_exists($path.'fileupload/profile_his/'.$data_per['PER_FILE_PIC'])) { // have file
					    echo "<img src=\"".$path.'fileupload/profile_his/'.$data_per['PER_FILE_PIC']."\" height=\"50\" width=\"50\">";
  					}else{ // 
					    echo "<img data-src=\"holder.js/100%x60\" class=\"img-responsive\">";
					}
				  }else{
					    echo "<img data-src=\"holder.js/100%x60\" class=\"img-responsive\">";
				  }
				
				
				 //echo (trim($data_per['PER_FILE_PIC'])==''?"<img data-src=\"holder.js/100%x60\" class=\"img-responsive\">":"<img src=\"".$path.'fileupload/profile_his/'.$data_per['PER_FILE_PIC']."\" height=\"50\" width=\"50\">");?></a></div> 
				<div class="col-sm-8 clearfix" style="padding-top:10px;"><small><strong>เลขที่ : </strong> <?php echo get_idCard($data_per['PER_IDCARD']); ?></small></div>
				<div class="col-sm-8 clearfix"><small><strong>ชื่อ : </strong> <?php echo $_SESSION['sys_name'].($_SESSION["sys_user_test"]=='1'?" <strong>(TEST)</strong>":"");?></small></div>
				<!--<div class="col-sm-8 clearfix">ประเภทตำแหน่ง <?php echo text($arr_pos_type[$data_per['TYPE_ID']]); ?></div>
				<div class="col-sm-8 clearfix">ระดับตำแหน่ง <?php echo text($arr_pos_level[$data_per['LEVEL_ID']]); ?></div>-->
				<div class="col-sm-4" align="left" style="white-space:nowrap;">
					<a href="#" data-toggle="modal" data-target="#myModal_alert" title="ข้อความแจ้งเตือน" onclick="FncLoad_Form('show_alert', 'alert_popup.php', 'page=1&menu_id=<?php echo $menu_id;?>','<?php echo ($menu_id=='0'?"head":"");?>');"><span class="splashy-mail_light_new_1" style="vertical-align:middle"></span>&nbsp;<span class="<?php echo $css_class;?>"><?php echo $num_alert_all;?></span></a>&nbsp;
					<!--<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2"><span class="splashy-information" style="vertical-align:middle"></span>&nbsp;<span class="badge">3</span></a>-->
				</div>
				<div class="col-sm-4 clearfix" align="right"><a href="<?php echo $path; ?>logout.php"><font color="#000000">ออกจากระบบ</font></a></div>
			</div> 
		</div>
	</div>
</div>

<nav class="navbar navbar-default navbar-fixed navbar-static visible-xs" role="navigation" style="background-color:#F5F5F5;">
  <div>
      <div class="navbar-header">
      	<a class="navbar-brand" data-toggle="collapse" data-target=".profile" href="javascript:void(0);" style="color:#000;"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['sys_name']?></a>
        <a class="navbar-brand pull-right" href="#" style="color:#000;"  data-toggle="modal" data-target="#myModal_alert" title="ข้อความแจ้งเตือน" onclick="FncLoad_Form('show_alert', 'alert_popup.php', 'page=1&menu_id=<?php echo $menu_id;?>','<?php echo ($menu_id=='0'?"head":"");?>');"><span class="splashy-mail_light_new_1" style="vertical-align:middle"></span>&nbsp;<span class="badge">7</span></a>
		<!--<a class="navbar-brand pull-right" href="javascript:void(0);" style="color:#000;"  data-toggle="modal" data-target="#myModal2"><span class="splashy-information" style="vertical-align:middle"></span>&nbsp;<span class="badge">3</span></a>-->
      </div>
      <div class="collapse navbar-collapse profile">
        <ul class="nav navbar-nav">
            <!--<li><a href="javascript:void(0);" style="color:#000;">ประวัติส่วนตัว</a></li>-->
            <li><a href="javascript:void(0);" style="color:#000;">เปลี่ยนรหัสผ่าน</a></li>
            <li><a href="<?php echo $path; ?>logout.php" style="color:#000;">ออกจากระบบ</a></li>
        </ul>
      </div>
  </div>
</nav>
<?php echo popup_model('myModal_alert','ข้อความแจ้งเตือน','show_alert');?>