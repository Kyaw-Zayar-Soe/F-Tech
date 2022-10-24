<?php

	$statement = $conn->prepare("SELECT * FROM categories");
	$statement->execute();
	$total_categories = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM products");
	$statement->execute();
	$total_products = $statement->rowCount();


	$statement = $conn->prepare("SELECT * FROM customers");
	$statement->execute();
	$total_customers = $statement->rowCount();

?>
<div class="col-12 col-lg-3 col-xl-2 vh-100 sidebar">
    <div class="d-flex justify-content-between align-items-center py-2 mt-3 nav-brand">
        <div class="d-flex align-items-center">
                    <span class="bg-dark p-2 rounded d-flex justify-content-center align-items-center mr-2">
                        <i class="feather-feather text-white h4 mb-0"></i>
                    </span>
            <span class="font-weight-bolder h4 mb-0 text-uppercase text-dark">F-tech</span>
        </div>
        <button class="hide-sidebar-btn btn btn-light d-block d-lg-none">
            <i class="feather-x text-dark" style="font-size: 2em;"></i>
        </button>
    </div>
    <div class="nav-menu">
        <ul>
        <li class="menu-spacer"></li>

            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>index.php" class="menu-item-link">
                    <span>
                        <i class="feather-home"></i>
                        Dashboard
                    </span>
                </a>
            </li>


            <li class="menu-title">
                <span>Manage</span>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>category.php" class="menu-item-link">
                    <span>
                        <i class="feather-layers"></i>
                            Manage Category
                    </span>
                    <span class="badge badge-pill bg-white shadow-sm text-primary p-1">
                        <?php echo $total_categories; ?>
                    </span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>category_add.php" class="menu-item-link">
                    <span>
                        <i class="feather-layers"></i>
                            New Category
                    </span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>product.php" class="menu-item-link">
                            <span>
                                <i class="feather-list"></i>
                                    Manage Product
                            </span>
                    <span class="badge badge-pill bg-white shadow-sm text-primary p-1">
                        <?php echo $total_products; ?>
                    </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>product_add.php" class="menu-item-link">
                            <span>
                                <i class="feather-list"></i>
                                    New Product
                            </span>
                </a>
            </li>
            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>order.php" class="menu-item-link">
                            <span>
                                <i class="feather-list"></i>
                                    Manage Order
                            </span>
                </a>
            </li>
            <li class="menu-spacer"></li>

            
            <li class="menu-title">
                <span>Setting</span>
            </li>

            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>region_setting.php" class="menu-item-link ">
                            <span>
                                <i class="feather-plus-circle"></i>
                                 Shipping cost 
                            </span>
                </a>
            </li>
            
            <li class="menu-item">
                <a href="<?php echo $url.'/'.ADMIN_URL; ?>customer.php" class="menu-item-link ">
                            <span>
                                <i class="feather-users"></i>
                                 customer Manager 
                            </span>
                    <span class="badge badge-pill bg-white shadow-sm text-primary p-1">
                        <?php echo $total_customers; ?>
                    </span>
                </a>
            </li>             
            <li class="menu-spacer"></li>
            
            <li class="menu-item">
                <a href="logout.php" class="btn btn-secondary w-100">
                            <span>
                                <i class="feather-log-out"></i>
                                Logout
                            </span>
                </a>
            </li>

        </ul>

    </div>
</div>