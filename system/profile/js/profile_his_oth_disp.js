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
	
	if($('#proc').val()!='edit'){
		getPosLevel($('#TYPE_ID').val(),'LEVEL_ID');
		 getORG2($('#ORG_ID_2').val(),'ORG_ID_4');
	}
});

function searchData(){
	$("#page").val(1);
	$("#frm-search").submit();
}

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

function transferData(id){
	$("#PER_ID").val(id);
	$("#frm-search").attr("action","profile_his_trans_rule_disp.php").submit();
}

function getORG2(value,id){
	var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'org_3',PARENT_ID:value,z_id:'ORG_ID_3',z_name:'ORG_ID_3',z_class:'selectbox form-control',oncharng:'ORG_ID_4'},
		async: false,
		success: function(data) {
				$('#ss_org3').html(data);
				$("#ORG_ID_3").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});

		}
		});
		
		getORG3('',id);
}

function getORG3(value,id){
var url ='process/select_selationship.php'
		$.ajax({
		url: url,
		type: 'POST',
		dataType: 'html',
		data: {proc:'org_4',PARENT_ID:value,z_id:'ORG_ID_4',z_name:'ORG_ID_4',z_class:'selectbox form-control'},
		async: false,
		success: function(data) {
				$('#ss_org4').html(data);
				$("#ORG_ID_4").chosen({//ค้นหา+เลือก select  id
					allow_single_deselect: true
				});
		}
		});
}

function getOrg(value,id){
	var url ='process/select_selationship.php'
	$.ajax({
	url: url,
	type: 'POST',
	dataType: 'html',
	data: {proc:'org_4',PARENT_ID:value,z_id:'ORG_ID_4',z_name:'ORG_ID_4',z_class:'selectbox form-control'},
	async: false,
	success: function(data) {
			$('#ss_org4').html(data);
			$("#ORG_ID_4").chosen({//ค้นหา+เลือก select  id
				allow_single_deselect: true
			});
		}
	});
}

function getPosDetail(POS_ID){
	var url ='process/select_selationship.php'
	$.ajax({
		url: url,
		type: 'POST',
		dataType: 'json',
		data: {proc:'pos_detail',POS_ID:POS_ID},
		async: false,
		success: function(data) {
			$("#TYPE_NAME_TH").html(data.TYPE_NAME_TH);
			$("#LEVEL_NAME_TH").html(data.LEVEL_NAME_TH);
			$("#LINE_NAME_TH").html(data.LINE_NAME_TH);
			$("#MANAGE_NAME_TH").html(data.MANAGE_NAME_TH);
			
			$("#TYPE_ID").val(data.TYPE_ID);
			$("#LEVEL_ID").val(data.LEVEL_ID);
			$("#LINE_ID").val(data.LINE_ID);
			$("#MANAGE_ID").val(data.MANAGE_ID);
		}
	});
}

function checkfile(sender) {
    var validExts = new Array(".gif", ".png", ".jpg");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("เลือกไฟล์รูปภาพได้เฉพาะ นามสกุล   " + validExts.toString() + " เท่านั้น");
	  $('#PER_FILE_PIC').val('');
	  //$('#SS_PICTURE').replaceWith('<input id="SS_PICTURE" type="file" name="SS_PICTURE" class="form-control"  value="" onchange="checkfile(this);" >');
      return false;
    }
    else return true;
}

// ========== POPUP FUNCTION ==============
function show_pop(){
	url = "../../system/all/form_select_position_no_plac_app.php";
	data = {span: 'show_display2',s_file: url,S_POS_NO: '', POS_ID_OLD:$("#POS_ID_OLD").val(), POSTYPE_ID:$("#POSTYPE_ID").val()};
	$.get(url,data,function(msg){
		$('#show_display2').html(msg);
	});
}

function search_pop(url1, show_dis, APPOINT_TYPE_PERSON, id_tb, S_POS_NO){	
	url = "../../system/all/"+url1;
	data = {span: show_dis,s_file: url1,APPOINT_TYPE_PERSON: APPOINT_TYPE_PERSON, id_tb:id_tb, S_POS_NO:S_POS_NO, POSTYPE_ID:$("#POSTYPE_ID").val()};
	$.get(url,data,function(msg){
		$('#'+show_dis).html(msg);
	});
}
function search_pop2(url1, show_dis, id_tb, S_POS_NO, POSTYPE_ID){
	url = "../../system/all/"+url1;
	data = {span: show_dis,s_file: url1, id_tb:id_tb, S_POS_NO:S_POS_NO, POSTYPE_ID:POSTYPE_ID};
	$.get(url,data,function(msg){
		$('#'+show_dis).html(msg);
	});
}

function closePopup(id){
	$('#'+id).modal('hide')
}

function return_position(LINE_ID, POS_NO, tb_id, POS_ID){
	//alert(per_id);
	$('#POS_NO').val(POS_NO);
	$('#POS_ID').val(POS_ID);
	getPosDetail(POS_ID);
	
	closePopup('myModal');
}
// =======================================

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