var url_process = "process/record_level_salary1_mg_process.php";
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
	$('.score_final input:text[id^=SCORE_]').each(function(){
		var arr_id = $(this).attr('id').split('_');
		var id_tb = arr_id[1];
		var score = $(this).val();
		var per_id = $('#PER_ID_'+id_tb).val();
		getPercent(score,id_tb,per_id);
	});
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
	$("#proc").val("edit");
	$("#MT_ID").val(id);
	$("#frm-search").attr("action","record_level_salary1_mg_form.php").submit();
}

function getPercent(score, id_tb,per_id){
	var url = 'process/record_level_salary1_mg_process.php';
	$.post(url,{proc: 'getPercent',score: score, id_tb: id_tb, S_YEAR_BDG : $('#S_YEAR_BDG').val(), S_ROUND : $('#S_ROUND').val(), PER_ID:per_id},function(data){	
		$('#SCORE_ID_'+id_tb).val(data['SCORE_ID']);
		$('#SCORE_PERCENT_'+id_tb).val(data['PERCENT']);
		getSalaryCal(id_tb,data['SALARY_MIN']	,data['SALARY_MAX']);
	},'json');
}
function getSalaryCal(id_tb,MIN,MAX){
	//คำนวณหาค่าเปอร์เซ็น
	var SCORE_PERCENT = parseFloat($('#SCORE_PERCENT_'+id_tb).val().split(",").join(""));  //ค่าเปอร์เซ็น
	var LEVEL_SALARY_MID = parseFloat($('#LEVEL_SALARY_MID_'+id_tb).val().split(",").join("")); //เงินเดือนปัจจุบัน
	var SALARY_UP = Math.ceil((SCORE_PERCENT*LEVEL_SALARY_MID)/100);    
	$('#SALARY_UP_'+id_tb).val(number_format_return(SALARY_UP));
	var SALARY  = SALARY_UP + LEVEL_SALARY_MID;  // เงินเดือนใหม่
	//เช็คว่าเปอร์เซ็นเกิน
	var  SPAC_COM = 0;    //ค่าตอบแทนพิเศษ
	if(SALARY>MAX){
		//ถ้าเกินให้เอาค่า salary_slip ลบค่า max 
		SPAC_COM =  SALARY-MAX ;
		$('#shw_salary_new_'+id_tb).html(number_format_return(MAX));
		$('#SHW_NEW_'+id_tb).val(number_format_return(MAX));
		$("#SALARY_SPE_UP_"+id_tb).val(number_format_return(SPAC_COM));  
		$("#shw_salary_spe_new_"+id_tb).html(number_format_return(SPAC_COM));
	}else if(SALARY<MAX){
		//ถ้าไม่เกินกรอบบนให้ค่าตอบแทนพิเศษเป็นศูนย์ 
		//alert(SALARY);
		SPAC_COM = 0;
		$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY));
		$('#SHW_NEW_'+id_tb).val(number_format_return(SALARY));
	}
}
function getSalaryCal_(id_tb){
	var SCORE_PERCENT = $('#SCORE_PERCENT_'+id_tb).val();
	var LEVEL_SALARY_MID = $('#LEVEL_SALARY_MID_'+id_tb).val().replace(",","");
	var SALARY_CAL = (SCORE_PERCENT*LEVEL_SALARY_MID)/100;
	
	$('#SALARY_CAL_'+id_tb).val(SALARY_CAL);
	$('#shw_salary_cal_'+id_tb).html();
	NumberFormat(document.getElementById('SALARY_CAL_'+id_tb),2);
	$('#shw_salary_cal_'+id_tb).html($('#SALARY_CAL_'+id_tb).val());
	
	var SALARY_UP = Math.ceil($('#SALARY_CAL_'+id_tb).val().replace(",",""));
	$('#SALARY_UP_'+id_tb).val(SALARY_UP);
	NumberFormat(document.getElementById('SALARY_UP_'+id_tb),2);
		
	var SALARY_NEW = parseFloat($('#SALARY_NOW_'+id_tb).val().replace(",",""))+parseFloat(SALARY_UP);
	$('#SALARY_NEW_'+id_tb).val(SALARY_NEW);
	NumberFormat(document.getElementById('SALARY_NEW_'+id_tb),2);
	$('#shw_salary_new_'+id_tb).html($('#SALARY_NEW_'+id_tb).val());
	
	var SALARY_SPE_NEW = parseFloat($('#SALARY_SPE_NOW_'+id_tb).val().replace(",",""));
	$('#SALARY_SPE_NEW_'+id_tb).val(SALARY_SPE_NEW);
	NumberFormat(document.getElementById('SALARY_SPE_NEW_'+id_tb),2);
	$('#shw_salary_spe_new_'+id_tb).html($('#SALARY_SPE_NEW_'+id_tb).val());
	
	if(SALARY_NEW > LEVEL_SALARY_MID){		
		var SALARY_SPE_UP = SALARY_NEW - LEVEL_SALARY_MID;
		$('#SALARY_SPE_UP_'+id_tb).val(SALARY_SPE_UP);
		NumberFormat(document.getElementById('SALARY_SPE_UP_'+id_tb),2);		
		
		var SALARY_SPE_NEW = parseFloat($('#SALARY_SPE_NOW_'+id_tb).val().replace(",",""))+parseFloat(SALARY_SPE_UP);
		$('#SALARY_SPE_NEW_'+id_tb).val(SALARY_SPE_NEW);
		NumberFormat(document.getElementById('SALARY_SPE_NEW_'+id_tb),2);
		$('#shw_salary_spe_new_'+id_tb).html($('#SALARY_SPE_NEW_'+id_tb).val());

		$('#SALARY_UP_'+id_tb).val(LEVEL_SALARY_MID-parseFloat($('#SALARY_NOW_'+id_tb).val().replace(",","")));
		NumberFormat(document.getElementById('SALARY_UP_'+id_tb),2);
		
		var SALARY_NEW = LEVEL_SALARY_MID;
		$('#SALARY_NEW_'+id_tb).val(SALARY_NEW);
		NumberFormat(document.getElementById('SALARY_NEW_'+id_tb),2);
		$('#shw_salary_new_'+id_tb).html($('#SALARY_NEW_'+id_tb).val());
	
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
	var err1=0;
	var err2=0;
	var err3=0;
	var err4=0;
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
		if($('#SALARY_CAL_'+id).val() <= 0){
			err4++;
			$('#SALARY_CAL_'+id).focus();
			return false;
		}
	});
	
	if(err1 > 0){
		alert('ระบุ คะแนนผลปฏิบัติงาน');
		return false;
	}
	if(err2 > 0){
		alert('ไม่พบ ฐานในการคำนวณ');
		return false;
	}
	if(err3 > 0){
		alert('ระบ ร้อยละที่ได้เลื่อน');
		return false;
	}
	if(err4 > 0){
		alert('ไม่พบ จำนวนเงินที่คำนวณ');
		return false;
	}*/
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#proc').val('save');
		$("#frm-search").attr('action','process/record_level_salary1_mg_process.php').submit();
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