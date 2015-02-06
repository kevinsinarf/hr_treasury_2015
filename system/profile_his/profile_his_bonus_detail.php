<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 2;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);
$BONUS_COM_ID = $_POST['BONUS_COM_ID'];

$sql = "SELECT A.PER_ID, A.BONUS_M1, A.BONUS_M2, B.PREFIX_ID, B.PER_FIRSTNAME_TH, B.PER_MIDNAME_TH, B.PER_LASTNAME_TH, C.LINE_NAME_TH
FROM BONUS_ADJUST A 
JOIN PER_PROFILE B ON  A.PER_ID =  B.PER_ID
LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID  
WHERE A.BONUS_COM_ID = '".$BONUS_COM_ID."' ";
$query = $db->query($sql);
$data = $db->get_data_rec("SELECT * FROM BONUS_COMMAND WHERE BONUS_COM_ID = '".$BONUS_COM_ID."'  ");
$bonus1=$data["BONUS_M1"]; 
$bonus2=$data["BONUS_M2"]; 
$bonus_total=$bonus1+$bonus2;

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
<script src="js/profile_his_bonus_detail.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li><a href="profile_his_bonus_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลจัดสรรเงินรางวัลประจำปี)</a></li>
      <li class="active">รายละเอียด</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
       
		<form id="frm-input" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID;?>">
        <input type="hidden" id="BONUS_COM_ID" name="BONUS_COM_ID" value="<?php echo $BONUS_COM_ID;?>">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
 
      	<div class="row head-form">ข้อมูลจัดสรรเงินรางวัลประจำปี</div>
        <div  class="row formSep">
            <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >เลขที่คำสั่ง :</div>
            <div class="col-xs-12 col-sm-2">
			<?php echo text($data["COM_NO"]); ?>
            </div>
            <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >ลงวันที่ :</div>
             <div class="col-xs-12 col-sm-2">
			<?php  echo  conv_date($data["COM_SDATE"]); ?>
            </div>
          </div>
          
          <div  class="row formSep">
              <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >เรื่อง :</div>
              <div class="col-xs-12 col-sm-2">
			<?php  echo text($data["COM_TITLE"]);  ?>
            </div>
           </div>
           
            <div  class="row formSep">
            <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >วันที่มีผล :</div>
              <div class="col-xs-12 col-sm-2">
			<?php echo conv_date($data["COM_DATE"]); ?>
            </div>
          </div>
          <div class="table-responsive">
          <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
            <thead>
                <tr class="bgHead">
                    <th width="3%"><div align="center"><strong>ลำดับ</strong></div></th>
                    <th width="16%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>                                                            
                    <th width="16%"><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                    <th width="10%" nowrap><div align="center"><strong>จัดสรรส่วนพื้นฐาน</strong></div></th>
                    <th width="10%" nowrap><div align="center"><strong>จัดสรรส่วนผันแปร</strong></div></th>
                </tr>
            </thead>
            <tbody >
            <?php
               $i = 1;
                while($rec = $db->db_fetch_array($query)){
                    $NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
                    ?>
                    
                    <tr id="row_<?php echo $i;?>">
                        <td align="center"><?php echo $i; ?>.</td>
                        <td align="left"><?php echo $NAME;?></td>
                        <td align="left"><?php echo text($rec['LINE_NAME_TH']);?></td>
                        <td align="right"><?php echo number_format($rec['BONUS_M1'],2); ?></td>
                        <td align="right"><?php echo number_format($rec['BONUS_M2'],2); ?></td>
                        
                    </tr>
                    <?php
                    $i++;
                }
            
            ?>
          </tbody>
        </table>
        </div>
        <div class="formlast">
            <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
                <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_bonus_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PER_ID=".$PER_ID);?>';">ยกเลิก</button>
            </div>
        </div>
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>