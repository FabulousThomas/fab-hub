<?php include "./inc/head.php"; ?>

<?php
$stmt = $conn->prepare("SELECT * FROM products ORDER BY product_id DESC LIMIT 6");
$stmt->execute();
$get_products = $stmt->get_result();

$stmt = $conn->prepare("SELECT * FROM orders ORDER BY order_id DESC LIMIT 8");
$stmt->execute();
$get_orders = $stmt->get_result();

$stmt = $conn->prepare("SELECT * FROM order_items ORDER BY order_id DESC LIMIT 8");
$stmt->execute();
$get_items = $stmt->get_result();

$stmt = $conn->prepare("SELECT * FROM users ORDER BY user_id DESC LIMIT 9");
$stmt->execute();
$get_users = $stmt->get_result();
?>
<title>Fab&dash;Hub | Admin&dash;Dashboard</title>

<body>
    <?php include "./inc/sidebar.php"; ?>

    <div class="main-content">
        <?php include "./inc/header.php"; ?>

        <main class="">
            <?php include "./inc/card.php"; ?>

            <div class="recent-grid">

                <div class="">
                    <div class="products">
                        <div class="card">
                            <div class="card-header">
                                <h4>Order Items</h4>
                                <a href="order_items.php" class="btn-orange border-0">See all</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <td>Item Id</td>
                                                <!-- <td>Order Id</td> -->
                                                <!-- <td>Product Id</td> -->
                                                <td>User Id</td>
                                                <!-- <td>Image</td> -->
                                                <td>Name</td>
                                                <td>Price</td>
                                                <td>qty</td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($get_items) : ?>
                                                <?php foreach ($get_items as $item) : ?>
                                                    <tr class="align-items-center">
                                                        <td><?= $item['item_id'] ?></td>
                                                        <!-- <td><?= $item['order_id'] ?></td> -->
                                                        <!-- <td><?= $item['product_id'] ?></td> -->
                                                        <td><?= $item['user_id'] ?></td>
                                                        <!-- <td><img src="../assets/img/<?= $item['product_image'] ?>" class="img-fluid"></td> -->
                                                        <td><?= $item['product_name'] ?></td>
                                                        <td>$ <?= $item['product_price'] ?></td>
                                                        <td><?= $item['product_qty'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <h5 class="text-center">No item available</h5>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="customers mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Orders</h4>
                            <a href="orders.php" class="btn-orange border-0">See all</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>Order Id</td>
                                            <td>Price</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($get_orders) : ?>
                                            <?php foreach ($get_orders as $order) : ?>
                                                <tr class="align-items-center">
                                                    <td><?= $order['order_id'] ?></td>
                                                    <td>$ <?= $order['order_cost'] ?></td>
                                                    <td>
                                                        <span class="status <?php if (isset($order['order_status'])) {
                                                                                if ($order['order_status'] == 'not paid') {
                                                                                    echo 'red';
                                                                                } else if ($order['order_status'] == 'paid') {
                                                                                    echo 'green';
                                                                                } else {
                                                                                    echo 'purple';
                                                                                }
                                                                            } ?>"></span><?= $order['order_status'] ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <h5 class="text-center">No orders available</h5>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <div class="products">
                    <div class="card">
                        <div class="card-header">
                            <h4>Products</h4>
                            <a href="products.php" class="btn-orange border-0">See all</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Image</td>
                                            <td>Price</td>
                                            <td>Name</td>
                                            <td>Color</td>
                                            <td>Offer</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($get_products) : ?>
                                            <?php foreach ($get_products as $product) : ?>
                                                <tr class="align-items-center">
                                                    <td><?= $product['product_id'] ?></td>
                                                    <td><img src="../assets/img/<?= $product['product_image'] ?>" class="img-fluid"></td>
                                                    <td>$ <?= $product['product_price'] ?></td>
                                                    <td><?= $product['product_name'] ?></td>
                                                    <td><?= $product['product_color'] ?></td>
                                                    <td><?= $product['product_special_offer'] ?> %</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <h5 class="text-center">No product available</h5>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </main>

        <footer class="text-center py-2">
            <div class="container">
                <p class="m-0">Developer: <a href="" class="text-dark" style="text-decoration: underline !important; color: coral !important;">Fab&ndash;Hub</a> </p>
                <small><span style="color: coral;">Fab&ndash;Hub </span><i class="fa fa-copyright" aria-hidden="true"></i>
                    <script>
                        var currentYear = new Date().getFullYear();
                        document.write(currentYear);
                    </script> | All Right Reserved
                </small>
            </div>
        </footer>
    </div>

    <?php include "./inc/footer.php"; ?>
</body>

</html>