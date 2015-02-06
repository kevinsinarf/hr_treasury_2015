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
	var collapseIcon = '../../images/clse.gif';
	var collapseText = 'Collapse this section';
	var expandIcon = '../../images/exp.gif';
	var expandText = 'Expand this section';
	$('table.collapsible tbody').each(function() {
	  var $section = $(this);
	  $section.addClass('collapsed')
		.find('tr.sub:not(:has(th))')
		.fadeOut('fast', function() {
		  $(this).css('display', 'none');
		});
	  $('<img />').attr('src', expandIcon)
		.attr('alt', collapseText)
		.prependTo($section.find('th'))
		.addClass('clickable')
		.click(function() {
		  if ($section.is('.collapsed')) {
			$section.removeClass('collapsed')
			  .find('tr:not(:has(th)):not(.filtered)')
			  .fadeIn('fast');
			$(this).attr('src', collapseIcon)
			  .attr('alt', collapseText);
		  }
		  else {
			$section.addClass('collapsed')
			  .find('tr:not(:has(th))')
			  .fadeOut('fast', function() {
				$(this).css('display', 'none');
			  });
			$(this).attr('src', expandIcon)
			  .attr('alt', expandText);
		  }
		  $section.parent().trigger('stripe');
		});
	});
	
});

function searchData(){
	$("#frm-search").submit();
}

function chkinput(){
	if($('#ORG_SEQ').val() == ''){
		alert('ระบุ ลำดับหน่วยงาน');
		$('#ORG_SEQ').focus();
		return false;
	}	
	
	if($("#org_year").val() == ""){
		alert("ระบุ ปีที่จัดโครงสร้าง");
		$("#org_year").focus();
		return false;
	}
	
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

	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
                $("#frm").submit();
        }
}

function addData(id,seq){
	$("#proc").val("add");
        $("#org_id1").val(id);
	$("#seq").val(seq);
	$("#frm-search").attr("target","").attr("action","form_senate.php").submit();
}

function editData(id){
   
	$("#proc").val("edit");
	$("#org_id").val(id);
	$("#frm-search").attr("target","").attr("action","form_senate.php").submit();
}
function editData1(id){
   
	$("#proc").val("edit");
	$("#org_id").val(id);
	$("#frm-search").attr("target","").attr("action","form_senate_address.php").submit();
}

function deleteData(id){
	if(confirm("ต้องการลบข้อมูลหรือไม่ ?")){
		$("#proc").val("delete");
		$("#org_id").val(id);
		$("#frm-search").attr("target","").attr("action","process/process_senate.php").submit();
	}
}
function getRampr(id,name_rampr,oncharng){
	var id;
	var val;
	if($('#ADDR_TYPE').val()!=''){
		val=$('#ampr_id'+$('#ADDR_TYPE').val()).val();	
	}else{
		val="";
	}
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"rampr",v_ampr:id.value,z_id:name_rampr,z_name:name_rampr,oncharng:oncharng,val:val,name_tamb:'tamb_id'},
		success : function(data){
			$('#ss_ampr').html(data);
			$("#ampr_id").chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true
				//no_results_text: "No results matched"
			});
			getStamb('ampr_id',$('#ampr_id').val(),'tamb_id');
		}
	});
}
function getStamb(id,val_ampr,name_tamb){
	var id;
	var val;
	if($('#ADDR_TYPE').val()!=''){
		val=$('#tamb_id'+$('#ADDR_TYPE').val()).val();	
	}else{
		val="";
	}
	$.ajax({
		url: "process/select_selationship.php",
		dataType: "html",   
		type: "POST",
		data:{proc:"stamb",v_tamb:val_ampr,z_id:name_tamb,z_name:name_tamb,val:val},
		success : function(data){
			$('#ss_tamb').html(data);
			$("#tamb_id").chosen({//ค้นหา+เลือก select 
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