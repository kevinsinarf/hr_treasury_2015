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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse12" onClick="$('.switchPic12').toggle();">
            <img class="switchPic12" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic12" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
             การายงานผลต่อ ก.พ. 
        </a>
    </div>
</div>

<div id="collapse12" class="collapse <?php echo $sty_in;?>">
		 <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง. :&nbsp;</div>
                <div class="col-xs-12 col-md-3"><?php echo text($arr_command_type[$rec_pun['KRST_COM_CT_ID']]);?></div> 
                <div class="col-xs-12 col-md-1"></div>   
        </div>
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :&nbsp;</div>
                <div class="col-xs-12 col-md-3"><?php echo text($rec_pun['KRST_COM_NO']);?></div> 
                <div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['KRST_COM_DATE'],'short');?></div>          
        </div>
	 <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
                <div class="col-xs-12 col-md-3"><?php echo text($rec_pun['KRST_COM_TITLE']);?></div>    
        </div>
        
        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">การประชุม ก.พ. ครั้งที่ :&nbsp;</div>
                <div class="col-xs-12 col-md-3"><?php echo text($rec_pun['REPORT_MEETING_TIME']);?></div> 
                <div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ประชุม :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['REPORT_MEETING_DATE'],'short');?></div>          
        </div>

        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัยที่สั่ง :&nbsp;</div>
                <div class="col-xs-12 col-md-3"><?php echo  $arr_punnish[$rec_pun['KRST_PUNISH_ID']]; ?></div>
                 <div class="col-xs-12 col-md-1"></div>
                 <?php if($rec_pun['FINAL_PUNISH_ID']== 6||$rec_pun['FINAL_PUNISH_ID']== 7){?>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ร้อยละ :&nbsp;</div>
                <div class="col-xs-12 col-md-1"><?php echo $rec_pun['KRST_PUNISH_PERCENTAGE']; ?></div> 
        		<?php } ?>
        </div>

        <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['KRST_COM_SDATE'],'short');?></div>
                <div class="col-xs-12 col-sm-2"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :&nbsp;</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['KRST_COM_EDATE'],'short');?></div>
                </div>
</div>
