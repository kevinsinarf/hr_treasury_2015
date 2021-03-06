<?php
$path = "../../";
include($path . "include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$TYPE_ID = $_POST['TYPE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";


$SQL_POS_TYPE ="SELECT TYPE_ID,TYPE_NAME_TH FROM SETUP_POS_TYPE WHERE ACTIVE_STATUS='1' and POSTYPE_ID = '1' AND DELETE_FLAG = '0' ORDER BY TYPE_SEQ ASC ";
$QUERY_POS_TYPE = $db->query($SQL_POS_TYPE);
$SQL_LEVEL ="SELECT LEVEL_ID, LEVEL_NAME_TH FROM SETUP_POS_LEVEL WHERE ACTIVE_STATUS='1' AND POSTYPE_ID = '1' AND DELETE_FLAG = '0' AND TYPE_ID = '".$TYPE_ID."' ORDER BY LEVEL_SEQ ASC ";
$QUERY_LEVEL = $db->query($SQL_LEVEL);
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
    <script src="js/pos_step_salary_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
    <div class="container-full">
        <div><?php include($path . "include/header.php"); ?></div>
        <div><?php include($path . "include/menu.php"); ?></div>
        <div class="col-xs-12 col-sm-12">
            <ol class="breadcrumb">
                <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
                <li><?php echo Showmenu($menu_sub_id); ?></li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-12" id="content">
            <div class="groupdata" >
                <form id="frm-input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
                    <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                    <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                    <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                    <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                    <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                    <input name="LINE_ID" type="hidden" id="LINE_ID" value="<?php echo $LINE_ID; ?>">
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-2">ประเภทตำแหน่ง :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-2">
                        <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="<?php echo $arr_txt['type_pos'];?>" onChange="get_level(this);">
                            <option value=""></option>
                            <?php   $i=1;
                            while($REC_TYPE = $db->db_fetch_array($QUERY_POS_TYPE)){?>
                            <option value="<?php echo $REC_TYPE['TYPE_ID']?>" <?php echo ($TYPE_ID== $REC_TYPE['TYPE_ID']?"selected":"");?>><?php echo text($REC_TYPE['TYPE_NAME_TH'])?></option>
                            <?php  $i++;}?>
                        </select>
                        </div>
                        <div class="col-xs-12 col-sm-3"></div>
                        <div class="col-xs-12 col-sm-2">ระดับ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-sm-2">
                        <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox form-control" placeholder="ระดับ" >
                            <option value=""></option>
                            <?php 
                            while($REC_LEVEL = $db->db_fetch_array($QUERY_LEVEL)){?>
                            <option value="<?php echo $REC_LEVEL['LEVEL_ID']?>" <?php echo ($LEVEL_ID == $REC_LEVEL['LEVEL_ID']?"selected":"");?>><?php echo text($REC_LEVEL['LEVEL_NAME_TH'])?></option>
                            <?php 
							}
							?>
                        </select>
                        </div>
                    </div>
                   <div class="row">
					<div class="col-xs-12 col-sm-3 col-md-12" align="center"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
				   </div>
                    
                    <div class="row head-form" style="margin-top:10px; margin-bottom:10px;">ระดับขั้นเงินเดือน</div>
                    <div class="table-responsive">
                     <?php
					  $QueryTitle = $db->query("SELECT * FROM SETUP_POS_SALARY_TITLE WHERE DELETE_FLAG = 0 ORDER BY SALARYTITLE_ID ASC");
					 ?>
                          <table class="table table-bordered table-striped table-hover">
                            <thead>
                              <tr class="bgHead">
                                <th width="10%"><div align="center"><strong><input name="chkAll" id="chkAll" type="checkbox" value="" onClick="checkbox_all();"></strong></div></th>
                                <th width="90%"><div align="center">ชื่อระดับขั้นเงินเดือน</div></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            while($RecTitle = $db->db_fetch_array($QueryTitle)){
								$SEL = "";
								$QueryStep = $db->query("SELECT SALARYTITLE_ID FROM SETUP_POS_STEP_SALARY WHERE TYPE_ID = '".$TYPE_ID."' AND LEVEL_ID = '".$LEVEL_ID."' AND SALARYTITLE_ID = '".$RecTitle['SALARYTITLE_ID']."' ");
                                $NumStep = $db->db_num_rows($QueryStep);
								if($NumStep > 0){
									$SEL = "CHECKED";
								}
                            ?>
                            <tr bgcolor="#FFFFFF">
                              <td align="center"><input name="SALARYTITLE_ID[<?php echo $RecTitle['SALARYTITLE_ID']; ?>]" <?php echo $SEL; ?> id="SALARYTITLE_ID_<?php echo $i; ?>" type="checkbox" value="<?php echo $RecTitle['SALARYTITLE_ID']; ?>"></td>
                              <td align="center"><?php echo  text($RecTitle["SALARYTITLE_NAME_TH"]); ?></td>
                            </tr>
                            <?php
                              $i++;
                            }
                            ?>
                            </tbody>
                       </table>
               	 </div>
                
                    <div class="formlast">
                        <div class="col-xs-12 col-sm-12" align="center">
                            <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                            <button type="button" class="btn btn-default" onClick="self.location.href = 'pos_step_salary_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>';">ยกเลิก</button>
                        </div>
                    </div>
                 
                </form>
            </div>
        </div>
    
    <div style="text-align:center; bottom:0px;">
        <?php include($path . "include/footer.php"); ?>
    </div>
 </div>
</body>
</html>