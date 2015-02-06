<?php 
//active
${'tab'.$ACT}="active";
$link="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&proc=".$proc."&PER_ID=".$PER_ID;
// ------------- วินัย ------------------
/*$sql_num_role = "SELECT PENALTY_ID FROM PENALTY_PETITION_FORM WHERE (case when PENALTY_STATUS = '2' then BOARD_TRANSFER_STATUS when PENALTY_STATUS = '3' then PAUSE_TRANSFER_STATUS when PENALTY_STATUS = '4' then RESIGN_TRANSFER_STATUS 
		 		 when PENALTY_STATUS = '5' then RESULT_TRANSFER_STATUS when PENALTY_STATUS = '6' then FINAL_TRANSFER_STATUS when PENALTY_STATUS = '7' then REPORT_TRANSFER_STATUS 
		 		 when PENALTY_STATUS = '8' then END_TRANSFER_STATUS when PENALTY_STATUS = '9' then CANCEL_TRANSFER_STATUS end) = '0' AND PENALTY_STATUS > 1";
$query_num_role = $db->query($sql_num_role);
$num_role = $db->db_num_rows($query_num_role);


$sql_num_bonus = "SELECT * FROM BONUS_COMMAND WHERE (TRANSFER_STATUS = 0 OR TRANSFER_STATUS IS NULL)";
$query_num_bonus = $db->query($sql_num_bonus);
$sql_num_app = "SELECT A.ROTCOM_ID, A.ROTCOM_NO, A.ROTCOM_DATE, A.ROTCOM_TITLE, A.ROTCOM_SDATE  FROM ROTATE_COMMAND A 
INNER JOIN ROTATE_DESC B ON A.ROTCOM_ID = B.ROTCOM_ID 
WHERE  A.DELETE_FLAG = 0 AND (A.TRANSFER_STATUS = 0 OR A.TRANSFER_STATUS IS NULL)
GROUP BY A.ROTCOM_ID, A.ROTCOM_NO, A.ROTCOM_DATE, A.ROTCOM_TITLE, A.ROTCOM_SDATE   ";
$query_num_app =  $db->query($sql_num_app);*/

//เลื่อนขั้นเงินเดือน
$sql_num_salary = "SELECT SAL_COM_ID FROM SAL_COMMAND WHERE DELETE_FLAG = 0 AND (TRANSFER_STATUS = 0 OR TRANSFER_STATUS IS NULL) ";

$query_num_salary =  $db->query($sql_num_salary);

/*$sql_num_retire="SELECT * FROM RETIRE_COMMAND WHERE DELETE_FLAG = 0 AND (TRANSFER_STATUS = 0 OR TRANSFER_STATUS IS NULL)    ";
$query_num_retire= $db->query($sql_num_retire);
$sql_num_slip="SELECT * FROM POSITION_COMMAND WHERE DELETE_FLAG = 0 AND (TRANSFER_STATUS = 0 or TRANSFER_STATUS IS NULL )";
$query_num_slip= $db->query($sql_num_slip);

$num_bonus = $db->db_num_rows($query_num_bonus);
$num_app = $db->db_num_rows($query_num_app);
$num_slip = $db->db_num_rows($query_num_slip);
$num_retire = $db->db_num_rows($query_num_retire);*/
$num_salary = $db->db_num_rows($query_num_salary);


//======================================
// ข้อมูลพัฒนาบุคลากร
//======================================
/*$num_dev=0;
$sql_dev="SELECT * FROM DEV_COURSE AS a INNER JOIN 
						DEV_GEN AS b ON a.COURSE_ID = b.COURSE_ID INNER JOIN 
						DEV_USER_REGIS AS c ON b.GEN_ID = c.GEN_ID INNER JOIN 
						DEV_PROJECT AS d ON d.PROJECT_ID = a.PROJECT_ID INNER JOIN
						PER_PROFILE AS e ON c.PER_ID = e.PER_ID
				WHERE 	c.TRANSFER_STATUS=0 ";
$exc_dev=$db->query($sql_dev);
$num_dev+=$db->db_num_rows($exc_dev);

$sql_dev="SELECT * FROM DEV_EX_EXCHANGE AS a INNER JOIN 
						DEV_EX_USER_REGIS AS b ON a.EXCHANGE_ID = b.EXCHANGE_ID INNER JOIN 
						DEV_PROJECT AS c ON a.PROJECT_ID = c.PROJECT_ID INNER JOIN
						PER_PROFILE AS e ON b.PER_ID = e.PER_ID
				WHERE 	b.TRANSFER_STATUS=0  ";
$exc_dev=$db->query($sql_dev);
$num_dev+=$db->db_num_rows($exc_dev);*/
//======================================

?>
<ul class="nav nav-tabs visible-md visible-lg" >

	<li class=" <?php echo $tab4;?>"><a href="profile_his_up_salary_disp.php?<?php echo url2code($link."&ACT=4");?>">ข้อมูลการเลื่อนขั้นเงินเดือน <span class="badge"><?php echo $num_salary; ?></span></a></li>
	<?php /*<!--===== ACT 1 =====-->
	<li class=" <?php echo $tab1;?>"><a href="profile_his_trans_rule_disp.php?<?php echo url2code($link."&ACT=1");?>">ข้อมูลงานวินัย <span class="badge"><?php echo $num_role; ?></span></a></li>
    <!--===== ACT 2 =====-->
	<li class=" <?php echo $tab2;?>"><a href="profile_his_bonus_disp.php?<?php echo url2code($link."&ACT=2");?>">ข้อมูลจัดสรรเงินรางวัลประจำปี <span class="badge"><?php echo $num_bonus; ?></span></a></li>
      <!--===== ACT 3 =====-->
	<li class=" <?php echo $tab3;?>"><a href="profile_his_appointment_disp.php?<?php echo url2code($link."&ACT=3");?>">ข้อมูลการย้ายตำแหน่ง <span class="badge"><?php echo $num_app; ?></span></a></li>

      <!--===== ACT 4 =====-->
	<li class=" <?php echo $tab4;?>"><a href="profile_his_up_salary_disp.php?<?php echo url2code($link."&ACT=4");?>">ข้อมูลการเลื่อนขั้นเงินเดือน <span class="badge"><?php echo $num_salary; ?></span></a></li>
      <!--===== ACT 5 =====-->
	<li class=" <?php echo $tab5;?>"><a href="profile_his_out_gov_disp.php?<?php echo url2code($link."&ACT=5");?>">ข้อมูลการออกจากราชการ <span class="badge"><?php echo $num_retire; ?></span></a></li>
     <!--===== ACT 6 =====-->
	<li class=" <?php echo $tab6;?>"><a href="profile_his_slip_position_disp.php?<?php echo url2code($link."&ACT=6");?>">ข้อมูลการเลื่อนตำแหน่ง <span class="badge"><?php echo $num_slip; ?></span></a></li>
    <!--===== ACT 7 =====-->
    <li class=" <?php echo $tab7;?>"><a href="profile_dev_general_approve.php?<?php echo url2code($link."&ACT=7");?>">ข้อมูลพัฒนาบุคลากร <span class="badge"><?php echo $num_dev; ?></span></a></li>
	*/ ?>
</ul> 