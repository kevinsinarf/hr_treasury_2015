//header( "content-type: application/x-javascript; charset=UTF-8" );

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
});

function searchData(){  
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","data_profess_licensing_form.php").submit();
}

function editData(id){  
	$("#proc").val("edit");
	$("#CERTHIS_ID").val(id);  
	$("#frm-search").attr("action","data_profess_licensing_form.php").submit();
}


function chkDup(){
	
}

function chkinput(){
	if($.trim($("#CERTIFICATE_ID").val()) == ""){
		alert("ระบุ "+$('#CERTIFICATE_ID').attr('placeholder'));
		$("#CERTIFICATE_ID").focus();
		return false;
	}
	
	if($.trim($("#CERTHIS_NO").val()) == ""){
		alert("ระบุ "+$('#CERTHIS_NO').attr('placeholder'));
		$("#CERTHIS_NO").focus();
		return false;
	}
	
	if($.trim($("#CERTHIS_DATE").val()) == ""){
		alert("โปรดระบุวันที่มีผลบังคับใช้");
		$("#CERTHIS_DATE").focus();
		return false;
	}
	
	if($("#flagDup1").val() == 1){
		alert($('#CERTIFICATE_ID').attr('placeholder')+"ซ้ำ");
		$("#CERTIFICATE_ID").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
  
} 

function call_txt(id){
 
			$.post( "../dev_ajax/call_cert_by.php", { id: id })
				.done(function( data ) {
						//alert( "on Dev - Data Loaded: " + data );
						$("#CERTIFICATE_BY").val(data);
			}, "json");
}

function chk_ex(){
	var proc_is = $("#proc").val();
	//alert(proc_is);
	if(proc_is=="edit"){
		if($.trim($("#CERTIFICATE_ID").val()) > 1){
			
			$.post( "../dev_ajax/chk_exist.php", { table_is: "2",  wh_f1:"CERTIFICATE_ID", wh_v1: $("#CERTIFICATE_ID").val(),wh_f2:"PER_ID", wh_v2: $("#PER_ID").val(),wh_f3:"CERTIFICATE_ID", wh_v3: $("#OLD_ID_is").val() })
				.done(function( data ) {
				//alert( "on Dev - Data Loaded: " + data );
				 //alert(data.flag);
				 //console.log(data);
				$("span[id=chkDup1]").each(function(){		
					var Dclass = $(this).attr("class").replace(" label-danger","").replace(" label-success","");
					if(data== 1){
						Dclass += " label-danger";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-remove\"></span> ข้อมูลซ้ำ</b>");
					}else{
						Dclass += " label-success";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-saved\"></span> สามารถใช้ข้อมูลนี้ได้</b>");
					}
				});
				
				
				/*
				if(data==1){ 
					// alert("ปีงบประมาณนี้ท่านเคยระบุแล้วค่ะ กรุณาเลือกปีอื่นค่ะ");
					 $("#CERTIFICATE_ID").focus();
					 throw { name: 'exist_data', message: 'ข้อมูลซ้ำค่ะ' };
					 return false;
				} //if*/
			}, "json");
				 
		} // if
			 
 
	}
}
	

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#CERTHIS_ID").val(id);
		$("#frm-search").attr("action","process/data_process_licensing_process.php").submit();
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