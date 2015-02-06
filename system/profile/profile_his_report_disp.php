<?php
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$count_num = 1;
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
<script src="js/profile_his_report_disp.js?<?php echo rand(); ?>"></script>

</head>
<body <?php echo $remove;?>>
<div id="content" class="container-full">
	<div><?php include($path."include/header.php"); ?></div>
	<div><?php include($path."include/menu.php"); ?></div>
	<div class="col-xs-12 col-md-12">
		<ol class="breadcrumb">
			<li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
			<li class="active"><?php echo showMenu($menu_sub_id); ?></li>
		</ol>
	</div>
	<div class="col-xs-12 col-md-12" >
		<div class="groupdata">
			<form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
				<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>">
				<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
				<input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
				<input type="hidden" id="page_size" name="page_size" value="<?php echo $page_size; ?>">
				<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();"><?php echo switchPic($path,"switchPic1", "0");?> รายงานทะเบียนประวัติ</a>
				</div>
				<div id="collapse1" class="collapse in">
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงาน ก.พ. 7</a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานกรอบอัตรากำลังและจำนวนผู้ปฎิบัติงานอยูู่จริงในภาพรวมของข้าราชการกรมป้องกัและบรรเทาสาธารณภัย</a></div>
						</div>
                        
                        
					</div>
				</div>
                
				<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="$('.switchPic2').toggle();"><?php echo switchPic($path,"switchPic2", "0");?> รายงานโครงสร้างกำลังคน</a>
				</div>
				<div id="collapse2" class="collapse in">
                
                
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการจำแนกตามประเภท ตำแหน่ง ระดับ </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการจำแนกตามเพศ</a></div>
						</div>              
					</div>
                
                
                
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการจำแนกตามระดับการศึกษา มหาวิทยาลัยและ ประเทศที่สำเร็จการศึกษา</a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการจำแกตามช่วงอายุ โครงสร้างอายุข้าราชการ</a></div>
						</div>              
					</div>
                    
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการจำแนกตามช่วงอายุ โครงสร้างอายุข้าราชการ</a></div>
						</div>
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานอัตราการเกษียณอายุข้าราชการในแต่ละปี</a></div>
						</div>   
					</div>
                    

					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการจำแนกตามวุฒิการศึกษา / สาขาวิชาเอก</a></div>
						</div>
						<div class="col-xs-12 col-md-6">	
							<div  > </div>
						</div>   
					</div>



                    
				</div>       
                
                
                
				<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="$('.switchPic3').toggle();"><?php echo switchPic($path,"switchPic3", "0");?> รายงานการเคลื่อนไหวของข้าราชการ</a>
				</div>
				<div id="collapse3" class="collapse in">
                
                
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. จำนวนข้าราชการที่บรรจุในปีงบประมาณ </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. จำนวนข้าราชการที่ออกจากราชการในปีงบประมาณ</a></div>
						</div>              
					</div>
                 
                 
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. จำนวนข้าราชการที่ย้ายระหว่างสำนัก / กองในปีงบประมาณ </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. จำนวนข้าราชการที่ย้ายระหว่างสายงานในปีงบประมาณ</a></div>
						</div>              
					</div>
                 
        
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. อัตราการเข้า - ออกข้าราชการในปีงบประมาณ </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. จำนวนข้าราชการที่ได้รับการเลื่อนระดับตำแหน่ง ในปีงบประมาณ</a></div>
						</div>              
					</div>
                 
        
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายชื่อข้าราชการที่บรรจุในปีงบประมาณ </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายชื่อข้าราชการที่โอน ลาออก เสียชีวิต ในแต่ละปีงบประมาณ </a></div>
						</div>              
					</div>
                 


					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายชื่อข้าราชการที่เลื่อนระดับตำแหน่งในปีงบประมาณ </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายชื่อข้าราชการที่ย้ายระหว่างกอง / สายงานในปีงบประมาณ </a></div>
						</div>              
					</div>
                         
                 
				</div> 
                
                
                
				<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onClick="$('.switchPic4').toggle();"><?php echo switchPic($path,"switchPic4", "0");?> รายงานการอื่นๆ</a>
				</div>
				<div id="collapse4" class="collapse in">
                

					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานจำนวนข้าราชการ ที่ครบกำหนดอายุเกษียณราชการในแต่ละปี และในช่วง 5 ปี </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายชื่อข้าราชการ ที่เกษียณอายุในสิ้นปีงบประมาณ </a></div>
						</div>              
					</div> 
                

					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานรายชื่อข้าราชการที่ดำรงตำแหน่งในระดับ เรียงตามลำดับอาวุโส พร้อมทั้งแสดงระยะเวลาในการดำรงตำแหน่ง</a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานรายชื่อข้าราชการ ตามตำแหน่ง สังกัดกรอบและสังกัดปฎิบัติ </a></div>
						</div>              
					</div> 
                


					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานข้อมูลข้าราชการ ที่ผ่านการฝึกอบรมหลักสูตรแยกตามสำนัก/กอง   </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานบัญชีรายชื่อข้าราชการแยกตามระดับ สายงาน สังกัด เรียงตามอาวุโส   </a></div>
						</div>              
					</div> 
                




					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานรายชื่อข้าราชการจำแนกตามระดับตำแหน่ง เพศ และสังกัด   </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานรายชื่อข้าราชการจำแนกตามตำแหน่งในการบริหารงานและสังกัด      </a></div>
						</div>              
					</div> 
                


					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานกรอบอัตรากำลังข้าราชการจำแนกตามสายงาน ระดับตำแหน่ง คนครอง และ อัตราว่าง   </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานสรุปข้อมูลราชการส่งสำนักงาน ก.พ.</a></div>
						</div>              
					</div> 

  
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานอัตรากำลังข้าราชการแต่ละประเภทแยกตามสังกัดหน่วยงานตามกรอบ และปฎิบัติ       </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.    รายงานสรุปข้อมูลอัตรากำลังข้าราชการตามประเภท และตำแหน่ง          </a></div>
						</div>              
					</div> 
  
  
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานรายชื่อข้าราชการผู้ที่ได้รับพระราชทานเครื่องราชอิสริยาภรณ์ในแต่ละปี       </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. จำนวนตำแหน่งจำแนกตามสถานภาพและลักษณะของตำแหน่ง  </a></div>
						</div>              
					</div> 
  
  
 
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  จำนวนตำแหน่งจำแนกตามลักษณะของตำแหน่ง       </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายชื่อตำแหน่งว่าง พร้อมระบุจำนวนตำแหน่งที่ว่าง  </a></div>
						</div>              
					</div> 
                    
                    
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  จำนวนตำแหน่งจำแนกตามประเภทตำแหน่ง       </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>. รายงานสำหรับผู้ปฎิบัติงาน และผู้บริหาร โดยสามารถส่งออกข้อมูลในลักษณะ CSV  </a></div>
						</div>              
					</div> 
    
  
  
					<div class="row">
						<div class="col-xs-12 col-md-6">	
							<div class="row formSep"><a href = "profile_his_report_1_<?php echo $count_num ;?>.php?<?php echo $paramlink;?>" class="report_link"><?php echo $count_num ; $count_num ++; ?>.  รายงานการลาแต่ละประเภทของข้าราชการ       </a></div>
						</div>
                        
						<div class="col-xs-12 col-md-6">	
					 
						</div>              
					</div> 
      
  
                
			</div>                 

			</form>
		</div>
        					<br/><br/>

	</div>
	<div style="text-align:center; bottom:0px;"><?php include($path."include/footer.php"); ?></div>
</div>
</body>
</html>