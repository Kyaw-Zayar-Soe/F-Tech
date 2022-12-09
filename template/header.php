<?php
ob_start();
session_start();
include("./admin/inc/config.php");
include("./admin/inc/CSRF_Protect.php");
include("./admin/inc/function.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';


$current_date_time = date('Y-m-d H:i:s');
$statement = $conn->prepare("SELECT * FROM payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);     
	$diff = $ts2 - $ts1;
	$time = $diff/(3600);
	if($time>24) {

		// Return back the stock amount
		// $statement1 = $conn->prepare("SELECT * FROM orders WHERE payment_id=?");
		// $statement1->execute(array($row['payment_id']));
		// $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
		// foreach ($result1 as $row1) {
		// 	$statement2 = $conn->prepare("SELECT * FROM products WHERE product_id=?");
		// 	$statement2->execute(array($row1['product_id']));
		// 	$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);							
		// 	foreach ($result2 as $row2) {
		// 		$product_quantity = $row2['quantity'];
		// 	}
		// 	$final = $product_quantity+$row1['quantity'];

		// 	$statement = $conn->prepare("UPDATE products SET quantity=? WHERE product_id=?");
		// 	$statement->execute(array($final,$row1['product_id']));
		// }
		
		// // Deleting data from table
		// $statement1 = $conn->prepare("DELETE FROM orders WHERE payment_id=?");
		// $statement1->execute(array($row['payment_id']));

		// $statement1 = $conn->prepare("DELETE FROM payments WHERE id=?");
		// $statement1->execute(array($row['id']));
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FTech - Online Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="./assets/css/style.min.css" rel="stylesheet">
    <link href="./assets/css/style1.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="./assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="./assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./assets/feather-icons-web/feather.css">
    <link rel="icon" href="./assets/img/logo-modified.png">


</head>


<body>

<!-- Topbar Start -->
<div class="container-fluid">
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="index.php" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">F</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">TECH</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="search.php" method="GET">
                    <div class="input-group">
                        <?php $csrf->echoInputField(); ?>
                        <input type="text" class="form-control" placeholder="Search for products" name="search_text">
                        <div class="input-group-append">
                            <button class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                    <div class="d-inline-flex align-items-center">
                            <?php
                                if(isset($_SESSION['customer'])) {   // login as yay tr
                            ?>
                        <div class="btn-group head">
                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">My Account</button>
                            <div class="dropdown-menu rounded shadow-lg dropdown-menu-right p-3">
                                    <li class="pb-1"><i class="fa fa-user"></i> login as <?php echo $_SESSION['customer']['customer_name']; ?></li>
                                    <li class="pb-1"><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
                                    <li><a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
                            </div>
                        </div>
                            <?php
                                } else {
                            ?>
                            <div class="head1">
                                <button type="button" class="btn btn-primary rounded mr-2"><a href="register.php">Create a Sign Up</a></button>
                                <button type="button" class="btn btn-outline-primary rounded"><a href="login.php">Log In</a></button>
                            </div>
                            <?php	
                                }
                            ?>
                    </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


  <!-- Navbar Start -->
  <div class="container-fluid bg-dark">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">

                    <?php
                        $statement = $conn->prepare("SELECT * FROM categories");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
					?>
                        <!-- <div class="nav-item dropdown dropright">
                            <a href="shop.php?id=<?php echo $row['category_id']; ?>" class="nav-link dropdown-toggle" data-toggle="dropdown">
                                <?php echo $row['category_name']; ?>
                            <i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                <a href="" class="dropdown-item">Computer</a>
                                <a href="" class="dropdown-item">Computer</a>
                                <a href="" class="dropdown-item">Computer</a>
                            </div>
                        </div> -->
                        <a href="shop.php?id=<?php echo $row['category_id']; ?>&type=cat&order_by=product_name" class="nav-item nav-link"><?php echo $row['category_name']; ?></a>
					<?php
						}
					?>

                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="<?php echo $url; ?>/dashboard.php" class="btn px-0 d-block d-lg-none">
                        <i class="fas fa-home fa-2x text-primary"></i>
                    </a>
                    <a href="index.php" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">F</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">TECH</span>
                    </a>
                    
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="about.php" class="nav-item nav-link">About Us</a>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages <i class="fa fa-angle-down mt-1"></i></a>
                                <div class="dropdown-menu bg-primary rounded-0 border-0 m-0">
                                    <a href="cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-pill" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="cart.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-pill" style="padding-bottom: 2px;">$
                                    <?php
                                        if(isset($_SESSION['cart_product_id'])) {
                                            $table_total_price = 0;
                                            $i=0;
                                            foreach($_SESSION['cart_product_quantity'] as $key => $value) 
                                            {
                                                $i++;
                                                $arr_cart_product_quantity[$i] = $value;
                                            }                    $i=0;
                                            foreach($_SESSION['cart_product_current_price'] as $key => $value) 
                                            {
                                                $i++;
                                                $arr_cart_product_current_price[$i] = $value;
                                            }
                                            for($i=1;$i<=count($arr_cart_product_quantity);$i++) {
                                                $total_price = $arr_cart_product_current_price[$i]*$arr_cart_product_quantity[$i];
                                                $table_total_price = $table_total_price + $total_price;
                                            }
                                            echo $table_total_price;
                                        } else {
                                            echo '0.00';
                                        }
                                    ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->