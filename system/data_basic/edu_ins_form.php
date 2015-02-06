<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$INS_ID=$_POST['INS_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

//DATA
$sql = "select * from SETUP_EDU_INSTITUTE where INS_ID = '".$INS_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$SQL_PROV = "SELECT PROV_ID ,PROV_TH_NAME as PROV_NAME FROM SETUP_PROV WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' order by PROV_TH_NAME asc";
$query_PROV = $db->query($SQL_PROV);

$SQL_COUNTRY = "SELECT COUNTRY_ID ,COUNTRY_NAME_TH as COUNTRY_NAME FROM SETUP_COUNTRY WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' order by COUNTRY_NAME_TH asc";
$query_COUNTRY = $db->query($SQL_COUNTRY);
$rec['COUNTRY_ID'] = $rec['COUNTRY_ID']==""?$default_country_id:$rec['COUNTRY_ID'];

$arr_ins_gree = array(
	'1' => 'สำหรับออกวุฒิการศึกษาทั่วไป',
	'2' => 'สำหรับออกวุฒิอื่น ๆ'
);
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
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
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
<script src="js/edu_ins.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="edu_ins.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
			<!--<div class="row heading"><?php echo $txt;?></div>-->
            <form id="frm-input" method="post" action="process/edu_ins_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="INS_ID" name="INS_ID" value="<?php echo $INS_ID; ?>">
                <input type="hidden" id="flagDup1" name="flagDup1">
                <input type="hidden" id="flagDup2" name="flagDup2">
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					<?php echo $arr_data['institute'];?> (<?php echo $arr_txt['th'];?>) </div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="INS_NAME_TH" name="INS_NAME_TH" class="form-control" placeholder="<?php echo $arr_data['institute'];?> (<?php echo $arr_txt['th'];?>)" value="<?php echo text($rec["INS_NAME_TH"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup1','flagDup1','INS_NAME_TH','INS_ID','SETUP_EDU_INSTITUTE','');">
                    </div> 
                    <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
				</div>
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					<?php echo $arr_data['institute'];?> (<?php echo $arr_txt['en'];?>)&nbsp;&nbsp;</div> 
					<div class="col-xs-12 col-md-3"><input type="text" id="INS_NAME_EN" name="INS_NAME_EN" class="form-control" placeholder="<?php echo $arr_data['institute'];?> (<?php echo $arr_txt['en'];?>)" value="<?php echo text($rec["INS_NAME_EN"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup2','flagDup2','INS_NAME_EN','INS_ID','SETUP_EDU_INSTITUTE','');"></div> 
                    <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
				</div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2"><?php echo $arr_data['country_name'];?> <span style="color:red;">*</span>&nbsp; </div>
                   <div class="col-xs-12 col-md-3">
                    <select id="COUNTRY_ID" name="COUNTRY_ID" class="selectbox form-control" placeholder="<?php echo $arr_data['country_name'];?>">
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_COUNTRY)){?>
                        <option value="<?php echo $rec1['COUNTRY_ID']?>" <?php echo ($rec1['COUNTRY_ID'] == $rec['COUNTRY_ID']?"selected":"");?>>
                        <?php echo text($rec1['COUNTRY_NAME'])?></option>
                      <?php }?>
                    </select>
                  </div>
                  
                  <div class="col-xs-12 col-md-1"></div>
                  <div class="col-xs-12 col-md-1">จังหวัด </div>
                  <div class="col-xs-12 col-md-3">
                    <select id="PROV_ID" name="PROV_ID" class="selectbox form-control" placeholder="จังหวัด">
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_PROV)){?>
                        <option value="<?php echo $rec1['PROV_ID']?>" <?php echo ($rec1['PROV_ID']== $rec['PROV_ID']?"selected":"");?>>
                        <?php echo text($rec1['PROV_NAME'])?></option>
                      <?php }?>
                    </select>
                  </div>
              </div>
              
                <div class="row formSep">
                	<div class="col-xs-12 col-md-2">ประเภทสถานศึกษา </div>
                  	<div class="col-xs-12 col-md-3">
                    <select id="INS_DEGREE" name="INS_DEGREE" class="selectbox form-control" placeholder="ประเภทสถานศึกษา">
					<option value=""></option>
					<?php foreach($arr_ins_gree as $key => $val){?>
					<option value="<?php echo $key?>" <?php echo ($rec['INS_DEGREE'] == $key && $rec['INS_DEGREE']!=''?"selected":"");?>><?php echo $val?></option><?php }?>
				</select></div>
                  
                  	<div class="col-xs-12 col-md-1"></div>
					<div class="col-xs-12 col-md-1" style="white-space:nowrap">ประเภทสถาบัน &nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-4 col-md-1">
						<label ><input type="radio" id="INS_TYPE1" name="INS_TYPE"  value="1" <?php echo ($rec['INS_TYPE']=='1'||$data['INS_TYPE']=='' ?"checked":"")?>> <?php echo $arr_ins_type['1'];?></label>
					</div>
					<div class="col-xs-4 col-md-1">
						<label ><input type="radio" id="INS_TYPE0" name="INS_TYPE" value="0" <?php echo ($rec['INS_TYPE']=='0'?"checked":"")?> > <?php echo $arr_ins_type['0'];?></label></div>
				</div>
                
                <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-4 col-md-1">
						<label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
					</div>
					<div class="col-xs-4 col-md-1">
						<label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
				</div>
                                
                <div class="formlast">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='edu_ins.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
                </div>                               
			</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->