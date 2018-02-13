<?php
session_start();


$uid = "28683";
$message = "sssss";
if($message == "Fail4")
{
	$sMsg = "User ID หรือ Password ไม่ถูกต้อง ";
}else if($message == "Fail6")
{
	$sMsg = "ไม่พบข้อมูลพนักงาน";
}
?>
<HTML>
<HEAD>
<TITLE>ระบบ RB-Front Workflow</TITLE>

<meta http-equiv=Content-Type content="text/html; charset=tis-620">
<style type="text/css">
BODY {
	MARGIN: 0px; font-family:Tahoma, Times New Roman, Geneva, sans-serif;
}
TD {
	FONT-SIZE: 14px; COLOR: #333333; FONT-FAMILY: Tahoma, Times New Roman, sans-serif
}
hr {
border : none;
border-top : dashed 1px #eeeeee;
color : #FFFFFF;
background-color : #FFFFFF;
height : 1px;
}
.Font0 {
	FONT-SIZE: 24px; COLOR: #FFFFFF; font-family:Georgia,Tahoma, Times New Roman, Geneva, sans-serif; font-weight: bold; text-decoration: none;
}
.Font1 {
	FONT-SIZE: 14px; COLOR: #FFFFFF; font-family:Tahoma, Times New Roman, Geneva, sans-serif; font-weight: bold; text-decoration: none;
}
.Font2 {
	FONT-SIZE: 12px; COLOR: #000000; font-family:Tahoma, Times New Roman, Geneva, sans-serif;
}
.Font3 {
	FONT-SIZE: 12px; COLOR: #FF0000; font-family:Tahoma, Times New Roman, Geneva, sans-serif;  font-weight: bold; text-decoration: none;
}
.Font4 {
	FONT-SIZE: 12px; COLOR: #0000FF; font-family:Tahoma, Times New Roman, Geneva, sans-serif; font-weight: bold; text-decoration: none;
}
.Font5 {
	FONT-SIZE: 8px; COLOR: #FFFFFF; font-family:Tahoma, Times New Roman, Geneva, sans-serif; font-weight: bold; text-decoration: none;
}
A:link {
	TEXT-DECORATION: none ; FONT-SIZE: 12px; COLOR: #0000FF; font-family:Tahoma, Times New Roman, Geneva, sans-serif;		
}
A:visited {
	TEXT-DECORATION: none ; FONT-SIZE: 12px; COLOR: #0000FF; font-family:Tahoma, Times New Roman, Geneva, sans-serif;
}
A:hover {
	TEXT-DECORATION: underline ; FONT-SIZE: 12px; COLOR: #FF0000; font-family:Tahoma, Times New Roman, Geneva, sans-serif;
}
A:active {
	TEXT-DECORATION: none ; FONT-SIZE: 12px; COLOR: #00FF00; font-family:Tahoma, Times New Roman, Geneva, sans-serif;
}
.t1
{
background-repeat: no-repeat;width:400;height:35;
}
.t2
{
background-repeat: no-repeat;width:400;height:220;
}

.input {
    border: 1px solid #006;
    background: #ffc;

}
.input:hover {
    border: 1px solid #f00;
    background: #ff6;
	
}
.button {
    border: 0px solid #006;
    /*  background: #ccf; */
	background:url(./jquery/images/Button2.gif);
	FONT-SIZE: 12px; COLOR: #FFFFFF;
	width:125px;
	height:35px;
}
.button:hover {
    border:0px solid #f00;    
	    /*  background: #eef; */
	FONT-SIZE: 12px; COLOR: #FFFFFF;
	background:url(./jquery/images/Button3.gif);
	width:125px;
	height:35px;
}
	
//.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style1 {
	color: #FF0000;
	font-weight: bold;
}
.style2 {color: #004000}
</style>
<SCRIPT LANGUAGE="JavaScript">
       if(top.frames.length > 0) { top.location.href=self.location; }
</SCRIPT>
<script type="text/javascript" src="js/encrypt.js"></script>
</HEAD>
<body bgcolor=#FFFFFF>
<FORM action=login.php id=form1 name=login_form onSubmit="Encrypt_Password()">
<TABLE cellSpacing=0 cellPadding=0 width=770 align=center border=0 bgcolor=#FFFFFF valign=top>
<TBODY>
		<TR><TD colspan="3"><IMG border=0 src=./jquery/images/rbfwlogo.jpg></TD></TR> 
		<TR><TD vAlign=top width=44><IMG border=0 src=./jquery/images/LeftBorder.jpg width=44 ></TD>
				<TD valign="top" width=682 align=left>
						<br>
					<TABLE  border=0 >
						<TR>
							<TD width=220 rowspan=2>&nbsp;</TD>
							<TD class=t1 align=left  background='./jquery/images/PleaseLogon.gif' ><font Class='Font1'>กรุณา Log On ::</font></TD>										
						</TR>
						<TR >		
							<TD  valign=top align=left background="jquery/images/logonbg.png">
								<div align="left" >
								    <b><font color=red><?php print $sMsg; ?></font></b>
									<br>
									<font Class='Font2'>User  ID :</font><br>
									<input type=text maxlength=6 width=10 name=userid autocomplete=OFF tabindex="1" value = "<?php $uid; ?>"  class="input" size=25 />
									<font class="Font3 style2"> (<strong>sxxxxx</strong>)</font><br>																
									<font Class='Font2'>Password :</font><br>													
									<input type=password maxlength=30  width=10 name=passwd AUTOCOMPLETE=OFF tabindex="2"  class="input" size=25/>
									<input type="hidden" name="domain" value="SCBCORP"  maxlength="7" size=25 DISABLED>
									<input type="hidden" name="fontsize" id="fontsize" value="10pt"><br>										
									<STRONG><font Class='Font2'>Domain : SCBCORP.CO.TH</font></STRONG> <br>                                              
                                                  								
	                                                			<input type=Submit value="ส่ง" tabindex="3"  name=ActionX class="button"/> 
                                                    				<input type=Reset value="ยกเลิก" tabindex="4"  name=ActionX class="button"/> 
                                    </div>
							</TD>                  
						</TR>

                        <tr valign="top">
                        		          <TD colspan="2">	
                                <div align="left"><IMG border=0 src=./jquery/images/telephone.jpg width=40><strong>ติดต่อสอบถาม ข้อสงสัย</strong></div>
                                <br/>
                          	<div align="left">              
                             		&bull;&nbsp;<a href="input_files/manual_odt.pdf" target="_blank">คู่มือการใช้งานระบบ RB-Front Workflow</a><br/>
                         		&bull;&nbsp;ติดต่อ User Admin โทร.<font color="red"><b>02-544-5948, 2813, 5657</b></font><br/>
                            		&bull;&nbsp;<b>การกรอกและอนุมัติรายการ</b><br/>
                             			&nbsp;&nbsp;&nbsp;&bull;&nbsp;1. <font color="red"><b>พนักงาน และ ผู้จัดการสาขา</b></font> สามารถกรอกแบบฟอร์ม RB-FRONT WORKFLOW และอนุมัติไม่เกิน <font color="red"><b>17:00 น.</b></font><br>
                             			&nbsp;&nbsp;&nbsp;&bull;&nbsp;2. <font color="red"><b>AO และ ผู้จัดการเขตพื้นที่</b></font> สามารถกรอกแบบฟอร์ม RB-FRONT WORKFLOW และอนุมัติไม่เกิน <font color="red"><b>18:00 น.</b></font><br>
                             			&nbsp;&nbsp;&nbsp;&bull;&nbsp;3. <font color="red"><b>AO และ ผู้จัดการเครือข่ายสาขา</b></font> สามารถกรอกแบบฟอร์ม RB-FRONT WORKFLOW และอนุมัติไม่เกิน<font color="red"><b>20:00 น.</b></font><br>
                             			&nbsp;&nbsp;&nbsp;&bull;&nbsp;4. ผู้ช่วยกรรมการผู้จัดการใหญ่เครือข่ายสาขาอนุมัติได้ไม่เกิน <font color="red"><b>20:00 น.</b></font><br>
                            		&bull;&nbsp;<b>แบบฟอร์มการเปลี่ยนย้ายตำแหน่งกรณีฉุกเฉิน</b><br/>
                            			&nbsp;&nbsp;&nbsp;&bull;<a href="input_files/RBFront_Change_br.ods" target="_blank">&nbsp;แบบฟอร์มสำหรับสาขา</a><br>
                            			&nbsp;&nbsp;&nbsp;&bull;<a href="input_files/RBFront_Change_ket.ods" target="_blank">&nbsp;แบบฟอร์มสำหรับสำนักงานเขตพื้นที่</a><br>
 					&bull;&nbsp;ปัญหา Password (Active Directory) , ปัญหาเกี่ยวกับเครื่อง PC หรือ Network  - โปรดแจ้ง IT Help Desk http://sm.scb.co.th , <span class="style1">02-544-2244</span>
                                    	<br/>
			        </div>          		
 									</TD>
                    </tr>
					</TABLE>
				</TD>
				<TD vAlign=top width=44><IMG border=0 src=./jquery/images/RightBorder.jpg width=44 ></TD>		
		</TR>
		<TR ><TD ALIGN=CENTER  VALIGN=MIDDLE HEIGHT=75 background="./jquery/images/BottomBorder.jpg" COLSPAN="3"> </TD></TR>
</TBODY>
</TABLE>
</FORM>
<br>
<br>
<script type="text/javascript" language="JavaScript">
	document.forms['form1'].elements['userid'].focus();
</script> 
</BODY>
</HTML>

