<?php
session_start();
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
//$_POST
$S_ORG_ID_1 = trim($_POST['S_ORG_ID_1']);
$S_ORG_ID_2 = trim($_POST['S_ORG_ID_2']);

$filter_1 = "";
$filter_2 = "";

if($S_ORG_ID_1 != ''){
	$filter_1 = " AND ORG_ID = '".$S_ORG_ID_1."' ";
}
if($S_ORG_ID_1 != '' and $S_ORG_ID_2 != ''){
	$filter_2 = " AND ORG_ID = '".$S_ORG_ID_2."' ";
}

//org1
$arr_org1 =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_NAME_TH");
//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$S_ORG_ID_1."' ", "ORG_NAME_TH");


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
<script src="js/disp_gov_other.js?<?php echo rand(); ?>"></script>
<script>
</script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
    <div><?php include($path."include/menu.php"); ?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li class="active"><?php echo showMenu($menu_sub_id); ?></li>
        </ol>
    </div>
    
    <div class="col-xs-12 col-sm-12" id="content">
        <div class="groupdata" >
            <div class="clearfix"></div>
            <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                <input name="org_parent_id" type="hidden" id="org_parent_id1">
                <input name="org_id" type="hidden" id="org_id">
                <input name="org_id1" type="hidden" id="org_id1">
                <input name="seq" type="hidden" id="seq">
                 <div class="row">   
                   <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง :</div>
                   <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('S_ORG_ID_1','S_ORG_ID_1',$arr_org1,'ระดับกระทรวง',$S_ORG_ID_1,'onchange="getORG(this);"','','');?></div>
                   <div class="col-xs-12 col-md-2"></div>
                   <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม :</div>
                   <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('S_ORG_ID_2','S_ORG_ID_2',$arr_org2,'ระดับกรม',$S_ORG_ID_2,'','','');?></div> 
                </div>
                <div class="row" style="text-align:center;">
                	<button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
                </div>
                <div class="row">  
                 <div class="col-xs-12 col-sm-12">
                  <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addDataMis('13','ministry');"><?php echo $img_save;?> เพิ่มกระทรวง</a>
                 </div>
               </div>
             
                <div class="col-xs-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover collapsible">
                            <thead>
                                <tr class="bgHead">
                                    <th width="70%"><div align="center"><strong>ชื่อหน่วยงาน</strong></div></th>
                                    <th width="10%"><div align="center"><strong>สถานะการใช้งาน</strong></div></th>
                                    <th width="20%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                </tr>
                            </thead>
                            <?php
							if($S_ORG_ID_1 != '' or $S_ORG_ID_2 != '' ){
							  //กระทรวง
						       $sql_2 = "SELECT ORG_ID, ORG_NAME_TH, ACTIVE_STATUS FROM  SETUP_ORG WHERE DELETE_FLAG = 0 AND OL_ID = 2 ".$filter_1." ORDER BY ORG_NAME_TH ASC ";
							   $query_2 = $db->query($sql_2);
								while($rec_2 = $db->db_fetch_array($query_2)){	
									$delete = "";
								    $sql_sub= "SELECT COUNT(ORG_ID) AS NUM_ORG FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$rec_2['ORG_ID']."' AND DELETE_FLAG = '0'";
									$query_sub =  $db->query($sql_sub);
									$rec_sub = $db->db_fetch_array($query_sub);
									$num_2 = (int)$rec_sub['NUM_ORG'];
									if($num_2 == 0){
										$delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('" .$rec_2['ORG_ID']. "');\">".$img_del." ลบ</a> ";
									}
									$addSub = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addData('".$rec_2['ORG_ID']."', 6);\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่ม</a> ";
									$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_2['ORG_ID']."');\">".$img_edit." แก้ไข</a> ";
									$edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" .$rec_2['ORG_ID']. "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
									$status = ($rec_2['ACTIVE_STATUS']  == 1)? "ใช้งาน" : "ไม่ใช้งาน";
									$HTML .= "
                                    <tr id='".$rec_2['ORG_ID']."' class=''>
                                        <td bgcolor='#FFFFFF'><a href='javascript:void(0)' onClick=\"show('".$rec_2['ORG_ID']."',this);\"><img src='../../images/clse.gif'></a> <strong>".text($rec_2['ORG_NAME_TH'])."</strong></td>
                                        <td align='center' bgcolor='#FFFFFF' >".$status."</td>
                                        <td align='center' bgcolor='#FFFFFF' >".$addSub.$edit.$edit1.$delete."</td>
                                    </tr>";
                                   
									//กรม
									$sql_6 = "SELECT ORG_ID, ORG_PARENT_ID, ORG_NAME_TH, ACTIVE_STATUS FROM  SETUP_ORG WHERE DELETE_FLAG = 0 AND ORG_ID NOT IN(15)  AND ORG_PARENT_ID = '".$rec_2['ORG_ID']."' ".$filter_2." ORDER BY ORG_NAME_TH ASC";
									$query_6 = $db->query($sql_6);
									$delete = "";
									while($rec_6 = $db->db_fetch_array($query_6)){
										$delete = "";
										$sql_sub= "SELECT COUNT(ORG_ID) AS NUM_ORG FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$rec_6['ORG_ID']."' AND DELETE_FLAG = '0'";
										$query_sub =  $db->query($sql_sub);
										$rec_sub = $db->db_fetch_array($query_sub);
										$num_6 = (int)$rec_sub['NUM_ORG'];
										if($num_6 == 0){
											$delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('" .$rec_6['ORG_ID']. "');\">".$img_del." ลบ</a> ";
										}
										$addSub = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addData('".$rec_6['ORG_ID']."', 16);\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่ม</a> ";
										$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_6['ORG_ID']."');\">".$img_edit." แก้ไข</a> ";
										$edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" .$rec_6['ORG_ID']. "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
										$status = ($rec_6['ACTIVE_STATUS'] == 1) ? "ใช้งาน" : "ไม่ใช้งาน";
								      $HTML .= "
                                      <tr  id='".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."' class='' >
                                        <td bgcolor='#FFFFFF' style='font-weight:bold; padding-left:20px;'><a href='javascript:void(0)' onClick=\"show('".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."',this)\" ><img src='../../images/clse.gif'></a> ".text($rec_6['ORG_NAME_TH'])."</td>
                                        <td align='center' bgcolor='#FFFFFF' >".$status."</td>
                                        <td align='center' bgcolor='#FFFFFF' >".$addSub.$edit.$edit1.$delete."</td>
                                     </tr>";
                                 
								       //กอง / สำนัก
								    	$sql_16 =  "SELECT ORG_ID, ORG_PARENT_ID, ORG_NAME_TH, ACTIVE_STATUS FROM  SETUP_ORG WHERE DELETE_FLAG = 0 AND ORG_PARENT_ID = '".$rec_6['ORG_ID']."' ORDER BY ORG_NAME_TH ASC";
										$query_16 =  $db->query($sql_16);
										while($rec_16 = $db->db_fetch_array($query_16)){
											$delete = "";
											$sql_sub= "SELECT COUNT(ORG_ID) AS NUM_ORG FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$rec_16['ORG_ID']."' AND DELETE_FLAG = '0'";
											$query_sub =  $db->query($sql_sub);
											$rec_sub = $db->db_fetch_array($query_sub);
											$num_16 = (int)$rec_sub['NUM_ORG'];
											if($num_16 == 0){
												$delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('".$rec_16['ORG_ID']. "');\">".$img_del." ลบ</a> ";
											}
											$addSub = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addData('".$rec_16['ORG_ID']."',17);\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่ม</a> ";
											$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_16['ORG_ID']."');\">".$img_edit." แก้ไข</a> ";
											$edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" .$rec_16['ORG_ID']. "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
											$status = ($rec_16['ACTIVE_STATUS'] == 1) ? "ใช้งาน" : "ไม่ใช้งาน";
								         $HTML .= "
										 
                                          <tr id='".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."_".$rec_16['ORG_ID']."' class='collapsed' >
                                            <td bgcolor='#FFFFFF'><span style='font-weight:bold; margin-left:60px;'><a href='javascript:void(0)' onClick=\"show('".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."_".$rec_16['ORG_ID']."',this);\" ><img   src='../../images/exp.gif' ></a>  ".text($rec_16['ORG_NAME_TH'])."</span></td>
                                            <td align='center' bgcolor='#FFFFFF' >".$status."</td>
                                            <td align='center' bgcolor='#FFFFFF' >".$addSub.$edit.$edit1.$delete."</td>
                                         </tr>";
                               
											//กลุ่มงาน
											$sql_17 = "SELECT ORG_ID, ORG_PARENT_ID, ORG_NAME_TH, ACTIVE_STATUS FROM  SETUP_ORG WHERE DELETE_FLAG = 0 AND ORG_PARENT_ID = '".$rec_16['ORG_ID']."' ORDER BY ORG_NAME_TH ASC";
											$query_17 = $db->query($sql_17);
											while($rec_17 = $db->db_fetch_array($query_17)){
												$sql_sub= "SELECT COUNT(ORG_ID) AS NUM_ORG FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$rec_17['ORG_ID']."' AND DELETE_FLAG = '0'";
												$query_sub =  $db->query($sql_sub);
												$rec_sub = $db->db_fetch_array($query_sub);
												$num_17 = (int)$rec_sub['NUM_ORG'];
												if($num_17 == 0){
													$delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('" .$rec_17['ORG_ID']. "');\">".$img_del." ลบ</a> ";
												}
												$addSub = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addData('".$rec_17['ORG_ID']."', 14);\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่ม</a> ";
												$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_17['ORG_ID']."');\">".$img_edit." แก้ไข</a> ";
												$edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" .$rec_17['ORG_ID']. "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
												$status = ($rec_16['ACTIVE_STATUS'] == 1) ? "ใช้งาน" : "ไม่ใช้งาน";
												$HTML .= "
                                				<tr  id='".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."_".$rec_16['ORG_ID']."_".$rec_17['ORG_ID']."' class='collapsed' style='display:none;' >
                                                  <td bgcolor='#FFFFFF'><span style='font-weight:bold; margin-left:80px;'><a href='javascript:void(0)' onClick=\"show('".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."_".$rec_16['ORG_ID']."_".$rec_17['ORG_ID']."',this);\" ><img   src='../../images/exp.gif' ></a> ".text($rec_17['ORG_NAME_TH'])."</span></td>
                                                  <td align='center' bgcolor='#FFFFFF' >".$status."</td>
                                                  <td align='center' bgcolor='#FFFFFF' >".$addSub.$edit.$edit1.$delete."</td>
                                               </tr>";
                                
											$sql_14 = "SELECT ORG_ID, ORG_PARENT_ID, ORG_NAME_TH, ACTIVE_STATUS FROM  SETUP_ORG WHERE DELETE_FLAG = 0 AND ORG_PARENT_ID = '".$rec_17['ORG_ID']."' ORDER BY ORG_NAME_TH ASC";
											$query_14 = $db->query($sql_14);
											while($rec_14 = $db->db_fetch_array($query_14)){
												$delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('" .$rec_14['ORG_ID']. "');\">".$img_del." ลบ</a> ";
												$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec_14['ORG_ID']."');\">".$img_edit." แก้ไข</a> ";
												$edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" .$rec_14['ORG_ID']. "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
												$status = $rec_14['ACTIVE_STATUS'] ? "ใช้งาน" : "ไม่ใช้งาน";
							  					$HTML .="
                              					<tr id='".$rec_2['ORG_ID']."_".$rec_6['ORG_ID']."_".$rec_16['ORG_ID']."_".$rec_17['ORG_ID']."_".$rec_14['ORG_ID']."' class='collapsed' style='display:none;' >
                                                  <td bgcolor='#FFFFFF'><div style='font-weight:bold; margin-left:100px;' > ".text($rec_14['ORG_NAME_TH'])."</div></td>
                                                  <td align='center' bgcolor='#FFFFFF' >".$status."</td>
                                                  <td align='center' bgcolor='#FFFFFF' >".$edit.$edit1.$delete."</td>
                                               </tr>";
												
                              					}//while 14
											}//while 17
										
										} //while 16
									 
									}// while 6
									
								}//while 2
							
						
						echo $HTML;
					} //ต้องค้นหาก่อน
					?>
					</table>
              
			  </div>
			</div>
			
        </form>
        </div>
    </div>
    <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>