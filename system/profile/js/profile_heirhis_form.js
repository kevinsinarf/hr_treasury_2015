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
	$('#FAMILY_IDCARD1').show();
	$('#FAMILY_IDCARD2').hide();
   }else{
	$('#shw_txt_type').html('เลขที่หนังสือเดินทาง'); 
	$('#FAMILY_IDCARD1').hide();
	$('#FAMILY_IDCARD2').show();
   }
});

function addPerData(){
	var total_per = parseInt($('#HEIR_TOTAL').val());
	var count_per =parseInt($('#count_per').val());
	if(count_per >= total_per){
		alert("ไม่สามารถเพิ่มผู้ถูกแสดงเจตนาเกินจำนวนบุคคลที่ระบุไว้");
		$("#HEIR_TOTAL").focus();
		return false;
	}
	$("#proc").val("add_per");
	$("#frm-input").attr("action","profile_heirhis_per_form.php").submit();
}

function editDataPer(id){
	$("#proc").val("edit_per");
	$('#HEIRDESC_ID').val(id);
	$("#frm-input").attr("action","profile_heirhis_per_form.php").submit();
}

function delDataPer(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete_per");
		$("#HEIRDESC_ID").val(id);
		$("#frm-input").attr("action","process/profile_heirhis_process.php").submit();
	}
}

function chkinput(){	

	if($("#HEIR_SDATE").val() == ""){
		alert("ระบุ เมื่อวันที่");
		$("#HEIR_SDATE").focus();
		return false;
	}
	if($("#HEIR_TYPE_SALARY").val() == ""){
		alert("ระบุ "+$('#HEIR_TYPE_SALARY').attr('placeholder'));
		$("#HEIR_TYPE_SALARY").focus();
		return false;
	}
	if($("#HEIR_TOTAL").val() == ""){
		alert("ระบุ "+$('#HEIR_TOTAL').attr('placeholder'));
		$("#HEIR_TOTAL").focus();
		return false;
	}			
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#proc').val('edit_head');
		$("#frm-input").submit();
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
function search_parent(){
	if($("#HEIR_IDCARD").val() == ''){
		$('#btn_save').hide();
		$('#show_parent_data').hide();
		$('#PK_ID').val('');
		alert("ระบุ "+$("#HEIR_IDCARD").attr('placeholder'));
		$("#HEIR_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#HEIR_IDCARD').val())){ 
			$('#btn_save').hide();
			$('#show_parent_data').hide();
			$('#PK_ID').val('');
			alert($("#HEIR_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#HEIR_IDCARD").focus();
			return false;
		}
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