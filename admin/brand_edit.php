<?php include "template/header.php" ?>
<?php
            // updating into the database
            $statement = $conn->prepare("UPDATE brands SET brand_name=? WHERE brand_id=?");
            $statement->execute(array($_POST['name'],$_POST['ii']));

            $success_message = 'Information are updated successfully.';
            header('location: brand.php');
?>
