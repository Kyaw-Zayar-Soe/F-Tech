<?php require "template/header.php"; ?>
<?php require "template/top_slider.php"; ?>

<!-- Products Start -->
<div class="container-fluid pt-6 pb-3 mt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Latest Products</span></h2>
        <div class="row px-xl-5">

            <?php
                $statement = $conn->prepare("SELECT * FROM products ORDER BY product_id DESC LIMIT 8");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
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
            <?php } ?>
                                
        </div>
        <br>

        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Popular Products</span></h2>
        <div class="row px-xl-5">

        <?php
            $statement = $conn->prepare("SELECT * FROM products ORDER BY total_view DESC LIMIT 8");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
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
            <?php } ?>
                                
        </div>
</div>
    <!-- Products End -->
	
<?php require "template/bottom_slider.php"; ?>
<?php require "template/footer.php"; ?>