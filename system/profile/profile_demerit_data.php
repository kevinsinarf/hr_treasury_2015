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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse8" onClick="$('.switchPic8').toggle();">
            <img class="switchPic8" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic8" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
            คำสั่งลงโทษทางวินัย
        </a>
    </div>
</div>

<div id="collapse8" class="collapse <?php echo $sty_in;?>">

    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;</div>
        <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo text($arr_command_type[$rec_main['FINAL_CT_ID']]); ?></div>
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่งลงโทษทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-md-3"><?php echo text($rec_main['FINAL_NO']); ?></div> 
        <div class="col-xs-12 col-md-1"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ลงคำสั่งลงโทษทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-md-2"><?php echo conv_date($rec_main['FINAL_DATE'],'short'); ?></div>         
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
        <div class="col-xs-12 col-md-10" style="white-space:nowrap"><?php echo text($rec_main['FINAL_TITLE']); ?></div>
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัยที่เห็นสมควร :&nbsp;</div>
        <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo  $arr_punnish[$rec_main['FINAL_PUNISH_ID']]; ?></div>
    	<div class="col-xs-12 col-sm-1"></div>
        <span id="shw_percent">
			<?php if($rec_main['FINAL_PUNISH_ID']==6||$rec_main['FINAL_PUNISH_ID']==7){?>
            <div class="col-xs-12 col-sm-2">ร้อยละ&nbsp;:</div>
            <div class="col-xs-12 col-sm-2"><?php echo $rec_main['FINAL_PERCENTAGE'];?></div>
            <?php }?>
        </span>
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :&nbsp;</div>
        <div class="col-xs-12 col-md-2"><?php echo conv_date($rec_main['FINAL_SDATE'],'short'); ?></div>
        <div class="col-xs-12 col-sm-2"></div> 
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_main['FINAL_EDATE'],'short'); ?></div> 
    </div>
</div>

