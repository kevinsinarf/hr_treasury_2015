<?php 
$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " 1=1 ", "ORG_SEQ");
//ข้อมูลบุคคล
/*$sql_pen = "select * from PENALTY_PETITION_FORM a
LEFT JOIN SETUP_CRIME_MAIN b  on a.INFORM_CRIME_ID = b.CRIME_ID
WHERE a.PENALTY_ID = '1'"; 
$query_pen= $db->query($sql_pen);
$rec_main = $db->db_fetch_array($query_pen);*/

//ข้อมูลการร้องเรียน
$sql_pun = "select * from PER_PUNISHMENT a
LEFT JOIN SETUP_CRIME_MAIN b  on a.INFORM_CRIME_ID = b.CRIME_ID
WHERE a.PUN_ID = '".$PUN_ID."' "; 
$query_pun= $db->query($sql_pun);
$rec_pun = $db->db_fetch_array($query_pun);


$r_to_per = $db->get_data_rec("SELECT PER_ID,PREFIX_ID ,PER_FIRSTNAME_TH ,PER_MIDNAME_TH , PER_LASTNAME_TH,TYPE_NAME_TH, LINE_NAME_TH, LEVEL_NAME_TH, ORG_ID_3, ORG_ID_4, PT_ID 
							   FROM PER_PROFILE JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = PER_PROFILE.TYPE_ID
							   JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = PER_PROFILE.LEVEL_ID 
							   JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = PER_PROFILE.LINE_ID 
							   WHERE PER_ID = '".$rec_pun['PER_ID']."'");
							   
//ผู้ถูกร้องเรียน
$name = Showname($r_to_per["PREFIX_ID"],$r_to_per["PER_FIRSTNAME_TH"],$r_to_per["PER_MIDNAME_TH"],$r_to_per["PER_LASTNAME_TH"]);
$position_to = $arr_txt['pos_no'].' : '.$db->get_pos_no($r_to_per['PER_ID']);
if($r_to_per['PT_ID'] == 1){
	$position_to .= '<br>'.$arr_txt['type_pos'].' : '.text($r_to_per['TYPE_NAME_TH']);
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

//$name_by =Showname($rec_main["INFORM_BY_PREFIX_ID"],$rec_main["INFORM_BY_FIRSTNAME_TH"],$rec_main["INFORM_BY_MIDNAME_TH"],$rec_main["INFORM_BY_LASTNAME_TH"]);

//ผู้ร้องเรียน
//if($rec_main['INFORM_BY_TYPE'] == 1){ //บุคคลภายใน
$rec_pun['INFORM_BY_PER_ID'];
$rec_pun['PT_ID'];

	$r_by_per = $db->get_data_rec("SELECT POS_NO,PER_IDCARD,PER_ID, PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, TYPE_NAME_TH, LINE_NAME_TH, LEVEL_NAME_TH, ORG_ID_3, ORG_ID_4, PT_ID 
								   FROM PER_PROFILE JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = PER_PROFILE.TYPE_ID
								   JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = PER_PROFILE.LEVEL_ID 
								   JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = PER_PROFILE.LINE_ID 
								   WHERE PER_ID = '".$rec_pun['INFORM_BY_PER_ID']."'");
								   
	$name_by =Showname($r_by_per["PREFIX_ID"],$r_by_per["PER_FIRSTNAME_TH"],$r_by_per["PER_MIDNAME_TH"],$r_by_per["PER_LASTNAME_TH"]);
	
	$position_by = $arr_txt['pos_no'].' : '.text($r_by_per['POS_NO']);
	if($r_by_per['PT_ID'] == 1){
		$position_by .= '<br>'.$arr_txt['type_pos'].' : '.text($r_by_per['TYPE_NAME_TH']);
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
//}
?>
<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
            <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
            <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
            ข้อมูลการร้องเรียน
        </a>
    </div>
</div>

<div id="collapse1" class="collapse in">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำร้อง :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo text($rec_pun['INFORM_NO']);?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ร้องเรียน&nbsp;:&nbsp;</div> 
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo conv_date($rec_pun['INFORM_DATE'],'short');?></div>   
    </div> 
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ฐานความผิดที่ร้องเรียน :&nbsp;&nbsp;</div> 
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo text($rec_pun['CRIME_NAME_TH']);?></div> 
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ผู้ถูกร้องเรียน :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo $name;?></div>
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตำแหน่ง :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo $position_to;?></div>
    </div>
</div>
<!--
<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
            <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
            <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
            ข้อมูลผู้ร้องเรียน
        </a>
    </div>
</div>

<div id="collapse2" class="collapse in">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทผู้ร้องเรียน :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php if($r_by_per['PT_ID'] == 1){ echo "บุคคลภายใน"; }else{ echo "บุคคลภายนอก";}?></div>
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ผู้ร้องเรียน :&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo $name_by;?></div>
    </div>
    <?php if($r_by_per['PT_ID'] == 1){?>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตำแหน่ง :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo $position_by;?></div>
        </div>
    <?php } ?>
    
    <?php  if($r_by_per['PT_ID'] == 2){?>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2">เลขบัตรประจำตัวประชาชน :&nbsp;</div>
            <div class="col-xs-12 col-md-4"><?php echo get_Idcard($r_by_per['PER_IDCARD']);?></div>
        </div>
     
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">หน่วยงานที่สังกัด :&nbsp;</div>
            <div class="col-xs-12 col-md-6"><?php echo text($r_by_per['INFORM_BY_ORG_NAME']);?></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">หมายเลขโทรศัพท์ ติดต่อ :&nbsp;</div>
            <div class="col-xs-12 col-md-4"><?php echo text($r_by_per['INFORM_BY_TEL']);?></div>
        </div>    
    <?php } ?>
</div>    -->
    