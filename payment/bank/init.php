<?php
ob_start();
session_start();
include("../../admin/inc/config.php");
include("../../admin/inc/functions.php");
// Getting all language variables into array as global variable
$i=1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	define('LANG_VALUE_'.$i,$row['lang_value']);
	$i++;
}
?>
<?php
if( !isset($_REQUEST['msg']) ) {
	if(empty($_POST['transaction_info'])) {
		header('location: ../../checkout.php');
	} else {
		$payment_date = date('Y-m-d H:i:s');
	    $payment_id = time();

	    $statement = $pdo->prepare("set foreign_key_checks=0;INSERT INTO tbl_payment (   
	                            customer_id,
	                            customer_name,
	                            customer_email,
	                            payment_date,
	                            txnid, 
	                            paid_amount,
	                            card_number,
	                            card_cvv,
	                            card_month,
	                            card_year,
	                            bank_transaction_info,
	                            payment_method,
	                            payment_status,
	                            shipping_status,
	                            payment_id
	                        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	    $statement->execute(array(
	                            $_SESSION['customer']['cust_id'],
	                            $_SESSION['customer']['cust_name'],
	                            $_SESSION['customer']['cust_email'],
	                            $payment_date,
	                            '',
	                            $_POST['amount'],
	                            '', 
	                            '',
	                            '', 
	                            '',
	                            $_POST['transaction_info'],
	                            'Bank Deposit',
	                            'Pending',
	                            'Pending',
	                            $payment_id
	                        ));

		$statement = $pdo->prepare("SELECT t1.p_id, t1.size, t1.color, t1.p_quantity,  t2.p_name, t2.p_current_price, t2.p_qty
									FROM tbl_cart t1
									INNER JOIN tbl_product t2
									ON t1.p_id = t2.p_id
									WHERE cust_id = :cust_id");
		$statement->bindParam(':cust_id', $_SESSION['customer']['cust_id']);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row){
			$statement = $pdo->prepare("set foreign_key_checks=0; INSERT INTO tbl_order (
				product_id,
				product_name,
				size, 
				color,
				quantity, 
				unit_price, 
				payment_id
				) 
				VALUES (:p_id, :p_name, :size, :color, :p_quantity, :p_current_price, :payment_id)");
			$statement->bindParam(':p_id', $row['p_id']);
			$statement->bindParam(':p_name', $row['p_name']);
			$statement->bindParam(':size', $row['size']);
			$statement->bindParam(':color', $row['color']);
			$statement->bindParam(':p_quantity', $row['p_quantity']);
			$statement->bindParam(':p_current_price', $row['p_current_price']);
			$statement->bindParam(':payment_id', $payment_id);
			$statement->execute();
			
			//update quantity product
            $statement = $pdo->prepare("set foreign_key_checks=0;UPDATE tbl_product SET p_qty=:p_qty WHERE p_id=:p_id");
			$quantity = $row['p_qty'] - $row['p_quantity'];
			$statement->bindParam(':p_qty', $quantity);
			$statement->bindParam(':p_id', $row['p_id']);
            $statement->execute();
		}

	    header('location: ../../payment_success.php');
	}
	$statement = $pdo->prepare("set foreign_key_checks=0;DELETE FROM tbl_cart WHERE cust_id = :cust_id");
	$statement->bindParam(':cust_id', $_SESSION['customer']['cust_id']);
	$statement->execute();

}
?>