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
	if($('input[name=FAMILY_IDTYPE]:checked').val() == 1){
		$('#shw_txt_type').html('เลขประจำตัวประชาชน');	
		$('#FAMILY_IDCARD1').show();
		$('#FAMILY_IDCARD2').hide();
	}else{
		$('#shw_txt_type').html('เลขที่หนังสือเดินทาง');	
		$('#FAMILY_IDCARD1').hide();
		$('#FAMILY_IDCARD2').show();
	}	
	
	if($('#FAMILY_JOB_ID').val() == '999999'){
		$('#shw_job_other').show();
	}else{
		$('#shw_job_other').hide();	
	}
	
	if($('#ADDRESS_COUNTRY_ID').val() == $('#default_country_id').val()){
		$('.chk_country').show();
		$('.chk_city').hide();
	}else{
		$('.chk_country').hide();
		$('.chk_city').show();
	}
	
	if($('#FAMILY_RELATIONSHIP').val() == 3){
		$('#shw_family_type3').show();
		$('#shw_family_type4').hide();
		$('#shw_family_type5').hide();
	}else if($('#FAMILY_RELATIONSHIP').val() == 4){
		$('#shw_family_type3').hide();
		$('#shw_family_type4').show();
		$('#shw_family_type5').hide();
	}else if($('#FAMILY_RELATIONSHIP').val() == 5){
		$('#shw_family_type3').hide();
		$('#shw_family_type4').hide();
		$('#shw_family_type5').show();
	}else{
		$('#shw_family_type3').hide();
		$('#shw_family_type4').hide();
		$('#shw_family_type5').hide();
	}
	
	if($('#MARRY_STATUS').val() == 2){
		$('#shw_family_type3_1').show();
	}else{
		$('#shw_family_type3_1').hide();
	}
	
	if($('#FAMILY_STATUS').val() == 2){
		$('#shw_family_type1_1').show();
	}else{
		$('#shw_family_type1_1').hide();
	}
	
	if($('#PROTEGE_STATUS').val() == 2 ){
		$('#shw_protege_e').show();	
	}else{
		$('#shw_protege_e').hide();	
	}
});

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_contact_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#FAMILY_ID").val(id);
	$("#frm-search").attr("action","profile_contact_form.php").submit();
}

function chkinput(){	
	if($('#FAMILY_DATE').val() == ''){
		alert('ระบุ วันที่แจ้ง');
		$('#FAMILY_DATE').focus();
		return false;
	}
	
	if($('#FAMILY_RELATIONSHIP').val() == ''){
		alert('ระบุ ความสัมพันธ์');
		$('#FAMILY_RELATIONSHIP').focus();
		return false;
	}
	
	if($("#FAMILY_PREFIX_ID").val() == ""){
		alert("ระบุ "+$('#FAMILY_PREFIX_ID').attr('placeholder'));
		$("#FAMILY_PREFIX_ID").focus();
		return false;
	}
	
	if($("#FAMILY_FIRSTNAME_TH").val() == ""){
		alert("ระบุ "+$('#FAMILY_FIRSTNAME_TH').attr('placeholder'));
		$("#FAMILY_FIRSTNAME_TH").focus();
		return false;
	}
		
	if($("#FAMILY_LASTNAME_TH").val() == ""){
		alert("ระบุ "+$('#FAMILY_LASTNAME_TH').attr('placeholder'));
		$("#FAMILY_LASTNAME_TH").focus();
		return false;
	}
	
	
	if($('#FAMILY_STATUS').val() == ''){
		alert('ระบุ สถานะการมีชีวิต');
		$('#FAMILY_STATUS').focus();
		return false;
	}
	//$arr_marry_status = array('1'=>'อยู่ระหว่างสมรส', '2'=>'หย่า', '3'=>'หม้าย');
	//$arr_smarry_type_status=array('1'=>'โสด','2'=>'สมรส ', '3'=>' หย่า ', '4'=>'หม้าย');
	if($('#FAMILY_RELATIONSHIP').val() == 3){
		if($('#MARRY_STATUS').val() == 1 && $('#PER_STATUS_MARRY').val() != 2){ //อยู่ระหว่างสมรส
			alert('กรุณา แก้ไขข้อมูลหลัก สถานภาพการสมรส ให้ถูกต้อง');
			return false;
		}	
		
		if($('#MARRY_STATUS').val() == 2 && $('#PER_STATUS_MARRY').val() != 3){ //หย่า
			alert('กรุณา แก้ไขข้อมูลหลัก สถานภาพการสมรส ให้ถูกต้อง');
			return false;
		}
		
		if($('#MARRY_STATUS').val() == 3 && $('#PER_STATUS_MARRY').val() != 4){ //หม้าย
			alert('กรุณา แก้ไขข้อมูลหลัก สถานภาพการสมรส ให้ถูกต้อง');
			return false;
		}
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function chkOther(id){
	if(id == '999999'){
		$('#shw_job_other').show();	
	}else{
		$('#shw_job_other').hide();	
		$('#FAMILY_JOB_OTHER').val('');
	}
}

function getType(val){
	if(val == 1){
		$('#shw_txt_type').html('เลขประจำตัวประชาชน');	
		$('#FAMILY_IDCARD1').show();
		$('#FAMILY_IDCARD2').hide();
	}else{
		$('#shw_txt_type').html('เลขที่หนังสือเดินทาง');	
		$('#FAMILY_IDCARD1').hide();
		$('#FAMILY_IDCARD2').show();
	}	
}

function chkFamilyType(type){
	if(type == 3){
		$('#shw_family_type3').show();
		$('#shw_family_type4').hide();
		$('#shw_family_type5').hide();
	}else if(type == 4){
		$('#shw_family_type3').hide();
		$('#shw_family_type3_1').hide();
		$('#shw_family_type4').show();
		$('#shw_family_type5').hide();
	}else if(type == 5){
		$('#shw_family_type3').hide();
		$('#shw_family_type3_1').hide();
		$('#shw_family_type4').hide();
		$('#shw_family_type5').show();
	}else{
		$('#shw_family_type3').hide();
		$('#shw_family_type3_1').hide();
		$('#shw_family_type4').hide();
		$('#shw_family_type5').hide();
	}
}

function chkMarryStatus(status){
	if(status == 2){
		$('#shw_family_type3_1').show();
	}else{
		$('#shw_family_type3_1').hide();	
	}
}

function chkFamilyStatus(status){
	if(status == 2){
		$('#shw_family_type1_1').show();
	}else{
		$('#shw_family_type1_1').hide();
	}
}

function chkProtegeStatus(status){
	if(status == 2){
		$('#shw_protege_e').show();
	}else{
		$('#shw_protege_e').hide();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#FAMILY_ID").val(id);
		$("#frm-search").attr("action","process/profile_contact_process.php").submit();
	}
}

function getcountry(id){
	if(id==$('#default_country_id').val()){
		$('.chk_country').show();
		$('.chk_city').hide();
	}else{
		$('.chk_country').hide();
		$('.chk_city').show();
	}
}

function getRampr(id,name_rampr,name_tamb, id_shw_ampr, id_shw_tamb){
	val=$('#'+name_rampr).val();	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,name_tamb:name_tamb,val:val,id_shw_tamb:id_shw_tamb},
		success : function(data){
			$('#'+id_shw_ampr).html(data);
			$("#"+name_rampr).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			getStamb(name_rampr,$('#'+name_rampr).val(),name_tamb,id_shw_tamb);
		}
	});
}

function getStamb(id,val_ampr,name_tamb, id_shw_tamb){
	val=$('#'+name_tamb).val();	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"stamb",v_tamb:val_ampr,z_id:name_tamb,z_name:name_tamb,val:val},
		success : function(data){
			$('#'+id_shw_tamb).html(data);
			$("#"+name_tamb).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
			});
		}
	});	
}

function getZip(id, name_zip, oncharng) {
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",
		type: "POST",
		data: {proc: "zipcode", v_zip: name_zip},
		success: function(data) {
		  $('#ADDRESS_POSTCODE').val(data);
		}
	});
}

function getTelClass(prov_id, key_index){
	$("#ADDRESS_TEL").removeClass("telbkk");
	$("#ADDRESS_FAX").removeClass("telbkk");
	$("#ADDRESS_TEL").removeClass("telprov");
	$("#ADDRESS_FAX").removeClass("telprov");
	
	if($("#default_prov_id").val() == prov_id){
		$("#ADDRESS_TEL").addClass("telbkk");
		$("#ADDRESS_FAX").addClass("telbkk");
	
		$("#ADDRESS_TEL").mask("9-9999-9999");
		$("#ADDRESS_FAX").mask("9-9999-9999");
	}else{
		$("#ADDRESS_TEL").addClass("telprov");
		$("#ADDRESS_FAX").addClass("telprov");
		
		$("#ADDRESS_TEL").mask("999-999-999");
		$("#ADDRESS_FAX").mask("999-999-999");
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