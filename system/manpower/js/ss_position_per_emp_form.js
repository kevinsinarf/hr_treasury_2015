var url_process = "process/ss_position_per_process.php";
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
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:$("#POSTYPE_ID").val()},
			success : function(data){  
				$("#LEVEL_ID_gov").html(data);
			}
		});
	}else{
		$("#LEVEL_ID_gov").html('<option value="">เลือก</option>');
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
function getLine(val){
	if($('#POSTYPE_ID').val() == 3){ // เฉพาะพนักงานราชการ 
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"getLine",level_id:val,postype_id:$("#POSTYPE_ID").val()},
			success : function(data){
				$("#LINE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}
}

function getFrame(e){
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"getFrame",type_id:e.value},
			success : function(data){
				$("#CL_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}else{
		$("#CL_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}

function get_line(e){
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: url_process,
			type: "POST",
			data:{proc:"get_line",type_id:e.value,postype_id:$("#POSTYPE_ID").val()},
			success : function(data){
				$("#LINE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}else{
		$("#LINE_ID").html('<option value="">เลือก</option>');
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
				alert(data);
				$("#MANAGE_ID").html(data);
				$('select').trigger('liszt:updated');
			}
		});
	}else{
		$("#MANAGE_ID").html('<option value="">เลือก</option>');
		$('select').trigger('liszt:updated');
	}
}
function chkinput(){	
	
	if($.trim($("#POS_NO").val()) == ''){
		alert("กรุณากรอก เลขที่ตำแหน่ง");
		$("#POS_NO").focus();
		return false;
	}
	if($.trim($("#POS_LIVE_YEAR").val()) == '' && $("#POSTYPE_ID").val() == '3'){
		alert("กรุณากรอก ปีกรอบ");
		$("#POS_LIVE_YEAR").focus();
		return false;
	}
	if($.trim($("#POS_LIVE_YEAR").val()) != '' && $("#POSTYPE_ID").val() == '3'){
		var result = $("#POS_LIVE_YEAR").val()%4;
		if(result != 1){
			alert('กรุณา ตรวจสอบปีกรอบให้ถูกต้อง');	
			return false;
		}
	}
	if($.trim($("#TYPE_ID").val()) == '' && $("#POSTYPE_ID").val() != 3){
		alert("กรุณาเลือก "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($.trim($("#LEVEL_ID_gov").val()) == '' && $('#POSTYPE_ID').val() != 3){
		alert("กรุณาเลือก ระดับตำแหน่ง");
		$("#LEVEL_ID").focus();
		return false;
	}
	if($.trim($("#LEVEL_ID").val()) == '' && $('#POSTYPE_ID').val() == 3){
		alert("กรุณาเลือก กลุ่ม");
		$("#LEVEL_ID").focus();
		return false;
	}	
	if($.trim($("#LINE_ID").val()) == ''){
		alert("กรุณาเลือก ตำแหน่งในสายงาน");
		$("#LINE_ID").focus();
		return false;
	}
	if($.trim($("#ORG_ID_3").val()) == ''){
		alert("กรุณาเลือก สำนัก/กลุ่ม");
		$("#ORG_ID_3").focus();
		return false;
	}
	if($.trim($("#ORG_ID_4").val()) == '' && $("#POSTYPE_ID").val() != '3'){
		alert("กรุณาเลือก กลุ่มงาน");
		$("#ORG_ID_4").focus();
		return false;
	}
	if($("#POS_FRAME_SALARY").val() <= 0){
		alert("กรุณากรอก กรอบ"+$("#textSalary").val());
		$("#POS_FRAME_SALARY").focus();
		return false;
	}
	if($.trim($("#POS_FRAME_POSITION_SALARY").val()) <= 0 && $("#POSTYPE_ID").val() == '1'){
		alert("กรุณากรอก กรอบเงินประจำตำแหน่ง");
		$("#POS_FRAME_POSITION_SALARY").focus();
		return false;
	}
	if($("#POS_FRAME_COMPENSATION_1").val() <= 0){
		alert("กรุณากรอก กรอบค่าคอบแทนx");
		$("#POS_FRAME_COMPENSATION_1").focus();
		return false;
	}
	if($.trim($("#POS_FRAME_COMPENSATION_2").val()) <= 0){
		alert("กรุณากรอก กรอบค่าคอบแทนพิเศษ");
		$("#POS_FRAME_COMPENSATION_2").focus();
		return false;
	}
	if($.trim($("#POS_STATUS").val()) == ''){
		alert("กรุณาเลือก สถานะของตำแหน่ง");
		$("#LINE_ID").focus();
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