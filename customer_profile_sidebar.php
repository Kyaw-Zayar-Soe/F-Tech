     <nav class="col-2 col-xl-3 shadow-sm rounded-left bg-dark pr-3" style="height:500px ;">
            <!-- Admin Name -->
        <h1 class="h4 py-3 text-center text-primary">
            <i class="fas fa-shopping-cart mr-2"></i>
            <span class="d-none d-lg-inline text-uppercase">Hello welcome</span>
        </h1>
                <!-- Nav list -->
        <div class="list-group text-center text-lg-left custom">
            <span class="list-group-item disabled text-center d-none mb-2 d-lg-block rounded" style="background-color:#d0d0dc ;">
                <small class="font-weight-bold text-muted h5">CONTROLS</small>
            </span>
            <a href="<?php echo $url; ?>/dashboard.php" class="post list-group-item mb-2 list-group-item-action menu-link rounded">
                <i class="fas fa-home"></i>
                <span class="d-none d-lg-inline">Dashboard</span>
            </a>
            <a href="<?php echo $url; ?>/customer_profile.php" class="post mb-2 list-group-item list-group-item-action menu-link rounded">
                <i class="fas fa-user"></i>
                <span class="d-none d-lg-inline">Manage Profile</span>
            </a>
            <a href="<?php echo $url; ?>/customer_billing_shipping_info.php" class="post mb-2 list-group-item list-group-item-action menu-link rounded ">
                <i class="fas fa-map-marker-alt"></i>
                <span class="d-none d-lg-inline">Manage Address Info</span>
            </a>
            <a href="<?php echo $url; ?>/customer_order.php" class="post mb-2 list-group-item list-group-item-action menu-link rounded ">
                <i class="fas fa-shopping-bag"></i>
                <span class="d-none d-lg-inline">Orders</span>
            </a>
        </div>

        <div class="list-group text-center text-lg-left mt-4 mb-3 custom">
            <a href="logout.php" class="btn btn-white rounded post mt-2 w-100 list-group-item ">
                <i class="feather-log-out font-weight-bold"></i>
                <span class="d-none d-lg-inline font-weight-bold">
                Logout
                </span>
            </a>
        </div>
    </nav> 

