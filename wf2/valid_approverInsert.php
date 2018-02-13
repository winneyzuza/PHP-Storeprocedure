<?php
include('connect.php');

$pJob = $_GET['job'];
$pRole = $_GET['role'];
$pCorp = $_GET['SelectCorp'];
$pApprv = $_GET['SelectApprover'];

$pReqType = $_GET['SelectRequester'];

$pDefaultApprv = $_GET['SelectDefaultApp'];
$pActive = $_GET['CheckBoxActive'];

$pRole =  str_replace(" ","+",$pRole);

$sql = "INSERT INTO approver(Job,Role,Requester,Approver,DefaultApp,Active,CorpStaff) VALUES ('$pJob',  '$pRole',  '$pReqType', '$pApprv', '$pDefaultApprv', '$pActive' ,'$pCorp')";


if(mysql_query($sql,$mysql_conn)){
    echo "Record inserted successfully";
} else {
    echo "Error inserting record: " . mysql_error($mysql_conn);
}
mysql_close($mysql_conn);

?>
