var url_process_1 = "process/profile_his_proc.php";
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

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_his_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PER_ID").val(id);
	$("#frm-search").attr("action","profile_his_form.php").submit();
}

function chkinput(){
	if($.trim($("#idcard").val()) == ""){
		alert("ระบุ "+$('#idcard').attr('placeholder'));
		$("#idcard").focus();
		return false;
	}
	if($.trim($("#PREFIX").val()) == ""){
		alert("ระบุ "+$('#PREFIX').attr('placeholder'));
		$("#PREFIX").focus();
		return false;
	}
	if($.trim($("#BLOOD_TYPE").val()) == ""){
		alert("ระบุ "+$('#BLOOD_TYPE').attr('placeholder'));
		$("#BLOOD_TYPE").focus();
		return false;
	}
	if($.trim($("#DATE_BIRTH").val()) == ""){
		alert("ระบุ วันเดือนปีเกิด ");
		$("#DATE_BIRTH").focus();
		return false;
	}
	if($.trim($("#DATE_BIRTH").val()) == ""){
		alert("ระบุ วันเดือนปีเกิด ");
		$("#DATE_BIRTH").focus();
		return false;
	}
	if($.trim($("#fname_th").val()) == ""){
		alert("ระบุ "+$('#fname_th').attr('placeholder'));
		$("#fname_th").focus();
		return false;
	}
	if($.trim($("#lname_th").val()) == ""){
		alert("ระบุ "+$('#lname_th').attr('placeholder'));
		$("#lname_th").focus();
		return false;
	}
	if($.trim($("#fname_en").val()) == ""){
		alert("ระบุ "+$('#fname_en').attr('placeholder'));
		$("#fname_en").focus();
		return false;
	}
	if($.trim($("#lname_en").val()) == ""){
		alert("ระบุ "+$('#lname_en').attr('placeholder'));
		$("#lname_en").focus();
		return false;
	}
	if($.trim($("#NATION_S").val()) == ""){
		alert("ระบุ "+$('#NATION_S').attr('placeholder'));
		$("#NATION_S").focus();
		return false;
	}
	if($.trim($("#NATION_CH").val()) == ""){
		alert("ระบุ "+$('#NATION_CH').attr('placeholder'));
		$("#NATION_CH").focus();
		return false;
	}
	if($.trim($("#RELIGION").val()) == ""){
		alert("ระบุ "+$('#RELIGION').attr('placeholder'));
		$("#RELIGION").focus();
		return false;
	}
	if($.trim($("#WEIGHT").val()) == ""){
		alert("ระบุ "+$('#WEIGHT').attr('placeholder'));
		$("#WEIGHT").focus();
		return false;
	}
	if($.trim($("#HEIGHT").val()) == ""){
		alert("ระบุ "+$('#HEIGHT').attr('placeholder'));
		$("#HEIGHT").focus();
		return false;
	}
	if($.trim($("#TYPE_ID").val()) == ""){
		alert("ระบุ "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($.trim($("#LEVEL_ID").val()) == ""){
		alert("ระบุ "+$('#LEVEL_ID').attr('placeholder'));
		$("#LEVEL_ID").focus();
		return false;
	}
	if($.trim($("#LINE_ID").val()) == ""){
		alert("ระบุ "+$('#LINE_ID').attr('placeholder'));
		$("#LINE_ID").focus();
		return false;
	}
	if($.trim($("#ORG_ID_2").val()) == ""){
		alert("ระบุ "+$('#ORG_ID_2').attr('placeholder'));
		$("#ORG_ID_2").focus();
		return false;
	}
	if($.trim($("#ORG_ID_3").val()) == ""||$.trim($("#ORG_ID_3").val()).length==0){
		alert("ระบุ "+$('#ORG_ID_3').attr('placeholder'));
		$("#ORG_ID_3").focus();
		return false;
	}
	if($.trim($("#ORG_ID_4").val()) == ""||$.trim($("#ORG_ID_4").val()).length==0){
		alert("ระบุ "+$('#ORG_ID_4').attr('placeholder'));
		$("#ORG_ID_4").focus();
		return false;
	}
	if($.trim($("#SALARY").val()) == ""){
		alert("ระบุ "+$('#SALARY').attr('placeholder'));
		$("#SALARY").focus();
		return false;
	}
	if($.trim($("#COMPENSATION_2").val()) == ""){
		alert("ระบุ "+$('#COMPENSATION_2').attr('placeholder'));
		$("#COMPENSATION_2").focus();
		return false;
	}
	if($.trim($("#DATE_ENTRANCE").val()) == ""){
		alert("ระบุ วันที่บรรจุ");
		$("#DATE_ENTRANCE").focus();
		return false;
	}
	if($.trim($("#DATE_RETIRE").val()) == ""){
		alert("ระบุ กำหนดวันเกษียณราชการ");
		$("#DATE_RETIRE").focus();
		return false;
	}
	if($.trim($("#PER_STATUS").val()) == ""){
		alert("ระบุ "+$('#PER_STATUS').attr('placeholder'));
		$("#PER_STATUS").focus();
		return false;
	}
	

	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PER_ID").val(id);
		$("#frm-search").attr("action","process/profile_his_proc.php").submit();
	}
}
function getORG(obj){
	var val = $(obj).val();
	var id_old = $(obj).attr('id').substr(-1);
	var id = parseInt($(obj).attr('id').substr(-1))+1;
	var id_new = $(obj).attr('id').replace(id_old, id);
	var html = "<option value=''></option>";
	
	$.post('process/profile_his_proc.php', {'proc':'get_org', ORG_PARENT_ID:val}, function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
	   });
	   $('#'+id_new).html(html);
	   $('#'+id_new).trigger('liszt:updated');
	   $('#'+id_new).chosen({ allow_single_deselect: true });
	},'json');

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