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
	$("#frm-search").attr("action","profile_activity_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#ACT_ID").val(id);
	$("#frm-search").attr("action","profile_activity_form.php").submit();
}

function chkinput(){
		if($("#ACT_DESC").val() == ""){
		alert("ระบุ "+$('#ACT_DESC').attr('placeholder'));
		$("#ACT_DESC").focus();
		return false;
	}
	if($("input[name=ACTIVE_STATUS]:checked").val() == ""){
		alert("ระบุ สถานะการใช้งาน");
		$("#ACTIVE_STATUS0").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#ACT_ID").val(id);
		$("#frm-search").attr("action","process/profile_activity_process.php").submit();
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