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
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();">
            <img class="switchPic5" src="<?php echo $path;?>images/exp.gif" <?php echo $sty_exp;?>>
            <img class="switchPic5" src="<?php echo $path;?>images/clse.gif" <?php echo $sty_clse;?>>
          คำสั่งให้พักราชการไว้ก่อน/คำสั่งให้ออกจากราชการไว้ก่อน
        </a>
    </div>
</div>

<div id="collapse5" class="collapse <?php echo $sty_in;?>">
    <div class="row formSep">
        <table class="table table-bordered table-striped table-hover table-condensed">
            <thead>
                <tr class="bgHead">
                    <th width="20%"><div align="center">รายการข้อมูล</div></th>
                    <th width="20%"><div align="center">การให้พักราชการไว้ก่อน</div></th>
                    <th width="20%"><div align="center">การให้ออกราชการไว้ก่อน</div></th>
                </tr>
                <tr>
                    <td align="left">ประเภทคำสั่ง</td>
                    <td align="left"><?php echo text($arr_command_type[$rec_pun['PAUSE_CT_ID']]);?></td>
                    <td align="left"><?php echo text($arr_command_type[$rec_pun['RESIGN_CT_ID']]);?></td>
                </tr>
                <tr>
                    <td align="left">เลขที่คำสั่ง</td>
                    <td align="left"><?php echo text($rec_pun['PAUSE_NO']);?></td>
                    <td align="left"><?php echo text($rec_pun['RESIGN_NO']);?></td>
                </tr>
                <tr>
                    <td align="left">ลงวันที่</td>
                    <td align="left"><?php echo conv_date($rec_pun['PAUSE_DATE'],'short');?></td>
                    <td align="left"><?php echo conv_date($rec_pun['RESIGN_DATE'],'short');?></td>
                 </tr>
                 <tr>
                    <td align="left">เรื่อง</td>
                    <td align="left"><?php echo text($rec_pun['PAUSE_TITLE']);?></td>
                    <td align="left"><?php echo text($rec_pun['RESIGN_TITLE']);?></td>
                 </tr>
                 <tr>
                    <td align="left">ตั้งแต่วันที่</td>
                    <td align="left"><?php echo conv_date($rec_pun['PAUSE_SDATE'],'short');?></td>
                    <td align="left"><?php echo conv_date($rec_pun['RESIGN_SDATE'],'short');?></td>
                 </tr>
                 <tr>
                    <td align="left">ถึงวันที่</td>
                    <td align="left"><?php echo conv_date($rec_pun['PAUSE_EDATE'],'short');?></td>
                    <td align="left"><?php echo conv_date($rec_pun['RESIGN_EDATE'],'short');?></td>
                 </tr>
                 <tr>
                    <td align="left">การรับเงินเดือน</td>
                    <td align="left"><?php echo $arr_perct_salary[$rec_pun['PAUSE_SALARY']];?></td>
                    <td align="left"><?php echo $arr_perct_salary[$rec_pun['RESIGN_SALARY']];?></td>
                 </tr>
            </thead>
        </table>
    </div>
</div>