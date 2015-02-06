<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;
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
$paramlink = url2code($link);

//POST
$PER_ID=$_POST['PER_ID'];
$REQUEST_ID=$_POST['REQUEST_ID'];

$txt = "เปลี่ยนแปลงข้อมูล";

//DATA NEW
$sql = "SELECT a.EDU_ID, a.PER_ID, a.EDU_SEQ, a.EL_ID, a.ED_ID, a.EM_ID, a.INS_ID, a.COUNTRY_ID, a.EDU_GPA, a.EDU_HORNOR, a.EDU_SDATE, a.EDU_EDATE, a.EDU_SCHOLARSHIP, a.EDU_TYPE, a.EDU_NOTE, CONVERT(DATE,b.REQUEST_DATETIME) as REQUEST_DATETIME, b.REQUEST_APP_DATE
FROM PER_EDUCATEHIS a 
INNER JOIN PER_REQUEST b ON a.REQUEST_ID = b.REQUEST_ID and a.PER_ID = b.PER_ID 
WHERE b.DELETE_FLAG = '0' AND b.REQUEST_ID = '".$REQUEST_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$PER_ID = $rec['PER_ID'];

//OLD DATA
$sql = "SELECT EDU_ID,PER_ID,EDU_SEQ,EL_ID,ED_ID,EM_ID,INS_ID,COUNTRY_ID,EDU_GPA,EDU_HORNOR,EDU_SDATE,EDU_EDATE,EDU_SCHOLARSHIP,EDU_TYPE, EDU_NOTE
FROM PER_EDUCATEHIS  where DELETE_FLAG = '0' AND ACTIVE_STATUS = '1' AND PER_ID = '".$PER_ID."' ";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

//สาขาวิชาเอก
$arr_edu_major=GetSqlSelectArray("EM_ID", "EM_NAME_TH", "SETUP_EDU_MAJOR", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "EM_NAME_TH");

//ระดับการศึกษา
$arr_edu_level=GetSqlSelectArray("EL_ID", "EL_NAME_TH", "SETUP_EDU_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "EL_NAME_TH");

//วุฒิการศึกษา
$arr_edu_degree=GetSqlSelectArray("ED_ID", "ED_NAME_TH", "SETUP_EDU_DEGREE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "ED_NAME_TH");

//สถาบันการศึกษา
$arr_edu_ins=GetSqlSelectArray("INS_ID", "INS_NAME_TH", "SETUP_EDU_INSTITUTE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "INS_NAME_TH");

//ประเทศ
$arr_country = GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "COUNTRY_NAME_TH");
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_approvehis_educatehis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="profile_approvehis.php?<?php echo url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li class="active">ประวัติการศึกษา</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_approvehis_educatehis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
        <input type="hidden" id="REQUEST_ID" name="REQUEST_ID"  value="<?php echo $REQUEST_ID; ?>">
         
   		<div class="clearfix"></div>
        <div class="row formSep">
            <div class="col-xs-2 col-sm-2">วันที่ขอเปลี่ยนแปลง&nbsp;:&nbsp;</div>
            <div class="col-xs-2 col-sm-2">
            	<?php echo conv_date($rec['REQUEST_DATETIME'],'short'); ?>				
            	<input type="hidden" id="REQUEST_DATETIME" name="REQUEST_DATETIME"  value="<?php echo conv_date($rec['REQUEST_DATETIME']); ?>">
            </div>
        </div>
        
        <div class="clearfix"></div>
        <div class="row formSep">
            <div class="col-xs-2 col-sm-2">วันที่อนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-2 col-sm-2">
                <div class="input-group">
                    <input type="text" id="REQUEST_APP_DATE" name="REQUEST_APP_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="">
                    <span class="input-group-addon datepicker" for="REQUEST_APP_DATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>						
            </div>
        </div>
        
        <div class="clearfix"></div>
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2">สาขาวิชาเอกเดิม : &nbsp; </div>
           	<div class="col-xs-12 col-sm-4"><?php  echo text($arr_edu_major[$data['EM_ID']]);?></div>
            
            <div class="col-xs-12 col-sm-2">สาขาวิชาเอกใหม่ : &nbsp; </div>
           	<div class="col-xs-12 col-sm-3"><?php  echo text($arr_edu_major[$rec['EM_ID']]);?></div>
        </div>
        
        <div class="clearfix"></div>
        <div class="row formSep">
           	<div class="col-xs-12 col-sm-2">ระดับการศึกษาเดิม : &nbsp; </div>
      		<div class="col-xs-12 col-sm-4"><?php  echo text($arr_edu_level[$data['EL_ID']]);?></div>
            <div class="col-xs-12 col-sm-2">ระดับการศึกษาใหม่ : &nbsp; </div>
      		<div class="col-xs-12 col-sm-3"><?php  echo text($arr_edu_level[$rec['EL_ID']]);?></div>
     	</div>
        
        <div class="clearfix"></div>
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2">วุฒิการศึกษาเดิม : &nbsp; </div>
          	<div class="col-xs-12 col-sm-4"><?php  echo text($arr_edu_degree[$data['ED_ID']]);?></div>
            <div class="col-xs-12 col-sm-2">วุฒิการศึกษาใหม่ : &nbsp; </div>
          	<div class="col-xs-12 col-sm-3"><?php  echo text($arr_edu_degree[$rec['ED_ID']]);?></div>
        </div>
        
        <div class="clearfix"></div>
        <div class="row formSep">
          	<div class="col-xs-12 col-sm-2">สถาบันการศึกษาเดิม : &nbsp; </div>
         	<div class="col-xs-12 col-sm-4"><?php  echo text($arr_edu_ins[$data['INS_ID']]);?></div>
            <div class="col-xs-12 col-sm-2">สถาบันการศึกษาใหม่ : &nbsp; </div>
         	<div class="col-xs-12 col-sm-3"><?php  echo text($arr_edu_ins[$rec['INS_ID']]);?></div>
     	</div>
        
        <div class="clearfix"></div>
    	<div class="row formSep">
    		<div class="col-xs-12 col-sm-2">ประเทศเดิม : &nbsp; </div>
            <div class="col-xs-12 col-sm-4"><?php  echo text($arr_country[$data['COUNTRY_ID']]);?></div>
            <div class="col-xs-12 col-sm-2">ประเทศใหม่ : &nbsp; </div>
            <div class="col-xs-12 col-sm-3"><?php  echo text($arr_country[$rec['COUNTRY_ID']]);?></div>
  		</div>
        
        <div class="clearfix"></div>
    	<div class="row formSep">
        	<div class="col-xs-12 col-sm-2">ผลการเรียนเฉลี่ยเดิม : </div>
       		<div class="col-xs-12 col-sm-4"><?php echo text(number_format($data['EDU_GPA'],2)); ?></div>
            <div class="col-xs-12 col-sm-2">ผลการเรียนเฉลี่ยใหม่ : </div>
       		<div class="col-xs-12 col-sm-3"><?php echo text(number_format($rec['EDU_GPA'],2)); ?></div>
        </div>
        
        <div class="clearfix"></div>
    	<div class="row formSep">
			<div class="col-xs-12 col-sm-2">สถานะของเกียรตินิยมเดิม : &nbsp; </div>
    		<div class="col-xs-12 col-sm-4"><?php echo ($arr_act_honor[$data['EDU_HORNOR']]); ?></div>
            <div class="col-xs-12 col-sm-2">สถานะของเกียรตินิยมใหม่ : &nbsp; </div>
    		<div class="col-xs-12 col-sm-3"><?php echo ($arr_act_honor[$rec['EDU_HORNOR']]); ?></div>
		</div>
        
        <div class="clearfix"></div>
		<div class="row formSep">
      		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่เริ่มศึกษาเดิม : </div>
            <div class="col-xs-12 col-sm-4"><?php echo conv_date($data["EDU_SDATE"],'short');?></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่เริ่มศึกษาใหม่ : </div>
            <div class="col-xs-12 col-sm-3"><?php echo conv_date($rec["EDU_SDATE"],'short');?>	</div>
        </div>
        
        <div class="clearfix"></div>
		<div class="row formSep">
      		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่สำเร็จการศึกษาเดิม : </div>
        	<div class="col-xs-12 col-sm-4"><?php echo conv_date($data["EDU_EDATE"],'short');?></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่สำเร็จการศึกษาใหม่ : </div>
        	<div class="col-xs-12 col-sm-3"><?php echo conv_date($rec["EDU_EDATE"],'short');?>	</div>
		</div>
        
        <div class="clearfix"></div>   
    	<div class="row formSep">
			<div class="col-xs-12 col-sm-2">สถานะของการได้รับทุนเดิม : &nbsp;</div>
        	<div class="col-xs-12 col-sm-4"><?php echo ($arr_scholarship[$data['EDU_SCHOLARSHIP']]);?></div>
			<div class="col-xs-12 col-sm-2">สถานะของการได้รับทุนใหม่ : &nbsp;</div>
        	<div class="col-xs-12 col-sm-3"><?php echo ($arr_scholarship[$rec['EDU_SCHOLARSHIP']]);?></div>
        </div>
        
        <div class="clearfix"></div>   
    	<div class="row formSep">
        	<div class="col-xs-12 col-sm-2">ประเภทของวุฒิการศึกษาเดิม : &nbsp; </div>
        	<div class="col-xs-12 col-sm-4"><?php echo ($arr_edu_type[$data['EDU_TYPE']]);?></div>
 			<div class="col-xs-12 col-sm-2">ประเภทของวุฒิการศึกษาใหม่ : &nbsp; </div>
        	<div class="col-xs-12 col-sm-3"><?php echo ($arr_edu_type[$rec['EDU_TYPE']]);?></div>
   		</div>
              
		<div class="row formSep">
			<div class="col-xs-12 col-sm-2">หมายเหตุเดิม : </div>
			<div class="col-xs-12 col-sm-4"><?php echo text($data['EDU_NOTE']); ?></div>
            <div class="col-xs-12 col-sm-2">หมายเหตุใหม่ : </div>
			<div class="col-xs-12 col-sm-3"><?php echo text($rec['EDU_NOTE']); ?></div>
		</div>
		
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">การอนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-4">
                <label ><input type="radio" id="REQUEST_RESULT2" name="REQUEST_RESULT" value="2" <?php echo $rec['REQUEST_RESULT']=='2' || $rec['REQUEST_RESULT']=='1' || $rec['REQUEST_RESULT']==''?'checked':'';?> >&nbsp;<?php echo $arr_request_result['2'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label ><input type="radio" id="REQUEST_RESULT3" name="REQUEST_RESULT" value="3" <?php echo $rec['REQUEST_RESULT']=='3'?'checked':'';?> >&nbsp;<?php echo $arr_request_result['3'];?></label>
            </div>
        </div>
        
        <div class="row formlast">
            <div class="col-xs-12 col-sm-12" align="center">
              <button type="button" class="btn btn-primary" onClick="chkApprove();">บันทึก</button>
              <button type="button" class="btn btn-default" onClick="self.location.href='profile_approvehis.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
            </div>
        </div>
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