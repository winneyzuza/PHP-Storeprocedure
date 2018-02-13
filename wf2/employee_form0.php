<?php
session_start();

if ($_SESSION["login"]=="")
 {
  print
  "
   <script language=\"javaScript\">
   window.location = \"http://racf.scb.co.th/RBF/workflow07012011/workflow.php\";
   </script>
  ";
 }

$eid = $_GET[eid];
$hr_pos = $_GET[hr_pos];
$branch_no = $_GET[branch_no];
$branch_name = $_GET[branch_name];
$area_name = $_GET[area_name];
$network_name = $_GET[network_name];
$branch_operating_days = $_GET[branch_operating_days];
$branch_total_employees = $_GET[branch_total_employees];
$branch_type = $_GET[branch_type];
$branch_opened_date = $_GET[branch_opened_date];
$job_duration = $_GET[job_duration];
$read_draft = $_GET[read_draft];

//echo "br no ". $branch_no. " area_name ". $area_name . " network_name " . $network_name;

$reqPosition = "";
if ( $branch_no <> "" )  {
    $reqPosition = "BM";
}
else{
    
    if ($area_name <> "" and $network_name <> "" ){
        
        $reqPosition = "AM";
        
    }else if($area_name = "" and $network_name <> ""){
        
         $reqPosition = "NM";
    }else{
        
         $reqPosition = "OTH";
    }
    
}

echo "reqPos " . $reqPosition;
include ('search/connect.php');  //ดึงเวลาเปิด/ปิดระบบ
        $sql="SELECT time_br,time_district,time_network FROM time_system WHERE tid='tm002' ;";		
		$result=mysql_query($sql,$connect);		
		while($read=mysql_fetch_array($result)){
		  $time_br=$read['time_br'];
		  $time_dist=$read['time_district'];
		  $time_netw=$read['time_network'];
		}//end while 
         mysql_close($connect);

//echo "time_br=$time_br<br>";

if (!(strstr($network_name, "เครือข่าย") || strstr($network_name, "ภาคศูนย์การค้า") || strstr($hr_pos, "เครือข่ายสาขา") || strstr($hr_pos, "เจ้าหน้าที่สนับสนุน") || ($branch_no) || strstr($hr_pos,"บริหารความปลอดภัยผู้ใช้บริการเทคโนโลยีสารสนเทศ") || strstr($hr_pos,"ผู้จัดการความปลอดภัยระบบเทคโนโลยีสารสนเทศและระบบงาน")))
 {
  echo "ERROR: ท่านไม่สามารถใช้แบบฟอร์มโยกย้ายได้เนื่องจากไม่ใช่พนักงาน สาขา, เขต, เครือข่าย<br><br><br>กรุณาเลือกเมนู 'รายงาน'";
  return;
 }
else if ($hr_pos=="ผู้ช่วยผู้จัดการใหญ่อาวุโส เครือข่ายสาขา")
 {
  return;
 }
 
 //set time zone
 date_default_timezone_set('Asia/Bangkok');


 //get date
 $today="";
 if ($today=="")
 {
  $today = getdate();
  $today_day = $today["mday"]+0;
  $today_day = sprintf("%02d", $today_day);
  //$today_day  += "";
  $today_month = $today["mon"]+0;
  $today_month = sprintf("%02d", $today_month);
  //$today_month += "";
  $today_year = $today["year"];
 }

 //get time
 $localtime_assoc="";
 if ($localtime_assoc=="")
 {
  $localtime_assoc = localtime(time(), true);
  $localtime_assoc[tm_hour] = $localtime_assoc[tm_hour] + 0;
  $localtime_assoc[tm_min]  = $localtime_assoc[tm_min]  + 0;
  $localtime_assoc[tm_sec]  = $localtime_assoc[tm_sec]  + 0;
  $localtime_assoc[tm_hour] = sprintf("%02d", $localtime_assoc[tm_hour]);
  //$localtime_assoc[tm_hour] = $localtime_assoc[tm_hour] + "";
  $localtime_assoc[tm_min] = sprintf("%02d", $localtime_assoc[tm_min]);
  //$localtime_assoc[tm_min]  = $localtime_assoc[tm_min]  + ""; 
  $localtime_assoc[tm_sec] = sprintf("%02d", $localtime_assoc[tm_sec]);
  //$localtime_assoc[tm_sec]  = $localtime_assoc[tm_sec]  + "";
 } 
 
if (1)
 {
  $time = "$localtime_assoc[tm_hour]:$localtime_assoc[tm_min]:$localtime_assoc[tm_sec]";
  
 
  
  print
  "
  <script language=\"javaScript\">
   var mytime = \"<?php $time ?>\";
   mytime = mytime.split(' ');
   mytime  = mytime[1];
   //alert('เวลาขณะนี้คือ ' + mytime + '(ระบบจะหยุดให้บริการเวลา 17:00-05:00)');
  </script>
  ";

  //echo "time_br=$time_br<br>";

  $time_br = 20;
  $time_dist= 18;
  $localtime_assoc[tm_hour] += 0;
  //$time_br += 0;  
  if ($branch_no!="")
   {
    if ($localtime_assoc[tm_hour] >= $time_br)
     {
      echo "ระบบปิดบริการ 17:00-05:00";
      return;
     } 
    else if ($localtime_assoc[tm_hour] < 5)
     {
      echo "ระบบปิดบริการ  17:00-05:00";
      return;
     }
   }  
  else if ($area_name != "")
   {
     if ($localtime_assoc[tm_hour] >= $time_dist)
     {
      echo "ระบบปิดบริการ 18:00-05:00";
      return;
     } 
    else if ($localtime_assoc[tm_hour] < 5)
     {
      echo "ระบบปิดบริการ  17:00-05:00";
      return;
     }
   }  
  else if ($network_name != "")
   {
     if ($localtime_assoc[tm_hour] >= $time_netw)
     {
      echo "ระบบปิดบริการ 20:00-05:00";
      return;
     } 
    else if ($localtime_assoc[tm_hour] < 5)
     {
      echo "ระบบปิดบริการ  17:00-05:00";
      return;
     }
   }  
    
 } 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<style type="text/css">
   .GreyTextBox
   {
    background-color: #000;
    color: black;
    border-style: none;
   }
   .smallfont
   {
    font-size: x-small;
   }
   .FormDropdown 
   {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 15px;
	width: 100px;
	behavior:url(EditableDropdown.htc);
   }
   .FormDropdown_Reason
   {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 150px;
	behavior:url(EditableDropdown.htc);
   }
   .NormalDropdown 
   {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 120px;	
   }
   .FormTextbox
   {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
   }
   

   BODY
   {      
      font-size: xx-large;
   }
.style2 {color: #0000FF}
.style4 {color: #FF0000}
    
</style>
</head>

<body bgcolor="#FFFFFF">

<script type="text/javascript" src="js/CalendarPopup.js"></script>
<script type="text/javascript" src="js/Ajax.js"></script>
<script type="text/javascript" src="js/Show_HR_Info.js"></script>
<script type="text/javascript" src="js/balloon.config.js"></script>
<script type="text/javascript" src="js/balloon.js"></script>
<script type="text/javascript" src="js/box.js"></script>
<script type="text/javascript" src="js/yahoo-dom-event.js"></script>
 

<script language="javaScript">
 var cal = new CalendarPopup();
 cal.setMonthNames("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
 cal.setDayHeaders("อ","จ","อ","พ","พฤ","ศ","ส");
 cal.setTodayText("วันนี้");
 
 // white balloon with default configuration
 // (see http://gmod.org/wiki/Popup_Balloons)
 var balloon    = new Balloon;
 

 // plain balloon tooltip
 var tooltip  = new Balloon;
 BalloonConfig(tooltip,'GPlain');

 // fading balloon
 var fader = new Balloon;
 BalloonConfig(fader,'GFade');   

 // a plainer popup box
 var box         = new Box;
 BalloonConfig(box,'GBox');

 // a box that fades in/out
 var fadeBox     = new Box;
 BalloonConfig(fadeBox,'GBox');
 fadeBox.bgColor     = 'black';
 fadeBox.fontColor   = 'white';
 fadeBox.borderStyle = 'none';
 fadeBox.delayTime   = 200;
 fadeBox.allowFade   = true;
 fadeBox.fadeIn      = 750;
 fadeBox.fadeOut     = 200;
</script>
  <div id="sending_status">
    <p align="left" class="style2" style="font-size:10pt; class="style1">กรุณากดส่งเพียงครั้งเดียว <span class="style4">(<u><strong>กดซ้ำ ทำให้เกิดความผิดผลาดในรายการของท่าน</strong></u>) *** </span></span></p>
</div>

<form name="rbfront_form" action="save_transfer_request0.php" method="post" onSubmit="return submit_form();">
<?php

//Target=\"_blank\"

include('connect.php');

$mysql_reason_result = NULL;
$mysql_reason_result = mysql_query("select distinct description from reason");
if ($mysql_reason_result  == NULL)
 {
  echo "ERROR: Problem with conducting sql query(Reason)";
  return;
 }


$mysql_rbfrontposition_result = NULL;
$mysql_rbfrontposition_result = mysql_query("select distinct short_position from level_template where type='BRANCH' order by short_position ASC");
if ($mysql_rbfrontposition_result  == NULL)
 {
  echo "ERROR: Problem with conducting sql query(short position)";
  return;
 }
$rbfront_position=NULL;
$rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result );
if ($rbfront_position==NULL)
{
  echo "ERROR: no record for rbfront position template";
  return;
}
$mysql_currentrbfrontposition_result = NULL;
$mysql_currentrbfrontposition_result = mysql_query("select * from limit_emp where eid='$eid'");
$cur_rbfront_positon = mysql_fetch_array($mysql_currentrbfrontposition_result);
mysql_close($mysql_conn);
//print_r($rbfront_position);

print
"
<input type=\"hidden\" name=\"dataentry_branch_no\" id=\"dataentry_branch_no\" value=\"$branch_no\">
<input type=\"hidden\" name=\"dataentry_area_name\" id=\"dataentry_area_name\" value=\"$area_name\">
<input type=\"hidden\" name=\"dataentry_network_name\" id=\"dataentry_network_name\" value=\"$network_name\">
<input type=\"hidden\" name=\"dataentry_eid\" id=\"dataentry_eid\" value=\"$eid\">
<input type=\"hidden\" name=\"dataentry_hrpos\" id=\"dataentry_hrpos\" value=\"$hr_pos\">
<input type=\"hidden\" name=\"dataentry_brname\" id=\"dataentry_brname\" value=\"$branch_name\">
<input type=\"hidden\" name=\"dataentry_br_op_days\" id=\"dataentry_br_op_days\" value=\"$branch_operating_days\">
<input type=\"hidden\" name=\"dataentry_br_total_emp\" id=\"dataentry_br_total_emp\" value=\"$branch_total_employees\">
<input type=\"hidden\" name=\"dataentry_br_type\" value=\"$branch_type\">
<input type=\"hidden\" name=\"dataentry_br_opened_date\" value=\"$branch_opened_date\">
<input type=\"hidden\" name=\"dataentry_job_duration\" value=\"$job_duration\">
";

if ($branch_no != "")
 {
  
 }
else
 {
  if ($area_name != "")
   {
    
   }
  else
   {
    
   }
 }


?>
<table border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#000000">
<?php

$No = "No";
$UserID = "UserID";
$FullName = "FullName";
$JobTitle = "JobTitle";
$YearsInSCB = "YearsInSCB";
$CurrentRBFrontPosition = "CurrentRBFrontPosition";
$NewRBFrontPosition = "NewRBFrontPosition";
$ReturnRBFrontPosition = "ReturnRBFrontPosition";
$StartDate = "StartDate";
$EndDate = "EndDate";
$ReturnPosition = "ReturnPosition";
$test = "กขค";
$CurrentLimit = "CurrentLimit";
$NewLimit = "NewLimit";
$ReturnLimit = "ReturnLimit";
$CurrentBranchNo = "CurrentBranchNo";
$NewBranchNo = "NewBranchNo";
$progress1 = "progress1";
$progress2 = "progress2";
$progress3 = "progress3";
$progress4 = "progress4";
$progress5 = "progress5";
$progress6 = "progress6";
$progress7 = "progress7";
$progress8 = "progress8";
$progress9 = "progress9";
$progress10 = "progress10";
$Redirected_Newbranchno = "Redirected_Newbranchno";
$Redirected_Returnbranchno = "Redirected_Returnbranchno";
$Reason = "Reason";
$ReturnBranchNo = "ReturnBranchNo";
$WorkFlow1 = "WorkFlow1";
$WorkFlow2 = "WorkFlow2";
$WorkFlow3 = "WorkFlow3";
$WorkFlow4 = "WorkFlow4";
$WorkFlowTable = "WorkFlowTable";
$WorkFlowTableRow1 = "WorkFlowTableRow1";
$WorkFlowTableRow2 = "WorkFlowTableRow2";

for ($i = 1 ; $i <= 11 ; $i++)     //up to 50 transfers and another 50 on return positons.
  {
   if ($i == 1)
    {
?>
      <tr bgcolor="#999999" align = "center" >
	<td nowrap><b><p style="font-size:10pt;">No.</p></b>      </td>
      	<td  nowrap ><b><p style="font-size:10pt;">User ID</p></b>      </td>
      	<td  nowrap><b><p style="font-size:10pt;">ชื่อ</p></b>    </td>
      	<td  nowrap><b><p style="font-size:10pt;">Job Title</p></b>      </td>
      	<td nowrap><b><p style="font-size:10pt;">อายุงาน(ปี)</p> </b>     </td>
<?php
     if ($branch_no == "")
      {
?>
        <td nowrap><b><p style="font-size:10pt;">สาขาปัจจุบัน</p></b>       </td>
<?php
      }
?>   
        <td nowrap><b><p style="font-size:10pt;">ตำแหน่งปัจจุบัน</p></b></td> 
<?php
     if ($branch_no == "")
      {
?>
        <td nowrap><b><p style="font-size:10pt;">สาขาใหม่</p></b>        </td>  
<?php
      }
?>  
      <td nowrap><b><p style="font-size:10pt;">ตำแหน่งใหม่</p></b>      </td>      
      <td nowrap><b><p style="font-size:10pt;">วงเงิน(ใหม่)</p></b>      </td>    
      <td nowrap><b><p style="font-size:10pt;">เริ่ม</p> </b>    </td>
      <td nowrap><b><p style="font-size:10pt;">สิ้นสุด</p> </b>     </td>
<?php
     if ($branch_no == "")
      {
?>
        <td nowrap><b><p style="font-size:10pt;">กลับสาขา</p></b>      </td>
<?php
      }
?>
      <td>      <b><p style="font-size:10pt;">กลับตำแหน่ง</p></b>     </td>
      <td nowrap><b><p style="font-size:10pt;">วงเงิน(กลับ)</p></b>      </td>  
      <td>      <b><p style="font-size:10pt;">เหตุผล</p></b>   </td>
      <td>      <b><p style="font-size:10pt;">การอนุมัติ</p></b>    </td>
     </tr>
<?php
   }
   else
   {
    

    $ac_row = $i - 1;
?>
    <tr bgcolor="#FFFFFF">
     <td nowrap align="center"><div id="<?php print "row".$ac_row.$No; ?>" name="<?php print "row".$ac_row.$No; ?>" style="position: relative; width: 25px; height: 15px;font-size:10pt;"><p style="font-size:10pt;"></p></div>     </td>
     <input type="hidden" id="<?php print "hiddenrow".$ac_row.$No; ?>" name="<?php print "hiddenrow".$ac_row.$No; ?>" value="">
      <td><input type="text"  name="<?php print "row".$ac_row.$UserID; ?>" class="FormTextbox" id="<?php print "row".$ac_row.$UserID; ?>" size=5 maxlength="5" value="" style="background-color: #33CCFF;color: #000000;" onKeyUp="Display_Full_Emp_Info(this.value, '<?php print $branch_no; ?>' ,'<?php print $ac_row; ?>', '<?php print $area_name; ?>', '<?php print $network_name; ?>');"       onkeypress="Display_Full_Emp_Info(this.value,'<?php print $branch_no; ?>' ,'<?php print $ac_row; ?>','<?php print $area_name; ?>', '<?php print $network_name; ?>');"  ondblclick="alert('double-click is not supported in the userid box!');">
     </td>
     <td nowrap><div id="<?php print "row".$ac_row.$FullName; ?>" class="FormTextBox" style="position: relative; width: 15px; height: 15px;font-size:10pt;"><p style="font-size:10pt;"></p></div> </td>
     <input type="hidden" id="<?php print "hiddenrow".$ac_row.$FullName; ?>" name="<?php print "hiddenrow".$ac_row.$FullName; ?>" value="">
     <td nowrap><div id="<?php print "row".$ac_row.$JobTitle; ?>" class="FormTextBox" style="position: relative; width: 15px; height: 15px;font-size:10pt;"><p style="font-size:10pt;"></p></div></td>
     <input type="hidden" id="<?php print "hiddenrow".$ac_row.$JobTitle; ?>" name="<?php print "hiddenrow".$ac_row.$JobTitle; ?>" value="">
     <td nowrap align="center"><div id="<?php print "row".$ac_row.$YearsInSCB; ?>" style="position: relative; width: 15px; height: 15px;font-size:10pt;"><p style="font-size:10pt;"></p></div>     </td>
     <input type="hidden" id="<?php print "hiddenrow".$ac_row.$YearsInSCB; ?>" name="<?php print "hiddenrow".$ac_row.$YearsInSCB; ?>" value="">     

<?php
     if ($branch_no != "")
      {
       
      }
     else
	{
      ?>
       <td nowrap align="center">
        <input type="text"  class="FormTextbox" name="<?php print "row".$ac_row.$CurrentBranchNo; ?>" id="<?php print "row".$ac_row.$CurrentBranchNo; ?>" size=5 /
			maxlength="5" value="" onKeyPress="Prevent_EnterKey_Submission('<?php print $ac_row; ?>', '<?php print $branch_no; ?>');Copy_To_ReturnBranchField('<?php print $ac_row; ?>');Check_Workflow2017( '<?php print $ac_row; ?>',  '<?php print $eid; ?>',  '<?php print $reqPosition; ?>');" onKeyUp="Prevent_EnterKey_Submission('<?php print $ac_row; ?>', '<?php print $branch_no; ?>');Copy_To_ReturnBranchField('<?php print $ac_row; ?>');Check_Workflow2017( '<?php print $ac_row; ?>',  '<?php print $eid; ?>',  '<?php print $reqPosition; ?>');">
       </td>
      <?php
     print
     "     
     <input type=\"hidden\" id=\"hiddenrow$ac_row$CurrentBranchNo\" name=\"hiddenrow$ac_row$CurrentBranchNo\" value=\"\">
     ";
	}
     ?>
     <td nowrap align="center">
     <table>
     <tr>
     <td>
	 <select name="<?php print "row" . $ac_row . $CurrentRBFrontPosition; ?>" class="NormalDropdown" ID="<?php print "row" . $ac_row . $CurrentRBFrontPosition; ?>" style="background-color: #33CCFF;color: #000000;" onChange="Duplicate_CurrentPosition_ReturnPosition('<?php print $ac_row; ?>');Check_Workflow2017( '<?php print $ac_row; ?>',  '<?php print $eid; ?>',  '<?php print $reqPosition; ?>');" onpropertychange="Duplicate_CurrentPosition_ReturnPosition('<?php print $ac_row; ?>');Check_Workflow2017( '<?php print $ac_row; ?>',  '<?php print $eid; ?>',  '<?php print $reqPosition; ?>');">
     <?php
     mysql_data_seek($mysql_rbfrontposition_result, 0);
     $rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result );
     ?>
      <option value="..."><p style="font-size:10pt;">...</p>
     <?php
     do
      {
       $rbfront_position[short_position] = trim($rbfront_position[short_position]);
       print
       "
        <option value=\"$rbfront_position[short_position]\"><p style=\"font-size:10pt;\">$rbfront_position[short_position]</p>
       ";
      }while ($rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result ));
     ?>
     </select>
     </td>
     <td>
     <input type="button" value="?" onClick="display_branch_positions('<?php print $ac_row; ?>');">
     </td>
     </tr>
     </table>
     </td>
     <input type="hidden" id="<?php print "row".$ac_row.$Redirected_Newbranchno; ?>" name="<?php print "row".$ac_row.$Redirected_Newbranchno; ?>" value="yes">
     
     <?php
     if ($branch_no != "")
      {
       
      }
     else
      print
      "
       <td nowrap align=\"center\">
        <input type=\"text\"   class=\"FormTextbox\" name=\"row$ac_row$NewBranchNo\" id=\"row$ac_row$NewBranchNo\" /
             size=5 maxlength=\"5\" value=\"\" onkeypress=\"Prevent_EnterKey_Submission('$ac_row', '$branch_no');if (this.value.length==4)Check_Workflow('$ac_row', '', '');\" onkeyup=\"Prevent_EnterKey_Submission('$ac_row', '$branch_no');if (this.value.length==4){if ( Check_New_Branch(this.value) ) Precheck_Workflow('$branch_no','$area_name','$network_name', '$hr_pos', '$ac_row');}\">
       </td>
      ";

//onchange=\"Update_Individual_Limit(this.options[this.selectedIndex].value, '$ac_row');\"

     ?>  
     <td>
     
	 <select name="<?php print "row" . $ac_row . $NewRBFrontPosition; ?>" class="NormalDropdown" ID="<?php print "row" . $ac_row . $NewRBFrontPosition; ?>" style="background-color: #33CCFF;color: #000000;" onChange="Check_Workflow2017( '<?php print $ac_row; ?>',  '<?php print $eid; ?>', '<?php print $reqPosition; ?>');">
     <?php
     mysql_data_seek($mysql_rbfrontposition_result, 0);
     $rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result );
     ?>
      <option value="..."><p style="font-size:10pt;">...</p>
     <?php
     do
      {
       $rbfront_position[short_position] = trim($rbfront_position[short_position]);
       print
       "
        <option value=\"$rbfront_position[short_position]\"><p style=\"font-size:10pt;\">$rbfront_position[short_position]</p>
       ";
      }while ($rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result ));
	 ?>
     
     </select>
     </td>
	 
<!-- Kenew -->
     <td>
     <select name="<?php print "row".$ac_row.$NewLimit; ?>" class="NormalDropdown" ID="<?php print "row".$ac_row.$NewLimit; ?>" style="background-color: #33CCFF;color: #000000;" >
      <option value="..."><p style="font-size:10pt;">...</p>
      <option value="LC"><p style="font-size:10pt;">Low Counter</p>
      <option value="HC"><p style="font-size:10pt;">High Counter</p>
     </select>
     </td>
	 
<!-- Kenew -->	 
<?php
print
     "
     <input type=\"hidden\" id=\"hiddenrow$ac_row$NewBranchNo\" name=\"hiddenrow$ac_row$NewBranchNo\" value=\"\">   

     <td>
     <input type=\"text\"  class=\"FormTextbox\" style=\"background-color: #33CCFF;color: #000000;\" name=\"row$ac_row$StartDate\" id=\"row$ac_row$StartDate\" size=15 value=\"...\" onClick=\"alert('กรุณาใช้ปฏิทินที่จัดให้เท่านั้น');document.rbfront_form.row$ac_row$NewRBFrontPosition.focus();\"><A href=\"#\" onClick=\"pre_convert_startdate('$ac_row');cal.select(document.rbfront_form.row$ac_row$StartDate,'row$ac_row$EndDate','dd MMM yyyy',true); return false;\" NAME=\"row$ac_row$StartDate\" ID=\"row$ac_row$StartDate\"><img src=\"img/calendar.jpg\" border=0></A>
     </td>
     ";

     if ($branch_no == "")
      {
       print
       "
        <td>
         <input type=\"text\" class=\"FormTextbox\" style=\"background-color: #33CCFF;color: #000000;\" name=\"row$ac_row$EndDate\" id=\"row$ac_row$EndDate\" size=15 value=\"...\" onClick=\"alert('กรุณาใช้ปฏิทินที่จัดให้เท่านั้น');document.rbfront_form.row$ac_row$NewRBFrontPosition.focus();\"><A href=\"#\" onClick=\"pre_convert_enddate('$ac_row');cal.secondselect(document.rbfront_form.row$ac_row$NewRBFrontPosition,document.rbfront_form.row$ac_row$ReturnRBFrontPosition);cal.select(document.rbfront_form.row$ac_row$EndDate,'row$ac_row$ReturnBranchNo','dd MMM yyyy',true);return false;\" NAME=\"row$ac_row$EndDate\" ID=\"row$ac_row$EndDate\"><img src=\"img/calendar.jpg\" border=0></A>
        </td>
       ";
      }
     else
      {
       print
       "
        <td>
         <input type=\"text\" class=\"FormTextbox\" style=\"background-color: #33CCFF;color: #000000;\" name=\"row$ac_row$EndDate\" id=\"row$ac_row$EndDate\" size=15 value=\"...\" onClick=\"alert('กรุณาใช้ปฏิทินที่จัดให้เท่านั้น');document.rbfront_form.row$ac_row$NewRBFrontPosition.focus();\"><A href=\"#\" onClick=\"pre_convert_enddate('$ac_row');cal.secondselect(document.rbfront_form.row$ac_row$NewRBFrontPosition,document.rbfront_form.row$ac_row$ReturnRBFrontPosition);cal.select(document.rbfront_form.row$ac_row$EndDate,'row$ac_row$ReturnRBFrontPosition','dd MMM yyyy',true); return false;\" NAME=\"row$ac_row$EndDate\" ID=\"row$ac_row$EndDate\"><img src=\"img/calendar.jpg\" border=0></A>
        </td>
       ";
      }    

     if ($branch_no != "")
      {
       
      }
     else
	{
//onchange=\"Update_Redirected_Returnbranchno(this.value, '$ac_row');\" onkeypress=\"Prevent_EnterKey_Submission();\" onkeyup=\"Prevent_EnterKey_Submission();\"

?>
       <td nowrap align="center"><input type="text"  class="FormTextbox"  name="<?php print "row".$ac_row.$ReturnBranchNo; ?>" id="<?php print "row".$ac_row.$ReturnBranchNo; ?>" /
             size=5 maxlength="5" value="" onKeyPress="Prevent_EnterKey_Submission('<?php print $ac_row; ?>', '<?php print $branch_no; ?>');if (this.value.length==4)Check_Workflow('<?php print $ac_row; ?>', '', '');" onKeyUp="Prevent_EnterKey_Submission('<?php print $ac_row; ?>', '<?php print $branch_no; ?>');if (this.value.length==4)Precheck_Workflow('<?php print $branch_no; ?>','<?php print $area_name; ?>','<?php print $network_name; ?>', '<?php print $hr_pos; ?>', '<?php print $ac_row; ?>');">
       </td>
<?php
	}
     if ($branch_no != "") 
      print
      "     
      <td>
	  <select name=\"row$ac_row$ReturnRBFrontPosition\" class=\"NormalDropdown\" ID=\"row$ac_row$ReturnRBFrontPosition\" style=\"background-color: #33CCFF;color: #000000;\" onchange=\"Check_Unindicated_Enddate('$ac_row');Check_Workflow2017('$ac_row','$eid','$reqPosition');\" onpropertychange=\"Check_Workflow2017('$ac_row','$eid','$reqPosition');\">
      ";
     else
      print
      "     
      <td nowrap align=\"center\">
      <select name=\"row$ac_row$ReturnRBFrontPosition\" class=\"NormalDropdown\" ID=\"row$ac_row$ReturnRBFrontPosition\" style=\"background-color: #33CCFF;color: #000000;\"
        onchange=\"Precheck_Workflow('$branch_no','$area_name','$network_name', '$hr_pos', '$ac_row');\">
      "; 
     mysql_data_seek($mysql_rbfrontposition_result, 0);
     $rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result );
     print
     "
      <option value=\"...\"><p style=\"font-size:10pt;\">...</p>
     ";
     do
      {
       $rbfront_position[short_position] = trim($rbfront_position[short_position]);
       ?>
        <option value="<?php print $rbfront_position[short_position]; ?>"><p style="font-size:10pt;"><?php print $rbfront_position[short_position]; ?></p>
       <?php
      }while ($rbfront_position=mysql_fetch_array($mysql_rbfrontposition_result ));
?>  
     </select>
     </td> 
	 
<!-- Kenew -->
     <td>
     <select name="<?php print "row".$ac_row.$ReturnLimit; ?>" class="NormalDropdown" ID="<?php print "row".$ac_row.$ReturnLimit; ?>" style="background-color: #33CCFF;color: #000000;" >
      <option value="..."><p style="font-size:10pt;">...</p>
      <option value="LC"><p style="font-size:10pt;">Low Counter</p>
      <option value="HC"><p style="font-size:10pt;">High Counter</p>
     </select>
     </td>
	 
<!-- Kenew -->	

       <td>
       <select name="<?php print "row".$ac_row.$Reason; ?>" class="FormDropdown_Reason" id="<?php print "row".$ac_row.$Reason; ?>" style="background-color: #33CCFF;color: #000000;">
<?php
      mysql_data_seek($mysql_reason_result, 0);
      $reason_arr=mysql_fetch_array($mysql_reason_result );
?>
       <option value="..." SELECTED><p style="font-size:10pt;">...</p> 
       <option value="โปรดระบุเหตุผล"><p style="font-size:10pt;">โปรดระบุเหตุผล</p>   
       </select>
       </td>
<?php

// Display Workflow According to HR Position
// If Branch Staffs key Form
      
	  
      if ($branch_no != "")
      {
      
      // If Branch Managers or Sub Branch Managers
      if (($hr_pos=="ผู้จัดการสาขา") || ($hr_pos=="ผู้จัดการสาขาย่อย"))   
       {
?>
		<td>
          <table border="0" id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>"  align="center" bgcolor="#000000" cellspacing="1" cellpadding="1">     
          <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" align="center" bgcolor="#9999FF">     
          <td nowrap><p style="font-size:10pt;">เขต</p>
          <td nowrap><p style="font-size:10pt;">เครือข่าย</p>
          <td nowrap><p style="font-size:10pt;">EVP</p>
          </tr>  
          <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" align="center" bgcolor="white">        
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow2; ?>" name="<?php print "row".$ac_row.$WorkFlow2; ?>" value="District" onClick="return false;"></td>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow3; ?>" name="<?php print "row".$ac_row.$WorkFlow3; ?>" value="Network" onClick="return false;"></td>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
<?php
       }
      else  // IF Branch Staffs
       {
?>
         <td>
         <table border="0"  id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>" bgcolor="#000000" cellspacing="1" cellpadding="1">     
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" bgcolor="#9999FF" align="center">
         <td nowrap><p style="font-size:10pt;">สาขา</p>
         <td nowrap><p style="font-size:10pt;">เขต</p>
         <td nowrap><p style="font-size:10pt;">เครือข่าย</p>
         <td nowrap><p style="font-size:10pt;">EVP</p>
         </tr>  
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" bgcolor="#FFFFFF" align="center">   
         <td nowrap><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow1; ?>" name="<?php print "row".$ac_row.$WorkFlow1; ?>" value="Branch" onClick="return false;"></td>
         <td nowrap><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow2; ?>" name="<?php print "row".$ac_row.$WorkFlow2; ?>" value="District" onClick="return false;"></td>
         <td nowrap><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow3; ?>" name="<?php print "row".$ac_row.$WorkFlow3; ?>" value="Network" onClick="return false;"></td>
         <td nowrap><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
<?php       
       }
      
?>
      </tr>    
      </table>
      </td>  
<?php
      } // If Area Staffs Key Form
      else if ($area_name != "")
      {    
       if (strstr($hr_pos,"ผู้จัดการ"))   
       {
?>
         <td>
         <table border="0" id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>" bgcolor="#000000" cellspacing="1" cellpadding="1">     
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" bgcolor="#9999FF" align="center">            
         <td nowrap><p style="font-size:10pt;">เครือข่าย</p>
         <td nowrap><p style="font-size:10pt;">EVP</p>
         </tr>  
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" align="center" bgcolor="white">
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow3; ?>" name="<?php print "row".$ac_row.$WorkFlow3; ?>" value="Network" onClick="return false;"></td>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
         </tr>    
         </table>
         </td>  
<?php
       }
      else
       {
?>
          <td>
          <table border="0" id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>" bgcolor="#000000" cellspacing="1" cellpadding="1">     
          <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" bgcolor="#9999FF" align="center">      
          <td nowrap><p style="font-size:10pt;">เขต</p>
          <td nowrap><p style="font-size:10pt;">เครือข่าย</p>
          <td nowrap><p style="font-size:10pt;">EVP</p>
          </tr>  
          <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" bgcolor=white align=center>
          <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow2; ?>" name="<?php print "row".$ac_row.$WorkFlow2; ?>" value="District" onClick="return false;"></td>
          <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow3; ?>" name="<?php print "row".$ac_row.$WorkFlow3; ?>" value="Network" onClick="return false;"></td>
          <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
          </tr>    
          </table>
          </td>  
<?php
       }      
      }  // If Network Staffs key Form
      else if ($network_name != "")
      {
       if (strstr($hr_pos,"ผู้จัดการ"))   
       {
?>
         <td>
         <table border="0" id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>" bgcolor="#000000" cellspacing="1" cellpadding="1" align="center">     
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" bgcolor="#9999FF" align="center">             
         <td nowrap><p style="font-size:10pt;">EVP</p>
         </tr>  
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" align="center" bgcolor=white>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
         </tr>    
         </table>
         </td>  
<?php
       }
      else
       {
?>
         <td>
         <table border="0" id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>" bgcolor="#000000" align="center" cellspacing="1" cellpadding="1">     
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" bgcolor="#9999FF" align="center">      
         <td nowrap><p style="font-size:10pt;">เครือข่าย</p>
         <td nowrap><p style="font-size:10pt;">EVP</p>
         </tr>  
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" bgcolor="white" align="center">
         <td nowrap><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow3; ?>" name="<?php print "row".$ac_row.$WorkFlow3; ?>" value="Network" onClick="return false;"></td>
         <td nowrap><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
         </tr>    
         </table>
         </td>  
<?php
       }            
      }
      else if ($hr_pos != "ผู้จัดการความปลอดภัยระบบเทคโนโลยีสารสนเทศและระบบงาน")
      {
       print "<td>กรอกโดย User Admin</td>";
      }
      else
      {
?>
         <td>
         <table border="0" id="<?php print "row".$ac_row.$WorkFlowTable; ?>" name="<?php print "row".$ac_row.$WorkFlowTable; ?>"  bgcolor="#000000" cellspacing="1" cellpadding="1" align="center" >     
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow1; ?>" bgcolor="#9999FF" align="center" >
         <td nowrap><p style="font-size:10pt;">สาขา</p>
         <td nowrap><p style="font-size:10pt;">เขต</p>
         <td nowrap><p style="font-size:10pt;">เครือข่าย</p>
         <td nowrap><p style="font-size:10pt;">EVP</p>
         </tr>  
         <tr id="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" name="<?php print "row".$ac_row.$WorkFlowTableRow2; ?>" bgcolor=white align="center">         
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow1; ?>" name="<?php print "row".$ac_row.$WorkFlow1; ?>" value="Branch" onClick="return false;"></td>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow2; ?>" name="<?php print "row".$ac_row.$WorkFlow2; ?>" value="District" onClick="return false;"></td>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow3; ?>" name="<?php print "row".$ac_row.$WorkFlow3; ?>" value="Network" onClick="return false;"></td>
         <td><input type="checkbox" id="<?php print "row".$ac_row.$WorkFlow4; ?>" name="<?php print "row".$ac_row.$WorkFlow4; ?>" value="NetworkNetwork" onClick="return false;"></td>
         </tr>    
         </table>
         </td>  
<?php
      }
 
      print
      "
      <input type=\"hidden\" id=\"hiddenrow$ac_row$ReturnBranchNo\">
      <input type=\"hidden\" id=\"row$ac_row$Redirected_Returnbranchno\" name=\"row$ac_row$Redirected_Returnbranchno\" value=\"yes\">
      ";
     //}
?>
     </tr>
<?php
   }

 }

?>
</table>
  <script type="text/javascript">
   var submit_text="";
  </script>
  <center><input type="submit" name="CABTN" id="CABTN" value="CA CHECK" onClick="submit_text='check';">&nbsp;&nbsp;&nbsp;<input type="button" name="submit_action" id="submit_action" value="ส่ง" onClick="submit_text='check';if(submit_form())document.getElementById('CABTN').click();">&nbsp;&nbsp;&nbsp;<input type="reset" value="ยกเลิก" onClick="cancel_form();">
  <!--<div id="sending_status"><p style="font-size:20pt;color:red">หลังจากกดส่ง(<u><b>กดส่งเพียงครั้งเดียว-อย่ากดส่งซ้ำ-ถ้ากดซ้ำ รายการของท่านอาจจะมีความผิดพลาดได้</b></u>)..ระบบจะใช้เวลาสักครู่...กรุณาคอยจนกว่าจะได้การยืนยัน</p><br/></div> -->
<?php
  print
  "
  <script type=\"text/javascript\">
    document.getElementById('sending_status').style.display = \"inline\";
    document.getElementById('CABTN').style.visibility = \"hidden\";
    function enable_sending_status()
     {
      document.getElementById('sending_status').style.display = \"inline\";
     }

    function Check_New_Branch(brno)
     {       
          var ajax_request1;
          var url = \"check_new_branch.php?br=\"+brno+\"&s=\"+Math.random();
           
          if (window.ActiveXObject)
           {
             ajax_request1 = new ActiveXObject(\"Msxml2.XMLHTTP\");
             if (!ajax_request1)
              ajax_request1 = new ActiveXObject(\"Microsoft.XMLHTTP\");            
             ajax_request1.onreadystatechange = 
                                                                       function()
                                                                        {               
                                                                           if (ajax_request1.readyState == 4)
                                                                             {
                                                                                if (ajax_request1.status == 200)
                                                                                  {                     
                                                                                       var myRegExp = /ERROR/;
                                                                                       var matchPos1 = ajax_request1.responseText.search(myRegExp);      
                                                                                        if (matchPos1 != -1)
                                                                                        {
                                                                                          alert(ajax_request1.responseText);                                                                              
                                                                                          return 0;
                                                                                        }
                                                                                       else
                                                                                        return 1;
                                                                                  }                 
                                                                             }                              
                                                                       }             
            }           
           ajax_request1.open(\"get\",url,false);
           ajax_request1.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
           ajax_request1.send(null);           
     }

    function display_branch_positions(row_no)
     {
      var row = row_no + \"\";   

      var dataentry_eid = \"<?php $branch_no ?>\";
      dataentry_eid = dataentry_eid.split(' ')[1];

      var transfering_employeeid = \"row\" + row + \"UserID\";
      transfering_employeeid = document.getElementById(transfering_employeeid).value;

      var src_new_position = \"row\" + row + \"NewRBFrontPosition\";
      src_new_position = document.getElementById(src_new_position).value;

      var src_startdate = \"row\" + row + \"StartDate\";
      src_startdate = document.getElementById(src_startdate).value;

      var src_enddate = \"row\" + row + \"EndDate\";
      src_enddate = document.getElementById(src_enddate).value;

      var src_new_branchno = \"row\" + row + \"NewBranchNo\";
      if (document.getElementById(src_new_branchno))
       src_new_branchno = document.getElementById(src_new_branchno).value;
      else
       src_new_branchno = dataentry_eid;

      var src_return_position = \"row\" + row + \"ReturnRBFrontPosition\";
      src_return_position = document.getElementById(src_return_position).value;

      var src_return_branchno = \"row\" + row + \"ReturnBranchNo\";
      if (document.getElementById(src_return_branchno))
       src_return_branchno = document.getElementById(src_return_branchno).value;
      else
       src_return_branchno = dataentry_eid;

      var src_current_position = \"row\" + row + \"CurrentRBFrontPosition\";
      
     
      var s = window.showModalDialog (\"display_branch_positions.php?row=\"+row+\"&dataentry_eid=\"+dataentry_eid+\"&newposition=\"+src_new_position+\"&returnposition=\"+src_return_position+\"&newbranchno=\"+src_new_branchno+\"&returnbranchno=\"+src_return_branchno+\"&startdate=\"+src_startdate+\"&enddate=\"+src_enddate+\"&eid=\"+transfering_employeeid+\"&sid=\"+Math.random(), \"\" , \"dialogHeight:800px;dialogWidth:480px;\");
      
      document.getElementById(src_current_position).value = s;
      src_return_position = \"row\" + row + \"ReturnRBFrontPosition\";
      document.getElementById(src_return_position).value = s;
    }
  </script>
  
  ";
  if ($branch_no != "")
  {
  ?>
     <input type="submit" name="submit_action" value="ขอเก็บงานไว้พิมพ์ต่อครั้งหน้า" onClick="submit_text='not check';save_draft();">&nbsp;&nbsp;&nbsp;<input type="submit" name="submit_action" value="ขอเปิดงานที่เก็บไว้จากครั้งที่แล้ว" onClick="submit_text='not check';restore_draft();">
  </center>
  </form>
<?php
   }
  //Implement Branch Input as Draft Mode...Isara
  if ($read_draft != "")
  {
    print
     "
      <script type=\"text/javascript\">
       var filename = \"<?php $read_draft ?>\";
       //alert(filename);
       //alert('fopen error');
      </script>
     ";

   //read branch file
   $fp = NULL;
   $fp = fopen($read_draft, "r");
   if ($fp == NULL)
   {
     print
     "
      <script type=\"text/javascript\">
       //var filename = \"<?php $read_draft ?>\";
       alert('fopen error');
      </script>
     ";
   }
   else
   {
    $rownum;
    while (!feof($fp))
    {
     $buffer = fgets($fp, 10000);
     if ($buffer == "\r\n")
      break;
     $tokens = explode(";", $buffer);
     $token_count = 0;
     foreach ($tokens as $token)
     {
      if ($token=="")
       break;
      $token_count++;
      if ($token_count == 1)
      {
       //create row variable for use.
       $rownum=$token;
       print
       "
        <script type=\"text/javascript\">
         var row_var = \"<?php $token ?>\";
         row_var = row_var.split(\" \")[1];
         var row_var_str = \"row\"+row_var+\"No\";
         document.getElementById(row_var_str).innerHTML =  \"<p stype=font-size:10pt>\"  + row_var + \"</p>\";
        </script>
       ";

       //row count
       }
      else if ($token_count == 2)
      {
       //eid
        print
        "
         <script type=\"text/javascript\">
          var row_eid = \"<?php $token ?>\";
          row_eid = row_eid.split(\" \")[1];
          var row_var_str = \"row\"+row_var+\"UserID\";
          document.getElementById(row_var_str).value = row_eid;
         </script>
        ";
      }
      else if ($token_count == 3)
      {
       //emp name
        print
        "
         <script type=\"text/javascript\">
          var row_name = \"<?php;$token;?>\";
          row_name = row_name.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"FullName\";
          document.getElementById(row_var_str).innerHTML = \"<p stype=font-size:10pt>\"  + row_name + \"</p>\";
         </script>
        ";
      }
      else if ($token_count == 4)
      {
       //job title
        print
        "
         <script type=\"text/javascript\">
          var row_title = \"<?php;$token;?>\";
          row_title = row_title.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"JobTitle\";
          document.getElementById(row_var_str).innerHTML = \"<p stype=font-size:10pt>\"  + row_title + \"</p>\";
         </script>
        ";
      }
      else if ($token_count == 5)
      {
       //job duration
        //job title
        print
        "
         <script type=\"text/javascript\">
          var row_jobduration = \"<?php;$token;?>\";
          row_jobduration = row_jobduration.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"YearsInSCB\";
          document.getElementById(row_var_str).innerHTML = \"<p stype=font-size:10pt>\"  + row_jobduration + \"</p>\";
         </script>
        ";
      }
      else if ($token_count == 6)
      {
        //org_br
        print
        "
         <script type=\"text/javascript\">
          var row_orgbr = \"<?php;$token;?>\";
          row_orgbr = row_orgbr.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"CurrentBranchNo\";
         </script>
        ";
        if ($branch_no != "")
         print
          "
           <script type=\"text/javascript\">
            document.getElementById(row_var_str).innerHTML = \"<p stype=font-size:10pt>\"  + row_orgbr + \"</p>\";
           </script>
          ";
        else
         print
          "
           <script type=\"text/javascript\">
            document.getElementById(row_var_str).value = row_orgbr;        
           </script>
          ";                
      }
      else if ($token_count == 7)
      {
       //org_pos
        print
        "
         <script type=\"text/javascript\">
          var row_orgpos = \"<?php;$token;?>\";
          row_orgpos = row_orgpos.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"CurrentRBFrontPosition\";
          document.getElementById(row_var_str).value = row_orgpos;
         </script>
        ";
      }
      else if ($token_count == 8)
      {
       //dest_br
        print
        "
         <script type=\"text/javascript\">
          var row_newbr = \"<?php;$token;?>\";
          row_newbr = row_newbr.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"NewBranchNo\";
         </script>
        ";
        if ($branch_no != "")
         print
          "
           <script type=\"text/javascript\">
            document.getElementById(row_var_str).innerHTML = \"<p stype=font-size:10pt>\"  + row_newbr + \"</p>\";
           </script>
          ";
        else
         print
          "
           <script type=\"text/javascript\">
            document.getElementById(row_var_str).value = row_newbr;        
           </script>
          ";                       
      }
      else if ($token_count == 9)
      {
       //dest_pos
       print
        "
         <script type=\"text/javascript\">
          var row_newpos = \"<?php;$token;?>\";
          row_newpos = row_newpos.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"NewRBFrontPosition\";
          document.getElementById(row_var_str).value = row_newpos;
         </script>
        ";
      }
      else if ($token_count == 10)
      {
       //start date
       print
        "
         <script type=\"text/javascript\">
          var row_startdate = \"<?php;$token;?>\";
          row_startdate = row_startdate.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"StartDate\";
          document.getElementById(row_var_str).value = row_startdate;
         </script>
        ";
      }
      else if ($token_count == 11)
      {
       //end date
       print
        "
         <script type=\"text/javascript\">
          var row_enddate = \"<?php;$token;?>\";
          row_enddate = row_enddate.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"EndDate\";
          document.getElementById(row_var_str).value = row_enddate;
         </script>
        ";
      }
      else if ($token_count == 12)
      {
       //return br
        print
        "
         <script type=\"text/javascript\">
          var row_retbr = \"<?php;$token;?>\";
          row_retbr = row_retbr.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"ReturnBranchNo\";
         </script>
         ";
         if ($branch_no != "")
         print
          "
           <script type=\"text/javascript\">
            document.getElementById(row_var_str).innerHTML = \"<p stype=font-size:10pt>\"  + row_retbr + \"</p>\";
           </script>
          ";
         else
         print
          "
           <script type=\"text/javascript\">
            document.getElementById(row_var_str).value = row_retbr;        
           </script>
          ";            
      }
      else if ($token_count == 13)
      {
       //return pos
       print
        "
         <script type=\"text/javascript\">
          var row_retpos = \"<?php;$token;?>\";
          row_retpos = row_retpos.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"ReturnRBFrontPosition\";
          document.getElementById(row_var_str).value = row_retpos;
         </script>
        ";
      }
      else if ($token_count == 14)
      {
       //Branch Authorizing
       print
        "
         <script type=\"text/javascript\">
          var row_branch_authorizing = \"<?php;$token;?>\";
          row_branch_authorizing = row_branch_authorizing.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"WorkFlow1\";
          if (row_branch_authorizing == \"YES\")
           document.getElementById(row_var_str).checked = true;
          else
           document.getElementById(row_var_str).checked = false;
          //alert(row_reason);
         </script>
        ";
      }
      else if ($token_count == 15)
      {
       //District Authorizing
        print
        "
         <script type=\"text/javascript\">
          var row_district_authorizing = \"<?php;$token;?>\";
          row_district_authorizing = row_district_authorizing.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"WorkFlow2\";
          if (row_district_authorizing == \"YES\")
           document.getElementById(row_var_str).checked = true;
          else
           document.getElementById(row_var_str).checked = false;
          //alert(row_reason);
         </script>
        ";
      }
      else if ($token_count == 16)
      {
       //Network Authorizing
       print
        "
         <script type=\"text/javascript\">
          var row_network_authorizing = \"<?php;$token;?>\";
          row_network_authorizing = row_network_authorizing.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"WorkFlow3\";
          if (row_network_authorizing == \"YES\")
           document.getElementById(row_var_str).checked = true;
          else
           document.getElementById(row_var_str).checked = false;
          //alert(row_reason);
         </script>
        ";
      }
      else if ($token_count == 17)
      {
       //NetworkNetwork Authorizing
       print
        "
         <script type=\"text/javascript\">
          var row_networknetwork_authorizing = \"<?php;$token;?>\";
          row_networknetwork_authorizing = row_networknetwork_authorizing.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"WorkFlow4\";
          if (row_networknetwork_authorizing == \"YES\")
           document.getElementById(row_var_str).checked = true;
          else
           document.getElementById(row_var_str).checked = false;
          //alert(row_reason);
         </script>
        ";
      }
      else
      {
       
        //reason field
        print
        "
         <script type=\"text/javascript\">
          var row_reason = \"<?php;$token;?>\";
          row_reason = row_reason.split(\";\")[1];
          var row_var_str = \"row\"+row_var+\"Reason\";
          document.getElementById(row_var_str).value = row_reason;
          //alert(row_reason);
          //Precheck_Workflow('$branch_no','$area_name','$network_name', '$hr_pos', '$rownum');
         </script>
        ";
      }
     }
    }
   }
   fclose($fp);
  }
  else
  {

   print
   "
    <script type=\"text/javascript\">
     //alert('not reading draft');
    </script>
   ";



  }

  print
  "
  <script type=\"text/javascript\">

  function Check_Unindicated_Enddate(row)
  {
   var MyEndDate =  \"row\" + row + \"EndDate\";
   MyEndDate = document.getElementById(MyEndDate).value;     
   if (MyEndDate == \"ไม่ระบุ\")
    {
     alert('ไม่สามารถระบุตำแหน่งที่จะกลับมาได้เนื่องจาก ผู้กรอกขอกรอกรายการที่ไม่มีวันสิ้นสุด');
     var new_rb_pos = \"row\" + row + \"NewRBFrontPosition\";
     var return_rb_pos = \"row\" + row + \"ReturnRBFrontPosition\";
     document.getElementById(return_rb_pos).value = document.getElementById(new_rb_pos).value; 
    }
  }

  
  function Copy_To_ReturnBranchField(row)
  {
   var current_br_field = \"row\" + row + \"CurrentBranchNo\";
   var return_rr_field= \"row\" + row + \"ReturnBranchNo\";
   document.getElementById(return_rr_field).value = document.getElementById(current_br_field).value ;
  }
  
  var check_date_ret=\"\";
  var ajax_request1;
  function Check_Date(row)
  {   
   //alert('checking');
  
   var MyStartDate = \"row\" + row + \"StartDate\";
   var MyEndDate =  \"row\" + row + \"StartDate\";
   var MyCurrentBranchNo =  \"row\" + row + \"CurrentBranchNo\";
   var MyNewBranchNo =  \"row\" + row + \"NewBranchNo\";
   var MyUserID =  \"row\" + row + \"UserID\";
   var url;
   if (document.getElementById(MyCurrentBranchNo))
    url = \"check_holiday_date.php?date=\"+document.getElementById(MyStartDate).value+\"&targetbranch=\"+document.getElementById(MyNewBranchNo).value+'&s='+Math.random();
   else
    url = \"check_holiday_date.php?date=\"+document.getElementById(MyStartDate).value+\"&userid=\"+document.getElementById(MyUserID).value+'&s='+Math.random();
   //alert(url);
   MyStartDate = document.getElementById(MyStartDate).value;
   MyEndDate = document.getElementById(MyEndDate).value;           
   Get_Ajax_Request1();
   ajax_request1.open(\"get\",url,false);
   ajax_request1.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
   check_date_ret=\"-1\";
   ajax_request1.send(null);
  }
  
  
  
  function Get_Ajax_Request1()
  {
   if (window.ActiveXObject)
   {
    ajax_request1 = new ActiveXObject(\"Msxml2.XMLHTTP\");
    if (!ajax_request1)
     ajax_request1 = new ActiveXObject(\"Microsoft.XMLHTTP\");
    ajax_request1.onreadystatechange=handle_ajax_request1;
   }
  } 


 function handle_ajax_request1()
  {
   if (ajax_request1.readyState == 4)
    if (ajax_request1.status == 200)
     {    
      check_date_ret = ajax_request1.responseText;     
      //alert(check_date_ret);      
     }
  }         
  
  var check_ca_ret=\"\";
  var ajax_request_ca;
  
   function Check_CA(row)
  {   
  
   var MyStartDate = \"row\" + row + \"StartDate\";
   var MyEndDate =  \"row\" + row + \"EndDate\";
   var MyCurrentBranchNo =  \"row\" + row + \"CurrentBranchNo\";
   var MyNewBranchNo =  \"row\" + row + \"NewBranchNo\";
   var MyUserID =  \"row\" + row + \"UserID\";
   var MyNewRBFrontPosition = \"row\" + row + \"NewRBFrontPosition\";
   var MyReturnRBFrontPosition = \"row\" + row + \"ReturnRBFrontPosition\";
   var url;

  if (document.getElementById(MyCurrentBranchNo))
    url = \"check_no_ca12.php?sdate=\"+document.getElementById(MyStartDate).value+\"&edate=\"+document.getElementById(MyEndDate).value+\"&userid=\"+document.getElementById(MyUserID).value+\"&targetbranch=\"+document.getElementById(MyNewBranchNo).value+'&s='+Math.random();
   else
    url = \"check_no_ca12.php?sdate=\"+document.getElementById(MyStartDate).value+\"&edate=\"+document.getElementById(MyEndDate).value+\"&userid=\"+document.getElementById(MyUserID).value+\"&targetbranch=\"+''+'&s='+Math.random();
    
   //alert(url);
          
   Get_Ajax_Request_CA();
   ajax_request_ca.open(\"get\",url,false);
   ajax_request_ca.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
   check_ca_ret=\"-1\";
   ajax_request_ca.send(null);
  }
  
  function Get_Ajax_Request_CA()
  {
   if (window.ActiveXObject)
   {
    ajax_request_ca = new ActiveXObject(\"Msxml2.XMLHTTP\");
    if (!ajax_request_ca)
     ajax_request_ca = new ActiveXObject(\"Microsoft.XMLHTTP\");
    ajax_request_ca.onreadystatechange=handle_ajax_request_ca;
   }else{
         //ajax_request_ca = new ActiveXObject(\"Microsoft.XMLHTTP\");
         ajax_request_ca = new XMLHttpRequest();
         ajax_request_ca.onreadystatechange=handle_ajax_request_ca;
         
    }
  } 
  
 function handle_ajax_request_ca()
  {
   if (ajax_request_ca.readyState == 4)
    if (ajax_request_ca.status == 200)
     {    
      check_ca_ret = ajax_request_ca.responseText;     
      //alert(check_ca_ret);      
     }
  }     
  
  
  function Duplicate_CurrentPosition_ReturnPosition(row)  
  {
   var current_rb_pos = \"row\" + row + \"CurrentRBFrontPosition\";
   var return_rb_pos = \"row\" + row + \"ReturnRBFrontPosition\";
   document.getElementById(return_rb_pos).value = document.getElementById(current_rb_pos).value ;
  }
  
  function copy_reason_dropdown(current_row)
  {
   var nextrow = parseInt(current_row)+1;
   nextrow += \"\";
   var current_reason_box = \"row\" + current_row + \"Reason\";
   var next_reason_box = \"row\" + nextrow + \"Reason\";
   document.getElementById(next_reason_box).length = 0;

   for (i = 0 ; i < document.getElementById(current_reason_box).options.length ; i++) 
    {
     document.getElementById(next_reason_box).options.length += 1;
     document.getElementById(next_reason_box).options[i].value = document.getElementById(current_reason_box).options[i].value;
     document.getElementById(next_reason_box).options[i].text = document.getElementById(current_reason_box).options[i].text;
    }
  }

  function check_enddate()
  {
   alert('coming soon');
  }

  var previous_startdate;
  var previous_enddate;
  function pre_convert_startdate(startdate_row)
  {
   var visible_start_date = \"row\" + startdate_row + \"StartDate\";
   var org_date = document.getElementById(visible_start_date).value;
   org_date = org_date.split(\" \");
   var just_year=parseInt(org_date[2]); //make it integer
   just_year -= 543;
   just_year += \"\";
   var dest_date = org_date[0] + \" \" + org_date[1] + \" \" + just_year;

   previous_startdate = document.getElementById(visible_start_date).value;
   if ((previous_startdate != \"...\"))
    {
     previous_startdate = previous_startdate.split(\" \");
     just_year=parseInt(previous_startdate[2]); //make it integer
     if (just_year > 2000)
      {
       if (just_year > 2500)
        just_year -= 543;
       just_year += \"\";
       previous_startdate = previous_startdate[0] + \" \" + previous_startdate[1] + \" \" + just_year;
      }
     else
      previous_startdate = \"\";
    }



   document.getElementById(visible_start_date).value = dest_date;
  }



  function check_startdatechange(startdate_row)
  {     
   var visible_start_date = \"row\" + startdate_row + \"StartDate\";
   var current_startdate = document.getElementById(visible_start_date).value;
   current_startdate = current_startdate.split(\" \");
   var just_year=parseInt(current_startdate[2]); //make it integer
   if (just_year > 2500)
    just_year -= 543;   
   just_year += \"\";
   current_startdate = current_startdate[0] + \" \" + current_startdate[1] + \" \" + just_year;
   if ((previous_startdate) && (previous_startdate!=\"...\") && (previous_startdate==current_startdate))
    {
     return 0;   
    }
   else if ((previous_startdate) && (current_startdate!=\"ไม่ระบุ\") )
    {     
     current_startdate = current_startdate.split(\" \");
     just_year=parseInt(current_startdate[2]); //make it integer
     if (!(just_year > 2000))
      return 0;    
     return 1;     
    }
  }
  


  function pre_convert_enddate(enddate_row)
  {
   var visible_end_date = \"row\" + enddate_row + \"EndDate\";
   var org_date = document.getElementById(visible_end_date).value;
   org_date = org_date.split(\" \");
   var just_year=parseInt(org_date[2]); //make it integer
   just_year -= 543;
   just_year += \"\";
   var dest_date = org_date[0] + \" \" + org_date[1] + \" \" + just_year; 


   previous_enddate = document.getElementById(visible_end_date).value;   
   if ((previous_enddate != \"...\"))
    {
     previous_enddate = previous_enddate.split(\" \");
     just_year=parseInt(previous_enddate[2]); //make it integer
     if (just_year > 2000)
      {
       if (just_year > 2500)
        just_year -= 543;
       just_year += \"\";
       previous_enddate = previous_enddate[0] + \" \" + previous_enddate[1] + \" \" + just_year;
      }
     else
      previous_enddate = \"\";
    }

  
   document.getElementById(visible_end_date).value = dest_date;
  }

  
  function check_enddatechange(enddate_row)
  {
   var visible_end_date = \"row\" + enddate_row + \"EndDate\";
   var current_enddate = document.getElementById(visible_end_date).value;
   current_enddate = current_enddate.split(\" \");
   var just_year=parseInt(current_enddate[2]); //make it integer
   if (just_year > 2500)
    just_year -= 543;   
   just_year += \"\";
   current_enddate = current_enddate[0] + \" \" + current_enddate[1] + \" \" + just_year;
   if ((previous_enddate) && (previous_enddate!=\"...\") && (previous_enddate==current_enddate))
    {
     return 0;
    }
   else if ((previous_enddate) && (current_enddate!=\"ไม่ระบุ\") )
    {
     
     current_enddate = current_enddate.split(\" \");
     just_year=parseInt(current_enddate[2]); //make it integer
     if (!(just_year > 2000))
      return;
     return 1;
    }
  }

  function post_convert_startdate()
  {
   var visible_start_date = \"row\" + startdate_row + \"StartDate\";
   var org_date = document.getElementById(visible_start_date).value;
   org_date = org_date.split(\" \");
   var just_year=parseInt(org_date[2]); //make it integer
   just_year += 543;
   just_year += \"\";
   var dest_date = org_date[0] + \" \" + org_date[1] + \" \" + just_year;
   //alert(dest_date);
   document.getElementById(visible_start_date).value = dest_date;
  }
  
  function Precheck_Workflow17(row, approver, reqpos){
  //alert('approver ' + approver);

    if(reqpos == 'BM'){
    
        var w_f2 = \"row\" + row + \"WorkFlow2\";
        var w_f3 = \"row\" + row + \"WorkFlow3\";
        var w_f4 = \"row\" + row + \"WorkFlow4\";
        
        document.getElementById(w_f2).checked = false;
        document.getElementById(w_f3).checked = false;
        document.getElementById(w_f4).checked = false;
        
		if(approver == 'BM'){
			document.getElementById(w_f2).checked = false;
			document.getElementById(w_f3).checked = false;
			document.getElementById(w_f4).checked = false;
		}
        else if(approver == 'AM'){
                document.getElementById(w_f2).checked = true;
        }
        else if(approver == 'NM'){
                document.getElementById(w_f2).checked = true;
                document.getElementById(w_f3).checked = true;
        }
        else if(approver == 'EVP'){
                document.getElementById(w_f2).checked = true;
                document.getElementById(w_f3).checked = true;
                document.getElementById(w_f4).checked = true;
        }
        else if(approver == 'NOT FOUND'){
            alert('ตรวจสอบไม่พบผู้อนุมัติ');
            }else if(approver == 'GROUP ERROR'){
            alert('เงื่อนไข Group ไม่สามารถขอสิทธิ์ได้');
        }else{
             alert('จำนวนสิทธิ์(role)มีเกินกว่าเงือนไขกำหนด');
        }
    }
    else if (reqpos == 'AM'){
        var w_f3 = \"row\" + row + \"WorkFlow3\";
        var w_f4 = \"row\" + row + \"WorkFlow4\";

        document.getElementById(w_f3).checked = false;
        document.getElementById(w_f4).checked = false;
        
         if(approver == 'BM' || approver == 'AM' ){

				document.getElementById(w_f3).checked = false;
                document.getElementById(w_f4).checked = false;
			 
		 }
		 else if(approver == 'NM'){
                
                document.getElementById(w_f3).checked = true;
        }
        else if(approver == 'EVP'){
             
                document.getElementById(w_f3).checked = true;
                document.getElementById(w_f4).checked = true;
                
        }
        else if(approver == 'NOT FOUND'){
            alert('ตรวจสอบไม่พบผู้อนุมัติ');
            }else if(approver == 'GROUP ERROR'){
            alert('เงื่อนไข Group ไม่สามารถขอสิทธิ์ได้');
        }else{
             alert('จำนวนสิทธิ์(role)มีเกินกว่าเงือนไขกำหนด');
        }
        
        
        
    }else if(reqpos == 'NM'){
    
         var w_f4 = \"row\" + row + \"WorkFlow4\";
         
         document.getElementById(w_f4).checked = false;
         
         if(approver == 'BM' || approver == 'AM' || approver == 'NM'){
			 document.getElementById(w_f4).checked = false;
		 }
		 else if(approver == 'EVP'){
 
                document.getElementById(w_f4).checked = true;
                
        }
        else if(approver == 'NOT FOUND'){
            alert('ตรวจสอบไม่พบผู้อนุมัติ');
            }else if(approver == 'GROUP ERROR'){
            alert('เงื่อนไข Group ไม่สามารถขอสิทธิ์ได้');
        }else{
             alert('จำนวนสิทธิ์(role)มีเกินกว่าเงือนไขกำหนด');
        }
        
    }else{
         
        var w_f1 = \"row\" + row + \"WorkFlow1\";
        var w_f2 = \"row\" + row + \"WorkFlow2\";
        var w_f3 = \"row\" + row + \"WorkFlow3\";
        var w_f4 = \"row\" + row + \"WorkFlow4\";
        
        document.getElementById(w_f1).checked = false;
        document.getElementById(w_f2).checked = false;
        document.getElementById(w_f3).checked = false;
        document.getElementById(w_f4).checked = false;
        
         if (approver == 'BM')
        {
            document.getElementById(w_f1).checked = 'true';
        }else if(approver == 'AM'){
            document.getElementById(w_f1).checked = 'true';
            document.getElementById(w_f2).checked = 'true';
        }else if(approver == 'NM'){
            document.getElementById(w_f1).checked = 'true';
            document.getElementById(w_f2).checked = 'true';
            document.getElementById(w_f3).checked = 'true';
        }else if(approver == 'EVP'){
            document.getElementById(w_f1).checked = 'true';
            document.getElementById(w_f2).checked = 'true';
            document.getElementById(w_f3).checked = 'true';
            document.getElementById(w_f4).checked = 'true';
        } else if(approver == 'NOT FOUND'){
            alert('ตรวจสอบไม่พบผู้อนุมัติ');
            }else if(approver == 'GROUP ERROR'){
            alert('เงื่อนไข Group ไม่สามารถขอสิทธิ์ได้');
        }else{
            alert('จำนวนสิทธิ์(role)มีเกินกว่าเงือนไขกำหนด');
        }
        
     }

  }
  
  function Precheck_Workflow(branch, area, network, hr_pos, row)
  {          

    //Clear all checkboxes
   var w_f1 = \"row\" + row + \"WorkFlow1\";
   var w_f2 = \"row\" + row + \"WorkFlow2\";
   var w_f3 = \"row\" + row + \"WorkFlow3\";
   var w_f4 = \"row\" + row + \"WorkFlow4\";
   
    if (document.getElementById(w_f1))
     document.getElementById(w_f1).checked = 0;
    if (document.getElementById(w_f2))
     document.getElementById(w_f2).checked = 0;
    if (document.getElementById(w_f3)) 
     document.getElementById(w_f3).checked = 0;
    if (document.getElementById(w_f4)) 
    document.getElementById(w_f4).checked = 0;

   var myRegExp = /ผู้จัดการ/;
   var matchPos1 = hr_pos.search(myRegExp);
   var manager=\"\";
   if (matchPos1 != -1)
    manager=\"yes\";
   else
    manager=\"no\";
      
   if (branch != \"\")
    {
     if (manager == \"yes\")
      {
       if ((hr_pos == \"ผู้จัดการสาขา\") || (hr_pos == \"ผู้จัดการสาขาย่อย\"))
        Check_Workflow(row, '', 'District');
       else
        Check_Workflow(row, '', 'Branch');
      }
     else
      Check_Workflow(row, '', 'Branch');
    }
   else if (area != \"\")
    {
      if (manager == \"yes\")
      Check_Workflow(row, '', 'Network');
     else
      Check_Workflow(row, '', 'DistrictStaff');
    }
   else
    {
     if (manager == \"yes\")
      Check_Workflow(row, '', 'EVP');
     else
      Check_Workflow(row, '', 'NetworkStaff');
    }
  }
  

  var ajax_request;  
  var ajax_row;




  function Check_Cashier_Positions()
  {
   

   var checkcashier_rowcount=0;   
   var q_str=\"\";
   var ca_url=\"\";
   for (var i = 1 ; i <= 100 ; i++)
    {
     var row = i + \"\";
     var visible_row_no = \"row\" + row + \"No\";          
     var visible_useridd = \"row\" + row + \"UserID\";
     var c_rb = \"row\" + row + \"CurrentRBFrontPosition\";
     var n_rb = \"row\" + row + \"NewRBFrontPosition\";
     var r_rb = \"row\" + row + \"ReturnRBFrontPosition\";
     var s_d = \"row\" + row + \"StartDate\";
     var e_d = \"row\" + row + \"EndDate\";     
     var visible_current_branchno = \"row\" + row + \"CurrentBranchNo\";
     var visible_new_branchno = \"row\" + row + \"NewBranchNo\";
     var visible_return_branchno = \"row\" + row + \"ReturnBranchNo\";

     if (!document.getElementById(visible_useridd))
      break;
     
     if (document.getElementById(visible_useridd).value==\"\")
      break;
   
     checkcashier_rowcount++;
     q_str += document.getElementById(visible_useridd).value;
     q_str += \",\";
     q_str += document.getElementById(c_rb).value;
     q_str += \",\";
     q_str += document.getElementById(n_rb).value;
     q_str += \",\";
     q_str += document.getElementById(r_rb).value;
     q_str += \",\";
     q_str += document.getElementById(s_d).value;
     q_str += \",\";
     q_str += document.getElementById(e_d).value;

    

     if (document.getElementById(visible_current_branchno))
      {
       //district and up       
       q_str += \",\";
       q_str += document.getElementById(visible_current_branchno).value;
       q_str += \",\";
       q_str += document.getElementById(visible_new_branchno).value;
       q_str += \",\";
       q_str += document.getElementById(visible_return_branchno).value;
      }
     else
      {
          //call ajax to get the branch_no of each record     
          var ajax_request1;
          var url = \"get_branchno_from_eid.php?eid=\"+document.getElementById(visible_useridd).value+\"&s=\"+Math.random();
          var proper_branch_no=\"\";
          if (window.ActiveXObject)
           {
             ajax_request1 = new ActiveXObject(\"Msxml2.XMLHTTP\");
             if (!ajax_request1)
              ajax_request1 = new ActiveXObject(\"Microsoft.XMLHTTP\");
            ajax_request1.onreadystatechange= 
            function()
             {               
               if (ajax_request1.readyState == 4)
                 {
                   if (ajax_request1.status == 200)
                    {                          
                       //alert(ajax_request1.responseText);            
                       proper_branch_no =  ajax_request1.responseText;                                                                         
                    }                 
                 }                              
              }                           
            }
           ajax_request1.open(\"get\",url,false);
           ajax_request1.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
           ajax_request1.send(null);           
           //end of ajax





       //branch
       q_str += \",\";
       q_str +=  proper_branch_no; /*document.getElementById('dataentry_branch_no').value;*/
       q_str += \",\";
       q_str += proper_branch_no; /*document.getElementById('dataentry_branch_no').value;*/   
       q_str += \",\";
       q_str += proper_branch_no; /*document.getElementById('dataentry_branch_no').value;*/     
      }

      row = (i+1) + \"\";
      visible_useridd = \"row\" + row + \"UserID\";
      if (!document.getElementById(visible_useridd))
       break;     
      if (document.getElementById(visible_useridd).value==\"\")
       break;
      q_str += \";\";                
    }     

  
   //ca_url=\"count_cashier_position2.php?q_str=\";
   ca_url=\"count_cashier_position.php?q_str=\";
   ca_url += q_str;
   ca_url += \"&sid=\";
   ca_url += Math.random();   

   

  // var s = window.showModalDialog(ca_url, \"\" , \"dialogHeight:800px;dialogWidth:1000px;menubar=no;titlebar=no;\");     
   //return s.content;

   //return 1;
  }
  

  
  function Check_Workflow2017(row_no, requestor, reqpos){

    var row = row_no + \"\";
    ajax_row = row;
    var visible_userid = \"row\" + row + \"UserID\";
    var visible_JobTitle = \"row\" + row + \"JobTitle\";
    var visible_JobDuration = \"row\" + row + \"YearsInSCB\";   
    var visible_current_branchno = \"row\" + row + \"CurrentBranchNo\";  
    var visible_new_branchno = \"row\" + row + \"NewBranchNo\";  
    var visible_return_branchno = \"row\" + row + \"ReturnBranchNo\"; 
    var c_rb = \"row\" + row + \"CurrentRBFrontPosition\";
    
    var visible_startdate =  \"row\" + row + \"StartDate\";
    var visible_enddate =  \"row\" + row + \"EndDate\";
    
   
    var req_id = requestor;
    var n_rb = \"row\" + row + \"NewRBFrontPosition\";
    var r_rb = \"row\" + row + \"ReturnRBFrontPosition\";
    
    var w_f1 = \"row\" + row + \"WorkFlow1\";
    var w_f2 = \"row\" + row + \"WorkFlow2\";
    var w_f3 = \"row\" + row + \"WorkFlow3\";
    var w_f4 = \"row\" + row + \"WorkFlow4\";
    
	var currentrbposition = document.getElementById(c_rb).value;
    var newrbposition = document.getElementById(n_rb).value;
    var returnrbposition = document.getElementById(r_rb).value;      
    var userid = document.getElementById(visible_userid).value;
    
    var startdate = document.getElementById(visible_startdate).value;
    var enddate = document.getElementById(visible_enddate).value;
     
   var dataentry_eid = \"<?php $branch_no ?>\";
      dataentry_eid = dataentry_eid.split(' ')[1];

    var src_new_branchno = \"row\" + row + \"NewBranchNo\";
      if (document.getElementById(src_new_branchno))
       src_new_branchno = document.getElementById(src_new_branchno).value;
      else
       src_new_branchno = dataentry_eid;
       

   var src_return_branchno = \"row\" + row + \"ReturnBranchNo\";
      if (document.getElementById(src_return_branchno))
       src_return_branchno = document.getElementById(src_return_branchno).value;
      else
       src_return_branchno = dataentry_eid;
 
    //url = \"check_workflow12.php?fwdPos=\"+'AT'+\"&revPos=\"+'AT'+\"&empid=\"+'04685'+'&s='+Math.random();
	
	//call ajax to get the branch_no of each record     
         
          var url = \"get_branchno_from_eid.php?eid=\"+userid+\"&s=\"+Math.random();

           Get_Ajax_Request_BRANCH();
           ajax_request_branch.open(\"get\",url,false);
           ajax_request_branch.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
           
            proper_branch_no=\"-1\";
            ajax_request_branch.send(null);           
            
          // alert('branch !! ' + proper_branch_no);

     //url = \"check_workflow12.php?fwdPos=\"+newrbposition+\"&revPos=\"+returnrbposition+\"&empid=\"+userid+'&branchid='+proper_branch_no+'&s='+Math.random();
     url = \"check_workflow12.php?fwdPos=\"+newrbposition+\"&revPos=\"+returnrbposition+\"&empid=\"+userid+'&branchid='+proper_branch_no+\"&fwdBranch=\"+src_new_branchno+\"&revBranch=\"+src_return_branchno+\"&reqPos=\"+reqpos+\"&s=\"+Math.random();

   
    if(currentrbposition != '...' && newrbposition != '...' && returnrbposition != '...' && userid != '' ){
				Get_Ajax_Request_APPROVE();
                ajax_request_aprv.open(\"get\",url,false);
                ajax_request_aprv.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
                check_approve_ret=\"-1\";
                ajax_request_aprv.send(null);
 
                
                Precheck_Workflow17(row, check_approve_ret, reqpos);
     }else{
        document.getElementById(w_f1).checked = false;
        document.getElementById(w_f2).checked = false;
        document.getElementById(w_f3).checked = false;
        document.getElementById(w_f4).checked = false;
    }
  }
  
  
  function Get_Ajax_Request_BRANCH()
  {
  
   if (window.ActiveXObject)
   {
    ajax_request_branch = new ActiveXObject(\"Msxml2.XMLHTTP\");
    if (!ajax_request_branch)
     ajax_request_branch = new ActiveXObject(\"Microsoft.XMLHTTP\");
     ajax_request_branch.onreadystatechange=handle_ajax_request_branch;
   }
   else{
         ajax_request_branch = new XMLHttpRequest();
         ajax_request_branch.onreadystatechange=handle_ajax_request_branch;
    }
  }
  
  function handle_ajax_request_branch()
  {
   if (ajax_request_branch.readyState == 4)
	if (ajax_request_branch.status == 200)
	 {    
	  proper_branch_no = ajax_request_branch.responseText;     
	  //alert('ret !! '+ proper_branch_no);      
	 }
  }
  
 
  function Get_Ajax_Request_APPROVE()
  {
  
   if (window.ActiveXObject)
   {
   //alert('Get_Ajax_Request_APPROVE');
    ajax_request_aprv = new ActiveXObject(\"Msxml2.XMLHTTP\");
    if (!ajax_request_aprv)
     ajax_request_aprv = new ActiveXObject(\"Microsoft.XMLHTTP\");
    ajax_request_aprv.onreadystatechange=handle_ajax_request_approve;
   }
   else{
    
         ajax_request_aprv = new XMLHttpRequest();
         ajax_request_aprv.onreadystatechange=handle_ajax_request_approve;
         

    }
  } 
  
 function handle_ajax_request_approve()
  {
   if (ajax_request_aprv.readyState == 4)
    if (ajax_request_aprv.status == 200)
     {    
      check_approve_ret = ajax_request_aprv.responseText;     
      //alert(check_approve_ret);      
     }
  }

  function Check_Workflow(row_no, workflowitem, minworkflow)
  {
   //alert(workflowitem);
   //alert(minworkflow);
  
   var row = row_no + \"\";
   ajax_row = row;
   var visible_userid = \"row\" + row + \"UserID\";
   var visible_JobTitle = \"row\" + row + \"JobTitle\";
   var visible_JobDuration = \"row\" + row + \"YearsInSCB\";   
   var visible_current_branchno = \"row\" + row + \"CurrentBranchNo\";  
   var visible_new_branchno = \"row\" + row + \"NewBranchNo\";  
   var visible_return_branchno = \"row\" + row + \"ReturnBranchNo\";  
   
   
   var c_rb = \"row\" + row + \"CurrentRBFrontPosition\";
   var n_rb = \"row\" + row + \"NewRBFrontPosition\";
   var r_rb = \"row\" + row + \"ReturnRBFrontPosition\";
    
   var w_f1 = \"row\" + row + \"WorkFlow1\";
   var w_f2 = \"row\" + row + \"WorkFlow2\";
   var w_f3 = \"row\" + row + \"WorkFlow3\";
   var w_f4 = \"row\" + row + \"WorkFlow4\";
   
   if ((document.getElementById(visible_JobDuration).innerHTML == \"0\") 
      &&
      (workflowitem != \"\"))
    {
      alert('ยังไม่ได้กรอกข้อมูลให้ครบถ้วน');

      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;

      return;
    }
   else if (document.getElementById(visible_JobDuration).innerHTML == \"0\") 
    return;

   if (
       (
        (document.getElementById(c_rb).value == \"...\")
        ||
        (document.getElementById(n_rb).value == \"...\")
        ||
        (document.getElementById(r_rb).value == \"...\")
       )
       &&
       (workflowitem != \"\")
      )
    {
      alert('ยังไม่ได้กรอกข้อมูลให้ครบถ้วน');

      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;

      return;
    }
   else if (
            
             (document.getElementById(c_rb).value == \"...\")
             ||
             (document.getElementById(n_rb).value == \"...\")
             ||
             (document.getElementById(r_rb).value == \"...\")
           )
    {
     return;
    }

   
   
    
   if (document.getElementById(visible_current_branchno) )
    if (document.getElementById(visible_current_branchno).value == \"...\") 
     {
      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;

      return;
     }
          
   if (document.getElementById(visible_new_branchno) )
    if (document.getElementById(visible_new_branchno).value == \"...\") 
     {
      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;

      return;
     }
  
   
  
   
   if (workflowitem == \"Branch\")
   {
    //alert('Branch');
    
    if (document.getElementById(w_f1).checked)
     {
      //alert('checked');
     }
    else
     {
      //alert('unchecked');
      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      return;
     }
   }
   else  if (workflowitem == \"District\")
   {
    //alert('District');
    if (document.getElementById(w_f2).checked)
     {
      //alert('checked');
     }
    else
     {
      //alert('unchecked');
      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      return;
     }
   }
   else  if (workflowitem == \"Network\")
   {
    //alert('Network');
    if (document.getElementById(w_f3).checked)
     {
      //alert('checked');
     }
    else
     {
      //alert('unchecked');
      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      return;
     }
   }
   else  if (workflowitem == \"EVP\")
   {
    //alert('EVP');
    if (document.getElementById(w_f4).checked)
     {
      //alert('checked');
     }
    else
     {
      //alert('unchecked');
      if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
      if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
      if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
      if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      return;
     }
   }
   
   
   
   
   var target=\"\";
   
   if (document.getElementById(w_f4) && (document.getElementById(w_f4).checked))
    target=\"EVP\";
   else if (document.getElementById(w_f3) && (document.getElementById(w_f3).checked))
    target=\"Network\";
   else if (document.getElementById(w_f2) && (document.getElementById(w_f2).checked))
    target=\"District\";
   else if (document.getElementById(w_f1) && (document.getElementById(w_f1).checked))
    target=\"Branch\";
    
   var title=document.getElementById(visible_JobTitle).innerHTML;
   var title_ar=title.split('>');   
   title=title_ar[1]; 
   title_ar=title.split('<');   
   title=title_ar[0]; 
   
   var duration=document.getElementById(visible_JobDuration).innerHTML;
   var duration_ar=duration.split('>');   
   duration=duration_ar[1]; 
   duration_ar=duration.split('<');   
   duration=duration_ar[0]; 
   
   var currentrbposition = document.getElementById(c_rb).value;
   var newrbposition = document.getElementById(n_rb).value;
   var returnrbposition = document.getElementById(r_rb).value;      
   var userid = document.getElementById(visible_userid).value;
   var visiblebranchno = document.getElementById(visible_current_branchno);
   
   var url;
   if (visiblebranchno == null)
    {
     url='check_workflow.php'+'?'+'userid='+userid+'&org_branchno='+'NOT SPECIFIED'+'&new_branchno='+'NOT SPECIFIED'+'&return_branchno='+'NOT SPECIFIED'+'&target='+target+'&minworkflow='+minworkflow+'&'+'jobtitle='+title+'&'+'duration='+duration+'&'+'currentposition='+currentrbposition+'&'+'newposition='+newrbposition+'&'+'returnposition='+returnrbposition+'&'+'s='+Math.random();
     //url='check_workflow.php'+'?'+'userid='+userid+'&s='+Math.random();
     //alert(url);
     //return;
    }
   else
    {
     var currentbranchno = document.getElementById(visible_current_branchno).value;
     var newbranchno = document.getElementById(visible_new_branchno).value; 
     var returnbranchno = document.getElementById(visible_return_branchno).value; 
      
     url='check_workflow.php'+'?'+'userid='+userid+'&org_branchno='+currentbranchno+'&new_branchno='+newbranchno+'&return_branchno='+returnbranchno+'&target='+target+'&minworkflow='+minworkflow+'&'+'jobtitle='+title+'&'+'duration='+duration+'&'+'currentposition='+currentrbposition+'&'+'newposition='+newrbposition+'&'+'returnposition='+returnrbposition+'&'+'s='+Math.random();
     //alert(url);   
    }
   
   Get_Ajax_Request();
   ajax_request.open(\"get\",url,true);
   ajax_request.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
   ajax_request.send(null);
  }

  function Get_Ajax_Request()
  {
   if (window.ActiveXObject)
   {
    ajax_request = new ActiveXObject(\"Msxml2.XMLHTTP\");
    if (!ajax_request)
     ajax_request = new ActiveXObject(\"Microsoft.XMLHTTP\");
    ajax_request.onreadystatechange=handle_ajax_request;
   }
  }

 function handle_ajax_request()
  {
   if (ajax_request.readyState == 4)
    if (ajax_request.status == 200)
     {    
       
     
                       
      var matchparenthesis= ajax_request.responseText.indexOf('(');      
      var response=ajax_request.responseText;
      var response_ar;
      if (matchparenthesis != -1)
       {
        response_ar = response.split('(');        
        response = response_ar[1];
        response_ar = response.split(')');
        response = response_ar[0];         
       }
      else
       response=\"\";
     
      var myRegExp = /SUCCESS/;
      var matchPos1 = ajax_request.responseText.search(myRegExp); 
      matchPos1 += 0;  
                       
      var w_f1 = \"row\" + ajax_row + \"WorkFlow1\";
      var w_f2 = \"row\" + ajax_row + \"WorkFlow2\";
      var w_f3 = \"row\" + ajax_row + \"WorkFlow3\";
      var w_f4 = \"row\" + ajax_row + \"WorkFlow4\";
      
      if (document.getElementById(w_f1))
        {
         //document.getElementById(w_f1).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f1).style.color = \"#000000\" ;
         document.getElementById(w_f1).checked = false ;
         document.getElementById(w_f1).style.display = \"inline\" ;
         //document.getElementById(w_f1).disabled = false;
        }
        if (document.getElementById(w_f2)) 
        {
         //document.getElementById(w_f2).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f2).style.color = \"#000000\" ;
         document.getElementById(w_f2).checked = false ;
         document.getElementById(w_f2).style.display = \"inline\" ;
         //document.getElementById(w_f2).disabled = false;
        }
        if (document.getElementById(w_f3))
        {
         //document.getElementById(w_f3).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f3).style.color = \"#000000\" ;
         document.getElementById(w_f3).checked = false ;
         document.getElementById(w_f3).style.display = \"inline\" ;
         //document.getElementById(w_f3).disabled = false;
        }
        if (document.getElementById(w_f4)) 
        {
         //document.getElementById(w_f4).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f4).style.color = \"#000000\" ;
         document.getElementById(w_f4).checked = false ;
         document.getElementById(w_f4).style.display = \"inline\" ;
         //document.getElementById(w_f4).disabled = false;
        }                
      
      var workflowtable = \"row\" + ajax_row + \"WorkFlowTable\"; 
          
      if (matchPos1 != -1)
      {       
       myRegExp = /self-approved/;
       matchPos1 = ajax_request.responseText.search(myRegExp);
       matchPos1 += 0;
       if (matchPos1 != -1)
       {
        //If self-approved, expand the table cell to say SELF-APPROVED.    
        alert('ไม่ต้องผ่านการอนุมัติระดับต่อไป เนื่องจาก ผู้กรอกมีอำนาจอนุมัติ');   
        if (document.getElementById(w_f1))
        {
         //document.getElementById(w_f1).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f1).style.color = \"#000000\" ;
         document.getElementById(w_f1).checked = false ;
         document.getElementById(w_f1).style.display = \"none\" ;
         //document.getElementById(w_f1).disabled = true;
        }
        if (document.getElementById(w_f2)) 
        {
         //document.getElementById(w_f2).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f2).style.color = \"#000000\" ;
         document.getElementById(w_f2).checked = false ;
         document.getElementById(w_f2).style.display = \"none\" ;
         //document.getElementById(w_f2).disabled = true;
        }
        if (document.getElementById(w_f3))
        {
         //document.getElementById(w_f3).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f3).style.color = \"#000000\" ;
         document.getElementById(w_f3).checked = false ;
         document.getElementById(w_f3).style.display = \"none\" ;
         //document.getElementById(w_f3).disabled = true;
        }
        if (document.getElementById(w_f4)) 
        {
         //document.getElementById(w_f4).style.backgroundColor = \"#000000\" ;
         //document.getElementById(w_f4).style.color = \"#000000\" ;
         document.getElementById(w_f4).checked = false ;
         document.getElementById(w_f4).style.display = \"none\" ;
         //document.getElementById(w_f4).disabled = true;
        }                
       }      

      
       //SUCCESS
       //Enable the lower level box here.
       else if (response != \"\")
       {
       if (response == \"Branch\")
        {
         if (document.getElementById(w_f1))
          document.getElementById(w_f1).checked = 1;
         //document.getElementById(w_f1).checked = 0;
         //document.getElementById(w_f2).checked = 0;
         //document.getElementById(w_f3).checked = 0;
         //document.getElementById(w_f4).checked = 0;
        }
      else if (response == \"District\")
        {
         if (document.getElementById(w_f1))
          document.getElementById(w_f1).checked = 1;
         if (document.getElementById(w_f2))
          document.getElementById(w_f2).checked = 1; 
         //document.getElementById(w_f2).checked = 0;
         //document.getElementById(w_f3).checked = 0;
         //document.getElementById(w_f4).checked = 0;
        }
      else if (response == \"Network\")
        {
         if (document.getElementById(w_f1))
          document.getElementById(w_f1).checked = 1;
         if (document.getElementById(w_f2))
          document.getElementById(w_f2).checked = 1;
         if (document.getElementById(w_f3)) 
          document.getElementById(w_f3).checked = 1; 
         //document.getElementById(w_f3).checked = 0;
         //document.getElementById(w_f4).checked = 0;
        }
      else if (response == \"EVP\")
        {
         if (document.getElementById(w_f1))
          document.getElementById(w_f1).checked = 1;
         if (document.getElementById(w_f2))
          document.getElementById(w_f2).checked = 1;
         if (document.getElementById(w_f3)) 
          document.getElementById(w_f3).checked = 1;
         if (document.getElementById(w_f4)) 
          document.getElementById(w_f4).checked = 1;
        }
      }
       
       return;
      }
     else
      {
      
        var myRegExp = /AUTOMARK/;
        var matchPos1 = ajax_request.responseText.search(myRegExp); 
        matchPos1 += 0;   
        if (matchPos1 != -1)        
         {
            //alert(ajax_request.responseText);
            //response=ajax_request.responseText;
            //response_ar = response.split(':');        
            //response = response_ar[1];          
            //alert(response);  
            myRegExp = /Branch/;
            matchPos1 = ajax_request.responseText.search(myRegExp); 
            myRegExp = /District/;
            matchPos2 = ajax_request.responseText.search(myRegExp); 
            myRegExp = /Network/;
            matchPos3 = ajax_request.responseText.search(myRegExp); 
            myRegExp = /EVP/;
            matchPos4 = ajax_request.responseText.search(myRegExp); 
            if (matchPos1 != -1)
            {
              if (document.getElementById(w_f1))
              document.getElementById(w_f1).checked = 1;
            }
          else if (matchPos2 != -1)
           {
             if (document.getElementById(w_f1))
             document.getElementById(w_f1).checked = 1;
            if (document.getElementById(w_f2))
            document.getElementById(w_f2).checked = 1;          
           }
         else if (matchPos3 != -1)
          {
            if (document.getElementById(w_f1))
            document.getElementById(w_f1).checked = 1;
           if (document.getElementById(w_f2))
            document.getElementById(w_f2).checked = 1;
           if (document.getElementById(w_f3)) 
            document.getElementById(w_f3).checked = 1;      
         }
       else if (matchPos4 != -1)
        {         
          if (document.getElementById(w_f1))
           document.getElementById(w_f1).checked = 1;
         if (document.getElementById(w_f2))
          document.getElementById(w_f2).checked = 1;
         if (document.getElementById(w_f3)) 
          document.getElementById(w_f3).checked = 1;
         if (document.getElementById(w_f4)) 
          document.getElementById(w_f4).checked = 1;
        }

       return;
      }
   }



       
      myRegExp = /ERROR/;
      matchPos1 = ajax_request.responseText.search(myRegExp);      
      if (matchPos1 == -1)
       return;
        
      alert(ajax_request.responseText);
      alert('ระบบจะเคลียร์ข้อมูลขั้นตอนอนุมัติทั้งหมดสำหรับรายการนี้ กรุณาใส่ข้อมูลใหม่');
       
      if (response != \"\")
      {      
      if (response == \"Branch\")
      {
       if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
       if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
       if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
       if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      }
      else if (response == \"District\")
      {
       if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
       if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
       if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
       if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      }
      else if (response == \"Network\")
      {
       if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
       if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
       if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
       if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      }
      else if (response == \"EVP\")
      {
       if (document.getElementById(w_f1))
        document.getElementById(w_f1).checked = 0;
       if (document.getElementById(w_f2))
        document.getElementById(w_f2).checked = 0;
       if (document.getElementById(w_f3)) 
        document.getElementById(w_f3).checked = 0;
       if (document.getElementById(w_f4)) 
        document.getElementById(w_f4).checked = 0;
      }
     }
    }
  }
  


  function submit_form()
  {
   //alert(submit_text);
   //<input type=\"hidden\" id=\"hiddenrow$ac_row$No\" name=\"hiddenrow$ac_row$No\"
   //Check_Cashier_Positions();
   //return false;
   //if (submit_text == \"check\")
    //{
     //Check_Cashier_Positions();
     //return false;
    //}


   for (var i = 1 ; i <= 100 ; i++)
    {
     var row = i + \"\";

     var visible_row_no = \"row\" + row + \"No\";
     var visible_FullName = \"row\" + row + \"FullName\";
     var visible_JobTitle = \"row\" + row + \"JobTitle\";
     var visible_JobDuration = \"row\" + row + \"YearsInSCB\";
     var visible_Limit = \"row\" + row + \"NewLimit\";
     var visible_reason = \"row\" + row + \"Reason\";
     var visible_userid = \"row\" + row + \"UserID\";
     var visible_yearsatscb = \"row\" + row + \"YearsInSCB\";
     var c_rb = \"row\" + row + \"CurrentRBFrontPosition\";
     var n_rb = \"row\" + row + \"NewRBFrontPosition\";
     var r_rb = \"row\" + row + \"ReturnRBFrontPosition\";
     var s_d = \"row\" + row + \"StartDate\";
     var e_d = \"row\" + row + \"EndDate\";
     var w_f1 = \"row\" + row + \"WorkFlow1\";
     var w_f2 = \"row\" + row + \"WorkFlow2\";
     var w_f3 = \"row\" + row + \"WorkFlow3\";
     var w_f4 = \"row\" + row + \"WorkFlow4\";
	 
	 // kenew
     var n_limit = \"row\" + row + \"NewLimit\";
     var r_limit = \"row\" + row + \"ReturnLimit\";
	 // kenew
     
     var visible_current_branchno = \"row\" + row + \"CurrentBranchNo\";
     var visible_new_branchno = \"row\" + row + \"NewBranchNo\";
     var visible_return_branchno = \"row\" + row + \"ReturnBranchNo\";
     
    
     if (!document.getElementById(visible_userid))
      break;
    

     if (submit_text == \"check\")
     {
     if ((i == 1) && (document.getElementById(visible_userid).value == \"\"))
      {
       alert('กรุณากรอกข้อมูล');
       return false;
      }

     if (document.getElementById(visible_userid).value != \"\")
      if (
          (document.getElementById(visible_reason).value == \"...\")
          ||
          (document.getElementById(visible_reason).value == \"\")          
          ||
          (document.getElementById(visible_reason).value == \"โปรดระบุเหตุผล\")         
         )
        {
         if (document.getElementById(visible_reason).value == \"โปรดระบุเหตุผล\")
          alert('กรุณากรอกเหตุผลและกดป่มสีเขียวที่อยู่ด้านขวาของช่องเหตุผลด้วยครับ');
         else
          alert( 'กรุณากรอกเหตุผลในการย้ายพนักงานให้ครบ');
         return false;
        }

     
    
     if (document.getElementById(visible_userid).value != \"\")
      if ((document.getElementById(visible_FullName).innerHTML == \"ERROR\") || (document.getElementById(visible_FullName).innerHTML == \"\") || (document.getElementById(visible_FullName).innerHTML == \"กำลังหาข้อมูล...\") || (document.getElementById(visible_yearsatscb).innerHTML == \"0\"))
        {
         alert('กรุณากรอกเลขที่พนักงานให้ถูกต้อง');
         return false;
        }

     if (document.getElementById(visible_userid).value != \"\")
      {
       document.getElementById(r_rb).disabled = false;
       if (
          (document.getElementById(c_rb).value == \"...\")
          ||
          (document.getElementById(c_rb).value == \"\")
          ||
          (document.getElementById(n_rb).value == \"...\")
          ||
          (document.getElementById(n_rb).value == \"\")
          ||
          (document.getElementById(r_rb).value == \"...\")
          ||
          (document.getElementById(r_rb).value == \"\")
          ||
          (document.getElementById(n_limit).value == \"...\")
          ||
          (document.getElementById(r_limit).value == \"...\")
         )
        {        
         alert( 'กรุณากรอกตำแหน่ง RBFront ให้ครบทั้ง ปัจจุบัน,ตำแหน่งใหม่,Limit,ตำแหน่งที่จะทำหลังตำแหน่งใหม่สิ้นลง');
         return false;
        }
      }
    
       

     if (document.getElementById(visible_userid).value != \"\")
      {
       if (
          (document.getElementById(s_d).value == \"...\")
          ||
          (document.getElementById(e_d).value == \"...\")       
          ||   
          (document.getElementById(s_d).value == \"ไม่ระบุ\")    
          ||
          (document.getElementById(e_d).value == \"ไม่ระบุ\")               
          )
        {        
         if (
              ((document.getElementById(s_d).value != \"ไม่ระบุ\") && (document.getElementById(s_d).value != \"...\"))
              &&
              (document.getElementById(e_d).value == \"ไม่ระบุ\")   
            )
           {
            alert('ตั้งแต่วันที่ 23 มี.ค. 2554 นโยบายของเครือข่ายสาขาไม่อนุญาติให้มีการเปลี่ยนตำแหน่งแบบ \"ถาวร\" และ สามารถเปลี่ยนไปทำงานในตำแหน่งใหม่ได้สูงสุดเพียง 30 วันเท่านั้น');
            return false;
           }
         alert( 'กรุณาระบุวันที่เริ่มต้นและวันสิ้นสุด');
         return false;
        }
       else
        {
		
		
	     //Check No of CA          //
         Check_CA(row);         
          if ( check_ca_ret.substring(0, 5)==\"ERROR\")
          {        
			var values = check_ca_ret.split(',');
			var oper_valid = values[1];
			var ca_valid = values[2];
			var ca_sum = values[3];
			var day_branch = values[4];
			
            if(oper_valid == '>'){
              oper_valid = 'มากกว่า';
            }else if(oper_valid == '>='){
              oper_valid = 'มากกว่าเท่ากับ';
            }
          
            var str = 'จำนวน Cashier เกินกว่าจำนวนที่กำหนด \\n' +   'สำหรับสาขา ' +  day_branch + 'วัน ' + ' ห้าม ' + oper_valid + ' ' + ca_valid + ' คน'  ;
		  
            alert(str);
           //alert( 'กรุณาตรวจสอบรายการคำขอตำแหน่ง Cashier >> จำนวน Cashier สำหรับสาขา 5D = 1 คน, สำหรับสาขา 6-7 D = 2 คน');   
           return false;         
          } 
         if (check_ca_ret==\"SUCCESS\")
          {        
           //alert( 'OK Cashier');   
           //return false;         
          } 
		
		
		
         //Check for 5D Condition(5D can only set the date for monday-friday and non-bank holiday)         
         Check_Date(row);         
         if (check_date_ret==\"ERROR\")
          {        
           alert( 'สาขา 5D ไม่สามารถระบุวันที่ตรงกับเสาร์อาทิตย์หรือวันหยุดได้');   
           return false;         
          }      
          
         //Check if start_date < end_date
         if (document.getElementById(e_d).value != \"ไม่ระบุ\")       
         {
         var my_sd = document.getElementById(s_d).value;
         my_sd = my_sd.split(' ');
         if (my_sd[1] == \"มกราคม\")
          {
           my_sd[1] = \"1\";
          }
         else if (my_sd[1]== \"กุมภาพันธ์\")
          {
           my_sd[1] = \"2\";
          }
         else if (my_sd[1] == \"มีนาคม\")
          {
           my_sd[1] = \"3\";
          }
         else if (my_sd[1] == \"เมษายน\")
          {
           my_sd[1] = \"4\";
          }
         else if (my_sd[1] == \"พฤษภาคม\")
          {
           my_sd[1] = \"5\";
          }
         else if (my_sd[1] == \"มิถุนายน\")
          {
           my_sd[1] = \"6\";
          }
         else if (my_sd[1] == \"กรกฎาคม\")
          {
           my_sd[1] = \"7\";
          }
         else if (my_sd[1] == \"สิงหาคม\")
          {
           my_sd[1] = \"8\";
          }
         else if (my_sd[1] == \"กันยายน\")
          {
           my_sd[1] = \"9\";
          }
         else if (my_sd[1] == \"ตุลาคม\")
          {
           my_sd[1] = \"10\";
          }
         else if (my_sd[1] == \"พฤศจิกายน\")
          {
           my_sd[1] = \"11\";
          }
         else if (my_sd[1] == \"ธันวาคม\")
          {
           my_sd[1] = \"12\";
          }
         if ((my_sd[0] == \"08\") || (my_sd[0] == \"09\"))
          my_sd[0] = parseFloat(my_sd[0]);
         else
          my_sd[0] = parseInt(my_sd[0]);
         
         my_sd[1] = parseInt(my_sd[1]);
         my_sd[2] = parseInt(my_sd[2]);
         
        
                           
         var my_ed = document.getElementById(e_d).value ;
         my_ed = my_ed.split(' '); 
          if (my_ed[1] == \"มกราคม\")
          {
           my_ed[1] = \"1\";
          }
          else if (my_ed[1]== \"กุมภาพันธ์\")
          {
           my_ed[1] = \"2\";
          }
          else if (my_ed[1] == \"มีนาคม\")
          {
           my_ed[1] = \"3\";
          }
          else if (my_ed[1] == \"เมษายน\")
          {
           my_ed[1] = \"4\";
          }
          else if (my_ed[1] == \"พฤษภาคม\")
          {
           my_ed[1] = \"5\";
          }
          else if (my_ed[1] == \"มิถุนายน\")
          {
           my_ed[1] = \"6\";
          }
          else if (my_ed[1] == \"กรกฎาคม\")
          {
           my_ed[1] = \"7\";
          }
          else if (my_ed[1] == \"สิงหาคม\")
          {
           my_ed[1] = \"8\";
          }
          else if (my_ed[1] == \"กันยายน\")
          {
           my_ed[1] = \"9\";
          }
          else if (my_ed[1] == \"ตุลาคม\")
          {
           my_ed[1] = \"10\";
          }
          else if (my_ed[1] == \"พฤศจิกายน\")
          {
           my_ed[1] = \"11\";
          }
          else if (my_ed[1] == \"ธันวาคม\")
          {
           my_ed[1] = \"12\";
          }
         if ((my_ed[0] == \"08\") || (my_ed[0] == \"09\"))
          my_ed[0] = parseFloat(my_ed[0]);
         else
          my_ed[0] = parseInt(my_ed[0]);
         my_ed[1] = parseInt(my_ed[1]);
         my_ed[2] = parseInt(my_ed[2]); 
        
         
         var sd_date = new Date(my_sd[2]-543,my_sd[1]-1,my_sd[0],0,0,0);

         var ed_date = new Date(my_ed[2]-543,my_ed[1]-1,my_ed[0],0,0,0); 
         var sd_date_time = sd_date.getTime();
         var ed_date_time = ed_date.getTime();
         var sd_ed_difference_time = Math.abs(ed_date_time - sd_date_time)
         if (sd_date > ed_date)
	
          {
		   
           alert('ไม่สามารถเลือกวันเริ่มต้นที่เกิดขึ้นหลังจากวันสิ้นสุดได้');
	
           return false;
		  
          }
         else if ((Math.round((sd_ed_difference_time*1.00)/(24*60*60*1000))) > 31)
          {
           alert('ตั้งแต่วันที่ 23 มี.ค. 2554 นโยบายของเครือข่ายสาขาไม่อนุญาติให้มีการเปลี่ยนตำแหน่งแบบ \"ถาวร\" และ สามารถเปลี่ยนไปทำงานในตำแหน่งใหม่ได้สูงสุดเพียง 30 วันเท่านั้น');           
           return false;

          }
         else
          {

           //special condition April 13 xxxx
           if (
               ((my_sd[1] == 4) && (my_sd[0] == 13))
               ||
               ((my_ed[1] == 4) && (my_ed[0] == 13))
              )
               {
		   
                alert('ไม่สามารถเลือกวันเริ่มต้นหรือวันสิ้นสุดที่เป็นวันสงกรานต์ได้(13 เม.ย.)');
	
                return false;
		  
               }   
           //special condition Jan 01   
           else if (
                     ((my_sd[1] == 1) && (my_sd[0] == 1))
                     ||
                     ((my_ed[1] == 1) && (my_ed[0] == 1))
                    )
               {
		   
                alert('ไม่สามารถเลือกวันเริ่มต้นหรือวันสิ้นสุดที่เป็นวันปีใหม่ได้ (1 ม.ค.)');
	
                return false;
		  
               }







          }
        }  
        
        
        
        }
      }  

      //Check Workflow RadioBox   
      if (
          (!(
          (document.getElementById(w_f4) && (document.getElementById(w_f4).checked == true))
          ||
          (document.getElementById(w_f3) && (document.getElementById(w_f3).checked == true))
          ||
          (document.getElementById(w_f2) && (document.getElementById(w_f2).checked == true))
          ||
          (document.getElementById(w_f1) && (document.getElementById(w_f1).checked == true))
          ))
         &&
         (
          (document.getElementById(visible_userid).value != \"\")
          &&
          ( 
           (document.getElementById(w_f1) && (document.getElementById(w_f1).style.display == \"inline\"))
           ||
           (document.getElementById(w_f2) && (document.getElementById(w_f2).style.display == \"inline\"))
           ||
           (document.getElementById(w_f3) && (document.getElementById(w_f3).style.display == \"inline\"))
           ||
           (document.getElementById(w_f1) && (document.getElementById(w_f4).style.display == \"inline\"))
          )
         )
         )
       {
        alert('กรุณาระบุขั้นตอนการอนุมัติ');
        return false;
       }
       
     if (
        (document.getElementById(visible_userid).value != \"\")
        &&
        (
        ( (document.getElementById(visible_current_branchno)) && (document.getElementById(visible_current_branchno).value == \"\") )
        ||
        ( (document.getElementById(visible_new_branchno)) && (document.getElementById(visible_new_branchno).value == \"\") )      
        ||
        ( (document.getElementById(visible_return_branchno)) && (document.getElementById(visible_return_branchno).value == \"\") )          
        )
        )
         {
          //alert(document.getElementById(visible_current_branchno).value);
          //alert(document.getElementById(visible_new_branchno).value);
          //alert(document.getElementById(visible_return_branchno).value);
          alert('กรุณาระบุรหัสสาขาให้ครบถ้วน');
          return false;
         }


     if (
        (document.getElementById(visible_userid).value != \"\")
        &&
        (
        ( (document.getElementById(visible_current_branchno)) && (document.getElementById(visible_current_branchno).value != \"\") && (document.getElementById(visible_current_branchno).value != \"ไม่สังกัดสาขาใด\") && (document.getElementById(visible_current_branchno).value.length != 4) )
        ||
        ( (document.getElementById(visible_new_branchno)) && (document.getElementById(visible_new_branchno).value != \"\") && (document.getElementById(visible_new_branchno).value.length != 4) )      
        ||
        ( (document.getElementById(visible_return_branchno)) && (document.getElementById(visible_return_branchno).value != \"\") && (document.getElementById(visible_return_branchno).value != \"ไม่สังกัดสาขาใด\") && (document.getElementById(visible_return_branchno).value.length != 4)  )          
        )
        )
         {         
           alert('กรุณากรอกรหักสาขาเป็นเลข 4 หลักเท่านั้น เช่น 0111, 0127, 0001');
           return false;
         }
     
      
     }


     //var visible_CurrentBranchNo = \"row\" + row + \"CurrentBranchNo\";
     //var visible_NewBranchNo = \"row\" + row + \"NewBranchNo\";

     var hidden_row_no = \"hiddenrow\" + row + \"No\";
     var hidden_FullName = \"hiddenrow\" + row + \"FullName\";
     var hidden_JobTitle = \"hiddenrow\" + row + \"JobTitle\";
     var hidden_JobDuration = \"hiddenrow\" + row + \"YearsInSCB\";
     var hidden_Limit = \"hiddenrow\" + row + \"NewLimit\";

     //var hidden_CurrentBranchNo = \"hiddenrow\" + row + \"CurrentBranchNo\";
     //var hidden_NewBranchNo = \"hiddenrow\" + row + \"NewBranchNo\";

     document.getElementById(hidden_row_no).value = document.getElementById(visible_row_no).innerHTML;
     document.getElementById(hidden_FullName).value = document.getElementById(visible_FullName).innerHTML;
     document.getElementById(hidden_JobTitle).value = document.getElementById(visible_JobTitle).innerHTML;
     document.getElementById(hidden_JobDuration).value = document.getElementById(visible_JobDuration).innerHTML;
     //document.getElementById(hidden_Limit).value = document.getElementById(visible_Limit).innerHTML;
     }
   //document.getElementById(\"submit_btn\").value=\"ฟอร์มส่งไปแล้ว ไม่สามารถส่งซ้ำได้...\";
   //document.getElementById(\"submit_btn\").disabled=\"true\";
   //document.getElementById(\"sending_status\").innerHTML = \"สถานะ: กำลังส่งข้อมูล..กรุณาคอย\";   
  
   return true;
  }


  function cancel_form()
  {
   //window.location='employee_form.php';
   //window.location.reload();
   parent.menu_frame.reload_dataentry_form();
  }

  function save_draft()
  {
   //alert('save draft per branch');

   //create a branch file
   var exec=\"<?php save_draft();>\";

   //alert(exec);
  }

  function restore_draft()
  {
   //alert('restore draft per branch');

   var exec=\"<?php restore_draft();>\";

   //alert(exec);
  }


  </script>
 ";
?>  
  </body>
  </html>
 <?php

  function save_draft()
  {
   print
   "
    <script type=\"text/javascript\">
     //alert('ok1');
    </script>
   ";
  }

  function restore_draft()
  {
    print
    "
    <script type=\"text/javascript\">
     //alert('ok2');
    </script>
    ";
  }
?>
