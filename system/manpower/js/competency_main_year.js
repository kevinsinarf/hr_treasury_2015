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

function searchData(){
	$("#frm-search").submit();
}

function chkinput(){
	
	if($("#COMSET_YEAR").val() == ""){
		alert("ระบุ "+$('#COMSET_YEAR').attr('placeholder'));
		$("#COMSET_YEAR").focus();
		return false;
	}
	
	if($("#COMTITLE_ID").val() == ""){
		alert("ระบุ "+$('#COMTITLE_ID').attr('placeholder'));
		$("#COMTITLE_ID").focus();
		return false;
	}
	
	if($('#TYPE_ID').val() == ''){
		alert('ระบุ '+$('#TYPE_ID').attr('placeholder'));
		$('#TYPE_ID').focus();
		return false;
	}
	
	if($('#LEVEL_ID').val() == ''){
		alert('ระบุ '+$('#LEVEL_ID').attr('placeholder'));
		$('#LEVEL_ID').focus();
		return false;
	}
	
	if($("#COMSET_EXPECT").val() == ""){
		alert("ระบุ "+$('#COMSET_EXPECT').attr('placeholder'));
		$("#COMSET_EXPECT").focus();
		return false;
	}
	
	if($("#flagDup2").val() == 1){
		alert($('#COMTITLE_ID').attr('placeholder')+"ซ้ำ");
		$("#COMTITLE_ID").focus();
		return false;
	}

	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
        $("#frm").submit();
    }
}

function addData(part_link){
	$("#proc").val("add");
	$("#frm-search").attr("target","").attr("action","competency_main_year_form.php?"+part_link).submit();
}

function editData(id){
   
	$("#proc").val("edit");
	$("#COMSET_ID").val(id);
	$("#frm-search").attr("target","").attr("action","competency_main_year_form.php").submit();
}

function deleteData(id){
	if(confirm("ต้องการลบข้อมูลหรือไม่ ?")){
		$("#proc").val("delete");
		$("#COMSET_ID").val(id);
		$("#frm-search").attr("target","").attr("action","process/competency_main_year_process.php").submit();
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

function ChkLevel(obj){
	var val = $(obj).val();
	var html = '';
	$.post('process/competency_main_year_process.php',{'proc':'ChkLevel', 'TYPE_ID':val}, function(data){
		$.each(data, function(index, val){
			html += "<option value='"+index+"'>"+val+"</option>";	
			
		});
		$('#LEVEL_ID').html(html).trigger('liszt:updated');
	},'json');	
}

function Chkrepeat(){
	
	if($("#COMSET_YEAR").val() == ""){
		alert("กรุณาเลือก ปีที่ใช้สมรรถนะ");
		$("#COMSET_YEAR").focus();
		$('#COMTITLE_ID').val('').trigger('liszt:updated');
		
		return false;
	}
	
	
	chkDup('chkDup2','flagDup2','COMTITLE_ID','COMSET_ID','COMPETENCY_SET',"COMSET_YEAR="+$("#COMSET_YEAR").val());
}
