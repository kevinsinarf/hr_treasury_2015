<?php
if(!empty($PER_ID)){
	$sql_info = "SELECT A.PER_ID, A.POS_NO, A.PT_ID, A.POS_YEAR, A.PER_IDCARD, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH,
	                 B.TYPE_NAME_TH, C.LEVEL_NAME_TH, D.LG_NAME_TH, E.LINE_NAME_TH, G.MANAGE_NAME_TH, H.ORG_NAME_TH AS ORG_NAME_3, 
					 I.ORG_NAME_TH AS ORG_NAME_4
	                 FROM PER_PROFILE A
					 LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
					 LEFT JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID = C.LEVEL_ID
					 LEFT JOIN SETUP_POS_LINE_GROUP D ON A.LG_ID = D.LG_ID
					 LEFT JOIN SETUP_POS_LINE E ON A.LINE_ID = E.LINE_ID
					 LEFT JOIN SETUP_POS_MANAGE G ON A.MANAGE_ID = G.MANAGE_ID
					 LEFT JOIN SETUP_ORG H ON A.ORG_ID_3 = H.ORG_ID
					 LEFT JOIN SETUP_ORG I ON A.ORG_ID_4 = I.ORG_ID
					 WHERE  A.PER_ID = '".$PER_ID."' ";
	$query_info = $db->query($sql_info);
	$info = $db->db_fetch_array($query_info);

	if($info["PT_ID"]=="2"){
		$page_back = "profile_his_empser.php";
		$txt_type = "ประเภทพนักงานราชการ";
		$txt_level = "ประเภทกลุ่มงาน";
		$txt_line = "ตำแหน่ง";
		
		//หาปีกรอบ
		$POS_YEAR = $info['POS_YEAR'];
		$formSep = " formSep3";
		$formSep3 = "";
	}elseif($info["PT_ID"]=="3"){
		$page_back = "profile_his_emp.php";
		$txt_type = "กลุ่มงาน";
		$txt_level = "ระดับตำแหน่ง";
		$txt_line = "ตำแหน่งในสายงาน";
		$formSep = "formSep";
		$formSep3 = "formSep3";
	}else{
		$page_back = "profile_his_disp.php";
		$txt_type = "ประเภทตำแหน่ง";
		$txt_level = "ระดับ";
		$txt_line = "ตำแหน่งในสายงาน";
		$formSep = "formSep";
		$formSep3 = "formSep3";
	}
}
?>
<div class="row formSep">
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right"><?php echo $arr_txt['idcard'];?> :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo get_idCard($info['PER_IDCARD']); ?></div>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right"><?php echo $arr_txt['name'];?> :</div>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap"><?php echo Showname($info["PREFIX_ID"],$info["PER_FIRSTNAME_TH"],$info["PER_MIDNAME_TH"],$info["PER_LASTNAME_TH"]);?></div>
</div>

<div class="row formSep">
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right">เลขที่ตำแหน่ง :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo $info['POS_NO']; ?></div>
    <?php if($info["PT_ID"] == 1){?>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right">ตำแหน่งทางการบริหาร :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo (trim($info['MANAGE_NAME_TH']) != '') ? text($info['MANAGE_NAME_TH']) : "-"; ?></div>
    <?php }else if($info['PT_ID'] == 2){ ?>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right">ปีที่อนุมัติกรอบ :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo (trim($info['POS_YEAR']) != '') ? $info['POS_YEAR'] : "-"; ?></div>
    <?php } ?>
</div>

<div class="row formSep">
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right"><?php echo $txt_type;?> :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo text($info['TYPE_NAME_TH']); ?></div>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right"><?php echo $txt_level;?> :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo text($info['LEVEL_NAME_TH']); ?></div>
</div>

<div class="row <?php echo $formSep;?>">
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right"><?php echo $txt_line;?> :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo text($info['LINE_NAME_TH']); ?></div>
    <?php if($info['PT_ID'] == 2){?>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right">สำนัก/กลุ่ม :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo text($info['ORG_NAME_3']);?></div>
    <?php } ?>
</div>

<?php if($info['PT_ID'] == 1 || $info['PT_ID'] == 3){?>
<div class="row <?php echo $formSep3;?>">
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right">สำนัก/กลุ่ม :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo text($info['ORG_NAME_3']);?></div>
	<div class="col-xs-6 col-sm-3" style="white-space:nowrap;font-weight:bold;" align="right">กลุ่มงาน :</div>
	<div class="col-xs-6 col-sm-2" style="white-space:nowrap"><?php echo text($info['ORG_NAME_4']);?></div>
</div>
<?php } ?>
<br />