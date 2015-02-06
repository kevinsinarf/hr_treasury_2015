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
	$("#frm-search").attr("action","knowledge_year_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#SKILLSET_ID").val(id);
	$("#frm-search").attr("action","knowledge_year_form.php").submit();
}

function chkinput(){
	if($("#SKILLSET_YEAR").val() == ""){
		alert("ระบุ "+$('#SKILLSET_YEAR').attr('placeholder'));
		$("#SKILLSET_YEAR").focus();
		return false;
	}
	if($("#SKILLTITLE_ID").val() == ""){
		alert("ระบุ "+$('#SKILLTITLE_ID').attr('placeholder'));
		$("#SKILLTITLE_ID").focus();
		return false;
	}
	if($("#flagDup2").val() == 1){
		alert($('#SKILLTITLE_ID').attr('placeholder')+" ซ้ำ");
		$("#SKILLTITLE_ID").focus();
		return false;
	}
	if($("#SKILLSET_EXPECT").val() == ""){
		alert("ระบุ "+$('#SKILLSET_EXPECT').attr('placeholder'));
		$("#SKILLSET_EXPECT").focus();
		return false;
	}
	
	if($("#TYPE_ID").val() == ""){
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
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#SKILLSET_ID").val(id);
		$("#frm-search").attr("action","process/knowledge_year_process.php").submit();
	}
}

function Chkrepeat(){
	if($("#SKILLSET_YEAR").val() == ""){
		alert("กรุณาเลือก "+$('#SKILLSET_YEAR').attr('placeholder'));
		$("#SKILLSET_YEAR").focus();
		$('#SKILLTITLE_ID').val('').trigger('liszt:updated');
		return false;
	}
	chkDup('chkDup2','flagDup2','SKILLTITLE_ID','SKILLSET_ID','SKILL_SET',"SKILLSET_YEAR="+$("#SKILLSET_YEAR").val());
}

function getLevel(id,pos_level,pos_line){
	val=$('#'+pos_level).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"level_pos",v_level:id.value,z_id:pos_level,z_name:pos_level,pos_line:pos_line,val:val},
		success : function(data){
			$('#p_level').html(data);
			$("#"+pos_level).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
		}
	});
}
function getLine(id,val_level,pos_line){
	//alert(level_max);
	val=$('#'+pos_line).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"line_pos",v_line:val_level, z_id:pos_line, z_name:pos_line, val:val},
		success : function(data){
			$('#p_line').html(data);
			$("#"+pos_line).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
		}
	});		
}

function get_line(val){
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"get_line",type_id:val},
		success : function(data){
			$('#p_line').html(data);
			$("#LINE_ID").chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
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