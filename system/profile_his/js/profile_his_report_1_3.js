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

function searchData(){ 
    //if($("#LINE_ID").val() == ""){ alert('line id'); return false;}
	$('#frm-search').submit();
}

function print_excel(){
	 
  	$('#frm-export_exc').submit();	 
}

function print_pdf(){
	 //alert($('#pdf_body').val());
	  $('#frm-export').submit();	
}

function print_report(type, url){
	if(type = 'pdf'){
		$('#frm-search').attr('target','_blank');
		$('#frm-search').attr('action',url);
		$('#frm-search').submit();
		$('#frm-search').attr('target','');
		$('#frm-search').attr('action','');
		
	}
}

function call_line2(id){
			$.post( "../dev_ajax/call_line_selection.php", { id: id })
				.done(function( data ) {
						//alert( "on Dev - Data Loaded: " + data );
						//$('#LINE_ID').empty(); //remove all child nodes
						 $("#LINE_AREA").html(data);
						$(".selectbox").chosen();
			}, "html");
 			
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
		 
			$('#ss_pos_line').html(data);
			$("#POSHIS_LINE_ID").chosen();
			/*$("#LINE_ID"+key_index).chosen({ 
				allow_single_deselect: true
			});*/
			 
			//console.log(data);
		}
	});
}

	function call_line(id){ 
		var file="call_line_selection.php";
		var url ='../dev_ajax/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {id:id},
			async: false,
			success: function(data) {
				$("#LINE_AREA").html(data);
				$(".selectbox").chosen();
				$(".chosenElement").chosen();
			} 
		});
	}
	
	function call_level(id){ 
		var file="call_level_selection.php";
		var url ='../dev_ajax/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {id:id},
			async: false,
			success: function(data) {
				$("#LEVEL_AREA").html(data);
				$(".selectbox").chosen();
				$(".chosenElement").chosen();
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