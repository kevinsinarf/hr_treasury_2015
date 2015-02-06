<?php
phpinfo();

 
$todo = (empty($_POST['todo'])) ? 'default' : $_POST['todo']; 
 
 
if (empty($_POST['todo'])) {
$action = 'default';
} else {
$action = $_POST['todo'];
}

?>