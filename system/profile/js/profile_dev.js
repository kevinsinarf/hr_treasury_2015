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
	if($('#proc').val()!='edit'){
		getPosLevel($('#TYPE_ID').val(),'LEVEL_ID');
		getORG2($('#ORG_ID_2').val(),'ORG_ID_2');
	}	
});

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_dev_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#TRAINHIS_ID").val(id);
	$("#frm-search").attr("action","profile_dev_form.php").submit();
}

function chkinput(){
	if($('#TRAINHIS_PROJECT_NAME').val() == ''){
		alert('ระบุ  โครงการ');
		$('#TRAINHIS_PROJECT_NAME').focus();
		return false;
	}
	if($('#TRAINHIS_COURSE_NAME').val() == ''){
		alert('ระบุ หลักสูตร');
		$('#TRAINHIS_COURSE_NAME').focus();
		return false;
	}
	if($('#TRAINHIS_TYPE_DEV').val() == ''){
		alert('ระบุ ลักษณะการพัฒนาบุคลากร');
		$('#TRAINHIS_TYPE_DEV').focus();
		return false;
	}
	if($('#TRAINHIS_TYPE_ACT').val() == ''){
		alert('ระบุ ประเภทกิจกรรม');
		$('#TRAINHIS_TYPE_ACT').focus();
		return false;
	}
	if($('#TRAINHIS_TYPE_PLACE').val() == ''){
		alert('ระบุ ประเภทตามสถานที่');
		$('#TRAINHIS_TYPE_PLACE').focus();
		return false;
	}
	if($('#TRAINHIS_TYPE_ORG').val() == ''){
		alert('ระบุ  ประเภทโครงการตามผู้จัด');
		$('#TRAINHIS_TYPE_ORG').focus();
		return false;
	}
	if($('#TRAINHIS_TYPE_ATTEND').val() == ''){
		alert('ระบุ ประเภทการเข้าร่วม');
		$('#TRAINHIS_TYPE_ATTEND').focus();
		return false;
	}
	if($('#S_COUNTRY').val() == ''){
		alert('ระบุ  ประเทศ');
		$('#S_COUNTRY').focus();
		return false;
	}
	if($('#S_COUNTRY').val()== $('#default_country_id').val()){
		if($('#s_prov').val() == ''){
			alert('ระบุ จังหวัด');
			$('#s_prov').focus();
			return false;
		}
	}
	if($('#S_COUNTRY').val() != $('#default_country_id').val()){
		if($('#S_CITY').val() == ''){
			alert('ระบุ  เมือง');
			$('#S_CITY').focus();
			return false;
		}
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#TRAINHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_dev_process.php").submit();
	}
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
function get_gov_org2(org_id){
	var html = "<option value=''></option>";
	if(org_id > 0 && $.trim(org_id) != ""){
		$.ajax({
			url: 'process/profile_dev_process.php',
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
			url: 'process/profile_dev_process.php',
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
			url: 'process/profile_dev_process.php',
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
			url: 'process/profile_dev_process.php',
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

function get_level(e){
	var html = "<option value=''></option>";
	var postype_id = $('#POSTYPE_ID').val();
		$.ajax({
			url: 'process/profile_dev_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:postype_id},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LEVEL_ID').html(html);
				$('#LEVEL_ID').trigger('liszt:updated');
			}
		});
	
}

function get_line_group(e){
	var html = "<option value=''></option>";
	var postype_id = $('#POSTYPE_ID').val();
		$.ajax({
			url: 'process/profile_dev_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:postype_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger('liszt:updated');
			}
		});
}

function get_line(e){
	var html = "<option value=''></option>";
	var postype = $('#POSTYPE_ID').val();
	var id = $(e).attr('id');
		$.ajax({
			url: 'process/profile_dev_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",type_id:e.value,postype_id:postype, name:id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger('liszt:updated');
			}
		});
	
}
function get_manage(e){
	var html = "<option value=''></option>";
	var type_id = $('#TYPE_ID').val();
	var mt_id = $('#MT_ID').val();
		$.ajax({
			url: 'process/profile_dev_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_manage",type_id:type_id,mt_id:mt_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#MANAGE_ID').html(html);
				$('#MANAGE_ID').trigger('liszt:updated');
			}
		});
	
}
function getORG1(value,id){
	var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'org_2',PARENT_ID:value,z_id:'ORG_ID_2',z_name:'ORG_ID_2',z_class:'selectbox form-control',oncharng:'ORG_ID_3'},
		async: false,
		success: function(data) {
				$('#ss_org2').html(data);
				$("#ORG_ID_2").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});

		}
		});
		
		getORG2('',id);
}


function getORG2(value,id){
var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'org_3',PARENT_ID:value,z_id:'ORG_ID_3',z_name:'ORG_ID_3',z_class:'selectbox form-control',oncharng:'ORG_ID_4'},
		async: false,
		success: function(data) {
				$('#ss_org3').html(data);
				$("#ORG_ID_3").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});

		}
		});
		
		getORG3('',id);
}

function getORG3(value,id){
		var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'org_4',PARENT_ID:value,z_id:'ORG_ID_4',z_name:'ORG_ID_4',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_org4').html(data);
				$("#ORG_ID_4").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
		
		getORG4('',id);
}

function getORG4(value,id){
		var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'org_5',PARENT_ID:value,z_id:'ORG_ID_5',z_name:'ORG_ID_5',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_org5').html(data);
				$("#ORG_ID_5").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
}

function getPosLevel(value,POSTYPE_ID){
		var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'pos_level',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'LEVEL_ID',z_name:'LEVEL_ID',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_pos_level').html(data);
				$("#LEVEL_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
}

function getPosLine(value,POSTYPE_ID){
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'get_line',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'LINE_ID',z_name:'LINE_ID',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_pos_line').html(data);
				$("#LINE_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
}

function getPosManage(value,POSTYPE_ID){
		var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'pos_manage',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'MANAGE_ID',z_name:'MANAGE_ID',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_pos_manage').html(data);
				$("#MANAGE_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
}

function set_pos_now(TYPE_LIVE){
	if(TYPE_LIVE == "1"){
		$("#ss_type_live").show();
	}else{
		$("#ss_type_live").hide();
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