<?PHP
header("Content-type: text/xml;  charset=TIS-620"); 

include('connect.php');


/*
$host = 'shure.scb.co.th'; 
$dbname = 'RBFW';
$user = 'rbfwusr';
$pass = 'rbfw1234!';
*/
$startdate=$_GET[sdate];
$enddate=$_GET[edate];
$userid=$_GET[userid];
$targetbranch=$_GET[targetbranch];



if ($targetbranch=="")
 {
  $sql = "select * from scb_emp where eid='$userid'";
  $result = mysql_query($sql, $mysql_conn);
  $row = mysql_fetch_array($result);
  $targetbranch = $row[branch_no];
 }

 
 //convert start date
$startdate_conv = explode(" ", $startdate);
$startdate = $startdate_conv[2]+0-543;
$startdate += "";
$startdate .= "-";
if ($startdate_conv[1] == "มกราคม")
 {
  $startdate .= "01";
 }
else if ($startdate_conv[1] == "กุมภาพันธ์")
 {
  $startdate .= "02";
 }
else if ($startdate_conv[1] == "มีนาคม")
 {
  $startdate .= "03";
 }
else if ($startdate_conv[1] == "เมษายน")
 {
  $startdate .= "04";
 }
else if ($startdate_conv[1] == "พฤษภาคม")
 {
  $startdate .= "05";
 }
else if ($startdate_conv[1] == "มิถุนายน")
 {
  $startdate .= "06";
 }
else if ($startdate_conv[1] == "กรกฎาคม")
 {
  $startdate .= "07";
 }
else if ($startdate_conv[1] == "สิงหาคม")
 {
  $startdate .= "08";
 }
else if ($startdate_conv[1] == "กันยายน")
 {
  $startdate .= "09";
 }
else if ($startdate_conv[1] == "ตุลาคม")
 {
  $startdate .= "10";
 }
else if ($startdate_conv[1] == "พฤศจิกายน")
 {
  $startdate .= "11";
 }
else if ($startdate_conv[1] == "ธันวาคม")
 {
  $startdate .= "12";
 }
$startdate .= "-";
$startdate .= $startdate_conv[0];

//
//convert end date
$enddate_conv = explode(" ", $enddate);
$enddate = $enddate_conv[2]+0-543;
$enddate += "";
$enddate .= "-";
if ($enddate_conv[1] == "มกราคม")
 {
  $enddate .= "01";
 }
else if ($enddate_conv[1] == "กุมภาพันธ์")
 {
  $enddate .= "02";
 }
else if ($enddate_conv[1] == "มีนาคม")
 {
  $enddate .= "03";
 }
else if ($enddate_conv[1] == "เมษายน")
 {
  $enddate .= "04";
 }
else if ($enddate_conv[1] == "พฤษภาคม")
 {
  $enddate .= "05";
 }
else if ($enddate_conv[1] == "มิถุนายน")
 {
  $enddate .= "06";
 }
else if ($enddate_conv[1] == "กรกฎาคม")
 {
  $enddate .= "07";
 }
else if ($enddate_conv[1] == "สิงหาคม")
 {
  $enddate .= "08";
 }
else if ($enddate_conv[1] == "กันยายน")
 {
  $enddate .= "09";
 }
else if ($enddate_conv[1] == "ตุลาคม")
 {
  $enddate .= "10";
 }
else if ($enddate_conv[1] == "พฤศจิกายน")
 {
  $enddate .= "11";
 }
else if ($enddate_conv[1] == "ธันวาคม")
 {
  $enddate .= "12";
 }
$enddate .= "-";
$enddate .= $enddate_conv[0];

//---------

//$dbh = new mysqli($host,$user,$pass,$dbname);

$qryString = "call getMatrixCaFwd('".$startdate. "','" . $enddate. "','" . $userid. "','" . $targetbranch."')";
$qr = $dbh->query($qryString);
//$qr = $dbh->query("call getMatrixCaFwd('2017-09-25','2017-10-25','90002','0111')");


//echo "QRY STR " . $qryString;
$row = $qr->fetch_assoc();

echo $row['final_msg'];


?>