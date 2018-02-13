<?php

$fp=fopen("app.txt",'r');
$buffer = fgets($fp, 255);
$buffers = explode("=",$buffer);
$buffers[1] = str_replace("\r","",$buffers[1]);
$buffers[1] = str_replace("\n","",$buffers[1]);
fclose($fp);


print
 "
  <html>
  <body>       
   <table border=\"1\">
    <tr bgcolor=\"A4A4A4\">
     <td colspan=\"3\">
                  กรุณาเลือก App Server ที่ต้องการจะใช้:
     </td>
    </tr>
    <tr>
     <td bgcolor=\"A4A4A4\">
      Server 1
     </td>
     <td>
  ";
if ($buffers[1]=="racf.scb.co.th")
print
  "
      racf.scb.co.th(default)
  ";
else
print
  "
      racf.scb.co.th
  ";
print
  "
     </td>
     <td>
      <input type=\"button\" id=\"app1\" value=\"SELECT\" onclick=\"select_app1();\">
     </td>
    </tr>
    <tr>
     <td bgcolor=\"A4A4A4\">
      Server 2
     </td>
     <td>
   ";
if ($buffers[1]=="10.0.85.69")
print
   "
      10.0.85.69(default)
   ";
else
print
   "
     10.0.85.69
   ";
print
   "
     </td>
     <td>
      <input type=\"button\" id=\"app2\" value=\"SELECT\" onclick=\"select_app2();\">
     </td>
    </tr> 
    <tr>
     <td bgcolor=\"A4A4A4\">
      Server 3
     </td>
     <td>
   ";
if ($buffers[1]=="10.0.85.57")
print
   "
      10.0.85.57(default)
   ";
else
print
   "
      10.0.85.57
   ";
print
   "
     </td>
     <td>
      <input type=\"button\" id=\"app3\" value=\"SELECT\" onclick=\"select_app3();\">
     </td>
    </tr>
   </table>
   <script language=\"javascript\">
    parent.db_action_frame.document.getElementById('detail').innerHTML=\"กรุณาเลือก App Server\";
    function select_app1()
     {
      parent.db_action_frame.document.getElementById('detail').innerHTML=\"เลือก DB:<br> racf.scb.co.th\";
      parent.db_action_frame.document.getElementById('detail').innerHTML +=\"<br><br>Action:<br> Write to AppConn/app.txt\";
      var ajax_request1;          
      var url = \"write_app_setting.php?app=\"+\"racf.scb.co.th\"+\"&s=\"+Math.random();        
      //alert(url);   
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
                     parent.db_action_frame.document.getElementById('detail').innerHTML += \"...done\";
                     //alert(ajax_request1.responseText);
                    }                 
                 }
                              
              }
         ajax_request1.open(\"get\",url,false);
         ajax_request1.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
         ajax_request1.send(null);
                           
        }          
     }
    function select_app2()
     {
      parent.db_action_frame.document.getElementById('detail').innerHTML=\"เลือก DB:<br> 10.0.85.69\";
      parent.db_action_frame.document.getElementById('detail').innerHTML +=\"<br><br>Action:<br> Write to AppConn/app.txt\";
      var ajax_request1;          
      var url = \"write_app_setting.php?app=\"+\"10.0.85.69\"+\"&s=\"+Math.random();           
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
                     parent.db_action_frame.document.getElementById('detail').innerHTML +=\"...done\";
                    }                 
                 }
                              
              }
         ajax_request1.open(\"get\",url,false);
         ajax_request1.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
         ajax_request1.send(null);
                           
        }         
     }
    function select_app3()
     {
      parent.db_action_frame.document.getElementById('detail').innerHTML=\"เลือก App:<br> 10.0.85.57\";
      parent.db_action_frame.document.getElementById('detail').innerHTML+=\"<br><br>Action:<br> Write to AppConn/app.txt\";
      var ajax_request1;          
      var url = \"write_app_setting.php?app=\"+\"10.0.85.57\"+\"&s=\"+Math.random();           
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
                     parent.db_action_frame.document.getElementById('detail').innerHTML +=\"...done\";
                    }                 
                 }                              
              }
         ajax_request1.open(\"get\",url,false);
         ajax_request1.setRequestHeader(\"Content-Type\",\"application/x-www-form-urlencoded; charset=UTF-8\");
         ajax_request1.send(null);                           
        }         
     }
   </script>
  </body>
  </html>
 ";

?>