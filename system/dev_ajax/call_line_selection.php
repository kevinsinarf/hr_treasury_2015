<?php
// chk_exist.php
// return exist or not to ajax 

 
// header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 

$id= (int)$_GET['id'];


$sql = "   select DISTINCT a.LINE_ID,b.LINE_NAME_TH from POSITION_FRAME a 
left join setup_pos_line b on a.line_id = b.line_id
where a.ACTIVE_STATUS = 1 AND a.POSTYPE_ID = 1 ";
if($id > 0){
$sql .= "  AND b.TYPE_ID = '".$id."' ";
}
$sql .= " ORDER BY b.LINE_NAME_TH ASC   ";
$query_cert_list = $db->query($sql);
?>
   <select id="LINE_ID" name="LINE_ID" class="selectbox chosenElement" placeholder="<?php echo $arr_txt['show_all']; ?>"  style="width:300px;"     onChange=" call_level(this.value,'line');"        >   
    <option value=""  ></option>
      <?php while($rec1 = $db->db_fetch_array($query_cert_list)){?>
        <option value="<?php echo $rec1['LINE_ID']?>"   <?php echo ($rec1['LINE_ID'] == $LINE_ID?"selected":"");?>   >
        <?php echo text($rec1['LINE_NAME_TH'])?></option>
      <?php }?>
    </select>	 
     
 
 