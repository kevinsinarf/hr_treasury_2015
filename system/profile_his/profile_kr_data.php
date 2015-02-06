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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse9" onClick="$('.switchPic9').toggle();">
            <img class="switchPic9" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic9" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
            ผลการพิจารณา ก.พ.
        </a>
    </div>
</div>

<div id="collapse9" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">การประชุม ก.พ. ครั้งที่ :&nbsp;</div>
        <div class="col-xs-12 col-md-3"><?php echo text($rec_main['KR_TIME']);?></div> 
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ประชุม :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_main['KR_DATE'],'short');?></div>
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ผลการอุทธรณ์ :&nbsp;</div>
        <div class="col-xs-12 col-md-3"><?php echo $arr_kr_result[$rec_main['KR_RESULT']];?></div> 
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-md-3"><?php echo $arr_punnish[$rec_main['KR_PUNISH_ID']];?></div>
    </div>
    
    <div class="row formSep" id="kr_percent">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ร้อยละ :&nbsp;</div>
        <div class="col-xs-12 col-md-1"><?php echo $rec_main['KR_PERCENTAGE'];?></div> 
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_main['KR_SDATE'],'short');?></div>
        <div class="col-xs-12 col-sm-1"></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_main['KR_EDATE'],'short');?></div>
    </div>
</div>