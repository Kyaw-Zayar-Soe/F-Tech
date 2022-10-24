<?php require "template/header.php"; ?>
<?php

// Check if the product is valid or not
if( !isset($_REQUEST['id']) ) {
    header('location: cart.php');
    exit;
}

$i=0;
foreach($_SESSION['cart_product_id'] as $key => $value) {
    $i++;
    $arr_cart_product_id[$i] = $value;
}



$i=0;
foreach($_SESSION['cart_product_quantity'] as $key => $value) {
    $i++;
    $arr_cart_product_quantity[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_product_current_price'] as $key => $value) {
    $i++;
    $arr_cart_product_current_price[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_product_name'] as $key => $value) {
    $i++;
    $arr_cart_product_name[$i] = $value;
}

$i=0;
foreach($_SESSION['cart_product_photo'] as $key => $value) {
    $i++;
    $arr_cart_product_photo[$i] = $value;
}

unset($_SESSION['cart_product_id']);
unset($_SESSION['cart_product_quantity']);
unset($_SESSION['cart_product_current_price']);
unset($_SESSION['cart_product_name']);
unset($_SESSION['cart_product_photo']);

$k=1;
for($i=1;$i<=count($arr_cart_product_id);$i++) {
    if( ($arr_cart_product_id[$i] == $_REQUEST['id']) ) {
        continue;
    } else {
        $_SESSION['cart_product_id'][$k] = $arr_cart_product_id[$i];
        $_SESSION['cart_product_quantity'][$k] = $arr_cart_product_quantity[$i];
        $_SESSION['cart_product_current_price'][$k] = $arr_cart_product_current_price[$i];
        $_SESSION['cart_product_name'][$k] = $arr_cart_product_name[$i];
        $_SESSION['cart_product_photo'][$k] = $arr_cart_product_photo[$i];
        $k++;
    }
}
header('location: cart.php');
?>