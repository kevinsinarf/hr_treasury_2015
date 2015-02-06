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
	$("#frm-search").attr("action","profile_ability_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#ABIHIS_ID").val(id);
	$("#frm-search").attr("action","profile_ability_form.php").submit();
}

function chkinput(){
	if($("#ABILITY_ID").val() == ""){
		alert("ระบุ "+$('#ABILITY_ID').attr('placeholder'));
		$("#ABILITY_ID").focus();
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
		$("#ABIHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_ability_process.php").submit();
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