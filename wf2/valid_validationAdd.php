<?php
session_start();

if ($_SESSION["login"]=="")

 { /*
  print
  "
   <script language=\"javaScript\">
   window.location = \"http://racf.scb.co.th/RBF/workflow07012011/workflow.php\";
   </script>
  ";*/
 }
 
 include('connect.php');
 
    $sql = "SELECT CONCAT(lv,':',JobName) JName FROM lvjob ORDER BY lv";
    $mysql_result = mysql_query($sql,$mysql_conn);
    
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>
<title>Add Business Role</title>
<script type="text/javascript">
    
    function doSubmit1(cmd){
		
		if(confirm("ยืนยันทำรายการ")){

			var topic = document.getElementById("topic").value;
                                                          var statement = document.getElementById("statement").value;
                                                          var SelectOperation = document.getElementById("SelectOperation").value;
                                                          var Value = document.getElementById("Value1").value;
                                                          var SelectAction = document.getElementById("SelectAction").value;
                                                          var CheckBoxActive = document.getElementById("CheckBoxActive").value;
                                                          
                                                          
			if(topic===''){
				alert('โปรดเลือก topic ก่อน Add');
			}else if(SelectOperation===''){
				alert('โปรดเลือก Operation ก่อน Add');
			}else if(Value===''){
				alert('โปรดใส่ข้อมูล Value ก่อน Add');
			}else{
                                                                            Value = encodeURIComponent(Value);
				if(cmd == 'add'){
                                                                                     //alert('topic='+topic+'&statement='+statement+'&SelectOperation='+SelectOperation+'&Value1='+Value+'&SelectAction='+SelectAction+'&CheckBoxActive='+CheckBoxActive);
                                                                                     $.ajax({
                                                                                        url:"valid_validationInsert.php",
                                                                                        data: 'topic='+topic+'&statement='+statement+'&SelectOperation='+SelectOperation+'&Value1='+Value+'&SelectAction='+SelectAction+'&CheckBoxActive='+CheckBoxActive,
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
                    
                    function setStatement(){
                            var se = document.getElementById("SelectOperation");
	         se.disabled = false;
                            var topic = document.getElementById("topic").value;
                            document.getElementById('statement').options.length = 0;
                            var x = document.getElementById("statement");

                            if(topic==='NumCA' || topic==='NumRole'){			
                                    var option = document.createElement("option");
                                    option.text = "3 day";
                                    option.value = "3";
                                    x.add(option);
                                    var option = document.createElement("option");
                                    option.text = "5 day";
                                    option.value = "5";
                                    x.add(option);
                                    var option = document.createElement("option");
                                    option.text = "6 day";
                                    option.value = "6";
                                    x.add(option);
                                    var option = document.createElement("option");
                                    option.text = "7 day";
                                    option.value = "7";
                                    x.add(option);
                                    var option = document.createElement("option");
                                    option.text = "All";
                                    option.value = "All";
                                    x.add(option);

                                   // document.getElementById("SelectOperation").disabled = false;

                            }else{
                                    var option3 = document.createElement("option");
                                    option3.text = 'Corp.ตั้งแต่ Staff2 ลงไป';
                                    option3.value = 'Corp2';
                                    x.add(option3);

                                    var option2 = document.createElement("option");
                                    option2.text = 'Corp.Staff3 และตำแหน่งงาน พนักงานธนกิจ หรือ พนักงานธุรกิจ';
                                    option2.value = 'Corp3';
                                    x.add(option2);

                                    var count = document.getElementById("countJName").value;
                                    for(i=1;i<=count;i++){
                                            var jName = document.getElementById('JName'+i).value;
                                            var l = jName.indexOf(":");
                                            var option = document.createElement("option");
                                            option.text = jName;
                                            option.value = jName.substring(0,l);
                                            x.add(option);
                                    }
                                    se.value = '=';
                                    se.disabled = true;
                            }

	}
        
                    function isNumber(input){
                            var flage = (input >= 48 && input <= 57) ;
                            if(!flage){
                                    alert('กรุณาใส่ เป็นตัวเลข');
                                    $('#Value').focus(function(){
                                        $(this).val('');
                                      });
                           }
                            return flage;
                    }
        
                    function isValue(e){
                        var topic = document.getElementById("topic").value;

                        if(topic==='NumCA' || topic==='NumRole' ){
                              var unicode=e.keyCode? e.keyCode : e.charCode;
                               
                               var flag =  unicode >= 48 && unicode <= 57;
                               if  (!flag) {
                                    alert('กรุณาใส่ เป็นตัวเลข');
                                    $('#Value').focus(function(){
                                        $(this).val('');
                                      });
                                       e.preventDefault();
                                      return false;
                                }
                        }
                        return true;
                        
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
                    
                    <?php
                            $i = 0;
                            while ($row = mysql_fetch_array($mysql_result)) {
                                $i++;				  	
                                $JName = $row[JName];
                    ?>
                            <input type="hidden" id="<?php echo "JName".$i; ?>" value="<?php echo $JName ;?>">
                   <?php
                            } 
                     ?>
                    <input type="hidden" id="countJName" value="<?php echo $i ; ?>">
                    <table border="0" cellpadding="0" cellspacing="0" class="tbl_search" >
                        
                        <tr>
                              <td width="100"align="right">Topic: </td>
                              <td width="10">&nbsp; </td>
                       
                              <td align="left" >
                                  <select class="txt1"  id="topic"  name="topic" size="1" onchange="setStatement();" >
                                    <option value="" > Choose Topic </option>                
                                    <option value="NumCA"  > NumCA </option>
                                    <option value="NumRole"  > NumRole </option>
                                    <option value="Group1"  > Group1 </option>
                                    <option value="Group2"  > Group2 </option>
                                    <option value="Group3"  > Group3 </option>
                                    
                                    </select>
                              </td>
                                                                        
                        </tr>
                        <tr><td align="right">Statement:</td>
                            <td width="10">&nbsp;</td>
                            <td align="left" >
                                <select id="statement"  name="statement" class="txt1" size="1" >
                                    <option value=""> </option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr><td align="right">Operator:</td>
                            <td width="10">&nbsp;</td>
                            <td align="left" >
                                <select class="txt1" id="SelectOperation"  name="SelectOperation" size="1" id="SelectOperation">
                                       <option value="" >  </option>       
                                       <option value="<=" > <= </option>                
                                        <option value="<" > < </option>
                                        <option value=">=" > >= </option> 
                                        <option value=">" > > </option>
                                        <option value="=" > = </option>
                                        <option value="!=" > != </option>                
                                  </select>
                            </td>
                       </tr>
                        
                       <tr><td align="right">Value:</td>
                            <td width="10">&nbsp;</td>
                            <td align="left" ><input align="center" class="txt1" id="Value1" name="Value1"  type="text"  onkeypress='return isValue(event)' /></td>
                       </tr>
                       
                       <tr><td align="right">Action:</td>
                        <td width="10">&nbsp;</td>
                            <td align="left"  >
                                <select class="txt1" id="SelectAction" name="SelectAction" size="1" >
                                    <option value="Reject"  >Reject</option>
                                    <option value="Cond.Reject" >Cond.Reject</option>
                                    <option value="BM"  >Branch Manager</option>
                                    <option value="AM"  >Area Manager</option>
                                    <option value="NM"  >Network Manager</option>
                                    <option value="EVP" >Executive Manager</option>

                                </select>
                            </td>
                        </tr>
                          
                          
                          <tr><td align="right">Active:</td>
                            <td width="10">&nbsp;</td>
                            <td align="left" >
                                <input class="txt1" id="CheckBoxActive"  name="CheckBoxActive" type="checkbox"  value="N" onclick="doCheck()" />
                            </td>										
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





