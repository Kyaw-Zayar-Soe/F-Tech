<?php include "template/header.php"; ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $conn->prepare("SELECT * FROM products WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	// Getting photo ID to unlink from folder
	$statement = $conn->prepare("SELECT * FROM products WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
		unlink('../assets/uploads/'.$photo);
	}



	// Delete from product
	$statement = $conn->prepare("DELETE FROM products WHERE product_id=?");
	$statement->execute(array($_REQUEST['id']));


	header('location: product.php');
?>