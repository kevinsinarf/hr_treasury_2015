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
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	$("#page").val(1);
	$('#proc').val('search');
	$("#frm-search").submit();
}
function addGroup(id){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	$('#proc').val('add');
	$('#page').val(1);
	$('#OGR_ID_3').val(id);
	$('#frm-search').attr('action','setup_per_group_gov_form.php');
	$('#frm-search').submit();
}

function addPerAllMg(){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	if(confirm("การนำเข้าข้อมูลใหม่ ระบบจะทำการลบข้อมูลการจัดกลุ่มเดิมทั้งหมด คุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
	  $('#proc').val('AddAllMg');
	  $('#frm-search').attr('action','process/setup_per_group_gov_process.php');
	  $('#frm-search').submit();
	}
}

function addPerAll(){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	if(confirm("การนำเข้าข้อมูลใหม่ ระบบจะทำการลบข้อมูลการจัดกลุ่มเดิมทั้งหมด คุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
	  $('#proc').val('AddAll');
	  $('#frm-search').attr('action','process/setup_per_group_gov_process.php');
	  $('#frm-search').submit();
	}
}
function ConfirmPer(){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	var S_YEAR_BDG = $('#S_YEAR_BDG').val();
	var S_ROUND = $('#S_ROUND').val();  
	if(confirm("อนุมัติการจัดกลุ่มการเลื่อนเงินเดือน\nประจำปีงบประมาณ "+S_YEAR_BDG+" รอบ "+S_ROUND+"\nคุณจะไม่สามารถแก้ไขข้อมูลได้อีก\nคุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
	  $('#proc').val('Confirm');
	  $('#frm-search').attr('action','process/setup_per_group_gov_process.php');
	  $('#frm-search').submit();
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