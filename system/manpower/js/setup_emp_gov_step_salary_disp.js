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
	if($('#S_LEVEL_SEQ').val() == ''){
		alert('ระบุ กลุ่ม');
		$('#S_LEVEL_SEQ').focus();
		return false;
	}
	
	$("#page").val(1);
	$('#frm-search #proc').val('search');
	$("#frm-search").submit();
}
function Transfer(id){
	/*$('#T_SAL_UP_ID').val(id);*/
	$('#transfer').modal('show');
}
function AddTransfer(){
	if($('#LEVEL_ID').val() == ''){
		alert('ระบุ ระดับ');
		$('#LEVEL_ID').focus();
		return false;
	}
	if($('#T_GROUP_ID').val() == ''){
		alert('ระบุ กลุ่ม');
		$('#T_GROUP_ID').focus();
		return false;
	}
	if($('#S_STEP').val() == ''){
		alert('ระบุ เริ่มต้นขั้นที่');
		$('#S_STEP').focus();
		return false;
	}
	if($('#E_STEP').val() == ''){
		alert('ระบุ ถึงขั้นที่');
		$('#E_STEP').focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการนำเข้าข้อมูลอีกครั้ง ?")){
	  var LEVEL_ID = $('#LEVEL_ID').val();
	  $('#frm-transfer #proc').val('AddTransfer');
	  $('#T_LEVEL_ID').val(LEVEL_ID);
	  $('#frm-transfer').attr('action','process/setup_emp_gov_step_salary_process.php');
	  $('#frm-transfer').submit();
	}
}
function AddDefault(){
	var i = 1;
	$('input[name^=STEP_SEQ]').each(function(index, element) {
		$(this).val(i);
		i = i+0.5;
    });
}

function add_row(){
	var table = document.getElementById('tb_data');
	var rowCount = (table.rows.length);
	var row = table.insertRow(rowCount);
	var id_tb = rowCount+"A"+parseInt((Math.random()*10)+1);

	table.rows[rowCount].id = id_tb;
	table.rows[rowCount].style.background = "#FFFFFF";
	var j =0;

	for(var i = 0;i<7;i++){
		table.rows[rowCount].insertCell(i);		
	}
		
	// JQUERY POST DATA
	var url = "process/set_salary3_process.php";
	//END 
	
	table.rows[rowCount].cells[0].align="center";
	table.rows[rowCount].cells[1].align="center";
	table.rows[rowCount].cells[2].align="center";
	table.rows[rowCount].cells[3].align="center";
	table.rows[rowCount].cells[4].align="center";
	table.rows[rowCount].cells[5].align="center";
	table.rows[rowCount].cells[6].align="center";
	
	table.rows[rowCount].cells[0].innerHTML="<input type=\"text\" id=\"GROUP_ID_"+id_tb+"\" name=\"GROUP_ID[]\"  class=\"form-control number\" maxlength=\"6\" style=\"width:100px;text-align:center;\" onBlur=\"NumberFormat(this)\">";
	table.rows[rowCount].cells[1].innerHTML="<input type=\"text\" id=\"STEP_NO_"+id_tb+"\" name=\"STEP_NO[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:100px;text-align:center;\" onBlur=\"NumberFormat(this,2)\">";
	table.rows[rowCount].cells[2].innerHTML="<input type=\"text\" id=\"STEP_SEQ_"+id_tb+"\" name=\"STEP_SEQ[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:100px;text-align:center;\" onBlur=\"NumberFormat(this,2)\">";
	table.rows[rowCount].cells[3].innerHTML="<input type=\"text\" id=\"SAL_MONTH_"+id_tb+"\" name=\"SAL_MONTH[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:120px;text-align:right;\" onBlur=\"NumberFormat(this,2)\">";
	table.rows[rowCount].cells[4].innerHTML="<input type=\"text\" id=\"SAL_DAY_"+id_tb+"\" name=\"SAL_DAY[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:120px;text-align:right;\" onBlur=\"NumberFormat(this,2)\">";
	table.rows[rowCount].cells[5].innerHTML="<input type=\"text\" id=\"SAL_HOURS_"+id_tb+"\" name=\"SAL_HOURS[]\"  class=\"form-control\" maxlength=\"6\" style=\"width:120px;text-align:right;\" onBlur=\"NumberFormat(this,2)\">";
	table.rows[rowCount].cells[6].innerHTML="<a  class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"remove_id('"+id_tb+"');\" >"+img_del+" ลบ</a> ";
	$(".number").keyup(function() {//Can Be {0-9}
  		check_number($(this).val(), $(this).attr('id'));
	});
}

function remove_id(id){
	$('#'+id).remove();
}

function chkinput(){
	var err1=0;
	var err2=0;
	var err3=0;
	var err4=0;
	var table = document.getElementById('tb_data');
	var rowCount = (table.rows.length);	

	if(rowCount == 2){
		alert('กรุณา บันทึกอย่างน้อย 1 รายการ');
		return false;
	}
	$('input[name^=STEP_NO]').each(function(){
		id = this.id.replace("STEP_NO_","");
		
		if($('#STEP_NO_'+id).val() == ''){
			err1++;
			$('#STEP_NO_'+id).val('').focus();
			return false;
		}
		
		if($('#SAL_MONTH_'+id).val()  == ''){
			err2++;
			$('#SAL_MONTH_'+id).val('').focus();
			return false;
		}
		
		if($('#SAL_DAY_'+id).val() == ''){
			err3++;
			$('#SAL_DAY_'+id).val('').focus();
			return false;
		}
		
		if($('#SAL_HOURS_'+id).val() == ''){
			err4++;
			$('#SAL_HOURS_'+id).val('').focus();
			return false;
		}
	});
	
	if(err1 > 0){
		alert('ระบุ ลำดับขั้น');
		return false;
	}
	if(err2 > 0){
		alert('ระบุ อัตราค่าจ้างรายเดือน');
		return false;
	}
	if(err3 > 0){
		alert('ระบุ อัตราค่าจ้างรายวัน');
		return false;
	}
	if(err4 > 0){
		alert('ระบุ อัตราค่าจ้างรายชั่วโมง');
		return false;
	}
	
	
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
			$('#frm-search #proc').val('add');
		   $("#frm-search").attr('action','process/setup_emp_gov_step_salary_process.php').submit();
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