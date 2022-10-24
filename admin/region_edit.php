<?php include "template/header.php" ?>
<?php
            // updating into the database
            $statement = $conn->prepare("UPDATE region SET region_name=?,amount=? WHERE region_id=?");
            $statement->execute(array($_POST['name'],$_POST['amount'],$_POST['ii']));

            $success_message = 'Information are updated successfully.';
            header('location: region_setting.php');
?>
