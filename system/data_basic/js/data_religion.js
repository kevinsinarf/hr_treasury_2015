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
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","data_religion_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#RELIGION_ID").val(id);
	$("#frm-search").attr("action","data_religion_form.php").submit();
}

function chkinput(){
	/*if($.trim($("#RELIGION_CODE").val()) == ""){
		alert("ระบุ "+$('#RELIGION_CODE').attr('placeholder'));
		$("#RELIGION_CODE").focus();
		return false;
	}
	if($("#flagDup3").val() == 1){
		alert($('#RELIGION_CODE').attr('placeholder')+"ซ้ำ");
		$("#RELIGION_CODE").focus();
		return false;
	}*/
	
	if($.trim($("#RELIGION_NAME_TH").val()) == ""){
		alert("ระบุ "+$('#RELIGION_NAME_TH').attr('placeholder'));
		$("#RELIGION_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#RELIGION_NAME_TH').attr('placeholder')+"ซ้ำ");
		$("#RELIGION_NAME_TH").focus();
		return false;
	}
	
	if($.trim($("#RELIGION_NAME_EN").val()) != "" && $("#flagDup2").val() == 1){
		alert($('#RELIGION_NAME_EN').attr('placeholder')+"ซ้ำ");
		$("#RELIGION_NAME_EN").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#RELIGION_ID").val(id);
		$("#frm-search").attr("action","process/data_religion_process.php").submit();
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