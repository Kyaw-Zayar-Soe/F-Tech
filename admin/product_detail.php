<?php include "template/header.php"; ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	$statement = $conn->prepare("SELECT * FROM products WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
    $statement = $conn->prepare("SELECT * FROM products WHERE product_id=?"); 
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);						
    foreach ($result as $us) {
        $name = $us['product_name'];
        $time = $us['created_at'];
        $oprice = $us['product_old_price'];
        $cprice = $us['product_current_price'];
        $des = $us['description'];
        $qty = $us['quantity'];
        $photo = $us['photo'];
    }
?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="product.php">Product List</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo $name; ?>
                </li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-info text-primary"></i> Products Detail
                    </h4>
                    <div class="">
                        <a href="product_add.php" class="btn btn-outline-primary">
                            <i class="feather-plus-circle"></i>
                        </a>
                        <a href="product.php" class="btn btn-outline-primary">
                            <i class="feather-list"></i>
                        </a>                        
                    </div>
                </div>
                <hr>
                <h4>
                    <?php echo $name;?>
                </h4>
                <div class="my-3">
                    <i class="feather-user text-primary"></i>
                    <?php if(isset($_SESSION['user']))echo $_SESSION['user']['name']; ?>
                    <?php 
                         $statement = $conn->prepare("SELECT category_id FROM products WHERE product_id=?"); 
                         $statement->execute(array($_REQUEST['id']));
                         $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                         foreach($result as $cus){
                             $cus['category_id'];
                         }	

                        $statement = $conn->prepare("SELECT category_name FROM categories WHERE category_id = ?");
                        $statement->execute(array($cus['category_id']));
                        $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result1 as $row1){
                            $cname = $row1['category_name'];
                        }
                    ?>
                    <i class="feather-layers text-success"></i>
                    <?php echo $cname; ?>

                    <i class="feather-calendar text-danger"></i>
                    <?php echo showTime($time,'M j \a\t\ g:i A'); ?>
                </div>
                <div class="">
                <div class="text-nowrap" style="width:82px;"><img src="../assets/uploads/<?php echo $photo; ?>" alt="" style="width:350px;height:400px;border-radius:5px;"></div><br>
                    <div class="product_price">
                            <div style="font-size:14px;" class="font-weight-bold mb-2"><h4>Product Price</h4></div>
                            <span>
                                    <span class="h6 font-weight-bold">OLD PRICE : <del>$<?php echo $oprice; ?></del></span><br><br>
                                    <span class="font-weight-semi-bold mb-4 h5">CURRENT PRICE : $<?php echo $cprice; ?></span>
                            </span>
                    </div>
                            <br>
                    <div class="product_quantity form-group">
                        <b>Quantity :</b>&nbsp<?php echo $qty; ?>;
                    </div>

                    <p class="mb-4 h6"><b><?php echo $des; ?></b></p>
                    

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-6">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-users text-primary"></i>  Product Viewer
                    </h4>
                    <div class="">
                        <a href="#" class="btn btn-outline-secondary full-screen-btn">
                                <i class="feather-maximize-2"></i>
                        </a>              
                    </div>
                </div>
                <hr>
                 <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Who</th>
                            <th>Device</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $statement = $conn->prepare("SELECT * FROM viewers WHERE product_id=?"); 
                            $statement->execute(array($_REQUEST['id']));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);						
                            foreach ($result as $us) {
                        ?>
                            <tr>
                                <td class="text-nowrap text-capitalize">
                                    <?php 
                                        if($us['customer_id']==0){
                                            echo "Unknown";
                                        }else{
                                                $statement = $conn->prepare("SELECT customer_name FROM customers WHERE customer_id=?"); 
                                                $statement->execute(array($us['customer_id']));
                                                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($result1 as $num){
                                                        $name =  $num['customer_name'];
                                                        echo $name;		
                                                    }
                                        }                                                                       
                                    ?></td>
                                <td ><?php echo $us['device']; ?></td>
                                <td class="text-nowrap"><?php echo showTime($us['created_at']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                 </table>
                
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>
<script>
    $(".table").dataTable({
        "order" : [[0,"desc"]]
    });
</script>