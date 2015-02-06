var form_input = "pos_level_salary_form.php";

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
	$("#frm-search").attr("action", form_input ).submit();
}

function TransferNormal(){
	$('#proc').val('TransferNormal');
	$('#frm-search').submit();
}
function TransferSpecial(){
	$('#proc').val('TransferSpecial');
	$('#frm-search').submit();
}
function chkinput(){
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-search").submit();
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