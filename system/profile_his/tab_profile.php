<?php 
	//active
	${'tab'.$ACT}="active";
	$link="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&proc=".$proc."&PER_ID=".$PER_ID;
?>
<ul class="nav nav-tabs visible-md visible-lg" >
	<!--===== ACT 1 =====-->
	<li class=" <?php echo $tab1;?>"><a href="profile_his_form.php?<?php echo url2code($link."&ACT=1");?>">ข้อมูลหลัก</a></li>
    <!--===== ACT 2 =====-->
	<li class="dropdown <?php echo $tab2;?>">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">ประวัติส่วนบุคคล <span class="caret"></span></a>
		<ul class="dropdown-menu">
            <li><a href="profile_namehis.php?<?php echo url2code($link."&ACT=2");?>">ประวัติการเปลี่ยนชื่อตัว - ชื่อสกุล</a></li>
			<li><a href="profile_address.php?<?php echo url2code($link."&ACT=2");?>">ประวัติที่อยู่</a></li>
            <li><a href="profile_educatehis_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติการศึกษา</a></li>
            <?php /*
            <li><a href="profile_activity_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติการทำกิจกรรมในสถานศึกษา</a></li>
            <li><a href="profile_jobhis_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติประสบการณ์การทำงาน</a></li>
            <li><a href="profile_healthhis_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติการตรวจสุขภาพ</a></li>
			*/ ?>
            <li><a href="professional_licensing.php?<?php echo url2code($link."&ACT=2");?>" >ประวัติการได้รับใบอนุญาติประกอบวิชาชีพ</a></li>
            <li><a href="profile_contact_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติบุคคลในครอบครัว</a></li>
            <?php /*
            <li><a href="profile_language_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติทักษะทางภาษา</a></li>
        	<li><a href="profile_ability_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติความสามารถพิเศษ</a></li>
			*/ ?>
            <li><a href="profile_heirhis_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติของผู้ถูกแสดงเจตนาให้รับบำเหน็จตกทอด</a></li>
            <li><a href="profile_receive_death_disp.php?<?php echo url2code($link."&ACT=2")?>">ประวัติของผู้ถูกแสดงเจตนารับเงินช่วยพิเศษกรณีถึงแก่ความตาย</a></li>
	
            <li><a href="profile_picture.php?<?php echo url2code($link."&ACT=2");?>">ประวัติภาพถ่าย</a></li>
            
            <!--<li><a href="profile_child_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติบุตร</a></li>-->
            <!--<li><a href="profile_marryhis_disp.php?<?php echo url2code($link."&ACT=2");?>">ประวัติการสมรส</a></li>-->
		</ul> 
	</li> 
    <!--===== ACT 3 =====-->
	<li class="dropdown <?php echo $tab3;?>">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">ประวัติการรับราชการ <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="profile_positionhis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการดำรงตำแหน่ง</a></li>
            <li><a href="profile_upsalary.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการเลื่อนเงินเดือน</a></li>
            <?php if($POSTYPE_ID!=3){?>
            <li><a href="profile_bonus.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการได้รับเงินรางวัลประจำปี</a></li>
            <?php }?>
			<li><a href="profile_punishment_disp.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการรับโทษทางวินัย</a></li>
        	<?php /*<li><a href="profile_latehis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการปฏิบัติราชการ</a></li> */ ?>
			<?php /*?><li><a href="profile_servicehis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการปฏิบัติราชการพิเศษ</a></li><?php */?>
			<li><a href="profile_rewardhis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการได้รับความดีความชอบ</a></li>
			<li><a href="profile_multitime.php?<?php echo url2code($link."&ACT=3");?>">ประวัติปฏิบัติราชการเวลาทวีคูณ</a></li>
            
        	<!--<li><a href="profile_absenthis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการลาปฏิบัติราชการ</a></li>-->
			<?php /*<li><a href="profile_probation.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการทดลองราชการ</a></li> */ ?>
			<!--<li><a href="profile_typechange.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการเปลี่ยนสถานะบุคลากร</a></li>-->
            <!--<li><a href="profile_latehis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการปฏิบัติราชการสาย</a></li>-->
            <li><a href="profile_decoratehis.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการรับพระราชทานเครื่องราชอิสริยาภรณ์</a></li>
            <li><a href="profile_absent.php?<?php echo url2code($link."&ACT=3");?>">ประวัติการลา</a></li>
		</ul>
	</li>
    <!--===== ACT 4 =====-->
    <?php /*
	<li class="dropdown <?php echo $tab4;?>">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">ประวัติการรับสวัสดิการ <span class="caret"></span></a>
		<ul class="dropdown-menu">
        	<li><a href="profile_child_scholar.php?<?php echo url2code($link."&ACT=4");?>">ประวัติการรับทุนการศึกษาบุตร</a></li>
			<li><a href="profile_pension.php?<?php echo url2code($link."&ACT=4");?>">ประวัติการขอรับบำเหน็จบำนาญ</a></li>
            <!--<li><a href="profile_salaryhis.php?<?php echo url2code($link."&ACT=4");?>">ประวัติการรับเงินเดือน</a></li>-->
			<!--<li><a href="profile_travelhis.php?<?php echo url2code($link."&ACT=4");?>">ประวัติการเดินทางไปต่างประเทศ</a></li>-->
		</ul>
	</li>
	*/ ?>
    <!--===== ACT 5 =====-->
	<li class="dropdown <?php echo $tab5;?>">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">ประวัติการพัฒนาบุคคล <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="profile_dev.php?<?php echo url2code($link."&ACT=5");?>">ประวัติการฝึกอบรม/สัมมนา/ศึกษาดูงาน</a></li>
			<?php /*<li><a href="profile_scholar.php?<?php echo url2code($link."&ACT=5");?>">ประวัติการรับทุนการศึกษา</a></li>
			<li><a href="profile_com.php?<?php echo url2code($link."&ACT=5");?>">ประวัติการประเมินสมรรถนะ</a></li>
			<li><a href="profile_dev_general.php?<?php echo url2code($link."&ACT=5");?>">ประวัติการฝึกอบรม/สัมมนา/ศึกษาดูงาน (สำนักพัฒนาบุคคลกร)</a></li> */ ?>
		</ul>
	</li>
    <!--===== ACT 6 =====-->
    <?php /*
	<li class="dropdown <?php echo $tab6;?>">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">ประวัติอื่นๆ <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<li><a href="profile_missalhis_disp.php?<?php echo url2code($link."&ACT=6");?>">ประวัติการไม่ได้รับเงินเดือน</a></li>
			<li><a href="per_doc_disp.php?<?php echo url2code($link."&ACT=6");?>">ประวัติการขอรับหนังสือรับรอง</a></li>
			<li><a href="per_card_disp.php?<?php echo url2code($link."&ACT=6");?>">ประวัติการขอจัดทำบัตร</a></li>
		</ul>
	</li>
	*/ ?>
</ul> 

