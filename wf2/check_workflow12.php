<?PHP
/*
$host = 'shure.scb.co.th'; 
$dbname = 'RBFW';
$user = 'rbfwusr';
$pass = 'rbfw1234!';
*/
 include('connect.php');


$fwdPos = $_GET[fwdPos];
$revPos = $_GET[revPos];
$empid = $_GET[empid];

$fwdBranch = $_GET[fwdBranch]; 
$revBranch = $_GET[revBranch]; 

$branchid = $_GET[branchid];

$reqpos = $_GET[reqPos];

//$dbh = new mysqli($host,$user,$pass,$dbname);

$fwdPos =  str_replace(" ","+",$fwdPos);
$revPos =  str_replace(" ","+",$revPos);

$qryString = "call getApproverByRequest('".$fwdPos. "','" . $revPos. "','" . $empid."',". "'". $branchid . "',".  " '". $fwdBranch . "' ," . "'". $revBranch. "'". "," . "'". $reqpos. "'" ." )";
//echo "qryString " . $qryString;
$qr = $dbh->query($qryString);;
$row = $qr->fetch_assoc();



echo $row['out_approve'];

   


?>