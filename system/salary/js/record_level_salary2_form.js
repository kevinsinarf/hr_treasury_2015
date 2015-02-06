var url_process = "process/record_level_salary2_process.php";
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
function getAvg(obj){
		var arr_id = $(obj).attr('id').split('_');
		var id_tb = arr_id[2];
		var SCORE_1 =  parseFloat($('#SCORE_1_'+id_tb).val().split(",").join(""));
		var SCORE_2 =  parseFloat($('#SCORE_2_'+id_tb).val().split(",").join(""));
		var SCORE = (SCORE_1 + SCORE_2)/2;
		
		if(SCORE>0){
			getPercent(id_tb,SCORE);
			$('#SCORE_'+id_tb).val(number_format_return(SCORE,2));
		}
		
		
}
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
	$("#proc").val("edit");
	$("#ORG_ID").val(id);
	$("#frm-search").attr("action","record_level_salary2_form.php").submit();
}

function getPercent(id_tb,score){
	var url = 'process/record_level_salary2_process.php';
	$.post(url,{proc: 'getPercent',score: score, id_tb: id_tb, S_YEAR_BDG : $('#S_YEAR_BDG').val(), S_ROUND : $('#S_ROUND').val(), LEVEL_ID : $('#LEVEL_ID_'+id_tb).val()},function(data){
		
		$('#SCORE_ID_'+id_tb).val(data['SCORE_ID']);
		$('#SCORE_PERCENT_'+id_tb).val(data['PERCENT']);
		$('#LEVEL_SALARY_MAX_'+id_tb).val(data['SALARY_MAX']);
		getSalaryCal(id_tb);
		
		
	},'json');
	
}

function getSalaryCal(id_tb){
	
	var SALARY_NOW = $('#SALARY_NOW_'+id_tb).val().split(",").join(""); //เงินเดือนล่าสุด
	var SALARY_MAX = $('#LEVEL_SALARY_MAX_'+id_tb).val().split(",").join("") // เงินเดือนขั้นสูง
	var SCORE_PERCENT = $('#SCORE_PERCENT_'+id_tb).val().split(",").join(""); //ค่าเปอร์เซ็น
	var SALARY_CAL = 0; //เงินเดือนที่คำนวณ
	var SALARY_UP = 0; //เงินเดือนทีได้เลื่อน
	var SALARY_NEW = 0; // เงินเดือนหลังจากเลื่อน
	
	if(SALARY_NOW == '' ){
		SALARY_NOW = 0;
	}
	if(SCORE_PERCENT == ''){
		SCORE_PERCENT = 0;
	}
	if(SALARY_MAX == ''){
		SALARY_MAX = 0;
	}
	if(SCORE_PERCENT == ''){
		SCORE_PERCENT = 0;
	}
	
	SALARY_NOW = parseFloat(SALARY_NOW);
	SCORE_PERCENT = parseFloat(SCORE_PERCENT);
	SALARY_MAX = parseFloat(SALARY_MAX);
	SCORE_PERCENT = parseFloat(SCORE_PERCENT);
	SALARY_CAL = (SALARY_NOW*SCORE_PERCENT)/100;
	SALARY_UP =  Math.ceil((SALARY_CAL/10),0)*10;
	SALARY_NEW  = SALARY_NOW + SALARY_UP;
	
	if(SALARY_NEW >= SALARY_MAX ){
		$('#SALARY_UP_'+id_tb).val(0.00);
		$('#SALARY_NEW_'+id_tb).val(number_format_return(SALARY_MAX,2));
		$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY_MAX,2));
	}else{
		$('#SALARY_UP_'+id_tb).val(number_format_return(SALARY_UP,2));
		$('#SALARY_NEW_'+id_tb).val(number_format_return(SALARY_NEW,2));
		$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY_NEW,2));
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

function get_line(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",level_id:e.value,postype_id:3},
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
function get_level(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:3},
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
function chkinput(){	
	var err1=0;
	var err2=0;
	var err3=0;
	var err4=0;
	var err5=0;
	var err6=0;
	var err7=0;
	var err8=0;
	var err9=0;
	var err10=0;
/*	$('input[name^=SALARY_UP]').each(function(){
		id = this.id.replace("SALARY_UP_","");
		
		if($('#SCORE_'+id).val() <= 0){
			err1++;
			$('#SCORE_'+id).val('').focus();
			return false;
		}
		if($('#LEVEL_SALARY_MID_'+id).val() <= 0){
			err2++;	
			$('#LEVEL_SALARY_MID_'+id).focus();
			return false; 
		}
		if($('#SCORE_PERCENT_'+id).val() <= 0){
			err3++;
			$('#SCORE_PERCENT_'+id).focus();
			return false;
		}
		if($('#PERCENT_SPE_'+id).val() <= 0){
			err4++;
			$('#PERCENT_SPE_'+id).focus();
			return false;
		}
		if($('#SALARY_CAL_'+id).val() <= 0){
			err5++;
			$('#SALARY_CAL_'+id).focus();
			return false;
		}
		if($('#SALARY_SPE_CAL_'+id).val() <= 0){
			err6++;
			$('#SALARY_SPE_CAL_'+id).focus();
			return false;
		}
		if($('#SALARY_UP_'+id).val() <= 0){
			err7++;
			$('#SALARY_UP_'+id).focus();
			return false;
		}
		if($('#SALARY_SPE_UP_'+id).val() <= 0){
			err8++;
			$('#SALARY_SPE_UP_'+id).focus();
			return false;
		}
		if($('#SALARY_NEW_'+id).val() <= 0){
			err9++;
			$('#SALARY_NEW_'+id).focus();
			return false;
		}
		if($('#SALARY_SPE_NEW_'+id).val() <= 0){
			err10++;
			$('#SALARY_SPE_NEW_'+id).focus();
			return false;
		}
	});
	
	if(err1 > 0){
		alert('ระบุ คะแนนผลปฏิบัติงาน');
		return false;
	}
	if(err2 > 0){
		alert('ไม่พบ ข้อมูลฐานคำนวณ');
		return false;
	}
	if(err3 > 0){
		alert('ระบุ ร้อยละที่ได้เลื่อน');
		return false;
	}
	if(err4 > 0){
		alert('ระบุ ร้อยละค่าตอบแทนพิเศษ');
		return false;
	}
	if(err5 > 0){
		alert('ไม่พบ จำนวนเงินค่าตอบแทนที่คำนวณ');
		return false;
	}
	if(err6 > 0){
		alert('ไม่พบ จำนวนเงินค่าตอบแทนพิเศษที่คำนวณ');
		return false;
	}
	if(err7 > 0){
		alert('ระบุ จำนวนเงินค่าตอบแทนที่ได้เลื่อน');
		return false;
	}
	if(err8 > 0){
		alert('ระบุ จำนวนเงินค่าตอบแทนพิเศษที่ได้เลื่อน');
		return false;
	}
	if(err9 > 0){
		alert('ไม่พบ จำนวนเงินค่าตอบแทนที่ได้จริง');
		return false;
	}
	if(err10 > 0){
		alert('ไม่พบ จำนวนเงินค่าตอบแทนพิเศษที่ได้จริง');
		return false;
	}*/

	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#proc').val('save');
		$("#frm-search").attr('action','process/record_level_salary2_process.php').submit();
	}
}

function ConfirmCom(){
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
	
	var S_YEAR_BDG = $('#S_YEAR_BDG').val();
	var S_ROUND = $('#S_ROUND').val(); 
	
	if(confirm("อนุมัติการเลื่อนค่าตอบแทน\nประจำปีงบประมาณ "+S_YEAR_BDG+" รอบ "+S_ROUND+"\nคุณจะไม่สามารถแก้ไขข้อมูลได้อีก\nคุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
		$('#proc').val('ConfirmCom');
		$("#frm-search").attr('action','process/record_level_salary2_process.php').submit();
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