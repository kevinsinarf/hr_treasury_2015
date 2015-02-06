<?php
//#################################//
$title_project = "ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล";

$TIMESTAMP = date("Y-m-d H:i:s");
//#########################################//
$servPath ="http://".$_SERVER['HTTP_HOST']."/";

define("DEPARTMENT_OF_DISATER", "กรมป้องกันและบรรเทาสาธารณภัย");

// image define
define("PROPFILE_THUM","fileupload/profile_his/no-image-half-landscape.png");

if($_GET['proc']=='add'){
	$txt_proc = "เพิ่ม";
}elseif($_GET['proc']=='edit'){
	$txt_proc = "แก้ไข";	
}

//fix text
$date_now=date("Ymd");//วันปัจจุบัน
$date_now_db=date("Y-m-d");//วันปัจจุบัน
$time_now=date("His");//เวลาปัจจุบัน
$time_now_db=date("H:i:s");//เวลาปัจจุบัน
$YEAR_PRESENT = (date("Y")+543);//ปีปัจจุบัน
$date_now_default=date("d/m/".$YEAR_PRESENT);//วันปัจจุบันดีฟอลต์
$time_now_h_default=date("H");//ชั่วโมงปัจจุบันดีฟอลต์
$time_now_m_default=date("i");//นาทีปัจจุบันดีฟอลต์
for($Y=($YEAR_PRESENT+2);$Y>=($YEAR_PRESENT-10);$Y--){//select ปี
	$A_CONFIG_YEAR[$Y] = $Y;
}
$YEAR_BUDGET = (date('m') < 10)?date("Y")+543:date("Y")+544;//ปีงบประมาณ
$YEAR_BUDGET_PREV = $YEAR_BUDGET-5;
$USER_BY=iconv('utf-8','tis-620',str_replace("&nbsp;"," ",$_SESSION["sys_name"]));//ชื่อผู้ใช้
$SYS_ADDR=$_SERVER["REMOTE_ADDR"];//ip address

$h_report="เลือกตั้งทั่วไป ".$_SESSION['sys_sapa_date'];/*deflaut หัวรายงาน*/
$remove="onmousemove=\"removement()\" onmousedown=\"removement()\" onkeydown=\"removement()\" onclick=\"removement()\"";
$save_proc="บันทึกข้อมูลเรียบร้อย";
$edit_proc="แก้ไขข้อมูลเรียบร้อย";
$del_proc="ลบข้อมูลเรียบร้อย";
$upload_proc="นำเข้าข้อมูลเรียบร้อย";
$img_save="<span class=\"glyphicon glyphicon-plus-sign\"></span>";
$img_edit="<span class=\"glyphicon glyphicon-pencil\"></span>";
$img_del="<span class=\"glyphicon glyphicon-trash\"></span>";
$img_upload="<span class=\"glyphicon glyphicon-upload\"></span>";
$img_view = "<span class=\"glyphicon glyphicon-search\"></span>";//glyphicon-eye-open
$img_user = "<span class=\"glyphicon glyphicon-user\"></span>";
$img_print = "<span class=\"glyphicon glyphicon-print\"></span>";
$img_pay = "<span class=\"glyphicon glyphicon-usd\"></span>";
$img_send = "<span class=\"glyphicon glyphicon-download-alt\"></span>";
$img_transfer = "<span class=\"glyphicon glyphicon-transfer\"></span>";
//array txt
$mont_en =  array ("01"=>"January","02"=>"February","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December"); 
$mont_en_short =  array ("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec"); 
$mont_th = array ("01"=>"มกราคม","02"=>"กุมภาพันธ์","03"=>"มีนาคม","04"=>"เมษายน","05"=>"พฤษภาคม","06"=>"มิถุนายน","07"=>"กรกฎาคม","08"=>"สิงหาคม","09"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม");
$mont_th_short = array ("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
$dow_th = array ("1"=>"จันทร์","2"=>"อังคาร","3"=>"พุธ","4"=>"พฤหัสบดี","5"=>"ศุกร์","6"=>"เสาร์","7"=>"อาทิตย์");
$dow_th_short = array ("1"=>"จ.","2"=>"อ.","3"=>"พ.","4"=>"พฤ.","5"=>"ศ.","6"=>"ส.","7"=>"อา.");
$arr_txt=array(
	/*ข้อมูล ทั่วไป*/
	'th'=>'ไทย',
	'en'=>'อังกฤษ',
	'active'=>'สถานะการใช้งาน',
	'download'=>'ดาวน์โหลดไฟล์',
	'per'=>'บุคลากรภายในสำนักงานฯ',
	'ss'=>'สมาชิกสภาผู้แทนราษฎร',
	'sp'=>'บุคคลในวงงานรัฐสภา',
        'sw'=>'วุฒิสมาชิก',
	'news'=>'สื่อมวลชน',
        'year_th'=>'ปีพุทธศักราช',
    'data_not_found' => 'ไม่พบข้อมูล',	

	// name org
	'org_label_name' => 'สำนัก / กอง',
	'total_result_txt' => 'รวม ( อัตรา )',
	'show_all' => 'ทั้งหมด',
	'budget_year_fill' => 'ปีงบประมาณ',
	
	'label_all' => 'รวม',
	'label_men' => 'ชาย',
	'label_women' => 'หญิง',
	/*ประวัติ สส*/
	'title'=>'คำนำหน้าชื่อ',
	'fname'=>'ชื่อตัว',
	'mname'=>'ชื่อรอง',
	'lname'=>'ชื่อสกุล',
	'pos_no'=>'เลขที่ตำแหน่ง',
	
	//'name'=>"ชื่อตัว-ชื่อรอง-ชื่อสกุล",
	'name'=>"ชื่อ-สกุล",
	'name_pdf'=>"ชื่อ-สกุล",
	'idcard'=>'เลขประจำตัวประชาชน',
	'birthday'=>'วัน/เดือน/ปี เกิด',
	'fax'=>'โทรสาร',
	'faxbkk'=>'โทรสารกรุงเทพฯ และปริมณฑล',
	'faxprov'=>'โทรสารต่างจังหวัด',
	'mobile2'=>'โทรศัพท์',
	'mobile'=>'โทรศัพท์เคลื่อนที่',
	'mobile4'=>'โทรศัพท์เคลื่อนที่ 1',
	'mobile5'=>'โทรศัพท์เคลื่อนที่ 2',
	'email'=>'e-Mail',
        'zipcode'=>'รหัสไปรษณีย์',
        'telbkk'=>'โทรศัพท์กรุงเทพฯ และปริมณฑล',
	'telbkk1'=>'โทรศัพท์กรุงเทพฯ และปริมณฑล 1',
	'telbkk2'=>'โทรศัพท์กรุงเทพฯ และปริมณฑล 2',
        'telprov'=>'โทรศัพท์ต่างจังหวัด',
	'telprov1'=>'โทรศัพท์ต่างจังหวัด 1',
	'telprov2'=>'โทรศัพท์ต่างจังหวัด 2',
    'profile_history' => 'ประวัติการดำรงตำแหน่ง',    
	'label_date'=>'วัน',
	'label_month' => 'เดือน',
	'label_year'=>'ปี',
	
	/*ข้อมูลการตั้งค่าอัตรากำลัง*/
	'type_pos'=>'ประเภทตำแหน่ง',
	'level_pos'=>'ระดับตำแหน่ง',
	'pos_in'=>'ตำแหน่งในสายงาน',
	'type_shortname'=>'ชื่อย่อประเภทตำแหน่ง',
	'lv_seq'=>'ลำดับของระดับตำแหน่ง',
	
	/*เครื่องราชอิสริยาภรณ์*/
        'gaz_name'=>'ราชกิจจานุเบกษา',
        'decoration'=>'เครื่องราชอิสริยาภรณ์',
		'gaz_book'=>'เล่ม',
		'gaz_part'=>'ตอนที่',
		'doc_date'=>'วันที่',
        'gaz_page'=>'หน้า',
		'doc_vol'=>'เล่มที่',
        'dec_price'=>'ราคาชดใช้',
        'year_bdg'=>'ปีงบประมาณ',
		'spec_me'=>'ระบุ',
		'def'=>'ตระกูลเครื่องราชฯ',
		'dec'=>'เครื่องราชฯ',
 ); // arr_txt
//หมู่โลหิต
$arr_blood=array('A'=>'A','B'=>'B','O'=>'O','AB'=>'AB');
//เกียรตินิยม
$arr_act_honor=array('1'=>'ปกติ', '2'=>'อันดับ 1', '3'=>'อันดับ 2', '4'=>'เหรียญทอง');

//array config
$arr_act_status=array('1'=>'ใช้งาน', '0'=>'ไม่ใช้งาน');
$arr_travel_status=array('1'=>'ปกติ', '2'=>'ยกเลิก');
$arr_stw_status=array('1'=>'กลับมาปฏิบัติหน้าที่ ', '0'=>' หยุดปฏิบัติหน้าที่ ');
$arrCompenMan = array("1"=>"มีตำแหน่งบริหาร","2"=>"ไม่มีตำแหน่งบริหาร");
$arrCompenFor = array("1"=>"ข้าราชการ","2"=>"พนักงานราชการ","3"=>"ลูกจ้างประจำ","4"=>"คู่สมรสข้าราชการชั้นผู้ใหญ่");
$arr_el_type=array('1'=>'ต่ำกว่าปริญญาตรี', '2'=>'สูงกว่าปริญญาตรี');
$arr_ef_status=array('1'=>'ยังไม่กรอกข้อมูล', '2'=>'สมาชิกฯ กรอกข้อมูลแล้ว','3'=>'เจ้าหน้าที่กรอกข้อมูลแล้ว');
$arr_withdraw=array('1'=>'ยังไม่ได้เบิก', '2'=>'เบิกแล้ว','3'=>'ดำเนินการเรียบร้อยแล้ว');
$arr_tax_status=array('1'=>'นำมาหัก', '0'=>'ไม่นำมาหัก');



//arr type address
$arr_address = array(
	'1'=>'ที่อยู่ตามทะเบียนบ้าน',
	'2'=>'ที่อยู่ตามภูมิลำเนา',
	'3'=>'ที่อยู่สามารถติดต่อได้',
	'4'=>'ที่อยู่ตามใบรับรองการหักภาษี',
	'5'=>'ที่อยู่ปัจจุบัน',
	'6'=>'ที่อยู่สำหรับจัดส่งเอกสาร ',
);
$arr_address_ss = array(
	'3'=>'ภูมิลำเนา',
	'4'=>'ที่อยู่ปัจจุบัน',
	'6'=>'สถานที่ติดต่อสำหรับส่งเอกสารและเผยแพร่  ',
	'8'=>'สถานที่ติดต่อสำหรับส่งเอกสารและเผยแพร่ ๒ ',
	'1'=>'ที่อยู่ตามทะเบียนบ้าน',
	'2'=>'ที่อยู่ตามใบรับรองการหักภาษี',
	'7'=>'ที่อยู่สามารถติดต่อได้'
);


//arr type address
$arr_address_sp = array(
	'2'=>'ที่อยู่ปัจจุบัน',
	'3'=>'สถานที่ติดต่อสำหรับส่งเอกสารและเผยแพร่',
	'4'=>'ที่อยู่ตามทะเบียนบ้าน',
	'5'=>'ที่อยู่สามารถติดต่อได้'
);


//ประเภทอาชีพ
$arr_emploment_type = array(
	
);


$arr_data = array(
	'ampr_name'=>'อำเภอ',
	'country_name'=>'ประเทศ',
	'degree'=>'วุฒิการศึกษา',
	'institute'=>'สถาบันศึกษา',
	'edu_lv'=>'ระดับการศึกษา',
	'edu_major'=>'สาขาวิชาเอก',
	'job_name'=>'อาชีพ',
	'nation'=>'สัญชาติ/เชื้อชาติ',
	'prefix'=>'คำนำหน้าชื่อ',
	'religion'=>'ศาสนา',
	'tamb'=>'ตำบล',
	'ampr'=>'อำเภอ',
	'zone'=>'ภูมิภาคตามภูมิศาสตร์',
	'heir'=>'ประเภทผู้สืบทอด',
	'reward'=>'การได้รับความดีความชอบ',
	'service_type'=>'ตำแหน่งที่ให้บริการราชการ',
	'service_title'=>'โครงการที่ให้บริการราชการพิเศษ',
);

$arr_pos_type_live = array(
	'1' => 'ปกติ',
	'2' => 'ปฏิบัติราชการแทน',
	'3' => 'รักษาการแทน',
	'4' => 'ช่วยราชการ'
);

$arr_pos_type_move = array(
	'1' => 'เปลี่ยนตำแหน่ง',
	'2' => 'เปลี่ยนสังกัด',
	'3' => 'เปลี่ยนทั้ง 2 อย่าง',
);
//สถานะของบุคคล   
$arr_per_status=array( 
	'2' => 'ปกติ',  
	'6' => 'เสียชีวิต' ,  
	'7' => 'สาบสูญ',
);
$arr_blood=array( 
	'1' => 'A', 
	'2' => 'B',  
	'3' => 'O',
	'4' => 'AB' 
);
$arr_space=array(
	'1'=>'เว้นวรรค',
	'0'=>'ไม่เว้นวรรค',
);
$arr_ins_type=array(
	'1'=>'รัฐบาล',
	'0'=>'เอกชน',
);
$arr_contact_type=array(
	'1'=>'บิดา',
	'2'=>'มารดา',
	'3'=>'ญาติ',
	'4'=>'เพื่อน',
);
$arr_report_age=array(
	'1'=>'25 - 35 ',
	'2'=>'36 - 45',
	'3'=>'46 - 55',
	'4'=>'56 - 65',
	'5'=>'66 - 75',
	'6'=>'76 - 80',
	'7'=>'81 - 85',
);
$arr_scholarship=array(
	'1'=>'ไม่ได้รับทุน',
	'2'=>'ได้รับทุน',
);
$arr_edu_type=array(
	'1'=>'วุฒิบรรจุ',
	'2'=>'วุฒิสูงสุด',
	'3'=>'วุฒิประกอบ'
);
$arr_hier_status=array(
	'1'=>'ปกติ',
	'2'=>'เสียชีวิต',
	'3'=>'ยกเลิก',
);
$arr_miss_type=array(
	'1'=>'ไม่ได้รับเงินเดือน',
	'2'=>'ลดเงินเดือน',
);
$arr_clere_result=array(
	'1'=>'มีผลย้อนหลัง (ยกเลิก)',
	'2'=>'ไม่มีผลย้อนหลัง',
);
$arr_absent_type=array(
	'1'=>'ลาทั้งวัน',
	'2'=>'ลาครึ่งวันเช้า',
	'3'=>'ลาครึ่งวันบ่าย',
);
$arr_absent_status=array(
	'1'=>'ลาปกติ',
	'2'=>'ยกเลิกการลา',
);
$arr_atten_absent=array(
	'1'=>'ลาประชุมล่วงหน้า',
	'0'=>'ไม่ลาประชุมล่วงหน้า',
);
$arr_late_type=array(
	'1'=>'สายปกติ',
	'2'=>'สายผ่อนผัน',
	'3'=>'ลา',
);
$arr_clear_result=array(
	'1'=>'มีผลย้อนหลัง (ยกเลิก)',
	'2'=>'ไม่มีผลย้อนหลัง',
);
$arr_miss_type=array(
	'1'=>'ไม่ได้รับเงินเดือน',
	'2'=>'ลดเงินเดือน',
);
$arr_rule=array(
	'crime_main'=>'ฐานความผิด',
	'crime_sub'=>'กรณีความผิด',
);
$arr_request_status=array(
	'1'=>'รอการอนุมัติ',
	'2'=>'อนุมัติแล้ว',
);
$arr_request_result=array(
	'1'=>'รอการอนุมัติ',
	'2'=>'อนุมัติ',
	'3'=>'ไม่อนุมัติ',
);
$arr_personal_type=array(
	'1'=>'ข้าราชการ',
	'2'=>'พนักงานราชการ',
	'3'=>'ลูกจ้าง',
);
$arr_approve_status=array(
	'1'=>'อนุมัติ',
	'2'=>'ไม่อนุมัติ',
);
$arr_marry_type=array(
	'1'=>'มีสิทธิขอเครื่องราชฯ',
	'2'=>'ไม่มีสิทธิขอเครื่องราชฯ',
);

$arr_competency_type=array(
	'competency_main'=>'ชื่อหัวข้อสมรรถนะหลัก',
	'competency_line'=>'ชื่อหัวข้อสมรรถนะในสายงาน',
	'competency_management'=>'ชื่อหัวข้อสมรรถนะในการบริหาร',
);
$arr_org_level=array(
	'2'=>'ทั่วไป',
	'1'=>'รัฐสภา',
);
$arr_mini_app = array(
	1 => 'เห็นชอบ',
	2 => 'ไม่เห็นชอบ'
);
$arr_military=array(
	'1'=>'เป็นชั้นทางทหาร',
	'0'=>'ปกติ',
);
$arr_dec = array(
	'1'=>'มีสิทธิ',
	'2'=>'ไม่มีสิทธิ',
);

$arr_study_status = array(
	'1' => 'อยู่ระหว่างการศึกษา',  
	'2' => 'สำเร็จการศึกษา',  
	'3' => 'ไม่สำเร็จการศึกษา'
);
//สถานะของการได้รับอนุมัติ
$arr_allowed_status = array(
	'1' =>'ได้รับอนุญาติ',
	'0' =>'ไม่ได้รับอนุญาติ',
);
//สถานะของการเกินกำหนด
$arr_over_status = array(
	'1' => 'ไม่เกินกำหนด',
	'0' => 'เกินกำหนด',
);
//สถานะการได้รับเงินเดือน
$arr_salary_status = array(
	'1' => 'ได้รับเงินเดือน',
	'0' => 'ไม่ได้รับเงินเดือน',
);



$arr_edu_level_m = array(
	'1'=>'ต่ำกว่าระดับปริญญาตรี',
	'2'=>'ระดับปริญญาตรี หรือเทียบเท่า',
	'3'=>'ระดับประกาศนียบัตรชั้นสูง (สูงกว่าปริญญาตรี)',
	'4'=>'ระดับปริญญาโท หรือเทียบเท่า',
	'5'=>'ระดับปริญญาเอก หรือเทียบเท่า',
	'6'=>'ปริญญากิตติมศักดิ/มหาบัณฑิตกิตติมศักดิ/ดุษฎีบัณฑิตกิติมศักดิ'
);



//ประเภทการเรียง
$arr_by_report = array(
	'asc'=>'น้อยไปหามาก',
	'desc'=>'มากไปหาน้อย'
);
//การรับค่าตอบแทน
$arr_benefit = array(
	'1'=>'รับค่าตอบแทน',
	'2'=>'ไม่รับค่าตอบแทน'
);
//ความสัมพันระหว่างผู้ค้ำประกัน
$arr_guaranty_relate = array(
	'1'=>'บิดา',
	'2'=>'มารดา', 
	'3'=>'พี่น้องร่วมบิดามารดา',
	'4'=>'หลักทรัพย์',
	'5'=>'อื่น ๆ'
);
//ประเภททุน
$arr_bugdet_type = array(
	'1' => 'ทุนส่วนตัว',  
	'2' => 'ทุนสำนักงานฯ',  
	'3' => 'ทุนภายนอก'
);
//สถานะของการศึกษา
$arr_edu_status = array(
	'1' => 'อยู่ระหว่างการลาศึกษา',  
	'2' => 'สำเร็จการศึกษา',  
	'3' => 'ไม่สำเร็จการศึกษา'
);
//ทะเบียนประวัติ
$arr_per_status_military = array(1=>'ไม่ต้องรับราชการทหาร', 2=>'ไม่เคยรับราชการทหาร', 3=>'รับราชการทหารแล้ว');
$arr_smarry_type_status=array('1'=>'โสด','2'=>'สมรส ', '3'=>' หย่า ', '4'=>'หม้าย');
$arr_gpf = array(1=>"เป็นสมาชิก", 2=>"ไม่เป็นสมาชิก");
$arr_status_moveup = array(0=>'ปกติ', 1=>'อยู่ระหว่างการประเมิน');
$arr_status_penalty = array(1=>'ไม่มี', 2=>'อยู่ระหว่างดำเนินการทางวินัย');
$arr_status_probation = array(0=>'รอกำหนดหัวข้อการประเมิน', 1=>'รอทดลองปฏิบัติราชการ ครั้งที่ 1', 2=>'รอทดลองปฏิบัติราชการ ครั้งที่ 2', 3=>'รอทดลองปฏิบัติราชการ ครั้งที่ 3', 4=>'ผ่าน รอทำคำสั่ง', 5=>'มีคำสั่งให้ผ่าน', 6=>'ไม่ผ่าน รอทำคำสั่ง', 7=>'มีคำสั่งให้ออกจากราชการ');
$arr_status_pension = array(1=>'ปกติ', 2=>'อยู่ระหว่างรอบันทึกขอ', 3=>'อยู่ระหว่างรออนุมัติ', 4=>'อนุมัติแล้ว');
$arr_status_civil = array(2=>'ยังรับราชการ', 3=>'โอน', 4=>'พ้นจากราชการ');
$arr_family_relation = array(1=>'บิดา', 2=>'มารดา', 3=>'คู่สมรส', 4=>'บุตร', 5=>'บุตรบุญธรรม');
$arr_family_status = array(1=>'มีชีวิต', 2=>'เสียชีวิต', 3=>'สาบสูญ');
$arr_marry_type = array(0=>'จดทะเบียนสมรส', 1=>'ไม่จดทะเบียนสมรส');
$arr_marry_status = array('1'=>'อยู่ระหว่างสมรส', '2'=>'หย่า', '3'=>'หม้าย');
$arr_protege_status = array(1=>'ยังรับเป็นบุตรบุญธรรม', 2=>'เลิกรับเป็นบุตรบุญธรรม');
$arr_train_type_act = array('1'=>'ฝึกอบรม', '2'=>'สัมมนา', '3'=>'ศึกษาดูงาน', '4'=>'เสวนา', '5'=>'แลกเปลี่ยนบุคลากร');
$arr_type_dev = array('1'=>'ทั่วไป', '2'=>'คุณธรรมจริยธรรม');
$arr_train_type_place = array('1'=>'ภายในประเทศ', '2'=>'ภายนอกประเทศ');
$arr_train_type_org = array('1'=>'ภายใน', '2'=>'ภายนอก'); 
$arr_train_type_attend = array('1'=>'เป็นผู้เข้าร่วม', '2'=>'เป็นวิทยากร');
$arr_special_type = array(1=>'คณะกรรมการ', 2=>'คณะอนุกรรมการ', 3=>'คณะทำงาน');
$arr_special_etype = array(1=>'อยู่ระหว่างดำเนินการ', 2=>'โครงการสำเร็จเสร็จสิ้น', 3=>'โครงการยุติไม่ประสบความสำเร็จ');


//การเลื่อนเงินเดือน
$arr_round = array(1 => 'รอบที่ 1 (1 ตุลาคม - 31 มีนาคม)', 2 => 'รอบที่ 2 (1 เมษายน - 30 กันยายน)'); //รอบการเลื่อนเงินเดือนข้าราชการ
$arr_emp_round = array(1 => '1 ตุลาคม - 30 กันยายน'); // รอบการเลื่อนพนักงานราชการ
$arr_emp_gov_round = array(1 => 'รอบที่ 1 (1 ตุลาคม - 31 มีนาคม)', 2 => 'รอบที่ 2 (1 เมษายน - 30 กันยายน)'); //รอบการเลื่อนลูกจ้างประจำ
//กรอบอัตรากำลัง
$arr_operating = array(1 => 'ERT');


//สถานะการคืน  เครื่องราช
$arr_dec_receive=array('1'=>'คืน', '2'=>'ชดใช้','0'=>'ยังไม่คืน');
$arr_dec_person=array ("1"=>"บุคลากรภายในสำนักงานฯ","2"=>"สมาชิกสภาผู้แทนราษฎร","3"=>"บุคคลในวงงานรัฐสภา");
//เครื่องราช
$arr_type_position=array ("1"=>"สมาชิกสภาผู้แทนราษฎร","2"=>"ตำแหน่งทางการเมือง","3"=>"ตำแหน่งคณะกรรมาธิการ");
$arr_type_person=array ("1"=>"ผู้ดำรงตำแหน่ง");
$arr_type_person2=array ("1"=>"ผู้ดำรงตำแหน่ง","2"=>"คู่สมรส");
$arr_return_by=array ("1"=>"เครื่องราชอิสริยาภรณ์","2"=>"ราคาชดใช้แทน");


//การขอค้ำประกันตัวผู้ต้องกา
$arr_type_evidence=array('1'=>'หนังสือรับรองการดำรงตำแหน่ง', '2'=>'บัตรประจำตัวเจ้าหน้าที่ของรัฐ');
$arr_guarantee_status=array('1'=>'อยู่ระหว่างพิจารณาคดี', '2'=>'สิ้นสุดคดีแล้ว');
$arr_coercion_status=array('0'=>'ไม่มีการบังคับคดี', '1'=>'มีการบังคับคดี');




//fixpic
#checkbox
$checkbox_yes = '<img src="../../images/checkbox_yes.png">';
$checkbox_no = '<img src="../../images/checkbox_no.png">';

//fix no_case
if($arr_group_pos){
	$gp=1;
	foreach($arr_group_pos as $key => $val){
		$case[$key]=$gp;
		$a_case.=($gp>1?"|":"").$key;
		$gp++;
	}
}
//fix no_case

$array_attache_report["at"] = "ที่";
$array_attache_report["sign_at"] = "ลงวันที่";

//config ประเทศ 
$default_country_id = 41;//ไทย

//config สัญชาติ เชื้อชาติ 
$default_nation_id = 3; //ไทย

//config ศาสนา 
$default_religion_id = 1; //พุทธ

//config จังหวัด 
$default_prov_id = 1; //กรุงเทพฯ

$report_menu = array();
 
$report_menu[1] = array('name'=>'รายงาน'.$arrCompenFor[1].' ตามรูปแบบ ก.พ. 7','report_id'=>1,'report_num'=>1); 
$report_menu[2] = array('name'=>'รายงานจำนวนผู้ปฎิบัติงานระดับ'.DEPARTMENT_OF_DISATER.'','report_id'=>2,'report_num'=>2);  
$report_menu[3] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'สังกัดปฎิบัติแยกตามประเภท ตำแหน่ง ระดับ','report_id'=>3,'report_num'=>3); 
$report_menu[4] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'จำแนกตามเพศ','report_id'=>4,'report_num'=>4);  
$report_menu[5] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'จำแนกตามระดับการศึกษา มหาวิทยาลัยและ ประเทศที่สำเร็จการศึกษา','report_id'=>5,'report_num'=>5);  
$report_menu[6] = array('name'=>'','report_id'=>6);  
$report_menu[7] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'จำแนกตามช่วงอายุ โครงสร้างอายุ'.$arrCompenFor[1],'report_id'=>7 ,'report_num'=>6);  
$report_menu[8] = array('name'=>'รายงานแสดงอัตราการเกษียณอายุราชการในแต่ละปีงบประมาณ','report_id'=>6,'report_num'=>7);  
$report_menu[9] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'จำแนกตามวุฒิการศึกษา / สาขาวิชาเอก','report_id'=>9,'report_num'=>8);  
$report_menu[10] = array('name'=>'จำนวน'.$arrCompenFor[1].'พลเรือนที่บรรจุใหม่ บรรจุกลับ รับโอน และการสูญเสียในกรณีต่างๆ','report_id'=>10,'report_num'=>9);  
$report_menu[11] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'ที่ย้ายภายในกรมป้องกันและบรรเทาสาธารณภัย','report_id'=>11,'report_num'=>10); 
$report_menu[12] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'ที่ย้ายระหว่างสายงานในปีงบประมาณ','report_id'=>12,'report_num'=>11); 
$report_menu[13] = array('name'=>'รายงานอัตราการเข้า - ออก'.$arrCompenFor[1].'ในปีงบประมาณ','report_id'=>13,'report_num'=>12); 
$report_menu[14] = array('name'=>'รายงานจำนวน'.$arrCompenFor[1].'ที่ได้รับการเลื่อนระดับ ในแต่ละปีงบประมาณ','report_id'=>14,'report_num'=>13); 
$report_menu[15] = array('name'=>'รายชื่อรายชื่อ'.$arrCompenFor[1].'ที่บรรจุในปีงบประมาณ','report_id'=>16); 
$report_menu[16] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].'ที่โอน ลาออก เสียชีวิต ในแต่ละปีงบประมาณ','report_id'=>172); 
$report_menu[17] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].'ทีได้่เลื่อนระดับในแต่ละปีงบประมาณ','report_id'=>18);
$report_menu[18] = array('name'=>'รายชื่อ'.$arrCompenFor[1].'ที่ย้ายระหว่างสายงานในแต่ละปีงบประมาณ','report_id'=>192);  
$report_menu[19] = array('name'=>'รายงาน'.$arrCompenFor[1].'ที่จะครบเกษียณอายุราชการล่วงหน้า 10 ปี','report_id'=>20); 
$report_menu[20] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].'ที่เกษียณอายุในสิ้นปีงบประมาณ','report_id'=>20); 
$report_menu[21] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].'ที่ดำรงตำแหน่งในระดับ เรียงตามลำดับอาวุโส พร้อมทั้งแสดงระยะเวลาในการดำรงตำแหน่ง','report_id'=>22); 
$report_menu[22] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].' ตามตำแหน่ง สังกัดกรอบและสังกัดปฎิบัติ','report_id'=>23);
$report_menu[23] = array('name'=>'รายงานข้อมูล'.$arrCompenFor[1].' ที่ผ่านการฝึกอบรมหลักสูตรแยกตามสำนัก/กอง','report_id'=>24); 
$report_menu[24] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].'จำแนกตามตำแหน่งในการบริหารงานและสังกัด','report_id'=>27); 
$report_menu[25] = array('name'=>'รายงานกรอบอัตรากำลัง'.$arrCompenFor[1].'จำแนกตามสายงาน ระดับตำแหน่ง คนครอง และ อัตราว่าง','report_id'=>28); 
$report_menu[26] = array('name'=>'รายงานสรุปข้อมูลราชการส่งสำนักงาน ก.พ. และ ส่งออกข้อมูลในลักษณะ CSV','report_id'=>291); 
$report_menu[27] = array('name'=>'รายงานอัตรากำลัง'.$arrCompenFor[1].'แต่ละประเภทแยกตามสังกัดหน่วยงานตามกรอบ ','report_id'=>30);
$report_menu[28] = array('name'=>'รายงานสรุปข้อมูลอัตรากำลัง'.$arrCompenFor[1].'ตามประเภท และตำแหน่ง','report_id'=>31); 
$report_menu[29] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[1].'ผู้ที่ได้รับพระราชทานเครื่องราชอิสริยาภรณ์ในแต่ละปี','report_id'=>32);  
$report_menu[30] = array('name'=>'รายงานจำนวนตำแหน่งจำแนกตามสถานภาพและลักษณะของตำแหน่ง','report_id'=>33); 
$report_menu[31] = array('name'=>'รายงานจำนวนตำแหน่งจำแนกตามลักษณะของตำแหน่ง','report_id'=>34); 
$report_menu[32] = array('name'=>'รายงานรายชื่อตำแหน่งว่าง ','report_id'=>35);  
$report_menu[33] = array('name'=>'รายงานจำนวนตำแหน่งจำแนกตามประเภทตำแหน่ง','report_id'=>36);
$report_menu[34] = array('name'=>'รายงานสำหรับผู้ปฎิบัติงาน และผู้บริหาร โดยสามารถส่งออกข้อมูลในลักษณะ CSV','report_id'=>37);
$report_menu[35] = array('name'=>'รายงานรายชื่อการลาแต่ละประเภทของ'.$arrCompenFor[1],'report_id'=>38); 

$report_menu[191] = array('name'=>'รายงานรายชื่อข้าราชการที่ปฎิบัติราชการแทน / รักษาราชการแทน', 'report_id'=>39);

// พนักงานราชการ มีรายละเอียดดังนี้  1.3.3

$report_menu[36] = array('name'=>'รายงานข้อมูล'.$arrCompenFor[2].' ตามรูปแบบ ก.พ. 7','report_id'=>1); //1
$report_menu[37] = array('name'=>'รายงานจำนวน'.$arrCompenFor[2].'ผู้ปฎิบัติงาน'.DEPARTMENT_OF_DISATER,'report_id'=>2); //2
$report_menu[38] = array('name'=>'รายงานจำนวน'.$arrCompenFor[2].'สังกัดปฎิบัติตามจำแนกตามตำแหน่ง กลุ่มงาน','report_id'=>311); //3.1
$report_menu[39] = array('name'=>'รายงานจำนวน'.$arrCompenFor[2].'จำแนกตามเพศ','report_id'=>4);    //3.2
$report_menu[40] = array('name'=>'รายงานจำนวน'.$arrCompenFor[2].'จำแนกตามช่วงอายุ โครงสร้างอายุ'.$arrCompenFor[2],'report_id'=>7); //3.3 
$report_menu[41] = array('name'=>'รายงานแสดงอัตรา'.$arrCompenFor[2].'ที่ออกจากราชการในปีงบประมาณ','report_id'=>6);  //4.1
$report_menu[42] = array('name'=>'รายงานจำนวน'.$arrCompenFor[2].'ที่ย้ายภายในกรมป้องกันและบรรเทาสาธารณภัย','report_id'=>11); //12 //4.2 
$report_menu[43] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[2].'ที่ลาออก เสียชีวิต ในแต่ละปีงบประมาณ','report_id'=>172); //   17 //4.3
$report_menu[44] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[2].'ที่ย้ายไปปฎิบัติ ระหว่างสำนัก / กอง ในปีงบประมาณ','report_id'=>19); //4.4  
$report_menu[45] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[2].'จำแนกตามสังกัดกรอบ และสังกัดปฎิบัติ','report_id'=>23);  //5
$report_menu[46] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[2].'ที่ได้รับพระราชทานเครื่องราชอิสริยาภรณ์ในแต่ละปี','report_id'=>32); //6  
$report_menu[47] = array('name'=>'รายงานการลาแต่ละประเภทของ '.$arrCompenFor[2],'report_id'=>38); //7
$report_menu[48] = array('name'=>'รายงานสำหรับผู้ปฎิบัติงาน และผู้บริหาร โดยสามารถส่งออกข้อมูลในลักษณะ CSV','report_id'=>291);  //8
 
// ลูกจ้างประจำ มีรายละเอียดดังต่อไปนี้      

$report_menu[49] = array('name'=>'รายงานข้อมูล'.$arrCompenFor[3].'ตามรูปแบบของ ก.พ. 7','report_id'=>1);   // 1
$report_menu[50] = array('name'=>'รายงานกรอบอัตรากำลังของ'.$arrCompenFor[3].'และจำนวนผู้ที่ปฎิบัติงานอยู่จริงในภาพรวมของลูกจ้างประจำ'.DEPARTMENT_OF_DISATER,'report_id'=>2);  //2
$report_menu[51] = array('name'=>'รายงานจำนวน'.$arrCompenFor[3].'สังกัดปฎิบัติแยกตามกลุ่มงาน ตำแหน่งในสายงาน ระดับ','report_id'=>3);  //3.1
$report_menu[52] = array('name'=>'รายงานจำนวน'.$arrCompenFor[3].'จำแนกตามเพศ','report_id'=>4);   //3.2
$report_menu[53] = array('name'=>'รายงานจำนวน'.$arrCompenFor[3].'จำแนกตามช่วงอายุ โครงสร้างอายุ'.$arrCompenFor[3],'report_id'=>7);   //3.3
$report_menu[54] = array('name'=>'อัตราการเกษียณอายุของ'.$arrCompenFor[3].'ในแต่ละปี','report_id'=>6); //8 //3.4
$report_menu[55] = array('name'=>'จำแนก'.$arrCompenFor[3].'ที่ออกจากราชการในปีงบประมาณ','report_id'=>172); //4.1
$report_menu[56] = array('name'=>'จำนวน'.$arrCompenFor[3].'ที่ย้ายระหว่างสำนัก / กอง ในปีงบประมาณ','report_id'=>11); //12 //4.2 
$report_menu[57] = array('name'=>'จำนวน'.$arrCompenFor[3].'ที่ได้รับการเลื่อนระดับ ตำแหน่ง','report_id'=>14); //4.3
$report_menu[58] = array('name'=>'รายชื่อ'.$arrCompenFor[3].'ที่ลาออก เสียชีวิต ในแต่ละปีงบประมาณ','report_id'=>172); // 17  //4.4
$report_menu[59] = array('name'=>'รายชื่อ'.$arrCompenFor[3].'ที่ย้ายระหว่างสำนัก / กอง ในปีงบประมาณ','report_id'=>19);  //4.5
$report_menu[60] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[3].'ที่เกษียณอายุในสิ้นปีงบระมาณ','report_id'=>20); // 21  //5
$report_menu[61] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[3].'ตามตำแหน่งสังกัดกรอบ และสังกัดปฎิบัติ','report_id'=>23);   //6
$report_menu[62] = array('name'=>'รายงาน'.$arrCompenFor[3].'ที่จะครบเกษียณอายุราชการล่วงหน้า 10 ปี','report_id'=>20);  //21  //7
$report_menu[63] = array('name'=>'รายงานรายชื่อ'.$arrCompenFor[3].'ผู้ที่ได้รับพระราชทานเครื่องราชอิสริยาภรณ์ในแต่ละปี','report_id'=>32);  //8 
$report_menu[64] = array('name'=>'รายงานสำหรับผู้ปฎิบัติงาน และผู้บริหาร โดยสามารถส่งออกข้อมูลในลักษณะ CSV','report_id'=>291); //9
$report_menu[65] = array('name'=>'รายงานการลาแต่ละประเภทของ'.$arrCompenFor[3],'report_id'=>38); //10
$report_menu[66] = array('name'=>'','report_id'=>68); 
// การเลื่อนเงินเดือน

$report_menu[201] = array('name'=>'การจัดสรรวงเงินให้สำนัก / ศูนย์ / กอง / หน่วยงาน ','report_id'=>1); 
$report_menu[202] = array('name'=>'การจัดสรรวงเงินให้สำนักงานป้องกันและบรรเทาสาธารณภัยจังหวัด  ','report_id'=>2); 
$report_menu[203] = array('name'=>'บัญชีการบริหารวงเงินงบประมาณในการพิจารณาเลื่อนเงินเดือนตามผลการประเมินผลการปฎิบัติราชการ  ','report_id'=>3); 
/*
// รายงานใหม่ การเลื่อนเงินเดือน

$report_menu[204] = array('name'=>'บัญชีรายละเอียดการเลื่อนค่าตอบแทนของพนักงานราชการ แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER. ' ที่ ๘๙๑ / ๒๕๕๕ ลงวันที่ ๓๐ พ.ย. ๒๕๕๕ ' , 'report_id'=>204);
$report_menu[205] = array('name'=>'บัญชีรายละเอียดการให้พนักงานราชการได้รับเงินเพิ่มการครองชีพชั่วคราว แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER. ' ที่ ๘๙๒ / ๒๕๕๕ ลงวันที่ ๓๐ พ.ย. ๒๕๕๕ ' , 'report_id'=>205);

$report_menu[206] = array('name'=>'บัญชีรายละเอียดการเลื่อนเงินเดือนข้าราชการ แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER. ' ที่ ๕๗๙ / ๒๕๕๗ ลงวันที่ ๒๒ ก.ค. ๒๕๕๗ '  , 'report_id'=>206);
$report_menu[207] = array('name'=>'บัญชีรายละเอียดให้ข้าราชการได้รับเงินเพิ่มการครองชีพชั่วคราวรายเดือน แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER. ' ที่ ๕๗๒ / ๒๕๕๗ ลงวันที่ ๒๕ ก.ค. ๒๕๕๗ '  , 'report_id'=>207);
$report_menu[208] = array('name'=>'บัญชีรายละเอียดค่าตอบแทนพิเศษข้าราชการ แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER . ' ที่ ๕๘๐ / ๒๕๕๗ ลงวันที่ ๒๒ ก.ค. ๒๕๕๗ ' , 'report_id' => 208);
$report_menu[209] = array('name'=>'บัญชีการบริหารวงเงินงบประมาณในการพิจารณาเลื่อนเงินเดือนตามผลการประเมินผลการปฎิบัติราชการ' , 'report_id'=>209);
$report_menu[210] = array('name'=>'บัญชีแสดงรายละเอียดผลการพิจารณาเลื่อนเงินเดือนข้าราชการที่ปฎิบัติราชการในราชการบริหารส่วนกลาง ( '.DEPARTMENT_OF_DISATER.' ) ', 'report_id'=>210);

// การเลือนขั้นเงินเือน ลูกจ้าง 
$report_menu[301] = array('name' =>'บัญชีรายละเอียดค่าตอบแทนพิเศษลููกจ้างประจำ แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER. ' ที่ ๐๓๖ / ๒๕๕๗ ลงวันที่ ๑๕ ม.ค. ๒๕๕๗ ' , 'report_id'=>301);
$report_menu[302] = array('name'=>'บัญชีรายละเอียดการเลื่อนขั้นค่าจ้างลูกจ้างประจำ แนบท้ายคำสั่ง'.DEPARTMENT_OF_DISATER. ' ที่ ๐๓๔ / ๒๕๕๗ ลงวันที่ ๑๕ ม.ค. ๒๕๕๗ ' , 'report_id'=>302);
 // $report_menu
*/

// รายงานใหม่ การเลื่อนเงินเดือน

$report_menu[204] = array('name'=>'บัญชีแนบท้ายคำสั่ง ให้เลื่อนค่าตอบแทน' , 'report_id'=>204);
$report_menu[205] = array('name'=>'บัญชีแนบท้ายคำสั่ง ให้ได้รับเงินเพิ่มการครองชีพชั่วคราว ' , 'report_id'=>205);

$report_menu[206] = array('name'=>'บัญชีแนบท้ายคำสั่ง บัญชีแนบท้ายคำสั่งเลื่อนเงินเดือน'  , 'report_id'=>206);
$report_menu[207] = array('name'=>'บัญชีแนบท้าย คำสั่งให้ได้รับเงินเพิ่มการครองชีพชั่วคราว  '  , 'report_id'=>207);
$report_menu[208] = array('name'=>'บัญชีแนบท้าย คำสั่งให้ได้รับค่าตอบแทนพิเศษ ' , 'report_id' => 208);
$report_menu[209] = array('name'=>'บัญชีการบริหารวงเงินงบประมาณในการพิจารณาเลื่อนเงินเดือนตามผลการประเมินผลการปฎิบัติราชการ' , 'report_id'=>3);
$report_menu[210] = array('name'=>'บัญชีแสดงรายละเอียดผลการพิจารณาเลื่อนเงินเดือนข้าราชการที่ปฎิบัติราชการในราชการบริหารส่วนกลาง ( '.DEPARTMENT_OF_DISATER.' ) ', 'report_id'=>210);
$report_menu[211] = array('name'=>'หนังสือแจ้งผลการเลื่อนเงินเดือน', 'report_id'=>2111);
// การเลือนขั้นเงินเือน ลูกจ้าง 
$report_menu[301] = array('name' =>'บัญชีแนบท้ายคำสั่ง ให้ได้รับค่าตอบแทนพิเศษ  ' , 'report_id'=>301);
$report_menu[302] = array('name'=>' บัญชีแนบท้ายคำสั่ง คำสั่งเลื่อนค่าจ้าง   ' , 'report_id'=>302);
 // $report_menu

 
//  report ที่เป็นประเภทแนบท้ายคำสั่งกรมป้องกันและบรรเทา 
$attached_report = array(203, 204, 205, 206, 207, 208, 301, 302); 

$arr_gender[1] = "ชาย";
$arr_gender[2] = "หญิง";
 
 

		$sql_get_value = ' SELECT a.PER_ID FROM PER_PROFILE a ';
		$sql_get_value .= 'LEFT JOIN POSITION_FRAME b ON a.POS_ID = b.POS_ID ';
		$sql_get_value .= ' WHERE a.PER_STATUS =2 AND a.ACTIVE_STATUS = 1 AND a.PER_STATUS_CIVIL = 2 ';

$csv_title_name = array();

// ข้าราชการ_ปัจจุบัน  
$csv_tite_name[1] = array('name'=>'ลำดับ' , 'value'=>1 ,'cssadj'=>'CENTER_TOP');
$csv_tite_name[2] = array('name'=>'เลขที่ตำแหน่ง' , 'value'=>2,'cssadj'=>'CENTER_TOP');
$csv_tite_name[3] = array('name'=>'เลขบัตรประชาชน' , 'value'=>3,'cssadj'=>'CENTER_TOP');
$csv_tite_name[4] = array('name'=>'เพศ' , 'value'=>4,'cssadj'=>'CENTER_TOP');
$csv_tite_name[5] = array('name'=>'สถานะตำแหน่ง' , 'value'=>5,'cssadj'=>'CENTER_TOP');
$csv_tite_name[6] = array('name'=>'คำนำ' , 'value'=>6,'cssadj'=>'CENTER_TOP');
$csv_tite_name[7] = array('name'=>'ชื่อ' , 'value'=>7,'cssadj'=>'CENTER_TOP');
$csv_tite_name[8] = array('name'=>'นามสกุล' , 'value'=>8,'cssadj'=>'CENTER_TOP');
$csv_tite_name[9] = array('name'=>'ประเภทตำแหน่ง' , 'value'=>9,'cssadj'=>'CENTER_TOP');
$csv_tite_name[10] = array('name'=>'โอนมา' , 'value'=>10,'cssadj'=>'CENTER_TOP');
$csv_tite_name[11] = array('name'=>'วันเกิด' , 'value'=>11,'cssadj'=>'CENTER_TOP');
$csv_tite_name[12] = array('name'=>'วันบรรจุ' , 'value'=>12,'cssadj'=>'CENTER_TOP');
$csv_tite_name[13] = array('name'=>'บรรจุกลับ' , 'value'=>13,'cssadj'=>'CENTER_TOP');
$csv_tite_name[14] = array('name'=>'วันเข้าสู่ระดับปัจจุบัน' , 'value'=>14,'cssadj'=>'CENTER_TOP');
$csv_tite_name[15] = array('name'=>'อำนวยการสูง' , 'value'=>15,'cssadj'=>'CENTER_TOP');
$csv_tite_name[16] = array('name'=>'อำนวยการต้น' , 'value'=>16,'cssadj'=>'CENTER_TOP');
$csv_tite_name[17] = array('name'=>'เชี่ยวชาญ' , 'value'=>17,'cssadj'=>'CENTER_TOP');
$csv_tite_name[18] = array('name'=>'ชำนาญการพิเศษ (ออกจาก อต.)' , 'value'=>18,'cssadj'=>'CENTER_TOP');
$csv_tite_name[19] = array('name'=>'ชำนาญการพิเศษ' , 'value'=>19,'cssadj'=>'CENTER_TOP');
$csv_tite_name[20] = array('name'=>'ชำนาญการ' , 'value'=>20,'cssadj'=>'CENTER_TOP');
$csv_tite_name[21] = array('name'=>'ปฏิบัติการ' , 'value'=>21,'cssadj'=>'CENTER_TOP');
$csv_tite_name[22] = array('name'=>'อาวุโส' , 'value'=>22,'cssadj'=>'CENTER_TOP');
$csv_tite_name[23] = array('name'=>'ชำนาญงาน' , 'value'=>23,'cssadj'=>'CENTER_TOP');
$csv_tite_name[24] = array('name'=>'ปฏิบัติงาน' , 'value'=>24,'cssadj'=>'CENTER_TOP');
$csv_tite_name[25] = array('name'=>'วันดำรงตำแหน่งปัจจุบัน' , 'value'=>25,'cssadj'=>'CENTER_TOP');
$csv_tite_name[26] = array('name'=>'วันเกษียณ' , 'value'=>26,'cssadj'=>'CENTER_TOP');
$csv_tite_name[27] = array('name'=>'เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก 1 ต.ค.- 30 มี.ค. ' , 'value'=>27,'cssadj'=>'CENTER_TOP');
$csv_tite_name[28] = array('name'=>'เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง 1 เม.ย. - 30 ก.ย. ' , 'value'=>28,'cssadj'=>'CENTER_TOP');
$csv_tite_name[29] = array('name'=>'ร้อยละในปีงบประมาณ ช่วง 6 เดือนแรก 1 ต.ค.- 30 มี.ค.' , 'value'=>29,'cssadj'=>'CENTER_TOP');
$csv_tite_name[30] = array('name'=>'ร้อยละในปีงบประมาณ ช่วง 6 เดือนหลัง 1 เม.ย. - 30 ก.ย. ' , 'value'=>30,'cssadj'=>'CENTER_TOP');
$csv_tite_name[31] = array('name'=>'ค่าตอบแทนรายเดือน' , 'value'=>31,'cssadj'=>'CENTER_TOP');
$csv_tite_name[32] = array('name'=>'ระดับบรรจุ' , 'value'=>32,'cssadj'=>'CENTER_TOP');
$csv_tite_name[33] = array('name'=>'ชื่อตำแหน่งที่บรรจุ' , 'value'=>33,'cssadj'=>'CENTER_TOP');
$csv_tite_name[34] = array('name'=>'เงินประจำตำแหน่ง' , 'value'=>34,'cssadj'=>'CENTER_TOP');
$csv_tite_name[35] = array('name'=>'ตำแหน่งในการบริหาร' , 'value'=>35,'cssadj'=>'CENTER_TOP');
$csv_tite_name[36] = array('name'=>'ตำแหน่งที่รักษาการ/ปฏิบัติราชการแทน' , 'value'=>36,'cssadj'=>'CENTER_TOP');
$csv_tite_name[37] = array('name'=>'ส่วนงาน/กลุ่มงาน/ฝ่าย (ที่รักษาการ/ปฏิบัติราชการแทน)' , 'value'=>37,'cssadj'=>'CENTER_TOP');
$csv_tite_name[38] = array('name'=>'ตำแหน่งในสายงาน (กรอบ)' , 'value'=>38,'cssadj'=>'CENTER_TOP');
$csv_tite_name[39] = array('name'=>'ประเภท' , 'value'=>39,'cssadj'=>'CENTER_TOP');
$csv_tite_name[40] = array('name'=>'ระดับปัจจุบัน' , 'value'=>40,'cssadj'=>'CENTER_TOP');
$csv_tite_name[41] = array('name'=>'รหัสระดับตำแหน่ง' , 'value'=>41,'cssadj'=>'CENTER_TOP');
$csv_tite_name[42] = array('name'=>'ระดับ (กรอบ)' , 'value'=>42,'cssadj'=>'CENTER_TOP');
$csv_tite_name[43] = array('name'=>'กลุ่มงาน/ฝ่าย51' , 'value'=>43,'cssadj'=>'CENTER_TOP');
$csv_tite_name[44] = array('name'=>'สังกัดปฏิบัติ' , 'value'=>44,'cssadj'=>'CENTER_TOP');
$csv_tite_name[45] = array('name'=>'สังกัดกรอบ' , 'value'=>45,'cssadj'=>'CENTER_TOP');


// พนักงานราชการ 1132
$csv_title_name2 = array();
$csv_tite_name2[1] = array('name'=>'ลำดับ' , 'value'=>1 ,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[2] = array('name'=>'เลขที่ตำแหน่ง' , 'value'=>2,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[3] = array('name'=>'เลขบัตรประชาชน' , 'value'=>3,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[4] = array('name'=>'เพศ' , 'value'=>4,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[5] = array('name'=>'สถานะตำแหน่ง' , 'value'=>5,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[6] = array('name'=>'คำนำ' , 'value'=>6,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[7] = array('name'=>'ชื่อ' , 'value'=>7,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[8] = array('name'=>'นามสกุล' , 'value'=>8,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[9] = array('name'=>'วันเกิด' , 'value'=>9,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[10] = array('name'=>'วันบรรจุ' , 'value'=>10,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[11] = array('name'=>'ระยะเวลาเริ่มจ้าง' , 'value'=>11,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[12] = array('name'=>'สิ้นสุดการจ้าง' , 'value'=>12,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[13] = array('name'=>'เลขที่สัญญาจ้าง' , 'value'=>13,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[14] = array('name'=>'ปีสัญญาจ้าง' , 'value'=>14,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[15] = array('name'=>'28_จำนวนครั้งที่ทำสัญญา' , 'value'=>15,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[16] = array('name'=>'ค่าตอบแทนในรอบปีงบประมาณ 1 ต.ค.' , 'value'=>16,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[17] = array('name'=>'ร้อยละในรอบปีงบประมาณ 1 ต.ค.' , 'value'=>17,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[18] = array('name'=>'ตำแหน่งสายงาน' , 'value'=>18,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[19] = array('name'=>'ด้าน' , 'value'=>19,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[20] = array('name'=>'กลุ่มงาน' , 'value'=>20,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[21] = array('name'=>'ประเภทภารกิจ' , 'value'=>21,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[22] = array('name'=>'สังกัดปฏิบัติ ' , 'value'=>22,'cssadj'=>'CENTER_TOP');
$csv_tite_name2[23] = array('name'=>'สังกัดกรอบ ' , 'value'=>23,'cssadj'=>'CENTER_TOP');

// ลูกจ้าง 2339
$csv_title_name3 = array();
$csv_tite_name3[1] = array('name'=>'ลำดับ' , 'value'=>1 ,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[2] = array('name'=>'เลขบัตรประชาชน' , 'value'=>2,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[3] = array('name'=>'เพศ' , 'value'=>3,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[4] = array('name'=>'คำนำ' , 'value'=>4,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[5] = array('name'=>'ชื่อ' , 'value'=>5,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[6] = array('name'=>'นามสกุล' , 'value'=>6,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[7] = array('name'=>'วันเกิด พ.ศ.' , 'value'=>7,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[8] = array('name'=>'วันบรรจุ พ.ศ.' , 'value'=>8,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[9] = array('name'=>'วันเกษียณ พ.ศ.' , 'value'=>9,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[10] = array('name'=>'เข้าสู่ระดับปัจจุบัน' , 'value'=>10,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[11] = array('name'=>'ค่าจ้างในปีงบประมาณ ช่วง 6 เดือนแรก 1 ต.ค.- 30 มี.ค.' , 'value'=>11,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[12] = array('name'=>'ค่าจ้างในปีงบประมาณ ช่วง 6 เดือนหลัง 1 เม.ย. - 30 ก.ย.' , 'value'=>12,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[13] = array('name'=>'ขั้นในปีงบประมาณ ช่วง 6 เดือนแรก 1 ต.ค.- 30 มี.ค.' , 'value'=>13,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[14] = array('name'=>'ขั้นในปีงบประมาณ ช่วง 6 เดือนหลัง  1 เม.ย. - 30 ก.ย.' , 'value'=>14,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[15] = array('name'=>'เลขที่ตำแหน่ง' , 'value'=>15,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[16] = array('name'=>'ตำแหน่งตามระบบใหม่' , 'value'=>16,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[17] = array('name'=>'ระดับ' , 'value'=>17,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[18] = array('name'=>'กลุ่มงาน' , 'value'=>18,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[19] = array('name'=>'สังกัดปฏิบัติ' , 'value'=>19,'cssadj'=>'CENTER_TOP');
$csv_tite_name3[20] = array('name'=>'สังกัดกรอบ' , 'value'=>20,'cssadj'=>'CENTER_TOP');



$age_between = array();
$age_between[1] = array('name'=>'ต่ำกว่า 20 ปีบริบูรณ์','value'=>1);
$age_between[2] = array('name'=>'ระหว่าง 20 - 29 ปีบริบูรณ์','value'=>2);
$age_between[3] = array('name'=>'ระหว่าง 30 - 39 ปีบริบูรณ์','value'=>3);
$age_between[4] = array('name'=>'ระหว่าง 40 - 49 ปีบริบูรณ์','value'=>4);
$age_between[5] = array('name'=>'ระหว่าง 50 - 60 ปีบริบูรณ์','value'=>5);
$age_between[6] = array('name'=>'สูงกว่า 60  ','value'=>6);
 
/* css replace */

$replace_line = "border:solid 1px #000000;";

$adjust_top = array();
$adjust_top['CENTER_TOP'] = " align='center' valign='top' style='border:solid 1px #000000; ' ";
$adjust_top['LEFT_TOP'] =   " align='left' valign='top' style='border:solid 1px #000000; ' ";
$adjust_top['RIGHT_TOP'] = " align='right' valign='top' style='border:solid 1px #000000; ' ";

$CENTER_TOP = " align='center' valign='top' style='border:solid 1px #000000; ' ";
$LEFT_TOP = " align='left' valign='top' style='border:solid 1px #000000; ' ";
$RIGHT_TOP = " align='right' valign='top' style='border:solid 1px #000000; ' ";

$CENTER_TOP_HTML = " align='center' valign='top'   ";
$LEFT_TOP_HTML  = " align='left' valign='top'  ";
$RIGHT_TOP_HTML  = " align='right' valign='top'   ";

$GLOBALS['CENTER_TOP_HTML'] = $CENTER_TOP_HTML;
$GLOBALS['LEFT_TOP_HTML'] = $LEFT_TOP_HTML;
$GLOBALS['RIGHT_TOP_HTML'] = $RIGHT_TOP_HTML;

$start_div_reportmenu = ' class="col-xs-12 col-md-6" ';
$tr_detail_style = "  style='height:0.7cm;' ";

$number_subfix = ". ";

?>