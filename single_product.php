<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Product</title>

<?php
include "server/connection.php";

if (isset($_GET['product_id']) && $_GET['product_tag']) {

    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id='$product_id' ");

    $stmt->execute();

    $product = $stmt->get_result(); //[]
} else {
    header('Location: index.php');
    // die("No Product found");
}
?>

<body>
    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- SINGLE PRODUCTS -->
    <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

            <?php foreach ($product as $row) : ?>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 h-75 mb-1 border rounded p-4" id="mainImg">
                    <div class="small-img-group">
                        <div class="small-img-col">
                            <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid small-img w-100">
                        </div>
                        <div class="small-img-col">
                            <img src="assets/img/<?= $row['product_image2'] ?>" alt="" class="img-fluid small-img w-100">
                        </div>
                        <div class="small-img-col">
                            <img src="assets/img/<?= $row['product_image3'] ?>" alt="" class="img-fluid small-img w-100">
                        </div>
                        <div class="small-img-col">
                            <img src="assets/img/<?= $row['product_image4'] ?>" alt="" class="img-fluid small-img w-100">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <h6 class="pt-2 text-uppercase">Shop &ndash; <?= $row['product_tag'] ?></h6>
                    <h3 class="py-2"><?= $row['product_name'] ?></h3>
                    <h2 class="d-inline-block">$ <?= $row['product_price'] ?> </h2> <?php if (isset($row) && $row['product_special_offer'] != 0) : ?>
                        <small class="text-danger"> &dash; <?= $row['product_special_offer'] . '% off sales' ?></small>
                    <?php endif; ?>

                    <form action="cart.php" method="POST" class="cart-form">
                        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                        <input type="hidden" name="product_image" value="<?= $row['product_image'] ?>">
                        <input type="hidden" name="product_name" value="<?= $row['product_name'] ?>">
                        <input type="hidden" name="product_price" value="<?= $row['product_price'] ?>">
                        <input type="hidden" name="product_special_offer" value="<?= $row['product_special_offer'] ?>">

                        <input type="number" name="product_qty" value="1" class="product_qty">
                        <button class="buy-btn" type="submit" name="add_to_cart"> <i class="fas fa-cart-plus pe-2"></i> Add To Cart</button>
                    </form>

                    <h4 class="mt-5 mb-3">Product Details</h4>
                    <p><?= $row['product_description'] ?></p>
                </div>

            <?php endforeach; ?>
        </div>
    </section>


    <!-- RELATED PRODUCTS -->
    <section id="related" class="mt-5 pb-5">
        <div class="container text-center mt-5 pt-5 pb-3">
            <h3 class="text-capitalize">related products</h3>
            <hr class="mx-auto">
        </div>

        <div class="row mx-auto container-fluid">
            <?php
            if (isset($_GET['product_tag'])) {
                $product_tag = mysqli_real_escape_string($conn, $_GET['product_tag']);

                $stmt = $conn->prepare("SELECT * FROM products WHERE product_tag = '$product_tag' ORDER BY product_id DESC LIMIT 6");
                $stmt->execute();
                $tag = $stmt->get_result();
            }
            ?>
            <?php foreach ($tag as $row) : ?>
                <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-2 col-md-3 col-sm-4 col-6 position-relative">
                    <?php if (isset($row) && $row['product_special_offer'] != 0) : ?>
                        <div class="position-absolute top-25 start-0 badge rounded bg-danger p-2 discount">
                            <small class="m-0"><?= $row['product_special_offer'] ?>% Off</small>
                        </div>
                    <?php endif ?>
                    <div class="image-container">
                        <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 img-small">
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
            <?php endforeach; ?>
        </div>

        <?php if (isset($tag) && $tag >= $tag) : ?>
            <a href="related_products.php?product_tag=<?= $row['product_tag'] ?>" class="btn btn-outline-dark btn-sm w-25 ms-2">See more</a>
        <?php endif; ?>

    </section>

    <!-- FOOTER -->
    <?php include "inc/footer.php" ?>

    <script>
        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");

        for (let i = 0; i < document.getElementsByClassName("small-img").length; i++) {
            smallImg[i].onclick = function() {
                mainImg.src = smallImg[i].src;
            }
        }
    </script>
</body>

</html>