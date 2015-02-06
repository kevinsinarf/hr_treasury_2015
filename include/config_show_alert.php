<?php
$b_alert=array(
   //ข้อมูลการเลื่อนเงินนเดือน
	'1_10_11'=>array(
		'label'=>'รอโอนข้อมูลการเลื่อนเงินเดือนเข้าทะเบียนประวัติ',
		'menu_id'=>'10',
		'menu_sub_id'=>'556',
		'sql'=>"SELECT *  FROM SAL_COMMAND WHERE CONFIRM_TYPE = 2 AND  DELETE_FLAG = 0 AND (TRANSFER_STATUS = 0 OR TRANSFER_STATUS IS NULL)",
		'link'=>'profile_his_up_salary_disp.php',
		'level'=>'',
		'cond'=>''
	),	
	
        
);      

if($b_alert){
	foreach($b_alert as $k => $v){ 
		$res_pop[$k]=list_data($v['label'], $v['menu_id'], $v['menu_sub_id'], $v['sql'], $v['link'], $v['level'], $v['cond']);
		
	}
}
?>