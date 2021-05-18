<?php

require('connection.inc.php');
require('functions.inc.php');
require('frontend_addtocart.php');

$str=get_safe_value($con,$_GET['str']);


if($str!='')
{
	
$get_product=get_product($con,'','','',$str);
}
else{
	?>
	<script>
	
	
	window.location.href='front_end.php';
	
	
	
	</script>
<?php 

}
?>
<?php
$cat_arr=array();

$cat_res=mysqli_query($con,"select * from categories where status=1 order by id asc");
while($row=mysqli_fetch_assoc($cat_res))
{
  $cat_arr[]=$row;
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

body
{
  background-color: #d3d3d3;
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


.selection_option
{
padding:3px;
}



.selection_option select,option
{
 border:1px solid grey;
 border-radius: 8px;
 font-size:15px;
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

/* overlay search box   */

.overlay {
  height: 20%;
  width: 100%;
  display: none;
  position: fixed;
  z-index: 2;
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
  <span><b>Grocery Store</b></span>
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
  
  
  
  
  
  
  
  
  &nbsp;&nbsp;
  &nbsp;
  <a href="frontend_cart.php" class="shopping_cart_icon"  style="text-decoration:none;"><span style="cursor:pointer; font-size:30px; "><i class="fa fa-shopping-cart"></i><?php echo $totalproduct; ?></span></a>

</div>

<?php  
if(count($get_product)>0)
{
	?>


<div class="latest_products" style="overflow:auto;">


    <div class="latest_product_header"  style="">
      <ul class="breadcrumb">
  <li><a href="front_end.php">Home</a></li>
  <li>Search</li>
  <li><?php echo $str   ?></li>


</ul>
    </div>















    <div class="latest_images" style="">
    <?php
        foreach($get_product as $list)
        {

    ?>
      
      <div class="latest_image_one_element_div">


          <div class="latest_image_image_portion">
             
                   <a href="frontend_product.php?id=<?php echo $list['id']; ?>">
                        <img  src="product/<?php echo $list['image']  ?>" alt="image not found">
                   </a>
          </div>

                   
          <div class="latest_image_content_portion">
             
            <p style=" text-transform: uppercase;"><a href="" style="text-decoration: none;"><?php echo $list['name']; ?></a></p>
            <ul style="list-style-type: none; text-align:center;">
              <li>  MRP.&nbsp;<?php echo $list['mrp']; ?></li>
              <li> Price &nbsp;<?php echo $list['price']; ?></li>

            </ul>
          </div>


      </div>
  
<?php
}
?>

    </div>




















</div>

<?php
}
else 
{
	echo "DATA NOT FOUND";
}

?>

























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
