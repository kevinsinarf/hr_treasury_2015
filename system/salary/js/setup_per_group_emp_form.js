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
	$('#transfer').on('hide.bs.modal',function(e){
		$('#T_ORG_ID_3').val('');
		$('#T_SAL_UP_ID').val('');
		$('#T_ORG_ID_3').trigger('liszt:updated');
	});
	 
});

function searchData(){
	$("#page").val(1);
	$('#frm-search #proc').val('search');
	$("#frm-search").submit();
}

function Transfer(id){
	$('#T_SAL_UP_ID').val(id);
	$('#transfer').modal('show');
}
function AddTransfer(){
	$('#frm-transfer #proc').val('AddTransfer');
	$('#frm-transfer').attr('action','process/setup_per_group_emp_process.php');
	$('#frm-transfer').submit();
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#SAL_UP_ID").val(id);
		$("#frm-search").attr("action","process/setup_per_group_emp_process.php").submit();
	}
}
function get_level(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/setup_per_group_emp_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:5},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#S_LEVEL_ID').html(html);
				$('#S_LEVEL_ID').trigger('liszt:updated');
			}
		});
		
		
	}else{
		$("#LEVEL_ID_gov").html('<option value="">เลือก</option>');
	}
}

function get_line_group(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/setup_per_group_emp_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:5},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#S_LG_ID').html(html);
				$('#S_LG_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#S_LG_ID").html('<option value="">เลือก</option>');
	}
}

function get_line(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/setup_per_group_emp_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",lg_id:e.value,postype_id:5},
			success : function(data){
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$("#S_LINE_ID").html(html);
				$("#S_LINE_ID").trigger('liszt:updated');
			}
		});
	}else{
		$("#S_LINE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
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