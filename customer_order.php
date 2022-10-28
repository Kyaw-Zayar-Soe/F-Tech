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

        <div class="col-xl-9 bg-secondary shadow-lg col-10 ">
                <?php
                    if($error_message != '') {
                        echo '<div class="error alert alert-warning">' . $error_message . '</div>';
                    }
                    if($success_message != '') {
                        echo '<div class="success alert alert-warning">' . $success_message . '</div>';
                    }
                ?>
                <?php
                    /* ===================== Pagination Code Starts ================== */
                    $adjacents = 5;

                    $statement = $conn->prepare("SELECT * FROM payment WHERE customer_email=? ORDER BY id DESC");
                    $statement->execute(array($_SESSION['customer']['customer_email']));
                    $total_pages = $statement->rowCount();

                    $targetpage = BASE_URL.'customer_order.php';
                    $limit = 2;
                    $page = @$_GET['page'];
                    if($page) 
                        $start = ($page - 1) * $limit;
                    else
                        $start = 0;
                        
                    
                    
                    $statement = $conn->prepare("SELECT * FROM payment WHERE customer_email=? ORDER BY id DESC LIMIT $start, $limit");
                    $statement->execute(array($_SESSION['customer']['customer_email']));
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                    
                    if ($page == 0) $page = 1;
                    $prev = $page - 1;
                    $next = $page + 1;
                    $lastpage = ceil($total_pages/$limit);
                    $lpm1 = $lastpage - 1;   
                    $pagination = "";
                    if($lastpage > 1)
                    {   
                        $pagination .= "<nav aria-label=\"Page navigation example\">
                                        <ul class=\"pagination justify-content-center\">";
                        if ($page > 1) 
                            $pagination.= "<li class=\"page-item\">
                                            <a class=\"page-link\" href=\"$targetpage?page=$prev\" tabindex=\"-1\" aria-disabled=\"true\">&laquo;</a>
                                           </li>";
                        else
                            $pagination.= "<li class=\"page-item disable\">
                                                <a class=\"page-link\" tabindex=\"-1\" aria-disabled=\"true\">&laquo;</a>
                                           </li>";    
                        if ($lastpage < 7 + ($adjacents * 2))
                        {   
                            for ($counter = 1; $counter <= $lastpage; $counter++)
                            {
                                if ($counter == $page)
                                    $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$counter</a></li>";
                                else
                                    $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                            }
                        }
                        elseif($lastpage > 5 + ($adjacents * 2))
                        {
                            if($page < 1 + ($adjacents * 2))        
                            {
                                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                                {
                                    if ($counter == $page)
                                        $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$counter</a></li>";
                                    else
                                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                                }
                                $pagination.= "...";
                                $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
                                $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";       
                            }
                            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                            {
                                $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                                $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                                $pagination.= "...";
                                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                                {
                                    if ($counter == $page)
                                        $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$counter</a></li>";
                                    else
                                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                                }
                                $pagination.= "...";
                                $pagination.= "<li class=\"page-item\"><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
                                $pagination.= "<li class=\"page-item\"><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";       
                            }
                            else
                            {
                                $pagination.= "<li class=\"page-item\"><a href=\"$targetpage?page=1\">1</a></li>";
                                $pagination.= "<li class=\"page-item\"><a href=\"$targetpage?page=2\">2</a></li>";
                                $pagination.= "...";
                                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                                {
                                    if ($counter == $page)
                                        $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$counter</a></li>";
                                    else
                                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$counter\">$counter</a></li>";                 
                                }
                            }
                        }
                        if ($page < $counter - 1) 
                            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage?page=$next\">&raquo;</a></a></li>";
                        else
                            $pagination.= "<li class=\"page-item disable\">
                                                <a class=\"page-link\" tabindex=\"-1\" aria-disabled=\"true\">&raquo;</a>
                                           </li>";
                        $pagination.= "</ul></nav>\n";       
                    } 
                    
                    /* ===================== Pagination Code Ends ================== */
                ?>
                <?php
                                                if(!$total_pages){

                                                    echo '<div class="card rounded mt-4 mb-4">
                                                    <div class="card-body text-center font-weight-bold">'
                                                        . "No order items found" .
                                                    '</div>
                                                  </div>';
                                                }else{
                            
                    $tip = $page*10-10;
                    foreach ($result as $row) {
                    $tip++;
                ?>
                <div class="card shadow-lg rounded m-4 border-light">
                    <div class="d-flex justify-content-between p-2 text-dark flex-column flex-lg-row">
                        <span>PaymentID#<?php echo $row['payment_id'] ;?></span>
                        <span>
                            <?php echo showTime($row['payment_date'],'M j / g:i A'); ?>
                        </span>
                    </div>
                                    <hr style="margin-top:-2px ;">
                    <div class="card-body">
                                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center mt-n4 text-dark">
                                    <span class="pt-2">
                                        
                                    <?php
                                        $statement1 = $conn->prepare("SELECT products.photo,products.product_name,orders.quantity FROM orders JOIN products ON orders.product_id = products.product_id WHERE payment_id = ?");
                                        $statement1->execute(array($row['payment_id']));
                                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result1 as $row1) {
                                            $img = $row1['photo'];
                                        }
                                    ?>
                                    <div class="mt-n4 mb-2"><br><?php echo $row1['product_name']; ?></div>
                                    <img src="./assets/uploads/<?php echo $img; ?>" style="width:100px;height:100px;border-radius:5px;" alt="">
                                    </span>
                                    <span class="pt-2">Qty:<?php echo $row1['quantity']; ?></span>
                                    <span class="pt-2"><?php echo $row['txnid']; ?></span>
                                    <span class="pt-2"><?php echo '$'.$row['paid_amount']; ?></span>
                                    <span class="badge rounded-pill badge-warning"><i class="p-2 pt-1"><?php echo $row['shipping_status']; ?></i></span>
                                    <?php if($row['payment_status'] == 'Completed'){ ?>
                                        <span class="pt-2"><?php echo $row['payment_method']; ?> <i class="far fa-check-circle text-success"></i></span>
                                        <?php } else{ ?>
                                            <span class="pt-2"><?php echo $row['payment_method']; ?></span>
                                    <?php };?>
                                </div>
                    </div>
                </div>
                <?php
                    } 
                ?>    
            <div class="pagination justify-content-center" style="overflow: hidden;">
                        <?php 
                            echo $pagination; 
                            }   
                        ?>
            </div>
        </div>

    </div>
</div>
<?php require "template/footer.php"; ?>
