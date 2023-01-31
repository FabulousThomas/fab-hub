<?php include "inc/head.php" ?>
<title>Fab&ndash;Hub</title>

<body>
    <?php include "inc/nav.php" ?>
    <!-- HOME -->
    <section id="home" class="carousel-image-1">
        <div class="container">
            <h5 class="text-uppercase">new arrivals</h5>
            <h1 class="text-capitalize"><span>Best Prices</span> this season</h1>
            <p>FabHub offers the best products for the most <span>affordable prices</span></p>
            <a href="#" class="">Shop Now</a>
        </div>
    </section>

    <!-- <section id="mycarousel" class="carousel slide" data-bs-ride="carousel">
        <div class=" carousel-inner">
            <div class="carousel-item carousel-image-1 active">
                <div class="container">
                    <h5 class="text-uppercase">new arrivals</h5>
                    <h1 class="text-capitalize"><span>Best Prices</span> this season</h1>
                    <p>FabHub offers the best products for the most <span>affordable prices</span></p>
                    <a href="#" class="">Shop Now</a href="#">
                </div>
            </div>

            <div class="carousel-item carousel-image-2">
                <div class="container">
                    <h5 class="text-uppercase">new arrivals</h5>
                    <h1 class="text-capitalize"><span>Best Prices</span> this season</h1>
                    <p>FabHub offers the best products for the most <span>affordable prices</span></p>
                    <a href="#" class="">Shop Now</a href="#">
                </div>
            </div>
        </div>
    </section> -->


    <!-- BRANDS -->
    <section id="brand" class="container">
        <div class="row">
            <img src="assets/img/brand-1.webp" alt="" class="img-fluid col-lg-3 col-md-6">
            <img src="assets/img/brand-2.png" alt="" class="img-fluid col-lg-3 col-md-6">
            <img src="assets/img/brand-4.png" alt="" class="img-fluid col-lg-3 col-md-6">
            <img src="assets/img/brand-5.png" alt="" class="img-fluid col-lg-3 col-md-6">

        </div>
    </section>

    <!-- PROMOTIONS -->
    <section id="new" class="w-100">
        <div class="row m-0 p-0">
            <!-- One -->
            <div class="one col-lg-3 col-md-6 col-sm-6 p-0">
                <img src="assets/img/shoe-3.webp" alt="" class="img-fluid">
                <div class="details">
                    <h3>Awesome Shoes</h2>
                        <a href="#" class="text-uppercase">Shop Now</a>
                </div>
            </div>
            <!-- Two -->
            <div class="one col-lg-3 col-md-6 col-sm-6 p-0">
                <img src="assets/img/headphone-4.png" alt="" class="img-fluid">
                <div class="details">
                    <h3>Discount Sales %</h2>
                        <a href="#" class="text-uppercase">Shop Now</a>
                </div>
            </div>
            <!-- Three -->
            <div class="one col-lg-3 col-md-6 col-sm-6 p-0">
                <img src="assets/img/featured-3.jpg" alt="" class="img-fluid">
                <div class="details">
                    <h3>Shop Phones Now</h2>
                        <a href="#" class="text-uppercase">Shop Now</a>
                </div>
            </div>
            <!-- Four -->
            <div class="one col-lg-3 col-md-6 col-sm-6 p-0">
                <img src="assets/img/pod-1.png" alt="" class="img-fluid">
                <div class="details">
                    <h3>Shop Ear-Pods</h2>
                        <a href="#" class="text-uppercase">Shop Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section id="featured" class="mt-5 pb-5">
        <div class="container text-center mt-5 pt-5 pb-3">
            <h3 class="text-capitalize">featured products</h3>
            <hr class="mx-auto">
            <p class="">Here you can check out our featured products</p>
        </div>

        <div class="row mx-auto container-fluid">

            <?php include "server/get_featured_product.php"; ?>

            <?php foreach ($featured_product as $row) : ?>
                <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-3 col-md-3 col-sm-4 col-6 position-relative">
                    <?php if(isset($row) && $row['product_special_offer'] > 0) : ?>
                    <div class="position-absolute top-25 start-0 badge rounded bg-danger p-2 discount">
                        <small class="m-0"><?= $row['product_special_offer'] ?>% Off</small>
                    </div>
                    <?php endif ?>
                    <div class="image-container">
                        <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 img-big">
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
            <?php endforeach ?>
        </div>
    </section>

    <!-- BANNER -->
    <section id="banner" class="my-5 py-5">
        <div class="container">
            <h4 class="text-uppercase">mid season's sale</h4>
            <h1>Autumn Collection <br class="text-uppercase">up to 30% discount </h1>
            <button>shop now</button>
        </div>
    </section>

    <!-- HEADPHONES -->
    <section id="headhpnes" class="mt-5">
        <div class="container text-center mt-5 pt-5 pb-3">
            <h3 class="text-capitalize">Headphones / Earphones</h3>
            <hr class="mx-auto">
            <p class="">Here you can check out our durable headphones</p>
        </div>

        <div class="row mx-auto container-fluid">
            <?php include "server/get_headphone.php"; ?>
            <?php foreach ($headphone_product as $row) : ?>
                <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-3 col-md-3 col-sm-4 col-6 position-relative">
                    <?php if(isset($row) && $row['product_special_offer'] > 0) : ?>
                    <div class="position-absolute top-25 start-0 badge rounded bg-danger p-2 discount">
                        <small class="m-0"><?= $row['product_special_offer'] ?>% Off</small>
                    </div>
                    <?php endif ?>
                    <div class="image-container">
                        <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 img-big">
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
    </section>

    <!-- SHOES -->
    <section id="shoes" class="mt-5">
        <div class="container text-center mt-5 pt-5 pb-3">
            <h3 class="text-capitalize">Shoes</h3>
            <hr class="mx-auto">
            <p class="">Here you can check out our great shoes</p>
        </div>

        <div class="row mx-auto container-fluid">
            <?php include "server/get_shoes.php" ?>
            <?php foreach ($shoe_product as $row) : ?>
                <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-3 col-md-3 col-sm-4 col-6 position-relative">
                    <?php if(isset($row) && $row['product_special_offer'] > 0) : ?>
                    <div class="position-absolute top-25 start-0 badge rounded bg-danger p-2 discount">
                        <small class="m-0"><?= $row['product_special_offer'] ?>% Off</small>
                    </div>
                    <?php endif ?>
                    <div class="image-container">
                        <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 img-big">
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
    </section>

    <!-- CLOTHES -->
    <section id="clothes" class="mt-5">
        <div class="container text-center mt-5 pt-5 pb-3">
            <h3 class="text-capitalize">dresses & coats</h3>
            <hr class="mx-auto">
            <p class="">Here you can check out our amazing dresses</p>
        </div>

        <div class="row mx-auto container-fluid">
            <?php include "server/get_coats.php"; ?>
            <?php foreach ($coat_product as $row) : ?>
                <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-3 col-md-3 col-sm-4 col-6 position-relative">
                    <?php if(isset($row) && $row['product_special_offer'] > 0) : ?>
                    <div class="position-absolute top-25 start-0 badge rounded bg-danger p-2 discount">
                        <small class="m-0"><?= $row['product_special_offer'] ?>% Off</small>
                    </div>
                    <?php endif ?>
                    <div class="image-container">
                        <img src="assets/img/<?= $row['product_image'] ?>" alt="" class="img-fluid w-100 img-big">
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
    </section>

    <?php include "inc/footer.php" ?>

</body>

</html>