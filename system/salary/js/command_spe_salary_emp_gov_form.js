//var form_input = "pos_type_form.php";

$(document).ready(function(){
						   
	if(isMobile.any() == "null"){				   
		$(window).scroll(function(){
			$('#myModal').css(
			{
				'margin-top': function () {
					return window.pageYOffset
				}
			}
			);
		});
		
	}
});	

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function chkinput(){
	if($("#CT_ID").val() == ""){
		alert("ระบุ "+$('#CT_ID').attr('placeholder'));
		$("#CT_ID").focus();
		return false;
	}
	if($("#COM_NO").val() == ""){
		alert("ระบุ "+$('#COM_NO').attr('placeholder'));
		$("#COM_NO").focus();
		return false;
	}
	if($("#COM_DATE").val() == ""){
		alert("ระบุ ลงวันที่ ");
		$("#COM_DATE").focus();
		return false;
	}
	if($("#COM_TITLE").val() == ""){
		alert("ระบุ "+$('#COM_TITLE').attr('placeholder'));
		$("#COM_TITLE").focus();
		return false;
	}
	if($("#COM_SDATE").val() == ""){
		alert("ระบุ วันที่มีผล ");
		$("#COM_SDATE").focus();
		return false;
	}
	if($('input:checkbox[name^=SAL_UP_ID]:checked').length <= 0){
		alert('กรุณาเลือก ชื่อผู้ได้รับค่าตอบแทนพิเศษ อย่างน้อย 1 รายการ');
		$('#chkAll').focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึก")){
		$("#frm-input").submit();
	}
}



function checkbox_all(){
	if($("#chkAll").prop("checked")){
		$("input[type=checkbox]").prop("checked",true);
	}else{
		$("input[type=checkbox]").prop("checked",false);
	}
}
function ConfirmCom(){
	var YEAR_BDG = $('#YEAR_BDG').val();
	var ROUND = $('#ROUND').val();
	
	if(confirm("อนุมัติออกคำสั่งให้ได้รับค่าตอบแทนพิเศษ\nปีงบประมาณ "+YEAR_BDG+" รอบ "+ROUND+"\nคุณจะไม่สามารถแก้ไขข้อมูลได้อีก\nคุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
		$('#proc').val('ConfirmCom');
		$("#frm-input").attr('action','process/command_spe_salary_emp_gov_process.php').submit();
	}
}

// =======================================

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