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
	
	if($('#proc').val()!='edit'){
		getPosLevel($('#TYPE_ID').val(),'LEVEL_ID');
		 getORG2($('#ORG_ID_2').val(),'ORG_ID_2');
	}
	
	getcountry($('#COUNTRY_ID').val());
});
function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_child_scholar_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#CHS_ID").val(id);
	$("#frm-search").attr("action","profile_child_scholar_form.php").submit();
}

function chkinput(){
/*	if($("#TYPE_ID").val() == ""){
		alert("ระบุ "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
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
	if($("#ORG_ID_2").val() == ""){
		alert("ระบุ "+$('#ORG_ID_2').attr('placeholder'));
		$("#ORG_ID_2").focus();
		return false;
	}
*/	if($("#PMARRY_ID").val() == ""){
		alert("ระบุ "+$('#PMARRY_ID').attr('placeholder'));
		$("#PMARRY_ID").focus();
		return false;
	}
	if($("#PCHILD_ID").val() == ""){
		alert("ระบุ "+$('#PCHILD_ID').attr('placeholder'));
		$("#PCHILD_ID").focus();
		return false;
	}
	if($("#EL_ID").val() == ""){
		alert("ระบุ "+$('#EL_ID').attr('placeholder'));
		$("#EL_ID").focus();
		return false;
	}
	if($("#INS_ID").val() == ""){
		alert("ระบุ "+$('#INS_ID').attr('placeholder'));
		$("#INS_ID").focus();
		return false;
	}
	if($.trim($("#COUNTRY_ID").val()) == ""){
		alert("ระบุ "+$('#COUNTRY_ID').attr('placeholder'));
		$("#COUNTRY_ID").focus();
		return false;
	}
	if($.trim($("#COUNTRY_ID").val())==$('#default_country_id').val()){
		if($("#PROV_ID").val() == ""){
			alert("ระบุ "+$('#PROV_ID').attr('placeholder'));
			$("#PROV_ID").focus();
			return false;
		}
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
		$("#CHS_ID").val(id);
		$("#frm-search").attr("action","process/profile_child_scholar_process.php").submit();
	}
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

function getcountry(id){
	if(id==$('#default_country_id').val()){
		$('#country_del').show();
	}else{
		$('#country_del').hide();
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