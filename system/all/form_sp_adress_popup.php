
<?php
$path = "../../";
include($path . "include/config_header_top.php");

$P_SAPA_ID = $_GET['SAPA_ID'];
$P_SP_ID = $_GET['SP_ID'];
$s_asset = $_GET['s_asset'];

//เช็คว่าสถานะเท่ากับ 5  หรือไม่
$sql = "SELECT ADDHIS_TYPE FROM SP_ADDRESS WHERE SP_ID = '" . $P_SP_ID . "' AND ADDHIS_TYPE = '5' ";
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

if($nums==0){
    $WHERE = " WHERE SAPA_ID = '" . $P_SAPA_ID . "' AND a.SP_ID = '" . $P_SP_ID . "' AND ( (ADDHIS_TYPE = '3')) ";    
}else{
    $WHERE = " WHERE SAPA_ID = '" . $P_SAPA_ID . "' AND a.SP_ID = '" . $P_SP_ID . "' AND ADDHIS_TYPE = '5' ";
}

$rec = $db->get_data_rec("SELECT TOP 1 * FROM SP_ADDRESS a 
INNER JOIN SP_MANPOWER b ON b.SP_ID=a.SP_ID
".$WHERE." ORDER BY ADDHIS_ID DESC ");

//อำเภอ/เขต
$arr_ampr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='" . $rec['SSA_PROV_ID'] . "' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
//ตำบล/แขวง
$arr_tamb = GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='" . $rec['SSA_AMPR_ID'] . "' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
?>
<input type="hidden" id="P_SP_ID" name="P_SP_ID" value="<?php echo $P_SP_ID; ?>" >
<input type="hidden" id="P_SAPA_ID" name="P_SAPA_ID" value="<?php echo $P_SAPA_ID; ?>" >
<input type="hidden" id="p_s_asset" name="p_s_asset" value="<?php echo $s_asset; ?>" >

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ :</div>
    <div class="col-xs-12 col-md-3">
        <input type="text" id="S_HOMENO" name="S_HOMENO" class="form-control" placeholder="บ้านเลขที่" maxlength="10" value="<?php echo text($rec['ADDHIS_ROOM_NO']); ?>">
    </div>
    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">หมู่ที่ :</div>
    <div class="col-xs-12 col-md-3 "> 
        <div id="ss_moo_L" style="display:none" > </div>
        <div id="ss_moo_T" ><input type="text" id="S_MOO" name="S_MOO" class="form-control" placeholder="หมู่" maxlength="10" value="<?php echo text($rec['ADDHIS_MOO']); ?>"></div> 
    </div>
</div>     
<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้าน :</div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_mooban_L" style="display:none" > </div>
        <div id="ss_mooban_T" ><input type="text" id="S_VILLAGE" name="S_VILLAGE" class="form-control" placeholder="หมู่บ้าน" maxlength="100" value="<?php echo text($rec['ADDHIS_VILLAGE']); ?>"></div>
    </div>
    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">อาคาร :</div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_build_L" style="display:none" > </div>
        <div id="ss_build_T" ><input type="text" id="S_BUILDING" name="S_BUILDING" class="form-control" placeholder="อาคาร" maxlength="100" value="<?php echo text($rec['ADDHIS_BUILDING']); ?>"></div>
    </div>
</div>
<div class="row formSep">
    <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">เลขที่ห้อง :</div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_room_L" style="display:none" > </div>
        <div id="ss_room_T" ><input type="text" id="S_ROOM" name="S_ROOM" class="form-control " placeholder="เลขที่ห้อง" maxlength="20" value="<?php echo text($rec['ADDHIS_ROOM_NO']); ?>"></div>
    </div>
    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ซอย :</div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_soi_L" style="display:none" > </div>
        <div id="ss_soi_T" ><input type="text" id="S_SOI" name="S_SOI" class="form-control" placeholder="ซอย" maxlength="100" value="<?php echo text($rec['ADDHIS_SOI']); ?>"></div>
    </div>
</div>
<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนน :</div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_road_L" style="display:none" > </div>
        <div id="ss_road_T" ><input type="text" id="S_ROAD" name="S_ROAD" class="form-control" placeholder="ถนน" maxlength="100" value="<?php echo text($rec['ADDHIS_ROAD']); ?>"></div>
    </div>
    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;"><?php echo $arr_data['country_name']; ?> :</div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_country_L" style="display:none" > </div>
        <div id="ss_country_T" ><?php echo GetHtmlSelect('S_COUNTRY', 'S_COUNTRY', $arr_country, $arr_data['country_name'], $rec["COUNTRY_ID"] == '' ? $rec["COUNTRY_ID"] = "41" : $rec["COUNTRY_ID"], '', '', '1'); ?></div>
    </div>
</div>
<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['prov']; ?> : </div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_prove_L" style="display:none" > </div>
        <div id="ss_prove_T" ><?php echo GetHtmlSelect('s_prov', 's_prov', $arr_prov, $arr_txt['prov'], $rec['PROV_ID'], 'onchange="getRampr(this,\'s_ampr' . '\',\'s_tamb' . '\')"', '', '1'); ?></div>
    </div>
    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">อำเภอ/เขต : </div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_armp_L" style="display:none" ></div>
        <span id='ss_ampr' ><?php echo GetHtmlSelect('s_ampr', 's_ampr', $arr_ampr, 'อำเภอ/เขต', $rec['AMPR_ID'], 'onchange="getStamb(this.id,this.value,\'s_tamb' . '\')"', '', '1'); ?></span>
    </div>
</div>
<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวง : </div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_tamb_L" style="display:none" ></div>
        <span id='ss_tamb'><?php echo GetHtmlSelect('s_tamb', 's_tamb', $arr_tamb, 'ตำบล/แขวง', $rec['TAMB_ID'], '', '', '1'); ?></span>
    </div>
    <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">รหัสไปรษณีย์ : </div>
    <div class="col-xs-12 col-md-3">
        <div id="ss_zip_L" style="display:none" ></div>
        <div id="ss_zip_T" ><input type="text" id="S_ZIPCODE" name="S_ZIPCODE" class="form-control number" placeholder="รหัสไปรษณีย์" maxlength="5" value="<?php echo trim($rec['ADDHIS_ZIPCODE']); ?>"></div>
    </div>
</div>
<?php
//โทรศัทพ์พื้นฐาน
for ($c_tel = 1; $c_tel <= 4; $c_tel++) {
    if($c_tel<=2){
		$c_text=$arr_txt['telbkk'.$c_tel];
		$n_class='telbkk';
	}else{
		$c_text=$arr_txt['telprov'.($c_tel-2)];
		$n_class='telprov';
	}
    $t_val = trim(text($rec['SSA_TEL_' . $c_tel]));
    $t_ext = trim(text($rec['SSA_TEL_' . $c_tel . '_EXT']));

    if ($c_tel == 1 || $c_tel == 3) {
        echo '<div class="row ">';
    }
    ?>
   
    <?php
    if ($c_tel == 2 || $c_tel == 4) {
        echo '</div>';
    }
}
?>
<div class="row formSep">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์กรุงเทพฯ  : </div>
	<div class="col-xs-12 col-md-2"><input type="text" id="SP_TEL1" name="SP_TEL1" class="form-control telbkk" placeholder="โทรศัพท์กรุงเทพฯ" maxlength="10" value="<?php echo text($rec['ADDHIS_TEL1']); ?>"></div>
	<div class="col-xs-12 col-sm-2"><div class="input-group"><span class="input-group-addon">ต่อ</span><input type="text" id="SP_TEL1_EXT" name="SP_TEL1_EXT" maxlength="4" class="form-control" placeholder="ต่อ" value="<?php echo text($rec["ADDHIS_TEL1_EXT"]); ?>"></div></div>
	<div class="col-xs-12 col-md-2 " style="white-space:nowrap;">โทรศัพท์ต่างจังหวัด   : </div>
	<div class="col-xs-12 col-md-2"><input type="text" id="SP_TEL2" name="SP_TEL2" class="form-control telprov" placeholder="โทรศัพท์ต่างจังหวัด" maxlength="10" value="<?php echo text($rec['ADDHIS_TEL2']); ?>"></div>
	<div class="col-xs-12 col-sm-2"><div class="input-group"><span class="input-group-addon">ต่อ</span><input type="text" id="SP_TEL2_EXT" name="SP_TEL2_EXT" maxlength="4" class="form-control" placeholder="ต่อ" value="<?php echo text($rec["ADDHIS_TEL2_EXT"]); ?>"></div></div>
</div>
    <div class="row formSep">
        <div class="col-xs-12 col-md-2 " ><?php echo $arr_txt['faxbkk']; ?> :</div>
        <div class="col-xs-12 col-md-2 ">
            <div id="ss_fax_L" style="display:none" ></div>
            <div id="ss_fax_T" style="display:''"><input type="text" id="S_FAX" name="S_FAX" class="form-control telbkk" placeholder="<?php echo $arr_txt['faxbkk']; ?>" maxlength="20" value="<?php echo trim(text($rec['ADDHIS_FAX1'])); ?>"></div>
            <input type="hidden" name="fax-line" id="fax-line" value="1" >
        </div>
        <div class="col-xs-12 col-md-2 col-md-offset-2" style="white-space:nowrap;"><?php echo $arr_txt['faxprov']; ?> :</div>
        <div class="col-xs-12 col-md-2 ">
            <div id="ss_faxprov_L" style="display:none" ></div>
            <div id="ss_faxprov_T" style="display:''"><input type="text" id="S_FAXPROV" name="S_FAXPROV" class="form-control telprov" placeholder="<?php echo $arr_txt['faxprov']; ?>" maxlength="20" value="<?php echo trim(text($rec['ADDHIS_FAX2'])); ?>"></div>
            <input type="hidden" name="fax-line" id="fax-line" value="1" >
        </div>
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;"><?php echo $arr_txt['mobile']; ?>  : &nbsp;</div>
        <div class="col-xs-12 col-md-2 ">
            <div id="ss_mobile_L" style="display:none" ></div>
            <div id="ss_mobile_T" style="display:''"><input type="text" id="S_MOBILE" name="S_MOBILE" class="form-control mobile " placeholder="<?php echo $arr_txt['mobile']; ?>" maxlength="20" value="<?php echo trim(text($rec['ADDHIS_MOBILE'])); ?>"></div>
            <input type="hidden" name="mob-line" id="mob-line" value="1" >
        </div>
        
    </div>
    <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['email']; ?> :</div>
        <div class="col-xs-12 col-md-3">
            <div id="ss_mail_L" style="display:none" ></div>
            <div id="ss_mail_T" style="display:''"><input type="email" id="S_EMAIL" name="S_EMAIL" class="form-control email" placeholder="<?php echo $arr_txt['email']; ?>" maxlength="50" value="<?php echo trim($rec['ADDHIS_EMAIL']); ?>"></div>
        </div>
    </div>