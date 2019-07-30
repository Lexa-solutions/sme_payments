<?php 
require_once '../config/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $username = filter_input(INPUT_POST, 'username');
    $passwd = filter_input(INPUT_POST, 'passwd');
    $remember = filter_input(INPUT_POST, 'remember');
     
    if ($username == 'finance_lead' & $passwd == 'superadmin') {
        $row = array('fullname'=> 'Finance Lead');

        $_SESSION['admin_logged_in'] = TRUE;
        $_SESSION['admin_user_time'] = time();
        $_SESSION['admin_profile'] = $row;
       	if($remember)
       	{
       		setcookie('admin_username',$username , time() + (86400 * 90), "/");
       		setcookie('admin_password',$passwd , time() + (86400 * 90), "/");
       	}
        header('Location:../dashboard.php');
        exit;
    } else {
        $_SESSION['login_failure'] = "Invalid email or password";
        header('Location:../index.php');
        exit;
    }
  
}