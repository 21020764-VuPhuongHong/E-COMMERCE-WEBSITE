<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT banner_cart FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_cart = $row['banner_cart'];
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_cart; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1>Giỏ hàng</h1>
    </div>
</div>

<div class="page">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

                
                <form action="" method="post">
                    <?php $csrf->echoInputField(); ?>
				<div class="cart">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th><!--<?php echo LANG_VALUE_7; ?>-->STT</th>
                                <th><!--<?php echo LANG_VALUE_8; ?>-->Hình ảnh</th>
                                <th><!--<?php echo LANG_VALUE_47; ?>-->Tên sản phẩm</th>
                                <th><!--<?php echo LANG_VALUE_157; ?>-->Kích cỡ</th>
                                <th><!--<?php echo LANG_VALUE_158; ?>-->Màu sắc</th>
                                <th><!--<?php echo LANG_VALUE_159; ?>-->Giá</th>
                                <th><!--<?php echo LANG_VALUE_55; ?>-->Số lượng</th>
                                <th class="text-right"><!--<?php echo LANG_VALUE_82; ?>-->Tổng</th>
                                <th class="text-center" style="width: 100px;"><!--<?php echo LANG_VALUE_83; ?>-->Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT                          
                                                        t1.p_id,
                                                        t1.p_name,
                                                        t1.p_current_price,
                                                        t1.p_featured_photo,
                                                        t2.c_id,
                                                        t2.p_quantity,
                                                        t2.size,
                                                        t2.color

                                                        FROM tbl_product t1
                                                        INNER JOIN tbl_cart t2
                                                        ON t1.p_id = t2.p_id
                                                        WHERE cust_id=:cust_id;
                                                        ");
                            $statement->bindParam(':cust_id', $_SESSION['customer']['cust_id']);                            
                            $statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $table_total_price = 0;
							foreach ($result as $row) {
								$i++;
								?>
								<tr>
									<td><?php echo $i; ?></td>
									<td style="width:130px;"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="<?php echo $row['p_name']; ?>" style="width:100px;"></td>
									<td><?php echo $row['p_name']; ?></td>
									<td><?php echo $row['size']; ?></td>
									<td><?php echo $row['color']; ?></td>
									<td><?php echo $row['p_current_price']; ?></td>
									<td><?php echo $row['p_quantity']; ?></td>
									<td class="text-right"><?php echo $row['p_quantity'] * $row['p_current_price']; ?></td>
                                    <td class="text-center">
                                        <a onclick="return confirmDelete();" href="cart-item-delete.php?c_id=<?php echo $row['c_id']; ?>" class="trash"><i class="fa fa-trash"></i></a>
                                    </td>
								</tr>
								<?php
                                $table_total_price += $row['p_quantity'] * $row['p_current_price'];
							}
							?>							
						</tbody>
                        
                        <tr>
                            <th colspan="7" class="total-text">Tổng</th>
                            <th class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $table_total_price; ?></th>
                            <th></th>
                        </tr>
                    </table> 
                </div>

                <div class="cart-buttons">
                    <ul>
                        <li><input type="submit" value="Cập nhật giỏ hàng" class="btn btn-primary" name="form1"></li>
                        <li><a href="index.php" class="btn btn-primary"><!--<?php echo LANG_VALUE_85; ?>-->Tiếp tục mua sắm</a></li>
                        <li><a href="checkout.php" class="btn btn-primary"><!--<?php echo LANG_VALUE_23; ?>-->Đi tới checkout</a></li>
                    </ul>
                </div>
                </form>
                

                

			</div>
		</div>
	</div>
</div>


<?php require_once('footer.php'); ?>