<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 

$sql=  " SELECT * FROM SETUP_POS_MANAGE WHERE MANAGE_ID ='".$MANAGE_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$sql_manage_type ="SELECT MT_ID, MT_NAME_TH FROM SETUP_POS_MANAGE_TYPE WHERE ACTIVE_STATUS='1' AND DELETE_FLAG = '0' ORDER BY MT_SEQ ASC ";
$q_manage_type = $db->query($sql_manage_type);

$sql_org = "SELECT A.ORG_ID, A.ORG_NAME_TH FROM SETUP_ORG A
JOIN SETUP_ORG_LEVEL B ON A.OL_ID = B.OL_ID
WHERE A.ACTIVE_STATUS = '1' AND A.DELETE_FLAG = '0' AND A.ORG_TYPE = 1 ORDER BY B.OL_SEQ ASC, A.ORG_SEQ ASC ";
$q_org = $db->query($sql_org);
while($r_org = $db->db_fetch_array($q_org)){
	$arr_org[$r_org['ORG_ID']] = $r_org['ORG_NAME_TH'];	
}
$query_org_3 = $db->query("SELECT ORG_ID ,ORG_PARENT_ID FROM SETUP_ORG WHERE OL_ID = '16' AND  ORG_ID = '".$rec['ORG_ID']."' ");
$query_org_4 = $db->query("SELECT ORG_ID ,ORG_PARENT_ID FROM SETUP_ORG WHERE  OL_ID = '17' AND  ORG_ID = '".$rec['ORG_ID']."' ");
$num_org3 = $db->db_num_rows($query_org_3);
$num_org4 = $db->db_num_rows($query_org_4);
$rec_org4 = $db->db_fetch_array($query_org_4);
if($num_org3==0){
	$org_3 = $rec_org4['ORG_PARENT_ID'];
}else{
	$org_3 = $rec['ORG_ID'];
}


$arr_pos_type = GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND POSTYPE_ID = 1 ", "TYPE_SEQ");
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
<script src="js/pos_manage_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="pos_manage_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
      <div class="groupdata" >
      <form id="frm-input" method="post" action="process/pos_manage_process.php">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="MANAGE_ID" name="MANAGE_ID"  value="<?php echo $MANAGE_ID; ?>">
		
        <div class="row formSep">
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ประเภทตำแหน่งทางการบริหาร :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-3">
            <select id="MT_ID" name="MT_ID" class="selectbox form-control" placeholder="ประเภทตำแหน่งทางการบริหาร" >
                <option value=""></option>
                <?php   
                $i=1;
                while($r_manage_type = $db->db_fetch_array($q_manage_type)){
					?>
                    <option value="<?php echo $r_manage_type['MT_ID']?>" <?php if($r_manage_type['MT_ID'] == $rec['MT_ID']){ echo "selected";}?>><?php echo text($r_manage_type['MT_NAME_TH'])?></option>
                    <?php  
                    $i++;
                }
                ?>
                </select>
            </div>
           
		</div>
        <div class="row formSep">
        <div class="col-xs-12 col-md-3" style="white-space:nowrap;">สำนัก/กลุ่ม : </div>
					<div class="col-xs-12 col-md-3">
						<select id="ORG_ID_3" name="ORG_ID_3" class="selectbox form-control" placeholder="สำนัก/กลุ่ม" onChange="get_org_4(this); 	$('#ORG_ID_4').prop('disabled',false); $('#ORG_ID_4').trigger('liszt:updated'); " >
							<option value=""></option>
							<?php
							$sql_org_3 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = 15 ORDER BY ORG_SEQ ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$org_3] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
					</div>
					<div class="col-xs-12 col-sm-3" style="white-space:nowrap;">กลุ่มงาน :</div>
					<div class="col-xs-12 col-md-3">
						<select id="ORG_ID_4" name="ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน" onChange="$('#ORG_ID_3').prop('disabled',false); $('#ORG_ID_3').trigger('liszt:updated');">
							<option value=""></option>
							<?php
						
								$sql_org_4 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND OL_ID = 17 AND ORG_PARENT_ID = '".$org_3."'  ORDER BY ORG_SEQ ASC";
								$query_org_4 = $db->query($sql_org_4);
								$select_org_4[$rec['ORG_ID']] = "Selected='Selected'";
								while($org = $db->db_fetch_array($query_org_4)){
									echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
								}
							?>
						</select>
					</div>
        	
        </div>
		<div class="row formSep">
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อตำแหน่งทางการบริหารภาษาไทย&nbsp;: <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-3"><input type="text" name="MANAGE_NAME_TH" id="MANAGE_NAME_TH" value="<?php echo text($rec['MANAGE_NAME_TH']);?>" class="form-control" placeholder="ชื่อตำแหน่งทางการบริหารภาษาไทย"></div>
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อย่อตำแหน่งทางการบริหารภาษาไทย :</div>
            <div class="col-xs-12 col-sm-3"><input type="text" name="MANAGE_SHORTNAME_TH" id="MANAGE_SHORTNAME_TH" value="<?php echo text($rec['MANAGE_SHORTNAME_TH']);?>" class="form-control" placeholder="ชื่อย่อตำแหน่งทางการบริหารภาษาไทย"></div>
		</div>
        
		<div class="row formSep">
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อตำแหน่งทางการบริหารภาษาอังกฤษ&nbsp;:</div>
            <div class="col-xs-12 col-sm-3"><input type="text" name="MANAGE_NAME_EN" id="MANAGE_NAME_EN" value="<?php echo text($rec['MANAGE_NAME_EN']);?>" class="form-control" placeholder="ชื่อตำแหน่งทางการบริหารภาษาอังกฤษ"></div>
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">ชื่อย่อตำแหน่งทางการบริหารภาษาอังกฤษ&nbsp;:</div>
            <div class="col-xs-12 col-sm-3"><input type="text" name="MANAGE_SHORTNAME_EN" id="MANAGE_SHORTNAME_EN" value="<?php echo text($rec['MANAGE_SHORTNAME_EN']);?>" class="form-control" placeholder="ชื่อย่อตำแหน่งทางการบริหารภาษาอังกฤษ"></div>
		</div>
        <div class="row formSep">
           <div class="col-xs-12 col-sm-3" >ประเภทตำแหน่ง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect("TYPE_ID","TYPE_ID",$arr_pos_type, 'ประเภทตำแหน่ง',$rec['TYPE_ID'],'','','1');?></div>
            <div class="col-xs-12 col-sm-3" style="white-space:nowrap">สถานะการใช้งาน&nbsp;:</div>
            <div class="col-xs-6 col-md-3">
            <input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS'] == '1' || $rec['ACTIVE_STATUS'] == '' ? "checked" : "") ?>> ใช้งาน
            <input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS'] == '0' ? "checked" : "") ?>> ไม่ใช้งาน
            </div>
        </div>
        
        <div class="formlast">
            <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                <button type="button" class="btn btn-default" onClick="self.location.href = 'pos_manage_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>';">ยกเลิก</button>
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
