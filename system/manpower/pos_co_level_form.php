<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$CO_ID=$_POST['CO_ID'];

$txt = ($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"; 
if($proc == "edit"){
$sql=  "SELECT CO_ID,CO_CODE,TYPE_ID,LEVEL_ID_MIN,LEVEL_ID_MAX,ACTIVE_STATUS FROM SETUP_POS_CO_LEVEL WHERE DELETE_FLAG='0' and CO_ID ='".$CO_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

$sql_level = "SELECT LEVEL_SEQ, TYPE_ID FROM SETUP_POS_LEVEL WHERE LEVEL_ID ='".$rec['LEVEL_ID_MAX']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'";
$query = $db->query($sql_level);
$rec1 = $db->db_fetch_array($query);

$arr_lv_min=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH as LEVEL_NAME_MIN", "SETUP_POS_LEVEL", "TYPE_ID='".$rec['TYPE_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_NAME_TH");
			
$arr_lv_max=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH as LEVEL_NAME_MAX", "SETUP_POS_LEVEL", "TYPE_ID = ".$rec['TYPE_ID']." and ACTIVE_STATUS='1' and DELETE_FLAG='0' and LEVEL_SEQ>=".$rec1['LEVEL_SEQ']." and POSTYPE_ID = '1'", "LEVEL_NAME_TH");
}
$arr_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH as TYPE_NAME", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1' ","TYPE_SEQ");

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
<script src="js/pos_co_level_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="pos_co_level_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" >
      <form id="frm-input" method="post" action="process/pos_co_level_process.php">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input name="CO_ID" type="hidden" id="CO_ID" value="<?php echo $CO_ID; ?>">
        <input name="flagDup" type="hidden" id="flagDup">
        
        <div class="row formSep">
        <div class="col-xs-12 col-sm-2">ประเภทตำแหน่ง : <span style="color:red;">*</span></div>
		<div class="col-xs-12 col-sm-3">
		<?php echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_type,'ประเภทตำแหน่ง',$rec['TYPE_ID'],'onchange="getPosLevel(this,\'LEVEL_ID_MIN'.'\')" ','','1');?></div>
        </div>
                
          <div class="row formSep">
			<div class="col-md-2 col-sm-2">ระดับเริ่มต้น : <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-md-4 col-sm-3"><span id='lv_min'>
					<?php 
					echo GetHtmlSelect('LEVEL_ID_MIN','LEVEL_ID_MIN',$arr_lv_min,$arr_txt['level_pos'].'ขั้นต่ำ',$rec['LEVEL_ID_MIN'],'onchange="getLevel2(this,this.value,\'LEVEL_ID_MAX\')" ','','1');?>
                    </span>
				</div>
                
			<div class="col-md-2 col-sm-2">ระดับสูงสุด : <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-md-4 col-sm-3"><span id='lv_max'>
					<?php echo GetHtmlSelect('LEVEL_ID_MAX','LEVEL_ID_MAX',$arr_lv_max,$arr_txt['level_pos'].'ขั้นสูง',$rec['LEVEL_ID_MAX'],'','','1');?></span>
				</div>
       	</div>
		<div class="row formSep">
			<div class="col-xs-4 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?>&nbsp;: <span style="color:red;">*</span>&nbsp; </div>
				<div class="col-xs-8 col-md-3">
						<label><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1"<?php echo ($rec['ACTIVE_STATUS']=='1'||$rec1['ACTIVE_STATUS']=='' ?"checked":"")?>><?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
						<label><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?>> <?php echo $arr_act_status['0'];?></label>
				</div> 	
		</div>
		<div class="formlast">
			<div class="col-xs-12 col-sm-12" align="center">
					<button type="button" class="btn btn-primary" onClick="	chkinput();">บันทึก</button>
					<button type="button" class="btn btn-default" onClick="self.location.href='pos_co_level_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>';">ยกเลิก</button>
			</div>
		</div>
      </form>
		
  </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
 <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="col-xs-12 col-sm-12 col-xs-6">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <div class="modal-body"> <!-- -->
            <hr>
          </div> 
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->