<?php

    require('connection.inc.php');
    require('functions.inc.php');


    unset($_SESSION['user_login']);
	unset($_SESSION['user_ID']);
	unset($_SESSION['user_name']);
	
	header('location:front_end.php');
?>