var url_process = "process/ss_position_per_temporary_process.php";
var url_form = "ss_position_per_temporary_form.php";
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
	$("#frm-search").attr("action",url_form).submit();
}
function editData(id){
	$("#proc").val("edit");
	$("#POS_ID").val(id);
	$("#frm-search").attr("action",url_form).submit();
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#POS_ID").val(id);
		$("#frm-search").attr("action",url_process).submit();
	}
}
function get_level(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
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
		$("#S_LEVEL_ID").html('<option value="">เลือก</option>');
	}
}
function get_org_4(e){
	if(e.value > 0  && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_org_4",org_parent_id:e.value},
			success : function(data){
				$("#S_ORG_ID_4").html(data);
				$('select').trigger('liszt:updated');
				$("#S_ORG_ID_4").chosen({//ค้นหา+เลือก select 
					allow_single_deselect: true
					//no_results_text: "No results matched"
				});
			}
		});
	}
}
function getLine(val){
	if($('#POSTYPE_ID').val() == 3){ // เฉพาะพนักงานราชการ 
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"getLine",level_id:val,postype_id:$("#POSTYPE_ID").val()},
			success : function(data){
				$("#S_LINE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}
}
function get_line(e){
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_line",type_id:e.value,postype_id:$("#POSTYPE_ID").val()},
			success : function(data){
				$("#S_LINE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}else{
		$("#S_LINE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}
function get_manage(e){
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_manage",type_id:e.value},
			success : function(data){
				$("#S_MANAGE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}else{
		$("#S_MANAGE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}
/*function getPL_LIST(e){
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"getPL_LIST",type_id:e.value,postype_id:$("#POSTYPE_ID").val()},
			success : function(data){
				$("#S_ORG_ID_4").html(data);
			}
		});
	}else{
		$("#S_ORG_ID_4").html('<option value="">เลือก</option>');
	}
}
*/
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