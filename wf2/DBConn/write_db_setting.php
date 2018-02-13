<?php

header("Content-type: text/xml;  charset=TIS-620"); 

$db=$_GET[db];
unlink("db.txt");
$fp=fopen("db.txt","w+");
fwrite($fp,"db=$db\r\n");
fclose($fp);

if (($db=="10.0.85.69") || ($db=="10.0.85.57"))
 {
   $db2=$_GET[db_2];
   unlink("db2.txt");
   $fp2=fopen("db2.txt","w+");
   fwrite($fp2,"db=$db2\r\n");
   fclose($fp2);
 }
else
 {
   //get the ip address of the standby server
  $fp_StandbyConn=fopen("http://racf.scb.co.th/RBF/workflow07012011/StandbyConn/db.txt",'r');
  $buffer = fgets($fp_StandbyConn, 255);
  $buffers = explode("=",$buffer);
  $buffers[1] = str_replace("\r","",$buffers[1]);
  $buffers[1] = str_replace("\n","",$buffers[1]);
  fclose($fp_StandbyConn);
  $server_ip = $buffers[1] ;

  //write to db2.txt
  $fp2=fopen("db2.txt","w+");
  fwrite($fp2,"db=$server_ip\r\n");
  fclose($fp2);
  //close db2.txt

 }

echo "$buffers[1]";

?>