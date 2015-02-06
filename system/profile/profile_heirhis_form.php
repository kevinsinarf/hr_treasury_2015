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
$path_a = '../fileupload/profile_his/';

//POST
$HEIR_ID=$_POST['HEIR_ID'];
$PER_ID = $_POST['PER_ID'];

$txt = (($proc == "edit") ? "แก้ไขข้อมูล":"เพิ่มข้อมูล"); 

$sql = "SELECT  * FROM PER_HEIRHIS  where DELETE_FLAG = '0' AND HEIR_ID = '".$HEIR_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$HEIR_TYPE_FORM = $rec['HEIR_TYPE_FORM'];
if($HEIR_TYPE_FORM == 2){
	$txt_type_heir = "แบบที่ 2";
}else{
	$txt_type_heir = "แบบที่ 1";
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
<script src="js/profile_heirhis_form.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_heirhis_disp.php?<?php echo url2code($link2); ?>">ประวัติของผู้ถูกแสดงเจตนาให้รับบำเหน็จตกทอด</a></li>
	  <li class="active">ข้อมูลหนังสือแสดงเจตนาระบุตัวผู้รับบำเหน็จตกทอด</li>
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
        <input type="hidden" id="HEIR_TYPE_FORM" name="HEIR_TYPE_FORM" value="<?php echo $HEIR_TYPE_FORM; ?>">
        <input type="hidden" id="HEIR_ID" name="HEIR_ID"  value="<?php echo $HEIR_ID; ?>">
        <input type="hidden" id="HEIRDESC_ID" name="HEIRDESC_ID"  >
        
        <div class="row head-form">ข้อมูลหนังสือแสดงเจตนาระบุตัวผู้รับบำเหน็จตกทอด</div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เขียนที่ : </div>
            <div class="col-xs-12 col-sm-7"><input type="text" id="HEIR_WRITE" name="HEIR_WRITE" class="form-control" placeholder="เขียนที่" value="<?php echo text($rec['HEIR_WRITE']); ?>" ></div> 
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
           <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2">ประเภทหนังสือแสดงเจตนา : </div>
           <div class="col-xs-12 col-sm-2"><?php echo $txt_type_heir; ?></div>  
        </div>	
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทรายได้ : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect('HEIR_TYPE_SALARY','HEIR_TYPE_SALARY',$arr_type_salary,'ประเภทรายได้',$rec['HEIR_TYPE_SALARY'],'','','1','',2);?></div>
            <div class="col-xs-12 col-sm-2"></div>
           <div class="col-xs-12 col-sm-2">เดือนละ : </div>
           <div class="col-xs-12 col-sm-2"><input type="text" id="HEIR_SALARY" name="HEIR_SALARY" class="form-control number " placeholder="เดือนละ" value="<?php echo number_format($rec['HEIR_SALARY'],2); ?>" onBlur="NumberFormat(this,2)" ></div>  
         </div>
         
         <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">รวม (คน) : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2"><input type="text" id="HEIR_TOTAL" name="HEIR_TOTAL" class="form-control number" placeholder="รวม (คน)" value="<?php echo $rec['HEIR_TOTAL']; ?>" ></div>
            <?php if($HEIR_TYPE_FORM == 2){ ?>
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-2">แทนหนังสือแสดงเจตนาลงวันที่ : </div>
            <div class="col-xs-12 col-sm-2"><?php echo conv_date($rec['HEIR_SDATE_REPLACE'],'short');	?></div>
            <?php } ?>
        </div>
        
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ไฟล์แนบ : </div>
            <div class="col-xs-12 col-sm-3">
                <div class="input-group"  >
                    <input type="file" id="HEIR_FILLE" name="HEIR_FILLE"  class="form-control" placeholder="ไฟล์แนบ" value="<?php echo text($rec['HEIR_FILLE']); ?>">
                    <?php echo displayDownloadFileAttach($path_a,$rec['HEIR_FILLE'],$arr_txt['download']);?>
                </div>
                <input type="hidden" id="OLD_HEIR_FILLE" name="OLD_HEIR_FILLE"   value="<?php echo !empty($rec["HEIR_FILLE"])?text($rec["HEIR_FILLE"]):""; ?>">
            </div>						
        </div>	
        					
        <div class="row head-form">
          <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
              <a data-toggle="collapse" data-parent="#accordion" href="#collapse" onClick="$('.switchPic').toggle();">
                  <img class="switchPic" src="<?php echo $path;?>images/exp.gif" style="display:none;" >
                  <img class="switchPic" src="<?php echo $path;?>images/clse.gif" >
                 ข้อมูลผู้ถูกแสดงเจตนารับบำเหน็จตกทอด
              </a>
          </div>
      </div>
      
        <div id="collapse" class="collapse in">
          <?php if($rec['ACTIVE_STATUS'] == 1){ ?>
            <div  style="text-align:left; margin-top:5px; margin-bottom:5px; "> 
                <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addPerData();">
                <?php echo $img_save;?> เพิ่มผู้ถูกแสดงเจตนา</a> 
            </div>
          <?php } ?>
        	<div class="table-responsive" style="margin-top:5px;">
            	<table class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                  <thead>
                      <tr class="bgHead">
                          <th width="4%"><div align="center"><strong>ลำดับ</strong></div></th>
                          <th width="18%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                          <th width="40%"><div align="center"><strong>ที่อยู่</strong></div></th>
                          <th width="25%"><div align="center"><strong>เบอร์โทรศัพท์</strong></div></th>
                          <th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
				  $sql ="SELECT HEIRDESC_ID, PREFIX_ID, HEIRDESC_FIRSTNAME_TH, HEIRDESC_MIDNAME_TH, HEIRDESC_LASTNAME_TH, ADDRESS_HOME_NO, ADDRESS_TAMB_ID, ADDRESS_AMPR_ID
				  ADDRESS_PROV_ID, ADDRESS_ZIPCODE, ADDRESS_TEL, ADDRESS_TEL_EXT, ADDRESS_MOBILE, B.TAMB_NAME_TH, C.AMPR_NAME_TH, D.PROV_TH_NAME
				  FROM PER_HEIRHIS_DESC A
				  LEFT JOIN SETUP_TAMB B ON A.ADDRESS_TAMB_ID = B.TAMB_ID 
				  LEFT JOIN SETUP_AMPR C ON A.ADDRESS_AMPR_ID = C.AMPR_ID 
				  LEFT JOIN SETUP_PROV D ON A.ADDRESS_PROV_ID = D.PROV_ID
				  WHERE HEIR_ID = '".$HEIR_ID. "' order by HEIRDESC_FIRSTNAME_TH ASC ";
				  $query = $db->query($sql);
				  $numper = $db->db_num_rows($query);
				  $i =1;
				  if($numper > 0){
				  	while($rec_per = $db->db_fetch_array($query)){
					if($rec['ACTIVE_STATUS'] == 1){
						$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editDataPer('".$rec_per["HEIRDESC_ID"]."');\">".$img_edit." แก้ไข</a> ";
						$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delDataPer('".$rec_per["HEIRDESC_ID"]."');\">".$img_del." ลบ</a> ";
					}else{
						$edit = '';
						$delete = '';
					}
						$NAME = Showname($rec_per["PREFIX_ID"],$rec_per["HEIRDESC_FIRSTNAME_TH"],$rec_per["HEIRDESC_MIDNAME_TH"],$rec_per["HEIRDESC_LASTNAME_TH"]);
				  ?>
                  <tr bgcolor="#FFFFFF">
                    <td align="center" valign="top"><?php echo $i+$goto;?></td>
                    <td align="left" valign="top"><?php echo $NAME;?>&nbsp;</td>
                    <td align="left" valign="top">
                    	<div> <strong> บ้านเลขที่ : </strong><?php echo text($rec_per['ADDRESS_HOME_NO']); ?></div>
                        <div> <strong> ตำบล/แขวง : </strong><?php echo text($rec_per['TAMB_NAME_TH']); ?></div>
                        <div> <strong> อำเภอ/เขต : </strong><?php echo text($rec_per['AMPR_NAME_TH']); ?></div>
                        <div> <strong> จังหวัด : </strong><?php echo text($rec_per['PROV_TH_NAME']); ?></div>
                        <div> <strong> รหัสไปรษณีย์ : </strong><?php echo text($rec_per['ADDRESS_ZIPCODE']); ?></div>
                    </td>
                    <td align="left" valign="top">
                    	<div> <strong> หมายเลขโทรศัพท์ : </strong><?php echo format_phone($rec_per['ADDRESS_TEL'],"tel","bk",$rec_per['ADDRESS_TEL_EXT']);  ?></div>
                        <div> <strong> หมายเลขโทรศัพท์เคลื่อนที่ : </strong><?php echo format_phone($rec_per['ADDRESS_MOBILE'],"mobile","bk",''); ?></div>
                    </td>
                    <td align="center" valign="top"><?php echo $edit.$delete; ?></td>
                </tr>
                  <?php
				    $i++;
				  	}
				  }else{
					  echo "<tr><td align=\"center\" colspan=\"5\">ไม่พบข้อมูล</td></tr>";
				  }
				  ?>
                  </tbody>
                 </table>
                <input type="hidden" name="count_per" id="count_per" value="<?php echo ($i-1); ?>" >
            </div>
        </div> 
      <?php if($rec['ACTIVE_STATUS'] == 1){ ?>
      <div class="col-xs-12 col-sm-12" align="center" style="margin-top:10px;">
        <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
        <button type="button" class="btn btn-default" 
        onClick="self.location.href='profile_heirhis_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
      </div>
      <?php } ?>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>