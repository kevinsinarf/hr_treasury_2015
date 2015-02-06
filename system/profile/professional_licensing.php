<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
   //echo "<pre>"; print_r($_SESSION); exit();
   //echo $_SESSION["sys_id"]; exit();
 if($_POST['PER_ID']){
 	$PER_ID = (int)$_POST['PER_ID'];
 }else{
 	$PER_ID = $_SESSION["sys_id"];
 }
$filter = "";

//PER_CERTIFICATEHIS 

$field= "a.PER_ID,a.CERTIFICATE_BY as 'CERTIFICATE_BY',b.CERTIFICATE_NAME_TH as 'CERTIFICATE_NAME_TH' ,b.CERTIFICATE_NAME_EN as 'CERTIFICATE_NAME_EN' ,a.CERTHIS_ID as 'CERTHIS_ID' ,a.CERTHIS_DATE as 'CERTHIS_DATE' , a.CERTHIS_NO as 'CERTHIS_NO' ";
$table =  "PER_CERTIFICATEHIS";
$table_join = "SETUP_CERTIFICATE";
$pk_id="CERTIFICATE_ID";
$order_by = " order by b.CERTIFICATE_NAME_TH ASC";





$wh="a.DELETE_FLAG='0'  {$filter}";

$sql = "  select ".$field."  from ".$table." a ";
$sql .=  " left join ".$table_join." b
on a.".$pk_id." = b.".$pk_id."
where  a.PER_ID = ".$PER_ID."    ";
if($s_name != ""){
	 $sql .= " and ('CERTIFICATE_NAME_TH' like '%".ctext($s_name)."%' )";
}
//echo $sql; exit();
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
 
$total_record = $db->db_num_rows($db->query($sql));

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
<script src="js/data_profess_licensing.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php");?></div>
    <div><?php include($path."include/menu.php");?></div>
    <div class="col-xs-12 col-sm-12">
        <ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          
          <li class="active">ประวัติประกอบวิชาชีพ</a></li>
        </ol>
    </div>
        <div class="col-xs-12 col-sm-12"  id="content"> 
    	<?php include("tab_profile.php");?>
        <div class="grouptab">
   
            <?php include("tab_info.php");?>
    
    
    
    <div class="">
		<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="CERTHIS_ID" name="CERTHIS_ID" value="">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">  
		<div class="row">
			<div class="col-xs-12 col-sm-1" style="white-space:nowrap;">ชื่อใบอนุญาติ :</div>
			<div class="col-xs-12 col-sm-3"><input type="text" id="s_name" name="s_name" class="form-control" placeholder="ชื่อใบประกอบวิชาชีพ" value="<?php echo $s_name; ?>"></div>
 
 
			<div class="col-xs-12 col-md-3"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
        </div>
        
        
		<?php if(chkPermission($menu_sub_id, 'add')=='1'){?>
		<div class="row">  
			<div class="col-xs-12 col-sm-1"><a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addData();"><?php echo $img_save;?> เพิ่มข้อมูล</a></div>
		</div>
		<?php }?>
        <div class="row"><?php echo ($nums>0) ? startPaging("frm-search",$total_record):""; ?></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed">
              <thead>
                <tr class="bgHead">
                  <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
                  <th width="30%"><div align="center"><strong>ชื่อใบประกอบวิชาชีพ (<?php echo $arr_txt['th'];?>)</strong> </div></th>
                  <th width="10%"><div align="center"><strong>หน่วยงานที่ออกให้</strong></div></th>
                  <th width="8%"><div align="center"><strong>เลขที่ใบอนุญาติ</strong></div></th>
                  <th width="8%"><div align="center"><strong>วันที่มีผลบังคับใช้ <br/> ( วัน เดือน ปี )</strong></div></th>
                  <th width="8%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                </tr>
				</thead>
 


				<tbody>
				<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($query)){
						//$rec = array_change_key_case($rec,CASE_LOWER);
						
					 
							$edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('".$rec["CERTHIS_ID"]."');\">".$img_view." ดูรายละเอียด</a> ";
					
						 
				?>  
                <tr bgcolor="#FFFFFF">
                  <td align="center"><?php echo $i+$goto; ?>.</td>
                   <td align="left"><?php echo text($rec["CERTIFICATE_NAME_TH"]); ?></td>
                  <td align="left"><?php echo $rec["CERTIFICATE_BY"]; ?></td>
                  <td align="left"><?php echo text($rec["CERTHIS_NO"]); ?></td>
                  <td align="left"><?php echo conv_date($rec["CERTHIS_DATE"], 'short'); ?></td>
                  <td align="center"><?php echo $edit; ?></td>
                </tr>
                <?php  
                        $i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
				}
				?>
              </tbody>
 


 
 
            </table>
          </div>
        </div>
        <div class="row"><?php echo ($nums>0)?endPaging("frm-search",$total_record):"";?></div>
      </form>
        </div>
    
    
    
    
    
    
    
    
    
    
    
    
    <div style="text-align:center; bottom:0px;"><?php    include($path."include/footer.php"); ?></div>
</div>   <?php // echo $sql; ?>
</body>
</html> 