<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

 // echo "<pre>"; print_r($_POST); echo "<hr/>";   //echo "<pre>"; print_r($_SESSION); exit();
$headline_title = " รายงานอัตรากำลังข้าราชการแต่ละประเภทแยกตามสังกัดหน่วยงานตามกรอบ และปฎิบัติ                   ";
$menu_name = 30;
 
 
   $html  = "";
   $start_no = 1;
   $s_OT_ID = (int)$_POST['s_OT_ID'];
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
 
   if(!empty($POS_ID)){ 
		$sql = "Select * From POSITION_FRAME Where POS_ID = ".$POS_ID;
		$query = $db->query($sql);
		$data = $db->db_fetch_array($query);
		$pos_no = $data['POS_NO'];
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
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">สำนัก/กลุ่ม :</div>
			<div class="col-xs-12 col-sm-3">
						<select id="ORG_ID_3" name="ORG_ID_3" class="selectbox form-control" placeholder="สำนัก/กลุ่ม" onChange="get_org_4(this);" >
							<option value=""></option>
							<?php
							$sql_org_3 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = 15 ORDER BY ORG_SEQ ASC";
							$query_org_3 = $db->query($sql_org_3);
							$select_org_3[$data['ORG_ID_3']] = "Selected='Selected'";
							while($org = $db->db_fetch_array($query_org_3)){
								echo '<option value="'.$org['ORG_ID'].'" '.$select_org_3[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
							}
							?>
						</select>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	กลุ่มงาน  :		<div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2">
						<select id="ORG_ID_4" name="ORG_ID_4" class="selectbox form-control" placeholder="กลุ่มงาน">
							<option value=""></option>
							<?php
							if(!empty($data['ORG_ID_4'])){
								$sql_org_4 = "Select ORG_ID , ORG_NAME_TH From SETUP_ORG WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = '0' AND ORG_PARENT_ID = '".$data['ORG_ID_3']."' ORDER BY ORG_SEQ ASC";
								$query_org_4 = $db->query($sql_org_4);
								$select_org_4[$data['ORG_ID_4']] = "Selected='Selected'";
								while($org = $db->db_fetch_array($query_org_4)){
									echo '<option value="'.$org['ORG_ID'].'" '.$select_org_4[$org['ORG_ID']].'>'.text($org['ORG_NAME_TH']).'</option>';
								}
							}
							?>
						</select> 
			</div>
        </div> 
      


 
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทตำแหน่ง :</div>
			<div class="col-xs-12 col-sm-3">
						<select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="ประเภทตำแหน่ง" onChange="get_level(this); get_co_level(this); get_line_group(this); ">
							<option value=""></option>
							<?php
							$sql_type_name = "Select TYPE_ID , TYPE_NAME_TH From SETUP_POS_TYPE WHERE ACTIVE_STATUS = 1 AND POSTYPE_ID = '1' AND DELETE_FLAG = 0 ORDER BY TYPE_SEQ ASC";
							$query_type_name = $db->query($sql_type_name);
							$select_type[$data['TYPE_ID']] = "Selected='Selected'";
							while($type = $db->db_fetch_array($query_type_name)){
								echo '<option value="'.$type['TYPE_ID'].'" '.$select_type[$type['TYPE_ID']].' >'.text($type['TYPE_NAME_TH']).'</option>';
							}
							?>
						</select>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 	กรอบ / ปฎิบัติ  :	<div class="col-xs-12 col-sm-2">  </div></div>
			<div class="col-xs-12 col-sm-2"> 
                          <select id="s_OT_ID" name="s_OT_ID" class="selectbox form-control" placeholder="--<?php echo $arr_txt['show_all']; ?>--">
                                <option value=""  ><?php echo $arr_txt['show_all']; ?></option>
                                <option value="1"  >กรอบ</option>
                                <option value="2"  >ปฎิบัติ</option>	 
                          </select>
			</div>
        </div> 
 <div class="row"  style="text-align:center;"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
            
       
 
     <?php
 
	
	$html_start   =  "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;'>
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  
 
  <tr class='bgHead'>
    <th style=' border:solid 1px #000000; width:10%; '   ><div align='center'><strong>ลำดับที่</strong></div></th>
    <th style=' border:solid 1px #000000; width:35%;  '  ><div align='center'><strong>".$arr_txt['idcard']." </strong></div></th>
 
    <th style=' border:solid 1px #000000;  '  ><div align='center'><strong>ชื่อ-สกุล </strong></div></th>

    <th style=' border:solid 1px #000000;  '  ><div align='center'><strong>สำนัก/กลุ่ม </strong></div></th>
	
    <th style=' border:solid 1px #000000;  '  ><div align='center'><strong>กลุ่มงาน </strong></div></th>
    <th style=' border:solid 1px #000000;  '  ><div align='center'><strong>รายละเอียด </strong></div></th>	
 
  </tr>
 
  </thead>
	"; 
 
 		$html  .= "<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
	 		 <td CENTER_TOP >&nbsp; </td>  
			 <td CENTER_TOP >&nbsp; </td> 
			 <td CENTER_TOP >&nbsp; </td> 		 	 
			 <td CENTER_TOP >&nbsp; </td>	
			 <td CENTER_TOP >&nbsp; </td>				 	  
		 </tr>";
 
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
         </div> 
 </div> 
 
    
    
    
	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>
    
    