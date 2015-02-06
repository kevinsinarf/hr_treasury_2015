$(document).ready(function(){
	$(window).scroll(function(){
		$('#myModal').css(
		{
			'margin-top': function () {
				return window.pageYOffset;
			}
		}
		);
	});
	
});

function addData(){
	$('#myModal').load('main4.php?'+Math.random(),function(e){
		$('#myModal').modal();
	});
}

function addData2(){
	$("#frm-search").attr("action","main5.php").submit();
}