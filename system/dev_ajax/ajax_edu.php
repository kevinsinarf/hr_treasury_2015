<?php   header ('Content-type: text/html; charset=utf-8');
$path = "../../";
include($path."include/config_header_top.php");
 //echo "<pre>"; print_r($_GET); exit();
 
 
 
 
 
 

 
 
 
 
 
 
 
function mssql_escape($data) {
    if(is_numeric($data))
        return $data;
    $unpacked = unpack('H*hex', $data);
    return '0x' . $unpacked['hex'];
}

function mssql_escape2($str)
{
   
    if(get_magic_quotes_gpc())
    {
        $str= stripslashes($str);
    }
    return str_replace("'", "''", $str);
}

function ms_escape_string($data) {
        if ( !isset($data) or empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
			 
        );
        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );
		
        
		
		
        return $data;
    }
	
function str_safe($EM_name=''){
   $EM_name = str_replace('"','&quot;',$EM_name);
   $EM_name = str_replace("'","&acute;",$EM_name);
   return $EM_name;
}	
	
function uEntities_Callback($m) {
    $d = hexdec($m[1] . $m[2] . $m[3] . $m[4]);
    if ($d >= 3585 && $d <= 3675)
        return chr($d - 3424);
    return '&#' . $d;
}
function uEntities($x) {
    return preg_replace_callback('~%u([0-9a-f])([0-9a-f])([0-9a-f])([0-9a-f])~i', 'uEntities_Callback', $x);
}
	

$row = array();
$return_arr = array();
$row_array = array();

// check type  
if((isset($_GET['whattype']) && (strlen($_GET['whattype']) > 0))){
   $whattype = $_GET['whattype'];
}else{
 exit(); // don't do anything if it not right.
}

$table = "";
$sql = "";

switch ($whattype) {
  case "EL":
	 // $table = "SETUP_EDU_LEVEL";
	 // $select = "   select ".$whattype."_ID,".$whattype."_GROUP, ".$whattype."_NAME_TH, ".$whattype."_TYPE ";
	 $sql1 = "select EL_ID,EL_GROUP, EL_NAME_TH, EL_TYPE from SETUP_EDU_LEVEL where ACTIVE_STATUS='1' and DELETE_FLAG='0' ";
	 $sql2 = " order by EL_TYPE, EL_ID";
	 $search_me =  $whattype."_NAME_TH";
	  break;

  case "ED":
	 // $table = "SETUP_EDU_DEGREE";
	 // $select = "   select ".$whattype."_ID,".$whattype."_GROUP, ".$whattype."_NAME_TH, ".$whattype."_TYPE ";
	 if((isset($_GET['EL_ID']) && is_numeric($_GET['EL_ID']))){
	 	$EL_GROUP = $_GET['EL_ID'];
	 }
	 
	 $sql1 = "SELECT ED_ID , (CASE WHEN ED_NAME_TH IS NULL OR ED_NAME_TH = '' THEN ED_NAME_EN ELSE ED_NAME_TH END) AS ED_NAME from SETUP_EDU_DEGREE 
                    WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND EL_ID = '".$EL_ID."' ";
	 $sql2  = " ORDER BY (CASE WHEN ED_NAME_TH IS NULL OR ED_NAME_TH = '' THEN ED_NAME_EN ELSE ED_NAME_TH END) ASC ";
	 $search_me =  $whattype."_NAME_TH";
	  break;
	  
	  
  case "EM":
 
	 
	 $sql1 = "SELECT EM_ID, 
				  (CASE WHEN EM_NAME_TH IS NULL OR EM_NAME_TH = '' THEN EM_NAME_EN ELSE EM_NAME_TH END) AS EM_NAME_TH
 				  FROM SETUP_EDU_MAJOR 
 				  WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' 
				  ";
	 $sql2  = " ORDER BY (CASE WHEN EM_NAME_TH IS NULL OR EM_NAME_TH = '' THEN EM_NAME_EN ELSE EM_NAME_TH END) ASC ";
	 $search_me =  $whattype."_NAME_TH";
	  break; 
	  
	  
  case "INS":
 
	 
	 $sql1 = "SELECT INS_ID, (CASE WHEN INS_NAME_TH IS NULL OR INS_NAME_TH = '' THEN INS_NAME_EN ELSE INS_NAME_TH END) AS INS_NAME_TH
               FROM SETUP_EDU_INSTITUTE 
               WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' 
			   
				  ";
	 $sql2  = " ORDER BY (CASE WHEN INS_NAME_TH IS NULL OR INS_NAME_TH = '' THEN INS_NAME_EN ELSE INS_NAME_TH END) ASC";
	 $search_me =  $whattype."_NAME_TH";
	  break; 

  default:
      exit();
    break;
}


// check search.
if((isset($_GET['q']) && strlen($_GET['q']) > 0) || (isset($_GET['id']) && is_numeric($_GET['id'])))
{  

    if(isset($_GET['q']))
    {    
        $getVar = $_GET['q'];     //  ms_escape_string($_GET['term']);  //$db->real_escape_string($_GET['term']);
	 
        $whereClause =  " AND ".$whattype."_NAME_TH LIKE '%" . ctext($getVar) ."%' ";
    }
    elseif(isset($_GET['id']))
    {
        $whereClause =  " AND ".$whattype."_NAME_TH = $getVar ";
    }
    /* limit with page_limit get */

    $limit = intval($_GET['page_limit']);

   // $sql = $select."  from ".$table." where ACTIVE_STATUS='1' and DELETE_FLAG='0' ".$whereClause." order by ".$whattype."_TYPE, ".$whattype."_ID ";
    $sql = $sql1.$whereClause.$sql2;
 
    /** @var $result MySQLi_result */
    ///$result = $db->query($sql);
	$query_cert_list = $db->query($sql);
 
    $nums = $db->db_num_rows($query_cert_list);
 
       // if($result->num_rows > 0)
        //{
		
	echo '{ ';
	echo '  "items": [ ';
    $i=1;
    while($row = $db->db_fetch_array($query_cert_list)){  
	
           if($whattype=="EL"){ 
		     $EL_name = text($row['EL_NAME_TH']);
           	 echo '{"id":'.$row['EL_ID'].',"name":"'.$EL_name.'" , "EL_GROUP":"'.text($row['EL_GROUP']).'"}';
		   }
           if($whattype=="ED"){ 
		       $ED_name = text($row['ED_NAME']);
           	 echo '{"id":'.$row['ED_ID'].',"name":"'.str_safe($ED_name).'" }';
		   }
           if($whattype=="EM"){ 
		       $EM_name = text($row['EM_NAME_TH']);
           	 echo '{"id":'.$row['EM_ID'].',"name":"'.str_safe($EM_name).'" }';
		   }
		   
           if($whattype=="INS"){ 
		       $ins_name = text($row['INS_NAME_TH']);
           	 echo '{"id":'.$row['INS_ID'].',"name":"'.str_safe($ins_name).'" }';
		   }
		   
		   if($i<$nums){
		   echo ',';
		   }
		   $i++;
		/*
                $row_array['id'] = $row['EL_ID'];
                $row_array['text'] = text($row['EL_NAME_TH']);
                array_push($return_arr,$row_array);
				*/
  } 
    echo ']}';	 exit();
        //}
}
else
{ 
    $row_array['id'] = 0;
    $row_array['text'] = '';// utf8_encode('เริ่มการค้นหา....');
    array_push($return_arr,$row_array);

}

$ret = array();
/* this is the return for a single result needed by select2 for initSelection */
if(isset($_GET['id']))
{    
    $ret = $row_array;
}
/* this is the return for a multiple results needed by select2
* Your results in select2 options needs to be data.result
*/
else
{   //  $return_arr['sql'] = $sql.$_GET['term'];
    $ret['results'] = $return_arr;
}
//echo json_encode($ret);

exit();
 
//echo json_encode($ret2);

?>  
