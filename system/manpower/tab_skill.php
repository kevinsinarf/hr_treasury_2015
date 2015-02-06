<?php 
	//active
	${'tab'.$ACT}="active";
	$link="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
	//$link="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&proc=".$proc."&PER_ID=".$PER_ID;
	
?>
	

<ul class="nav nav-tabs visible-md visible-lg" >

	<!--===== ACT 1 =====-->
	<li class="<?php echo $tab1;?>">
		<a href="skill_title_disp.php?<?php echo url2code($link."&ACT=1");?>">ทักษะจำเป็นในงาน</a>
		 
	</li>

    <!--===== ACT 2 =====-->
    <li class="<?php echo $tab2;?>">
		<a href="knowledge_title_disp.php?<?php echo url2code($link."&ACT=2");?>">ความรู้จำเป็นในงาน</a>
	</li>
    
	
</ul> 

