<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT = 5;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

$field="ORG_ID_1,ORG_ID_2,ORG_ID_3,ORG_ID_4,ORG_ID_5,SCHOLAR_COURSE_NAME,SCHOLAR_FUND_AMOUNT,SCHOLAR_SDATE,SCHOLAR_GPA,SCHOLAR_EDATE,SCHOLAR_FUND_NAME,SCHOLAR_FUND_TYPE,SCHOLAR_PROJECT_NAME,a.EL_ID,a.TYPE_ID,
b.EL_NAME_TH,c.ED_NAME_TH,e.INS_NAME_TH,d.EM_NAME_TH,f.COUNTRY_NAME_TH,g.TYPE_NAME_TH,h.LEVEL_NAME_TH,i.LINE_NAME_TH,j.MANAGE_NAME_TH";
$table="PER_SCHOLARHIS a 
LEFT JOIN SETUP_EDU_LEVEL b ON a.EL_ID = b.EL_ID
LEFT JOIN SETUP_EDU_DEGREE c ON a.ED_ID = c.ED_ID
LEFT JOIN SETUP_EDU_MAJOR d ON a.EM_ID = d.EM_ID
LEFT JOIN SETUP_EDU_INSTITUTE e ON a.INS_ID = e.INS_ID
LEFT JOIN SETUP_COUNTRY f ON a.COUNTRY_ID = f.COUNTRY_ID
LEFT JOIN SETUP_POS_TYPE g ON a.TYPE_ID = g.TYPE_ID
LEFT JOIN SETUP_POS_LEVEL h ON a.LEVEL_ID = h.LEVEL_ID
LEFT JOIN SETUP_POS_LINE i ON a.LINE_ID = i.LINE_ID 
LEFT JOIN SETUP_POS_MANAGE j ON a.MANAGE_ID = j.MANAGE_ID
";

$sql = "select ".$field." from ".$table." where a.SCHOLAR_ID = '".$SCHOLAR_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' AND DELETE_FLAG='0' ", "ORG_NAME_TH");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
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
<script src="js/profile_scholar.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
   <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  		<li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  		<li><a href="profile_scholar.php?<?php echo url2code($link2);?>">ประวัติการการรับทุน</a></li>
	  		<li class="active"><?php echo "แสดงประวัติการรับทุนการศึกษา";?></li>
		</ol>
	</div>
  <div class="col-xs-12 col-sm-12" id="content">
    <?php include("tab_profile.php");?>
    <div class="grouptab">
      <?php include("tab_info.php");?>
      <div class="clearfix"></div>
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="SCHOLAR_ID" name="SCHOLAR_ID" value="<?php echo $SCHOLAR_ID;?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="EL_ID" name="EL_ID" value="<?php echo $EL_ID ?>">
		
        <div class="row head-form">ประวัติการได้รับทุน</div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">โครงการ : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['SCHOLAR_PROJECT_NAME']); ?></div>
            <div class="col-xs-12 col-sm-1"></div>
        </div>		
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หลักสูตร : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['SCHOLAR_COURSE_NAME']); ?></div> 
            <div class="col-xs-12 col-sm-1"></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับการศึกษา :</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['EL_NAME_TH']); ?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วุฒิการศึกษา :</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['ED_NAME_TH']); ?></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สาขาวิชา : </div>
            <div class="col-xs-12 col-sm-3"><?php  echo text($data['EM_NAME_TH']);?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเทศ : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['COUNTRY_NAME_TH']); ?></div> 
        </div>
        
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถาบันการศึกษา : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['INS_NAME_TH']); ?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทแหล่งทุน : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['SCHOLAR_FUND_TYPE']); ?></div>
        </div>
        
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">แหล่งทุน : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['SCHOLAR_FUND_NAME']); ?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">จำนวนทุน (บาท) : </div>
            <div class="col-xs-12 col-sm-3"><?php echo number_format($data['SCHOLAR_FUND_AMOUNT'],2); ?></div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่ศึกษาต่อตั้งแต่ : </div>
            <div class="col-xs-12 col-sm-3"><?php echo  conv_date($data["SCHOLAR_SDATE"]);?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ถึง : </div>
            <div class="col-xs-12 col-sm-3"><?php echo  conv_date($data["SCHOLAR_EDATE"]);?></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ผลการเรียนเฉลี่ย  : &nbsp;</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['SCHOLAR_GPA']); ?></div>
        </div>

        <div class="row head-form"> ข้อมูลตำแหน่งขณะที่แลกเปลี่ยนบุคลากรระหว่างหน่วยงาน</div>
			
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_org[$data['ORG_ID_1']]);?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม/สำนักงาน : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_org[$data['ORG_ID_2']]);?></div> 
        </div>
		
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สำนัก/กลุ่ม/กอง : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_org[$data['ORG_ID_3']]);?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กลุ่มงาน/ส่วน : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_org[$data['ORG_ID_4']]);?></div> 
        </div>
		
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ฝ่าย : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_org[$data['ORG_ID_5']]);?></div>
        </div>
		
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['TYPE_NAME_TH']);?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับ : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['LEVEL_NAME_TH']);?></div> 
        </div>
		
		<div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['LINE_NAME_TH']);?></div> 
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งทางการบริหาร : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($data['MANAGE_NAME_TH']);?></div> 
        </div>
        
        <div class="formlast">
            <div class="col-xs-12 col-md-12" align="center">
                <button type="button" class="btn btn-default" onClick="self.location.href='profile_scholar.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
            </div>
        </div>		
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>