<?php
$path = "../../";
include($path . "include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$LINE_ID = $_POST['LINE_ID'];
$TYPE_ID_EDU = $_POST['TYPE_ID'];
$txt = ($proc == "add") ? "เพิ่มข้อมูล" : "แก้ไขข้อมูล";

$sql = " SELECT  LINE_ID,POSTYPE_ID,TYPE_ID,LEVEL_ID,LINE_CODE,LINE_NAME_TH,LINE_NAME_EN,LINE_SHORTNAME_TH,LINE_SHORTNAME_EN,ACTIVE_STATUS 
FROM SETUP_POS_LINE WHERE LINE_ID ='" . $LINE_ID . "' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$LINE_ID = text($rec["LINE_ID"]);
$LEVEL_ID = text($rec["LEVEL_ID"]);
$POSTYPE_ID = text($rec["POSTYPE_ID"]);
$TYPE_ID = text($rec["TYPE_ID"]);
$LINE_CODE = text($rec["LINE_CODE"]);
$LINE_NAME_TH = text($rec["LINE_NAME_TH"]);
$LINE_NAME_EN = text($rec["LINE_NAME_EN"]);
$LINE_SHORTNAME_TH = text($rec["LINE_SHORTNAME_TH"]);
$LINE_SHORTNAME_EN = text($rec["LINE_SHORTNAME_EN"]);

$SQL_POS_TYPE ="SELECT TYPE_ID,TYPE_NAME_TH FROM SETUP_POS_TYPE WHERE ACTIVE_STATUS='1' and POSTYPE_ID = '1' AND DELETE_FLAG = '0' ORDER BY TYPE_SEQ ASC ";
$query_POS_TYPE = $db->query($SQL_POS_TYPE);
$SQL_LINE_GROUP ="SELECT LG_ID, LG_NAME_TH FROM SETUP_POS_LINE_GROUP WHERE ACTIVE_STATUS='1' and POSTYPE_ID = '1' AND DELETE_FLAG = '0' AND TYPE_ID = '".$TYPE_ID."' ORDER BY LG_NAME_TH ASC ";
$query_line_group = $db->query($SQL_LINE_GROUP);


if($TYPE_ID_EDU ==1){
	$type_id .= " AND EL_ID IN  (4,5,6)";	
}
if($TYPE_ID_EDU==2){
	$type_id .= " AND EL_ID IN (7,8,9)";
}	

$arr_el = GetSqlSelectArray("EL_ID", "EL_NAME_TH", "SETUP_EDU_LEVEL" , "ACTIVE_STATUS='1' and DELETE_FLAG='0' $type_id ", "EL_SEQ");
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
    <script src="js/pos_edu_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
    <div class="container-full">
        <div><?php include($path . "include/header.php"); ?></div>
        <div><?php include($path . "include/menu.php"); ?></div>
        <div class="col-xs-12 col-sm-12">
            <ol class="breadcrumb">
                <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
                <li><a href="pos_line_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>"><?php echo Showmenu($menu_sub_id); ?></a></li>
                <li class="active"><?php echo $txt; ?></li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-12" id="content">
            <div class="groupdata" >
                <form id="frm-input" method="post" action="process/pos_edu_process.php">
                    <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
                    <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
                    <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                    <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
                    <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                    <input type="hidden" id="LINE_ID" name="LINE_ID" value="<?php echo $LINE_ID; ?>">
                    <input type="hidden" id="TYPE_ID" name="TYPE_ID" value="<?php echo $TYPE_ID_EDU; ?>">
                    <input name="flagDup1" type="hidden" id="flagDup1">
                    <input name="flagDup2" type="hidden" id="flagDup2">
                    <input name="flagDup3" type="hidden" id="flagDup3">
                    <input name="flagDup4" type="hidden" id="flagDup4">
                    
                    
                <div class="row">
               	<div class="table-responsive">
                 <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data_3">
                <!--  <table  class="table table-bordered table-striped table-hover table-condensed" id="tb_data_3">-->
                    <thead>
                      <tr class="bgHead">
                        <th width="7%"  style="vertical-align:top; text-align:center"><strong>ลำดับ</strong></th>
                        <th width="40%"  style="vertical-align:top; text-align:center"><strong>ระดับการศึกษา</strong></th>
                        <th width="30%"  style="vertical-align:top; text-align:center"><strong>วุฒิการศึกษา</strong> </th>
                        <th width="7%"  style="vertical-align:top; text-align:center"><strong>ลบ</strong></th>
                      </tr>
                     </thead>
                     <tbody>
                     <?php
					 $sql_edu = "SELECT * FROM SETUP_POS_LINE_DEGREE WHERE LINE_ID = '".$LINE_ID."' AND  ACTIVE_STATUS = 1";
					 $query_edu = $db->query($sql_edu);
					 $i=1;
					 while($rec_edu=$db->db_fetch_array($query_edu)){
					$arr_ed = GetSqlSelectArray("ED_ID", "ED_NAME_TH", "SETUP_EDU_DEGREE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND EL_ID = '".$rec_edu['EL_ID']."' ", "ED_NAME_TH");
					 ?>
                   
                    <tr >
                     	
                        <td align="center" >
							<?php echo $i;?> 
                            <input type="hidden" name='KEY[]' id='KEY_<?php echo $i;?>' value='<?php echo $i;?>' >
                          
                        </td>
                        <td style='text-align:left' >
                        <div id = 'EL_X_<?php echo $i; ?>' >
                            
                                <?php echo GetHtmlSelect('EL_ID_'.$i,'EL_ID[]',$arr_el,'ระดับการศึกษาแรกบรรจุ',$rec_edu['EL_ID'],'onchange="getED(this.value,'.$i.');"','chosen','1','400'); ?>
                            
                        </div>
                        </td>
                    	<td align="left" >
                        <div id = "ED_Y_<?php echo $i; ?>"  >
                            
							    <?php echo GetHtmlSelect('ED_ID_'.$i,'ED_ID[]',$arr_ed,'วุฒิการศึกษา',$rec_edu['ED_ID'],'','','1','400');?>
                           
                        </div>
                        </td>
                        <td align="center" ><a  class="btn btn-default btn-xs" data-backdrop="static" href="#" onClick="remove_id(this);" ><?php echo $img_del;?> ลบ</a></td>
                   	</tr>
                      <?php 
					  $i++;
					 }
					  ?>
                     </tbody>
                   </table>
                   <input type="hidden" name="count_3" id="count_3" value="<?php echo $i; ?>" >
                   <div id="add_order">
                     <div align="right" style="margin-bottom:10px;"><a href="javascript:void(0);" onClick="add_row(3);"><img src="<?php echo $path; ?>images/ico078.gif" border="0">เพิ่มรายการใหม่</a></div>
                </div>
                 </div>
               </div>
                    
                    <div class="formlast">
                        <div class="col-xs-12 col-sm-12" align="center">
                            <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
                            <button type="button" class="btn btn-default" onClick="self.location.href = 'pos_line_disp.php?<?php echo url2code("menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id); ?>';">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  
    <div style="text-align:center; bottom:0px;">
        <?php include($path . "include/footer.php"); ?>
    </div>
</body>
