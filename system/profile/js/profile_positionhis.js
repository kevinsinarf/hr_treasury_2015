var url_process = "process/profile_positionhis_process.php";
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
	$("#frm-search").attr("action","profile_positionhis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#POSHIS_ID").val(id);
	$("#frm-search").attr("action","profile_positionhis_form.php").submit();
}
function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}
function chkinput(){
	if($("#MOVEMENT_ID").val() == ""){
		alert("ระบุ "+$('#MOVEMENT_ID').attr('placeholder'));
		$("#MOVEMENT_ID").focus();
		return false;
	}
 	if($("#COM_NO").val() == ""){
		alert("ระบุ "+$('#COM_NO').attr('placeholder'));
		$("#COM_NO").focus();
		return false;
	}

 	if($("#COM_DATE").val() == ""){
		alert("ระบุ ลงวันที่");
		$("#COM_DATE").focus();
		return false;
	}
   	if($("#POSHIS_DATE").val() == ""){
		alert("ระบุ วันที่บันทึก");
		$("#POSHIS_DATE").focus();
		return false;
	}
	if($("#COM_SDATE").val() == ""){
		alert("ระบุ วันที่มีผล");
		$("#COM_SDATE").focus();
		return false;
	}
	if($("#POS_NO").val() == ""){
		alert("ระบุ "+$('#POS_NO').attr('placeholder'));
		$("#POS_NO").focus();
		return false;
	}
	
	if($("#ORG_ID_1").val() == ""){
		alert("ระบุ "+$('#ORG_ID_1').attr('placeholder'));
		$("#ORG_ID_1").focus();
		return false;
	}
	if($("#ORG_ID_2").val() == ""){
		alert("ระบุ "+$('#ORG_ID_2').attr('placeholder'));
		$("#ORG_ID_2").focus();
		return false;
	}
	
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
		if($("#LG_ID").val() == ""){
		alert("ระบุ "+$('#LG_ID').attr('placeholder'));
		$("#LG_ID").focus();
		return false;
	}
	if($("#LINE_ID").val() == ""){
		alert("ระบุ "+$('#LINE_ID').attr('placeholder'));
		$("#LINE_ID").focus();
		return false;
	}
	if (parseFloat($("#SALARY").val().split(',').join('')) <= 0 ){
		alert("ระบุ "+$('#SALARY').attr('placeholder'));
		$("#SALARY").focus();
		return false;
	}
	if($("#COMPENSATION_3").val() == ""){
		alert("ระบุ "+$('#COMPENSATION_3').attr('placeholder'));
		$("#COMPENSATION_3").focus();
		return false;
	}

	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#POSHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_positionhis_process.php").submit();
	}
}

function getORG(obj){
	var val = $(obj).val();
	var id_old = $(obj).attr('id').substr(-1);
	var id = parseInt($(obj).attr('id').substr(-1))+1;
	var id_new = $(obj).attr('id').replace(id_old, id);
	var html = "<option value=''></option>";
	
	$.post('process/profile_positionhis_process.php', {'proc':'get_org', ORG_PARENT_ID:val}, function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
	   });
	   $('#'+id_new).html(html);
	   $('#'+id_new).trigger('liszt:updated');
	   $('#'+id_new).chosen({ allow_single_deselect: true });
	},'json');

}


function getlevel(value,POSTYPE_ID){
	var url ='process/profile_positionhis_process.php';
	var html = "<option value=''></option>";
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'getlevel',POSTYPE_ID:POSTYPE_ID,TYPE_ID:value},
		async: false,
		success: function(data) {
			$.each(data,function(index,value){
					html += "<option value='"+value['ID']+"'>"+value['VALUE']+"</option>";	
			});	
			$('#LEVEL_ID').html(html);
			$('#LEVEL_ID').trigger("liszt:updated");
			$("#LEVEL_ID").chosen({ allow_single_deselect: true });
				
		}
	});
}
function getLineGroup(TYPE_ID,POSTYPE_ID){
		var html = "<option value=''></option>";
		$.post('process/profile_positionhis_process.php',{proc:'getLineGroup',TYPE_ID:TYPE_ID,POSTYPE_ID:POSTYPE_ID},function(data){
			$.each(data,function(index,value){
					html += "<option value='"+value['ID']+"'>"+value['VALUE']+"</option>";	
			});	
			$('#LG_ID').html(html);
			$('#LG_ID').trigger("liszt:updated");
			 $('#LG_ID').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}

function GetLineGov(value,POSTYPE_ID){
	var url ='process/profile_positionhis_process.php'
	var html = "<option value=''></option>";
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'GetLineGov',LG_ID:value,POSTYPE_ID:POSTYPE_ID},
		async: false,
		success: function(data) {
			$.each(data,function(index,value){
					html += "<option value='"+value['ID']+"'>"+value['VALUE']+"</option>";	
			});	
			$('#LINE_ID').html(html);
			$('#LINE_ID').trigger("liszt:updated");
			$("#LINE_ID").chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});
		}
	});
}

function GetManage(MT_ID, POSTYPE_ID){
	var url ='process/profile_positionhis_process.php'
	var html = "<option value=''></option>";
	
		$.ajax({
			url: url,
			dataType : 'json',
			type: "POST",
			data:{proc:"GetManage",MT_ID:MT_ID},
			success : function(data){
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$("#MANAGE_ID").html(html);
				$("#MANAGE_ID").trigger('liszt:updated');
			}
		});
	
}

function GetLineEmp(LEVEL_ID,POSTYPE_ID){
	var url ='process/profile_positionhis_process.php'
	var html = "<option value=''></option>";
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'GetLineEmp',POSTYPE_ID:POSTYPE_ID,LEVEL_ID:LEVEL_ID},
		async: false,
		success: function(data) {
			    $.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger("liszt:updated");
				$("#LINE_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
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