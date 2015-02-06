
<?php
$path = "../../";
include($path."include/config_header_top.php");
 //echo "test: "; print_r($_POST); exit();
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link);

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

//POST
$CERTIFICATE_ID=$_POST['CERTIFICATE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

//DATA
$CERTHIS_ID = (int)$_POST['CERTHIS_ID'];
if($proc=="edit"){     

	$sql = "select CERTHIS_NO,CERTHIS_DATE,CERTIFICATE_ID,CERTHIS_ID,CERTIFICATE_BY  from PER_CERTIFICATEHIS WHERE CERTHIS_ID = ".$CERTHIS_ID."    "; 
	$query = $db->query($sql);
	$rec_edit = $db->db_fetch_array($query);
}
$sql = "select CERTIFICATE_ID, CERTIFICATE_NAME_TH from SETUP_CERTIFICATE WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ";
   

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
<script src="js/data_profess_licensing.js?<?php echo rand(); ?>"></script>
</head>
<body>  
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="professional_licensing.php?<?php echo url2code($link2); ?>">ประวัติประกอบวิชาชีพ</a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content" >
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
            <form id="frm-input" method="post" action="process/data_process_licensing_process.php">
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
                <?php if($proc=="edit"){    ?>
                <input type="hidden" id="CERTHIS_ID" name="CERTHIS_ID" value="<?php echo $rec_edit['CERTHIS_ID']; ?>">
                <?php } ?>
                <input type="hidden" id="flagDup1" name="flagDup1">
                <input type="hidden" id="flagDup2" name="flagDup2">
                
        	   <div class="row head-form">ข้อมูลประวัติประกอบวิชาชีพ </div>
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่ใบอุนุญาติ <span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-md-3">
                      <input type="text" id="CERTHIS_NO" name="CERTHIS_NO" class="form-control" placeholder="เลขที่ใบอุนุญาติ" value="<?php echo $rec_edit['CERTHIS_NO']; ?>" maxlength="20"   >
                      </div>
                      <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผลบังคับใช้ <span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-md-2">
                         <div class="input-group">
                           <input type="text" id="CERTHIS_DATE" name="CERTHIS_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec_edit['CERTHIS_DATE']); ?>">
                            <span class="input-group-addon datepicker" for="CERTHIS_DATE" >&nbsp;
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                         </div>                   
                  </div>
				</div>
                <div class="row formSep">
                	<div class="col-xs-12 col-md-2">ใบประกอบวิชาชีพ <span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-3">
                    	<?php  
                        echo get_Select($sql ,$db , array(
                          'id'=>'CERTIFICATE_ID',
                          'name'=>'CERTIFICATE_ID',
                          'class'=>'form-control selectbox',
                          's_selected'=>$rec_edit['CERTIFICATE_ID'],
                          's_defualt'=>'',
                          's_key'=>'CERTIFICATE_ID', 
                          's_value'=>'CERTIFICATE_NAME_TH',
                          's_onchage'=>'',
                          's_placeholder'=>'ใบประกอบวิชาชีพ',
                          's_style'=>""
                          )
                        ); 
					 ?>
                    </div>
                     <div class="col-xs-12 col-md-1" ></div>
                    <div class="col-xs-12 col-md-2" >หน่วยงานที่ออกให้ <span style="color:red;">*</span></div>
					<div class="col-xs-12 col-md-3">
                    <input type="text" id="CERTIFICATE_BY" name="CERTIFICATE_BY" class="form-control" placeholder="หน่วยงานที่ออกให้" value="<?php echo $rec_edit['CERTIFICATE_BY']; ?>" maxlength="255"   >
                    </div>
                </div>
				
                <div class="col-xs-12 col-sm-12" align="center" style="margin-top:150px;">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="self.location.href='professional_licensing.php?<?php echo url2code($link2); ?>';">ยกเลิก</button>
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