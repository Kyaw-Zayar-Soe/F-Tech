<?php require "template/header.php"; ?>

<?php
    if(!isset($_SESSION['cart_product_id'])) {
        header('location: cart.php');
        exit;
    }
?>


    <!-- Breadcrumb Start -->
<div class="container-fluid mt-3">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                <a class="breadcrumb-item text-dark" href="cart.php">Shopping Cart</a>
                <span class="breadcrumb-item active">Checkout</span>
            </nav>
        </div>
    </div>
</div>
    <!-- Breadcrumb End -->

   <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <?php if(!isset($_SESSION['customer'])): ?>
                    <div class="col justify-content-center align-items-center d-flex">
                    <p>
                        <a href="login.php" class="btn btn-lg btn-danger"><?php echo "Please login as customer to checkout"; ?></a>
                    </p>
                    </div>
            <?php else: ?>
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="table-sm-responsive mo">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Full Name :</label>
                                <input type="text" name="bname" id="" value="<?php echo $_SESSION['customer']['customer_b_name']; ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Phone No :</label>
                                <input type="text" name="bphone" id="" value="<?php echo $_SESSION['customer']['customer_b_phone']; ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-12">
                                <label for=""><i class="feather-mail text-primary"></i> Address :</label>
                                <textarea name="baddress" class="form-control " cols="30" rows="10" style="height:70px;" disabled><?php echo $_SESSION['customer']['customer_b_address']; ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Region :</label>
                                    <?php
                                        $statement = $conn->prepare("SELECT * FROM region WHERE region_id=?");
                                        $statement->execute(array($_SESSION['customer']['customer_b_region']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                             $ret = $row['region_name'];
                                        }
                                    ?>
                                <input type="text" name="bregion" id="" value="<?php echo @$ret; ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> City :</label>
                                <input type="text" name="bcity" id="" value="<?php echo $_SESSION['customer']['customer_b_city']; ?>" class=" form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Township :</label>
                                <input type="text" name="stownship" id="" value="<?php echo $_SESSION['customer']['customer_b_township']; ?>" class=" form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Zip Code :</label>
                                <input type="text" class=" form-control" name="szip" value="<?php echo $_SESSION['customer']['customer_b_zip']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Shipping address</label>
                        </div>
                    </div>
                </div>
                <div class="collapse mb-5" id="shipping-address">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
                    <div class="bg-light p-30">
                    <div class="row">
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Full Name :</label>
                                <input type="text" name="bname" id="" value="<?php echo $_SESSION['customer']['customer_s_name']; ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Phone No :</label>
                                <input type="text" name="bphone" id="" value="<?php echo $_SESSION['customer']['customer_s_phone']; ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-12">
                                <label for=""><i class="feather-mail text-primary"></i> Address :</label>
                                <textarea name="baddress" class="form-control " cols="30" rows="10" style="height:70px;" disabled><?php echo $_SESSION['customer']['customer_s_address']; ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Region :</label>
                                    <?php
                                        $statement = $conn->prepare("SELECT * FROM region WHERE region_id=?");
                                        $statement->execute(array($_SESSION['customer']['customer_s_region']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                             $row['region_name'];
                                        }
                                    ?>
                                <input type="text" name="bregion" id="" value="<?php echo @$row['region_name']; ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> City :</label>
                                <input type="text" name="bcity" id="" value="<?php echo $_SESSION['customer']['customer_s_city']; ?>" class=" form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Township :</label>
                                <input type="text" name="stownship" id="" value="<?php echo $_SESSION['customer']['customer_s_township']; ?>" class=" form-control" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Zip Code :</label>
                                <input type="text" class=" form-control" name="szip" value="<?php echo $_SESSION['customer']['customer_s_zip']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Products</h6>
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

                        ?>
                        <?php for($i=1;$i<=count($arr_cart_product_id);$i++): ?>
                        <div class="d-flex justify-content-between cart">
                            <p id="style"><?php echo $arr_cart_product_name[$i]; ?></p>
                            <p>Qty: <?php echo $arr_cart_product_quantity[$i]; ?></p>
                            <?php
                                $total_price = $arr_cart_product_current_price[$i]*$arr_cart_product_quantity[$i];
                                $table_total_price = $table_total_price + $total_price;
                                ?>
                            <p>$<?php echo $total_price; ?></p>
                        </div>
                        <?php endfor; ?>           
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>$<?php echo $table_total_price; ?></h6>
                        </div>
                        <?php
                            $statement = $conn->prepare("SELECT * FROM region WHERE region_id=?");
                            $statement->execute(array($_SESSION['customer']['customer_s_region']));
                            $result = $statement->rowCount();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    $shipping_cost = $row['amount'];
                                    $id = $row['region_id'];
                                }
                        ?>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$
                                <?php 
                                    if(empty($shipping_cost)):
                                        $shipping_cost =  0;
                                    else:
                                        echo $shipping_cost;
                                    endif;
                                ?>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <?php
                                $final_total = $table_total_price + $shipping_cost;
                            ?>
                            <h5>Total</h5>
                            <h5>$<?php echo $final_total; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                    <div class="bg-light p-30">
                    
                    <?php
                    $checkout_access = 1;
                    if(
                        ($_SESSION['customer']['customer_b_name']=='') ||
                        ($_SESSION['customer']['customer_b_phone']=='') ||
                        ($_SESSION['customer']['customer_b_address']=='') ||
                        ($_SESSION['customer']['customer_b_region']=='') ||
                        ($_SESSION['customer']['customer_b_city']=='') ||
                        ($_SESSION['customer']['customer_b_township']=='') ||
                        ($_SESSION['customer']['customer_b_zip']=='') ||
                        ($_SESSION['customer']['customer_s_name']=='') ||
                        ($_SESSION['customer']['customer_s_phone']=='') ||
                        ($_SESSION['customer']['customer_s_address']=='') ||
                        ($_SESSION['customer']['customer_s_region']=='') ||
                        ($_SESSION['customer']['customer_s_city']=='') ||
                        ($_SESSION['customer']['customer_s_township']=='') ||
                        ($_SESSION['customer']['customer_s_zip']=='')
                    ) {
                        $checkout_access = 0;
                    }
                    ?>
                    <?php if($checkout_access == 0): ?>
                        <div class="col-md-12">
                            <div style="color:red;font-size:22px;margin-bottom:50px;">
                                You must have to fill up all the billing and shipping information from your dashboard panel in order to checkout the order. Please fill up the information going to <a href="customer_billing_shipping_info.php" style="color:red;text-decoration:underline;">Click here!</a>.
                            </div>
                        </div>
                    <?php else: ?>
                            
                            <div class="row">

                                <div class="col-md-12 form-group">
                                    <label for=""><?php echo "Select payment method"; ?> *</label>
                                    <select name="payment_method" class="form-control select2" id="advFieldsStatus">
                                        <option value=""><?php echo "Select a method"; ?></option>
                                        <option value="PayPal"><?php echo "Paypal"; ?></option>
                                        <option value="Bank Deposit"><?php echo "Bank Deposit"; ?></option>
                                    </select>
                                </div>

                                <form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank">
                                    <input type="hidden" name="cmd" value="_xclick" />
                                    <input type="hidden" name="no_note" value="1" />
                                    <input type="hidden" name="lc" value="UK" />
                                    <input type="hidden" name="currency_code" value="USD" />
                                    <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

                                    <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                    <div class="col-md-12 form-group">
                                        <input type="submit" class="btn btn-primary" value="<?php echo "Pay Now"; ?>" name="form1">
                                    </div>
                                </form>
                                
                            </div>
                                
                            
                    <?php endif; ?>
                    
                        <!-- <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div> -->

                    
                        <!-- <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button> -->
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Checkout End -->

<?php require "template/footer.php"; ?>