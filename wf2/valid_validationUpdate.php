<?php
include('connect.php');
$numRow =  $_POST["numRow"];


$flag1 = false;

for ($i = 1; $i <= $numRow; $i++) {

    $PKey = $_POST["PKey".$i];
    $SelectOper =  $_POST["SelectOper".$i];
    $Value = $_POST["Value".$i];
    $SelectAction = $_POST["SelectAction".$i];
    $CheckBoxActive = $_POST["CheckBoxActive".$i];
    
 
    if($CheckBoxActive != 'Y'){
        $CheckBoxActive = 'N';
    }   
    
    $sql = "UPDATE validation SET  ACTION = '".$SelectAction."' ,". " Operation='". $SelectOper ."',   Active = '". $CheckBoxActive . "', VALUE = '".  $Value . " '   WHERE PKey= '". $PKey."'";	


    if( mysql_query( $sql ) ){
        $flag1 = true;
    }else{
        $flag1 = false;
    }
    
    
}

if ($flag1) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . mysql_error($mysql_conn);
}
mysql_close($mysql_conn);
?>