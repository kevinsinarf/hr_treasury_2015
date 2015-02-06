<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";
if(trim($s_change_date) != ""){
	$filter .= " and convert(date,A.REQUEST_DATETIME) = '".conv_date_db($s_change_date)."' ";
}
if(trim($s_comset_year) != ""){
	$filter .= " and a.COMSET_YEAR = '".$s_comset_year."' ";
}
if(trim($s_comtitle_type) != ""){
	$filter .= " and a.COMTITLE_ID = '".$s_comtitle_type."' ";
}


$field="a.COMSET_ID,a.COMSET_YEAR,b.COMTITLE_NAME_TH,a.COMSET_EXPECT,c.TYPE_NAME_TH,d.LEVEL_NAME_TH,e.LINE_NAME_TH";
$table="COMPETENCY_SET a
left JOIN COMPETENCY_TITLE b ON a.COMTITLE_ID = b.COMTITLE_ID
left JOIN SETUP_POS_TYPE c ON a.TYPE_ID = c.TYPE_ID
left JOIN SETUP_POS_LEVEL d ON a.LEVEL_ID = d.LEVEL_ID
left JOIN SETUP_POS_LINE e ON a.LINE_ID = e.LINE_ID";
$pk_id="COMSET_ID";
$wh="a.DELETE_FLAG='0' AND a.COMSET_TYPE = '2' {$filter}";
$orderby="order by a.COMSET_YEAR DESC,  b.COMTITLE_NAME_TH ASC";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

//หัวข้อสรรถนะ
$query_compet = $db->query("SELECT * FROM COMPETENCY_TITLE WHERE ACTIVE_STATUS = 1 AND COMTITLE_TYPE = 2");

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
<script src="js/competency_line_year.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div class="col-xs-12 col-md-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active">สมรรถนะสายงานประจำปี</li>
        </ol>
    </div>
    <div class="col-xs-12 col-md-12" id="content">
        <div class="groupdata">
        	         
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="mode" name="mode" value="<?php echo $mode;?>">
                <input type="hidden" id="COMSET_ID" name="COMSET_ID" value="">
               <div class="row">
                <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ปีที่ใช้สมรรถนะ :</div>
                    <div class="col-xs-12 col-sm-2">
                      <input type="text" id="s_comset_year" name="s_comset_year" class="form-control number" placeholder="ปีที่ใช้สมรรถนะ" value="<?php echo $s_comset_year; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อหัวข้อสมรรถนะสายงาน :</div>
                    <div class="col-xs-12 col-sm-3">
                     <select id="s_comtitle_type" name="s_comtitle_type" class="selectbox form-control" placeholder="หัวข้อสมรรถนะ">
                      <option value=""></option>
                      <?php while($rec_com = $db->db_fetch_array($query_compet)){ ?>
                          <option value="<?php echo $rec_com['COMTITLE_ID']; ?>"<?php echo ($rec_com['COMTITLE_ID'] == $s_comtitle_type ? "selected" : ""); ?>><?php echo text($rec_com['COMTITLE_NAME_TH']); ?></option>
                      <?php } ?>
                    </select>	
                    </div>
                 </div>
                 
                <div class="row">
                    <div class="col-xs-12 col-sm-12" align="center"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div> 
                </div>
                 
                <div class="row">
                   <div class="col-xs-12 col-md-12" style="margin-bottom:5px;"> 
                      <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData('<?php echo $paramlink; ?>');">
                      <?php echo $img_save;?> เพิ่มข้อมูล</a> 
                    </div>
                    <div class="col-xs-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                  <tr class="bgHead">   
                                       <th width="10%"><div align="center"><strong>ลำดับ</strong></div></th>
                                       <th width="10%" ><div align="center">ปีที่ใช้สมรรถนะ</div></th>
                                   	   <th width="15%" ><div align="center"><strong>ชื่อหัวข้อสมรรถนะสายงาน</strong></div></th>
                                       <th width="10%" ><div align="center"><strong>ค่าความคาดหวัง</strong></div></th>
                                       <th width="15%" ><div align="center"><strong>ประเภทตำแหน่ง</strong></div></th>
                                       <th width="15%" ><div align="center"><strong>ระดับตำแหน่ง</strong></div></th>
                                       <th width="15%" ><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                                       <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($nums > 0){
                                        $i=1;
                                        while($rec = $db->db_fetch_array($query)){
                                        $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["COMSET_ID"]."');\">".$img_edit." แก้ไข</a> ";
                                         $delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["COMSET_ID"]."');\">".$img_del." ลบ</a> ";
                                    ?>
                                    <tr bgcolor="#FFFFFF">
                                        <td align="center"><?php echo $i+$goto."."; ?></td>
                                        <td align="center"><?php echo text($rec['COMSET_YEAR']); ?></td>
                                        <td align="left"><?php echo text($rec['COMTITLE_NAME_TH']); ?></td>
                                        <td align="center"><?php echo text($rec['COMSET_EXPECT']); ?></td>
                                        <td align="left"><?php echo text($rec['TYPE_NAME_TH']); ?></td>
                                        <td align="left"><?php echo text($rec['LEVEL_NAME_TH']); ?></td>
                                        <td align="left"><?php echo text($rec['LINE_NAME_TH']); ?></td>
                                        <td align="center"><?php echo $edit.$delete; ?></td>
                                    </tr>
                                   <?php 
                                       		$i++;
                                        }
                                    }else{
                                        echo "<tr><td align=\"center\" colspan=\"8\">ไม่พบข้อมูล</td></tr>";
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                     </div> 
                    </div>   
  
                <div class="row">
                	<?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?>
                </div>
            </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
