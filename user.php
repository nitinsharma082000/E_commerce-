<?php

require('connection.inc.php');
require('functions.inc.php');
$msg='';
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!='')
{

}
else
{
      header('location:login.php');
      die();
}


if(isset($_GET['type']) && $_GET['type']!='')
{

$type=get_safe_value($con,$_GET['type']);



/*delete operation on categories*/
if($type=='delete')
{

  $id=get_safe_value($con,$_GET['id']);
 
  $delete_sql="delete from user where id='$id' ";
  mysqli_query($con,$delete_sql);
}

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
  background-color: #20B2AA;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color:black;
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
  background-color:lightgrey;
}




</style>
</head>
<body>



  <div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="categories.php">Categories Master</a>
  <a href="product.php">Product Master</a>
  <a href="admin_order_master.php">Order Master</a>
  <a href="#">User Master</a>
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
          <div class="categories_header"><p><h1><i>USERS</i></h1></p>
                
          </div>
    <table>
    <tr>
      <th>S.NO</th>
      <th>ID</th>
      <th>NAME</th>
      <th>EMAIL</th>
      <th>MOBILE</th>
      <th>DATE</th>
      <th></th>
    </tr>
<?php
$i=1;
while($row=mysqli_fetch_assoc($res))
{ 
 ?>

    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['email']; ?></td>
      <td><?php echo $row['mobile']; ?></td>
      <td><?php echo $row['added_on']; ?></td>
      <td>  

        <?php 
      
        echo "<a href='?type=delete&id=".$row['id']."'>DELETE</a>";
      

      ?>
    </td>
    </tr>
  <?php 
  $i=$i+1;
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
