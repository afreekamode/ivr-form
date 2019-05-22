<?php
 // DROP TABLE IF EXISTS `controlform`; CREATE TABLE `controlform` ( `emp_id` int(11) NOT NULL, `fname` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL, `lname` varchar(225) NOT NULL, `dept` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL, `locat` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL, `recv` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL, `recv_date` varchar(30) NOT NULL, `priority` varchar(30) NOT NULL, `phone` text NOT NULL, `descp` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL, `unique4` varchar(30) NOT NULL, `status` int(1) NOT NULL DEFAULT '0', `submit_date` datetime NOT NULL, `ass` varchar(10) NOT NULL DEFAULT 'unassigned' ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

$servername = "localhost";
$username =  "root";
$password = "";
$DBname = "control";

// create connection
$conn = mysqli_connect($servername, $username, $password, $DBname);
//check connection
if (!$conn) {
	die("connection failed: " . mysqli_connect_error());
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

// $extime = '';
// $active = time('H:m:s');
// while ($extime = 5940000){
// if ($active > $extime) {
// $time = "Note! its already $active it may be tommorow before we get to you. Thank you."; 
// }
// else{
// $time1 = " Thank you.";  
// }
// }
$code = rand(99,99999);
$uniqcode = "IVR$code";

// define variable and set to empty values to avoid error before users input any information
$fnameErr = $lnameErr = $deptErr = $recv_dateErr = $phoneErr = $phone1Err = "";
$fname= $lname = $dept = $recv_date = $phone = $phone1 = "";

//capturing users input
if (isset($_POST["submit"])) {
	$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
	$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
	$dept = mysqli_real_escape_string($conn, $_POST["dept"]);
	$recv = mysqli_real_escape_string($conn, $_POST["recv"]);
	$recv_date = mysqli_real_escape_string($conn, $_POST["recv_date"]);
	$priority = mysqli_real_escape_string($conn, $_POST["priority"]);
	$phone =$_POST["phone"];
	$phone1 =$_POST["phone1"];
	$comment = mysqli_real_escape_string($conn, $_POST["descp"]);	

//form validation without file\
if (!empty($fname)) {
	$fname = test_input($_POST["fname"]);
}else {
	$fnameErr = "required";
}

if (!empty($lname)) {
	$lname = test_input($_POST["lname"]);
}else {
	$lnameErr = "required";
} 

if (!empty($phone)) {
	$phone = test_input($_POST["phone"]);
}else{
	$phoneErr = "required";
}

if (!empty($recv)) {
	$recv = test_input($_POST["recv"]);
}else{
	$recvErr = "required";
}

if (!empty($recv_date)) {
	$recv_date = test_input($_POST["recv_date"]);
}else{
	$recv_dateErr = "**";
}

if (!empty($dept)) {
	$dept= test_input($_POST["dept"]);
}else{
	$deptErr = "required";
}
}
if (!empty($fname && $lname && $dept && $recv && $phone && $priority)) {

$locat = "Apapa";
//conditional to stop resubmit if already assigned
$sql ="SELECT * FROM controlform where unique4 = true";
$result_new=mysqli_query($conn, $sql);

  if (mysqli_num_rows($result_new)>0){

    //to loggedout for logged in users we run our codes inside this logged in area
    $unique = "";
    while($rows_check = mysqli_fetch_assoc($result_new)) {

      //get the user name frm the login details
      $unique = $rows_check['unique4'];

      if ($unique == "$referenceCode") {
  header('location: icform2.php');
  # code...
  die();
  }

    }
}


	//insert the information into the databse
$sql = "INSERT INTO controlform (fname, lname, dept, locat, recv, recv_date, priority, phone, descp, unique4, submit_date) VALUES('$fname' , '$lname' , '$dept', '$locat', '$recv', '$recv_date','$priority', '$phone,$phone1', '$comment', '$uniqcode', now())";
	//if the query is successful give the user the following messages using javascript alert function and take them to their portal
if (mysqli_query($conn, $sql)) {

		echo "<script> alert ('Request Submited successfully !!!'); </script>";
		echo "<div style='position:absolute;top:200px;left:550px;width:500px;height:500px;background:#fff;padding:50px;'><center style='padding-bottom:30px;font-size: 20px;'> Your Req. code is: $uniqcode <br><p>An Internal Control personnel will be there shortly <br><a href='icform2.php'>Continue</a></p></center><br></div>";
		die(); 
	}else{
		echo "<script> alert ('Form Not Submited !!!'); </script>" . $sql . "<br>" . mysqli_error($conn);
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>IVR Form</title>
<meta name="generator" content="WYSIWYG Web Builder 11 - http://www.wysiwygwebbuilder.com">
<link rel="icon"  type="image/x-icon" href="favicon.ico">
<link href="policies_intranet_2.css" rel="stylesheet">
<link href="icform_landing_page.css" rel="stylesheet">
<script src="jquery-1.11.3.min.js"></script>
</head>
<style type="text/css">
.error{
	color:#ff0000;
	padding-bottom: 10px;
	font-style: bold;
 }
</style>
<script>
  var name = $("input#name").val();
  var email = $("input#locat").val();
  var phone = $("input#dept").val();
  var phone = $("input#recv").val();
  var phone = $("input#recv_date").val();
  var phone = $("input#priority").val();
  var phone = $("input#phone").val();
  var phone = $("input#descp").val();

  var dataString = 'name='+ name + '&locat=' + locat + '&dept=' + dept + '&recv=' + recv + '&recv_date=' + recv_date + '&priority=' + priority + '&phone=' + phone + '&descp=' + descp;
// Then we used jQuery's ajax function to process the values in the dataString. After that
// process finishes successfully, we display a message back to the user and add return false so that our page does not refresh:

    $.ajax({
      type: "POST",
      url: "icform2.php",
      data: dataString,
      success: function() {
        $('#icform2').html("<div id='message'></div>");
        $('#message').html("<h2>Form Submitted!</h2>")
        .append("<p>We will be in touch soon.</p>")
        .hide()
        .fadeIn(1500, function() {
          $('#message').append("<img id='checkmark' src='images/img0005.png' />");
        });
      }
    });
    return false;

</script>
<body>
<div class="container" style="width:auto;height:1000px;">
<div id="Layer4" style="position:absolute;text-align:center;left:1108px;top:136px;width:384px;height:144px;z-index:34;">
<div id="Layer4_Container" style="width:384px;height:144px;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
<div id="wb_Image1" style="position:absolute;left:275px;top:31px;width:96px;height:98px;z-index:0;">
<img src="images/sales.png" id="Image1" alt=""></div>
<div id="wb_Text1" style="position:absolute;left:11px;top:21px;width:161px;height:72px;z-index:1;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:21px;"><em>Performance Management System</em></span></div>
<div id="wb_Text4" style="position:absolute;left:14px;top:110px;width:106px;height:16px;z-index:2;text-align:left;">
<span style="color:#FFFF00;font-family:Arial;font-size:13px;"><strong><em><a href="" target="_blank">Log on to PMS</a></em></strong></span></div>
</div>
</div>
<div id="Layer2" style="position:absolute;text-align:center;left:0px;top:66px;width:99.5876%;height:28px;z-index:35;">
<div id="Layer2_Container" style="width:966px;height:28px;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
</div>
</div>
<div id="Layer1" style="position:absolute;text-align:center;left:0px;top:0px;width:99.5876%;height:64px;z-index:36;">
<div id="Layer1_Container" style="width:966px;height:64px;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
<span style="position:absolute;left:0px;top:62px;width:80px;height:35px;z-index:38;"><img src="images/wistleblowing.png" id="Image16" alt=""></span><marquee direction="left" scrolldelay="150" scrollamount="6" behavior="scroll" loop="0" style="position:absolute;left:7px;top:75px;height:141px;z-index:5;" id="Marquee1" onmouseover="this.stop()" onmouseout="this.start()"><span style="color:#000000;font-family:Arial;font-size:13px;"></span><strong>Whistle Blowing Hotline:| When you see something say something...</strong></marquee>
</div>
</div>
<div id="Layer3" style="position:absolute;text-align:left;left:302px;top:108px;width:787px;height:980px;z-index:37;">
<div id="wb_Text7" style="position:absolute;left:18px;top:35px;width:148px;height:20px;z-index:9;text-align:left;">
  <label style="position:absolute;left:558px;top:15px;width:250px;border-radius: 25px;height:38px;line-height:38px;color: #111;">Want to know your request status?</label>
  <button class="btn btn-primary" type="button" style="position:absolute;left:608px;top:45px;width:100px;border-radius: 15px;font-size: 15px;padding:5px;"><a href="/ivr-dashboard/followup.php" style="text-decoration:none;">Followup</a></button>
<span style="color:#000000;font-family:Verdana;font-size:17px;"><strong><em>Welcome to,</em></strong></span></div>
<div id="wb_Text8" style="position:absolute;left:59px;top:56px;width:390px;height:37px;z-index:10;text-align:left;">
<span style="color:#2E8B57;font-family:Arial;font-size:32px;"><strong>INTERNAL CONTROL</strong></span><br>
<span style="color:#2E8B57;font-family:Arial;font-size:22px;"><strong>Item Verification Request</strong></span></div>
<hr id="Line1" style="position:absolute;left:19px;top:135px;width:755px;height:9px;z-index:11;">
<div id="wb_Image4" style="position:absolute;left:14px;top:58px;width:40px;height:34px;z-index:12;">
<img src="images/marketing_ico_.png" id="Image4" alt=""></div>
<div id="wb_Form1" style="position:absolute;left:77px;top:180px;width:632px;height:754px;z-index:13;">

<form method="post" action="">

<label for="" class="Label1" style="position:absolute;left:46px;top:169px;width:109px;height:38px;line-height:38px;z-index:3;">*Department:</label>

<label for="" class="Label1" style="position:absolute;left:46px;top:269px;width:109px;height:38px;line-height:38px;z-index:48;">*Receiving Point:</label>
<label for="" class="Label1" style="position:absolute;left:46px;top:319px;width:109px;height:38px;line-height:38px;z-index:48;">*Delivery Date:</label>
<label for="" class="Label1" style="position:absolute;left:46px;top:399px;width:109px;height:38px;line-height:38px;z-index:49;border-radius: 4px;">*Phone:</label>
<label for="" class="Label1" style="position:absolute;left:46px;top:439px;width:109px;height:38px;line-height:38px;z-index:49;border-radius: 4px;">Ext:</label>
<textarea rows="10" cols="50" name="descp" value="description" placeholder="Please give item(s) details. Example: 2 pcs of office chairs." class="Label1" style="position:absolute;left:176px;top:519px;z-index:47;border-radius: 4px;" required></textarea><br><span style="font-size: 11px;position:absolute;left:466px;top:630px;z-index:3;">Max: 150 words</span>
<input type="text" name="fname" value="" id="fname" style="position:absolute;left:163px;top:58px;width:389px;height:25px;line-height:25px;z-index:4;border-radius: 4px;" required="name">
<input type="text" name="lname" value="" id="lname" style="position:absolute;left:163px;top:116px;width:389px;height:25px;line-height:25px;z-index:4;border-radius: 4px;" required="name">
<select type="text" name="dept" value="" id="dept" style="position:absolute;left:163px;top:171px;width:389px;height:25px;line-height:25px;z-index:41;border-radius: 4px;" required>
	<option></option>
<option value="General Management">General Management</option>
<option value="Financial Accounting">Financial Accounting</option>
<option value="Finance General Management">Finance General Management</option>
<option value="R&D">R&D</option>
<option value="Sales Corporate">Sales Corporate</option>
<option value="Advertising and Promotion">Advertising and Promotion</option>
<option value="Production Fertilizer">Production Fertilizer</option>
<option value="Logistics">Logistics</option>
<option value="Primary Distribution">Primary Distribution</option>
<option value="Warehouse & Dispatch Finished Goods">Warehouse & Dispatch Finished Goods</option>
<option value="Technical Electrical Engineering">Technical Electrical Engineering </option>
<option value="Technical Mechanical Engineering">Technical Mechanical Engineering</option> 
<option value="B2C Management">B2C Management</option>
<option value="CSC Management">CSC Management</option> 
<option value="CSCs">CSCs </option>
<option value="Financial Expenses/Income & FX loss/gain">Financial Expenses/Income & FX loss/gain</option>
<option value="Corporate Manufacturing Excellence">Corporate Manufacturing Excellence</option>
<option value="Corporate Communication">Corporate Communication</option>
<option value="Canteen">Canteen</option>
<option value="CSR">CSR</option>
<option value="General Management">General Management</option>
<option value="Business Assurance">Business Assurance</option>
<option value="Internal Control">Internal Control</option>
<option value="Immigration">Immigration</option>
<option value="Legal">Legal</option>
<option value="Housing Management">Housing Management</option>
<option value="Security">Security</option>
<option value="Transport">Transport</option>
<option value="Financial Accounting">Financial Accounting</option>
<option value="Business Decision Support">Business Decision Support</option>
<option value="Finance General Management">Finance General Management</option>
<option value="Treasury">Treasury</option>
<option value="Tax">Tax</option>
<option value="Business Partnering">Business Partnering</option>
<option value="Clinic ">Clinic </option>
<option value="HR">HR</option>
<option value="HR General Management">HR General Management</option>
<option value="Talent Acquisition">Talent Acquisition</option>
<option value="Talent Development">Talent Development</option>
<option value="Data Centre Management">Data Centre Management</option>
<option value="Business Process & Analysis">Business Process & Analysis</option>
<option value="Database Management">Database Management</option>
<option value="IT Management">IT Management</option>
<option value="Network & Communication">Network & Communication</option>
<option value="Corporate Marketing">Corporate Marketing </option>
<option value="MM General Management">MM General Management</option>
<option value="Inventory Management">Inventory Management</option> 
<option value="Purchasing">Purchasing</option> 
<option value="Service and Contracts Management">Service and Contracts Management</option>
<option value="Stores">Stores</option>
<option value="Health & Safety">Health & Safety</option> 
<option value="Corporate Export Department">Corporate Export Department</option>
<option value="Sales and Operations">Sales and Operations</option>
<option value="Producition Stores & Purchasing">Producition Stores & Purchasing</option>
<option value="Production Projects">Production Projects</option>
<option value="Production Quality Assurance">Production Quality Assurance</option>
<option value="Production Quality Assurance">Production Quality Assurance</option>
<option value="Production Order Processing">Production Order Processing</option>
<option value="Production Mechanical Maintenance">Production Mechanical Maintenance</option>
<option value="Production Specialised Workshop">Production Specialised Workshop</option>
<option value="Production Fork Lifts">Production Fork Lifts</option>
<option value="Production Automation and Maintenance">Production Automation and Maintenance</option>
<option value="Production Electrical Maintenance">Production Electrical Maintenance</option>
<option value="Production West Mill">Production West Mill</option>
<option value="MIS">MIS</option>
<option value="IT">IT</option>
<option value="Production East Mills">Production East Mills</option>
<option value="Production Quality Control">Production Quality Control</option>
<option value="Production Projects">Production Projects</option>
<option value="Conveying Systems & Headhouse">Conveying Systems & Headhouse</option>
<option value="Packing Household Maintenance">Packing Household Maintenance</option>
<option value="Finance General Management">Finance General Management</option>
<option value="Manufacturing Finance">Manufacturing Finance</option>
<option value="Production General Management">Production General Management</option>
<option value="Production Service Contracts">Production Service Contracts</option>
<option value="Production Weigh Bridges">Production Weigh Bridges</option>
<option value="Business Partnering">Business Partnering</option>
<option value="Health & Safety">Health & Safety </option>
<option value="other">Others</option>
<input type="text" type="text" name="locat" value="Apapa" id="locat" style="position:absolute;left:163px;top:227px;width:389px;height:25px;line-height:25px;z-index:42;border-radius: 4px;" disabled>
<input type="text" name="recv" value="" id="recv" style="position:absolute;left:163px;top:274px;width:389px;height:25px;line-height:25px;z-index:43;border-radius: 4px;"  required>
<input type="date" name="recv_date"  value="" id="recv_date" style="position:absolute;left:163px;top:324px;width:389px;height:25px;line-height:25px;z-index:43;border-radius: 4px;"  required>
<input type="radio" name="priority" value="low" id= "priority" style="position:absolute;left:163px;top:368px;"><span style="position:absolute;left:183px;top:370px;">Low</span>
<input type="radio" name="priority" value="high" id= "priority" style="position:absolute;left:263px;top:368px;"><span style="position:absolute;left:283px;top:370px;">High</span>
<input type="radio" name="priority" value="critical" id= "priority" style="position:absolute;left:363px;top:368px;"><span style="position:absolute;left:383px;top:370px;">Critical</span>
<input type="tel" pattern="^\d{3}\d{4}\d{4}$" max ="12" title="Format: 080123456789 (Eleven digits code)" placeholder=" 080123456789" name="phone" value="" id="phone" style="position:absolute;left:163px;top:394px;width:389px;height:25px;line-height:25px;z-index:5;" required>
<input type="tel" pattern="^\d{2}\d{3}$" max ="12" title="Format: 33111 (Five digits code)" placeholder=" 33111" name="phone1" value="" id="phone" style="position:absolute;left:163px;top:450px;width:389px;height:25px;line-height:25px;z-index:5;">
<input type="hidden" name="submit_date" id="submit_date" value= "now()"  required>
<input type="submit" id="submit" name="submit" value="Submit" style="position:absolute;left:466px;top:710px;width:96px;height:25px;z-index:6;border-radius: 4px;" required>
<div id="wb_Text9" style="position:absolute;left:46px;top:22px;width:504px;height:16px;z-index:7;text-align:left;">
<span style="color:#2E8B57;font-family:Verdana;font-size:13px;"><strong>Please complete the form below, areas in * are required.</strong></span></div>
<label for="" class="Label2" style="position:absolute;left:46px;top:537px;width:109px;height:38px;line-height:38px;z-index:44;">*Item Description:</label>
<label for="" class="Label2" style="position:absolute;left:46px;top:217px;width:109px;height:38px;line-height:38px;z-index:45;">*Location:</label>
<label for="" class="Label2" style="position:absolute;left:46px;top:357px;width:109px;height:38px;line-height:38px;z-index:46;">Priority</label>
<label for="" class="Label2" style="position:absolute;left:46px;top:57px;width:109px;height:38px;line-height:38px;z-index:;">*First Name:</label>
<label for="" class="Label2" style="position:absolute;left:46px;top:107px;width:109px;height:38px;line-height:38px;z-index:;">*Last Name:</label>
</form>
</select>
  <input type="text" id="otherType" name="dept" value="" style="position:absolute;left:163px;top:171px;width:389px;height:25px;line-height:25px;z-index:41;border-radius: 4px; display: none;" name="specify" placeholder="Specify Department" required>
<script type="text/javascript">
	$('#dept').on('change',function(){
     var selection = $(this).val();
    switch(selection){
    case "other":
    $("#otherType").show()
   break;
    default:
    $("#otherType").hide()
    }
});
</script>
</div>
</div>
<div id="wb_Image16" style="position:absolute;left:73px;top:5px;width:103px;height:81px;z-index:38;">
<img src="images/FMN_Logo.png" id="Image16" alt=""></div>
<div id="Layer5" style="position:absolute;text-align:center;left:1108px;top:286px;width:384px;height:144px;z-index:39;">
<div id="Layer5_Container" style="width:384px;height:144px;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
<div id="wb_Image2" style="position:absolute;left:285px;top:34px;width:89px;height:94px;z-index:14;">
<img src="images/vms.png" id="Image2" alt=""></div>
<div id="wb_Text2" style="position:absolute;left:15px;top:16px;width:161px;height:72px;z-index:15;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:21px;"><em>Vacation<br>Management System</em></span></div>
<div id="wb_Text5" style="position:absolute;left:18px;top:103px;width:106px;height:16px;z-index:16;text-align:left;">
<span style="color:#FFFF00;font-family:Arial;font-size:13px;"><strong><em><a href="" target="_blank">Log on to VMS</a></em></strong></span></div>
</div>
</div>
<div id="Layer6" style="position:absolute;text-align:center;left:1108px;top:437px;width:384px;height:144px;z-index:40;">
<div id="Layer6_Container" style="width:384px;height:144px;position:relative;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;text-align:left;">
<div id="wb_Image3" style="position:absolute;left:278px;top:21px;width:100px;height:100px;z-index:17;">
<img src="images/ithelpdesk.png" id="Image3" alt=""></div>
<div id="wb_Text3" style="position:absolute;left:15px;top:19px;width:161px;height:48px;z-index:18;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:21px;"><em>Service Desk Support</em></span></div>
<div id="wb_Text6" style="position:absolute;left:14px;top:90px;width:106px;height:32px;z-index:19;text-align:left;">
    <span style="color:#FFFF00;font-family:Arial;font-size:13px;"><strong><em><a href="" target="_blank">Log on to IT Helpdesk </a></em></strong></span></div>
</div>
</div>
<div id="Layer7" style="position:absolute;text-align:left;left:31px;top:108px;width:259px;height:527px;z-index:41;">
<hr id="Line2" style="position:absolute;left:9px;top:62px;width:243px;height:8px;z-index:20;">
<div id="wb_Text11" style="position:absolute;left:31px;top:91px;width:191px;height:20px;z-index:21;text-align:left;">
<span style="color:#FFFFFF;font-family:Verdana;font-size:17px;"><strong>P -&nbsp; Performance</strong></span></div>
<div id="wb_Text12" style="position:absolute;left:31px;top:129px;width:191px;height:20px;z-index:22;text-align:left;">
<span style="color:#FFFFFF;font-family:Verdana;font-size:17px;"><strong>I -&nbsp; Integrity</strong></span></div>
<div id="wb_Text13" style="position:absolute;left:31px;top:167px;width:191px;height:20px;z-index:23;text-align:left;">
<span style="color:#FFFFFF;font-family:Verdana;font-size:17px;"><strong>I -&nbsp; Initiative</strong></span></div>
<div id="wb_Text14" style="position:absolute;left:31px;top:207px;width:191px;height:20px;z-index:24;text-align:left;">
<span style="color:#FFFFFF;font-family:Verdana;font-size:17px;"><strong>L -&nbsp; Leadership</strong></span></div>
<div id="wb_Text15" style="position:absolute;left:30px;top:244px;width:191px;height:20px;z-index:25;text-align:left;">
<span style="color:#FFFFFF;font-family:Verdana;font-size:17px;"><strong>O -&nbsp; Ownership</strong></span></div>
<div id="wb_Text16" style="position:absolute;left:31px;top:285px;width:191px;height:20px;z-index:26;text-align:left;">
<span style="color:#FFFFFF;font-family:Verdana;font-size:17px;"><strong>T -&nbsp; Teamwork</strong></span></div>
<div id="wb_Text10" style="position:absolute;left:9px;top:21px;width:238px;height:34px;z-index:27;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:29px;"><strong>Our Core Values</strong></span></div>
</div>
<div class="PageFooter1" style="position:absolute;overflow:hidden;text-align:left;left:0px;top:1110px;width:100%;height:42px;z-index:26;">
<div id="wb_Text17" style="position:absolute;left:234px;top:14px;width:683px;height:16px;z-index:11;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">&copy; <?php echo date('Y'); ?>Developed by Sikiru <a href="https://github.com/afreekamode/ivr-form">Shittu</a>.</span></div>
</div>
</div>
</body>
</html>
<?php 
mysqli_close($conn);
?>