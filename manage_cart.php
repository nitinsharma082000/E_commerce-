<?php
require('connection.inc.php');
require('functions.inc.php');
require('frontend_addtocart.php');
$pid =get_safe_value($con,$_GET['id']);
$type =get_safe_value($con,$_GET['type']);
$qty;


unset($_SESSION['cart']['$pid']);



$obj=new add_to_cart();

if($type=="add")
{
	
$qty =get_safe_value($con,$_POST['qty']);
$obj->add_product($pid,$qty);
header("location:frontend_product.php?id=".$pid);
}

if($type=="update")
{
	
	$value= $_POST[$pid."qty"];
	$obj->update_product($pid,$value);
	header("location:frontend_cart.php");
	
	
}

if($type=="remove")
{
	
	$obj->remove_product($pid);
header("location:frontend_cart.php");
	
}




?>