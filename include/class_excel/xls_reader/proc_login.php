<?php 
	ob_start();
   session_start ();
   $path = './';
   include ($path.'include/config.inc.php');
   include ($path.'include/class_db.php');
   include ($path.'include/class_login.php');
   include ($path.'include/class_display.php');
   include ($path.'include/system_string.php');
   include ($path.'include/class_application.php'); 

   $CLASS['db']   = new db();
   $CLASS['db']->connect ();

   $CLASS['disp'] = new display();
   $CLASS['str']  = new strings();
   $CLASS['app'] = new application();
   
   $LOGIN = $u_name; //username
   $PWD   = $pass; // password
   $CLASS['log'] = new login();
   
    $db   = $CLASS['db'];
	$disp = $CLASS['disp'];
	$log  = $CLASS['log'];
	$str  = $CLASS['str'];
	$app = $CLASS['app'];  
 
	if ($proc=='login') {
        if (($result=$log->chk_login ()) != false)  { 
			 //Auto logout //
			session_unregister ("LOGUSER");
			session_unregister ("LOGNAME");  
			session_unregister ("LOGLEVEL");
			session_unregister ("LOGUSERID");
			session_unregister ("LOGID");   
			session_unregister ("LOGFUNCTION");  
			//----------------//
			session_register ("LOGUSER");
			session_register ("LOGID");
			session_register ("LOGNAME");  
			session_register ("LOGLEVEL");
			session_register ("LOGUSERID"); 
			session_register ("LOGFUNCTION");  
 
             $LOGUSER = $LOGIN; 
			 $LOGUSERID = $result['user_id'];
			 $LOGFUNCTION = $result['admin_commit']; // 0 -> none ;1 -> this user is administrator 
			 if($LOGFUNCTION){
				$LOGNAME = '¼Ùé´ÙáÅÃÐºº';
			 } else {
			 	$LOGID = $result['staff_id'];    
				$LOGLEVEL  = $db->get_data_field("SELECT * FROM staff_role WHERE staff_id LIKE '$LOGID' ORDER BY role_id","role_id");
				$LOGNAME = $app->show_staff_name ($LOGID,'th');  
			 }  
				 header ('location:home/home.php'); 
		}else {
            $disp->set_tag_script ("alert ('Can not log in. Please try again. ');history.back ();");           
		}
	}else if ($proc=='logout') {
         //$log->set_logout ($log->get_usr_code_f_sid ($SID));
		 	session_unregister ("LOGUSER");
			session_unregister ("LOGNAME");  
			session_unregister ("LOGLEVEL");
			session_unregister ("LOGUSERID");
			session_unregister ("LOGID");   
			session_unregister ("LOGFUNCTION");  
		 header ("location:index.php");
	} 
	$db->close_db ();
	ob_end_flush();
?>
<!-- <meta http-equiv="Content-Type" content="text/html; charset=windows-874"> -->