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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
            <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
            ตั้งคณะกรรมการสอบสวนข้อเท็จจริง
        </a>
    </div>
</div>

<div id="collapse3" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;</div>
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo text($arr_command_type[$rec_pun['BOARD_CT_ID']]);?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :&nbsp;</div>
        <div class="col-xs-12 col-md-4"><?php echo text($rec_pun['BOARD_NO']);?></div>
    </div>
   
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['BOARD_DATE'],'short');?></div>        
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผล :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['BOARD_DATE_RESULT'],'short');?></div>
    </div>
    <div class="row formSep">
    	<div class="col-xs-12 col-md-2" style="white-space:nowrap">ผลการพิจารณา :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php if($rec_pun['BOARD_RESULT'] == 1){ echo "มีมูลสั่งให้ดำเนินการทางวินัย";}else{ echo "ไม่มีมูลสั่งให้ยุติเรื่อง";}?></div>    
    	<div class="col-xs-12 col-md-2" style="white-space:nowrap">รายละเอียด :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo text($rec_pun['BOARD_DETAIL']);?></div>    
    </div>
    
</div>

<!--<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
            <img class="switchPic4" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
            ผลการสอบสวนข้อเท็จจริง
        </a>
    </div>
</div>

<div id="collapse4" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผลการพิจารณา : </div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['BOARD_DATE_RESULT'],'short');?></div>   
        <div class="col-xs-12 col-sm-2">ผลการพิจารณา : </div>
        <div class="col-xs-12 col-sm-4"><?php if($rec_pun['BOARD_RESULT'] == 1){ echo "มีมูลสั่งให้ดำเนินการทางวินัย";}else{ echo "ไม่มีมูลสั่งให้ยุติเรื่อง";}?></div>
    </div> 

    <div class="row formSep">
        <div class="col-xs-12 col-sm-2">รายละเอียด : </div>
        <div class="col-xs-12 col-sm-10"><?php echo htmlspecialchars_decode(text($rec_pun['BOARD_DETAIL']));?></div>
    </div>
</div>-->