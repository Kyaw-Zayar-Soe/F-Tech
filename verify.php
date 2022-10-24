<?php require "template/header.php"; ?>

<?php
if ( (!isset($_REQUEST['email'])) || (isset($_REQUEST['token'])) )
{
    $var = 1;

    // check if the token is correct and match with database.
    $statement = $conn->prepare("SELECT * FROM customer WHERE customer_email=?");
    $statement->execute(array($_REQUEST['email']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
    foreach ($result as $row) {
        if($_REQUEST['token'] != $row['customer_token']) {
            header('location: '.BASE_URL);
            exit;
        }
    }

    // everything is correct. now activate the user removing token value from database.
    if($var != 0)
    {
        $statement = $conn->prepare("UPDATE customers SET customer_token=? WHERE customer_email=?");
        $statement->execute(array('',$_GET['email']));

        $success_message = '<p style="color:green;">Your email is verified successfully. You can now login to our website.</p><p><a href="'.BASE_URL.'login.php" style="color:#167ac6;font-weight:bold;">Click here to login</a></p>';     
    }
}
?>

<div class="row justify-content-center align-items-center">
    <div class="col-xl-5 col-md-8 col-sm-12">
        <div class="card pre m-5">
            <div class="card-header text-center text-primary">
                <h4 class="pt-2 text-warning"> Welcome to Shop! Registration Successful.</h4>   
            </div>
            <div class="card-body">
                <?php
                    echo $error_message,$success_message;
                ?>
            </div>
        </div>
    </div>
</div>

<?php require "template/footer.php"; ?>
