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
            <div class="post col-xl-8 shadow-lg card rounded mt-4 mb-4">
                <div class="card-body font-weight-bold">
                    <div class="card-title row justify-content-between">
                        <div class="h3 ml-3">Your Profile's Info</div>
                        <a href="<?php echo $url; ?>/customer_profile.php" class="mr-2">Manage</a>
                    </div>
                    <hr>
                <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-user text-primary"></i> Your Name :</label>
                            <?php echo $_SESSION['customer']['customer_name']; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Email :</label>
                            <?php echo $_SESSION['customer']['customer_email']; ?>
                        </div>
                </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-phone text-primary"></i> Phone No :</label>
                            <?php echo $_SESSION['customer']['customer_phone']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg overflow-hidden rounded mb-4">
                <div class="table-responsive">
                    <div class="p-3 row justify-content-between ml-2 mr-2">
                        <p class="mb-0">Recent Order</p>
                        <a href="<?php echo $url; ?>/customer_order.php" class="mr-2 font-weight-bold">Detail</a>
                    </div>
                    <table class="table table-hover mt-3 mb-0 cont">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Order#</th>
                                <th class="text-nowrap">Place On</th>
                                <th class="text-nowrap">Items</th>
                                <th class="text-nowrap">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $statement = $conn->prepare("SELECT * FROM payment WHERE customer_email=? && shipping_status=? ORDER BY id DESC LIMIT 2");
                                $statement->execute(array($_SESSION['customer']['customer_email'],"Completed"));    
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $us) {
                            ?>
                                <tr>
                                    <td class="text-nowrap text-capitalize">
                                    <?php echo $us['payment_id'] ;?></td>
                                    <td class="text-nowrap"><?php echo showTime($us['payment_date'],'M j'); ?></td>
                                    <td class="text-nowrap">
                                        <?php
                                            $statement1 = $conn->prepare("SELECT products.photo,products.product_name,orders.quantity FROM orders JOIN products ON orders.product_id = products.product_id WHERE payment_id = ?");
                                            $statement1->execute(array($us['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $us1) {
                                                $img = $us1['photo'];
                                            }
                                        ?>
                                        <img src="./assets/uploads/<?php echo $img; ?>" style="width:100px;height:100px;border-radius:5px;" alt="">
                                    </td>
                                    <td class="text-nowrap"><?php echo '$'.$us['paid_amount']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?php require "template/footer.php"; ?>
