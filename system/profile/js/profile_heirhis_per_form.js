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
  if($('input[name=HEIRDESC_IDTYPE]:checked').val() == 1){
	$('#shw_txt_type').html('เลขประจำตัวประชาชน'); 
	$('#HEIRDESC_IDCARD1').show();
	$('#HEIRDESC_IDCARD2').hide();
   }else{
	$('#shw_txt_type').html('เลขที่หนังสือเดินทาง'); 
	$('#HEIRDESC_IDCARD1').hide();
	$('#HEIRDESC_IDCARD2').show();
   }
});

function chkinput(){	
	if($("#PREFIX_ID").val() == ""){
		alert("ระบุ "+$('#PREFIX_ID').attr('placeholder'));
		$("#PREFIX_ID").focus();
		return false;
	}
	if($("#HEIRDESC_FIRSTNAME_TH").val() == ""){
		alert("ระบุ "+$('#HEIRDESC_FIRSTNAME_TH').attr('placeholder'));
		$("#HEIRDESC_FIRSTNAME_TH").focus();
		return false;
	}
	if($("#HEIRDESC_LASTNAME_TH").val() == ""){
		alert("ระบุ "+$('#HEIRDESC_LASTNAME_TH').attr('placeholder'));
		$("#HEIRDESC_LASTNAME_TH").focus();
		return false;
	}
	
	if($("#ADDRESS_HOME_NO").val() == ""){
		alert("ระบุ "+$('#ADDRESS_HOME_NO').attr('placeholder'));
		$("#ADDRESS_HOME_NO").focus();
		return false;
	}
	if($("#ADDRESS_PROV_ID").val() == ""){
		alert("ระบุ "+$('#ADDRESS_PROV_ID').attr('placeholder'));
		$("#ADDRESS_PROV_ID").focus();
		return false;
	}
	if($("#ADDRESS_AMPR_ID").val() == ""){
		alert("ระบุ "+$('#ADDRESS_AMPR_ID').attr('placeholder'));
		$("#ADDRESS_AMPR_ID").focus();
		return false;
	}
	if($("#ADDRESS_TAMB_ID").val() == ""){
		alert("ระบุ "+$('#ADDRESS_AMPR_ID').attr('placeholder'));
		$("#ADDRESS_AMPR_ID").focus();
		return false;
	}
	if($("#ADDRESS_ZIPCODE").val() == ""){
		alert("ระบุ "+$('#ADDRESS_ZIPCODE').attr('placeholder'));
		$("#ADDRESS_ZIPCODE").focus();
		return false;
	}
	if($("#ADDRESS_TEL").val() == ""){
		alert("ระบุ "+$('#ADDRESS_TEL').attr('placeholder'));
		$("#ADDRESS_TEL").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function getType(val){
   if(val == 1){
	$('#shw_txt_type').html('เลขประจำตัวประชาชน'); 
	$('#HEIRDESC_IDCARD1').show();
	$('#HEIRDESC_IDCARD2').hide();
   }else{
	$('#shw_txt_type').html('เลขที่หนังสือเดินทาง'); 
	$('#HEIRDESC_IDCARD1').hide();
	$('#HEIRDESC_IDCARD2').show();
   } 
}

function getRampr(obj){	
	
	var id = $(obj).attr('id');
	var val = $(obj).val();
	var html = "<option value=''></option>";
	$.post('process/profile_heirhis_process.php',{'proc': 'getApmr','prov_id':val},function(data){
		$.each(data,function(index, val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
		});
		
		$('#ADDRESS_AMPR_ID').html(html);
		$('#ADDRESS_AMPR_ID').trigger('liszt:updated');
	},'json');
	
}

function getStamb(obj){
	var id = $(obj).attr('id');
	var val = $(obj).val();
	var html = "<option value=''></option>";
	$.post('process/profile_heirhis_process.php',{'proc': 'getTamb','ampr_id':val},function(data){
		$.each(data,function(index, val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
		});
		
		$('#ADDRESS_TAMB_ID').html(html);
		$('#ADDRESS_TAMB_ID').trigger('liszt:updated');
	},'json');
	
}
function getZipcode(obj){
	var id = $(obj).attr('id');
	var val = $(obj).val();
	var html = "<option value=''></option>";
	$.post('process/profile_heirhis_process.php',{'proc': 'getZipcode','tamb_id':val},function(data){
		$('#ADDRESS_ZIPCODE').val(data['VALUE']);
	},'json');
	
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