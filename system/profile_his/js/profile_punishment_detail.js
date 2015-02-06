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
function getBack(per_id,act){
	$("#PER_ID").val(per_id);
	$("ACT").val(act);
	$("#frm-input").attr("action","profile_punishment_disp.php").submit();
}
function editData(id){
	$("#proc").val("edit");
	$("#PUN_ID").val(id);
	$("#frm-search").attr("action","profile_punishment_detail.php").submit();
}
function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
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