<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}
$paramlink = url2code($link);
//POST
$PER_ID=$_POST['PER_ID'];
$EDU_ID=$_POST['EDU_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"); 

//DATA
$sql = "SELECT EDU_ID,PER_ID,EDU_SEQ,EL_ID,ED_ID,EM_ID,INS_ID,COUNTRY_ID,EDU_GPA,EDU_HORNOR,EDU_SDATE,EDU_EDATE,EDU_SCHOLARSHIP,EDU_TYPE, EDU_NOTE,ACTIVE_STATUS
FROM PER_EDUCATEHIS  where DELETE_FLAG = '0' AND EDU_ID = '".$EDU_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$COUNTRY_ID = empty($rec['COUNTRY_ID'])?$default_country_id:$rec['COUNTRY_ID'];
$EL_ID = $rec['EL_ID'];

//ประเทศ
$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");

//ระดับการศึกษา
$sql_edu="select EL_ID,EL_GROUP, EL_NAME_TH, EL_TYPE from SETUP_EDU_LEVEL where ACTIVE_STATUS='1' and DELETE_FLAG='0' order by EL_TYPE, EL_ID";
$query_edu=$db->query($sql_edu);
//วุฒิการศึกษา
$sql_degree = "select ED_ID , ED_NAME from V_SETUP_EDU_DEGREE a left join SETUP_EDU_LEVEL b on a.EL_GROUP=b.EL_GROUP WHERE a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND (b.EL_ID= '".$EL_ID."') ORDER BY SEQ_TYPE,SEQ_TH_EN "; 
//สาขาวิชาเอก
$arr_edu_major=GetSqlSelectArray("EM_ID", "EM_NAME", "V_SETUP_EDU_MAJOR", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND SEQ_TYPE != 3", "SEQ_TYPE, SEQ_TH_EN"); 
//สถานศึกษา
$arr_edu_ins=GetSqlSelectArray("INS_ID", "INS_NAME", "V_SETUP_EDU_INSTITUTE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND SEQ_TYPE != 3", "SEQ_TYPE, SEQ_TH_EN"); 
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
<script src="js/profile_educatehis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	 
      <li><a href="profile_educatehis_disp.php?<?php echo url2code($link2); ?>">ประวัติการศึกษา</a></li>
	  <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
     
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="EDU_ID" name="EDU_ID"  value="<?php echo $EDU_ID; ?>">

        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ระดับการศึกษา : &nbsp; </div>
            <div class="col-xs-12 col-sm-3">
                 
                    <?php 
                    $t="";
                    while($rec_edu = $db->db_fetch_array($query_edu)){  
                        if($t!=$rec_edu['EL_TYPE']){
                            //echo ($t!=''?"":"</optgroup>");
                            //echo "<optgroup label='".$arr_edu_level_m[$rec_edu['EL_TYPE']]."'>";
                            $t=$rec_edu['EL_TYPE'];
                        } 
                        ?> <?php  if($rec_edu['EL_ID']==$rec['EL_ID']){ echo text($rec_edu['EL_NAME_TH']); }  
                    }
                    ?>
                 
            </div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2">วุฒิการศึกษา : &nbsp; </div>
            <div class="col-xs-12 col-sm-3">
                <span id="ss_edu_degree"><?php  echo get_Select_v($sql_degree ,$db , array(
                    'id'=>'ED_ID',
                    'name'=>'ED_ID',
                    'class'=>'form-control selectbox',
                    's_selected'=>$rec["ED_ID"],
                    's_defualt'=>'',
                    's_key'=>'ED_ID', 
                    's_value'=>'ED_NAME',
                    's_onchage'=>'',
                    's_placeholder'=>'วุฒิการศึกษา',
                    's_style'=>""
                    )
                    ); ?>
                </span>
            </div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">สาขาวิชาเอก : &nbsp; </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('EM_ID','EM_ID',$arr_edu_major,'สาขาวิชาเอก',$rec['EM_ID'],'','','1');?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2">สถาบันการศึกษา : &nbsp; </div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('INS_ID','INS_ID',$arr_edu_ins,'สถาบันการศึกษา',$rec['INS_ID'],'','','1');?></div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ประเทศ : &nbsp; </div>
            <div class="col-xs-12 col-sm-2"><?php  echo GetHtmlSelect_v('COUNTRY_ID','COUNTRY_ID',$arr_country,'ประเทศ',$COUNTRY_ID,'','','1');?></div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ผลการเรียนเฉลี่ย : </div>
            <div class="col-xs-12 col-sm-2"><?php echo text(number_format($rec['EDU_GPA'],2)); ?></div>
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-2">สถานะของเกียรตินิยม : &nbsp; </div>
            <div class="col-xs-12 col-sm-2">
                 
                    <?php foreach($arr_act_honor as $key => $value){
					   if($rec['EDU_HORNOR'] == $key){
					     echo $value;
					   } ?>
                    
                    <?php } ?>
                
            </div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่เริ่มศึกษา : </div>
            <div class="col-xs-12 col-sm-2">
                <div class="input-group">
               <?php echo conv_date($rec["EDU_SDATE"],'short');?>
                 </div>	
            </div> 
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่สำเร็จการศึกษา : </div>
            <div class="col-xs-12 col-sm-2">
                <div class="input-group">
                     <?php echo conv_date($rec["EDU_EDATE"],'short');?> 
                </div>	
            </div> 
        </div>
                
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">สถานะของการได้รับทุน : &nbsp;</div>
            <div class="col-xs-12 col-sm-3">
            <label ><input type="radio" id="EDU_SCHOLARSHIP1" disabled name="EDU_SCHOLARSHIP" value="1" <?php echo ($rec['EDU_SCHOLARSHIP']=='1'||$rec['EDU_SCHOLARSHIP']=='' ?"checked":"")?>>  <?php echo $arr_scholarship['1'];?></label>&nbsp;&nbsp;
            <label ><input type="radio" id="EDU_SCHOLARSHIP2" disabled name="EDU_SCHOLARSHIP" value="2" <?php echo ($rec['EDU_SCHOLARSHIP']=='2'?"checked":"")?>>  <?php echo $arr_scholarship['2'];?></label></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2">ประเภทของวุฒิการศึกษา : &nbsp; </div>
            <div class="col-xs-12 col-sm-3">
             
                <?php foreach($arr_edu_type as $key => $value){ 
				       if($rec['EDU_TYPE'] == $key){
					     echo $value;
					   }
					   ?>
                     
                <?php } ?>
             
            </div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">หมายเหตุ : </div>
            <div class="col-xs-12 col-sm-3"><?php echo text($rec['EDU_NOTE']); ?></div>
        </div>
         
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?> :&nbsp;&nbsp;</div>
            <div class="col-xs-12 col-md-2">
            <label ><input type="radio" id="ACTIVE_STATUS1" disabled name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
            <label ><input type="radio" id="ACTIVE_STATUS0" disabled name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
        </div>
              
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>