$(document).ready(function() {
    if (isMobile.any() == "null") {
        $(window).scroll(function() {
            $('#myModal').css({
                'margin-top': function() {
                    return window.pageYOffset
                }
            });
        });
    }

	
});
function show(id,obj){
	var collapseIcon = '<img src="../../images/clse.gif">';
	var expandIcon = '<img src="../../images/exp.gif">';
	var txt_class = $('#'+id).attr('class');
	var arr = id.split('_');
	var num = arr.length;
	var txt = '';
	var id_1 = arr[0];
	var id_2 = arr[1];
	var id_3 = arr[2];
	var id_4 = arr[3];
	if(num == 1){
		txt = id_1;
	}else if(num == 2){
		txt = id_1+'_'+id_2;
	}else if(num == 3){
		txt = id_1+'_'+id_2+'_'+id_3;
	}else if(num == 4){
		txt = id_1+'_'+id_2+'_'+id_3+'_'+id_4;
	}
	
	
	$('tr[id^='+txt+']').each(function(index, element) {
		
		if(txt_class == 'collapsed'){
			$('#'+id).removeClass('collapsed');
			$(obj).html(collapseIcon);
			$(this).not($('#'+id)).css('display','');
		}else{
			$('#'+id).addClass('collapsed');
			$(obj).html(expandIcon);
			$(this).not($('#'+id)).css('display','none');
		}
        
    });
}
function searchData(){
	$("#frm-search").submit();
}

function chkinput(){
	if($("#ot_id").val() == ""){
		alert("ระบุ ประเภทส่วนราชการ");
		$("#ot_id").focus();
		return false;
	}
	
	if($("#ol_id").val() == ""){
		alert("ระบุ ฐานะของหน่วยงาน");
		$("#ol_id").focus();
		return false;
	}
	
	if($("#org_name_th").val() == ""){
		alert("ระบุ ชื่อหน่วยงาน (ภาษาไทย)");
		$("#org_name_th").focus();
		return false;
	}
   if($("#flagDup1").val() == 1){
		alert($('#org_name_th').attr('placeholder')+"ซ้ำ");
		$("#org_name_th").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
			$("#frm").submit();
	}
}

function addDataMis(id,seq){
	$("#proc").val("add");
        $("#org_id1").val(id);
	    $("#seq").val(seq);
	$("#frm-search").attr("target","").attr("action","form_gov_other.php").submit();
}
function addData(id,seq){
	$("#proc").val("add");
        $("#org_id1").val(id);
	$("#seq").val(seq);
	$("#frm-search").attr("target","").attr("action","form_gov_other.php").submit();
}

function editData(id){
   
	$("#proc").val("edit");
	$("#org_id").val(id);
	$("#frm-search").attr("target","").attr("action","form_gov_other.php").submit();
}
function editData1(id){
   
	$("#proc").val("edit");
	$("#org_id").val(id);
	$("#frm-search").attr("target","").attr("action","form_other_address.php").submit();
}

function deleteData(id){
	if(confirm("ต้องการลบข้อมูลหรือไม่ ?")){
		$("#proc").val("delete");
		$("#org_id").val(id);
		$("#frm-search").attr("target","").attr("action","process/gov_other_process.php").submit();
	}
}

function getRampr(id,name_rampr,name_tamb){	
	val=$('#'+name_rampr).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,name_tamb:name_tamb,val:val},
		success : function(data){
			$('#ss_ampr').html(data);
			$("#"+name_rampr).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			getStamb(name_rampr,$('#'+name_rampr).val(),name_tamb);
		}
	});
}

function getStamb(id,val_ampr,name_tamb){
	val=$('#'+name_tamb).val();	
	$.ajax({
		url: "process/select_relationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"stamb",v_tamb:val_ampr,z_id:name_tamb,z_name:name_tamb,val:val},
		success : function(data){
			$('#ss_tamb').html(data);
			$("#"+name_tamb).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
		}
	});		
}
function getORG(obj){
	var val = $(obj).val();
	var id_old = $(obj).attr('id').substr(-1);
	var id = parseInt($(obj).attr('id').substr(-1))+1;
	var id_new = $(obj).attr('id').replace(id_old, id);
	var html = "<option value=''></option>";
	
	$.post('process/gov_other_process.php', {'proc':'get_org', ORG_PARENT_ID:val}, function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
	   });
	   $('#'+id_new).html(html);
	   $('#'+id_new).trigger('liszt:updated');
	   $('#'+id_new).chosen({ allow_single_deselect: true });
	},'json');

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