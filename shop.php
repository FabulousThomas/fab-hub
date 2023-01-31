<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Shop</title>

<style>
   
</style>

<?php
require_once "server/connection.php";

if (isset($_POST['search'])) {
    // $page = "";
    $totalPages = "";
    $num_per_page = "";
    $prev = "";
    $next = "";

    $category = $_POST['category'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_category = ? AND product_price <= ?");
    $stmt->bind_param('si', $category, $price);
    $stmt->execute();
    $products = $stmt->get_result();
} else {

    // $page = isset($_GET['page']) ? $_GET['page'] : 1;

    if (isset($_GET['page']) && $_GET['page'] != "") {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $num_per_page = 8;
    $start_from = intval(($page) - 1) * $num_per_page;
    $prev = intval($page) - 1;
    $next = intval($page) + 1;

    $sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT $start_from, $num_per_page";
    $products = $conn->query($sql);

    // $i = 1;

    $result = $conn->query("SELECT * FROM products");
    $entries = mysqli_num_rows($result);
    $totalPages = ceil($entries / $num_per_page);
}
?>


<body>

    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <div class="row container-fluid mx-auto flex-column flex-md-row justify-content-between align-items-baseline pt-3">
        <section id="search" class="col-lg-3 col-md-6">
            <div class="container-fluid text-start mt-5 pt-5 pb-3">
                <p class="text-capitalize m-0">Search products</p>
                <hr class="text-center d-lg-block d-none">
            </div>

            <form action="shop.php" method="POST">
                <div class="row mx-auto container-fluid px-0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p class="">Category</p>

                        <?php
                        $stmt1 = $conn->prepare("SELECT DISTINCT product_category FROM products");
                        $stmt1->execute();
                        $product_categories = $stmt1->get_result();
                        ?>
                        <?php foreach ($product_categories as $cate) : ?>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="<?= $cate['product_category'] ?>" name="category" id="category-one">
                                <label for="flexRadioDefault1" class="form-check-label"><?= $cate['product_category'] ?></label>
                            </div>
                        <?php endforeach; ?>

                        <h5 class="mt-lg-5 mt-4">Pice Range</h5>
                        <input type="range" class="form-range w-75" min="1" max="1000" name="price" id="customeRange2">
                        <div class="d-flex justify-content-between align-items-center w-75">
                            <span>1</span>
                            <span>1000</span>
                        </div>

                        <div class="form-group my-3">
                            <input type="submit" value="Search" name="search" class="btn-orange">
                        </div>
                    </div>
                </div>
            </form>

        </section>

        <!-- FEATURED PRODUCTS -->
        <section id="featured" class="mt-3 mt-lg-5 pt-5 py-lg-4 col-lg-9 col-md-12 px-0">
            <div class="container-fluid text-start mt-md-2 mt-lg-5 pt-md-2 pt-lg-5 pb-3">
                <h3 class="text-capitalize">our products</h3>
                <hr class="text-center">
                <p class="">Here you can check out our products</p>
            </div>

            <div class="row mx-auto align-items-center container-fluid px-0 px-lg-2 gutters-2">
                <?php while ($row = $products->fetch_assoc()) : ?>
                    <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-3 col-md-3 col-sm-4 col-6 position-relative">
                    <?php if(isset($row) && $row['product_special_offer'] > 0) : ?>
                    <div class="position-absolute top-25 start-0 badge rounded bg-danger p-2 discount">
                        <small class="m-0"><?= $row['product_special_offer'] ?>% Off</small>
                    </div>
                    <?php endif ?>
                    <div class="image-container">
                        <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 img-mid">
                        </div>
                        <div class="star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="p-name"><?= $row['product_name'] ?></h5>
                        <h5 class="p-price" style="font-weight: bolder;">$<?= $row['product_price'] ?></h5>
                        <button class="buy-btn" onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';">Buy Now</button>
                    </div>
                <?php endwhile; ?>

                <!-- PAGINATION -->
                <?php if ($num_per_page) { ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination pagination-sm mt-5 rounded-0">

                            <li class="page-item <?php if ($page <= 1) {
                                                        echo 'disabled';
                                                    } ?>">
                                <a class="page-link" href="<?php if ($page <= 1) : ?> 
                                                                <?= '#'; ?>
                                                            <?php else : ?>
                                                                <?= '?page=' . $page - 1; ?>
                                                            <?php endif; ?>" title="Previous page"><span>Previous</span>
                                </a>
                            </li>


                            <li class='page-item'><a class='page-link' href='?page=1' title='Page 1'>1</a></li>
                            <li class='page-item'><a class='page-link' href='?page=2' title='Page 2'>2</a></li>

                            <?php if ($page >= 3) : ?>
                                <li class='page-item'><a class='page-link' href='#' title='Page #'>...</a></li>
                                <li class='page-item'><a class='page-link' href='<?= "?page=" . $page; ?>' title='Page <?= $page ?>'><?= $page; ?></a></li>
                            <?php endif; ?>



                            <li class="page-item <?php if ($page >= $totalPages) {
                                                        echo 'disabled';
                                                    } ?>">
                                <a class="page-link" href="<?php if ($page >= $totalPages) : ?> 
                                                                <?= '#'; ?>
                                                            <?php else : ?>
                                                                <?= '?page=' . $page + 1; ?>
                                                            <?php endif; ?>" title="Next page"><span>Next</span></a>
                            </li>

                        </ul>
                    </nav>
                <?php } else {
                } ?>
            </div>
        </section>

    </div>

    <!-- FOOTER -->
    <?php include "inc/footer.php"; ?>
</body>

</html>