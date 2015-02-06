
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
	$("#frm-search").attr("action","man_budget_form.php").submit();
}
function editData(id){
	$("#proc").val("edit");
	$("#MAN_BDG_ID").val(id);
	$("#frm-search").attr("action","man_budget_form.php").submit();
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#MAN_BDG_ID").val(id);
		$("#frm-search").attr("action","process/man_budget_process.php").submit();
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