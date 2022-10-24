<?php require "template/header.php"; ?>
<!-- login form -->
<?php
    if(isset($_POST['signBtn'])) {
            
        if(empty($_POST['email']) || empty($_POST['password'])) {
            $error_message = "Email and/or Password cannot be empty!".'<br>';
        } else {
            
            $email = strip_tags($_POST['email']);
            $password = strip_tags($_POST['password']);

            $statement = $conn->prepare("SELECT * FROM customers WHERE customer_email=?");
            $statement->execute(array($email));
            $total = $statement->rowCount();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row) {
                $rpassword = $row['customer_password'];
            }

            if($total==0) {
                $error_message .= "Email address does not match".'<br>';
            } else {
                //using MD5 form
                if( $rpassword != md5($password) ) {
                    $error_message .= "Passwords do not match".'<br>';
                } else {
                        $_SESSION['customer'] = $row;
                        header("location: ".BASE_URL."dashboard.php");
                }
                
            }
        }
    }
?>
<div class="row justify-content-center align-items-center">
    <div class="col-xl-5 col-md-8 col-sm-12">
        <div class="card pre m-5 rounded-0">
            <div class="card-header text-center text-primary">
                <h4 class="pt-2 text-warning"> Welcome to Shop! Please Login.</h4>   
            </div>
            <div class="card-body">
                <?php
                    if($error_message != '') {
                        echo '<div class="error alert alert-warning">' . $error_message . '</div>';
                    }
                    if($success_message != '') {
                        echo '<div class="success alert alert-warning">' . $success_message . '</div>';
                    }
                ?>

                <form action="" method="post">
                    <?php $csrf->echoInputField(); ?> 
                    <div class="form-group">
                        <label for=""><i class="feather-mail text-primary"></i> Enter email</label>
                        <input type="email" name="email" id="" class="form__input form-control" required>
                    </div>
                    <div class="form-group">
                        <label for=""><i class="feather-lock text-primary"></i> Enter Password</label>
                        <div class="input-group">
                                <input name="password" type="password" value="" class="input form-control" id="password" placeholder="*****" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                <div class="input-group-append">
                                    <span class="input-group" onclick="password_show_hide();">
                                    <i class="far fa-eye" id="show_eye"></i>
                                    <i class="far fa-eye-slash d-none" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>                   
                         </div> 
                    <div class="form-group">
                        <a href="forget_password.php" class="text-danger">Forget Password?</a>
                    </div>
                    <div class="form-group mb-0">
                        <button class="btn btn-primary rounded" name="signBtn"><i class="feather-log-in text-dark"></i> Sign In</button>
                        <a href="register.php" class="btn btn-link btn-dark rounded float-right">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "template/footer.php"; ?>