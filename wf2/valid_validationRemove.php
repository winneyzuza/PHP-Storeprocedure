<?php
include('connect.php');

$pkey = $_GET['param'];

$sql = "DELETE FROM validation WHERE PKey= '". $pkey."'";

$rs = mysql_query($sql,$mysql_conn);


if (mysql_affected_rows() > 0) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . mysql_error($mysql_conn);
}

?>
