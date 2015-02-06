<?php
//header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 
$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	//$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	//$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	//$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}

//echo "On Debuging <pre>"; print_r($_POST); 

//POST
$PER_ID=(int)$_POST['PER_ID'];
//$POSHIS_ID=$_POST['POSHIS_ID'];
$PUN_ID = (int)$_POST['PUN_ID'];
 
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 
$arr_punnish2 = GetSqlSelectArray2(" a.PUNISH_ID", " a.PUNISH_NAME_TH", "SETUP_PUNNISH as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0'  ", "a.PUNISH_SEQ");
//ประเภทการเคลื่อนไหว
$arr_mov_type = GetSqlSelectArray("MOVEMENT_ID", "MOVEMENT_NAME_TH", "SETUP_MOVEMENT", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND  MOVEMENT_GROUP = 4 ","MOVEMENT_NAME_TH");
$arr_ct_type = GetSqlSelectArray("CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE A LEFT JOIN SETUP_LAW_TYPE B ON A.LT_ID = B.LT_ID ", " A.DELETE_FLAG='0' "," B.LT_SEQ DESC, A.CT_NAME_TH ASC "); 

$field="*";
$table="PER_PUNISHMENT a
LEFT JOIN SETUP_CRIME_MAIN c on a.INFORM_CRIME_ID = c.CRIME_ID
LEFT JOIN SETUP_PUNNISH e on   a.FINAL_PUNISH_ID  = e.PUNISH_ID";
$pk_id="a.PUN_ID";
$orderby="";

$sql = "select ".$field." from ".$table." where a.DELETE_FLAG = 0 AND  a.PUN_ID = '".$PUN_ID."' ".$orderby; // echo $sql;
$query_pen = $db->query($sql);
$rec = $db->db_fetch_array($query_pen);



?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
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
<script src="js/profile_punishment_form.js?<?php echo rand(); ?>"></script>
</head>
<body>

<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li><a href="profile_punishment_disp.php?<?php echo url2code($link2); ?>">ประวัติการรับโทษทางวินัย</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content">
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
     <div class="clearfix"></div>
   	 <form id="frm-input" method="post" action="process/profile_punishment_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="PUN_ID" name="PUN_ID" value="<?php echo $PUN_ID?>">
        <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID;?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
		<input type="hidden" id="flagDup1" name="flagDup1">
          <div class="row ">
    
                    <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                                    <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                                    <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                                  	โทษทางวินัย
                                </a>
                            </div>
                        </div>
                        
                        <div id="collapse1" class="collapse in">
        <div class="row formSep">
        	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทคำสั่ง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('CT_ID','CT_ID',$arr_ct_type,'ประเภทคำสั่ง',$rec['FINAL_CT_ID'],'"','','1');?></div> 
                <div class="col-xs-12 col-sm-1"></div>
            	<div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทการเคลื่อนไหว : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('MOVEMENT_ID','MOVEMENT_ID',$arr_mov_type,'ประเภทการเคลื่อนไหว',$rec['FINAL_MOVEMENT_ID'],'','','1');?></div> 
        </div>
        <div class="row formSep">  
        	    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่  :  <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-3"><input type="text" id="FINAL_NO" name="FINAL_NO" class="form-control" placeholder="เลขที่" maxlength="100" value="<?php echo text($rec['FINAL_NO']); ?>"  onKeyUp="chkDup('chkDup1','flagDup1','FINAL_NO','FINAL_NO','PER_PUNISHMENT','');"   >   
            <span id="chkDup1" class=" hidden-xs label"></span>  </div><div class="col-xs-12 col-md-1"></div>		
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ลงวันที่ :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <input type="text" id="COM_DATE" name="COM_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["FINAL_DATE"]==''?'':conv_date(text($rec["FINAL_DATE"]),''); ?>"  >
                    <span class="input-group-addon datepicker" for="COM_DATE">&nbsp;
                        <span id="sdate" class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
                </div>
        </div>
        <div class="row formSep">
        	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่บันทึก :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <input type="text" id="POSHIS_DATE" name="POSHIS_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["FINAL_SDATE"]==''?'':conv_date(text($rec["FINAL_SDATE"]),''); ?>" >
                    <span class="input-group-addon datepicker" for="POSHIS_DATE">&nbsp;
                        <span id="sdate" class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
                </div>
                 <div class="col-xs-12 col-md-2"></div>
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">วันที่มีผล :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">				
                <div class="input-group">
                    <input type="text" id="COM_SDATE" name="COM_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="<?php echo $rec["FINAL_EDATE"]==''?'':conv_date(text($rec["FINAL_EDATE"]),''); ?>" >
                    <span class="input-group-addon datepicker" for="COM_SDATE">&nbsp;
                        <span id="sdate" class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>
                </div>
                </div>
                <div class="row formSep">
                		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">โทษทางวินัยที่เห็นสมควร :  &nbsp;<span style="color:red;">*</span><span style="color:red;"></span></div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect('PUNISH_ID','PUNISH_ID',$arr_punnish2,'โทษทางวินัยที่เห็นสมควร',$rec['PUNISH_ID'],'','','1','','1');?></div><div class="col-xs-12 col-sm-1"></div>
            
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">
            <?php /*
            สถานะของการบันทึก :&nbsp;<span style="color:red;"></span>&nbsp;</div>
                                    <div class="col-xs-6 col-md-1"><label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS"  value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> ปกติ</label></div>
                                    <div class="col-xs-6 col-md-1"><label ><input type="radio" id="ACTIVE_STATUS2" name="ACTIVE_STATUS" value="2" <?php echo ($rec['ACTIVE_STATUS']=='2'?"checked":"")?> > ยกเลิก</label>
			*/ ?>						
									</div>
                                </div>
                 <div class="row formSep">
                 		<div class="col-xs-12 col-sm-2" style="white-space:nowrap">หมายเหตุ :</div>
                                <div class="col-xs-12 col-sm-8"><textarea id="POSHIS_NOTE" name="POSHIS_NOTE" class="form-control" placeholder="หมายเหตุ" maxlength="255"  ><?php echo  text(trim($rec["FINAL_PUNISH_NOTE"]));?></textarea></div> 		
                 </div>
				</div>
                     
 
        </div>
                      
       
                </div>
                             
                   
        <br>
          <div class="row">
        <div class="col-xs-12 col-sm-12" align="center">
			<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
			<button type="button" class="btn btn-default" onClick="self.location.href='profile_punishment_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        </div>
        <br>
    </form>
</div>
</div>
   <div style="text-align:center;width: 100%;
    height: 120px;
    position: relative;
    z-index: 1;bottom:0px;
">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>

</body>
</html>