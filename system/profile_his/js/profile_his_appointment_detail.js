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

function viewData(id){
	$("#ROTCOM_ID").val(id);
	$("#frm-search").attr("action","profile_his_appointment_detail.php").submit();
}

function chkinput(){
	if(confirm('ยืนยันการโอนข้อมูลการย้ายตำแหน่ง')){
		$('#proc').val('transfer');
		$('#frm-input').attr('action','process/profile_his_transfer_appointment_process.php');
		$('#frm-input').submit();
	}	
}
// =======================================

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