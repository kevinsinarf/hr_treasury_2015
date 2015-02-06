var url_process = "process/record_level_salary1_org_process.php";
$(document).ready(function(){	   
	if(isMobile.any() == "null"){				   
		$(window).scroll(function(){
			$('#myModal').css({
				'margin-top': function () {
					return window.pageYOffset
				}
			});
		});
	}
	
	 
});

function searchData(){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	$("#page").val(1);
	$('#proc').val('search');
	$("#frm-search").submit();
}

function editData(id){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	$("#proc").val("edit");
	$("#LEVEL_ID").val(id);
	$("#frm-search").attr("action","record_up_salary_mg_form.php").submit();
}
function getPercent(score, id_tb,per_id){
	var url = 'process/record_level_salary1_org_process.php';
	$.post(url,{proc: 'getPercent',score: score, id_tb: id_tb, S_YEAR_BDG : $('#S_YEAR_BDG').val(), S_ROUND : $('#S_ROUND').val(), PER_ID:per_id}
	,function(data){	
		$('#SCORE_ID_'+id_tb).val(data['SCORE_ID']);
		$('#SCORE_PERCENT_'+id_tb).val(data['PERCENT']);
		$('#LEVEL_SALARY_MAX_'+id_tb).val(data['SALARY_MAX']);
		getSalaryCal(id_tb);
	},'json');
}

function getSalaryCal(id_tb){
	//คำนวณหาค่าเปอร์เซ็น
	var SALARY_UP = 0; //เงินที่ได้เลื่อน
	var  SPAC_COM = 0;    //ค่าตอบแทนพิเศษ
	var SALARY_CAL = 0; // เงินที่ปัดเป็นหลักสิบ
	var SALARY = 0; // เงินเดือนหลังจากการเลื่อน
	
	var MAX = $('#LEVEL_SALARY_MAX_'+id_tb).val().split(",").join(""); //เงินเดือนขั้นสูงของระดับที่ถือครอง
	var SCORE_PERCENT = $('#SCORE_PERCENT_'+id_tb).val().split(",").join("");  //ค่าเปอร์เซ็น
	var LEVEL_SALARY_MID = $('#LEVEL_SALARY_MID_'+id_tb).val().split(",").join("");  //ฐานคำนวณ
	var SALARY_NOW = $('#SALARY_NOW_'+id_tb).val().split(",").join("") //เงินเดือนปัจจุบัน
	
	if(SCORE_PERCENT == '')	{
		SCORE_PERCENT = 0;
	}
	if(LEVEL_SALARY_MID == ''){
		SCORE_PERCENT = 0
	}
	if(SALARY_NOW == ''){
		SALARY_NOW = 0;
	}
	
	
	SCORE_PERCENT = parseFloat(SCORE_PERCENT);  //ค่าเปอร์เซ็น
    LEVEL_SALARY_MID = parseFloat(LEVEL_SALARY_MID);  //ฐานคำนวณ
	SALARY_NOW = parseFloat(SALARY_NOW)//เงินเดือนปัจจุบัน
	MAX = parseFloat(MAX);
	
	SALARY_UP = (SCORE_PERCENT*LEVEL_SALARY_MID)/100;  
	SALARY_CAL = Math.round((SALARY_UP/10),0)*10;  
	SALARY  = SALARY_CAL + SALARY_NOW;  // เงินเดือนใหม่
	//เช็คว่าเปอร์เซ็นเกิน
	
	if(SALARY>MAX){
		//ถ้าเกินให้เอาค่า salary_slip ลบค่า max 
		SPAC_COM =  SALARY-MAX;
		$('#shw_salary_new_'+id_tb).html(number_format_return(MAX));
		$('#SHW_NEW_'+id_tb).val(number_format_return(MAX));
		$("#SALARY_SPE_UP_"+id_tb).val(number_format_return(SPAC_COM,2));  
		$("#shw_salary_spe_new_"+id_tb).html(number_format_return(SPAC_COM,2));
	}else if(SALARY<MAX){
		//ถ้าไม่เกินกรอบบนให้ค่าตอบแทนพิเศษเป็นศูนย์ 
		$('#SALARY_UP_'+id_tb).val(number_format_return(SALARY_CAL));
		$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY));
		$('#SHW_NEW_'+id_tb).val(number_format_return(SALARY));
		$("#SALARY_SPE_UP_"+id_tb).val(number_format_return('0.00'),2); 
		$("#shw_salary_spe_new_"+id_tb).html(number_format_return('0.00'),2);
	}

	
}


function calSalaryNew(id){
	var salary_new = parseFloat($('#SALARY_UP_'+id).val().replace(",",""))+parseFloat($('#SALARY_NOW_'+id).val().replace(",",""));
	$('#SALARY_NEW_'+id).val(salary_new);
	NumberFormat(document.getElementById('SALARY_NEW_'+id),2);
	$('#shw_salary_new_'+id).html($('#SALARY_NEW_'+id).val());
}

function calSalarySpeNew(id){
	var salary_spe_new = parseFloat($('#SALARY_SPE_UP_'+id).val().replace(",",""))+parseFloat($('#SALARY_SPE_NOW_'+id).val().replace(",",""));
	$('#SALARY_SPE_NEW_'+id).val(salary_spe_new);
	NumberFormat(document.getElementById('SALARY_SPE_NEW_'+id),2);
	$('#shw_salary_spe_new_'+id).html($('#SALARY_SPE_NEW_'+id).val());
}
function get_level(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:1},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#S_LEVEL_ID').html(html);
				$('#S_LEVEL_ID').trigger('liszt:updated');
			}
		});
		
		
	}else{
		$("#LEVEL_ID_gov").html('<option value="">เลือก</option>');
	}
}
function get_org_4(e){
	if(e.value > 0  && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_org_4",org_parent_id:e.value},
			success : function(data){
				$("#S_ORG_ID_4").html(data);
				$('select').trigger('liszt:updated');
				$("#S_ORG_ID_4").chosen({//ค้นหา+เลือก select 
					allow_single_deselect: true
					//no_results_text: "No results matched"
				});
			}
		});
	}
}
function get_line_group(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#S_LG_ID').html(html);
				$('#S_LG_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#S_LG_ID").html('<option value="">เลือก</option>');
	}
}

function get_line(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",lg_id:e.value,postype_id:1},
			success : function(data){
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$("#S_LINE_ID").html(html);
				$("#S_LINE_ID").trigger('liszt:updated');
			}
		});
	}else{
		$("#S_LINE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}

function get_manage(e){
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_manage",type_id:e.value},
			success : function(data){
				$("#S_MANAGE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}else{
		$("#S_MANAGE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}


function chkinput(){	
	
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#proc').val('save');
		$("#frm-search").attr('action','process/record_level_salary1_org_process.php').submit();
	}
}

var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};