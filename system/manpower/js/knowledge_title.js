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
	$("#frm-search").attr("action","knowledge_title_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#SKILLTITLE_ID").val(id);
	$("#frm-search").attr("action","knowledge_title_form.php").submit();
}

function chkinput(){
	if($("#SKILLTITLE_NAME_TH").val() == ""){
		alert("ระบุ "+$('#SKILLTITLE_NAME_TH').attr('placeholder'));
		$("#SKILLTITLE_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#SKILLTITLE_NAME_TH').attr('placeholder')+" ซ้ำ");
		$("#SKILLTITLE_NAME_TH").focus();
		return false;
	}
	
	if($("#flagDup2").val() == 1){
		alert($('#SKILLTITLE_NAME_EN').attr('placeholder')+" ซ้ำ");
		$("#SKILLTITLE_NAME_EN").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#SKILLTITLE_ID").val(id);
		$("#frm-search").attr("action","process/skill_title_process.php").submit();
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