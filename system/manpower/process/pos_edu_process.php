<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");

$proc = $_POST['proc'];
$TYPE_ID=$_POST['TYPE_ID'];
$LINE_ID=$_POST['LINE_ID'];
$ARR_KEY=$_POST['KEY'];

$ARR_EL_ID=$_POST['EL_ID'];
$ARR_ED_ID=$_POST['ED_ID'];


$url_back="../pos_edu_form.php";
$table = "SETUP_POS_LINE_DEGREE";
switch($proc){
	case "add" :
		try{
			$sql = "SELECT  * FROM $table WHERE LINE_ID = '".$LINE_ID."' ";
			$query = $db->query($sql);
			$num_row = $db->db_num_rows($query);
			$db->db_delete($table," LINE_ID = '".$LINE_ID."' ");
			
			foreach($ARR_KEY as $key => $val){
			$sql_gr = "SELECT * FROM SETUP_EDU_DEGREE WHERE ED_ID = '".$ARR_ED_ID[$key]."'";	
			$query_r = $db->query($sql_gr);
			$rec_gr = $db->db_fetch_array($query_r);
			$fields = array(
						   "EL_ID" => $ARR_EL_ID[$key],	
						   "ED_ID" => $ARR_ED_ID[$key],
						   "LINE_ID" => $LINE_ID,
						   "EL_GROUP" => $rec_gr['EL_GROUP'],
						   "ACTIVE_STATUS" => 1,
						   "CREATE_BY" =>$USER_BY,
						   "CREATE_DATE" => $TIMESTAMP,
						   );	
				$db->db_insert($table,$fields);
			}
			$text=$save_proc;
			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "get_el_add" :
	    $id_tb = $_POST['id_tb'];
		if($TYPE_ID==1){
			$con = " AND EL_ID IN (4,5,6)";
		}
		if($TYPE_ID==2){
			$con = " AND EL_ID IN (7,8,9)";
		}
		$arr_el = GetSqlSelectArray("EL_ID", "EL_NAME_TH", "SETUP_EDU_LEVEL", "ACTIVE_STATUS='1' and DELETE_FLAG='0' $con "," EL_SEQ ASC");
		$html =  "<div style='margin-bottom:5px;' >".GetHtmlSelect('EL_ID'.$id_tb,'EL_ID[]',$arr_el,'ระดับการศึกษา',' ','onchange="getED(this.value,'.$id_tb.');" ','chosen','1','400')."<div>";
		echo $html;
	break;
	case "get_ed_add":
		$id_tb = $_POST['id_tb'];
		$html =  "<div style='margin-bottom:5px;' >".GetHtmlSelect('ED_ID_'.$id_tb,'ED_ID[]',array(),'วุฒิการศึกษา',' ',' ','chosen','1','400')."<div>";
		echo $html;
	break;
}
if($proc=='add' || $proc=='edit' || $proc=='delete'){
?>
<form name="form_back" method="post" action="<?php echo $url_back;?>">
	<input type="hidden" id="proc" name="proc" value="<?php echo $proc;?>" />
	<input type="hidden" id="menu_id" name="menu_id" value="<?php echo $menu_id;?>" />
	<input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>" />
    <input name="LINE_ID" type="hidden" id="LINE_ID" value="<?php echo $LINE_ID; ?>">
    <input name="TYPE_ID" type="hidden" id="TYPE_ID" value="<?php echo $TYPE_ID; ?>">
</form>
<script>
	alert('<?php echo $text;?>');
	form_back.submit();
</script>
<?php }?>