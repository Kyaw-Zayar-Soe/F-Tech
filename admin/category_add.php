<?php include "template/header.php"; ?>

<?php
if (isset($_POST['addCat'])) {
    $valid = 1;

    if (empty($_POST['name'])) {
        $valid = 0;
        $error_message .= "Category Name can not be empty<br>";
    } else {
        // Duplicate Category checking
        $statement = $conn->prepare("SELECT * FROM categories WHERE category_name=?");
        $statement->execute(array($_POST['name']));
        $total = $statement->rowCount();
        if ($total) {
            $valid = 0;
            $error_message .= "Category Name already exists<br>";
        }
    }

    if ($valid == 1) {

        // Saving data into the main table tbl_top_category
        $statement = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $statement->execute(array($_POST['name']));

        $success_message = 'Category is added successfully.';
    }
}
?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="Category.php">Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Category</li>
            </ol>
        </nav>
    </div>
</div>

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
                        <i class="feather-plus-circle text-primary"></i> Create New Category
                    </h4>
                    <a href="category.php" class="btn btn-outline-primary">
                        <i class="feather-list"></i>
                    </a>
                </div>
                <hr>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="">Category Name</label>
                        <input type="text" name="name" id="" class="form-control" required>
                    </div>

                    <button class="btn btn-primary" name="addCat">Add Category</button>


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