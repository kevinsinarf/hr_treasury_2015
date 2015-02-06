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
	$("#frm-search").attr("action","pos_level_setup_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#LEVEL_ID").val(id);
	$("#frm-search").attr("action","pos_level_setup_form.php").submit();
}

function chkinput(){
	if($("#TYPE_ID").val() == ""){
		alert("ระบุ "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($("#GROUP").val() == ""){
		alert("ระบุ "+$('#GROUP').attr('placeholder'));
		$("#GROUP").focus();
		return false;
	}
	if($("#LEVEL_NAME_TH").val() == ""){
		alert("ระบุ "+$('#LEVEL_NAME_TH').attr('placeholder'));
		$("#LEVEL_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#LEVEL_NAME_TH').attr('placeholder')+" ซ้ำ");
		$("#LEVEL_NAME_TH").focus();
		return false;
	}
	if($("#flagDup2").val() == 1){
		alert($('#LEVEL_SHORTNAME_TH').attr('placeholder')+" ซ้ำ");
		$("#LEVEL_SHORTNAME_TH").focus();
		return false;
	}
	if($("#flagDup3").val() == 1){
		alert($('#LEVEL_NAME_EN').attr('placeholder')+" ซ้ำ");
		$("#LEVEL_NAME_EN").focus();
		return false;
	}
	if($("#flagDup4").val() == 1){
		alert($('#LEVEL_SHORTNAME_EN').attr('placeholder')+" ซ้ำ");
		$("#LEVEL_SHORTNAME_EN").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#LEVEL_ID").val(id);
		$("#frm-search").attr("action","process/pos_level_setup_process.php").submit();
	}
}

function Chkrepeat(){
	if($("#TYPE_ID").val() == ""){
		$("#TYPE_ID").focus();
		return false;
	}
	chkDup('chkDup1','flagDup1','LEVEL_NAME_TH','LEVEL_ID','SETUP_POS_LEVEL','TYPE_ID='+$('#TYPE_ID').val());
	chkDup('chkDup2','flagDup2','LEVEL_SHORTNAME_TH','LEVEL_ID','SETUP_POS_LEVEL','TYPE_ID='+$('#TYPE_ID').val());
	chkDup('chkDup3','flagDup3','LEVEL_NAME_EN','LEVEL_ID','SETUP_POS_LEVEL','TYPE_ID='+$('#TYPE_ID').val());
	chkDup('chkDup4','flagDup4','LEVEL_SHORTNAME_EN','LEVEL_ID','SETUP_POS_LEVEL','TYPE_ID='+$('#TYPE_ID').val());
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