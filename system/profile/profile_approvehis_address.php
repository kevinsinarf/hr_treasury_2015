<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;

//ที่อยู่ที่ขอเปลี่ยนแปลงข้อมูล
$arr_address_change=GetSqlSelectArray("PADD_TYPE", "PADD_TYPE", "PER_ADDRESS", " DELETE_FLAG = '0' AND REQUEST_ID='".$REQUEST_ID."'", "PADD_ID");

$sql = "select REQUEST_ID, PER_ID, CONVERT(DATE,REQUEST_DATETIME) as REQUEST_DATETIME, REQUEST_APP_DATE  from PER_REQUEST where DELETE_FLAG = '0' AND REQUEST_ID='".$REQUEST_ID."' ";
$query = $db->query($sql);
$req_data = $db->db_fetch_array($query);

$PER_ID = $req_data['PER_ID'];

//ข้อมูลที่ขอเปลี่ยนแปลง
$arr_request_table=GetSqlSelectArray("TABLE_ID", "TABLE_DESCRIPTION", "PER_TABLE_LIST", " 1=1 ", "TABLE_DESCRIPTION");
//ประเทศ
$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");
//จังหวัด
$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME");
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
				<input type="hidden" id="REQUEST_ID" name="REQUEST_ID" value="<?php echo $REQUEST_ID?>">
                <input type="hidden" id="default_country_id" name="default_country_id" value="<?php echo $default_country_id;?>">
                
                <div class="row formSep">
                    <div class="col-xs-2 col-sm-2">วันที่ขอเปลี่ยนแปลง&nbsp;&nbsp;</div>
                    <div class="col-xs-2 col-sm-2">
                        <?php echo conv_date($req_data['REQUEST_DATETIME'],'short'); ?>				
                        <input type="hidden" id="REQUEST_DATETIME" name="REQUEST_DATETIME"  value="<?php echo conv_date($req_data['REQUEST_DATETIME']); ?>">
                    </div>
                </div>
                
                <div class="row formSep">
                    <div class="col-xs-2 col-sm-2">วันที่อนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
                    <div class="col-xs-2 col-sm-2">
                        <div class="input-group">
                            <input type="text" id="REQUEST_APP_DATE" name="REQUEST_APP_DATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10" value="">
                            <span class="input-group-addon datepicker" for="REQUEST_APP_DATE" >&nbsp;
                                <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            </span>
                        </div>						
                    </div>
                </div>
                
				<?php 
				$address_change = "";
				foreach($arr_address_change as $key => $val){
					if($key>5){
						continue;
					}
					$address_change .= ",".$key."";
					//data new
					$sql="SELECT * FROM PER_ADDRESS a WHERE a.DELETE_FLAG = '0' AND a.REQUEST_ID = '".$REQUEST_ID."' AND a.PER_ID = '".$PER_ID."' AND PADD_TYPE = '".$key."'";
					$query = $db->query($sql);
					$rec = $db->db_fetch_array($query);
					
					//OLD DATA
					$sql="SELECT * FROM PER_ADDRESS WHERE DELETE_FLAG = '0' AND ACTIVE_STATUS = '1' AND PER_ID = '".$PER_ID."' AND PADD_TYPE = '".$key."'";
					$query = $db->query($sql);
					$data = $db->db_fetch_array($query);
					
					//อำเภอ/เขต
					if(!empty($rec['PADD_PROV_ID'])){
						$arr_ampr_new=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$rec['PADD_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					}
					if(!empty($data['PADD_PROV_ID'])){
						$arr_ampr_old=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$data['PADD_PROV_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
					}
					
					//ตำบล/แขวง\
					if(!empty($rec['PADD_AMPR_ID'])){
						$arr_tamb_new=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$rec['PADD_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
					}
					if(!empty($data['PADD_AMPR_ID'])){
						$arr_tamb_old=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$data['PADD_AMPR_ID']."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
					}
					?>
					<div class="panel-group" id="accordion">
						<div class="row head-form">
							<div class="col-xs-12 col-md-2" style="white-space:nowrap;">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>" onClick="$('.switchPic<?php echo $key?>').toggle();">
									<img class="switchPic<?php echo $key?>" src="<?php echo $path;?>images/clse.gif");?>
									<img class="switchPic<?php echo $key?>" src="<?php echo $path;?>images/exp.gif" style="display:none;">
									<?php echo $arr_address[$key];?>
								</a>
							</div>	
						</div>				
						
						<div id="collapse<?php echo $key;?>" class="collapse in">
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศเดิม :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_country[$data['PADD_COUNTRY_ID']]);?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ประเทศใหม่ :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_country[$rec['PADD_COUNTRY_ID']]);?></div>
							</div> 
                            
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้องเดิม : </div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_ROOM_NO']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">เลขที่ห้องใหม่ : </div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_ROOM_NO']); ?></div>
							</div>
                            
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชั้นเดิม : </div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_FLOOR']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ชั้นใหม่ : </div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_FLOOR']); ?></div>
							</div>
                            
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคารเดิม :</div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_BUILDING']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อาคารใหม่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_BUILDING']); ?></div>
							</div>
                        
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่เดิม :</div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_HOME_NO']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">บ้านเลขที่ใหม่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_HOME_NO']); ?></div>
							</div>
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่เดิม : </div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_MOO']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่ที่ใหม่ : </div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_MOO']); ?></div>
							</div>
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้านเดิม :</div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_VILLAGE']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">หมู่บ้านใหม่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_VILLAGE']); ?></div>
							</div>
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอยเดิม : </div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_SOI']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ซอยใหม่ : </div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_SOI']); ?></div>
							</div> 
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนนเดิม : </div>
								<div class="col-xs-12 col-md-4"><?php echo text($data['PADD_ROAD']); ?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ถนนใหม่ : </div>
								<div class="col-xs-12 col-md-2"><?php echo text($rec['PADD_ROAD']); ?></div>
							</div>
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัดเดิม :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_prov[$data['PADD_PROV_ID']]); ?></div>
	
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">จังหวัดใหม่ :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_prov[$rec['PADD_PROV_ID']]); ?></div>
							</div> 
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขตเดิม :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_ampr_old[$data['PADD_AMPR_ID']]);?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อำเภอ/เขตใหม่ :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_ampr_new[$rec['PADD_AMPR_ID']]); ?></div>
							</div> 
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวงเดิม :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_tamb_old[$data['PADD_TAMB_ID']]);?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">ตำบล/แขวงใหม่ :&nbsp;</div>
								<div class="col-xs-12 col-md-4"><?php echo text($arr_tamb_new[$rec['PADD_TAMB_ID']]); ?></div>
							</div>
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์เดิม :</div>
								<div class="col-xs-12 col-md-4"><?php echo trim($data['PADD_POSTCODE']); ?></div>
									
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">รหัสไปรษณีย์ใหม่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo trim($rec['PADD_POSTCODE']); ?></div>
							</div> 
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เดิม :</div>
								<div class="col-xs-12 col-md-4"><?php echo trim($data['PADD_TEL']); ?> <?php echo ($data['PADD_TEL_EXT'] != '') ? "ต่อ ".$data['PADD_TEL_EXT'] : "";?></div>
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์ใหม่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo trim($rec['PADD_TEL']); ?> <?php echo ($rec['PADD_TEL_EXT'] != '') ? "ต่อ ".$rec['PADD_TEL_EXT'] : "";?></div>
							</div> 
							
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสารเดิม :</div>
								<div class="col-xs-12 col-md-4"><?php echo trim($data['PADD_FAX']);?> <?php echo ($data['PADD_FAX_EXT'] != '') ? "ต่อ ".$data['PADD_FAX_EXT'] : "";?></div>	
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรสารใหม่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo trim($rec['PADD_FAX']);?> <?php echo ($rec['PADD_FAX_EXT'] != '') ? "ต่อ ".$rec['PADD_FAX_EXT'] : "";?></div>	
							</div>
                            
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่ :</div>
								<div class="col-xs-12 col-md-4"><?php echo trim($data['PADD_MOBILE']);?></div>	
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">โทรศัพท์เคลื่อนที่ :</div>
								<div class="col-xs-12 col-md-2"><?php echo trim($rec['PADD_MOBILE']);?></div>	
							</div>
                            
							<div class="row formSep">
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์ :</div>
								<div class="col-xs-12 col-md-4"><?php echo trim($data['PADD_EMAIL']);?></div>	
								
								<div class="col-xs-12 col-md-2" style="white-space:nowrap;">อีเมล์ :</div>
								<div class="col-xs-12 col-md-2"><?php echo trim($rec['PADD_EMAIL']);?></div>	
							</div>
                        </div>
                    </div>
                    <?php 
				}
				?>
				<input type="" id="ADDRESS_CHANGE" name="ADDRESS_CHANGE" value="<?php echo substr($address_change,1); ?>" >
				<div class="row formSep">
					<div class="col-xs-12 col-sm-2" style="white-space:nowrap">การอนุมัติ&nbsp;:&nbsp;<span style="color:red;">*</span></div>
					<div class="col-xs-12 col-sm-4">
						<label ><input type="radio" id="REQUEST_RESULT2" name="REQUEST_RESULT" value="2" <?php echo $rec['REQUEST_RESULT']=='2' || $rec['REQUEST_RESULT']=='1' || $rec['REQUEST_RESULT']==''?'checked':'';?> >&nbsp;<?php echo $arr_request_result['2'];?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<label ><input type="radio" id="REQUEST_RESULT3" name="REQUEST_RESULT" value="3" <?php echo $rec['REQUEST_RESULT']=='3'?'checked':'';?> >&nbsp;<?php echo $arr_request_result['3'];?></label>
					</div>
				</div>
			
				<div class="row formlast">
					<div class="col-xs-12 col-md-12" align="center">
						<button type="button" class="btn btn-primary" onClick="chkApprove();">บันทึก</button>
						<button type="button" class="btn btn-default" onClick="self.location.href='profile_approvehis.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
					</div>
				</div>
			</form>
		</div>
	</div>
   <div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>