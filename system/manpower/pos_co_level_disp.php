<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$filter = "";

if($sTYPE_ID != "" ){
	$filter .= " and  d.TYPE_ID = '".ctext($sTYPE_ID)."' ";
}
if($sLEVEL_ID_MIN != "" ){
	 $filter .= " and  a.LEVEL_ID_MIN = '".$sLEVEL_ID_MIN."' ";
}
if($sLEVEL_ID_MAX != "" ){
	$filter .= " and  a.LEVEL_ID_MAX = '".$sLEVEL_ID_MAX."' ";
}
if($sACTIVE_STATUS != ""){
	$filter .= " and a.ACTIVE_STATUS = '".$sACTIVE_STATUS."' ";
}

$field="a.CO_ID,a.CO_CODE,(b.LEVEL_NAME_TH) as LEVEL_NAME_MIN ,
(c.LEVEL_NAME_TH) as LEVEL_NAME_MAX ,c.LEVEL_NAME_EN,a.ACTIVE_STATUS,
(d.TYPE_NAME_TH) as TYPE_NAME";
$table=" SETUP_POS_CO_LEVEL  a
INNER JOIN SETUP_POS_LEVEL b ON a.LEVEL_ID_MIN=b.LEVEL_ID
INNER JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID_MAX=c.LEVEL_ID
INNER JOIN SETUP_POS_TYPE d ON a.TYPE_ID=d.TYPE_ID";
$pk_id="CO_ID";	
$wh="a.DELETE_FLAG='0' {$filter} ";
$orderby=" order by TYPE_SEQ ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;//exit();
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$cond_level = "";
if($sTYPE_ID > 0){
	$cond_type = " AND TYPE_ID = '".$sTYPE_ID."' ";
}
 
if(trim($sLEVEL_ID_MAX) > 0){
 
  $sql_level = "SELECT LEVEL_SEQ, TYPE_ID FROM SETUP_POS_LEVEL WHERE LEVEL_ID ='".$sLEVEL_ID_MAX."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'";
  $query_level = $db->query($sql_level);
  $rec_level = $db->db_fetch_array($query_level);
  $cond_level = " and LEVEL_SEQ >= ".$rec_level['LEVEL_SEQ'];
  
  if($sTYPE_ID <= 0){
	  $cond_type = " AND TYPE_ID = '".$rec_level['TYPE_ID']."' ";
  }
  
}
	
$SQL_SETUP_POS_LEVEL_MAX ="SELECT LEVEL_ID,LEVEL_NAME_TH as LEVEL_NAME_MAX  FROM SETUP_POS_LEVEL WHERE ACTIVE_STATUS='1' and POSTYPE_ID = '1' AND DELETE_FLAG = '0'".$cond_type.$cond_level." ORDER BY LEVEL_SEQ ASC";
$query_LEVEL_MAX = $db->query($SQL_SETUP_POS_LEVEL_MAX);

$SQL_SETUP_POS_LEVEL_MIN ="SELECT LEVEL_ID,LEVEL_NAME_TH as LEVEL_NAME_MIN  FROM SETUP_POS_LEVEL WHERE ACTIVE_STATUS='1' and POSTYPE_ID = '1' AND DELETE_FLAG = '0' ".$cond_type." ORDER BY LEVEL_SEQ ASC ";
$query_LEVEL_MIN = $db->query($SQL_SETUP_POS_LEVEL_MIN);

$SQL_SETUP_POS_TYPE ="SELECT TYPE_ID,TYPE_NAME_TH as TYPE_NAME  FROM SETUP_POS_TYPE WHERE ACTIVE_STATUS='1' and POSTYPE_ID = '1' AND DELETE_FLAG = '0' ORDER BY TYPE_SEQ ASC ";
$query_POS_TYPE = $db->query($SQL_SETUP_POS_TYPE);

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
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li class="active"><?php echo Showmenu($menu_sub_id);?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata">
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="CO_ID" name="CO_ID" value="<?php echo $CO_ID; ?>">
        
        <div class="row">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทตำแหน่ง :</div>
            <div class="col-xs-12 col-sm-3">
                <select id="sTYPE_ID" name="sTYPE_ID" onChange="getPosLevel3(this,'sLEVEL_ID_MIN','');" class="selectbox form-control" placeholder="--ทั้งหมด--">
                    <option value=""></option>
                    <?php   $i=1;
                    while($rec_type = $db->db_fetch_array($query_POS_TYPE)){?>
                    <option value="<?php echo $rec_type['TYPE_ID']?>" <?php echo ($sTYPE_ID== $rec_type['TYPE_ID']?"selected":"");?>>	<?php echo text($rec_type['TYPE_NAME'])?>
                    </option>
                    <?php  $i++;}?>
                </select>
            	</div>
            </div>
                    
            <div class="row">
               <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระดับเริ่มต้น :</div>
                <div class="col-xs-12 col-sm-3">
                <span id='lv_min'>
                  <select id="sLEVEL_ID_MIN" name="sLEVEL_ID_MIN" onChange="getLevel4(this,this.value,'sLEVEL_ID_MAX');" class="selectbox form-control" placeholder="--ทั้งหมด--">
                    <option value=""></option>
                    <?php   $i=1;
					while($rec_min = $db->db_fetch_array($query_LEVEL_MIN)){?>
                    <option value="<?php echo $rec_min['LEVEL_ID']?>" <?php echo ($sLEVEL_ID_MIN== $rec_min['LEVEL_ID']?"selected":"");?>>		<?php echo text($rec_min['LEVEL_NAME_MIN'])?></option>
                   <?php  $i++;}?>
                  </select>
                </span>
                </div>
                <div class="col-xs-12 col-sm-2"></div>
                <div class="col-xs-12 col-sm-2">ระดับสูงสุด :</div>
                    <div class="col-xs-12 col-sm-3">
                    	<span id='lv_max'>
                          	<select id="sLEVEL_ID_MAX" name="sLEVEL_ID_MAX" class="selectbox form-control"placeholder="--ทั้งหมด--">
                                <option value=""></option>
								<?php   $i=1;
								while($rec_mxx = $db->db_fetch_array($query_LEVEL_MAX)){?>
                                <option value="<?php echo $rec_mxx['LEVEL_ID']?>" <?php echo ($sLEVEL_ID_MAX == $rec_mxx['LEVEL_ID'])?"selected":"";?>><?php echo text($rec_mxx['LEVEL_NAME_MAX'])?></option>
								<?php  $i++;}?>
                          	</select>
                        </span>
                    </div>
        </div>
        <div class="row" style="text-align:center; margin-top:15px;">
           <div class="col-xs-12 col-sm-12 ">
                 <button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
          </div>
        </div>
       <div class="col-sm-12">
        	<a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a> 
        </div>
        <div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bgHead">
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="20%"><div align="center">ประเภทตำแหน่ง</div></th>
                  <th width="20%"><div align="center">ระดับเริ่มต้น</div></th>
                  <th width="20%"><div align="center">ระดับสูงสุด</div></th>
                  <th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                </tr>
              </thead>
              <tbody>
                <?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["CO_ID"]."');\">".$img_edit." แก้ไข</a> ";
						$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["CO_ID"]."');\">".$img_del." ลบ</a> ";
						?>
                        <tr bgcolor="#FFFFFF">
                          <td align="center"><?php echo $i+$goto."."; ?></td>
                          <td align="left"><?php echo text($rec["TYPE_NAME"]); ?></td>
                          <td align="left"><?php echo text($rec["LEVEL_NAME_MIN"]); ?></td>
                          <td align="left"><?php echo text($rec["LEVEL_NAME_MAX"]); ?></td>
                          <td align="center"><?php echo $edit.$delete; ?></td>
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
        <div class="row"><?php echo ($nums > 0) ? endPaging("frm-search",$total_record):""; ?></div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>
<!-- Modal -->
<div class="modal fade" id="myModal"></div>
<!-- /.modal -->