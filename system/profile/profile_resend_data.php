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
$arr_proof = array( '1' => "ยื่นโทษ" , '2' => "เพิ่มโทษ", '3' => "ลดโทษ" , '4' => "งดโทษ" , '5' => "ยกโทษ"
);
//DATA โทษทางวินัย
$arr_punnish = array();
$sql = "SELECT *
FROM SETUP_PUNNISH
WHERE ACTIVE_STATUS = '1' 
AND DELETE_FLAG = '0' ";
$query = $db->query($sql);
while($rec = $db->db_fetch_array($query)){
	$rec = convert_text($rec);
	$arr_punnish[$rec['PUNISH_ID']] = $rec['PUNISH_NAME_TH'];
}
$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "CT_TYPE = '1' AND ACTIVE_STATUS = '1' and DELETE_FLAG = '0' ", "CT_NAME_TH");
?>
<!--<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse9" onClick="$('.switchPic9').toggle();">
            <img class="switchPic9" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic9" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
           การรายงานผลต่อ ก.พ.
        </a>
    </div>
</div>
<div id="collapse9" class="collapse <?php echo $sty_in;?>">
<div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่รายงานผลต่อ ก.พ. :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['REPORT_DATE'],'short'); ?></div> 
</div>
<div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่หนังสือ ก.พ. :&nbsp;</div>
        <div class="col-xs-12 col-md-3"><?php echo text($rec_pun['REPORT_BOOK_NO']); ?></div> 
        <div class="col-xs-12 col-sm-1"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['REPORT_BOOK_DATE'],'short'); ?></div>         
</div>
<div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
        <div class="col-xs-12 col-md-10" style="white-space:nowrap"><?php echo text($rec_pun['REPORT_BOOK_TITLE']); ?></div>
</div>
<div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">การประชุม ก.พ. ครั้งที่ :&nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php echo text($rec_pun['REPORT_MEETING_TIME']); ?></div> 
            <div class="col-xs-12 col-sm-1"></div>  
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ประชุม :&nbsp;</div>
            <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['REPORT_MEETING_DATE'],'short'); ?></div>
</div>         
<div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ผลการพิจารณา :&nbsp;</div>
        <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo $arr_proof[$rec_pun['REPORT_RESULT']]; ?></div>
        <div class="col-xs-12 col-md-1"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัยที่สั่ง :&nbsp;</div>
        <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo $arr_punnish[$rec_pun['REPORT_PUNISH_ID']]; ?></div>
</div>
<?php if($rec_pun['REPORT_PUNISH_ID']==6||$rec_pun['REPORT_PUNISH_ID']==7){?>
<div class="row formSep" id="percent2">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ร้อยละ :&nbsp;</div>
        <div class="col-xs-12 col-md-1"><?php echo $rec_pun['REPORT_PUNISH_PERCENTAGE'] ?></div> 
</div>
<?php }?>
<div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['REPORT_SDATE'],'short'); ?></div>
		<div class="col-xs-12 col-sm-2"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['REPORT_EDATE'],'short'); ?></div>   
        </div>
</div>-->
<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse10" onClick="$('.switchPic10').toggle();">
            <img class="switchPic10" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic10" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
            คำสั่งลงโทษทางวินัยภายหลังการรายงานผลต่อ ก.พ.
        </a>
    </div>
</div>
<div id="collapse10" class="collapse <?php echo $sty_in;?>">
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;</div>
                <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo text($arr_command_type[$rec_pun['KRST_COM_CT_ID']]); ?></div>
        </div>
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :&nbsp;</div>
                <div class="col-xs-12 col-md-3"><?php echo $rec_pun['KRST_COM_NO']; ?></div> 
                <div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['KRST_COM_DATE'],'short'); ?></div>          
        </div>
	<div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
            <div class="col-xs-12 col-md-10" style="white-space:nowrap"><?php echo text($rec_pun['KRST_COM_TITLE']); ?></div>
	</div>
    <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัยที่สั่ง :&nbsp;</div>
            <div class="col-xs-12 col-md-3" style="white-space:nowrap"> <?php echo  $arr_punnish[$rec_pun['KRST_PUNISH_ID']]; ?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <?php if($rec_pun['KRST_PUNISH_ID']==6||$rec_pun['KRST_PUNISH_ID']==7){?>
            <div id="percent">
            <div class="col-xs-12 col-sm-2">ร้อยละ&nbsp;:</div><div class="col-xs-12 col-sm-2"><?php echo $rec_pun['KRST_PUNISH_PERCENTAGE']; ?></div>
            </div>
            <?php }?>
    </div>
    <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :&nbsp;</div>
                <div class="col-xs-12 col-md-2"><?php echo conv_date($rec_pun['KRST_COM_SDATE'],'short');?></div>
                <div class="col-xs-12 col-sm-2"></div> 
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['KRST_COM_EDATE'],'short'); ?></div>
    </div>          
</div> 
