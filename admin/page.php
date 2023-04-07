<?php require_once('header.php'); ?>

<?php

if(isset($_POST['form_about'])) {
    
    $valid = 1;

    if(empty($_POST['about_title'])) {
        $valid = 0;
        $error_message .= 'Tiêu đề không được để trống<br>';
    }

    if(empty($_POST['about_content'])) {
        $valid = 0;
        $error_message .= 'Nội dung không được để trống<br>';
    }

    if($valid == 1) {
        // updating the database
        $statement = $pdo->prepare("UPDATE tbl_page SET about_title=?,about_content=? WHERE id=1");
        $statement->execute(array($_POST['about_title'],$_POST['about_content']));
        $success_message = 'Thông tin về Trang được cập nhật thành công.'; 
    }
    
}


?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Giới thiệu</h1>
    </div>
</section>

<?php
$statement = $pdo->prepare("SELECT about_title,about_content  FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $about_title = $row['about_title'];
    $about_content = $row['about_content'];
}
?>


<section class="content" style="min-height:auto;margin-bottom: -30px;">
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
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="tab-pane active" id="tab_1">
                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="box box-info">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Tiêu đề* </label>
                            <div class="col-sm-5">
                                <input class="form-control" type="text" name="about_title" value="<?php echo $about_title; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Nội dung * </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="about_content" id="editor1"><?php echo $about_content; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" class="btn btn-success pull-left" name="form_about">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
    </div>
</section>

<?php require_once('footer.php'); ?>