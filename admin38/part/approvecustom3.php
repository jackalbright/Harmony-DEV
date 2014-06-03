<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 12/8/04
******************************************************************************************/
	session_start();
	if (!array_key_exists('UName', $_SESSION)){
		header ('Location: ../index.php');
	} else {
		$manageOrders=$_SESSION['canManageOrders'];
		$manageParts=$_SESSION['canManageParts'];
		$manageUsers=$_SESSION['canManageUsers'];
		$manageItems=$_SESSION['canManageItems'];
		$manageEvents=$_SESSION['canManageEvents'];
		$manageDatabase=$_SESSION['canManageDatabase'];
		$manageTestimonials=$_SESSION['canManageTestimonials'];
	};
	if ($_SESSION['canManageParts']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	if (!array_key_exists('image_id', $_GET)){
		header ("customsmenu.php");
	} else {
		include ('../../includes/admin.inc');
		global $txtImageID;
		$txtImageID=$_GET['image_id'];
    	include ('../../includes/database.inc');
		$txtQueryString="SELECT image_location, display_location, title, description, Approved, approval_notes, Notes, MONTH(submission_date) as submit_month, DAYOFMONTH(submission_date) as submit_day, YEAR(submission_date) as submit_year, customer_id, send_email, thumbnail_location FROM custom_image WHERE image_id=" . $txtImageID;
    	$result = mysql_query($txtQueryString, $database);
		while ($row = mysql_fetch_object($result))
    	{
			$txtImageLocation=$row->image_location;
			$txtDisplayLocation=$row->display_location;
			$txtTitle=$row->title;
			$txtDescription=$row->description;
			$txtStatus=$row->Approved;
			$sub_day=$row->submit_day;
			$sub_month=$row->submit_month;
			$sub_year=$row->submit_year;
			$customerID=$row->customer_id;
			$emailStatus=$row->send_email;
			$txtThumbnailLocation=$row->thumbnail_location;
			$txtAdditionalNotes = $row->approval_notes;
			$txtOtherReasons = $row->Notes;
			$today=getdate();
		};
		$txtQueryString="SELECT First_Name, Last_Name FROM customer WHERE customer_id=" . $customerID;
    	$result = mysql_query($txtQueryString, $database);
		while ($row = mysql_fetch_object($result))
    	{
			$txtFirstName=$row->First_Name;
			$txtLastName=$row->Last_Name;
		};
	};
	$txtQueryString="SELECT refusal_reason_id FROM custom_reason WHERE custom_image_id= $txtImageID";
   	$result = mysql_query($txtQueryString, $database);
	$txtReasons[] ="";
	$otherReason = "";
	if ($result){
		while ($row = mysql_fetch_row($result)){
			$txtReasons[]=$row[0];
			if ($row[0]==8){
				$otherReason="true";
			};
		};
	};
	
$title = "Custom Graphic Approval";
	
include ('../includes/htmlTop.php');
?>

<style type="text/css">
<!--
.basetext1 {color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext2 {color: silver; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext3 {color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext4 {color: white; font-weight: normal; font-size: 0px; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext5 {color: black; font-weight: bold; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-weight: bold}
.style2 {font-size: small}
.style4 {color: black; font-weight: normal; font-size: xx-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
-->
</style>

		
        

<SCRIPT language="javascript1.2" type="text/javascript">
	function graphicWindow(){
		open(document.getElementByID("").value, "Image");
		return true;
	};
	function changeStatus(){
		var basedOnApproval = document.getElementsByTagName('label');
		var approvalList = document.frmCustomApproval.txtApprovalStatus;
		if (approvalList.options[approvalList.selectedIndex].text == "Not Approved"){
			document.getElementById("lblReason").className="basetext3";
			document.getElementById("lblEMailExplanation").className="basetext3";
			document.frmCustomApproval.txtRefusalReason.disabled=false;
		};
		if (approvalList.options[approvalList.selectedIndex].text == "Approved" || approvalList.options[approvalList.selectedIndex].text == "Approval Pending"){
			document.getElementById("lblReason").className="basetext2";
			document.getElementById("lblEMailExplanation").className="basetext4";
			for (i=1; i>document.frmCustomApproval.txtRefusalReason.options.length; i++){
				document.getElementByID('txtRefusalReason').options[i].selected = false;
			};
			document.frmCustomApproval.txtOtherReason.value="";
			document.frmCustomApproval.txtOtherReason.disabled=true;
			document.frmCustomApproval.txtRefusalReason.selectedIndex = -1;
			document.frmCustomApproval.txtRefusalReason.disabled=true;
		};
		return true;
	};
	function openReason(){
		var ReasonCode = document.getElementById('txtRefusalReason');
		if (ReasonCode.options[6].selected){
			document.frmCustomApproval.txtOtherReason.disabled = false;
		} else {
			document.frmCustomApproval.txtOtherReason.value="";
			document.frmCustomApproval.txtOtherReason.disabled = true;			
		}; 
	};

	function previewEmail(){
		var txtURLAddress="previewemail.php?";
		txtURLAddress= txtURLAddress + "&txtImageID=" + document.frmCustomApproval.hdnImageID.value;
		txtURLAddress= txtURLAddress + "&txtApprovalStatus=" + document.frmCustomApproval.txtApprovalStatus.options[document.frmCustomApproval.txtApprovalStatus.selectedIndex].value;
		var refusalReason = document.getElementById('txtRefusalReason');
		var loopLimit = refusalReason.options.length;
		for (var loopIndex = 0; loopIndex < loopLimit; loopIndex++){
			if (refusalReason.options[loopIndex].selected == true){
				txtURLAddress= txtURLAddress + "&txtRefusalReason[]='" + refusalReason.options[loopIndex].value + "'";
			};
		}; 
		txtURLAddress= txtURLAddress + "&txtOtherReason=" + document.frmCustomApproval.txtOtherReason.value;
		txtURLAddress= txtURLAddress + "&txtAdditionalNotes=" + document.frmCustomApproval.txtAdditionalNotes.value;
		var popUpWin=0;
		popUpWin = open(txtURLAddress, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=yes,resizable=yes,copyhistory=yes,width=700,height=500,left=5,top=5,screenX=5,screenY=5');
	};

	function changeEmailStatus(){
		document.getElementById("lblEMailSent").className="basetext4";
		document.getElementById("lblEMailNotSent").className="basetext4";
		document.getElementById("lblEMailQueued").className="basetext5";
		document.frmCustomApproval.hdnSendEmail.value="Queued";		
	};
	function validateForm(){
		var checkStatus=0;
		var loopIndex;
		var otherReasonNeeded="False";
		var approvalStatus = document.getElementById('txtApprovalStatus');
		var reasonsChosen =document.getElementById('txtRefusalReason');
		if (approvalStatus.options[2].selected == true){
			checkStatus++;
		};
		if (checkStatus==1){
			alert("You need to change the approval status away from *Approval Pending* to continue.");
			return false;
		};
		if (approvalStatus.options[1].selected==true){
			loopLimit = reasonsChosen.options.length;			
			var checkReasons=0;
			for (loopIndex = 0; loopIndex < loopLimit; loopIndex++){
				if (reasonsChosen.options[loopIndex].selected == true){
					checkReasons++;
				};
			};
			if (checkReasons==0){
				alert("You need to select at least one reason code for not approving this image.");
				return false;
			};
			if (reasonsChosen.options[7].selected && document.frmCustomApproval.txtOtherReason.value==""){
				alert("If you select \"Other Reason\" from the list of reasons, then you must enter an explanation in the box below.");
				document.frmCustomApproval.txtOtherReason.focus();
				return false;
			};
		return true;
	};
};
</SCRIPT>
</head>

<body >
<div id="mainContainer">
<?php include("../includes/header.php"); ?>
<div id="mainContent">
<ul class="admin38_submenu">
<li><a href="../menu.php">Main</a></li>
<li><a href="menu.php">Parts Menu</a></li>
<li><a href="approvecustom.php">Back to Custom Menu</a></li>
</ul>		
<br style="clear:both">
<h1>Custom Graphic Approval </h1>
		


                
  <table width="499" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="200" class="basetext1"><a id="ImageLocation" href="../..<?php echo $txtImageLocation; ?>" target="_blank" onClick="return graphicWindow();">Download the full-size graphic.<br>
        (Use &quot;Save Link As...&quot; from menu.)
      </a></td>
      <td width="300"><img src="../..<?php echo $txtDisplayLocation; ?>" alt="Image" /></td>
    </tr>
  </table>
  <form name="frmCustomApproval" method="post" action="approvecustom4.php" onSubmit="return validateForm();">
    <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">&nbsp;</td>
        <td width="392">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" >&nbsp;</td>
        <td><div align="right">
          <input type="submit" name="btnSubmit" value="Submit">
          <input type="button" name="btnReset" value="Reset" onClick="return resetForm();" >
        </div></td>
      </tr>
      <tr>
        <td colspan="2" class="basetext1">Customer Name: </td>
        <td class="basetext5"><?php echo "<B>$txtFirstName $txtLastName</B>"; ?> </td>
      </tr>
      <tr>
        <td colspan="2" class="basetext1">Image Name: 
        <input type="hidden" name="hdnImageID" value="<?php echo $txtImageID; ?>"></td>
        <td><input type="text" name="txtImageName" value="<?php echo $txtTitle; ?>" size="50"></td>
      </tr>
      <tr>
        <td colspan="2" class="basetext1">Image Description: </td>
        <td><input type="text" name="txtImageDescription" value="<?php echo $txtDescription; ?>" size="50"></td>
      </tr>
      <tr>
        <td colspan="2" class="basetext1">Submission Date:</td>
        <td><input type="text" name="txtSubmitMonth" size="2" value="<?php echo $sub_month; ?>" disabled> 
          / <input type="text" name="txtSubmitDay" size="2" value="<?php echo $sub_day; ?>" disabled> 
          / <input type="text" name="txtSubmitYear" size="4" value="<?php echo $sub_year; ?>" disabled></td>
      </tr>
      <tr>
        <td colspan="2" class="basetext1">Approval Status: </td>
        <td><select id="txtApprovalStatus" name="txtApprovalStatus" onChange="return changeStatus();">
          <option value="Yes" <?php if ($txtStatus == "Yes"){ echo "SELECTED";}; ?>>Approved</option>
          <option value="No" <?php if ($txtStatus == "No"){ echo "SELECTED";}; ?>>Not Approved</option>
          <option value="Pending" <?php if ($txtStatus == "Pending"){ echo "SELECTED";}; ?>>Approval Pending</option>
        </select></td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td><p>
          <label class="<?php if ($emailStatus=="Yes"){echo "basetext5";} else {echo "basetext4";}; ?>" id="lblEMailSent">The e-mail for this custom image has been sent.</label>
          <label class="<?php if ($emailStatus=="No"){echo "basetext5";} else {echo "basetext4";}; ?>" id="lblEMailNotSent">The e-mail for this custom image has not been sent.</label>
          <label class="basetext4" id="lblEMailQueued">The e-mail for this custom image has been queued for sending.  It will be sent when you click the "Submit" button.  You may still make changes to your approval information until you click the "Submit" button.</label><br>
          <input type="button" name="btnPreview" value="Preview E-mail" onClick="return previewEmail();">
          <input type="button" name="btnSend" value="Send E-mail" onClick="return changeEmailStatus();">
</p>
        </td>
      </tr>
      <tr>
        <td width="20" >&nbsp;</td>
        <td width="88" valign="top"><label id="lblReason" class=" <?php if ($txtStatus=="Yes" || $txtStatus=="Pending"){echo "basetext2";} else {echo "basetext3";};?>">Reason:<br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            Other Reason:</label></td>
        <td>
        <select id="txtRefusalReason" name="txtRefusalReason[]" size="4" multiple class="changeOnApproval" <?php if ($txtStatus=="Yes" || $txtStatus=="Pending"){echo "disabled";};?> onChange="return openReason();">
            <option value="1" <?php foreach($txtReasons as $value){if ($value == 1){echo "selected";};}; ?>>File is too small.</option>
            <option value="2" <?php foreach($txtReasons as $value){if ($value == 2){echo "selected";};}; ?>>File in wrong format.</option>
            <option value="4" <?php foreach($txtReasons as $value){if ($value == 4){echo "selected";};}; ?>>Image was out of focus.</option>
            <option value="5" <?php foreach($txtReasons as $value){if ($value == 5){echo "selected";};}; ?>>Image was corrupted.</option>
            <option value="6" <?php foreach($txtReasons as $value){if ($value == 6){echo "selected";};}; ?>>Image is copyright protected.</option>
            <option value="7" <?php foreach($txtReasons as $value){if ($value == 7){echo "selected";};}; ?>>Image was inappropriate.</option>
            <option value="8" <?php foreach($txtReasons as $value){if ($value == 8){echo "selected";};}; ?>>Other Reason.</option>
        </select><br>
        <textarea name="txtOtherReason" rows="2" cols="50" <?php if ($otherReason!="true"){ echo "disabled";}; ?>><?php echo $txtOtherReasons; ?></textarea></td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td valign="top"><label id="lblAdditionalNotes" class="basetext1">Additional Notes:<br>
            <span class="style4">(optional)</span>                        </label></td>
        <td><textarea name="txtAdditionalNotes" rows="4" cols="50"><?php echo $txtAdditionalNotes; ?></textarea></td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td valign="top"><input type="hidden" name="hdnSendEmail" value="<?php echo $emailStatus; ?>">
        <input type="hidden" name="hdnCustomerID" value="<?php echo $customerID ?>">
        <input type="hidden" name="hdnThumbnailLocation" value="<?php echo $txtDisplayLocation; ?>"></td>
        <td><label class="basetext4" id="lblEMailExplanation">When you click on &quot;Send E-mail&quot; the message will be queued up to send after you hit submit. You may still make changes in the message body up until the point you hit the submit button.</label> </td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td><div align="right">
          <input type="submit" name="btnSubmit" value="Submit">
          <input type="button" name="btnReset" value="Reset" onClick="return resetForm();" >
        </div></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p></td>
</tr>
</table>
</div><!--mainContent-->

<?php include ('../includes/footer.php'); ?>      
</div><!--mainContainer-->
<?php include ('../includes/htmlBottom.php'); ?>