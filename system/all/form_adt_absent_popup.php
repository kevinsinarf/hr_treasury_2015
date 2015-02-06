<?php
$path = "../../";
include($path."include/config_header_top.php");

$PER_ID = $_GET['PER_ID'];
$ATTENDANCE_ID = $_GET['ATTENDANCE_ID'];

$sql = "SELECT c.ABSENT_NAME_TH, ATTABSENT_NDATE, b.ATTABSENT_SDATE, b.ATTABSENT_EDATE, b.ATTABSENT_CDATE , b.ATTABSENT_STIME, b.ATTABSENT_ETIME, 
		b.ATTABSENT_TOTAL_DAY, b.ATTABSENT_TOTAL_HOUR, b.ATTABSENT_USED, ATTABSENT_NOTE
		FROM ATTENDANCE_ABSENT b JOIN SETUP_ABSENT c ON b.ABSENT_ID = c.ABSENT_ID 
		WHERE ATTENDANCE_ID = '".$ATTENDANCE_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$arr_attabsent_used = array(1=>"ใช้สิทธิ์การลา", 2=>"ยกเลิกการลา");
?>
<div class="row">
    <div class="col-xs-12 col-md-5">ประเภทการลา : </div>
    <div class="col-xs-12 col-md-7"><?php echo text($rec['ABSENT_NAME_TH']); ?></div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-5">วันที่แจ้งลา : </div>
	<div class="col-xs-12 col-md-7"><?php echo conv_date($rec['ATTABSENT_NDATE'],'short'); ?></div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-5">วันที่เริ่มต้น - สิ้นสุดการลา : </div>
	<div class="col-xs-12 col-md-7"><?php echo conv_date($rec['ATTABSENT_SDATE'],'short'); ?>&nbsp;-&nbsp;<?php echo conv_date($rec['ATTABSENT_EDATE'],'short'); ?></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-5">รวมจำนวนวัน : </div>
    <div class="col-xs-12 col-md-7"><?php echo $rec['ATTABSENT_TOTAL_DAY'];?>&nbsp;วัน</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-5">เวลาที่ลา : </div>
	<div class="col-xs-12 col-md-7"><?php echo text(substr($rec['ATTABSENT_STIME'],0,5)); ?>&nbsp;-&nbsp;<?php echo text(substr($rec['ATTABSENT_ETIME'],0,5));?></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-5">รวมจำนวนชั่วโมง : </div>
	<div class="col-xs-12 col-md-7"><?php echo $rec['ATTABSENT_TOTAL_HOUR'];?>&nbsp;ชั่วโมง</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-5">สถานะของการใช้สิทธิ์การลา : </div>
	<div class="col-xs-12 col-md-7"><?php echo $arr_attabsent_used[$rec['ATTABSENT_USED']];?></div>
</div>

<?php if($rec['ATTABSENT_USED'] == 2){ ?>
<div class="row">
	<div class="col-xs-12 col-md-5">วันที่ยกเลิกการลา : </div>
	<div class="col-xs-12 col-md-7"><?php echo conv_date($rec['ATTABSENT_CDATE'],'short');?></div>
</div>
<?php } ?>

<div class="row">
	<div class="col-xs-12 col-md-5">รายละเอียดการลา : </div>
	<div class="col-xs-12 col-md-7"><?php echo text($rec['ATTABSENT_NOTE']);?></div>
</div>

<?php $db->db_close();?>