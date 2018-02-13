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
 
 include('connect.php');
 
$sql = "select distinct RoleName from role t order by t.RoleName ";
$role_result = mysql_query($sql,$mysql_conn);

$sql1 = "select distinct s.job_title_en from scb_emp s where s.job_title_en is not null and LENGTH(s.job_title_en) > 0 and s.job_title_en IN (select  lv.jobname from lvjob lv)  order by  s.job_title_en";
$job_result = mysql_query($sql1,$mysql_conn);

$sql2 = "select * from lvcorpstaff t order by CONVERT(t.lv,UNSIGNED INTEGER) ";
$corp_result = mysql_query($sql2,$mysql_conn); 

//mysql_close($mysql_conn);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>
<title>Add Business Role</title>
<script type="text/javascript">
    
    function doSubmit1(cmd){
		
		if(confirm("ยืนยันทำรายการ")){
			var mainForm = document.getElementById("mainForm")
			
			var job = document.getElementById("job").value;
			var role = document.getElementById("role").value;
                        
                                                          var SelectCorp = document.getElementById("SelectCorp").value;
                                                          var SelectApprover = document.getElementById("SelectApprover").value;
                                                          var SelectDefaultApp = document.getElementById("SelectDefaultApp").value;
                                                          var CheckBoxActive = document.getElementById("CheckBoxActive").value;
                                                          
                                                          var SelectRequester = document.getElementById("SelectRequester").value;
                                                          
                                                            
			if(job==''){
				alert('โปรดเลือก Job Title ก่อน Add');
			}else if(role==''){
				alert('โปรดเลือก Role ก่อน Add');
			}else{
				if(cmd == 'add'){
                                                                                     $.ajax({
                                                                                        url:"valid_approverInsert.php",
                                                                                        data: 'job='+job+'&role='+role+'&SelectCorp='+SelectCorp+'&SelectApprover='+SelectApprover+'&SelectDefaultApp='+SelectDefaultApp+'&CheckBoxActive='+CheckBoxActive+'&SelectRequester='+SelectRequester,
                                                                                        contentType: 'html',
                                                                                        type: "GET",
                                                                                        success:function(result){
                                                                                         alert(result);
                                                                                         window.close();
                                                                                         window.opener.location.reload();
                                                                                       }
                                                                                     });
				}			
			}
		}
	}
        
                    function doCheck(){

                       var CheckBoxActive = document.getElementById("CheckBoxActive");
                       if(CheckBoxActive.checked){
                           CheckBoxActive.value = 'Y';
                       }else{
                            CheckBoxActive.value = 'N';
                       }

                    }

</script>

</head>

<link rel="stylesheet" type="text/css" href="style.css" />
<body>
    <div id="container">
        <div id="header">
            
            <table border="0" cellpadding="0" cellspacing="0" class="header_banner" width="100%" height="90">
            <tr>
                <td class="header_logo" width="229"><img src="menu_images/spacer.gif" style="border:0;" /></td>
                <td><span class="header_caption">RBFront Workflow</span></td>
            </tr>
            </table>
            
        </div>
        
        
        <div id="content">
            
            <div id="main_content">
                
                <form id="mainForm"  method="post" action="" >
                    
                    <table border="0" cellpadding="0" cellspacing="0" class="tbl_search" >
                        
                        <tr><td width="100"align="right">Job Title: </td>
                              <td width="10">&nbsp; </td>
                              <td align="left" ><select class="txt1" id="job"  name="job" size="1" >
                                                        <option value="">Choose Job Title</option>
                                                        <?php 
                                                                while ($job_row = mysql_fetch_array($job_result))
                                                                {
                                                                        $jobT = $job_row[job_title_en];
                                                                        
                                                          
                                                          ?>
                                                                    <option value="<?php  echo  $jobT; ?>"  > <?php  echo  $jobT; ?></option> 
                                                                        
                                                          <?php             											
                                                                }
                                                       ?>
                                                    </select>
                              </td>
                        </tr>
                        
                        
                        <tr><td align="right">Role Name:</td>
                              <td width="10">&nbsp;</td>
                              <td align="left" ><select class="txt1" id="role"  name="role" size="1" >
                                                            <option value="">Choose Role Name </option>
                                                            <?php
                                                                while ($role_row = mysql_fetch_array($role_result)){
                                                                   $jobR = $role_row[RoleName];
                                                                   
                                                              ?> 
                                                            
                                                                    <option value="<?php  echo  $jobR; ?>"  > <?php  echo  $jobR; ?></option> 
                                                             
                                                             <?php
                                                                }
                                                           ?>
                                                        </select>
                              </td>
                        </tr>
                        
                        <tr><td align="right">Requester:</td>
                        <td width="10">&nbsp;</td>
                                <td align="left" >
                                         <select class="txt1" id="SelectRequester" name="SelectRequester" size="1" >	
                                             <option value="ALL" >ALL</option>
                                            <option value="BM" >Branch Manager</option>
                                            <option value="AM" >Area Manager</option>
                                            <option value="NM"  >Network Manager</option>
                                            <option value="OTH" >Other</option>						                	
                                        </select>
                                </td>
                       </tr>
                        
                        <tr><td align="right">Corperate:</td>
                            <td width="10">&nbsp;</td>
                                    <td align="left" ><select class="txt1" id="SelectCorp"  name="SelectCorp" size="1" >
                                                                    <option value="">Choose Corperate </option>
                                                                    <?php
                                                                        while ($corp_row = mysql_fetch_array($corp_result)){
                                                                            $lv =  $corp_row[lv];
                                                                            $CorpName = $corp_row[CorpStaff];
                                                                           
                                                                    ?>        
                                                                        <option value="<?php  echo  $lv; ?>"  > <?php  echo  $CorpName; ?></option> 
                                                                    <?php        
                                                                        }
                                                                        mysql_data_seek($corp_result, 0);
                                                                    ?>
                                                                   
                                                                </select>
                                    </td>
                         </tr>
                         
                         
                         <tr>
                             <td align="right">Approver:</td>
                             <td width="10">&nbsp;</td>
                             <td align="left" >
                                 <select class="txt1" id="SelectApprover" name="SelectApprover" size="1" >						                	
                                        <option value="BM" >Branch Manager</option>
                                        <option value="AM" >Area Manager</option>
                                        <option value="NM"  >Network Manager</option>
                                        <option value="EVP" >EVP</option>						                	
                                    </select>
                             </td>
                          </tr>
                          
                          
                          <tr>
                              <td align="right">DefaultApp:</td>
                               <td width="10">&nbsp;</td>		    
                                <td align="left" >
                                    <select class="txt1" id="SelectDefaultApp" name="SelectDefaultApp" >

                                                <option value="BM"  >Branch Manager</option>
                                                <option value="AM" >Area Manager</option>
                                                <option value="NM" >Network Manager</option>
                                                <option value="EVP" >EVP</option>						                	
                                
                                        </select> 
                                </td>
                            </tr>
                        
                            
                            
                            <tr><td align="right">Active:</td>
                            <td width="10">&nbsp;</td>
                            <td align="left" ><input class="txt1" id="CheckBoxActive" name="CheckBoxActive" type="checkbox" value="N"  onclick="doCheck()" /></td>										
                            </tr>
                            
                            <br>
                            <tr><td colspan="3" align="center" ><input class="btn1" type="submit" name="Submit" value="Add" onClick="doSubmit1('add')" /></td></tr>
		         
                        
                    </table>
                </form>
                
            </div>
            
        </div>
        
        
        <div id="footer">
    	<span class="footer_text">&copy; สงวนลิขสิทธิ์ 2560 ธนาคารไทยพาณิชย์ จำกัด (มหาชน)</span>
        </div>
        
        
        
    </div>
    
</body>
</html>





