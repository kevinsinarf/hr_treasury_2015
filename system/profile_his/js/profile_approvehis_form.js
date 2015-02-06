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

function getTable_URL(TABLE_ID){
	$.ajax({
		url: "process/profile_approvehis_list_process.php",
		dataType: "html",
		type: "POST",
		data: {proc:'getTablename',TABLE_ID:TABLE_ID},
		success: function(data_url){
			$("#frm-input").attr("action",data_url).submit();
			}
		});
}

function getRampr(id,name_rampr,oncharng){	
	var key_index=id.id.replace(/\D/g,'');
	
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,oncharng:oncharng, key_index:key_index},
		success : function(data){
			$('#ss_ampr'+key_index).html(data);
			$("#s_ampr"+key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			$('#ss_tamb'+key_index).html('<select id="s_tamb'+key_index+'" name="s_tamb'+key_index+'" class="selectbox form-control"><option value="0">--ไม่พบข้อมูล--</option></select>');	
			$("#s_tamb"+key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			
			if($("#ADDR_TYPE"+key_index).val() != ""){
				$('#s_ampr'+key_index).val($('#s_ampr'+$("#ADDR_TYPE"+key_index).val()).val());	
				$('#s_ampr'+key_index).change().trigger("liszt:updated");
			}
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