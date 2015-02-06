<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 3;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);
$ROTCOM_ID = $_POST['ROTCOM_ID'];

$data = $db->get_data_rec("SELECT * FROM ROTATE_COMMAND WHERE ROTCOM_ID = '".$ROTCOM_ID."' ");

$sql = "SELECT A.ROTDESC_ID,  A.ROTDESC_LAST_POS_NO AS POS_NO_LAST, C.TYPE_NAME_TH AS TYPE_NAME_LAST, D.LEVEL_NAME_TH AS LEVEL_NAME_LAST,
E.LINE_NAME_TH AS LINE_NAME_LAST, G.MANAGE_NAME_TH AS MANAGE_NAME_LAST, H.ORG_NAME_TH AS ORG_NAME_LAST_3,
J.ORG_NAME_TH AS ORG_NAME_LAST_4, A.ROTDESC_NEW_POS_NO AS POS_NO_NEW, L.TYPE_NAME_TH AS TYPE_NAME_NEW, M.LEVEL_NAME_TH AS LEVEL_NAME_NEW,
N.LINE_NAME_TH AS LINE_NAME_NEW, O.MANAGE_NAME_TH AS MANAGE_NAME_NEW, P.ORG_NAME_TH AS ORG_NAME_NEW_3, Q.ORG_NAME_TH AS ORG_NAME_NEW_4,
A.ROTDESC_TYPE_BUDGET, A.ROTDESC_TYPE_LIVE, K.PER_FIRSTNAME_TH, K.PER_MIDNAME_TH, K.PER_LASTNAME_TH, K.PREFIX_ID, A.ROTDESC_NOTE
FROM ROTATE_DESC A
LEFT JOIN SETUP_POS_TYPE C ON A.ROTDESC_LAST_TYPE_ID = C.TYPE_ID
LEFT JOIN SETUP_POS_LEVEL D ON A.ROTDESC_LAST_LEVEL_ID = D.LEVEL_ID
LEFT JOIN SETUP_POS_LINE E ON A.ROTDESC_LAST_LINE_ID = E.LINE_ID
LEFT JOIN SETUP_POS_MANAGE G ON A.ROTDESC_LAST_MANAGE_ID = G.MANAGE_ID
LEFT JOIN SETUP_ORG H ON A.ROTDESC_LAST_ORG_ID_3 = H.ORG_ID
LEFT JOIN SETUP_ORG J ON A.ROTDESC_LAST_ORG_ID_4 = J.ORG_ID
JOIN PER_PROFILE  K ON  K.PER_ID = A.ROTDESC_PER_ID

LEFT JOIN SETUP_POS_TYPE L ON A.ROTDESC_NEW_TYPE_ID = L.TYPE_ID
LEFT JOIN SETUP_POS_LEVEL M ON A.ROTDESC_NEW_LEVEL_ID = M.LEVEL_ID
LEFT JOIN SETUP_POS_LINE N ON A.ROTDESC_NEW_LINE_ID = N.LINE_ID
LEFT JOIN SETUP_POS_MANAGE O ON A.ROTDESC_NEW_MANAGE_ID = O.MANAGE_ID
LEFT JOIN SETUP_ORG P ON A.ROTDESC_NEW_ORG_ID_3 = P.ORG_ID
LEFT JOIN SETUP_ORG Q ON A.ROTDESC_NEW_ORG_ID_4 = Q.ORG_ID
WHERE A.ROTCOM_ID = '".$ROTCOM_ID."' ";
$query_posi = $db->query($sql);


$arr_move_type = array(1=> "ตามคำขอ", 2=> "ตามคำบัญชา");
$arr_budget_type = array(1=> "อาศัยเบิก", 2 =>"สับเปลี่ยนอัตราเงินเดือน");
$arr_live_type = array(1=> 'ปกติ', 2 => 'ปฏิบัติราชการแทน', 3 => 'รักษาราชการแทน', 4 => 'ช่วยราชการ');

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
<script src="js/profile_his_appointment_detail.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li><a href="profile_his_appointment_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการย้ายตำแหน่ง)</a></li>
      <li class="active">รายละเอียด</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
        <?php //include("tab_info.php");?>
		 <form action="process/profile_his_transfer_appointment_process.php" method="post" enctype="multipart/form-data" id="frm-input">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="ROTCOM_ID" name="ROTCOM_ID" value="<?php echo $ROTCOM_ID;?>">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row head-form">ข้อมูลการย้ายตำแหน่ง</div>
        <div  class="row formSep">
              <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >เลขที่คำสั่ง :</div>
              <div class="col-xs-12 col-sm-2"><?php echo text($data["ROTCOM_NO"]); ?></div>
              <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >ลงวันที่ :</div>
              <div class="col-xs-12 col-sm-2"><?php  echo  conv_date($data["ROTCOM_DATE"]); ?></div>
          </div>
          
          <div  class="row formSep">
              <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >เรื่อง :</div>
              <div class="col-xs-12 col-sm-2"><?php  echo text($data["ROTCOM_TITLE"]);  ?></div>
           </div>
           
            <div  class="row formSep">
              <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >วันที่มีผล :</div>
              <div class="col-xs-12 col-sm-2"><?php   echo  conv_date($data["ROTCOM_SDATE"]); ?></div>
              <div class="col-xs-12 col-sm-2 col-sm-offset-1 " align="right" >ประเภทการย้ายและแต่งตั้ง :</div>
              <div class="col-xs-12 col-sm-2"><?php echo $arr_move_type[$data["ROTCOM_TYPE"]]; ?></div>
          </div>
          
					<div class="table-responsive">
                     <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                     <thead>
                        <tr class="bgHead">                        
                        	<th width="5%" style="text-align:center;" ><strong>ลำดับ</strong></th>  
                            <th width="15%" style="text-align:center;" ><strong>ชื่อสกุล</strong></th>                                                                
                          	<th width="25%" style="text-align:center;" ><strong>ตำแหน่งเดิม</strong></th>
                            <th width="25%" style="text-align:center;" ><strong>ตำแหน่งใหม่</strong></th>
                            <th width="10%" style="text-align:center;" ><strong>ประเภทการเบิกจ่าย</strong></th>
                            <th width="10%" style="text-align:center;" ><strong>ประเภทการถือครอง</strong></th>
                            <th width="10%" style="text-align:center;" ><strong>หมายเหตุ</strong></th>
                        </tr>
                    </thead>
                     <tbody>
                  <?php  while($rec_posi = $db->db_fetch_array($query_posi)){  ?>
                      <tr>
                      
                      <td align="center" valign="top"> <?php $i=1; echo $i++;?> </td>
                      <td align="left" valign="top"><?php echo Showname($rec_posi["PREFIX_ID"],$rec_posi["PER_FIRSTNAME_TH"],$rec_posi["PER_MIDNAME_TH"],$rec_posi["PER_LASTNAME_TH"]);?></td>
                      <td align='left' valign="top">                       
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left'><?php echo $arr_txt['pos_no']; ?> :</div>
                         <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['POS_NO_LAST']); ?></div>
                        </div>
                       	<div class='row formSep'>
                       	  <div class='col-xs-12 col-sm-6' align='left' ><?php echo $arr_txt['type_pos']; ?> :</div>
                              <div class='col-xs-12 col-sm-3' ><?php echo text($rec_posi['TYPE_NAME_LAST']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left'>ระดับตำแหน่ง :</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['LEVEL_NAME_LAST']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >ตำแหน่งในสายงาน :</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo  text($rec_posi['LINE_NAME_LAST']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >ตำแหน่งทางการบริหาร :</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo  text($rec_posi['MANAGE_NAME_LAST']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >สำนัก/กลุ่ม :</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo  text($rec_posi['ORG_NAME_LAST_3']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >กลุ่มงาน :</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['ORG_NAME_LAST_4']); ?></div>
                        </div>
                      </td>
                      <td align='left' valign="top">                       
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left'><?php echo $arr_txt['pos_no']; ?>:</div>
                            <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['POS_NO_NEW']); ?></div>
                        </div>
                       	<div class='row formSep'>
                          <div class='col-xs-12 col-sm-6' align='left' ><?php echo $arr_txt['type_pos']; ?>:</div>
                              <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['TYPE_NAME_NEW']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left'>ระดับตำแหน่ง:</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['LEVEL_NAME_NEW']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >ตำแหน่งในสายงาน:</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo  text($rec_posi['LINE_NAME_NEW']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >ตำแหน่งทางการบริหาร:</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo  text($rec_posi['MANAGE_NAME_NEW']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >สำนัก/กลุ่ม:</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo  text($rec_posi['ORG_NAME_NEW_3']); ?></div>
                        </div>
                        <div class='row formSep'>
                        <div class='col-xs-12 col-sm-6' align='left' >กลุ่มงาน:</div>
                          <div class='col-xs-12 col-sm-6'  ><?php echo text($rec_posi['ORG_NAME_NEW_4']); ?></div>
                        </div>
                      
                      </td>
                      <td valign="top" align="center"><?php   echo $arr_budget_type[$rec_posi["ROTDESC_TYPE_BUDGET"]]; ?></td>
                      <td valign="top" align="center"><?php  echo $arr_live_type[$rec_posi["ROTDESC_TYPE_LIVE"]]; ?></td>
                        <td valign="top" align="left"><?php  echo $rec_posi['ROTDESC_NOTE'];  ?></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table>                  
                    </div>
               
          
        <div class="formlast">
            <div class="col-xs-12 col-sm-12" align="center">
                <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
                <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_appointment_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PER_ID=".$PER_ID);?>';">ยกเลิก</button>
            </div>
        </div>
      </form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>