<?php require_once('template/header.php'); ?>

<?php
// Preventing the direct access of this page.
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $conn->prepare("SELECT * FROM brands WHERE brand_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if ($total == 0) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

// // Delete from category
$statement = $conn->prepare("DELETE FROM brands WHERE brand_id=?");
$statement->execute(array($_REQUEST['id']));

header('location: brand.php');
?>