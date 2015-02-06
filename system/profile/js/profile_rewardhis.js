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
	$("#frm-search").attr("action","profile_rewardhis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#REWHIS_ID").val(id);
	$("#frm-search").attr("action","profile_rewardhis_form.php").submit();
}

function chkinput(){
/*	if($("#TYPE_ID").val() == ""){
		alert("ระบุ "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($("#LEVEL_ID").val() == ""){
		alert("ระบุ "+$('#LEVEL_ID').attr('placeholder'));
		$("#LEVEL_ID").focus();
		return false;
	}
	if($("#LINE_ID").val() == ""){
		alert("ระบุ "+$('#LINE_ID').attr('placeholder'));
		$("#LINE_ID").focus();
		return false;
	}
	if($("#ORG_ID_2").val() == ""){
		alert("ระบุ "+$('#ORG_ID_2').attr('placeholder'));
		$("#ORG_ID_2").focus();
		return false;
	}
*/	if($("#REWARD_ID").val() == ""){
		alert("ระบุ "+$('#REWARD_ID').attr('placeholder'));
		$("#REWARD_ID").focus();
		return false;
	}
	/*if($.trim($("#REH_DATE").val()) == ""){
		alert("ระบุ วันที่ได้รับ");
		$("#REH_DATE").focus();
		return false;
	}*/
		
	if($("input[name=ACTIVE_STATUS]:checked").val() == ""){
		alert("ระบุ สถานะการใช้งาน");
		$("#ACTIVE_STATUS1").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#REH_ID").val(id);
		$("#frm-search").attr("action","process/profile_rewardhis_process.php").submit();
	}
}

function getORG(obj){
	var val = $(obj).val();
	var id_old = $(obj).attr('id').substr(-1);
	var id = parseInt($(obj).attr('id').substr(-1))+1;
	var id_new = $(obj).attr('id').replace(id_old, id);
	var html = "<option value=''></option>";
	$.post('process/profile_rewardhis_process.php', {'proc':'get_org', ORG_PARENT_ID:val}, function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
	   });
	   $('#'+id_new).html(html);
	   $('#'+id_new).trigger('liszt:updated');
	},'json');

}
function get_level(e){
	var html = "<option value=''></option>";
	var postype_id = $('#POSTYPE_ID').val();
		$.ajax({
			url: 'process/profile_rewardhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:postype_id},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LEVEL_ID').html(html);
				$('#LEVEL_ID').trigger('liszt:updated');
			}
		});
	
}

function get_line_group(e){
	var html = "<option value=''></option>";
	var postype_id = $('#POSTYPE_ID').val();
		$.ajax({
			url: 'process/profile_rewardhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:postype_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger('liszt:updated');
			}
		});
}

function get_line(e){
	var html = "<option value=''></option>";
	var postype = $('#POSTYPE_ID').val();
	var id = $(e).attr('id');
		$.ajax({
			url: 'process/profile_rewardhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",type_id:e.value,postype_id:postype, name:id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger('liszt:updated');
			}
		});
	
}
function get_manage(e){
	var html = "<option value=''></option>";
	var type_id = $('#TYPE_ID').val();
	var mt_id = $('#MT_ID').val();
		$.ajax({
			url: 'process/profile_rewardhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_manage",type_id:type_id,mt_id:mt_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#MANAGE_ID').html(html);
				$('#MANAGE_ID').trigger('liszt:updated');
			}
		});
	
}
function chkType(val){
	if(val == 1){
		$('#type_other input:text').val('');
		$('#type_other').hide();
		$('#type_gov').show();
	}else{
		$('#type_other').show();
		$('#type_gov').hide();
		$('#type_gov select').val('');
		$('.selectbox').trigger('liszt:updated');
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