<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$LINE_ID = $_POST['LINE_ID'];
$LEVEL_ID = $_POST['LEVEL_ID'];

$sql = "SELECT * 
          FROM SETUP_POS_STEP_EMP_GOV_SALARY
		  WHERE LEVEL_ID = '".$LEVEL_ID."' AND LINE_ID = '".$LINE_ID."'
		  ORDER BY CASE WHEN  STEP_SEQ > 0 THEN  STEP_SEQ ELSE SAL_MONTH END ASC  ";
$query = $db->query($sql);

// กลุ่มงาน
$sql_line = "SELECT A.LINE_ID, C.TYPE_ID, A.LG_ID,  A.LINE_NAME_TH, B.TYPE_NAME_TH, C.LG_NAME_TH 
               FROM SETUP_POS_LINE A 
			   LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
			   LEFT JOIN SETUP_POS_LINE_GROUP C ON A.LG_ID = C.LG_ID
			   WHERE A.LINE_ID = '".$LINE_ID."' ";
$query_line = $db->query($sql_line);
$rec_line = $db->db_fetch_array($query_line);
$TYPE_ID = $rec_line['TYPE_ID'];
$LG_ID = $rec_line['LG_ID'];

$arr_level =GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = 5 AND TYPE_ID = '".$TYPE_ID."' ","LEVEL_SEQ");
$arr_group = array(1 => 1, 2 => 2, 3 => 3, 4 => 4);
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
<script src="js/setup_emp_gov_step_salary_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="pos_line_setup_disp.php?<?php echo $paramlink; ?>"><?php echo Showmenu($menu_sub_id);?></a></li>
            <li class="active">ขั้นค่าจ้าง</li>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-12" id="content">
		<div class="groupdata">
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
			<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
			<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
			<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
			<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
			<input type="hidden" id="TYPE_ID" name="TYPE_ID" value="<?php echo $TYPE_ID; ?>">
            <input type="hidden" id="LG_ID" name="LG_ID" value="<?php echo $LG_ID; ?>">
            <input type="hidden" id="LINE_ID" name="LINE_ID" value="<?php echo $LINE_ID; ?>" >
            
            <div class="row">
                <div class="col-xs-12 col-md-2">กลุ่มงาน : </div>
				<div class="col-xs-12 col-md-2">
               		<?php echo text($rec_line['TYPE_NAME_TH']); ?>
                </div>
                <div class="col-xs-12 col-md-2">สายงาน : </div>
				<div class="col-xs-12 col-md-2">
               		<?php echo text($rec_line['LG_NAME_TH']); ?>
                </div>
			</div>  
            <div class="row">
                <div class="col-xs-12 col-md-2">ตำแหน่งในสายงาน : </div>
				<div class="col-xs-12 col-md-2">
                	<?php echo text($rec_line['LINE_NAME_TH']); ?>
                </div>
			</div>                    
			<div class="row">
                <div class="col-xs-12 col-md-2">ระดับ :  <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-2">
                	<?php echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_level,'ระดับ',$LEVEL_ID,"onChange=\"$('#frm-search').submit();\" ",'','1',350);?>
                </div>
				<div class="col-xs-12 col-md-1"><button type="button"  class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
			</div>
            
            <div class="row">
            	<div class="col-xs-12 col-md-4">
                	<a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="Transfer();"><?php echo $img_save;?> นำเข้าขั้นค่าจ้าง</a>&nbsp;&nbsp;
                   <a class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="AddDefault();"><?php echo $img_save;?> ค่าเริ่มต้นลำดับการเลื่อน</a> 
                </div>
            </div>
            
			<div class="col-xs-12 col-sm-12">
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                          <th width="6%" rowspan="2"><div align="center"><strong>กลุ่ม</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ลำดับขั้น</strong></div></th>
                          <th width="6%" rowspan="2"><div align="center"><strong>ลำดับการเลื่อน</strong></div></th>
                          <th colspan="3"><div align="center"><strong>อัตราค่าจ้าง / ขั้นวิ่ง</strong></div></th>
                          <th>&nbsp;</th>
                        </tr>
                        <tr class="bgHead">
                            <th width="10%"><div align="center"><strong>รายเดือน</strong></div></th>                                                            
                          	<th width="10%"><div align="center"><strong>รายวัน</strong></div></th>
                          	<th width="10%"><div align="center"><strong>รายชั่วโมง</strong></div></th>
                            <th width="5%"><div align="center"><strong>ลบ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					
					while($rec = $db->db_fetch_array($query)){
						$i++;
						$id_tb = "A".$i;//id tr ตั้งขึ้นมาเอง
						?>
                        <tr id="<?php echo $id_tb;?>" >
                        	<td align="center"><input type="text" id="GROUP_ID_<?php echo $id_tb;?>" name="GROUP_ID[]" value="<?php echo number_format($rec['GROUP_ID']);?>" class="form-control number" maxlength="6" style="width:100px;text-align:center;" onBlur="NumberFormat(this)"></td>
                            <td align="center"><input type="text" id="STEP_NO_<?php echo $id_tb;?>" name="STEP_NO[]" value="<?php echo number_format($rec['STEP_NO'],1);?>" class="form-control" maxlength="6" style="width:100px;text-align:center;" onBlur="NumberFormat(this,1)"></td>
                            <td align="center"><input type="text" id="STEP_SEQ_<?php echo $id_tb;?>" name="STEP_SEQ[]" value="<?php echo number_format($rec['STEP_SEQ'],1);?>" class="form-control" maxlength="6" style="width:100px;text-align:center;" onBlur="NumberFormat(this,1)"></td>
                            <td align="center"><input type="text" id="SAL_MONTH_<?php echo $id_tb;?>" name="SAL_MONTH[]" value="<?php echo number_format($rec['SAL_MONTH'],2);?>" class="form-control" maxlength="6" style="width:120px;text-align:right;" onBlur="NumberFormat(this,2)"></td>
                            <td align="center"><input type="text" id="SAL_DAY_<?php echo $id_tb;?>" name="SAL_DAY[]" value="<?php echo number_format($rec['SAL_DAY'],2);?>" class="form-control" maxlength="6" style="width:120px;text-align:right;" onBlur="NumberFormat(this,2)"></td>
                            <td align="center"><input type="text" id="SAL_HOURS_<?php echo $id_tb;?>" name="SAL_HOURS[]" value="<?php echo number_format($rec['SAL_HOURS'],2);?>" class="form-control" maxlength="6" style="width:120px;text-align:right;" onBlur="NumberFormat(this,2)"></td>
                            <td align="center"><a class="btn btn-default btn-xs" data-backdrop="static" href="javascript:void(0);" onClick="remove_id('<?php echo $id_tb;?>');" ><?php echo $img_del;?> ลบ</a></td>
                        </tr>
                        <?php
                        }
                    ?>
                 	</tbody>
                </table>
                </div>
                 <div align="right"><a href="javascript:void(0);" onClick="add_row();"><img src="<?php echo $path; ?>images/ico078.gif" border="0">เพิ่มรายการใหม่</a></div>
                 <div class="row" style="color:#F00;">* กรมบัญชีกลาง กำหนดคุณสมบัติเฉพาะตำแหน่งและอัตราค่าจ้างขั้นต่ำ-ขั้นสูง ตาม กค 0428/2554 ลว 2 ก.ย. 53 </div>
                </div>
            
            <div class="formlast">
                <div class="col-xs-12 col-sm-12" align="center">
                    <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                    <button type="button" class="btn btn-default" onClick="self.location.href = 'pos_line_setup_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>';">ยกเลิก</button>
                </div>
            </div>
            <br>
          
		</form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
<!-- Modal -->
<form id="frm-transfer" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="modal fade" id="transfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">นำเข้าขั้นค่าจ้าง</h4>
      </div>
      <div class="modal-body">
      <div class="row">
           <div class="col-xs-12 col-md-3" >กลุ่ม : <span style="color:red;">*</span></div>
           <div class="col-xs-12 col-md-3" >
      			<?php echo GetHtmlSelect('T_GROUP_ID','T_GROUP_ID',$arr_group,'กลุ่ม','','','','1');?>
          </div>
      </div>
       <div class="row">
           <div class="col-xs-12 col-md-3" >เริ่มต้นขั้นที่ : <span style="color:red;">*</span></div>
           <div class="col-xs-12 col-md-3" >
      			<input type="text" id="S_STEP" name="S_STEP"  class="form-control" maxlength="6" style="width:100px;text-align:center;" onBlur="NumberFormat(this,1)" onKeyUp="chkFormatNam_id(this.value,this.id);" >
          </div>
      </div>
      <div class="row">
           <div class="col-xs-12 col-md-3" >ถึงขั้นที่ : <span style="color:red;">*</span></div>
           <div class="col-xs-12 col-md-3" >
      			<input type="text" id="E_STEP" name="E_STEP"  class="form-control" maxlength="6" style="width:100px;text-align:center;" onBlur="NumberFormat(this,1)" onKeyUp="chkFormatNam_id(this.value,this.id);">
          </div>
      </div>
       <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
	   <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
       <input type="hidden" id="proc" name="proc" value="">
       <input type="hidden" name="T_LINE_ID" id="T_LINE_ID" value="<?php echo $LINE_ID; ?>" >
       <input type="hidden" name="T_LEVEL_ID" id="T_LEVEL_ID"  >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick ="AddTransfer();">นำเข้าขั้นค่าจ้าง</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
 </div>
  </form>
 <!-- Modal --> 