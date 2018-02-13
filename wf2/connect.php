<?php

$fp_DBConn=fopen("DBConn/db.txt",'r');
$buffer = fgets($fp_DBConn, 255);
$buffers = explode("=",$buffer);
$buffers[1] = str_replace("\r","",$buffers[1]);
$buffers[1] = str_replace("\n","",$buffers[1]);
fclose($fp_DBConn);


$host = 'localhost'; 
$dbname = 'rbfw';
$user = 'root';
$pass = '';


/*
$mysql_conn = mysql_connect($buffers[1],"rbfwusr","rbfw1234!");
if  (!$mysql_conn)
{
   echo "Error DB ; Contact Admin<br>";
   die('Could not connect: ' . mysql_error());
}

if (($buffers[1]=="10.0.85.57") || ($buffers[1]=="10.0.85.69"))
 mysql_select_db("rbfw",$mysql_conn) ;
else
 mysql_select_db("RBFW",$mysql_conn) ;

mysql_query("SET NAMES TIS620",$mysql_conn);
*/
$buffers[1] = "localhost";

if (($buffers[1]=="10.0.85.57") || ($buffers[1]=="10.0.85.69"))
 {
   $mysql_conn = mysql_connect($buffers[1],"rbfwusr","rbfw1234!");
   
   $dbh = new mysqli($buffers[1], 'rbfwusr', 'rbfw1234!', 'rbfw');
   
   if  (!$mysql_conn)
   {
     echo "Error DB ; Contact Admin<br>";
     die('Could not connect: ' . mysql_error());
   }
 
    if ($dbh->connect_error) {
        die('Connect Error, '. $dbh->connect_errno . ': ' . $dbh->connect_error);
    }
    
  mysql_select_db("rbfw",$mysql_conn) ;
  mysql_query("SET NAMES TIS620",$mysql_conn);
 }
else
 {
   $mysql_conn = mysql_connect($buffers[1].":3306","root","");
   
    $dbh = new mysqli($buffers[1], 'root', '', 'rbfw',3306);  
    
     if ($dbh->connect_error) {
        die('Connect Error, '. $dbh->connect_errno . ': ' . $dbh->connect_error);
    }
    
   if  (!$mysql_conn)
   {
     echo "Error DB ; Contact Admin<br>";
     die('Could not connect: ' . mysql_error());
   }
   
  mysql_select_db("rbfw",$mysql_conn) ;
  mysql_query("SET NAMES TIS620",$mysql_conn);
  
 }
?>
