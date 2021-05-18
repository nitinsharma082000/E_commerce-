





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



$pid =get_safe_value($con,$_GET['id']);
$type =get_safe_value($con,$_GET['type']);

if($type=="remove")
{
	
	$obj->remove_product($pid);
	header("location:frontend_checkout.php?id=''&type=''");
	
	
}




$login_email="";
$login_password="";
$login_formerror="";
$loginemailerror="";
$loginpassworderror="";
if(isset($_POST['login']))
{
$login_email=$_POST['login_email'];
$login_password=$_POST['login_password'];


    if($login_email=="")
	{
	  $loginemailerror="please enter your email";
	  $login_formerror="yes";
	}
	if($login_password=="")
	{
		$loginpassworderror="please enter your password";
		$login_formerror="yes";
	}
	
	if($login_formerror!='yes')
	{
$result=mysqli_query($con,"select * from user where email='$login_email' and password='$login_password'");
$check=mysqli_num_rows($result);	
if($check>0)
{
	$row=mysqli_fetch_assoc($result);
	$_SESSION['user_login']="yes";
	$_SESSION['user_ID']=$row['id'];
	
	$_SESSION['user_name']=$row['name'];
		header("location:frontend_checkout.php?id=''&type=''");
}
else{
	
	 ?>
	 <script>
	 alert("Incorrect login details");
	 </script>
	 <?php
	
	
}

}
}


$name="";
$email="";
$mobile="";
$password="";
$nameerror="";
$emailerror="";
$mobileerror="";
$passworderror="";
$formerror="";
if(isset($_POST['register']))
{
	
	$name=$_POST['name'];
	$email=$_POST['email'];
	$mobile=$_POST['mobile'];
	$password=$_POST['password'];
	$added_on=date('y-m-d h:i:s');
	
	if($name=="")
	{
	  $nameerror="please enter your name";
	  $formerror="yes";
	}
	if($email=="")
	{
		$emailerror="please enter your email";
		$formerror="yes";
	}
	
	if($mobile=="")
	{
		$mobileerror="please enter your mobile_no.";
		$formerror="yes";
	}
	
	if($password=="")
	{
		$passworderror="please enter your password";
		$formerror="yes";
	}
	
	if($formerror!="yes")
	{
		
		$check_user=mysqli_num_rows(mysqli_query($con,"select * from user where email='$email'"));
		if($check_user>0)
		{
		  ?>
		  <script>
		  alert("email already present .Please another email");
		  </script>
		  <?php
		  
		}
		else{
			
		mysqli_query($con,"insert into user (name,email,mobile,added_on,password) values('$name','$email','$mobile','$added_on','$password')");
	    
	?>
	
	      <script>
		  alert("Registered succesfully");
		  </script>
		  <?php
		  
		  
            $name="";
            $email="";
            $mobile="";
            $password="";
	
    }
	
}
	
	
}
	
	
$cart_total=0;
foreach($_SESSION['cart'] as $key=>$val)
{
  $productarr=get_product($con,'','',$key);
  $pname=$productarr[0]['name'];
  $mrp=$productarr[0]['mrp'];
  $price=$productarr[0]['price'];
  $image=$productarr[0]['image'];
  $qty=$val['qty'];
  $cart_total=$cart_total+($price*$qty);
}  
	
if(isset($_POST['submit']))

{
	$address=get_safe_value($con,$_POST['address']);
	$city=get_safe_value($con,$_POST['city']);
	$pincode=get_safe_value($con,$_POST['pincode']);
	$payment_type=get_safe_value($con,$_POST['payment_type']);
	$user_id=$_SESSION['user_ID'];
	$total_price=$cart_total;
	$payment_status='pending';
	if($payment_type=='cod')
	{
		
		$payment_status='success';
		
	}
	
	
	$order_status='1';
	$added_on=date('Y-m-d h:i:s');
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);	
	
	mysqli_query($con,"insert into order_table(user_id,address,city,pincode,payment_type,total_price,payment_status,order_status,txnid,added_on) values('$user_id','$address','$city','$pincode','$payment_type','$total_price','$payment_status','$order_status','$txnid','$added_on')");

     $order_id=mysqli_insert_id($con);
	 foreach($_SESSION['cart'] as $key=>$val)
    {
        $productarr=get_product($con,'','',$key);
  
  
        $price=$productarr[0]['price'];
  
        $qty=$val['qty'];
 
        mysqli_query($con,"insert into order_detail(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
 
     }



  
	unset($_SESSION['cart']);
	if($payment_type=='payu')
	{
		$MERCHANT_KEY = "gtKFFx"; 
$SALT = "eCwWELxi";
$hash_string = '';
//$PAYU_BASE_URL = "https://secure.payu.in";
$PAYU_BASE_URL = "https://test.payu.in";
$action = '';
$posted = array();
if(!empty($_POST)) {
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
  }
}

$userArr=mysqli_fetch_assoc(mysqli_query($con,"select * from user where id='$user_id'"));
$formError = 0;

$posted['txnid']=$txnid;
$posted['amount']=$total_price;
$posted['firstname']=$userArr['name'];
$posted['email']=$userArr['email'];
$posted['phone']=$userArr['mobile'];
$posted['productinfo']="productinfo";
$posted['key']=$MERCHANT_KEY ;
$hash = '';
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
         
  ) {
    $formError = 1;
  } else {    
	$hashVarsSeq = explode('|', $hashSequence);
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}


$formHtml ='<form method="post" name="payuForm" id="payuForm" action="'.$action.'">
<input type="hidden" name="key" value="'.$MERCHANT_KEY.'" />
<input type="hidden" name="hash" value="'.$hash.'"/><input type="hidden" name="txnid" value="'.$posted['txnid'].'" />
<input name="amount" type="hidden" value="'.$posted['amount'].'" />
<input type="hidden" name="firstname" id="firstname" value="'.$posted['firstname'].'" />
<input type="hidden" name="email" id="email" value="'.$posted['email'].'" />
<input type="hidden" name="phone" value="'.$posted['phone'].'" />
<textarea name="productinfo" style="display:none;">'.$posted['productinfo'].'</textarea><input type="hidden" name="surl" value="http://127.0.0.1/project/e_commerce/payu/payment_complete.php" />
<input type="hidden" name="furl" value="http://127.0.0.1/project/e_commerce/payu/payment_fail.php"/>
<input type="submit" style="display:none;"/></form>';
echo $formHtml;
echo '<script>document.getElementById("payuForm").submit();</script>';
	}
	else
	{
		
		
      ?>
     <script>
  
       window.location.href='thank_you.php';
  
     </script>
  
  
    <?php 

	}
	
    }

	
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
	border:none;
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


.div1,.div2
{
float:left;
}
.div1
{
width:70%;
overflow:hidden;

}
.div2
{
width:30%;
overflow:hidden;
}

.loginform,.registerform
{
float:left;
width:50%;
}



*{
  margin: 0;
  padding: 0;
  font-family: "montserrat",sans-serif;
}
.contact-section{
 
  padding: 40px 0;
}
.contact-section h1{
  text-align: center;
  color: #ddd;
}


.contact-form{
  max-width: 600px;
  margin: auto;
  padding: 0 10px;
  overflow: hidden;
}


.biling-input
{
display: block;
  width: 100%;
  box-sizing: border-box;
  margin: 16px 0;
  border: 1px solid black;
  background:white;
  padding: 20px 40px;
  outline: none;
  color: black;
  transition: 0.5s;
}

.biling-input:focus{
  box-shadow: 0 0 10px 4px #34495e;
}


.contact-form-text{
  display: block;
  width: 100%;
  box-sizing: border-box;
  margin: 16px 0;
  border: 1px solid black;
  background:white;
  border-radius:20px;
  padding: 10px 30px;
  outline: none;
  color: black;
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

.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}



@media (max-width: 800px) {
 .div1
{
width:100%;
overflow:hidden;

}
.div2
{
width:100%;
overflow:hidden;
}
}

th, td {
  padding: 15px;
  text-align: left;
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
  padding: 10px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 2px 1px;
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
  <li>Checkout</li>

</ul>
    </div>

   
</div>





<div class="row">
     <div class="col1">
         <div class="div1"  style="">
		 <?php
		 if(!isset($_SESSION['user_login']))
		 {
			 ?>
        
               <div class="loginform">
                     
                   <h1>LOGIN</h1>
                   
                   <form class="contact-form" action="" method="post">
   
                      <input type="email" class="contact-form-text" id="login_email"  name="login_email"  placeholder="Your email"  value="<?php  if($loginemailerror==""){  echo $login_email;  }    ?>">
                   	  <br>
	                  <p style="color:red;"><?php echo $loginemailerror ?></p>
                      <input type="password" class="contact-form-text"  id="login_password"  name="login_password"  placeholder="your password"  value="<?php  if($loginpassworderror==""){  echo $password;  }    ?>">
                  	  <br>
	                  <p style="color:red;"><?php echo $loginpassworderror ?></p>
                      <input type="submit" name="login" class="contact-form-btn" value="Login">

	
                   </form>
                   <br>
                   <br>
                   <br>
  
  
               </div>
              
              
               <div class="registerform">
                   <h1>REGISTER</h1>
  
                   <form class="contact-form" action="" method="post">
                     <input type="text" class="contact-form-text"  id="name" name="name" placeholder="Your name"  value="<?php  if($nameerror==""){  echo $name;  }    ?>">
	                 <br>
	                 <p style="color:red;"><?php echo $nameerror  ?></p>
	
                     <input type="email" class="contact-form-text" id="email"  name="email"  placeholder="Your email"   value="<?php  if($emailerror==""){  echo $email;  }    ?>">
	                 <br>
	                 <p style="color:red;"><?php echo $emailerror  ?></p>
					 
					 <input type="text" class="contact-form-text"  id="mobile"  name="mobile"  placeholder="Your phone" value="<?php  if($mobileerror==""){  echo $mobile;  }    ?>">
	<br>
	<p style="color:red;"><?php echo $mobileerror  ?></p>
    
	                 <input type="password" class="contact-form-text"  id="password"  name="password"  placeholder="Your password"  value="<?php  if($passworderror==""){  echo $password;  }    ?>">
	                 <br>
	                 <p style="color:red;"><?php echo $passworderror  ?></p>
   
                     <input type="submit" name="register" class="contact-form-btn" value="Submit">
	
                   </form>
              </div>
              
              <br>
              <br>
              
		 <?php
		 }
		 ?>
              <div class="billing and address information"  >
              
                   <div class="bilingdiv"  style=" background-color:#E6E6FA; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  ">
                     
                     <h3 style=" background-color:#48D1CC;padding:-top:10px; padding-bottom:10px; text-align:center;">Billing Address</h3>
                   
                     <form class="contact-form" action="" method="post">
                     <br>
                     <br>
   
                  
                     <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                     <input type="text" id="adr"  class="biling-input"  name="address" placeholder="542 W. 15th Street" required>
                     <label for="city"><i class="fa fa-institution"></i> City/STATE</label>
                     <input type="text" id="city"   class="biling-input"   name="city" placeholder="New York"  required>
                     <label for="zip">Zip/Post Code</label>
                     <input type="text" id="zip"  class="biling-input" name="pincode"  placeholder="123-45-678" pattern="[0-9]{6}"  required>
                
                
                
                    <div>
                      <h3 style="text-align:center">Payment Information</h3>
                          <br><br>
                      <div class="radiobutton">  Cash On Delivery
                         <input type="radio" name="payment_type"  value="cod"  required >&nbsp;&nbsp; PayU
                         <input type="radio" name="payment_type"  value="payu"   required >
                      </div>
                 
	                 <input type="submit" name="submit" value="Continue to checkout" class="btn">
                    </div>
                  </form>
                         <br>
                         <br>
                         <br>
  
  
 
              
                    </div>
              
              
              
             
        
        
             </div>
        
        </div>
        
        <div class="div2" style="padding:10px;  ">
           
<div class="cart_table"   style=" border:1px solid grey; background-color:#ADD8E6; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);  ">

<div style="padding:20px;  text-align:center;">
<h3  style="background-color:#48D1CC; text-align:center;">YOUR ORDER</h3>
<form method="post">


<?php
$cart_total=0;
foreach($_SESSION['cart'] as $key=>$val)
{
  $productarr=get_product($con,'','',$key);
  $pname=$productarr[0]['name'];
  $mrp=$productarr[0]['mrp'];
  $price=$productarr[0]['price'];
  $image=$productarr[0]['image'];
  $qty=$val['qty'];
  $cart_total=$cart_total+($price*$qty);
	?>

<table  style="width:100%; border:none;">



<tr>

<td  class="product_thumbnail">
   <a href=""><img src="product/<?php echo $image  ?>"  width="120px;" height="120px;" alt="product_img"> </a>
</td>


<td class="product_name">
   <a href="" style="text-decoration:none;"><?php  echo $pname  ?></a>
      <span >Rs. &nbsp;<?php echo ($price*$qty)  ?></span>
</td>



  <td>   
   

<input type="submit"  id="remove_button" formaction="?id=<?php echo $key ?>&type=remove " value="remove">

</td>



</tr>
<?php
}
?>

</table>


</form>


</div>
            
            
            
            
            
            
            
            
            
            
       
        
               <div  style="clear:both;  background-color:#20B2AA;"  >&nbsp;&nbsp;
			   
                 <h5  style="float:left;">Order_total</h5>
                 <span  style="float:right;">Rs. &nbsp;<?php echo $cart_total ?></span>
                
              
               </div>
               
               
            </div>  
        
        
        
        
        
        
        </div>
        
        
        
   </div>
   
   


</div>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge"  style="clear:both">
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
