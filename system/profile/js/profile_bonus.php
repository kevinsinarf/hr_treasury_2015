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
	$("#frm-search").attr("action","profile_upsalary_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#SALHIS_ID").val(id);
	$("#frm-search").attr("action","profile_upsalary_form.php").submit();
}

function chkinput(){
	if($("#ORG_ID").val() == ""){
		alert("ระบุ "+$('#ORG_ID').attr('placeholder'));
		$("#ORG_ID").focus();
		return false;
	}
	if($("#LINE_ID").val() == ""){
		alert("ระบุ "+$('#LINE_ID').attr('placeholder'));
		$("#LINE_ID").focus();
		return false;
	}
	if($("#LEVEL_ID").val() == ""){
		alert("ระบุ "+$('#LEVEL_ID').attr('placeholder'));
		$("#LEVEL_ID").focus();
		return false;
	}
	if($("#MISS_TYPE").val() == ""){
		alert("ระบุ "+$('#MISS_TYPE').attr('placeholder'));
		$("#MISS_TYPE").focus();
		return false;
	}
	if($("#MISS_SDATE").val() == ""){
		alert("ระบุ วันที่เริ่มต้น");
		$("#MISS_SDATE").focus();
		return false;
	}
	if($("#MISS_EDATE").val() == ""){
		alert("ระบุ วันที่สิ้นสุด");
		$("#MISS_EDATE").focus();
		return false;
	}	
	if($("#MISS_LAST_SALARY").val() == ""){
		alert("ระบุ "+$('#MISS_LAST_SALARY').attr('placeholder'));
		$("#MISS_LAST_SALARY").focus();
		return false;
	}
	if($("#MISS_NEW_SALARY").val() == ""){
		alert("ระบุ "+$('#MISS_NEW_SALARY').attr('placeholder'));
		$("#MISS_NEW_SALARY").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#SALHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_upsalary_process.php").submit();
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