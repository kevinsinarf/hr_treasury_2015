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

function getTitle(){
	$.ajax({
		url: "process/gettitle.php",
		type: "POST",
		data:{proc:"getTitle",PREFIX_ID:$('#PREFIX_ID').val()},
		success : function(data){ 
			$('#prefix_en').html(data);
		}
	});
}

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","pension_record_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PENSION_ID").val(id);
	$("#frm-search").attr("action","pension_record_form.php").submit();
}

function chkinput(){	
	if($("#S_PENSION_IDCARD").val() == ""){
		alert("ระบุ เลขประจำตัวประชาชน");
		$("#S_PENSION_IDCARD").focus();
		return false;
	}
	if($("#PENSION_TYPE_REQUEST_CIVIL").val() == ""){
		alert("ระบุ สาเหตุที่ขอบำเหน็จบำนาญ");
		$("#PENSION_TYPE_REQUEST_CIVIL").focus();
		return false;
	}
	if($("#PENSION_TYPE_PENSION").val() == ""){
		alert("ระบุ ประเภทการขอบำเหน็จบำนาญ");
		$("#PENSION_TYPE_PENSION").focus();
		return false;
	}
	if($("#PENSION_RECEIVE_IDCARDS").val() == ""){
		alert("ระบุ เลขประจำตัวประชาชนผู้ติดต่อรับบำเหน็จบำนาญ");
		$("#PENSION_RECEIVE_IDCARDS").focus();
		return false;
	}else{
		if(!checkID($('#PENSION_RECEIVE_IDCARDS').val())){ 
			alert('เลขประจำตัวประชาชนไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PENSION_RECEIVE_IDCARDS").focus();
			return false;
		}
	}
	if($("#PENSION_RECEIVE_PREFIX").val() == ""){
		alert("ระบุ คำนำหน้าชื่อ");
		$("#PENSION_RECEIVE_PREFIX").focus();
		return false;
	}
	if($("#PENSION_RECEIVE_FIRSTNAME_TH").val() == ""){
		alert("ระบุ ชื่อตัว");
		$("#PENSION_RECEIVE_FIRSTNAME_TH").focus();
		return false;
	}	
	if($("#PENSION_RECEIVE_LASTNAME_TH").val() == ""){
		alert("ระบุ ชื่อสกุล");
		$("#PENSION_RECEIVE_LASTNAME_TH").focus();
		return false;
	}
	if($('#PENSION_BANK_ID').val() == ''){
		alert('ระบ ธนาคาร');
		$('#PENSION_BANK_ID').focus();
		return false;
	}
	if($("#PENSION_BANK_BRANCH").val() == ""){
		alert("ระบุ สาขา");
		$("#PENSION_BANK_BRANCH").focus();
		return false;
	}
	if($("#PENSION_BANK_NO").val() == ""){
		alert("ระบุ เลขที่บัญชี");
		$("#PENSION_BANK_NO").focus();
		return false;
	}
	if($("#PENSION_BANK_NAME").val() == ""){
		alert("ระบุ ชื่อบัญชี");
		$("#PENSION_BANK_NAME").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#frm-input').attr('action', 'process/pension_record_process.php');
		$("#frm-input").submit();
	}
}

function delData(id, PER_ID){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PENSION_ID").val(id);
		$('#PER_ID').val(PER_ID);
		$("#frm-search").attr("action","process/pension_record_process.php").submit();
	}
}

function clrContact(val){
	if(val == 1){
		if($('#proc').val() == 'add'){
			$('#PENSION_RECEIVE_IDCARDS').val($('#S_PENSION_IDCARD').val());
			$('#PENSION_RECEIVE_PREFIX').val($('#O_PENSION_RECEIVE_PREFIX').val());
			$('#PENSION_RECEIVE_FIRSTNAME_TH').val($('#O_PENSION_RECEIVE_FIRSTNAME_TH').val());
			$('#PENSION_RECEIVE_MIDNAME_TH').val($('#O_PENSION_RECEIVE_MIDNAME_TH').val());
			$('#PENSION_RECEIVE_LASTNAME_TH').val($('#O_PENSION_RECEIVE_LASTNAME_TH').val());
		}else if($('#proc').val() == 'edit'){
			$('#PENSION_RECEIVE_IDCARDS').val($('#S_PENSION_IDCARD').val());
			$('#PENSION_RECEIVE_PREFIX').val($('#O_PREFIX').val());
			$('#PENSION_RECEIVE_FIRSTNAME_TH').val($('#O_FIRSTNAME_TH').val());
			$('#PENSION_RECEIVE_MIDNAME_TH').val($('#O_MIDNAME_TH').val());
			$('#PENSION_RECEIVE_LASTNAME_TH').val($('#O_LASTNAME_TH').val());
		}
	}else if(val == 2){
		$('#PENSION_RECEIVE_IDCARDS').val('');
		$('#PENSION_RECEIVE_PREFIX').val('');
		$('#PENSION_RECEIVE_FIRSTNAME_TH').val('');
		$('#PENSION_RECEIVE_MIDNAME_TH').val('');
		$('#PENSION_RECEIVE_LASTNAME_TH').val('');
	}	
}

function getcountry(id){
	if(id==$('#default_country_id').val()){
		$('#country_del1').hide();
		$('#country_del2').show();
	}else{
		$('#country_del2').hide();
		$('#country_del1').show();
	}
}

function getRampr(id,name_rampr,name_tamb){	
	val=$('#'+name_rampr).val();	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,name_tamb:name_tamb,val:val},
		success : function(data){
			$('#ss_ampr').html(data);
			$("#"+name_rampr).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			getStamb(name_rampr,$('#'+name_rampr).val(),name_tamb);
		}
	});
}

function getStamb(id,val_ampr,name_tamb){
	val=$('#'+name_tamb).val();	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"stamb",v_tamb:val_ampr,z_id:name_tamb,z_name:name_tamb,val:val},
		success : function(data){
			$('#ss_tamb').html(data);
			$("#"+name_tamb).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
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