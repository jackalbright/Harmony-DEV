<?php
/******************************************************************************************
Edited by: Steven Laskoske
Last edited: 8/10/05
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
	include ('../../includes/admin.inc');
?>
<?php
  $dtToday=getdate();
  $catalognumber=$_POST['eventID'];
  	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT *, YEAR(issue_date) as stampyear, MONTH(issue_date) as stampmonth, DAYOFMONTH(issue_date) as stampday, reproducible, entry_date FROM `stamp` WHERE catalog_number='$catalognumber'", $database);
    while ($event = mysql_fetch_object($result))
        {
           $issuemonth=$event->stampmonth;
           $oldcatalognumber=$event->old_catalog_number;
           $issueday=$event->stampday;
           $issueyear=$event->stampyear;
           $facevalue=$event->face_value;
           $series=$event->series;
		   $country=$event->country;
           $stampname=$event->stamp_name;
           $longdescription=$event->long_description;
		   $shortdescription=$event->short_description;
		   $keywords=$event->keywords;
		   $HTMLKeywords=$event->HTML_Keywords;
		   $thumbnaillocation=$event->thumbnail_location;
		   $imagelocation=$event->image_location;
		   $available=$event->available;
		   $country=$event->country;
		   $reproducible=$event->reproducible;
		   $entrydate=$event->entry_date;
         };
     mysql_close($database);
  	include ('../../includes/database.inc');
    $result = mysql_query ("SELECT * FROM `stamp_surcharge` WHERE catalog_number='$catalognumber'", $database);
	$surcharge="";
	while ($event = mysql_fetch_object($result))
   	    {
			$per1=$event->per1;
			$per12=$event->per12;
			$per50=$event->per50;
			$per250=$event->per250;
			$per500=$event->per500;
			$per100=$event->per100;
			$per1000=$event->per1000;
			$per2500=$event->per2500;
			$per5000=$event->per5000;
			$per7500=$event->per7500;
			$surcharge="CHECKED";
       	};
		if ($surcharge != "CHECKED"){
			$per1="";
			$per12="";
			$per50="";
			$per250="";
			$per500="";
			$per100="";
			$per1000="";
			$per2500="";
			$per5000="";
			$per7500="";
		};
     mysql_close($database);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Stamp Addition Page</title>
		<style type="text/css" media="screen">
		<!--
.title { color: blue; font-style: normal; font-weight: bold; font-size: large; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.errormsg { color: red; font-style: normal; font-weight: bolder; font-size: small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetext { color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.basetextgrey { color: gray; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular }
.style2 {color: black; font-weight: normal; font-size: 9px; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular; }
.basetextSurcharge {
color: black; font-weight: normal; font-size: x-small; font-family: Arial, Helvetica, Geneva, Swiss, SunSans-Regular
}
.style3 {font-size: medium}
.style4 {	font-size: xx-small;
	font-style: italic;
}
--></style>
<script language="javascript" type="text/javascript">
	function changeSurcharge(){
		if (document.frmStamp.cbSurcharge.checked==false){
			document.frmStamp.txtPer1.value="";
			document.frmStamp.txtPer1.focus();
			document.frmStamp.txtPer12.value="";
			document.frmStamp.txtPer12.focus();
			document.frmStamp.txtPer50.value="";
			document.frmStamp.txtPer50.focus();
			document.frmStamp.txtPer100.value="";
			document.frmStamp.txtPer100.focus();
			document.frmStamp.txtPer250.value="";
			document.frmStamp.txtPer250.focus();
			document.frmStamp.txtPer500.value="";
			document.frmStamp.txtPer500.focus();
			document.frmStamp.txtPer1000.value="";
			document.frmStamp.txtPer1000.focus();
			document.frmStamp.txtPer2500.value="";
			document.frmStamp.txtPer2500.focus();
			document.frmStamp.txtPer5000.value="";
			document.frmStamp.txtPer5000.focus();
			document.frmStamp.txtPer7500.value="";	
			document.frmStamp.txtPer7500.focus();
			document.frmStamp.cbSurcharge.focus();
		} else {
			document.frmStamp.txtPer1.value="1.00";
			document.frmStamp.txtPer1.focus();
			document.frmStamp.txtPer12.value="1.00";
			document.frmStamp.txtPer12.focus();
			document.frmStamp.txtPer50.value="1.00";
			document.frmStamp.txtPer50.focus();
			document.frmStamp.txtPer100.value="1.00";
			document.frmStamp.txtPer100.focus();
			document.frmStamp.txtPer250.value="1.00";
			document.frmStamp.txtPer250.focus();
			document.frmStamp.txtPer500.value="1.00";
			document.frmStamp.txtPer500.focus();
			document.frmStamp.txtPer1000.value="1.00";
			document.frmStamp.txtPer1000.focus();
			document.frmStamp.txtPer2500.value="1.00";
			document.frmStamp.txtPer2500.focus();
			document.frmStamp.txtPer5000.value="1.00";
			document.frmStamp.txtPer5000.focus();
			document.frmStamp.txtPer7500.value="1.00";	
			document.frmStamp.txtPer7500.focus();
			document.frmStamp.cbSurcharge.focus();		
		};
		return true;
	};
	function changeThumbnail(){
		if (document.frmStamp.txtThumbnailLocation.value !=""){
			document.imgThumbnail.src="../.."+document.frmStamp.txtThumbnailLocation.value;
		} else {
			document.imgThumbnail.src="../../thumbnails/blankstamp.jpg";
		};
		return;
	};
	function changeStamp(){
		if (document.frmStamp.txtImageLocation.value !=""){
			document.imgStampImage.src="../../"+document.frmStamp.txtImageLocation.value;
		} else {
			document.imgStampImage.src="../../stamps/blankstamp.jpg";
		}; 
		return;
	};
	function validateForm(){
		var txtReturn = "True"
		if (document.frmStamp.txtCatalogNumber.value == ""){
			alert("You need to enter a Catalog Number to continue.");
			txtReturn="False";
			return false;
		}; 		
		if (document.frmStamp.txtStampName.value==""){
			alert("You need to enter a Stamp Name to continue.");
			txtReturn="False";
			return false;
		};
		if (document.frmStamp.txtShortDescription.value ==""){
			alert("You need to enter a Short Description to continue.");
			txtReturn="False";
			return false;
		};
		if (document.frmStamp.txtLongDescription.value == ""){
			alert("You need to enter a Long Description to continue.");
			txtReturn="False";
			return false;
		};
		if (document.frmStamp.txtKeywords.value == ""){
			alert("You need to enter at least one Keyword to continue.");
			txtReturn="False";
			return false;
		};
		if (document.frmStamp.txtHTMLKeywords.value == ""){
			alert("You need to enter at least one HTML Keyword to continue.");
			txtReturn="False";
			return false;
		};
		return true;		
	};
	function changeCatalogNumber(){
<?php		
		echo "txtStampID = new Array();\n";
		include ('../../includes/database.inc');
		$intCounter=0;
    	$result = mysql_query ("SELECT catalog_number FROM `stamp`", $database);
    	while ($row = mysql_fetch_row($result))
        	{
           		$StampID=strtolower($row[0]);
           		echo "txtStampID[$intCounter]=\"$StampID\";\n";
				$intCounter++;
         	};
		mysql_close($database);
?>
	var CatalogNumber1;
	CatalogNumber1=document.frmStamp.txtCatalogNumber.value;
	CatalogNumber1=CatalogNumber1.toLowerCase();
	for (var i = 0; i < txtStampID.length; i++){
		if (CatalogNumber1 == txtStampID[i]){
				return confirm("The Catalog Number that you have chosen is already in the database.  This could cause a change in two stamps.  Are you certain that you wish to change this?");
			};
		};
		return true;	
	};
	function checkSurcharge(txtPerWhatever){
		if (txtPerWhatever != ""){
			document.frmStamp.cbSurcharge.checked=true;
		};
		if (document.frmStamp.txtPer1.value=="" && document.frmStamp.txtPer12.value=="" && document.frmStamp.txtPer50.value=="" && document.frmStamp.txtPer100.value=="" && document.frmStamp.txtPer250.value=="" && document.frmStamp.txtPer500.value=="" && document.frmStamp.txtPer1000.value=="" && document.frmStamp.txtPer2500.value=="" && document.frmStamp.txtPer5000.value=="" && document.frmStamp.txtPer7500.value==""){ 
			document.frmStamp.cbSurcharge.checked=false;
		};
	};

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
						<span class="title">Stamp Edit Page</span></div>
				</td>
			</tr>
			<tr>
				<td width="200" valign="top" class="title style3"><p>Navigation:</p>
			      <p class="basetext"><a href="../menu.php">Back to Main Menu</a><br><a href="menu.php">Back to Parts Menu</a><br>
                      <a href="stampsmenu.php">Back to Stamp Menu</a> </p>
			      <p>Thumbnail:<br>
			        <img name="imgThumbnail" src="<?php echo $thumbnaillocation;?>">			    </p>
			      <p>Image:<br>
			      <img name="imgStampImage" src="<?php echo $imagelocation; ?>">			    </p>
			    <p>&nbsp; </p></td>
				<td>
					<div align="center">
						<form action="editstamp2.php" method="post" name="frmStamp" onSubmit="return validateForm();">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form"></div>
									</td>
								</tr>
								<tr>
									<td><span class="basetext">Catalog Number:
									  <input type="hidden" name="hdncatalognumber" value="<?php echo $catalognumber;?>">
									</span></td>
									<td><input type="text" name="txtCatalogNumber" size="60" onchange="return changeCatalogNumber();" value="<?php echo $catalognumber; ?>">                              <br>
                              <span class="style4">(Note: No spaces or punctuation should be in the catalog number.) </span></td>
								</tr>
								<tr>
									<td><span class="basetext">Old Catalog Number:
									  <input type="hidden" name="hdnoldcatalognumber" value="<?php echo $oldcatalognumber;?>">
									</span></td>
									<td><input type="text" name="txtOldCatalogNumber" size="60" onchange="" value="<?php echo $oldcatalognumber; ?>">                              <br>
                              <span class="style4">(Note: No spaces or punctuation should be in the catalog number.) </span></td>
								</tr>
								<tr>
									<td><span class="basetext">Stamp Name:</span></td>
									<td><input type="text" name="txtStampName" size="60"  value="<?php echo $stampname; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Issue Date:</span></td>
									<td><input name="txtDateMonth" type="text" id="txtDateMonth" size="4" maxlength="2" value="<?php echo $issuemonth; ?>">
									  / 
								      <input name="txtDateDay" type="text" id="txtDateDay" size="4" maxlength="2" value="<?php echo $issueday; ?>"> 
								      / 
								      <input name="txtDateYear" type="text" id="txtDateYear" size="8" maxlength="4" value="<?php echo $issueyear; ?>"> 
								      <span class="style2">(mm/dd/yyyy)</span></td>
								</tr>
								<tr>
									<td><span class="basetext">Series:</span></td>
									<td><input type="text" name="txtSeries" size="60" value="<?php echo $series;?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Face Value:<span class="style4"><br/>(in dollars)</span> </span></td>
									<td><input type="text" name="txtFaceValue" size="60" value="<?php echo $facevalue; ?>"></td>
								</tr>
								<tr>
									<td><p class="basetext">Country:</p>								</p>								    </td>
									<td><input type="text" name="txtCountry" size="60" value="<?php echo $country; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Short Description:</span></td>
								  <td><textarea name="txtShortDescription"  rows="6" cols="50"><?php echo $shortdescription; ?></textarea>
							      <br/><span class="style4">This information appears on the stamp list page.</span> </td>
								</tr>
								<tr>
									<td>
										<div class="basetext">
											Long Description:</div>
									</td>
									<td><p>
									  <textarea name="txtLongDescription" rows="6" cols="50"><?php echo("$longdescription"); ?></textarea></p>
								  </td>
								</tr>
								<tr>
									<td><span class="basetext">Keywords:</span></td>
									<td><textarea name="txtKeywords" rows="6" cols="40"><?php echo $keywords; ?></textarea></td>
								</tr>
								<tr>
									<td><span class="basetext">HTML Keywords:</span></td>
									<td><input type="text" name="txtHTMLKeywords" size="60" value="<?php echo $HTMLKeywords; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Thumbnail Location:</span></td>
									<td><input type="text" name="txtThumbnailLocation" size="60" onchange="changeThumbnail();" value="<?php echo $thumbnaillocation; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Image Location:</span></td>
									<td><input type="text" name="txtImageLocation" size="60" onchange="changeStamp();" value="<?php echo $imagelocation; ?>"></td>
								</tr>
								<tr>
									<td><span class="basetext">Available:</span></td>
									<td><input type="checkbox" name="cbAvailable" value="True" <?php if ($available=="Yes"){echo "CHECKED";};?> >									  <span class="basetext"> Checked means that the stamp is available.</span></td>
								</tr>
								<tr>
									<td valign="top"><span class="basetext">Reproducible:</span></td>
								  <td><span class="basetext"><input name="cbReproducible" type="radio" value="True" <?php if ($reproducible=="Yes"){echo "CHECKED";};?>>Yes<br/> <input name="cbReproducible" type="radio" value="False"  <?php if ($reproducible=="No"){echo "CHECKED";};?>>No<BR/>  <input name="cbReproducible" type="radio" value="Only" <?php if ($reproducible=="Only"){echo "CHECKED";};?>>Only Available as Reproduction</span>	</td>								  
									
								</tr>
								<tr>
								  <td><span class="basetext">Surcharge:</span></td>
								  <td><input type="checkbox" name="cbSurcharge" value="True"  onchange="return changeSurcharge();" <?php echo $surcharge; ?>>
							      <span class="basetext">Checked means that there is a surcharge for this stamp.</span></td>
							  </tr>
								<tr>
									<td>&nbsp;</td>
									<td><table width="300" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="100" class="basetextSurcharge">Per 1</td>
                                        <td width="200"><input type="text" name="txtPer1" value="<?php echo $per1;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 12 </td>
                                        <td><input type="text" name="txtPer12" value="<?php echo $per12;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 50 </td>
                                        <td><input type="text" name="txtPer50" value="<?php echo $per50;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 100 </td>
                                        <td><input type="text" name="txtPer100" value="<?php echo $per100;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 250 </td>
                                        <td><input type="text" name="txtPer250" value="<?php echo $per250;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 500 </td>
                                        <td><input type="text" name="txtPer500" value="<?php echo $per500;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 1000 </td>
                                        <td><input type="text" name="txtPer1000" value="<?php echo $per1000;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 2500 </td>
                                        <td><input type="text" name="txtPer2500" value="<?php echo $per2500;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 5000 </td>
                                        <td><input type="text" name="txtPer5000" value="<?php echo $per5000;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                      <tr>
                                        <td class="basetextSurcharge">Per 7500 </td>
                                        <td><input type="text" name="txtPer7500" value="<?php echo $per7500;?>" onChange="checkSurcharge(this);"></td>
                                      </tr>
                                    </table></td>
								</tr>
								<tr>
									<td><input type="hidden" name="hdnEntryDate" value="<?php echo $entrydate; ?>"></td>
									<td>
										<div align="right">
											<input type="submit" name="sbSubmit" value="Next --&gt;"><input type="reset" name="sbReset" value="Clear Form"></div>
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
