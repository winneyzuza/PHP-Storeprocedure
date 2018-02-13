<?php

include('connect.php');

$pTopic = $_GET['topic'];
$pStatement = $_GET['statement'];
$pSelectOperation = $_GET['SelectOperation'];
$pValue = $_GET['Value1'];
$pSelectAction = $_GET['SelectAction'];
$pActive = $_GET['CheckBoxActive'];

/*
$sql_pkey = "SELECT random_num
FROM (
  SELECT LPAD(FLOOR(RAND() * 99999),5,0) AS random_num
)  a
WHERE random_num NOT IN (SELECT PKey FROM validation WHERE  PKey IS NOT NULL)
LIMIT 1";



$rs_pkey = mysql_query($sql_pkey,$mysql_conn);

$row = mysql_fetch_assoc($rs_pkey);

$pKey =$row[random_num];
 * */
 

$sql = "INSERT INTO validation( Validate, DayBranch, Operation, VALUE, ACTION, Active) VALUES ('$pTopic',  '$pStatement', '$pSelectOperation', '$pValue', '$pSelectAction', '$pActive')";

//$rs = mysql_query($sql,$mysql_conn);

if(mysql_query($sql,$mysql_conn)){
     echo "Record inserted successfully";
}else{
    echo "Error inserting record: " . mysql_error($mysql_conn);
}


mysql_close($mysql_conn); 

?>
