<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$SAL_COM_ID=$_POST['SAL_COM_ID'];
$MOVEMENT_ID = $_POST['MOVEMENT_ID'];
$YEAR_BDG = $_POST['YEAR_BDG'];
$ROUND = $_POST['ROUND'];


$proc = ($proc == '' ) ? "add" : $proc;
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";


if($proc == 'edit'){
	$sql_edit =  " SELECT CT_ID, MOVEMENT_ID, SAL_COM_ID,YEAR_BDG ,ROUND,COM_NO,COM_DATE,COM_TITLE,COM_SDATE,CREATE_BY,UPDATE_BY,CREATE_DATE,UPDATE_DATE,POSTYPE_ID FROM SAL_COMMAND WHERE  SAL_COM_ID ='".$SAL_COM_ID."' ";
	$query_edit = $db->query($sql_edit);
	$rec_edit = $db->db_fetch_array($query_edit);
	$YEAR_BDG = $rec_edit['YEAR_BDG'];
	$ROUND = $rec_edit['ROUND'];
	$COM_NO = text($rec_edit["COM_NO"]);
	$COM_DATE = conv_date($rec_edit["COM_DATE"]);
	$COM_TITLE = text($rec_edit["COM_TITLE"]);
	$COM_SDATE = conv_date($rec_edit["COM_SDATE"]);
	
	$query_sal_all = $db->query("SELECT COUNT(SAL_UP_ID) AS NUM_SAL FROM SAL_UP_SALARY WHERE  SAL_COM_TEMP = '".$SAL_COM_ID."' ");
	$rec_all = $db->db_fetch_array($query_sal_all);
	$num_all = $rec_all['NUM_SAL'];
	
	$query_com = $db->query("SELECT COUNT(SAL_COM_ID) AS NUM_COM FROM SAL_COMMAND WHERE  SAL_COM_ID = '".$SAL_COM_ID."' AND CONFIRM_TYPE = 2 ");
	$rec_com = $db->db_fetch_array($query_com);
	(int)$num_com = $rec_com['NUM_COM'];
	
}

 $sql = "SELECT B.PER_IDCARD,B.PREFIX_ID,B.PER_ID,B.PER_FIRSTNAME_TH,B.PER_MIDNAME_TH, B.PER_LASTNAME_TH ,B.POS_NO,
			A.SAL_COMPENSATION_4, A.SALARY_NEW, A.SALARY_NOW, A.SAL_UP_ID,	TYPE_NAME_TH,LEVEL_NAME_TH,LINE_NAME_TH, F.ORG_NAME_TH AS ORG_NAME_3 
			
			FROM SAL_UP_SALARY A 
			INNER JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID 
			LEFT  JOIN SETUP_POS_TYPE C ON A.TYPE_ID = C.TYPE_ID
			LEFT  JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
			LEFT  JOIN SETUP_POS_LEVEL E ON A.LEVEL_ID = E.LEVEL_ID
			LEFT  JOIN SETUP_ORG F ON A.ORG_ID_3 = F.ORG_ID
			WHERE SAL_UP_TYPE = 1 AND CONFIRM_TYPE = 3 AND A.YEAR_BDG = '".$YEAR_BDG."' AND ROUND = '".$ROUND."' AND A.POSTYPE_ID = 3 AND A.SALARY_NEW < 12285   ";
$query = $db->query($sql);
$nums = $db->db_num_rows($query);

$arr_command_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", " LT_ID = 8 AND ACTIVE_STATUS = 1 ", "CT_NAME_TH");
$arr_movement = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", " ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND POSTYPE_ID = '3' AND MOVEMENT_ID = 23 ", "MOVEMENT_NAME_TH");
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/command_temp_salary_emp_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="command_temp_salary_emp_disp.php?<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li class="active"><?php echo $txt;?></li>
        </ol>
    </div>
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
		<form id="frm-input" method="post" action="process/command_temp_salary_emp_process.php">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="SAL_COM_ID" name="SAL_COM_ID" value="<?php echo $SAL_COM_ID; ?>">
        <input type="hidden" id="YEAR_BDG" name="YEAR_BDG" value="<?php echo $YEAR_BDG; ?>">
        <input type="hidden" id="ROUND" name="ROUND" value="<?php echo $ROUND; ?>">
        <div class="row formSep">
        	<div class="col-xs-12 col-md-2"  style="white-space:nowrap;">ปีงบประมาณ :</div>
            <div class="col-xs-12 col-sm-3"><?php echo $YEAR_BDG; ?></div>
            <div class="col-xs-12 col-md-2 col-md-offset-1" style="white-space:nowrap;">รอบ :</div>
            <div class="col-xs-12 col-sm-3"><?php echo $ROUND; ?></div>
        </div>
         <div class="row formSep">
         	<div class="col-xs-12 col-md-2" style="white-space:nowrap">ประเภทคำสั่ง :&nbsp;<span style="color:red">*</span></div>
            <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect('CT_ID','CT_ID',$arr_command_type,'ประเภทคำสั่ง',$rec_edit['CT_ID'],'','','1','','1');?></div> 
            <div class="col-xs-12 col-md-1"></div> 
            <div class="col-xs-12 col-md-2">ประเภทความเคลื่อนไหว : </div>
            <div class="col-xs-12 col-md-3">
			  <?php echo text($arr_movement['23']); ?>
              <input type="hidden" id="MOVEMENT_ID" name="MOVEMENT_ID" value="23">
            </div> 
        </div>
		<div class="row formSep">
			<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เลขที่คำสั่ง :<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2">
            <input type="text" id="COM_NO" name="COM_NO" maxlength="100" class="form-control" placeholder="เลขที่คำสั่ง" value="<?php echo $COM_NO; ?>">
            </div>
            <div class="col-xs-12 col-sm-1"></div>            
			<div class="col-xs-12 col-sm-2 col-md-offset-1" style="white-space:nowrap;">ลงวันที่ : <span style="color:red;">*</span></div>
            <div class="col-xs-8 col-md-2">
               <div class="input-group">
                  <input type="text" class="form-control col-md-13" name="COM_DATE" id="COM_DATE" value="<?php echo $COM_DATE; ?>" placeholder="DD/MM/YYYY">
                  <span class="input-group-addon datepicker" for="COM_DATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
              </div>
            </div>
		</div>
        <div class="row formSep">
			<div class="col-xs-12 col-md-2 " style="white-space:nowrap">เรื่อง :<span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-8">
           		 <input type="text" id="COM_TITLE" name="COM_TITLE" maxlength="100" class="form-control" placeholder="เรื่อง" value="<?php echo $COM_TITLE; ?>">
            </div> 
        </div>
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2 " style="white-space:nowrap;">วันที่มีผล : <span style="color:red;">*</span></div>
            <div class="col-xs-8 col-md-2">
              <div class="input-group">
                  <input type="text" class="form-control col-md-13" name="COM_SDATE" id="COM_SDATE" value="<?php echo $COM_SDATE;?>" placeholder="DD/MM/YYYY">
                  <span class="input-group-addon datepicker" for="COM_SDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span>
              </div>
            </div>
        </div>
            <br>
				 <div class="table-responsive">
                      <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                        <thead>
                            <tr class="bgHead">
                               	<th width="5%"><div align="center"><strong><input name="chkAll" id="chkAll" type="checkbox" onClick="checkbox_all()" ></strong></div></th>
                          		<th width="20%"><div align="center"><strong>ชื่อ - สกุล</strong></div></th>
                          		<th width="35%"><div align="center"><strong>ตำแหน่ง</strong></div></th>                                
                                <th width="10%"><div align="center"><strong>ค่าตอบแทนเดิม</strong></div></th> 
                                <th width="10%"><div align="center"><strong>เงินเพิ่มชั่วคราว</strong></div></th>  
                            </tr>
                         <?php
						 if($nums > 0){
							$i = 1;
					
							while($rec = $db->db_fetch_array($query)){
								$PER_NAME = "";
								$SEL = '';
								$SAL_COMPENSATION_4 = '';
								$name = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
								$PER_IDCARD = get_idCard($rec['PER_IDCARD']);
								$PER_NAME .= "<strong>".$arr_txt['idcard']." : </strong>".$PER_IDCARD."<br>";	
								$PER_NAME .= $name;					
								$POS_DETAIL  = "<strong>เลขที่ตำแหน่ง : </strong>".text($rec['POS_NO']);
								$POS_DETAIL .= "<br><strong>ประเภทพนักงานราชการ : </strong>".text($rec['TYPE_NAME_TH']);
								$POS_DETAIL .= "<br><strong>ประเภทกลุ่มงาน : </strong>".text($rec['LEVEL_NAME_TH']);
								$POS_DETAIL .= "<br><strong>ตำแหน่ง : </strong>".text($rec['LINE_NAME_TH']);
								$POS_DETAIL .= "<br><strong>สำนัก : </strong>".text($rec['ORG_NAME_3']);
								if($proc == 'edit'){
									$query_sal_com = $db->query("SELECT SAL_UP_ID, SAL_COMPENSATION_4 FROM SAL_UP_SALARY WHERE SAL_UP_ID = '".$rec['SAL_UP_ID']."' AND SAL_COM_TEMP = '".$SAL_COM_ID."' ");
									$num_sal = $db->db_num_rows($query_sal_com);
									$rec_sal = $db->db_fetch_array($query_sal_com);
									if($num_sal > 0){
										$SEL = "checked";
										$SAL_COMPENSATION_4 = $rec_sal['SAL_COMPENSATION_4']; 
									}else{
										$SEL = "";
									}
								}
								?>
								<tr bgcolor="#FFFFFF" >
								<td align="center">
                                 <input name="SAL_UP_ID[<?php echo $rec['SAL_UP_ID']; ?>]" id="SAL_UP_ID_<?php echo $i;?>" <?php echo $SEL; ?>   type="checkbox" value="<?php echo $rec['SAL_UP_ID']; ?>">
                                </td>
                               <td align="left"><?php echo $PER_NAME; ?></td>
                               <td align="left"><?php echo $POS_DETAIL; ?></td>
                               <td align="right"><?php echo number_format($rec['SALARY_NOW'],2);?></td>
                               <td align="center">
                               	<input type="text" id="SAL_COMPENSATION_4" name="SAL_COMPENSATION_4[<?php echo $rec['SAL_UP_ID']; ?>]" class="form-control" placeholder="เงินเพิ่มชั่วคราว" value="<?php echo number_format($SAL_COMPENSATION_4,2); ?>"  onblur="NumberFormat(this,2);" style="text-align:right;" >
                               </td>
                                    
								</tr>
								<?php
								$i++;
							}
						}else{
							echo "<tr id=\"row_0\"><td align=\"center\" colspan=\"6\" bgcolor=\"FFFFFF\">ไม่พบข้อมูล</td></tr>";
						}
						?>
                 		</tbody>
                    </table>
                </div>
            <div class="row">
			<div class="col-xs-12 col-md-12" align="center">
            <?php if($num_com == 0){ ?>
			  <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
              <?php if($num_all > 0){ ?>
                <button type="button" class="btn btn-primary" onClick="ConfirmCom();">อนุมัติออกคำสั่งเลื่อนเงินเดือน</button>
                <?php } ?>
           <?php } ?>
              <button type="button" class="btn btn-default" onClick="$('#frm-input').attr('action','command_temp_salary_emp_disp.php').submit();">ยกเลิก</button>
			</div>
        </div>
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
