﻿$(document).ready(function(){
						   
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
function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_decoratehis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#DEH_ID").val(id);
	$("#frm-search").attr("action","profile_decoratehis_form.php").submit();
}

function chkinput(){
	if($("#DEC_ID").val() == ""){
		alert("ระบุ "+$('#DEC_ID').attr('placeholder'));
		$("#DEC_ID").focus();
		return false;
	}
	if($("#LEVEL_ID").val() == ""){
		alert("ระบุ "+$('#LEVEL_ID').attr('placeholder'));
		$("#LEVEL_ID").focus();
		return false;
	}
	if($("#LINE_ID").val() == ""){
		alert("ระบุ "+$('#LINE_ID').attr('placeholder'));
		$("#LINE_ID").focus();
		return false;
	}
	if($("#DEH_GAZZETTE_DATE").val() == ""){
		alert("ระบุ วันที่ลงในราชกิจจานุเบกษา");
		$("#DEH_GAZZETTE_DATE").focus();
		return false;
	}
	if($("#DEH_GAZZETTE_BOOK").val() == ""){
		alert("ระบุ "+$('#DEH_GAZZETTE_BOOK').attr('placeholder'));
		$("#DEH_GAZZETTE_BOOK").focus();
		return false;
	}
	if($("#DEH_GAZZETTE_PART").val() == ""){
		alert("ระบุ "+$('#DEH_GAZZETTE_PART').attr('placeholder'));
		$("#DEH_GAZZETTE_PART").focus();
		return false;
	}
	if(chk_date($.trim($("#DEH_RECEIVE_DATE").val()),$.trim($("#DEH_RETURN_DATE").val()),'วันที่ได้รับเครื่องราชฯ','วันที่ส่งคืนเครื่องราชฯ')){
		return false;	
	}
	
	if($("input[name=ACTIVE_STATUS]:checked").val() == ""){
		alert("ระบุ สถานะการใช้งาน");
		$("#ACTIVE_STATUS1").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}
function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#DEH_ID").val(id);
		$("#frm-search").attr("action","process/profile_decoratehis_process.php").submit();
	}
}

function getDec(value){
var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'dec',DEF_ID:value,z_id:'DEC_ID',z_name:'DEC_ID',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_dec').html(data);
				$("#DEC_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});

		}
		});
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


function getORG2(parent_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_org',parent_id:parent_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['org_id']+"'>"+value['org_name_th']+"</option>";
		 });
		 $('#ORG_ID_2').html(html);
		 $("#ORG_ID_2").trigger('liszt:updated');
		 $('#ORG_ID_2').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}
function getORG3(parent_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_org',parent_id:parent_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['org_id']+"'>"+value['org_name_th']+"</option>";
		 });
		 $('#ORG_ID_3').html(html);
		 $("#ORG_ID_3").trigger('liszt:updated');
		 $('#ORG_ID_3').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}
function getORG4(parent_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_org',parent_id:parent_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['org_id']+"'>"+value['org_name_th']+"</option>";
		 });
		 $('#ORG_ID_4').html(html);
		 $("#ORG_ID_4").trigger('liszt:updated');
		 $('#ORG_ID_4').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}

function get_level(type_id,postype_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_level',type_id:type_id,postype_id:postype_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['level_id']+"'>"+value['level_name_th']+"</option>";
			 
		 });
		 $('#LEVEL_ID').html(html);
		 $("#LEVEL_ID").trigger('liszt:updated');
		 $('#LEVEL_ID').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}

function get_lg(type_id,postype_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_lg',type_id:type_id,postype_id:postype_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['lg_id']+"'>"+value['lg_name_th']+"</option>";
			 
		 });
		 $('#LG_ID').html(html);
		 $("#LG_ID").trigger('liszt:updated');
		 $('#LG_ID').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}
function get_Manage(type_id,postype_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_Manage',type_id:type_id,postype_id:postype_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['manage_id']+"'>"+value['manage_name_th']+"</option>";
			 
		 });
		 $('#MANAGE_ID').html(html);
		 $("#MANAGE_ID").trigger('liszt:updated');
		 $('#MANAGE_ID').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}

function get_line(lg_id,postype_id){
	var html = "<option value=''></option>";;
	$.post('process/select_selationship.php',{proc:'get_Line',lg_id:lg_id,postype_id:postype_id},function(data){
		 $.each(data,function(index,value){
			 html += "<option value='"+value['line_id']+"'>"+value['line_name_th']+"</option>";
			 
		 });
		 $('#LINE_ID').html(html);
		 $("#LINE_ID").trigger('liszt:updated');
		 $('#LINE_ID').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
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