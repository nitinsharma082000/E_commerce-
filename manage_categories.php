<?php

require('connection.inc.php');
require('functions.inc.php');
$categories='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!='')
{

 $id=get_safe_value($con,$_GET['id']);
 $res=mysqli_query($con,"select * from categories where id='$id'");
 $check=mysqli_num_rows($res);
if($check>0)
{
   $row=mysqli_fetch_assoc($res);
   $categories=$row['categories'];
}
else
{
  header('location:categories.php');
  die();
}
}


if(isset($_POST['submit']))
{
          $categories=get_safe_value($con,$_POST['categories']);
          $res=mysqli_query($con,"select * from categories where categories='$categories'");
          $check=mysqli_num_rows($res);
          if($check>0)
                {
                  
                  if(isset($_GET['id']) && $_GET['id']!='')
                    {
                        $getdata=mysqli_fetch_assoc($res);
                        if($id=$getdata['id'])
                        {

                        }
                        else
                        {
                          $msg="category already exists";
                        }
                    }
                




                  else
                    {

                         $msg="categories already exists";
                    }
                }
          if($msg=='')
          {
            if(isset($_GET['id']) && $_GET['id']!='')
                       {
                          mysqli_query($con,"update  categories set categories='$categories' where id='$id'");
                       }
                    else
                       {
                          mysqli_query($con,"insert into categories(categories,status) value('$categories','1')");
                       }
                    header('location:categories.php');
                    die();
          }

}
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


.main_content {
  width: 100%;
  height:auto;
  overflow:auto;
}
.welcome_quote
{
  width:90%;
  display:inline-block;
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
  display:inline-block;
}
.categories_table
{
  padding-top:3%;
  width:100%;

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


.logout span a{
  text-decoration:none;
  color:black;
}

.categories_table table tr a
{
  text-decoration:none;
  cursor:pointer;
  color:black;
}
.categories_table table tr a:hover
{
  background-color:black;
  color:white;
  border:2px solid grey;
  padding:3px;
}



body
{
  background-color:lightgrey;
}

input
{
  padding:5px;
  display:block;
  width:80%;

  margin:10px;
  border-radius:6px;
}

.categories_form .container button{
  width:100%;
  background-color:rgb(122,122,234);
}
.error_msg
{
  color:red;i
}
.categories_table .categories_form
{
  background-color:white;
  box-shadow: 10px 14px 15px grey;
  margin:auto;
  width:100%;
  padding:2%;
}
.categories_table .categories_form .container
{
  width:100%;
}
.categories_table .categories_form .container .categories_input_field
{
  width:100%;
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

   
                  <form method="post" class="categories_form">
  

                      <div class="container">
                           <label for="categories" ><b>CATEGORIES</b></label>
                           <input type="text"  class="categories_input_field" placeholder="Enter Categorie name" name="categories" value="<?php echo $categories; ?>"required>
                          <button type="submit" name="submit">SUBMIT</button>
                          <div class="error_msg"><?php echo $msg ?></div>
                      </div>
                  </form>
      </div>


      <div class="footer">
          <h3><i>DESIGNED BY NITIN SHARMA</i></h3>
      </div>
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
