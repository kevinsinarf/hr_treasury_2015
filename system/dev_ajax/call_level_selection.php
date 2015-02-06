<?php
// chk_exist.php
// return exist or not to ajax 

 
// header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 

$id= (int)$_GET['id'];
 
   $sql_level = "select LEVEL_ID, LEVEL_NAME_TH ";
   $sql_level .= " from SETUP_POS_LEVEL  WHERE ACTIVE_STATUS = 1  AND  POSTYPE_ID = 1 "; 
	if($id > 0){
	$sql_level  .= "  AND  TYPE_ID = '".$id."' ";
	}
 
    $sql_level .= " ORDER BY LEVEL_NAME_TH ASC";
	$query_level = $db->query($sql_level); 
?>
                    <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox  chosenElement" placeholder="<?php echo $arr_txt['show_all']; ?>"   style="width:300px;"     >   
                    <option value=""  ></option>
                      <?php while($rec2 = $db->db_fetch_array($query_level)){?>
                        <option value="<?php echo $rec2['LEVEL_ID']?>"  <?php echo ($rec2['LEVEL_ID'] == $LEVEL_ID?"selected":"");?>  >
                        <?php echo text($rec2['LEVEL_NAME_TH'])?></option>
                      <?php }?>
                    </select>  	<?php echo $type; ?> 
     
 
 