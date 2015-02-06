<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 4;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);
$SAL_COM_ID = $_POST["SAL_COM_ID"];
$ORG_ID_3 = $_POST['ORG_ID_3'];
$YEAR_BDG = $_POST['YEAR_BDG'];
$ROUND = $_POST['ROUND'];


$sql =  "SELECT * FROM SAL_COMMAND A  WHERE  A.SAL_COM_ID = '".$SAL_COM_ID."'  ";
$query = $db->query($sql);
$data = $db->db_fetch_array($query);

if($data['MOVEMENT_ID']==15||$data['MOVEMENT_ID']==22||$data['MOVEMENT_ID']==26){
		$filter = "  A.SAL_COM_ID = ".$SAL_COM_ID; 
		
}
if($data['MOVEMENT_ID']==17||$data['MOVEMENT_ID']==23||$data['MOVEMENT_ID']==45){
		$filter = "  A.SAL_COM_TEMP = ".$SAL_COM_ID; 
}

if($data['MOVEMENT_ID']==16||$data['MOVEMENT_ID']==44||$data['MOVEMENT_ID']==27){
		$filter = "  A.SAL_COM_SPE =  ".$SAL_COM_ID; 

}




$sql_sal_up ="SELECT COUNT(PER_ID) AS PERSONAL, B.ORG_NAME_TH, A.ORG_ID_3  , A.YEAR_BDG , A.ROUND 
FROM SAL_UP_SALARY A
LEFT JOIN SETUP_ORG B ON A.ORG_ID_3 = B.ORG_ID
WHERE ".$filter."
GROUP BY A.ORG_ID_3, B.ORG_NAME_TH ,A.YEAR_BDG, A.ROUND ORDER BY B.ORG_NAME_TH ";
$query_sal_up = $db->query($sql_sal_up);
$nums = $db->db_num_rows($query_sal_up);
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_up_salary_detail.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li><a href="profile_his_up_salary_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการเลื่อนขั้นเงินเดือน)</a></li>
      <li class="active">ข้อมูลการเลื่อนขั้นเงินเดือน</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
        <?php //include("tab_info.php");?>
		<form id="frm-input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>">
        <input type="hidden" id="SAL_COM_ID" name="SAL_COM_ID" value="<?php echo $SAL_COM_ID;?>">
        <input type="hidden" id="ORG_ID_3" name="ORG_ID_3" value="<?php echo $ORG_ID_3?>">
        <input type="hidden" id="YEAR_BDG" name="YEAR_BDG" value="<?php echo $YEAR_BDG?>">
        <input type="hidden" id="ROUND" name="ROUND" value="<?php echo $ROUND?>">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <div class="row head-form">ข้อมูลการเลื่อนขั้นเงินเดือน</div>
        <div  class="row formSep">
          <div class="col-xs-12 col-sm-2">ปีงบประมาณ :</div>
          <div class="col-xs-12 col-sm-3"><?php echo $data["YEAR_BDG"]; ?></div>
          <div class="col-xs-12 col-sm-2 "  >รอบ :</div>
          <div class="col-xs-12 col-sm-2"><?php  echo  $data["ROUND"]; ?></div>
         </div>
         <div  class="row formSep">
          <div class="col-xs-12 col-sm-2 " >เลขที่คำสั่ง :</div>
          <div class="col-xs-12 col-sm-3"><?php echo text($data["COM_NO"]); ?></div>
          <div class="col-xs-12 col-sm-2 " >ลงวันที่ :</div>
          <div class="col-xs-12 col-sm-2"><?php  echo  conv_date($data["COM_DATE"],'short'); ?></div>
         </div>
         <div  class="row formSep">
          <div class="col-xs-12 col-sm-2 "  >เรื่อง :</div>
          <div class="col-xs-12 col-sm-4"><?php echo text($data["COM_TITLE"]); ?></div>
         </div>
          <div  class="row formSep">
          <div class="col-xs-12 col-sm-2" >วันที่มีผล :</div>
          <div class="col-xs-12 col-sm-2"><?php  echo  conv_date($data["COM_SDATE"],'short'); ?></div>
          </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>							
                    <tr class="bgHead">
                        <th width="60%"><div align="center"><strong>สำนัก</strong></div></th>
                        <th width="10%"><div align="center"><strong>จำนวนอัตรา (คน)</strong></div></th>
                         <th width="10%"><div align="center"><strong>รายละเอียด</strong></div></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($nums > 0) {
                    $i = 1;						
                    while($rec_sal_up= $db->db_fetch_array($query_sal_up)) {
                        $view = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"View('".$data['SAL_COM_ID']."','".$rec_sal_up["ORG_ID_3"]."','".$rec_sal_up['YEAR_BDG']."','".$rec_sal_up['ROUND']."');\">".$img_save." ดูรายละเอียด</a> ";
                     ?>
                    <tr bgcolor="#FFFFFF">
                        <td align="left"><?php echo text($rec_sal_up['ORG_NAME_TH']); ?>
                        <input type="hidden" id="ORG_ID_<?php echo $rec_sal_up['ORG_ID_3'] ?>" name="ORG_ID[]" value="<?php echo $rec_sal_up['ORG_ID_3'] ?>" >
                        </td>
                        <td align="center"><?php echo text($rec_sal_up['PERSONAL'],2); ?> </td>
                        <td align="center"><?php echo $view;?></td>
                    </tr>
                    <?php
                        $i++; 
                        }	
                     } else {
                        echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
                     }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="formlast">
            <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
                <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_up_salary_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PER_ID=".$PER_ID);?>';">ยกเลิก</button>
            </div>
        </div>
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>