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

function getTable_URL(TABLE_ID){
	$.ajax({
		url: "process/profile_approvehis_list_process.php",
		dataType: "html",
		type: "POST",
		data: {proc:'getTablename',TABLE_ID:TABLE_ID},
		success: function(data_url){
			$("#frm-input").attr("action",data_url).submit();
		}
	});
}

function chkinput(){
	if($("#REQUEST_DATETIME").val() == ""){
		alert("ระบุ วันที่ขอเปลี่ยนแปลง");
		$("#REQUEST_DATETIME").focus();
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
	
	if($("#FAMILY_FIRSTNAME_EN").val() == ""){
		alert("ระบุ "+$('#FAMILY_FIRSTNAME_EN').attr('placeholder'));
		$("#FAMILY_FIRSTNAME_EN").focus();
		return false;
	}
	
	if($("#FAMILY_LASTNAME_EN").val() == ""){
		alert("ระบุ "+$('#FAMILY_LASTNAME_EN').attr('placeholder'));
		$("#FAMILY_LASTNAME_EN").focus();
		return false;
	}
	
	if($('#FAMILY_STATUS').val() == ''){
		alert('ระบุ สถานะการมีชีวิต');
		$('#FAMILY_STATUS').focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function chkApprove(){
	if($('#REQUEST_APP_DATE').val() == ''){
		alert('ระบุ วันที่อนุมัติ');
		$('#REQUEST_APP_DATE').focus();
		return false;
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