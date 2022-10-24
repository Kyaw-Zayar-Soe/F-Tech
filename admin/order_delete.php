<?php require_once('template/header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $conn->prepare("SELECT * FROM payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	} else {
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
		foreach ($result as $row) {
			$payment_id = $row['payment_id'];
			$payment_status = $row['payment_status'];
			$shipping_status = $row['shipping_status'];
		}
	}
}
?>

<?php
	

	// Delete from order
	$statement = $conn->prepare("DELETE FROM orders WHERE payment_id=?");
	$statement->execute(array($payment_id));

	// Delete from payment
	$statement = $conn->prepare("DELETE FROM payment WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: order.php');
?>