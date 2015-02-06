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
function score_type(id){
	$("#SCORE_TYPE").val(id);
	$("#frm-search").submit();
}
function searchData(){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	if($('#S_ORG3').val() == ''){
		alert('สำนัก/กลุ่ม');
		$('#S_ORG3').focus();
		return false;
	}
	
	$("#page").val(1);
	$('#proc').val('search');
	$("#frm-search").submit();
}

function add_row(id){
	var x = '';
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	if($('#S_ORG3').val() == ''){
		alert('สำนัก/กลุ่ม');
		$('#S_ORG3').focus();
		return false;
	}
	
	if($('#S_SCORE_TYPE').val() == ''){
		alert('ระบุ ประเภท');
		$('#S_SCORE_TYPE').focus();
		return false;
	}
	
	var table = document.getElementById('tb_data');
	var rowCount = (table.rows.length);
	var row = table.insertRow(rowCount);
	var id_tb = rowCount+"A"+parseInt((Math.random()*10)+1);

	table.rows[rowCount].id = id_tb;
	table.rows[rowCount].style.background = "#FFFFFF";
	var j =0;

	for(var i = 0;i<5;i++){
		table.rows[rowCount].insertCell(i);		
	}
		
	// JQUERY POST DATA
	var url = "process/set_level_salary1_process.php";
	var html ="<option value='' ></option>";
	var txt_sel  = "<div style='text-align:left; width:105px;'><select name='LV_SCORE_ID[]' id='LV_SCORE_ID_"+id_tb+"' placeholder='เลือกระดับ' class='selectbox form-control' style='width:100px;'>";
		 txt_sel += "</select></div>";
 
	//END 
	
	table.rows[rowCount].cells[0].align="center";
	table.rows[rowCount].cells[1].align="center";
	table.rows[rowCount].cells[2].align="center";
	table.rows[rowCount].cells[3].align="center";
	table.rows[rowCount].cells[4].align="center";
	
	table.rows[rowCount].cells[0].innerHTML=""+(rowCount);
	
	//ระดับ
	$.post(url,{proc: 'getLevel',id_tb: id_tb},function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"' >"+val['VALUE']+"</option>";
		});
		$('#LV_SCORE_ID_'+id_tb).html(html);
	    $('#LV_SCORE_ID_'+id_tb).trigger('liszt:updated');
	},'json');
	table.rows[rowCount].cells[1].innerHTML=""+txt_sel+"";
	$('#LV_SCORE_ID_'+id_tb).chosen({allow_single_deselect: true});
	
	if(id==1||id==3){
		if(id==1){
			x=' -';
		}else{ x=','; }
		var score_type = x+"<input type=\"text\" id=\"PERCENT_SAL_E"+id_tb+"\" name=\"PERCENT_SAL_E[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:100px;display:inline; text-align:center;\" onBlur=\"NumberFormat(this,2)\" onKeyUp=\"chkFormatNam_id(this.value,this.id);\" >";
	}else{
		var score_type = "";
	}
	table.rows[rowCount].cells[2].innerHTML="<input type=\"text\" id=\"SCORE_S_"+id_tb+"\" name=\"SCORE_S[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:100px;display:inline; text-align:center;\" onBlur=\"NumberFormat(this,2)\" onKeyUp=\"chkFormatNam_id(this.value,this.id);\" >-<input type=\"text\" id=\"SCORE_E_"+id_tb+"\" name=\"SCORE_E[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:100px;display:inline; text-align:center;\" onBlur=\"NumberFormat(this,2)\" onKeyUp=\"chkFormatNam_id(this.value,this.id);\" >";
	table.rows[rowCount].cells[3].innerHTML="<input type=\"text\" id=\"PERCENT_SAL_"+id_tb+"\" name=\"PERCENT_SAL[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:100px;display:inline; text-align:center;\" onBlur=\"NumberFormat(this,2)\" onKeyUp=\"chkFormatNam_id(this.value,this.id);\" >"+score_type;
	table.rows[rowCount].cells[4].innerHTML="<a  class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"remove_id('"+id_tb+"');\" >"+img_del+" ลบ</a> ";
	$(".number").keyup(function() {//Can Be {0-9}
  		check_number($(this).val(), $(this).attr('id'));
	});
}

function remove_id(id){
	$('#'+id).remove();
}

function chkinput(type_save){
	var err1=0;
	var err2=0;
	var err3=0;
	var err4=0;
	var table = document.getElementById('tb_data');
	var rowCount = (table.rows.length);	
	
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	
	if($('#S_ORG3').val() == ''){
		alert('เลือก กอง/สำนัก/กลุ่ม');
		$('#S_ORG3').focus();
		return false;
	}
	
	
	
	if(rowCount == 1){
		alert('กรุณา บันทึกอย่างน้อย 1 รายการ');
		return false;
	}
	$('input[name^=PERCENT_SAL]').each(function(){
		id = this.id.replace("PERCENT_SAL_","");
		
		if($('#LV_SCORE_ID_'+id).val() == ''){
			err1++;
			$('#LV_SCORE_ID_'+id).val('').focus();
			return false;
		}
		
		if($('#SCORE_S_'+id).val() == ''){
			err2++;
			$('#SCORE_S_'+id).val('').focus();
			return false;
		}
		
		if($('#SCORE_E_'+id).val()  == ''){
			err3++;
			$('#SCORE_E_'+id).val('').focus();
			return false;
		}
		
		if($('#PERCENT_SAL_'+id).val() == ''){
			err4++;
			$('#PERCENT_SAL_'+id).val('').focus();
			return false;
		}
	});
	
	if(err1 > 0){
		alert('ระบุ ระดับ');
		return false;
	}
	if(err2 > 0){
		alert('ระบุ คะแนนเริ่มต้น');
		return false;
	}
	if(err3 > 0){
		alert('ระบุ คะแนนสิ้นสุด');
		return false;
	}
	if(err4 > 0){
		alert('ระบุ ร้อยละ');
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		if(type_save == 1){
			$('#proc').val('save');
		}else if(type_save == 2){
			$('#proc').val('save_all');
		}
		$("#frm-search").attr('action','process/set_level_salary1_process.php').submit();
	}
}
function ConfirmGov(){
	if($('#S_YEAR_BDG').val() == ''){
		alert('ระบุ ปีงบประมาณ');
		$('#S_YEAR_BDG').focus();
		return false;
	}
	
	if($('#S_ROUND').val() == ''){
		alert('ระบุ รอบ');
		$('#S_ROUND').focus();
		return false;
	}
	if($('#S_ORG3').val() == ''){
		alert('เลือก กอง/สำนัก/กลุ่ม');
		$('#S_ORG3').focus();
		return false;
	}
	
	if($('#S_SCORE_TYPE').val() == ''){
		alert('ระบุ ประเภท');
		$('#S_SCORE_TYPE').focus();
		return false;
	}
	var S_YEAR_BDG = $('#S_YEAR_BDG').val();
	var S_ROUND = $('#S_ROUND').val(); 
	var ORG_NAME = $('#S_ORG3 option:selected').text();
	if(confirm("อนุมัติเกณฑ์การประเมิน\nประจำปีงบประมาณ "+S_YEAR_BDG+" รอบ "+S_ROUND+"\nสำนัก/กลุ่ม : "+ORG_NAME+"\nคุณจะไม่สามารถแก้ไขข้อมูลได้อีก\nคุณต้องการดำเนินการต่อใช้หรือไม่ ?")){
		$('#proc').val('ConfirmGov');
		$("#frm-search").attr('action','process/set_level_salary1_process.php').submit();
	}
}
function getOrgParent(org_id){
	var url = "process/set_level_salary1_process.php";
	var data = {proc: "getOrgParent",org_id: org_id};
	$.post(url,data,function(data){
		$('#shw_org4').html(""+data);
		$("#S_ORG4").chosen({//ค้นหา+เลือก select  id
			allow_single_deselect: true
		});
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