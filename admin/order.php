<?php include "template/header.php"; ?>

<?php
    // $error_message = '';
    // if(isset($_POST['form1'])) {
    //     $valid = 1;
    //     if(empty($_POST['subject_text'])) {
    //         $valid = 0;
    //         $error_message .= 'Subject can not be empty\n';
    //     }
    //     if(empty($_POST['message_text'])) {
    //         $valid = 0;
    //         $error_message .= 'Subject can not be empty\n';
    //     }
    //     if($valid == 1) {

    //         $subject_text = strip_tags($_POST['subject_text']);
    //         $message_text = strip_tags($_POST['message_text']);

    //         // Getting Customer Email Address
    //         $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
    //         $statement->execute(array($_POST['cust_id']));
    //         $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    //         foreach ($result as $row) {
    //             $cust_email = $row['cust_email'];
    //         }

    //         // Getting Admin Email Address
    //         $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    //         $statement->execute();
    //         $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    //         foreach ($result as $row) {
    //             $admin_email = $row['contact_email'];
    //         }

    //         $order_detail = '';
    //         $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
    //         $statement->execute(array($_POST['payment_id']));
    //         $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    //         foreach ($result as $row) {
                
    //             if($row['payment_method'] == 'PayPal'):
    //                 $payment_details = '
    // Transaction Id: '.$row['txnid'].'<br>
    //                 ';
    //             elseif($row['payment_method'] == 'Stripe'):
    //                 $payment_details = '
    // Transaction Id: '.$row['txnid'].'<br>
    // Card number: '.$row['card_number'].'<br>
    // Card CVV: '.$row['card_cvv'].'<br>
    // Card Month: '.$row['card_month'].'<br>
    // Card Year: '.$row['card_year'].'<br>
    //                 ';
    //             elseif($row['payment_method'] == 'Bank Deposit'):
    //                 $payment_details = '
    // Transaction Details: <br>'.$row['bank_transaction_info'];
    //             endif;

    //             $order_detail .= '
    // Customer Name: '.$row['customer_name'].'<br>
    // Customer Email: '.$row['customer_email'].'<br>
    // Payment Method: '.$row['payment_method'].'<br>
    // Payment Date: '.$row['payment_date'].'<br>
    // Payment Details: <br>'.$payment_details.'<br>
    // Paid Amount: '.$row['paid_amount'].'<br>
    // Payment Status: '.$row['payment_status'].'<br>
    // Shipping Status: '.$row['shipping_status'].'<br>
    // Payment Id: '.$row['payment_id'].'<br>
    //             ';
    //         }

    //         $i=0;
    //         $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
    //         $statement->execute(array($_POST['payment_id']));
    //         $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    //         foreach ($result as $row) {
    //             $i++;
    //             $order_detail .= '
    // <br><b><u>Product Item '.$i.'</u></b><br>
    // Product Name: '.$row['product_name'].'<br>
    // Size: '.$row['size'].'<br>
    // Color: '.$row['color'].'<br>
    // Quantity: '.$row['quantity'].'<br>
    // Unit Price: '.$row['unit_price'].'<br>
    //             ';
    //         }

    //         $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
    //         $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id']));

    //         // sending email
    //         $to_customer = $cust_email;
    //         $message = '
    // <html><body>
    // <h3>Message: </h3>
    // '.$message_text.'
    // <h3>Order Details: </h3>
    // '.$order_detail.'
    // </body></html>
    // ';
    //         $headers = 'From: ' . $admin_email . "\r\n" .
    //                 'Reply-To: ' . $admin_email . "\r\n" .
    //                 'X-Mailer: PHP/' . phpversion() . "\r\n" . 
    //                 "MIME-Version: 1.0\r\n" . 
    //                 "Content-Type: text/html; charset=ISO-8859-1\r\n";

    //         // Sending email to admin                  
    //         mail($to_customer, $subject_text, $message, $headers);
            
    //         $success_message = 'Your email to customer is sent successfully.';

    //     }
    // }
?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders List</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($error_message) : ?>
    <div class="alert alert-warning">
        <p>
            <?php echo $error_message; ?>
        </p>
    </div>
<?php endif; ?>

<?php if ($success_message) : ?>
    <div class="alert alert-success">

        <p><?php echo $success_message; ?></p>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-list text-primary"></i> Order List
                    </h4>
                    <div class="">
                        <a href="#" class="btn btn-outline-secondary full-screen-btn">
                            <i class="feather-maximize-2"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover rounded mt-3 mb-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">#</th>
                                <th class="text-nowrap">Customer Info</th>
                                <th class="text-nowrap">Product</th>
                                <th class="text-nowrap">Amount</th>
                                <th class="text-nowrap">Payment Status</th>
                                <th class="text-nowrap text-center">Method</th>
                                <th class="text-nowrap">Shipping Status</th>
                                <th class="text-nowrap">Control</th>
                                <th class="text-nowrap">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i=0;
                            $statement = $conn->prepare("SELECT * FROM payment");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
                            foreach ($result as $row) {
                            $i++;
            		    ?>
                                <tr class="">
                                    <td class="text-nowrap"><?php echo $i; ?></td>
                                    <td class="text-center"><?php echo $row['customer_name']; ?><br>
                                        <?php echo $row['customer_email']; ?>
                                    </td>
                                    <td class="text-nowrap">
                                    <?php
                                        $statement1 = $conn->prepare("SELECT * FROM orders WHERE payment_id=?");
                                        $statement1->execute(array($row['payment_id']));
                                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result1 as $row1) {
                                                echo $row1['product_name'];
                                                echo '<br>$'.$row1['price']."<br>";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-nowrap">$<?php echo $row['paid_amount']; ?></td>
                                    <td class="text-nowrap">
                                        <?php
                                            if($row['payment_status']=='Pending'){
                                        ?>
                                            <a href="order_change_status.php?id=<?php echo $row['id']; ?>&task=Completed" class="text-decoration-none text-warning"><i class="fas fa-dot-circle fa-xs"></i> <?php echo $row['payment_status']; ?></i></a>
                                        <?php
                                            }else{
                                        ?>
                                            <span class="text-success"><i class="fas fa-dot-circle fa-xs"></i> <?php echo $row['payment_status']; ?></span>
                                        <?php        
                                            }
                                        ?>    
                                    </td>
                                    <td class="text-nowrap" ><img src="./assets/img/paypal.webp"  style="width:90px;height:50px;border-radius:5px;"><?php echo $row['payment_method']; ?></td>
                                    <td class="text-nowrap">
                                            <?php
                                            if($row['payment_status']=='Completed') {
                                                if($row['shipping_status']=='Pending'){
                                            ?>
                                                <a href="shipping_change_status.php?id=<?php echo $row['id']; ?>&task=Completed" class="text-decoration-none text-warning"><i class="fas fa-dot-circle fa-xs"></i> <?php echo $row['shipping_status']; ?></a>
                                            <?php
                                                    } else {
                                            ?>
                                                <span class="text-success"><i class="fas fa-dot-circle fa-xs"></i> <?php echo $row['shipping_status']; ?></span>
                                            <?php 
                                                    }
                                                }
                                            ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="#" data-href="order_delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-outline-danger btn-sm">
                                            <i class="feather-trash-2 fa-fw"></i></a>
                                    </td>
                                    <td class="text-nowrap"><?php echo showTime($row['payment_date']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok text-white" href="order_delete.php?id=<?php echo $row['id']; ?>">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>
<script>
    $(".table").dataTable({
        "order": [
            [0, "desc"]
        ]
    });
</script>