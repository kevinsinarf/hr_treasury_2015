<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;

$page_back = "skill_year_disp.php";

//POST
$SKILLSET_ID=$_POST['SKILLSET_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT * FROM SKILL_SET  where DELETE_FLAG = '0' AND SKILLSET_ID = '".$SKILLSET_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '1'", "TYPE_NAME_TH");

$arr_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND TYPE_ID = '".$data['TYPE_ID']."'", "LEVEL_NAME_TH");

$arr_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND TYPE_ID = '".$data['TYPE_ID']."'", "LINE_NAME_TH");

$arr_skill_title=GetSqlSelectArray("SKILLTITLE_ID", "SKILLTITLE_NAME_TH", "SKILL_TITLE", "ACTIVE_STATUS='1' AND SKILL_TYPE = 2 and DELETE_FLAG='0'", "SKILLTITLE_NAME_TH");
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
<script src="js/knowledge_year.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/knowledge_year_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="SKILLSET_ID" name="SKILLSET_ID"  value="<?php echo $SKILLSET_ID; ?>">
		<div class="clearfix"></div>
		<div class="row formSep">
             <div class="col-xs-12 col-sm-3" >ปีที่ใช้หัวข้อความรู้ <span style="color:red;">*</span>&nbsp;</div>
             <div class="col-xs-12 col-sm-3"><select id="SKILLSET_YEAR" name="SKILLSET_YEAR" style="width:300px;" class="selectbox form-control" placeholder="ปีที่ใช้หัวข้อความรู้" onChange="Chkrepeat();">
              <option value=""></option>
			  <?php for($Y=($YEAR_PRESENT-10);$Y<=($YEAR_PRESENT+2);$Y++){//select ปี
								$A_CONFIG_YEAR[$Y] = $Y; ?>
                <option value="<?php echo $Y; ?>"<?php echo ($Y == $data['SKILLSET_YEAR'] ? "selected" : ""); ?> onChange="chkDup('chkDup1','flagDup1','SKILLSET_YEAR','SKILLSET_ID','SETUP_CRIME_SUB','SKILLSET_ID='+$('#SKILLSET_ID').val());"><?php echo $Y; ?></option><?php } ?></select></div>
        </div>
		
		<div class="row formSep">
			<div class="col-xs-12 col-md-3">ชื่อหัวข้อความรู้จำเป็นในงาน : <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-xs-12 col-md-3">
				<?php 
						echo GetHtmlSelect('SKILLTITLE_ID','SKILLTITLE_ID',$arr_skill_title,ชื่อหัวข้อความรู้จำเป็นในงาน,$data['SKILLTITLE_ID'],'onChange=\'Chkrepeat();\' ','','1');
				?></div>
                <span id="chkDup2" class="col-sm-2 hidden-xs label"></span>
                <input type="hidden" id="flagDup2" name="flagDup2" >
                </div>
			<div class="row formSep">
			<div class="col-xs-12 col-md-3" style="white-space:nowrap;">ค่าวามคาดหวัง : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-md-3">
				<input type="text" id="SKILLSET_EXPECT" name="SKILLSET_EXPECT" class="form-control number" placeholder="ค่าวามคาดหวัง" value="<?php echo text($data["SKILLSET_EXPECT"]); ?>"></div>
                <div class="col-xs-12 col-md-2">ประเภทตำแหน่งข้าราชการ : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3">
				<?php 
						echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,ประเภทตำแหน่งข้าราชการ,$data['TYPE_ID'],'onchange="getLevel(this,\'LEVEL_ID\');get_line(this.value);"','','1');
				?></div>
			</div>
                <div class="row formSep">
				<div class="col-xs-12 col-md-3" style="white-space:nowrap">ระดับตำแหน่ง : <span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-md-3"><span id='p_level'>
                      <?php  
                      echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_level,'ระดับตำแหน่ง',$data['LEVEL_ID'],'onchange="getLine(this,this.value,\'LINE_ID\')"','','1');
					  ?>
                      </span></div>
                      <div class="col-xs-12 col-md-2">ตำแหน่งในสายงาน : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3"><span id='p_line'>
				<?php 
						echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_line,ตำแหน่งในสายงาน,$data['LINE_ID'],'','','1');
				?>
                </span></div>
			</div>

		<div class="clearfix"></div><br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='skill_year_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <div class="clearfix"></div>
        <br>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>