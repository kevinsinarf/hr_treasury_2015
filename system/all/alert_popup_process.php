<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
if($_SESSION['sys_self']=='1'){//self_service
	include($path."include/config_show_alert_self.php");//ข้อความแจ้งเตือน
}else{//เจ้าหน้าที่
	include($path."include/config_show_alert.php");//ข้อความแจ้งเตือน
}
//echo startPaging('ddd',32);
$p_page=$_POST['p_page'];
$cou_page=$_POST['cou_page'];//
	$P_MENU_ID= $_POST['P_MENU_ID'];
	
	$start_page= $p_page==1?1:(($p_page*10)+1)-10;
	$end_page = $p_page*10;
			$i=0;
			$j=1;
			if(count($res_pop)>0){
				foreach($res_pop as $key => $val){
					
					if($val['count']>0){
						if($_SESSION['sys_self']=='1'){//self_service
							$link=$val['link']."?".url2code("self=1".($val['cond']?'&'.$val['cond']:""));
						}else{
							$link=$val['link']."?".url2code("menu_id=".$val['menu_id']."&menu_sub_id=".$val['menu_sub_id'].($val['cond']?'&'.$val['cond']:""));
						}
						if(trim($P_MENU_ID)== $val['menu_id'] ||$P_MENU_ID==''){
						
						
							//echo $j.'<='. $end_page.'==='.$j.'>='.$start_page.'<br>';
						if( $j <= $end_page && ( $j >=  $start_page )){
						?>
						<tr>
							<td align="center"><small><?php echo $val['date'];?></small></td>
							<td align="center"><small><?php echo Showmenu($val['menu_id']);?></small></td>
							<td align="left"><small><?php echo $val['label'];?></small></td>
							<td align="center"><small><b><a href="<?php echo $link;?>"><?php echo $val['count'];?></a></b></small></td>
						</tr>
						<?php 
						$i++;
						}
						}
						$j++;
					}
				}
			}
			
			if($i==0){
				echo "<tr><td align=\"center\" colspan=\"4\">".$arr_txt['data_not_found']."</td></tr>";
			}
			
	
			?>