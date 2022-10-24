<?php include "template/header.php"; ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $conn->prepare("SELECT * FROM customers WHERE customer_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

	// Delete from customer
	$statement = $conn->prepare("DELETE FROM customers WHERE customer_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: customer.php');
?>