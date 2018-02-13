<?php
include('connect.php');
$numRow =  $_POST["numRow"];


$flag1 = false;
$flag2 = false;
for ($i = 1; $i <= $numRow; $i++) {
    $PKey = $_POST["PKey".$i];
    $Job =  $_POST["Job".$i];
    $DefaultApp = $_POST["DefaultApp".$i];
    
    $sql = "UPDATE approver SET DefaultApp='". $DefaultApp ."'   WHERE Job= '". $Job."'";			
    
    if(!empty($Job)){
        if( !mysql_query( $sql ) ){
            $flag1 = false;
        }else{
            $flag1 = true;
        }
    }
    
    $CheckBoxActive = $_POST["CheckBoxActive".$i];
    $PKey = $_POST["PKey".$i];
    $SelectApprover = $_POST["SelectApprover".$i];
    $SelectCorp = $_POST["SelectCorp".$i]; 
    $SelectRequestor = $_POST["SelectRequester".$i];
    
    if($CheckBoxActive != 'Y'){
        $CheckBoxActive = 'N';
    }   
    $sql2 = "UPDATE approver SET Approver='". $SelectApprover . "',   Requester = '". $SelectRequestor .  "',   Active = '". $CheckBoxActive . "', CorpStaff = '".  $SelectCorp . "'    WHERE PKey= '". $PKey."'";	
    
    if(!empty($PKey)){
        if( !mysql_query( $sql2 ) ){
            $flag2 = false;
        }else{
            $flag2 = true;
        }
    }
    
}

if ($flag1  && $flag2) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysql_error($mysql_conn);
}
mysql_close($mysql_conn);
?>