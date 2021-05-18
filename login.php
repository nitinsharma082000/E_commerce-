<?php

require('connection.inc.php');
require('functions.inc.php');













$msg='';
if(isset($_POST['submit']))
{
    $username=get_safe_value($con,$_POST['username']);
    $password=get_safe_value($con,$_POST['password']);
    $sql="select * from admin_users where username='$username' and password='$password'";
    $res=mysqli_query($con,$sql);
    $count=mysqli_num_rows($res);
    if($count>0)
    {
$_SESSION['ADMIN_LOGIN']='yes';
$_SESSION['ADMIN_USERNAME']=$username;
header('location:categories.php');
die();
    }
    else
    {
      $msg="PLEASE ENTER CORRECT LOGIN DETAILS";
    }
}
?>
<html>
<head>
<title>Form</title>
<link type="text/css" rel="stylesheet" href="style.css" />
<link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:800' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="container">
<form method="post">
<p><input type="text" class="box" name="username" value="ENTER USERNAME" id="username" required/></p>
<p><input type="password" class="box"  name="password" value="ENTER PASSWORD" id="pass" required/></p>
<p style="text-align:center"><input type="submit"  name="submit" value="SIGNIN" id="button" /></p>
</form>
<p id="login_error"><?php echo $msg;?></p>

</div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>