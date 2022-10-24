<?php require "template/header.php"; ?>
<?php
    if(isset($_POST['sub'])) {

        $valid = 1;
            
        if(empty($_POST['email'])) {
            $valid = 0;
            $error_message .= "Email Address cannot be empty"."\\n";
        } else {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $valid = 0;
                $error_message .= "Email Address must be valid"."\\n";
            } else {
                $statement = $conn->prepare("SELECT * FROM customers WHERE customer_email=?");
                $statement->execute(array($_POST['email']));
                $total = $statement->rowCount();                        
                if(!$total) {
                    $valid = 0;
                    $error_message .= "Your email address is not found in our system"."\\n";
                }
            }
        }

        if($valid == 1) {

                $forget_password_message = "A confirmation link is sent to your email address. You will get the password reset information in there.";

            $token = md5(rand());
            $now = time();

            $statement = $conn->prepare("UPDATE customers SET customer_token=?,timestamp=? WHERE customer_email=?");
            $statement->execute(array($token,$now,strip_tags($_POST['email'])));
            
            $message = '<p>'."To reset your password, please click on the link below.".'<br> <a href="'.BASE_URL.'reset_password.php?email='.$_POST['email'].'&token='.$token.'">Click here</a>';
            
            $to      = $_POST['email'];
            $subject = "PASSWORD RESET REQUEST - YOUR WEBSITE.COM";
            $headers = "From: megadathh468@" . BASE_URL . "\r\n" .
                    "Reply-To: megadathh468@" . BASE_URL . "\r\n" .
                    "X-Mailer: PHP/" . phpversion() . "\r\n" . 
                    "MIME-Version: 1.0\r\n" . 
                    "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mail($to, $subject, $message, $headers);

            $success_message = $forget_password_message;
        }
    }
?>
<div class="row justify-content-center align-items-center">
    <div class="col-xl-5 col-md-8 col-sm-12">
        <div class="card pre m-5">
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
                    <div class="form-group mb-0">
                        <button class="btn btn-primary rounded" name="sub"><i class="text-dark"></i> Submit</button>
                        <a href="login.php" class="float-right text-dark"><i class="fas fa-2x fa-arrow-circle-left"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require "template/footer.php"; ?>
