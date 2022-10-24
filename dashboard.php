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

<div class="container mt-3  rounded-lg">
    <div class="row">
                   <?php include "customer_profile_sidebar.php";?>

        <div class="col-xl-9 bg-white shadow-lg col-10">
            <div class="card rounded mt-4 mb-4">
                <div class="card-body text-center font-weight-bold">
                    Welcome to F-Tech online shopping
                </div>
            </div>
        </div>

    </div>
</div>
<?php require "template/footer.php"; ?>
