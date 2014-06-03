<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 2/9/05
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<meta name="generator" content="Adobe GoLive 6">
		<title>Web Feature Announcement Addition Page</title>
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
var bbtags   = new Array();

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
		if (document.FormName.txtItemName.value==""){
			ErrMsg="You must enter a name for the spotlighted item to continue.\n";
		};
		if (document.FormName.txtFileAddress.value==""){
			ErrMsg+="You must enter an address for the include file to continue.\n";
		};
		if (document.FormName.txtStartMonth.value=="" || document.FormName.txtStartDay.value=="" || document.FormName.txtStartYear.value==""){
			ErrMsg+="You must enter a start date to continue.\n";
		};
		if (document.FormName.txtEndMonth.value=="" || document.FormName.txtEndDay.value=="" || document.FormName.txtEndYear.value==""){
			ErrMsg+="You must enter a end date to continue.\n";
		};
		if (ErrMsg!=""){
			alert(ErrMsg);
			return false;
		};
		return true;
	};
function tag_url1()
{
	var FoundErrors = '';
    var enterURL   = prompt("Enter the URL for the page to where you are linking", "http://");
    var enterTITLE = prompt("Enter the text that will be displayed as the link", "text for the link");

    if (!enterURL) {
        FoundErrors += "You need to enter a URL.";
    };
    if (!enterTITLE) {
        FoundErrors += "You need to enter text for the link.";
    };
    if (FoundErrors) {
        alert("Error!"+FoundErrors);
        return;
    };

	doInsert1("<A HREF='"+enterURL+"'>"+enterTITLE+"</A>", "", false);
}

function doInsert1(ibTag, ibClsTag, isSingle)
{
	var isClose = false;
	var obj_ta = document.FormName.txtAnnounceTitle;

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

	doInsert2("<A HREF='"+enterURL+"'>"+enterTITLE+"</A>", "", false);
}

function doInsert2(ibTag, ibClsTag, isSingle)
{
	var isClose = false;
	var obj_ta = document.FormName.txtAnnounceDesc;

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
						<span class="title">Announcement Addition Page</span></div>
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
						<form action="announcementsubmit.php" method="post" enctype="multipart/form-data" name="FormName" onSubmit="return validateForm();">
						      <input type="hidden" name="hdnAnnounceID" value="AAA">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><span class="style6">Title:
									  <input type="button" name="AddLink" value="Add Link To Title" onClick="javascript:return tag_url1()">
								    <br>
									</span></td>
									<td><input type="text" name="txtAnnounceTitle" size="60" ></td>
								</tr>
								<tr>
								  <td><span class="style6"><strong>Body:<br>
								    <input type="button" name="AddLink2" value="Add Link To Desc" onClick="javascript:return tag_url2()">
								  </strong></span></td>
									<td><textarea name="txtAnnounceDesc" cols="56" rows="4"></textarea></td>
								</tr>
								<tr>
									<td><span class="style6">Start Date:</span></td>
								    <td><input type="text" name="txtStartMonth" size="4" value="<?php echo $today['mon']; ?>">								    
								      /
								      <input type="text" name="txtStartDay" size="4" value="<?php echo $today['mday']; ?>">
								      /
								      <input type="text" name="txtStartYear" size="8" value="<?php echo $today['year']; ?>"> 
						          <span class="style4">(mm/dd/yyyy) </span></td></tr>
								<tr>
									<td><span class="style6">End Date:</span></td>
									<td><input type="text" name="txtEndMonth" size="4" value="<?php echo $today['mon']; ?>">
/
  <input type="text" name="txtEndDay" size="4" value="<?php echo $today['mday']; ?>">
/
<input type="text" name="txtEndYear" size="8" value="<?php echo $today['year']; ?>">
<span class="style4">(mm/dd/yyyy)</span></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Submit" ><input name="sbReset" type="reset" value="Reset" ></div>
									</td>
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