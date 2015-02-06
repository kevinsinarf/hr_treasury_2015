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
	if($('#ADDRESS_COUNTRY_ID').val()==41){
			$("#city1").hide();
			$('#prov1').show();
		}else{
			$("#city1").show();
			$('#prov1').hide();
		}
		if($('#FAMILY_JOB_ID').val()==999999){
		$('#work').show();
	}else{
		$('#work').hide();
	}
	
});

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(PER_ID){
	$("#proc").val("add");
	$("#PER_ID").val(PER_ID);
	$("#frm-search").attr("action","profile_receive_death_form.php").submit();
}
function GetCity(id){
	if(id==41){
		$("#city1").hide();
		$('#prov1').show();
	}else{
		$("#city1").show();
		$('#prov1').hide();
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
function chkwork(id){
	if(id==999999){
		$('#work').show();
	}else{
		$('#work').hide();
	}
}
function editData(id){
	$("#proc").val("edit");
	$("#FAMILY_ID").val(id);
	$("#frm-search").attr("action","profile_receive_death_form.php").submit();
}
function getRampr(id){	
	$.ajax({
		url: "process/profile_receive_death_proc.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id},
		success : function(data){
			$('#SS_ADDRESS_AMPR_ID').html(data);
			$("#ADDRESS_AMPR_ID").chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
			});
		}
	});
}
function getZipcode(id){
	$.ajax({
		url: "process/profile_receive_death_proc.php",
		dataType: "json",   
		type: "POST",
		data:{proc:"zipcode",zipcond:id},
		success : function(data){
			$("#ADDRESS_POSTCODE").val(data['TAMB_ZIPCODE']);
		}
	});
}
function getStamb(id){	
	$.ajax({
		url: "process/profile_receive_death_proc.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"tamb",v_Stamb:id},
		success : function(data){
			$('#SS_ADDRESS_TAMB_ID').html(data);
			$("#ADDRESS_TAMB_ID").chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
			});
		}
	});
}
function getTelClass(prov_id, key_index){
	$("#S_TEL"+key_index).removeClass("telbkk");
	$("#S_FAX"+key_index).removeClass("telbkk");
	$("#S_TEL"+key_index).removeClass("telprov");
	$("#S_FAX"+key_index).removeClass("telprov");
	
	if($("#default_prov_id").val() == prov_id){
		$("#S_TEL"+key_index).addClass("telbkk");
		$("#S_FAX"+key_index).addClass("telbkk");
		
		$("#S_TEL"+key_index).mask("9-9999-9999");
		$("#S_FAX"+key_index).mask("9-9999-9999");
	}else{
		$("#S_TEL"+key_index).addClass("telprov");
		$("#S_FAX"+key_index).addClass("telprov");
		
		$("#S_TEL"+key_index).mask("999-999-999");
		$("#S_FAX"+key_index).mask("999-999-999");
	}
}
function chkinput(){
	if($("#FAMILY_DATE").val() == ""){
		alert("ระบุ วันที่แจ้ง");
		$("#FAMILY_DATE").focus();
		return false;
	}
	/*if($("#FAMILY_IDCARD1").val() == ""||$("#FAMILY_IDCARD2").val() == ""){
		if($("#FAMILY_IDCARD1").val() == ""){
			alert("ระบุ "+$('#FAMILY_IDCARD1').attr('placeholder'));
			$("#FAMILY_IDCARD1").focus();
			return false;
		}
		if($("#FAMILY_IDCARD2").val() == ""){
			alert("ระบุ "+$('#FAMILY_IDCARD2').attr('placeholder'));
			$("#FAMILY_IDCARD2").focus();
			return false;
		}
	}*/
	if($('#FAMILY_PREFIX_ID').val()==""){
		alert("ระบุ "+$('#FAMILY_PREFIX_ID').attr('placeholder'));
		$("#FAMILY_PREFIX_ID").focus();
		return false;
	}
	if($('#FAMILY_FIRSTNAME_TH').val()==""){
		alert("ระบุ "+$('#FAMILY_FIRSTNAME_TH').attr('placeholder'));
		$("#FAMILY_FIRSTNAME_TH").focus();
		return false;
	}
	if($('#FAMILY_LASTNAME_TH').val()==""){
		alert("ระบุ "+$('#FAMILY_LASTNAME_TH').attr('placeholder'));
		$("#FAMILY_LASTNAME_TH").focus();
		return false;
	}
	/*if($('#FAMILY_FIRSTNAME_EN').val()==""){
		alert("ระบุ "+$('#FAMILY_FIRSTNAME_EN').attr('placeholder'));
		$("#FAMILY_FIRSTNAME_EN").focus();
		return false;
	}
	if($('#FAMILY_LASTNAME_EN').val()==""){
		alert("ระบุ "+$('#FAMILY_LASTNAME_EN').attr('placeholder'));
		$("#FAMILY_LASTNAME_EN").focus();
		return false;
	}
	if($('#FAMILY_STATUS').val()==""){
		alert("ระบุ "+$('#FAMILY_STATUS').attr('placeholder'));
		$("#FAMILY_STATUS").focus();
		return false;
	}*/
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#FAMILY_ID").val(id);
		$("#frm-search").attr("action","process/profile_receive_death_proc.php").submit();
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