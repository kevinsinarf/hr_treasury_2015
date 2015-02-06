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
	if($('#proc').val()!='edit'){
			getPosLevel($('#TYPE_ID').val(),'LEVEL_ID');
			 getORG2($('#ORG_ID_2').val(),'ORG_ID_2');
	}
});
function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_servicehis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#SPECHIS_ID").val(id);
	$("#frm-search").attr("action","profile_servicehis_form.php").submit();
}

function chkinput(){
	if($("#CT_ID").val() == ""){
		alert("ระบุ "+$('#CT_ID').attr('placeholder'));
		$("#CT_ID").focus();
		return false;
	}
	if($("#MOVEMENT_ID").val() == ""){
		alert("ระบุ "+$('#MOVEMENT_ID').attr('placeholder'));
		$("#MOVEMENT_ID").focus();
		return false;
	}
	if($("#COM_NO").val() == ""){
		alert("ระบุ "+$('#COM_NO').attr('placeholder'));
		$("#COM_NO").focus();
		return false;
	}
		if($("#COM_DATE").val() == ""){
		alert("ระบุ "+$('#COM_DATE').attr('placeholder'));
		$("#COM_DATE").focus();
		return false;
	}
	if($("#COM_DATE").val() == ""){
		alert("ระบุ "+$('#COM_DATE').attr('placeholder'));
		$("#COM_DATE").focus();
		return false;
	}
	if($("#COM_SDATE").val() == ""){
		alert("ระบุ "+$('#COM_SDATE').attr('placeholder'));
		$("#COM_SDATE").focus();
		return false;
	}
	if($("#SPECIAL_ID").val() == ""){
		alert("ระบุ "+$('#SPECIAL_ID').attr('placeholder'));
		$("#SPECIAL_ID").focus();
		return false;
	}
	if($("#ORG_ID_1").val() == ""){
		alert("ระบุ "+$('#ORG_ID_1').attr('placeholder'));
		$("#ORG_ID_1").focus();
		return false;
	}
	if($("#ORG_ID_2").val() == ""){
		alert("ระบุ "+$('#ORG_ID_2').attr('placeholder'));
		$("#ORG_ID_2").focus();
		return false;
	}
	if($("#ORG_ID_3").val() == ""){
		alert("ระบุ "+$('#ORG_ID_3').attr('placeholder'));
		$("#ORG_ID_3").focus();
		return false;
	}
	if($("#ORG_ID_4").val() == ""){
		alert("ระบุ "+$('#ORG_ID_4').attr('placeholder'));
		$("#ORG_ID_4").focus();
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
	if($("#LG_ID").val() == ""){
		alert("ระบุ "+$('#LG_ID').attr('placeholder'));
		$("#LG_ID").focus();
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
		$("#SPECHIS_ID").val(id);
		$("#frm-search").attr("action","process/profile_servicehis_process.php").submit();
	}
}


function getORG(obj){
	var val = $(obj).val();
	var id_old = $(obj).attr('id').substr(-1);
	var id = parseInt($(obj).attr('id').substr(-1))+1;
	var id_new = $(obj).attr('id').replace(id_old, id);
	var html = "<option value=''></option>";
	$.post('process/profile_servicehis_process.php', {'proc':'get_org', ORG_PARENT_ID:val}, function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
	   });
	   $('#'+id_new).html(html);
	   $('#'+id_new).trigger('liszt:updated');
	},'json');

}
function get_level(e){

	var html = "<option value=''></option>";
	var postype_id = $('#POSTYPE_ID').val();
		$.ajax({
			url: 'process/profile_servicehis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_level",type_id:e.value,postype_id:postype_id},
			success : function(data){ 
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LEVEL_ID').html(html);
				$('#LEVEL_ID').trigger('liszt:updated');
			}
		});
	
}

function get_line_group(e){
	var html = "<option value=''></option>";
	var postype_id = $('#POSTYPE_ID').val();
		$.ajax({
			url: 'process/profile_servicehis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line_group",type_id:e.value,postype_id:postype_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger('liszt:updated');
			}
		});
}

function get_line(e){
	var html = "<option value=''></option>";
	var postype = $('#POSTYPE_ID').val();
	var id = $(e).attr('id');
		$.ajax({
			url: 'process/profile_servicehis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_line",type_id:e.value,postype_id:postype, name:id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger('liszt:updated');
			}
		});
}
function get_manage(e){
	var html = "<option value=''></option>";
	var type_id = $('#TYPE_ID').val();
	var mt_id = $('#MT_ID').val();
		$.ajax({
			url: 'process/profile_servicehis_process.php',
			dataType : 'json',
			type: "POST",
			data:{proc:"get_manage",type_id:type_id,mt_id:mt_id},
			success : function(data){  
				$.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#MANAGE_ID').html(html);
				$('#MANAGE_ID').trigger('liszt:updated');
			}
		});
	
}
function set_pos_now(TYPE_LIVE){
	if(TYPE_LIVE == "1"){
		$("#ss_type_live").show();
	}else{
		$("#ss_type_live").hide();
	}
}

function chk_date(startdate,enddate,startdate_text,enddate_text){
	var chk_sdate=startdate.replace(/0/gi,"").replace(/\//gi,"");
	var chk_edate=enddate.replace(/0/gi,"").replace(/\//gi,"");
	var date1 = startdate;  // '24/11/2010'
	var date2 = enddate; 
	var thisdate=new Date();
	date1 = date1.split("/"); 
	date2 = date2.split("/"); 
	startdate_text = startdate_text==""?"วันที่เริ่มต้น":startdate_text;
	enddate_text = enddate_text==""?"วันที่สิ้นสุด":enddate_text;
	
	if(chk_sdate ==""){
		return false;
	}else{
		sDate = new Date(date1[2]-543,date1[1]-1,date1[0]);  
	}
	
	if(chk_edate ==""){
		return false;
	}else{
		eDate = new Date(date2[2]-543,date2[1]-1,date2[0]);  
	}
	
	if(eDate < sDate){
		alert(enddate_text+" ต้องอยู่หลัง "+startdate_text);	
		return true;
	}else{
		return false;
	}
}

function getPosition(val){
	var url ='process/profile_servicehis_process.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'getPosition',SPECIAL_TYPE:val},
		async: false,
		success: function(data) {
			$('#shw_pos').html(data);
			$("#SPECIAL_ID").chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});
		}
	});
}

function getPosition(val){
	var url ='process/profile_servicehis_process.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'getPosition',SPECIAL_TYPE:val},
		async: false,
		success: function(data) {
			$('#shw_pos').html(data);
			$("#SPECIAL_ID").chosen({//ค้นหา+เลือก select  id
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