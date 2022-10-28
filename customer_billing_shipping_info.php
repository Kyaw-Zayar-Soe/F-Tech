<?php require "template/header.php"; ?>


<?php
    // Check if the customer is logged in or not
    if(!isset($_SESSION['customer'])) {
            header('location: '.BASE_URL.'logout.php');
            exit;
        } else {
            $statement = $conn->prepare("SELECT * FROM customers WHERE customer_id=?");
            $statement->execute(array($_SESSION['customer']['customer_id']));
            $total = $statement->rowCount();
        }
?>

<?php
    if (isset($_POST['update'])) {


        // update data into the database
        $statement = $conn->prepare("UPDATE customers SET 
                                customer_b_name=?, 
                                customer_b_phone=?, 
                                customer_b_address=?, 
                                customer_b_region=?, 
                                customer_b_city=?, 
                                customer_b_township=?, 
                                customer_b_zip=?,
                                customer_s_name=?, 
                                customer_s_phone=?, 
                                customer_s_address=?, 
                                customer_s_region=?, 
                                customer_s_city=?, 
                                customer_s_township=?, 
                                customer_s_zip=?

                                WHERE customer_id=?");
        $statement->execute(array(
                                strip_tags($_POST['bname']),
                                strip_tags($_POST['bphone']),
                                strip_tags($_POST['baddress']),
                                strip_tags($_POST['bregion']),
                                strip_tags($_POST['bcity']),
                                strip_tags($_POST['btownship']),
                                strip_tags($_POST['bzip']),
                                strip_tags($_POST['sname']),
                                strip_tags($_POST['sphone']),
                                strip_tags($_POST['saddress']),
                                strip_tags($_POST['sregion']),
                                strip_tags($_POST['scity']),
                                strip_tags($_POST['stownship']),
                                strip_tags($_POST['szip']),
                                $_SESSION['customer']['customer_id']
                            ));  
    
        $success_message = "Billing and Shipping Information is updated successfully.";

        $_SESSION['customer']['customer_b_name'] = strip_tags($_POST['bname']);
        $_SESSION['customer']['customer_b_phone'] = strip_tags($_POST['bphone']);
        $_SESSION['customer']['customer_b_address'] = strip_tags($_POST['baddress']);
        $_SESSION['customer']['customer_b_region'] = strip_tags($_POST['bregion']);
        $_SESSION['customer']['customer_b_city'] = strip_tags($_POST['bcity']);
        $_SESSION['customer']['customer_b_township'] = strip_tags($_POST['btownship']);
        $_SESSION['customer']['customer_b_zip'] = strip_tags($_POST['bzip']);
        $_SESSION['customer']['customer_s_name'] = strip_tags($_POST['sname']);
        $_SESSION['customer']['customer_s_phone'] = strip_tags($_POST['sphone']);
        $_SESSION['customer']['customer_s_address'] = strip_tags($_POST['saddress']);
        $_SESSION['customer']['customer_s_region'] = strip_tags($_POST['sregion']);
        $_SESSION['customer']['customer_s_city'] = strip_tags($_POST['scity']);
        $_SESSION['customer']['customer_s_township'] = strip_tags($_POST['stownship']);
        $_SESSION['customer']['customer_s_zip'] = strip_tags($_POST['szip']);

    }
?>
<div class="container mt-3 rounded-lg">
    <div class="row">
                   <?php include "customer_profile_sidebar.php";?>

        <div class="col-xl-9 bg-white shadow-lg col-10 ">
            <div class="card rounded mt-4 mb-4">
                <div class="card-body">
                <?php
                    if($error_message != '') {
                        echo '<div class="error alert alert-warning">' . $error_message . '</div>';
                    }
                    if($success_message != '') {
                        echo '<div class="success alert alert-warning">' . $success_message . '</div>';
                    }
                ?>
                <form action="" method="post" class="">
                <?php $csrf->echoInputField(); ?> 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="h4">Billing Address</div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="h4">Shipping Address</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Full Name :</label>
                            <input type="text" name="bname" id="" value="<?php echo $_SESSION['customer']['customer_b_name']; ?>" class="form__input form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Full Name :</label>
                            <input type="text" name="sname" id="" value="<?php echo $_SESSION['customer']['customer_s_name']; ?>" class="form__input form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Phone No :</label>
                            <input type="text" name="bphone" id="" value="<?php echo $_SESSION['customer']['customer_b_phone']; ?>" class="form__input form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Phone No :</label>
                            <input type="text" name="sphone" id="" value="<?php echo $_SESSION['customer']['customer_s_phone']; ?>" class="form__input form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Address :</label>
                            <textarea name="baddress" class="form-control form__input" cols="30" rows="10" style="height:70px;" required><?php echo $_SESSION['customer']['customer_b_address']; ?></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Address :</label>
                            <textarea name="saddress" class="form-control form__input" cols="30" rows="10" style="height:70px;" required><?php echo $_SESSION['customer']['customer_s_address']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Region :</label>
                                <select name="bregion" class="form-control" >
                                <option value="0" selected disabled>Select Region</option>
                                    <?php
                                        $statement = $conn->prepare("SELECT * FROM region");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['region_id']; ?>" <?php if($row['region_id'] == $_SESSION['customer']['customer_b_region']) {echo 'selected';} ?>><?php echo $row['region_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            <!-- <input type="text" name="bregion" id="" value="" class="form__input form-control" > -->
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Region :</label>
                                <select name="sregion" class="form-control" >
                                    <option value="0" selected disabled>Select Region</option>
                                    <?php
                                        $statement = $conn->prepare("SELECT * FROM region");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['region_id']; ?>" <?php if($row['region_id'] == $_SESSION['customer']['customer_s_region']) {echo 'selected';} ?>><?php echo $row['region_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> City :</label>
                            <input type="text" name="bcity" id="" value="<?php echo $_SESSION['customer']['customer_b_city']; ?>" class="form__input form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> City :</label>
                            <input type="text" name="scity" id="" value="<?php echo $_SESSION['customer']['customer_s_city']; ?>" class="form__input form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Township :</label>
                            <input type="text" name="btownship" id="" value="<?php echo $_SESSION['customer']['customer_b_township']; ?>" class="form__input form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for=""><i class="feather-mail text-primary"></i> Township :</label>
                            <input type="text" name="stownship" id="" value="<?php echo $_SESSION['customer']['customer_s_township']; ?>" class="form__input form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Zip Code :</label>
                                <input type="text" class="form__input form-control" name="bzip" value="<?php echo $_SESSION['customer']['customer_b_zip']; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                                <label for=""><i class="feather-mail text-primary"></i> Zip Code :</label>
                                <input type="text" class="form__input form-control" name="szip" value="<?php echo $_SESSION['customer']['customer_s_zip']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group pt-2 mb-0">
                        <button class="btn btn-primary rounded" name="update">Update</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php require "template/footer.php"; ?>
