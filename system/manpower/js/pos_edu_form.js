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
function add_row(){
	var table = document.getElementById('tb_data_3');
	var rowCount = (table.rows.length);
	var id_tb = parseInt(rowCount);
	
	var TYPE_ID = $('#TYPE_ID').val();
	// ระดับการศึกษา
	$.post('process/pos_edu_process.php',{proc: 'get_el_add',id_tb: id_tb,TYPE_ID:TYPE_ID},function(data){
		   var data1 = data.split("get_el_add");
		   $('#EL_X_'+id_tb).html(data1);
		   $(".chosen").chosen({//ค้นหา+เลือก select  id
			 	allow_single_deselect: true
		   });
	});
	
	// วุฒิการศึกษา
	$.post('process/pos_edu_process.php',{proc: 'get_ed_add',id_tb: id_tb,TYPE_ID:TYPE_ID},function(data){
		   var data1 = data.split("get_ed_add");
		   $('#ED_Y_'+id_tb).html(data1);
		   $(".chosen").chosen({//ค้นหา+เลือก select  id
			 	allow_single_deselect: true
		   });
	});
	
	var  html ="<tr >";
		 html += "<td align='center'>"+id_tb+"<input type=\"hidden\" name='KEY[]' id='KEY_"+id_tb+"' value='"+id_tb+"' ></td>";
	     html +="<td style='text-align:left'><div id = 'EL_X_"+id_tb+"' ></div></td>";
	     html +="<td style='text-align:left'><div id = 'ED_Y_"+id_tb+"' ></div></td>";
		 html += "<td align='center' ><a  class='btn btn-default btn-xs' data-backdrop='static' href='javascript:void(0);' onClick='remove_id(this);' >"+img_del+" ลบ</a></td>";
  		 html += "</tr>";
	$('#tb_data_3 tbody').append(html);
}
function remove_id(obj){
	$(obj).parent().parent().remove(); 
}
function getED(el_id,id_tb){
	
	var html = "<option value=''></option>";
	$.post('process/pos_line_process.php',{proc:'get_ed',el_id:el_id},function(data){
			$.each(data,function(index,value){
					html += "<option value='"+value['ed_id']+"'>"+value['ed_name_th']+"</option>";	
			});	
			$('#ED_ID_'+id_tb).html(html);
			$('#ED_ID_'+id_tb).trigger("liszt:updated");
			$('#ED_ID_'+id_tb).chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}
function chkinput(){
	
	$("#proc").val("add");
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