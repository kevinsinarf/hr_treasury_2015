$(document).ready(function(){	   
	if(isMobile.any() == "null"){				   
		$(window).scroll(function(){
			$('#myModal').css({
				'margin-top': function () {
					return window.pageYOffset
				}
			});
		});
	}
	
	if($('#proc').val()!='edit'){
		getPosLevel($('#TYPE_ID').val(),'LEVEL_ID');
		 getORG2($('#ORG_ID_2').val(),'ORG_ID_4');
	}
});

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function getTitle(){
	$.ajax({
		url: "process/gettitle.php",
		type: "POST",
		data:{proc:"getTitle",PREFIX_ID:$('#PREFIX_ID').val()},
		success : function(data){ 
			$('#prefix_en').html(data);
		}
	});
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_his_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PER_ID").val(id);
	$("#frm-search").attr("action","profile_his_form.php").submit();
}

function chkinput(){
	/*if($("#PER_IDCARD").val() == ""){
		alert("ระบุ "+$("#PER_IDCARD").attr('placeholder'));
		$("#PER_IDCARD").focus();
		return false;
	}else{
		if(!checkID($('#PER_IDCARD').val())){ 
			alert($("#PER_IDCARD").attr('placeholder')+'ไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PER_IDCARD").focus();
			return false;
		}
	}
	if($("#PREFIX_ID").val() == ""){
		alert("ระบุ "+$("#PREFIX_ID").attr('placeholder'));
		$("#PREFIX_ID").focus();
		return false;
	}
	if($("input[name=GENDER]:checked").val() == ""){
		alert("ระบุ เพศ");
		$("#GENDER1").focus();
		return false;
	}
	if($("#BLOOD_TYPE").val() == ""){
		alert("ระบุ "+$("#BLOOD_TYPE").attr('placeholder'));
		$("#BLOOD_TYPE").focus();
		return false;
	}
	if($("#DATE_BIRTH").val() == ""){
		alert("ระบุ วันเดือนปีเกิด");
		$("#DATE_BIRTH").focus();
		return false;
	}
	if($("#fname_th").val() == ""){
		alert("ระบุ "+$("#fname_th").attr('placeholder'));
		$("#fname_th").focus();
		return false;
	}
	if($("#lname_th").val() == ""){
		alert("ระบุ "+$("#lname_th").attr('placeholder'));
		$("#lname_th").focus();
		return false;
	}
	if($("#fname_en").val() == ""){
		alert("ระบุ "+$("#fname_en").attr('placeholder'));
		$("#fname_en").focus();
		return false;
	}
	if($("#lname_en").val() == ""){
		alert("ระบุ "+$("#lname_en").attr('placeholder'));
		$("#lname_en").focus();
		return false;
	}
	if($.trim($("#NATION_ID").val()) == ""){
		alert("ระบุ "+$('#NATION_ID').attr('placeholder'));
		$("#NATION_ID").focus();
		return false;
	}
	if($.trim($("#RACE_NATION_ID").val()) == ""){
		alert("ระบุ "+$('#RACE_NATION_ID').attr('placeholder'));
		$("#RACE_NATION_ID").focus();
		return false;
	}
	if($.trim($("#RELIGION_ID").val()) == ""){
		alert("ระบุ "+$('#RELIGION_ID').attr('placeholder'));
		$("#RELIGION_ID").focus();
		return false;
	}
	if($("#POS_ID").val() == ""){
		alert("ระบุ เลขที่ตำแหน่ง");
		$("#POS_ID").focus();
		return false;
	}
	
	if($("#ORG_ID_2").val() == ""){
		alert("ระบุ "+$('#ORG_ID_2').attr('placeholder'));
		$("#ORG_ID_2").focus();
		return false;
	}
	if($("#ORG_ID_3").val() == ""){
		alert("ระบุ "+$('#ORG_ID_3').attr('placeholder'));
		$("#ORG_ID_3").focus();
		return false;
	}
	if($("#ORG_ID_4").val() == ""){
		alert("ระบุ "+$('#ORG_ID_4').attr('placeholder'));
		$("#ORG_ID_4").focus();
		return false;
	}
	if($("#SALARY").val() == ""){
		alert("ระบุ "+$('#SALARY').attr('placeholder'));
		$("#SALARY").focus();
		return false;
	}
	if($("#PER_STEP").val() == "" || $("#PER_STEP").val() == "0"){
		alert("ระบุ "+$('#PER_STEP').attr('placeholder'));
		$("#PER_STEP").focus();
		return false;
	}
	
	if($("#DATE_ENTRANCE").val() == ""){
		alert("ระบุ วันที่บรรจุ");
		$("#DATE_ENTRANCE").focus();
		return false;
	}
	if($("#DATE_RETIRE").val() == ""){
		alert("ระบุ กำหนดวันเกษียณราชการ");
		$("#DATE_RETIRE").focus();
		return false;
	}
	if($("input[name=GPF_STATUS]:checked").val() == ""){
		alert("ระบุ การเป็นสมาชิก กบข.");
		return false;
	}

	if($.trim($("input[name=ACTIVE_STATUS]:checked").val()) == ""){
		alert("ระบุ สถานะการใช้งาน ");
		$("#ACTIVE_STATUS1").focus();
		return false;
	}*/
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PER_ID").val(id);
		$("#frm-search").attr("action","process/profile_his_proc.php").submit();
	}
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
}

function getOrg(value,id){
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
}

function getPosDetail(POS_ID){
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'pos_detail',POS_ID:POS_ID},
		async: false,
		success: function(data) {
			$("#TYPE_NAME_TH").html(data.TYPE_NAME_TH);
			$("#LEVEL_NAME_TH").html(data.LEVEL_NAME_TH);
			$("#LINE_NAME_TH").html(data.LINE_NAME_TH);
			$("#MANAGE_NAME_TH").html(data.MANAGE_NAME_TH);
			
			$("#TYPE_ID").val(data.TYPE_ID);
			$("#LEVEL_ID").val(data.LEVEL_ID);
			$("#LINE_ID").val(data.LINE_ID);
			$("#MANAGE_ID").val(data.MANAGE_ID);
		}
	});
}

function checkfile(sender) {
    var validExts = new Array(".gif", ".png", ".jpg");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("เลือกไฟล์รูปภาพได้เฉพาะ นามสกุล   " + validExts.toString() + " เท่านั้น");
	  $('#PER_FILE_PIC').val('');
	  //$('#SS_PICTURE').replaceWith('<input id="SS_PICTURE" type="file" name="SS_PICTURE" class="form-control"  value="" onchange="checkfile(this);" >');
      return false;
    }
    else return true;
}

// ========== POPUP FUNCTION ==============
function show_pop(){
	url = "../../system/all/form_select_position_no_plac_app.php";
	data = {span: 'show_display2',s_file: url,S_POS_NO: '', POS_ID_OLD:$("#POS_ID_OLD").val(), POSTYPE_ID:$("#POSTYPE_ID").val()};
	$.get(url,data,function(msg){
		$('#show_display2').html(msg);
	});
}

function search_pop(url1, show_dis, APPOINT_TYPE_PERSON, id_tb, S_POS_NO){	
	url = "../../system/all/"+url1;
	data = {span: show_dis,s_file: url1,APPOINT_TYPE_PERSON: APPOINT_TYPE_PERSON, id_tb:id_tb, S_POS_NO:S_POS_NO, POSTYPE_ID:$("#POSTYPE_ID").val()};
	$.get(url,data,function(msg){
		$('#'+show_dis).html(msg);
	});
}
function search_pop2(url1, show_dis, id_tb, S_POS_NO, POSTYPE_ID){
	url = "../../system/all/"+url1;
	data = {span: show_dis,s_file: url1, id_tb:id_tb, S_POS_NO:S_POS_NO, POSTYPE_ID:POSTYPE_ID};
	$.get(url,data,function(msg){
		$('#'+show_dis).html(msg);
	});
}

function closePopup(id){
	$('#'+id).modal('hide')
}

function return_position(LINE_ID, POS_NO, tb_id, POS_ID){
	//alert(per_id);
	$('#POS_NO').val(POS_NO);
	$('#POS_ID').val(POS_ID);
	getPosDetail(POS_ID);
	
	closePopup('myModal');
}
// =======================================

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