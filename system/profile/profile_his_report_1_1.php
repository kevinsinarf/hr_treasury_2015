<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

//POST
$S_PENSION_IDCARD = trim($_POST['S_PENSION_IDCARD']);

if($S_PENSION_IDCARD != ''){
	
	//ข้อมูลส่วนตัว
	
	$sql_per = " SELECT A.PER_ID, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_DATE_BIRTH, A.PER_DATE_ENTRANCE, 
	A.PER_DATE_OCCUPLY, A.PER_DATE_RETIRE, B.ORG_NAME_TH AS ORG_NAME_1, C.ORG_NAME_TH AS ORG_NAME_2, D.CV_NAME_TH  ,A.PER_FILE_PIC ,E.TYPE_NAME_TH, A.PER_SALARY_POSITION 
	FROM PER_PROFILE A
	LEFT JOIN SETUP_ORG B ON A.ORG_ID_1 =  B.ORG_ID
	LEFT JOIN SETUP_ORG C ON A.ORG_ID_2 = C.ORG_ID
	LEFT JOIN ANNOUNCE_SETUP_CIVIL_TYPE D ON A.CV_ID = D.CV_ID
  	LEFT JOIN SETUP_POS_TYPE E ON A.TYPE_ID = E.TYPE_ID
	WHERE A.PER_IDCARD = '".str_replace('-','',$S_PENSION_IDCARD)."' AND A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0 AND A.POSTYPE_ID = 1 ";
	
	$query_per = $db->query($sql_per);
	$num_per = $db->db_num_rows($query_per);
	$rec_per = $db->db_fetch_array($query_per);
	$PER_ID = $rec_per['PER_ID'];
	$PER_NAME = Showname($rec_per["PREFIX_ID"],$rec_per["PER_FIRSTNAME_TH"],$rec_per["PER_MIDNAME_TH"],$rec_per["PER_LASTNAME_TH"]);
	
	//คู่สมรส
	$sql_mate ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
	FROM PER_FAMILY 
	WHERE FAMILY_RELATIONSHIP = '3' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  
	ORDER BY MARRY_SEQ DESC ";
	$query_mate = $db->query($sql_mate);
	$rec_mate = $db->db_fetch_array($query_mate);
	$MATE_NAME = Showname($rec_mate["FAMILY_PREFIX_ID"],$rec_mate["FAMILY_FIRSTNAME_TH"],$rec_mate["FAMILY_MIDNAME_TH"],$rec_mate["FAMILY_LASTNAME_TH"]);
	
	//บิดา
	$sql_father ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
	FROM PER_FAMILY 
	WHERE FAMILY_RELATIONSHIP = '1' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  ";
	
	$query_father = $db->query($sql_father);
	$rec_father = $db->db_fetch_array($query_father);
	$FATHER_NAME = Showname($rec_father["FAMILY_PREFIX_ID"],$rec_father["FAMILY_FIRSTNAME_TH"],$rec_father["FAMILY_MIDNAME_TH"],$rec_father["FAMILY_LASTNAME_TH"]);
	
	//มารดา
	$sql_mother ="SELECT TOP 1 FAMILY_PREFIX_ID, FAMILY_FIRSTNAME_TH, FAMILY_MIDNAME_TH, FAMILY_LASTNAME_TH
	FROM PER_FAMILY 
	WHERE FAMILY_RELATIONSHIP = '2' AND ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."'  ";
	
	$query_mother = $db->query($sql_mother);
	$rec_mother = $db->db_fetch_array($query_mother);
	$MOTHER_NAME = Showname($rec_mother["FAMILY_PREFIX_ID"],$rec_mother["FAMILY_FIRSTNAME_TH"],$rec_mother["FAMILY_MIDNAME_TH"],$rec_mother["FAMILY_LASTNAME_TH"]);
    $gov_type = text($rec_per['CV_NAME_TH']);//"ข้าราชการรัฐสภาสามัญ";
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
<script src="js/profile_his_report_1_1.js?<?php echo rand(); ?>"></script>

</head>
<body <?php echo $remove;?>>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><a href="profile_his_report_disp.php?<?php echo $paramlink; ?>"><?php echo showMenu($menu_sub_id); ?></a></li>
            <li class="active">รายงาน ก.พ. 7</li>
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
                
				<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();"><?php echo switchPic($path,"switchPic1", "0");?> รายงาน ก.พ. 7</a>
				</div>
				<div id="collapse1" class="collapse in">
                  <div class="row formSep">
                      <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['idcard']; ?> :&nbsp;<span style="color:red;">*</span></div>
                      <div class="col-xs-12 col-md-3">
                        <input type="text" id="S_PENSION_IDCARD" name="S_PENSION_IDCARD" class="form-control idcard" value="<?php echo $S_PENSION_IDCARD; ?>" style="display:inline-table; width:200px; margin-right:5px;">
                        <button type="button" class="btn btn-primary" onClick="GetPer();">ค้นหา</button>
                       </div>
                       <?php if($num_per > 0){ ?>
                       <div class="col-xs-12 col-md-3">
                         <div class="btn-group">
                          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                          พิมพ์  <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                          <li><a href="#" onClick="print_report('pdf','profile_his_report_1_1_pdf.php');" >พิมพ์แบบ PDF</a></li>
                         <!-- <li><a href="#" onClick="print_report('excel','$PageRep');" >พิมพ์แบบ EXCEL</a></li>
                          <li><a href="#" onClick="print_report('word','$PageRep');" >พิมพ์แบบ WORD</a></li>-->
                          </ul>
                        </div>
                    </div>
                   <?php } ?>
                  </div>
                  
                <div class='row formSep'>
                  <div class='col-xs-12 col-sm-2' >กระทรวง :</div>
                  <div class='col-xs-12 col-sm-3'><?php echo text($rec_per['ORG_NAME_1']); ?></div>
                  <div class='col-xs-12 col-sm-2' >กรม :</div>
                  <div class='col-xs-12 col-sm-3'><?php echo text($rec_per['ORG_NAME_2']);  ?></div>
               </div>  
               
               <div class='row formSep'>
                  <div class='col-xs-12 col-sm-2' >ชื่อ-สกุล :</div>
                  <div class='col-xs-12 col-sm-3'><?php echo $PER_NAME; ?></div>
                  <div class='col-xs-12 col-sm-2' ></div>
                  <div class='col-xs-12 col-sm-3'> </div>
                  
               </div> 
               <div class='row formSep'>
               
                  <div class='col-xs-12 col-sm-2' >ชื่อ-สกุลคู่สมรส :</div>
                  <div class='col-xs-12 col-sm-3'><?php echo $MATE_NAME; ?>   </div>
                  <div class='col-xs-12 col-sm-2' >นามสกุลเดิม</div>
                  <div class='col-xs-12 col-sm-3'> </div>
              </div> 
               
               <div class='row formSep'>
               	  <div class='col-xs-12 col-md-2' >ชื่อ-สกุลบิดา :</div>
                  <div class='col-xs-12 col-md-3'><?php echo $FATHER_NAME; ?>    </div>
                  <div class='col-xs-12 col-md-2' ></div>
                  <div class='col-xs-12 col-md-3'></div>
               </div>
               
               <div class='row formSep'>
                  <div class='col-xs-12 col-md-2' >ชื่อ-สกุลมารดา :</div>
                  <div class='col-xs-12 col-md-3'><?php echo $MOTHER_NAME; ?></div>
                  <div class='col-xs-12 col-md-2' >นามสกุลเดิม</div>
                  <div class='col-xs-12 col-md-3'></div>
               </div>        
               
               
               
               <div class='row formSep'>
                  <div class='col-xs-12 col-md-2' >วัน เดือน ปี เกิด :</div>
                  <div class='col-xs-12 col-md-3'><?php echo conv_date($rec_per['PER_DATE_BIRTH'],'short'); ?></div>
                 <div class='col-xs-12 col-sm-2' >วันบรรจุ :</div>
                  <div class='col-xs-12 col-sm-3'><?php echo conv_date($rec_per['PER_DATE_ENTRANCE'],'short')  ?></div>
               </div>    
               <div class='row formSep'>
                  <div class='col-xs-12 col-md-2' >วันที่เริมปฏิบัติราชการ :</div>
                  <div class='col-xs-12 col-md-3'><?php echo conv_date($rec_per['PER_DATE_ENTRANCE'],'short')  ?></div>
                  <div class='col-xs-12 col-md-2' >วันครบเกษียณอายุ :</div>
                  <div class='col-xs-12 col-md-3'><?php echo conv_date($rec_per['PER_DATE_RETIRE'],'short')  ?></div>
               </div>
               <div class='row formSep'>
               	  <div class='col-xs-12 col-md-2' >ประเภทข้าราชการ :</div>
                  <div class='col-xs-12 col-md-3'><?php echo  $gov_type;  ?></div>
               </div>
     
         
                    
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
				 	WHERE A.PER_ID = '".$PER_ID."' AND A.DELETE_FLAG = 0 AND A.ACTIVE_STATUS = 1 ORDER BY A.EDU_SEQ ASC
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
                      <td align="center"><?php echo conv_date($rec_train['EDU_SDATE'],'short'); ?> - <?php echo conv_date($rec_train['EDU_EDATE'],'short'); ?> </td>
                      <td align="left"><?php echo text($rec_train['ED_NAME_TH']).$majar; ?></td>
                	</tr>
                  <?php
					  }
				  }else{
					  echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
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
					  echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
				  }
				  ?>
                  </tbody>
                </table> 
                	
              </div>
            
            </div>
          
          
            <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();"><?php echo switchPic($path,"switchPic6", "0");?> ประวัติการฝึกอบรม</a>
			</div>
            
			<div id="collapse6" class="collapse in">
            
            <?php
				$sql_dev = " SELECT * FROM PER_TRAINHIS WHERE PER_ID =  '".$PER_ID."' ";
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
				  if($num_dev > 0){
					  while($rec_dev = $db->db_fetch_array($query_dev)){
						   				  ?>
                  <tr bgcolor="#FFFFFF">
                         <td align="left" valign="top"><?php   echo text($rec_dev['TRAINHIS_PROJECT_NAME']); ?></td>

                  		<td align="center" valign="top"><?php echo  conv_date($rec_dev['TRAINHIS_EDATE'],'short'); ?> </td>
                  		<td align="center" valign="top"><?php   echo  text($rec_dev['TRAINHIS_ORG_NAME']); ?> </td>
                	</tr>
                  <?php
					  }
				  }else{
					  echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
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
  where a.DELETE_FLAG = 0 AND  a.PER_ID = '".$PER_ID."' ";
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
					  while($rec_punis = $db->db_fetch_array($query_punis)){
						  //$detial = text($rec_punis['CRIME_NAME_TH'])."(".$arr_penalty_status[$rec_punis['PENALTY_STATUS']].")";
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
					  }
				  }else{
					  echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
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
		    $sql_miss = "SELECT * FROM PER_MISSSALHIS WHERE ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND PER_ID = '".$PER_ID."' ";
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
						echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
					}
					?>
                    </tbody>
                  </table>
               </div>
           </div> 
*/ ?>       
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
						echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
					}
					?>
                    </tbody>
                  </table>
                </div>
           </div> 
           
           
           
           
          <div class="row head-form">				
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse6" onClick="$('.switchPic6').toggle();"><?php echo switchPic($path,"switchPic6", "0");?> ประวัติการรับพระราชทานเครื่องราชอิสริยาภรณ์</a>
			</div> 
            <div id="collapse6" class="collapse in">
            <?php
 
			$field=" a.DEH_ID, a.DEH_SEQ, a.DEH_GAZZETTE_DATE, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE, b.DEF_NAME_TH, c.DEC_NAME_TH, a.ACTIVE_STATUS, a.DEH_GAZZETTE_BOOK, a.DEH_GAZZETTE_PART, a.DEH_GAZZETTE_PAGE, a.DEH_SEQ, a.DEH_RECEIVE_DATE, a.DEH_RETURN_DATE ";
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
		                $book_detail = "เล่มที่  ".$rec_decorate["DEH_GAZZETTE_BOOK"]." ตอนที่ ".$rec_decorate["DEH_GAZZETTE_PART"]." หน้าที่ ".$rec_decorate["DEH_GAZZETTE_PAGE"]." ลำดับที่ ".$rec_decorate["DEH_SEQ"]."";
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
						echo "<tr><td align=\"center\" colspan=\"5\">ไม่พบข้อมูล</td></tr>";
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
						while($rec_leave = $db->db_fetch_array($query_leave)){
 
					?>
                    <tr bgcolor="#FFFFFF">
          
                       <td align="center" valign="top"><?php echo text($rec_leave["LEAVEHIS_YEAR"]); ?> </td>
                      <td align="center" valign="top"><?php echo number_format($rec_leave["LEAVEHIS_SICK_DAY"],2); ?></td>
                      <?php $private_relax = ($rec_leave["LEAVEHIS_PRIVATE_DAY"]+ $rec_leave["LEAVEHIS_RELAX_DAY"]); ?>
                      <td align="center" valign="top"><?php echo number_format($private_relax,2); ?> </td>
                      <td align="center" valign="top"> <?php echo number_format($rec_leave["LEAVEHIS_LATE_DAY"],2); ?></td>
                      <td align="center" valign="top"><?php echo number_format($rec_leave["LEAVEHIS_WITHOUT_DAY"],2); ?> </td>
                       <td align="center" valign="top"><?php echo number_format($rec_leave["LEAVEHIS_STUDY_DAY"],2); ?> </td>
       
                                                
                	</tr>
                    <?php
						}
					}else{
						echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
					}
					?>
                    </tbody>
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