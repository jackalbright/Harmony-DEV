<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 03/30/05
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
	if ($_SESSION['canManageEvents']!="Yes"){
		header ('Location: ../menu.php');
	};
?>
<?php
	include ('../../includes/admin.inc');
	$imageLocation = "";
	if (array_key_exists('ImageLoc', $_GET)){
		$imageLocation = $_GET["ImageLoc"];
	};
	$today=getdate();
	$stampdate=getdate( mktime(0,0,0,$today['mon']-4,$today['mday'],$today['year']));
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Newsletter Creation Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style1 {font-size: medium}
.style4 {font-size: xx-small}
.style6 {color: black; font-weight: bold; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
--></style>
<script language="javascript1.2" type="text/javascript">
var B_open = 0;
var I_open = 0;
var U_open = 0;
var QUOTE_open = 0;
var CODE_open = 0;
var SQL_open = 0;
var HTML_open = 0;

var bbtags   = new Array();

function previewNewsletter(){
		var txtURLAddress="previewnewsletter.php?";
		txtURLAddress= txtURLAddress + "&txtStartDay=" + document.FormName.txtStartDay.value;
		txtURLAddress= txtURLAddress + "&txtStartMonth=" + document.FormName.txtStartMonth.value;
		txtURLAddress= txtURLAddress + "&txtStartYear=" + document.FormName.txtStartYear.value;
		txtURLAddress= txtURLAddress + "&txtStampDay=" + document.FormName.txtStampDay.value;
		txtURLAddress= txtURLAddress + "&txtStampMonth=" + document.FormName.txtStampMonth.value;
		txtURLAddress= txtURLAddress + "&txtStampYear=" + document.FormName.txtStampYear.value;
		txtURLAddress= txtURLAddress + "&txtWelcomeTitle=" + document.FormName.txtWelcomeTitle.value;
		txtURLAddress= txtURLAddress + "&txtWelcomeDesc=" + document.FormName.txtWelcomeDesc.value;
		var popUpWin=0;
//		alert (txtURLAddress);
		popUpWin = open(txtURLAddress, 'popUpWin', 'toolbar=yes,location=yes,directories=yes,status=yes,menubar=yes,scrollbar=yes,resizable=yes,copyhistory=yes,width=700,height=500,left=5,top=5,screenX=5,screenY=5');
		return false;
};

function noSendEmail(){
	//alert("I made it here.");
	document.FormName.txtSendEmail.value = "false";
	//alert(document.FormName.txtSendEmail.value);
	return true;
}

// Determine browser type and stuff.
// Borrowed from http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html

var myAgent   = navigator.userAgent.toLowerCase();
var myVersion = parseInt(navigator.appVersion);

var is_ie   = ((myAgent.indexOf("msie") != -1)  && (myAgent.indexOf("opera") == -1));
var is_nav  = ((myAgent.indexOf('mozilla')!=-1) && (myAgent.indexOf('spoofer')==-1)
                && (myAgent.indexOf('compatible') == -1) && (myAgent.indexOf('opera')==-1)
                && (myAgent.indexOf('webtv') ==-1)       && (myAgent.indexOf('hotjava')==-1));

var is_win   =  ((myAgent.indexOf("win")!=-1) || (myAgent.indexOf("16bit")!=-1));
var is_mac    = (myAgent.indexOf("mac")!=-1);

// Set the number of tags open box

function cstat()
{
	var c = stacksize(bbtags);
	
	if ( (c < 1) || (c == null) ) {
		c = 0;
	}
	
	if ( ! bbtags[0] ) {
		c = 0;
	}
	
	document.FormName.tagcount.value = c;
}

//--------------------------------------------
// Get stack size
//--------------------------------------------

function stacksize(thearray)
{
	for (i = 0 ; i < thearray.length; i++ ) {
		if ( (thearray[i] == "") || (thearray[i] == null) || (thearray == 'undefined') ) {
			return i;
		}
	}
	
	return thearray.length;
}

//--------------------------------------------
// Push stack
//--------------------------------------------

function pushstack(thearray, newval)
{
	arraysize = stacksize(thearray);
	thearray[arraysize] = newval;
}

//--------------------------------------------
// Pop stack
//--------------------------------------------

function popstack(thearray)
{
	arraysize = stacksize(thearray);
	theval = thearray[arraysize - 1];
	delete thearray[arraysize - 1];
	return theval;
}

function get_easy_mode_state(){
	return true;
}

//--------------------------------------------
// Close all tags
//--------------------------------------------

function closeall()
{
	if (bbtags[0]) {
		while (bbtags[0]) {
			tagRemove = popstack(bbtags)
			document.FormName.Post.value += "</" + tagRemove + ">";
			
			// Change the button status
			// Ensure we're not looking for FONT, SIZE or COLOR as these
			// buttons don't exist, they are select lists instead.
			
			if ( (tagRemove != 'FONT') && (tagRemove != 'SIZE') && (tagRemove != 'COLOR') )
			{
				eval("document.FormName." + tagRemove + ".value = ' " + tagRemove + " '");
				eval(tagRemove + "_open = 0");
			}
		}
	}
	
	// Ensure we got them all
	document.FormName.tagcount.value = 0;
	bbtags = new Array();
	document.FormName.Post.focus();
}

//--------------------------------------------
// SIMPLE TAGS (such as B, I U, etc)
//--------------------------------------------

function simpletag(thetag)
{
	var tagOpen = eval(thetag + "_open");
	var tagname;
	if (thetag=='B'){
		tagname='boldface';
	}
	if (thetag=='I'){
		tagname='italics';
	};
	if (thetag=='U'){
		tagname='underline';
	};	
	if ( get_easy_mode_state() )
	{
		inserttext = prompt("Enter the text to be put in " + tagname);
		if ( (inserttext != null) && (inserttext != "") )
		{
			//alert ("I made it here.");
			doInsert2("<" + thetag + ">" + inserttext + "</" + thetag + "> ", "", false);
		}
	}
}

		function displayItemAd(){
			var targetURI = 'showspotlight.php?stylesheet=' + document.FormName.txtCSSAddress.value + '&include_file=' + document.FormName.txtFileAddress.value;
			var targetTitle = 'Spotlight Item';
			var targetAttributes = "toolbar=no,width=380,height=300,status=yes,resize=yes,scrollbars=yes,menubar=no";
			detailWindow = open(targetURI, targetTitle, targetAttributes);
			detailWindow.focus();
			return false;
		};

	function validateForm(){
		var ErrMsg="";
		if ((document.FormName.txtStartDay.value=="") || (document.FormName.txtStartMonth.value=="") || (document.FormName.txtStartYear.value=="")){
			ErrMsg+="You must enter a Send Date for the newsletter.\n";
		};
		if ((document.FormName.txtStampDay.value=="") || (document.FormName.txtStampMonth.value=="") || (document.FormName.txtStampYear.value=="")){
			ErrMsg+="You must enter a start date for displaying new stamps to continue.\n";
		};
		if (document.FormName.txtWelcomeTitle.value==""){
			ErrMsg+="You must enter a Title for the Welcome Letter.\n";
		};
		if (document.FormName.txtWelcomeDesc.value==""){
			ErrMsg+="You must enter a body to the Welcome Letter.\n";
		};
		if (ErrMsg!=""){
			alert(ErrMsg);
			return false;
		};
		return true;
	};

function tag_url2()
{
    var FoundErrors = '';
    var enterURL   = prompt("Enter the URL for the page to where you are linking", "http://");
    var enterTITLE = prompt("Enter the text that will be displayed as the link", "text for the link");

    if (!enterURL) {
        FoundErrors += "You need to enter a URL.";
    }
    if (!enterTITLE) {
        FoundErrors += "You need to enter text for the link.";
    }

    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    }
	//alert("I made it here!");
	doInsert2("<A HREF='"+enterURL+"'>"+enterTITLE+"</A>", "", false);
}

function doInsert2(ibTag, ibClsTag, isSingle)
{
	var isClose = false;
	var obj_ta = document.FormName.txtWelcomeDesc;

	if ( (myVersion >= 4) && is_ie && is_win) // Ensure it works for IE4up / Win only
	{
		if(obj_ta.isTextEdit){ // this doesn't work for NS, but it works for IE 4+ and compatible browsers
			obj_ta.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			if((sel.type == "Text" || sel.type == "None") && rng != null){
				if(ibClsTag != "" && rng.text.length > 0)
					ibTag += rng.text + ibClsTag;
				else if(isSingle)
					isClose = true;
	
				rng.text = ibTag;
			}
		}
		else{
			if(isSingle)
				isClose = true;
	
			obj_ta.value += ibTag;
		}
	}
	else
	{
		if(isSingle)
			isClose = true;

		obj_ta.value += ibTag;
	}

	obj_ta.focus();
	
	// clear multiple blanks
//	obj_ta.value = obj_ta.value.replace(/  /, " ");

	return isClose;
}	

</script>
	</head>

	<body bgcolor="#ffffff">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" width="200">
					<div align="center">
						<img src="../hdlogo.gif" alt="" height="78" width="160" border="0"></div>
				</td>
				<td valign="bottom">
					<div align="center">
						<span class="title">Newletter Addition Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style1"><p>Navigation:</p>
				  <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br>
				      <a href="menu.php">Back to What's New Menu</a><br>
				      <br>
				  </p>
			  </td>
				<td>
					<div align="center">
						<form action="newslettersubmit.php" method="post" enctype="multipart/form-data" name="FormName" onSubmit="return validateForm();">
						      <input type="hidden" name="hdnFeatureID" value="AAA">
							  <input type="hidden" name="txtSendEmail" value="true">
							<table width="500" border="0" cellspacing="0" cellpadding="0">
								<tr>
								  <td><span class="style6">Send Date:</span></td>
								  <td><input type="text" name="txtStartMonth" size="4" value="<?php echo $today['mon']; ?>">								    
								      /
								      <input type="text" name="txtStartDay" size="4" value="<?php echo $today['mday']; ?>">
								      /
								      <input type="text" name="txtStartYear" size="8" value="<?php echo $today['year']; ?>"> 
						          <span class="style4">(mm/dd/yyyy) </span></td>
							  </tr>
								<tr>
								  <td class="style6">Stamp Start Date: </td>
								  <td><input type="text" name="txtStampMonth" size="4" value="<?php echo $stampdate['mon']; ?>">								    
								      /
								      <input type="text" name="txtStampDay" size="4" value="<?php echo $stampdate['mday']; ?>">
								      /
								      <input type="text" name="txtStampYear" size="8" value="<?php echo $stampdate['year']; ?>"> 
						          <span class="style4">(mm/dd/yyyy) </span></td>
							  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							  </tr>
								<tr>
									<td><span class="style6">Welcome Title:								    <br>
								  </span></td>
									<td><input type="text" name="txtWelcomeTitle" size="60" ></td>
								</tr>
								<tr>
								  <td><span class="style6"><strong>Welcome Body:</strong></span></td>
									<td>
									<input type="button" name="AddLink2" value="Add Link To Desc" onClick="javascript:return tag_url2()">
									<input type="button" name="boldbutton" value="B" onClick="javascript:return simpletag('B')">
									<input type="button" name="italicbutton" value="I" onClick="javascript:return simpletag('I')">
									<input type="button" name="underlinebutton" value="U" onClick="javascript:return simpletag('U')">								
									<br><textarea name="txtWelcomeDesc" cols="56" rows="16"></textarea></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
									<td><div align="right">
								      <input type="button" name="sbPreview" value="Preview Newsletter" onClick="javascript:return previewNewsletter()"><BR>
								      <input type="submit" name="sbSend" value="Send Newsletter" >
                                      <input type="submit" name="sbSave" value="Save Newsletter(No Send)" onClick="javascript:return noSendEmail()">								      
                                      <input name="sbReset" type="reset" value="Reset" >
								    </div></td>
								</tr>
							</table>
					  </form>
				  </div>
				</td>
			</tr>
		</table>
		<p></p>
	</body>

</html>