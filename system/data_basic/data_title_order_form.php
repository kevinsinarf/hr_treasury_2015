<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$POSTYPE_ID=$_POST['POSTYPE_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

//DATA
if($proc == 'edit'){
  $sql = "select * from SETUP_MOVEMENT where MOVEMENT_ID = '".$MOVEMENT_ID."' ";
  $query = $db->query($sql);
  $rec = $db->db_fetch_array($query);
  $MOVEMENT_CODE = $rec['MOVEMENT_CODE'];
}else{
	$sql = "SELECT MAX(CAST(MOVEMENT_CODE AS INT)) AS MAX_CODE FROM SETUP_MOVEMENT ";
  	$query = $db->query($sql);
  	$rec = $db->db_fetch_array($query);
	$MOVEMENT_CODE = sprintf('%04d',$rec["MAX_CODE"]+1);
	
}
//ประเภทบุคลากร
$arr_pos=GetSqlSelectArray("POSTYPE_ID", "POSTYPE_NAME_TH", "SETUP_POSITION_TYPE", " DELETE_FLAG='0'", "POSTYPE_NAME_TH");

$arr_group = array( '1' => 'การดำรงตำแหน่ง' , '2' => 'เงินเดือน/ค่าจ้าง/ค่าตอบแทน' ,'3' => 'เงินรางวัลประจำปี' ,'4' => 'โทษทางวินัย' );
$arr_process = GetSqlSelectArray("MOVE_PROCESS_ID", "MOVE_PROCESS_NAME", "SETUP_MOVEMENT_PROCESS", " DELETE_FLAG='0' ", "MOVE_PROCESS_NAME");
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
<script src="js/data_title_order_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="data_title_order_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
			<!--<div class="row heading"><?php echo $txt;?></div>-->
            <form id="frm-input" method="post" action="process/data_title_order_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="MOVEMENT_ID" name="MOVEMENT_ID" value="<?php echo $MOVEMENT_ID; ?>">
                <input type="hidden" id="flagDup1" name="flagDup1">
                <input type="hidden" id="flagDup2" name="flagDup2">
                <div class="row head-form">ข้อมูลชื่อคำสั่ง</div>
                <div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">
					รหัส &nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-1">
                    <input type="text" id="MOVEMENT_CODE" name="MOVEMENT_CODE" class="form-control" placeholder="รหัส" value="<?php echo text($MOVEMENT_CODE); ?>" maxlength="4" onKeyUp="chkDup('chkDup1','flagDup1','MOVEMENT_CODE','MOVEMENT_ID','SETUP_MOVEMENT','');" >
                    </div> 
                    <span id="chkDup1" class="col-sm-2 hidden-xs label"></span>
				</div>          
				<div class="row formSep">
					<div class="col-xs-12 col-md-2" style="white-space:nowrap">ชื่อประเภทความเคลื่อนไหวภาษาไทย &nbsp;<span style="color:red;">*</span>&nbsp;</div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="MOVEMENT_NAME_TH" name="MOVEMENT_NAME_TH" class="form-control" placeholder="ชื่อประเภทความเคลื่อนไหวคำสั่งภาษาไทย" value="<?php echo text($rec["MOVEMENT_NAME_TH"]); ?>" maxlength="100" onKeyUp="chkDup('chkDup2','flagDup2','MOVEMENT_NAME_TH','MOVEMENT_ID','SETUP_MOVEMENT','');" >
                    </div> 
                    <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
                    <div class="col-xs-12 col-md-2" >ชื่อประเภทความเคลื่อนไหวภาษาอังกฤษ &nbsp;</div> 
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="MOVEMENT_NAME_EN" name="MOVEMENT_NAME_EN" class="form-control" placeholder="ชื่อประเภทความเคลื่อนไหวภาษาอังกฤษ" value="<?php echo text($rec["MOVEMENT_NAME_EN"]); ?>" maxlength="100" >
                    </div> 
				</div>
           
           <div class="row formSep">
           		<div class="col-xs-12 col-md-2" style="white-space:nowrap">หมวดหมู่ &nbsp;<span style="color:red;">*</span></div>
                <div class="col-xs-12 col-sm-3">
                     <?php echo GetHtmlSelect('MOVEMENT_GROUP','MOVEMENT_GROUP',$arr_group,'หมวดหมู่',$rec['MOVEMENT_GROUP'],'onchange="getProcess(this.value);"','','1','','2');?>
               </div>
               <div class="col-xs-12 col-sm-2"></div>
				<div class="col-xs-12 col-md-2" style="white-space:nowrap">กระบวนงาน &nbsp;<span style="color:red;">*</span></div>
				<div class="col-xs-12 col-sm-3">
    			  <?php echo GetHtmlSelect('MOVE_PROCESS_ID','MOVE_PROCESS_ID',$arr_process,'กระบวนงาน',$rec['MOVE_PROCESS_ID'],'','','1','','1');?>
                </div>
               </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2" style="white-space:nowrap">สำหรับประเภทบุคลากร &nbsp;<span style="color:red;">*</span></div>
                  <div class="col-xs-12 col-sm-3">
                      <?php echo GetHtmlSelect('POSTYPE_ID','POSTYPE_ID',$arr_pos,'สำหรับประเภทบุคลากร',$rec['POSTYPE_ID'],'','','1','','1');?>
                </div>
		      </div>            
                <div class="formlast">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='data_title_order_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
					</div>
                </div>                               
			</form>
        </div>
    </div>
    <div style="text-align:center;  width: 100%;
    height: 100px;
    position: relative;
    z-index: 1;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->