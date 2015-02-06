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




function editData(id){
	$("#proc").val("edit");
	$("#PER_ID").val(id);
	$("#frm-search").attr("action","profile_his_form.php").submit();
}

function chkinput(){
 
  if($("#MOVEMENT_CODE").val() == ""){
	  alert("ระบุ "+$('#MOVEMENT_CODE').attr('placeholder'));
	  $("#MOVEMENT_CODE").focus();
	  return false;
  }
   if($("#flagDup1").val() == 1){
		alert($('#MOVEMENT_CODE').attr('placeholder')+"ซ้ำ");
		$("#MOVEMENT_CODE").focus();
		return false;
	}
	if($("#flagDup2").val() == 1){
		alert($('#MOVEMENT_NAME_TH').attr('placeholder')+"ซ้ำ");
		$("#MOVEMENT_NAME_TH").focus();
		return false;
	}
	
 
  if($("#MOVEMENT_GROUP").val() == ""){
	  alert("ระบุ "+$('#MOVEMENT_GROUP').attr('placeholder'));
	  $("#MOVEMENT_GROUP").focus();
	  return false;
  }
	
	if($("#MOVEMENT_NAME_TH").val() == ""){
		alert("ระบุ "+$('#MOVEMENT_NAME_TH').attr('placeholder'));
		$("#MOVEMENT_NAME_TH").focus();
		return false;
	}
	if($("#POSTYPE_ID").val() == ""){
		alert("ระบุ "+$('#POSTYPE_ID').attr('placeholder'));
		$("#POSTYPE_ID").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PER_ID").val(id);
		$("#frm-search").attr("action","process/profile_his_proc.php").submit();
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