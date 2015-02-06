<?php  echo '</form>';
//if($sum_all > 0){  
	  if(($menu_name==11)||($menu_name==12)||($menu_name==16)||($menu_name==42)||($menu_name==43)
	  ||($menu_name==55)||($menu_name==56)||($menu_name==58)||($menu_name==26)||($menu_name==48)
	  ||($menu_name==64)){ // use year in report.
		  $SEARCH_TYPE = $AGE_IS_gen; // send param to be title of table.
	  }
	  echo print_btn($menu_name,$html,$SEARCH_TYPE);  // made a print button with group of it. 
//} 
/*
	$html =  str_replace("CENTER_TOP",$CENTER_TOP_HTML,$html);
	$html =  str_replace("LEFT_TOP",$LEFT_TOP_HTML,$html);		
	$html =  str_replace("RIGHT_TOP",$RIGHT_TOP_HTML,$html);		
	$html =  str_replace("XRXX","",$html);
*/
	$html = restr_html($html);
?>

<div class="col-xs-12 col-sm-12"><div class="table-responsive">
<?php 
	echo $html_start.$html.$html_end; // return html body 
?>
</div></div>