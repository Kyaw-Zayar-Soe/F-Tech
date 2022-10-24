<?php include "template/header.php"; ?>

<?php
if(isset($_POST['update'])) {

	if($_SESSION['user']['role'] == 'Admin') {

		$valid = 1;

	    if(empty($_POST['name'])) {
	        $valid = 0;
	        $error_message .= "Name can not be empty<br>";
	    }

	    if(empty($_POST['email'])) {
	        $valid = 0;
	        $error_message .= 'Email address can not be empty<br>';
	    } else {
	    	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
		        $valid = 0;
		        $error_message .= 'Email address must be valid<br>';
		    } else {
		    	// current email address that is in the database
		    	$statement = $conn->prepare("SELECT * FROM admin WHERE id=?");
				$statement->execute(array($_SESSION['user']['id']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $row) {
					$current_email = $row['email'];
				}

		    	$statement = $conn->prepare("SELECT * FROM admin WHERE email=? and email!=?");
		    	$statement->execute(array($_POST['email'],$current_email));
		    	$total = $statement->rowCount();							
		    	if($total) {
		    		$valid = 0;
		        	$error_message .= 'Email address already exists<br>';
		    	}
		    }
	    }

	    if($valid == 1) {
			
			$_SESSION['user']['name'] = $_POST['name'];
	    	$_SESSION['user']['email'] = $_POST['email'];

			// updating the database
			$statement = $conn->prepare("UPDATE admin SET name=?, email=?, phone=? WHERE id=?");
			$statement->execute(array($_POST['name'],$_POST['email'],$_POST['phone'],$_SESSION['user']['id']));

	    	$success_message = 'User Information is updated successfully.';
	    }

        if( empty($_POST['password']) || empty($_POST['rpassword']) ) {
            $valid = 0;
            $error_message .= "Password can not be empty<br>";
        }
    
        if( !empty($_POST['password']) && !empty($_POST['rpassword']) ) {
            if($_POST['password'] != $_POST['rpassword']) {
                $valid = 0;
                $error_message .= "Passwords do not match<br>";	
            }        
        }
    
        if($valid == 1) {
    
            $_SESSION['user']['password'] = md5($_POST['password']);
    
            // updating the database
            $statement = $conn->prepare("UPDATE admin SET password=? WHERE id=?");
            $statement->execute(array(md5($_POST['password']),$_SESSION['user']['id']));
    
            $success_message = 'User Password is updated successfully.';
        }

        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if($path!='') {
            $ext = pathinfo( $path, PATHINFO_EXTENSION );
            $file_name = basename( $path, '.' . $ext );
            if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
                $valid = 0;
                $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
            }
        }

        if($valid == 1) {

            // removing the existing photo
            if($_SESSION['user']['photo']!='') {
                unlink('../assets/uploads/'.$_SESSION['user']['photo']);	
            }

            // updating the data
            $final_name = 'user-'.$_SESSION['user']['id'].'.'.$ext;
            move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
            $_SESSION['user']['photo'] = $final_name;

            // updating the database
            $statement = $conn->prepare("UPDATE admin SET photo=? WHERE id=?");
            $statement->execute(array($final_name,$_SESSION['user']['id']));

            $success_message = 'User Photo is updated successfully.';
            
    }

	}
	else {
		$_SESSION['user']['phone'] = $_POST['phone'];

		// updating the database
		$statement = $conn->prepare("UPDATE admin SET phone=? WHERE id=?");
		$statement->execute(array($_POST['phone'],$_SESSION['user']['id']));

		$success_message = 'User Information is updated successfully.';	
	}
}


?>

<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-4">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</div>

<?php
    $statement = $conn->prepare("SELECT * FROM admin WHERE id=?");
    $statement->execute(array($_SESSION['user']['id']));
    $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
    foreach ($result as $row) {
        $name = $row['name'];
        $email     = $row['email'];
        $phone     = $row['phone'];
        $photo     = $row['photo'];
        $role      = $row['role'];
    }
?>

<form class="row" method="post" enctype="multipart/form-data">
    <div class="col-12 col-xl-8">
        <div class="card mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="feather-user-check text-primary"></i> Profile List
                    </h4>
                    <div class="">
                        <a href="#" class="btn btn-outline-secondary full-screen-btn">
                            <i class="feather-maximize-2"></i>
                        </a>
                    </div>
                </div>

                <hr>

                    <div class="form-group">
                        <label for="">User Name : </label>
                        <?php
                            if($_SESSION['user']['role'] == 'Admin') {
                        ?>
                            <input type="text" name="name" id="" class="form-control" value="<?php echo $name; ?>" required>
                        <?php
                            } else {
                        ?>
                            <?php echo $name; ?>
                        <?php
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="">Email : </label>
                        <?php
                            if($_SESSION['user']['role'] == 'Admin') {
                        ?>
                            <input type="email" name="email" id="" class="form-control" value="<?php echo $email; ?>" required>
                        <?php
                            } else {
                        ?>
                            <?php echo $email; ?>
                        <?php
                            }
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="">phone : </label>
                        <input type="text" name="phone" id="" class="form-control" value="<?php echo $phone; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" name="password" id="" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="">Retype-Password</label>
                        <input type="password" name="rpassword" id="" class="form-control" required>
                    </div>

            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">
                     <h4 class="mb-0">
                        <i class="feather-user-check text-primary"></i> Profile List
                     </h4>
                     <a href="#" class="btn btn-outline-secondary full-screen-btn">
                            <i class="feather-maximize-2"></i>
                     </a>
                </div>
                    <hr>
                    <div class="form-group">
                        <label for="">Role : </label>
                            <?php echo $role; ?>
                    </div>

                    <div class="form-group">
                        <div class="">
                            <img src="../assets/uploads/<?php echo $photo;?>" style="width:150px;" alt="">
                        </div>
                        <label for="">Choose Photo</label>
                        <div class="custom-file mb-2">
                            <input type="file" class="custom-file-input" id="customFile" name="photo" required>
                            <label class="custom-file-label" for="customFile">..........</label>
                        </div>
                    </div>

                    <hr>
                    <button class="btn btn-primary" name="update">Update</button>             
            </div>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>
</div>



<?php include "template/footer.php"; ?>
