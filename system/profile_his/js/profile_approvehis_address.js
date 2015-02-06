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
	$('select[name^=S_COUNTRY]').each(function(){
		var id = this.id.replace("S_COUNTRY","");
		if(this.value == $('#default_country_id').val()){
			$('.country_del1'+id).hide();
			$('.country_del2'+id).show();
		}else{
			$('.country_del1'+id).show();	
			$('.country_del2'+id).hide();
		}									  
	});
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
	var chk_val = true;
	
	if($("#REQUEST_DATETIME").val() == ""){
		alert("ระบุ วันที่ขอเปลี่ยนแปลง");
		$("#REQUEST_DATETIME").focus();
		return false;
	}
	
/*	$("input[name*='checkbox']:visible").each(function(index, element) {
		var ind = this.value;
    	if($("#S_COUNTRY"+ind).val() == ""){
			alert("ระบุ "+$('#S_COUNTRY'+ind).attr('placeholder')+" ของ "+$('#address'+ind).html());
			$("#S_COUNTRY"+ind).focus();
			chk_val = false;
			return false;
		}
		if($("#S_COUNTRY"+ind).val() == $('#default_country_id').val()){
			if($("#s_prov"+ind).val() == ""){
				alert("ระบุ "+$('#s_prov'+ind).attr('placeholder')+" ของ "+$('#address'+ind).html());
				$("#s_prov"+ind).focus();
				chk_val = false;
				return false;
			}
			if($("#s_ampr"+ind).val() == ""){
				alert("ระบุ "+$('#s_ampr'+ind).attr('placeholder')+" ของ "+$('#address'+ind).html());
				$("#s_ampr"+ind).focus();
				chk_val = false;
				return false;
			}		 
			if($("#s_tamb"+ind).val() == ""){
				alert("ระบุ "+$('#s_tamb'+ind).attr('placeholder')+" ของ "+$('#address'+ind).html());
				$("#s_tamb"+ind).focus();
				chk_val = false;
				return false;	 
			}
		}else if($.trim($("#S_OTHER_COUNTRY"+ind).val()) == ""){
			alert("ระบุ "+$('#S_OTHER_COUNTRY'+ind).attr('placeholder')+" ของ "+$('#address'+ind).html());
			$("#S_OTHER_COUNTRY"+ind).focus();
			chk_val = false;
			return false;
		}
    });
	if(chk_val == false){
		return false;
	}*/
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("input[name*='checkbox']:hidden").prop('checked',false);
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
		$('#S_FAX'+id).val($('#S_FAX'+val).val());
		$('#S_MOBILE'+id).val($('#S_MOBILE'+val).val());
		$('#S_EMAIL'+id).val($('#S_EMAIL'+val).val());
	}
	//S_COUNTRY
	$('#S_COUNTRY'+id).val($('#S_COUNTRY'+val).val());
		$('#S_COUNTRY'+id).change().trigger("liszt:updated");
	//s_prov
	$('#s_prov'+id).val($('#s_prov'+val).val());
		$('#s_prov'+id).change().trigger("liszt:updated");
	//s_ampr
	$('#s_ampr'+id).val($('#s_ampr'+val).val());	
		$('#s_ampr'+id).change().trigger("liszt:updated");
	//s_ampr
	$('#s_tamb'+id).val($('#s_tamb'+val).val());	
		$('#s_tamb'+id).change().trigger("liszt:updated");	
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
	var z=id.id.substr(6);
	var val;
	if($('#ADDR_TYPE'+z).val()!=''){
		val=$('#s_ampr'+$('#ADDR_TYPE'+z).val()).val();	
	}else{
		val="";
	}
	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,name_tamb:'s_tamb'+z,oncharng:oncharng,val:val},
		success : function(data){
			
			$('#ss_ampr'+z).html(data);
			$("#s_ampr"+z).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			getStamb('s_ampr'+z,$('#s_ampr'+z).val(),'s_tamb'+z);
		}
	});
}

function getStamb(id,val_ampr,name_tamb){
	var z=id.substr(6);
	var val;
	if($('#ADDR_TYPE'+z).val()!=''){
		val=$('#s_tamb'+$('#ADDR_TYPE'+z).val()).val();	
	}else{
		val="";
	}
	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"stamb",v_tamb:val_ampr,z_id:name_tamb,z_name:name_tamb,val:val,zip_id:'PADD_ZIPCODE'+z},
		success : function(data){
			$('#ss_tamb'+z).html(data);
			$("#s_tamb"+z).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
		}
	});		
}

function getcountry(val,num_id){
	if(val==$('#default_country_id').val()){
		$('.country_del1'+num_id).hide();
		$('.country_del2'+num_id).show();
	}else{
		$('.country_del2'+num_id).hide();
		$('.country_del1'+num_id).show();
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

function getZip(id, name_zip, zip_id) {
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",
		type: "POST",
		data: {proc: "zipcode", v_zip: name_zip, zip_id:zip_id},
		success: function(data) {
			$('#aa').html(data);
		  $('#'+zip_id).val(data);
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