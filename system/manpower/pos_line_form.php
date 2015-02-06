<?php
$path = "../../";
include($path . "include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$LINE_ID = $_POST['LINE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";

$sql = " SELECT  LINE_ID, LG_ID, POSTYPE_ID,TYPE_ID,LEVEL_ID,LINE_CODE,LINE_NAME_TH,LINE_NAME_EN,LINE_SHORTNAME_TH,LINE_SHORTNAME_EN,ACTIVE_STATUS 
FROM SETUP_POS_LINE WHERE LINE_ID ='" . $LINE_ID . "' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$LINE_ID = text($rec["LINE_ID"]);
$LG_ID = $rec['LG_ID'];
$LEVEL_ID = text($rec["LEVEL_ID"]);
$POSTYPE_ID = text($rec["POSTYPE_ID"]);
$TYPE_ID = text($rec["TYPE_ID"]);
$LINE_CODE = text($rec["LINE_CODE"]);
$LINE_NAME_TH = text($rec["LINE_NAME_TH"]);
$LINE_NAME_EN = text($rec["LINE_NAME_EN"]);
$LINE_SHORTNAME_TH = text($rec["LINE_SHORTNAME_TH"]);
$LINE_SHORTNAME_EN = text($rec["LINE_SHORTNAME_EN"]);

$SQL_POS_TYPE ="SELECT TYPE_ID,TYPE_NAME_TH FROM SETUP_POS_TYPE WHERE  POSTYPE_ID = '1' AND DELETE_FLAG = '0' ORDER BY TYPE_SEQ ASC ";
$query_POS_TYPE = $db->query($SQL_POS_TYPE);
$SQL_LINE_GROUP ="SELECT LG_ID, LG_NAME_TH FROM SETUP_POS_LINE_GROUP WHERE  POSTYPE_ID = '1' AND DELETE_FLAG = '0' AND TYPE_ID = '".$TYPE_ID."' ORDER BY LG_NAME_TH ASC ";
$query_line_group = $db->query($SQL_LINE_GROUP);

$arr_salary_step = array(1 => 'ขั้นปกติ', 2 => 'ขั้นสูง');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="language" content="en" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
    <link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
    <link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
    <link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
    <link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
    <link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
    <script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
    <script src="<?php echo $path; ?>js/func.js"></script>
    <script src="js/pos_line_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
    <div class="container-full">
        <div><?php include($path . "include/header.php"); ?></div>
        <div><?php include($path . "include/menu.php"); ?></div>
        <div class="col-xs-12 col-sm-12">
            <ol class="breadcrumb">
                <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
                <li><a href="pos_line_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>"><?php echo Showmenu($menu_sub_id); ?></a></li>
                <li class="active"><?php echo $txt; ?></li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-12" id="content">
            <div class="groupdata" >
                <form id="frm-input" method="post" action="process/pos_line_process.php">
                    <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                    <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                    <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                    <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                    <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                    <input name="LINE_ID" type="hidden" id="LINE_ID" value="<?php echo $LINE_ID; ?>">
                    <input name="flagDup1" type="hidden" id="flagDup1">
                    <input name="flagDup2" type="hidden" id="flagDup2">
                    <input name="flagDup3" type="hidden" id="flagDup3">
                    <input name="flagDup4" type="hidden" id="flagDup4">
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ประเภทตำแหน่ง :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-2">
                        <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['type_pos'];?>" onChange="Chkrepeat(); get_line_group(this);">
                            <option value=""></option>
                            <?php   $i=1;
                            while($rec2 = $db->db_fetch_array($query_POS_TYPE)){?>
                            <option value="<?php echo $rec2['TYPE_ID']?>" <?php echo ($TYPE_ID== $rec2['TYPE_ID']?"selected":"");?>><?php echo text($rec2['TYPE_NAME_TH'])?></option>
                            <?php  $i++;}?>
                        </select>
                        </div>
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-2">สายงาน :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-sm-2">
                        <select id="LG_ID" name="LG_ID" class="selectbox form-control" placeholder="สายงาน" >
                            <option value=""></option>
                            <?php   $i=1;
                            while($rec_line = $db->db_fetch_array($query_line_group)){?>
                            <option value="<?php echo $rec_line['LG_ID']?>" <?php echo ($LG_ID== $rec_line['LG_ID']?"selected":"");?>><?php echo text($rec_line['LG_NAME_TH'])?></option>
                            <?php  $i++;}?>
                        </select>
                        </div>
                    </div>
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ชื่อตำแหน่งในสายงาน (ไทย) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-2">
                            <input id="LINE_NAME_TH" type="text" name="LINE_NAME_TH" class="form-control" maxlength="100" placeholder="ชื่อตำแหน่งในสายงานภาษาไทย" value="<?php echo $LINE_NAME_TH; ?>" onKeyUp="Chkrepeat();">
                        </div>
                        <div class="col-xs-12 col-sm-2"><span id="chkDup1" class="hidden-xs label"></span></div>
                        <div class="col-xs-12 col-sm-2">ชื่อย่อตำแหน่งในสายงาน (ไทย) :</div>
                        <div class="col-xs-12 col-md-2"><span id="chkDup3" class="col-xs-9 visible-xs label"></span><input id="LINE_SHORTNAME_TH" type="text" name="LINE_SHORTNAME_TH" class="form-control" placeholder="ชื่อย่อตำแหน่งในสายงานภาษาไทย" value="<?php echo $LINE_SHORTNAME_TH; ?>" ></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2">ชื่อตำแหน่งในสายงาน (อังกฤษ) :</div>
                        <div class="col-xs-12 col-md-2"><input id="LINE_NAME_EN" type="text" name="LINE_NAME_EN" class="form-control" maxlength="100" placeholder="ชื่อตำแหน่งในสายงานภาษาอังกฤษ" value="<?php echo $LINE_NAME_EN; ?>"onkeyup="Chkrepeat();"></div>
                        <div class="col-xs-12 col-sm-2"><span id="chkDup2" class=" hidden-xs label"></span></div>
                        <div class="col-xs-12 col-sm-2">ชื่อย่อตำแหน่งในสายงาน (อังกฤษ) :</div>
                        <div class="col-xs-12 col-md-2"><input id="LINE_SHORTNAME_EN" type="text" name="LINE_SHORTNAME_EN" class="form-control" placeholder="ชื่อย่อตำแหน่งในสายงานภาษาอังกฤษ" value="<?php echo $LINE_SHORTNAME_EN; ?>" ></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active']; ?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-6 col-md-1"><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS'] == '1' || $rec['ACTIVE_STATUS'] == '' ? "checked" : "") ?>> <?php echo $arr_act_status['1']; ?></div>
                        <div class="col-xs-6 col-md-1"><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS'] == '0' ? "checked" : "") ?>> <?php echo $arr_act_status['0']; ?></div>
                    </div>
                    
                    <div class="formlast">
                        <div class="col-xs-12 col-sm-12" align="center">
                            <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                            <button type="button" class="btn btn-default" onClick="self.location.href = 'pos_line_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>';">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;">
        <?php include($path . "include/footer.php"); ?>
    </div>
</body>
