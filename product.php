<?php require "template/header.php"; ?>

<?php
    if(!isset($_REQUEST['id'])) {
        header('location: index.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $conn->prepare("SELECT * FROM products WHERE product_id=?");
        $statement->execute(array($_REQUEST['id']));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if( $total == 0 ) {
            header('location: index.php');
            exit;
        }
    }

    foreach($result as $row) {
        $product_name = $row['product_name'];
        $product_old_price = $row['product_old_price'];
        $product_current_price = $row['product_current_price'];
        $quantity = $row['quantity'];
        $photo = $row['photo'];
        $description = $row['description'];
        $product_category_id = $row['category_id'];
    }

    // Getting all categories name for breadcrumb
    $statement = $conn->prepare("SELECT * FROM categories WHERE category_id=?");
    $statement->execute(array($product_category_id));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
    foreach ($result as $row) {
        $category_name = $row['category_name'];
        $category_id = $row['category_id'];
    }


    if(isset($_SESSION['customer']['customer_id'])){
        $userId = $_SESSION['customer']['customer_id'];
    }else{
        $userId = 0;
    }
    $statement = $conn->prepare("INSERT INTO viewers (customer_id,product_id,device) VALUES (?,?,?)");
    $statement->execute(array($userId,$_REQUEST['id'],$_SERVER['HTTP_USER_AGENT']));


    if(isset($_POST['add'])) {

        // getting the currect stock of this product
        $statement = $conn->prepare("SELECT * FROM products WHERE product_id=?");
        $statement->execute(array($_REQUEST['id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
        foreach ($result as $row) {
            $current_product_quantity = $row['quantity'];
        }
        if($_POST['quantity'] > $current_product_quantity):
            $temp_msg = 'Sorry! There are only '.$current_product_quantity.' item(s) in stock';
            ?>
            <script type="text/javascript">alert('<?php echo $temp_msg; ?>');</script>
            <?php
        else:
        if(isset($_SESSION['cart_product_id']))
        {
            $arr_cart_product_id = array();
            $arr_cart_product_quantity = array();
            $arr_cart_product_current_price = array();

            $i=0;
            foreach($_SESSION['cart_product_id'] as $key => $value) 
            {
                $i++;
                $arr_cart_product_id[$i] = $value;
            }


            $added = 0;
            for($i=1;$i<=count($arr_cart_product_id);$i++) {
                if( $arr_cart_product_id[$i]==$_REQUEST['id'] ) {
                    $added = 1;
                    break;
                }
            }
            if($added == 1) {
            $error_message1 = 'This product is already added to the shopping cart.';
            } else {

                $i=0;
                foreach($_SESSION['cart_product_id'] as $key => $res) 
                {
                    $i++;
                }
                $new_key = $i+1;

                $_SESSION['cart_product_id'][$new_key] = $_REQUEST['id'];
                $_SESSION['cart_product_quantity'][$new_key] = $_POST['quantity'];
                $_SESSION['cart_product_current_price'][$new_key] = $_POST['product_current_price'];
                $_SESSION['cart_product_name'][$new_key] = $_POST['product_name'];
                $_SESSION['cart_product_photo'][$new_key] = $_POST['photo'];

                $success_message1 = 'Product is added to the cart successfully!';
            }
            
        }
        else
        {
            $_SESSION['cart_product_id'][1] = $_REQUEST['id'];
            $_SESSION['cart_product_quantity'][1] = $_POST['quantity'];
            $_SESSION['cart_product_current_price'][1] = $_POST['product_current_price'];
            $_SESSION['cart_product_name'][1] = $_POST['product_name'];
            $_SESSION['cart_product_photo'][1] = $_POST['photo'];

            $success_message1 = 'Product is added to the cart successfully!';
        }
        endif;
    }
    ?>

    <?php
    if($error_message1 != '') {
        echo "<script>alert('".$error_message1."')</script>";
    }
    if($success_message1 != '') {
        echo "<script>alert('".$success_message1."')</script>";
        header('location: product.php?id='.$_REQUEST['id']);
    }
?>

    <!-- Breadcrumb Start -->
    <div class="container-fluid mt-3">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="index.php">Home</a>
                    <span class="breadcrumb-item active"><?php echo $product_name; ?></span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="./assets/uploads/<?php echo $photo; ?>" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">

                    <form action="" method="post">
                        <h3><?php echo $product_name; ?></h3>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star"></small>
                                <small class="fas fa-star-half-alt"></small>
                                <small class="far fa-star"></small>
                            </div>
                            <small class="pt-1">(99 Reviews)</small>
                        </div>
                        <div class="product_price">
                                <div style="font-size:14px;" class="font-weight-bold mb-2">Product Price</div>
                                <span>
                                    <?php if($product_old_price!=''): ?>
                                        <del>$<?php echo $product_old_price; ?></del>
                                    <?php endif; ?> 
                                        <h3 class="font-weight-semi-bold mb-4">$<?php echo $product_current_price; ?></h3>
                                </span>
                        </div>

                        <input type="hidden" name="product_current_price" value="<?php echo $product_current_price; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
                        <input type="hidden" name="photo" value="<?php echo $photo; ?>">

                        
                        <div class="d-flex align-items-center mb-4 pt-2">

                            <div class="product_quantity form-group">
                                <b>Quantity :</b>&nbsp;
								<input type="number" class="input-text qty" step="1" min="1" max="" name="quantity" style="width:60px ;" value="1" title="Qty" size="4" pattern="[0-9]*" inputmode="numeric">
							</div>

                            <!-- <div class="input-group quantity mr-3" style="width: 130px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="number" class="form-control bg-secondary border-0 text-center" min='1' max="" name="quantity" value="1" pattern="[0-9]*" inputmode="numeric">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div> -->
                            
                        </div>
                        <button class="btn btn-primary px-3" name="add"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                    </form>    

                    
                    <div class="d-flex pt-2 mt-4">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="https://www.facebook.com/">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="https://twitter.com/">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="https://www.linkedin.com/feed/">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="https://www.pinterest.com/">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <?php
                                if($description == '') {
                                    echo "No feature found!";
                                } else {
                            ?>
                                    <h4 class="mb-3">Product Description</h4>
                                    <p><?php echo $description; ?></p>    
                            <?php } ?>
                            
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                        </li>
                                        <li class="list-group-item px-0">
                                            Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                        </li>
                                      </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">1 review for "Product Name"</h4>
                                    <div class="media mb-4">
                                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            
            <?php
                $statement = $conn->prepare("SELECT * FROM products WHERE category_id=? AND product_id !=? LIMIT 4");
                $statement->execute(array($category_id,$_REQUEST['id']));
                $result3 = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result3 as $row) {
            ?>                    
                 <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="./assets/uploads/<?php echo $row['photo'];?>" style="height: 300px;object-fit: cover;"  alt="">
                            <div class="product-action">
                                
                                <a class="btn btn-outline-dark btn-square" href="product.php?id=<?php echo $row['product_id']; ?>"><i class="fa fa-shopping-cart"></i></a>
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


<?php require "template/footer.php"; ?>