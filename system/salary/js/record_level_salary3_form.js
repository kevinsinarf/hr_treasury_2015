var url_process = "process/record_level_salary3_process.php";
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
	$("#proc").val("edit");
	$("#ORG_ID").val(id);
	$("#frm-search").attr("action","record_level_salary3_form.php").submit();
}

function getPercent(score, id_tb){
	var url = 'process/record_level_salary3_process.php';
	var LEVEL_ID = $('#LEVEL_ID_'+id_tb).val();
	var LINE_ID = $('#LINE_ID_'+id_tb).val();
	
	$.post(url,{proc: 'getPercent',score: score, id_tb: id_tb, S_YEAR_BDG : $('#S_YEAR_BDG').val(), S_ROUND : $('#S_ROUND').val(), 'LEVEL_ID':LEVEL_ID, 'LINE_ID':LINE_ID },function(data){
		$('#SCORE_ID_'+id_tb).val(data['SCORE_ID']);
		$("#STEP_UP_"+id_tb+" option[value='"+data['STEP']+"']").prop('selected', true).trigger("liszt:updated");
		$('#LEVEL_SALARY_MAX_'+id_tb).val(data['SALARY_MAX']);
		getSalaryCal(id_tb);
	},'json');
}

function getSalaryCal(id_tb){
	var PERCENT_SPE = 0;
	var SALARY_UP = 0;
	var SALARY_NEW = 0;
	var SALARY_CAL = 0;
	var SALARY_SPE_UP = 0;
	var UP_STATUS = 0;
	var STEP_DIFF = 0;
	var url = 'process/record_level_salary3_process.php';
	var LEVEL_ID = $('#LEVEL_ID_'+id_tb).val();
	var LINE_ID = $('#LINE_ID_'+id_tb).val();
	var SALARY_NOW = $('#SALARY_NOW_'+id_tb).val().split(',').join('');
	var SALARY_MAX = $('#LEVEL_SALARY_MAX_'+id_tb).val().split(',').join('');
	var STEP_UP = $('#STEP_UP_'+id_tb).val();
	
	if(SALARY_NOW == ''){
		SALARY_NOW = 0;
	}
	if(SALARY_MAX == ''){
		SALARY_MAX = 0;
	}
	if(STEP_UP == ''){
		STEP_UP = 0;
	}
	
	SALARY_NOW = parseFloat(SALARY_NOW);
	SALARY_MAX = parseFloat(SALARY_MAX);
	STEP_UP = parseFloat(STEP_UP);
	if(SALARY_NOW <  SALARY_MAX){
		$.post(url,{proc: 'getSalaryCal','SALARY_NOW':SALARY_NOW, 'LEVEL_ID':LEVEL_ID, 'LINE_ID':LINE_ID, 'STEP_UP':STEP_UP },function(data){
			
				UP_STATUS = data['UP_STATUS'];
				STEP_DIFF = data['STEP_DIFF'];
				SALARY_UP = data['SALARY_UP'];
				SALARY_CAL = SALARY_UP - SALARY_NOW;
				SALARY_NEW = SALARY_UP; 
			if(UP_STATUS == 1){	
				$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY_NEW,2));
				$('#SALARY_NEW_'+id_tb).val(number_format_return(SALARY_NEW,2));
				$('#SALARY_UP_'+id_tb).val(number_format_return(SALARY_CAL,2));
				$('#PERCENT_SPE_'+id_tb).val('0.00');
				$('#shw_salary_spe_new_'+id_tb).html('0.00');
				$('#SALARY_SPE_NEW_'+id_tb).val('0.00');
				$('#SALARY_SPE_UP_'+id_tb).val('0.00');
			}else if(UP_STATUS == 2){
				
				if(STEP_DIFF == 0.5){
					PERCENT_SPE = 2;
				}
				if(STEP_DIFF == 1){
					PERCENT_SPE =4;
				}
				if(STEP_DIFF == 1.5){
					PERCENT_SPE = 6;
				}
				
				SALARY_SPE_UP = (SALARY_MAX * PERCENT_SPE)/100;
				$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY_NEW,2));
				$('#SALARY_NEW_'+id_tb).val(number_format_return(SALARY_NEW,2));
				$('#SALARY_UP_'+id_tb).val(number_format_return(SALARY_CAL,2));
				$('#PERCENT_SPE_'+id_tb).val(number_format_return(PERCENT_SPE,2));
				$('#shw_salary_spe_new_'+id_tb).html(number_format_return(SALARY_SPE_UP,2));
				$('#SALARY_SPE_NEW_'+id_tb).val(number_format_return(SALARY_SPE_UP,2));
				$('#SALARY_SPE_UP_'+id_tb).val(number_format_return(SALARY_SPE_UP,2));
				
			}
			
		},'json');
	}else if(SALARY_NOW >=  SALARY_MAX){
			if(STEP_UP == 0.5){
				PERCENT_SPE = 2;
			}
			if(STEP_UP == 1){
				PERCENT_SPE =4;
			}
			if(STEP_UP == 1.5){
				PERCENT_SPE = 6;
			}
			
			SALARY_SPE_UP = (SALARY_MAX * PERCENT_SPE)/100;
			$('#shw_salary_new_'+id_tb).html(number_format_return(SALARY_MAX,2));
			$('#SALARY_NEW_'+id_tb).val(number_format_return(SALARY_MAX,2));
			$('#SALARY_UP_'+id_tb).val(number_format_return(SALARY_MAX,2));
			$('#PERCENT_SPE_'+id_tb).val(number_format_return(PERCENT_SPE,2));
			$('#shw_salary_spe_new_'+id_tb).html(number_format_return(SALARY_SPE_UP,2));
			$('#SALARY_SPE_NEW_'+id_tb).val(number_format_return(SALARY_SPE_UP,2));
			$('#SALARY_SPE_UP_'+id_tb).val(number_format_return(SALARY_SPE_UP,2));
			
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
			data:{proc:"get_level",type_id:e.value,postype_id:5},
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
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:5},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#S_LG_ID').html(html);
				$('#S_LG_ID').trigger('liszt:updated');
			}
		});
}

function get_line(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",lg_id:e.value,postype_id:5},
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
		$("#frm-search").attr('action','process/record_level_salary3_process.php').submit();
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
	
	if(confirm("อนุมัติการเลื่อนค่าจ้าง\nประจำปีงบประมาณ "+S_YEAR_BDG+" รอบ "+S_ROUND+"\nคุณจะไม่สามารถแก้ไขข้อมูลได้อีก\nคุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
		$('#proc').val('ConfirmCom');
		$("#frm-search").attr('action','process/record_level_salary3_process.php').submit();
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