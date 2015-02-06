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
	$("#frm-search").attr("action","setup_pos_line_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#LINE_ID").val(id);
	$("#frm-search").attr("action","setup_pos_line_form.php").submit();
}

function chkinput(){
	if($("#TYPE_ID").val() == ""){
		alert("ระบุ "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($("#LEVEL_ID").val() == ""){
		alert("ระบุ "+$('#LEVEL_ID').attr('placeholder'));
		$("#LEVEL_ID").focus();
		return false;
	}
	if($("#LINE_NAME_TH").val() == ""){
		alert("ระบุ "+$('#LINE_NAME_TH').attr('placeholder'));
		$("#LINE_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#LINE_NAME_TH').attr('placeholder')+" ซ้ำ");
		$("#LINE_NAME_TH").focus();
		return false;
	}
	if($("#flagDup2").val() == 1){
		alert($('#LINE_SHORTNAME_TH').attr('placeholder')+" ซ้ำ");
		$("#LINE_SHORTNAME_TH").focus();
		return false;
	}
	if($("#flagDup3").val() == 1){
		alert($('#LINE_NAME_EN').attr('placeholder')+" ซ้ำ");
		$("#LINE_NAME_EN").focus();
		return false;
	}
	if($("#flagDup4").val() == 1){
		alert($('#LINE_SHORTNAME_EN').attr('placeholder')+" ซ้ำ");
		$("#LINE_SHORTNAME_EN").focus();
		return false;
	}
	if($("#LINE_DECO_RIGHT").val() == ""){
		alert("ระบุ "+$('#LINE_DECO_RIGHT').attr('placeholder'));
		$("#LINE_DECO_RIGHT").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#LINE_ID").val(id);
		$("#frm-search").attr("action","process/setup_pos_line_process.php").submit();
	}
}
function getLevel(obj){
	var html = "<option value=''></option>";
	if(obj.value > 0 && $.trim(obj.value) != ""){
		$.ajax({
			url: "process/setup_pos_line_process.php",
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:obj.value,postype_id:3},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LEVEL_ID').html(html);
				$('#LEVEL_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#LEVEL_ID").html('<option value=""></option>');
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