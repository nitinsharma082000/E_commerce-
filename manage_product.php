<?php

require('connection.inc.php');
require('functions.inc.php');
$categories_id='';

$name='';

$mrp='';

$price='';

$qty='';

$image='';

$short_desc='';

$description='';

$meta_title='';
$meta_desc='';
$meta_keyword='';

$msg='';
$image_required='required';
if(isset($_GET['id']) && $_GET['id']!='')
{
$image_required='';
 $id=get_safe_value($con,$_GET['id']);
 $res=mysqli_query($con,"select * from product where id='$id'");
 $check=mysqli_num_rows($res);
if($check>0)
{
   $row=mysqli_fetch_assoc($res);
   $categories_id=$row['categories_id'];
    $name=$row['name'];
     $mrp=$row['mrp'];
      $price=$row['price'];
       $qty=$row['qty'];
        $short_desc=$row['short_desc'];
         $description=$row['description'];
          $meta_title=$row['meta_title'];
           $meta_desc=$row['meta_desc'];
            $meta_keyword=$row['meta_keyword'];
}
else
{
  header('location:product.php');
  die();
}
}


if(isset($_POST['submit']))
{
          $categories_id=get_safe_value($con,$_POST['categories_id']);
           $name=get_safe_value($con,$_POST['name']);
            $mrp=get_safe_value($con,$_POST['mrp']);
             $price=get_safe_value($con,$_POST['price']);
              $qty=get_safe_value($con,$_POST['qty']);
              $short_desc=get_safe_value($con,$_POST['short_desc']);                        
           $description=get_safe_value($con,$_POST['description']);
           $meta_title=get_safe_value($con,$_POST['meta_title']);
           $meta_desc=get_safe_value($con,$_POST['meta_desc']);
              $meta_keyword=get_safe_value($con,$_POST['meta_keyword']);   
                  
                 

          $res=mysqli_query($con,"select * from product where name='$name'");
          $check=mysqli_num_rows($res);
          if($check>0)
                {
                  
                  if(isset($_GET['id']) && $_GET['id']!='')
                    {
                        $getdata=mysqli_fetch_assoc($res);
                        if($id==$getdata['id'])
                        {

                        }
                        else
                        {
                          $msg="product already exists";
                        }
                    }
                




                  else
                    {

                         $msg="product already exists";
                    }
                }
                $var=$_FILES['image']['type'];

          if($var!=''  &&  $var!='image/png' && $var!='image/jpeg' && $var!='image/jpg') 
              {
                $msg="please select only png jpg jpeg type of format";
              }








          if($msg=='')
          {
            if(isset($_GET['id']) && $_GET['id']!='')
                       {


                        if($_FILES['image']['name']!='')
                        {

                          $image= rand(1111111111,9999999999).'_'.$_FILES['image']['name'];
                         move_uploaded_file($_FILES['image']['tmp_name'],'product/'.$image);

                         $update_sql="update  product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword', image='$image'  where id='$id'";
                         
                        }
                        else
                        {
                          $update_sql="update  product set categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword'  where id='$id'";
                        }



                         mysqli_query($con,$update_sql);



                       }
                    else
                       {  

                          $image= rand(1111111111,9999999999).'_'.$_FILES['image']['name'];
                         move_uploaded_file($_FILES['image']['tmp_name'],'product/'.$image);
                          mysqli_query($con,"insert into product(categories_id,name,mrp,price,qty,short_desc,description,meta_title,meta_desc,meta_keyword,status,image) value('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword',1,'$image')");
                       }
                    header('location:product.php');
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

.categories_form  button{

  background-color:rgb(122,122,234);
  padding:5px;
  display:block;
  width:100%;

  margin:10px;
  border-radius:6px;
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
.categories_table .categories_form .container select
{
  padding:5px;
  display:block;
  width:80%;

  margin:10px;
  border-radius:6px;
}
button .categories_submit_button{
  display:block;
  text-align:center;

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

   
                  <form method="post" class="categories_form" enctype="multipart/form-data">
  

                      <div class="container">
                           <label for="categories" ><b>PRODUCT</b></label>
                          <select  class="categories_input_field" name="categories_id">

                         <option>select categories</option>
            
                              <?php
                              $res=mysqli_query($con,"select id,categories from categories order by categories  asc");
                              while($row=mysqli_fetch_assoc($res))
                              {
                                if($row['id']==$categories_id)
                                {
                               echo "<option value=".$row['id']." selected>".$row['categories']."</option>";
                                }
                                else
                                {
                               echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                }
                                
                              }

                            ?>

                          </select>
                      </div>

                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>PRODUCT NAME</b></label>
                           <input type="text"  class="categories_input_field" placeholder="Enter product name" name="name" value="<?php echo $name; ?>">
                       
                          
                      </div>


                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>PRODUCT MRP</b></label>
                           <input type="text"  class="categories_input_field" placeholder="Enter product mrp" name="mrp" value="<?php echo $mrp; ?>"required>
                       
                          
                      </div>


                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>PRODUCT PRICE</b></label>
                           <input type="text"  class="categories_input_field" placeholder="Enter product name" name="price" value="<?php echo $price; ?>"required>
                       
                          
                      </div>


                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>QTY</b></label>
                           <input type="text"  class="categories_input_field" placeholder="QTY" name="qty" value="<?php echo $qty; ?>"required>
                       
                          
                      </div>


                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>Image</b></label>
                           <input type="file"  class="categories_input_field" name="image"  <?php $image_required ?>>
                       
                          
                      </div>


                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>SHORT DESCRIPTION</b></label>
                           <textarea  class="categories_input_field" placeholder="Enter product short_description" name="short_desc" ><?php echo $short_desc ?></textarea>
                          
                      </div>


                      <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>DESCRIPTION</b></label>
                           <textarea type="text"  class="categories_input_field" placeholder="Enter product description" name="description"><?php echo $description ?></textarea>
                          
                      </div>


                       <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>META TITLE</b></label>
                           <textarea type="text"  class="categories_input_field" placeholder="Enter product meta title" name="meta_title"><?php echo $meta_title ?></textarea>
                          
                      </div>


                       <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>META DESCRIPTION</b></label>
                           <textarea type="text"  class="categories_input_field" placeholder="Enter product meta description" name="meta_desc" ><?php echo $meta_desc ?></textarea>
                          
                      </div>


                       <div class="container" style="margin-top:1%;">
                           <label for="categories" ><b>META KEYWORD</b></label>
                           <textarea meta_keyword class="categories_input_field" placeholder="Enter product meta_keyword" name="meta_keyword"><?php echo $meta_keyword ?></textarea>
                          
                      </div>





                      


                          <button type="submit" name="submit">SUBMIT</button>
                          <div class="error_msg"><?php echo $msg ?></div>
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
