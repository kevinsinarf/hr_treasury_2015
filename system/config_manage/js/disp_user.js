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
	
	if($("#proc").val()=='edit'&&$ ("#PER_IDCARD").val() != ""){
	chk_idcard('chkDup1','flagDup1','PER_IDCARD','chk_idcard');
	}
	if($("#proc").val()=='edit'&&$("#username").val() != ""){
	chk_idcard('spanUser','flagUser','username','chk_dup');
	}
});

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","form_user.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#aut_user_id").val(id);
	$("#frm-search").attr("action","form_user.php").submit();
}

function form_load(){
		FncLoad_Form('show_display','material_per_profile.php',
		'page=1&PER_IDCARD='+$("#PER_IDCARD").val().replace(/-/g,'').replace(/ /gi,'').replace(/_/gi,''),
		'SAPA');//แสดงข้อมูล ajax
			$('#myModelprofile').modal('show');
}
function chk_idcard(span,hidden,id,proc){//'chkDup1','flagDup1','PER_IDCARD'
var vals='';
if(id=='PER_IDCARD'){
	vals= $('#'+id).val().replace(/-/g,'').replace(/ /gi,'').replace(/_/gi,'');
}else{
	vals=$('#'+id).val();
}
//alert($('#'+id).val());
					v_val='';
					if(id=='username'){
						v_val='?aut_user_id='+$('#aut_user_id').val();	
					}	
		$.ajax({
			url: './process/process_user.php'+v_val,
			dataType: "json",   
			type: "POST",
			data:{proc:proc,val:vals},
			success : function(data){//alert(data.aa);
				$("span[id="+span+"]").each(function(){
					$("#"+hidden).val(data.flag);	
					if(id=='PER_IDCARD'){
					$("#PER_ID").val(data.per_id);	
					}					
					var Dclass = $(this).attr("class").replace(" label-danger","").replace(" label-success","");
					if(data.flag == 1){
						Dclass += " label-danger";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-remove\"></span> "+data.detail+"</b>");
					}else{
						Dclass += " label-success";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-saved\"></span> "+data.detail+"</b>");
					}
				});
			}
		});
}
function chk_email(span, hidden, id, proc){
	var email = $('#email').val();
	
	if(!check_email(email)){
		  var Dclass = $('#'+span).attr("class").replace(" label-danger","").replace(" label-success","");
		  $("#"+hidden).val(1);
		  Dclass += " label-danger";
		  $('#'+span).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-remove\"></span> กรุณากรอก Email ให้ถูกต้อง</b>");
	}else{
		$.post('process/process_user.php',{'proc':proc, 'email':email },function(data){
			var Dclass = $('#'+span).attr("class").replace(" label-danger","").replace(" label-success","");
			 
			if(data == 0){
				$("#"+hidden).val(0);
				Dclass += " label-success";
				$('#'+span).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-saved\"></span> Email สามารถใช้งานได้</b>");
			}else{
				$("#"+hidden).val(1);
				 Dclass += " label-danger";
		  		 $('#'+span).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-remove\"></span> Email มีผู้ใช้งานแล้ว</b>");
			}
	    });
	}
	
	/*if(checkEmail(email)){
		alert('กรอก Email ไม่ถูกต้อง');
		$('#email').focus();
		return false;
	}*/
	
	
}

function searchpopup(){ //alert(); 
var url ='../../system/all/material_per_profile.php';
$.ajax({
	url: url,
		type: 'GET',
		dataType: 'html',
		data: {span:'show_display',s_file:'material_per_profile.php',S_CARD:$('#S_CARD').val(),S_NAME:$('#S_NAME').val(),TYPE:'SAPA'},
		async: false,
		success: function(data) {
		//alert(data);
		//$('#PL_FIRSTNAME_TH').val(data.name);
		$("#show_display").html(data);
			
			
	} 
	});
}
function getChk(id){//ดึงข้อมูลมาแสดง
	$('#PER_IDCARD').val($('#f1_'+id).val());
	$('#PER_ID').val($('#f2_'+id).val());
		$("#flagDup1").val(0);
		chk_idcard('chkDup1','flagDup1','PER_IDCARD','chk_idcard')
		$('#myModelprofile').modal('hide');
}
function chkinput(){
	if($('#proc').val() == 'add'){
		if($("#PER_IDCARD").val() == ""){
		alert("ระบุ "+$("#PER_IDCARD").attr('placeholder'));
		$("#PER_IDCARD").focus();
		return false;
		}
		if($("#flagDup1").val() == 1 ){
			alert('กรุณาเลือก เลขประจำตัวประชาชน ใหม่ เนื่องจากมีผู้ใช้งานแล้ว');
			$("#PER_IDCARD").focus();
			return false;
		}
		if($("#username").val() == ""){
			alert("ระบุ ชื่อผู้ใช้");
			$("#username").focus();
			return false;
		}
		
		if($("#flagUser").val() == 1){
			alert("ไม่สามารถใช้ username นี้ได้");
			$("#username").focus();
			return false;
		}
		
		if($("#password").val() == ""){
			alert("ระบุ รหัสผ่าน");
			$("#password").focus();
			return false;
		}
		
		if($("#confirm_password").val() == ""){
			alert("ระบุ ยืนยันรหัสผ่าน");
			$("#confirm_password").focus();
			return false;
		}
		
		if($("#password").val() != $("#confirm_password").val()){
			alert("ระบุ รหัสผ่านกับยืนยันรหัสผ่านไม่ตรงกัน โปรดตรวจสอบอีกครั้ง");
			$("#confirm_password").focus();
			return false;
		}
	}
	if($("#email").val() == ""){
		alert("ระบุ Email");
		$("#email").focus();
		return false;
	}
	if($("#flagEmail").val() == 1 ){
		alert('กรอก Email ไม่ถูกต้อง');
		$("#PER_IDCARD").focus();
		return false;
	}
	if($("#user_group_id").val() == ""){
		alert("ระบุ กล่มสิทธิ์");
		$("#user_group_id").focus();
		return false;
	}
	
	
	if($("input[name=ACTIVE_STATUS]:checked").length == 0){
		alert("ระบุ สถานะ");
		$("#ACTIVE_STATUS").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#aut_user_id").val(id);
		$("#frm-search").attr("action","process/process_user.php").submit();
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