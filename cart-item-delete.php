<?php require_once('header.php'); ?>

<?php

// Check if the product is valid or not
if( !isset($_REQUEST['c_id']) ) {
    header('location: cart.php');
    exit;
}

$statement = $pdo->prepare("DELETE FROM tbl_cart WHERE c_id = :c_id");
$statement->bindParam(':c_id', $_REQUEST['c_id']);
$statement->execute();

header('location: cart.php');
?>