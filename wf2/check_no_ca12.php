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
if ($startdate_conv[1] == "���Ҥ�")
 {
  $startdate .= "01";
 }
else if ($startdate_conv[1] == "����Ҿѹ��")
 {
  $startdate .= "02";
 }
else if ($startdate_conv[1] == "�չҤ�")
 {
  $startdate .= "03";
 }
else if ($startdate_conv[1] == "����¹")
 {
  $startdate .= "04";
 }
else if ($startdate_conv[1] == "����Ҥ�")
 {
  $startdate .= "05";
 }
else if ($startdate_conv[1] == "�Զع�¹")
 {
  $startdate .= "06";
 }
else if ($startdate_conv[1] == "�á�Ҥ�")
 {
  $startdate .= "07";
 }
else if ($startdate_conv[1] == "�ԧ�Ҥ�")
 {
  $startdate .= "08";
 }
else if ($startdate_conv[1] == "�ѹ��¹")
 {
  $startdate .= "09";
 }
else if ($startdate_conv[1] == "���Ҥ�")
 {
  $startdate .= "10";
 }
else if ($startdate_conv[1] == "��Ȩԡ�¹")
 {
  $startdate .= "11";
 }
else if ($startdate_conv[1] == "�ѹ�Ҥ�")
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
if ($enddate_conv[1] == "���Ҥ�")
 {
  $enddate .= "01";
 }
else if ($enddate_conv[1] == "����Ҿѹ��")
 {
  $enddate .= "02";
 }
else if ($enddate_conv[1] == "�չҤ�")
 {
  $enddate .= "03";
 }
else if ($enddate_conv[1] == "����¹")
 {
  $enddate .= "04";
 }
else if ($enddate_conv[1] == "����Ҥ�")
 {
  $enddate .= "05";
 }
else if ($enddate_conv[1] == "�Զع�¹")
 {
  $enddate .= "06";
 }
else if ($enddate_conv[1] == "�á�Ҥ�")
 {
  $enddate .= "07";
 }
else if ($enddate_conv[1] == "�ԧ�Ҥ�")
 {
  $enddate .= "08";
 }
else if ($enddate_conv[1] == "�ѹ��¹")
 {
  $enddate .= "09";
 }
else if ($enddate_conv[1] == "���Ҥ�")
 {
  $enddate .= "10";
 }
else if ($enddate_conv[1] == "��Ȩԡ�¹")
 {
  $enddate .= "11";
 }
else if ($enddate_conv[1] == "�ѹ�Ҥ�")
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