<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;


$arr_address_change=GetSqlSelectArray("PADD_TYPE", "PADD_TYPE", "PER_ADDRESS", " DELETE_FLAG = '0' AND REQUEST_ID='".$REQUEST_ID."'", "PADD_ID");
//ข้อมูลที่ขอเปลี่ยนแปลง
$arr_request_table=GetSqlSelectArray("TABLE_ID", "TABLE_DESCRIPTION", "PER_TABLE_LIST", " 1=1 ", "TABLE_DESCRIPTION");
//ประเทศ
$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");
//จังหวัด
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");

$arr_address_change=GetSqlSelectArray("PADD_TYPE", "PADD_TYPE", "PER_ADDRESS", " DELETE_FLAG = '0' AND REQUEST_ID='".$REQUEST_ID."'", "PADD_ID");

$sql = "select REQUEST_ID, PER_ID, CONVERT(DATE,REQUEST_DATETIME) as REQUEST_DATETIME, REQUEST_APP_DATE  from PER_REQUEST where DELETE_FLAG = '0' AND REQUEST_ID='".$REQUEST_ID."' ";
$query = $db->query($sql);
$req_data = $db->db_fetch_array($query);
//Mask โทรศัพท์
$tel_class = $PADD_PROV_ID==$default_prov_id?"telbkk":"telprov";
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
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_approvehis_address.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
          <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
          <li><a href="profile_approvehis.php?<?php echo url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
          <li><a href="profile_approvehis_list.php?<?php echo url2code($link2); ?>">บุคลากรที่ขอเปลี่ยนแปลงประวัติ</a></li>
          <li class="active">ประวัติที่อยู่</li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12" id="content">
		<div class="grouptab">
		 <?php include("tab_info.php");?>
		 <div class="clearfix"></div>
			<form id="frm-input" method="post" action="process/profile_approvehis_address_process.php" >
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
				<input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
                <input type="hidden" id="default_country_id" name="default_country_id" value="<?php echo $default_country_id;?>">
                <input type="hidden" id="default_prov_id" name="default_prov_id" value="<?php echo $default_prov_id;?>">
                <div class="clearfix"></div>
                <div class="row formSep">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">ข้อมูลที่ต้องการเปลี่ยนแปลง : &nbsp; </div>
                    <div class="col-xs-12 col-md-4">
                        <?php echo GetHtmlSelect('TABLE_ID','TABLE_ID',$arr_request_table,"ข้อมูลที่ต้องการเปลี่ยนแปลง",$TABLE_ID,'onchange=\'getTable_URL(this.value);\'','','1');?>
                    </div> 
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">&nbsp;</div>
                    <div class="col-xs-12 col-md-4">&nbsp;</div>
                </div> 
                
                <div class="clearfix"></div>
                <div class="row formSep2">
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">วันที่ขอเปลี่ยนแปลง&nbsp;:&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-12 col-md-2">
                        <div class="input-group">
                            <input type="text" id="REQUEST_DATETIME" name="REQUEST_DATETIME" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="">
                            <span class="input-group-addon datepicker" for="REQUEST_DATETIME" >&nbsp;
                                <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-2" style="white-space:nowrap">&nbsp;</div>
                    <div class="col-xs-12 col-md-6">&nbsp;</div>
                </div>
                
				<div class="clearfix"></div>
				<?php 
				foreach($arr_address as $key => $val){
					//เพิ่มมา
					//data new
					$sql = "SELECT * FROM PER_ADDRESS a WHERE a.DELETE_FLAG = '0' AND a.REQUEST_ID = '".$REQUEST_ID."' AND a.PER_ID = '".$PER_ID."' AND PADD_TYPE = '".$key."'";
					$query = $db->query($sql);
					$data = $db->db_fetch_array($query);
					
					//data old
					$sql_old = "SELECT * FROM PER_ADDRESS WHERE DELETE_FLAG = '0' AND ACTIVE_STATUS = '1' AND PER_ID = '".$PER_ID."' AND PADD_TYPE = '".$key."'";
					$query_old = $db->query($sql_old);
					$rec = $db->db_fetch_array($query_old);
					
					//ประเทศไทย
					$rec['COUNTRY_ID'] = $rec['COUNTRY_ID']==""?$default_country_id:$rec['COUNTRY_ID'];
					
					//อำเภอ/เขต
					if(!empty($rec['PADD_PROV_ID'])){
						$arr_ampr = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['PADD_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					}
					if(!empty($data['PADD_PROV_ID'])){
						$arr_ampr_new = GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$data['PADD_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					}
					//ตำบล/แขวง\
					if(!empty($rec['PADD_AMPR_ID'])){
						$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec['PADD_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
					}
					if(!empty($data['PADD_AMPR_ID'])){
						$arr_tamb_new=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$data['PADD_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
					}
					?>
			
                    <div class="panel-group" id="accordion">
                        <div class="row head-form">
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>" onClick="$('.switchPic<?php echo $key?>').toggle();">
                                    <input type="checkbox" class="switchPic<?php echo $key?>" readonly >
                                    <input type="checkbox" class="switchPic<?php echo $key?>" checked style="display:none" readonly id="checkbox<?php echo $key?>" name="checkbox[]" value="<?php echo $key?>">
                                    <label id="address<?php echo $key?>" ><?php echo $val;?></label>
                                </a>
                            </div>
                            <div class="col-xs-12 col-md-9">
                                <div class="col-xs-4 col-md-2">คัดลอกจาก</div>
                                <div class="col-xs-12 col-md-6" style="color:#000;">
                                    <select id="ADDR_TYPE<?php echo $key;?>" name="ADDR_TYPE<?php echo $key;?>" class="selectbox form-control" onChange="getAddr('<?php echo $key;?>', this.value);" placeholder="ดึงข้อมูล">
                                        <option value=""></option>
                                        <?php 
										foreach($arr_address as $key1 => $val1){
											if($key != $key1 && $key1<=5){?><option value="<?php echo $key1;?>"><?php echo $val1;?></option><?php }
										}
                                        ?>
                                    </select>
                                </div>
                            </div>		
                        </div>				
                    
					<div id="collapse<?php echo $key;?>" class="collapse">
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศเดิม :&nbsp;</div>
							<div class="col-xs-12 col-md-4"><?php echo text($arr_country[$rec['COUNTRY_ID']]);?></div>
                            
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศใหม่ :&nbsp;<span style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-4"><?php echo GetHtmlSelect('S_COUNTRY'.$key,'S_COUNTRY'.$key,$arr_country,'',$default_country_id,'onchange="getcountry(this.value,\''.$key.'\')"','','1');?></div>
                        </div> 
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เมืองเดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_CITY']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เมืองใหม่ : </div>
							<div class="col-xs-12 col-md-3">
                                <div class="country_del1<?php echo $key; ?>" >
                                    <input type="text" id="S_CITY<?php echo $key;?>" name="S_CITY<?php echo $key;?>" class="form-control" placeholder="เมือง" maxlength="255" value="">
                                </div>
                                <div class="country_del2<?php echo $key; ?>" style='display:none'>
                                    -
                                </div>
                            </div>
                        </div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้องเดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_ROOM_NO']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้องใหม่ : </div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_ROOM_NO<?php echo $key;?>" name="S_ROOM_NO<?php echo $key;?>" class="form-control" placeholder="เลขที่ห้อง" maxlength="10" value=""></div>
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชั้นเดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_FLOOR']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชั้นใหม่ : </div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_FLOOR<?php echo $key;?>" name="S_FLOOR<?php echo $key;?>" class="form-control" placeholder="ชั้น" maxlength="10" value=""></div>
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคารเดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_BUILDING']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคารใหม่ : </div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_BUILDING<?php echo $key;?>" name="S_BUILDING<?php echo $key;?>" class="form-control" placeholder="อาคาร" value=""></div>
						</div>
                    
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่เดิม :</div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_HOME_NO']); ?></div>
                            
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ใหม่ :</div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_HOME_NO<?php echo $key;?>" name="S_HOME_NO<?php echo $key;?>" class="form-control " placeholder="บ้านเลขที่" maxlength="10" value=""></div>
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่เดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_MOO']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่ใหม่ : </div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_MOO<?php echo $key;?>" name="S_MOO<?php echo $key;?>" class="form-control" placeholder="หมู่" maxlength="10" value=""></div>
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้านเดิม :</div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_VILLAGE']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้านใหม่ :</div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_VILLAGE<?php echo $key;?>" name="S_VILLAGE<?php echo $key;?>" class="form-control" placeholder="หมู่บ้าน" maxlength="100" value=""></div>
						</div>
                                                                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอยเดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_SOI']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอยใหม่ : </div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_SOI<?php echo $key;?>" name="S_SOI<?php echo $key;?>" class="form-control" placeholder="ซอย" maxlength="100" value=""></div>
                        </div> 
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนนเดิม : </div>
							<div class="col-xs-12 col-md-4"><?php echo text($rec['PADD_ROAD']); ?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนนใหม่ : </div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_ROAD<?php echo $key;?>" name="S_ROAD<?php echo $key;?>" class="form-control" placeholder="ถนน" maxlength="100" value=""></div>
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัดเดิม :&nbsp;</div>
							<div class="col-xs-12 col-md-4"><?php echo text($arr_prov[$rec['PADD_PROV_ID']]);?></div>

                       		<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัดใหม่ :&nbsp;<span class="country_del2<?php echo $key; ?>" style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2">
                            	<div class="country_del2<?php echo $key; ?>" >
									<?php echo GetHtmlSelect('s_prov'.$key,'s_prov'.$key,$arr_prov,'จังหวัด',$PADD_PROV_ID,'onchange="getRampr(this,\'s_ampr'.$key.'\',\'s_tamb'.$key.'\');getTelClass(this.value, \''.$key.'\');"','','1');?>
                                </div>
                                <div class="country_del1<?php echo $key; ?>" style='display:none'>
                                	-
                                </div>
                            </div>
                        </div> 
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขตเดิม :&nbsp;</div>
							<div class="col-xs-12 col-md-4"><?php echo text($arr_ampr[$rec['PADD_AMPR_ID']]);?></div>
                            
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขตใหม่ :&nbsp;<span class="country_del2<?php echo $key; ?>" style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2">
                            	<div class="country_del2<?php echo $key; ?>" >
                            		<span id='ss_ampr<?php echo $key;?>'><?php echo GetHtmlSelect('s_ampr'.$key,'s_ampr'.$key,array(),'อำเภอ/เขต','','onchange="getStamb(this.id,this.value,\'s_tamb'.$key.'\')"','','1');?></span>
                                </div>
                                <div class="country_del1<?php echo $key; ?>" style='display:none'>
                                	-
                                </div>
                            </div>
                        </div> 
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวงเดิม :&nbsp;</div>
                            <div class="col-xs-12 col-md-4"><?php echo text($arr_tamb[$rec['PADD_TAMB_ID']]);?></div>
                            
                            <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวงใหม่ :&nbsp;<span class="country_del2<?php echo $key; ?>" style="color:red;">*</span></div>
							<div class="col-xs-12 col-md-2">
                            	<div class="country_del2<?php echo $key; ?>" >
                            		<span id='ss_tamb<?php echo $key;?>'><?php echo GetHtmlSelect('s_tamb'.$key,'s_tamb'.$key,array(),'ตำบล/แขวง','','onchange="getZip(this.id,this.value,\'PADD_ZIPCODE'.$key.'\')"','','1');?></span>
                                </div>
                                <div class="country_del1<?php echo $key; ?>" style='display:none'>
                                	-
                                </div>
                            </div>
                        </div>
                        
                        <div class="row formSep">
                        	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์เดิม :</div>
                        	<div class="col-xs-12 col-md-4"><?php echo trim($rec['PADD_POSTCODE']); ?></div>
                                
                          	<div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์ใหม่ :</div>
                          	<div class="col-xs-12 col-md-2">
                                <div class="country_del2<?php echo $key; ?>" >
                                	<input type="text" id="PADD_ZIPCODE<?php echo $key; ?>" name="PADD_ZIPCODE<?php echo $key; ?>" class="form-control number" placeholder="รหัสไปรษณีย์" maxlength="5" value="<?php echo trim($data['PADD_ZIPCODE']); ?>">
                                </div>
                                <div class="country_del1<?php echo $key; ?>" style='display:none'>
                                	-
                                </div>
                            </div>
                     	</div> 
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เดิม :</div>
							<div class="col-xs-12 col-md-4"><?php echo trim($rec['PADD_TEL']); ?> <?php echo ($rec['PADD_TEL_EXT'] != '') ? "ต่อ ".$rec['PADD_TEL_EXT'] : "";?></div>
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์ใหม่ :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_TEL<?php echo $key;?>" name="S_TEL<?php echo $key;?>" class="form-control <?php echo $tel_class ?>"  placeholder="โทรศัพท์" maxlength="20" value=""></div>
                     		<div class="col-xs-12 col-sm-2">
                                <div class="input-group">
                                <span class="input-group-addon">ต่อ</span>
                                 <input type="text" id="S_TEL_EXT<?php echo $key;?>" name="S_TEL_EXT<?php echo $key;?>" maxlength="4" class="form-control number" placeholder="ต่อ" value="" style="width:80px;">
                                </div>	
                            </div>
                        </div> 
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสารเดิม :</div>
							<div class="col-xs-12 col-md-4"><?php echo trim($rec['PADD_FAX']);?> <?php echo ($rec['PADD_FAX_EXT'] != '') ? "ต่อ ".$rec['PADD_FAX_EXT'] : "";?></div>	
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสารใหม่ :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_FAX<?php echo $key;?>" name="S_FAX<?php echo $key;?>" class="form-control <?php echo $tel_class ?>" placeholder="โทรสาร" maxlength="20" value=""></div>
                            <div class="col-xs-12 col-sm-2">
                                <div class="input-group">
                                <span class="input-group-addon">ต่อ</span>
                                 <input type="text" id="S_FAX_EXT<?php echo $key;?>" name="S_FAX_EXT<?php echo $key;?>" maxlength="4" class="form-control number" placeholder="ต่อ" value="" style="width:80px;">
                                </div>	
                            </div>	
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่เดิม :</div>
							<div class="col-xs-12 col-md-4"><?php echo trim($rec['PADD_MOBILE']);?> </div>	
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่ใหม่ :</div>
							<div class="col-xs-12 col-md-2"><input type="text" id="S_MOBILE<?php echo $key;?>" name="S_MOBILE<?php echo $key;?>" class="form-control <?php echo $tel_class ?>" placeholder="โทรศัพท์เคลื่อนที่" maxlength="20" value=""></div>
						</div>
                        
                        <div class="row formSep">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์เดิม :</div>
							<div class="col-xs-12 col-md-4"><?php echo trim($rec['PADD_EMAIL']);?> </div>	
                            
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์ใหม่ :</div>
							<div class="col-xs-12 col-md-3"><input type="text" id="S_EMAIL<?php echo $key;?>" name="S_EMAIL<?php echo $key;?>" class="form-control" placeholder="อีเมล์" maxlength="100" ></div>
						</div>
					</div>
            	</div>
				<?php }?>

				<div class="formlast">
					<div class="col-xs-12 col-md-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='profile_approvehis_list.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
   <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>