<?php
$hostname = "shure.scb.co.th"; 
$dbname= "selfchangpwd"  ;
$user1 = "scbadmin" ;
$pass = "scb1234!" ;
mysql_connect($hostname,$user1,$pass) or die("Can not connect to database ");
mysql_set_charset('tis620');
mysql_select_db($dbname) or die("Can not select database web APP. ");
?>