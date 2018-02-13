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

 //set time zone
 date_default_timezone_set('Asia/Bangkok');

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>

<script>
  function getSelect(value, AP)
 {
    if(value.equals(AP))
        return "selected";
    return "";
 }
 
 </script>
</head>

<body>

<?php
include('connect.php');

$sql = "select * from approver t join job j join lvjob l on t.Job=j.NameEN and l.JobName=j.NameEN order by l.lv,t.Job,t.role";
$mysql_result = mysql_query($sql,$mysql_conn);


$sql1 = "select * from lvcorpstaff t order by CONVERT(t.lv,UNSIGNED INTEGER)  ";
$rs_corp = mysql_query($sql1,$mysql_conn);


$row_count_i=0;
$row_count_j=0;
$tempJ = "";

  function getSelect($value, $AP) {  
      if($value == $AP ) {
          return "selected";
      }
      return "";
  }
  ?>

  <html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css" />
 </head>
  <body>
  
      <form id="mainForm" name="mainForm"  method="post" action="">
  <table align="left" border="0" cellpadding="0" cellspacing="0"  >
    <tr>
            <td>เงือนไขสิทธิ์อนุมัติตำแหน่งงาน</td>
            <td width="10"><img src="menu_images/spacer.gif" style="border:0;" /></td>
            <td id="imgAdd" align="left" > <img src="menu_images/add_icon.png" style="border:0;" height="24" title="Add" onclick="window.open('valid_approverAdd.php', '_blank','width=720,height=400')" /></td>
  </table>
  <br/><br/>
  
<?php
print "

<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"  class=\"tbl_content\">	
  ";

    while ($mysql_row = mysql_fetch_array($mysql_result))
    {
        $row_count_i++;
        $row_count_j++; 
        
            $pkey = $mysql_row[PKey];
            $job = $mysql_row[Job];
            $jobTH=$mysql_row[NameTH];
            $role=$mysql_row[Role];
            $reqter =$mysql_row[Requester];
            $corp=$mysql_row[CorpStaff];
            $approver=$mysql_row[Approver];
            $defaultApp=$mysql_row[DefaultApp];
            $active=$mysql_row[Active];
            
            if($tempJ != $job){
    ?>
    
                <tr><td colspan=15>
                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="tbl_content">
                                <tr><td class="header_tbl_content2" > <?php echo $jobTH."(".$job.")" ?>
                                        
                                        <input type="hidden" id="<?php echo "Job".$row_count_i ?>" name= "<?php echo "Job".$row_count_i ?>" value="<?php echo $job;?>" />
                                    </td>
                                <td align="right" class="header_tbl_content2" >อำนาจอนุมัติกรณีขอนอกเหนือจากที่กำหนด:
                                    <select class="txt1" name= <?php echo "DefaultApp". $row_count_i; ?> >
                                        <option value="BM"  <?php echo getSelect($defaultApp,'BM'); ?>  >  Branch Manager</option> 
                                        <option value="AM"  <?php echo getSelect($defaultApp,'AM'); ?>  >  Area Manager</option> 
                                        <option value="NM"  <?php echo getSelect($defaultApp,'NM'); ?>  >  Network Manager</option> 
                                        <option value="EVP"  <?php echo getSelect($defaultApp,'EVP'); ?>  >  EVP</option> 

                                    </select>
                                </td>
                                </tr>
                        </table>
                </td></tr>
                <?php
               $tempJ = $job;
               $row_count_j = 1;
            }?>
                
            <tr>
                <td width="100" >&nbsp;</td>
                <td><?php echo $row_count_j; ?></td>
                <td ><?php echo $role; ?></td>
                <td width="20" >&nbsp;</td>
                 <td ><?php echo " ผู้ขอสังกัด  "; ?>&nbsp;</td>
                
                 <td>
                      <select class="txt1" name=<?php  echo "SelectRequester".$row_count_i ?>  size="1" >
                        <option value="ALL" <?php echo getSelect($reqter,"ALL") ?> >ALL</option>
                        <option value="BM" <?php echo getSelect($reqter,"BM") ?> >Branch Manager</option>
                        <option value="AM" <?php echo getSelect($reqter,"AM") ?> >Area Manager</option>
                        <option value="NM" <?php echo getSelect($reqter,"NM") ?> >Network Manager</option>
                        <option value="Other" <?php echo getSelect($reqter,"OTH") ?> >Other</option>	
                    </select>
                 </td>
                   
                 <td width="20" >&nbsp;</td>
                <td ><?php echo " เจ้าของสิทธิ์มี Corporate Title ตั้งแต่ "; ?>&nbsp;</td>
                <td align="left" ><select class="txt1" id="SelectCorp"  name= "<?php echo "SelectCorp".$row_count_i; ?>" size="1" >
                <?php
                    while ($rscorp_row = mysql_fetch_array($rs_corp)){
                        $lv = $rscorp_row[lv];
	     $CorpName = $rscorp_row[CorpStaff];
                  ?>
                    
                    <option value=<?php echo "'".$lv."'"; echo  getSelect($lv,$corp); ?> ><?php echo $CorpName; ?></option>
                    
                    <?php
                    } mysql_data_seek($rs_corp, 0);
                ?>
                    
                </select></td>
                <td width="20" >&nbsp;</td>
                <td ><?php echo " ติดอำนาจอนุมัติ  "; ?>&nbsp;</td>
                <td>
                    <select class="txt1" name=<?php  echo "SelectApprover".$row_count_i ?>  size="1" >
                        <option value="BM" <?php echo getSelect($approver,"BM") ?> >Branch Manager</option>
                        <option value="AM" <?php echo getSelect($approver,"AM") ?> >Area Manager</option>
                        <option value="NM" <?php echo getSelect($approver,"NM") ?> >Network Manager</option>
                        <option value="EVP" <?php echo getSelect($approver,"EVP") ?> >EVP</option>	
                    </select>
                </td>
              
                <td width="50" align="center" ><input class="txt1" type="checkbox" value="<?php if($active == "Y")  {echo "Y";} else{ echo "N";}  ?>"   onclick=<?php echo "doCheck('$row_count_i')"; ?> id="<?php echo "CheckBoxActive".$row_count_i;?>" name= "<?php echo "CheckBoxActive".$row_count_i;?>" <?php if($active == "Y") echo "checked = checked" ;?> /> </td>
                <td width="50" class="tbl_row1"  ><img src="menu_images/delete_icon.png" style="border:0;" height="24" title="Delete" onClick= <?php echo "doSubmit('remove".$row_count_i."')"; ?>  /></td>
            </tr>
            
            <input type="hidden" id=<?php echo "PKey".$row_count_i; ?>  name="<?php echo "PKey".$row_count_i; ?>" value=<?php echo $pkey; ?> />
            
<?php
    }
    mysql_close($mysql_conn);
 ?>
            <input type="hidden" id="numRow" name="numRow" value=<?php echo  $row_count_i;?>>
            <input type="hidden"  id="vRemove" name="vRemove" value="">
            <input type="hidden" id="clickActive" name="clickActive" value="" />
</table>
 <br><br>
    <div align="center">
        <input class="btn1" type="submit" id="btUpdate" value="Update"/>
    </div>
   <br><br>
    <div id="footer" >	        
        <span class="footer_text">&copy; สงวนลิขสิทธิ์ 2560 ธนาคารไทยพาณิชย์ จำกัด (มหาชน)</span>
   </div>
  </form>
  
  <script type="text/javascript">

$(function() {
    $("#mainForm").on("submit", function(event) {
        event.preventDefault();
        $.ajax({
            url: "valid_approverUpdate.php",
            type: "post",
            data: $(this).serialize(),
            success: function(d) {
                alert(d);
            }
        });
    });
});

function doCheck(row){

    var CheckBoxActive = document.getElementById("CheckBoxActive"+row);
    if(CheckBoxActive.checked){
        CheckBoxActive.value = 'Y';
    }else{
         CheckBoxActive.value = 'N';
    }
}

function doSubmit(cmd){
		
            var mainForm = document.getElementById("mainForm")

            if(confirm("ยืนยันทำรายการ")){			
                    if(cmd.substring(0,6)=='remove'){
                            var i = cmd.substring(6)
                            document.getElementById("vRemove").value = document.getElementById("PKey"+i).value;

                            var pkey =document.getElementById("vRemove").value;
                            
                            $.ajax({
                                url:"valid_approverRemove.php?param=" + pkey, 
                                type: "GET",
                                success:function(result){
                                 alert(result);
                                 location.reload();
                               }
                             });
                    }
            }

    }
 
 </script>
  

</body>
</html>