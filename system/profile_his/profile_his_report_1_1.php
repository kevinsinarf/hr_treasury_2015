<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$postype_id = (int)$_GET['postype_id'];


$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}

//POST
$S_PENSION_IDCARD = trim($_POST['S_PENSION_IDCARD']);

if($S_PENSION_IDCARD != ''){
	
	//ข้อมูลส่วนตัว
	
	$sql_per = " SELECT  A.PT_ID,A.PER_SALARY_POSITION,A.PER_SALARY,A.POS_NO,A.LINE_ID,A.PER_ID, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_DATE_BIRTH, A.PER_DATE_ENTRANCE, 
	A.PER_DATE_OCCUPLY, A.PER_DATE_RETIRE, B.ORG_NAME_TH AS ORG_NAME_1, C.ORG_NAME_TH AS ORG_NAME_2, D.CV_NAME_TH  ,A.PER_FILE_PIC ,E.TYPE_NAME_TH, A.PER_SALARY_POSITION ,A.ORG_ID_3, A.GPF_STATUS ,A.PER_GPF_SDATE
	FROM PER_PROFILE A
	LEFT JOIN SETUP_ORG B ON A.ORG_ID_1 =  B.ORG_ID
	LEFT JOIN SETUP_ORG C ON A.ORG_ID_2 = C.ORG_ID
	LEFT JOIN ANNOUNCE_SETUP_CIVIL_TYPE D ON A.CV_ID = D.CV_ID
  	LEFT JOIN SETUP_POS_TYPE E ON A.TYPE_ID = E.TYPE_ID
	WHERE      A.DELETE_FLAG = 0 AND A.PER_IDCARD = '".str_replace('-','',$S_PENSION_IDCARD)."' AND a.POSTYPE_ID = '".$postype_id_is."'  ";
	//echo $sql_per;
	$query_per = $db->query($sql_per);
	$num_per = $db->db_num_rows($query_per);
	$rec_per = $db->db_fetch_array($query_per);
	$PER_ID = (int)$rec_per['PER_ID'];
	$PER_NAME = Showname($rec_per["PREFIX_ID"],$rec_per["PER_FIRSTNAME_TH"],$rec_per["PER_MIDNAME_TH"],$rec_per["PER_LASTNAME_TH"]);
	$POS_NO = (int)$rec_per["POS_NO"];
	$LINE_ID = (int)$rec_per["LINE_ID"];
	$PER_SALARY = number_format($rec_per['PER_SALARY'],2)." ".$arr_txt['baht'];
    $PER_SALARY_POSITION = number_format($rec_per['PER_SALARY_POSITION'],2)." ".$arr_txt['baht'];
	
  $per_pt_id = (int)$rec_per['PT_ID'];
  if($per_pt_id==1){
    $label_money = "เงินเดือน";
	$label_money_title = "ประวัติการเลื่อนขั้นเงินเดือน";
	$label_position = "ตำแหน่ง ระดับ";
  
  }
  if($per_pt_id==2){
    $label_money = "ค่าตอบแทน";
	$label_money_title = "ประวัติการเลื่อนค่าตอบแทน";
	$label_position = "ตำแหน่ง กลุ่มงาน";
  }
  if($per_pt_id==3){
    $label_money = "ค่าจ้าง";
	$label_money_title = "ประวัติการเลื่อนขั้นค่าจ้าง";
	$label_position = "ตำแหน่งในสายงาน ระดับตำแหน่ง";
  }
  /*
	$GPF_STATUS = 'ไม่ได้ระบุสถานะ';
	if($rec_per['PER_SALARY_POSITION'] > 0){
	   if($rec_per['PER_SALARY_POSITION'] ==1){ $GPF_STATUS = "เป็นสมาชิก";  }
	   if($rec_per['PER_SALARY_POSITION'] ==1){ $GPF_STATUS = "ไม่เป็นสมาชิก";  }
	}
*/
    $GPF_STATUS = $rec_per['GPF_STATUS'];
    if($GPF_STATUS == 1){
			$GPF_STATUS = "เป็นสมาชิก"; 
	}else if($GPF_STATUS == 2){
	        $GPF_STATUS = "ไม่เป็นสมาชิก";
	}else{
	        $GPF_STATUS = "ไม่ได้ระบุสถานะ";
	}
	
	$PER_GPF_SDATE =  conv_date($rec_per['PER_GPF_SDATE'],'short');  
	  $sql_position = " select Line_name_th from setup_pos_line where line_id = '".$LINE_ID."' ";
	  $query_position = $db->query($sql_position);
	  $rec_postion = $db->db_fetch_array($query_position);
	  $line_name_th = text(wordwrap($rec_postion['Line_name_th']));
	  
  $org_id_3 = (int)$rec_per['ORG_ID_3'];
  $sql_position = " select ORG_NAME_TH from SETUP_ORG where org_id = '".$org_id_3."' ";
  $query_position = $db->query($sql_position);
  $rec_postion = $db->db_fetch_array($query_position);
  $org_name_th = text(wordwrap($rec_postion['ORG_NAME_TH']));
	  
	//คู่สมรส
	$sql_mate ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
	FROM PER_FAMILY 
	WHERE FAMILY_RELATIONSHIP = '3'  AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  
	ORDER BY MARRY_SEQ DESC ";
	$query_mate = $db->query($sql_mate);
	$rec_mate = $db->db_fetch_array($query_mate);
	$MATE_NAME = Showname($rec_mate["FAMILY_PREFIX_ID"],$rec_mate["FAMILY_FIRSTNAME_TH"],$rec_mate["FAMILY_MIDNAME_TH"],$rec_mate["FAMILY_LASTNAME_TH"]);
	
	//บิดา
	$sql_father ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
	FROM PER_FAMILY 
	WHERE FAMILY_RELATIONSHIP = '1' AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  ";
	
	$query_father = $db->query($sql_father);
	$rec_father = $db->db_fetch_array($query_father);
	$FATHER_NAME = Showname($rec_father["FAMILY_PREFIX_ID"],$rec_father["FAMILY_FIRSTNAME_TH"],$rec_father["FAMILY_MIDNAME_TH"],$rec_father["FAMILY_LASTNAME_TH"]);
	
	//มารดา
	$sql_mother ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
	FROM PER_FAMILY 
	WHERE FAMILY_RELATIONSHIP = '2'   AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  ";
	
	$query_mother = $db->query($sql_mother);
	$rec_mother = $db->db_fetch_array($query_mother);
	$MOTHER_NAME = Showname($rec_mother["FAMILY_PREFIX_ID"],$rec_mother["FAMILY_FIRSTNAME_TH"],$rec_mother["FAMILY_MIDNAME_TH"],$rec_mother["FAMILY_LASTNAME_TH"]);
    $gov_type = text($rec_per['CV_NAME_TH']);//"ข้าราชการรัฐสภาสามัญ";
	
	 $sql_edu = " select a.ed_id,a.ins_id,b.ED_NAME_TH,c.INS_NAME_TH,d.EM_NAME_TH from PER_EDUCATEHIS a 
left JOIN SETUP_EDU_DEGREE b ON a.ed_id = b.ED_ID
left join SETUP_EDU_INSTITUTE c ON a.ins_id = c.ins_id 
left join SETUP_EDU_MAJOR d ON a.EM_id = d.EM_id 
where a.EDU_TYPE = 2  and a.DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'
order by a.EDU_EDATE DESC  ";
	$query_edu = $db->query($sql_edu);
	$rec_edu = $db->db_fetch_array($query_edu);
	$edu1_degree = text(wordwrap($rec_edu['ED_NAME_TH']));
	if($rec_edu['EM_NAME_TH']!=""){ 
		$edu1_degree .= " ( ".text(wordwrap($rec_edu['EM_NAME_TH']))." ) ";
	}
	$edu1_ins = text(wordwrap($rec_edu['INS_NAME_TH']));	


	
	 $sql_edu = " select a.ed_id,a.ins_id,b.ED_NAME_TH,c.INS_NAME_TH,d.EM_NAME_TH from PER_EDUCATEHIS a 
left JOIN SETUP_EDU_DEGREE b ON a.ed_id = b.ED_ID
left join SETUP_EDU_INSTITUTE c ON a.ins_id = c.ins_id 
left join SETUP_EDU_MAJOR d ON a.EM_id = d.EM_id 
where a.EDU_TYPE = 1   and a.DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'
order by a.EDU_EDATE DESC  ";
	$query_edu = $db->query($sql_edu);
	$rec_edu = $db->db_fetch_array($query_edu);
	$edu2_degree = text(wordwrap($rec_edu['ED_NAME_TH']));
	if($rec_edu['EM_NAME_TH']!=""){ 
		$edu2_degree .= " ( ".text(wordwrap($rec_edu['EM_NAME_TH']))." ) ";
	}
	$edu2_ins = text(wordwrap($rec_edu['INS_NAME_TH']));	
}
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "  DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "  DELETE_FLAG='0'", "TAMB_NAME_TH"); //ตำบล 
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", " DELETE_FLAG='0'", "AMPR_NAME_TH"); //อำเภอ
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
<script src="js/profile_his_report_1_1.js?<?php echo rand(); ?>"></script>
<script>
 
$(document).ready(function() {
    $('#footer').css({
        position: 'relative',
        bottom: '-200px',
         
    });
});
</script>
</head>
<body <?php echo $remove;?>>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="profile_his_report_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
            <li class="active">
            <?php
			if($postype_id_is==1){  echo "1".$number_subfix.$report_menu[1]['name'];  }
			if($postype_id_is==3){  echo "34".$number_subfix.$report_menu[36]['name'];  }
			if($postype_id_is==5){  echo "47".$number_subfix.$report_menu[49]['name'];  }
			?>
             </li>
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
                <input type="hidden" id="POSTYPE_ID_is" name="POSTYPE_ID_is" value="<?php echo $postype_id_is; ?>">
				<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();"><?php echo switchPic($path,"switchPic1", "0");?> รายงาน ก.พ. 7</a>
				</div>
				<div id="collapse1" class="collapse in">
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap; font-weight:bold;"><?php echo $arr_txt['idcard']; ?> :&nbsp;<span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-md-3">
                        <input type="text" id="S_PENSION_IDCARD" name="S_PENSION_IDCARD" class="form-control idcard" value="<?php echo $S_PENSION_IDCARD; ?>" style="display:inline-table; width:200px; margin-right:5px;">
               
                          <?php echo btn_do_center("GetPer();","a"); ?>
                       </div>
                       <?php if($num_per > 0){ ?>
                               <div class="col-xs-12 col-md-3">
                                 <div class="btn-group">
                                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                  พิมพ์  <span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu" role="menu">
                                  <li><a href="#" onClick="print_report('pdf','profile_his_report_1_1_2pdf.php');" >พิมพ์แบบ PDF</a></li>
                                 <!-- <li><a href="#" onClick="print_report('excel','$PageRep');" >พิมพ์แบบ EXCEL</a></li>
                                  <li><a href="#" onClick="print_report('word','$PageRep');" >พิมพ์แบบ WORD</a></li>-->
                                  </ul>
                                </div>
                            </div>
                   <?php } ?>
                  </div>


 <?php
				
				    $label[] = "กระทรวง";     $data_label[] =  text($rec_per['ORG_NAME_1']);
				    $label[] = "กรม";     $data_label[] =  text($rec_per['ORG_NAME_2']);
					
				    $label[] = "ชื่อ - สกุล";     $data_label[] =  $PER_NAME;
				    $label[] = "";     $data_label[] = "";
					
				    $label[] = "ชื่อ-สกุลคู่สมรส ";     $data_label[] =  $MATE_NAME;	
				    $label[] = "นามสกุลเดิม";     $data_label[] = "";
					
				    $label[] = "ชื่อ-สกุลบิดา ";     $data_label[] =  $FATHER_NAME;	
				    $label[] = "";     $data_label[] = "";
					
				    $label[] = "ชื่อ-สกุลมารดา ";     $data_label[] =  $MOTHER_NAME;			
				    $label[] = "นามสกุลเดิม";     $data_label[] = "";
					
				    $label[] = "วัน เดือน ปี เกิด";     $data_label[] = conv_date($rec_per['PER_DATE_BIRTH'],'short');
				    $label[] = "วันบรรจุ";     $data_label[] = conv_date($rec_per['PER_DATE_ENTRANCE'],'short');
					
				    $label[] = "วันที่เริ่มปฏิบัติราชการ";     $data_label[] = conv_date($rec_per['PER_DATE_ENTRANCE'],'short');
                    if($per_pt_id!=2){ 
				    $label[] = "วันครบเกษียณอายุ";     $data_label[] = conv_date($rec_per['PER_DATE_RETIRE'],'short');
					}else{
				    $label[] = "";     $data_label[] = "";
					}
					
				    $label[] = "ประเภทข้าราชการ";     $data_label[] = $gov_type;			
				    $label[] = "กอง / สำนัก";     $data_label[] = $org_name_th;
					
				    $label[] = $arr_txt['pos_no'];     $data_label[] = $POS_NO;
				    $label[] = "ตำแหน่ง";     $data_label[] = $line_name_th;
					
				    $label[] = $label_money;     $data_label[] = $PER_SALARY;
				    $label[] = "เงินประจำตำแหน่ง";     $data_label[] = $PER_SALARY_POSITION;
					
				    $label[] = "วุฒิการศึกษาสูงสุด";     $data_label[] = $edu1_degree;
				    $label[] = "สถานศึกษา";     $data_label[] = $edu1_ins;			
					
				    $label[] = "วุฒิการศึกษาในตำแหน่ง";     $data_label[] = $edu2_degree;
				    $label[] = "สถานศึกษา";     $data_label[] = $edu2_ins;
  				    if($per_pt_id!=2){ 
				    $label[] = "สถานะของการเป็นสมาชิก กบข.";     $data_label[] = $GPF_STATUS;
				    $label[] = "วันที่เป็นสมาชิก";     $data_label[] = $PER_GPF_SDATE;
 					} 
				     label_data_on_row($label,$data_label);
?>
 
                    
			</div>




            <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();"><?php echo switchPic($path,"switchPic2", "0");?> ประวัติการศึกษา</a>
			</div>
			<div id="collapse2" class="collapse in">
              <?php
			  	$sql_train = " 
				 	SELECT B.INS_NAME_TH, A.EDU_SDATE, A.EDU_EDATE, C.ED_NAME_TH, D.EM_NAME_TH  
					FROM PER_EDUCATEHIS  A 
					LEFT JOIN SETUP_EDU_INSTITUTE B ON A.INS_ID = B.INS_ID
					LEFT JOIN SETUP_EDU_DEGREE C ON A.ED_ID = C.ED_ID
					LEFT JOIN SETUP_EDU_MAJOR D ON A.EM_ID = D.EM_ID
				 	WHERE A.PER_ID = '".$PER_ID."' AND A.DELETE_FLAG = 0  ORDER BY A.EDU_SEQ DESC
				";
				$query_train = $db->query($sql_train);
				$num_train = $db->db_num_rows($query_train);
			  ?>
            
            	<div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="40%"><div align="center"><strong>สถานศึกษา</strong></div></th>
                          <th width="20%"><div align="center"><strong>ตั้งแต่ - ถึง (วัน เดือน ปี)</strong></div></th>
                          <th width="40%"><div align="center"><strong>วุุฒิ ( สาขาวิชาเอก )</strong></div></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
				  if($num_train > 0){
					  while($rec_train = $db->db_fetch_array($query_train)){
						  $majar = "";
						  if(trim($rec_train['EM_NAME_TH']) != ''){
							  $majar = "(".text($rec_train['EM_NAME_TH']).")";
						  }
				  ?>
                  	<tr bgcolor="#FFFFFF">
                      <td align="left"><?php echo text($rec_train['INS_NAME_TH']); ?></td>
                      <td align="center"><?php echo conv_date($rec_train['EDU_SDATE'],'short'); ?> ถึง <?php echo conv_date($rec_train['EDU_EDATE'],'short'); ?> </td>
                      <td align="left"><?php echo text($rec_train['ED_NAME_TH']).$majar; ?></td>
                	</tr>
                  <?php
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],3); 
				  }
				  ?>
                  </tbody>
                </table>
               </div>
           </div>	
          

        
            <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();"><?php echo switchPic($path,"switchPic4", "0");?> ใบอนุญาดิประกอบวิชาชีพ</a>
			</div>
			<div id="collapse4" class="collapse in">
 <?php
				$sql_professional = " select a.PER_ID,b.CERTIFICATE_BY as 'CERTIFICATE_BY',b.CERTIFICATE_NAME_TH as 'CERTIFICATE_NAME_TH' ,b.CERTIFICATE_NAME_EN as 'CERTIFICATE_NAME_EN' ,a.CERTHIS_ID as 'CERTHIS_ID' ,a.CERTHIS_DATE as 'CERTHIS_DATE' , a.CERTHIS_NO as 'CERTHIS_NO' from PER_CERTIFICATEHIS a left join SETUP_CERTIFICATE b on a.CERTIFICATE_ID = b.CERTIFICATE_ID where a.PER_ID =  '".$PER_ID."' ";
				$query_professional = $db->query($sql_professional);
				$num_professional = $db->db_num_rows($query_professional);
?>
            	<div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="40%"><div align="center"><strong>ชื่อใบอนุญาต</strong></div></th>
                          <th width="30%"><div align="center"><strong>หน่วยงาน</strong></div></th>
                          <th width="15%"><div align="center"><strong>เลขที่ใบอนุญาต</strong></div></th>
                          <th width="15%"><div align="center"><strong>วันที่มีผลบังคับใช้ <br/>( วัน เดือน ปี )</strong></div></th>

                      </tr>
                  </thead>
                  <tbody>
<?php
				  if($num_professional > 0){
					  while($rec_professional = $db->db_fetch_array($query_professional)){
?>
                  <tr bgcolor="#FFFFFF">
                      <td align="left" valign="top"><?php echo text($rec_professional['CERTIFICATE_NAME_TH']); ?></td>
                      <td align="left" valign="top"><?php echo  text($rec_professional['CERTIFICATE_BY']); ?> </td>
                  		<td align="center" valign="top"><?php echo  text($rec_professional['CERTHIS_NO']); ?> </td>
                  		<td align="center" valign="top"><?php echo  conv_date($rec_professional['CERTHIS_DATE'],'short'); ?> </td>
                	</tr>
<?php
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],4); 
				  }
?>
                  </tbody>
                </table> 
                	
              </div>
            
            </div>
          
          
          




            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse21x" onClick="$('.switchPic21x').toggle();"><?php echo switchPic($path,"switchPic21x", "0");?> <?php echo $arr_txt['profile_history']; ?></a></div>
			<div id="collapse21x" class="collapse in"> 
              <?php 
			  
if($S_PENSION_IDCARD != ''){	
				$sql_pos=" SELECT a.per_id ,a.POS_NO,b.LINE_NAME_TH,a.COM_SDATE , DATEADD(day,-1,a.COM_SDATE) AS end_date
,d.ORG_NAME_TH,e.OT_NAME_TH ,f.CT_NAME_TH,a.COM_NO,a.COM_DATE,g.LEVEL_NAME_TH,
a.MOVEMENT_ID,h.MOVEMENT_NAME_TH
				from PER_POSITIONHIS  a
LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID 
LEFT JOIN SETUP_ORG d ON a.ORG_ID_3 = d.org_id
LEFT JOIN SETUP_ORG_TYPE e ON d.OT_ID = e.OT_ID
LEFT JOIN SETUP_COMMAND_TYPE f ON a.CT_ID = f.CT_ID
LEFT JOIN SETUP_POS_LEVEL g ON a.LEVEL_id = g.LEVEL_id
LEFT JOIN SETUP_MOVEMENT h ON a.MOVEMENT_ID = h.MOVEMENT_ID
where a.per_id = '".$PER_ID."'
ORDER BY COM_SDATE DESC , d.ORG_NAME_TH DESC  ";   
				$query_pos=$db->query($sql_pos);
				$poshis_nums=$db->db_num_rows($query_pos);
			  ?>
            
            	<div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
<?php 							 
								 th_show("เริ่ม (วัน เดือน ปี)"); 
						         th_show("ถึง (วัน เดือน ปี)"); 
								 th_show($label_position);
								 th_show($arr_txt['pos_no']);
								 th_show($arr_txt['org_label_name']);
								 th_show("กรม กระทรวง");
								 th_show("คำสั่ง ลงวันที่ "); 
 ?>
 
                      </tr>
                  </thead>
                  <tbody>
                  <?php 
  if($poshis_nums > 0){  
  $i=1;
      while($rec_pos = $db->db_fetch_array($query_pos)){
	         $end_date= conv_date($rec_pos['end_date'],'short');
	         $end_date_temp = conv_date($rec_pos['end_date'],'short');
			 if($i==1){  
			 	$end_date = "";  
			 }else{
			    $end_date = $end_date_temp2;
			 }//if
	    echo  "<tr >";
		echo "
						 <td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_pos['COM_SDATE'],'short')."</td>
						 <td align='center' valign='top' style=' border:solid 1px #000000;' >".$end_date."</td>
						 <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_pos['LINE_NAME_TH'],45, ' ',true))." ".text(wordwrap($rec_pos['LEVEL_NAME_TH'],45, ' ',true))."</td>
						 <td align='center' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_pos['POS_NO'],45, ' ',true))."</td> 
						 <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_pos['ORG_NAME_TH'],45, ' ',true))."</td>
						 <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_pos['OT_NAME_TH'],45, ' ',true))."</td>
						 <td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_pos['CT_NAME_TH'],45, ' ',true))." ที่<br/>".text($rec_pos['COM_NO'])." ลว. ".conv_date($rec_pos['COM_DATE'],'short')." ".text(wordwrap($rec_pos['MOVEMENT_NAME_TH'],45,' ',true))." ) </td> 
					</tr> ";
		$i++;
		$end_date_temp2 = $end_date_temp;
					  }
	  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],7); 
	  } 
				  ?>
                  </tbody>
                </table>
   </div>
</div>	

            
            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse21" onClick="$('.switchPic21').toggle();"><?php echo switchPic($path,"switchPic21", "0");?> <?php echo $label_money_title; ?></a></div>
			<div id="collapse21" class="collapse in"> 
              <?php
		 $sql_salary_up =  " SELECT A.COM_NO, A.COM_DATE, A.COM_SDATE, A.SALARY, A.SALHIS_TYPE, A.SALHIS_UP, A.SALHIS_NOTE,  B.LEVEL_NAME, 
		  C.CT_NAME_TH, D.MOVEMENT_NAME_TH
		  FROM PER_SALARYHIS A 
		  LEFT JOIN SAL_LEVEL_SCORE B ON A.LV_SCORE_ID = B.LV_SCORE_ID 
		  LEFT JOIN SETUP_COMMAND_TYPE C  ON  A.CT_ID = C.CT_ID
		  LEFT JOIN SETUP_MOVEMENT D ON A.MOVEMENT_ID = D.MOVEMENT_ID
		  WHERE D.MOVE_PROCESS_ID = 8  AND A.PER_ID = '".$PER_ID."'  ";
		  
		  
		  

 				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			  ?>
            
            	<div class="table-responsive">
						<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
 
								<tr class='bgHead'>
                                
<?php 							 
								 th_show("วัน เดือน ปี"); 
								 th_show("ขั้น"); 
								 th_show("อัตรา".$label_money);  
								 th_show("คำสั่ง ลงวันที่");
								 th_show("หมายเหตุ");                       
?>
 
								</tr>
							</thead>
							<tbody> 
                  <?php
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
	   	$SALHIS_TYPE  = $rec_salary_up['STEP_UP'];
	   	$SALHIS_UP  = $rec_salary_up['PERCENT_SPE'];
        $SALHIS_UP_is = "";
	    if($SALHIS_UP>0){
			if($SALHIS_TYPE>0){
			
			      $SALHIS_UP_is = "ร้อยละ ".number_format($SALHIS_UP,3);
				 if($SALHIS_TYPE==1){ //ร้อยละ 
				    $SALHIS_UP_is = $SALHIS_UP_is." % "; 
				 }
				 if($SALHIS_TYPE==2){ // ขั้น
				    $SALHIS_UP_is = $SALHIS_UP_is." ขั้น"; 
				 } 
				$SALHIS_UP_is = $SALHIS_UP_is." ( ".text(wordwrap($rec_salary_up['LEVEL_NAME'],45, ' ',true))." ) "; 
			}
	    }
 $html  = " <tr  >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))." ".$SALHIS_UP_is." </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['SALARY'],2)."&nbsp;&nbsp;</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     										 <td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['REMARKS'],45, ' ',true))." </td>		 
		</tr> "; 
	    echo $html;
		$i++;
		$end_date_temp2 = $end_date_temp;
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],5); 
				  }
				  ?>
                  </tbody>
                </table>
               </div>
           </div>	
           
           
           
        
            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse23" onClick="$('.switchPic23').toggle();"><?php echo switchPic($path,"switchPic23", "0");?> ประวัติการได้รับเงินรางวัลประจำปี</a></div>
			<div id="collapse23" class="collapse in"> 
              <?php
				$sql_salary_up="  select  * from PER_BONUSHIS  A  
where A.DELETE_FLAG = 0 and per_id = '".$PER_ID."'
ORDER BY a.COM_SDATE DESC ";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			  ?>
            
            	<div class="table-responsive">
						<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
 
								<tr class='bgHead'>
                                    <?php 
									th_show("วัน เดือน ปี"); 
									th_show("ขั้น");
									th_show("อัตรา".$label_money); 
									th_show("คำสั่ง ลงวันที่");
									th_show("หมายเหตุ","width:5cm;");
									?>
 
								</tr>
							</thead>
							<tbody> 
                  <?php
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
 $html  =    " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text($arr_mov_type[$rec['MOVEMENT_ID']])."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['SALARY'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['BOUNUSHIS_TITLE_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['BOUNUSHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	    echo $html;
		$i++;
		$end_date_temp2 = $end_date_temp;
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],5); 
				  }
				  ?>
                  </tbody>
                </table>
               </div>
           </div>	

           
           
           
           
            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse22" onClick="$('.switchPic22').toggle();"><?php echo switchPic($path,"switchPic22", "0");?> ประวัติเงินเพิ่มค่าครองชีพชั่วคราว</a></div>
			<div id="collapse22" class="collapse in"> 
              <?php
				$sql_salary_up=" select  a.COMPENSATION_4,a.SALHIS_TYPE,a.SALHIS_UP,a.COM_SDATE,a.SALARY,a.SALHIS_NOTE,a.COM_NO,b.CT_NAME_TH,a.COM_DATE ,c.MOVEMENT_NAME_TH
 from PER_SALARYHIS a 
LEFT JOIN SETUP_COMMAND_TYPE b ON  a.CT_ID = b.CT_ID
left join SETUP_MOVEMENT c ON a.MOVEMENT_ID = c.MOVEMENT_ID
where a.per_id = '".$PER_ID."'  
AND COMPENSATION_4 > 0
ORDER BY a.COM_SDATE DESC";
 
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			  ?>
            
            	<div class="table-responsive">
						<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
 
								<tr class='bgHead'>
                                
                                    <?php 
									th_show("วัน เดือน ปี"); 
									th_show("ขั้น");
									th_show("อัตรา".$label_money); 
									th_show("คำสั่ง ลงวันที่");
									th_show("หมายเหตุ","width:5cm;");
									?>
 
								</tr>
							</thead>
							<tbody> 
                  <?php
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
 $html  = " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['COMPENSATION_4'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	    echo $html;
		$i++;
		$end_date_temp2 = $end_date_temp;
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],5); 
				  }
				  ?>
                  </tbody>
                </table>
               </div>
           </div>	
           
 

   
            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse23" onClick="$('.switchPic23').toggle();"><?php echo switchPic($path,"switchPic23", "0");?> ประวัติเงินเพิ่มพิเศษสำหรับการสู้รบ (พ.ส.ร.)</a></div>
			<div id="collapse23" class="collapse in"> 
              <?php
				$sql_salary_up="  select  a.COMPENSATION_3,a.SALHIS_TYPE,a.SALHIS_UP,a.COM_SDATE,a.SALARY,a.SALHIS_NOTE,a.COM_NO,b.CT_NAME_TH,a.COM_DATE ,c.MOVEMENT_NAME_TH
 from PER_SALARYHIS a 
LEFT JOIN SETUP_COMMAND_TYPE b ON  a.CT_ID = b.CT_ID
left join SETUP_MOVEMENT c ON a.MOVEMENT_ID = c.MOVEMENT_ID
where a.per_id = '".$PER_ID."'  
AND COMPENSATION_3 > 0
ORDER BY a.COM_SDATE DESC";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			  ?>
            
            	<div class="table-responsive">
						<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
 
								<tr class='bgHead'>
                                
                                    <?php 
									th_show("วัน เดือน ปี"); 
									th_show("ขั้น");
									th_show("อัตรา".$label_money); 
									th_show("คำสั่ง ลงวันที่");
									th_show("หมายเหตุ","width:5cm;");
									?>
 
								</tr>
							</thead>
							<tbody> 
                  <?php
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
 $html  =   ""; 
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['COMPENSATION_3'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	    echo $html;
		$i++;
		$end_date_temp2 = $end_date_temp;
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],5); 
				  }
				  ?>
                  </tbody>
                </table>
               </div>
           </div>	
        
      

 



   
            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse231" onClick="$('.switchPic231').toggle();"><?php echo switchPic($path,"switchPic231", "0");?> เงินเพิ่มสำหรับตำแหน่งที่มีเหตุพิเศษ</a></div>
			<div id="collapse231" class="collapse in"> 
              <?php
				$sql_salary_up="  select  a.COMPENSATION_5,a.SALHIS_TYPE,a.SALHIS_UP,a.COM_SDATE,a.SALARY,a.SALHIS_NOTE,a.COM_NO,b.CT_NAME_TH,a.COM_DATE ,c.MOVEMENT_NAME_TH
 from PER_SALARYHIS a 
LEFT JOIN SETUP_COMMAND_TYPE b ON  a.CT_ID = b.CT_ID
left join SETUP_MOVEMENT c ON a.MOVEMENT_ID = c.MOVEMENT_ID
where a.per_id = '".$PER_ID."'  
AND COMPENSATION_5 > 0
ORDER BY a.COM_SDATE DESC";
				$query_salary_up=$db->query($sql_salary_up);
				$salary_up_nums=$db->db_num_rows($query_salary_up);
			  ?>
            
            	<div class="table-responsive">
						<table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' >
							<thead>
 
								<tr class='bgHead'>
                                
                                    <?php 
									th_show("วัน เดือน ปี"); 
									th_show("ขั้น");
									th_show("อัตรา".$label_money); 
									th_show("คำสั่ง ลงวันที่");
									th_show("หมายเหตุ","width:5cm;");
									?>
 
								</tr>
							</thead>
							<tbody> 
                  <?php
  if($salary_up_nums > 0){ 
      while($rec_salary_up = $db->db_fetch_array($query_salary_up)){
 
 $html  =   ""; 
	   $html .= " <tr >
     				<td align='center' valign='top' style=' border:solid 1px #000000;' >".conv_date($rec_salary_up['COM_SDATE'],'short')."</td>
                    <td align='left' valign='top' style=' border:solid 1px #000000;' > ".text(wordwrap($rec_salary_up['MOVEMENT_NAME_TH'],45, ' ',true))."  </td>";
	   $html .= " 	<td align='right' valign='top' style=' border:solid 1px #000000;' >".number_format($rec_salary_up['COMPENSATION_5'],2)."</td> ";
	   $html .= " 	<td align='left' valign='top' style=' border:solid 1px #000000;' >(".text(wordwrap($rec_salary_up['CT_NAME_TH'],45, ' ',true));
	   if($rec_salary_up['COM_NO']!=""){
	   	$html .= " ที่<br/>".text($rec_salary_up['COM_NO']);
	   }
	   if($rec_salary_up['COM_DATE']!=""){
	   	$html .= " 	 ลว. ".conv_date($rec_salary_up['COM_DATE'],'short') ;
	   }
	  $html .= " 	 )</td> 
     				<td align='left' valign='top' style=' border:solid 1px #000000;' >".text(wordwrap($rec_salary_up['SALHIS_NOTE'],45, ' ',true))." </td>		
		</tr> "; 
	    echo $html;
		$i++;
		$end_date_temp2 = $end_date_temp;
					  }
				  }else{
                                 tr_show_no_found($arr_txt['data_not_found'],5); 
				  }
				  ?>
                  </tbody>
                </table>
               </div>
           </div>	
        
<?php } // if($S_PENSION_IDCARD != ''){	?>       

  
          
            <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();"><?php echo switchPic($path,"switchPic6", "0");?> ประวัติการฝึกอบรม</a>
			</div>
            
			<div id="collapse6" class="collapse in">
            
<?php
				$sql_dev = " SELECT TRAINHIS_COURSE_NAME,TRAINHIS_EDATE,TRAINHIS_ORG_NAME  FROM PER_TRAINHIS WHERE PER_ID =  '".$PER_ID."' ";
				$query_dev = $db->query($sql_dev);
				$num_dev = $db->db_num_rows($query_dev);
?>
            	<div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="40%"><div align="center"><strong>หลักสูตรฝึกอบรม</strong></div></th>
 

                          <th width="15%"><div align="center"><strong>วันที่มีผลบังคับใช้ <br/>( วัน เดือน ปี )</strong></div></th>
                          <th width="15%"><div align="center"><strong>หน่วยงานที่จัดการฝึกอบรม</strong></div></th>
                      </tr>
                  </thead>
                  <tbody>
                  <?php
				  if($num_dev > 0)
				  {
					  while($rec_dev = $db->db_fetch_array($query_dev))
				      { //while
				  ?>
                  <tr bgcolor="#FFFFFF">
                         <td align="left" valign="top"><?php   echo text($rec_dev['TRAINHIS_COURSE_NAME']); ?></td>
                  		<td align="center" valign="top"><?php echo  conv_date($rec_dev['TRAINHIS_EDATE'],'short'); ?> </td>
                  		<td align="center" valign="top"><?php   echo  text($rec_dev['TRAINHIS_ORG_NAME']); ?> </td>
                	</tr>
                  <?php
					  } // end while 
				  }else
				  {
                                 tr_show_no_found($arr_txt['data_not_found'],4); 
				  }
				  ?>
                  </tbody>
                </table> 
                	
              </div>
            
            </div>
            


          
           
            <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();"><?php echo switchPic($path,"switchPic3", "0");?> การได้รับโทษทางวินัยและการนิรโทษกรรม</a>
			</div>
			<div id="collapse3" class="collapse in">
 <?php
				$sql_punis = " select * from PER_PUNISHMENT a
								LEFT JOIN SETUP_CRIME_MAIN c on a.INFORM_CRIME_ID = c.CRIME_ID
								LEFT JOIN SETUP_PUNNISH e on   a.FINAL_PUNISH_ID  = e.PUNISH_ID
  								WHERE a.DELETE_FLAG = 0 AND  a.PER_ID = '".$PER_ID."' ";
				$query_punis = $db->query($sql_punis);
				$num_punis = $db->db_num_rows($query_punis);
?>
            	<div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                  <thead>
                      <tr class="bgHead">
                          <th width="10%"><div align="center"><strong>พ.ศ.</strong></div></th>
                          <th width="65%"><div align="center"><strong>รายการ</strong></div></th>
                          <th width="25%"><div align="center"><strong>เอกสารอ้างอิง</strong></div></th>
                      </tr>
                  </thead>
                  <tbody>
 <?php
				  if($num_punis > 0){
					  while($rec_punis = $db->db_fetch_array($query_punis))
					  { //while 
?>
                  <tr bgcolor="#FFFFFF">
                      <td align="center" valign="top"><?php echo ($rec_punis['FINAL_DATE']+543); ?></td>
                      <td align="left" valign="top"><?php echo text($rec_punis['PUNISH_NAME_TH']); ?> </td>
                      <td align="left" valign="top">
                      <div> <strong>เลขที่คำร้อง</strong> <?php echo $rec_punis['FINAL_NO'].""; ?> </div>
                      <div> <strong>ลงวันที่</strong> <?php echo conv_date($rec_punis['FINAL_DATE'],'short'); ?> </div>
                    </td>
                	</tr>
                  <?php
					  } //end while 
				  }else
				  {
                                 tr_show_no_found($arr_txt['data_not_found'],3); 
				  }
				  ?>
                  </tbody>
                </table>
                	
              </div>
            </div>	


<?php /*
           <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();"><?php echo switchPic($path,"switchPic4", "0");?> วันที่ไม่ได้รับเงินเดือนหรือได้รับเงินเดือนไม่เต็ม หรือวันที่มิได้ประปฏิบัติหน้าที่อยู่ในเขตที่ได้มีประกาศใช้กฏอัยการศึก</a>
			</div> 
           <div id="collapse4" class="collapse in">
           <?php
		    $sql_miss = "SELECT * FROM PER_MISSSALHIS WHERE  DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."' ";
			$query_miss = $db->query($sql_miss);
			$rec_miss = $db->db_fetch_array($query_miss);
			$num_miss = $db->db_num_rows($query_miss);
		   ?>
           		<div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="15%"><div align="center"><strong>ตั้งแต่ - ถึง (วัน เดือน ปี)</strong></div></th>
                            <th width="60%"><div align="center"><strong>รายการ</strong></div></th>
                            <th width="25%"><div align="center"><strong>เอกสารอ้างอิง</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
					if($num_miss > 0){
					?>
                     <tr bgcolor="#FFFFFF">
                      <td align="center" valign="top"><?php echo conv_db($rec_miss['MISS_SDATE'],'short'); ?> - <?php echo conv_db($rec_miss['MISS_EDATE'],'short'); ?> </td>
                      <td align="left" valign="top"><?php echo $detial; ?> </td>
                      <td align="left" valign="top"></td>
                	</tr>
                    <?php
					}else{
						echo "<tr><td align=\"center\" colspan=\"3\"  style='background-color:#DAEDF4;'>ไม่พบข้อมูล</td></tr>";
					}
					?>
                    </tbody>
                  </table>
               </div>
           </div> 
     




           <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onClick="$('.switchPic5').toggle();"><?php echo switchPic($path,"switchPic5", "0");?> ตำแหน่งและเงินเดือน</a>
			</div> 
            <div id="collapse5" class="collapse in">
            <?php
			 $sql_position = "SELECT A.COM_DATE, A.COM_SDATE, A.COM_NO, B.MOVEMENT_TYPE, C.LINE_NAME_TH,  G.ORG_NAME_TH AS ORG_NAME_3, H.ORG_NAME_TH AS ORG_NAME_4,
			 E.MANAGE_NAME_TH, A.POS_NO, B.MOVEMENT_NAME_TH, D.LEVEL_NAME_TH, A.SALARY
			 FROM V_PROFILE_STORY A
			 LEFT JOIN SETUP_MOVEMENT B ON A.MOVEMENT_ID = B.MOVEMENT_ID
			 LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID
			 LEFT JOIN SETUP_POS_LEVEL D ON A.LEVEL_ID = D.LEVEL_ID
			 LEFT JOIN SETUP_POS_MANAGE E ON A.MANAGE_ID = E.MANAGE_ID
			 LEFT JOIN SETUP_ORG G ON A.ORG_ID_3 = G.ORG_ID
			 LEFT JOIN SETUP_ORG H ON A.ORG_ID_4 = H.ORG_ID
			 WHERE PER_ID = '".$PER_ID."' ORDER BY COM_SDATE ASC ";
			 $query_position = $db->query($sql_position);
			 $num_position = $db->db_num_rows($query_position)
			?>
            	<div class="table-responsive">
                	<table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="10%"><div align="center"><strong>วัน เดือน ปี</strong></div></th>
                            <th width="30%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
                            <th width="7%"><div align="center"><strong>เลขที่<br/>ตำแหน่ง</strong></div></th>
                            <th width="7%"><div align="center"><strong>ตำแหน่ง<br/>ประเภท</strong></div></th>
                            <th width="7%"><div align="center"><strong>ระดับ</strong></div></th>
                            <th width="7%"><div align="center"><strong>เงินเดือน</strong></div></th>
                            <th width="7%"><div align="center"><strong>เงินประจำ<br/>ตำแหน่ง</strong></div></th>
                            <th width="15%"><div align="center"><strong>เอกสารอ้างอิง</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
					if($num_position > 0){
						while($rec_position = $db->db_fetch_array($query_position)){
							$detail_position = "";
							$refer = "";
							$detail_position .= "<div>".text($rec_position['MOVEMENT_NAME_TH'])."</div>";
							$detail_position .= "<div><strong>ตำแหน่ง : </strong>".text($rec_position['LINE_NAME_TH'])."</div>";
							$detail_position .= "<div><strong>ตำแหน่งทางการบริหาร (ถ้ามี) : </strong>".text($rec_position['MANAGE_NAME_TH'])."</div>";
							$detail_position .= "<div><strong>สำนัก : </strong>".text($rec_position['ORG_NAME_3'])."</div>";
							$detail_position .= "<div><strong>กลุ่มงาน : </strong>".text($rec_position['ORG_NAME_4'])."</div>";
							
							$refer .= "<div><strong>เลขที่คำสั่ง : </strong> ".text($rec_position['COM_NO'])."</div>";
							$refer .= "<div><strong>ลงวันที่ : </strong> ".conv_date($rec_position['COM_SDATE'],'short')."</div>";
							
							
					?>
                    <tr bgcolor="#FFFFFF">
                      <td align="center" valign="top"><?php echo conv_date($rec_position['COM_SDATE'],'short'); ?></td>
                      <td align="left" valign="top" ><?php echo $detail_position; ?></td>
                      <td align="center" valign="top"><?php echo $rec_position['POS_NO']; ?></td>
                      <td align="center" valign="top"><?php echo $rec_position['POS_NO']; ?></td>
                      <td align="center" valign="top"><?php echo text($rec_per['TYPE_NAME_TH']); ?></td>
                      <td align="right" valign="top"><?php echo number_format($rec_position['SALARY'],2); ?></td>
                      <td align="right" valign="top"><?php echo number_format($rec_position['PER_SALARY_POSITION'],2); ?></td>
                      <td align="left" valign="top" ><?php echo $refer; ?></td>
                    
                	</tr>
                    <?php
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"6\"  style='background-color:#DAEDF4;'>ไม่พบข้อมูล</td></tr>";
					}
					?>
                    </tbody>
                  </table>
                </div>
           </div> 
           
*/ ?>  
           
           
          <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();"><?php echo switchPic($path,"switchPic6", "0");?> ประวัติการรับพระราชทานเครื่องราชอิสริยาภรณ์</a>
			</div> 
            <div id="collapse6" class="collapse in">
<?php
			$field=" a.DEH_ID, a.DEH_SEQ, a.DEH_GAZZETTE_DATE, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE, b.DEF_NAME_TH, c.DEC_NAME_TH, 
					 a.ACTIVE_STATUS, a.DEH_GAZZETTE_BOOK, a.DEH_GAZZETTE_PART, a.DEH_GAZZETTE_PAGE, a.DEH_SEQ, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE ";
			$table=" PER_DECORATEHIS  a
					 LEFT JOIN SETUP_DECORATION_FAMILY b ON a.DEF_ID=b.DEF_ID
					 LEFT JOIN SETUP_DECORATION c ON a.DEC_ID=c.DEC_ID ";
			$orderby=" order by a.ACTIVE_STATUS DESC, a.DEH_SEQ DESC ";
			
			$sql_decorate = "select ".$field." from ".$table." where a.PER_ID = '".$PER_ID."' AND a.DELETE_FLAG = '0' ".$orderby;
			$query_decorate = $db->query($sql_decorate);
			$num_decorate = $db->db_num_rows($query_decorate); 
?>
            	<div class="table-responsive">
                	<table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="10%"><div align="center"><strong>วัน เดือน ปี</strong></div></th>
                            <th width="30%"><div align="center"><strong>เครื่องราชอิสริยาภรณ์ที่ได้รับ</strong></div></th>
                            <th width="17%"><div align="center"><strong>ตามประกาศราชกิจจา</strong></div></th>
                            <th width="7%"><div align="center"><strong>วันเดือนปี ที่รับ</strong></div></th>
                            <th width="7%"><div align="center"><strong>วันเดือนปี ที่ส่งคืน</strong></div></th> 
                        </tr>
                    </thead>
                    <tbody>
<?php
					if($num_decorate > 0){
						while($rec_decorate = $db->db_fetch_array($query_decorate)){
		                $book_detail = "เล่มที่  ".$rec_decorate["DEH_GAZZETTE_BOOK"]." ตอนที่ ".$rec_decorate["DEH_GAZZETTE_PART"];
						$book_detail .= " หน้าที่ ".$rec_decorate["DEH_GAZZETTE_PAGE"]." ลำดับที่ ".$rec_decorate["DEH_SEQ"]."";
?>
                    <tr bgcolor="#FFFFFF">
                         <td align="center" valign="top"><?php echo conv_date($rec_decorate["DEH_GAZZETTE_DATE"],'short'); ?></td>
                         <td align="left" valign="top"><?php echo  text($rec_decorate["DEC_NAME_TH"]); ?></td>
                         <td align="center" valign="top"><?php echo $book_detail; ?></td>
                         <td align="center" valign="top"><?php echo conv_date($rec_decorate["DEH_RECEIVE_DATE"],'short'); ?></td>
                         <td align="center" valign="top"><?php echo conv_date($rec_decorate["DEH_RETURN_DATE"],'short'); ?></td>
                	</tr>
                    <?php
						}
					}else{
                                 tr_show_no_found($arr_txt['data_not_found'],5); 
					}
					?>
                    </tbody>
                  </table>
                </div>
           </div> 
           

          <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onClick="$('.switchPic7').toggle();"><?php echo switchPic($path,"switchPic7", "0");?> จำนวนวันลาหยุดราชการ ขาดราชการ มาสาย</a>
			</div> 
            <div id="collapse7" class="collapse in">
<?php
 
			$field=" * ";
			$table=" PER_LEAVEHIS ";
			$pk_id="LEAVEHIS_ID";
			$wh=" PER_ID = '".$PER_ID."' {$filter} ";
			$orderby="order by LEVEHIS_ID DESC ";
			$notin = $wh;
			$sql_leave = "select top {$page_size} ".$field." from ".$table." where ".$notin;


			$query_leave = $db->query($sql_leave);
			$num_leave = $db->db_num_rows($query_leave);
 ?>
            	<div class="table-responsive">
                	<table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr class="bgHead">
                            <th width="10%"><div align="center"><strong>พ.ศ.</strong></div></th>
                            <th width="10%"><div align="center"><strong>ลาป่วย ( วัน )</strong></div></th>
                            <th width="10%"><div align="center"><strong>ลากิจและพักผ่อน  ( วัน )</strong></div></th>
                            <th width="10%"><div align="center"><strong>มาสาย  ( วัน )</strong></div></th>
                            <th width="10%"><div align="center"><strong>ขาดราชการ  ( วัน )</strong></div></th>
                            <th width="10%"><div align="center"><strong>ลาศึกษาต่อ  ( วัน )</strong></div></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
					if($num_decorate > 0){
						while($rec_leave = $db->db_fetch_array($query_leave))
						{ //while 
?>
                    <tr bgcolor="#FFFFFF">
          
                       <td align="center" valign="top"><?php echo text($rec_leave["LEAVEHIS_YEAR"]); ?> </td>
                      <td align="center" valign="top"><?php echo number_format($rec_leave["LEAVEHIS_SICK_DAY"],2); ?></td>
<?php 					$private_relax = ($rec_leave["LEAVEHIS_PRIVATE_DAY"]+ $rec_leave["LEAVEHIS_RELAX_DAY"]); ?>
                      <td align="center" valign="top"><?php echo number_format($private_relax,2); ?> </td>
                      <td align="center" valign="top"> <?php echo number_format($rec_leave["LEAVEHIS_LATE_DAY"],2); ?></td>
                      <td align="center" valign="top"><?php echo number_format($rec_leave["LEAVEHIS_WITHOUT_DAY"],2); ?> </td>
                       <td align="center" valign="top"><?php echo number_format($rec_leave["LEAVEHIS_STUDY_DAY"],2); ?> </td>
       
                                                
                	</tr>
 <?php
						}
					}else
					{
                                 tr_show_no_found($arr_txt['data_not_found'],6); 
					}
?>
                    </tbody>
                  </table>
 
                  
                </div>
           </div> 
           


            <div class="row head-form"><a data-toggle="collapse" data-parent="#accordion" href="#collapse001" onClick="$('.switchPic001').toggle();"><?php echo switchPic($path,"switchPic21", "0");?> ประวัติข้อมูลส่วนบุคคล</a></div>
			<div id="collapse001" class="collapse in"> 
<?php
$field=" PADD_ID, PADD_TYPE, PADD_ROOM_NO, PADD_FLOOR, PADD_BUILDING, PADD_HOME_NO, PADD_MOO, PADD_VILLAGE, PADD_SOI, PADD_ROAD, 
		 PADD_TAMB_ID, PADD_AMPR_ID, PADD_PROV_ID, PADD_POSTCODE, PADD_TEL, PADD_TEL_EXT, PADD_FAX, PADD_FAX_EXT, PADD_MOBILE";	
$table=" PER_ADDRESS";
$orderby=" order by PADD_ID ASC";

$sql = "select ".$field." from ".$table." where DELETE_FLAG = '0'  AND PER_ID = '".$PER_ID."'".$orderby; //echo $sql; exit();
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
?>
            
                        <table class="table table-bordered table-striped table-hover table-condensed">
                            <thead>
                                <tr class="bgHead">
                            
                                    <th width="12%"><div align="center"><strong>ประเภท</strong></div></th>
                                    <th width="24%"><div align="center"><strong>ที่อยู่</strong></div></th>
                                    <th width="16%" nowrap><div align="center"><strong>หมายเลขติดต่อ</strong></div></th>
           
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($nums > 0){
                                $i=1;
                                while($rec = $db->db_fetch_array($query)){
                                    $PADD_ROOM_NO = (trim($rec['PADD_ROOM_NO']) != '') ? 'เลขที่ห้อง '.text($rec['PADD_ROOM_NO']) : '';
                                    $PADD_FLOOR = (trim($rec['PADD_FLOOR']) != '') ? ' ชั้น '.text($rec['PADD_FLOOR']) : '';
                                    $PADD_BUILDING = (trim($rec['PADD_BUILDING']) != '') ? ' อาคาร'.text($rec['PADD_BUILDING']) : '';
                                    $PADD_HOME_NO = (trim($rec['PADD_HOME_NO']) != '') ? '<br>บ้านเลขที่ '.text($rec['PADD_HOME_NO']) : '';
                                    $PADD_MOO = (trim($rec['PADD_MOO']) != '') ? ' หมู่ที่ '.text($rec['PADD_MOO']) : '';
                                    $PADD_VILLAGE = (trim($rec['PADD_VILLAGE']) != '') ? ' หมู่บ้าน'.text($rec['PADD_VILLAGE']) : '';
                                    $PADD_SOI = (trim($rec['PADD_SOI']) != '') ? ' ซอย '.text($rec['PADD_SOI']) : '';
                                    $PADD_ROAD = (trim($rec['PADD_ROAD']) != '') ? ' ถนน'.text($rec['PADD_ROAD']) : '';
									$PADD_TAMB_ID = (!empty($rec['PADD_TAMB_ID'])) ? '<br>ตำบล'.text($arr_tamb[$rec['PADD_TAMB_ID']]) : '';
									$PADD_AMPR_ID = (!empty($rec['PADD_AMPR_ID'])) ? ' อำเภอ'.text($arr_ampr[$rec['PADD_AMPR_ID']]) : '';
									$PADD_PROV_ID = (!empty($rec['PADD_PROV_ID'])) ? ' จังหวัด'.text($arr_prov[$rec['PADD_PROV_ID']]) : '';
									$PADD_POSTCODE = (trim($rec['PADD_POSTCODE']) != '') ? ' '.$rec['PADD_POSTCODE'] : '';
                                    
                                    $ADDRESS = $PADD_ROOM_NO.$PADD_FLOOR.$PADD_BUILDING.$PADD_HOME_NO.$PADD_MOO.$PADD_VILLAGE.$PADD_SOI.$PADD_ROAD.$PADD_TAMB_ID.$PADD_AMPR_ID.$PADD_PROV_ID.$PADD_POSTCODE;
                                    
                                    $PADD_TEL_EXT = (trim($rec['PADD_TEL_EXT']) != '') ? ' ต่อ '.text($rec['PADD_TEL_EXT']) : '';
                                    $PADD_FAX_EXT = (trim($rec['PADD_FAX_EXT']) != '') ? ' ต่อ '.text($rec['PADD_FAX_EXT']) : '';
 
                                    ?>
                                    <tr bgcolor="#FFFFFF">
                                
                                        <td align="left"><?php echo $arr_address[$rec['PADD_TYPE']];?></td>
                                        <td align="left"><?php echo $ADDRESS;?></td>
                                        <td align="left">โทรศัพท์ <?php echo $rec['PADD_TEL'].$PADD_TEL_EXT;?><br>โทรสาร <?php echo $rec['PADD_FAX'].$PADD_FAX_EXT;?><br>โทรศัพท์เคลื่อนที่ <?php echo $rec['PADD_MOBILE'];?></td>
                        
                                    </tr>
                                    <?php 
                                    $i++;
                                }
                            }else{
                                 tr_show_no_found($arr_txt['data_not_found'],3); 
                            }
                            ?>
                            </tbody>
                        </table>
            
            </div>



   
           

			</form>
		</div>
	</div>

</div>	<?php include_once("report_footer.php"); ?>
</body>
</html>