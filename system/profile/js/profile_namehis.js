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
	// ---------------- รายละเอียดการเปลี่ยนแปลง -------------------//
	if($('#NAMEHIS_DETAIL_1').is(':checked') == true){
		$('#shw_prefix').show();	
	}else{
		$('#shw_prefix').hide();	
	}
	
	if($('#NAMEHIS_DETAIL_2').is(':checked') == true){
		$('#shw_fname').show();	
	}else{
		$('#shw_fname').hide();	
	}
	
	if($('#NAMEHIS_DETAIL_3').is(':checked') == true){
		$('#shw_mname').show();	
	}else{
		$('#shw_mname').hide();	
	}
	
	if($('#NAMEHIS_DETAIL_4').is(':checked') == true){
		$('#shw_lname').show();	
	}else{
		$('#shw_lname').hide();	
	}
	
	// ---------------- สาเหตุการเปลี่ยนแปลง -------------------//
	if($('#NAMEHIS_BECAUSE_1').is(':checked') == true){
		$('#shw_ref_1').show();	
	}else{
		$('#shw_ref_1').hide();	
	}
	
	if($('#NAMEHIS_BECAUSE_2').is(':checked') == true){
		$('#shw_ref_2').show();	
	}else{
		$('#shw_ref_2').hide();	
	}

	if($('#NAMEHIS_BECAUSE_3').is(':checked') == true){
		$('#shw_ref_3').show();	
	}else{
		$('#shw_ref_3').hide();	
	}

	if($('#NAMEHIS_BECAUSE_4').is(':checked') == true){
		$('#shw_ref_4').show();	
	}else{
		$('#shw_ref_4').hide();	
	}

	if($('#NAMEHIS_BECAUSE_5').is(':checked') == true){
		$('#shw_ref_5').show();	
	}else{
		$('#shw_ref_5').hide();	
	}

	if($('#NAMEHIS_BECAUSE_6').is(':checked') == true){
		$('#shw_ref_6').show();	
	}else{
		$('#shw_ref_6').hide();	
	}

	if($('#NAMEHIS_BECAUSE_7').is(':checked') == true){
		$('#shw_ref_7').show();	
	}else{
		$('#shw_ref_7').hide();	
	}

	if($('#NAMEHIS_BECAUSE_8').is(':checked') == true){
		$('#shw_ref_8').show();	
	}else{
		$('#shw_ref_8').hide();	
	}

	if($('#NAMEHIS_BECAUSE_9').is(':checked') == true){
		$('#shw_ref_9').show();	
	}else{
		$('#shw_ref_9').hide();	
	}
	
	if($('#NAMEHIS_BECAUSE_10').is(':checked') == true){
		$('#shw_other').show();	
	}else{
		$('#shw_other').hide();	
	}
});
		
function getRampr(id,name_rampr,oncharng){	
	var key_index = id.id.replace("PROV_ID_",''); 
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:'AMRP_ID_'+key_index,z_name:name_rampr,oncharng:oncharng, key_index:key_index},
		success : function(data){
			$('#ss_ampr_'+key_index).html(data);
			$("#AMRP_ID_"+key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
		}
	});
}

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_namehis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#NAMEHIS_ID").val(id);
	$("#frm-search").attr("action","profile_namehis_form.php").submit();
}

function chkinput(){	
	if($("#NAMEHIS_CHANGEDATE").val() == ""){
		alert("ระบุ วันที่แจ้งเปลี่ยนชื่อ - สกุล");
		$("#NAMEHIS_CHANGEDATE").focus();
		return false;
	}
	
	if($("#NAMEHIS_CHANGEDATE").val() == ""){
		alert("ระบุ วันที่เปลี่ยนชื่อ - สกุล");
		$("#NAMEHIS_CHANGEDATE").focus();
		return false;
	}
	
	if($('input:Checkbox[name^=NAMEHIS_DETAIL]:checked').length==0){
		alert("ระบุ รายละเอียดการเปลี่ยนแปลง");
		$("#NAMEHIS_DETAIL_1").focus();
		return false;
	}
	
	if($("#NAMEHIS_NEW_PREFIX_ID").val() == "" && $('#NAMEHIS_DETAIL_1').is(':checked') == true){
		alert("ระบุ"+$('#NAMEHIS_NEW_PREFIX_ID').attr('placeholder'));
		$("#NAMEHIS_NEW_PREFIX_ID").focus();
		exit(0);
	}
	
	if($("#NAMEHIS_NEW_FIRSTNAME_TH").val() == "" && $('#NAMEHIS_DETAIL_2').is(':checked') == true){
		alert("ระบุ "+$('#NAMEHIS_NEW_FIRSTNAME_TH').attr('placeholder'));
		$("#NAMEHIS_NEW_FIRSTNAME_TH").focus();
		exit(0);
	}
	
	if($("#NAMEHIS_NEW_FIRSTNAME_EN").val() == "" && $('#NAMEHIS_DETAIL_2').is(':checked') == true){
		alert("ระบุ "+$('#NAMEHIS_NEW_FIRSTNAME_EN').attr('placeholder'));
		$("#NAMEHIS_NEW_FIRSTNAME_EN").focus();
		exit(0);
	}
	
	if($("#NAMEHIS_NEW_MIDNAME_TH").val() == "" && $('#NAMEHIS_DETAIL_3').is(':checked') == true){
		alert("ระบุ "+$('#NAMEHIS_NEW_MIDNAME_TH').attr('placeholder'));
		$("#NAMEHIS_NEW_MIDNAME_TH").focus();
		exit(0);
	}
	
	if($("#NAMEHIS_NEW_MIDNAME_EN").val() == "" && $('#NAMEHIS_DETAIL_3').is(':checked') == true){
		alert("ระบุ "+$('#NAMEHIS_NEW_MIDNAME_EN').attr('placeholder'));
		$("#NAMEHIS_NEW_MIDNAME_EN").focus();
		exit(0);
	}
	
	if($("#NAMEHIS_NEW_LASTNAME_TH").val() == "" && $('#NAMEHIS_DETAIL_4').is(':checked') == true){
		alert("ระบุ "+$('#NAMEHIS_NEW_LASTNAME_TH').attr('placeholder'));
		$("#NAMEHIS_NEW_LASTNAME_TH").focus();
		exit(0);
	}
			
	if($("#NAMEHIS_NEW_LASTNAME_EN").val() == "" && $('#NAMEHIS_DETAIL_4').is(':checked') == true){
		alert("ระบุ "+$('#NAMEHIS_NEW_LASTNAME_EN').attr('placeholder'));
		$("#NAMEHIS_NEW_LASTNAME_EN").focus();
		exit(0);
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function chkDetail(span, id){
	if($('#'+id).is(':checked') == true){
		$('#'+span).show();	
	}else{
		$('#'+span).hide();	
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#NAMEHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_namehis_process.php").submit();
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