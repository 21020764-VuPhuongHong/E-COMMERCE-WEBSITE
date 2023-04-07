<?php require_once('header.php'); ?>

    <div id="left" class="span3">

        <ul id="menu-group-1" class="nav menu">
            <?php
                $i=0;
                $statement = $pdo->prepare("SELECT tcat_id, tcat_name FROM tbl_top_category WHERE show_on_menu=1");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $i++;
                    ?>
                    <li class="cat-level-1 deeper parent">
                        <a class="" href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category">
                            <span data-toggle="collapse" data-parent="#menu-group-1" href="#cat-lvl1-id-<?php echo $i; ?>" class="sign"><i class="fa fa-plus"></i></span>
                            <span class="lbl"><?php echo $row['tcat_name']; ?></span>                      
                        </a>
                        <ul class="children nav-child unstyled small collapse" id="cat-lvl1-id-<?php echo $i; ?>">
                            
                        </ul>
                    </li>
                    <?php
                }
            ?>
        </ul>

    </div>