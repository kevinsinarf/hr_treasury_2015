<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$query_type = $db->query("SELECT * FROM SETUP_POS_TYPE WHERE POSTYPE_ID = 1 AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ DESC");

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
<script src="js/pos_level_salary_disp.js?<?php echo rand(); ?>"></script>
</head>
<body>
<div class="container-full">
  <div><?php include($path."include/header.php"); ?></div>
  <div><?php include($path."include/menu.php"); ?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
      <li class="active"><?php echo Showmenu($menu_sub_id);?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata">
      <form id="frm-search" method="post" action="process/pos_level_salary_process.php">
        <input type="hidden" id="proc" name="proc" value="add">
        <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
        
		
      
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed">
              <thead class="bgHead">
                <tr >
                  <th rowspan="2" style="vertical-align:middle; text-align:center;" width="15%"><strong>ประเภทตำแหน่ง</strong></th>
                  <th rowspan="2" style="vertical-align:middle; text-align:center;" width="10%"><strong>ระดับ</strong></th>
                  <th rowspan="2" style="vertical-align:middle; text-align:center;" width="30%"><strong>ช่วงเงินเดือน</strong></th>
				  <th colspan="2" style="vertical-align:middle; text-align:center;" width="30%"><strong>ฐานในการคำนวณ</strong></th>
			    </tr>
                <tr >
				  <th  width="15%" style="vertical-align:middle; text-align:center;" ><strong>ระดับ</strong></th>
				  <th width="15%" style="vertical-align:middle; text-align:center;" ><strong>อัตรา</strong></th>
                </tr>
                </thead>
              <tbody> 
               <?php
			   $i= 0;
			   while($RecType = $db->db_fetch_array($query_type)){
				  $i_type=1;
				 $arr_level = GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND TYPE_ID = '".$RecType['TYPE_ID']."' ", "LEVEL_SEQ DESC ");
				 $QueryTitleAll = $db->query("SELECT A.SALARYTITLE_ID FROM SETUP_POS_STEP_SALARY A JOIN  SETUP_POS_SALARY_TITLE B ON A.SALARYTITLE_ID = B.SALARYTITLE_ID
                  WHERE a.TYPE_ID = '".$RecType['TYPE_ID']."' ");
				 $count_level = count($arr_level);
			     //$count_title_all = $db->db_num_rows($QueryTitleAll);
				 $total_field = $db->db_num_rows($QueryTitleAll); 
				 ?>
               <tr>
               	<td style="text-align:center; vertical-align:middle;" rowspan="<?php echo $total_field; ?>" ><?php echo text($RecType['TYPE_NAME_TH']); $i_type++; ?></td>
			   <?php
				   foreach($arr_level as $keylevel=>$level){ 
				   		$i_level=1;
						$arr_title = GetSqlSelectArray("A.SALARYTITLE_ID", "B.SALARYTITLE_NAME_TH", "SETUP_POS_STEP_SALARY A JOIN SETUP_POS_SALARY_TITLE B ON A.SALARYTITLE_ID = B.SALARYTITLE_ID", "A.TYPE_ID = '".$RecType['TYPE_ID']."' AND A.LEVEL_ID = '".$keylevel."' ", " A.SALARYTITLE_ID ");
					    $count_title = count($arr_title);
						//$count_sub = $count_title;
						/*echo "<pre>";
						print_r($arr_title);
						echo "</pre>";*/
					    if($i_type>2) echo "</tr><tr>"; ?>
                       	<td style="text-align:center; vertical-align:middle;" rowspan="<?php echo $count_title; ?>" ><?php echo text($level); ?></td>
                        <?php foreach($arr_title as $keytitle => $title){
							$query_salary = $db->query("SELECT LEVEL_SALARY_MIN, LEVEL_SALARY_MID, LEVEL_SALARY_MAX FROM SETUP_POS_LEVEL_SALARY WHERE TYPE_ID = '".$RecType['TYPE_ID']."' AND LEVEL_ID = '".$keylevel."' AND SALARYTITLE_ID = '".$keytitle."' AND POSTYPE_ID = 1");
							$rec_salary = $db->db_fetch_array($query_salary);
							if($i_level>2) echo "<tr>"; 
						?>
                        <td style="text-align:center">
                        <input name="min_money[<?php echo $RecType['TYPE_ID']."/".$keylevel."/".$keytitle; ?>]" type="text" class="form-control" style="width:150px;display:inline; text-align:right;" onBlur="NumberFormat(this,2);" value="<?php echo number_format($rec_salary['LEVEL_SALARY_MIN'],2); ?>" placeholder="" >
                        &nbsp;-&nbsp;
                        <input type="text" name="max_money[<?php echo $RecType['TYPE_ID']."/".$keylevel."/".$keytitle; ?>]" style="width:150px;display:inline; text-align:right;" class="form-control" placeholder="" onBlur="NumberFormat(this,2);" value="<?php echo number_format($rec_salary['LEVEL_SALARY_MAX'],2); ?>" >
                        </td>
                        <td align="center"><?php echo text($title); ?></td>
                        <td align="center"><input type="text" name="avg_money[<?php echo $RecType['TYPE_ID']."/".$keylevel."/".$keytitle; ?>]" style="width:150px;display:inline; text-align:right" class="form-control"  onBlur="NumberFormat(this,2);" value="<?php echo number_format($rec_salary['LEVEL_SALARY_MID'],2); ?>"  ></td>
                      
                       </tr>
				   <?php 
				      $i++;
				  	 $i_level++;
				   }
				  }
			   }
               ?>                 
              </tbody>
            </table>
          </div>
        </div>
        <div class="formlast">
          <div class="col-xs-12 col-sm-12" align="center">
              <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
              <button type="button" class="btn btn-default" >ยกเลิก</button>
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