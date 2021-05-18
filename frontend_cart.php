<?php

require('connection.inc.php');
require('functions.inc.php');
require('frontend_addtocart.php');




if(!isset($_SESSION['cart'])|| count($_SESSION['cart'])==0)
{
	?>
	<script>
	window.location.href='front_end.php';
	</script>
	<?php
	
}


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
body
{
  background-color: #d3d3d3;
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



/* add to cart button css  */

.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  display:inline-block;
  padding: 25px 38px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}






table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align:center;
}
th,td{
	padding:12px;
}


 td:nth-child(even) {
  background-color: #87CEEB;
}
td:nth-child(odd) {
  background-color: #4682B4;
}




.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
 
  padding: 15px 55px;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #4CAF50;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}

.button2 {
  background-color: white; 
  color: black; 
  border: 2px solid #008CBA;
}

.button2:hover {
  background-color: #008CBA;
  color: white;
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


/*button css  */
#remove_button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  background-color: white; 
  color: black; 
  border: 2px solid #f44336;
}

#remove_button:hover {
  background-color: #f44336;
  color: white;
}



#update_button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  background-color: white; 
  color: black; 
  border: 2px solid #32CD32;
}

#update_button:hover {
  background-color: #32CD32;
  color: white;
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
  















&nbsp;&nbsp;&nbsp;
  <a href="frontend_cart.php" class="shopping_cart_icon"    style="text-decoration:none;"><span style="cursor:pointer; font-size:30px"><i class="fa fa-shopping-cart"></i> <?php echo $totalproduct  ?></span></a>

</div>




<div class="latest_products" style="overflow:auto;">


    <div class="latest_product_header"  style="">
    <ul class="breadcrumb">
  <li><a href="front_end.php">Home</a></li>
  <li>SHOPPING CART</li>
 

</ul>
    </div>

   

<div class="cart_table" >


<form method="post">


<table  style="width:100%">
<tr><th>PRODUCT</th>
<th>NAME OF PRODUCT</th>
<th>PRICE</th>


<th>QUANTITY</th>
<th>TOTAL</th>
<th>REMOVE</th>
</tr>


<?php

foreach($_SESSION['cart'] as $key=>$val)
{
  $productarr=get_product($con,'','',$key);
  $pname=$productarr[0]['name'];
  $mrp=$productarr[0]['mrp'];
  $price=$productarr[0]['price'];
  $image=$productarr[0]['image'];
  $maxquantity=$productarr[0]['qty'];
  $qty=$val['qty'];
	?>
<tr>

<td  class="product_thumbnail">
   <a href=""><img src="product/<?php echo $image  ?>"  width="120px;" height="120px;" alt="product_img"> </a>
</td>


<td class="product_name">
   <a href="" style="text-decoration:none;"><?php echo $pname  ?></a>
      <ul style="list-style-type:none;  margin:0;  padding:0;"><li>MRP.&nbsp; &nbsp Rs.<del><?php echo $mrp   ?></del>/kg</li>
          <li>PRICE.&nbsp; &nbsp; Rs.<?php echo $price  ?>/kg</li>
      </ul>
</td>


<td>
   <span><?php echo $price  ?></span>

</td>

<td>
   <input type="number" name="<?php echo $key  ?>qty" value="<?php echo $qty  ?>"    min='1'   max="<?php  echo $maxquantity; ?>" >
   <br>
   <input type="submit" id="update_button" formaction="manage_cart.php?id=<?php echo $key ?>&type=update " value="update">
</td>




<td><?php echo $qty*$price  ?></td>

<td>
         
   
<input type="submit"  id="remove_button" formaction="manage_cart.php?id=<?php echo $key ?>&type=remove " value="remove">

</td>



</tr>

<?php


}


?>

</table>


</form>


</div>





<div style="float:left;">
<a href="front_end.php" class="button button1">Continue Shopping</a>

</div>

<div  style="  float:right; clear:right;">
<a href="frontend_checkout.php?id=''&type=''"  class="button button2">Checkout</a>
</div>




















































<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge"  style="clear:both;">
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
