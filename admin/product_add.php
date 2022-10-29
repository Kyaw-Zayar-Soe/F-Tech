<?php include "template/header.php"; ?>

<?php
if (isset($_POST['addProduct'])) {
    $valid = 1;

    if (empty($_POST['category_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a category<br>";
    }

    if (empty($_POST['brand_id'])) {
        $valid = 0;
        $error_message .= "You must have to select a brand<br>";
    }

    if (empty($_POST['product_name'])) {
        $valid = 0;
        $error_message .= "Product name can not be empty<br>";
    }

    if (empty($_POST['product_current_price'])) {
        $valid = 0;
        $error_message .= "Current Price can not be empty<br>";
    }

    if (empty($_POST['quantity'])) {
        $valid = 0;
        $error_message .= "Quantity can not be empty<br>";
    }

    $path = $_FILES['product_photo']['name'];
    $path_tmp = $_FILES['product_photo']['tmp_name'];

    if ($path != '') {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    } else {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    }


    if ($valid == 1) {

        $statement = $conn->prepare("SHOW TABLE STATUS LIKE 'products'");
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $id = $row[10];
        }


        $final_name = 'product-photo-' . $id . '.' . $ext;
        move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);

        //Saving data into the main table product
        $statement = $conn->prepare("INSERT INTO products(
										product_name,
										product_old_price,
										product_current_price,
										quantity,
									    photo,
										description,
										total_view,
										category_id,
                                        brand_id
									) VALUES (?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            $_POST['product_name'],
            $_POST['product_old_price'],
            $_POST['product_current_price'],
            $_POST['quantity'],
            $final_name,
            $_POST['description'],
            0,
            $_POST['category_id'],
            $_POST['brand_id']
        ));

        $success_message = 'Product is added successfully.';
    }
}
?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Product.php">Product</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Product</li>
            </ol>
        </nav>
    </div>
</div>

<?php if ($error_message) : ?>
    <div class="alert alert-warning m-2">
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
                        <i class="feather-plus-circle text-primary"></i> Create New Product
                    </h4>
                    <a href="product.php" class="btn btn-outline-primary">
                        <i class="feather-list"></i>
                    </a>
                </div>

                <hr>
                
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" name="product_name" id="" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Old Price</label>
                        <input type="number" name="product_old_price" id="" class="form-control" >
                    </div>
                    
                    <div class="form-group">
                        <label for="">Current Price</label>
                        <input type="number" name="product_current_price" id="" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" id="" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="">Choose Photo</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="product_photo" required>
                            <label class="custom-file-label" for="customFile">..........</label>
                        </div>
                    </div>
                    
                    <div class="form-group mb-0">
                        <label for="">Product Description</label>
                        <textarea name="description" id="description" class="form-control" rows="10" required></textarea>
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
                        <option disabled selected>Select the brand</option>
                            <?php
                            $statement = $conn->prepare("SELECT * FROM brands");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);	
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['brand_id']; ?>"><?php echo $row['brand_name']; ?></option>
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
                        <option disabled selected>Select the category</option>
                            <?php
                            $statement = $conn->prepare("SELECT * FROM categories");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);	
                            foreach ($result as $row) {
                                ?>
                                <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                                <?php
                            }
                            ?>
                    </select>

                    </div>  
                    <hr>
                    <button class="btn btn-primary" name="addProduct">Add Product</button>             
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