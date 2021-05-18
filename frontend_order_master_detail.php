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



$order_id=get_safe_value($con,$_GET['id']);

if(isset($_POST['update_order_status']))
{
	$update_order_status=$_POST['update_order_status'];
	mysqli_query($con,"update order_table set order_status='$update_order_status' where id='$order_id'");
	
}




$sql="select * from user order by id desc";
$res=mysqli_query($con,$sql);

?>
<!DOCTYPE html>
<html>
<head>
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
  color: #818181;
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
  transition:0s;
}
.categories_table table tr a:hover
{
  background-color:black;
  color:white;
  
}

body
{
  background-color: lightgrey;
}

.address_detail .status_submit{
  width:100%;
  background-color:rgb(122,122,234);
}

</style>
</head>
<body>



  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="categories.php">Categories Master</a>
  <a href="product.php">Product Master</a>
  <a href="admin_order_master.php">Order Master</a>
  <a href="user.php">User Master</a>
  <a href="contact_us.php">Contact US</a>
  </div>

<div class="header">
  <span><b>Grocery Store</b></span>
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
          <div class="categories_header"><p><h1><i>ORDER_DETAIL</i></h1></p>
                
          </div>
      
	  
	      <div>
	  
              <table  style="width:100%; border:1px solid black;">
                     <tr><th>Product Name</th>
                     <th >Product Image</th>
                     <th>QTY</th>


                    <th>Price</th>
                    <th> Total Price</th>
                    
					
                    </tr>
					
					<?php 
					

					$res=mysqli_query($con,"select distinct(order_detail.id),order_detail.*,product.name,product.image,order_table.address,order_table.city,order_table.pincode from order_detail,product,order_table where order_detail.order_id='$order_id' and order_table.id='$order_id'  and order_detail.product_id=product.id");
					
					$total_price=0;
					while($row=mysqli_fetch_assoc($res))
					{
						
						$address=$row['address'];
						$city=$row['city'];
						$pincode=$row['pincode'];
						
						
					$total_price=$total_price+$row['qty']*$row['price'];
						?>
					<tr>

					    <td><?php echo $row['name'] ?></td> 
						
						<td  style="text-align:center ;  text-align:left;"><a href=""><img src="product/<?php echo $row['image'];  ?>"  width="120px;" height="120px;" alt="product_img"> </a></td> 
						<td><?php echo $row['qty'] ?></td> 
						<td><?php echo $row['price'] ?></td> 
					   <td><?php echo $row['qty']*$row['price'] ?></td> 
						
						
					</tr>

                <?php
					}
					
					?>
					<tr style="border:1px solid black;">

					    <td colspan="3"></td> 
						
						<td  style="" >Total Price</td> 
						<td  style="border:1px solid black;"><?php echo $total_price; ?></td> 
					
						
						
					</tr>

                                          

              </table>
			  
			    <div class="address_detail"><strong>Address</strong>  <?php echo $address;  ?>, <?php echo $city;  ?>,  <?php echo $pincode; ?><br><br>
                 				<strong>Order Status</strong>  <?php $order_status_arr=mysqli_fetch_assoc(mysqli_query($con,"select order_status.name from order_status,order_table where order_table.id='$order_id' and order_table.order_status=order_status.id"));
								echo $order_status_arr['name'];?>
								
								<div>
								<form method="post">
								 <select  style="padding:4px;border:1px solid grey;" class="categories_input_field" name="update_order_status">

                         <option><strong>select status</option>
            
                              <?php
                              $res=mysqli_query($con,"select * from order_status");
                              while($row=mysqli_fetch_assoc($res))
                              {
                                if($row['id']==$categories_id)
                                {
                               echo "<option value=".$row['id']." selected>".$row['name']."</option>";
                                }
                                else
                                {
                               echo "<option value=".$row['id'].">".$row['name']."</option>";
                                }
                                
                              }

                            ?>

                          </select>
								<input   style="width:100%; font-size:20px; display:block; border:10% ;"type="submit" class="status_submit">
								
								</form>
								
								
								</div>
								
								
				</div>
		  </div>

 
   </div>
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
</script>

</body>
</html>
