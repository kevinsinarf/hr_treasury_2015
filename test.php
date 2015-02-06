<?php
$code_txt = 'e7e88ee56be19147f175b818275d6657';
echo $code_pass = hash_hmac('md5','admin',$code_txt);
?>