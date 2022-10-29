<?php include "template/header.php"; ?>



<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Category List</li>
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
                        <i class="feather-layers text-primary"></i> Category List
                    </h4>
                    <div class="">
                        <a href="category_add.php" class="btn btn-outline-primary">
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
                                <th>Category</th>
                                <th>Control</th>
                                <th>Created_at</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $statement = $conn->prepare("SELECT * FROM categories");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $i++;
                            ?>
                                <tr>
                                    <td class="text-nowrap"><?php echo $i; ?></td>
                                    <td class="text-nowrap"><?php echo $row['category_name']; ?></td>

                                    <td class="text-nowrap">

                                        <a href="#" data-href="category_delete.php?id=<?php echo $row['category_id']; ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-outline-danger btn-sm">
                                            <i class="feather-trash-2 fa-fw"></i></a>

                                        <a href="category_edit.php?id=<?php echo $row['category_id'] ?>" class="btn btn-outline-warning btn-sm">
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
                <a class="btn btn-danger text-white btn-ok">Delete</a>
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