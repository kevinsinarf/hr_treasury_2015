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
	if($('input:checkbox[name^=APP_ID]:checked').length <= 0){
		alert('กรุณาเลือก ผู้ที่ต้องการโอนข้อมูลเข้าทะเบียนประวัติ');
		$('input:checkbox[name^=APP_ID]:checked').focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#proc').val('transfer');
		$("#frm-search").attr('action','process/profile_his_new_gov_process.php').submit();
	}
}

function getOrg(obj){
	var ORG_ID = $(obj).val();
	var html = " <option value=''></option> ";
	$.ajax({
	url: 'process/profile_his_new_gov_process.php',
	type: 'POST',
	dataType: 'json',
	data: {proc:'get_org',ORG_ID:ORG_ID},
	async: false,
	success: function(data) {
			$.each(data,function(index, val){
				html +=  " <option value='"+val['ID']+"'>"+val['VALUE']+"</option> ";
			});
			$('#s_org_4').html(html);
			$('#s_org_4').trigger('liszt:updated');
		}
	});
}
function chkAllCheck(obj){
	if($(obj).prop('checked')){
		$('input:checkbox[name^=APP_ID]').prop('checked',true);
	}else{
		$('input:checkbox[name^=APP_ID]').prop('checked',false);
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