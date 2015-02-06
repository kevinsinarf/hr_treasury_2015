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
	$("#frm-search").attr("action","pos_line_form.php").submit();
}
function add_edu(type_id,line_id){
	$("#proc").val("add");
	$("#TYPE_ID").val(type_id);
	$("#LINE_ID").val(line_id);
	$("#frm-search").attr("action","pos_edu_form.php").submit();
}
function add_step(type_id,line_id){
	$("#proc").val("add");
	$("#TYPE_ID").val(type_id);
	$("#LINE_ID").val(line_id);
	$("#frm-search").attr("action","line_level_salary_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#LINE_ID").val(id);
	$("#frm-search").attr("action","pos_line_form.php").submit();
}

function selectData(id){
	$("#proc").val("select");
	$("#LINE_ID").val(id);
	$("#frm-search").attr("action","pos_line_form.php").submit();
	
	
}
function ClickFocus(id){alert(id);
			$("#"+id).focus();
}

function chkinput(){
	if($("#TYPE_ID").val() == ""){
		alert("ระบุ "+$('#TYPE_ID').attr('placeholder'));
		$("#TYPE_ID").focus();
		return false;
	}
	if($("#LG_ID").val() == ""){
		alert("ระบุ "+$('#LG_ID').attr('placeholder'));
		$("#LG_ID").focus();
		return false;
	}
	if($('#SALARY_STEP_TYPE').val() == ''){
		alert("ระบุ "+$('#SALARY_STEP_TYPE').attr('placeholder'));
		$("#SALARY_STEP_TYPE").focus();
		return false;
	}
	if($("#LINE_NAME_TH").val() == ""){
		alert("ระบุ "+$('#LINE_NAME_TH').attr('placeholder'));
		$("#LINE_NAME_TH").focus();
		return false;
	}
	if($("#flagDup1").val() == 1){
		alert($('#LINE_NAME_TH').attr('placeholder')+"ซ้ำ");
		$("#LINE_NAME_TH").focus();
		return false;
	}
	if($("#flagDup2").val() == 1){
		alert($('#LINE_NAME_EN').attr('placeholder')+"ซ้ำ");
		$("#LINE_NAME_EN").focus();
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
		$("#LINE_ID").val(id);
		$("#frm-search").attr("action","process/pos_line_process.php").submit();
	}
}

function Chkrepeat(){
	if($("#TYPE_ID").val() == ""){
		$("#TYPE_ID").focus();
		return false;
	}
	chkDup('chkDup1','flagDup1','LINE_NAME_TH','LINE_ID','SETUP_POS_LINE','TYPE_ID='+$('#TYPE_ID').val());
	chkDup('chkDup2','flagDup2','LINE_NAME_EN','LINE_ID','SETUP_POS_LINE','TYPE_ID='+$('#TYPE_ID').val());
	chkDup('chkDup3','flagDup3','LINE_SHORTNAME_TH','LINE_ID','SETUP_POS_LINE','TYPE_ID='+$('#TYPE_ID').val());
	chkDup('chkDup4','flagDup4','LINE_SHORTNAME_EN','LINE_ID','SETUP_POS_LINE','TYPE_ID='+$('#TYPE_ID').val());
}
function get_line_group(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: "process/pos_line_process.php",
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LG_ID').html(html);
				$('#LG_ID').trigger('liszt:updated');
			}
		});
	}else{
		$("#LG_ID").html('<option value="">เลือก</option>');
	}
}
function get_line_group_disp(e){
	var html = "<option value=''></option>";
	if(e.value > 0 && $.trim(e.value) != ""){
		$.ajax({
			url: "process/pos_line_process.php",
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:1},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#s_lg_id').html(html);
				$('#s_lg_id').trigger('liszt:updated');
			}
		});
	}else{
		$("#s_lg_id").html('<option value="">เลือก</option>');
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