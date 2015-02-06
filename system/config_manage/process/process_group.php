<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//echo '<per>';
//print_r($_POST);
//echo '</pre>';
switch($proc){
	case "add" : 
		try{
			$fields = array(
			   "GROUP_NAME" => ctext($group_name),
			   "ACTIVE_STATUS" => $active_status,
				"DELETE_FLAG" => '0',
				"CREATEBY" => $USER_BY,
				"CREATE_TIMESTAMP" => $TIMESTAMP,
				"UPDATEBY" => $USER_BY,
				"UPDATE_TIMESTAMP" => $TIMESTAMP,
			   );	
			$db->db_insert("aut_group",$fields);
			
			
            $text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edit" : 
		try{
			$fields = array(
			   "group_name" => ctext($group_name),
			   "ACTIVE_STATUS" => $active_status,
				"UPDATEBY" => $USER_BY,
				"UPDATE_TIMESTAMP" => $TIMESTAMP,
			   );	
			$db->db_update("aut_group",$fields," user_group_id = '".$user_group_id."' ");
			
			$text=$edit_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "delete" : 
		try{	
			$db->db_delete("aut_group"," user_group_id = '".$user_group_id."' ");
			
			$text=$delete_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "user_group" : 
		try{
			//db_delete
			if(count($menu) > 0){
				$db->db_delete("aut_group_menu"," user_group_id = '".$user_group_id."' ");
			}
			
			if(count($menu) > 0){
				foreach($menu as $key => $arrMenu){
					if($arrMenu != 1){			
						foreach($arrMenu as $key1 => $arrMenu1){	
							if(array_key_exists("add",$arrMenu1) || array_key_exists("edit",$arrMenu1) || array_key_exists("delete",$arrMenu1)){
								unset($field);
								$field = array(
									"user_group_id" => $user_group_id,
									"menu_id" => $key1,
									"user_add" => $arrMenu1["add"],
									"user_edit" => $arrMenu1["edit"],
									"user_delete" => $arrMenu1["delete"],
								);
								$db->db_insert("aut_group_menu",$field); 
							}elseif(count($arrMenu1) > 0){
								foreach($arrMenu1 as $key2 => $arrMenu2){
									if(array_key_exists("add",$arrMenu2) || array_key_exists("edit",$arrMenu2) || array_key_exists("delete",$arrMenu2)){
										unset($field);
										$field = array(
											"user_group_id" => $user_group_id,
											"menu_id" => $key2,
											"user_add" => $arrMenu2["add"],
											"user_edit" => $arrMenu2["edit"],
											"user_delete" => $arrMenu2["delete"],
										);
										$db->db_insert("aut_group_menu",$field); 
									}elseif(count($arrMenu2) > 0){
										foreach($arrMenu2 as $key3 => $arrMenu3){
											if(array_key_exists("add",$arrMenu3) || array_key_exists("edit",$arrMenu3) || array_key_exists("delete",$arrMenu3)){
												unset($field);
												$field = array(
													"user_group_id" => $user_group_id,
													"menu_id" => $key3,
													"user_add" => $arrMenu3["add"],
													"user_edit" => $arrMenu3["edit"],
													"user_delete" => $arrMenu3["delete"],
												);
												$db->db_insert("aut_group_menu",$field);
											}elseif(count($arrMenu3) > 0){
												foreach($arrMenu3 as $key4 => $arrMenu4){
													unset($field);
													$field = array(
														"user_group_id" => $user_group_id,
														"menu_id" => $key4,
														"user_add" => $arrMenu4["add"],
														"user_edit" => $arrMenu4["edit"],
														"user_delete" => $arrMenu4["delete"],
													);
													$db->db_insert("aut_group_menu",$field);
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			$text=$save_proc;
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}

if($proc=='user_group'){
	$url_back="../disp_menu_group.php";
}else{
	$url_back="../disp_group.php";
}
 
//if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name='form_back' method="post" action="<?php echo $url_back; ?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>" />
    <input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id; ?>" />
    <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id ?>" />
    <input type="hidden" id="user_group_id" name="user_group_id" value="<?php echo $user_group_id ?>" />
</form>
<script>
	alert('<?php echo $text; ?>');
	form_back.submit();
</script>
<?php //}?>