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

function print_excel(){
 
  	$('#frm-export_exc').submit();	
}

function GetPer(){
	$('#frm-search').submit();
}

function print_report(type, url){
	if(type = 'pdf'){
		$('#frm-search').attr('target','_blank');
		$('#frm-search').attr('action',url);
		$('#frm-search').submit();
		$('#frm-search').attr('target','');
		$('#frm-search').attr('action','');
		
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