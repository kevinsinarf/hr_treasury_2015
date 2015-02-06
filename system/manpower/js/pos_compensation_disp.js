var form_input = "pos_compensation_form.php";

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

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action", form_input ).submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#COMPEN_ID").val(id);
	$("#frm-search").attr("action", form_input ).submit();
}

function chkinput(){
	
	if($("#COMPEN_CODE").val() == ""){
		alert("ระบุ "+$('#COMPEN_CODE').attr('placeholder'));
		$("#COMPEN_CODE").focus();
		return false;
	}
	
	if($("#COMPEN_TITLE").val() == ""){
		alert("ระบุ "+$('#COMPEN_TITLE').attr('placeholder'));
		$("#COMPEN_TITLE").focus();
		return false;
	}
	
	if($("#LEVEL_ID").val() == ""){
		alert("ระบุ  "+$('#LEVEL_ID').attr('placeholder'));
		$("#LEVEL_ID").focus();
		return false;
	}
	
	if($("#LINE_ID").val() == ""){
		alert("ระบุ  "+$('#LINE_ID').attr('placeholder'));
		$("#LINE_ID").focus();
		return false;
	}
	
	if($("#COMPEN_YEAR").val() == ""){
		alert("ระบุ "+$('#COMPEN_YEAR').attr('placeholder'));
		$("#COMPEN_YEAR").focus();
		return false;
	}
	
	if($("#COMPEN_MANAGE_STATUS").val() == ""){
		alert("ระบุ  "+$('#COMPEN_MANAGE_STATUS').attr('placeholder'));
		$("#COMPEN_MANAGE_STATUS").focus();
		return false;
	}
	
	if($("#COMPEN_SALARY_POSITION").val() == ""){
		alert("ระบุ "+$('#COMPEN_SALARY_POSITION').attr('placeholder'));
		$("#COMPEN_SALARY_POSITION").focus();
		return false;
	}
	
	if($("#COMPEN_COMPENSATION_1").val() == ""){
		alert("ระบุ "+$('#COMPEN_COMPENSATION_1').attr('placeholder'));
		$("#COMPEN_COMPENSATION_1").focus();
		return false;
	}
	
	if($("#COMPEN_COMPENSATION_2").val() == ""){
		alert("ระบุ "+$('#COMPEN_COMPENSATION_2').attr('placeholder'));
		$("#COMPEN_COMPENSATION_2").focus();
		return false;
	}
	
	if($("#COMPEN_FOR").val() == ""){
		alert("ระบุ  สำหรับ");
		$("#COMPEN_FOR").focus();
		return false;
	}	
	
	if($("input[name=ACTIVE_STATUS]:checked").length == 0){
		alert("ระบุ สถานะ");
		$("#ACTIVE_STATUS").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#COMPEN_ID").val(id);
		$("#frm-search").attr("action","process/pos_compensation_process.php").submit();
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