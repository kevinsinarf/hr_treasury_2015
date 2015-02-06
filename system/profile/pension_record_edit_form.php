<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//POST
$PENSION_ID = $_POST['PENSION_ID'];
$S_PENSION_IDCARD = trim($_POST['S_PENSION_IDCARD']);
//$ARR = CalAgePension('2012-09-30','2014-05-09');

if($proc == 'edit'){
	$query = $db->query("SELECT TOP 1  * FROM PENSION_MAIN A 
	                             JOIN SETUP_POSITION_TYPE B ON A.POSTYPE_ID = B.POSTYPE_ID 
								WHERE A.PENSION_ID = '".$PENSION_ID."' AND A.DELETE_FLAG = 0 ORDER BY PENSION_TIME DESC ");
	$num  = $db->db_num_rows($query);
	$QueryMain = $query;
	$rec_main  = $db->db_fetch_array($QueryMain);
	$query_per = $db->query("SELECT * FROM PER_PROFILE WHERE PER_ID = '".$rec_main['PER_ID']."' ");
	$rec_per = $db->db_fetch_array($query_per);
	
	
	//PER_PROFILE 
	$name =  Showname($rec_per["PREFIX_ID"],$rec_per["PER_FIRSTNAME_TH"],$rec_per["PER_MIDNAME_TH"],$rec_per["PER_LASTNAME_TH"]);
	$POSTYPE_NAME = text($rec_main['POSTYPE_NAME_TH']);
	$PER_ID = $rec_main['PER_ID'];
	$PENSION_ID = $rec_main['PENSION_ID'];
	$SEX = $arr_gender[$rec_per['PER_GENDER']];
	$PER_DATE_ENTRANCE = $rec_main['PENSION_DATE_ENTRANCE'];
	$PER_DATE_RETIRE = $rec_main['PENSION_DATE_RETIRE'];
	$PER_DATE_RESIGN = $rec_main['PENSION_DATE_RESIGN'];
	$PER_STATUS_PENALTY = $rec_per['PER_STATUS_PENALTY'];
	$PER_SALARY = $rec_main['PENSION_SALARY'];
	$SDATE_NOW = $rec_main['PENSION_DATE_ENTRANCE'];
	if(trim($PER_DATE_RESIGN) != ''){
		$EDATE_NOW = $PER_DATE_RESIGN;  
	}else{
		$EDATE_NOW = $PER_DATE_RETIRE;  
	}
	
	
	
	if(trim($PER_DATE_ENTRANCE)!=""){
		$AgeGovDate = date ("Y-m-d", strtotime("+25 YEAR", strtotime($PER_DATE_ENTRANCE)));
	}else{
		$AgeGovDate = '';
	}
	
	if($rec_main['PENSION_TYPE_RESIGN'] == 6){
		$arr_type_pension = array(3 => 'บำเหน็จตกทอด');
	}else{
		$arr_type_pension = array(1 => 'บำเหน็จ', 2 => 'บำนาญ', 3 => 'บำเหน็จตกทอด');
	}
}



$sql_arr_family = "SELECT FAMILY_ID, FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH FROM PER_FAMILY WHERE PER_ID = '".$PER_ID."' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND FAMILY_RELATIONSHIP <= 5 ORDER BY FAMILY_FIRSTNAME_TH ASC ";
$query_arr_family = $db->query($sql_arr_family);
while($rec_arr_family = $db->db_fetch_array($query_arr_family)){
	$arr_family[$rec_arr_family['FAMILY_ID']] = Showname($rec_arr_family["FAMILY_PREFIX_ID"],$rec_arr_family["FAMILY_FIRSTNAME_TH"],$rec_arr_family["FAMILY_MIDNAME_TH"],$rec_arr_family["FAMILY_LASTNAME_TH"]); 
}


$arr_resign = array(1 => 'ลาออก', 2 => 'เกษียณอายุราชการ', 3 => 'เกษียณอายุราชการก่อนกำหนด', 4 => 'โทษทางวินัย', 5 => 'เหตุตามมาตร 83', 6 => 'เสียชีวิต' );
$arr_pension_type = array(1 => 'บำเหน็จ', 2 => 'บำนาญ', 3 => 'บำเหน็จตกทอด');
$arr_receiver = array(1 => 'ทายาทโดยชอบด้วยกฏหมาย', 2 => 'ผู้ถูกแสดงเจตนารับบำเหน็จจทอด');
$arr_receive_type = array(1 => 'เจ้าตัว', 2 => 'ทายาทโดยชอบด้วยกฎหมาย', 3 => 'ผู้จัดการมรดก');
$arr_delegate_type = array(1 => 'เจ้าตัว', 2 => 'ผู้เสมือนไร้ความสามารถ', 3 => 'ผู้ไร้ความสามารถ', 4 => 'ผู้เยาว์');
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND PROV_ID = '".$rec_main['ADDRESS_PROV_ID']."' ", "AMPR_NAME_TH");
$arr_ampr_died =GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND PROV_ID = '".$rec_main['DIED_PROV_ID']."' ", "AMPR_NAME_TH");
$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND AMPR_ID = '".$rec_main['ADDRESS_AMPR_ID']."' ", "TAMB_NAME_TH");
$arr_gender = array( '1' => 'ชาย', '2' => 'หญิง');




//PENSION_MAIN

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
<script src="js/pension_record_edit_form.js?<?php echo rand(); ?>"></script>
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
      <li><a href="pension_record_disp.php?<?php echo url2code($link2); ?>">บันทึกข้อมูลการขอบำเหน็จบำนาญ (ข้าราชการ)</a></li>
	   <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" >
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
       <input type="hidden" id="PER_ID" name="PER_ID"  value="<?php echo $PER_ID; ?>">
        <input type="hidden" id="PENSION_ID" name="PENSION_ID"  value="<?php echo $PENSION_ID; ?>">
         
        <div class="panel-group" id="accordion"> 
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                        <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                       ข้อมูลทั่วไปของผู้มีสิทธิขอรับบำเหน็จบำนาญ
                    </a>
                </div>
            </div>
            <div id="collapse1" class="collapse in">
              
               <div class='row formSep'>
                <div class='col-xs-12 col-md-2' style='white-space:nowrap;'><?php echo $arr_txt['idcard']; ?> :</div>
                <div class='col-xs-12 col-md-3'><?php echo get_idCard($rec_per['PER_IDCARD']);?></div> 
              </div>
               <div class='row formSep'>
                <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>ชื่อ-สกุล :</div>
                <div class='col-xs-12 col-md-3'><?php echo $name;?></div> 
              </div>
              <div class='row formSep'>
                  <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>ประเภทบุคลากร :</div>
                  <div class='col-xs-12 col-md-3'><?php echo $POSTYPE_NAME ; ?></div>
                  <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>เพศ :</div>
                  <div class='col-xs-12 col-md-3'><?php echo $SEX  ?></div>
              </div>
              <div class='row formSep'>
                  <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>วันเดือนปีอายุราชการครบ 25 ปี :</div>
                  <div class='col-xs-12 col-md-3'>
				  <?php echo conv_date($AgeGovDate,'short');?>
                  </div>
                  <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>วันเดือนปีที่เกษียณอายุราชการ :</div>
                  <div class='col-xs-12 col-md-3'><?php echo conv_date($PER_DATE_RETIRE,'short'); ?></div>
              </div>
              <div class='row formSep'>
                  <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>วันที่ออกจากราชการ :</div>
                  <div class='col-xs-12 col-md-3'><?php echo conv_date($PER_DATE_RESIGN,'short'); ?></div>
                  <div class='col-xs-12 col-md-2' style='white-space:nowrap;'>สาเหตุที่ออกจากราชการ:</div>
                  <div class='col-xs-12 col-md-3'><?php echo $arr_per_status[$rec_per['PER_STATUS']]; ?></div>
              </div>
              <div class='row formSep'>
                 <div class="col-xs-12 col-md-2" >สถานะอยู่ระหว่างดำเนินการวินัย:</div>
                 <div class="col-xs-12 col-md-2"><?php echo $arr_status_moveup[$PER_STATUS_PENALTY];?></div>
                 <div class="col-xs-12 col-md-1"></div>
                 <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ครั้งที่เสนอขอรับ :&nbsp;<span style="color:red;">*</span></div>
               	 <div class="col-xs-12 col-md-1">
                    	<input type="text" id="PENSION_TIME" name="PENSION_TIME" class="form-control number" value="<?php echo $rec_main['PENSION_TIME']; ?>" readonly >
                    </div>
               </div>
                <div class="row formSep">
                	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่เสนอเรื่อง :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
						<div class="input-group">
                            <input type="text" class="form-control col-md-13" name="PENSION_DATE" id="PENSION_DATE" value="<?php echo conv_date($rec_main['PENSION_DATE']);?>" placeholder="DD/MM/YYYY">
                            <span class="input-group-addon datepicker" for="PENSION_DATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะการเป็นสมาชิก กบข. :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
					<?php echo GetHtmlSelect('PENSION_TYPE_GPF','PENSION_TYPE_GPF',$arr_gpf,'สถานะการเป็นสมาชิก กบข',$rec_main['PENSION_TYPE_GPF'],"onChange='GetContent();' ",'','1','','2');?>
                    </div>
                 </div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาเหตุที่ออกจากราชการ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
					<?php echo GetHtmlSelect('PENSION_TYPE_RESIGN','PENSION_TYPE_RESIGN',$arr_resign,'สาเหตุที่ออกจากราชการ',$rec_main['PENSION_TYPE_RESIGN'],"onChange='GetPension();' ",'','1','','2');?>
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">เหตุแห่งบำเหน็จบำนาญ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
					<?php echo GetHtmlSelect('PENSION_TYPE_REQUEST_CIVIL','PENSION_TYPE_REQUEST_CIVIL',$arr_pension_request,'เหตุแห่งบำเหน็จบำนาญ',$rec_main['PENSION_TYPE_REQUEST_CIVIL'],'','','1','','2');?>
                    </div>
                </div>
        		<div class="row formSep">
                  <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทการขอรับ :&nbsp;<span style="color:red;">*</span></div>
                  <div class="col-xs-12 col-md-2">
                  	<?php echo GetHtmlSelect('PENSION_TYPE_PENSION','PENSION_TYPE_PENSION',$arr_type_pension,'ประเภทการขอรับ',$rec_main['PENSION_TYPE_PENSION']," onChange='GetReceiver(); GetContent();' ",'','1','','2');?>
                  </div>
                  <div class="col-xs-12 col-md-1"></div>
                  <div id="TYPE_RECEIVER" >
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ผู้ติดต่อขอรับ :&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
                      <?php echo GetHtmlSelect('PENSION_TYPE_RECEIVER','PENSION_TYPE_RECEIVER',$arr_receiver,'ผู้ติดต่อขอรับ',$rec_main['PENSION_TYPE_RECEIVER']," onChange='GetReceiverDetail();' ",'','1','','2');?>
                    </div>
                  </div>
                </div>	
            </div>
            <div id="div_10">
             <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();">
                        <img class="switchPic2" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลใบมรณะบัตร
                    </a>
                </div>
            </div>
            <div id="collapse2" class="collapse">
            	<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ : </div>
                    <div class="col-xs-12 col-md-2">
					<input type="text" id="DIED_NO"   name="DIED_NO" class="form-control" value="<?php echo text($rec_main['DIED_NO']); ?>" placeholder="เลขที่" >
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ : </div>
                    <div class="col-xs-12 col-md-2">
                    	<div class="input-group">
                            <input type="text" class="form-control col-md-13" name="DIED_DATE" id="DIED_DATE" value="<?php echo conv_date($rec_main['DIED_DATE']);?>" placeholder="DD/MM/YYYY">
                            <span class="input-group-addon datepicker" for="DIED_DATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                        </div>
                    </div>
                </div>	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่เสียชีวิต : </div>
                    <div class="col-xs-12 col-md-2">
                    	<div class="input-group">
                            <input type="text" class="form-control col-md-13" name="DIED_SDATE" id="DIED_SDATE" value="<?php echo conv_date($rec_main['DIED_SDATE']);?>" placeholder="DD/MM/YYYY">
                            <span class="input-group-addon datepicker" for="DIED_SDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                        </div>
					</div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาเหตุที่เสียชีวิต : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="DIED_REASON" name="DIED_REASON" class="form-control " value="<?php echo text($rec_main['DIED_REASON']); ?>" >
                    </div>
                </div>	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานที่เสียชีวิต : </div>
                    <div class="col-xs-12 col-md-7">
                    	<input type="text" id="DIED_PLACE" name="DIED_PLACE" class="form-control" value="<?php echo text($rec_main['DIED_PLACE']); ?>" >
                    </div>
                </div>	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด : </div>
                    <div class="col-xs-12 col-md-2">
					 <?php echo GetHtmlSelect('DIED_PROV_ID','DIED_PROV_ID',$arr_prov,'จังหวัด',$rec_main['DIED_PROV_ID'],'','','1');?>
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" >อำเภอ :</div>
                    <div class="col-xs-12 col-md-2">
                    	<?php echo GetHtmlSelect('DIED_AMPR_ID','DIED_AMPR_ID',$arr_ampr_died,'อำเภอ',$rec_main['DIED_AMPR_ID'],'','','1');?>
                    </div>
                </div>	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ไฟลแนบ : </div>
                    <div class="col-xs-12 col-md-2">
                        <input id="DIED_FILE_OLD" type="hidden" name="DIED_FILE_OLD" value="<?php echo $rec_main['DIED_FILE']; ?>" >
                        <div class="input-group">
                    	<input name="DIED_FILE" id="DIED_FILE" class="form-control" type="file">
                        <?php echo displayDownloadFileAttach('../fileupload/file_pension/',$rec_main['DIED_FILE'],$arr_txt['download']);?>
                        </div>
                    </div>
                </div>	
            </div>
            </div>
            <div id="div_11">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                        <img class="switchPic3" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                       ข้อมูลผู้ถูกแสดงเจตนารับเงินช่วยเหลือพิเศษกรณีถึงแก่ความตาย
                    </a>
                </div>
            </div>
             <div id="collapse3" class="collapse">
             	<div class="table-responsive">
           		<table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="35%"><div align="center"><strong>ข้อมูลบุคคล</strong></div></th>
                          <th width="35%"><div align="center"><strong>ข้อมูลที่อยู่ติดต่อ</strong></div></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
				  $i = 1;
				  $sql_dead ="SELECT A.FAMILY_ID, A.FAMILY_IDCARD, A.FAMILY_PREFIX_ID, A.FAMILY_FIRSTNAME_TH, A.FAMILY_MIDNAME_TH, A.FAMILY_LASTNAME_TH,
				  A.ADDRESS_HOME_NO, A.ADDRESS_POSTCODE, A.ADDRESS_TEL, A.ADDRESS_TEL_EXT, A.ADDRESS_MOBILE,
				  B.TAMB_NAME_TH, C.AMPR_NAME_TH,  D.PROV_TH_NAME
				  FROM PER_FAMILY  A
				  LEFT JOIN SETUP_TAMB B ON A.ADDRESS_TAMB_ID = B.TAMB_ID
				  LEFT JOIN SETUP_AMPR C ON A.ADDRESS_AMPR_ID = C.AMPR_ID
				  LEFT JOIN SETUP_PROV D ON A.ADDRESS_PROV_ID = D.PROV_ID
				  WHERE A.PER_ID = '".$PER_ID."' AND A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0 AND A.FAMILY_RELATIONSHIP = 6
				  order by FAMILY_FIRSTNAME_TH ASC ";
				  $query_dead = $db->query($sql_dead);
				  $num_heir = $db->db_num_rows($query_dead);
				  if($num_heir > 0){
					  while($rec_dead = $db->db_fetch_array($query_dead)){
						  
						 
				  ?>
                  
                <tr bgcolor="#FFFFFF">
                    <td align="left">
                      <input type="hidden" id="FAMILY_ID_11_<?php echo $i; ?>" name="FAMILY_ID_11[<?php echo $rec_dead['FAMILY_ID']; ?>]" value="<?php echo $rec_dead['FAMILY_ID']; ?>" >
                  	 <div><strong>เลขบัตรประจำตัวประชาชน : </strong> <?php echo get_idCard($rec_dead['FAMILY_IDCARD']); ?></div>
                   	 <div><strong>ชื่อ-สกุล : </strong><?php echo Showname($rec_dead["FAMILY_PREFIX_ID"],$rec_dead["FAMILY_FIRSTNAME_TH"],$rec_dead["FAMILY_MIDNAME_TH"],$rec_dead["FAMILY_LASTNAME_TH"]); ?></div>
                    </td>
                    <td align="left">
                      <div> <strong> บ้านเลขที่ : </strong><?php echo text($rec_dead['ADDRESS_HOME_NO']); ?></div>
                      <div> <strong> ตำบล/แขวง : </strong><?php echo text($rec_dead['TAMB_NAME_TH']); ?></div>
                      <div> <strong> อำเภอ/เขต : </strong><?php echo text($rec_dead['AMPR_NAME_TH']); ?></div>
                      <div> <strong> จังหวัด : </strong><?php echo text($rec_dead['PROV_TH_NAME']); ?></div>
                      <div> <strong> รหัสไปรษณีย์ : </strong><?php echo text($rec_dead['ADDRESS_POSTCODE']); ?></div>
                      <div> <strong> หมายเลขโทรศัพท์ : </strong><?php echo format_phone($rec_dead['ADDRESS_TEL'],"tel","bk",$rec_dead['ADDRESS_TEL_EXT']);  ?></div>
                      <div> <strong> หมายเลขโทรศัพท์เคลื่อนที่ : </strong><?php echo format_phone($rec_dead['ADDRESS_MOBILE'],"mobile","bk",''); ?></div>
                    </td>                    
                </tr>
                <?php
				 $i++;
				 }
                }else{
					echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
				}
				?>
                </tbody>
              </table>
             </div>
             </div>
             </div>
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();">
                        <img class="switchPic4" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic4" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        เวลาราชการปกติ
                    </a>
                </div>
            </div>
                
            <div id="collapse4" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับที่</strong></div></th>
                            <th width="30%"><div align="center"><strong>รายการ</strong></div></th>
                            <th width="12%"><div align="center"><strong>วันที่เริ่มต้น</strong></div></th>
                            <th width="12%"><div align="center"><strong>วันที่สิ้นสุด</strong></div></th>
                            <th width="5%"><div align="center"><strong>ปี</strong></div></th>
                            <th width="5%"><div align="center"><strong>เดือน</strong></div></th>
                            <th width="5%"><div align="center"><strong>วัน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
					 $query_attendance = $db->query("SELECT SUM(WAREHOUSE_ABSENT) AS SUM_ABSENT, SUM(WAREHOUSE_LEAVE_NOTAPPROVE) AS NOTAPPROVE FROM ATTENDANCE_WAREHOUSE WHERE PER_ID = '".$PER_ID."' ");
					 $query_now = $db->query("SELECT * FROM PENSION_POSITIONHIS WHERE PENSION_ID = '".$PENSION_ID."' AND POSHIS_SEQ = 3 ");
					 $rec_now = $db->db_fetch_array($query_now);
					 $rec_attendance = $db->db_fetch_array($query_attendance);
					 $total_atten_day = $rec_attendance['SUM_ABSENT']+$rec_attendance['NOTAPPROVE'];
					
					 if(trim($SDATE_NOW)!="" and trim($EDATE_NOW)){
						$arr_date =  CalAgePension($SDATE_NOW, date("Y-m-d", strtotime("+1 DAY", strtotime($EDATE_NOW))));
						$year = $arr_date['YEAR'];
						$month = $arr_date['MONTH'];						
						$day = $arr_date['DAY'];
					}else{
						$year = '';
						$month = '';
						$day = '';
					}
					
					 if($total_atten_day > 0){
						  $arr_atten =  DateDiffPension($total_atten_day);
						  list($year_atten,$month_atten,$day_atten) = explode("-",$arr_atten);
					 }
					 
					 
					 
					?>
                    <tr bgcolor="#FFFFFF">
                        <td align="center">1.</td>
                        <td align="left" ><span style="border-bottom:solid 1px #000000;">ตั้ง</span> ระยะเวลารับราชการปกติ</td>
                        <td align="center">
						<input type="hidden" id="POSHIS_SDATE_1" name="POSHIS_SDATE[1]" value="<?php echo conv_date($PER_DATE_ENTRANCE); ?>" >
						<?php echo conv_date($SDATE_NOW,'short'); ?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="POSHIS_EDATE_1" name="POSHIS_EDATE[1]" value="<?php echo conv_date($PER_DATE_RESIGN); ?>" >
						<?php echo conv_date($EDATE_NOW,'short'); ?>
                        </td>
                        <td align="center">
                         <input type="hidden" id="POSHIS_YEAR_1" name="POSHIS_YEAR[1]" value="<?php echo $year; ?>" >
						<?php echo $year; ?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="POSHIS_MONTH_1" name="POSHIS_MONTH[1]" value="<?php echo  $month; ?>" >
						<?php echo $month; ?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="POSHIS_DAY_1" name="POSHIS_DAY[1]" value="<?php echo  $day; ?>" >
						<?php echo $day ?>
                        </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td align="center">2.</td>
                        <td align="left" ><span style="border-bottom:solid 1px #000000;">หัก</span> จำนวนวันที่การลาป่วยเกินสิทธิและไม่ได้รับอนุมัติ</td>
                        <td align="center" >
                        </td>
                        <td align="center" >
                        </td>
                        <td align="center"  >
                          <?php echo $year_atten; ?>
                          <input type="hidden" id="POSHIS_YEAR_2" name="POSHIS_YEAR[2]" value="<?php echo $year_atten; ?>" >
                         </td>
                        <td align="center" >
                         <?php echo $month_atten; ?>
                         <input type="hidden" id="POSHIS_MONTH_2" name="POSHIS_MONTH[2]" value="<?php echo $month_atten; ?>" >
                         </td>
                        <td align="center" >
                         <?php echo $day_atten ; ?>
                         <input type="hidden" id="POSHIS_DAY_2" name="POSHIS_DAY[2]" value="<?php echo $day_atten ; ?>" >
                         </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                        <td align="center">3.</td>
                        <td align="left" ><span style="border-bottom:solid 1px #000000;">เพิ่ม</span> ระยะเวลาราชการทหาร</td>
                        <td align="center" >
                        	<div class="input-group">
                              <input type="text" class="form-control col-md-13" name="POSHIS_SDATE[3]" id="POSHIS_SDATE_3" value="<?php  echo conv_date($rec_now['POSHIS_SDATE']);  ?>" placeholder="DD/MM/YYYY">
                              <span class="input-group-addon datepicker" for="POSHIS_SDATE_3" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                            </div>
                        </td>
                        <td align="center" >
                       		<div class="input-group">
                              <input type="text" class="form-control col-md-13" name="POSHIS_EDATE[3]" id="POSHIS_EDATE_3" value="<?php  echo conv_date($rec_now['POSHIS_EDATE']);  ?>" placeholder="DD/MM/YYYY">
                              <span class="input-group-addon datepicker" for="POSHIS_EDATE_3" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
                            </div> 
                        </td>
                        <td align="center" style="border-bottom:solid 1px #000000;" > 
                       <?php echo $rec_now['POSHIS_YEAR']; ?>
                        <input type="hidden" id="POSHIS_YEAR_3" name="POSHIS_YEAR[3]" value="<?php echo $rec_now['POSHIS_YEAR']; ?>" >
                        </td>
                        <td align="center" style="border-bottom:solid 1px #000000;" >
                         <?php echo $rec_now['POSHIS_MONTH']; ?>
                         <input type="hidden" id="POSHIS_MONTH_3" name="POSHIS_MONTH[3]" value="<?php echo $rec_now['POSHIS_MONTH']; ?>" >
                         </td>
                        <td align="center" style="border-bottom:solid 1px #000000;" >
                        <?php echo $rec_now['POSHIS_DAY']; ?>
                        <input type="hidden" id="POSHIS_DAY_3" name="POSHIS_DAY[3]" value="<?php echo $rec_now['POSHIS_DAY']; ?>" >
                        </td>
                    </tr>
                    <?php
					    $total_now_year = 0;
						$total_now_month = 0;
						$total_now_day = 0;
						
						if($rec_now['POSHIS_YEAR'] > 0 or $rec_now['POSHIS_MONTH'] > 0 or $rec_now['POSHIS_DAY'] > 0  ){
							$txt_poshis = $rec_now['POSHIS_YEAR'].'-'.$rec_now['POSHIS_MONTH'].'-'.$rec_now['POSHIS_DAY'];
							$txt_day_now  = $year.'-'.$month.'-'.$day;
							$arr_poshis =  PlusAgePension($txt_poshis,$txt_day_now);
							$total_now_day = $arr_poshis['DAY'];
							$total_now_month = $arr_poshis['MONTH'];
							$total_now_year = $arr_poshis['YEAR'];
						}else{
							$total_now_day = $day;
							$total_now_month = $month;
							$total_now_year = $year;
						}
						
						if($year_atten > 0 or $month_atten > 0 or $day_atten > 0  ){
							$txt_day_atten = $year_atten.'-'.$month_atten.'-'.$day_atten;
						    $txt_day_now  = $total_now_year.'-'.$total_now_month.'-'.$total_now_day;
							$arr_diff_atten = CalAgePension($txt_day_atten, $txt_day_now); 
							$total_now_day = $arr_diff_atten['DAY'];
							$total_now_month = $arr_diff_atten['MONTH'];
							$total_now_year = $arr_diff_atten['YEAR'];
						}
					
					
					
					   // $total_practices_day = ($DateDiffNow+$total_now_day)-$total_atten_day;
						//$arr_practices =  datediff_cal($total_practices_day);
						//list($total_now_year,$total_now_month,$total_now_day) = explode("-",$arr_practices);
						
					?>
                    <tr bgcolor="#FFFFFF">
                        <td colspan="4" align="center"><strong>รวมเวลาราชการปกติ</strong></td>
                        <td align="center" style="border-bottom:double 3px #000000;" ><?php echo $total_now_year; ?></td>
                        <td align="center" style="border-bottom:double 3px #000000;" ><?php echo $total_now_month; ?></td>
                        <td align="center" style="border-bottom:double 3px #000000;" ><?php echo $total_now_day; ?></td>
                    </tr>
					
                   </tbody>
                </table>
            </div> 
            
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();">
                        <img class="switchPic5" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic5" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        เวลาราชการทวีคูณ
                    </a>
                </div>
            </div>
            
            <div id="collapse5" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับที่</strong></div></th>
                            <th width="15%"><div align="center"><strong>ช่วงเวลาทวีคูณ</strong></div></th>
                            <th width="10%"><div align="center"><strong>วันที่เริ่มต้น</strong></div></th>
                            <th width="10%"><div align="center"><strong>วันที่สิ้นสุด</strong></div></th>
                            <th width="10%"><div align="center"><strong>จำวนวันลา/ขาด ราชการ</strong></div></th>
                            <th width="5%"><div align="center"><strong>ปี</strong></div></th>
                            <th width="5%"><div align="center"><strong>เดือน</strong></div></th>
                            <th width="5%"><div align="center"><strong>วัน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                   <?php
				    $i = 1;
					$sql_multitime = "SELECT A.MULTI_ID, A.MULTIME_ID, A.MULTI_FRAC, B.MULTIME_SDATE, B.MULTIME_EDATE, B.MULTIME_NAME_TH, B.MULTITIME_YEAR,
					B.MULTITIME_MONTH, B.MULTITIME_DAY
					FROM PENSION_MULTITIME A
					JOIN SETUP_MULTITIME B ON A.MULTIME_ID = B.MULTIME_ID
					WHERE A.PENSION_ID = '".$PENSION_ID."' ";	
					$query_multitime = $db->query($sql_multitime);
					$num_multitime = $db->db_num_rows($query_multitime);
					if($num_multitime > 0){
						while($rec_multitime = $db->db_fetch_array($query_multitime)){
							
						$year_multi = $rec_multitime['MULTITIME_YEAR'];
						$month_multi = $rec_multitime['MULTITIME_MONTH'];
						$day_multi = $rec_multitime['MULTITIME_DAY'];
						$day_miss_multi = $rec_multitime['MULTI_FRAC'];	
													
				   ?>
                    <tr bgcolor="#FFFFFF">
                        <td align="center"><?php echo $i; ?></td>
                        <td align="left" >
                        <input type="hidden" id="MULTI_ID_<?php echo $i; ?>" name="MULTI_ID[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo $rec_multitime['MULTI_ID']; ?>" >
                        <input type="hidden" id="MULTITIME_ID_<?php echo $i; ?>" name="MULTITIME_ID[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo $rec_multitime['MULTIME_ID']; ?>" >
						<?php echo text($rec_multitime['MULTIME_NAME_TH']);?>
                        </td>
                        <td align="center">
                        <input  type="hidden" id="MULTI_SDATE_<?php echo $i; ?>" name="MULTI_SDATE[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo conv_date($rec_multitime["MULTIME_SDATE"]);?>" >
						<?php echo conv_date($rec_multitime["MULTIME_SDATE"], 'short');?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="MULTI_EDATE_<?php echo $i; ?>" name="MULTI_EDATE[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo conv_date($rec_multitime["MULTIME_EDATE"]);?>" >
						<?php echo conv_date($rec_multitime["MULTIME_EDATE"], 'short');?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="MULTI_FRAC_<?php echo $i; ?>"  name="MULTI_FRAC[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo $rec_multitime['MULTI_FRAC'];?>" >
						<?php echo $rec_multitime['MULTI_FRAC'];?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="MULTI_YEAR_<?php echo $i; ?>"  name="MULTI_YEAR[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo $year_multi;?>" >
						<?php echo $year_multi;?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="MULTI_MONTH_<?php echo $i; ?>"  name="MULTI_MONTH[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo $month_multi;?>" >
						<?php echo $month_multi;?>
                        </td>
                        <td align="center">
                        <input type="hidden" id="MULTI_DAY_<?php echo $i; ?>"  name="MULTI_DAY[<?php echo $rec_multitime['MULTI_ID']; ?>]" value="<?php echo $day_multi;?>" >
						<?php echo $day_multi;?>
                        </td>
                    </tr>
                    <?php
					$i++;
					}
					}else{
					}
					?>
                 </tbody>
              </table>
            </div>
            
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();">
                        <img class="switchPic6" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic6" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        รวมเวลาราชการ
                    </a>
                </div>
            </div>
            
            <div id="collapse6" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                             <th width="5%"><div align="center"><strong>ลำดับที่</strong></div></th>
                            <th width="30%"><div align="center"><strong>รายการ</strong></div></th>
                            <th width="5%"><div align="center"><strong>ปี</strong></div></th>
                            <th width="5%"><div align="center"><strong>เดือน</strong></div></th>
                            <th width="5%"><div align="center"><strong>วัน</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr bgcolor="#FFFFFF">
                            <td align="center">1.</td>
                            <td align="left" >เวลาราชการปกติ</td>
                            <td align="center" style="padding-left:5px"><?php echo $total_now_year; ?></td>
                            <td align="center"><?php echo $total_now_month; ?></td>
                            <td align="center"><?php echo $total_now_day; ?></td>
                        </tr>
                        <?php
						  if($day_miss_multi > 0){
							 $miss_multi = DateDiffPension($day_miss_multi);
							 list($year_miss_multi, $month_miss_multi, $day_miss_multi_1) = explode('-',$miss_multi);
							 }
							 $txt_day_multi =  $year_multi.'-'.$month_multi.'-'.$day_multi;
							 if($year_miss_multi > 0 or $month_miss_multi > 0 or $day_miss_multi_1 > 0){
								 $txt_miss_multi = $year_miss_multi.'-'.$month_miss_multi.'-'.$day_miss_multi_1;
								 $arr_multi_miss = CalAgePension($txt_miss_multi, $txt_day_multi);
								 $year_multi = $arr_multi_miss['YEAR'] ;
								 $month_multi = $arr_multi_miss['MONTH'];
								 $day_multi = $arr_multi_miss['DAY'];
								 
							 }
						?>
                        <tr bgcolor="#FFFFFF">
                            <td align="center">2.</td>
                            <td align="left" >เวลาราชการทวีคูณ</td>
                            <td align="center" style="border-bottom:solid 1px #000000;" ><?php echo $year_multi; ?></td>
                            <td align="center" style="border-bottom:solid 1px #000000;" ><?php echo $month_multi; ?></td>
                            <td align="center" style="border-bottom:solid 1px #000000;" ><?php echo $day_multi; ?></td>
                        </tr>
                        <?php
						    $txt_day_normal = $total_now_year.'-'.$total_now_month.'-'.$total_now_day;
						    $txt_day_multi =  $year_multi.'-'.$month_multi.'-'.$day_multi;
						   if($year_multi > 0 or $month_multi > 0 or $day_multi > 0){
							   $arr_all = PlusAgePension($txt_day_multi,$txt_day_normal);
							   $all_year = $arr_all['YEAR'];
							   $all_month = $arr_all['MONTH'];
							   $all_day = $arr_all['DAY'];
						   }else{
							   $all_year = $total_now_year;
							   $all_month = $total_now_month;
							   $all_day = $total_now_day;
						   }
							
							$total_year = $all_year;
							$total_month = $all_month;
							$total_day = $all_day;
							$total_year_cal = $all_year;
							$total_month_cal = $all_month;
							$total_day_cal = $all_day;
							
							if($total_day >= 15){
								$total_day_cal = 0;
								$total_month_cal = $total_month +1;
							}
							if($total_month_cal >= 6){
								$total_month_cal = 0;
								$total_year_cal = $total_year + 1;
							} 
							
						?>
                        <tr bgcolor="#FFFFFF">
                            <td colspan="2" align="center"><strong>รวมเวลาราชการ</strong></td>
                            <td align="center" style="border-bottom:double 3px #000000;" >
                            <input type="hidden" id="PENSION_YEAR" name="PENSION_YEAR" value="<?php echo $total_year; ?>" >
							<?php echo $total_year; ?>
                            </td>
                            <td align="center" style="border-bottom:double 3px #000000;" >
                            <input type="hidden" id="PENSION_MONTH" name="PENSION_MONTH" value="<?php echo $total_month; ?>" >
							<?php echo $total_month; ?>
                            </td>
                            <td align="center" style="border-bottom:double 3px #000000;">
                            <input type="hidden" id="PENSION_DAY" name="PENSION_DAY" value="<?php echo $total_day; ?>" >
							<?php echo $total_day; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="div_1">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse9" onClick="$('.switchPic9').toggle();">
                        <img class="switchPic9" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic9" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        บำเหน็จ
                    </a>
                </div>
            </div> 
            <div id="collapse9" class="collapse">
            	 <div class="row formSep">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือน เดือนสุดท้าย : </div>
                <div class="col-xs-12 col-md-2">
                    <input type="text" id="PENSION_SALARY" name="PENSION_SALARY" class="form-control" value="<?php echo number_format($rec_main['PENSION_SALARY'],2); ?>" style="display:inline-table; width:200px; margin-right:5px;" onBlur="NumberFormat(this,2);">
                </div>
                <div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินบำเหน็จที่ได้รับ :</div>
                <div class="col-xs-12 col-md-2">
                 	<input type="text" id="PENSION_ALL" name="PENSION_ALL" class="form-control " value="<?php echo number_format($rec_main['PENSION_ALL'],2); ?>" onBlur="NumberFormat(this,2);" >
                </div>
            </div>	
            </div>
            </div>
            <div id="div_2">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onClick="$('.switchPic7').toggle();">
                        <img class="switchPic7" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic7" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                       บำนาญ กรณีไม่เป็นสมาชิก กบข.
                    </a>
                </div>
            </div>
            <div id="collapse7" class="collapse">
            	<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินเดือน เดือนสุดท้าย :&nbsp;</div>
                    <div class="col-xs-12 col-md-2">
						<input type="text" id="PENSION_SALARY" name="PENSION_SALARY" class="form-control" value="<?php echo number_format($rec_main['PENSION_SALARY'],2); ?>" onBlur="NumberFormat(this,2);" >
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เงินบำนาญที่ได้รับต่อเดือน :</div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="PENSION_MONTHLY" name="PENSION_MONTHLY" class="form-control " value="<?php echo number_format($rec_main['PENSION_MONTHLY'],2); ?>" onBlur="NumberFormat(this,2);">
                    </div>
                </div>
            
           </div>
           </div>
           <div id="div_3">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse8" onClick="$('.switchPic8').toggle();">
                        <img class="switchPic8" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic8" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        บำนาญ กรณีเป็นสมาชิก กบข.
                    </a>
                </div>
            </div> 
            
            <div id="collapse8" class="collapse">
                <br>
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                            <th width="12%"><div align="center"><strong>วันที่เริ่มต้น</strong></div></th>
                            <th width="12%"><div align="center"><strong>วันที่สิ้นสุด</strong></div></th>
                            <th width="8%"><div align="center"><strong>เงินเดือนที่ได้รับ</strong></div></th>
                            <th width="10%"><div align="center"><strong>จำนวนเดือน</strong></div></th>
                            <th width="10%"><div align="center"><strong>รวม</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						 $i =1;
						$sql_salary = "SELECT * FROM PENSION_UPSALARY A WHERE A.DELETE_FLAG = 0  AND PENSION_ID = '".$PENSION_ID."' ";
						$query_salary = $db->query($sql_salary);
						$num_salary = $db->db_num_rows($query_salary);
						while($rec_sal = $db->db_fetch_array($query_salary)){
						$SALARY_PENSION = $rec_sal['UPS_SALARY'];
						$month_salary = $rec_sal['UPS_MONTH'];
					    $num_month = $num_month + $month_salary ;
						$num_money = $month_salary*$rec_sal['UPS_SALARY'];
					    $total_salary = $total_salary + $num_money;
						$total_pension_month = $total_pension_month + $month_salary; 
				     ?>
                      <tr bgcolor="#FFFFFF">
                          <td align="center"><?php echo $i; ?>.</td>
                          <td align="center">
                            <?php  echo conv_date($rec_sal['UPS_SDATE'],'short');  ?>
                          	<input type="hidden" id="SALHIS_ID_<?php echo $i; ?>" name="SALHIS_ID[<?php echo $rec_sal['SALHIS_ID'] ?>]" value="<?php echo $rec_sal['SALHIS_ID']; ?>" >
                          	<input type="hidden"  name="UPS_SDATE[<?php echo $rec_sal['SALHIS_ID'] ?>]" id="UPS_SDATE_<?php echo $i ?>" value="<?php  echo conv_date($rec_sal['UPS_SDATE']);  ?>" >
                      
                          </td>
                          <td align="center">
                            <?php echo conv_date($rec_sal['UPD_EDATE'],'short'); ?>
                          	<input type="hidden"  name="UPS_EDATE[<?php echo $rec_sal['SALHIS_ID'] ?>]" id="UPS_EDATE_<?php echo $i; ?>" value="<?php echo conv_date($rec_sal['UPD_EDATE']); ?>" >
                             
                          </td>
                          <td align="right">
                          	<?php echo number_format($SALARY_PENSION,2); ?>
                          	<input type="hidden" id="UPS_SALARY_<?php echo $i; ?>" name="UPS_SALARY[<?php echo $rec_sal['SALHIS_ID'] ?>]" class="form-control " value="<?php echo $SALARY_PENSION; ?>" >
                          </td>
                          <td align="center">						  
                              <?php echo  $month_salary; ?>
                         	 <input type="hidden" id="UPS_MONTH_<?php echo $i; ?>" name="UPS_MONTH[<?php echo $rec_sal['SALHIS_ID'] ?>]" class="form-control " value="<?php echo $month_salary; ?>" >
                          </td>
                          <td align="right">
                          <input type="hidden" name="UPS_TOTAL[<?php echo $rec_sal['SALHIS_ID'] ?>]" id="UPS_TOTAL_<?php echo $i ?>" value=" <?php echo number_format($num_money,2);?>" >
						  <?php echo number_format($num_money,2);?>
                          </td>
                      </tr>	
                      <?php 
					   $b++;
					   $i++;
					  }
					 
					  $day_cal_pension = 0;
					  $month_cal_pension = 0;
					  $year_cal_pension = 0;
					  $RECEIVE_GPF = 0;
					  
					  if($total_day > 0){
						  $day_cal_pension = ($total_day/360);
					  }
					  if($total_month > 0){
						  $month_cal_pension = ($total_month/12);
					  }
					 $year_cal_pension = ($total_year+$day_cal_pension)+$month_cal_pension; 
					  
					  $AVG_SALARY = $total_salary/60;
					  $PERCENT_SALARY = $AVG_SALARY*0.7;
					  $CAL_GPF_SALARY = round((($AVG_SALARY*$year_cal_pension)/50),2);
					  if($CAL_GPF_SALARY < $PERCENT_SALARY){
						  $RECEIVE_GPF = $CAL_GPF_SALARY;
					  }else{
						  $RECEIVE_GPF = $PERCENT_SALARY;
					  }
					 ?>
                      <tr bgcolor="#FFFFFF">
                          <td colspan="4" align="center"><strong>รวม</strong></td>
                          <td align="center"><strong><?php echo $total_pension_month; ?></strong></td>
                          <td align="right"><strong>
                          <?php  echo number_format($total_salary,2); ?>
                          </strong></td>
                          
                      </tr>	
                     
                     
                    </tbody>
                </table>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-3" style="white-space:nowrap;">รวมเงินเดือน 60 เดือนสุดท้าย :</div>
                    <div class="col-xs-12 col-md-2">
                       <input type="hidden" name="SALARY_ALL" id="SALARY_ALL" value="<?php echo number_format($total_salary,2); ?>" >
						<?php echo number_format($total_salary,2); ?>
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">เงินเดือนเฉลี่ย 60 เดือนสุดท้าย :</div>
                    <div class="col-xs-12 col-md-2">
                        <input type="hidden" id="SALARY_AVG" name="SALARY_AVG" value="<?php echo number_format($AVG_SALARY,2);?>" >
                    	<?php echo number_format($AVG_SALARY,2);?>
                    </div>
                </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-3" style="white-space:nowrap;">ร้อยละ 70 ของเงินเดือน เฉลี่ย 60 เดือนสุดท้าย :</div>
                  <div class="col-xs-12 col-md-2">
                    <input type="hidden" id="SALARY_SEVENTY" name="SALARY_SEVENTY" value="  <?php echo number_format($PERCENT_SALARY,2);?>" >
                    <?php echo number_format($PERCENT_SALARY,2);?>
                  </div>
                  <div class="col-xs-12 col-md-1"></div>
                 <div class="col-xs-12 col-md-3" style="white-space:nowrap;">เงินบำนาญที่คำนวณได้ :</div>
                 <div class="col-xs-12 col-md-3">
                   <input type="hidden" id="SALARY_TRUST" name="SALARY_TRUST" value="<?php echo number_format($CAL_GPF_SALARY,2);  ?>" >
                   	<?php echo number_format($CAL_GPF_SALARY,2);  ?>
                 </div>
                </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-3" >เงินบำนาญที่ได้รับจริง :</div>
                  <div class="col-xs-12 col-md-2">
                     <input type="hidden" id="PENSION_MONTHLY" name="PENSION_MONTHLY" value="<?php echo number_format($RECEIVE_GPF,2);  ?>">
                     <?php echo number_format($RECEIVE_GPF,2);  ?>
                  </div>
            </div>	
                
           </div>
           </div>
           <div id="div_4" >
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse10" onClick="$('.switchPic10').toggle();">
                        <img class="switchPic10" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic10" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        บำเหน็จตกทอด
                    </a>
                </div>
            </div>
            <div id="collapse10" class="collapse">
               <?php 
			   		$LEGENCY_ALL = ($PENSION_MONTHLY*30);
					$BONUSTIME_ALL = ($PENSION_MONTHLY * 15);
					if($BONUSTIME_ALL >= 400000){
						$BONUSTIME_ALL = 400000;
					}
			   ?>
            	<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บำเหน็จตกทอด : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="LEGENCY_ALL" name="LEGENCY_ALL" class="form-control " value="<?php echo number_format($LEGENCY_ALL,2); ?>" onBlur="NumberFormat(this,2);" >
					</div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บำเหน็จดำรงชีพทั้งหมด : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="BONUSTIME_ALL" name="BONUSTIME_ALL" class="form-control " value="<?php echo number_format($BONUSTIME_ALL,2); ?>" onBlur="NumberFormat(this,2);" >
                    </div>
                </div>	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">การขอรับบำเหน็จดำรงชีพครั้งที่ 1 : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input name="BONUSTIME_RECEIVE" type="radio"   id="BONUSTIME_RECEIVE" value="1" <?php echo($rec_main['BONUSTIME_RECEIVE'] == 1 or trim($rec_main['BONUSTIME_RECEIVE']) <= '0')?'checked':''; ?> onClick="getBonustime();" >&nbsp; รับ &nbsp;&nbsp;
                        <input name="BONUSTIME_RECEIVE" type="radio"  id="BONUSTIME_RECEIVE" value="2" <?php echo($rec_main['BONUSTIME_RECEIVE'] == 2)?'checked':''; ?> onClick="getBonustime();" >&nbsp; ไม่รับ
					</div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จำนวนเงินบำเหน็จดำรงชีพรอบที่ 1 <br>ได้รับไม่เกิน 200,000 บาท : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="BONUSTIME_AMOUNT" name="BONUSTIME_AMOUNT" class="form-control " value="<?php echo number_format($rec_main['BONUSTIME_AMOUNT'],2); ?>" onKeyUp="" onBlur="NumberFormat(this,2); ChkMoneyBonus(this);" >
                    </div>
                </div>	
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จำนวนเงินบำเหน็จดำรงชีพคงเหลือ : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="BONUSTIME_BALANCE" name="BONUSTIME_BALANCE" class="form-control " value="<?php echo number_format($rec_main['BONUSTIME_BALANCE'],2); ?>"  onBlur="NumberFormat(this,2);">
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บำเหน็จตกทอดคงเหลือ : </div>
                    <div class="col-xs-12 col-md-2">
                    	<input type="text" id="LEGENCY_BALANCE" name="LEGENCY_BALANCE" class="form-control " value="<?php echo number_format($rec_main['LEGENCY_BALANCE'],2); ?>" onBlur="NumberFormat(this,2);">
                    </div>
                </div>	
                
            </div> 
            </div>
            <div id="div_5">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse11" onClick="$('.switchPic11').toggle();">
                        <img class="switchPic11" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic11" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลผู้ติดต่อขอรับ
                    </a>
                </div>
            </div> 
            
            <div id="collapse11" class="collapse">
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" >ผู้ติดต่อขอรับ :</div>
                    <div class="col-xs-12 col-md-2">
                     <?php echo GetHtmlSelect('PENSION_TYPE_RECEIVE','PENSION_TYPE_RECEIVE',$arr_receive_type,'ผู้ติดต่อขอรับ',$rec_main['PENSION_TYPE_RECEIVE'],'onchange="GetReceiveType()";','','1','200','2');?>
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div id="type_1">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อ - สกุล :</div>
                         <div class="col-xs-12 col-md-3">
                        <?php echo GetHtmlSelect('FAMILY_ID','FAMILY_ID',$arr_family,'ชื่อ - สกุล',$rec_main['FAMILY_ID'],'','','1','300',2);?>
                        </div>
                     </div>
              	  </div>
               
                <div id="type_3">
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['idcard']; ?> : </div>
                      <div class="col-xs-12 col-md-2">
                      <input type="text" name="RECEIVER_IDCARD" id="RECEIVER_IDCARD" value="<?php echo get_idCard($rec_main['RECEIVE_IDCARD']);?>" class="form-control idcard">
                      </div>
                  </div>
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">คำนำหน้าชื่อ :</div>
                      <div class="col-xs-12 col-md-2">
                      <?php echo GetHtmlSelect("RECEIVER_PREFIX_ID","RECEIVER_PREFIX_ID",$arr_prefix,'คำนำหน้าชื่อ',$rec_main['RECEIVER_PREFIX_ID'],'','','1','200'); ?>
                      </div>
                      <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัว : </div>
                      <div class="col-xs-12 col-md-2"><input type="text" name="RECEIVER_FIRSTNAME_TH" id="RECEIVER_FIRSTNAME_TH" value="<?php echo text($rec_main['RECEIVER_FIRSTNAME_TH']);?>" class="form-control"></div>
                  </div>
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อรอง :</div>
                      <div class="col-xs-12 col-md-2"><input type="text" id="RECEIVER_MIDNAME_TH" name="RECEIVER_MIDNAME_TH" value="<?php echo text($rec_main['RECEIVER_MIDNAME_TH']); ?>" class="form-control "></div>
                       <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุล :</div>
                      <div class="col-xs-12 col-md-2"><input type="text" name="RECEIVER_LASTNAME_TH" id="RECEIVER_LASTNAME_TH" value="<?php echo text($rec_main['RECEIVER_LASTNAME_TH']);?>" class="form-control"></div>
                  </div>
                  </div>
                  <div id="type_2">
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานะของบุคคล : </div>
                      <div class="col-xs-12 col-md-2">
                          <?php echo GetHtmlSelect('PENSION_TYPE_DELEGATE','PENSION_TYPE_DELEGATE',$arr_delegate_type,'สถานะของบุคคล',$rec_main['PENSION_TYPE_DELEGATE'],'','','1','200','2');?>
                      </div>
                      <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['idcard']; ?> : </div>
                      <div class="col-xs-12 col-md-2">
                      <input type="text" name="DELEGATE_IDCARD" id="DELEGATE_IDCARD" value="<?php echo get_idCard($rec_main['DELEGATE_IDCARD']);?>" class="form-control idcard">
                      </div>
                  </div>
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">คำนำหน้าชื่อ : </div>
                      <div class="col-xs-12 col-md-2">
                      <?php echo GetHtmlSelect("DELEGATE_PREFIX_ID","DELEGATE_PREFIX_ID",$arr_prefix,'คำนำหน้าชื่อ',$rec_main['DELEGATE_PREFIX_ID'],'','','1','200'); ?>
                      </div>
                       <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัว : </div>
                      <div class="col-xs-12 col-md-2"><input type="text" name="DELEGATE_FIRSTNAME_TH" id="DELEGATE_FIRSTNAME_TH" value="<?php echo text($rec_main['DELEGATE_FIRSTNAME_TH']);?>" class="form-control"></div>
                  </div>
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อรอง :</div>
                      <div class="col-xs-12 col-md-2"><input type="text" id="DELEGATE_MIDNAME_TH" name="DELEGATE_MIDNAME_TH" value="<?php echo text($rec_main['DELEGATE_MIDNAME_TH']);?>" class="form-control "></div>
                      <div class="col-xs-12 col-md-1"></div>
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อสกุล :</div>
                      <div class="col-xs-12 col-md-2"><input type="text" name="DELEGATE_LASTNAME_TH" id="DELEGATE_LASTNAME_TH" value="<?php echo text($rec_main['DELEGATE_LASTNAME_TH']);?>" class="form-control"></div>
                  </div>
                  </div>
        </div>
        </div>
          <div id="div_6">
           <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse12" onClick="$('.switchPic12').toggle();">
                        <img class="switchPic12" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic12" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ที่อยู่สำหรับการติดต่อภายหลังเกษียณอายุราชการ
                    </a>
                </div>
            </div> 
           <div id="collapse12" class="collapse">
           <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเทศ : </div>
              <div class="col-xs-12 col-sm-2">
                   <?php echo GetHtmlSelect('ADDRESS_COUNTRY_ID','ADDRESS_COUNTRY_ID',$arr_country,'ประเทศ',$rec_main['ADDRESS_COUNTRY_ID']," onChange='GetCountry();' ",'chosen','1'); ?>
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div id="address_group_1">
               <div class="col-xs-12 col-sm-2">เมือง : </div>
               <div class="col-xs-12 col-sm-2">
                   <input  type="text" id="ADDRESS_CITY" name="ADDRESS_CITY" class="form-control" placeholder="เมือง" value="<?php echo text($rec_main['ADDRESS_CITY']); ?>" >  
               </div>  
             </div>
          </div>
          <div id="address_group_2">
           	<div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">เลขที่ห้อง : </div>
              <div class="col-xs-12 col-sm-2">
                   <input type="text" id="ADDRESS_ROOM_NO" name="ADDRESS_ROOM_NO" class="form-control" placeholder="เลขที่ห้อง" value="<?php echo text($rec_main['ADDRESS_ROOM_NO']); ?>" >
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">ชั้น : </div>
             <div class="col-xs-12 col-sm-2">
                  <input type="text" id="ADDRESS_FLOOR" name="ADDRESS_FLOOR" class="form-control" placeholder="ชั้น" value="<?php echo text($rec_main['ADDRESS_FLOOR']); ?>" >
             </div>  
          </div>
           <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">อาคาร : </div>
              <div class="col-xs-12 col-sm-2">
                   <input type="text" id="ADDRESS_BUILDING" name="ADDRESS_BUILDING" class="form-control" placeholder="อาคาร" value="<?php echo text($rec_main['ADDRESS_BUILDING']); ?>" >
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">บ้านเลขที่ : </div>
             <div class="col-xs-12 col-sm-2">
                  <input type="text" id="ADDRESS_HOME_NO" name="ADDRESS_HOME_NO" class="form-control" placeholder="บ้านเลขที่" value="<?php echo text($rec_main['ADDRESS_HOME_NO']); ?>" >
             </div>  
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมู่ที่ : </div>
              <div class="col-xs-12 col-sm-2">
                   <input type="text" id="ADDRESS_MOO" name="ADDRESS_MOO" class="form-control number" placeholder="หมู่ที่" value="<?php echo text($rec_main['ADDRESS_MOO']); ?>" >
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">หมู่บ้าน : </div>
             <div class="col-xs-12 col-sm-2">
                  <input type="text" id="ADDRESS_VILLAGE" name="ADDRESS_VILLAGE" class="form-control " placeholder="หมู่บ้าน" value="<?php echo text($rec_main['ADDRESS_VILLAGE']); ?>" >
             </div>  
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ซอย : </div>
              <div class="col-xs-12 col-sm-2">
                   <input type="text" id="ADDRESS_SOI" name="ADDRESS_SOI" class="form-control " placeholder="ซอย" value="<?php echo text($rec_main['ADDRESS_SOI']); ?>" >
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">ถนน : </div>
             <div class="col-xs-12 col-sm-2">
                 <input type="text" id="ADDRESS_ROAD" name="ADDRESS_ROAD" class="form-control " placeholder="ถนน" value="<?php echo text($rec_main['ADDRESS_ROAD']); ?>" >
             </div>  
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">จังหวัด : </div>
              <div class="col-xs-12 col-sm-2">
                   <?php echo GetHtmlSelect('ADDRESS_PROV_ID',"ADDRESS_PROV_ID",$arr_prov,'จังหวัด',$rec_main['ADDRESS_PROV_ID']," onChange='getRampr(this)' ",'','1'); ?>
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">อำเภอ/เขต : </div>
             <div class="col-xs-12 col-sm-2">
                 <?php echo GetHtmlSelect('ADDRESS_AMPR_ID','ADDRESS_AMPR_ID',$arr_ampr,'อำเภอ/เขต',$rec_main['ADDRESS_AMPR_ID']," onChange='getStamb(this);' ",'','1'); ?>
             </div>  
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำบล/แขวง : </div>
              <div class="col-xs-12 col-sm-2">
                   <?php echo GetHtmlSelect('ADDRESS_TAMB_ID','ADDRESS_TAMB_ID',$arr_tamb,'ตำบล/แขวง',$rec_main['ADDRESS_TAMB_ID']," onChange='getZipcode(this);' ",'','1'); ?>
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">รหัสไปรษณีย์ : </div>
             <div class="col-xs-12 col-sm-2">
                 <input type="text" id="ADDRESS_ZIPCODE" name="ADDRESS_ZIPCODE" class="form-control" placeholder="รหัสไปรษณีย์" value="<?php echo text($rec_main['ADDRESS_POSTCODE']); ?>" >
             </div>  
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมายเลขโทรศัพท์ : </div>
              <div class="col-xs-12 col-sm-2">
                   <input type="text" id="ADDRESS_TEL" name="ADDRESS_TEL" class="form-control  telbkk" placeholder="หมายเลขโทรศัพท์" value="<?php echo text($rec_main['ADDRESS_TEL']); ?>" > 
               </div>
              <div class="col-xs-12 col-sm-2">
                  <div class="input-group">
                    <span class="input-group-addon">ต่อ</span>
                    <input type="text" id="ADDRESS_TEL_EXT" name="ADDRESS_TEL_EXT"  class="form-control number" placeholder="ต่อ" value="<?php echo $rec_main['ADDRESS_TEL_EXT']; ?>" style="width:100px;"  >
                    </div>
              </div>
             <div class="col-xs-12 col-sm-2">หมายเลขโทรสาร : </div>
             <div class="col-xs-12 col-sm-2">
                 <input type="text" id="ADDRESS_FAX" name="ADDRESS_FAX" class="form-control  telbkk" placeholder="หมายเลขโทรสาร" value="<?php echo text($rec_main['ADDRESS_FAX']); ?>" >
                 
             </div>
             <div class="col-xs-12 col-sm-2">
              <div class="input-group">
                  <span class="input-group-addon">ต่อ</span>
                  <input type="text" id="ADDRESS_FAX_EXT" name="ADDRESS_FAX_EXT"  class="form-control number " placeholder="ต่อ" value="<?php echo $rec_main['ADDRESS_FAX_EXT']; ?>" style="width:100px;">
                 </div>
             </div>  
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมายเลขโทรศัพท์เคลื่อนที่ : </div>
              <div class="col-xs-12 col-sm-2">
                  <input type="text" id="ADDRESS_MOBILE" name="ADDRESS_MOBILE" class="form-control mobile" placeholder="หมายเลขโทรศัพท์เคลื่อนที่" value="<?php echo text($rec_main['ADDRESS_MOBILE']); ?>" >
              </div>
              <div class="col-xs-12 col-sm-2"></div>
             <div class="col-xs-12 col-sm-2">อีเมล์ : </div>
             <div class="col-xs-12 col-sm-2">
                  <input type="text" id="ADDRESS_EMAIL" name="ADDRESS_EMAIL" class="form-control" placeholder="อีเมล์" value="<?php echo text($rec_main['ADDRESS_EMAIL']); ?>" >
             </div>  
          </div>
          </div>
           </div>
          </div>
          <div id="div_7">
           <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse13" onClick="$('.switchPic13').toggle();">
                        <img class="switchPic13" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic13" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลธนาคาร
                    </a>
                </div>
            </div> 
           <div id="collapse13" class="collapse">
           		<div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ธนาคาร : </div>
                    <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('BANK_ID','BANK_ID',$arr_bank,'ธนาคาร',$rec_main['BANK_ID'],'','','1');?></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาขา : </div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="BANK_BRANCH" id="BANK_BRANCH" value="<?php echo text($rec_main['BANK_BRANCH']);?>" class="form-control"></div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่บัญชี : </div>
                    <div class="col-xs-12 col-md-2"><input type="text" id="BANK_NO" name="BANK_NO" class="form-control " value="<?php echo text($rec_main['BANK_NO']);?>"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อบัญชี : </div>
                    <div class="col-xs-12 col-md-2"><input type="text" name="BANK_NAME" id="BANK_NAME" value="<?php echo text($rec_main['BANK_NAME']);?>" class="form-control"></div>
                </div>
            </div>
           </div>
           <div id="div_8">
           <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse14" onClick="$('.switchPic14').toggle();">
                        <img class="switchPic14" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic14" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลทายาท
                    </a>
                </div>
            </div> 
           <div id="collapse14" class="collapse">
           	<div class="table-responsive">
           		<table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="5%"><div align="center"><strong><input type="checkbox" name="chk_all_8" id="chk_all_8"  onClick="ChkAll(8)" /></strong></div></th>
                           <th width="10%"><div align="center"><strong>ความสัมพันธ์</strong></div></th>
                          <th width="35%"><div align="center"><strong>ข้อมูลบุคคล</strong></div></th>
                          <th width="35%"><div align="center"><strong>ข้อมูลที่อยู่ติดต่อ</strong></div></th>
                          <th width="14%"><div align="center"><strong>ผู้ขอรับบำเหน็จตกทอด</strong></div></th>
                          <th width="14%"><div align="center"><strong>ธนาคาร</strong></div></th>

                      </tr>
                  </thead>
                  <tbody>
                  <?php
				  $i = 1;
				  $sql_family = "SELECT A.FAMILY_ID, A.FAMILY_IDCARD, A.FAMILY_PREFIX_ID, A.FAMILY_FIRSTNAME_TH, A.FAMILY_MIDNAME_TH, A.FAMILY_LASTNAME_TH,
				  A.FAMILY_STATUS, A.FAMILY_RELATIONSHIP, A.ADDRESS_HOME_NO, A.ADDRESS_POSTCODE, A.ADDRESS_TEL, A.ADDRESS_TEL_EXT, A.ADDRESS_MOBILE,
				  B.TAMB_NAME_TH, C.AMPR_NAME_TH,  D.PROV_TH_NAME
				  FROM PER_FAMILY  A
				  LEFT JOIN SETUP_TAMB B ON A.ADDRESS_TAMB_ID = B.TAMB_ID
				  LEFT JOIN SETUP_AMPR C ON A.ADDRESS_AMPR_ID = C.AMPR_ID
				  LEFT JOIN SETUP_PROV D ON A.ADDRESS_PROV_ID = D.PROV_ID
				  WHERE A.PER_ID = '".$PER_ID."' AND A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0 AND A.FAMILY_RELATIONSHIP <= 5 ";
				  $query_family = $db->query($sql_family);
				  $num_family = $db->db_num_rows($query_family);
				  if($num_family > 0){
				  	while($rec_family = $db->db_fetch_array($query_family)){
						$sel = "";
						$query_family_1 = $db->query("SELECT * FROM PENSION_FAMILY WHERE FAMILY_ID = '".$rec_family['FAMILY_ID']."' AND DELETE_FLAG = 0");
						$rec_family_1 = $db->db_fetch_array($query_family_1);
						if($rec_family['FAMILY_ID'] == $rec_family_1['FAMILY_ID']){
							$sel = "checked";
						}
						
				  ?>
                  <tr bgcolor="#FFFFFF">
                      <td align="center"><input type="checkbox"  name="FAMILY_ID_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="FAMILY_ID_8_<?php echo $i; ?>" value="<?php echo $rec_family['FAMILY_ID']; ?>" <?php echo $sel; ?>  /></td>
                       <td align="center"><?php echo $arr_family_relation[$rec_family['FAMILY_RELATIONSHIP']]; ?></td>
                      <td align="left">
                      	<div><strong>เลขบัตรประจำตัวประชาชน : </strong> <?php echo get_idCard($rec_family['FAMILY_IDCARD']); ?></div>
                      	<div><strong>ชื่อ-สกุล : </strong><?php echo Showname($rec_family["FAMILY_PREFIX_ID"],$rec_family["FAMILY_FIRSTNAME_TH"],$rec_family["FAMILY_MIDNAME_TH"],$rec_family["FAMILY_LASTNAME_TH"]); ?></div>
                      	<div><strong>สถานะการมีชีวิต : </strong><?php echo $arr_family_status[$rec_family['FAMILY_STATUS']]; ?></div>
                      </td>
                      <td align="left">
                      	<div> <strong> บ้านเลขที่ : </strong><?php echo text($rec_family['ADDRESS_HOME_NO']); ?></div>
                        <div> <strong> ตำบล/แขวง : </strong><?php echo text($rec_family['TAMB_NAME_TH']); ?></div>
                        <div> <strong> อำเภอ/เขต : </strong><?php echo text($rec_family['AMPR_NAME_TH']); ?></div>
                        <div> <strong> จังหวัด : </strong><?php echo text($rec_family['PROV_TH_NAME']); ?></div>
                        <div> <strong> รหัสไปรษณีย์ : </strong><?php echo text($rec_family['ADDRESS_POSTCODE']); ?></div>
                        <div> <strong> หมายเลขโทรศัพท์ : </strong><?php echo format_phone($rec_family['ADDRESS_TEL'],"tel","bk",$rec_family['ADDRESS_TEL_EXT']);  ?></div>
                        <div> <strong> หมายเลขโทรศัพท์เคลื่อนที่ : </strong><?php echo format_phone($rec_family['ADDRESS_MOBILE'],"mobile","bk",''); ?></div>
                      </td>
                      <td align="left">
                      <div>สถานะของบุคคล : </div>
                      <div>
                          <?php echo GetHtmlSelect("PENHEIR_CONTACT_FAMILY_SATUS_8_".$i,"PENHEIR_CONTACT_FAMILY_SATUS_8[".$rec_family['FAMILY_ID']."]",$arr_delegate_type,'สถานะของบุคคล',$rec_family_1['PENHEIR_CONTACT_BY']," onChange='ChkTypePer(this);' ",'','1','200','2');?>
                      </div>
                      <div id="family_type_<?php echo $i; ?>">
                          <div> 
                              <?php echo $arr_txt['idcard']; ?> : 
                          </div>
                          <div>
                          <input type="textbox" class="form-control  idcard" name="PENHEIR_CONTACT_IDCARD_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_IDCARD_8_<?php echo $i; ?>" value="<?php echo $rec_family_1['PENHEIR_CONTACT_IDCARD']; ?>"  placeholder="<?php echo $arr_txt['idcard']; ?>" />
                          </div>
                          <div>คำนำหน้าชื่อ :</div>
                          <div>
                          <?php echo GetHtmlSelect("PENHEIR_CONTACT_PREFIX_ID_8_".$i,"PENHEIR_CONTACT_PREFIX_ID_8[".$rec_family['FAMILY_ID']."]",$arr_prefix,'คำนำหน้าชื่อ',$rec_family_1['PENHEIR_CONTACT_PREFIX_ID'],'','','1','200'); ?>
                          </div>
                          <div>ชื่อตัว :</div>
                          <div>
                          <input type="textbox" class="form-control" name="PENHEIR_CONTACT_FIRSTNAME_TH_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_FIRSTNAME_TH_8_<?php echo $i ?>" value="<?php echo text($rec_family_1['PENHEIR_CONTACT_FIRSTNAME_TH']); ?>" placeholder="ชื่อตัว" />
                          </div>
                          <div>ชื่อรอง :</div>
                          <div>
                          <input type="textbox"  class="form-control" name="PENHEIR_CONTACT_MIDNAME_TH_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_MIDNAME_TH_8_<?php echo $i; ?>" value="<?php echo text($rec_family_1['PENHEIR_CONTACT_MIDNAME_TH']); ?>" placeholder="ชื่อรอง" />
                          </div>
                          <div>ชื่อสกุล :</div>
                          <div>
                          <input type="textbox" class="form-control" name="PENHEIR_CONTACT_LASTNAME_TH_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_LASTNAME_TH_8_<?php echo $i; ?>" value="<?php echo text($rec_family_1['PENHEIR_CONTACT_LASTNAME_TH']); ?>"  placeholder="ชื่อสกุล" />
                          </div>
                          <div>มีความสัมพันธ์กับทายาทฯ :</div>
                          <div>
                          <input type="textbox" class="form-control" name="PENHEIR_CONTACT_RELATIONSHIP_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_RELATIONSHIP_8_<?php echo $i; ?>" value="<?php echo text($rec_family_1['PENHEIR_CONTACT_RELATIONSHIP']); ?>"  placeholder="มีความสัมพันธ์กับทายาทฯ" />
                          </div>
                      </div>
                      </td>
                      <td align="left">
                      <div>ธนาคาร :</div>
                      <div>
                      <?php echo GetHtmlSelect("PENHEIR_CONTACT_BANK_ID_8_".$i,"PENHEIR_CONTACT_BANK_ID_8[".$rec_family['FAMILY_ID']."]",$arr_bank,'ธนาคาร',$rec_family_1['BANK_ID'],'','','1','250'); ?>
                      </div>
                      <div>สาขา :</div>
                      <div>
                      <input type="textbox"  class="form-control" name="PENHEIR_CONTACT_BANK_BRANCH_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_BANK_BRANCH_8_<?php echo $i; ?>" value="<?php echo text($rec_family_1['BANK_BRANCH']); ?>" placeholder="สาขา" />
                      </div>
                      <div>เลขที่บัญชี :</div>
                      <div>
                      <input type="textbox" class="form-control" name="PENHEIR_CONTACT_BANK_NO_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_BANK_NO_8_<?php echo $i; ?>" value="<?php echo text($rec_family_1['BANK_NO']); ?>"  placeholder="เลขที่บัญชี" />
                      </div>
                      <div>ชื่อบัญชี :</div>
                      <div>
                      <input type="textbox" class="form-control" name="PENHEIR_CONTACT_BANK_NAME_8[<?php echo $rec_family['FAMILY_ID']; ?>]" id="PENHEIR_CONTACT_BANK_NAME_8_<?php echo $i; ?>" value="<?php echo text($rec_family_1['BANK_NAME']); ?>"  placeholder="ชื่อบัญชี" />
                      </div>
                      </td>
                  </tr>
                  <?php
				    $i++;
				  	}
				  }else{
					  echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
				  }
				 ?>
                </tbody>
              </table>
             </div>
           </div>
           </div>
           <div id="div_9">
           <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse15" onClick="$('.switchPic15').toggle();">
                        <img class="switchPic15" src="<?php echo $path;?>images/exp.gif">
                        <img class="switchPic15" src="<?php echo $path;?>images/clse.gif" style="display:none;"">
                        ข้อมูลผู้ถูกแสดงเจตนารับบำเหน็จตกทอด
                    </a>
                </div>
            </div> 
           <div id="collapse15" class="collapse">
           	<div class="table-responsive">
           		<table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="5%">
                          	<div align="center"><input type="checkbox" name="chk_all_9" id="chk_all_9" value="1" onClick="ChkAll(9)" /> </div>
                          </th>
                          <th width="35%"><div align="center"><strong>ข้อมูลบุคคล</strong></div></th>
                          <th width="10%"><div align="center"><strong>ส่วนที่ได้รับ</strong></div></th>
                          <th width="35%"><div align="center"><strong>ข้อมูลที่อยู่ติดต่อ</strong></div></th>
                          <th width="14%"><div align="center"><strong>ผู้ขอรับบำเหน็จตกทอด</strong></div></th>
                          <th width="14%"><div align="center"><strong>ธนาคาร</strong></div></th>

                      </tr>
                  </thead>
                  <tbody>
                  <?php
				  $i = 1;
				  $sql_heir ="SELECT HEIRDESC_ID, HEIRDESC_IDCARD, HEIRDESC_PART, PREFIX_ID, HEIRDESC_FIRSTNAME_TH, HEIRDESC_MIDNAME_TH, HEIRDESC_LASTNAME_TH, ADDRESS_HOME_NO, ADDRESS_TAMB_ID, ADDRESS_AMPR_ID
				  ADDRESS_PROV_ID, ADDRESS_ZIPCODE, ADDRESS_TEL, ADDRESS_TEL_EXT, ADDRESS_MOBILE, C.TAMB_NAME_TH, D.AMPR_NAME_TH, E.PROV_TH_NAME
				  FROM PER_HEIRHIS A
				  JOIN PER_HEIRHIS_DESC B ON A.HEIR_ID = B.HEIR_ID
				  LEFT JOIN SETUP_TAMB C ON B.ADDRESS_TAMB_ID = C.TAMB_ID 
				  LEFT JOIN SETUP_AMPR D ON B.ADDRESS_AMPR_ID = D.AMPR_ID 
				  LEFT JOIN SETUP_PROV E ON B.ADDRESS_PROV_ID = E.PROV_ID
				  WHERE A.PER_ID = '".$PER_ID. "'  AND A.DELETE_FLAG = 0 AND A.ACTIVE_STATUS = 1
				  order by HEIRDESC_FIRSTNAME_TH ASC ";
				  $query_heir = $db->query($sql_heir);
				  $num_heir = $db->db_num_rows($query_heir);
				  if($num_heir > 0){
					  while($rec_heir = $db->db_fetch_array($query_heir)){
						  $sel = '';
						  $query_heir_1 = $db->query("SELECT * FROM PENSION_HEIR_DESC WHERE HEIRDESC_ID = '".$rec_heir['HEIRDESC_ID']."' AND DELETE_FLAG = 0 ");
						  $rec_heir_1 = $db->db_fetch_array($query_heir_1);
						  if($rec_heir['HEIRDESC_ID'] == $rec_heir_1['HEIRDESC_ID']){
							  $sel = "checked";
						  }
				  ?>
                  
                <tr bgcolor="#FFFFFF">
                    <td align="center"><input type="checkbox"  name="HEIRDESC_ID_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="HEIRDESC_ID_9_<?php echo $i; ?>" value="<?php echo $rec_heir['HEIRDESC_ID']; ?>" <?php echo $sel; ?>  /></td>
                    <td align="left">
                  	 <div><strong>เลขบัตรประจำตัวประชาชน : </strong> <?php echo get_idCard($rec_heir['HEIRDESC_IDCARD']); ?></div>
                   	 <div><strong>ชื่อ-สกุล : </strong><?php echo Showname($rec_heir["PREFIX_ID"],$rec_heir["HEIRDESC_FIRSTNAME_TH"],$rec_heir["HEIRDESC_MIDNAME_TH"],$rec_heir["HEIRDESC_LASTNAME_TH"]); ?></div>
                    </td>
                    <td align="center"><?php echo $rec_heir['HEIRDESC_PART']; ?></td>
                    <td align="left">
                      <div> <strong> บ้านเลขที่ : </strong><?php echo text($rec_heir['ADDRESS_HOME_NO']); ?></div>
                      <div> <strong> ตำบล/แขวง : </strong><?php echo text($rec_heir['TAMB_NAME_TH']); ?></div>
                      <div> <strong> อำเภอ/เขต : </strong><?php echo text($rec_heir['AMPR_NAME_TH']); ?></div>
                      <div> <strong> จังหวัด : </strong><?php echo text($rec_heir['PROV_TH_NAME']); ?></div>
                      <div> <strong> รหัสไปรษณีย์ : </strong><?php echo text($rec_heir['ADDRESS_POSTCODE']); ?></div>
                      <div> <strong> หมายเลขโทรศัพท์ : </strong><?php echo format_phone($rec_heir['ADDRESS_TEL'],"tel","bk",$rec_heir['ADDRESS_TEL_EXT']);  ?></div>
                      <div> <strong> หมายเลขโทรศัพท์เคลื่อนที่ : </strong><?php echo format_phone($rec_heir['ADDRESS_MOBILE'],"mobile","bk",''); ?></div>
                    </td>
                    <td align="left">
                    <div>สถานะของบุคคล : </div>
                   	<div>
                    	<?php echo GetHtmlSelect('PENHEIR_CONTACT_FRAMILY_STATUS_9_'.$i,"PENHEIR_CONTACT_FRAMILY_STATUS_9[".$rec_heir['HEIRDESC_ID']."]",$arr_delegate_type,'สถานะของบุคคล',$rec_heir_1['CONTACT_BY'],"onChange='ChkTypePer(this);' ",'','1','200','2');?>
                    </div>
                    <div id="heir_type_<?php echo $i; ?>">
                        <div> 
                            <?php echo $arr_txt['idcard']; ?> : 
                        </div>
                        <div>
                        <input type="textbox" class="form-control  idcard" name="PENHEIR_CONTACT_IDCARD_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="NAMEHIS_BECAUSE_9_<?php echo $i; ?>" value="<?php echo get_idCard($rec_heir_1['CONTACT_IDCARD']);?>"  placeholder="<?php echo $arr_txt['idcard']; ?>" />
                        </div>
                        <div>คำนำหน้าชื่อ :</div>
                        <div>
                        <?php echo GetHtmlSelect('PENHEIR_CONTACT_PREFIX_ID_9_'.$i,"PENHEIR_CONTACT_PREFIX_ID_9[".$rec_heir['HEIRDESC_ID']."]",$arr_prefix,'คำนำหน้าชื่อ',$rec_heir_1['CONTACT_PREFIX_ID'],'','','1','200'); ?>
                        </div>
                        <div>ชื่อตัว :</div>
                        <div>
                        <input type="textbox" class="form-control" name="PENHEIR_CONTACT_FIRSTNAME_TH_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]"  id="PENHEIR_CONTACT_FIRSTNAME_TH_9_<?php echo $i; ?>" value="<?php echo text($rec_heir_1['CONTACT_FIRSTNAME_TH']); ?>" placeholder="ชื่อตัว" />
                        </div>
                        <div>ชื่อรอง :</div>
                        <div>
                        <input type="textbox"  class="form-control" name="PENHEIR_CONTACT_MIDNAME_TH_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="PENHEIR_CONTACT_MIDNAME_TH_9_<?php echo $i; ?>" value="<?php echo text($rec_heir_1['CONTACT_MIDNAME_TH']); ?>" placeholder="ชื่อรอง" />
                        </div>
                        <div>ชื่อสกุล :</div>
                        <div>
                        <input type="textbox" class="form-control" name="PENHEIR_CONTACT_LASTNAME_TH_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="PENHEIR_CONTACT_LASTNAME_TH_9_<?php echo $rec_heir['HEIRDESC_ID']; ?>" value="<?php echo text($rec_heir_1['CONTACT_LASTNAME_TH']); ?>"  placeholder="ชื่อสกุล" />
                        </div>
                    </div>
                    </td>
                    <td align="left">
                    <div>ธนาคาร :</div>
                    <div>
                    <?php echo GetHtmlSelect('PENHEIR_CONTACT_BANK_ID_9_'.$i,"PENHEIR_CONTACT_BANK_ID_9[".$rec_heir['HEIRDESC_ID']."]",$arr_bank,'ธนาคาร',$rec_heir_1['BANK_ID'],'','','1','250'); ?>
                    </div>
                    <div>สาขา :</div>
                    <div>
                    <input type="textbox"  class="form-control" name="PENHEIR_CONTACT_BANK_BRANCH_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="PENHEIR_CONTACT_BANK_BRANCH_9_<?php echo $i; ?>" value="<?php echo text($rec_heir_1['BANK_BRANCH']); ?>" placeholder="สาขา" />
                    </div>
                    <div>เลขที่บัญชี :</div>
                    <div>
                    <input type="textbox" class="form-control" name="PENHEIR_CONTACT_BANK_NO_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="PENHEIR_CONTACT_BANK_NO_9_<?php echo $i; ?>" value="<?php echo text($rec_heir_1['BANK_NO']); ?>"  placeholder="เลขที่บัญชี" />
                    </div>
                    <div>ชื่อบัญชี :</div>
                    <div>
                    <input type="textbox" class="form-control" name="PENHEIR_CONTACT_BANK_NAME_9[<?php echo $rec_heir['HEIRDESC_ID']; ?>]" id="PENHEIR_CONTACT_BANK_NAME_9_<?php echo $i; ?>" value="<?php echo text($rec_heir_1['BANK_NAME']); ?>"  placeholder="ชื่อบัญชี" />
                    </div>
                    </td>
                </tr>
                <?php
				 $i++;
				 }
                }else{
					echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
				}
				?>
                </tbody>
              </table>
             </div>
           </div> 
          </div>   
		</div>
        <br>
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" 
          onClick="self.location.href='pension_record_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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
<?php 

?>