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

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_educatehis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#EDU_ID").val(id);
	$("#frm-search").attr("action","profile_educatehis_form.php").submit();
}

function chkinput(){
	if($("#EL_ID").val() == ""){
		alert("ระบุ "+$('#EL_ID').attr('placeholder'));
		$("#EL_ID").focus();
		return false;
	}
	if($("#ED_ID").val() == ""){
		alert("ระบุ "+$('#ED_ID').attr('placeholder'));
		$("#ED_ID").focus();
		return false;
	}
	if($("#EM_ID").val() == ""){
		alert("ระบุ "+$('#EM_ID').attr('placeholder'));
		$("#EM_ID").focus();
		return false;
	}	
	if($("#INS_ID").val() == ""){
		alert("ระบุ "+$('#INS_ID').attr('placeholder'));
		$("#INS_ID").focus();
		return false;
	}
	if($("#COUNTRY_ID").val() == ""){
		alert("ระบุ "+$('#COUNTRY_ID').attr('placeholder'));
		$("#COUNTRY_ID").focus();
		return false;
	}
	if($("#EDU_GPA").val() == ""){
		alert("ระบุ "+$('#EDU_GPA').attr('placeholder'));
		$("#EDU_GPA").focus();
		return false;
	}
	if($("#EDU_HORNOR").val() == ""){
		alert("ระบุ "+$('#EDU_HORNOR').attr('placeholder'));
		$("#EDU_HORNOR").focus();
		return false;
	}
	if($("#EDU_SDATE").val() == ""){
		alert("ระบุ วันที่เริ่มศึกษา");
		$("#EDU_SDATE").focus();
		return false;
	}
	if($("#EDU_EDATE").val() == ""){
		alert("ระบุ วันที่สำเร็จการศึกษา");
		$("#JOB_ID").focus();
		return false;
	}
	if(chk_date($.trim($("#EDU_SDATE").val()),$.trim($("#EDU_EDATE").val()),'วันที่เริ่มศึกษา','วันที่สำเร็จการศึกษา')){
		return false;	
	}
	if($("#EDU_SCHOLARSHIP").val() == ""){
		alert("ระบุ "+$('#EDU_SCHOLARSHIP').attr('placeholder'));
		$("#EDU_SCHOLARSHIP").focus();
		return false;
	}
	if($("#EDU_TYPE").val() == ""){
		alert("ระบุ "+$('#EDU_TYPE').attr('placeholder'));
		$("#EDU_TYPE").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#EDU_ID").val(id);
		$("#frm-search").attr("action","process/profile_educatehis_process.php").submit();
	}
}

function get_edu(EL_ID){
	var url ='process/select_selationship.php'	
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'edu_degree',EL_ID:EL_ID,z_id:'ED_ID',z_name:'ED_ID',z_class:'form-control'},
		async: false,
		success: function(data) {
			$('#ss_edu_degree').html(data);
			$('#ED_ID').chosen({
				allow_single_deselect: true
			});
		} 
	});
}

function chk_date(startdate,enddate,startdate_text,enddate_text){
	var chk_sdate=startdate.replace(/0/gi,"").replace(/\//gi,"");
	var chk_edate=enddate.replace(/0/gi,"").replace(/\//gi,"");
	var date1 = startdate;  // '24/11/2010'
	var date2 = enddate; 
	var thisdate=new Date();
	date1 = date1.split("/"); 
	date2 = date2.split("/"); 
	startdate_text = startdate_text==""?"วันที่เริ่มต้น":startdate_text;
	enddate_text = enddate_text==""?"วันที่สิ้นสุด":enddate_text;
	
	if(chk_sdate ==""){
		return false;
	}else{
		sDate = new Date(date1[2]-543,date1[1]-1,date1[0]);  
	}
	
	if(chk_edate ==""){
		return false;
	}else{
		eDate = new Date(date2[2]-543,date2[1]-1,date2[0]);  
	}
	
	if(eDate < sDate){
		alert(enddate_text+" ต้องอยู่หลัง "+startdate_text);	
		return true;
	}else{
		return false;
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