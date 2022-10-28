<?php require "template/header.php"; ?>

<?php
    if( !isset($_REQUEST['id']) || !isset($_REQUEST['type']) ) {
        header('location: index.php');
        exit;
    } else {

        if( ($_REQUEST['type'] != 'cat') ) {
            header('location: index.php');
            exit;
        } else {

            $statement = $conn->prepare("SELECT * FROM categories");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
            foreach ($result as $row) {
                $category_id[] = $row['category_id'];
                $category_name[] = $row['category_name'];
            }

            if($_REQUEST['type'] == 'cat') {
                if(!in_array($_REQUEST['id'],$category_id)) {
                    header('location: index.php');
                    exit;
                } else {

                    // Getting Title
                    for ($i=0; $i < count($category_id); $i++) { 
                        if($category_id[$i] == $_REQUEST['id']) {
                            $title = $category_name[$i];
                            break;
                        }
                    }
                    
                    $final_category_id = array($_REQUEST['id']);
                }   
            }

            
        }   
    }
?>

    <!-- Breadcrumb Start -->
<div class="container-fluid mt-3">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                <a class="breadcrumb-item text-dark" href="#">Shop</a>
                <span class="breadcrumb-item active">Shop List</span>
            </nav>
        </div>
    </div>
</div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-1">
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                        <span class="badge border font-weight-normal">150</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-2">
                        <label class="custom-control-label" for="price-2">$100 - $200</label>
                        <span class="badge border font-weight-normal">295</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-3">
                        <label class="custom-control-label" for="price-3">$200 - $300</label>
                        <span class="badge border font-weight-normal">246</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="price-4">
                        <label class="custom-control-label" for="price-4">$300 - $400</label>
                        <span class="badge border font-weight-normal">145</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="price-5">
                        <label class="custom-control-label" for="price-5">$400 - $500</label>
                        <span class="badge border font-weight-normal">168</span>
                    </div>
                </form>
            </div>
            <!-- Price End -->
            
            <!-- Color Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" checked id="color-all">
                        <label class="custom-control-label" for="price-all">All Color</label>
                        <span class="badge border font-weight-normal">1000</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-1">
                        <label class="custom-control-label" for="color-1">Black</label>
                        <span class="badge border font-weight-normal">150</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-2">
                        <label class="custom-control-label" for="color-2">White</label>
                        <span class="badge border font-weight-normal">295</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-3">
                        <label class="custom-control-label" for="color-3">Red</label>
                        <span class="badge border font-weight-normal">246</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input" id="color-4">
                        <label class="custom-control-label" for="color-4">Blue</label>
                        <span class="badge border font-weight-normal">145</span>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-control-input" id="color-5">
                        <label class="custom-control-label" for="color-5">Green</label>
                        <span class="badge border font-weight-normal">168</span>
                    </div>
                </form>
            </div>
            <!-- Color End -->

        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="shop.php?id=<?php echo $_REQUEST['id'];?>&type=cat">Latest</a>
                                    <a class="dropdown-item" href="shop.php?id=<?php echo $_REQUEST['id'];?>&type=cat&order_by=total_view">Popularity</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 
                

                <?php
                        // Checking if any product is available or not
                    $count = 0;
                    $statement = $conn->prepare("SELECT * FROM products");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $product_category_id[] = $row['category_id'];
                    }

                    for($i=0;$i<count($final_category_id);$i++):
                        if(in_array($final_category_id[$i],$product_category_id)) {
                            $count++;
                        }
                    endfor;

                    if($count==0) {
                        echo '<div class="h4 ml-5 pl-4">'."No product found".'</div>';
                    } else {
                        for($i=0;$i<count($final_category_id);$i++) {
                            if(isset($_REQUEST['order_by'])){
                                $ordercol = $_REQUEST['order_by'];
                                $statement = $conn->prepare("SELECT * FROM products WHERE category_id=? ORDER BY $ordercol DESC");
                                $statement->execute(array($final_category_id[$i]));
                                $result22 = $statement->fetchAll(PDO::FETCH_ASSOC);
                            }else{
                                $statement = $conn->prepare("SELECT * FROM products WHERE category_id=? ORDER BY product_id DESC");
                                $statement->execute(array($final_category_id[$i]));
                                $result22 = $statement->fetchAll(PDO::FETCH_ASSOC);
                            }
                            
                            foreach ($result22 as $row) {
                ?>

                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
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
                        }
                    };
                ?>

                <!-- <div class="col-12">
                    <nav>
                        <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div> -->
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
    <!-- Shop End -->


<?php require "template/footer.php"; ?>
