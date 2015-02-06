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
	$("#frm-search").attr("action","edu_degree_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#ED_ID").val(id);
	$("#frm-search").attr("action","edu_degree_form.php").submit();
}

function chkinput(){
	if($.trim($("#ED_NAME_TH").val()) == "" && $.trim($("#ED_NAME_EN").val()) == ""){
		alert("ระบุ วุฒิการศึกษา ");
		$("#ED_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#ED_NAME_TH').attr('placeholder')+"ซ้ำ");
		$("#ED_NAME_TH").focus();
		return false;
	}
	
	/*if($.trim($("#ED_NAME_EN").val()) == ""){
		alert("ระบุ "+$('#ED_NAME_EN').attr('placeholder'));
		$("#ED_NAME_EN").focus();
		return false;
	}*/
	if($.trim($("#ED_NAME_EN").val()) != "" && $("#flagDup2").val() == 1){
		alert($('#ED_NAME_EN').attr('placeholder')+"ซ้ำ");
		$("#ED_NAME_EN").focus();
		return false;
	}
	if($.trim($("#EL_ID").val()) == ""){
		alert("ระบุ "+$('#EL_ID').attr('placeholder'));
		$("#EL_ID").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function Chkrepeat(){
	
	chkDup('chkDup1','flagDup1','ED_NAME_TH','ED_ID','SETUP_EDU_DEGREE','EL_ID='+$('#EL_ID').val());
	chkDup('chkDup2','flagDup2','ED_NAME_EN','ED_ID','SETUP_EDU_DEGREE','EL_ID='+$('EL_ID').val());
	
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#ED_ID").val(id);
		$("#frm-search").attr("action","process/edu_degree_process.php").submit();
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