var url_process = "process/ss_position_per_official_process.php";
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
	if($('#proc').val() == 'edit'){
		get_level_salary($('#CO_ID').val());
	}
});

function checkfile(sender) {
    var validExts = new Array(".gif", ".png", ".jpg");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("เลือกไฟล์รูปภาพได้เฉพาะ นามสกุล   " + validExts.toString() + " เท่านั้น");
	  $('#POS_FILE').val('');
	  //$('#SS_PICTURE').replaceWith('<input id="SS_PICTURE" type="file" name="SS_PICTURE" class="form-control"  value="" onchange="checkfile(this);" >');
      return false;
    }
    else return true;
}
function get_level(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:1},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LEVEL_ID').html(html);
				$('#LEVEL_ID').trigger('liszt:updated');
			}
		});
		
		
	}else{
		$("#LEVEL_ID_gov").html('<option value="">เลือก</option>');
	}
}
function get_co_level(e){
	   var html = "<option value=''></option>";
	
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_co_level",type_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#CO_ID').html(html);
				$('#CO_ID').trigger('liszt:updated');
			}
		});
}
function get_line_group(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LG_ID').html(html);
				$('#LG_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#LEVEL_ID_gov").html('<option value="">เลือก</option>');
	}
}
function get_line(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",lg_id:e.value,postype_id:1},
			success : function(data){
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$("#LINE_ID").html(html);
				$("#LINE_ID").trigger('liszt:updated');
			}
		});
	}else{
		$("#LINE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}
function get_level_salary(val){
	   if($.trim($("#LINE_ID").val()) == ''){
		  alert("กรุณาเลือก ตำแหน่งในสายงาน");
		  $("#LINE_ID").focus();
		  $('#CO_ID').val('');
		  $('#CO_ID').trigger('liszt:updated');
		  return false;
	   }
	   var line_id = $('#LINE_ID').val();
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_level_salary",co_id:val, line_id:line_id,postype_id:1},
			success : function(data){
				$('#salary').html(data);			
			}
		});
	
}
function get_manage(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_manage",mt_id:e.value},
			success : function(data){
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$("#MANAGE_ID").html(html);
				$("#MANAGE_ID").trigger('liszt:updated');
			}
		});
	}else{
		$("#MANAGE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}

function get_org_4(e){
	if(e.value > 0  && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_org_4",org_parent_id:e.value},
			success : function(data){
				$("#ORG_ID_4").html(data);
				$('select').trigger('liszt:updated');
				$("#ORG_ID_4").chosen({//ค้นหา+เลือก select 
					allow_single_deselect: true
					//no_results_text: "No results matched"
				});
			}
		});
	}
}
function chkinput(){	
	
	if($.trim($("#POS_NO").val()) == ''){
		alert("กรุณากรอก เลขที่ตำแหน่ง");
		$("#POS_NO").focus();
		return false;
	}
	if($.trim($("#TYPE_ID").val()) == ''){
		alert("กรุณาเลือก "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($.trim($("#CO_ID").val()) == ''){
		alert("กรุณาเลือก ระดับตำแหน่ง");
		$("#CO_ID").focus();
		return false;
	}
	if($.trim($("#LG_ID").val()) == '' ){
		alert("กรุณาเลือก สายงาน");
		$("#LG_ID").focus();
		return false;
	}	
	if($.trim($("#LINE_ID").val()) == ''){
		alert("กรุณาเลือก ตำแหน่งในสายงาน");
		$("#LINE_ID").focus();
		return false;
	}
	var salary = parseFloat($("#POS_FRAME_SALARY").val().split(',').join());
	if( salary <= 0 ){
		alert("กรุณากรอก กรอบเงินเดือน");
		$("#PPOS_FRAME_SALARY").focus();
		return false;
	}
	
	if($('#POS_STATUS').val() == ''){
		alert('กรุณาเลือก '+$('#POS_STATUS').attr('placeholder'));
		$('#POS_STATUS').focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
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