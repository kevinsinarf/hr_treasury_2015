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
$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "CT_TYPE = '1' AND ACTIVE_STATUS = '1' and DELETE_FLAG = '0' ", "CT_NAME_TH");
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
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo text($arr_command_type[$rec_pun['FINAL_CT_ID']]);?></div>
   </div>
   <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo text($rec_pun['FINAL_TITLE']);?></div>
   </div>
    
   <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่งลงโทษทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-md-4"><?php echo text($rec_pun['FINAL_NO']);?></div> 
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ลงคำสั่งลงโทษทางวินัย :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['FINAL_DATE'],'short');?></div>          
   </div>
   <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">โทษทางวินัยที่เห็นสมควร :&nbsp;</div>
        <div class="col-xs-12 col-md-4" style="white-space:nowrap"><?php echo $arr_punnish[$rec_pun['FINAL_PUNISH_ID']];?></div>
        <?php if($rec_pun['FINAL_PUNISH_ID']== 6||$rec_pun['FINAL_PUNISH_ID']== 7){?>
            <div class="col-xs-12 col-sm-2">ร้อยละ&nbsp;:</div>
            <div class="col-xs-12 col-sm-4"><?php echo $rec_pun['FINAL_PERCENTAGE'];?></div>
        <?php } ?>
   </div>
    
   <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตั้งแต่วันที่ :&nbsp;</div>
        <div class="col-xs-12 col-md-4"><?php echo conv_date($rec_pun['FINAL_SDATE'],'short');?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ถึงวันที่ :&nbsp;</div>
        <div class="col-xs-12 col-sm-4"><?php echo conv_date($rec_pun['FINAL_EDATE'],'short');?></div>          
   </div>
</div>