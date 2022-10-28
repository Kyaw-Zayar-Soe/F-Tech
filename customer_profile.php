<?php require "template/header.php"; ?>


<?php
    // Check if the customer is logged in or not
    if(!isset($_SESSION['customer'])) {
            header('location: '.BASE_URL.'logout.php');
            exit;
        } else {
            $statement = $conn->prepare("SELECT * FROM customers WHERE customer_id=?");
            $statement->execute(array($_SESSION['customer']['customer_id']));
            $total = $statement->rowCount();
        }
?>


<?php
    if (isset($_POST['update'])) {

        $valid = 1;

        if(empty($_POST['name'])) {
            $valid = 0;
            $error_message .= "Customer Name can not be empty."."<br>";
        }

        if(empty($_POST['phone'])) {
            $valid = 0;
            $error_message .= "Phone Number can not be empty."."<br>";
        }

        if(empty($_POST['address'])) {
            $valid = 0;
            $error_message .= "Address can not be empty."."<br>";
        }

        if( empty($_POST['password']) || empty($_POST['rpassword']) ) {
            $valid = 0;
            $error_message .= "Password can not be empty."."<br>";
        }

        if($valid == 1) {

            // update data into the database
            $statement = $conn->prepare("UPDATE customers SET customer_name=?, customer_phone=?, customer_address=?, customer_password=? WHERE customer_id=?");
            $statement->execute(array(
                        strip_tags($_POST['name']),
                        strip_tags($_POST['phone']),
                        strip_tags($_POST['address']),
                        md5(strip_tags($_POST['password'])),
                        $_SESSION['customer']['customer_id']
                    ));  
                    
            $success_message = "Profile Information is updated successfully.";

            $_SESSION['customer']['customer_name'] = $_POST['name'];
            $_SESSION['customer']['customer_phone'] = $_POST['phone'];
            $_SESSION['customer']['customer_address'] = $_POST['address'];
            $_SESSION['customer']['customer_password'] = md5(strip_tags($_POST['password']));        
        }
    }
?>
<div class="container mt-3  rounded-lg">
    <div class="row">
                   <?php include "customer_profile_sidebar.php";?>

        <div class="col-xl-9 bg-white shadow-lg col-10 ">
            <div class="card rounded mt-4 mb-4">
                <div class="card-body">
                <?php
                    if($error_message != '') {
                        echo '<div class="error alert alert-warning">' . $error_message . '</div>';
                    }
                    if($success_message != '') {
                        echo '<div class="success alert alert-warning">' . $success_message . '</div>';
                    }
                ?>
                <form action="" method="post" class="">
                    <?php $csrf->echoInputField(); ?> 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Enter Full Name :</label>
                            <input type="text" name="name" id="" value="<?php echo $_SESSION['customer']['customer_name']; ?>" class="form__input form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Enter email :</label>
                            <input type="email" name="email" id="" value="<?php echo $_SESSION['customer']['customer_email']; ?>" class="form__input form-control" disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Enter Phone No :</label>
                            <input type="text" name="phone" id="" value="<?php echo $_SESSION['customer']['customer_phone']; ?>" class="form__input form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-lock text-primary"></i> Enter Password :</label>
                            <div class="input-group">
                                <input name="password" type="password" value="" class="form__input form-control" id="password" placeholder="*****" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                <div class="input-group-append">
                                    <span class="input-group" onclick="password_show_hide();">
                                    <i class="far fa-eye" id="show_eye"></i>
                                    <i class="far fa-eye-slash d-none" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-lock text-primary"></i> Retype-Password :</label>
                            <div class="input-group">
                                <input name="rpassword" type="password" value="" class="form__input form-control" id="password" placeholder="*****" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                <div class="input-group-append">
                                    <span class="input-group" onclick="password_show_hide();">
                                    <i class="far fa-eye" id="show_eye"></i>
                                    <i class="far fa-eye-slash d-none" id="hide_eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for=""><i class="feather-mail text-primary"></i> Address :</label>
                        <textarea name="address" class="form-control form__input" cols="30" rows="10" style="height:70px;"><?php echo $_SESSION['customer']['customer_address']; ?></textarea>
                    </div>
                    <div class="form-group pt-2 mb-0">
                        <button class="btn btn-primary rounded" name="update">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php require "template/footer.php"; ?>
