var form_input = "pos_manage_form.php";

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
function get_org_4(e){
	if(e.value > 0  && $.trim(e.value) != ""){
		$.ajax({
			url: "process/pos_manage_process.php",
			type: "POST",
			data:{proc:"get_org_4",org_parent_id:e.value},
			success : function(data){
				$("#ORG_ID_4").html(data);
				$('select').trigger('liszt:updated');
				$("#ORG_ID_4").chosen({//ค้นหา+เลือก select 
					allow_single_deselect: true
					//no_results_text: "No results matched"
				});
			}
		});
	}
}	
function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action", form_input ).submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#MANAGE_ID").val(id);
	$("#frm-search").attr("action", form_input ).submit();
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#MANAGE_ID").val(id);
		$("#frm-search").attr("action","process/pos_manage_process.php").submit();
	}
}

function chkinput(){
	if($("#MT_ID").val() == ""){
		alert("ระบุ "+$('#MT_ID').attr('placeholder'));
		$("#MT_ID").focus();
		return false;
	}
	
	if($("#ORG_ID_3").val() != "" && $("#ORG_ID_4").val()!=""){
		$("#ORG_ID_3").prop("disabled",true);
		$('#ORG_ID_3').trigger('liszt:updated');
	}else if($("#ORG_ID_3").val() != ""){
		$("#ORG_ID_4").prop("disabled",true);
		$('#ORG_ID_4').trigger('liszt:updated');
	}else if($("#ORG_ID_4").val() != ""){
		$("#ORG_ID_3").prop("disabled",true);
		$('#ORG_ID_3').trigger('liszt:updated');
	}
	
	if($("#MANAGE_NAME_TH").val() == ""){
		alert("ระบุ "+$('#MANAGE_NAME_TH').attr('placeholder'));
		$("#MANAGE_NAME_TH").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
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