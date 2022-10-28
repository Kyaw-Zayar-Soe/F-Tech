<?php require "template/header.php"; ?>

<?php
    if(!isset($_REQUEST['search_text'])) {
        header('location: index.php');
        exit;
    } else {
        if($_REQUEST['search_text']=='') {
            header('location: index.php');
            exit;
        }
    }
?>

    <!-- Breadcrumb Start -->
<div class="container-fluid mt-3">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                    <span class="breadcrumb-item active">Search by "<?php 
                        $search_text = strip_tags($_REQUEST['search_text']); 
                        echo $search_text; 
                        ?>"
                    </span>
                </nav>
            </div>
        </div>
</div>
    <!-- Breadcrumb End -->

<div class="container-fluid pt-6 pb-3 mt-5">
    <div class="row px-xl-5">
        <?php
            $search_text = '%'.$search_text.'%';
        ?>

		<?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;
            $statement = $conn->prepare("SELECT * FROM products WHERE product_name LIKE ?");
            $statement->execute(array($search_text));
            $total_pages = $statement->rowCount();

            $targetpage = BASE_URL.'search.php?search_text='.$_REQUEST['search_text'];   //your file name  (the name of this file)
            $limit = 4;                                 //how many items to show per page
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;          //first item to display on this page
            else
                $start = 0;
            

            $statement = $conn->prepare("SELECT * FROM products WHERE product_name LIKE ? LIMIT $start, $limit");
            $statement->execute(array($search_text));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
            $prev = $page - 1;                          //previous page is page - 1
            $next = $page + 1;                          //next page is page + 1
            $lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
            $lpm1 = $lastpage - 1;   
            $pagination = "";
            if($lastpage > 1)
                {   
                    $pagination .= "<nav aria-label=\"Page navigation example\">
                                    <ul class=\"pagination justify-content-center\">";
                    if ($page > 1) 
                        $pagination.= "<li class=\"page-item\">
                                        <a class=\"page-link\" href=\"$targetpage&page=$prev\" tabindex=\"-1\" aria-disabled=\"true\">&laquo;</a>
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
                                $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";                 
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
                                    $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";                 
                            }
                            $pagination.= "...";
                            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
                            $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";       
                        }
                        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                        {
                            $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                            $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                            $pagination.= "...";
                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                            {
                                if ($counter == $page)
                                    $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$counter</a></li>";
                                else
                                    $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";                 
                            }
                            $pagination.= "...";
                            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
                            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";       
                        }
                        else
                        {
                            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=1\">1</a></li>";
                            $pagination.= "<li class=\"page-item\"><a href=\"$targetpage&page=2\">2</a></li>";
                            $pagination.= "...";
                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                            {
                                if ($counter == $page)
                                    $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">$counter</a></li>";
                                else
                                    $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$counter\">$counter</a></li>";                 
                            }
                        }
                    }
                    if ($page < $counter - 1) 
                        $pagination.= "<li class=\"page-item\"><a class=\"page-link\" href=\"$targetpage&page=$next\">&raquo;</a></a></li>";
                    else
                        $pagination.= "<li class=\"page-item disable\">
                                            <a class=\"page-link\" tabindex=\"-1\" aria-disabled=\"true\">&raquo;</a>
                                        </li>";
                    $pagination.= "</ul></nav>\n";       
                }
            /* ===================== Pagination Code Ends ================== */
        ?>

        <?php
            if(!$total_pages):
                echo '<span class="col justify-content-center" style="color:red;font-size:18px;">No result found</span>';
            else:
            foreach ($result as $row) {
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">

                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="./assets/uploads/<?php echo $row['photo'];?>" style="height: 300px;object-fit: cover;"  alt="">
                        <div class="product-action">
                            <?php if($row['quantity'] == 0): ?>
                                <div class="out-of-stock">
                                    <div class="inner">
                                        Out Of Stock
                                    </div>
                                </div>
                            <?php else: ?>
                                <a class="btn btn-outline-dark btn-square" href="product.php?id=<?php echo $row['product_id']; ?>"><i class="fa fa-shopping-cart"></i></a>
                            <?php endif; ?>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="product.php?id=<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>$<?php echo $row['product_current_price']; ?></h5>
                            <?php if($row['product_old_price'] != ''): ?>
                                <h6 class="text-muted ml-2"><del>$<?php echo $row['product_old_price']; ?></del></h6>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
                        </div>
                    </div>

                </div>
            </div>
            <?php
                }
            ?>
            <div class="clear"></div>
		    <div class="pagination">
                <?php 
                    echo $pagination; 
                ?>
            </div>
            <?php
                endif;
            ?>
    </div>
</div>
<?php require "template/bottom_slider.php"; ?>
<?php require "template/footer.php"; ?>
