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
	var JOH_JOB_TYPE = $('#JOH_JOB_TYPE').val();
	if($('#proc').val() == 'edit'){
		GetDetail(JOH_JOB_TYPE);
	}else{
		GetDetail('');
	}
});

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_jobhis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#JOH_ID").val(id);
	$("#frm-search").attr("action","profile_jobhis_form.php").submit();
}

function chkinput(){
	if($('#JOH_SEQ').val()==""){
		alert("ระบุ "+$('#JOH_SEQ').attr('placeholder'));
		$("#JOH_SEQ").focus();
		return false;
	}
	if($('#JOH_JOB_TYPE').val()==""){
		alert("ระบุ "+$('#JOH_JOB_TYPE').attr('placeholder'));
		$("#JOH_JOB_TYPE").focus();
		return false;
	}
	if(chk_date($.trim($("#JOH_SDATE").val()),$.trim($("#JOH_EDATE").val()),'วันที่เริ่มงาน','วันที่สิ้นสุด')){
		return false;	
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#JOH_ID").val(id);
		$("#frm-search").attr("action","process/profile_jobhis_process.php").submit();
	}
}

function GetDetail(id){
	//alert(id);
	if(id == ''){
		$("#gov").hide();
		$("#gov_emp").hide();
		$("#emp").hide();
		$("#other").hide();
		$('#shw_job_other').hide();
		$('#gov_emp input').val('');
		$('#gov_emp select').val('');
		$('#emp input').val('');
		$('#emp select').val('');
		$('#other input').val('');
		$('#other select').val('');
		$('#JOB_EJOB_NAME').val('');
	}else if(id=="1"){
		$("#gov").show();
		$("#gov_emp").hide();
		$("#emp").hide();
		$("#other").hide();
		$('#shw_job_other').hide();
		$('#gov_emp input').val('');
		$('#gov_emp select').val('');
		$('#emp input').val('');
		$('#emp select').val('');
		$('#other input').val('');
		$('#other select').val('');
		$('#JOB_EJOB_NAME').val('');
		
		$('.selectbox').trigger('liszt:updated');
	}else if(id=="2"){
		$("#gov_emp").show();
		$("#gov").hide();		
		$("#emp").hide();
		$("#other").hide();
		$('#shw_job_other').hide();
		
		$('#gov input').val('');
		$('#gov select').val('');
		$('#emp input').val('');
		$('#emp select').val('');
		$('#other input').val('');
		$('#other select').val('');
		$('#JOB_EJOB_NAME').val('');
		$('.selectbox').trigger('liszt:updated');
	}else if(id=="3"){
		$("#emp").show();
		$("#gov").hide();
		$("#gov_emp").hide();
		$("#other").hide();
		$('#shw_job_other').hide();
		
		$('#gov input').val('');
		$('#gov select').val('');
		$('#gov_emp input').val('');
		$('#gov_emp select').val('');
		$('#other input').val('');
		$('#other select').val('');
		$('#JOB_EJOB_NAME').val('');
		$('.selectbox').trigger('liszt:updated');
	}else if(id=="9"){
		$("#gov").hide();
		$("#gov_emp").hide();
		$("#emp").hide();
		$("#other").hide();
		$('#shw_job_other').hide();
		
		$('#gov input').val('');
		$('#gov select').val('');
		$('#gov_emp input').val('');
		$('#gov_emp select').val('');
		$('#other input').val('');
		$('#other select').val('');
		$('#emp input').val('');
		$('#emp select').val('');
		$('#JOB_EJOB_NAME').val('');
		$('.selectbox').trigger('liszt:updated');
		
	}else{
		$("#gov").hide();
		$("#gov_emp").hide();
		$("#emp").hide();
		$("#other").show();
		$('#shw_job_other').hide();
		
		$('#gov input').val('');
		$('#gov select').val('');
		$('#gov_emp input').val('');
		$('#gov_emp select').val('');
		$('#emp input').val('');
		$('#emp select').val('');
		
		$('.selectbox').trigger('liszt:updated');
		
		if(id == '10'){
			$('#shw_job_other').show();
		}else{
			$('#JOB_EJOB_NAME').val('');
		}
		
		
	}
}
function get_gov_org2(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_ORG_ID_2').html(html);
				$('#GOV_ORG_ID_2').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_ORG_ID_2").html('<option value="">เลือก</option>');
	}
}

function get_gov_org3(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_ORG_ID_3').html(html);
				$('#GOV_ORG_ID_3').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_ORG_ID_3").html('<option value="">เลือก</option>');
	}
}

function get_gov_org4(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_ORG_ID_4').html(html);
				$('#GOV_ORG_ID_4').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_ORG_ID_4").html('<option value="">เลือก</option>');
	}
}

function get_gov_org5(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_ORG_ID_5').html(html);
				$('#GOV_ORG_ID_5').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_ORG_ID_5").html('<option value="">เลือก</option>');
	}
}

function get_gov_level(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:1},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_LEVEL_ID').html(html);
				$('#GOV_LEVEL_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_LEVEL_ID").html('<option value="">เลือก</option>');
	}
}

function get_gov_line_group(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_LG_ID').html(html);
				$('#GOV_LG_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_LG_ID").html('<option value="">เลือก</option>');
	}
}

function get_gov_line(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",lg_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_LINE_ID').html(html);
				$('#GOV_LINE_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_LINE_ID").html('<option value="">เลือก</option>');
	}
}

//--------------------- พนักงานราชการ --------------------//
function get_gov_emp_org2(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_EMP_ORG_ID_2').html(html);
				$('#GOV_EMP_ORG_ID_2').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_EMP_ORG_ID_2").html('<option value="">เลือก</option>');
	}
}

function get_gov_emp_org3(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_EMP_ORG_ID_3').html(html);
				$('#GOV_EMP_ORG_ID_3').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_EMP_ORG_ID_3").html('<option value="">เลือก</option>');
	}
}

function get_level_gov_emp(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:3},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_EMP_LEVEL_ID').html(html);
				$('#GOV_EMP_LEVEL_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_EMP_LEVEL_ID").html('<option value="">เลือก</option>');
	}
}

function get_line_gov_emp(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_gov_emp",level_id:e.value,postype_id:3},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#GOV_EMP_LINE_ID').html(html);
				$('#GOV_EMP_LINE_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#GOV_EMP_LINE_ID").html('<option value="">เลือก</option>');
	}
}


//--------------------- ลูกจ้างประจำ --------------------//
function get_emp_org2(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#EMP_ORG_ID_2').html(html);
				$('#EMP_ORG_ID_2').trigger('liszt:updated');
			}
		});
	}else{
		$("#EMP_ORG_ID_2").html('<option value="">เลือก</option>');
	}
}

function get_emp_org3(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#EMP_ORG_ID_3').html(html);
				$('#EMP_ORG_ID_3').trigger('liszt:updated');
			}
		});
	}else{
		$("#EMP_ORG_ID_3").html('<option value="">เลือก</option>');
	}
}

function get_emp_org4(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#EMP_ORG_ID_4').html(html);
				$('#EMP_ORG_ID_4').trigger('liszt:updated');
			}
		});
	}else{
		$("#EMP_ORG_ID_4").html('<option value="">เลือก</option>');
	}
}

function get_emp_org5(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_org",org_id:org_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#EMP_ORG_ID_5').html(html);
				$('#EMP_ORG_ID_5').trigger('liszt:updated');
			}
		});
	}else{
		$("#EMP_ORG_ID_5").html('<option value="">เลือก</option>');
	}
}

function get_line_emp(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: 'process/profile_jobhis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_emp",type_id:e.value,postype_id:5},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#EMP_LINE_ID').html(html);
				$('#EMP_LINE_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#EMP_LINE_ID").html('<option value="">เลือก</option>');
	}
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