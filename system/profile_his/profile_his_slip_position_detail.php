<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 6;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
$paramlink = url2code($link2);
$POSCOM_ID = $_POST['POSCOM_ID'];

$field = "POSCOM_ID, POSCOM_NO, POSCOM_DATE, POSCOM_TITLE, TYPE_NAME_TH, POSCOM_SDATE,CT_ID,MOVEMENT_ID,POSCOM_LAST_TYPE_ID";
$table = "POSITION_COMMAND 
JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = POSITION_COMMAND.POSCOM_LAST_TYPE_ID";
$pk_id = "POSCOM_ID";
$wh = "POSCOM_ID = '".$POSCOM_ID."'";
$orderby = "order by POSCOM_ID ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh));
$rec = $db->db_fetch_array($query);

$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", " CT_TYPE = '1' ", "CT_NAME_TH");
$arr_movement = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", " ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND POSTYPE_ID = '1'", "MOVEMENT_NAME_TH");
$arr_type = GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "POSTYPE_ID = '1' AND ACTIVE_STATUS = '1' and DELETE_FLAG = '0' AND TYPE_ID IN (1,2)", "TYPE_NAME_TH");
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
<script src="js/profile_his_slip_position_detail.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li><a href="profile_his_slip_position_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการเลื่อนตำแหน่ง)</a></li>
      <li class="active">รายละเอียด</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
  		<?php include("tab_transfer.php");?>
        <div class="grouptab">
		 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="frm-input">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="POSCOM_ID" name="POSCOM_ID" value="<?php echo $POSCOM_ID;?>">
		<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($arr_command_type[$rec['CT_ID']]);?></div> 
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2">ประเภทความเคลื่อนไหว :</div>
                    <div class="col-xs-12 col-md-4"><?php echo text($arr_movement[$rec['MOVEMENT_ID']]); ?></div>  
                </div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">เลขที่คำสั่ง :&nbsp;</div>
                    <div class="col-xs-12 col-md-3"><?php echo text($rec["POSCOM_NO"]);?></div> 
                    <div class="col-xs-12 col-md-1"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ลงวันที่ :&nbsp;</div>
                    <div class="col-xs-12 col-md-2">
                           <?php echo conv_date($rec['POSCOM_DATE'],'short');?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-1"></div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">เรื่อง :&nbsp;</div>
                  	<div class="col-xs-12 col-md-6"><?php echo text($rec["POSCOM_TITLE"]);?></div> 
                </div>                                
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่มีผล :&nbsp;</div> 
               	  	<div class="col-xs-12 col-md-2">
                            <?php echo conv_date($rec['POSCOM_SDATE'],'short');?>
                    </div> 
                    <div class="col-xs-12 col-md-2"></div>
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทตำแหน่ง :&nbsp;</div> 
                    <div class="col-xs-12 col-md-2"><?php echo text($arr_type[$rec['POSCOM_LAST_TYPE_ID']]); ?></div> 
                    <div class="col-xs-12 col-md-1"></div>
                </div>
                    <div class="row formSep">
                    <div class="col-xs-12 col-md-12" style="text-align:center">
                    <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                        <thead>
                            <tr class="bgHead">
                                <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                                <th width="16%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>   
                                <th width="16%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
                                <th width="14%"><div align="center"><strong>ตำแหน่งที่ขอเลื่อน</strong></div></th>
                                <th width="14%"><div align="center"><strong>ชื่อผลงาน/รายละเอียด</strong></div></th>
                                <th width="14%"><div align="center"><strong>หมายเหตุ</strong></div></th>
                            </tr>
                        </thead>
                        <tbody >
                        <?php
						if(!empty($POSCOM_ID)){
							$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " ACTIVE_STATUS = '1' and DELETE_FLAG = '0'", "ORG_SEQ");
							$q_edit = $db->query("SELECT POSMOVE_ID, C.PER_ID, PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, ORG_ID_3, ORG_ID_4,
												  E.TYPE_NAME_TH, D.TYPE_NAME_TH AS TYPE_NEW, G.LEVEL_NAME_TH, F.LEVEL_NAME_TH AS LEVEL_NEW, LINE_NAME_TH, MANAGE_NAME_TH,
												  POS_ID, POSMOVE_NEW_TYPE_ID, POSMOVE_NEW_LEVEL_ID, INNOVATION_NAME, INNOVATION_DESC, INNOVATION_FILE, ASSIGN_NOTE
												  FROM POSITION_MOVEUP A JOIN SETUP_POS_LEVEL B ON B.LEVEL_ID = A.POSMOVE_NEW_LEVEL_ID 
												  JOIN PER_PROFILE C ON C.PER_ID = A.POSMOVE_PER_ID
												  JOIN SETUP_POS_TYPE D ON D.TYPE_ID = A.POSMOVE_NEW_TYPE_ID
												  JOIN SETUP_POS_TYPE E ON E.TYPE_ID = A.POSMOVE_LAST_TYPE_ID
												  JOIN SETUP_POS_LEVEL F ON F.LEVEL_ID = A.POSMOVE_NEW_LEVEL_ID
												  JOIN SETUP_POS_LEVEL G ON G.LEVEL_ID = A.POSMOVE_LAST_LEVEL_ID
												  JOIN SETUP_POS_LINE H ON H.LINE_ID = C.LINE_ID
												  LEFT JOIN SETUP_POS_MANAGE I ON I.MANAGE_ID = C.MANAGE_ID
												  WHERE POSCOM_ID = '".$POSCOM_ID."'");
							$i = 0;
							while($r_edit = $db->db_fetch_array($q_edit)){
								$PER_NAME = Showname($r_edit["PREFIX_ID"],$r_edit["PER_FIRSTNAME_TH"],$r_edit["PER_MIDNAME_TH"],$r_edit["PER_LASTNAME_TH"]);
								
								$POS_DETAIL  = $arr_txt['pos_no'].' : '.$db->get_pos_no($r_edit['PER_ID']);
								$POS_DETAIL .= '<br>ตำแหน่งทางการบริหาร (ถ้ามี) : '.text($r_edit['MANAGE_NAME_TH']);
								$POS_DETAIL .= '<br>ประเภทตำแหน่ง : '.text($r_edit['TYPE_NAME_TH']);
								$POS_DETAIL .= '<br>ตำแหน่งในสายงาน : '.text($r_edit['LINE_NAME_TH']);
								$POS_DETAIL .= '<br>ระดับ : '.text($r_edit['LEVEL_NAME_TH']);
								$POS_DETAIL .= "<br>สำนัก/กลุ่ม : ".text($arr_org[$r_edit['ORG_ID_3']]);
								$POS_DETAIL .= "<br>กลุ่มงาน : ".text($arr_org[$r_edit['ORG_ID_4']]);
								
								$INNOVATION_NAME = (trim($r_edit['INNOVATION_NAME']) != '') ? 'ชื่อผลงาน : '.text($r_edit['INNOVATION_NAME']) : "-";
								$INNOVATION_DESC = (trim($r_edit['INNOVATION_DESC']) != '') ? '<br>รายละเอียด : '.text($r_edit['INNOVATION_DESC']) : "-";
								$download = (trim($r_edit['INNOVATION_FILE']) != '') ? "<br><a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"".$path."fileupload/file_placement/".trim($r_edit['INNOVATION_FILE'])."\"><span class=\"glyphicon glyphicon-download\"></span> Download File</a> " : "";
								?>
								
								<tr id="row_<?php echo $i;?>">
									<td align="center"><input type="hidden" id="ARR_POSMOVE_ID_<?php echo $i;?>" name="ARR_POSMOVE_ID[<?php echo $i;?>]" value="<?php echo $r_edit['POSMOVE_ID'];?>" ><?php echo ($i+1);?>.</td>
									<td align="left"><?php echo $PER_NAME;?></td>
                                    <td align="left"><?php echo $POS_DETAIL;?></td>
									<td align="left">ประเภทตำแหน่ง : <br><?php echo text($r_edit['TYPE_NEW']);?><br><br>ระดับตำแหน่ง : <br><?php echo text($r_edit['LEVEL_NEW']);?></td>
									<td align="left"><?php echo $INNOVATION_NAME.$INNOVATION_DESC.$download;?></td>
									<td align="left"><?php echo text($r_edit['ASSIGN_NOTE']);?>&nbsp;</td>
									
								</tr>
								<?php
								$i++;
							}
						}
						?>
                        <input type="hidden" id="COUNT_ROW" name="COUNT_ROW" value="<?php echo $i;?>" >
                      </tbody>
                    </table>
                    </div> 
                </div>
        		<div class="formlast">
                    <div class="col-xs-12 col-sm-12" align="center">
                        <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
                        <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_slip_position_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PER_ID=".$PER_ID);?>';">ยกเลิก</button>
                    </div>
                </div>
      		</form>
        </div>
    </div>
    <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>