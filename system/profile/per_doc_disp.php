<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT = 6;
$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
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
$paramlink = url2code($link);
$arr_language = array('1' => 'ไทย', '2' => 'อังกฤษ', '3' => 'ไทยและอังกฤษ');
//  MAIN
$field="*";
$table="CERTIFICATE a 
JOIN CERTIFICATE_PER b ON b.CERT_ID=a.CERT_ID";
$pk_id="a.CERT_ID";
$wh = "a.DELETE_FLAG='0' and a.PER_ID = '" . $PER_ID . "'  and CERT_STATUS = '4' "; //and CERT_GROUP = '2'
$orderby = "order by REQUEST_DATE desc";
$notin = $wh . " and " . $pk_id . " not in (select top $goto " . $pk_id . " from " . $table . " where " . $wh . " " . $orderby . ") " . $orderby;

$sql = "select top {$page_size} " . $field . " from " . $table . " where " . $notin;
 $sql = "select " . $field . " from " . $table . " where " . $wh;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select " . $field . " from " . $table . " where " . $wh));
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

<script>
	function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","per_doc_form.php").submit();
}
function editData(id,sta,proc){
	$("#proc").val(proc);
	$("#CERT_ID").val(id);
        $("#REQ_STA").val(sta);
	$("#frm-search").attr("action","per_doc_form.php").submit();
}
</script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active">ประวัติการขอรับหนังสือรับรอง</li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content"> 
    	<?php include("tab_profile.php");?>
        <div class="grouptab">
            <br>
            <?php include("tab_info.php");?>
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
                <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
                <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
                <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
                <input type="hidden" id="MISS_ID" name="MISS_ID" value="">
				<input type="hidden" id="CERT_ID" name="CERT_ID" value="">
				<input type="hidden" id="REQ_STA" name="REQ_STA" value="">
        
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover table-condensed">
                                <thead>
                                    <tr class="bgHead">
                                        <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                       <th width="10%"><div align="center"><strong>วันที่ขอ</strong></div></th>
								<th width="10%"><div align="center"><strong>ภาษาที่ขอ</strong></div></th>
								<th width="30%"><div align="center"><strong>เหตุผลการขอทำหนังสือรับรอง</strong></div></th>
                                <th width="12%"><div align="center"><strong>สถานะ</strong></div></th>                                
								<th width="10%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                      
                                      
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                if($nums > 0){
                                    $i=1;
                                    while($rec = $db->db_fetch_array($query)){
                                       	$detail = "<button type=\"button\" class=\"btn btn-default btn-xs\" onClick=\"editData('".$rec["CERT_ID"]."','".$rec['CERT_STATUS']."','view');\">".$img_view." รายละเอียด</button> ";

                                    	?>
                                        <tr bgcolor="#FFFFFF">
											<td align="center"><?php echo $i+$goto; ?>.</td>
											<td align="center"><?php echo conv_date($rec["REQUEST_EOFFICE_DATE"],"short"); ?></td>
                                            <td align="left"><?php echo ($arr_language[$rec["REQUEST_LANGUAGE"]]);?></td>
											<td align="left"><?php echo text($arr_doc_req[$rec["REASON_ID"]]);?></td>
                                             <td align="center"><?php echo ($arr_req_doc_status[$rec["CERT_STATUS"]]);?></td>
											<td align="center"><?php echo $detail; ?></td>
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
            </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
