<?php
	if(isset($_POST['add'])) {
		$valid = 1;

		if(empty($_POST['name'])) {
			$valid = 0;
			$error_message .= "Country Name can not be empty<br>";
		} else {
			// Duplicate Category checking
			$statement = $conn->prepare("SELECT * FROM region WHERE region_name=?");
			$statement->execute(array($_POST['name']));
			$total = $statement->rowCount();
			if($total)
			{
				$valid = 0;
				$error_message .= "Region Name already exists<br>";
			}
		}

        if($_POST['amount'] == '') {
            $valid = 0;
            $error_message .= 'Amount can not be empty.<br>';
        } else {
            if(!is_numeric($_POST['amount'])) {
                $valid = 0;
                $error_message .= 'You must have to enter a valid number.<br>';
            }
        }

		if($valid == 1) {

			// Saving data into the main table region
			$statement = $conn->prepare("INSERT INTO region (region_name,amount) VALUES (?,?)");
			$statement->execute(array($_POST['name'],$_POST['amount']));
		
			$success_message = 'Region and shipping cost is added successfully.';

		}
	}
?>
<div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="feather-plus-circle"></i> Create New Region</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
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
                    <div class="form-group col-12 col-md-6">
                        <label for="">Region Name :</label>
                        <input type="text" name="name" id="" class="form-control" required>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="">Amount :</label>
                        <input type="text" name="amount" id="" class="form-control" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" name="add">Add</button>

            </div>
                </form>
        </div>
    </div>
</div>




