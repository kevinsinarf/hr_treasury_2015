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

function getPosLine(value, POSTYPE_ID, key_index){  
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'get_line',PARENT_ID:value,POSTYPE_ID:POSTYPE_ID,z_id:'POSHIS_LINE_ID',z_name:'POSHIS_LINE_ID',z_class:'selectbox form-control', key_index:key_index},
		async: false,
		success: function(data) {
		 
			$('#ss_pos_line').html(data);
			$("#POSHIS_LINE_ID").chosen();
			/*$("#LINE_ID"+key_index).chosen({ 
				allow_single_deselect: true
			});*/
			 
			//console.log(data);
		}
	});
}

function print_excel(){
	 
  	$('#frm-export_exc').submit();	 
}

function searchData(){ 
	$('#frm-search').submit();
}

function print_pdf(){
    
	  $('#frm-export').submit();	
}

function  print_pdf_attached(){
	   //var attached_name_report = $('#insert_report_name').val()+" "+$('#insert_report_name_2').val()+" "+$('#insert_report_name_3').val();
	   var attached_name_report = $('#insert_report_name').val();
	   var attached_name_report2 = $('#insert_report_name2').val();
	   var attached_name_report3 = $('#insert_report_name3').val();
	   //alert(attached_name_report);
	   $('#report_print_name').val(attached_name_report);
	   $('#report_print_name2').val(attached_name_report2);
	   $('#report_print_name3').val(attached_name_report3); 
	  $('#frm-export').submit();
}

function get_level_1(e){
   
 //alert(e.value);
$.post( "../../system/profile_his/process/type_line_reply.php", { type_id: e.value, type: "type" })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
	  
	  $('#ss_pos_level').html(data);
  });
}

function get_lg_1(e){
   
 //alert(e.value);
$.post( "../../system/profile_his/process/type_line_reply.php", { type_id: e.value, type: "level" })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
	  
	  $('#ss_pos_lg').html(data);
  });
}




function get_line_1(e){
   
  //alert(e.value+' '+$('#TYPE_ID').value);
$.post( "../../system/profile_his/process/type_line_reply.php", { type_id: e.value, type: "line" })
  .done(function( data ) {
    //alert( "Data Loaded: " + data );
	  
	  $('#ss_pos_line').html(data);
  });
}


function getORG(obj){
	var val = $(obj).val();
	var id_old = $(obj).attr('id').substr(-1);
	var id = parseInt($(obj).attr('id').substr(-1))+1;
	var id_new = $(obj).attr('id').replace(id_old, id);
	var html = "<option value=''></option>";
	
	$.post('process/profile_positionhis_process.php', {'proc':'get_org', ORG_PARENT_ID:val}, function(data){
		$.each(data,function(index,val){
			html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
	   });
	   $('#'+id_new).html(html);
	   $('#'+id_new).trigger('liszt:updated');
	   $('#'+id_new).chosen({ allow_single_deselect: true });
	},'json');

}



function getlevel(value,POSTYPE_ID){
	var url ='process/profile_positionhis_process.php';
	var html = "<option value=''></option>";
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'getlevel',POSTYPE_ID:1,TYPE_ID:value},
		async: false,
		success: function(data) {
			$.each(data,function(index,value){
					html += "<option value='"+value['ID']+"'>"+value['VALUE']+"</option>";	
			});	
			$('#LEVEL_ID').html(html);
			$('#LEVEL_ID').trigger("liszt:updated");
			$("#LEVEL_ID").chosen({ allow_single_deselect: true });
				
		}
	});
}

function getLineGroup(TYPE_ID,POSTYPE_ID){
		var html = "<option value=''></option>";
		$.post('process/profile_positionhis_process.php',{proc:'getLineGroup',TYPE_ID:TYPE_ID,POSTYPE_ID:1},function(data){
			$.each(data,function(index,value){
					html += "<option value='"+value['ID']+"'>"+value['VALUE']+"</option>";	
			});	
			$('#LG_ID').html(html);
			$('#LG_ID').trigger("liszt:updated");
			 $('#LG_ID').chosen({ allow_single_deselect: true, no_results_text: "No results matched"});
	},'json');
}

function GetLineGov(value,POSTYPE_ID){
	var url ='process/profile_positionhis_process.php'
	var html = "<option value=''></option>";
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'GetLineGov',LG_ID:value,POSTYPE_ID:1},
		async: false,
		success: function(data) {
			$.each(data,function(index,value){
					html += "<option value='"+value['ID']+"'>"+value['VALUE']+"</option>";	
			});	
			$('#LINE_ID').html(html);
			$('#LINE_ID').trigger("liszt:updated");
			$("#LINE_ID").chosen({ 
				allow_single_deselect: true
			});
		}
	});
}

function GetLineEmp(LEVEL_ID,POSTYPE_ID){
	var url ='process/profile_positionhis_process.php'
	var html = "<option value=''></option>";
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'GetLineEmp',POSTYPE_ID:1,LEVEL_ID:LEVEL_ID},
		async: false,
		success: function(data) {
			    $.each(data, function(index, val){
					html += "<option value='"+val['ID']+"'>"+val['VALUE']+"</option>";
				});
				$('#LINE_ID').html(html);
				$('#LINE_ID').trigger("liszt:updated");
				$("#LINE_ID").chosen({ 
					allow_single_deselect: true
				});
		}
	});
}


function datediff(startdate,enddate){
	if(startdate == enddate){
		$("#POSHIS_YEAR").val('0');
		$("#POSHIS_MONTH").val('0');
		$("#POSHIS_DAY").val('1');
		
		return false;
	}
	
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
	years = 0; months = 0; days = 0;
	years = parseInt(daysDiff/365);
	if((daysDiff%365) != 0){
		months = parseInt((daysDiff-(years*365))/30);
	}
	days = (daysDiff - ((years*365) + (months*30)));
	
	$("#POSHIS_YEAR").val(years);
	$("#POSHIS_MONTH").val(months);
	$("#POSHIS_DAY").val(days);
}

function chk_date(startdate,enddate,startdate_text,enddate_text){
	var chk_sdate=startdate.replace(/0/gi,"").replace(/\//gi,"");
	var chk_edate=enddate.replace(/0/gi,"").replace(/\//gi,"");
	var date1 = startdate;  // '24/11/2010'
	var date2 = enddate; 
	var thisdate=new Date();
	date1 = date1.split("/"); 
	date2 = date2.split("/"); 
	startdate_text = startdate_text==""?"date start":startdate_text;
	enddate_text = enddate_text==""?"date end ":enddate_text;
	
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
		alert(enddate_text+" must after "+startdate_text);	
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