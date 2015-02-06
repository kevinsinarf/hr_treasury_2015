<?php

	$menu_group_id = $db->get_data_field("select menu_parent_id from aut_menu_setting where menu_id = '".$menu_id."' ","menu_parent_id");
	$sqlMenu2 = "
	with recursive_member as (
		select menu_id , menu_desc , menu_url , menu_img , menu_parent_id , menu_level , menu_group , menu_order from aut_menu_setting where menu_level = '2' and menu_parent_id = '".$menu_id."' and active_status='1'
		
		union all
		
		select a.menu_id , a.menu_desc , a.menu_url , a.menu_img , a.menu_parent_id , a.menu_level , a.menu_group , a.menu_order
		from aut_menu_setting a
		inner join recursive_member b on a.menu_parent_id = b.menu_id
	)
	select * from recursive_member order by menu_parent_id , menu_order asc
	";
	$queryMeu = $db->query($sqlMenu2);
	$queryMenu_1 = $db->query($sqlMenu2);
	$numMenu_1 = $db->db_num_rows($queryMenu_1);
	while($recMenu = $db->db_fetch_array($queryMeu)){
		$recMenu = array_change_key_case($recMenu,CASE_LOWER);
		//echo $recMenu["menu_id"]."==".$recMenu["menu_parent_id"]."==".$recMenu["menu_desc"]."<br>";
		$arrMenu[$recMenu["menu_parent_id"]][] = array("menu_id"=>$recMenu["menu_id"],"desc"=>text($recMenu["menu_desc"]),"url"=>$recMenu["menu_url"]);
	}
	
	if(count($arrMenu[$menu_id]) > 0){
		foreach($arrMenu[$menu_id] as $key => $val){
			if(count($arrMenu[$val["menu_id"]]) > 0){
				$total = 0;
				foreach($arrMenu[$val["menu_id"]] as $keySub => $valSub){
					if(count($arrMenu[$valSub["menu_id"]]) > 0){
						$arrMenu[$val["menu_id"]][$keySub]["group"] = count($arrMenu[$valSub["menu_id"]]);
					}else{
						$arrMenu[$val["menu_id"]][$keySub]["group"] = 0;
					}
					$total += count($arrMenu[$valSub["menu_id"]]);
				}
				$arrMenu[$menu_id][$key]["group"] = $total;
			}
		}
	}
/*echo "<pre>";
print_r($_SESSION["sys_group_menu"]);
echo "</pre>";*/
?>
<div>
<nav class="navbar navbar-default hidden-fix" role="navigation" >
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
      </div>  
        
        <div class="collapse navbar-collapse navbar-ex1-collapse" style="background-color:#F5F5F5;" >
            <ul class="nav navbar-nav">
                <li class="menu-item dropdown">
                    <a href="<?php echo $path; ?>main.php" >หน้าหลัก</a>
                </li>
            </ul>
            <?php
			if($numMenu_1 > 0){
				while($rec_1 = $db->db_fetch_array($queryMenu_1)){
					$sql_2 = "SELECT * FROM AUT_MENU_SETTING WHERE MENU_PARENT_ID = '".$rec_1['menu_id']."' ORDER BY MENU_ORDER ASC ";
					$query_2 = $db->query($sql_2);
					$numMenu_2 = $db->db_num_rows($query_2);
					
					if(@array_key_exists($rec_1["menu_id"],$_SESSION["sys_group_menu"][$menu_group_id][$menu_id])){
						$url = ($rec_1["menu_url"] == "") ? "javascript:void(0);":$rec_1["menu_url"]."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$rec_1["menu_id"]);
						 
						if($numMenu_2 > 0){
							$sql_act = "with recursive_member as (
											select menu_id , menu_desc , menu_url , menu_img , menu_parent_id , menu_level , menu_group , menu_order from aut_menu_setting 
											WHERE menu_id = '".$menu_sub_id."'
												
											union all
											
											select a.menu_id , a.menu_desc , a.menu_url , a.menu_img , a.menu_parent_id , a.menu_level , a.menu_group , a.menu_order
											from aut_menu_setting a
											inner join recursive_member b on a.menu_id = b.menu_parent_id 
										
										)
										select menu_id, menu_parent_id, menu_level, menu_desc  from recursive_member
										WHERE menu_id = '".$rec_1["menu_id"]."' ";
							$query_act = $db->query($sql_act);
							$rec_act = $db->db_fetch_array($query_act);
							//$rec_act=$db->db_fetch_array($db->query("select MENU_PARENT_ID from AUT_MENU_SETTING where MENU_ID='".$menu_sub_id."' "));
							$active=($rec_1["menu_id"]==$rec_act['menu_id']?"active":"");
			 ?>
                            <ul class="nav navbar-nav">
                                <li class="menu-item dropdown <?php echo $active;?> ">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo text($rec_1["menu_desc"]); ?><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                       <?php
										   while($rec_2 = $db->db_fetch_array($query_2)){
											  $sql_3 = "SELECT * FROM AUT_MENU_SETTING WHERE MENU_PARENT_ID = '".$rec_2['MENU_ID']."' ORDER BY MENU_ORDER ASC  ";
											   $query_3 = $db->query($sql_3);
											   $numMenu_3 = $db->db_num_rows($query_3);
											   if($numMenu_3 > 0){
												   
												if(@array_key_exists($rec_2["MENU_ID"],$_SESSION["sys_group_menu"][$menu_group_id][$menu_id][$rec_1["menu_id"]])){
													$url_1 = ($rec_2["MENU_URL"] == "") ?"javascript:void(0);" : $rec_2["MENU_URL"]."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$rec_2["MENU_ID"]);
													
									   ?>
                                        <li class="menu-item dropdown dropdown-submenu">
                                            <a href="<?php echo $url_1; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php  echo text($rec_2["MENU_DESC"]); ?></a>
                                            <ul class="dropdown-menu">
                                            <?php
											while($rec_3 = $db->db_fetch_array($query_3)){
											   
												$sql_4 = "SELECT * FROM AUT_MENU_SETTING WHERE MENU_PARENT_ID = '".$rec_3['MENU_ID']."' ORDER BY MENU_ORDER ASC ";
												$query_4 = $db->query($sql_4);
												$numMenu_4 = $db->db_num_rows($query_4);
												if(@array_key_exists($rec_3["MENU_ID"],$_SESSION["sys_group_menu"][$menu_group_id][$menu_id][$rec_1["menu_id"]][$rec_2["MENU_ID"]])){
													 $url_2 = ($rec_3["MENU_URL"] == "") ?"javascript:void(0);" : $rec_3["MENU_URL"]."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$rec_3["MENU_ID"]);
													if($numMenu_4 > 0){
											?>
                                                <li class="menu-item dropdown dropdown-submenu">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo text($rec_3['MENU_DESC']); ?></a>
                                                    <!--<ul class="dropdown-menu">
                                                        <li>
                                                            <a href="#">Link 3</a>
                                                        </li>
                                                    </ul>-->
                                                </li>
                                              <?php
												  }else{
											 ?>
                                                     <li><a href="<?php echo $url_2; ?>"><?php echo text($rec_3["MENU_DESC"]); ?></a></li>
                                             <?php
												  }
												}
											}
											  ?>
                                            </ul>
                                           </li>
                                        <?php
										  }
										 }else{
												if(@array_key_exists($rec_2["MENU_ID"],$_SESSION["sys_group_menu"][$menu_group_id][$menu_id][$rec_1["menu_id"]])){
													$url = ($rec_2["MENU_URL"] == "") ? "javascript:void(0);":$rec_2["MENU_URL"]."?".url2code("menu_id=".$menu_id."&menu_sub_id=".$rec_2["MENU_ID"]);	
										?>
                                        			<li><a href="<?php echo $url; ?>"><?php echo text($rec_2["MENU_DESC"]); ?></a></li>
                                        <?php
												}
										
										  }
										}
									?>
                                    </ul>
                                </li>
                            </ul>
            
					   <?php
                                        }else{
                                        //active root	
                                        $active=($rec_1["menu_id"]==$menu_sub_id?"active":"");
                        ?>
                                       
                                        <ul class="nav navbar-nav">
                                            <li class="<?php echo $active;?>">
                                              <?php if($rec_1["menu_url"]=="profile_report"){ ?>
                                                <a href="<?php echo $path; ?>system/profile_his/profile_his_report_1_1_2pdf.php?mode=2&<?php echo url2code("menu_id=".$menu_id."&menu_sub_id=".$rec_2["MENU_ID"]); ?>" target="_blank" ><?php echo text($rec_1['menu_desc']); ?></a>
											  <?php  }else{  ?>
                                                <a href="<?php echo $url; ?>" ><?php echo text($rec_1['menu_desc']); ?></a>
                                                <?php } ?>
                                            </li>
                                        </ul>	
                                      	
                        <?php					
                                        }
                                }
                            }
                        }
                ?>  
    		
    	</div>
	</nav>
</div>