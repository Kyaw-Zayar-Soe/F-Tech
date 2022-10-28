<?php 
ob_start();
session_start();
include './admin/inc/config.php';
unset($_SESSION['customer']);
unset($_SESSION['cart_product_id']);
unset($_SESSION['cart_product_quantity']);
unset($_SESSION['cart_product_current_price']);
unset($_SESSION['cart_product_name']);
unset($_SESSION['cart_product_photo']);
header("location: ".BASE_URL.'login.php'); 
?>