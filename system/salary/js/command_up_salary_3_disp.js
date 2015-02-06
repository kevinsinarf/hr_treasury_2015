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

function addData(){
	if($("#ROUND").val() == "") {
		alert("ระบุ "+$('#ROUND').attr('placeholder'));
		$("#ROUND").focus();
		return false;
	}
	$("#proc").val("add");
	$("#frm-search").attr("action", "command_up_salary3_form.php" ).submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#SAL_COM_ID").val(id);
	$("#frm-search").attr("action", "command_up_salary3_form.php" ).submit();
}

function View(id){
	$("#ORG_ID_3").val(id);
	$("#frm-input").attr("action", "command_up_salary3_view.php" ).submit();
}

function chkinput(){
	if($("#CT_ID").val() == ""){
		alert("ระบุ "+$('#CT_ID').attr('placeholder'));
		$("#CT_ID").focus();
		return false;
	}
	if($("#MOVEMENT_ID").val() == ""){
		alert("ระบุ "+$('#MOVEMENT_ID').attr('placeholder'));
		$("#MOVEMENT_ID").focus();
		return false;
	}
	if($("#COM_NO").val() == ""){
		alert("ระบุ "+$('#COM_NO').attr('placeholder'));
		$("#COM_NO").focus();
		return false;
	}
	if($("#COM_DATE").val() == ""){
		alert("ระบุ "+$('#COM_DATE').attr('placeholder'));
		$("#COM_DATE").focus();
		return false;
	}
	if($("#COM_TITLE").val() == ""){
		alert("ระบุ "+$('#COM_TITLE').attr('placeholder'));
		$("#COM_TITLE").focus();
		return false;
	}
	if($("#COM_SDATE").val() == ""){
		alert("ระบุ "+$('#COM_SDATE').attr('placeholder'));
		$("#COM_SDATE").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึก")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#SAL_COM_ID").val(id);
		$("#frm-search").attr("action","process/command_up_salary3_process.php").submit();
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