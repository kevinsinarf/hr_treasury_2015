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
	
	$("span[for*=POSHIS_SDATE]").on("changeDate", function (e){//onchangeDate
		var date_for = $(this).attr("for").replace(/\D/g, '');
		datediff($('#POSHIS_SDATE'+date_for).val(), $('#POSHIS_EDATE'+date_for).val(), date_for);
	});
	
	$("span[for*=POSHIS_EDATE]").on("changeDate", function (e){//onchangeDate
		var date_for = $(this).attr("for").replace(/\D/g, '');
		datediff($('#POSHIS_SDATE'+date_for).val(), $('#POSHIS_EDATE'+date_for).val(), date_for);
	});
	
	$("span[for*=UPS_EFFECTIVE_SDATE]").on("changeDate", function (e){//onchangeDate
		var date_for = $(this).attr("for").replace(/\D/g, '');
		monthdiff($('#UPS_EFFECTIVE_SDATE'+date_for).val(), $('#UPS_EFFECTIVE_EDATE'+date_for).val(), date_for);
	});
	
	$("span[for*=UPS_EFFECTIVE_EDATE]").on("changeDate", function (e){//onchangeDate
		var date_for = $(this).attr("for").replace(/\D/g, '');
		monthdiff($('#UPS_EFFECTIVE_SDATE'+date_for).val(), $('#UPS_EFFECTIVE_EDATE'+date_for).val(), date_for);
	});
});

function getTitle(){
	$.ajax({
		url: "process/gettitle.php",
		type: "POST",
		data:{proc:"getTitle",PREFIX_ID:$('#PREFIX_ID').val()},
		success : function(data){ 
			$('#prefix_en').html(data);
		}
	});
}

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","pension_request_record_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#PENSION_ID").val(id);
	$("#frm-search").attr("action","pension_request_record_form.php").submit();
}

function chkinput(){	
	
	if($("#S_PENSION_IDCARD").val() == ""){
		alert("กรุณาระบุ เลขประจำตัวประชาชน");
		$("#S_PENSION_IDCARD").focus();
		return false;
	}
	if($("#PENSION_TYPE_REQUEST_CIVIL").val() == ""){
		alert("กรุณาระบุ สาเหตุที่ขอบำเหน็จบำนาญ");
		$("#S_PENSION_IDCARD").focus();
		return false;
	}
	if($("#PENSION_TYPE_PENSION").val() == ""){
		alert("กรุณาระบุ ประเภทการขอบำเหน็จบำนาญ");
		$("#PENSION_TYPE_PENSION_chzn").focus();
		return false;
	}
	
	var chk_val = true;
	//ข้อมูลประวัติการรับราชการปกติ mode = 2
	var tb_name = " ข้อมูลประวัติการรับราชการปกติ ";
	var row = 1;
	$("tr[id*=poshis_row_]").each(function(index, element) {
		var key_index = $(this).attr("id").replace(/\D/g,'');
        if($("#POSHIS_ORG_ID2"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_ORG_ID2"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_ORG_ID2"+key_index+"_chzn").focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_ORG_ID3"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_ORG_ID3"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_ORG_ID3"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_ORG_ID4"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_ORG_ID4"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_ORG_ID4"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_NO"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_NO"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_NO"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_TYPE_ID"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_TYPE_ID"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_TYPE_ID"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_LEVEL_ID"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_LEVEL_ID"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_LEVEL_ID"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_LINE_ID"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_LINE_ID"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_LINE_ID"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_MANAGE_ID"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_MANAGE_ID"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_MANAGE_ID"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_SDATE"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_SDATE"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_SDATE"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_EDATE"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_EDATE"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_EDATE"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_YEAR"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_YEAR"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_YEAR"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_MONTH"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_MONTH"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_MONTH"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#POSHIS_DAY"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic2').toggle();
				$("#collapse2").attr("class", "in");
				$("#collapse2").css('height', 'auto'); 
				$("#collapse2").css('overflowY', 'auto'); 
				$("#collapse2").show();
			}
			alert("กรุณาระบุ "+$("#POSHIS_DAY"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#POSHIS_DAY"+key_index).focus();
			return chk_val = false;
		}
		row++;
    });
	if(!chk_val){return false;}
	
	tb_name = " ข้อมูลประวัติการรับราชการเวลาทวีคูณ ";
	row = 1;
	$("tr[id*=multi_row_]").each(function(index, element) {
		var key_index = $(this).attr("id").replace(/\D/g,'');
        if($("#MULTIME_ID"+key_index).val() == ""){
			if($("#collapse2").attr("class") == "collapse"){
				$('.switchPic3').toggle();
				$("#collapse3").attr("class", "in");
				$("#collapse3").css('height', 'auto'); 
				$("#collapse3").css('overflowY', 'auto'); 
				$("#collapse3").show();
			}
			alert("กรุณาระบุ "+$("#MULTIME_ID"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#MULTIME_ID"+key_index).focus();
			return chk_val = false;
		}
		row++;
    });
	if(!chk_val){return false;}
	
	tb_name = " ข้อมูลประวัติการรับราชการปกติ ";
	row = 1;
	$("tr[id*=poshis_row_]").each(function(index, element) {
		var key_index = $(this).attr("id").replace(/\D/g,'');
        if($("#UPS_EFFECTIVE_SDATE"+key_index).val() == ""){
			if($("#collapse5").attr("class") == "collapse"){
				$('.switchPic5').toggle();
				$("#collapse5").attr("class", "in");
				$("#collapse5").css('height', 'auto'); 
				$("#collapse5").css('overflowY', 'auto'); 
				$("#collapse5").show();
			}
			alert("กรุณาระบุ "+$("#UPS_EFFECTIVE_SDATE"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#UPS_EFFECTIVE_SDATE"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#UPS_EFFECTIVE_EDATE"+key_index).val() == ""){
			if($("#collapse5").attr("class") == "collapse"){
				$('.switchPic5').toggle();
				$("#collapse5").attr("class", "in");
				$("#collapse5").css('height', 'auto'); 
				$("#collapse5").css('overflowY', 'auto'); 
				$("#collapse5").show();
			}
			alert("กรุณาระบุ "+$("#UPS_EFFECTIVE_EDATE"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#UPS_EFFECTIVE_EDATE"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#UPS_MONTH"+key_index).val() == ""){
			if($("#collapse5").attr("class") == "collapse"){
				$('.switchPic5').toggle();
				$("#collapse5").attr("class", "in");
				$("#collapse5").css('height', 'auto'); 
				$("#collapse5").css('overflowY', 'auto'); 
				$("#collapse5").show();
			}
			alert("กรุณาระบุ "+$("#UPS_MONTH"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#UPS_MONTH"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#UPS_SALARY"+key_index).val() == ""){
			if($("#collapse5").attr("class") == "collapse"){
				$('.switchPic5').toggle();
				$("#collapse5").attr("class", "in");
				$("#collapse5").css('height', 'auto'); 
				$("#collapse5").css('overflowY', 'auto'); 
				$("#collapse5").show();
			}
			alert("กรุณาระบุ "+$("#UPS_SALARY"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#UPS_SALARY"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#UPS_CASH"+key_index).val() == ""){
			if($("#collapse5").attr("class") == "collapse"){
				$('.switchPic5').toggle();
				$("#collapse5").attr("class", "in");
				$("#collapse5").css('height', 'auto'); 
				$("#collapse5").css('overflowY', 'auto'); 
				$("#collapse5").show();
			}
			alert("กรุณาระบุ "+$("#UPS_CASH"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#UPS_CASH"+key_index).focus();
			return chk_val = false;
		}
		
		if($("#UPS_PLUS"+key_index).val() == ""){
			if($("#collapse5").attr("class") == "collapse"){
				$('.switchPic5').toggle();
				$("#collapse5").attr("class", "in");
				$("#collapse5").css('height', 'auto'); 
				$("#collapse5").css('overflowY', 'auto'); 
				$("#collapse5").show();
			}
			alert("กรุณาระบุ "+$("#UPS_PLUS"+key_index).attr("placeholder")+" แถวที่ "+row+tb_name);
			$("#UPS_PLUS"+key_index).focus();
			return chk_val = false;
		}
		row++;
    });
	if(!chk_val){return false;}
	
	if($("#PENSION_RECEIVE_IDCARDS").val() == ""){
		alert("กรุณาระบุ เลขประจำตัวประชาชนผู้ติดต่อรับบำเหน็จบำนาญ");
		$("#PENSION_RECEIVE_IDCARDS").focus();
		return false;
	}else{
		if(!checkID($('#PENSION_RECEIVE_IDCARDS').val())){ 
			alert('เลขประจำตัวประชาชนไม่ถูกต้อง กรุณาตรวจสอบ'); 
			$("#PENSION_RECEIVE_IDCARDS").focus();
			return false;
		}
	}
	if($("#PENSION_RECEIVE_PREFIX").val() == ""){
		alert("กรุณาระบุ คำนำหน้าชื่อ");
		$("#PENSION_RECEIVE_PREFIX").focus();
		return false;
	}
	if($("#PENSION_RECEIVE_FIRSTNAME_TH").val() == ""){
		alert("กรุณาระบุ ชื่อตัว");
		$("#PENSION_RECEIVE_FIRSTNAME_TH").focus();
		return false;
	}	
	if($("#PENSION_RECEIVE_LASTNAME_TH").val() == ""){
		alert("กรุณาระบุ ชื่อสกุล");
		$("#PENSION_RECEIVE_LASTNAME_TH").focus();
		return false;
	}
	if($('#PENSION_BANK_ID').val() == ''){
		alert('ระบ ธนาคาร');
		$('#PENSION_BANK_ID').focus();
		return false;
	}
	if($("#PENSION_BANK_BRANCH").val() == ""){
		alert("กรุณาระบุ สาขา");
		$("#PENSION_BANK_BRANCH").focus();
		return false;
	}
	if($("#PENSION_BANK_NO").val() == ""){
		alert("กรุณาระบุ เลขที่บัญชี");
		$("#PENSION_BANK_NO").focus();
		return false;
	}
	if($("#PENSION_BANK_NAME").val() == ""){
		alert("กรุณาระบุ ชื่อบัญชี");
		$("#PENSION_BANK_NAME").focus();
		return false;
	}
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$('#frm-input').attr('action', 'process/pension_request_record_process.php');
		$("#frm-input").submit();
	}
}

function delData(id, PER_ID){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#PENSION_ID").val(id);
		$('#PER_ID').val(PER_ID);
		$("#frm-search").attr("action","process/pension_request_record_process.php").submit();
	}
}

function clrContact(val){
	if(val == 1){
		if($('#proc').val() == 'add'){
			$('#PENSION_RECEIVE_IDCARDS').val($('#S_PENSION_IDCARD').val());
			$('#PENSION_RECEIVE_PREFIX').val($('#O_PENSION_RECEIVE_PREFIX').val());
			$('#PENSION_RECEIVE_FIRSTNAME_TH').val($('#O_PENSION_RECEIVE_FIRSTNAME_TH').val());
			$('#PENSION_RECEIVE_MIDNAME_TH').val($('#O_PENSION_RECEIVE_MIDNAME_TH').val());
			$('#PENSION_RECEIVE_LASTNAME_TH').val($('#O_PENSION_RECEIVE_LASTNAME_TH').val());
		}else if($('#proc').val() == 'edit'){
			$('#PENSION_RECEIVE_IDCARDS').val($('#S_PENSION_IDCARD').val());
			$('#PENSION_RECEIVE_PREFIX').val($('#O_PREFIX').val());
			$('#PENSION_RECEIVE_FIRSTNAME_TH').val($('#O_FIRSTNAME_TH').val());
			$('#PENSION_RECEIVE_MIDNAME_TH').val($('#O_MIDNAME_TH').val());
			$('#PENSION_RECEIVE_LASTNAME_TH').val($('#O_LASTNAME_TH').val());
		}
	}else if(val == 2){
		$('#PENSION_RECEIVE_IDCARDS').val('');
		$('#PENSION_RECEIVE_PREFIX').val('');
		$('#PENSION_RECEIVE_FIRSTNAME_TH').val('');
		$('#PENSION_RECEIVE_MIDNAME_TH').val('');
		$('#PENSION_RECEIVE_LASTNAME_TH').val('');
	}	
}

function getcountry(id){
	if(id==$('#default_country_id').val()){
		$('#country_del1').hide();
		$('#country_del2').show();
	}else{
		$('#country_del2').hide();
		$('#country_del1').show();
	}
}

function getRampr(id,name_rampr,name_tamb){	
	val=$('#'+name_rampr).val();	
	$.ajax({
		url: "process/select_selationship.php",
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
		url: "process/select_selationship.php",
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

function add_row_pos(){
	//เพิ่ม row javascript	
	var table = document.getElementById('poshis_tbdata');
	var rowCount = (table.rows.length) - 1;
	var tbInsertRow = table.insertRow(rowCount);
	
	var row_index = parseInt($("#ROW_COUNT_POSHIS").val())+1;
	tbInsertRow.id = "poshis_row_"+row_index;
	tbInsertRow.style.background = "#FFFFFF";
	
	for(var i = 0 ; i < 10 ; i++){
		tbInsertRow.insertCell(i);		
	}
	
	// ปุ่มลบ
	tbInsertRow.cells[0].innerHTML = "<a class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"remove_row('poshis_row_"+row_index+"');\" >"+img_del+" ลบ</a>";
	
	//สังกัด
	tbInsertRow.cells[1].id = "td2_row"+row_index;
	getORG(2,'','POSHIS_ORG_ID','sp_org','POSHIS_ORG_ID',row_index);
	
	//เลขที่ตำแหน่ง
	tbInsertRow.cells[2].innerHTML = "<input type=\"text\" id=\"POSHIS_NO"+row_index+"\" name=\"POSHIS_NO"+row_index+"\" class=\"form-control\"  placeholder=\"เลขที่ตำแหน่ง\" style=\"text-align:right\" maxlength=\"10\" >";
	
	//ข้อมูลตำแหน่ง
	tbInsertRow.cells[3].id = "td4_row"+row_index;
	getPOS(row_index);
	
	//วันที่เริ่มต้น
	tbInsertRow.cells[4].innerHTML +="<div class=\"input-group\"><input type=\"text\" id=\"POSHIS_SDATE"+row_index+"\" name=\"POSHIS_SDATE"+row_index+"\" class=\"form-control date\" placeholder=\"DD/MM/YYYY\" maxlength=\"10\" value=\"\" style=\"width:100px\" readonly ><span class=\"input-group-addon datepicker_pos\" for=\"POSHIS_SDATE"+row_index+"\" >&nbsp;<span class=\"glyphicon glyphicon-calendar\" ></span>&nbsp;</span></div>";
	
	//วันที่สิ้นสุด
	tbInsertRow.cells[5].innerHTML +="<div class=\"input-group\"><input type=\"text\" id=\"POSHIS_EDATE"+row_index+"\" name=\"POSHIS_EDATE"+row_index+"\" class=\"form-control date\" placeholder=\"DD/MM/YYYY\" maxlength=\"10\" value=\"\" style=\"width:100px\" readonly><span class=\"input-group-addon datepicker_pos\" for=\"POSHIS_EDATE"+row_index+"\" >&nbsp;<span class=\"glyphicon glyphicon-calendar\"></span>&nbsp;</span></div>";
	
	$(".datepicker_pos").each(function() {//ปฏิทิน
		var date_for = $(this).attr("for");
		$('span[for='+date_for+']').attr('data-date', $('#'+date_for).val());
		
		$("span[for="+date_for+"]").datepicker({
			showOn: "button",
			language: "th-th"
		});
		$("span[for="+date_for+"]").on("changeDate", function (e){//onchangeDate
			$('#'+date_for).val(e.format('dd/mm/yyyy'));
			$('span[for='+date_for+']').datepicker('hide');
			datediff($('#POSHIS_SDATE'+date_for.replace(/\D/g, '')).val(), $('#POSHIS_EDATE'+date_for.replace(/\D/g, '')).val(), date_for.replace(/\D/g, ''));
		});
		$("#"+date_for).on("keyup", function (e){//onkeyup
			beginchk(this,e,this.id);
		});
	});
	
	//ปี
	tbInsertRow.cells[6].innerHTML = "<input type=\"text\" id=\"POSHIS_YEAR"+row_index+"\" name=\"POSHIS_YEAR"+row_index+"\" class=\"form-control\"  placeholder=\"ปี\" style=\"text-align:right\" >";
	
	//เดือน
	tbInsertRow.cells[7].innerHTML = "<input type=\"text\" id=\"POSHIS_MONTH"+row_index+"\" name=\"POSHIS_MONTH"+row_index+"\" class=\"form-control\"  placeholder=\"เดือน\" style=\"text-align:right\" >";
	
	//วัน
	tbInsertRow.cells[8].innerHTML = "<input type=\"text\" id=\"POSHIS_DAY"+row_index+"\" name=\"POSHIS_DAY"+row_index+"\" class=\"form-control\"  placeholder=\"วัน\" style=\"text-align:right\" >";
	
	//แนบไฟล์
	tbInsertRow.cells[9].innerHTML = "<input type='file' id='POSHIS_FILE"+row_index+"' name='POSHIS_FILE"+row_index+"' maxlength='100' class='' placeholder='แนบไฟล์' style='width:80px' >";
	
	$("#ROW_COUNT_POSHIS").val(row_index);
}

function add_row_multi(){
	//เพิ่ม row javascript	
	var table = document.getElementById('multi_tbdata');
	var rowCount = (table.rows.length) - 1;
	var tbInsertRow = table.insertRow(rowCount);
	
	var row_index = parseInt($("#ROW_COUNT_MULTI").val())+1;
	tbInsertRow.id = "row_"+row_index;
	tbInsertRow.style.background = "#FFFFFF";
	
	for(var i = 0 ; i < 8 ; i++){
		tbInsertRow.insertCell(i);		
	}
	
	tbInsertRow.align = "center";
	tbInsertRow.cells[1].align = "left";
	
	// ปุ่มลบ
	tbInsertRow.cells[0].innerHTML = "<a class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"remove_row('row_"+row_index+"');\" >"+img_del+" ลบ</a>";
	
	//คำอธิบาย
	var url ='process/select_selationship.php';
	var data = {proc : 'get_multi', parent_id : '', z_id : 'MULTIME_ID', z_name : 'MULTIME_ID', z_class : 'selectbox form-control', onchange : '', span_id : '', key_index : row_index, mode : 'json'};
	$.ajax({
		url:url,
		type: "POST",
		dataType:"json",
		data:data,
		success: function(data){
			tbInsertRow.cells[1].innerHTML = data.selectbox;
			
			$("#MULTIME_ID"+data.key_index).attr('title','สามารถค้นหาและเลือกข้อมูลได้');
			$("#MULTIME_ID"+data.key_index).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true,
				no_results_text: "No results matched"
			})
		}
	});
	
	//วันที่เริ่มต้น
	tbInsertRow.cells[2].innerHTML ="<label id='LABEL_MULTIME_SDATE"+row_index+"' class='' ></label><input type='hidden' id='MULTIME_SDATE"+row_index+"' name='MULTIME_SDATE"+row_index+"' class='form-control' maxlength='10' >";
	
	//วันที่สิ้นสุด
	tbInsertRow.cells[3].innerHTML ="<label id='LABEL_MULTIME_EDATE"+row_index+"' class='' ></label><input type='hidden' id='MULTIME_EDATE"+row_index+"' name='MULTIME_EDATE"+row_index+"' class='form-control' maxlength='10' >";
	
	//ปี
	tbInsertRow.cells[4].innerHTML = "<label id='LABEL_MULTITIME_YEAR"+row_index+"' class='' ></label><input type='hidden' id='MULTITIME_YEAR"+row_index+"' name='MULTITIME_YEAR"+row_index+"' class='form-control' maxlength='10' >";
	
	//เดือน
	tbInsertRow.cells[5].innerHTML = "<label id='LABEL_MULTITIME_MONTH"+row_index+"' class='' ></label><input type='hidden' id='MULTITIME_MONTH"+row_index+"' name='MULTITIME_MONTH"+row_index+"' class='form-control' maxlength='10' >";
	
	//วัน
	tbInsertRow.cells[6].innerHTML = "<label id='LABEL_MULTITIME_DAY"+row_index+"' class='' ></label><input type='hidden' id='MULTITIME_DAY"+row_index+"' name='MULTITIME_DAY"+row_index+"' class='form-control' maxlength='10' >";
	
	//แนบไฟล์
	tbInsertRow.cells[7].innerHTML = "<input type='file' id='MULTI_FILE"+row_index+"' name='MULTI_FILE"+row_index+"' maxlength='100' class='' placeholder='แนบไฟล์' style='width:80px' >";
	
	$("#ROW_COUNT_MULTI").val(row_index);
}

function add_row_upsalary(){
	//เพิ่ม row javascript	
	var table = document.getElementById('upsalary_tbdata');
	var rowCount = (table.rows.length) - 8;
	var tbInsertRow = table.insertRow(rowCount);
	
	var row_index = parseInt($("#ROW_COUNT_UPSALARY").val())+1;
	tbInsertRow.id = "poshis_row_"+row_index;
	tbInsertRow.style.background = "#FFFFFF";
	
	for(var i = 0 ; i < 9 ; i++){
		tbInsertRow.insertCell(i);		
	}
	
	tbInsertRow.align = "center";
	
	// ปุ่มลบ
	tbInsertRow.cells[0].innerHTML = "<a class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"remove_row('poshis_row_"+row_index+"');\" >"+img_del+" ลบ</a>";
	
	//วันที่เริ่มต้น
	tbInsertRow.cells[1].innerHTML +="<div class=\"input-group\" style=\"width:100px\"><input type=\"text\" id=\"UPS_EFFECTIVE_SDATE"+row_index+"\" name=\"UPS_EFFECTIVE_SDATE"+row_index+"\" class=\"form-control date\" placeholder=\"DD/MM/YYYY\" maxlength=\"10\" value=\"\" style=\"width:100px\" readonly ><span class=\"input-group-addon datepicker_ups\" for=\"UPS_EFFECTIVE_SDATE"+row_index+"\" >&nbsp;<span class=\"glyphicon glyphicon-calendar\" ></span>&nbsp;</span></div>";
	
	//วันที่สิ้นสุด
	tbInsertRow.cells[2].innerHTML +="<div class=\"input-group\" style=\"width:100px\"><input type=\"text\" id=\"UPS_EFFECTIVE_EDATE"+row_index+"\" name=\"UPS_EFFECTIVE_EDATE"+row_index+"\" class=\"form-control date\" placeholder=\"DD/MM/YYYY\" maxlength=\"10\" value=\"\" style=\"width:100px\" readonly><span class=\"input-group-addon datepicker_ups\" for=\"UPS_EFFECTIVE_EDATE"+row_index+"\" >&nbsp;<span class=\"glyphicon glyphicon-calendar\"></span>&nbsp;</span></div>";
	
	$(".datepicker_ups").each(function() {//ปฏิทิน
		var date_for = $(this).attr("for");
		$('span[for='+date_for+']').attr('data-date', $('#'+date_for).val());
		
		$("span[for="+date_for+"]").datepicker({
			showOn: "button",
			language: "th-th"
		});
		$("span[for="+date_for+"]").on("changeDate", function (e){//onchangeDate
			$('#'+date_for).val(e.format('dd/mm/yyyy'));
			$('span[for='+date_for+']').datepicker('hide');
			monthdiff($('#UPS_EFFECTIVE_SDATE'+date_for.replace(/\D/g, '')).val(), $('#UPS_EFFECTIVE_EDATE'+date_for.replace(/\D/g, '')).val(), date_for.replace(/\D/g, ''));
		});
		$("#"+date_for).on("keyup", function (e){//onkeyup
			beginchk(this,e,this.id);
		});
	});
	
	//จำนวนเดือน
	tbInsertRow.cells[3].innerHTML = "<input type=\"text\" id=\"UPS_MONTH"+row_index+"\" name=\"UPS_MONTH"+row_index+"\" class=\"form-control\"  placeholder=\"จำนวนเดือน\" style=\"text-align:right\" onkeyup=\"chkFormatNam(this.value, this.id);get_salary('"+row_index+"')\">";
	
	//เงินเดือน
	tbInsertRow.cells[4].innerHTML = "<input type=\"text\" id=\"UPS_SALARY"+row_index+"\" name=\"UPS_SALARY"+row_index+"\" class=\"form-control\"  placeholder=\"เงินเดือน\" style=\"text-align:right\" onkeyup=\"chkFormatNam(this.value, this.id);get_salary('"+row_index+"')\">";
	
	//เงินสด
	tbInsertRow.cells[5].innerHTML = "<input type=\"text\" id=\"UPS_CASH"+row_index+"\" name=\"UPS_CASH"+row_index+"\" class=\"form-control\"  placeholder=\"เงินสด\" style=\"text-align:right\" onkeyup=\"chkFormatNam(this.value, this.id);get_salary('"+row_index+"')\">";
	
	//เงินเพิ่ม
	tbInsertRow.cells[6].innerHTML = "<input type=\"text\" id=\"UPS_PLUS"+row_index+"\" name=\"UPS_PLUS"+row_index+"\" class=\"form-control\"  placeholder=\"เงินเพิ่ม\" style=\"text-align:right\" onkeyup=\"chkFormatNam(this.value, this.id);get_salary('"+row_index+"')\">";
	
	//เป็นเงิน
	tbInsertRow.cells[7].innerHTML = "<label id=\"UPS_TOTAL"+row_index+"\" ></label>";
	
	//แนบไฟล์
	tbInsertRow.cells[8].innerHTML = "<input type='file' id='UPS_FILE"+row_index+"' name='UPS_FILE"+row_index+"' maxlength='100' class='' placeholder='แนบไฟล์' style='width:80px' >";
	
	$("#ROW_COUNT_UPSALARY").val(row_index);
}

function remove_row(id){
	$('#'+id).remove();
}

function getORG(org, value, id, span_id, onchange_id, key_index){
	var url ='process/select_selationship.php';
	var data = {proc : 'getOrg', org : org, parent_id:'',z_id : id, z_name : id, z_class:'selectbox form-control',onchange : onchange_id, span_id : span_id, key_index : key_index};
	$.ajax({
		url:url, 
		type:"POST",
		dataType:"json",
		data:data
	}).done(function(data){
		$("#td2_row"+key_index).html($("#td2_row"+key_index).html()+"<div class=\'row\'><span id='"+span_id+data.org+data.key_index+"' >"+data.selectbox+"</span></div>");
		
		if(org < 4){
			getORG(parseInt(org) + 1, '', id, span_id, onchange_id, key_index)
		}else{
			$("select[id*="+id+"]").each(function() {//selectbox
				$('#'+$(this).attr('id')).attr('title','สามารถค้นหาและเลือกข้อมูลได้');
				$("#"+$(this).attr('id')).chosen({//ค้นหา+เลือก select 
					allow_single_deselect: true,
					no_results_text: "No results matched"
				});
			});	
		}
	});	
}

function changeORG(org, value, id, span_id, onchange_id, key_index){
	var url ='process/select_selationship.php';
	var data = {proc : 'getOrg', org : org, parent_id:value,z_id : id, z_name : id, z_class:'selectbox form-control',onchange : onchange_id, span_id : span_id, key_index : key_index};
	$.ajax({
		url:url, 
		type:"POST",
		dataType:"json",
		data:data,
		success: function(data){
			$("#"+span_id+org+key_index).html(data.selectbox);
				$('#'+id+org+key_index).attr('title','สามารถค้นหาและเลือกข้อมูลได้');
				$("#"+id+org+key_index).chosen({//ค้นหา+เลือก select 
					allow_single_deselect: true,
					no_results_text: "No results matched"
				});
			}
	});
}

function getPOS(key_index){
	var url ='process/select_selationship.php';
	//ประเภทตำแหน่ง
	var data = {proc:'pos_type',PARENT_ID:'',POSTYPE_ID:$('#POSTYPE_ID').val(),z_id:'POSHIS_TYPE_ID',z_name:'POSHIS_TYPE_ID',z_class:'selectbox form-control', key_index : key_index};
	
	$.post(url, data, function(data){
		$("#td4_row"+key_index).html($("#td4_row"+key_index).html()+"<div class='row' ><span id='' >"+data+"</span></div>");
		
		//ระดับตำแหน่ง
		data = {proc:'pos_level',PARENT_ID:'',POSTYPE_ID:$('#POSTYPE_ID').val(),z_id:'POSHIS_LEVEL_ID',z_name:'POSHIS_LEVEL_ID',z_class:'selectbox form-control', key_index : key_index};
		$.post(url, data, function(data){
			$("#td4_row"+key_index).html($("#td4_row"+key_index).html()+"<div class='row' ><span id='ss_pos_level"+key_index+"' >"+data+"</span></div>");
			
			//ตำแหน่งในสายงาน
			data = {proc:'get_line',PARENT_ID:'',POSTYPE_ID:$('#POSTYPE_ID').val(),z_id:'POSHIS_LINE_ID',z_name:'POSHIS_LINE_ID',z_class:'selectbox form-control', key_index : key_index};
			$.post(url, data, function(data){
				$("#td4_row"+key_index).html($("#td4_row"+key_index).html()+"<div class='row' ><span id='ss_pos_line"+key_index+"' >"+data+"</span></div>");
				
				//ตำแหน่งในการบริหาร
				data = {proc:'pos_manage',PARENT_ID:'',POSTYPE_ID:$('#POSTYPE_ID').val(),z_id:'POSHIS_MANAGE_ID',z_name:'POSHIS_MANAGE_ID',z_class:'selectbox form-control', key_index : key_index};
				$.post(url, data, function(data){
					$("#td4_row"+key_index).html($("#td4_row"+key_index).html()+"<div class='row' ><span id='ss_pos_manage"+key_index+"' >"+data+"</span></div>");
					
					$(".selectbox").each(function() {//selectbox
						$('#'+$(this).attr('id')).attr('title','สามารถค้นหาและเลือกข้อมูลได้');
						$("#"+$(this).attr('id')).chosen({//ค้นหา+เลือก select 
							allow_single_deselect: true,
							no_results_text: "No results matched"
						});
					});	
				});
			});
		});
	});
}

function getPosLevel(value, POSTYPE_ID, key_index){
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'pos_level',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'POSHIS_LEVEL_ID',z_name:'POSHIS_LEVEL_ID',z_class:'selectbox form-control', key_index:key_index},
		async: false,
		success: function(data) {
			$('#ss_pos_level'+key_index).html(data);
			$("#POSHIS_LEVEL_ID"+key_index).chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});
		}
	});
}

function getPosLine(value, POSTYPE_ID, key_index){
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'get_line',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'POSHIS_LINE_ID',z_name:'POSHIS_LINE_ID',z_class:'selectbox form-control', key_index:key_index},
		async: false,
		success: function(data) {
			$('#ss_pos_line'+key_index).html(data);
			$("#POSHIS_LINE_ID"+key_index).chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});
		}
	});
}

function getPosManage(value,POSTYPE_ID, key_index){
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'pos_manage',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'POSHIS_MANAGE_ID',z_name:'POSHIS_MANAGE_ID',z_class:'selectbox form-control', key_index:key_index},
		async: false,
		success: function(data) {
			$('#ss_pos_manage'+key_index).html(data);
			$("#POSHIS_MANAGE_ID"+key_index).chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});
		}
	});
}

function get_multi_data(val, key_index){
	var url ='process/select_selationship.php';
	var data = {proc : 'get_multi_data', parent_id : '', z_val : val, z_id : '', z_name : '', z_class : '', onchange : '', span_id : '', key_index : key_index};
	$.ajax({
		url:url,
		type: "POST",
		dataType:"json",
		data:data,
		success: function(data){
			$('#LABEL_MULTIME_SDATE'+key_index).html(data.sdate_short == null || data.sdate_short == ""?"-":data.sdate_short);
			$('#LABEL_MULTIME_EDATE'+key_index).html(data.edate_short == null || data.edate_short == ""?"-":data.edate_short);
			$('#LABEL_MULTITIME_YEAR'+key_index).html(data.year == null || data.year == ""?"-":data.year);
			$('#LABEL_MULTITIME_MONTH'+key_index).html(data.month == null || data.month == ""?"-":data.month);
			$('#LABEL_MULTITIME_DAY'+key_index).html(data.day == null || data.day == ""?"-":data.day);
			
			$('#MULTIME_SDATE'+key_index).val(data.sdate);
			$('#MULTIME_EDATE'+key_index).val(data.edate);
			$('#MULTITIME_YEAR'+key_index).val(data.year);
			$('#MULTITIME_MONTH'+key_index).val(data.month);
			$('#MULTITIME_DAY'+key_index).val(data.day);
		}
	});
}

function get_salary(key_index){
	var total_month = parseInt($("#UPS_MONTH"+key_index).val() == ""?0:$("#UPS_MONTH"+key_index).val());
	var salary = parseFloat($("#UPS_SALARY"+key_index).val() == ""?0:$("#UPS_SALARY"+key_index).val());
	var cash = parseFloat($("#UPS_CASH"+key_index).val() == ""?0:$("#UPS_CASH"+key_index).val());
	var plus = parseFloat($("#UPS_PLUS"+key_index).val() == ""?0:$("#UPS_PLUS"+key_index).val());
	
	$("#UPS_TOTAL"+key_index).html(number_format_return((salary * total_month) + cash + plus, 2));
}

function monthdiff(startdate,enddate,key_index){	
	var chk_sdate=startdate.replace(/0/gi,"").replace(/\//gi,"");
	var chk_edate=enddate.replace(/0/gi,"").replace(/\//gi,"");
	var date1 = startdate;  // '24/11/2010'
	var date2 = enddate; 
	var thisdate=new Date();
	date1 = date1.split("/"); 
	date2 = date2.split("/"); 
	
	if(chk_sdate ==""){
		sDate = new Date(thisdate.getFullYear(),thisdate.getMonth(),thisdate.getDate());  
	}else{
		sDate = new Date(date1[2]-543,date1[1]-1,date1[0]);  
	}
	
	if(chk_edate ==""){
		eDate = new Date(thisdate.getFullYear(),thisdate.getMonth(),thisdate.getDate());  
	}else{
		eDate = new Date(date2[2]-543,date2[1]-1,date2[0]);  
	}
	
	var daysDiff = Math.round((eDate-sDate)/86400000); 
	
	$("#UPS_MONTH"+key_index).val(parseInt(daysDiff/30));
	
	get_salary(key_index);
}

function datediff(startdate,enddate,key_index){
	var chk_sdate=startdate.replace(/0/gi,"").replace(/\//gi,"");
	var chk_edate=enddate.replace(/0/gi,"").replace(/\//gi,"");
	var date1 = startdate;  // '24/11/2010'
	var date2 = enddate; 
	var thisdate=new Date();
	date1 = date1.split("/"); 
	date2 = date2.split("/"); 
	
	if(chk_sdate ==""){
		sDate = new Date(thisdate.getFullYear(),thisdate.getMonth(),thisdate.getDate());  
	}else{
		sDate = new Date(date1[2]-543,date1[1]-1,date1[0]);  
	}
	
	if(chk_edate ==""){
		eDate = new Date(thisdate.getFullYear(),thisdate.getMonth(),thisdate.getDate());  
	}else{
		eDate = new Date(date2[2]-543,date2[1]-1,date2[0]);  
	}
	
	var daysDiff = Math.round((eDate-sDate)/86400000); 
	if(daysDiff == 0){
		$("#POSHIS_YEAR"+key_index).val('0');
		$("#POSHIS_MONTH"+key_index).val('0');
		$("#POSHIS_DAY"+key_index).val('1');
		return false;
	}
	
	years = 0; months = 0; days = 0;
	years = parseInt(daysDiff/365);
	if((daysDiff%365) != 0){
		months = parseInt((daysDiff-(years*365))/30);
	}
	days = (daysDiff - ((years*365) + (months*30)));
	
	$("#POSHIS_YEAR"+key_index).val(years);
	$("#POSHIS_MONTH"+key_index).val(months);
	$("#POSHIS_DAY"+key_index).val(days);
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