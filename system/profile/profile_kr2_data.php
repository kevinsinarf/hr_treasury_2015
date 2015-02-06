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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse13" onClick="$('.switchPic13').toggle();">
            <img class="switchPic13" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic13" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
              ผลการอุทธรณ์
        </a>
    </div>
</div>

<div id="collapse13" class="collapse <?php echo $sty_in;?>">

		<div class="row formSep">
        	<div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่หนังสือ :&nbsp;</div>
            <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo text($rec_pun['BOOK_NO']); ?></div>
             <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
                <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo conv_date($rec_pun['BOOK_DATE'],'short'); ?></div>
        </div>
		<div class="row formSep">
        		<div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
                <div class="col-xs-12 col-md-10" style="white-space:nowrap"><?php echo text($rec_pun['BOOK_TITLE']); ?></div>
        </div>

        	<div class="row formSep">
        		<div class="col-xs-12 col-md-2" style="white-space:nowrap">การประชุม ก.พ. ครั้งที่ :&nbsp;</div>
                <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo $rec_pun['KR_TIME']; ?></div>
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ประชุม :&nbsp;</div>
                <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo conv_date($rec_pun['KR_DATE'],'short'); ?></div>
        </div>
	   <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;</div>
                <div class="col-xs-12 col-md-3" style="white-space:nowrap"><?php echo text($arr_command_type[$rec_pun['END_COM_CT_ID']]); ?></div>
        </div>
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :</div>
                <div class="col-xs-12 col-md-3"><?php echo text($rec_pun['END_COM_NO']); ?></div>
                <div class="col-xs-12 col-sm-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['END_COM_DATE'],'short'); ?></div>   
        </div>
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
                <div class="col-xs-12 col-md-10" style="white-space:nowrap"><?php echo text($rec_pun['END_COM_TITLE']); ?></div>
        </div>
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัย :</div>
                <div class="col-xs-12 col-md-3"><?php echo $arr_punnish[$rec_pun['END_PUNISH_ID']]; ?> </div>
                <div class="col-xs-12 col-md-1"></div>
                <span id="end_percent">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ร้อยละ :&nbsp;</div>
                        <div class="col-xs-12 col-md-1"><?php echo $rec_pun['END_PUNISH_PERCENTAGE']; ?></div> 
                </span>
        </div>
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['END_COM_SDATE'],'short');?> </div>
      			<div class="col-xs-12 col-sm-2"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['END_COM_EDATE'],'short');?></div>
        </div>
</div>