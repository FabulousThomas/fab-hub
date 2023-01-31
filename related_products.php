<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Product</title>

<?php
include "server/connection.php";


// if(isset($_GET['product_tag'])) {
//    $product_tag = mysqli_real_escape_string($conn, $_GET['product_tag']);

// $stmt = $conn->prepare("SELECT * FROM products WHERE product_tag = '$product_tag' ORDER BY product_id DESC");
// $stmt->execute();
// $tag = $stmt->get_result();

// } else {
//     header('Location: index.php');
//     // die("No Product found");
// }


if (isset($_GET['product_tag'])) {
    $product_tag = mysqli_real_escape_string($conn, $_GET['product_tag']);
    // $page = isset($_GET['page']) ? $_GET['page'] : 1;

    if (isset($_GET['page']) && $_GET['page'] != "") {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $num_per_page = 6;
    $start_from = intval(($page) - 1) * $num_per_page;
    $prev = intval($page) - 1;
    $next = intval($page) + 1;

    $sql = "SELECT * FROM products WHERE product_tag = '$product_tag' ORDER BY product_id DESC LIMIT $start_from, $num_per_page";
    $tag = $conn->query($sql);

    // $i = 1;

    $result = $conn->query("SELECT * FROM products");
    $entries = mysqli_num_rows($result);
    $totalPages = ceil($entries / $num_per_page);
}
?>

<body>
    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- RELATED PRODUCTS -->
    <section id="related" class="mt-5 pb-5 pt-lg-2">
        <div class="container text-center mt-5 pt-5 pb-3">
            <!-- <h3 class="text-capitalize">related products</h3> -->
            <h3 class="pt-2 text-uppercase">Shop &ndash; <?= $_GET['product_tag'] ?></h3>
            <hr class="mx-auto">
        </div>

        <div class="row mx-auto container-fluid">
            <?php 
                
            ?>
            <?php foreach($tag as $row) : ?>
                <div onclick="window.location.href='single_product.php?product_id=<?= $row['product_id'] ?>&product_tag=<?= $row['product_tag'] ?>';" class="product text-center col-lg-2 col-md-3 col-sm-4 col-6 position-relative">
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
            <?php endforeach; ?>
        </div>

         <!-- PAGINATION -->
         <?php if ($num_per_page) { ?>
               <nav aria-label="Page navigation example">
                  <ul class="pagination pagination-sm mt-5 rounded-0">

                     <li class="page-item <?php if ($page <= 1) {
                     echo 'disabled';
                  } ?>">
                        <a class="page-link" href="<?php if ($page <= 1): ?> 
                                                                            <?='#'; ?>
                                                                        <?php else: ?>
                                                                           related_products.php?product_tag=<?=$_GET['product_tag'] ?>&page=<?= $page - 1 ?>"
                                                                        <?php endif; ?>
                           title="Previous page"><span>Previous</span>
                        </a>
                     </li>

                     <li class='page-item'><a class='page-link' href='?product_tag=<?= $_GET['product_tag'] ?>&page=1' title='Page 1'>1</a></li>
                     <li class='page-item'><a class='page-link' href='?product_tag=<?= $_GET['product_tag'] ?>&page=2' title='Page 2'>2</a></li>

                     <?php if ($page >= 3): ?>
                        <li class='page-item'><a class='page-link' href='#' title='Page #'>...</a></li>
                        <li class='page-item'><a class='page-link' href='?product_tag=<?= $_GET['product_tag'] ?>&page=<?= $page ?>'
                              title='Page <?= $page ?>'>
                              <?= $page; ?>
                           </a></li>
                        <?php endif; ?>

                     <li class="page-item <?php if ($page >= $totalPages) {
                     echo 'disabled';
                  } ?>">
                        <a class="page-link" href="<?php if ($page >= $totalPages): ?> 
                                                                            <?='#'; ?>
                                                                        <?php else: ?>
                                                                            related_products.php?product_tag=<?=$_GET['product_tag'] ?>&page=<?= $page + 1 ?>"
                                                                        <?php endif; ?>
                           title="Next page"><span>Next</span></a>
                     </li>

                  </ul>
               </nav>
               <?php } else {
               } ?>
    </section>

    <!-- FOOTER -->
    <?php include "inc/footer.php" ?>

    <SCript>
        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");

        for (let i = 0; i < document.getElementsByClassName("small-img").length; i++) {
            smallImg[i].onclick = function() {
                mainImg.src = smallImg[i].src;
            }
        }
    </SCript>
</body>

</html>