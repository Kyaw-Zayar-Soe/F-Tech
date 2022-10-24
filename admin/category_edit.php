<?php include "template/header.php"; ?>

<?php
    if (isset($_POST['editCat'])) {
        $valid = 1;

        if (empty($_POST['name'])) {
            $valid = 0;
            $error_message .= "Category Name can not be empty<br>";
        } else {
            $statement = $conn->prepare("SELECT * FROM categories WHERE category_id=?");
            $statement->execute(array($_REQUEST['id']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $current_category_name = $row['category_name'];
            }

            $statement = $conn->prepare("SELECT * FROM categories WHERE category_name=? and category_name!=?");
            $statement->execute(array($_POST['name'], $current_category_name));
            $total = $statement->rowCount();
            if ($total) {
                $valid = 0;
                $error_message .= 'Category name already exists<br>';
            }
        }

        if ($valid == 1) {
            // updating into the database
            $statement = $conn->prepare("UPDATE categories SET category_name=? WHERE category_id=?");
            $statement->execute(array($_POST['name'], $_REQUEST['id']));

            $success_message = 'Category is updated successfully.';
        }
    }
?>

<?php
    if (!isset($_REQUEST['id'])) {
        header('location: logout.php');
        exit;
    } else {
        // Check the id is valid or not
        $statement = $conn->prepare("SELECT * FROM categories WHERE category_id=?");
        $statement->execute(array($_REQUEST['id']));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($total == 0) {
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
                <li class="breadcrumb-item"><a href="Category.php">Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
            </ol>
        </nav>
    </div>
</div>

<?php							
foreach ($result as $row) {
	$category_name = $row['category_name'];
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

<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-edit text-primary"></i> Edit Category
                    </h4>
                    <a href="category.php" class="btn btn-outline-primary">
                        <i class="feather-list"></i>
                    </a>
                </div>
                <hr>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" name="name" id="" value="<?php echo $category_name; ?>" class="form-control" required>
                    </div>

                    <button class="btn btn-primary" name="editCat">Update Category</button>


                </form>


            </div>
        </div>
    </div>

</div>

<?php include "template/footer.php"; ?>
<script>
    $("#description").summernote({
        placeholder: 'Hello Bootstrap 4',
        tabsize: 2,
        height: 500,

    });
</script>