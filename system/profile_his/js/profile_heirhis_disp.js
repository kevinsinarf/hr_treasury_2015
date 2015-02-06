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
	$("#proc").val("add_head");
	$("#frm-search").attr("action","profile_heirhis_head_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#HEIR_ID").val(id);
	$("#frm-search").attr("action","profile_heirhis_form.php").submit();
}

function chkinput(){	

	if($("#HEIR_SDATE").val() == ""){
		alert("ระบุ เมื่อวันที่");
		$("#HEIR_SDATE").focus();
		return false;
	}
	if($("#HEIR_TYPE_SALARY").val() == ""){
		alert("ระบุ "+$('#HEIR_TYPE_SALARY').attr('placeholder'));
		$("#HEIR_TYPE_SALARY").focus();
		return false;
	}
	if($("#HEIR_TOTAL").val() == ""){
		alert("ระบุ "+$('#HEIR_TOTAL').attr('placeholder'));
		$("#HEIR_TOTAL").focus();
		return false;
	}		
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#proc').val('add_head');
		$("#frm-input").submit();
	}
}

function search_parent(){
	if($("#HEIR_IDCARD").val() == ''){
		$('#btn_save').hide();
		$('#show_parent_data').hide();
		$('#PK_ID').val('');
		alert("ระบุ "+$("#HEIR_IDCARD").attr('placeholder'));
		$("#HEIR_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#HEIR_IDCARD').val())){ 
			$('#btn_save').hide();
			$('#show_parent_data').hide();
			$('#PK_ID').val('');
			alert($("#HEIR_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#HEIR_IDCARD").focus();
			return false;
		}
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#HEIR_ID").val(id);
		$("#frm-search").attr("action","process/profile_heirhis_process.php").submit();
	}
}


function getRampr(obj){	
	var arr_id = $(obj).attr('id').split('_');	
	var id = arr_id[3];
	var val = $(obj).val();
	var html = "<option value=''></option>";
	$.post('process/profile_heirhis_process.php',{'proc': 'getApmr','prov_id':val},function(data){
		$.each(data,function(index, val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
		});
		
		$('#ADDRESS_AMPR_ID_'+id).html(html);
		$('#ADDRESS_AMPR_ID_'+id).trigger('liszt:updated');
	},'json');
	
}

function getStamb(obj){
	
	var arr_id = $(obj).attr('id').split('_');	
	var id = arr_id[3];
	var val = $(obj).val();
	var html = "<option value=''></option>";
	$.post('process/profile_heirhis_process.php',{'proc': 'getTamb','ampr_id':val},function(data){
		$.each(data,function(index, val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
		});
		
		$('#ADDRESS_TAMB_ID_'+id).html(html);
		$('#ADDRESS_TAMB_ID_'+id).trigger('liszt:updated');
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