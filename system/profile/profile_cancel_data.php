<?php 
/*$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " 1=1 ", "ORG_SEQ");

$sql_pen = "select * from PENALTY_PETITION_FORM a
INNER JOIN SETUP_CRIME_MAIN b  on a.INFORM_CRIME_ID = b.CRIME_ID
WHERE a.PENALTY_ID = '".$PENALTY_ID."'"; 
$query_pen= $db->query($sql_pen);
$rec_main = $db->db_fetch_array($query_pen);

$r_to_per = $db->get_data_rec("SELECT PER_ID, TYPE_NAME_TH, LINE_NAME_TH, LEVEL_NAME_TH, ORG_ID_3, ORG_ID_4, PT_ID 
							   FROM PER_PROFILE JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = PER_PROFILE.TYPE_ID
							   JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = PER_PROFILE.LEVEL_ID 
							   JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = PER_PROFILE.LINE_ID 
							   WHERE PER_ID = '".$rec_main['INFORM_TO_PER_ID']."'");
//ผู้ถูกร้องเรียน
$name = Showname($rec_main["INFORM_TO_PREFIX_ID"],$rec_main["INFORM_TO_FIRSTNAME"],$rec_main["INFORM_TO_MIDNAME"],$rec_main["INFORM_TO_LASTNAME"]);
$position_to = 'เลขที่ตำแหน่ง : '.$db->get_pos_no($r_to_per['PER_ID']);
if($r_to_per['PT_ID'] == 1){
	$position_to .= '<br>ประเภทตำแหน่ง : '.text($r_to_per['TYPE_NAME_TH']);
	$position_to .= '<br>ตำแหน่งในสายงาน : '.text($r_to_per['LINE_NAME_TH']);
	$position_to .= '<br>ระดับ : '.text($r_to_per['LEVEL_NAME_TH']);
}else if($r_by_per['PT_ID'] == 2){
	$position_to .= '<br>ประเภทพนักงานราชการ : '.text($r_to_per['TYPE_NAME_TH']);
	$position_to .= '<br>ตำแหน่ง : '.text($r_to_per['LINE_NAME_TH']);
	$position_to .= '<br>ประเภทกลุ่มงาน : '.text($r_to_per['LEVEL_NAME_TH']);
}else if($r_by_per['PT_ID'] == 3){
	$position_to .= '<br>กลุ่มงาน : '.text($r_to_per['TYPE_NAME_TH']);
	$position_to .= '<br>ตำแหน่งในสายงาน : '.text($r_to_per['LINE_NAME_TH']);
	$position_to .= '<br>ระดับตำแหน่ง : '.text($r_to_per['LEVEL_NAME_TH']);
}
$position_to .= '<br>สำนัก/กลุ่ม : '.text($arr_org[$r_to_per['ORG_ID_3']]);
$position_to .= '<br>กลุ่มงาน : '.text($arr_org[$r_to_per['ORG_ID_4']]);

$name_by =Showname($rec_main["INFORM_BY_PREFIX_ID"],$rec_main["INFORM_BY_FIRSTNAME_TH"],$rec_main["INFORM_BY_MIDNAME_TH"],$rec_main["INFORM_BY_LASTNAME_TH"]);

//ผู้ร้องเรียน
if($rec_main['INFORM_BY_TYPE'] == 1){ //บุคคลภายใน
	$r_by_per = $db->get_data_rec("SELECT PER_ID, PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, TYPE_NAME_TH, LINE_NAME_TH, LEVEL_NAME_TH, ORG_ID_3, ORG_ID_4, PT_ID 
								   FROM PER_PROFILE JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = PER_PROFILE.TYPE_ID
								   JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = PER_PROFILE.LEVEL_ID 
								   JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = PER_PROFILE.LINE_ID 
								   WHERE PER_ID = '".$rec_main['INFORM_BY_PER_ID']."'");
	
	$position_by = 'เลขที่ตำแหน่ง : '.$db->get_pos_no($r_by_per['PER_ID']);
	if($r_by_per['PT_ID'] == 1){
		$position_by .= '<br>ประเภทตำแหน่ง : '.text($r_by_per['TYPE_NAME_TH']);
		$position_by .= '<br>ตำแหน่งในสายงาน : '.text($r_by_per['LINE_NAME_TH']);
		$position_by .= '<br>ระดับ : '.text($r_by_per['LEVEL_NAME_TH']);
	}else if($r_by_per['PT_ID'] == 2){
		$position_by .= '<br>ประเภทพนักงานราชการ : '.text($r_by_per['TYPE_NAME_TH']);
		$position_by .= '<br>ตำแหน่ง : '.text($r_by_per['LINE_NAME_TH']);
		$position_by .= '<br>ประเภทกลุ่มงาน : '.text($r_by_per['LEVEL_NAME_TH']);
	}else if($r_by_per['PT_ID'] == 3){
		$position_by .= '<br>กลุ่มงาน : '.text($r_by_per['TYPE_NAME_TH']);
		$position_by .= '<br>ตำแหน่งในสายงาน : '.text($r_by_per['LINE_NAME_TH']);
		$position_by .= '<br>ระดับตำแหน่ง : '.text($r_by_per['LEVEL_NAME_TH']);
	}
	$position_by .= '<br>สำนัก/กลุ่ม : '.text($arr_org[$r_by_per['ORG_ID_3']]);
	$position_by .= '<br>กลุ่มงาน : '.text($arr_org[$r_by_per['ORG_ID_4']]);
}*/
?>
<?php
	if($type_track == 1){
	$sty_in = "in";
	$sty_exp = "style=\"display:none;\"";
	$sty_clse = "";
	}else{
	$sty_in = "";
	$sty_exp = "";
	$sty_clse = "style=\"display:none;\"";
	}
 ?>

 <div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse14" onClick="$('.switchPic14').toggle();">
            <img class="switchPic14" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic14" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
              การล้างมลทิน
        </a>
    </div>
</div>

<div id="collapse14" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">พ.ร.บ. ล้างมลทิน ปี พ.ศ. :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-3"><?php echo text($rec_pun['CANCEL_YEAR']);?></div>
         <div class="col-xs-12 col-md-1"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผล&nbsp;:&nbsp;</div> 
        <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo conv_date($rec_pun['CANCEL_DATE'],'short');?></div>   
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เล่มที่ :&nbsp;&nbsp;</div> 
        <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo $rec_pun['CANCEL_GAZZETTE_BOOK']; ?></div> 
        <div class="col-xs-12 col-md-1"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตอน :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-3"><?php echo $rec_pun['CANCEL_GAZZETTE_PART'];?></div>
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เมื่อวันที่ :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-3"><?php echo conv_date($rec_pun['CANCEL_GAZZETTE_DATE'],'short');?></div>
         <div class="col-xs-12 col-md-1"></div>
         <div class="col-xs-12 col-md-2" style="white-space:nowrap">หน้าที่ :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-3"><?php echo $rec_pun['CANCEL_GAZZETTE_PAGE'];?></div>
    </div>
</div>
    
    