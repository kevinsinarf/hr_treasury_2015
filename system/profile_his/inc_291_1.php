<?php

		
    for($i=1;$i<=45;$i++){ 
	    $title_name = $csv_tite_name[$i]['name'];
	    if(($i==27)||($i==29)){
		   $title_name = $title_name." ".($AGE_IS_gen-1);
		}
	    if(($i==28)||($i==30)){
		   $title_name = $title_name." ".$AGE_IS_gen;
		}
    	$html_start .= " <th style='  '   ><div align='center'><strong>".$title_name."</strong></div></th>
		";
		//$out_header .= $csv_tite_name[$i]['name'].","; //cache it.
	} // for 
	    $out_header .= "ลำดับ,เลขที่ตำแหน่ง,เลขบัตรประชาชน,เพศ,สถานะตำแหน่ง,คำนำ,ชื่อ,นามสกุล,ประเภทตำแหน่ง,โอนมา,วันเกิด,วันบรรจุ,บรรจุกลับ,วันเข้าสู่ระดับปัจจุบัน,อำนวยการสูง,อำนวยการต้น,เชี่ยวชาญ,ชำนาญการพิเศษ (ออกจาก อต.),ชำนาญการพิเศษ,ชำนาญการ,ปฏิบัติการ,อาวุโส,ชำนาญงาน,ปฏิบัติงาน,วันดำรงตำแหน่งปัจจุบัน,วันเกษียณ,เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.),เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.),เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.),เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.),ค่าตอบแทนรายเดือน,ระดับบรรจุ,ชื่อตำแหน่งที่บรรจุ,เงินประจำตำแหน่ง,ตำแหน่งในการบริหาร,ตำแหน่งที่รักษาการ/ปฏิบัติราชการแทน,ส่วนงาน/กลุ่มงาน/ฝ่าย (ที่รักษาการ/ปฏิบัติราชการแทน),ตำแหน่งในสายงาน (กรอบ),ประเภท,ระดับปัจจุบัน,รหัสระดับตำแหน่ง,ระดับ (กรอบ),กลุ่มงาน/ฝ่าย51,สังกัดปฏิบัติ,สังกัดกรอบ";
	    $out_header .= "\r\n";
 
	
    $html_start .= "</tr>
  </thead>";
        // sql from inc_csv_search.php
		$sql .= "  AND a.POSTYPE_ID = 1 " ;
 
		
		$query_who = $db->query($sql ); 
             $list_csv = array();
             while($rec1 = $db->db_fetch_array($query_who)){
			     
					$POS_STATUS = (int)$rec1['POS_STATUS'];
					if($POS_STATUS==1){ $POS_STATUS_NAME = "ว่าง ไม่มีเงิน";  }
					if($POS_STATUS==2){ $POS_STATUS_NAME = "ว่าง มีเงิน";  }
					if($POS_STATUS==3){ $POS_STATUS_NAME = "มีผู้ถือครอง";  }
					if($POS_STATUS==4){ $POS_STATUS_NAME = "ยุบเลิก";  }
					
					$pos_no = $rec1['POS_NO'];
					$id_card = get_idCard($rec1['PER_IDCARD']);
					$gender = $rec1['PER_GENDER'];
					$firstname = text($rec1['PER_FIRSTNAME_TH']);
					$lastname = text($rec1['PER_LASTNAME_TH']);
					$type_name = text($rec1['TYPE_NAME_TH']);
					
					$PER_DATE_BIRTH = conv_date($rec1['PER_DATE_BIRTH'],'short');
					$PER_DATE_ENTRANCE = conv_date($rec1['PER_DATE_ENTRANCE'],'short');
					$PER_DATE_RETIRE = conv_date($rec1['PER_DATE_RETIRE'],'short');
					
					$LINE_NAME_TH = text($rec1['LINE_NAME_TH']);
					$TYPE_NAME_TH = text($rec1['TYPE_NAME_TH']);
					$current_level_name = text($rec1['current_level_name']);
					$LEVEL_SHORTNAME_EN = text($rec1['LEVEL_SHORTNAME_EN']);
					$LEVEL_NAME_TH = text($rec1['LEVEL_NAME_TH']);
					$do_org_shortname = text($rec1['do_org_shortname']);
					$frame_org_name3 = text($rec1['frame_org_name3']);
					
					$PER_SALARY_POSITION = number_format($rec1['PER_SALARY_POSITION'],2);
					$PER_COMPENSATION_1 =  number_format($rec1['PER_COMPENSATION_1'],2);
					$MT_NAME_TH = text($rec1['MT_NAME_TH']); // ตำแหน่งในการบริหาร
					$PREFIX_SHORTNAME_TH = text($rec1['PREFIX_NAME_TH']);
					
					$PER_ID = (int)$rec1['PER_ID'];
					$PER_DATE_LEVEL = conv_date($rec1['PER_DATE_LEVEL'],'short');   
					$PER_DATE_POSITION = conv_date($rec1['PER_DATE_POSITION'],'short');
					
					
					$sql_moveback =  " select TOP 1 a.COM_SDATE
 										from PER_POSITIONHIS a   
										left join SETUP_POS_TYPE c ON a.type_id = c.type_id 
      									left join SETUP_MOVEMENT d ON a.MOVEMENT_ID = d.MOVEMENT_ID
      									left join SETUP_MOVEMENT_PROCESS e ON d.MOVE_PROCESS_ID = e.MOVE_PROCESS_ID
	  									WHERE a.ACTIVE_STATUS = 1 
										AND d.MOVE_PROCESS_ID = 2
										AND a.PER_ID = '".$PER_ID."'    ";
					
					$query_moveback = $db->query($sql_moveback ); 
					$rec_backdate = $db->db_fetch_array($query_moveback);
					$date10 = conv_date($rec_backdate['COM_SDATE'],'short'); 
					
					// บรรจุกลับ
					$sql_bring_back =  " select TOP 1  COM_SDATE from PER_POSITIONHIS a  
										LEFT JOIN SETUP_MOVEMENT b ON a.MOVEMENT_ID = b.MOVEMENT_ID 
										where  a.ACTIVE_STATUS = 1    
										and b.MOVEMENT_CODE = '0046' and a.PER_ID =  '".$PER_ID."' ";
										
										$query_bring_back = $db->query($sql_bring_back ); 
             							$rec_backdate = $db->db_fetch_array($query_bring_back);
									 
										$date_back = conv_date($rec_backdate['COM_SDATE'],'short');
					$per_id_search = "  and a.PER_ID =  '".$PER_ID."'  ";					
					$sdate_filter = $per_id_search."  ORDER BY COM_SDATE ASC    ";					
					// วันเข้าสู่ระดับ	
					
					// อำนวยการสูง		
				 	 $sql15 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1   and type_id = 3  and LEVEL_ID = 6 ";
					 $query_15 = $db->query($sql15 ); 
             		 $rec15 = $db->db_fetch_array($query_15);
					 $date_15 = conv_date($rec15['COM_SDATE'],'short');
					 
					 // อำนวยการต้น 
				 	 $sql16 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1   and type_id = 3  and LEVEL_ID = 7   ".$sdate_filter;
					 $query_16 = $db->query($sql16 ); 
             		 $rec16 = $db->db_fetch_array($query_16);
					 $date_16 = conv_date($rec16['COM_SDATE'],'short');
					 
					 // เชี่ยวชาญ 
				 	 $sql17 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1  and LEVEL_ID = 9   ".$sdate_filter;
					 $query_17 = $db->query($sql17 ); 
             		 $rec17 = $db->db_fetch_array($query_17);
					 $date_17 = conv_date($rec16['COM_SDATE'],'short');
					 
					 // ชำนาญการพิเศษ (ออกจาก อต.) 
					 
				     // ชำนาญการพิเศษ 
				 	 $sql19 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1  and LEVEL_ID = 10   ".$sdate_filter;
					 $query_19 = $db->query($sql19 ); 
             		 $rec19 = $db->db_fetch_array($query_19);
					 $date_19 = conv_date($rec19['COM_SDATE'],'short');
					 
					 // ชำนาญการ 
				 	 $sql20 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1  and LEVEL_ID = 11   ".$sdate_filter;
					 $query_20 = $db->query($sql20 ); 
             		 $rec20 = $db->db_fetch_array($query_20);
					 $date_20 = conv_date($rec20['COM_SDATE'],'short');
					 
					 // ปฏิบัติการ
				 	 $sql21 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1  and LEVEL_ID = 12   ".$sdate_filter;
					 $query_21 = $db->query($sql21 ); 
             		 $rec21 = $db->db_fetch_array($query_21);
					 $date_21 = conv_date($rec21['COM_SDATE'],'short'); 
					 
					 // อาวุโส
				 	 $sql22 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1  and LEVEL_ID = 14   ".$sdate_filter;
					 $query_22 = $db->query($sql22 ); 
             		 $rec22 = $db->db_fetch_array($query_22);
					 $date_22 = conv_date($rec22['COM_SDATE'],'short'); 
					 
					 // ชำนาญงาน
				 	 $sql23 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1  and LEVEL_ID = 15   ".$sdate_filter;
					 $query_23 = $db->query($sql23 ); 
             		 $rec23 = $db->db_fetch_array($query_23);
					 $date_23 = conv_date($rec23['COM_SDATE'],'short');  
					 
					 // ปฏิบัติงาน 
				 	 $sql24 = " select TOP 1  COM_SDATE   from PER_POSITIONHIS a  where  a.ACTIVE_STATUS = 1      and LEVEL_ID = 16   ".$sdate_filter;
					 $query_24 = $db->query($sql24 ); 
             		 $rec24 = $db->db_fetch_array($query_24);
					 $date_24 = conv_date($rec24['COM_SDATE'],'short'); 
					 

					 // * AGE_IS *//
					 // 27 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)
					 $sql27 = " select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'03/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_27 = $db->query($sql27); 
             		 $rec27 = $db->db_fetch_array($query_27);
					 $search27_salary = number_format($rec27['SALARY'],0);
					 // 28 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.)
					 $sql28 =" select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'04/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_28 = $db->query($sql28); 
             		 $rec28 = $db->db_fetch_array($query_28);
					 $search28_salary = number_format($rec28['SALARY'],0);
				  /*
					 
					 // 29 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)
					 $sql29 = " select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen2-1)."') 
					            AND convert(datetime,'03/30/".$AGE_IS_gen2."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_29 = $db->query($sql29); 
             		 $rec29 = $db->db_fetch_array($query_29);
					 $search29_salary = number_format($rec29['SALARY'],0);
					 
					 // 30 ร้อยละในปีงบประมาณ ช่วง 6 เดือนหลัง  (1 เม.ย. - 30 ก.ย.)
					 $sql30 =" select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'04/01/".($AGE_IS_gen2-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen2."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_30 = $db->query($sql30); 
             		 $rec30 = $db->db_fetch_array($query_30);
					 $search30_salary = number_format($rec30['SALARY'],0);
				*/ 
					 $sql29 = " select    SALHIS_TYPE, SALHIS_UP  from PER_SALARYHIS  
                                WHERE    ACTIVE_STATUS = 1  and SALHIS_TYPE = 1  AND    COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'03/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_29 = $db->query($sql29); 
             		 $rec29 = $db->db_fetch_array($query_29);
					 $search29_salary = number_format($rec29['SALHIS_UP'],5);
 
					 $sql30 ="select    SALHIS_TYPE, SALHIS_UP  from PER_SALARYHIS  
                                WHERE    ACTIVE_STATUS = 1  and SALHIS_TYPE = 1  AND      COM_SDATE between convert(datetime,'04/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_30 = $db->query($sql30); 
             		 $rec30 = $db->db_fetch_array($query_30);
					 $search30_salary = number_format($rec30['SALHIS_UP'],5);
    
					 // ชื่อตำแหน่งที่บรรจุ
				 	 $sql33 = "   SELECT TOP 1   a.LINE_ID ,b.LINE_NAME_TH  from PER_POSITIONHIS a  
                                  LEFT JOIN SETUP_POS_LINE b ON a.LINE_ID = b.LINE_ID 
                                  WHERE  a.ACTIVE_STATUS = 1    
								  AND NULLIF(b.LINE_NAME_TH, '') IS NOT NULL  ".$sdate_filter;
					 $query_33 = $db->query($sql33 ); 
             		 $rec33 = $db->db_fetch_array($query_33);
					 $line_33 = text($rec33['LINE_NAME_TH']);  
					 
					 $sql_36 = " select TOP 1 a.PER_ID , b.LEVEL_NAME_TH, c.LINE_NAME_TH from PER_POSITIONHIS a 
LEFT JOIN SETUP_POS_LEVEL b ON a.LEVEL_ID = b.LEVEL_ID  
LEFT JOIN SETUP_POS_LINE c ON a.LINE_ID = c.LINE_ID 

 where a.TYPE_LIVE = 2 ".$per_id_search." order by a.COM_SDATE DESC  ";
					 $query_36 = $db->query($sql_36); 	 
             		 $rec36 = $db->db_fetch_array($query_36);
					 $rec36_line_name = text($rec36['LINE_NAME_TH']);
					 $rec36_level_name = text($rec36['LEVEL_NAME_TH']);
					 
			     $list_csv[$start_no] = array('1'=>number_format($start_no), // ลำดับ
				                              '2'=>$pos_no, // เลขที่ตำแหน่ง
											  '3'=>$id_card, // เลขบัตรประชาชน
											  '4'=>$gender,  // เพศ
											  '5'=>$POS_STATUS_NAME,  // สถานะตำแหน่ง
											  '6'=>$PREFIX_SHORTNAME_TH, // คำนำ
											  '7'=> $firstname, // ชื่อ
											  '8'=> $lastname, // นามสกุล
											  '9'=> $type_name,  // ประเภทตำแหน่ง
											  '10'=>$date10,    // โอนมา
											  '11'=> $PER_DATE_BIRTH,     // วันเกิด
											  '12'=> $PER_DATE_ENTRANCE,  // วันบรรจุ
											  '13'=> $date_back,        // บรรจุกลับ
											  '14'=> $PER_DATE_LEVEL,   // วันเข้าสู่ระดับปัจจุบัน
											  '15'=> $date_15, // อำนวยการสูง positiion his  
											  '16'=> $date_16,   // อำนวยการต้น
											  '17'=> $date_17,   // เชี่ยวชาญ 
											  '18'=> '',         // ชำนาญการพิเศษ (ออกจาก อต.) 
											  '19'=> $date_19,   // ชำนาญการพิเศษ
											  '20'=> $date_20,   // ชำนาญการ
											  '21'=> $date_21,   // ปฏิบัติการ
											  '22'=> $date_22,   // อาวุโส
											  '23'=> $date_23,
											  '24'=> $date_24,
											  '25'=> $PER_DATE_POSITION,    // วันดำรงตำแหน่งปัจจุบัน
											  '26'=> $PER_DATE_RETIRE,
											  '27'=> $search27_salary, // เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)
											  '28'=> $search28_salary, // เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.)
											  '29'=> $search29_salary,
											  '30'=> $search30_salary, // ร้อยละในปีงบประมาณ ช่วง 6 เดือนหลัง  (1 เม.ย. - 30 ก.ย.)
											  '31'=> $PER_COMPENSATION_1,   // ค่าตอบแทนรายเดือน
											  '32'=> '', // ระดับบรรจุ
											  '33'=> $line_33, // ชื่อตำแหน่งที่บรรจุ
											  '34'=> $PER_SALARY_POSITION,
											  '35'=> $MT_NAME_TH, // ตำแหน่งในการบริหาร
											  '36'=> $rec36_line_name, // ตำแหน่งที่รักษาการ/ปฏิบัติราชการแทน
											  '37'=> $rec36_level_name, // ส่วนงาน/กลุ่มงาน/ฝ่าย (ที่รักษาการ/ปฏิบัติราชการแทน)
											  '38'=> $LINE_NAME_TH, // ตำแหน่งในสายงาน (กรอบ)
											  '39'=> $TYPE_NAME_TH, // ประเภท
											  '40'=> $current_level_name, // ระดับปัจจุบัน
											  '41'=> $LEVEL_SHORTNAME_EN, // รหัสระดับตำแหน่ง
											  '42'=> $LEVEL_NAME_TH, // ระดับ (กรอบ)
											  '43'=> '', // กลุ่มงาน/ฝ่าย51
											  '44'=> $do_org_shortname, // สังกัดปฏิบัติ
											  '45'=> $frame_org_name3 // สังกัดกรอบ
											  );
 		$html  .= "<tr  style='height:0.7cm;'> ";
		    for($i=1;$i<=45;$i++){ 
				switch ($i) {
					//case $i>= 6 && $i<=26:
                    case 6:
					case $i>= 10 && $i<=26:
					   $css_do = "RIGHT_TOP";
						break;
					case $i>= 7 && $i<=9:
					case 33:
					case $i>= 35 && $i<=40:
					case 42:
					case 43:
					   $css_do = "LEFT_TOP";
						break;
					default:
					   $css_do = "CENTER_TOP";
				}
				$html .= " <td ".$css_do."  >".$list_csv[$start_no][$i]."</td>
				 ";
			}
 
		$html .= "</tr>";
			 
			$start_no++; 
			
 
			 }
			 
			 
?>