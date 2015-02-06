<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
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
//POST
$PER_ID=$_POST['PER_ID'];
$MULTI_ID=$_POST['MULTI_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
//MAIN
$sql = "SELECT a.*
FROM PER_MULTITIME a
WHERE a.DELETE_FLAG='0' AND a.MULTI_ID = '".$MULTI_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

##------------------- ข้าราชการ ------------------------##

//กระทรวง
$arr_org1 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","OL_ID = '2' and ACTIVE_STATUS=1 and DELETE_FLAG='0' ","ORG_SEQ" );
//สำนัก
$cond_org3 = ($rec['ORG_ID_2'] != '') ? " AND ORG_PARENT_ID = '".$rec['ORG_ID_2']."'" : "";
$arr_org3 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","ACTIVE_STATUS = 1 and DELETE_FLAG = '0' ".$cond_org3, "ORG_SEQ" );

//ประเภทตำแหน่ง
$arr_pos_type =GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//สายงาน
$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LG_NAME_TH");
//ระดับ
$arr_level_gov =  GetSqlSelectArray("LEVEL_ID","LEVEL_NAME_TH","SETUP_POS_LEVEL","ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND TYPE_ID = '".$rec['TYPE_ID']."' ","LEVEL_SEQ");
//ตำแหน่งในสายงาน
$arr_line_gov = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$rec['TYPE_ID']."' ", "LINE_NAME_TH");
//ต่ำแหน่งทางการบริหาร
$arr_manage = GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$rec['TYPE_ID']."' ", "MANAGE_NAME_TH");

//ต่ำแหน่งทางการบริหาร
$arr_manage_type = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ", "MT_NAME_TH");

//ตำแหน่งในการบริหาร
$sql_manage_name='';
if(!empty($rec['TYPE_ID'])){
	$sql_manage_name .= " OR TYPE_ID = ".$rec['TYPE_ID'];
}
$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND (TYPE_ID IS NULL ".$sql_manage_name.") ", "MANAGE_NAME_TH");

//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_NAME_TH");

//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_1']."' ", "ORG_NAME_TH");

//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "ORG_NAME_TH");

//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "ORG_NAME_TH");
					
//เวลาทวีคุณ
$arr_multitime=GetSqlSelectArray("MULTIME_ID", "MULTIME_NAME_TH", "SETUP_MULTITIME", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "MULTIME_NAME_TH");
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_multitime.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li><a href="profile_multitime.php?<?php echo url2code($link2); ?>">ประวัติเวลาทวีคูณ</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
    <form id="frm-input" method="post" action="process/profile_multitime_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="MULTI_ID" name="MULTI_ID" value="<?php echo $MULTI_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
		<input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID?>">
           <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                                    <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลการรับราชการเวลาทวีคูณ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse1" class="collapse in">
		<div class="row formSep">
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ช่วงเวลาทวีคูณ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
            <div class="col-xs-12 col-md-3"><?php  echo GetHtmlSelect('MULTIME_ID','MULTIME_ID',$arr_multitime,'เวลาทวีคุณ',$rec['MULTIME_ID'],'','','1');?>				</div>
			<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จำนวนวันปฏิบัติราชการเวลาทวีคูณ :&nbsp;<span style="color:red;"></span>&nbsp;</div>
		</div>
        
        <div class="row formSep">
        	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จำนวนวันลา ขาด หนี <br>การปฏิบัติราชการในเวลาทวีคูณ :&nbsp;</div>
            <div class="col-xs-12 col-md-2"><input type="text" id="MULTI_FRAC" name="MULTI_FRAC" class="form-control number" placeholder="จำนวนวันที่ลาปฏิบัติราชการ" value="<?php echo text($rec['MULTI_FRAC']); ?>" maxlength="5"></div>
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จำนวนวันคงเหลือ :&nbsp;<span style="color:red;"></span></div>
            <div class="col-xs-12 col-md-2"><input type="text" id="MULTI_BALANCE" name="MULTI_BALANCE" class="form-control number" placeholder="จำนวนวันคงเหลือ" value="<?php echo text($rec['MULTI_BALANCE']); ?>" maxlength="5"></div>
     	</div> 
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ  : &nbsp;</div>
            <div class="col-xs-12 col-md-3"><textarea id="MULTI_NOTE" name="MULTI_NOTE" class="form-control" placeholder="หมายเหตุ" cols="5" rows="3"><?php echo text($rec['MULTI_NOTE']); ?></textarea></div>
        </div>
        

        </div>
		<!--gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg-->
		<div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse22" onClick="$('.switchPic1').toggle();">
                                    <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                                    ข้อมูลตำแหน่งขณะรับราชการทวีคูณ
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse22" class="collapse in">
						  <span id = "gov" >
					<div class="row formSep">
					    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['pos_no']; ?> :&nbsp;<span style="color:red;"></span></div>
						<div class="col-xs-12 col-md-2"><input type="text" id="POS_NO" name="POS_NO" class="form-control number" placeholder="<?php echo $arr_txt['pos_no']; ?>" value="<?php echo text($rec['POS_NO']); ?>" maxlength="5"></div>
						<div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2 col-md-2" style="white-space:nowrap;">กระทรวง : &nbsp;</div>
                        <div class="col-xs-12 col-sm-3"><?php echo GetHtmlSelect('GOV_ORG_ID_1','GOV_ORG_ID_1', $arr_org1 , 'กระทรวง', $rec['ORG_ID_1'],"onChange=\"get_gov_org2(this.value);\"",'','','300','1'); ?></div>
                     
                       
					</div>
					<div class="row formSep">
					    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กรม : &nbsp;<span style="color:red;">*</span>&nbsp;</div>
						 <div class="col-xs-12 col-sm-2">
                        	<select id="GOV_ORG_ID_2" name="GOV_ORG_ID_2" class="selectbox form-control" placeholder="กรม" onChange="get_gov_org3(this.value);" style="width:300px;">
                        		<option value=""></option>
								<?php
                                $sql_org_name = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND ORG_PARENT_ID = '".$rec['ORG_ID_1']."' AND DELETE_FLAG = 0 ORDER BY ORG_SEQ ASC";
                                $query_org_name = $db->query($sql_org_name);
                                $select_type[$rec['ORG_ID_2']] = "Selected='Selected'";
                                while($type = $db->db_fetch_array($query_org_name)){
                                	echo '<option value="'.$type['ORG_ID'].'" '.$select_type[$type['ORG_ID']].' >'.text($type['ORG_NAME_TH']).'</option>';
                                }
                                ?>
                        	</select>
                      </div>
					   <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-md-2 col-md-2" style="white-space:nowrap;">สำนัก/กอง : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('GOV_ORG_ID_3','GOV_ORG_ID_3', $arr_org3 , 'สำนัก/กอง',$rec['ORG_ID_3'],"onChange=\"get_gov_org4(this.value);\"",'','','300','1'); ?></div>
                      
                   
                    </div>
					<div class="row formSep">
					     <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 1 ระดับ<br>(ส่วน/กลุ่ม/กลุ่มงาน) : </div>
                        <div class="col-xs-12 col-md-3">
                            <select id="GOV_ORG_ID_4" name="GOV_ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน" onChange="get_gov_org5(this.value);" style="width:300px;">
                                <option value=""></option>
                                <?php
                                $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND ORG_PARENT_ID = '".$rec['ORG_ID_3']."' ORDER BY ORG_SEQ ASC";
                                $query_org_4 = $db->query($sql_org_4);
                                $select_org_4[$rec['ORG_ID_4']] = "Selected='Selected'";
                                while($org = $db->db_fetch_array($query_org_4)){
                                	echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                                }
                                ?>
                            </select>
                        </div>
						 <div class="col-xs-12 col-sm-1"></div>
                        <div class="col-xs-12 col-md-2 col-md-2" style="white-space:nowrap;">ต่ำกว่าสำนัก/กอง 2 ระดับ<br>(ฝ่าย) : </div>
                        <div class="col-xs-12 col-md-3">
                            <select id="GOV_ORG_ID_5" name="GOV_ORG_ID_5" class="selectbox form-control" placeholder="ฝ่าย" style="width:300px;">
                                <option value=""></option>
                                <?php
                                $sql_org_4 = "SELECT ORG_ID, ORG_NAME_TH FROM SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$rec['ORG_ID_4']."' ORDER BY ORG_SEQ ASC";
                                $query_org_4 = $db->query($sql_org_4);
                                $select_org_4[$rec['ORG_ID_5']] = "Selected='Selected'";
                                while($org = $db->db_fetch_array($query_org_4)){
                                	echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
                                }
                                ?>
                            </select>
                        </div>                            
                    </div>
					<!------------gg---->
					<div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทตำแหน่ง : </div>
                        <div class="col-xs-12 col-md-3">
                        	<?php echo GetHtmlSelect('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทตำแหน่ง' ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); get_manage(this); ' ",'', '', '300', '1'); ?>
                           
                    	</div>
                    	<div class="col-xs-12 col-md-2 col-md-offset-1" >ระดับตำแหน่ง : </div>
                    	<div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('LEVEL_ID', 'LEVEL_ID',$arr_level_gov , 'ระดับ' ,$rec['LEVEL_ID'] ,'','', '', '300', '1'); ?></div>
                    </div>
                    
                     <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >สายงาน : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onChange='get_line(this);' ", '', '', '300', '1'); ?></div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่งในสายงาน : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('LINE_ID', 'LINE_ID',$arr_line_gov, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ประเภทตำแหน่งทางการบริหาร : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php  echo GetHtmlSelect('MT_ID','MT_ID',$arr_manage_type,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=get_manage(this);','','1');?></div>
                        
                        <div class="col-xs-12 col-md-2 col-md-offset-1" >ตำแหน่งทางการบริหาร : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('MANAGE_ID', 'MANAGE_ID', $arr_manage, 'ตำแหน่งทางการบริหาร' ,$rec['MANAGE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div> 
					   </span>
        </div>
		<!--gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg-->
		
		
		
		</div>
        <div class="col-xs-12 col-sm-12" align="center">
			<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			<button type="button" class="btn btn-default" onClick="self.location.href='profile_multitime.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
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