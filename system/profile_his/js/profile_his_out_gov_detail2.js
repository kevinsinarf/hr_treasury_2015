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
	$("#page").val(1);
	$("#frm-search").submit();
}

function addPerson(){
	url = "../../system/all/form_retirement_retired_gov.php";
	data = {span: 'show_display',s_file: url };
	$.get(url,data,function(msg){
		$('#show_display').html(msg);
	});
}

function search_pop(url1,show_dis,val){
	url = "../../system/all/"+url1;
	data = {span: show_dis,s_file: url1,s_name_th: val};
	$.get(url,data,function(msg){
		$('#'+show_dis).html(msg);
	});
}

function closePopup(id){
	$('#'+id).modal('hide')
}

function checkbox_all(){
	if($("#all_chk").prop("checked")){
		$("input[type=checkbox]").prop("checked",true);
	}else{
		$("input[type=checkbox]").prop("checked",false);
	}
}

function addData(){
	$('#proc').val('add');
	$('#frm-search').attr('action','retirement_retired_gov_form.php').submit();
}

function editData(id){
	$('#proc').val('edit');
	$('#COM_ID').val(id);
	$('#frm-search').attr('action','retirement_retired_gov_form.php').submit();
}

function delData(id){
	if(confirm("ต้องการลบข้อมูลใช่หรือไม่ ?")){
		$("#proc").val("delete");
		$('#COM_ID').val(id);
		$('#frm-search').attr('action','process/retirement_retired_gov_process.php').submit();
	}
}

function getSave(){
	$("input[type=checkbox][id^=chk]:checked").each(function() {
		var id = this.id.replace("chk", "");
		var val = $(this).val();
		$.post('process/retirement_retired_gov_process.php',{proc:'get_value',PER_ID:val}, function(html){ 
		 	$('#tb_data tbody').append(html);	
				$(".selectbox").chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});		
		})
	});
	closePopup('myModal');
}

function remove_id(obj){
	if(confirm('คุณต้องการลบแถวนี้?')){
	  	$(obj).parent().parent().remove(); 
	}else{ 
		alert('ไม่อนุญาตให้ลบแถวที่เหลือนี้ได้'); 
	} 
}

function chkinput(){
	if(confirm("ยืนยันการบันทึก อีกครั้ง")){
		$('#proc').val('transfer');
		$('#frm-input').submit();
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