<?php
session_start();
session_destroy();

if(isset($_COOKIE['admin_username']) && isset($_COOKIE['admin_password'])){
	unset($_COOKIE['admin_username']);
    unset($_COOKIE['admin_password']);
    setcookie('admin_username', null, -1, '/');
    setcookie('admin_password', null, -1, '/');
}
header('Location:../index.php');

 ?>