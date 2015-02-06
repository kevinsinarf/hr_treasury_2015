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
	$("#frm-search").attr("action","pos_co_level_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#CO_ID").val(id);
	$("#frm-search").attr("action","pos_co_level_form.php").submit();
}

function selectData(id){
	$("#proc").val("select");
	$("#CO_ID").val(id);
	$("#frm-search").attr("action","pos_co_level_form.php").submit();
	
	
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
	if($("#LEVEL_ID_MIN").val() == ""){
		alert("ระบุ "+$('#LEVEL_ID_MIN').attr('placeholder'));
		$("#LEVEL_ID_MIN").focus();
		return false;
	}
	if($("#LEVEL_ID_MAX").val() == ""){
		alert("ระบุ "+$('#LEVEL_ID_MAX').attr('placeholder'));
		$("#LEVEL_ID_MAX").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
	}
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#CO_ID").val(id);
		$("#frm-search").attr("action","process/pos_co_level_process.php").submit();
	}
}


function getPosLevel(id,level_min,level_max){
	val=$('#'+level_min).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"min",v_min:id.value,z_id:level_min,z_name:level_min,level_max:level_max,val:val},
		success : function(data){
			$('#lv_min').html(data);
			$("#"+level_min).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			//getLevel2(level_min,$('#'+level_min).val(),level_max);
		}
	});
}
function getLevel2(id,val_min,level_max){
	//alert(level_max);
	val=$('#'+level_max).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"max",v_max:val_min, z_id:level_max, z_name:level_max, val:val},
		success : function(data){
			$('#lv_max').html(data);
			$("#"+level_max).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
		}
	});		
}

function getPosLevel3(id,level_min,level_max){
	val=$('#'+level_min).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"smin",v_min:id.value,z_id:level_min,z_name:level_min,level_max:level_max,val:val},
		success : function(data){
			$('#lv_min').html(data);
			$("#"+level_min).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			//getLevel2(level_min,$('#'+level_min).val(),level_max);
		}
	});
}
function getLevel4(id,val_min,level_max){
	//alert(level_max);
	val=$('#'+level_max).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"smax",v_max:val_min, z_id:level_max, z_name:level_max, val:val},
		success : function(data){
			$('#lv_max').html(data);
			$("#"+level_max).chosen({//ค้นหา+เลือก select 
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