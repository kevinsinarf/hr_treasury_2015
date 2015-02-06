<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$headline_title = " รายงานสำหรับผู้ปฎิบัติงาน และผู้บริหาร โดยสามารถส่งออกข้อมูลในลักษณะ CSV                         ";
$menu_name = 37;
 
 
 
 

   $html  = "";
   $start_no = 1;
 


 
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
	    <?php echo report_breadcrumb($paramlink,showMenu($menu_sub_id),$headline_title); ?>
    
    
	<div class="col-xs-12 col-md-12" id="content">
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
                <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID; ?>">

 
 
        
 
        
 


 
 

       
 


     
     <?php
 
	
	$html_start   =  "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;'>
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  
  	 
	 
 
  <tr class='bgHead'>
    <th style=' border:solid 1px #000000; width:5%; '  rowspan='2'><div align='center'><strong>ลำดับที่</strong></div></th>
    <th style=' border:solid 1px #000000; width:10%;  '   rowspan='2'><div align='center'><strong>".$arr_txt['pos_no']." </strong></div></th>
      <th style=' border:solid 1px #000000; width:10%; '  ><div align='center'><strong> ชื่อ-สกุล</strong></div></th> 
 
 
      <th style=' border:solid 1px #000000; width:10%; '  ><div align='center'><strong>ประเภทตำแหน่ง</strong></div></th>
      <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>ระดับ</strong></div></th>
    <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>สายงาน</strong></div></th>
    <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>ตำแหน่งในสายงาน</strong></div></th>
    <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>สำนัก/กลุ่ม</strong></div></th>
    <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>สถานะของตำแหน่ง</strong></div></th>
	
   <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>รายละเอียด</strong></div></th>	
	 
  </tr>
   <tr>
 
  </tr>
 

 
  </thead>
	"; 
 
 
 
		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td CENTER_TOP >&nbsp; </td> 
 			 <td CENTER_TOP >&nbsp; </td> 
			 <td CENTER_TOP >&nbsp; </td> 
			 <td CENTER_TOP >&nbsp; </td> 
			 <td CENTER_TOP >&nbsp; </td> 
			 <td CENTER_TOP >&nbsp; </td> 		 
			 <td CENTER_TOP >&nbsp; </td> 
			 <td CENTER_TOP >&nbsp; </td> 
		 </tr>";
		$start_no++;
 
	 
 	  
 
	
		$html_end   = "</table>";

// if($num_rows > 0){ ?>
</form>   
      <div class="row">  <div class="col-xs-12 col-md-3">
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
     </div> </div>
<?php // } 

	$html =  str_replace("CENTER_TOP",$CENTER_TOP,$html);
	$html =  str_replace("LEFT_TOP",$LEFT_TOP,$html);		
?><div class="col-xs-12 col-sm-12">
<?php
	echo $html_start.$html.$html_end;	
 ?> </div>
 
 <center><button type="button" class="btn btn-primary" onClick="csv_export();">ส่งออกข้อมูลในรูปแบบ CSV</button></center>
     
         </div> 
 </div> 
 
    
    
    
	</div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    