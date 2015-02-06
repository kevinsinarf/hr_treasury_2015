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
	$("#frm-search").attr("action","profile_language_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#LANGUAGE_ID").val(id);
	$("#frm-search").attr("action","profile_language_form.php").submit();
}

function chkinput(){
/*	if($("input[name=LANGUAGE_RATE]:checked").val() == undefined || $("input[name=LANGUAGE_RATE]:checked").val() == ""){
		alert("ระบุ ระดับทักษะภาษา");
		$("#LANGUAGE_RATE5").focus();
		return false;
	}*/
	if($("#COUNTRY_ID").val() == ""){
		alert("ระบุ "+$('#COUNTRY_ID').attr('placeholder'));
		$("#COUNTRY_ID").focus();
		return false;
	}
	if($("#LANGHIS_LISTEN").val() == ""){
		alert("ระบุ การ"+$('#LANGHIS_LISTEN').attr('placeholder'));
		$("#LANGHIS_LISTEN").focus();
		return false;
	}
	if($("#LANGHIS_SPEAKING").val() == ""){
		alert("ระบุ การ"+$('#LANGHIS_SPEAKING').attr('placeholder'));
		$("#LANGHIS_SPEAKING").focus();
		return false;
	}
	if($("#LANGHIS_READING").val() == ""){
		alert("ระบุ การ"+$('#LANGHIS_READING').attr('placeholder'));
		$("#LANGHIS_READING").focus();
		return false;
	}
	if($("#LANGHIS_WRITING").val() == ""){
		alert("ระบุ การ"+$('#LANGHIS_WRITING').attr('placeholder'));
		$("#LANGHIS_WRITING").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function search_parent(){
	if($("#COUNTRY_ID").val() == ''){
		$('#btn_save').hide();
		$('#show_parent_data').hide();
		$('#PK_ID').val('');
		alert("ระบุ "+$("#COUNTRY_ID").attr('placeholder'));
		$("#COUNTRY_ID").focus();
		return false;
	}else{
		if(!checkID($('#COUNTRY_ID').val())){ 
			$('#btn_save').hide();
			$('#show_parent_data').hide();
			$('#PK_ID').val('');
			alert($("#COUNTRY_ID").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#COUNTRY_ID").focus();
			return false;
		}
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#LANGHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_language_process.php").submit();
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