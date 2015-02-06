<?php // inc_report_bottom.php
$html_end   = "</table>";
if($sum_all > 0){  
  
  if($menu_name!=211){
    echo "</form><br/>";
  	echo print_btn($menu_name,$html,$SEARCH_TYPE);  
  }else{  // if not print .
    echo "</form><br/>";
  }
} 
/*
	$html =  str_replace("CENTER_TOP",$CENTER_TOP_HTML,$html);
	$html =  str_replace("LEFT_TOP",$LEFT_TOP_HTML,$html);		
	$html =  str_replace("RIGHT_TOP",$RIGHT_TOP_HTML,$html);	
*/
  $html = restr_html($html); 
  if($menu_name==211){
    echo ' <div class="row"> 
       <div class="col-xs-12 col-md-3">
          <div class="btn-group">'.$all_btn.'  </div>
     </div>
 </div>  ';
  }
  echo '<div class="col-xs-12 col-sm-12"><div class="table-responsive">';
  
      
   if($menu_name==203){ echo'<div class="small-box">';  }
	echo $html_start.$html.$html_end;
   if($menu_name==203){ echo'</div>';  }	
  echo '</div></div>';
     
     echo '</div>';
  echo '</div>';

include_once($path."system/profile_his/report_footer.php");  ?>
</div>

</body>
</html>