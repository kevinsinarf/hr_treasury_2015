// JavaScript Document

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


function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_punishment_form.php").submit();
}




function chkinput(){
	

	if($("#flagDup1").val() == 1){
		alert($('#FINAL_NO').attr('placeholder')+"ซ้ำ");
		$("#FINAL_NO").focus();
		return false;
	}	
	
	if($.trim($("#MOVEMENT_ID").val()) == ""){
		alert("ระบุ "+$('#MOVEMENT_ID').attr('placeholder'));
		$("#MOVEMENT_ID").focus();
		return false;
	} 
 
 	if($.trim($("#FINAL_NO").val()) == ""){
		alert("ระบุ "+$('#FINAL_NO').attr('placeholder'));
		$("#FINAL_NO").focus();
		return false;
	} 
 
 
 	if($.trim($("#COM_DATE").val()) == ""){
		alert("กรุณาลงวันที่");
		$("#COM_DATE").focus();
		return false;
	} 
	

 	if($.trim($("#POSHIS_DATE").val()) == ""){
		alert("กรุุณาระบวันที่บันทึก");
		$("#POSHIS_DATE").focus();
		return false;
	} 	
	

 	if($.trim($("#COM_SDATE").val()) == ""){
		alert("กรุณาระบุวันที่มีผล");
		$("#COM_SDATE").focus();
		return false;
	} 	
		
	

 	if($.trim($("#PUNISH_ID").val()) == ""){
		alert("ระบุ "+$('#PUNISH_ID').attr('placeholder'));
		$("#PUNISH_ID").focus();
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
