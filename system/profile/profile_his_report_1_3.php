<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$headline_title = "รายงานจำนวนข้าราชการจำแนกตามประเภท    ";
$menu_name = 3;
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
 
   
   
   
   $sql_line = "select LINE_ID, LINE_NAME_TH ";
   $sql_line .= " from SETUP_POS_LINE  "; 
 
    $sql_line .= " ORDER BY LINE_NAME_TH ASC";
	$query_line = $db->query($sql_line); 


   $sql_level = "select LEVEL_ID, LEVEL_NAME_TH ";
   $sql_level .= " from SETUP_POS_LEVEL  "; 
 
    $sql_level .= " ORDER BY LEVEL_NAME_TH ASC";
	$query_level = $db->query($sql_level); 
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
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_his_report_1_<?php echo $menu_name; ?>.js?<?php echo rand(); ?>"></script>

</head>
<body <?php echo $remove;?>> <?php  ///echo "<pre>"; print_r($_POST);  ?>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="profile_his_report_disp.php?<?php echo url2code($link2); ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
            <li class="active"><?php echo $headline_title; ?></li>
		</ol>
	</div>
    
    
	<div class="col-xs-12 col-md-12" id="content">
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ตำแหน่ง :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ตำแหน่ง "     >   
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_line)){?>
                        <option value="<?php echo $rec1['LINE_ID']?>"   >
                        <?php echo text($rec1['LINE_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ระดับ :</div>
			<div class="col-xs-12 col-sm-2">
                    <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox form-control" placeholder="ระดับ "     >   
                      <option value=""></option>
                      <?php while($rec2 = $db->db_fetch_array($query_level)){?>
                        <option value="<?php echo $rec2['LEVEL_ID']?>"   >
                        <?php echo text($rec2['LEVEL_NAME_TH'])?></option>
                      <?php }?>
                    </select>	
			</div>
        </div>
        
 <div class="row"  style="text-align:center;"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
            
      

       
          


     
     <?php
 
	
	$html_start   =  "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;'>
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  
  	 
	 
 
  <tr class='bgHead'>
    <th style=' border:solid 1px #000000;  '  rowspan=2><div align='center'><strong>ลำดับที่</strong></div></th>
    <th style=' border:solid 1px #000000;  ' rowspan=2><div align='center'><strong>ตำแหน่ง - ระดับ</strong></div>&nbsp;</th>
    <th style=' border:solid 1px #000000;  ' colspan=2><div align='center'><strong>ข้าราชการ</strong></div></th>
    <th style=' border:solid 1px #000000;  ' colspan=2><div align='center'><strong>ลูกจ้างประจำ</strong></div></th>
    <th style=' border:solid 1px #000000;  ' colspan=2><div align='center'><strong>พนักงานราชการ</strong></div></th>
    <th style=' border:solid 1px #000000;  ' rowspan=2><div align='center'><strong>รวม</strong></div></th>
    <th style=' border:solid 1px #000000;  ' rowspan=2><div align='center'><strong>หมายเหตุ</strong></div></th>
  </tr>
  <tr  class='bgHead'>
    <th><div align='center' style=' border-right:solid 1px #000000;  ' ><strong>ชาย</strong></div></th>
    <th><div align='center' style=' border-right:solid 1px #000000;  ' ><strong>หญิง</strong></div></th>
    <th><div align='center' style=' border-right:solid 1px #000000;  ' ><strong>ชาย</strong></div></th>
    <th><div align='center' style=' border-right:solid 1px #000000;  ' ><strong>หญิง</strong></div></th>
    <th><div align='center' style=' border-right:solid 1px #000000;  ' ><strong>ชาย</strong></div></th>
    <th><div align='center' ><strong>หญิง</strong></div></th>
  </tr>
 
	 
	 
 
  </thead>
	"; 
 
 
 
 /*
	foreach ($arr_org as $key => $value) {
		//echo "$key$value<br/>";
		$officer_num = 0;
		$regular_emp_num = 0;
		$temp_emp_num = 0;
		$all_emp_num = $officer_num + $regular_emp_num + $temp_emp_num;
		
		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td CENTER_TOP >".number_format(0,0)."</td> 
			 <td CENTER_TOP >".number_format(0,0)."</td> 
			 <td CENTER_TOP >".number_format(0,0)."</td> 	
			 <td CENTER_TOP >".number_format(0,0)."</td> 
			 <td CENTER_TOP >".number_format(0,0)."</td> 
			 <td CENTER_TOP >".number_format(0,0)."</td> 
			 <td CENTER_TOP >".number_format(0,0)."</td> 
			 <td CENTER_TOP >&nbsp; </td> 
		 </tr>";
		$start_no++;
	}
	 
*/ 
	    // summery 
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>".$arr_txt['total_result_txt']."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 	
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 	
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 
			 <td CENTER_TOP ><div align='center'><strong>".number_format(0,0)."</strong></div></td> 
			 <td CENTER_TOP >&nbsp; </td> 			 
		 </tr>";
	
		$html_end   = "</table>";


//if($num_rows > 0){ ?>
</form>  
<div class="row">  
       <div class="col-xs-12 col-md-3">
          <div class="btn-group">
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">พิมพ์  <span class="caret"></span></button>

              <ul class="dropdown-menu" role="menu">	
                            <li><a href="#" onClick="print_pdf();" >พิมพ์แบบ PDF</a></li>
             	<!-- <li><a href="#" onClick="print_report('excel','$PageRep');" >พิมพ์แบบ EXCEL</a></li>
              	<li><a href="#" onClick="print_report('word','$PageRep');" >พิมพ์แบบ WORD</a></li>-->
              </ul>
               <form id="frm-export" method="post" action="profile_his_report_1_<?php echo $menu_name; ?>_pdf.php">
                   <input type="hidden" id="pdf_body" name="pdf_body" value="<?php echo $html; ?>">
               </form>
        </div>
     </div>
</div>     
<?php // } 


	$html =  str_replace("CENTER_TOP",$CENTER_TOP,$html);
	$html =  str_replace("LEFT_TOP",$LEFT_TOP,$html);		
	
?><div class="col-xs-12 col-sm-12">
<?php
	echo $html_start.$html.$html_end;	
 ?> </div>
 
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
    
    