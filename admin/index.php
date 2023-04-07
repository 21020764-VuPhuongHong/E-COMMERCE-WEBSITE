<?php require_once('header.php'); ?>

<section class="content-header">
	<h1>Tổng quan</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT tcat_id FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT p_id FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT payment_status FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$total_order_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT shipping_status FROM tbl_payment WHERE shipping_status=?");
$statement->execute(array('Completed'));
$total_shipping_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT payment_status FROM tbl_payment WHERE payment_status=? AND shipping_status=?");
$statement->execute(array('Completed','Pending'));
$total_order_complete_shipping_pending = $statement->rowCount();
?>

<section class="content">
	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-hand-o-right"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Danh mục sản phẩm</span>
					<span class="info-box-number"><?php echo $total_top_category; ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="fa fa-hand-o-right"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Sản phẩm</span>
					<span class="info-box-number"><?php echo $total_product; ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-hand-o-right"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Đơn hàng đã hoàn thành</span>
					<span class="info-box-number"><?php echo $total_order_completed; ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-hand-o-right"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Hoàn thành vận chuyển </span>
					<span class="info-box-number"><?php echo $total_shipping_completed; ?></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="fa fa-hand-o-right"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">Đơn hàng chờ vận chuyển</span>
					<span class="info-box-number"><?php echo $total_order_complete_shipping_pending; ?></span>
				</div>
			</div>
		</div>
		
	</div>
</section>

<?php require_once('footer.php'); ?>