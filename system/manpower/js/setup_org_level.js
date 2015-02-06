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
	$("#frm-search").attr("action","setup_org_level_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#OL_ID").val(id);
	$("#frm-search").attr("action","setup_org_level_form.php").submit();
}

function chkinput(){
	if($("#OL_SEQ").val() == ""){
		alert("ระบุ "+$('#OL_SEQ').attr('placeholder'));
		$("#OL_SEQ").focus();
		return false;
	}
	if($("#OL_NAME_TH").val() == ""){
		alert("ระบุ "+$('#OL_NAME_TH').attr('placeholder'));
		$("#OL_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#OL_NAME_TH').attr('placeholder')+" ซ้ำ");
		$("#OL_NAME_TH").focus();
		return false;
	}
	
	if($("#flagDup2").val() == 1){
		alert($('#OL_NAME_EN').attr('placeholder')+" ซ้ำ");
		$("#OL_NAME_EN").focus();
		return false;
	}
	if($("#OL_TYPE").val() == ""){
		alert("ระบุ "+$('#OL_TYPE').attr('placeholder'));
		$("#OL_TYPE").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#OL_ID").val(id);
		$("#frm-search").attr("action","process/setup_org_level_process.php").submit();
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