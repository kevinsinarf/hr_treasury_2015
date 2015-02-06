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
$arr_con = array( '1' => 'ดำเนินการสั่งลงโทษ' , '2'=> 'ดำเนินการสั่งงดโทษ' , '3' => 'ดำเนินการสั่งยุติเรื่อง'); 
$arr_pun_type = array( '1' => 'ไม่ร้ายแรง' , '2'=> 'ร้ายแรง');
?>
<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();">
            <img class="switchPic6" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic6" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
            คำสั่งแต่งตั้งคณะกรรมการสอบสวนทางวินัย
        </a>
    </div>
</div>

<div id="collapse6" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;</div>
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo text($arr_command_type[$rec_pun['RESULT_CT_ID']]);?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :&nbsp;</div>
        <div class="col-xs-12 col-md-4"><?php echo text($rec_pun['RESULT_NO']);?></div> 
    </div>

    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_DATE_ORDER'],'short');?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผล :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_RDATE'],'short');?></div>
    </div>
    <div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผลการพิจารณาทางวินัย :&nbsp;</div>
     <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_DATE_RESULT'],'short');?></div>
     <div class="col-xs-12 col-md-2" style="white-space:nowrap">ผลการสอบสวน :&nbsp;</div>
     <div class="col-xs-12 col-sm-4"><?php echo $arr_con[$rec_pun['RESULT_FINAL']];?></div>
    </div>
    <div class="row formSep">
     <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทความผิด :&nbsp;</div>
     <div class="col-xs-12 col-sm-4"><?php echo $arr_pun_type[$rec_pun['RESULT_PUNISH_TYPE']];?></div> 
	</div>
    
    
     <div class="row formSep">
      <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัย :&nbsp;</div>
     <div class="col-xs-12 col-sm-2"><?php echo $arr_punnish[$rec_pun['RESULT_PUNISH_ID']];?></div>
      <?php if($rec_pun['RESULT_PUNISH_ID']==6||$rec_pun['RESULT_PUNISH_ID']==7) {?>
      <div class="col-xs-12 col-sm-2"></div>
     <div class="col-xs-12 col-md-2" style="white-space:nowrap">ร้อยละ :&nbsp;</div>
     <div class="col-xs-12 col-sm-4"><?php echo $rec_pun['PERCENT_PUNISH'];?></div> 
     <?php }?>
    </div>		
     <div class="row formSep">
     <div class="col-xs-12 col-md-2" style="white-space:nowrap">มีผลตั้งแต่วันที่ :&nbsp;</div>
     <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_SDATE'],'short');?></div> 
     <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึง :&nbsp;</div>
     <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec_pun['RESULT_EDATE'],'short');?></div>
	</div>
    <div class="row formSep">
     <div class="col-xs-12 col-md-2" style="white-space:nowrap">รายละเอียด :&nbsp;</div>
     <div class="col-xs-12 col-sm-4"><?php echo text($rec_pun['RESULT_DETAIL']);?></div> 
    </div>
    </div>

<!--<div class="row head-form">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onClick="$('.switchPic7').toggle();">
            <img class="switchPic7" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic7" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?> >
            ผลการสอบสวนทางวินัย
        </a>
    </div>
</div>

<div id="collapse7" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผลการพิจารณาทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_DATE_RESULT'],'short');?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ผลการสอบสวน :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php if($rec_pun['RESULT_FINAL'] == 1){ echo "ดำเนินการสั่งลงโทษ"; }else if($rec_pun['RESULT_FINAL'] == 2){ echo "ดำเนินการสั่งยุติเรื่อง"; }else{ echo "ดำเนินการสั่งงดโทษ"; }?>&nbsp;</div>
    </div>
    
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทความผิด :&nbsp;</div>
        <div class="col-xs-12 col-sm-10"><?php echo $arr_crime_type[$rec_pun['RESULT_PUNISH_TYPE']];?></div>
    </div>
    
    <div class="row formSep" id="show_date_dis2">
        <div class="col-xs-12 col-sm-2">โทษทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo $arr_punnish[$rec_pun['RESULT_PUNISH_ID']];?></div>
        <?php if($rec_pun['PERCENT_PUNISH'] != ''){?>
            <div class="col-xs-12 col-sm-2">ร้อยละ&nbsp;:</div>
            <div class="col-xs-12 col-sm-4"><?php echo $rec_pun['PERCENT_PUNISH'];?></div>
        <?php } ?>
    </div>
    
    <?php if($rec_pun['RESULT_PUNISH_ID'] != ''){ ?> 
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">มีผลตั้งแต่วันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_SDATE'],'short');?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึง :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['RESULT_EDATE'],'short');?></div>
    </div>
    <?php } ?>
     
    <div class="row formSep">
        <div class="col-xs-12 col-sm-2">รายละเอียด:&nbsp;&nbsp;</div>
        <div class="col-xs-12 col-sm-10"><?php echo text($rec_pun['RESULT_DETAIL']);?></div>
    </div>
</div>-->