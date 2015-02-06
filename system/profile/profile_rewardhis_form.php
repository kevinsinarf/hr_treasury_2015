<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&PER_ID=".$PER_ID."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&ACT=".$ACT;
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
//POST
$PER_ID=$_POST['PER_ID'];
$REWHIS_ID = $_POST['REWHIS_ID'];
$txt = (($proc == "add") ? "เพิ่มข้อมูล":"ดูรายละเอียด"); 
//MAIN
$sql = "SELECT a.* FROM PER_REWARDHIS a WHERE REWHIS_ID = '".$REWHIS_ID."'  ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0'  AND TYPE_ID = '".$rec['TYPE_ID']."' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "LEVEL_SEQ");

if($POSTYPE_ID==1||$POSTYPE_ID==5){
	$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '".$POSTYPE_ID."' ", "LG_NAME_TH");

}
if($POSTYPE_ID==1 || $POSTYPE_ID== 5 ){
//ตำแหน่งในสายงาน
	$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LG_ID = '".$rec['LG_ID']."'", "LINE_NAME_TH");
}else{
	$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND LEVEL_ID = '".$rec['LEVEL_ID']."'", "LINE_NAME_TH");
}


$arr_manage=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", "DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' AND MT_ID = '".$rec['MT_ID']."' ");
//org1
$arr_org1=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_SEQ");

//org2
$arr_org2=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_1']."' ", "ORG_SEQ");

//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_2']."' ", "ORG_SEQ");
//สำหรับส่วนราบการ
$arr_org1_type =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.OL_ID='2' ", "ORG_SEQ");

//org2
$arr_org2_type =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['REWHIS_ORG_ID_1']."' ", "ORG_SEQ");

//org3
$arr_org3_type =GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['REWHIS_ORG_ID_2']."' ", "ORG_SEQ");


//org4
$arr_org4=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$rec['ORG_ID_3']."'  ", "ORG_SEQ");
//org5
$arr_org5=GetSqlSelectArray( "a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a ", "a.DELETE_FLAG='0' AND a.ACTIVE_STATUS='1'  AND a.ORG_PARENT_ID='".$rec['ORG_ID_4']."'  ", "ORG_SEQ");
					
//ข้อมูลรางวัล
$arr_reward=GetSqlSelectArray("REWARD_ID", "REWARD_NAME_TH", "SETUP_REWARD", "ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "REWARD_NAME_TH");
$arr_type_mt = GetSqlSelectArray("MT_ID", "MT_NAME_TH", "SETUP_POS_MANAGE_TYPE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0  ", "MT_SEQ"); 
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
<script src="js/profile_rewardhis_form.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?> >
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb" >
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  
	  <li><a href="profile_rewardhis.php?<?php echo url2code($link2); ?>">ประวัติการได้รับความดีความชอบ</a></li>
      <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
<div class="col-xs-12 col-sm-12" id="content" >
<div class="groupdata" > <br>
	<?php include ("tab_info.php"); ?>
    <div class="clearfix"></div>

        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
		<input type="hidden" id="REWHIS_ID" name="REWHIS_ID" value="<?php echo $REWHIS_ID; ?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
         <input type="hidden" id="POSTYPE_ID" name="POSTYPE_ID" value="<?php echo $POSTYPE_ID; ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        
       <div class="row head-form">การได้รับความดีความชอบ</div>
       <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ประเภทส่วนราชการที่ได้มอบรางวัล : </div>
            <div class="col-xs-12 col-sm-3">
            	<input id="REWARD_ORG_TYPE_1" name="REWARD_ORG_TYPE"  type="radio" disabled value="1" onClick="chkType(this.value);" <?php echo ($rec['REWHIS_ORG_TYPE'] == 1)?'checked':''; ?> >&nbsp;หน่วยงานราชการ <br>
                <input id="REWARD_ORG_TYPE_2" name="REWARD_ORG_TYPE" type="radio" disabled value="2" onClick="chkType(this.value);" <?php echo ($rec['REWHIS_ORG_TYPE'] == 2)?'checked':''; ?> >&nbsp;หน่วยงานเอกชน/รัฐวิสาหกิจ 
            </div> 
            <div class="col-xs-12 col-sm-1"></div>
            <span id="type_other">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">โปรดระบุ : </div>
            <div class="col-xs-12 col-sm-3">
                  <?php echo text($rec['REWHIS_ORG_NAME']); ?>
            </div>
            </span>
        </div>		
        
        <span id="type_gov">
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง :</div>
            <div class="col-xs-12 col-sm-3"><?php  echo GetHtmlSelect_v('REWHIS_ORG_ID_1','REWHIS_ORG_ID_1',$arr_org1_type,'กระทรวง',$rec['REWHIS_ORG_ID_1'],'onchange="getORG(this);"','','');?></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม/สำนักงาน :</div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org2'><?php  echo GetHtmlSelect_v('REWHIS_ORG_ID_2','REWHIS_ORG_ID_2',$arr_org2_type,'กรม/สำนักงาน',$rec['REWHIS_ORG_ID_2'],'onchange="getORG(this);"','','');?></span></div> 
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สำนัก/กอง/กลุ่ม : </div>
            <div class="col-xs-12 col-sm-3"><span id='ss_org3'><?php echo GetHtmlSelect_v('REWHIS_ORG_ID_3','REWHIS_ORG_ID_3',$arr_org3_type,'สำนัก/กอง/กลุ่ม',$rec['REWHIS_ORG_ID_3'],'','','1');?></span></div> 
        </div>
       </span>
         <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">เนื่องในโอกาส/ตามโครงการ : &nbsp;</div>
            <div class="col-xs-12 col-md-9">
            	 <?php  echo text($rec["REWHIS_TITLE"]); ?>
            </div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รายการรางวัลที่ได้รับ :&nbsp; </div>
            <div class="col-xs-12 col-md-3">
			<?php  echo GetHtmlSelect_v('REWARD_ID','REWARD_ID',$arr_reward,'ข้อมูลรางวัล',$rec['REWARD_ID'],'','','1');?>	
		    </div>
            <div class="col-xs-12 col-sm-1"></div>
        	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เมื่อวันที่ :&nbsp;</div>
            <div class="col-xs-12 col-md-2">	
            	<div class="input-group">
                     <?php echo conv_date($rec["REWARD_DATE"]);?>
                     
                </div>
            </div>
     	   </div>       
       
        <div class="row head-form">ข้อมูลตำแหน่งขณะที่ได้รับ</div>
        <div class="row formSep">
            <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><?php echo $arr_txt['pos_no']; ?>  :  </div>
            <div class="col-xs-12 col-md-3">
                         <?php  echo text($rec["POS_NO"]); ?>
          	</div>
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กระทรวง :</div>
            <div class="col-xs-12 col-sm-3">
				<?php  echo GetHtmlSelect_v('ORG_ID_1','ORG_ID_1',$arr_org1,'กระทรวง',$rec['ORG_ID_1'], " onchange='getORG(this);' ",'','');?>
            </div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กรม/สำนักงาน :</div>
            <div class="col-xs-12 col-sm-3">
				<?php  echo GetHtmlSelect_v('ORG_ID_2','ORG_ID_2',$arr_org2,'กรม/สำนักงาน',$rec['ORG_ID_2'],"onchange='getORG(this);' ",'','');?>
            </div> 
            <div class="col-xs-12 col-md-1"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">สำนัก/กอง/กลุ่ม : </div>
            <div class="col-xs-12 col-sm-3">
     			<?php echo GetHtmlSelect_v('ORG_ID_3','ORG_ID_3',$arr_org3,'สำนัก/กอง/กลุ่ม',$rec['ORG_ID_3'],"onchange='getORG(this);'",'','1');?>
            </div> 
        </div>
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">กลุ่มงาน/ส่วน : </div>
            <div class="col-xs-12 col-sm-3">
     			<?php echo GetHtmlSelect_v('ORG_ID_4','ORG_ID_4',$arr_org4,'กลุ่มงาน/ส่วน',$rec['ORG_ID_4'],"onchange='getORG(this);' ",'','1');?>
            </div> 
            <div class="col-xs-12 col-md-1"></div>
           <div class="col-xs-12 col-sm-2" style="white-space:nowrap">ฝ่าย : </div>
            <div class="col-xs-12 col-sm-3">
     			<?php echo GetHtmlSelect_v('ORG_ID_5','ORG_ID_5',$arr_org5,'ฝ่าย',$rec['ORG_ID_5'],"onchange='getORG(this);' ",'','1');?>
            </div>
        </div>
         <!------------ข้าราชการ---------------------------------------------------------------->  
          <?php if($POSTYPE_ID == 1){ ?>
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเภทตำแหน่ง : </div>
                        <div class="col-xs-12 col-md-3">
                        	<?php echo GetHtmlSelect_v('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทตำแหน่ง' ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); get_manage(this); ' ",'', '', '300', '1'); ?>
                           
                    	</div>
                    	<div class="col-xs-12 col-md-2 col-md-offset-1" >ระดับตำแหน่ง : </div>
                    	<div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ระดับ' ,$rec['LEVEL_ID'] ,'','', '', '300', '1'); ?></div>
                    </div>
                    
                     <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >สายงาน : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onChange='get_line(this);' ", '', '', '300', '1'); ?></div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่งในสายงาน : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('LINE_ID', 'LINE_ID',$arr_pos_line, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div>
                    
                    <div class="row formSep">
                        <div class="col-xs-12 col-md-2 " style="white-space:nowrap;">ประเภทตำแหน่งทางการบริหาร : &nbsp;</div>
                        <div class="col-xs-12 col-md-3"><?php  echo GetHtmlSelect_v('MT_ID','MT_ID',$arr_type_mt,'ประเภทตำแหน่งทางการบริหาร',$rec['MT_ID'],'onchange=get_manage(this);','','1');?></div>
                        
                        <div class="col-xs-12 col-md-2 col-md-offset-1" >ตำแหน่งทางการบริหาร : </div>
                        <div class="col-xs-12 col-md-3"><?php echo GetHtmlSelect_v('MANAGE_ID', 'MANAGE_ID', $arr_manage, 'ตำแหน่งทางการบริหาร' ,$rec['MANAGE_ID'] ,'', '', '', '300', '1'); ?></div>
                    </div> 
                       
       
                <?php } ?>
                <!-- พนักงานราชการ -->
                <?php if($POSTYPE_ID == 3){ ?>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2 " >ปีที่อนุมัติกรอบ : </div>
                  <div class="col-xs-12 col-md-3">
                  	 <?php echo $rec['POS_YEAR']; ?>
                  </div>
                   <div class="col-xs-12 col-md-2 col-md-offset-1" >ประเภทพนักงานราชการ : </div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect_v('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'ประเภทพนักงานราชการ' ,$rec['TYPE_ID'] ," onChange='get_level(this); ' ",'', '', '300', '1'); ?>
                  </div>
                 </div>
                 
                  <div class="row formSep">
                     	<div class="col-xs-12 col-md-2 " >ประเภทกลุ่มงาน : </div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ประเภทกลุ่มงาน' ,$rec['LEVEL_ID'] ," onChange='get_line(this); ' ",'', '', '300', '1'); ?>
                        </div>
                        <div class="col-xs-12 col-md-2 col-md-offset-1 " >ตำแหน่ง : &nbsp;</div>
                        <div class="col-xs-12 col-md-3">
							<?php echo GetHtmlSelect_v('LINE_ID', 'LINE_ID',$arr_pos_line, 'ตำแหน่ง' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if($POSTYPE_ID == 5){ ?>
                 <div class="row formSep">
                  <div class="col-xs-12 col-md-2 " >กลุ่ม : </div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect_v('TYPE_ID', 'TYPE_ID',$arr_pos_type , 'กลุ่ม' ,$rec['TYPE_ID'] ," onChange='get_level(this); get_line_group(this); ' ",'', '', '300', '1'); ?>
                  </div>
                  <div class="col-xs-12 col-md-2 col-md-offset-1 " >สายงาน : </div>
                  <div class="col-xs-12 col-md-3">
				  	<?php echo GetHtmlSelect_v('LG_ID', 'LG_ID', $arr_pos_lg, 'สายงาน' ,$rec['LG_ID'] ," onChange='get_line(this);' ", '', '', '300', '1'); ?>
                  </div>
                </div>
                <div class="row formSep">
                  <div class="col-xs-12 col-md-2  " >ตำแหน่งในสายงาน : &nbsp;</div>
                  <div class="col-xs-12 col-md-3">
				  	<?php echo GetHtmlSelect_v('LINE_ID', 'LINE_ID',$arr_pos_line, 'ตำแหน่งในสายงาน' ,$rec['LINE_ID'] ,'', '', '', '300', '1'); ?>
                  </div>
                  <div class="col-xs-12 col-md-2 col-md-offset-1 " >ระดับตำแหน่ง : &nbsp;</div>
                  <div class="col-xs-12 col-md-3">
                      <?php echo GetHtmlSelect_v('LEVEL_ID', 'LEVEL_ID',$arr_poss_level , 'ระดับตำแหน่ง' ,$rec['LEVEL_ID'] ," ",'', '', '300', '1'); ?>
                  </div>
                 </div>
              <?php } ?>
            
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