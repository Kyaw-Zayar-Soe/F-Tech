<?php
ob_start();
session_start();
include("./inc/config.php");
include("./inc/function.php");
include("./inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';


if (isset($_POST['signBtn'])) {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'Email and/or Password can not be empty<br>';
    } else {

        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);

        $statement = $conn->prepare("SELECT * FROM admin WHERE email=?");
        $statement->execute(array($email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($total == 0) {
            $error_message .= 'Email Address does not match<br>';
        } else {
            foreach ($result as $row) {
                $row_password = $row['password'];
            }

            if ($row_password != md5($password)) {
                $error_message .= 'Password does not match<br>';
            } else {

                $_SESSION['user'] = $row;
                header("location: index.php");
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/vendor/feather-icons-web/feather.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="icon" href="./assets/img/logo-modified.png">
</head>
<style>
    body{
        background-image:url(./assets/img/image3.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        height: auto;
    }
</style>
<body class="min-vh-100">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-5 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header text-center text-primary">
                        <h4><i class="feather-users"></i> Admin Login</h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if ((isset($error_message)) && ($error_message != '')) :
                            echo '<div class="error alert alert-warning">' . $error_message . '</div>';
                        endif;
                        ?>

                        <form action="" method="post">
                            <?php $csrf->echoInputField(); ?>
                            <div class="form-group">
                                <label for=""><i class="feather-mail text-primary"></i> Your email</label>
                                <input type="email" name="email" id="" class="form-control" autocomplete="off" autofocus required>
                            </div>
                            <div class="form-group">
                                <label for=""><i class="feather-lock text-primary"></i> Enter Password</label>
                                <input type="password" name="password" min="6" id="" autocomplete="off" class="form-control" required>
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary" name="signBtn"><i class="feather-log-in text-white"></i> Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/vendor/jquery.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="./assets/js/app.js"></script>
</body>

</html>