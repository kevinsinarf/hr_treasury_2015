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
	
	if($('#PENSION_TYPE_RESIGN').val() == ''){
	   $('#PENSION_TYPE_RESIGN option[value=2]').prop('selected',true);
	   $('#PENSION_TYPE_RESIGN').trigger('liszt:updated');
	   GetPension();
	}
	
	if($('#PENSION_TYPE_PENSION').val() == ''){
	   $('#PENSION_TYPE_PENSION option[value=2]').prop('selected',true);
	   $('#PENSION_TYPE_PENSION').trigger('liszt:updated');
	}
	if($('#PENSION_TYPE_RECEIVER').val() == ''){
	   $('#PENSION_TYPE_RECEIVER option[value=1]').prop('selected',true);
	   $('#PENSION_TYPE_RECEIVER').trigger('liszt:updated');
	}
	if($('#ADDRESS_COUNTRY_ID').val() == ''){
		$('#ADDRESS_COUNTRY_ID option[value=41]').prop('selected',true);
	    $('#ADDRESS_COUNTRY_ID').trigger('liszt:updated');
	}
	if($('#PENSION_TYPE_RECEIVE').val() == ''){
		$('#PENSION_TYPE_RECEIVE option[value=1]').prop('selected',true);
	    $('#PENSION_TYPE_RECEIVE').trigger('liszt:updated');
	}
	if($('#div_8 input:checkbox[name^=FAMILY_ID_8]').length > 0){
		var arr_name_8 = '';
		var id_main_8 = '';
		var id_run_8 = '';
		$.each($('#div_8 input:checkbox[name^=FAMILY_ID_8]'),function(index,val){
			arr_name_8 = $(this).attr('id').split('_');
			id_main_8 = arr_name_8[2];
			id_run_8 = arr_name_8[3];
			
			if($('#PENHEIR_CONTACT_FAMILY_SATUS_8_'+id_run_8).val() == ''){
			  $('#PENHEIR_CONTACT_FAMILY_SATUS_8_'+id_run_8+' option[value=1]').prop('selected',true);
	  		  $('#PENHEIR_CONTACT_FAMILY_SATUS_8_'+id_run_8).trigger('liszt:updated');
			  ChkTypePer($('#PENHEIR_CONTACT_FAMILY_SATUS_8_'+id_run_8));
			}
		});
	}
	if($('#div_9 input:checkbox[name^=HEIRDESC_ID_9]').length > 0){
		var arr_name_9 = '';
		var id_main_9 = '';
		var id_run_9 = '';
		$.each($('#div_9 input:checkbox[name^=HEIRDESC_ID_9]'),function(index,val){
			arr_name_9 = $(this).attr('id').split('_');
			id_main_9 = arr_name_9[2];
			id_run_9 = arr_name_9[3];
			
			if($('#PENHEIR_CONTACT_FRAMILY_STATUS_9_'+id_run_9).val() == ''){
			  $('#PENHEIR_CONTACT_FRAMILY_STATUS_9_'+id_run_9+' option[value=1]').prop('selected',true);
	  		  $('#PENHEIR_CONTACT_FRAMILY_STATUS_9_'+id_run_9).trigger('liszt:updated');
			  ChkTypePer($('#PENHEIR_CONTACT_FRAMILY_STATUS_9_'+id_run_9));
			}
		});
	}
	
	if($('#PENSION_TYPE_PENSION').val() != ''){
		GetReceiver();
	}
	if($('#PENSION_TYPE_PENSION').val() != '' && $('#PENSION_TYPE_RESIGN').val() != '' ){
		GetContent();
	}
	if($('#PENSION_TYPE_PENSION').val() != '' && $('#PENSION_TYPE_RECEIVER').val() != ''){
		GetReceiverDetail();
	}
	if($('#PENSION_TYPE_RECEIVE').val() != '' && $('#PENSION_TYPE_PENSION').val() != ''){
		GetReceiveType();
	}
	if($('#ADDRESS_COUNTRY_ID').val() != ''){
		GetCountry();
	}
	
});

function  GetPer(){
	$('#frm-input').submit();
} 
function GetPension(){
	
	var html = "<option value = ''></option>" ;
	var PENSION_TYPE_RESIGN = parseInt($('#PENSION_TYPE_RESIGN').val());
	
	if(PENSION_TYPE_RESIGN == 6){
		html += "<option value = '3'>บำเหน็จตกทอด</option>";
	}else{
		html += "<option value = '1'>บำเหน็จ</option>";
		html += "<option value = '2'>บำเหน็จรายเดือน</option>";
		html += "<option value = '3'>บำเหน็จตกทอด</option>"
	}
	$('#PENSION_TYPE_PENSION').html(html);
	$('#PENSION_TYPE_PENSION').trigger('liszt:updated');
	$('#PENSION_TYPE_PENSION').chosen({	allow_single_deselect:true });
}

function GetReceiver(){
	var PENSION_TYPE_PENSION = $('#PENSION_TYPE_PENSION').val();
	if(PENSION_TYPE_PENSION == 3){
		$('#PENSION_TYPE_RECEIVER').prop('disabled',false);
		$('#TYPE_RECEIVER').show();
		$('#PENSION_TYPE_RECEIVER').trigger('liszt:updated');
	}else{
		$('#PENSION_TYPE_RECEIVER').prop('disabled',true);
		$('#TYPE_RECEIVER').hide();
		$('#PENSION_TYPE_RECEIVER').trigger('liszt:updated');
	}
}
function GetReceiverDetail(){
	var PENSION_TYPE_PENSION = $('#PENSION_TYPE_PENSION').val();
	var PENSION_TYPE_RECEIVER = $('#PENSION_TYPE_RECEIVER').val();
	if(PENSION_TYPE_PENSION == 3){
		if(PENSION_TYPE_RECEIVER == 1){
		  $('#div_8').show();
		  $('#div_9').hide();
		  $('#div_8 select').prop('disabled',false);
		  $('#div_8 select').trigger('liszt:updated');
		  $('#div_9 select').prop('disabled',true);
		  $('#div_9 select').trigger('liszt:updated');
		  $('#div_8 input').prop('disabled',false);
		  $('#div_9 input').prop('disabled',true);
	}else{
		$('#div_8').hide();
		$('#div_9').show();
		$('#div_8 select').prop('disabled',true);
		$('#div_8 select').trigger('liszt:updated');
		$('#div_9 select').prop('disabled',false);
		$('#div_9 select').trigger('liszt:updated');
		$('#div_8 input').prop('disabled',true);
		$('#div_9 input').prop('disabled',false);
	}
  }else{
	  $('#div_8').hide();
	  $('#div_9').hide();
	  $('#div_8 select').prop('disabled',true);
	  $('#div_8 select').trigger('liszt:updated');
	  $('#div_9 select').prop('disabled',true);
	  $('#div_9 select').trigger('liszt:updated');
	  $('#div_8 input').prop('disabled',true);
	  $('#div_9 input').prop('disabled',true);

  }
}
function GetContent(){
	var PENSION_TYPE_PENSION = $('#PENSION_TYPE_PENSION').val();
	var PENSION_TYPE_RESIGN = parseInt($('#PENSION_TYPE_RESIGN').val());
	var LEGENCY_ALL = 0;
	var BONUSTIME_ALL = 0;
	GetReceiverDetail();
	if(PENSION_TYPE_PENSION == 1){
		$('#div_1').show();
		$('#div_4').hide();
		
		$('#div_1 input').prop('disabled',false);
		$('#div_4 input').prop('disabled',true);
		
	}else if(PENSION_TYPE_PENSION == 2){
		$('#div_1').hide();
		$('#div_4').show();
		
		$('#div_1 input').prop('disabled',true);
		$('#div_4 input').prop('disabled',false);
    }else if(PENSION_TYPE_PENSION == 3){
		$('#div_1').hide();
		$('#div_4').show();
		
		$('#div_1 input').prop('disabled',true);
		$('#div_4 input').prop('disabled',false);
	}
  
	if(PENSION_TYPE_PENSION == 3){
		$('#div_10').show();
		$('#div_11').show();
		$('#div_10 select').prop('disabled',false);
		$('#div_10 select').trigger('liszt:updated');
		$('#div_11 select').prop('disabled',false);
		$('#div_11 select').trigger('liszt:updated');
		$('#div_10 input').prop('disabled',false);
		$('#div_11 input').prop('disabled',false);
		
		
	}else{
		$('#div_10').hide();
		$('#div_11').hide();
		
		$('#div_10 select').prop('disabled',true);
		$('#div_10 select').trigger('liszt:updated');
		$('#div_11 select').prop('disabled',true);
		$('#div_11 select').trigger('liszt:updated');
		$('#div_10 input').prop('disabled',true);
		$('#div_11 input').prop('disabled',true);
	}
	
	 
}

function GetReceiveType(){
	var PENSION_TYPE_RECEIVE = parseInt($('#PENSION_TYPE_RECEIVE').val());
	var PENSION_TYPE_PENSION = $('#PENSION_TYPE_PENSION').val();
	
	if(PENSION_TYPE_RECEIVE == 1){
		$('#type_1').hide();
		$('#type_2').hide();
		$('#type_3').hide();
		$('#type_1 select').prop('disabled',true);
		$('#type_1 select').trigger('liszt:updated');
		$('#type_2 select').prop('disabled',true);
		$('#type_2 input').prop('disabled',true);
		$('#type_2 select').trigger('liszt:updated');
		$('#type_3 select').prop('disabled',true);
		$('#type_3 input').prop('disabled',true);
		$('#type_3 select').trigger('liszt:updated');
		
		
	}else if(PENSION_TYPE_RECEIVE == 2){
		$('#type_1').show();
		$('#type_2').show();
		$('#type_3').hide();
		$('#type_1 select').prop('disabled',false);
		$('#type_1 select').trigger('liszt:updated');
		$('#type_2 select').prop('disabled',false);
		$('#type_2 input').prop('disabled',false);
		$('#type_2 select').trigger('liszt:updated');
		$('#type_3 select').prop('disabled',true);
		$('#type_3 input').prop('disabled',true);
		$('#type_3 select').trigger('liszt:updated');
	}else if(PENSION_TYPE_RECEIVE == 3){
		$('#type_1').hide()
		$('#type_2').hide();
		$('#type_3').show();
		$('#type_1 select').prop('disabled',true);
		$('#type_1 select').trigger('liszt:updated');
		$('#type_2 select').prop('disabled',true);
		$('#type_2 input').prop('disabled',true);
		$('#type_2 select').trigger('liszt:updated');
		$('#type_3 select').prop('disabled',false);
		$('#type_3 input').prop('disabled',false);
		$('#type_3 select').trigger('liszt:updated');
		
	}
	
	if(PENSION_TYPE_RECEIVE == 1){
		$('#div_6').hide();
		$('#div_6 select').prop('disabled',true);
		$('#div_6 select').trigger('liszt:updated');
		$('#div_6 input').prop('disabled',true);
		
	}else{
		$('#div_6').show();
		$('#div_6 select').prop('disabled',false);
		$('#div_6 select').trigger('liszt:updated');
		$('#div_6 input').prop('disabled',false);
	}
	
	
}
function GetCountry(){
	var ADDRESS_COUNTRY_ID = $('#ADDRESS_COUNTRY_ID').val();
	if(ADDRESS_COUNTRY_ID == 41){
		$('#address_group_2').show();
		$('#address_group_1').hide();
		$('#address_group_2 input').prop('disabled',false);
		$('#address_group_2 select').prop('disabled',false);
		$('#address_group_1 input').prop('disabled',true);
		$('#address_group_2 select').trigger('liszt:updated');
		
	}else{
		$('#address_group_1').show();
		$('#address_group_2').hide();
		$('#address_group_1 input').prop('disabled',false);
		$('#address_group_2 input').prop('disabled',true);
		$('#address_group_2 select').prop('disabled',true);
		$('#address_group_2 select').trigger('liszt:updated');
	}
}

function ChkTypePer(obj){
	var arr_name  = $(obj).attr('id').split('_');
	var val = $(obj).val();
	var id_main = arr_name[4];
	var id_run = arr_name[5];
	if(id_main == 8 ){
		if(val == 1){
		    $('#family_type_'+id_run).hide();
			$('#family_type_'+id_run+' select').prop('disabled',true);
			$('#family_type_'+id_run+' select').trigger('liszt:updated');
			$('#family_type_'+id_run+' input').prop('disabled',true);
		}else{
			$('#family_type_'+id_run).show();
			$('#family_type_'+id_run+' select').prop('disabled',false);
			$('#family_type_'+id_run+' select').trigger('liszt:updated');
			$('#family_type_'+id_run+' input').prop('disabled',false);
		}
	}
	if(id_main == 9 ){
		if(val == 1){
			$('#heir_type_'+id_run).hide();
			$('#heir_type_'+id_run+' select').prop('disabled',true);
			$('#heir_type_'+id_run+' select').trigger('liszt:updated');
			$('#heir_type_'+id_run+' input').prop('disabled',true);
		}else{
			$('#heir_type_'+id_run).show();
			$('#heir_type_'+id_run+' select').prop('disabled',false);
			$('#heir_type_'+id_run+' select').trigger('liszt:updated');
			$('#heir_type_'+id_run+' input').prop('disabled',false);
		}
	}
}

function ChkAll(num){
	var id = "chk_all_"+num;
	if($("#"+id).prop('checked')){
		$("#div_"+num+" input:checkbox").prop('checked',true);
	}else{
		$("#div_"+num+" input:checkbox").prop('checked',false);
	}
}

function chkinput(){	
    
	if($('#PENSION_TIME').val() == ''){
		alert('กรุณาระบุ ครั้งที่เสนอขอรับ');
		$('#PENSION_TIME').focus();
		return false;
	}
	if($('#PENSION_DATE').val() == ''){
		alert('กรุณาเลือก วันที่เสนอเรื่อง');
		$('#PENSION_DATE').focus();
		return false;
	}
	if($('#PENSION_TYPE_RESIGN').val() == ''){
		alert('กรุณาเลือก สาเหตุที่ออกจากราชการ');
		$('#PENSION_TYPE_RESIGN').focus();
		return false;
	}
	if($('#PENSION_TYPE_PENSION').val() == ''){
		alert('กรุณาเลือก ประเภทการขอรับ');
		$('#PENSION_TYPE_PENSION').focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#frm-input').attr('action', 'process/pension_record_emp_process.php');
		$("#frm-input").submit();
	}
}

function getRampr(obj){	
	var PROV_ID = $(obj).val();
	var html = "<option value=''></option>";
	$.ajax({
		url: "process/pension_record_emp_process.php",
		dataType: "json",   
		type: "POST",
		data:{proc:"GetRampr",'PROV_ID':PROV_ID},
		success : function(data){
			$.each(data,function(index, val){
				html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
			});
			$('#ADDRESS_AMPR_ID').html(html);
			$('#ADDRESS_AMPR_ID').trigger('liszt:updated');
			
		}
	});
}

function getStamb(obj){
	var AMPR_ID = $(obj).val(); 
	var html = "<option value=''></option>";
	$.ajax({
		url: "process/pension_record_emp_process.php",
		dataType: "json",   
		type: "POST",
		data:{proc:"GetStamb",'AMPR_ID':AMPR_ID},
		success : function(data){
			$.each(data,function(index, val){
				html +=  "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>"; 
			});
			$('#ADDRESS_TAMB_ID').html(html);
			$('#ADDRESS_TAMB_ID').trigger('liszt:updated');
			$('#ADDRESS_TAMB_ID').chosen({	allow_single_deselect:true });
		}
	});		
}
function getZipcode(obj){
	var TAMB_ID = $(obj).val();
	$.post('process/pension_record_emp_process.php',{proc:'getZipcode','TAMB_ID':TAMB_ID},function(data){
		$('#ADDRESS_ZIPCODE').val(data);
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