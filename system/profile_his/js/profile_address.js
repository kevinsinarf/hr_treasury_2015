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
	if($('#S_COUNTRY').val() == $('#default_country_id').val()){
		$('.chk_country').show();
		$('.chk_city').hide();
	}else{
		$('.chk_country').hide();
		$('.chk_city').show();
	}
});

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_address_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PADD_ID").val(id);
	$("#frm-search").attr("action","profile_address_form.php").submit();
}

function chkinput(){
	if($('#PADD_DATE').val() == ''){
		alert('ระบุ วันที่แจ้ง');
		$('#PADD_DATE').focus();
		return false;
	}
	
	if($("#PADD_TYPE").val() == ""){
		alert("ระบุ ประเภทที่อยู่");
		$("#PADD_TYPE").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function getAddr(id,val){
	if(id!='3'){
		$('#S_HOMENO'+id).val($('#S_HOMENO'+val).val());
		$('#S_MOO'+id).val($('#S_MOO'+val).val());
		$('#S_VILLAGE'+id).val($('#S_VILLAGE'+val).val());
		$('#S_BUILDING'+id).val($('#S_BUILDING'+val).val());
		$('#S_ROOM'+id).val($('#S_ROOM'+val).val());
		$('#S_SOI'+id).val($('#S_SOI'+val).val());
		$('#S_ROAD'+id).val($('#S_ROAD'+val).val());
		$('#S_ZIPCODE'+id).val($('#S_ZIPCODE'+val).val());
		$('#S_TEL'+id).val($('#S_TEL'+val).val());
		$('#S_TEL_EXT'+id).val($('#S_TEL_EXT'+val).val());
		$('#S_FAX'+id).val($('#S_FAX'+val).val());
		$('#S_MOBILE'+id).val($('#S_MOBILE'+val).val());
		$('#S_EMAIL'+id).val($('#S_EMAIL'+val).val());
	}
	//S_COUNTRY
	if(val == ""){
		$('#S_COUNTRY'+id).val($("#default_country_id").val());
	}else{
		$('#S_COUNTRY'+id).val($('#S_COUNTRY'+val).val());
	}
	$('#S_COUNTRY'+id).change().trigger("liszt:updated");
	//s_prov
	if(val == ""){
		$('#s_prov'+id).val($("#default_prov_id").val());
	}else{
		$('#s_prov'+id).val($('#s_prov'+val).val());
	}
	$('#s_prov'+id).change().trigger("liszt:updated");
}

function viewHis(PADD_TYPE){
	$("#proc").val("view");
	$("#PADD_TYPE").val(PADD_TYPE);
	$("#frm-search").attr("action","profile_address_view.php").submit();
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#SSA_ID").val(id);
		$("#frm-search").attr("action","process/ss_address_process.php").submit();
	}
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

function getRampr(id,name_rampr,oncharng){	
	var key_index=id.id.replace(/\D/g,'');
	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,oncharng:oncharng, key_index:key_index},
		success : function(data){
			$('#ss_ampr'+key_index).html(data);
			$("#s_ampr"+key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			$('#ss_tamb'+key_index).html('<select id="s_tamb'+key_index+'" name="s_tamb'+key_index+'" class="selectbox form-control"><option value="0">--ไม่พบข้อมูล--</option></select>');	
			$("#s_tamb"+key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			
			if($("#ADDR_TYPE"+key_index).val() != ""){
				$('#s_ampr'+key_index).val($('#s_ampr'+$("#ADDR_TYPE"+key_index).val()).val());	
				$('#s_ampr'+key_index).change().trigger("liszt:updated");
			}
		}
	});
}

function getStamb(id,val_ampr,name_tamb){
	var key_index=id.replace(/\D/g,'');
	var val;
	if($('#ADDR_TYPE'+key_index).val()!=''){
		val=$('#s_tamb'+$('#ADDR_TYPE'+key_index).val()).val();	
	}else{
		val="";
	}
	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"stamb",v_tamb:val_ampr,z_id:name_tamb,z_name:name_tamb,val:val, zip_id:'PADD_POSTCODE'+key_index},
		success : function(data){
			$('#ss_tamb'+key_index).html(data);
			$("#s_tamb"+key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			
			if($("#ADDR_TYPE"+key_index).val() != ""){
				$('#s_tamb'+key_index).val($('#s_tamb'+$("#ADDR_TYPE"+key_index).val()).val());	
				$('#s_tamb'+key_index).change().trigger("liszt:updated");	
			}
		}
	});		
}

function getZip(id, name_zip, zip_id) {
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",
		type: "POST",
		data: {proc: "zipcode", v_zip: name_zip},
		success: function(data) {
			$('#aa').html(data);
		  $('#'+zip_id).val(data);
		}
	});
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

function getStatus(id){
	if(id=='1'){
		$('#del_Status').hide()
	}else{
		$('#del_Status').show()
	}
}

function getPublic(){ 
	$(':checkbox').on('change',function(){
		var th = $(this), name = th.prop('name'); 
		if(th.is(':checked')){
			$(':checkbox[name="'+name+'"]').not($(this)).prop('checked',false);   
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