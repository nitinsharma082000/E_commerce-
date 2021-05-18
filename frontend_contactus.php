<?php

require('connection.inc.php');
require('functions.inc.php');
require('frontend_addtocart.php');

$cat_arr=array();

$cat_res=mysqli_query($con,"select * from categories where status=1 order by id asc");
while($row=mysqli_fetch_assoc($cat_res))
{
  $cat_arr[]=$row;
}


$name="";
$email="";
$mobile="";
$message="";
$error="";
if(isset($_POST['submit']))
{
	
	$name=$_POST['name'];
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];
	$message=$_POST['message'];
	$added_on="";
	
	if($name=="")
	{
	  $error="please enter your name";
	  
	}
	elseif($email=="")
	{
		$error="please enter your email";
	}
	
	elseif($mobile=="")
	{
		$error="please enter your mobile_no.";
	}
	
	elseif($message=="")
	{
		$error="please enter your query or message";
	}
	
	else{
		
		
		$name=get_safe_value($con,$name);
	    $email=get_safe_value($con,$email);
		$mobile=get_safe_value($con,$mobile);
		$message=get_safe_value($con,$message);
	    $added_on=date('y-m-d h:i:s');
		mysqli_query($con,"insert into contact_us(name,email,mobile,comment,added_on)  values('$name','$email','$mobile','$message','$added_on')");
	}
	
	
	
	
}
	
	
	$obj=new add_to_cart();
$totalproduct= $obj->total_product();
	
	
	
	
?>
<!DOCTYPE html>
<html>
<head>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
* {
  box-sizing: border-box;
  font-size:25px;
}
html {
  font-family: "Lucida Sans", sans-serif;
}



/* icon css */
.header .menu_icon
{
  margin-left:10%;
}
.header .menu_icon:hover
{
  color:black;
}
.header .user_icon
{
  position:absolute;
  right:10em;
  padding-left:4px;
   border-left:1px solid white;
  color:white;
}
.header .shopping_cart_icon
{
  position:absolute;
  right:2em;
  padding-left:4px;
   border-left:1px solid white;
  color:white;
}

.header .myorder_icon
{
  position:absolute;
  right:6em;
  padding-left:4px;
   border-left:1px solid white;
  
  color:white;
}


.header .search_icon:hover
{
  color:black;
}
.header .search_icon
{
  position:absolute;
  right:12em;
  color:white;
  
}





.header {
  background-color:#000080;
  color: #ffffff;
  position:fixed;
  width:100%;
  z-index:1;
  position:sticky;
  top:0;
  padding: 15px;
  font-size:2vw;
}

/*
css for side menu navigation
*/
.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}
.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 3;
  top: 0;
  left: 0;
   background-color:  #20B2AA;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: white;
  display: block;
  transition: 0.3s;
  margin-top:4%;
}

.sidenav a:hover {
  color: black;
}


.latest_image_one_element_div
{
  float:left;
  width:25%;
  height:auto;
   padding:10px;
 

  overflow:hidden;

}





@media only screen and (max-width: 1000px)

{
  .latest_image_one_element_div
  {
     float:left;
  width:33.33%;

  height:auto;
     padding:15px;
 
  overflow:hidden;

  }
}
@media only screen and (max-width: 500px)

{
  .latest_image_one_element_div
  {
     float:left;
     width:100%;
     height:auto;
     padding:15px;
     overflow:hidden;

  }
}

img
{
  max-width:100%;
  height:auto;
  border: 1px solid #ddd;
  border-radius: 6px;
}

.latest_image_content_portion
{
  text-align:center;
  
  text-align:center;
}

.latest_image_content_portion ul
{
  margin-top:0px;
 text-align:center;
}





/*breadcum  */



ul.breadcrumb {
	margin:0;
	text-align:center;
  padding: 20px 26px;
  list-style: none;
  background-color: #ddd;
}

/* Display list items side by side */
ul.breadcrumb li {
  display: inline;
  font-size: 18px;
}

/* Add a slash symbol (/) before/behind each list item */
ul.breadcrumb li+li:before {
  padding: 8px;
  color: black;
  content: "/\00a0";
}

/* Add a color to all links inside the list */
ul.breadcrumb li a {
  color: #0275d8;
  text-decoration: none;
}

/* Add a color on mouse-over */
ul.breadcrumb li a:hover {
  color: #01447e;
  text-decoration: underline;
}


/*  breadcum   end */


.latest_product_header
{
	margin:10;
	padding:0;
	width:100%;
	height:25%;
	background-color:#ddd;
}





/* CONTACT US FORM CSS CODE   */
*{
  margin: 0;
  padding: 0;
  font-family: "montserrat",sans-serif;
}
.contact-section{
  background: url(bg.png) no-repeat center;
  background-size: cover;
  padding: 40px 0;
}
.contact-section h1{
  text-align: center;
  color: #ddd;
}
.border{
  width: 100px;
  height: 10px;
  background: #34495e;
  margin: 40px auto;
}

.contact-form{
  max-width: 600px;
  margin: auto;
  padding: 0 10px;
  overflow: hidden;
}

.contact-form-text{
  display: block;
  width: 100%;
  box-sizing: border-box;
  margin: 16px 0;
  border: 0;
  background: #111;
  padding: 20px 40px;
  outline: none;
  color: #ddd;
  transition: 0.5s;
}
.contact-form-text:focus{
  box-shadow: 0 0 10px 4px #34495e;
}
textarea.contact-form-text{
  resize: none;
  height: 120px;
}
.contact-form-btn{
  float: right;
  border: 0;
  background: #34495e;
  color: #fff;
  padding: 12px 50px;
  border-radius: 20px;
  cursor: pointer;
  transition: 0.5s;
}
.contact-form-btn:hover{
  background: #2980b9;
}


/* end of contact us forn css   */



/* overlay search box   */

.overlay {
  height: 20%;
  width: 100%;
  display: none;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0, 0.9);
}

.overlay-content {
  position: relative;
  top: 30%;
  width: 80%;
  text-align: center;
  margin-top: 10px;
  margin: auto;
}

.overlay .closebtn {
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 30px;
  cursor: pointer;
  color: white;
}

.overlay .closebtn:hover {
  color: #ccc;
}

.overlay input[type=text] {
  padding: 15px;
  font-size: 17px;
  border: none;
  float: left;
  width: 80%;
  background: white;
}

.overlay input[type=text]:hover {
  background: #f1f1f1;
}

.overlay button {
  float: left;
  width: 20%;
  padding: 15px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.overlay button:hover {
  background: #bbb;
}


</style>
</head>
<body>


<div id="myOverlay" class="overlay">
  <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
  <div class="overlay-content">
    <form action="frontend_search.php"  method="get">
      <input type="text" placeholder="Search.." name="str">
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
  </div>
</div>






  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="front_end.php">HOME</a>
  <?php
  foreach($cat_arr as $list)
  {
  ?>

  <a href="frontend_categories.php?id=<?php  echo $list['id'];  ?>"><?php echo $list['categories']; ?> </a>

  <?php
  }
  ?>
  <a href="frontend_contactus.php">CONTACT US</a>
  </div>



<div class="header">
  <span><b>E-COMMERCE</b></span>
  <span style="font-size:30px;cursor:pointer; " class="menu_icon" onclick="openNav()">&#9776;</span>
  <span style="font-size:30px;cursor:pointer; " class="search_icon"    onclick="openSearch()"><i class='fas fa-search' style='font-size:24px'></i></span>
   
   
   
    <?php
  if(isset($_SESSION['user_login']))
  {
	  
	 echo " <a href='frontend_logout.php'  class='user_icon' style='text-decoration:none;'><span style='cursor:pointer;  margin-right:10px;'><i  style='font-size:20px'>LOGOUT</i></span></a>";
    echo " <a href='frontend_myorder.php'  class='myorder_icon' style='text-decoration:none;'><span style='cursor:pointer; '><i  style='font-size:20px'>My Order</i></span></a>";
	  
  }
  else
  {
  echo "<a href='frontend_login.php'  class='user_icon' style='text-decoration:none;'><span style='cursor:pointer;  margin-right:10px;'><i  style='font-size:20px'>LOGIN</i></span></a>";
  }
  ?>
   
   
   
   
   
   
   
   
   
   
   
   
   &nbsp;&nbsp;&nbsp;
  <a href="frontend_cart.php" class="shopping_cart_icon"  style="text-decoration:none;"><span style="cursor:pointer; font-size:30px"><i class="fa fa-shopping-cart"></i><?php echo $totalproduct; ?></span></a>

</div>



<div class="latest_products" style="overflow:auto;">


    <div class="latest_product_header"  style="">
      <ul class="breadcrumb">
  <li><a href="front_end.php">Home</a></li>
  <li>CONTACT US</li>


</ul>
    </div>

   




<div class="contact-section">

  <h1>Contact Us</h1>
  <div class="border"></div>
  <form class="contact-form" action="" method="post">
    <input type="text" class="contact-form-text"  id="name" name="name" placeholder="Your name">
    <input type="email" class="contact-form-text" id="email"  name="email"  placeholder="Your email">
    <input type="text" class="contact-form-text"  id="mobile"  name="mobile"   placeholder="1234567890" pattern="[0-9]{10}" >
    <textarea class="contact-form-text"  id="message"  name="message"  placeholder="Your message"></textarea>
    <input type="submit" name="submit" class="contact-form-btn" value="Send">
	
	<?php if($error!="" && isset($_POST['submit']))
	{
		?>
	<p style="color:white;"><?php echo $error  ?></p>
	
	<?php
	}
	else
	{
		?>
		<script>
		alert("THANK YOU FOR CONTACTING US");
		</script>
	<?php
	}
	?>
  </form>
</div>




















<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  
</footer>



<script>
   var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
function openNav() {
  if(width>768)
  {
  document.getElementById("mySidenav").style.width = "25%";
}
else
{
  document.getElementById("mySidenav").style.width = "100%";
}
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0%";
}



function openSearch() {
  document.getElementById("myOverlay").style.display = "block";
}

function closeSearch() {
  document.getElementById("myOverlay").style.display = "none";
}






</script>

</body>
</html>
