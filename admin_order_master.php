<?php

require('connection.inc.php');
require('functions.inc.php');
require('frontend_addtocart.php');
$msg='';
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!='')
{

}
else
{
      header('location:login.php');
      die();
}







$sql="select * from user order by id desc";
$res=mysqli_query($con,$sql);

?>
<!DOCTYPE html>
<html>
<head>
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}
.header .menu_icon
{
  margin-left:10%;
}

.row::after {
  content: "";
  clear: both;
  display: block;
}


html {
  font-family: "Lucida Sans", sans-serif;
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



}

.aside {
  background-color: #33b5e5;
  padding: 15px;
  color: #ffffff;
  text-align: center;
  font-size: 14px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
}
/*
css for menu icon
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
  color: black;
  display: block;
  transition: 0.3s;
  margin-top:4%;
}

.sidenav a:hover {
  color: #f1f1f1;
}


.footer {
  background-color: #111111;
  color: #ffffff;
  text-align: center;
  font-size: 12px;
  padding: 15px;
}


.main_content {width: 100%;}
.welcome_quote
{
  width:90%;
  float:left;
}
.welcome_quote i strong
{
  text-transform: uppercase;
}
.logout
{
  width:10%;
  float:right;
}
.categories_table
{
  padding-top:3%;
}
.categories_table table
{
  color:black;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}



tr:nth-child(even) {
  background-color: #ADD8E6;
}
tr:nth-child(odd) {
  background-color: #F0F8FF;
}


.logout span a{
  text-decoration:none;
  color:black;
}
.categories_table table tr a
{
  text-decoration:none;
  cursor:pointer;
  color:black;
  transition:1s;
}
.categories_table table tr a:hover
{
  background-color:black;
  color:white;
  border:1px solid grey;
  padding:2px;
}


body
{
  background-color:lightgrey;
}




</style>
</head>
<body>



  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="categories.php">Categories Master</a>
  <a href="product.php">Product Master</a>
  <a href="#">Order Master</a>
  <a href="user.php">User Master</a>
  <a href="contact_us.php">Contact US</a>
  </div>

<div class="header">
  <span><b>GROCERY STORE</b></span>
  <span style="font-size:30px;cursor:pointer" class="menu_icon" onclick="openNav()">&#9776;</span>
</div>

<div class="row" >
 

  <div class="main_content">
            <div class="welcome_quote"><i><strong>WELCOME &nbsp &nbsp &nbsp <?php echo $_SESSION['ADMIN_USERNAME']; ?></strong></i>
            </div> 


            <div class="logout"><span><a href="logout.php">LOG OUT<i class=" fas fa-arrow-alt-circle-right"></i></a></span>
            </div> 
  </div>
  <div class="categories_table">
          <div class="categories_header"><p><h1><i>ORDER_MASTER</i></h1></p>
                
          </div>
   <table  style="width:100%; border:1px solid black;">
                     <tr><th>ORDER_ID</th>
                     <th>ORDER_DATE</th>
                     <th>ADDRESS</th>


                    <th>PAYMENT-TYPE</th>
                    <th>PAYMENT-STATUS</th>
                    <th>ORDER STATUS</th>
					
                    </tr>
					
					<?php 
				

					$res=mysqli_query($con,"select order_table.*,order_status.name as order_status_str from order_table,order_status where order_status.id=order_table.order_status");
					while($row=mysqli_fetch_assoc($res))
					{
						
						?>
					<tr>
					   <td  style="padding:10px;  text-align:center;"><a href="frontend_order_master_detail.php?id=<?php echo $row['id'] ?>"  style="display:block;  padding:3px;  background-color:#4CAF50;"><?php echo $row['id'] ?></a></td>
					    <td><?php echo $row['added_on'] ?></td> 
						<td>
						<?php echo $row['address'] ?><br>
						<?php echo $row['city'] ?><br>
						<?php echo $row['pincode'] ?>
						</td> 
						<td><?php echo $row['payment_type'] ?></td> 
						<td><?php echo $row['payment_status'] ?></td> 
						<td><?php echo $row['order_status_str'] ?></td> 
						
						
					</tr>

                <?php
					}
					
					?>

                                          

</table>
  </div>

  
</div>

<div class="footer">
  <h3><i>DESIGNED BY NITIN SHARMA</i></h3>
</div>
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
</script>

</body>
</html>
