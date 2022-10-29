<?php include "template/header.php"; ?>

<?php
if(isset($_POST['editProduct'])) {
	$valid = 1;

    if(empty($_POST['category_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a category<br>";
    }

    if(empty($_POST['brand_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a brand<br>";
    }

    if(empty($_POST['product_name'])) {
        $valid = 0;
        $error_message .= "Product name can not be empty<br>";
    }

    if(empty($_POST['product_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    if(empty($_POST['quantity'])) {
        $valid = 0;
        $error_message .= "Quantity can not be empty<br>";
    }

    $path = $_FILES['product_photo']['name'];
    $path_tmp = $_FILES['product_photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }


    if($valid == 1) {

    	// if( isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmp_name"]) )
        // {

        // 	$photo = array();
        //     $photo = $_FILES['photo']["name"];
        //     $photo = array_values(array_filter($photo));

        // 	$photo_temp = array();
        //     $photo_temp = $_FILES['photo']["tmp_name"];
        //     $photo_temp = array_values(array_filter($photo_temp));

        // 	$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
		// 	$statement->execute();
		// 	$result = $statement->fetchAll();
		// 	foreach($result as $row) {
		// 		$next_id1=$row[10];
		// 	}
		// 	$z = $next_id1;

        //     $m=0;
        //     for($i=0;$i<count($photo);$i++)
        //     {
        //         $my_ext1 = pathinfo( $photo[$i], PATHINFO_EXTENSION );
		//         if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
		//             $final_name1[$m] = $z.'.'.$my_ext1;
        //             move_uploaded_file($photo_temp[$i],"../assets/uploads/product_photos/".$final_name1[$m]);
        //             $m++;
        //             $z++;
		//         }
        //     }

        //     if(isset($final_name1)) {
        //     	for($i=0;$i<count($final_name1);$i++)
		//         {
		//         	$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
		//         	$statement->execute(array($final_name1[$i],$_REQUEST['id']));
		//         }
        //     }            
        // }

        if($path == '') {
        	$statement = $conn->prepare("UPDATE products SET 
        							product_name=?, 
        							product_old_price=?, 
        							product_current_price=?, 
        							quantity=?,
        							description=?,
        							category_id=?,
        							brand_id=?

        							WHERE product_id=?");
        	$statement->execute(array(
        							$_POST['product_name'],
        							$_POST['product_old_price'],
        							$_POST['product_current_price'],
        							$_POST['quantity'],
        							$_POST['description'],
        							$_POST['category_id'],
        							$_POST['brand_id'],
        							$_REQUEST['id']
        						));
        } else {

        	unlink('../assets/uploads/'.$_POST['current_photo']);

			$final_name = 'product-photo-'.$_REQUEST['id'].'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );


        	$statement = $conn->prepare("UPDATE products SET 
        							product_name=?, 
        							product_old_price=?, 
        							product_current_price=?, 
        							quantity=?,
        							photo=?,
        							description=?,
        							category_id=?,
        							brand_id=?

        							WHERE product_id=?");
        	$statement->execute(array(
        							$_POST['product_name'],
        							$_POST['product_old_price'],
        							$_POST['product_current_price'],
        							$_POST['quantity'],
        							$final_name,
        							$_POST['description'],
        							$_POST['category_id'],
        							$_POST['brand_id'],
        							$_REQUEST['id']
        						));
        }
		
    	$success_message = 'Product is updated successfully.';
    }
}
?>

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

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Product.php">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </nav>
    </div>
</div>

<?php
    $statement = $conn->prepare("SELECT * FROM products WHERE product_id=?");
    $statement->execute(array($_REQUEST['id']));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $product_name = $row['product_name'];
        $product_old_price = $row['product_old_price'];
        $product_current_price = $row['product_current_price'];
        $quantity = $row['quantity'];
        $photo = $row['photo'];
        $description = $row['description'];
        $category_id = $row['category_id'];
        $brand_id = $row['brand_id'];
    }

    $statement = $conn->prepare("SELECT * FROM categories WHERE category_id=?");
    $statement->execute(array($category_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $category_name = $row['category_name'];
    }

    $statement = $conn->prepare("SELECT * FROM brands WHERE brand_id=?");
    $statement->execute(array($brand_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $brand_name = $row['brand_name'];
    }

?>

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

<form class="row" method="post" enctype="multipart/form-data">
    <div class="col-12 col-xl-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-edit text-primary"></i> Edit Product
                    </h4>
                    <a href="product.php" class="btn btn-outline-primary">
                        <i class="feather-list"></i>
                    </a>
                </div>
                <hr>
                
              
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" name="product_name" id="" class="form-control" value="<?php echo $product_name;?>" required>
                    </div>

                    <div class="form-group">
                        <label for="">Old Price</label>
                        <input type="number" name="product_old_price" id="" class="form-control" value="<?php echo $product_old_price;?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="">Current Price</label>
                        <input type="number" name="product_current_price" id="" class="form-control" value="<?php echo $product_current_price;?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" id="" class="form-control" value="<?php echo $quantity;?>" required>
                    </div>

                    <div class="form-group">
                        <label for="">Choose Photo</label>
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" id="customFile" name="product_photo" >
                            <label class="custom-file-label" for="customFile">..........</label>
                        </div>
                        <div class="">
                            <img src="../assets/uploads/<?php echo $photo;?>" style="width:150px;" alt="">
                            <input type="hidden" name="current_photo" id="customFile" value="<?php echo $photo; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label for="">Product Description</label>
                        <textarea name="description" id="description" class="form-control" rows="10" required><?php echo $description;?></textarea>
                    </div>
                    
                
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                     <h4 class="mb-0">
                         <i class="feather-wind text-primary"></i> Select Brand
                     </h4>
                     <a href="brand.php" class="btn btn-outline-primary">
                         <i class="feather-list"></i>
                     </a>
                </div>
                    <hr>
                    <div class="form-group">
                    <select class="custom-select custom-select" name="brand_id" required>
                        <option disabled>Select the brand</option>
                            <?php
                            $statement = $conn->prepare("SELECT * FROM brands");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);	
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['brand_id']; ?>"  <?php echo $row['brand_id'] == $brand_id ? 'selected' : ''; ?>><?php echo $row['brand_name']; ?></option>
                                <?php
                            }
                            ?>
                    </select>

                    </div>  
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                     <h4 class="mb-0">
                         <i class="feather-layers text-primary"></i> Select Category
                     </h4>
                     <a href="category.php" class="btn btn-outline-primary">
                         <i class="feather-list"></i>
                     </a>
                </div>
                    <hr>
                    <div class="form-group">
                    <select class="custom-select custom-select" name="category_id" required>
                        <option disabled>Select the category</option>
                            <?php
                            $statement = $conn->prepare("SELECT * FROM categories");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);	
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['category_id']; ?>"  <?php echo $row['category_id'] == $category_id ? 'selected' : ''; ?>><?php echo $row['category_name']; ?></option>
                                <?php
                            }
                            ?>
                    </select>

                    </div>  
                    <hr>
                    <button class="btn btn-primary" name="editProduct">Update Product</button>             
            </div>
        </div>
    </div>
</form>

<?php include "template/footer.php"; ?>
<script>
    $("#description").summernote({
        placeholder: 'Hello! write your description',
        tabsize: 2,
        height: 500,

    });
</script>