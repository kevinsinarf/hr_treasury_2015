<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;;  /// for mobile
$paramlink = url2code($link);



// ## List Query Zone ## //
//--SEARCH

$filter = "";
if(trim($s_comset_year) != ""){
	$filter .= " AND A.COMSET_YEAR = '".$s_comset_year."' ";
}
if(trim($s_comtitle_id) != ""){
	$filter .= " AND A.COMTITLE_ID = '".$s_comtitle_id."' ";
}


//--ORDER BY
$orderby = " ORDER BY A.COMSET_YEAR DESC, B.COMTITLE_NAME_TH ASC ";
$groupby = "  ";
 
$table   = " COMPETENCY_SET A JOIN COMPETENCY_TITLE B ON A.COMTITLE_ID = B.COMTITLE_ID ";

 //--CONDITION
$cond    = " WHERE COMSET_TYPE = 1 ".$filter;
$notInto = " and A.COMSET_ID not in (select top ".$goto." A.COMSET_ID from ".$table.$cond.$orderby.")";

$field   = " A.COMSET_ID, A.COMSET_EXPECT, A.COMSET_YEAR, B.COMTITLE_NAME_TH, A.TYPE_ID, A.LEVEL_ID ";
 
 //--QUERY
$sql_main =  "SELECT TOP ".$page_size.$field." FROM ".$table.$cond.$notInto.$groupby.$orderby;

$querymain = $db->query($sql_main);
$nums = $db->db_num_rows($querymain);
$total_record = $db->db_num_rows($db->query("SELECT ".$field." FROM ".$table.$cond.$groupby));
 
// ##################### //


//หัวข้อสรรถนะ
$query_compet = $db->query("SELECT * FROM COMPETENCY_TITLE WHERE ACTIVE_STATUS = 1 AND COMTITLE_TYPE = 1");


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
<script src="js/competency_main_year.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div class="col-xs-12 col-md-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active">สมรรถนะหลักประจำปี</li>
        </ol>
    </div>
    <div class="col-xs-12 col-md-12" id="content">
        <div class="groupdata">
        	          
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="COMSET_ID" name="COMSET_ID" value="">
                
               <div class="row">
          			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ปีที่ใช้สมรรถนะ :</div>
                    <div class="col-xs-12 col-sm-2">
                      <input type="text" id="s_comset_year" name="s_comset_year" class="form-control number" placeholder="ปีที่ใช้สมรรถนะ" value="<?php echo $s_comset_year; ?>">
                    </div>
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อหัวข้อสมรรถนะหลัก :</div>
                    <div class="col-xs-12 col-sm-3">
                     <select id="s_comtitle_id" name="s_comtitle_id" class="selectbox form-control"  placeholder="ชื่อหัวข้อสมรรถนะหลัก">
                      <option value=""></option>
                      <?php while($rec_com = $db->db_fetch_array($query_compet)){ ?>
                                
                          <option value="<?php echo $rec_com['COMTITLE_ID']; ?>"<?php echo ($Y == $org_year ? "selected" : ""); ?>><?php echo text($rec_com['COMTITLE_NAME_TH']); ?></option>
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
                                       <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                       <th width="10%" ><div align="center">ปีที่ใช้สมรรถนะ</div></th>
                                   	   <th width="30%" ><div align="center"><strong>ชื่อหัวข้อสมรรถนะหลัก</strong></div></th>
                                       <th width="15%" ><div align="center"><strong>ประเภทตำแหน่ง</strong></div></th>
                                       <th width="15%" ><div align="center"><strong>ระดับตำแหน่ง</strong></div></th>
                                       <th width="10%" ><div align="center"><strong>ค่าความคาดหวัง</strong></div></th>
                                       <th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                      if($nums > 0){
                                      $i=1;
                                        while($recmain = $db->db_fetch_array($querymain)){
											if(chkPermission($menu_sub_id, 'edit')=='1'){
												$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$recmain["COMSET_ID"]."');\">".$img_edit." แก้ไข</a> ";
											}
											if(chkPermission($menu_sub_id, 'delete')=='1'){
												$delete = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"deleteData('".$recmain["COMSET_ID"]."');\">".$img_del." ลบ</a> ";
											}
															   
                                    ?>
                                    <tr bgcolor="#FFFFFF">

                                        <td align="center"><?php echo $i+$goto."."; ?></td>
                                         <td align="center"><?php echo $recmain['COMSET_YEAR']; ?></td>
                                        <td align="left"><?php echo text($recmain['COMTITLE_NAME_TH']);?></td>
                                        <td align="left"><?php echo text($arr_pos_type[$recmain['TYPE_ID']]);?></td>
                                        <td align="left"><?php echo text($arr_pos_level[$recmain['LEVEL_ID']]);?></td>
                                        <td align="center"><?php echo $recmain['COMSET_EXPECT']; ?></td>
                                        <td align="center"><?php echo $edit.$delete; ?></td>
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
