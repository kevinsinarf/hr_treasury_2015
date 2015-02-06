<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2 = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;
$paramlink = url2code($link);

//POST
$s_idcard = trim($_POST['s_idcard']);
$s_name = trim($_POST['s_name']); 

$filter = '';
if($s_idcard != ''){
	$filter .= " AND PENSION_IDCARD = '".str_replace(' ','',$s_idcard)."' ";
}
if($s_name != ''){
	$filter .= " and (B.PER_FIRSTNAME_TH like '%".ctext($s_name)."%' OR B.PER_MIDNAME_TH like '%".ctext($s_name)."%' OR B.PER_LASTNAME_TH like '%".ctext($s_name)."%') ";
}

$field = "PENSION_ID, PENSION_IDCARD, A.PER_ID, A.PENSION_TIME, B.PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, PENSION_TYPE_RESIGN, PENSION_TYPE_PENSION, PENSION_TYPE_REQUEST_CIVIL";
$table = "PENSION_MAIN A 
JOIN PER_PROFILE B ON B.PER_ID = A.PER_ID ";

$pk_id = "PENSION_ID";
$wh = "A.DELETE_FLAG='0' AND A.POSTYPE_ID = 5 {$filter}";
$orderby = "order by PENSION_ID DESC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));

$arr_resign = array(1 => 'ลาออก', 2 => 'เกษียณอายุราชการ', 3 => 'เกษียณอายุราชการก่อนกำหนด', 4 => 'โทษทางวินัย', 5 => 'เหตุตามมาตร 83', 6 => 'เสียชีวิต' );
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="js/pension_record_emp_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active">บันทึกข้อมูลการขอบำเหน็จบำนาญ (ลูกจ้างประจำ)</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12"> 
     <div class="groupdata" >
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PENSION_ID" name="PENSION_ID" value="">
                
                <div class="row">
                  <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['idcard'];?> :</div>
                  <div class="col-xs-12 col-sm-2">
                  <input type="text" id="s_idcard" name="s_idcard" class="form-control " placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $s_idcard; ?>">
                  </div>
                   <div class="col-xs-12 col-sm-2"></div>
                  <div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['name'];?> :</div>
                  <div class="col-xs-12 col-sm-2">
                  	<input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>">
                  </div>
              </div>
              <div class="row" style="text-align:center;"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>  
                
                <div class="row">
                	<div class="col-xs-12 col-md-12"> 
                		<a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();">
                		<?php echo $img_save;?> บันทึกคำขอรับบำเหน็จบำนาญ</a> 
                	</div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr class="bgHead">
                                        <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                        <th width="14%"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                                    	<th width="22%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                                        <th width="10%"><div align="center"><strong>ประเภทการขอรับ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>ครั้งที่เสนอขอรับ</strong></div></th>
                                        <th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($nums > 0){
                                        $i=1;
                                        while($rec = $db->db_fetch_array($query)){
											$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
											$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["PENSION_ID"]."');\">".$img_edit." แก้ไข</a> ";
											$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"delData('".$rec["PENSION_ID"]."', '".$rec['PENSION_ID']."');\">".$img_del." ลบ</a> ";
											?>
											<tr bgcolor="#FFFFFF">
												<td align="center"><?php echo $i+$goto;?>.</td>
												<td align="center"><?php echo get_idCard($rec["PENSION_IDCARD"]);?></td>
												<td align="left" style="padding-left:5px"><?php echo $PER_NAME;?></td>
												<td align="center"><?php echo $arr_pension_type[$rec['PENSION_TYPE_PENSION']];?></td>
												<td align="center"><?php echo $rec['PENSION_TIME'];?></td>
												<td align="center"><?php echo $edit.$delete;?></td>
											</tr>
											<?php 
                                       		$i++;
                                        }
                                    }else{
                                        echo "<tr><td align=\"center\" colspan=\"6\">".$arr_txt['data_not_found']."</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>                  
                    </div>
                </div>
                <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
            </form>
       </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
