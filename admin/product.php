<?php include "template/header.php"; ?>


<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product List</li>
            </ol>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-list text-primary"></i> Product List
                    </h4>
                    <div class="">
                        <a href="product_add.php" class="btn btn-outline-primary">
                            <i class="feather-plus-circle"></i>
                        </a>
                        <a href="#" class="btn btn-outline-secondary full-screen-btn">
                            <i class="feather-maximize-2"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover mt-3 mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Product Name</th>
                                <th>Old Price</th>
                                <th>Current Price</th>
                                <th>Quantity</th>
                                <th>Title</th>
                                <th>Viewer</th>
                                <th>Control</th>
                                <th>Created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $conn->prepare("SELECT
														
														p.product_id,
														p.product_name,
														p.product_old_price,
														p.product_current_price,
														p.quantity,
														p.photo,
                                                        p.category_id,
                                                        p.created_at,
                                                        c.category_id,
														c.category_name

							                           	FROM products p
							                           	JOIN categories c
							                           	ON p.category_id = c.category_id
							                           	
							                           	");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr>
                                    <td class="text-nowrap"><?php echo $i; ?></td>
                                    <td class="text-nowrap" style="width:82px;"><img src="../assets/uploads/<?php echo $row['photo']; ?>" alt="<?php echo $row['product_name']; ?>" style="width:100px;height:100px;border-radius:5px;"></td>
                                    <td class="text-nowrap"><?php echo $row['product_name']; ?></td>
                                    <td class="text-nowrap">$<?php echo $row['product_old_price']; ?></td>
                                    <td class="text-nowrap">$<?php echo $row['product_current_price']; ?></td>
                                    <td class="text-nowrap"><?php echo $row['quantity']; ?></td>
                                    <td class="text-nowrap"><?php echo $row['category_name']; ?></td>
                                    <td class="text-nowrap">
                                        <?php 
                                            $statement = $conn->prepare("SELECT * FROM viewers WHERE product_id =?");
                                            $statement->execute(array($row['product_id']));
                                            $total = $statement->rowCount();
                                            echo $total;
                                        ?>
                                    </td>

                                    <td class="text-nowrap">
                                        <a href="product_detail.php?id=<?php echo $row['product_id'] ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="feather-info fa-fw"></i></a>

                                        <a href="#" data-href="product_delete.php?id=<?php echo $row['product_id'] ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-outline-danger btn-sm">
                                            <i class="feather-trash-2 fa-fw"></i></a>

                                        <a href="product_edit.php?id=<?php echo $row['product_id'] ?>" class="btn btn-outline-warning btn-sm">
                                            <i class="feather-edit-2 fa-fw"></i></a>

                                    </td>
                                    <td class="text-nowrap"><?php echo showTime($row['created_at']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
                <p style="color:red;">Be careful!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok text-white" href="product_delete.php?id=<?php echo $row['product_id'] ?>">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>
<script>
    $(".table").dataTable({
        "order": [
            [0, "desc"]
        ]
    });
</script>