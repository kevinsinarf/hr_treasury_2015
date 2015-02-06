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


function AddLeave(id){
	$("#proc").val("edit");
	$("#PER_ID").val(id);
	$("#frm-search").attr("action","salary_leve_his_gov_per_disp.php").submit();
}

function getOrg(value){
	var url ='process/salary_leave_his_gov_per_process.php';
	var html = "<option value=''></option>";
	$.ajax({
	url: url,
	type: 'POST',
	dataType: 'json',
	data: {proc:'get_org_4',PARENT_ID:value},
	async: false,
	success: function(data) {
			$.each(data, function(index, val){
				html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
			});
			$("#s_org_4").html(html);
			$('#s_org_4').trigger('liszt:updated');
			$("#s_org_4").chosen({allow_single_deselect: true	});
		}
	});
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