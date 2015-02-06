<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$S_YEAR_BDG = $_POST['S_YEAR_BDG'];
$S_ROUND = $_POST['S_ROUND'];
$ORG_ID_3 = $_POST['ORG_ID_3'];


//SELECT ORG
$query_org = $db->query("SELECT ORG_NAME_TH FROM SETUP_ORG WHERE ORG_ID = '".$ORG_ID_3."' ");
$rec_org = $db->db_fetch_array($query_org);

$filter = "";
if($s_name != ""){
	$filter .= " and (A.NAME like '%".ctext($s_name)."%') ";
}

if(!empty($S_POS_NO) && $S_POS_NO != 'undefined'){
	$filter .= " AND A.POS_NO = ".trim($S_POS_NO);
}
if(!empty($S_TYPE_ID) && $S_TYPE_ID != 'undefined'){
	$filter .= " AND  A.TYPE_ID = ".$S_TYPE_ID;
}

if(!empty($S_LEVEL_ID) && $S_LEVEL_ID != 'undefined'){
	$filter .= " AND A.LEVEL_ID = ".$S_LEVEL_ID;
}
if(!empty($S_LINE_ID) && $S_LINE_ID != 'undefined'){
	$filter .= " AND A.LINE_ID = ".$S_LINE_ID;
}
if(!empty($S_LG_ID) && $S_LG_ID != 'undefined'){
	$filter .= " AND A.LG_ID = ".$S_LG_ID;
}



$field="A.SAL_UP_ID, B.PER_IDCARD, A.POS_NO, A.NAME,
         C.LINE_NAME_TH, D.LEVEL_NAME_TH,  A.SALARY_NOW ";
$table="SAL_UP_SALARY A
		  JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID
		  LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID
		  LEFT JOIN SETUP_POS_LEVEL D ON A.LEVEL_ID = D.LEVEL_ID ";
		 
		   
$pk_id="A.SAL_UP_ID";
$wh=" A.POSTYPE_ID = 5 AND A.YEAR_BDG = '".$S_YEAR_BDG."' AND A.ROUND = '".$S_ROUND."' AND A.ORG_ID_3 = '".$ORG_ID_3."' {$filter} ";
$groupby = "  "; 
$orderby="order by B.POS_NO ASC ";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh.$groupby." ".$orderby.") ".$groupby.$orderby;

$sql = "select top $page_size ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh." {$filter}".$groupby));

$query_all = $db->query("SELECT COUNT(PER_ID) AS COUNT_PER FROM SAL_UP_SALARY WHERE  POSTYPE_ID = 5 AND CONFIRM_TYPE >= 2 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' ");
$rec_all = $db->db_fetch_array($query_all);
$num_all = (int)$rec_all['COUNT_PER'];

$arr_line_group = GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$S_TYPE_ID."' ", "LG_NAME_TH");
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND (a.ORG_PARENT_ID='15' or a.ORG_ID = 15) ", "ORG_SEQ");
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
<script src="js/setup_per_group_emp_gov_form.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="#" onClick=" $('#page').val(1); $('#frm-search').attr('action','setup_per_group_emp_gov_disp.php').submit(); ">ลูกจ้างประจำ->จัดกลุ่มสำหรับการเลื่อนค่าตอบแทน</a></li>
            <li class="active">จัดกลุ่ม</li>
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
            <input type="hidden" id="OGR_ID_3" name="ORG_ID_3" value="<?php echo $ORG_ID_3; ?>" >
            <input type="hidden" id="S_YEAR_BDG" name="S_YEAR_BDG" value="<?php echo $S_YEAR_BDG; ?>" >
			<input type="hidden" id="S_ROUND" name="S_ROUND" value="<?php echo $S_ROUND; ?>" >
            <input type="hidden" id="SAL_UP_ID" name="SAL_UP_ID"  >
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3"> <?php echo $S_YEAR_BDG; ?> </div>
				<div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2">รอบ :  <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3"><?php echo $arr_emp_gov_round[$S_ROUND]; ?></div>
			</div>
            <div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สังกัด (ปฏิบัติ) : </div>
				<div class="col-xs-12 col-md-3"><?php echo text($rec_org['ORG_NAME_TH']); ?></div>
            </div>
           <div class="row">
             <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">เลขที่ตำแหน่ง :</div>
             <div class="col-xs-12 col-sm-4 col-md-2"><input type="text" name="S_POS_NO" id="S_POS_NO" value="<?php echo $S_POS_NO;?>" class="form-control number"></div>
             <div class="col-xs-12 col-md-3"></div>
             <div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อ-สกุล :</div>
             <div class="col-xs-12 col-sm-2">
                 <input type="text" id="s_name" name="s_name" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name; ?>">
              </div>
            </div>
            	<div class="row">
					
						<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">กลุ่มงาน :</div>
						<div class="col-xs-12 col-sm-2">
							<select id="S_TYPE_ID" name="S_TYPE_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" onChange="get_level(this); get_line_group(this);">
								<option value=""></option>
								<?php
								$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '5' AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ ASC";
								$query_type_name = $db->query($sql_type_name);
								$select_type[$S_TYPE_ID] = "Selected='Selected'";
								while($type = $db->db_fetch_array($query_type_name)){
									echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
								}
								?>
							</select>
						</div>
                       <div class="col-xs-12 col-md-3"></div>
					   <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">ระดับ :</div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                          <select id="S_LEVEL_ID" name="S_LEVEL_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" >
                              <option value=""></option>
                              <?php
                             
							  $cond_level =  " and TYPE_ID = '".$S_TYPE_ID."'";
                              $sql_level_name = "Select LEVEL_ID , LEVEL_NAME_TH  From SETUP_POS_LEVEL WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '5' AND DELETE_FLAG = '0'".$cond_level." ORDER BY LEVEL_SEQ ASC";
                              $select_level[$S_LEVEL_ID] = "Selected='Selected'";
                              $query_level_name = $db->query($sql_level_name);
                                  while($level = $db->db_fetch_array($query_level_name)){
                                      echo '<option value="'.$level['LEVEL_ID'].'" '.$select_level[$level['LEVEL_ID']].'>'.text($level['LEVEL_NAME_TH']).'</option>';
                                  }
                              ?>
                          </select>
                      </div>
						
                </div>
			    <div class="row">
                     <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สายงาน :</div>
                      <div class="col-xs-12 col-md-2" >
                          <?php echo GetHtmlSelect('S_LG_ID', 'S_LG_ID',$arr_line_group , 'สายงาน' ,$S_LG_ID ,'onChange="get_line(this);"', '1', '', ''); ?>	
                      </div>
                      <div class="col-xs-12 col-md-3"></div>	
                      <div class="col-xs-12 col-sm-2 col-md-2" style="white-space:nowrap;">ตำแหน่งในสายงาน :</div>
                      <div class="col-xs-12 col-sm-4 col-md-2">                                        
                          <select id="S_LINE_ID" name="S_LINE_ID" class="selectbox form-control" placeholder="-ทั้งหมด-" >
                              <option value=""></option>
                              <?php
                              $sql_line_name="SELECT LINE_ID , LINE_NAME_TH FROM SETUP_POS_LINE WHERE DELETE_FLAG='0' AND POSTYPE_ID = '5' AND LG_ID = '".$S_LG_ID."' ORDER BY LINE_NAME_TH ASC";
                              $select_line[$S_LINE_ID] = "Selected='Selected'";
                              $query_line_name = $db->query($sql_line_name);
                              while($line = $db->db_fetch_array($query_line_name)){
                                  echo '<option value="'.$line['LINE_ID'].'" '.$select_line[$line['LINE_ID']].'>'.text($line['LINE_NAME_TH']).'</option>';
                              }
                              ?>
                          </select>
                      </div>
                </div> 
			   
            <div class="row" style="text-align:center">
            	<button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
            </div>
            <div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                            <th width="4%"><div align="center"><strong>ลำดับ</strong></div></th>
                          	<th width="12%"><div align="center"><strong><?php echo $arr_txt['idcard']; ?></strong></div></th>
                            <th width="8%"><div align="center"><strong>เลขที่ตำแหน่ง</strong></div></th>
                            <th width="15%"><div align="center"><strong>ชื่อ - สกุล</strong></div></th>
                            <th width="13%"><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                            <th width="8%"><div align="center"><strong>ระดับ</strong></div></th>
                            <th width="10%"><div align="center"><strong>ค่าตอบแทน</strong></div></th>
                            <?php if($num_all == 0){ ?>
                          	<th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					
					$i = 1;
					if($nums > 0){
					while($rec = $db->db_fetch_array($query)){
						$PER_NAME = text(htmlspecialchars_decode($rec['NAME']));
						$group = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"Transfer('".$rec["SAL_UP_ID"]."');\">".$img_transfer." ย้ายกลุ่ม</a>&nbsp;&nbsp;";
						$del = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"delData('".$rec["SAL_UP_ID"]."');\">".$img_del." ลบ</a>";
						
						?>
                        <tr>
                            <td align="center"><?php echo $i+$goto; ?>.</td>
                            <td align="center"><?php echo get_idCard($rec['PER_IDCARD']);?></td>
                            <td align="center"><?php echo $rec['POS_NO'];?></td>
                            <td align="left"><?php echo $PER_NAME;?></td>
                            <td align="left"><?php echo text($rec['LINE_NAME_TH']);?></td>
                            <td align="center"><?php echo text($rec['LEVEL_NAME_TH']);?></td>
                            <td align="right"><?php echo number_format($rec['SALARY_NOW'],2);?></td>
                            <?php if($num_all == 0){ ?>
                            <td align="center"><?php echo $group.$del;?>&nbsp;</td>
                            <?php } ?>
                        </tr>
                        <?php
						$i++;
					}
					}else{
						echo "<tr><td align=\"center\" colspan=\"9\">ไม่พบข้อมูล</td></tr>";
					}
                    ?>
                 	</tbody>
                </table>
			</div>
			<div class="row"><?php echo ($nums > 0) ? endPaging("frm-search",$total_record):""; ?></div>
        
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
        <h4 class="modal-title" id="myModalLabel">ย้ายกลุ่ม</h4>
      </div>
      <div class="modal-body">
      <div class="row">
           <div class="col-xs-12 col-md-3" >ย้ายไปกลุ่ม :</div>
           <div class="col-xs-12 col-md-9" >
      			<?php echo GetHtmlSelect('T_ORG_ID_3','T_ORG_ID_3',$arr_org3,'สำนัก/กอง','','','','1',400);?>
          </div>
      </div> 
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
		<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="proc" name="proc" value="">
       <input type="hidden" name="T_SAL_UP_ID" id="T_SAL_UP_ID" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick ="AddTransfer();">ย้ายกลุ่ม</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
 </div>
  </form>
 <!-- Modal --> 