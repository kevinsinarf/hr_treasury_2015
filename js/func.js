var img_save="<span class=\"glyphicon glyphicon-plus-sign\"></span>";
var img_edit="<span class=\"glyphicon glyphicon-pencil\"></span>";
var img_del="<span class=\"glyphicon glyphicon-trash\"></span>";
var thday = new Array ("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์"); 
var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
var notime=0;

//fix class
$(document).ready(function() {
	load_format('all');//ready
});//End function ready

var intid = (notime!=1?'':setInterval("nomovement()",30*60*1000));
function nomovement() {    //alert(notime);
	alert('คุณไม่ได้ใช้งานในระบบ มากว่า 30 นาที กรุณา เข้าสู่ระบบใหม่  (Please Login Before)');
	//location.href = 'http://61.19.100.20/logout.php';//เครื่องจริง
	//location.href = 'http://192.168.0.223/disaster/logout.php';//เครื่องล่าง
	//location.href = 'http://localhost/parliament_hr_new/logout.php';//เครื่องตัวเอง
}
function removement() {
	clearInterval(intid);   
	intid = setInterval("nomovement()",30*60*1000);  
}

 

Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
}

Storage.prototype.getObject = function(key) {
    var value = this.getItem(key);
    return value && JSON.parse(value);
}

        //var minutesLabel = document.getElementById("minutes");
        //var secondsLabel = document.getElementById("seconds");
        var totalSeconds = 0;
        setInterval(setTime, 1000);

        function setTime()
        {
            ++totalSeconds;
            //secondsLabel.innerHTML = pad(totalSeconds%60);
            //minutesLabel.innerHTML = pad(parseInt(totalSeconds/60));
			return pad(totalSeconds%(1800));
        }

        function pad(val)
        {
            var valString = val + "";
            if(valString.length < 2)
            {
                return "0" + valString;
            }
            else
            {
                return valString;
            }
        }


$(window).on("blur focus", function(e) {
    var prevType = $(this).data("prevType");
	var intid2;
	var notime2=0;
	var intid3 = 0;
    if (prevType != e.type) {   //  reduce double fire issues
	   // console.log(' == '+e.type);
        switch (e.type) {
            case "blur":
                // do work,

				//intid2 = (notime2!=1?'':setInterval("nomovement()",30*60*1000));
				//intid3 = intid2;

				localStorage.setObject('blur_time', setTime());
				//console.log("blur : "+localStorage.getObject('blur_time')); 
				if(setTime()==1800){
					     nomovement();
				}
                break;
            case "focus":
                // do work,
				//console.log("blur before focus : "+ setTime()); 
				totalSeconds = 0;
				localStorage.setObject('blur_time', totalSeconds);
				intid2 = 1;
				//console.log("focus : "+localStorage.getObject('blur_time')); 
                break;
        }
    }

    $(this).data("prevType", e.type);
})

//ready
function load_format(format){
	if(format=='all' || format=='number'){
		$(".number").keyup(function() {//Can Be {0-9}
			check_number($(this).val(), $(this).attr('id'));
		});
	}
	if(format=='all' || format=='numb'){
		$(".numb").keyup(function() {//Can Be {0-9,.}
			chkFormatNam($(this).val(), $(this).attr('id'));
		});
	}
    if(format=='all' || format=='email'){
		$(".email").keyup(function() {
			Checkemail($(this).val(), $(this).attr('id'));
		});
	}
	if(format=='all' || format=='datepicker'){    
		$(".datepicker").each(function() {//ปฏิทิน
			var date_for = $(this).attr("for");
			$('span[for='+date_for+']').attr('data-date', $('#'+date_for).val());
			
			$("span[for="+date_for+"]").datepicker({
				showOn: "button",
				language: "th-th"
			});
			$("span[for="+date_for+"]").on("changeDate", function (e){//onchangeDate
				$('#'+date_for).val(e.format('dd/mm/yyyy'));
				$('span[for='+date_for+']').datepicker('hide');
			});
			$("#"+date_for).on("keyup", function (e){//onkeyup
				beginchk(this,e,this.id);
			});
		});
	}
	if(format=='all' || format=='selectbox'){
		$(".selectbox").each(function() {//selectbox
			$('#'+$(this).attr('id')).attr('title','สามารถค้นหาและเลือกข้อมูลได้');
			$("#"+$(this).attr('id')).chosen({//ค้นหา+เลือก select 
				allow_single_deselect: true,
				no_results_text: "No results matched"
			});
		});
	}
	if(format=='all' || format=='idcard'){
		$(".idcard").each(function() {//เลขประชาชน
			$('#'+$(this).attr('id')).mask("9-9999-99999-99-9");
		});
	}
	if(format=='all' || format=='mobile'){
		$(".mobile").each(function() {//โทรศัพท์มือถือ
			$('#'+$(this).attr('id')).mask("99-9999-9999");
		});
	}
	if(format=='all' || format=='tel'){
		$(".telprov").each(function() {//โทรศัพท์ โทรสาร ต่างจังหวัด
			$('#'+$(this).attr('id')).mask("999-999-999");
		});
	}
	if(format=='all' || format=='fax'){
		$(".telbkk").each(function() {//โทรศัพท์ โทรสาร กรุงเทพ
			$('#'+$(this).attr('id')).mask("9-9999-9999");
		});
	}
	if(format=='all' || format=='date'){
		$(".date").each(function() {//วัน
			$('#'+$(this).attr('id')).mask("99/99/9999");
		});
	}
}

/////check number
function isNum (charCode) {
	if (charCode >= 48 && charCode <= 57 ){
		return true;
	}else{
		return false;
	}
}
//กรอกข้อมูลตัวเลข
function check_number(str,input) {//Can [0-9]
	strlen = str.length;
	for (i=0;i<strlen;i++){
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode)=='1') {//ถ้าอยู่ 0-9 จะส่งค่า 1
			alert('กรุณากรอกข้อมูลตัวเลขเท่านั้น');
			$("input[id = '"+input+"']").val('');
			$("input[id = '"+input+"']").focus();
			return false;
		}
	}//for
	return true;
} // end function

function chkFormatNam (str,input) {// Can Be {0-9,-, .}
	strlen = str.length;
	var amount = '';
	var dot = 0;
	//var minus = 0;
	for (i=0;i<strlen;i++){
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode)) {
			if(charCode=='44') {
			} 
			//ตรงนี้จะเป็น - 
			else if (charCode=='45' && minus != 1) {
				minus = 1;
				if (i!=0) {
					amount = '';
				}
			} 
			else if(charCode=='45' && minus==1){
				amount = '';
			} 
			else if(charCode=='46' && dot!=1){
				dot = 1;
				if (i==1 && minus == 1){
					amount = '-0';
				}else if (i==0) {
					amount = 0;
				}
			} 
			else if(charCode=='46' && dot==1){
				if (minus == 1) {
					amount = '-0';
				}else if (minus != 1) {
					amount = 0;
				}
			}  else{ 
				alert('กรุณากรอกข้อมูลตัวเลขเท่านั้น');
				//alert(myText [$('#lang').val()]['chk_number']);
			
				$("input[id = '"+input+"']").val('');
				$("input[id = '"+input+"']").focus();
				return false;
			}
		}
		amount += str.charAt(i);
	}//for
	//document.getElementById(input).value=amount;
	$("input[id = "+input+"]").val(amount);
	return true;
}/////end number
function chkFormatNam_id (str,input) {// Can Be {0-9,-.}
	strlen = str.length;
	var amount = '';
	var dot = 0;
	var minus = 0;
	for (i=0;i<strlen;i++)
	{
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode)) {
			if(charCode=='44') {
			} else if (charCode=='45' && minus != 1) {
				minus = 1;
				if (i!=0) {
					amount = '';
				}
			} else if(charCode=='45' && minus==1){
				amount = '';
			} else if(charCode=='46' && dot!=1){
				dot = 1;
				if (i==1 && minus == 1){
					amount = '-0';
				}else if (i==0) {
					amount = 0;
				}
			} else if(charCode=='46' && dot==1){
				if (minus == 1) {
					amount = '-0';
				}else if (minus != 1) {
					amount = 0;
				}
			}  else{ 
				$("input[id = "+input+"]").val('');
				$("input[id = "+input+"]").focus();
				return false;
			}
		}
		amount += str.charAt(i);
	}//for
	//document.getElementById(input).value=amount;
	$("input[id = "+input+"]").val(amount);
	return true;
}
// number format แบบส่งค่ากลับ
function number_format_return(number,decimal,dec_sign,thousand_sign){
	if(isNaN(number)){
		return false;	
	}
	dec_sign = dec_sign != undefined ? dec_sign : '.';
	var result = isNaN(decimal) ? parseFloat(number).toFixed(2) : (parseFloat(number).toFixed(decimal)).toString().replace('.',dec_sign);
	thousand_sign = thousand_sign != undefined ? thousand_sign : ',';
	result = result.replace(/\B(?=(?:\d{3})+(?!\d))/g, thousand_sign);
	return result;
}

//chk เลขประชาชน
function checkID(id) { 
	if(id.length == 17){
		var card=id.split("-").join('');
	}else{
		return false;
	}	
	/*if(id.length != 13){
		return false;
	}*/		
	for(i=0, sum=0; i < 12; i++){ 
		sum += parseFloat(card.charAt(i))*(13-i);
	}
	if((11-sum%11)%10!=parseFloat(card.charAt(12))){ 
		return false; 
	}
	return true;
}

//ตรวจสอบ email
function Checkemail(str,input){
	var Email="^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$"
	if(!document.getElementById(str).value.match(Email)){
		return false;
	}else{
		return true;
	}
}

//ตรวจสอบค่าซ้ำ
function chkDup(span, hidden, name, pk, stable, other){
	if($.trim($('#'+name).val()) != ""){
		$.ajax({
			url: '../all/chk_dupicate_proc.php',
			dataType: "json",   
			type: "POST",
			data:{proc:span,table:stable,pk_name:pk,pk_val:$('#'+pk).val(),data_name:name,data_val:$('#'+name).val().replace(/-/g,""),detail_data:other},
			success : function(data){//alert(data.aa);
				$("span[id="+span+"]").each(function(){
					$("#"+hidden).val(data.flag);			
					var Dclass = $(this).attr("class").replace(" label-danger","").replace(" label-success","");
					if(data.flag == 1){
						Dclass += " label-danger";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-remove\"></span> "+data.detail+"</b>");
					}else{
						Dclass += " label-success";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-saved\"></span> "+data.detail+"</b>");
					}
				});
			}
		});
	}else{			
		$("span[id="+span+"]").each(function(){
			Dclass = $(this).attr("class").replace(" label-danger","").replace(" label-success","");
			$(this).attr("class",Dclass).html("");
		});
	}
}



//ตรวจสอบค่าซ้ำ
function chkDup_test(span, hidden, name, pk, stable, other){
	if($.trim($('#'+name).val()) != ""){
		$.ajax({
			url: '../all/chk_dupicate_proc2.php',
			dataType: "json",   
			type: "POST",
			data:{proc:span,table:stable,pk_name:pk,pk_val:$('#'+pk).val(),data_name:name,data_val:$('#'+name).val().replace(/-/g,""),detail_data:other},
			success : function(data){//alert(data.aa);
				$("span[id="+span+"]").each(function(){
					$("#"+hidden).val(data.flag);			
					var Dclass = $(this).attr("class").replace(" label-danger","").replace(" label-success","");
					if(data.flag == 1){
						Dclass += " label-danger";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-remove\"></span> "+data.detail+"</b>");
					}else{
						Dclass += " label-success";
						$(this).attr("class",Dclass).html("<b><span class=\"glyphicon glyphicon-saved\"></span> "+data.detail+"</b>");
					}
				});
			}
		});
	}else{			
		$("span[id="+span+"]").each(function(){
			Dclass = $(this).attr("class").replace(" label-danger","").replace(" label-success","");
			$(this).attr("class",Dclass).html("");
		});
	}
}

//parent all
function getParent(span, name, i, f_id, f_name, table, cond, order, title, t_parent){ //alert(order);
	$.ajax({
		url: '../all/parent_all_proc.php',
		dataType: "html",
		type: "POST",
		data: {proc:"all", span:span, name:name, i:i, f_id:f_id, f_name:f_name, table:table, cond:cond, order:order, title:title, t_parent:t_parent},
		success: function(data){//alert(data);
			$('#'+span+(i!=''?i:'')).html(data);
			$('#'+name+i).chosen({
				allow_single_deselect: true
			});
		}
	});
}

//แสดง Form POPUP
function FncLoad_Form(id,s_file,cond,type){//alert(id);alert(s_file);alert(cond);alert(type);
	var link2="";
	if(type=='map'){
		link2="";
	}else if(type=='head'){
		link2="system/all/";
	}else{
		link2="../../system/all/";
	}
	var url=link2+s_file+'?span='+id+'&s_file='+s_file+'&'+cond+'&TYPE='+type;
	//alert(url);
	$.get(url, function(msg){//alert(msg);
		$('#'+id).html(msg);
		load_format("all");
	});
}//end function

function FncLoad_Form2(id,s_file,cond){//alert(type);alert(id);alert(s_file);alert(cond);
	var link2="../../system/all/";
	var url=link2+s_file+'?span='+id+'&s_file='+s_file+'&'+cond;
	//alert(url);
	$.get(url, function(msg){
		$('#'+id).html(msg);
	});
}//end function

function chk_file_pic(fname){
	var arr_typefname = new Array();
	arr_typefname = fname.split(".");
	var arr_type = arr_typefname.reverse();
	type_name = arr_type[0];
	type_name = type_name.toUpperCase();
	if(type_name == 'GIF' || type_name == 'JPG' || type_name == 'JPEG' || type_name == 'PNG'){
		return true;
	}else{
		return false;
	}
}

//*** Chk Date Format (dd/mm/yyyy) ***//
function beginchk(ip,ek,id_txt) {
	//เริ่มต้นการรับพารามิเตอร์จากคีย์บอร์ด
	if((ek.keyCode>47&&ek.keyCode<58)||ek.keyCode==8||ek.keyCode==46||ek.keyCode==144||ek.keyCode==111||(ek.keyCode>95&&ek.keyCode<106)||(ek.keyCode>36&&ek.keyCode<41)){//อนุญาตให้พิมพ์ตัวเลข Delete Backspace Left Right Up Down
		if(ip.value.match("^([0-9]{2})/([0-9]{2})//$")){
			ip.value=ip.value.substring(0,6);
			return true;
		}else if(ip.value.match("^([0-9]{2})/([0-9]{2})$")&&ek.keyCode!=8){//ตรวจสอบพารามิเตอร์โดยเลือกใช้ Regular Expression
			ip.value=ip.value + "/";
			return true;
		}else if(ip.value.match("^([0-9]{2})//$")&&ek.keyCode!=8){
			ip.value=ip.value.substring(0,3);
			return true;
		}else if(ip.value.match("^([0-9]{2})$")&&ek.keyCode!=8){//ตรวจสอบพารามิเตอร์โดยเลือกใช้ Regular Expression
			ip.value=ip.value + "/";
			return true;
		}else if(ip.value.match("^([0-9]{2})/([0-9]{2})/([0-9]{4})$")){//ตรวจสอบพารามิเตอร์โดยเลือกใช้ Regular Expression
			isDate(ip.value,ip);//ส่งพารามิเตอร์ไปตรวจสอบที่ฟังก์ชั่น isDate ว่ากรอกวันเดือนปีถูกต้องหรือไม่
			return true;
		}else if(ip.value.length>10){//เงื่อนไขนี้ตรวจสอบว่าห้ามกรอกข้อมูลเกินสิบหลักถ้าเกินให้ตัดตัวสุดท้ายทิ้ง
			ip.value=ip.value.substring(0,10);
			isDate(ip.value,ip);
			return true;
		}
	}else{//แจ้งเตือนถ้าคีย์ข้อความที่ไม่ใช่ตัวเลข
		//alert('กรอกได้เฉพาะค่าตัวเลข');
		ip.value = '';
		return true;
	}
}

//เริ่มต้นเช็คค่าวันที่ที่กรอกลงมา
//Date Validation just copy and paste this cod
var dtCh= "/";
var minYear=1900+543;
var maxYear=2100+543;
var minYearA=1900+543;//ค่าตัวแปรที่สองเอาไว้โชว์ค่าพุทธศักราชไทยอะครับ ^^
var maxYearA=2100+543;//ค่าตัวแปรที่สองเอาไว้โชว์ค่าพุทธศักราชไทยอะครับ ^^

function isInteger(s){//ฟังก์ชั่นเช็คค่าตัวเลข
	var i;
	for (i = 0; i < s.length; i++){ 
	// Check that current character is number.
		var c = s.charAt(i);
		if (((c < "0") || (c > "9"))) return false;
	}
	// All characters are numbers.
	return true;
}

function stripCharsInBag(s, bag){//เช็ครูปแบบ
	var i;
	var returnString = "";
	// Search through string's characters one by one.
	// If character is not in bag, append to returnString.
	for (i = 0; i < s.length; i++){ 
		var c = s.charAt(i);
		if (bag.indexOf(c) == -1) returnString += c;
	}
	return returnString;
}

function daysInFebruary (year){//เช็คค่าวันที่ 29 กุมภาพันธ์ ในแต่ละปี
	// February has 29 days in any year evenly divisible by four,
	// EXCEPT for centurial years which are not also divisible by 400.
	return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}

function DaysArray(n){ //เช็ควันสุดท้ายของแต่ละเดือน
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
	} 
	return this
}

function isDate(dtStr,ip){//ฟังก์ชั่นหลักในการเช็คค่าวันที่ ถ้ากรอกวันเดือนปีผิดจะแจ้งเตือนผู้ใช้งาน
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strDay=dtStr.substring(0,pos1)
	var strMonth=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear

	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)//ตัดเลข0
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)//ตัดเลข0
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)//ตัดเลข0
	}
	day=parseInt(strDay)
	month=parseInt(strMonth)
	year=parseInt(strYr)

	if (pos1==-1 || pos2==-1){
		alert("The date format should be : dd/mm/yyyy")
		ip.value=''
		return false
	}

	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		ip.value=''
		return false
	}

	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		ip.value=''
		return false
	}

	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYearA+" and "+maxYearA)
		ip.value=''
		return false
	}

	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		ip.value=''
		return false
	}
	return true
}
//*** Chk Date Format (dd/mm/yyyy) ***//
function print_pdf(type, id,PARENT,type_page){
	if(type_page=='1'){//การมาแสดงตน (การมาแสดงตนของสมาชิกผู้แทนราษฎร)
		if(type == '1' && PARENT=='' ){
			window.open('../../e_form/pdf/e_form1_pdf.php?'+id,'_blank');
		}else if(type == '1'&&PARENT!=''){
			window.open('../../e_form/pdf/e_form1_pdf.php?'+id,'_blank');
		}else if(type == '2'){
			window.open('../../e_form/pdf/e_form2_pdf.php?'+id,'_blank');
		}else if(type == '3'){
			window.open('../../e_form/pdf/e_form3_pdf.php?'+id,'_blank');
		}else if(type == '4'){
			window.open('../../e_form/pdf/e_form4_pdf.php?'+id,'_blank');
		}
	}else if(type_page=='2'){ //ของ e_form
			if(type == '1' && PARENT=='' ){
			window.open('pdf/e_form1_pdf.php?'+id,'_blank');
		}else if(type == '1'&&PARENT!=''){
			window.open('pdf/e_form1_pdf.php?'+id,'_blank');
		}else if(type == '2'){
			window.open('pdf/e_form2_pdf.php?'+id,'_blank');
		}else if(type == '3'){
			window.open('pdf/e_form3_pdf.php?'+id,'_blank');
		}else if(type == '4'){
			window.open('pdf/e_form4_pdf.php?'+id,'_blank');
		}
	}else{
	}
}
function isNum (charCode) 
{
	if (charCode >= 48 && charCode <= 57 )
		return true;
	else
		return false;
}
function NumberOnly(e){
	if(navigator.appName == "Microsoft Internet Explorer"){
		if(event.keyCode < 48 || event.keyCode > 57)
		return false;		
	}
	if(navigator.appName == "Netscape"){
		if(e.which != 8 & e.which != 0 & e.which < 48 || e.which > 57)
		return false;		
	}
}


function NumberFormat(obj,digit){//onBlur="NumberFormat(this,2);" this is object of textbox,2 is digit of number
	if($.trim(obj.value) != ''){
		var number = $.trim(obj.value).split(",").join("");
		if(!isNaN(number)&&number!=""){
			number_format(obj,digit);
		}else{
			num = 0;
			//alert("กรุณากรอกเฉพาะตัวเลขเท่านั้น");
			obj.value = "";
			return false;
			//obj.value = num.toFixed(digit);
		}
	}
	
	//alert("AAA");
}
function NumberFormat_c(obj){
	number_format(obj);
}

function number_format(objNumber,decimals) {
	
	var point = '.';
	var type = 'i';
	var number = $.trim(objNumber.value);
	var number_zero = '';
	number = number.split(",").join("");
	//alert(number);
	for(i=0; i<number.length; i++) {
		if(number.charAt(i) == point) {
			type = 'f';
		}
	}
	if(type == 'f') {
		for(i=0; i<number.length; i++) {
			if(number.charAt(i) == 'e') {
				e_number = (number.substring(i+1, number.length)).split(".").join("");
				if(parseFloat(e_number) < 0) {
					this_number = (number.substring(0, i)).split(".").join("");
					e_sign = (this_number == (this_number = Math.abs(parseFloat(this_number))));
					real_number = "0.";
					real_number = (((e_sign)?'':'-') + real_number);
					for(j=1; j<Math.abs(parseFloat(e_number)); j++) {
						real_number += '0';
					}
					real_number += this_number;
					number = real_number;
				}
			}
		}
		decimal = number.split(".");
	}
	if(decimals == 0) {
		number = Math.round(parseFloat(number));
	}
	sign = (number == (number = Math.abs(number)));
	number = Math.floor(number*100+0.50000000001);
	number = Math.floor(number/100).toString();
	for (var i = 0; i < Math.floor((number.length-(1+i))/3); i++)
		number = number.substring(0,number.length-(4*i+3))+','+number.substring(number.length-(4*i+3));
	number = (((sign)?'':'-') + number);
	if(type == 'i' && decimals > 0) {
		number += '.';
		for(j=1; j<=decimals; j++) {
			number += '0';
		}
	} else if(type == 'f' && decimals > 0) {
		if(decimal[1].length == decimals) {
			number += '.'+decimal[1];
		} else if(decimal[1].length < decimals) {
			number += '.'+decimal[1];
			for(j=1; j<=decimals-decimal[1].length; j++) {
				number += '0';
			}
		} else if(decimal[1].length > decimals) {
			decimal_value = decimal[1].toString();
			number_string = decimal_value.substring(0, (decimals)+1);
			number_eval = parseFloat(number_string)/Math.pow(10, decimals-1);
			number_eval = Math.round(number_eval);
			if(number_eval == Math.pow(10, decimals)) {
				number_eval = 0;
			}
			if(number_eval.toString().length == 1) {
				number_eval = '0'+number_eval.toString();
			}
			if(number_eval.toString().length < decimals) {
				number_zero += '.'+number_eval.toString();
				for(j=1; j<=decimals-number_eval.toString().length; j++) {
					number_zero += '0';
				}
				number += number_zero;
			} else {
				number += '.'+number_eval.toString();
			}
		}
	}
	objNumber.value = number;
}
//str_pad string
function str_pad (input, pad_length, pad_string, pad_type) {
  // From: http://phpjs.org/functions
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // + namespaced by: Michael White (http://getsprink.com)
  // +      input by: Marco van Oort
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
  // *     returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
  // *     example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
  // *     returns 2: '------Kevin van Zonneveld-----'
  var half = '',
    pad_to_go;

  var str_pad_repeater = function (s, len) {
    var collect = '',
      i;

    while (collect.length < len) {
      collect += s;
    }
    collect = collect.substr(0, len);

    return collect;
  };

  input += '';
  pad_string = pad_string !== undefined ? pad_string : ' ';

  if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
    pad_type = 'STR_PAD_RIGHT';
  }
  if ((pad_to_go = pad_length - input.length) > 0) {
    if (pad_type === 'STR_PAD_LEFT') {
      input = str_pad_repeater(pad_string, pad_to_go) + input;
    } else if (pad_type === 'STR_PAD_RIGHT') {
      input = input + str_pad_repeater(pad_string, pad_to_go);
    } else if (pad_type === 'STR_PAD_BOTH') {
      half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
      input = half + input + half;
      input = input.substr(0, pad_length);
    }
  }

  return input;
}
//แปลงเลขไทย
function thaiNumber(num){
 var array = {"1":"๑", "2":"๒", "3":"๓", "4" : "๔", "5" : "๕", "6" : "๖", "7" : "๗", "8" : "๘", "9" : "๙", "0" : "๐"};
 var str = num.toString();
 for (var val in array) {
  str = str.split(val).join(array[val]);
 }
 return str;
}
//PrintAll ปริ้นรีพอทรูปแบบต่างๆ
function print_report(type,PageRep){
	if(type == 'pdf'){
		//window.open('../../report/pdf/report_pdf_8.php?'+id,'_blank');
		$('#frm-search').attr('action','report/report_pdf_'+PageRep+'.php');
		$('#frm-search').attr('target','_blank');
		$('#frm-search').submit();
		
		$('#frm-search').attr('action','report_'+PageRep+'.php');
		$('#frm-search').attr('target','_self');
	}else if(type == 'excel'){
		$('#frm-search').attr('action','report/report_excel_'+PageRep+'.php');
		$('#frm-search').attr('target','_blank');
		$('#frm-search').submit();
                $('#frm-search').attr('action','report_'+PageRep+'.php');
		$('#frm-search').attr('target','_self');
	}
        else if(type == 'word'){
		$('#frm-search').attr('action','report/report_word_'+PageRep+'.php');
		$('#frm-search').attr('target','_blank');
		$('#frm-search').submit();
                $('#frm-search').attr('action','report_'+PageRep+'.php');
		$('#frm-search').attr('target','_self');
	}
}
function new_win_def_prot(mypage, myname, w, h, scroll,fullscreen) { //Show center screen,focus page in use
	var winl = (screen.width - w) / 2;
	var wint = (screen.height - h) / 2;
	winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',fullscreen='+fullscreen+',resizable,toolbar=no,location=no,status=no,menubar=no'
	win = window.open(mypage, myname, winprops)
	if (parseInt(navigator.appVersion) >= 4) { win.window.focus(); }
}


function wireupCallbacks(jsonObject) {
  // @RequestMapping(method=RequestMethod.GET, produces={"application/json; charset=UTF-8"})
  // response.setContentType("application/json;charset=utf-8");
  if (typeof jsonObject === "object") {
    for (var prop in jsonObject) {
      var callbackName = jsonObject[prop];
      if (/Callback$/.test(prop) && typeof callbackName === "string") {
        if (typeof this[callbackName] === "function") {
          jsonObject[prop] = this[callbackName];
        }
      }
    }
  }
  return jsonObject;
}


function array2jsonz(arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { //Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts.push('"' + key + '":' + array2json(value)); /* :RECURSION: */
            //else parts[key] = array2json(value); /* :RECURSION: */
            
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if(typeof value == "number") str += value; //Numbers
            else if(value === false) str += 'false'; //  booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; //All other things
          

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}


function print_pdf(){
	 //alert($('#pdf_body').val());
	  $('#frm-export').submit();	
}
function print_excel(){
	 //alert($('#pdf_body').val());
	  $('#frm-export_exc').submit();	
}

function check_email(email){ 
var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}



