<?php
	if(isset($_POST['add'])) {
		$valid = 1;

		if(empty($_POST['name'])) {
			$valid = 0;
			$error_message .= "Brand Name can not be empty<br>";
		} else {
			// Duplicate Category checking
			$statement = $conn->prepare("SELECT * FROM brands WHERE brand_name=?");
			$statement->execute(array($_POST['name']));
			$total = $statement->rowCount();
			if($total)
			{
				$valid = 0;
				$error_message .= "Brand Name already exists<br>";
			}
		}

		if($valid == 1) {

			// Saving data into the main table region
			$statement = $conn->prepare("INSERT INTO brands (brand_name) VALUES (?)");
			$statement->execute(array($_POST['name']));
		
			$success_message = 'Brand Name is added successfully.';

		}
	}
?>
<div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="feather-plus-circle"></i> Create Brand</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <form class="row" method="post">
                    <div class="form-group col-12">
                        <label for="">Brand Name :</label>
                        <input type="text" name="name" id="" class="form-control" required>
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




