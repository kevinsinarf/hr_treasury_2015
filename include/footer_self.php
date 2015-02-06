<?php
	if($_SESSION['sys_ss_id']){
		$footer="footer_ss";
	}elseif($_SESSION['sys_sp_id']){
		$footer="footer_sp";
	}else{
		$footer="footer_per";
	}
?>
<div id="<?php echo $footer;?>" class="row">
	<div class="col-xs-12 col-md-8 col-md-offset-2">
		สงวนลิขสิทธิสำนักงานเลขาธิการสภาผู้แทนราษฎร ถนนอู่ทองใน เขตดุสิต กรุงเทพฯ 10300<br>
		โทร 0 2244 1060, 0 2244 1324, 0 2357 3115&nbsp;&nbsp;e-Mail : hris@parliament.go.th
	</div>
	<div class="col-xs-12 col-md-2 visible-md visible-lg text-right">
		<a href="#" style="color:#000"><span class="glyphicon glyphicon-circle-arrow-up"></span> Back to top</a><br />
		<span style="color:#F00; font-weight:bold">Page&nbsp;Code&nbsp;:&nbsp;<?php echo ($menu_sub_id!=""?$menu_sub_id:($menu_id!=''?$menu_id:'0'));?></span>
	</div>
</div>