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
	$("#frm-search").attr("action","form_group.php").submit();
}

function editData(id){
	
	$("#proc").val("edit");
	$("#user_group_id").val(id);
	$("#frm-search").attr("action","form_group.php").submit();
	
	
}

function menuData(id){
	$("#user_group_id").val(id);
	$("#frm-search").attr("action","disp_menu_group.php").submit();
}

function chkinput(){
	if($("#group_name").val() == ""){
		alert("ระบุ ชื่อกลุ่ม");
		$("#group_name").focus();
		return false;
	}
	
	if($("#flagDup").val() == 1){
		alert("ไม่สามารถใช้ ชื่อกลุ่ม นี้ได้");
		$("#group_name").focus();
		return false;
	}
	
	if($("input[id=active_status]:checked").length == 0){
		alert("ระบุ สถานะ");
		$("#active_status").focus();
		return false;
	}
	
	$("#frm-input").submit();
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#user_group_id").val(id);
		$("#frm-search").attr("action","process/process_group.php").submit();
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