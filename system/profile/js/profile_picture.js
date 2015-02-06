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
	$("#frm-search").attr("action","profile_picture_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PIC_ID").val(id);
	$("#frm-search").attr("action","profile_picture_form.php").submit();
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PIC_ID").val(id);
		$("#frm-search").attr("action","process/profile_picture_process.php").submit();
	}
}

function chkinput(){
	if($.trim($("#PIC_DATE").val()) == ""){
		alert("ระบุ วันที่ถ่ายภาพ");
		$("#PIC_DATE").focus();
		return false;
	}
	if($.trim($("#PIC_FILENAME").val()) == "" && $.trim($("#OLD_FILEPATH").val()) == ""){
		alert("ระบุ "+$('#PIC_FILENAME').attr('placeholder'));
		$("#PIC_FILENAME").focus();
		return false;
	}
	if($.trim($("input[name=PIC_DEFAULT]:checked").val()) == ""){
		alert("ระบุ สถานะการใช้ภาพถ่าย");
		$("input[name=PIC_DEFAULT]:checked").focus();
		return false;
	}
	if($("#ACTIVE_STATUS").val() == ""){
		alert("ระบุ "+$('#ACTIVE_STATUS').attr('placeholder'));
		$("#ACTIVE_STATUS").focus();
		return false;
	}
	

	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
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