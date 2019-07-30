<?php
session_start();
require_once './config/config.php';

$db = getDbInstance();
//If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === TRUE) {
    header('Location:dashboard.php');
}

//If user has previously selected "remember me option", his credentials are stored in cookies.
if(isset($_COOKIE['admin_username']) && isset($_COOKIE['admin_password']))
{
	//Get user credentials from cookies.
	$username = filter_var($_COOKIE['admin_username']);
	$passwd = filter_var($_COOKIE['admin_password']);
    $db->where ("email", $username);
    $db->where ("passwd", $passwd);
    $row = $db->get('admins');

    if ($db->count >= 1)
    {
    	//Allow user to login.
        $_SESSION['admin_logged_in'] = TRUE;
        $_SESSION['admin_user_time'] = time();
        $_SESSION['admin_profile'] = $row[0];
        header('Location:dashboard.php');
        exit;
    }
    else //Username Or password might be changed. Unset cookie
    {
    unset($_COOKIE['admin_username']);
    unset($_COOKIE['admin_password']);
    setcookie('admin_username', null, -1, '/');
    setcookie('admin_password', null, -1, '/');
    header('Location:auth-login.php');
    exit;
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="css/main.css?version=4.4.0" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="icon_fonts_assets/picons-thin/style.css">

  </head>
  <body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
        <div class="login_logo" style="background-color:white">
            <img src="img/bakery.png">
        </div>
        <br><br>
        <div class="auth-box-w">
            <div class="login-profile">
                <i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i>
            </div>
            <form action="actions/authenticate.php" method="POST">
                <div class="form-group">
                    <label for="">Email</label><input class="form-control" placeholder="Email" type="text" name="username">
                </div>
                <div class="form-group">
                    <label for="">Password</label><input class="form-control" placeholder="Password" type="password" name="passwd">
                </div>
                <div class="form-group">
                    <label for="">Remember Me &nbsp</label><input class="form-control" placeholder="remember" type="checkbox" name="remember" />
                </div>
                <?php
				if(isset($_SESSION['login_failure'])){ // header('Location:../profile.php'); ?>
				<div class="alert alert-danger alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $_SESSION['login_failure']; unset($_SESSION['login_failure']);?>
				</div>
				<?php } ?>
                <div class="buttons-w form-btn-center">
                    <button class="btn btn-lg btn-primary pl-5 pr-5">Login</button>
                </div>
                <br>
                <div class="no-account-2 text-center">
                        SWEET CAKES ADMINISTRATOR LOGIN
                </div>
            </form>
        </div>
    </div>
    <footer class="row fixed-bottom text-center">
        <div class="col-md-12 col-xs-12">
            <p>All Rights 2019. Reserved. Sweet Cakes Nigeria Limited</p>
        </div>
    </footer>
  </body>
</html>
