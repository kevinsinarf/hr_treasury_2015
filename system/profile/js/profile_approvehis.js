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
	$("#frm-search").attr("action","").submit();	
}

function addData(){
	$("#frm-search").attr("action","profile_approvehis_list.php").submit();
}

function approveData(id,TABLE_ID){
	$("#proc").val("approve");
	$("#REQUEST_ID").val(id);
	
	$.ajax({
		url:"process/profile_approvehis_process.php",
		dataType:"html",
		type:"POST",
		data:{proc:'getTablename',TABLE_ID:TABLE_ID},
		success: function(data_url){
			$("#frm-search").attr("action",data_url).submit();	
		}
	});
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