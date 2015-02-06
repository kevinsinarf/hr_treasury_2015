var url_process = "process/ss_position_per_staff_process.php";
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
				$('#LEVEL_ID').html(html);
				$('#LEVEL_ID').trigger('liszt:updated');
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
			data:{proc:"get_line",lg_id:e.value,postype_id:5},
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

function get_line_group(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:5},
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

function chkinput(){	
	if($.trim($("#ORG_ID_3").val()) == ''){
		alert("กรุณาเลือก สำนัก/กลุ่ม");
		$("#ORG_ID_3").focus();
		return false;
	}
	if($.trim($("#POS_NO").val()) == ''){
		alert("กรุณากรอก เลขที่ตำแหน่ง");
		$("#POS_NO").focus();
		return false;
	}

	if($.trim($("#LINE_ID").val()) == ''){
		alert("กรุณาเลือก ตำแหน่งในสายงาน");
		$("#LINE_ID").focus();
		return false;
	}
	var salary = parseFloat($("#POS_FRAME_SALARY").val().split(',').join());
	if( salary <= 0 ){
		alert("กรุณากรอก กรอบค่าจ้าง");
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