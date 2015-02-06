<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
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
$paramlink = url2code($link);
//POST
$HEIR_ID=$_POST['HEIR_ID'];
$PER_ID = $_POST['PER_ID'];

$txt = "เพิ่มข้อมูล"; 

$query_num = $db->query("SELECT TOP 1 * FROM PER_HEIRHIS WHERE PER_ID = '".$PER_ID."' ORDER BY HEIR_ID DESC ");
$num_heir = $db->db_num_rows($query_num);
if($num_heir > 0){
	$rec_old = $db->db_fetch_array($query_num);
	$txt_type_heir = "แบบที่ 2";
	$type_heir_val = 2;
}else{
	$txt_type_heir = "แบบที่ 1";
	$type_heir_val = 1;
}

$arr_type_salary = array(1 => 'เงินเดือน', 2 => 'เงินบำนาญรวมกับ ช.ค.บ.', 3 => 'เบี้ยหวัดรวมกับ ช.ค.บ.');
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
<script src="js/profile_heirhis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
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
      <li><a href="profile_heirhis_disp.php?<?php echo url2code($link2); ?>">ประวัติของผู้ถูกแสดงเจตนาให้รับบำเหน็จตกทอด</a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" >
    <br>
	<?php include ("tab_info.php"); ?>
	
      <form id="frm-input" method="post" action="process/profile_heirhis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="HEIR_TYPE_FORM" name="HEIR_TYPE_FORM" value="<?php echo $type_heir_val; ?>">
        <input type="hidden" id="HEIR_ID" name="HEIR_ID"  value="<?php echo $HEIR_ID; ?>">
       
        
        <div class="row head-form">ข้อมูลหนังสือแสดงเจตนาระบุตัวผู้รับบำเหน็จตกทอด</div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เขียนที่ : </div>
            <div class="col-xs-12 col-sm-7">
            	<input type="text" id="HEIR_WRITE" name="HEIR_WRITE" class="form-control " placeholder="เขียนที่" value="<?php echo text($rec['HEIR_WRITE']); ?>" >
            </div> 
        </div>	
         <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เมื่อวันที่ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2">
            	<div class="input-group">
                    <input type="text" id="HEIR_SDATE" name="HEIR_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec["HEIR_SDATE"]);?>">
                    <span class="input-group-addon datepicker" for="HEIR_SDATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
           <div class="col-xs-12 col-sm-2">ประเภทหนังสือแสดงเจตนา : </div>
           <div class="col-xs-12 col-sm-2"><?php echo $txt_type_heir; ?></div>  
        </div>	
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทรายได้ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2">
            	<?php  echo GetHtmlSelect('HEIR_TYPE_SALARY','HEIR_TYPE_SALARY',$arr_type_salary,'ประเภทรายได้',$rec['HEIR_TYPE_SALARY'],'','','1','',2);?>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
           <div class="col-xs-12 col-sm-2">เดือนละ : </div>
           <div class="col-xs-12 col-sm-2">
           	<input type="text" id="HEIR_SALARY" name="HEIR_SALARY" class="form-control number " placeholder="เดือนละ" value="<?php echo number_format($rec['HEIR_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" >
           </div>  
        </div>
         <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">รวมบุคคล : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2">
            	<input type="text" id="HEIR_TOTAL" name="HEIR_TOTAL" class="form-control number" placeholder="รวมบุคคล" value="<?php echo $rec['HEIR_TOTAL']; ?>" >
            </div>
            <?php if($type_heir_val == 2){ ?>
            <div class="col-xs-12 col-sm-1"></div>
           <div class="col-xs-12 col-sm-2">แทนหนังสือแสดงเจตนาลงวันที่ : </div>
           <div class="col-xs-12 col-sm-2">
           		<?php echo conv_date($rec_old['HEIR_SDATE'],'short');	?>
           </div>
           <?php } ?>
        </div>	
        
      <div class="col-xs-12 col-sm-12" align="center" style="margin-top:10px;">
        <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
        <button type="button" class="btn btn-default" 
        onClick="self.location.href='profile_heirhis_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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