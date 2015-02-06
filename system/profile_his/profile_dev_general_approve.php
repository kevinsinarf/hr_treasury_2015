<?php
$path = "../../";
include($path."include/config_header_top.php");

$ACT= 7;
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter="";
if(!empty($_POST['S_NAME'])){
	$filter.= " AND (e.PER_FIRSTNAME_TH LIKE '%".ctext($_POST['S_NAME'])."%' OR e.PER_LASTNAME_TH LIKE '%".ctext($_POST['S_NAME'])."%')";	
}
if(!empty($_POST['S_PROJECT'])){
	$filter.= " AND d.PROJECT_NAME_TH LIKE '%".ctext($_POST['S_PROJECT'])."%' ";	
}
if(!empty($_POST['S_ACT'])){
	$filter1= " AND a.COURSE_NAME_TH LIKE '%".ctext($_POST['S_ACT'])."%' ";
	$filter2= " AND a.EX_NAME_TH LIKE '%".ctext($_POST['S_ACT'])."%' ";	
}


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
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
<script src="js/profile_dev_general_approve.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li class="active"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการพัฒนาบุคลากร)</li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <?php include("tab_transfer.php");?>
    <div class="grouptab">
      <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="USER_REGIS_ID" name="USER_REGIS_ID" value="">
        <input type="hidden" id="TABLE_TRANSFER" name="TABLE_TRANSFER" value="">
        <input type="hidden" id="FIELD_TRANSFER" name="FIELD_TRANSFER" value="">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
        <div class="row">
            <div class="col-xs-12 col-md-1" style="white-space:nowrap">ชื่อ-สกุล :&nbsp;</div>   
            <div class="col-xs-12 col-md-3"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="ชื่อ-สกุล" maxlength="100" value="<?php echo $S_NAME;?>" ></div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-md-1" style="white-space:nowrap">โครงการ :&nbsp;</div>   
            <div class="col-xs-12 col-md-3"><input type="text" id="S_PROJECT" name="S_PROJECT" class="form-control" placeholder="โครงการ" maxlength="100" value="<?php echo $S_PROJECT;?>" ></div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-md-1" style="white-space:nowrap">หลักสูตร/กิจกรรม :&nbsp;</div>   
            <div class="col-xs-12 col-md-3"><input type="text" id="S_ACT" name="S_ACT" class="form-control" placeholder="หลักสูตร/กิจกรรม" maxlength="100" value="<?php echo $S_ACT;?>" ></div>
            <div class="col-xs-5 col-md-2"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
        </div>
        
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bgHead">
                      <th width="5%"><div align="center"><strong>ลำดับ
                        <input name="chkall" type="checkbox" id="chkall" value="1" onClick="f_chkall()">
                      </strong></div></th>
                      <th width="12%"><div align="center"><strong>ชื่อ-นามสกุล</strong></div></th>
                      <th width="12%"><div align="center"><strong>ประเภทโครงการ</strong></div></th>
                      <th width="12%"><div align="center"><strong>โครงการ</strong></div></th>
                      <th width="12%"><div align="center"><strong>หลักสุตร/กิจกรรม</strong></div></th>
                      <th width="12%"><div align="center"><strong>สถานที่</strong></div></th>
                      <th width="6%"><div align="center"><strong>ภายในประเภท/ต่างประเทศ</strong></div></th>
                      <th width="6%"><div align="center"><strong>วันที่</strong></div></th>
                      <th width="6%"><div align="center"><strong>ระยะเวลา</strong></div></th>
                      <th width="12%"><div align="center"><strong>ผู้จัด</strong></div></th>
                      <th width="5%"><div align="center"><strong>จัดการ</strong></div></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                //ฝึกอบรม/จริยธรรม/ดูงาน
                $i=1;
                $sql_his="SELECT	b.GEN_SDATE,
                                    b.GEN_EDATE,
                                    b.NUM_YEAR,
                                    b.NUM_MONTH,
                                    b.NUM_DAY,
                                    b.ADDRESS_NAME,
                                    d.PROJECT_NAME_TH,
                                    a.COURSE_NAME_TH,
									a.PROJECT_TYPE_COUNTRY,
									e.PREFIX_ID,
									e.PER_FIRSTNAME_TH,
									e.PER_LASTNAME_TH,
									c.USER_REGIS_ID,
									f.PROJECT_TYPE_NAME_TH,
									org2.ORG_NAME_TH AS org_name2,
									org3.ORG_NAME_TH AS org_name3,
									org4.ORG_NAME_TH AS org_name4
                            FROM	DEV_COURSE AS a INNER JOIN 
                                    DEV_GEN AS b ON a.COURSE_ID = b.COURSE_ID INNER JOIN 
                                    DEV_USER_REGIS AS c ON b.GEN_ID = c.GEN_ID INNER JOIN 
                                    DEV_PROJECT AS d ON d.PROJECT_ID = a.PROJECT_ID INNER JOIN
									PER_PROFILE AS e ON c.PER_ID = e.PER_ID LEFT JOIN
									DEV_SETUP_PROJECT_TYPE AS f ON f.PROJECT_TYPE_ID=a.COURSE_APP_TYPE LEFT JOIN
									SETUP_ORG AS org2 ON org2.ORG_ID=a.ORG_ID_2 LEFT JOIN
									SETUP_ORG AS org3 ON org3.ORG_ID=a.ORG_ID_3 LEFT JOIN
									SETUP_ORG AS org4 ON org4.ORG_ID=a.ORG_ID_4
                            WHERE	c.TRANSFER_STATUS=0 ".$filter.$filter1;
                $exc_his=$db->query($sql_his);
                while($row_his=$db->db_fetch_array($exc_his)){
					$transfer = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"transferData('".$row_his["USER_REGIS_ID"]."','DEV_USER_REGIS','USER_REGIS_ID');\">โอนข้อมูล</a> ";
                ?>
                  <tr>
                    <td align="center"><?php echo $i; ?>.
                    <input type="checkbox" name="chk_id<?php echo $i; ?>" id="chk_id<?php echo $i; ?>" class="chk" value="<?php echo $row_his["USER_REGIS_ID"]; ?>">
                    <input type="hidden" id="H_TABLE_TRANSFER<?php echo $i; ?>" name="H_TABLE_TRANSFER<?php echo $i; ?>" value="">
        			<input type="hidden" id="H_FIELD_TRANSFER<?php echo $i; ?>" name="H_FIELD_TRANSFER<?php echo $i; ?>" value="">
                    </td>
                    <td><?php echo Showname($row_his['PREFIX_ID'],$row_his['PER_FIRSTNAME_TH'],"",$row_his['PER_LASTNAME_TH']); ?></td>
                    <td><?php echo text($row_his['PROJECT_TYPE_NAME_TH']); ?></td>
                    <td><?php echo text($row_his['PROJECT_NAME_TH']); ?></td>
                    <td><?php echo text($row_his['COURSE_NAME_TH']); ?></td>
                    <td><?php echo text($row_his['ADDRESS_NAME']); ?></td>
                    <td align="center"><?php if($row_his['PROJECT_TYPE_COUNTRY']==1){ echo "ภายในประเทศ"; }else if($row_his['PROJECT_TYPE_COUNTRY']==2){ echo "ต่างประเทศ"; } ?></td>
                    <td align="center"><?php echo conv_date($row_his['GEN_SDATE'])." - ".conv_date($row_his['GEN_EDATE']); ?></td>
                    <td align="center"><?php 
                    echo ($row_his['NUM_YEAR']>0?$row_his['NUM_YEAR']." ปี ":"");
                    echo ($row_his['NUM_MONTH']>0?$row_his['NUM_MONTH']." เดือน ":"");
                    echo ($row_his['NUM_DAY']>0?$row_his['NUM_DAY']." วัน ":"");
                    ?></td>
                    <td align="center"><?php echo text($row_his['org_name2'])." / ".text($row_his['org_name3'])." / ".text($row_his['org_name4'])." "; ?></td>
                    <td align="center"><?php echo $transfer; ?></td>
                    </tr>
                <?php
                    $i++;
                }//while
            
                //แลกเปลี่ยน
                $sql_his="SELECT	a.EXCHANGE_ID,
									a.EX_NAME_TH,
									a.TOTAL_YEAR,
                                    a.TOTAL_MONTH,
                                    a.TOTAL_DATE,
                                    a.EX_SDATE,
                                    a.EX_EDATE,
									a.PROJECT_TYPE_COUNTRY,
                                    d.PROJECT_NAME_TH,
									e.PREFIX_ID,
									e.PER_FIRSTNAME_TH,
									e.PER_LASTNAME_TH,
									b.EX_USER_REGIS_ID,
									org2.ORG_NAME_TH AS org_name2,
									org3.ORG_NAME_TH AS org_name3,
									org4.ORG_NAME_TH AS org_name4
                            FROM	DEV_EX_EXCHANGE AS a INNER JOIN 
                                    DEV_EX_USER_REGIS AS b ON a.EXCHANGE_ID = b.EXCHANGE_ID INNER JOIN 
                                    DEV_PROJECT AS d ON a.PROJECT_ID = d.PROJECT_ID INNER JOIN
									PER_PROFILE AS e ON b.PER_ID = e.PER_ID LEFT JOIN
									SETUP_ORG AS org2 ON org2.ORG_ID=a.ORG_ID_2 LEFT JOIN
									SETUP_ORG AS org3 ON org3.ORG_ID=a.ORG_ID_3 LEFT JOIN
									SETUP_ORG AS org4 ON org4.ORG_ID=a.ORG_ID_4
                            WHERE	b.TRANSFER_STATUS=0 ".$filter.$filter2;
                $exc_his=$db->query($sql_his);
                while($row_his=$db->db_fetch_array($exc_his)){
					$transfer = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"transferData('".$row_his["EX_USER_REGIS_ID"]."','DEV_EX_USER_REGIS','EX_USER_REGIS_ID');\">โอนข้อมูล</a> ";
					
					
					
                ?>
                  <tr>
                    <td align="center"><?php echo $i; ?>.
                    <input type="checkbox" name="chk_id[]" id="chk_id[]" value="<?php echo $row_his["EX_USER_REGIS_ID"]; ?>"></td>
                    <td><?php echo Showname($row_his['PREFIX_ID'],$row_his['PER_FIRSTNAME_TH'],"",$row_his['PER_LASTNAME_TH']); ?></td>
                    <td>การแลกเปลี่ยนบุคลากรระหว่างหน่วยงาน (ภายในและภายนอก)</td>
                    <td><?php echo text($row_his['PROJECT_NAME_TH']); ?></td>
                    <td><?php echo text($row_his['EX_NAME_TH']); ?></td>
                    <td>
                    <?php
					$x=1;
					$sql_country="SELECT 	COUNTRY_NAME_TH
									FROM 	DEV_EX_COUNTRY LEFT JOIN
											SETUP_COUNTRY ON SETUP_COUNTRY.COUNTRY_ID=DEV_EX_COUNTRY.COUNTRY_ID
									WHERE 	EXCHANGE_ID='".$row_his['EXCHANGE_ID']."' ";
					$exc_country=$db->query($sql_country);
					$num_country=$db->db_num_rows($exc_country);
					while($row_country=$db->db_fetch_array($exc_country)){
						
						echo "-".text($row_country['COUNTRY_NAME_TH'])."<BR>";
						
					}//while
					?>
                    </td>
                    <td align="center"><?php if($row_his['PROJECT_TYPE_COUNTRY']==1){ echo "ภายในประเทศ"; }else if($row_his['PROJECT_TYPE_COUNTRY']==2){ echo "ต่างประเทศ"; } ?></td>
                    <td align="center"><?php echo conv_date($row_his['EX_SDATE'])." - ".conv_date($row_his['EX_SDATE']); ?></td>
                    <td align="center"><?php 
                    echo ($row_his['TOTAL_YEAR']>0?$row_his['TOTAL_YEAR']." ปี ":"");
                    echo ($row_his['TOTAL_MONTH']>0?$row_his['TOTAL_MONTH']." เดือน ":"");
                    echo ($row_his['TOTAL_DATE']>0?$row_his['TOTAL_DATE']." วัน ":"");
                    ?></td>
                    <td align="center"><?php echo text($row_his['org_name2'])." / ".text($row_his['org_name3'])." / ".text($row_his['org_name4'])." "; ?></td>
                    <td align="center"><?php echo $transfer; ?></td>
                    </tr>
                <?php
                    $i++;
                }//while
                ?>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
        <div class="row"> <?php echo ($nums>0)?endPaging("frm-search",$total_record):""; ?> </div>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>