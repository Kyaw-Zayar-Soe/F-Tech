<?php include "template/header.php"; ?>

<?php

	$statement = $conn->prepare("SELECT * FROM categories");
	$statement->execute();
	$total_categories = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM brands");
	$statement->execute();
	$total_brands = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM products");
	$statement->execute();
	$total_products = $statement->rowCount();

	$statement = $conn->prepare("SELECT COUNT(id)AS Total FROM viewers WHERE 1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $viewers = $row['Total'];
    }

	$statement = $conn->prepare("SELECT * FROM customers");
	$statement->execute();
	$total_customers = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM region");
	$statement->execute();
	$available_region = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM payment WHERE payment_status=?");
	$statement->execute(array('Completed'));
	$total_order_completed = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM payment WHERE shipping_status=?");
	$statement->execute(array('Completed'));
	$total_shipping_completed = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM payment WHERE payment_status=?");
	$statement->execute(array('Pending'));
	$total_order_pending = $statement->rowCount();

	$statement = $conn->prepare("SELECT * FROM payment WHERE payment_status=? AND shipping_status=?");
	$statement->execute(array('Completed','Pending'));
	$total_order_complete_shipping_pending = $statement->rowCount();
?>

<div class="row">
    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card mb-4 status-card" >
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-eye h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $viewers; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Total Visitor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>product.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-list h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_products; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Total Product</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>category.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-layers h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_categories; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Total Category</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>brand.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-wind h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_brands; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Total Brand</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>customer.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-users h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_customers; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Total Customer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>order.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="fas fa-clipboard-list h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_order_pending; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Pending Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>order.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-check-square h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_order_completed; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Completed Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>region_setting.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-map-pin h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $available_region; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Available Region</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>order.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="feather-truck h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_order_complete_shipping_pending; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Pending Shipping</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card mb-4 status-card" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>order.php')">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="far fa-check-circle h1 text-primary"></i>
                    </div>
                    <div class="col-9">
                        <p class="mb-1 h4 font-weight-bolder">
                            <span class="counter-up"><?php echo $total_shipping_completed; ?></span>
                        </p>
                        <p class="mb-0 text-black-50">Completed Shipping</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-12 col-xl-7">
            <div class="card overflow-hidden shadow mb-4">
                <div class="">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">Order & Viewer</h4>
                        <div class="">
                        </div>
                    </div>
                    <canvas id="ov" height="145"></canvas>

                </div>
            </div>
        </div>

        <div class="col-12 col-md-8 col-xl-5">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">Order / Place</h4>
                        <div class="">
                            <i class="feather-pie-chart h4 mb-0 text-primary"></i>
                        </div>
                    </div>
                    <canvas id="op" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
            <div class="card overflow-hidden mb-4" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>order.php')">
                <div class="">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <p class="mb-0">Order List</p>
                        <div class="">
                            <i class="feather-more-vertical h4 mb-0 text-primary"></i>
                        </div>
                    </div>
                    <table class="table table-hover p-2 rounded mt-3 mb-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Customer Info</th>
                                <th class="text-nowrap">Product</th>
                                <th class="text-nowrap">Amount</th>
                                <th class="text-nowrap">Payment Status</th>
                                <th class="text-nowrap text-center">Method</th>
                                <th class="text-nowrap">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i=0;
                            $statement = $conn->prepare("SELECT * FROM payment ORDER BY id DESC LIMIT 6");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
                            foreach ($result as $row) {
                            $i++;
            		    ?>
                                <tr class="">
                                    <td class="text-center"><?php echo $row['customer_name']; ?><br>
                                        <?php echo $row['customer_email']; ?>
                                    </td>
                                    <td class="text-nowrap">
                                    <?php
                                        $statement1 = $conn->prepare("SELECT * FROM orders WHERE payment_id=?");
                                        $statement1->execute(array($row['payment_id']));
                                        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result1 as $row1) {
                                                echo $row1['product_name'];
                                                echo '<br>$'.$row1['price']."<br>";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-nowrap">$<?php echo $row['paid_amount']; ?></td>
                                    <td class="text-nowrap">
                                        <?php
                                            if($row['payment_status']=='Pending'){
                                        ?>
                                            <a href="#" class="text-decoration-none text-warning"><i class="fas fa-dot-circle fa-xs"></i> <?php echo $row['payment_status']; ?></i></a>
                                        <?php
                                            }else{
                                        ?>
                                            <span class="text-success"><i class="fas fa-dot-circle fa-xs"></i> <?php echo $row['payment_status']; ?></span>
                                        <?php        
                                            }
                                        ?>    
                                    </td>
                                    <td class="text-nowrap" ><img src="./assets/img/paypal.webp"  style="width:90px;height:50px;border-radius:5px;"><?php echo $row['payment_method']; ?></td>

                                    <td class="text-nowrap"><?php echo showTime($row['payment_date']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="card overflow-hidden mb-4" onclick="go('<?php echo $url.'/'.ADMIN_URL; ?>product.php')">
                <div class="">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <p class="mb-0">Product Viewer</p>
                        <div class="">
                            <?php
                            ?>
                            <small>Your products : <?php echo $total_products; ?></small>
                            <div class="progress" style="width: 300px;height: 15px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $total_products; ?>%; " aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover mt-3 mb-0">
                        <thead>
                            <tr>
                                <th>Who</th>
                                <th>Device</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $statement = $conn->prepare("SELECT * FROM viewers ORDER BY id DESC LIMIT 5"); 
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);						
                                foreach ($result as $us) {
                            ?>
                                <tr>
                                    <td class="text-nowrap text-capitalize">
                                        <?php 
                                            if($us['customer_id']==0){
                                                echo "Unknown";
                                            }else{

                                                $statement = $conn->prepare("SELECT customer_name FROM customers WHERE customer_id=?"); 
                                                $statement->execute(array($us['customer_id']));
                                                $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach($result1 as $num){
                                                        echo $num['customer_name'];
                                                    }
                                            }                                                                       
                                        ?></td>
                                    <td ><?php echo $us['device']; ?></td>
                                    <td class="text-nowrap"><?php echo showTime($us['created_at']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php include "template/footer.php"; ?>
<script>
    <?php
        $place = [];
        $order = [];
        $statement = $conn->prepare("SELECT * FROM region");
        $statement->execute();
        $result5 = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result5 as $c){
            array_push($place,$c['region_name']);
            $statement = $conn->prepare("SELECT c.customer_s_region,p.* FROM payment p JOIN customers c ON p.customer_id = c.customer_id WHERE c.customer_s_region=?");
            $statement->execute(array($c['region_id']));
            $result6 = $statement->rowCount();
            array_push($order,$result6);
        }
    ?>
    let placeAry = <?php echo json_encode($place); ?>;
    let countOrder = <?php echo json_encode($order); ?>;

    let op = document.getElementById('op').getContext('2d');
    let opChart = new Chart(op, {
        type: 'doughnut',
        data: {
            labels:placeAry,
            datasets: [{
                label: '# of Votes',
                data:countOrder,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    display:false,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes: [
                    {
                        display:false
                    }
                ]
            },
            legend:{
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#333',
                    usePointStyle:true
                }
            }
        }
    });

<?php
    $dateArry = [];
    $viewercount = [];
    $ordercount = [];
    $today = date('Y-m-d');
    for($i=0;$i<20;$i++){
        $date = date_create($today);
        date_sub($date,date_interval_create_from_date_string("$i days"));
        $current = date_format($date,'Y-m-d');
        array_push($dateArry, $current);

        $statement = $conn->prepare("SELECT COUNT(id) AS Total FROM viewers WHERE CAST(created_at AS DATE)='$current'");
        $statement->execute();
        $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result1 as $c){
            $result = $c['Total'];
        }
        array_push($viewercount,$result);

        $statement = $conn->prepare("SELECT COUNT(id) AS Total FROM orders WHERE CAST(created_at AS DATE)='$current'");
        $statement->execute();
        $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result2 as $c1){
            $result2 = $c1['Total'];
        }
        array_push($ordercount,$result2);
    }
   
    
?>
    let dateArr = <?php  echo json_encode($dateArry); ?>;
    let orderCountArr = <?php  echo json_encode($ordercount); ?>;
    let viewerCountArr = <?php echo json_encode($viewercount); ?>;

    let ov = document.getElementById('ov').getContext('2d');
    let ovChart = new Chart(ov, {
        type: 'line',
        data: {
            labels: dateArr,
            datasets: [
                {
                    label: 'Order Count',
                    data: orderCountArr,
                    backgroundColor: [
                        '#007bff30',
                    ],
                    borderColor: [
                        '#007bff',
                    ],
                    borderWidth: 1,
                    tension:0
                },
                {
                    label: 'Viewer Count',
                    data: viewerCountArr,
                    backgroundColor: [
                        '#28a74530',
                    ],
                    borderColor: [
                        '#28a745',
                    ],
                    borderWidth: 1,
                    tension:0
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    display:false,
                    ticks: {
                        beginAtZero: true
                    }
                }],
                xAxes:[
                    {
                        display:false,
                        gridLines:[
                            {
                                display:false
                            }
                        ]
                    }
                ]
            },
            legend:{
                display: true,
                shape:"circle",
                position: 'top',
                labels: {
                    fontColor: '#333',
                    usePointStyle:true
                }
            }
        }
    });
</script>