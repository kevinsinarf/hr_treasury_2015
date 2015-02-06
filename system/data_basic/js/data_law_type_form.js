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



function chkinput(){
 
  if($("#CT_NAME_TH").val() == ""){
	  alert("ระบุ "+$('#CT_NAME_TH').attr('placeholder'));
	  $("#CT_NAME_TH").focus();
	  return false;
  }
   if($("#flagDup1").val() == 1){
		alert($('#MOVEMENT_CODE').attr('placeholder')+"ซ้ำ");
		$("#MOVEMENT_CODE").focus();
		return false;
	}
	
	if($("#LT_ID").val() == ""){
		alert("ระบุ "+$('#LT_ID').attr('placeholder'));
		$("#LT_ID").focus();
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