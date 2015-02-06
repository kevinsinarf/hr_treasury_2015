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
function viewData(retire,id,retype){
	$('#RETIRE_ID').val(retire);
	$("#COM_ID").val(id);
	$("#RETYPE_TYPE").val(retype);
	
	var retype_type =  parseInt(retype);
	if(retype_type==2){
		$("#frm-search").attr("action","profile_his_out_gov_detail.php").submit();
	}else{
		$("#frm-search").attr("action","profile_his_out_gov_detail2.php").submit();
	}
}
function chkinput(){
	if(confirm('ยืนยันการโอนข้อมูลเข้าทะเบียนประวัติ')){
		$('#proc').val('transfer');
		$('#frm-input').attr('action','process/profile_his_trans_rule_process.php');
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