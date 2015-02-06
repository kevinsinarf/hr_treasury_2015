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

function getTitle(){
	$.ajax({
		url: "process/gettitle.php",
		type: "POST",
		data:{proc:"getTitle",PREFIX_ID:$('#PREFIX_ID').val()},
		success : function(data){ 
			$('#prefix_en').html(data);
		}
	});
}

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_child_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PCHILD_ID").val(id);
	$("#frm-search").attr("action","profile_child_form.php").submit();
}

function chkinput(){
	/*if($("#DOC_RECEIVE_NO").val() == ""){
		alert("ระบุ เลขที่หนังสือ");
		$("#DOC_RECEIVE_NO").focus();
		return false;
	}*/
	if($("#PCHILD_IDCARD").val() == ""){
		alert("ระบุ "+$("#PCHILD_IDCARD").attr('placeholder'));
		$("#PCHILD_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#PCHILD_IDCARD').val())){ 
			alert($("#PCHILD_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PCHILD_IDCARD").focus();
			return false;
		}
	}
	if($("#PREFIX_ID").val() == ""){
		alert("ระบุ "+$("#PREFIX_ID").attr('placeholder'));
		$("#PREFIX_ID").focus();
		return false;
	}
	 if($("#PCHILD_BIRTHDATE").val() == ""){
		alert("ระบุ วันเดือนปีเกิด");
		$("#PCHILD_BIRTHDATE").focus();
		return false;
	}
	if($("#PCHILD_FIRSTNAME_TH").val() == ""){
			alert("ระบุ ชื่อตัว (ไทย)");
			$("#PCHILD_FIRSTNAME_TH").focus();
			return false;
	}
	if($("#PCHILD_LASTNAME_TH").val() == ""){
		alert("ระบุ ชื่อสกุล (ไทย)");
		$("#PCHILD_LASTNAME_TH").focus();
		return false;
	}
	if($("#PCHILD_FIRSTNAME_EN").val() == ""){
		alert("ระบุ ชื่อตัว (อังกฤษ)");
		$("#PCHILD_FIRSTNAME_EN").focus();
		return false;
	}
	if($("#PCHILD_LASTNAME_EN").val() == ""){
		alert("ระบุ ชื่อสกุล (อังกฤษ)");
		$("#PCHILD_LASTNAME_EN").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function search_parent(){
	if($("#PCHILD_IDCARD").val() == ''){
		$('#btn_save').hide();
		$('#show_parent_data').hide();
		$('#PK_ID').val('');
		alert("ระบุ "+$("#PCHILD_IDCARD").attr('placeholder'));
		$("#PCHILD_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#PCHILD_IDCARD').val())){ 
			$('#btn_save').hide();
			$('#show_parent_data').hide();
			$('#PK_ID').val('');
			alert($("#PCHILD_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PCHILD_IDCARD").focus();
			return false;
		}
	}
}



function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PCHILD_ID").val(id);
		$("#frm-search").attr("action","process/profile_child_process.php").submit();
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