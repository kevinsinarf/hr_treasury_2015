<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

$page_back = "profile_his_out_gov_disp.php";

//POST
$RETYPE_TYPE = $_POST['RETYPE_TYPE'];
$RETIRE_ID = $_POST['RETIRE_ID'];
$sql = "SELECT * 
FROM RETIRE A 
INNER JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID 
WHERE A.RETIRE_ID = '".$RETIRE_ID."'  ";
$query = $db->query($sql);
$recmain = $db->db_fetch_array($query);
$name = text($arr_prefix[$recmain["PREFIX_ID"]]).' '.text($recmain["PER_FIRSTNAME_TH"]).' '.text($recmain["PER_MIDNAME_TH"]).' '.text($recmain["PER_LASTNAME_TH"]);

$sql_com = "SELECT * FROM RETIRE_COMMAND A  JOIN RETIRE B ON A.COM_ID = B.COM_ID WHERE A.RETIRE_ID = '".$RETIRE_ID."'";
$query_com = $db->query($sql_com);
$rec_com = $db->db_fetch_array($query_com);

//ค่าบุคคาลากรจาก RETIRE
$sql_per = "SELECT A.TYPE_ID,B.POS_NO,A.MANAGE_ID,A.LINE_ID,A.LEVEL_ID,B.PER_SALARY,A.ORG_ID_3,A.ORG_ID_4,A.PER_ID, A.RETIRE_BOOK_NO,A.RETIRE_BOOK_DATE,A.RETIRE_BOOK_TITLE,A.RETIRE_RESIGN_DATE,A.RETIRE_NOTE
FROM RETIRE A 
INNER JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID 
WHERE A.RETIRE_ID = '".$RETIRE_ID."' ";
$query_per = $db->query($sql_per);
$rec_per = $db->db_fetch_array($query_per);


$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "V_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_SEQ,PREFIX_NAME_TH"); //คำนำหน้าชื่อ th
//ประเภทคำสั่ง
$arr_ct = GetSqlSelectArray( "CT_ID", "CT_NAME_TH", "SETUP_COMMAND_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0", "CT_NAME_TH" ); 

//ประเภทความเคลื่อนไหว
$arr_mov = GetSqlSelectArray("MOVEMENT_ID" , "MOVEMENT_NAME_TH" ,"SETUP_MOVEMENT","ACTIVE_STATUS = 1 AND DELETE_FLAG= 0 AND MOVEMENT_TYPE = 7","MOVEMENT_NAME_TH");
  
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
<script src="js/profile_his_out_gov_detail.js?<?php echo rand(); ?>"></script>
<style type="text/css">
ul{
  margin:0;
  list-style-type:none;
}
li{
	margin:3px;
}
</style>
</head>
<body>
<div class="container-full">
  <div>
    <?php include($path."include/header.php");?>
  </div>
  <div>
    <?php include($path."include/menu.php");?>
  </div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo "profile_his_out_gov_disp.php"."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?> (ข้อมูลการออกจากราชการ)</a></li>
       <li>รายละเอียด</li>
      
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_his_out_gov_tranfer_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="RETIRE_ID" name="RETIRE_ID"  value="<?php echo $RETIRE_ID;?>">


        <div class="panel-group" id="accordion">
	    	<div class="row formSep">
			<div class="col-xs-12 col-md-2" >เลขที่หนังสือ : </div>
			<div class="col-xs-12 col-md-3">
				<?php echo text($rec_per["RETIRE_BOOK_NO"]); ?>
            </div>
             <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-md-2">ลงวันที่ : </div>
			   <div class="col-xs-12 col-md-2">
             	 <?php echo conv_date($rec_per['RETIRE_BOOK_DATE'],'short');?>
              </div>
             </div> 
            <div class="row formSep">   
			 <div class="col-xs-12 col-md-2 ">เรื่อง : </div>
			  <div class="col-xs-12 col-md-7">
				<?php echo text($rec_per["RETIRE_BOOK_TITLE"]); ?>
               </div>
            </div>
            <div class="row formSep"> 
            <div class="col-xs-12 col-md-2" >ผู้ขอลาออก : </div>
            <div class="col-xs-12 col-md-3">
             <?php echo $name;?>
            </div>
            <div class="col-xs-12 col-md-1"></div>
			<div class="col-xs-12 col-md-2 ">วันที่ขอลาออก : </div>
            <div class="col-xs-12 col-md-2">
			  <?php echo conv_date($rec_per['RETIRE_RESIGN_DATE'],'short');?>
            </div>
           </div>
            <div class="row formSep">
                  <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตำแหน่ง : </div>
                  <div class="col-xs-12 col-md-10" id="position_detial">
                    <table width='100%' border='0' cellspacing='0' cellpadding='0'  >
                    <tbody style=' background-color:transparent;' >
                      <tr height='10px;' >
                        <td align='left' width='42%'>&nbsp;</td>
                        <td width='19%' align='left'>สังกัด :</td>
                        <td width='39%' align='left'>&nbsp;</td>
                      </tr>
                      <tr >
                        <td align='left' ><?php echo $arr_txt['pos_no']; ?> : <?php echo $rec_per['POS_NO']; ?></td>
                        <td align='left' ></td>
                        <td align='left' >สำนัก/กลุ่ม : <?php echo text($arr_setup_org[$recmain['ORG_ID_3']]); ?></td>
                      </tr>
					  <tr>
                        <td align='left' >ประเภทตำแหน่ง :<?php echo text($arr_pos_type[$rec_per['TYPE_ID']]); ?> </td>
                        <td align='left' ></td>
                        <td align='left' >กลุ่มงาน :<?php echo text($arr_setup_org[$rec_per['ORG_ID_4']]); ?></td>
                      </tr>
					  <tr>
                        <td align='left' >ตำแหน่งทางการบริหาร : <?php echo text($arr_type_manage[$rec_per['MANAGE_ID']]); ?></td>
                        <td align='left' ></td>
                        <td align='left' ></td>
                      </tr>
					  <tr>
                        <td align='left' >ตำแหน่งในสายงาน :  <?php echo text($arr_pos_line[$rec_per['LINE_ID']]); ?></td>
                        <td align='left' ></td>
                        <td align='left' ></td>
                      </tr>
					  <tr>
                        <td align='left' >ระดับ : <?php echo text($arr_pos_level[$rec_per['LEVEL_ID']]); ?></td>
                        <td align='left' ></td>
                        <td align='left' ></td>
                      </tr>
					  <tr>
                        <td align='left' >เงินเดือน : <?php echo number_format($rec_per['PER_SALARY'],2); ?></td>
                        <td align='left' ></td>
                        <td align='left' ></td>
                      </tr>
                     </tbody>
                    </table>
                  </div> 
              </div>
            <div class="row formSep">   
			 <div class="col-xs-12 col-md-2 ">สาเหตุของการลาออก : </div>
			  <div class="col-xs-12 col-md-4">
              	<?php echo text($rec_per['RETIRE_NOTE']); ?>
			  </div>
           </div>
            <div class="row head-form">
                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();">
                        <img class="switchPic1" src="<?php echo $path;?>images/exp.gif" style="display:none;">
                        <img class="switchPic1" src="<?php echo $path;?>images/clse.gif" >
                        ภาระผูกพันกับทางราชการและผู้ที่เกี่ยวข้อง
                    </a>
                </div>
            </div>
            
            <div id="collapse1" class="collapse in"><?php include("../retirement/include_asset_retirement.php"); ?></div> 
               <div id="collapse2" class="collapse in"><?php  
			  if($recmain['RETIRE_STATUS']==2){
				  include("../retirement/include_approve_result1.php");
			  } ?></div> 
                <div id="collapse3" class="collapse in"><?php 
				if($recmain['RETIRE_STATUS']==3){
					include("../retirement/include_approve_result1.php");
					include("../retirement/include_approve_result2.php");
				}
				if($recmain['RETIRE_STATUS']==5){
					include("../retirement/include_approve_result1.php");
					include("../retirement/include_approve_result2.php");
					include("../retirement/include_out_gov_detail.php");
				}
				 ?></div> 
          
    
         <div class="col-xs-12 col-sm-12" align="center">
         <br>
           <button type="button" class="btn btn-primary" onClick="chkinput();">โอนข้อมูลเข้าทะเบียนประวัติ</button>
           <button type="button" class="btn btn-default" onClick="self.location.href='profile_his_out_gov_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <div class="clearfix"></div>
        <br>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
</body>
</html>
<?php

 echo form_model('myModal','เลือกผู้ขอลาออก','show_display');?>