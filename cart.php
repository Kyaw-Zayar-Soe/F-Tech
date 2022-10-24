<?php require "template/header.php"; ?>

<?php
    $error_message = '';
    if(isset($_POST['update'])) {

        $i = 0;
        $statement = $conn->prepare("SELECT * FROM products");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $i++;
            $table_product_id[$i] = $row['product_id'];
            $table_quantity[$i] = $row['quantity'];
        }

        $i=0;
        foreach($_POST['product_id'] as $val) {
            $i++;
            $arr1[$i] = $val;
        }
        $i=0;
        foreach($_POST['quantity'] as $val) {
            $i++;
            $arr2[$i] = $val;
        }
        $i=0;
        foreach($_POST['product_name'] as $val) {
            $i++;
            $arr3[$i] = $val;
        }
        
        $allow_update = 1;
        for($i=1;$i<=count($arr1);$i++) {
            for($j=1;$j<=count($table_product_id);$j++) {
                if($arr1[$i] == $table_product_id[$j]) {
                    $temp_index = $j;
                    break;
                }
            }
            if($table_quantity[$temp_index] < $arr2[$i]) {
                $allow_update = 0;
                $error_message .= '"'.$arr2[$i].'" items are not available for "'.$arr3[$i].'"\n';
            } else {
                $_SESSION['cart_product_quantity'][$i] = $arr2[$i];
            }
        }
        $error_message .= '\Other items quantity are updated successfully!';
        ?>
        
         <?php if($allow_update == 0): ?>
             <script>alert('<?php echo $error_message; ?>');</script>
         <?php else: ?>
             <script>alert('All Items Quantity Update is Successful!');</script>
         <?php endif; ?>
         <?php

    }
?>
    <!-- Breadcrumb Start -->
<div class="container-fluid mt-3">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
</div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
<div class="container-fluid">
    <?php if(!isset($_SESSION['cart_product_id'])): ?>
    <?php echo '<h2 class="text-center">Cart is Empty!!</h2></br>'; ?>
    <?php echo '<h4 class="text-center">Add products to the cart in order to view it here.</h4>'; ?>
    <?php else: ?>
        <form action="" method="post">
            <div class="row px-xl-5">
                <?php $csrf->echoInputField(); ?>
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>items</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                        <?php
                            $table_total_price = 0;

                            $i=0;
                            foreach($_SESSION['cart_product_id'] as $key => $value) 
                            {
                                $i++;
                                $arr_cart_product_id[$i] = $value;
                            }

                            $i=0;
                            foreach($_SESSION['cart_product_quantity'] as $key => $value) 
                            {
                                $i++;
                                $arr_cart_product_quantity[$i] = $value;
                            }

                            $i=0;
                            foreach($_SESSION['cart_product_current_price'] as $key => $value) 
                            {
                                $i++;
                                $arr_cart_product_current_price[$i] = $value;
                            }

                            $i=0;
                            foreach($_SESSION['cart_product_name'] as $key => $value) 
                            {
                                $i++;
                                $arr_cart_product_name[$i] = $value;
                            }

                            $i=0;
                            foreach($_SESSION['cart_product_photo'] as $key => $value) 
                            {
                                $i++;
                                $arr_cart_product_photo[$i] = $value;
                            }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_product_id);$i++): ?>

                            <tr>
                                <td class="align-middle text-nowrap"><?php echo $i; ?></td>
                                <td class="align-middle text-nowrap"><img src="./assets/uploads/<?php echo $arr_cart_product_photo[$i]; ?>" alt="" style="width:100px;height:100px;border-radius:5px;"></td>
                                <td class="align-middle text-nowrap"><?php echo $arr_cart_product_name[$i]; ?></td>
                                <td class="align-middle text-nowrap"><?php echo $arr_cart_product_current_price[$i]; ?></td>
                                <td class="align-middle text-nowrap">
                                    <input type="hidden" name="product_id[]" value="<?php echo $arr_cart_product_id[$i]; ?>">
                                    <input type="hidden" name="product_name[]" value="<?php echo $arr_cart_product_name[$i]; ?>">
                                    <input type="number" class="input-text qty text" step="1" min="1" max="" name="quantity[]" value="<?php echo $arr_cart_product_quantity[$i]; ?>" title="Qty" size="4" style="width:60px ;" pattern="[0-9]*" inputmode="numeric">
                                </td>
                                <td class="align-middle">
                                    <?php
                                        $total_price = $arr_cart_product_current_price[$i]*$arr_cart_product_quantity[$i];
                                        $table_total_price = $table_total_price + $total_price;
                                    ?>
                                    $<?php echo $total_price; ?>
                                </td>
                                <td class="align-middle">
                                    <button type="button" data-href="cart_remove.php?id=<?php echo $arr_cart_product_id[$i]; ?>" class="btn btn-outline-danger rounded-circle" 
                                        data-toggle="modal" data-target="#confirm-delete">
                                        <i class="fas fa-trash-alt fas-danger"></i>
                                    </button>
                                    <?php include "cart_remove_modal.php";  ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>

                </div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6>$<?php echo $table_total_price; ?></h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <?php $shipping_cost = null; ?>
                                <?php if(isset($_SESSION['customer'])){ 
                                    $statement = $conn->prepare("SELECT * FROM region WHERE region_id=?");
                                    $statement->execute(array($_SESSION['customer']['customer_s_region']));
                                    $result = $statement->rowCount();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            $shipping_cost = $row['amount'];
                                        }
                                ?>
                                    <h6 class="font-weight-medium">$<?php echo $shipping_cost; ?></h6>
                                <?php }else{ ?>
                                    
                                    <h6 class="font-weight-medium">$<?php echo $shipping_cost; ?></h6>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <?php $final_price = $table_total_price + $shipping_cost; ?>
                                <h5>Total</h5>
                                <h5>$<?php echo $final_price; ?></h5>
                            </div>
                            <button class="btn btn-block btn-primary rounded-pill font-weight-bold my-3 py-3" name="update">UPDATE CART</button>
                            <a href="index.php" class="btn btn-block rounded-pill btn-primary font-weight-bold my-3 py-3">CONTINUE SHOPPING</a>
                            <a href="checkout.php" class="btn btn-block rounded-pill btn-primary font-weight-bold my-3 py-3">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
    <!-- Cart End -->

<?php require "template/footer.php"; ?>
