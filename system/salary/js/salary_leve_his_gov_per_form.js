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


function chkinput(){

/*
	if($("#flagDup1").val() == 1){
		alert($('#LEAVEHIS_YEAR').attr('placeholder')+"ซ้ำ");
		$("#LEAVEHIS_YEAR").focus();
		return false;
	}	
*/


 	if($.trim($("#LEAVEHIS_YEAR").val()) == ""){
		alert("กรุณาระบุปีงบประมาณค่ะ");
		$("#LEAVEHIS_YEAR").focus();
		return false;
	} 	
	
 	if($.trim($("#ROUND_YEAR").val()) == ""){
		alert("กรุณาระบุรอบด้วยค่ะ");
		$("#ROUND_YEAR").focus();
		return false;
	} 
	
	
	//
	
	 
	

		if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
			$("#frm-input").submit();
		}

}


function chk_ex(){
	 
		var proc_is = $("#proc").val();
	 
	//if(proc_is=="edit"){
		if($.trim($("#LEAVEHIS_YEAR").val()) > 1){
			$.post( "../dev_ajax/chk_exist.php", { table_is: "1",  wh_f1:"LEAVEHIS_YEAR", wh_v1: $("#LEAVEHIS_YEAR").val(),wh_f2:"PER_ID", wh_v2: $("#PER_ID").val(),wh_f3:"LEAVEHIS_YEAR", wh_v3: $("#OLD_ID_is").val() })
				.done(function( data ) {
				//alert( "on Dev - Data Loaded: " + data );
				/*
				if(data==1){ 
					 alert("ปีงบประมาณนี้ท่านเคยระบุแล้วค่ะ กรุณาเลือกปีอื่นค่ะ");
					 $("#LEAVEHIS_YEAR").focus();
					 throw { name: 'exist_data', message: 'ข้อมูลซ้ำค่ะ' };
					 return false;
				}*/
				
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
				
				
				
				
			});
				 
		} // if
			 
 
	//}// add
	
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_absent_form.php").submit();
}

function delData(id){    
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#LEAVEHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_absent_process.php").submit();
	}
}


function editData(id){
	$("#proc").val("edit");
	$("#LEAVEHIS_ID").val(id);
	$("#frm-search").attr("action","profile_absent_form.php").submit();
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
		data: {proc:'pos_level',PARENT_ID:value,POSTYPE_ID:$("#PT_ID").val(),z_id:'LEVEL_ID',z_name:'LEVEL_ID',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_pos_level').html(data);
				$("#LEVEL_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'get_line',PARENT_ID:value,POSTYPE_ID:$("#PT_ID").val(),z_id:'LINE_ID',z_name:'LINE_ID',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_pos_line').html(data);
				$("#LINE_ID").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
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