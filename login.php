<?php
session_start();
require_once('vendor/autoload.php');

use Rakit\Validation\Validator;
use Helper\Flash;
use Models\Admin;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $validator = new Validator;
        $validation = $validator->validate($_POST, [
            'email' => 'required|email',
            'pass' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();

            Flash::setFlash('error', $errors->firstOfAll()[array_key_first($errors->firstOfAll())]);
            return header('Location: ' . base_url('login.php'));
        }

        $email = $_POST['email'];
        $password = $_POST['pass'];

        $user = Admin::where('email', $email)->first();

        if (!is_null($user) && password_verify($password, $user->password)) {
            $_SESSION['auth'] = $user->id;

            return header('Location: ' . base_url('home.php'));
        }

        Flash::setFlash('error', 'Kredensial tidak valid');
        return header('Location: ' . base_url('login.php'));
    case 'GET':
        if (isset($_SESSION['auth'])) {
            return header('Location: ' . base_url('home.php'));
        }
        break;
    default:
        return error_response('Method not allowed');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head cpassword_verify($password, $user->password)ontent must come *after* these tags -->

    <!-- Title -->
    <title>Login</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/font-awesome/css/all.min.css" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="assets/css/lime.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
</head>

<body class="login-page err-500">
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
        </div>
    </div>

    <div class="container">
        <div class="login-container">
            <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-9 lfh">
                    <div class="card login-box">
                        <div class="card-body">
                            <h5 class="card-title">Sign In</h5>
                            <?php include($_SERVER['DOCUMENT_ROOT'] . '/template/message.inc.php') ?>
                            <form method="post" id="formlogin">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" required placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="pass" id="pass" class="form-control" required placeholder="Password">
                                </div>
                                <class="btn btn-primary float-right m-l-xxs>
                                    <input type="submit" name="Login" class="btn btn-primary float-right m-l-xxs">
                                    </class=>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.1.0.min.js"></script>
    <script src="assets/plugins/bootstrap/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/lime.min.js"></script>
</body>

</html>