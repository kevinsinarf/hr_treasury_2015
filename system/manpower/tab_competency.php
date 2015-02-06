<?php 
	//active
	${'tab'.$ACT}="active";
	$link="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
?>
<ul class="nav nav-tabs visible-md visible-lg" >
	<!--===== ACT 1 =====-->
	<li class=" <?php echo $tab1;?>"><a href="competency_main_disp.php?<?php echo url2code($link."&ACT=1");?>">ตั้งค่าสมรรถนะหลัก</a></li>
    <!--===== ACT 2 =====-->
    	<li class="<?php echo $tab2;?>"><a href="competency_line_disp.php?<?php echo url2code($link."&ACT=2");?>">ตั้งค่าสมรรถนะในสายงาน </a></li>
    <!--===== ACT 3 =====-->
    <li class="<?php echo $tab3;?>"><a href="competency_management_disp.php?<?php echo url2code($link."&ACT=3");?>">ตั้งค่าสมรรถนะในการบริหาร </a></li>

</ul> 

