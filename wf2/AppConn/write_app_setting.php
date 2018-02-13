<?php

@header("Content-type: text/xml;  charset=TIS-620"); 




$app=$_GET[app];
unlink("app.txt");
$fp=fopen("app.txt","w+");
fwrite($fp,"app=$app\r\n");
fclose($fp);



?>