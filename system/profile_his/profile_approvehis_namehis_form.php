<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

//POST
$PER_ID=$_POST['PER_ID'];
$NAMEHIS_ID=$_POST['NAMEHIS_ID'];

$txt = "เปลี่ยนแปลงข้อมูล";
//ประเภทบุคลากร
$arr_personal_type = GetSqlSelectArray("PT_ID", "PT_NAME_TH", "PERSONAL_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PT_NAME_TH");
//ข้อมูลที่ขอเปลี่ยนแปลง
$arr_request_table = GetSqlSelectArray("TABLE_ID", "TABLE_DESCRIPTION", "PER_TABLE_LIST", " 1=1 ", "TABLE_DESCRIPTION");
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th

//DATA
$sql = "SELECT PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, PER_FIRSTNAME_EN, PER_MIDNAME_EN, PER_LASTNAME_EN FROM PER_PROFILE WHERE PER_ID = '".$PER_ID."'";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);
$NAMEHIS_LAST_PREFIX_ID = $data['PREFIX_ID'];
$NAMEHIS_LAST_FIRSTNAME_TH = $data['PER_FIRSTNAME_TH'];
$NAMEHIS_LAST_MIDNAME_TH= $data['PER_MIDNAME_TH'];
$NAMEHIS_LAST_LASTNAME_TH= $data['PER_LASTNAME_TH'];
$NAMEHIS_LAST_FIRSTNAME_EN= $data['PER_FIRSTNAME_EN'];
$NAMEHIS_LAST_MIDNAME_EN= $data['PER_MIDNAME_EN'];
$NAMEHIS_LAST_LASTNAME_EN = $data['PER_LASTNAME_EN'];
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
<script src="js/profile_approvehis_namehis.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="profile_approvehis.php?<?php echo url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_approvehis_list.php?<?php echo url2code($link2); ?>">บุคลากรที่ขอเปลี่ยนแปลงประวัติ</a></li>
	  <li class="active">ประวัติการเปลี่ยนคำนำหน้า ชื่อ ชื่อกลาง ชื่อสกุล</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_approvehis_namehis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="NAMEHIS_ID" name="NAMEHIS_ID"  value="<?php echo $NAMEHIS_ID; ?>">
        
        <div class="row formSep">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ข้อมูลที่ต้องการเปลี่ยนแปลง : &nbsp; </div>
			<div class="col-xs-12 col-sm-4"><?php echo GetHtmlSelect('TABLE_ID','TABLE_ID',$arr_request_table,"ข้อมูลที่ต้องการเปลี่ยนแปลง",$TABLE_ID,'onchange=\'getTable_URL(this.value);\'','','1');?></div>  
     	</div> 
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">วันที่ขอเปลี่ยนแปลง :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-2">
                <div class="input-group">
                    <input type="text" id="REQUEST_DATETIME" name="REQUEST_DATETIME" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" 
                    value="">
                    <span class="input-group-addon datepicker" for="REQUEST_DATETIME" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>						
            </div>
            <div class="col-xs-12 col-sm-2"></div>
			<div class="col-xs-12 col-sm-2">วันที่เปลี่ยนชื่อ - สกุล :&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2">
                <div class="input-group">
                    <input type="text" id="NAMEHIS_CHANGEDATE" name="NAMEHIS_CHANGEDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo  conv_date($data["NAMEHIS_CHANGEDATE"]);?>">
                    <span class="input-group-addon datepicker" for="NAMEHIS_CHANGEDATE" >&nbsp;
                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>						
            </div>
        </div>
        
        <div class="row formSep">
			<div class="col-xs-12 col-sm-2">รายละเอียดการเปลี่ยนแปลง :&nbsp;<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_DETAIL_1" id="NAMEHIS_DETAIL_1" value="1" onClick="chkDetail('shw_prefix', 'NAMEHIS_DETAIL_1');" <?php if($data['NAMEHIS_DETAIL_1'] == 1){ echo "checked";}?> />&nbsp;คำนำหน้าชื่อ</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_DETAIL_2" id="NAMEHIS_DETAIL_2" value="1" onClick="chkDetail('shw_fname', 'NAMEHIS_DETAIL_2');" <?php if($data['NAMEHIS_DETAIL_2'] == 1){ echo "checked";}?> />&nbsp;ชื่อตัว</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_DETAIL_3" id="NAMEHIS_DETAIL_3" value="1" onClick="chkDetail('shw_mname', 'NAMEHIS_DETAIL_3');" <?php if($data['NAMEHIS_DETAIL_3'] == 1){ echo "checked";}?> />&nbsp;ชื่อรอง</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_DETAIL_4" id="NAMEHIS_DETAIL_4" value="1" onClick="chkDetail('shw_lname', 'NAMEHIS_DETAIL_4');" <?php if($data['NAMEHIS_DETAIL_4'] == 1){ echo "checked";}?> />&nbsp;ชื่อสกุล</div>			            
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-2">สาเหตุการเปลี่ยนแปลง :&nbsp;</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_1" id="NAMEHIS_BECAUSE_1" value="1" onClick="chkDetail('shw_ref_1', 'NAMEHIS_BECAUSE_1');" <?php if($data['NAMEHIS_BECAUSE_1'] == 1){ echo "checked";}?> />&nbsp;จดทะเบียนสมรส</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_2" id="NAMEHIS_BECAUSE_2" value="1" onClick="chkDetail('shw_ref_2', 'NAMEHIS_BECAUSE_2');" <?php if($data['NAMEHIS_BECAUSE_2'] == 1){ echo "checked";}?> />&nbsp;จดทะเบียนหย่า</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_3" id="NAMEHIS_BECAUSE_3" value="1" onClick="chkDetail('shw_ref_3', 'NAMEHIS_BECAUSE_3');" <?php if($data['NAMEHIS_BECAUSE_3'] == 1){ echo "checked";}?> />&nbsp;เปลี่ยนชื่อตัว</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_4" id="NAMEHIS_BECAUSE_4" value="1" onClick="chkDetail('shw_ref_4', 'NAMEHIS_BECAUSE_4');" <?php if($data['NAMEHIS_BECAUSE_4'] == 1){ echo "checked";}?> />&nbsp;ตั้งชื่อ-สกุลใหม่</div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_5" id="NAMEHIS_BECAUSE_5" value="1" onClick="chkDetail('shw_ref_5', 'NAMEHIS_BECAUSE_5');" <?php if($data['NAMEHIS_BECAUSE_5'] == 1){ echo "checked";}?> />&nbsp;ขอใช้ชื่อ-สกุลร่วม</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_6" id="NAMEHIS_BECAUSE_6" value="1" onClick="chkDetail('shw_ref_6', 'NAMEHIS_BECAUSE_6');" <?php if($data['NAMEHIS_BECAUSE_6'] == 1){ echo "checked";}?> />&nbsp;เปลี่ยนชื่อ-สกุล</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_7" id="NAMEHIS_BECAUSE_7" value="1" onClick="chkDetail('shw_ref_7', 'NAMEHIS_BECAUSE_7');" <?php if($data['NAMEHIS_BECAUSE_7'] == 1){ echo "checked";}?> />&nbsp;เพิ่มชื่อรอง</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_8" id="NAMEHIS_BECAUSE_8" value="1" onClick="chkDetail('shw_ref_8', 'NAMEHIS_BECAUSE_8');" <?php if($data['NAMEHIS_BECAUSE_8'] == 1){ echo "checked";}?> />&nbsp;เปลี่ยนชื่อรอง</div>
        </div>           
     	   
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_9" id="NAMEHIS_BECAUSE_9" value="1" onClick="chkDetail('shw_ref_9', 'NAMEHIS_BECAUSE_9');" <?php if($data['NAMEHIS_BECAUSE_9'] == 1){ echo "checked";}?> />&nbsp;ยกเลิกการใช้ชื่อรอง</div>
            <div class="col-xs-12 col-md-2"><input type="checkbox" name="NAMEHIS_BECAUSE_10" id="NAMEHIS_BECAUSE_10" value="1" onClick="chkDetail('shw_other', 'NAMEHIS_BECAUSE_10');" <?php if($data['NAMEHIS_BECAUSE_10'] == 1){ echo "checked";}?>/>&nbsp;อื่นๆ</div>
            <span id="shw_other">
            	<div class="col-xs-12 col-md-2">โปรดระบุ :</div>
                <div class="col-xs-12 col-md-2"><input type="text" name="NAMEHIS_BECAUSE_DESC" id="NAMEHIS_BECAUSE_DESC" class="form-control" value="<?php echo $NAMEHIS_BECAUSE_DESC;?>" /></div>
            </span>
        </div>   
			
        <div class="row formSep">
			<div class="col-xs-12 col-sm-2">ไฟล์แนบ :&nbsp;</div>
            <div class="col-xs-12 col-md-3">
            	<div class="input-group">
                <input type= "file" id="NAMEHIS_FILE" name="NAMEHIS_FILE" class="form-control"  value="<?php echo text($data["NAMEHIS_FILE"]);?>" >
				<?php echo displayDownloadFileAttach($path_a,trim($data['NAMEHIS_FILE']),$arr_txt['download']);?>
                </div>		
                <input type="hidden" id="OLD_NAMEHIS_FILE" name="OLD_NAMEHIS_FILE"   value="<?php echo !empty($data["NAMEHIS_FILE"])?text($data["NAMEHIS_FILE"]):""; ?>">
			</div>
        </div>
			
        <div class="row formSep">
			<div class="col-xs-12 col-sm-2">หมายเหตุ :&nbsp;</div>
            <div class="col-xs-12 col-md-6"><input type="text" id="NAMEHIS_NOTE" name="NAMEHIS_NOTE" class="form-control" maxlength="255" value="<?php echo text($data["NAMEHIS_NOTE"]); ?>"></div>	
        </div>

    	<div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic1').toggle();">
                        <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                        เอกสารอ้างอิง
                    </a>
                </div>
            </div>
            
            <div id="collapse2" class="collapse in">
				<div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-condensed">
                        <thead>
                            <tr class="bgHead">
                                <th width="20%"><div align="center"><strong>รายการ</strong></div></th>
                                <th width="13%"><div align="center"><strong>จังหวัด</strong> </div></th>
                                <th width="13%"><div align="center"><strong>อำเภอ/เขต</strong> </div></th>
                                <th width="15%"><div align="center"><strong>เลขที่เอกสาร</strong> </div></th>
                                <th width="15%"><div align="center"><strong>ลงวันที่</strong> </div></th>
                                <th width="15%"><div align="center"><strong>ไฟล์แนบ</strong> </div></th>
                            </tr>
                        </thead>
						<tbody>	
                        	<tr id="shw_ref_1">
                        		<td align="left">การสมรส</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_1', 'PROV_ID_1', $arr_prov, 'จังหวัด', $A_PROV_ID['1'], 'onchange="getRampr(this,\'AMRP_ID_1\',\'TAMB_ID_1\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_1'><?php echo GetHtmlSelect('AMRP_ID_1', 'AMRP_ID_1', $arr_ampr_1, 'อำเภอ/เขต', $A_AMRP_ID['1'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_1" id="NAMEDESC_NO_1" class = "form-control" value="<?php echo $A_NAMEDESC_NO['1'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_1" name="NAMEDESC_DATE_1" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['1']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_1" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_1" name="NAMEDESC_FILE_1" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['1'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['1'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_1" name="OLD_NAMEDESC_FILE_1"   value="<?php echo !empty($A_NAMEDESC_FILE['1'])?text($A_NAMEDESC_FILE['1']):""; ?>">
                                </td>
                        	</tr>
                            
                        	<tr id="shw_ref_2">
                        		<td align="left">การหย่า</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_2', 'PROV_ID_2', $arr_prov, 'จังหวัด', $A_PROV_ID['2'], 'onchange="getRampr(this,\'AMRP_ID_2\',\'TAMB_ID_2\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_2'><?php echo GetHtmlSelect('AMRP_ID_2', 'AMRP_ID_2', $arr_ampr_2, 'อำเภอ/เขต', $A_AMRP_ID['2'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_2" id="NAMEDESC_NO_2" class = "form-control" value="<?php echo $A_NAMEDESC_NO['2'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_2" name="NAMEDESC_DATE_2" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['2']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_2" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_2" name="NAMEDESC_FILE_2" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['2'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['2'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_2" name="OLD_NAMEDESC_FILE_2" value="<?php echo !empty($A_NAMEDESC_FILE['2'])?text($A_NAMEDESC_FILE['2']):""; ?>">
                                </td>
                        	</tr>
                            
                        	<tr id="shw_ref_3">
                        		<td align="left">การเปลี่ยนชื่อตัว</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_3', 'PROV_ID_3', $arr_prov, 'จังหวัด', $A_PROV_ID['3'], 'onchange="getRampr(this,\'AMRP_ID_3\',\'TAMB_ID_3\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_3'><?php echo GetHtmlSelect('AMRP_ID_3', 'AMRP_ID_3', $arr_ampr_3, 'อำเภอ/เขต', $A_AMRP_ID['3'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_3" id="NAMEDESC_NO_3" class = "form-control" value="<?php echo $A_NAMEDESC_NO['3'];;?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_3" name="NAMEDESC_DATE_3" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['3']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_3" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_3" name="NAMEDESC_FILE_3" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['3'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['3'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_3" name="OLD_NAMEDESC_FILE_3" value="<?php echo !empty($A_NAMEDESC_FILE['3'])?text($A_NAMEDESC_FILE['3']):""; ?>">
                                </td>
                        	</tr>
                            
                            <tr id="shw_ref_4">
                        		<td align="left">การตั้งชื่อสกุลใหม่</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_4', 'PROV_ID_4', $arr_prov, 'จังหวัด', $A_PROV_ID['4'], 'onchange="getRampr(this,\'AMRP_ID_4\',\'TAMB_ID_4\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_4'><?php echo GetHtmlSelect('AMRP_ID_4', 'AMRP_ID_4', $arr_ampr_4, 'อำเภอ/เขต', $A_AMRP_ID['4'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_4" id="NAMEDESC_NO_4" class = "form-control" value="<?php echo $A_NAMEDESC_NO['4'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_4" name="NAMEDESC_DATE_4" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['4']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_4" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                    <div class="input-group">	
                                    <input type="file" id="NAMEDESC_FILE_4" name="NAMEDESC_FILE_4" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['4'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['4'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_4" name="OLD_NAMEDESC_FILE_4" value="<?php echo !empty($A_NAMEDESC_FILE['4'])?text($A_NAMEDESC_FILE['4']):""; ?>">
                                </td>
                        	</tr>
                            
                            <tr id="shw_ref_5">
                        		<td align="left">การขอใช้ชื่อสกุลร่วม</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_5', 'PROV_ID_5', $arr_prov, 'จังหวัด', $A_PROV_ID['5'], 'onchange="getRampr(this,\'AMRP_ID_5\',\'TAMB_ID_5\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_5'><?php echo GetHtmlSelect('AMRP_ID_5', 'AMRP_ID_5', $arr_ampr_5, 'อำเภอ/เขต', $A_AMRP_ID['5'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_5" id="NAMEDESC_NO_5" class = "form-control" value="<?php echo $A_NAMEDESC_NO['5'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_5" name="NAMEDESC_DATE_5" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['5']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_5" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_5" name="NAMEDESC_FILE_5" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['5'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['5'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_5" name="OLD_NAMEDESC_FILE_5" value="<?php echo !empty($A_NAMEDESC_FILE['5'])?text($A_NAMEDESC_FILE['5']):""; ?>">
                                </td>
                        	</tr>
                            
                            <tr id="shw_ref_6">
                        		<td align="left">การขอเปลี่ยนชื่อสกุล</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_6', 'PROV_ID_6', $arr_prov, 'จังหวัด', $A_PROV_ID['6'], 'onchange="getRampr(this,\'AMRP_ID_6\',\'TAMB_ID_6\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_6'><?php echo GetHtmlSelect('AMRP_ID_6', 'AMRP_ID_6', $arr_ampr_6, 'อำเภอ/เขต', $A_AMRP_ID['6'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_6" id="NAMEDESC_NO_6" class = "form-control" value="<?php echo $A_NAMEDESC_NO['6'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_6" name="NAMEDESC_DATE_6" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['6']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_6" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_6" name="NAMEDESC_FILE_6" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['6'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['6'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_6" name="OLD_NAMEDESC_FILE_6" value="<?php echo !empty($A_NAMEDESC_FILE['6'])?text($A_NAMEDESC_FILE['6']):""; ?>">
                                </td>
                        	</tr>
                            
                            <tr id="shw_ref_7">
                        		<td align="left">การขอเพิ่มชื่อรอง</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_7', 'PROV_ID_7', $arr_prov, 'จังหวัด', $A_PROV_ID['7'], 'onchange="getRampr(this,\'AMRP_ID_7\',\'TAMB_ID_7\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_7'><?php echo GetHtmlSelect('AMRP_ID_7', 'AMRP_ID_7', $arr_ampr_7, 'อำเภอ/เขต', $A_AMRP_ID['7'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_7" id="NAMEDESC_NO_7" class = "form-control" value="<?php echo $A_NAMEDESC_NO['7'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_7" name="NAMEDESC_DATE_7" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['7']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_7" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_7" name="NAMEDESC_FILE_7" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['7'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['7'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_7" name="OLD_NAMEDESC_FILE_7" value="<?php echo !empty($A_NAMEDESC_FILE['7'])?text($A_NAMEDESC_FILE['7']):""; ?>">
                                </td>
                        	</tr>
                            
                            <tr id="shw_ref_8">
                        		<td align="left">การขอเปลี่ยนชื่อรอง</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_8', 'PROV_ID_8', $arr_prov, 'จังหวัด', $A_PROV_ID['8'], 'onchange="getRampr(this,\'AMRP_ID_8\',\'TAMB_ID_8\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_8'><?php echo GetHtmlSelect('AMRP_ID_8', 'AMRP_ID_8', $arr_ampr_8, 'อำเภอ/เขต', $A_AMRP_ID['8'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_8" id="NAMEDESC_NO_8" class = "form-control" value="<?php echo $A_NAMEDESC_NO['8'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_8" name="NAMEDESC_DATE_8" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['8']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_8" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_8" name="NAMEDESC_FILE_8" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['8'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['8'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_8" name="OLD_NAMEDESC_FILE_8" value="<?php echo !empty($A_NAMEDESC_FILE['8'])?text($A_NAMEDESC_FILE['8']):""; ?>">
                                </td>
                        	</tr>
                            
                            <tr id="shw_ref_9">
                        		<td align="left">การขอยกเลิกการใช้ชื่อรอง</td>
                                <td align="left"><?php echo GetHtmlSelect('PROV_ID_9', 'PROV_ID_9', $arr_prov, 'จังหวัด', $A_PROV_ID['9'], 'onchange="getRampr(this,\'AMRP_ID_9\',\'TAMB_ID_9\');"','','1', '200');?></td>
                                <td align="left"><span id='ss_ampr_8'><?php echo GetHtmlSelect('AMRP_ID_9', 'AMRP_ID_9', $arr_ampr_9, 'อำเภอ/เขต', $A_AMRP_ID['9'],'','','1', '200');?></span></td>
                                <td align="center"><input type="text" name="NAMEDESC_NO_9" id="NAMEDESC_NO_9" class = "form-control" value="<?php echo $A_NAMEDESC_NO['9'];?>" style="width:180px;" ></td>
                                <td align="center">
                                	<div class="input-group" style="width:160px;">
                                        <input type="text" id="NAMEDESC_DATE_9" name="NAMEDESC_DATE_9" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo conv_date($A_NAMEDESC_DATE['9']);?>" style="width:160px;">
                                        <span class="input-group-addon datepicker" for="NAMEDESC_DATE_9" >&nbsp;
                                        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                                        </span>
                                    </div>
                                </td>
                                <td align="left">
                                	<div class="input-group">
                                    <input type="file" id="NAMEDESC_FILE_9" name="NAMEDESC_FILE_9" class="form-control"  value="<?php echo $A_NAMEDESC_FILE['9'];?>"> 
                                    <?php echo displayDownloadFileAttach($path_a,$A_NAMEDESC_FILE['9'],$arr_txt['download']);?>	
                                    </div>
                                    <input type="hidden" id="OLD_NAMEDESC_FILE_9" name="OLD_NAMEDESC_FILE_9" value="<?php echo !empty($A_NAMEDESC_FILE['9'])?text($A_NAMEDESC_FILE['9']):""; ?>">
                                </td>
                        	</tr>
                        </tbody>
                    </table>						
                </div>	
            </div>
        </div>
                    
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic2').toggle();">
                        <img class="switchPic2" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic2" src="<?php echo $path;?>images/clse.gif" >
                        ข้อมูลชื่อ - สกุล เดิม
                    </a>
                </div>
            </div>
                            
            <div id="collapse1" class="collapse in">
                <div class="row formSep">
                    <div class="col-md-2 col-sm-2">คำนำหน้าชื่อเดิม : </div>
                    <div class="col-md-2 col-sm-3"><?php echo text($arr_prefix[$NAMEHIS_LAST_PREFIX_ID]);?></div>
                </div>
                
                <div class="row formSep">	
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัวเดิม (ไทย) : &nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($NAMEHIS_LAST_FIRSTNAME_TH); ?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัวเดิม (อังกฤษ) :&nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($NAMEHIS_LAST_FIRSTNAME_EN); ?></div>
                </div>
                    
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ชื่อรองเดิม (ไทย) :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($NAMEHIS_LAST_MIDNAME_TH); ?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อรองเดิม (อังกฤษ) :</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($NAMEHIS_LAST_MIDNAME_EN); ?></div>	
                </div>
                        
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อ-สกุลเดิม (ไทย) : &nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($NAMEHIS_LAST_LASTNAME_TH); ?></div>
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อ-สกุลเดิม (อังกฤษ) :&nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($NAMEHIS_LAST_LASTNAME_EN); ?></div>
                </div>
            </div>	
        </div>
                    
        <div class="panel-group" id="accordion">
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();">
                        <img class="switchPic3" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic3" src="<?php echo $path;?>images/clse.gif" >
                        ข้อมูลชื่อ - สกุล ที่เปลี่ยนแปลงใหม่ 
                    </a>
                </div>
            </div>
            
            <div id="collapse3" class="collapse in">
                <span id="shw_prefix">
                    <div class=" row formSep">
                        <div class="col-md-2 col-sm-2">คำนำหน้าชื่อใหม่ : <span style="color:red;">*</span></div>
                        <div class="col-md-2 col-sm-2"><?php echo GetHtmlSelect('NAMEHIS_NEW_PREFIX_ID','NAMEHIS_NEW_PREFIX_ID',$arr_prefix,"คำนำหน้าชื่อ",$data['NAMEHIS_NEW_PREFIX_ID'],'','','1');?></div>
                    </div>
                </span>
                            
                <span id="shw_fname">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัวใหม่ (ไทย) : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="NAMEHIS_NEW_FIRSTNAME_TH" name="NAMEHIS_NEW_FIRSTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['fname']."ใหม่"; ?> (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["NAMEHIS_NEW_FIRSTNAME_TH"]); ?>"></div>
                        <div class="col-xs-12 col-md-1"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อตัวใหม่ (อังกฤษ) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="NAMEHIS_NEW_FIRSTNAME_EN" name="NAMEHIS_NEW_FIRSTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['fname']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["NAMEHIS_NEW_FIRSTNAME_EN"]); ?>"></div>	
                    </div>
                </span>	
                                
                <span id="shw_mname">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ชื่อรองใหม่ (ไทย) : <span style="color:red;">*</span></div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="NAMEHIS_NEW_MIDNAME_TH" name="NAMEHIS_NEW_MIDNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['mname']."ใหม่"; ?> (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["NAMEHIS_NEW_MIDNAME_TH"]); ?>"></div>
                        <div class="col-xs-12 col-md-1"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อรองใหม่ (อังกฤษ) : <span style="color:red;">*</span></div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="NAMEHIS_NEW_MIDNAME_EN" name="NAMEHIS_NEW_MIDNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['mname']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["NAMEHIS_NEW_MIDNAME_EN"]); ?>"></div>	
                    </div>
                </span>
                
                <span id="shw_lname">
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อ-สกุลใหม่ (ไทย) : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="NAMEHIS_NEW_LASTNAME_TH" name="NAMEHIS_NEW_LASTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['lname']."ใหม่"; ?> (<?php echo $arr_txt['th'] ;?>)" maxlength="100" value="<?php echo text($data["NAMEHIS_NEW_LASTNAME_TH"]); ?>"></div>	
                        <div class="col-xs-12 col-md-1"></div>
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชื่อ-สกุลใหม่ (อังกฤษ) :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
                        <div class="col-xs-12 col-md-3"><input type="text" id="NAMEHIS_NEW_LASTNAME_EN" name="NAMEHIS_NEW_LASTNAME_EN" class="form-control" placeholder="<?php echo $arr_txt['lname']."ใหม่"; ?> (<?php echo $arr_txt['en'] ;?>)" maxlength="100" value="<?php echo text($data["NAMEHIS_NEW_LASTNAME_EN"]); ?>"></div>
                    </div>
                </span>
            </div>	
        </div>
              
        <div class="col-xs-12 col-sm-12" align="center">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='profile_approvehis_list.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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