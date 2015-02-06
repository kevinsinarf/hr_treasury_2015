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

function addData(){
	$("#proc").val("add");
	$("#frm-search").attr("action","profile_missalhis_form.php").submit();
}

function editData(id){
	$("#proc").val("edit");
	$("#MISS_ID").val(id);
	$("#frm-search").attr("action","profile_missalhis_form.php").submit();
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$("#MISS_ID").val(id);
		$("#frm-search").attr("action","process/profile_missalhis_process.php").submit();
	}
}

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

function chkinput(){
	if($("#MISS_TYPE").val() == ""){
		alert("ระบุ "+$('#MISS_TYPE').attr('placeholder'));
		$("#MISS_TYPE").focus();
		return false;
	}
	
	if($("#MISS_SDATE").val() == ""){
		alert("ระบุ วันที่เริ่มต้น");
		$("#MISS_SDATE").focus();
		return false;
	}
	
	if($("#MISS_EDATE").val() == ""){
		alert("ระบุ วันที่สิ้นสุด");
		$("#MISS_EDATE").focus();
		return false;
	}
	
	if(chk_date($("#MISS_SDATE").val(), $("#MISS_EDATE").val(), "วันที่เริ่มต้น", "วันที่สิ้นสุด")){
		return false;	
	}
	
	if($("#MISS_LAST_SALARY").val() == "" || parseFloat($("#MISS_LAST_SALARY").val().replace(/,/g,'')) == 0.00){
		alert("ระบุ "+$('#MISS_LAST_SALARY').attr('placeholder'));
		$("#MISS_LAST_SALARY").focus();
		return false;
	}
	
	if(($("#MISS_NEW_SALARY").val() == "" || parseFloat($("#MISS_NEW_SALARY").val().replace(/,/g,'')) == 0.00) && $("#MISS_TYPE").val() != 1){
		alert("ระบุ "+$('#MISS_NEW_SALARY').attr('placeholder'));
		$("#MISS_NEW_SALARY").focus();
		return false;
	}
	
	if($("input[name=ACTIVE_STATUS]:checked").val() == ""){
		alert("ระบุ สถานะ");
		$("#ACTIVE_STATUS1").focus();
		return false;
	}
	
	if(confirm("กรุณายืนยันการบันทึกอีกครั้ง ?")){
		$("#frm-input").submit();
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