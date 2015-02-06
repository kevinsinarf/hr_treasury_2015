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
	$("#frm-search").attr("action","profile_healthhis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#HEALTH_ID").val(id);
	$("#frm-search").attr("action","profile_healthhis_form.php").submit();
}

function chkinput(){
		if($("#HEALTH_DATE").val() == ""){
		alert("ระบุ วันที่เข้ารับการตรวจ");
		$("#HEALTH_DATE").focus();
		return false;
	}
	if($("#HEALTH_BLOOD").val() == ""){
		alert("ระบุ "+$('#HEALTH_BLOOD').attr('placeholder'));
		$("#HEALTH_BLOOD").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

/*function search_parent(){
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
}*/

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#HEALTH_ID").val(id);
		$("#frm-search").attr("action","process/profile_healthhis_process.php").submit();
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