<?php 
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID;  /// for mobile
$paramlink = url2code($link);
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

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

$field=" PADD_ID,PER_ID,PADD_ROOM,PADD_BUILDING,PADD_HOMENO,PADD_MOO,PADD_SOI,PADD_VILLAGE,PADD_ROAD,
PADD_TAMB_ID,PADD_AMPR_ID,PADD_PROV_ID,PADD_ZIPCODE,PADD_TEL,PADD_FAX,COUNTRY_ID,
PADD_OTHER_COUNTRY,PADD_TYPE,REQUEST_ID,REQUEST_RESULT,REQUEST_STATUS,ACTIVE_STATUS ";	
$table="PER_ADDRESS";
$pk_id="PADD_ID";

$wh=" DELETE_FLAG='0' {$filter} and PER_ID = '".$PER_ID."'  ";
$notin=$wh." and ".$pk_id." not in (select top {$goto} ".$pk_id." from ".$table." where ".$wh.")";
$orderby="order by  PADD_ID ASC";

$sql = "select top {$page_size} ".$field." from ".$table." where ".$notin." {$filter} ".$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$total_record = $db->db_num_rows($db->query("select ".$field." from ".$table." where ".$wh." {$filter} "));

//DATA
/*
$sql = "SELECT PADD_ID,PER_ID,PADD_ROOM,PADD_BUILDING,PADD_HOMENO,PADD_MOO,PADD_SOI,PADD_VILLAGE,PADD_ROAD,
PADD_TAMB_ID,PADD_AMPR_ID,PADD_PROV_ID,PADD_ZIPCODE,PADD_TEL,PADD_FAX,COUNTRY_ID,
PADD_OTHER_COUNTRY,PADD_TYPE,REQUEST_ID,REQUEST_RESULT,REQUEST_STATUS,ACTIVE_STATUS
FROM PER_ADDRESS
WHERE  DELETE_FLAG='0' AND PADD_ID = '".$PADD_ID."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
*/
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
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
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
<script src="<?php echo $path; ?>bootstrap/js/tooltip.js"></script> 
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_address.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			 <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
	  <li class="active">ประวัติที่อยู่</li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12" id="content">
		<?php include("tab_profile.php");?>
		<div class="grouptab">
		 <?php include("tab_info.php");?>
		 <div class="clearfix"></div>
			<form id="frm-input" method="post" action="process/profile_address_process.php" >
				<input type="hidden" id="proc" name="proc" value="<?php echo 'edit'; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
				<input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        		<input type="hidden" id="TABLE_ID" name="TABLE_ID" value="<?php echo $TABLE_ID ?>">
				<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
				<input type="hidden" id="PADD_ID" name="PADD_ID" value="<?php echo $PADD_ID?>">
                <input type="hidden" id="default_country_id" name="default_country_id" value="<?php echo $default_country_id;?>">
                <input type="hidden" id="default_prov_id" name="default_prov_id" value="<?php echo $default_prov_id;?>">
				 <div class="clearfix"></div>
				<?php 
				foreach($arr_address as $key => $val){
					if($key>5){
						continue;	
					}
					//data
					$sql_ssp_type="SELECT PADD_ID,PER_ID,PADD_ROOM,PADD_BUILDING,PADD_HOMENO,PADD_MOO,PADD_SOI,PADD_VILLAGE,PADD_ROAD,
					PADD_TAMB_ID,PADD_AMPR_ID,PADD_PROV_ID,PADD_ZIPCODE,PADD_TEL,PADD_FAX,COUNTRY_ID,
					PADD_OTHER_COUNTRY,PADD_TYPE,REQUEST_ID,REQUEST_RESULT,REQUEST_STATUS,ACTIVE_STATUS
					FROM PER_ADDRESS WHERE PER_ID='".$PER_ID."' AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND PADD_TYPE='".$key."'";
					$query_ssp_type = $db->query($sql_ssp_type);
					$rec = $db->db_fetch_array($query_ssp_type);
					//echo $rec['PADD_PROV_ID'];
					
					//ประเทศ
					$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");
					$rec['COUNTRY_ID'] = $rec['COUNTRY_ID']==""?$default_country_id:$rec['COUNTRY_ID'];
					
					//จังหวัด
					$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
					$PADD_PROV_ID = empty($rec['PADD_PROV_ID'])?$default_prov_id:$rec['PADD_PROV_ID'];

					//อำเภอ/เขต
					$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$PADD_PROV_ID."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					
					//ตำบล/แขวง
					$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec['PADD_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
					
					//Mask โทรศัพท์
					$tel_class = $PADD_PROV_ID==$default_prov_id?"telbkk":"telprov";
				?>
				<div class="panel-group" id="accordion">
					<div class="row head-form">
						<div class="col-xs-12 col-md-2" style="white-space:nowrap;">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>" onClick="$('.switchPic<?php echo $key?>').toggle();">
								<img class="switchPic<?php echo $key?>" src="<?php echo $path;?>images/<?php echo ($key=='3'?"clse.gif":"exp.gif");?>">
								<img class="switchPic<?php echo $key?>" src="<?php echo $path;?>images/<?php echo ($key=='3'?"exp.gif":"clse.gif");?>" style="display:none;">
							<?php echo $val;?>
								
							</a>
						</div>
						<div class="col-xs-12 col-md-9">
							<div class="col-xs-4 col-md-2">คัดลอกจาก</div>
							<div class="col-xs-12 col-md-6" style="color:#000;">
								<select id="ADDR_TYPE<?php echo $key;?>" name="ADDR_TYPE<?php echo $key;?>" class="selectbox form-control" onChange="getAddr('<?php echo $key;?>', this.value);" placeholder="ดึงข้อมูล">
									<option value=""></option>
									<?php 
										foreach($arr_address as $key1 => $val1){
											if($key!=$key1 && $key1<=5){?><option value="<?php echo $key1;?>"><?php echo $val1;?></option>
											<?php
											 }
										}
									?>
								</select>
							</div>
						</div>		
					</div>				
					<div id="collapse<?php echo $key;?>" class="<?php echo ($key=='3'?"collapse in":"collapse");?>">
						<?php if($key=='3'){?>
						<div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศ :&nbsp;<span style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('S_COUNTRY'.$key,'S_COUNTRY'.$key,$arr_country,'',$rec['COUNTRY_ID'],'onchange="getcountry(this.value,\''.$key.'\')"','','1');?></div>
						</div> 
						<div id="country_del1<?php echo $key; ?>" class="row formSep2" <?php echo ($rec['COUNTRY_ID']!=$default_country_id)?"":"style='display:none'";?>>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">สถานที่เกิดต่างประเทศ :&nbsp;<span style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-8"><textarea id="S_OTHER_COUNTRY<?php echo $key?>" name="S_OTHER_COUNTRY<?php echo $key?>" class="form-control" placeholder="สถานที่เกิดต่างประเทศ" maxlength="255"><?php echo text(trim($rec['PADD_OTHER_COUNTRY'])); ?></textarea></div>
						</div>   
						<div id="country_del2<?php echo $key; ?>" class="row formSep2" <?php echo ($rec['COUNTRY_ID']==$default_country_id)?"":"style='display:none'";?>>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :&nbsp;<span style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('s_prov'.$key,'s_prov'.$key,$arr_prov,'จังหวัด',$PADD_PROV_ID,'onchange="getRampr(this,\'s_ampr'.$key.'\',\'s_tamb'.$key.'\')"','','1');?></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :&nbsp;<span style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2"><span id='ss_ampr<?php echo $key;?>'><?php echo GetHtmlSelect('s_ampr'.$key,'s_ampr'.$key,$arr_ampr,'อำเภอ/เขต',$rec['PADD_AMPR_ID'],'onchange="getStamb(this.id,this.value,\'s_tamb'.$key.'\')"','','1');?></span></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวง :&nbsp;<span style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2"><span id='ss_tamb<?php echo $key;?>'><?php echo GetHtmlSelect('s_tamb'.$key,'s_tamb'.$key,$arr_tamb,'ตำบล/แขวง',$rec['PADD_TAMB_ID'],'','','1');?></span></div>
						</div>
						<?php }else{?>
						<div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_HOMENO<?php echo $key;?>" name="S_HOMENO<?php echo $key;?>" class="form-control " placeholder="บ้านเลขที่" maxlength="10" value="<?php echo text($rec['PADD_HOMENO']); ?>"></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่ :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_MOO<?php echo $key;?>" name="S_MOO<?php echo $key;?>" class="form-control" placeholder="หมู่" maxlength="10" value="<?php echo text($rec['PADD_MOO']); ?>"></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้าน :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_VILLAGE<?php echo $key;?>" name="S_VILLAGE<?php echo $key;?>" class="form-control" placeholder="หมู่บ้าน" maxlength="100" value="<?php echo text($rec['PADD_VILLAGE']); ?>"></div>
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคาร :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_BUILDING<?php echo $key;?>" name="S_BUILDING<?php echo $key;?>" class="form-control" placeholder="อาคาร" maxlength="100" value="<?php echo text($rec['PADD_BUILDING']); ?>"></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้อง :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_ROOM<?php echo $key;?>" name="S_ROOM<?php echo $key;?>" class="form-control" placeholder="เลขที่ห้อง" maxlength="10" value="<?php echo text($rec['PADD_ROOM']); ?>"></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอย :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_SOI<?php echo $key;?>" name="S_SOI<?php echo $key;?>" class="form-control" placeholder="ซอย" maxlength="100" value="<?php echo text($rec['PADD_SOI']); ?>"></div>
						</div>
						<div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนน :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_ROAD<?php echo $key;?>" name="S_ROAD<?php echo $key;?>" class="form-control" placeholder="ถนน" maxlength="100" value="<?php echo text($rec['PADD_ROAD']); ?>"></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศ :</div>
							<div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('S_COUNTRY'.$key,'S_COUNTRY'.$key,$arr_country,'ประเทศ',$rec['COUNTRY_ID'],'onchange="getcountry(this.value,\''.$key.'\')"','','1');?></div>
						</div>
						
                        <div id="country_del1<?php echo $key; ?>" class="row formSep" <?php echo ($rec['COUNTRY_ID']!=$default_country_id)?"":"style='display:none'";?>>
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ที่อยู่ในต่างประเทศ :&nbsp;</div>
                            <div class="col-xs-12 col-md-8"><textarea id="S_OTHER_COUNTRY<?php echo $key?>" name="S_OTHER_COUNTRY<?php echo $key?>" class="form-control" placeholder="ที่อยู่ในต่างประเทศ" maxlength="255"><?php echo text(trim($rec['PADD_OTHER_COUNTRY'])); ?></textarea></div>
						</div>  
                         
						<div id="country_del2<?php echo $key; ?>" <?php echo ($rec['COUNTRY_ID']==$default_country_id)?"":"style='display:none'";?>>
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัด :</div>
                                <div class="col-xs-12 col-md-2"><?php echo GetHtmlSelect('s_prov'.$key,'s_prov'.$key,$arr_prov,'จังหวัด',$PADD_PROV_ID,'onchange="getRampr(this,\'s_ampr'.$key.'\',\'s_tamb'.$key.'\');getTelClass(this.value, \''.$key.'\');"','','1');?></div>
                                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขต :</div>
                                <div class="col-xs-12 col-md-2"><span id='ss_ampr<?php echo $key;?>'><?php echo GetHtmlSelect('s_ampr'.$key,'s_ampr'.$key,$arr_ampr,'อำเภอ/เขต',$rec['PADD_AMPR_ID'],'onchange="getStamb(this.id,this.value,\'s_tamb'.$key.'\') " ','','1');?></span></div>
                                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวง :</div>
                                <div class="col-xs-12 col-md-2"><span id='ss_tamb<?php echo $key;?>'><?php echo GetHtmlSelect('s_tamb'.$key,'s_tamb'.$key,$arr_tamb,'ตำบล/แขวง',$rec['PADD_TAMB_ID'],'','','1');?></span></div>
                            </div>						
                            <div class="row formSep">
                                <div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์ :</div>
                                <div class="col-xs-12 col-md-2"><input type="text" id="S_ZIPCODE<?php echo $key;?>" name="S_ZIPCODE<?php echo $key;?>" class="form-control number" placeholder="รหัสไปรษณีย์" maxlength="5" value="<?php echo trim($rec['PADD_ZIPCODE']); ?>"></div>
                            </div>
                        </div>
                        
                        <div class="row formSep2">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์ :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_TEL<?php echo $key;?>" name="S_TEL<?php echo $key;?>" class="form-control <?php echo $tel_class ?>"  placeholder="โทรศัพท์" maxlength="20" value="<?php echo trim($rec['PADD_TEL']); ?>"></div>
                            <div class="col-xs-12 col-sm-2">
                            	<div class="input-group">
                                	<span class="input-group-addon">ต่อ</span>
                                    <input type="text" id="S_TEL_EXT<?php echo $key;?>" name="S_TEL_EXT<?php echo $key;?>" maxlength="4" class="form-control" placeholder="ต่อ" value="<?php echo $t_ext; ?>">
                            	</div>	
                            </div>
                            
                            <div class="col-xs-12 col-md-2"></div>
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสาร :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_FAX<?php echo $key;?>" name="S_FAX<?php echo $key;?>" class="form-control <?php echo $tel_class ?>" placeholder="โทรสาร" maxlength="20" value="<?php if( $rec['PADD_FAX'] ==0) { echo ''; }else{  echo trim($rec['PADD_FAX']); }?>"></div>				
						</div>
						<?php }?>
					</div>
				</div>
				<?php }?>
				<div class="formlast">
					<div class="col-xs-12 col-md-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='profile_his_form.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
   <?php include_once("report_footer.php"); ?>
</div>
</body>
</html>