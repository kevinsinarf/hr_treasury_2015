<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "ดูรายละเอียด";
$path_file = "../../fileupload/file_retirement";
//POST
$COM_ID = $_POST['COM_ID'];
$RETYPE_TYPE = $_POST['RETYPE_TYPE'];
if($COM_ID != ''){
	$sql = " SELECT * FROM RETIRE_COMMAND WHERE COM_ID = '".$COM_ID."'";
	$query = $db->query($sql);
	$recmain = $db->db_fetch_array($query);
}
	$arr_retype2 = GetSqlSelectArray("RETYPE_ID","RETYPE_NAME_TH","RETIRE_SETUP_TYPE"," ACTIVE_STATUS=1 and DELETE_FLAG='0' ","RETYPE_NAME_TH" );
$arr_command = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE" , "ACTIVE_STATUS = '1' and DELETE_FLAG = '0'  " , "CT_NAME_TH");
$arr_movement = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT" , "ACTIVE_STATUS = '1' and DELETE_FLAG = '0' AND POSTYPE_ID = '1' AND MOVEMENT_TYPE = '7'" , "MOVEMENT_SEQ"); 
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_out_gov_detail2.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo "profile_his_out_gov_disp.php"."?".url2code($link2);?>">ข้อมูลการออกจากราชการ</a></li>
      <li class="active"><?php echo $txt;?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
      <form id="frm-input" method="post" action="process/profile_his_out_gov_tranfer_process2.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="COM_ID" name="COM_ID" value="<?php echo $COM_ID;?>">
        <!-------เกษียณอายุราชการ------------------------------------------->
		<div class="row head-form">ประกาศให้พ้นจากราชการ</div>
      
        	 <?php if($RETYPE_TYPE==1){//เสียชีวิต สาปสูญ 
			 ?>
		 <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">ประเภทหนังสือ : </div>
              <div class="col-xs-12 col-sm-3">
              	<?php echo text($arr_command[$recmain["CT_ID"]]);?>
              </div>
              <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ประเภทความเคลื่อนไหว : </div>
              <div class="col-xs-12 col-sm-3">
              	<?php echo text($arr_movement[$recmain["MOVEMENT_ID"]]);?>
              </div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">เลขที่หนังสือ : </div>
              <div class="col-xs-12 col-sm-3"><?php echo text($recmain['COM_NO']); ?>
              </div>
              <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ลงวันที่ :</div>
              <div class="col-xs-12 col-sm-2"> <?php echo conv_date($recmain['COM_DATE'],'short'); ?>
              </div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">เรื่อง : </div>
              <div class="col-xs-12 col-sm-4"><?php echo text($recmain['COM_TITLE']); ?>
              </div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">วันที่มีผล :</div>
              <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_SDATE'],'short') ?></div>
          </div>
          <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">หมายเหตุ :</div>
              <div class="col-xs-12 col-sm-2"><?php echo text($recmain['COM_NOTE']) ?></div>
          </div>
          <?
			 }
			 ?> 
        <?php if($RETYPE_TYPE==3){ //เกษียณอายุราชการ?>           
        <div class="row formSep">
            <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">ประเภทประกาศ :</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_command[$recmain["CT_ID"]]);?></div>
            <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ประเภทความเคลื่อนไหว :</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_movement[$recmain["MOVEMENT_ID"]]);?></div>
        </div>               
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เรื่อง :</div>
            <div class="col-xs-12 col-sm-5"><?php echo text($recmain['COM_TITLE']);?></div>
        </div> 
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่มีผล :</div>
            <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_SDATE'],'short');?>
        	</div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ลงวันที่ :</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_DATE'],'short');?>
            </div>            
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ :</div>
            <div class="col-xs-12 col-sm-4"><?php echo text($recmain['COM_NOTE']);?></div>
        </div>
        <?php  }
		if($RETYPE_TYPE==4){ //มาตรา 83
			?>
		 <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">ประเภทคำสั่ง :</div>
              <div class="col-xs-12 col-sm-3">
              	<?php echo text($arr_command[$recmain["CT_ID"]]);?>
              </div>
              <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ประเภทความเคลื่อนไหว :</div>
              <div class="col-xs-12 col-sm-3">
              	<?php echo text($arr_movement[$recmain["MOVEMENT_ID"]]);?>
              </div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">เลขที่คำสั่ง :</div>
              <div class="col-xs-12 col-sm-3"><?php echo text($recmain['COM_NO']); ?>
              </div>
              <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ลงวันที่ :</div>
              <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_DATE'],'short'); ?>
              </div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">เรื่อง :</div>
              <div class="col-xs-12 col-sm-4"><?php echo text($recmain['COM_TITLE']); ?>
              </div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">วันที่มีผล :</div>
              <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_SDATE'],'short') ?></div>
          </div>
         <div class="row formSep">
              <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">หมายเหตุ :</div>
              <div class="col-xs-12 col-sm-4"><?php echo text($recmain['COM_NOTE']); ?>
            </div>
          </div>

          <?
		}if($RETYPE_TYPE==6){ ?>
		<div class="row formSep">
            <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">ประเภทคำสั่ง :</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_command[$recmain["CT_ID"]]);?></div>
            <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ประเภทความเคลื่อนไหว :</div>
            <div class="col-xs-12 col-sm-3"><?php echo text($arr_movement[$recmain["MOVEMENT_ID"]]);?></div>
        </div> 
        <div class="row formSep">
            <div class="col-xs-12 col-md-2"  style="white-space:nowrap;">เลขที่คำสั่ง :</div>
            <div class="col-xs-12 col-sm-2"><?php echo text($recmain['COM_NO']);?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">ลงวันที่ :</div>
                <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_DATE'],'short');?>
            </div>
        </div>  
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เรื่อง :</div>
            <div class="col-xs-12 col-sm-5"><?php echo text($recmain['COM_TITLE']);?></div>
        </div> 
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่มีผล :</div>
            <div class="col-xs-12 col-sm-2"><?php echo conv_date($recmain['COM_SDATE'],'short');?>
        	</div>
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมายเหตุ :</div>
            <div class="col-xs-12 col-sm-4"><?php echo text($recmain['COM_NOTE']);?></div>
        </div>
        <?
        }
		?>
         <?php if($RETYPE_TYPE==3){ ?>
        <div class="table-responsive">
             <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                <thead>
                    <tr class="bgHead">
                        <th width="15%" style="text-align:center; vertical-align:text-top;"><strong>ชื่อ-สกุล</strong></th>                                                            
                        <th width="20%" style="text-align:center; vertical-align:text-top;"><strong>ตำแหน่ง/สังกัด</strong></th>
                        <th width="12%" style="text-align:center; vertical-align:text-top;"><strong>สิทธิการขอรับ<br>บำเหน็จบำนาญ</strong></th>
                        <th width="12%" style="text-align:center; vertical-align:text-top;"><strong>สิทธิการขอรับ<br>บำเหน็จบำนาญตาม</strong></th>
                        <th width="12%" style="text-align:center; vertical-align:text-top;"><strong>เหตุแห่งการขอ<br>รับบำเหน็จบำนาญ</strong></th>
                       
                    </tr>
                </thead>
                <tbody>
                <?php
					$q_sub = $db->query("SELECT A.PER_ID, H.POS_NO, H.PER_DATE_BIRTH, H.PER_IDCARD, H.PREFIX_ID, H.PER_FIRSTNAME_TH, H.PER_MIDNAME_TH, 
						H.PER_LASTNAME_TH, B.TYPE_NAME_TH, C.LEVEL_NAME_TH, D.LINE_NAME_TH, E.ORG_NAME_TH AS ORG_NAME_3, G.ORG_NAME_TH AS ORG_NAME_4, 
						A.RETYPE_ID, A.COMDESC_PENSION_RIGHT, A.COMDESC_PENSION_LAWS, A.COMDESC_PENSION_REASON, A.COMDESC_CIVIL_MONTH, A.COMDESC_CIVIL_YEAR,A.COMDESC_EDATE_PRESENT,A.COMDESC_EDATE_CIVIL
						,A.COMDESC_ORG_ID_1,A.COMDESC_ORG_ID_2,A.COMDESC_NOTE
						FROM RETIRE_COMMAND_DESC A
						LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
						LEFT JOIN SETUP_POS_LEVEL C  ON A.LEVEL_ID = C.LEVEL_ID
						LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
						LEFT JOIN SETUP_ORG E ON A.ORG_ID_3 = E.ORG_ID
						LEFT JOIN SETUP_ORG G ON A.ORG_ID_4 = G.ORG_ID
						LEFT JOIN PER_PROFILE H ON A.PER_ID = H.PER_ID
										WHERE A.COM_ID = '".$COM_ID."' ORDER BY A.COMDESC_ID ASC");
					while($r_sub = $db->db_fetch_array($q_sub)){
						$name = Showname($r_sub["PREFIX_ID"],$r_sub["PER_FIRSTNAME_TH"],$r_sub["PER_MIDNAME_TH"],$r_sub["PER_LASTNAME_TH"]);
						?>
						<tr>
							<td><?php echo $name;?></td>
							<td><input type='hidden' name='PER_ID[<?php echo $r_sub['PER_ID'];?>]' value='<?php echo $r_sub['PER_ID'];?>' />
							<div><strong><?php echo $arr_txt['pos_no']; ?> :</strong><?php echo $r_sub['POS_NO'];?></div>
							<div><strong>ตำแหน่ง :</strong><?php echo text($r_sub['LINE_NAME_TH']);?></div>
							<div><strong>ระดับ :</strong><?php echo text($r_sub['LEVEL_NAME_TH']);?></div>
							<div><strong>กลุ่มงาน :</strong><?php echo text($r_sub['ORG_NAME_3']);?></div>
							<div><strong>สำนัก/กลุ่ม :</strong><?php echo text($r_sub['ORG_NAME_4']);?></div>
							<div><strong>อายุราชการ :</strong><?php echo $r_sub['COMDESC_CIVIL_YEAR']; ?> ปี <?php echo $r_sub['COMDESC_CIVIL_MONTH']; ?> เดือน</div>
							</th>
							<td><?php echo $arr_reward[$r_sub['COMDESC_PENSION_RIGHT']];?></td>
							<td><?php echo $arr_pension[$r_sub['COMDESC_PENSION_LAWS']];?></td>
							<td><?php echo $arr_retirement[$r_sub['COMDESC_PENSION_REASON']];?></td>
							
						</tr>
						<?php
					}
		 }
				?>
                </tbody>
           	</table>

		<!-------เสียชีวิต/สาปสูญ---------------------------------------------->
        <?php if($RETYPE_TYPE==1){ ?>         
         <div class="table-responsive">
            	 <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                        <thead>
                            <tr class="bgHead">
                                <th width="30%" style="text-align:center; vertical-align:text-top;" ><strong>ชื่อ-สกุล</strong></th>                                                            
                                <th width="25%" style="text-align:center; vertical-align:text-top;" ><strong>ตำแหน่ง/สังกัด</strong></th>
                                <th width="20%" style="text-align:center; vertical-align:text-top;" ><strong>สาเหตุ</strong></th>
                                <th width="25%" style="text-align:center; vertical-align:text-top;" ><strong>สิทธิการขอรับ<br>
                                บำเหน็จตกทอด</strong></th>
                                  <th width="25%" style="text-align:center; vertical-align:text-top;" ><strong>แนบไฟล์</strong></th>
                              
                            </tr>
                        </thead>
                        <tbody >
                       <?php
						   $query_desc = $db->query("SELECT A.PER_ID, H.POS_NO, H.PER_DATE_BIRTH, H.PER_IDCARD, H.PREFIX_ID, H.PER_FIRSTNAME_TH, H.PER_MIDNAME_TH, 
							H.PER_LASTNAME_TH, B.TYPE_NAME_TH, C.LEVEL_NAME_TH, D.LINE_NAME_TH, E.ORG_NAME_TH AS ORG_NAME_3, G.ORG_NAME_TH AS ORG_NAME_4, 
							A.RETYPE_ID, A.COMDESC_PENSION_RIGHT, A.COMDESC_PENSION_LAWS, A.COMDESC_PENSION_REASON, H.PER_DATE_ENTRANCE,  A.COMDESC_CIVIL_YEAR, 
							A.COMDESC_CIVIL_MONTH,A.COMDESC_FILE
							FROM RETIRE_COMMAND_DESC A
							LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
							LEFT JOIN SETUP_POS_LEVEL C  ON A.LEVEL_ID = C.LEVEL_ID
							LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
							LEFT JOIN SETUP_ORG E ON A.ORG_ID_3 = E.ORG_ID
							LEFT JOIN SETUP_ORG G ON A.ORG_ID_4 = G.ORG_ID
							LEFT JOIN PER_PROFILE H ON A.PER_ID = H.PER_ID
							WHERE A.COM_ID = '".$COM_ID."' ");
						   while($rec_sub = $db->db_fetch_array($query_desc)){
							  $name=Showname($rec_sub["PREFIX_ID"],$rec_sub["PER_FIRSTNAME_TH"],$rec_sub["PER_MIDNAME_TH"],$rec_sub["PER_LASTNAME_TH"]);
							  $PER_ID = $rec_sub['PER_ID'];
							 // $view_train = "<a href=\"../../fileupload/file_retirement\<>"  data-toggle=\"modal\" data-target=\"#myModal2\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\"  >".$img_view." ไฟล์แนบ</a><br>";
						   ?> 
						   <tr>
							<td align='left'>
							  <div><strong><?php echo $arr_txt['idcard']; ?> :</strong><?php echo get_idCard($rec_sub['PER_IDCARD']); ?></div>
							  <div><strong>ชื่อ-สกุล :</strong><?php echo $name; ?></div>
							  <div><strong>วันเดือนปีเกิด :</strong><?php echo conv_date($rec_sub['PER_DATE_BIRTH'],'short'); ?></div>
                              <div><strong>วันที่บรรจุ :</strong><?php echo conv_date($rec_sub['PER_DATE_ENTRANCE'],'short'); ?></div>
                              <div><strong>อายุราชการ : </strong><?php echo $rec_sub['COMDESC_CIVIL_YEAR']; ?> ปี <?php echo $rec_sub['COMDESC_CIVIL_MONTH']; ?> เดือน</div>
							</td>
							<td align='left'>
							  <input type='hidden' name='PER_ID[]' value='<?php echo $rec_sub['PER_ID']; ?>' />
							  <div><strong><?php echo $arr_txt['pos_no']; ?> :</strong><?php echo $rec_sub['POS_NO']; ?></div>
							  <div><strong>ตำแหน่ง :</strong><?php echo text($rec_sub['LINE_NAME_TH']); ?></div>
							  <div><strong>ระดับ :</strong><?php echo text($rec_sub['LEVEL_NAME_TH']); ?></div>
							  <div><strong>กลุ่มงาน :</strong><?php echo text($rec_sub['ORG_NAME_3']); ?></div>
							  <div><strong>สำนัก/กลุ่ม :</strong><?php echo text($rec_sub['ORG_NAME_4']); ?></div>
							</td>
							<td align='left'><?php echo text($arr_retype2[$rec_sub['RETYPE_ID']]); ?></td>
							<td align='left'>
							<?php echo $arr_pension[$rec_sub['COMDESC_PENSION_LAWS']]; ?>
							</td>
                            <td><?php   $str =  trim($rec_sub['COMDESC_FILE'])."x";
								if($str!="x"){ 
									echo $view_atten = "<a   class=\"btn btn-default btn-xs\" data-backdrop=\"static\"   href='".$path_file."/".$rec_sub['COMDESC_FILE']."'>".$img_view." ".$arr_txt['download']."</a>";
								 } else{
									echo $view_atten = "-";
								}
								?></td>
						  </tr>
						   <?php
					   } 
					   ?>
                        </tbody>
                   </table>
        <?php } ?>
        <!-------ตามมาตรา83---------------------------------------------->
        <?php if($RETYPE_TYPE==4){ ?>  
         <div class="row formSep">
          	<div class="table-responsive">
            	 <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                        <thead>
                            <tr class="bgHead">
                                <th width="15%" style="text-align:center; vertical-align:text-top;" ><strong>ชื่อ-สกุล</strong></th>                                                            
                                <th width="12%" style="text-align:center; vertical-align:text-top;" ><strong>ตำแหน่ง/สังกัด</strong></th>
                                <th width="12%" style="text-align:center; vertical-align:text-top;" ><strong>สาเหตุ</strong></th>
                                <th width="12%" style="text-align:center; vertical-align:text-top;" ><strong>สิทธิการขอรับ<br>บำเหน็จบำนาญ</strong></th>
                                <th width="12%" style="text-align:center; vertical-align:text-top;" ><strong>สิทธิการขอรับ<br>บำเหน็จบำนาญตาม</strong></th>
                                <th width="12%" style="text-align:center; vertical-align:text-top;" ><strong>เหตุแห่งการขอ<br>รับบำเหน็จบำนาญ</strong></th>
                                  <th width="5%" style="text-align:center; vertical-align:text-top;" ><strong>ไฟล์แนบ</strong></th>
                            </tr>
                        </thead>
                        <tbody >
                       <?php
					   	$query_desc = $db->query("SELECT A.PER_ID, H.POS_NO, H.PER_DATE_BIRTH, H.PER_IDCARD, H.PREFIX_ID, H.PER_FIRSTNAME_TH, H.PER_MIDNAME_TH, 
						H.PER_LASTNAME_TH, B.TYPE_NAME_TH, C.LEVEL_NAME_TH, D.LINE_NAME_TH, E.ORG_NAME_TH AS ORG_NAME_3, G.ORG_NAME_TH AS ORG_NAME_4, 
						A.RETYPE_ID, A.COMDESC_PENSION_RIGHT, A.COMDESC_PENSION_LAWS, A.COMDESC_PENSION_REASON, A.COMDESC_CIVIL_MONTH, A.COMDESC_CIVIL_YEAR,A.COMDESC_FILE
						FROM RETIRE_COMMAND_DESC A
						LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
						LEFT JOIN SETUP_POS_LEVEL C  ON A.LEVEL_ID = C.LEVEL_ID
						LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
						LEFT JOIN SETUP_ORG E ON A.ORG_ID_3 = E.ORG_ID
						LEFT JOIN SETUP_ORG G ON A.ORG_ID_4 = G.ORG_ID
						LEFT JOIN PER_PROFILE H ON A.PER_ID = H.PER_ID
						WHERE A.COM_ID = '".$COM_ID."' ");

					   while($rec_sub = $db->db_fetch_array($query_desc)){
						  $name=Showname($rec_sub["PREFIX_ID"],$rec_sub["PER_FIRSTNAME_TH"],$rec_sub["PER_MIDNAME_TH"],$rec_sub["PER_LASTNAME_TH"]);
						  $PER_ID = $rec_sub['PER_ID'];
						  
						  $view_train = "<a  data-toggle=\"modal\" data-target=\"#myModal2\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\"  >".$img_view." ไฟล์แนบ</a><br>";
						  	$view_rule = "<a data-toggle=\"modal\" data-target=\"#myModal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\"  onClick=\"viewRule('".$rec["PER_ID"]."');\">".$img_view." ประวัติการรับโทษทางวินัย</a><br>";
						   ?> 
						   <tr>
							<td align='left'>
							  <div><strong><?php echo $arr_txt['idcard']; ?> :</strong></div>
							  <div><?php echo get_idCard($rec_sub['PER_IDCARD']); ?></div>
							  <div><strong>ชื่อ-สกุล :</strong></div>
							  <div><?php echo $name; ?></div>
							  <div><strong>วันเดือนปีเกิด :</strong></div>
							  <div><?php echo conv_date($rec_sub['PER_DATE_BIRTH'],'short'); ?></div>
							</td>
							<td align='left'>
							  <input type='hidden' name='PER_ID[]' value='<?php echo $rec_sub['PER_ID']; ?>' />
							  <div><strong><?php echo $arr_txt['pos_no']; ?> :</strong><?php echo $rec_sub['POS_NO']; ?></div>
							  <div><strong>ตำแหน่ง :</strong><?php echo text($rec_sub['LINE_NAME_TH']); ?></div>
							  <div><strong>ระดับ :</strong><?php echo text($rec_sub['LEVEL_NAME_TH']); ?></div>
							  <div><strong>กลุ่มงาน :</strong><?php echo text($rec_sub['ORG_NAME_3']); ?></div>
							  <div><strong>สำนัก/กลุ่ม :</strong><?php echo text($rec_sub['ORG_NAME_4']); ?></div>
							  <div><strong>อายุราชการ :</strong><?php if(trim($rec_sub['COMDESC_CIVIL_YEAR'])!=""){ echo text($rec_sub['COMDESC_CIVIL_YEAR'])." ปี ".text($rec_sub['COMDESC_CIVIL_MONTH'])." เดือน"; }?></div>
							</td>
							<td align='left'>
							 <?php echo text($arr_retype2[$rec_sub['RETYPE_ID']]); ?>
							</td>
							<td align='left'>
							 <?php echo $arr_reward[$rec_sub['COMDESC_PENSION_RIGHT']]; ?>
							</td>
							<td align='left'>
							<?php echo $arr_pension[$rec_sub['COMDESC_PENSION_LAWS']]; ?>
							</td>
							<td align='left'>
							<?php echo $arr_retirement[$rec_sub['COMDESC_PENSION_REASON']]; ?>
							</td>
                            <td align="left">
							<?php 
							   $str =  trim($rec_sub['COMDESC_FILE'])."x";
								if($str!="x"){ 
									echo $view_atten = "<a   class=\"btn btn-default btn-xs\" data-backdrop=\"static\"   href='".$path_file."/".$rec_sub['COMDESC_FILE']."'>".$img_view." ".$arr_txt['download']."</a>";
								 } else{
									echo $view_atten = "-";
								}
								
							?>
							<?php //echo displayDownloadFileAttach($path_file,$rec_sub['COMDESC_FILE'],$arr_txt['download']);?></td>
						  </tr>
						   <?php 
						   } 
					   }
					   ?>
                        </tbody>
                   </table>
       
       <!-------คำสั่งให้ออกจากราชการอื่น(สงวนตำแหน่ง)---------------------------------------------->    
       <?php if($RETYPE_TYPE==6){ ?>  
        <div class="table-responsive">
             <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                <thead>
                    <tr class="bgHead">
                        <th width="20%" style="text-align:center; vertical-align:text-top;"><strong>ชื่อ-สกุล</strong></th>                                                            
                        <th width="20%" style="text-align:center; vertical-align:text-top;"><strong>ตำแหน่ง/สังกัด</strong></th>
                        <th width="12%" style="text-align:center; vertical-align:text-top;"><strong>สาเหตุ</strong></th>
                        <th width="20%" style="text-align:center; vertical-align:text-top;"><strong>วันที่ครบกำหนดกลับมารายงานตัว<br>นับจากวันที่พ้นจากราชการทหาร/อื่น ๆ</strong></th>
                        <th width="12%" style="text-align:center; vertical-align:text-top;"><strong>วันที่รายงานตัวกลับ<br>เข้ารับราชการ</strong></th>
                        <th width="12%" style="text-align:center; vertical-align:text-top;"><strong>ส่วนราชการที่ไป</strong></th>
                    </tr>
                </thead>
                <tbody>
                <?php
				
					$arr_org1 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG","OL_ID = '2' and ACTIVE_STATUS=1 and DELETE_FLAG='0' ","ORG_SEQ" );
					$q_sub = $db->query("SELECT A.PER_ID, H.POS_NO, H.PER_DATE_BIRTH, H.PER_IDCARD, H.PREFIX_ID, H.PER_FIRSTNAME_TH, H.PER_MIDNAME_TH, 
						H.PER_LASTNAME_TH, B.TYPE_NAME_TH, C.LEVEL_NAME_TH, D.LINE_NAME_TH, E.ORG_NAME_TH AS ORG_NAME_3, G.ORG_NAME_TH AS ORG_NAME_4, 
						A.RETYPE_ID, A.COMDESC_PENSION_RIGHT, A.COMDESC_PENSION_LAWS, A.COMDESC_PENSION_REASON, A.COMDESC_CIVIL_MONTH, A.COMDESC_CIVIL_YEAR,A.COMDESC_EDATE_PRESENT,A.COMDESC_EDATE_CIVIL
						,A.COMDESC_ORG_ID_1,A.COMDESC_ORG_ID_2,A.COMDESC_NOTE
						FROM RETIRE_COMMAND_DESC A
						LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
						LEFT JOIN SETUP_POS_LEVEL C  ON A.LEVEL_ID = C.LEVEL_ID
						LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
						LEFT JOIN SETUP_ORG E ON A.ORG_ID_3 = E.ORG_ID
						LEFT JOIN SETUP_ORG G ON A.ORG_ID_4 = G.ORG_ID
						LEFT JOIN PER_PROFILE H ON A.PER_ID = H.PER_ID
										WHERE A.COM_ID = '".$COM_ID."' ORDER BY A.COMDESC_ID ASC");
					while($r_sub = $db->db_fetch_array($q_sub)){
						$name = Showname($r_sub["PREFIX_ID"],$r_sub["PER_FIRSTNAME_TH"],$r_sub["PER_MIDNAME_TH"],$r_sub["PER_LASTNAME_TH"]);
						$arr_org2 = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG"," DELETE_FLAG='0' AND ORG_PARENT_ID = '".$r_sub['COMDESC_ORG_ID_1']."'","ORG_SEQ" );
						?>
						<tr>
							<td><?php echo $name;?></td>
							<td><input type='hidden' name='PER_ID[<?php echo $r_sub['PER_ID'];?>]' value='<?php echo $r_sub['PER_ID'];?>' />
							<div><strong><?php echo $arr_txt['pos_no']; ?> :</strong><?php echo $r_sub['POS_NO'];?></div>
							<div><strong>ตำแหน่ง :</strong><?php echo text($r_sub['LINE_NAME_TH']);?></div>
							<div><strong>ระดับ :</strong><?php echo text($r_sub['LEVEL_NAME_TH']);?></div>
							<div><strong>กลุ่มงาน :</strong><?php echo text($r_sub['ORG_NAME_3']);?></div>
							<div></div>
							<div><strong>สำนัก/กลุ่ม :</strong><?php echo text($r_sub['ORG_NAME_4']);?></div>
							<div><strong>อายุราชการ :</strong><?php if(trim($r_sub['COMDESC_CIVIL_YEAR'])!=""){ echo text($r_sub['COMDESC_CIVIL_YEAR'])." ปี ".text($r_sub['COMDESC_CIVIL_MONTH'])." เดือน"; }?></div>
							</td>
							<td><?php echo text($arr_retype2[$r_sub['RETYPE_ID']]);?></td>
							<td align="center"><?php echo conv_date($r_sub['COMDESC_EDATE_CIVIL'],'short');?>
							</td>
							<td align="center"><?php echo conv_date($r_sub['COMDESC_EDATE_PRESENT'],'short');?>
							</td>
							<td>
							<div><strong>กระทรวง :</strong></div>
							<div><?php echo text($arr_org1[$r_sub['COMDESC_ORG_ID_1']]);?></div>
							<div><strong>กรม/สำนักงาน :</strong></div>
							<div><?php echo text($arr_org2[$r_sub['COMDESC_ORG_ID_2']]);?></div>
							<div><strong>รายละเอียด :</strong></div>
							<div><?php echo $r_sub['COMDESC_NOTE'];?></div>
							</td>
						</tr>
						<?php
					}
				}
			
				?>
                </tbody>
           	</table>
        <?php 

		?>
        
      <br>
          <div class="col-xs-12 col-sm-12" align="center" style="margin:10px;">
        
            <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
           <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_out_gov_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>

      
      </form>
           </div>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</body>
</html>
<?php echo form_model('myModal','เลือกรายชื่อผู้เกษียณอายุราชการ','show_display','950','','1','เลือก'); ?>
<?php

?>