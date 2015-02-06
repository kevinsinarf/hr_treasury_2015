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

function getTitle(PREFIX_ID){
	$.ajax({
		url: "process/gettitle.php",
		type: "POST",
		data:{proc:"getTitle",PREFIX_ID:PREFIX_ID},
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
	$("#frm-search").attr("action","profile_marryhis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PMARRY_ID").val(id);
	$("#frm-search").attr("action","profile_marryhis_form.php").submit();
}

function chkinput(){
	
	if($("#PMAARY_IDCARD").val() == ""){
		alert("ระบุ "+$("#PMAARY_IDCARD").attr('placeholder'));
		$("#PMAARY_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#PMAARY_IDCARD').val())){ 
			alert($("#PMAARY_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PMAARY_IDCARD").focus();
			return false;
		}
	}
	if($("#PREFIX_ID").val() == ""){
		alert("ระบุ "+$('#PREFIX_ID').attr('placeholder'));
		$("#PREFIX_ID").focus();
		return false;
	}
	
		if($("#PMARRY_FIRSTNAME_TH").val() == ""){
		alert("ระบุ "+$('#PMARRY_FIRSTNAME_TH').attr('placeholder'));
		$("#PMARRY_FIRSTNAME_TH").focus();
		return false;
	}
		if($("#PMARRY_LASTNAME_TH").val() == ""){
		alert("ระบุ "+$('#PMARRY_LASTNAME_TH').attr('placeholder'));
		$("#PMARRY_LASTNAME_TH").focus();
		return false;
	}
	if($("#PMARRY_FIRSTNAME_EN").val() == ""){
		alert("ระบุ "+$('#PMARRY_FIRSTNAME_EN').attr('placeholder'));
		$("#PMARRY_FIRSTNAME_EN").focus();
		return false;
	}
		if($("#PMARRY_LASTNAME_EN").val() == ""){
		alert("ระบุ "+$('#PMARRY_LASTNAME_EN').attr('placeholder'));
		$("#PMARRY_LASTNAME_EN").focus();
		return false;
	}
	if($("#PMARRY_STATUS").val() == ""){
		alert("ระบุ "+$('#PMARRY_STATUS').attr('placeholder'));
		$("#PMARRY_STATUS").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function search_parent(){
	if($("#PCON_IDCARD").val() == ''){
		$('#btn_save').hide();
		$('#show_parent_data').hide();
		$('#PK_ID').val('');
		alert("ระบุ "+$("#PCON_IDCARD").attr('placeholder'));
		$("#PCON_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#PCON_IDCARD').val())){ 
			$('#btn_save').hide();
			$('#show_parent_data').hide();
			$('#PK_ID').val('');
			alert($("#PCON_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PCON_IDCARD").focus();
			return false;
		}
	}
}



function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PMARRY_ID").val(id);
		$("#frm-search").attr("action","process/profile_marryhis_process.php").submit();
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