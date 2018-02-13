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
 
 function getStatement(Validate,BranchDay) {
	var Statement="";
   
	if("NumCA".equals(Validate)){
                        Statement = "branch สาขา "+BranchDay+" วัน";
	}
	return Statement;
}



 
 </script>
</head>

<body>

<?php
include('connect.php');

$sql = "SELECT PKey,Validate,DayBranch,Operation,VALUE,ACTION,Active FROM validation ORDER BY Validate,DayBranch ";
$mysql_result = mysql_query($sql,$mysql_conn);


$sqlRole = "SELECT RoleName FROM role ORDER BY RoleName ";
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
            <td>เงือนไขการตรวจสอบ</td>
            <td width="10"><img src="menu_images/spacer.gif" style="border:0;" /></td>
            <td id="imgAdd" align="left" > <img src="menu_images/add_icon.png" style="border:0;" height="24" title="Add" onclick="window.open('valid_validationAdd.php', '_blank','width=720,height=400')" /></td>
  </table>
  <br/><br/>
  
<table align="center" border="0" cellpadding="0" cellspacing="0"  class="tbl_content">
    <tr>
          <td class="header_tbl_content" >Topic</td>
          <td class="header_tbl_content" >Statement</td>
          <td class="header_tbl_content" >Operation</td>
          <td class="header_tbl_content" >Value</td>
          <td class="header_tbl_content" >Action</td>
          <td width="10" class="header_tbl_content_last" >Active</td>
          <td width="30" ></td>
    </tr> 
 
    <?php  $i=0;
               while ($mysql_row = mysql_fetch_array($mysql_result))
                {
                   $i++;
                   $pkey = $mysql_row[PKey];
                   $valid = $mysql_row[Validate];
                   $dayBranch = $mysql_row[DayBranch];
                   $oper = $mysql_row[Operation];
                   $val = $mysql_row[VALUE];
                   $act = $mysql_row[Action];
                   $active = $mysql_row[Active];
                   $statement = "";
       
                   if("NumCA" == $valid || "NumRole" == $valid){
                        $statement = "branch สาขา ".$dayBranch." วัน";
                   }
                   else {
                        if("All" == $dayBranch){
                                $statement = "ทุกสาขา ";
                        }else if("Corp3"== $dayBranch){
                                $statement = "Corp.Staff3 และตำแหน่งงาน พนักงานธนกิจ หรือ พนักงานธุรกิจ";
                        }else if("Corp2"== $dayBranch){
                                $statement = "Corp.ตั้งแต่ Staff2 ลงไป";
                        }else{
                                $sqlJob = "SELECT * FROM lvjob l JOIN job j ON l.JobName=j.NameEN WHERE l.lv = '". $dayBranch . "'";
                                $mysqlJob_result = mysql_query($sqlJob,$mysql_conn);
                                
                                $job = "";
                              
                                while ($row = mysql_fetch_array($mysqlJob_result)) 
                                {
                                    if($job != ""){
                                        $job = $job .",";
                                    }
			
                                    if( $row['NameTH'] == "" ){
                                        $job  = "ไม่มีชื่อ Job";
                                    }else{
                                        $job = $job . $row['NameTH'];
                                    }
                                    
                                    
                                }
                                
                              
                                $statement = "ตำแหน่งสูงกว่า ".$job;
                        }
	}
                  
       ?>
                   <input type="hidden" id="<?php echo "PKey".$i; ?>" name="<?php echo "PKey".$i; ?>" value="<?php echo $pkey; ?>">
                           
                   <tr>
                    <td align="center" ><input size="10" align="left" class="txt1" style="background-color:#f3defc" id="<?php echo "Validate".$i; ?>" name="<?php echo "Validate".$i; ?>"  type="text" value="<?php echo $valid;?>" readonly /></td>
                    <td align="center" ><input size="45" align="center" class="txt1" style="background-color:#f3defc" name="<?php echo "statement".$i; ?>"  type="text" value="<?php echo $statement;?>" readonly /></td>
                    <td>
                        <?php
                        if("Group1" == $valid || "Group2" == $valid || "Group3" == $valid){ ?>
                           <select class="txt1" name="<?php echo "SelectOper".$i; ?>" size="1" >	
                                <option value="=" <?php echo getSelect($oper,"=") ?> > = </option>
                            </select>
                        <?php
                        }else{
                        ?>
                            <select class="txt1" name="<?php echo "SelectOper".$i; ?>" size="1" >								    	
                                <option value="<=" <?php echo getSelect($oper,"<=") ?> > <= </option>
                                <option value="<" <?php echo getSelect($oper,"<") ?> > < </option>
                                <option value=">=" <?php echo getSelect($oper,">=") ?> > >= </option>
                                <option value=">" <?php echo getSelect($oper,">") ?> > > </option>
                                <option value="=" <?php echo getSelect($oper,"=") ?> > = </option>
                                <option value="!=" <?php echo getSelect($oper,"!=") ?> > != </option>
                            </select>
                        <?php
                            }
                        ?>
                    </td>
                    
                    <td align="center" ><input align="center" class="txt1" id="<?php echo "Value".$i; ?>"  name="<?php echo "Value".$i; ?>"  type="text" value="<?php echo $val;?>" /></td>
                    
                    <td>
                        <select class="txt1" name="<?php echo "SelectAction".$i; ?>" size="1" >
                            
                            <option value="Reject" <?php echo getSelect($act,"Reject") ?> > Reject </option>
                            <option value="Cond.Reject" <?php echo getSelect($act,"Cond.Reject") ?> > Cond.Reject </option>
                            <option value="BM" <?php echo getSelect($act,"BM") ?> > BM </option>
                            <option value="AM" <?php echo getSelect($act,"AM") ?> > AM </option>
                            <option value="NM" <?php echo getSelect($act,"NM") ?> > NM </option>
                            <option value="EVP" <?php echo getSelect($act,"EVP") ?> > EVP </option>

                        </select>
                    </td>
                    
                    
                    <td align="center" ><input class="txt1"  id="<?php echo "CheckBoxActive".$i;?>" name= "<?php echo "CheckBoxActive".$i;?>"  type="checkbox" value="<?php if($active == "Y")  {echo "Y";} else{ echo "N";}  ?>" <?php if($active == "Y") echo "checked = checked" ;?>  onclick=<?php echo "doCheck('$i')"; ?> /></td>
                 
                    <td width="50" class="tbl_row1"  ><img src="menu_images/delete_icon.png" style="border:0;" height="24" title="Delete" onClick= <?php echo "doSubmit('remove".$i."')"; ?>  /></td>
                   </tr>
                   
                 <?php  //}//end if 
                }// end while
                    mysql_close($mysql_conn);
                ?>
                   <input type="hidden"  name="numRow" value="<?php echo $i; ?>">
                   <input type="hidden"  id="vRemove" name="vRemove" value="">
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
            url: "valid_validationUpdate.php",
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
                                url:"valid_validationRemove.php?param=" + pkey, 
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