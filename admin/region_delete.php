<?php include "template/header.php"; ?>


<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $conn->prepare("SELECT * FROM region WHERE region_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Delete from region
	$statement = $conn->prepare("DELETE FROM region WHERE region_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: region_setting.php');
?>