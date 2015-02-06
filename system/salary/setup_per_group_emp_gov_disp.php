<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$S_YEAR_BDG = trim($_POST['S_YEAR_BDG']);
$S_ROUND = trim($_POST['S_ROUND']);
$S_ORG_ID_3 = $_POST['S_ORG_ID_3'];

//DEFUALT
if($S_YEAR_BDG == ''){
	$S_YEAR_BDG = date('Y')+543;
}
if($S_ROUND == ''){
	$S_ROUND = 1;
}


$filter = "";
if($S_ORG_ID_3 != ''){
	$filter .= " AND A.ORG_ID = '".$S_ORG_ID_3."' ";
}

$field="A.ORG_ID, A.ORG_NAME_TH";
$table="SETUP_ORG A
		  JOIN SAL_UP_SALARY B ON A.ORG_ID = B.ORG_ID_3  ";
$pk_id="A.ORG_ID";
$wh=" B.POSTYPE_ID = 5 AND B.YEAR_BDG = '".$S_YEAR_BDG."' AND B.ROUND = '".$S_ROUND."' {$filter} ";
$groupby = " GROUP BY A.ORG_ID, A.ORG_NAME_TH, A.ORG_SEQ "; 
$orderby="order by CASE WHEN A.ORG_SEQ IS NULL THEN 1 ELSE 0 END ,A.ORG_SEQ ASC ";
$notin=$wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh.$groupby." ".$orderby.") ".$groupby.$orderby;

$sql = "select top $page_size ".$field." from ".$table." where ".$notin;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh." {$filter}".$groupby));

$query_all = $db->query("SELECT COUNT(PER_ID) AS COUNT_PER FROM SAL_UP_SALARY WHERE  POSTYPE_ID = 5 AND CONFIRM_TYPE >= 2 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' ");
$rec_all = $db->db_fetch_array($query_all);
$num_all = (int)$rec_all['COUNT_PER'];

$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.DELETE_FLAG='0' AND a.ORG_PARENT_ID= 15 ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");
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
<script src="js/setup_per_group_emp_gov_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-sm-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active">ลูกจ้างประจำ->จัดกลุ่มสำหรับการเลื่อนขั้นค่าจ้าง</li>
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
            <input type="hidden" id="OGR_ID_3" name="ORG_ID_3" >
			
            
			<div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปีงบประมาณ : <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3">
                <select name="S_YEAR_BDG" id="S_YEAR_BDG" class="selectbox form-control" placeholder="ปีงบประมาณ" style="width:300px;" onChange="$('#frm-search').submit();" >
                <?php 
				for($y=$YEAR_BUDGET;$y>=$YEAR_BUDGET_PREV;$y--){
					?>
                    <option value="<?php echo $y;?>" <?php if($y == $S_YEAR_BDG){ echo "selected";} ?>><?php echo $y;?></option>
                    <?php	
				}
				?>
                </select>
                </div>
				<div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2">รอบ :  <span style="color:red;">*</span></div>
				<div class="col-xs-12 col-md-3">
                <select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="รอบ" onChange="$('#frm-search').submit();" >
                    <option value=""></option>
					<?php 
                    foreach($arr_emp_gov_round as $index => $val){
                        ?>
                        <option value="<?php echo $index;?>" <?php if($index == $S_ROUND){ echo "selected"; }?>><?php echo $val;?></option>
                        <?php
                    }
                    ?>
                </select>
                </div>
				
			</div>
            <div class="row">
				<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สังกัด (ปฏิบัติ) : </div>
				<div class="col-xs-12 col-md-3">
                	<?php echo GetHtmlSelect('S_ORG_ID_3','S_ORG_ID_3',$arr_org3,'ทั้งหมด',$S_ORG_ID_3,'','','1');?>
                </div>
            </div>
            <div class="row" style="text-align:center">
            	<button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button>
            </div>
            <div class="row"><?php echo ($nums > 0) ? startPaging("frm-search",$total_record):""; ?></div>
            <?php if($num_all == 0){ ?>
            <div class="row" style="margin-top:10px;">
                 <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="addPerAll();"><?php echo $img_save;?> นำเข้าข้อมูลจากทะเบียนประวัติ</a>
                 <?php if($nums > 0){ ?>
                 <a data-toggle="modal" class="btn btn-default" data-backdrop="static" href="javascript:void(0);" onClick="ConfirmPer();"><?php echo $img_save;?> อนุมัติการจัดกลุ่มเพื่อกำหนดกรอบเลื่อนค่าตอบแทน</a> 
           		<?php } ?>
                
           </div> 
           <?php } ?>
			<div class="table-responsive">
                <table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
                    <thead>
                        <tr class="bgHead">
                            <th width="4%"><div align="center"><strong>ลำดับ</strong></div></th>
                          	<th width="60%"><div align="center"><strong>สังกัด (ปฏิบัติ)</strong></div></th>
                            <th width="10%"><div align="center"><strong>จำนวน (คน)</strong></div></th>
                          	<th width="10%"><div align="center"><strong>จัดการ</strong></div></th>
                        </tr>
                    </thead>
                    <tbody >
                    <?php
					
					$i = 1;
					if($nums > 0){
					while($rec = $db->db_fetch_array($query)){
						$detail = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addGroup('".$rec["ORG_ID"]."');\">".$img_edit." จัดกลุ่ม</a>";
						$query_num = $db->query("SELECT COUNT(PER_ID) AS COUNT_PER FROM SAL_UP_SALARY WHERE POSTYPE_ID = 5 AND YEAR_BDG = '".$S_YEAR_BDG."' AND ROUND = '".$S_ROUND."' AND ORG_ID_3 = '".$rec['ORG_ID']."' ");
						$rec_num = $db->db_fetch_array($query_num);
						?>
                        <tr>
                            <td  align="center"><?php echo $i+$goto; ?>.</td>
                            <td align="left"><?php echo text($rec['ORG_NAME_TH']);?></td>
                            <td align="center"><?php echo number_format($rec_num['COUNT_PER']);?></td>
                            <td align="center"><?php echo $detail;?>&nbsp;</td>
                        </tr>
                        <?php
						$i++;
					}
					}else{
						echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
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