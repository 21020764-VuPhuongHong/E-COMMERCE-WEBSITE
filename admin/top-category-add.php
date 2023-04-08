<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['tcat_name'])) {
        $valid = 0;
        $error_message .= "Top Category Name can not be empty<br>";
    } else {
    	// Duplicate Category checking
    	$statement = $pdo->prepare("SELECT tcat_name FROM tbl_top_category WHERE tcat_name=?");
    	$statement->execute(array($_POST['tcat_name']));
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Top Category Name already exists<br>";
    	}
    }

    if($valid == 1) {

		// Saving data into the main table tbl_top_category
		$statement = $pdo->prepare("set foreign_key_checks=0;INSERT INTO tbl_top_category (tcat_name,show_on_menu) VALUES (?,?)");
		$statement->execute(array($_POST['tcat_name'],$_POST['show_on_menu']));
	
    	$success_message = 'Top Category is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Thêm danh mục</h1>
	</div>
	<div class="content-header-right">
		<a href="top-category.php" class="btn btn-primary btn-sm">Quay lại</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tên danh mục <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="tcat_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Hiển thị trên menu <span>*</span></label>
							<div class="col-sm-4">
								<select name="show_on_menu" class="form-control" style="width:auto;">
									<option value="0">Không</option>
									<option value="1">Có</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Hoàn thành</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>