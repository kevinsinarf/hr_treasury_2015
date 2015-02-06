<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$ATTENTYPE_ID=$_POST['ATTENTYPE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

//DATA
$sql = "select * FROM PER_PROFILE where PER_ID = '".$PER_ID."' ";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);
//คำนำหน้าชื่อ
$sql_prefix = "SELECT * FROM SETUP_PREFIX WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY PREFIX_NAME_TH asc ";
$query_prefix= $db->query($sql_prefix);
//เชื่อชาติ
$arr_nation=GetSqlSelectArray("NATION_ID", "NATION_NAME_TH", "SETUP_NATION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "NATION_NAME_TH");
//ศาสนา 
$arr_religion=GetSqlSelectArray("RELIGION_ID", "RELIGION_NAME_TH", "SETUP_RELIGION", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "RELIGION_NAME_TH");
//สถานะของบุคคล   
$arr_per_status=$arr_address;
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
<script src="js/profile_his_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="setup_meet_atten.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
			<div class="row heading"><?php echo $txt;?></div>
            <form id="frm-input" method="post" action="process/profile_his_proc.php" enctype="multipart/form-data" >
            	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
            	<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden1" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">
				
				<div class="row ">
					<div class="col-xs-12 col-sm-10" >
						<div class="row formSep visible-xs">
							<div class="col-xs-12 col-md-6 col-sm-offset-2">
								<div class="col-xs-6 col-md-6"><?php echo showPic_ss($data['PER_IDCARD']);?></div>
							</div>
						</div>
						 <div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">นำเข้าไฟล์รูปภาพ :&nbsp;</div>
							<div class="col-xs-12 col-sm-4">
								 <div id="RET"  class="input-group"  >
									  <input type="file" id="PER_FILE_PIC" name="PER_FILE_PIC" maxlength="100"
											class="form-control" placeholder="นำเข้าไฟล์ " 
											value="<?php echo text($data["PER_FILE_PIC"]); ?>">   
											 <input type="hidden" id="ODL_FILE_PIC" name="ODL_FILE_PIC"   value="<?php echo text($data["PER_FILE_PIC"]); ?>"> 
										<?php echo $data["DOC_FILE"]!=''?displayDownloadFileAttach($path,text($data["DOC_FILE"]),  $arr_txt['download']):''; ?>
								</div>		
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ไฟล์แบบฟอร์มสมาชิก กบข :&nbsp;</div>
							<div class="col-xs-12 col-sm-4">
								 <div id="RET"  class="input-group"  >
									  <input type="file" id="PER_FILE_GPF" name="PER_FILE_GPF" maxlength="100"
											class="form-control" placeholder="นำเข้าไฟล์ " 
											value="<?php echo text($data["PER_FILE_GPF"]); ?>">   
											 <input type="hidden" id="ODL_FILE_GPF" name="ODL_FILE_GPF"   value="<?php echo text($data["PER_FILE_GPF"]); ?>"> 
										<?php echo $data["PER_FILE_GPF"]!=''?displayDownloadFileAttach($path,text($data["PER_FILE_GPF"]),  $arr_txt['download']):''; ?>
								</div>		
							</div>
						</div>	
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['idcard'];?><span style="color:red;">*</span>&nbsp;
							</div>
							<div class="col-xs-12 col-sm-4">
								<input type="text" id="idcard" name="idcard" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $data['PER_IDCARD']; ?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">รหัสประเภทบุคลากร :</div>
							<div class="col-xs-12 col-sm-4">
								<input type="text" id="PT_ID" name="PT_ID" class="form-control" placeholder="รหัสประเภทบุคลากร " value="<?php echo $data['PT_ID']; ?>">
							</div> 
						</div>			
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2"><?php echo $arr_txt['title'];?> <span style="color:red;">*</span>&nbsp;</div>
							<div class="col-xs-12 col-sm-4 ">
								<select id="PREFIX" name="PREFIX" class="selectbox form-control" placeholder="<?php echo $arr_txt['title'];?>">
									<option value=""></option>
										 <?php while($rec_prefix = $db->db_fetch_array($query_prefix)){  ?>
											<option value="<?php echo $rec_prefix['PREFIX_ID'] ?>" <?php echo ($rec_prefix['PREFIX_ID'] == $data['PREFIX_ID']?"selected":"");?>><?php echo text($rec_prefix['PREFIX_NAME_TH'])?></option>
										<?php }?>
								</select>
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">เพศ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
							<div class="col-xs-6 col-md-1">
								<label ><input type="radio" id="GENDER1" name="GENDER"  value="1" <?php echo ($data['PER_GENDER']=='1'||$data['PER_GENDER']=='' ?"checked":"")?>>ชาย</label>
							</div>
							<div class="col-xs-6 col-md-1">
								<label ><input type="radio" id="GENDER2" name="GENDER" value="2" <?php echo ($data['PER_GENDER']=='2'?"checked":"")?> >หญิง</label>
							</div>
						</div>			
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมู่โลหิต :</div>
							<div class="col-xs-12 col-sm-4">
								<input type="text" id="BLOOD_TYPE" name="BLOOD_TYPE" class="form-control" placeholder="หมู่โลหิต" value="<?php echo text($data['PER_BLOOD_TYPE']) ;?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันเดือนปีเกิด</div>
							<div class="col-xs-12 col-sm-4">
								<div class="input-group">
									<input type="text" id="DATE_BIRTH" name="DATE_BIRTH" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_BIRTH"]);?>">
									<span class="input-group-addon datepicker" for="DATE_BIRTH" >&nbsp;
									<span class="glyphicon glyphicon-calendar"></span>&nbsp;
									</span>
								</div>	
							</div> 
						</div>	
					</div>
					<!-- -->
					<div class="col-xs-12 col-sm-2 visible-lg"  >
						<div class="col-xs-12 col-sm-10">
							<?php echo showPic_ss($data['PER_IDCARD']);?>
						</div>
					</div>
					<div class="row" >
					</div>
					<!-- -->
					<div class="col-xs-12 col-sm-12">						
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['fname'].$arr_txt['th']; ?><span style="color:red;">*</span>
							</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="fname_th" name="fname_th" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['th']; ?>" value="<?php echo text($data['PER_FIRSTNAME_TH']) ;?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['mname'].$arr_txt['th']; ?> <span style="color:red;">*</span>
							</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="mname_th" name="mname_th" class="form-control" placeholder="<?php echo $arr_txt['mname'].$arr_txt['th']; ?>" value="<?php echo text($data['PER_MIDNAME_TH']) ;?>">
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['lname'].$arr_txt['th']; ?><span style="color:red;">*</span>
							</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="lname_th" name="lname_th" class="form-control" placeholder="<?php echo $arr_txt['lname'].$arr_txt['th']; ?>" value="<?php echo text($data['PER_LASTNAME_TH']) ;?>">
							</div>							
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['fname'].$arr_txt['en']; ?> <span style="color:red;">*</span>
							</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="fname_en" name="fname_en" class="form-control" placeholder="<?php echo $arr_txt['fname'].$arr_txt['en']; ?>" value="<?php echo text($data['PER_FIRSTNAME_EN']) ;?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['mname'].$arr_txt['en']; ?> <span style="color:red;">*</span>
							</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="mname_en" name="mname_en" class="form-control" placeholder="<?php echo $arr_txt['mname'].$arr_txt['en']; ?>" value="<?php echo text($data['PER_MIDNAME_EN']) ;?>">
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">
								<?php echo $arr_txt['lname'].$arr_txt['en']; ?> <span style="color:red;">*</span>
							</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="lname_en" name="lname_en" class="form-control" placeholder="<?php echo $arr_txt['lname'].$arr_txt['en']; ?>" value="<?php echo text($data['PER_LASTNAME_EN']) ;?>">
							</div>							
						</div>	
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">สัญชาติ :</div>
							<div class="col-xs-12 col-sm-2">
								<?php  echo GetHtmlSelect('NATION_S','NATION_S',$arr_nation,'สัญชาติ',$data['NATION_ID'],'','','1');?>
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">เชื้อชาติ :</div>
							<div class="col-xs-12 col-sm-2">
								<?php  echo GetHtmlSelect('NATION_CH','NATION_CH',$arr_nation,'เชื้อชาติ',$data['NATION_ID'],'','','1');?>
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ศาสนา<?php echo $data['RELIGION_ID']; ?></div>
							<div class="col-xs-12 col-sm-2">
								<?php  echo GetHtmlSelect('RELIGION','RELIGION',$arr_religion,'ศาสนา',$data['RELIGION_ID'],'','','1');?>
							</div>							
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">สีผิว :</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="SKIN_COLOR" name="SKIN_COLOR" class="form-control" placeholder="สีผิว" maxlength="255"  value="<?php echo  text($data["PER_SKIN_COLOR"]);?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ส่วนสูง (ซ.ม.) :</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="WEIGHT" name="WEIGHT" class="form-control" placeholder="น้ำหนัก (ก.ก.)" maxlength="3"  value="<?php echo  text($data["PER_WEIGHT"]);?>">
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">น้ำหนัก (ก.ก.)</div>
							<div class="col-xs-12 col-sm-2">
								<input type="text" id="HEIGHT" name="HEIGHT" class="form-control" placeholder="น้ำหนัก (ก.ก.)" maxlength="3"  value="<?php echo  text($data["PER_HEIGHT"]);?>">
							</div>							
						</div>	
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">รอยตำหนิ :</div>
							<div class="col-xs-12 col-sm-8">
								<input type="text" id="SKIN_MARKUP" name="SKIN_MARKUP" class="form-control" placeholder="รอยตำหนิ" maxlength="255"  value="<?php echo  text($data["PER_SKIN_MARKUP"]);?>">
							</div> 

									
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทตำแหน่ง :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="TYPE_ID" name="TYPE_ID" class="form-control" placeholder="ประเภทตำแหน่ง" maxlength="255"  value="<?php echo  text($data["TYPE_ID"]);?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ระดับตำแหน่ง :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="LEVEL_ID" name="LEVEL_ID" class="form-control" placeholder="ระดับตำแหน่ง" maxlength="255"  value="<?php echo  text($data["LEVEL_ID"]);?>">
							</div> 
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในสายงาน :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="LINE_ID" name="LINE_ID" class="form-control" placeholder="ตำแหน่งในสายงาน" maxlength="255"  value="<?php echo  text($data["LINE_ID"]);?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ตำแหน่งในการบริหาร :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="MANAGE_ID" name="MANAGE_ID" class="form-control" placeholder="ตำแหน่งในการบริหาร" maxlength="255"  value="<?php echo  text($data["MANAGE_ID"]);?>">
							</div> 
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">เงินเดือน/ค่าตอบแทน/ค่าจ้าง :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="SALARY" name="SALARY" class="form-control" placeholder="เงินเดือน/ค่าตอบแทน/ค่าจ้าง" maxlength="255"  value="<?php echo  text($data["PER_SALARY"]);?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">เงินประจำตำแหน่ง :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="SALARY_POSITION" name="SALARY_POSITION" class="form-control" placeholder="เงินประจำตำแหน่ง" maxlength="255"  value="<?php echo  text($data["PER_SALARY_POSITION"]);?>">
							</div> 
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ค่าตอบแทน:</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="COMPENSATION_1" name="COMPENSATION_1" class="form-control" placeholder="ค่าตอบแทน" maxlength="255"  value="<?php echo  text($data["PER_COMPENSATION_1"]);?>">
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ค่าตอบแทนพิเศษ :</div>
							<div class="col-xs-12 col-sm-3">
								<input type="text" id="COMPENSATION_2" name="COMPENSATION_2" class="form-control" placeholder="ค่าตอบแทนพิเศษ" maxlength="255"  value="<?php echo  text($data["PER_COMPENSATION_2"]);?>">
							</div> 
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่บรรจุ :</div>
							<div class="col-xs-12 col-sm-3">
								<div class="input-group">
									<input type="text" id="DATE_ENTRANCE" name="DATE_ENTRANCE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_ENTRANCE"]);?>">
									<span class="input-group-addon datepicker" for="DATE_ENTRANCE" >&nbsp;
									<span class="glyphicon glyphicon-calendar"></span>&nbsp;
									</span>
								</div>
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่เข้าส่วนราชการ</div>
							<div class="col-xs-12 col-sm-3">
								<div class="input-group">
									<input type="text" id="DATE_OCCUPLY" name="DATE_OCCUPLY" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_OCCUPLY"]);?>">
									<span class="input-group-addon datepicker" for="DATE_OCCUPLY" >&nbsp;
									<span class="glyphicon glyphicon-calendar"></span>&nbsp;
									</span>
								</div>	
							</div> 
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่ออกจากราชการ :</div>
							<div class="col-xs-12 col-sm-3">
								<div class="input-group">
									<input type="text" id="DATE_RESIGN" name="DATE_RESIGN" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_RESIGN"]);?>">
									<span class="input-group-addon datepicker" for="DATE_RESIGN" >&nbsp;
									<span class="glyphicon glyphicon-calendar"></span>&nbsp;
									</span>
								</div>
							</div> 
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">กำหนดวันเกษียณราชการ :</div>
							<div class="col-xs-12 col-sm-3">
								<div class="input-group">
									<input type="text" id="DATE_RETIRE" name="DATE_RETIRE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo  conv_date($data["PER_DATE_RETIRE"]);?>">
									<span class="input-group-addon datepicker" for="DATE_RETIRE" >&nbsp;
									<span class="glyphicon glyphicon-calendar"></span>&nbsp;
									</span>
								</div>	
							</div> 
						</div>	
						<div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">สถานะของบุคคล:</div>
							<div class="col-xs-12 col-sm-3">
								<?php  echo GetHtmlSelect('PER_STATUS','PER_STATUS',$arr_per_status,'สถานะของบุคคล',$data['PER_STATUS'],'','','1');?>
							</div> 
							</div> 

									
						</div>						
						 <div class="row formSep">
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ไฟล์แบบฟอร์มชั้นความลับ รปภ 1:&nbsp;</div>
							<div class="col-xs-12 col-sm-3">
								 <div id="RET"  class="input-group"  >
									  <input type="file" id="PER_FILE_SECRET" name="PER_FILE_SECRET" maxlength="100"
											class="form-control" placeholder="นำเข้าไฟล์ " 
											value="<?php echo text($data["PER_FILE_SECRET"]); ?>">   
											 <input type="hidden" id="ODL_FILE_SECRET" name="ODL_FILE_SECRET"   value="<?php echo text($data["PER_FILE_SECRET"]); ?>"> 
										<?php echo displayDownloadFileAttach($path,text($data["PER_FILE_SECRET"]),  $arr_txt['download']); ?>
								</div>		
							</div>
							<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ไฟล์ ก.พ. 7:&nbsp;</div>
							<div class="col-xs-12 col-sm-3">
								 <div id="RET"  class="input-group"  >
									  <input type="file" id="PER_FILE_MAIN" name="PER_FILE_MAIN" maxlength="100"
											class="form-control" placeholder="นำเข้าไฟล์ " 
											value="<?php echo text($rec["PER_FILE_MAIN"]); ?>">   
											 <input type="hidden" id="ODL_FILE_MAIN" name="ODL_FILE_MAIN"   value="<?php echo text($data["PER_FILE_MAIN"]); ?>"> 
										<?php echo displayDownloadFileAttach($path,text($data["PER_FILE_MAIN"]),  $arr_txt['download']) ?>
								</div>		
							</div>
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-sm-3" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;<span style="color:red;">*</span>&nbsp;</div>
							<div class="col-xs-6 col-md-1">
								<label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($data['ACTIVE_STATUS']=='1'||$data['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>
							</div>
							<div class="col-xs-6 col-md-1">
								<label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($data['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label>
							</div>
						</div>						
					</div>
				</div> 
				
				<div class="row">
					<div class="col-xs-12 col-sm-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='profile_his_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
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