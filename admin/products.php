<?php include "./inc/head.php"; ?>
<title>Fab&dash;Hub | Admin&dash;Products</title>
<?php

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

$sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT $start_from, $num_per_page";
$products = $conn->query($sql);

// $i = 1;

$result = $conn->query("SELECT * FROM products");
$entries = mysqli_num_rows($result);
$totalPages = ceil($entries / $num_per_page);

if (isset($_POST['btn-update-product'])) {
   $product_id = $_POST['product_id'];
   $product_price = $_POST['product_price'];
   $product_name = $_POST['product_name'];
   $product_category = $_POST['product_category'];
   $product_color = $_POST['product_color'];
   $product_special_offer = $_POST['product_special_offer'];
   $product_description = $_POST['product_description'];

   $stmt1 = $conn->prepare("UPDATE products SET product_price=?, product_name=?, product_category=?, product_color=?, product_special_offer=?, product_description=? WHERE product_id = ?");
   $stmt1->bind_param('ssssisi', $product_price, $product_name, $product_category, $product_color, $product_special_offer, $product_description, $product_id);

   if (!$stmt1->execute()) {
      echo "Something went wrong";
   } else {
      flashMsg("message", "Product updated");
      redirect("products.php?page=" . $page . "#products");
   }
} else if (isset($_POST['btn-add-product'])) {
   $product_name = $_POST['product_name'];
   $product_category = $_POST['product_category'];
   $product_price = $_POST['product_price'];
   $product_offer = $_POST['product_offer'];
   $product_color = $_POST['product_color'];
   $product_tag = $_POST['product_tag'];
   $product_description = $_POST['product_description'];

   $rand_number1 = random_num(10);
   $product_image1 = $_FILES['product_image1']['name'];
   $image_ext1 = pathinfo($product_image1, PATHINFO_EXTENSION);
   $image_name1 = $rand_number1 . '.' . $image_ext1;

   $rand_number2 = random_num(10);
   $product_image2 = $_FILES['product_image2']['name'];
   $image_ext2 = pathinfo($product_image2, PATHINFO_EXTENSION);
   $image_name2 = $rand_number2 . '.' . $image_ext2;

   $rand_number3 = random_num(10);
   $product_image3 = $_FILES['product_image3']['name'];
   $image_ext3 = pathinfo($product_image3, PATHINFO_EXTENSION);
   $image_name3 = $rand_number3 . '.' . $image_ext3;

   $rand_number4 = random_num(10);
   $product_image4 = $_FILES['product_image4']['name'];
   $image_ext4 = pathinfo($product_image4, PATHINFO_EXTENSION);
   $image_name4 = $rand_number4 . '.' . $image_ext4;

   $image_path = "../assets/img/";

   $stmt = $conn->prepare("INSERT INTO products (product_name, product_category, product_price, product_special_offer, product_color, product_tag, product_description, product_image, product_image2, product_image3, product_image4) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
   $stmt->bind_param("sssssssssss", $product_name, $product_category, $product_price, $product_offer, $product_color, $product_tag, $product_description, $image_name1, $image_name2, $image_name3, $image_name4);

   if($stmt->execute()) {
      move_uploaded_file($_FILES['product_image1']['tmp_name'], $image_path . $image_name1);
      move_uploaded_file($_FILES['product_image2']['tmp_name'], $image_path . $image_name2);
      move_uploaded_file($_FILES['product_image3']['tmp_name'], $image_path . $image_name3);
      move_uploaded_file($_FILES['product_image4']['tmp_name'], $image_path . $image_name4);
      flashMsg('message', 'Product created successfully!');
      redirect('products.php');
   } else {
      echo "Something went wrong";
   }
   
} else if (isset($_POST['btn-update-product-image'])) {
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];

   $new_image1 = $_FILES['image']['name'];
   $old_image1 = $_POST['old_image'];

   $rand_number1 = random_num(10);
   $product_image1 = $_FILES['product_image1']['name'];
   $image_ext1 = pathinfo($product_image1, PATHINFO_EXTENSION);
   $image_name1 = $rand_number1 . '.' . $image_ext1;

   $rand_number2 = random_num(10);
   $product_image2 = $_FILES['product_image2']['name'];
   $image_ext2 = pathinfo($product_image2, PATHINFO_EXTENSION);
   $image_name2 = $rand_number2 . '.' . $image_ext2;

   $rand_number3 = random_num(10);
   $product_image3 = $_FILES['product_image3']['name'];
   $image_ext3 = pathinfo($product_image3, PATHINFO_EXTENSION);
   $image_name3 = $rand_number3 . '.' . $image_ext3;

   $rand_number4 = random_num(10);
   $product_image4 = $_FILES['product_image4']['name'];
   $image_ext4 = pathinfo($product_image4, PATHINFO_EXTENSION);
   $image_name4 = $rand_number4 . '.' . $image_ext4;

   $image_path = "../assets/img/";

} else if (isset($_POST['btn-delete-product'])) {
   $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

   $sql = "SELECT * FROM products WHERE product_id='$product_id' LIMIT 1";
   $sql_run = $conn->query($sql);
   $row = mysqli_fetch_array($sql_run);
   $image = $row['product_image'];
   $image2 = $row['product_image2'];
   $image3 = $row['product_image3'];
   $image4 = $row['product_image4'];

   $stmt = $conn->query("DELETE FROM products WHERE product_id='$product_id' LIMIT 1");
   
   if (!$stmt) {
      echo "Something went wrong";
   } else {
      if(file_exists("../assets/img/" . $image)) {
         unlink("../assets/img/" . $image);
         unlink("../assets/img/" . $image2);
         unlink("../assets/img/" . $image3);
         unlink("../assets/img/" . $image4);
      }
      flashMsg("message", "Product Deleted");
      redirect("products.php?page=" . $page . "#products");
   }
}

?>

<body>

   <?php include "./inc/sidebar.php"; ?>

   <div class="main-content">
      <?php include "./inc/header.php"; ?>

      <main class="">
         <?php include "./inc/card.php"; ?>

         <div class=" my-5" id="products">
            <div class="products">
               <p class="w-50">
                  <?php flashMsg("message"); ?>
               </p>
               <div class="card">
                  <div class="card-header">
                     <h4>Products</h4>
                     <a class="btn-orange border-0" data-target="#add-product-modal" data-toggle="modal">Add Products</a>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table width="100%">
                           <thead>
                              <tr>
                                 <td>Product Id</td>
                                 <td>Image</td>
                                 <td>Price</td>
                                 <td>Product Name</td>
                                 <td>Category</td>
                                 <td>Color</td>
                                 <td>Offer</td>
                                 <!-- <td>Description</td> -->
                                 <!-- <td>Action</td> -->
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($products): ?>
                                 <?php foreach ($products as $product): ?>
                                    <tr class="align-items-center">
                                       <td><?= $product['product_id'] ?></td>
                                       <td><img src="../assets/img/<?= $product['product_image'] ?>" class="img-fluid"></td>
                                       <td hidden><img src="../assets/img/<?= $product['product_image2'] ?>" class="img-fluid"></td>
                                       <td hidden><img src="../assets/img/<?= $product['product_image3'] ?>" class="img-fluid"></td>
                                       <td hidden><img src="../assets/img/<?= $product['product_image4'] ?>" class="img-fluid"></td>
                                       <td><?= $product['product_price'] ?></td>
                                       <td><?= $product['product_name'] ?></td>
                                       <td><?= $product['product_category'] ?></td>
                                       <td><?= $product['product_color'] ?></td>
                                       <td><?= $product['product_special_offer'] ?></td>
                                       <td hidden><?= $product['product_description'] ?></td>
                                       <td>
                                          <div class="dropdown open bg-light">
                                             <a class="p-1 dropdown-toggle btn-sm" type="button" data-toggle="dropdown">
                                                Admin
                                             </a>
                                             <div class="dropdown-menu shadow">

                                                <a value="<?= $product['product_id'] ?>"
                                                   class="dropdown-item btn-sm btn-edit-product" data-toggle="modal"
                                                   data-target="#edit-product-modal">Edit Product</a>

                                                   <a value="<?= $product['product_id'] ?>"
                                                   class="dropdown-item btn-sm btn-edit-product-image" data-toggle="modal"
                                                   data-target="#edit-product-image-modal">Edit Images</a>
                                                   
                                                <form action="" method="POST">
                                                   <input type="hidden" name="product_id"
                                                      value="<?= $product['product_id']; ?>">
                                                   <input type="submit" name="btn-delete-product" value="Delete"
                                                      class="dropdown-item btn-sm">
                                                </form>
                                             </div>
                                          </div>
                                       </td>
                                    </tr>
                                    <?php endforeach; ?>
                                 <?php else: ?>
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
                                                                            <?='?page=' . $page - 1 . '#products'; ?>
                                                                        <?php endif; ?>"
                           title="Previous page"><span>Previous</span>
                        </a>
                     </li>

                     <li class='page-item'><a class='page-link' href='?page=1#products' title='Page 1'>1</a></li>
                     <li class='page-item'><a class='page-link' href='?page=2#products' title='Page 2'>2</a></li>

                     <?php if ($page >= 3): ?>
                        <li class='page-item'><a class='page-link' href='#' title='Page #'>...</a></li>
                        <li class='page-item'><a class='page-link' href='<?="?page=" . $page . '#products'; ?>'
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
                                                                            <?='?page=' . $page + 1 . '#products'; ?>
                                                                        <?php endif; ?>"
                           title="Next page"><span>Next</span></a>
                     </li>

                  </ul>
               </nav>
               <?php } else {
               } ?>

         </div>
      </main>

      <footer class="text-center py-2">
         <div class="container">
            <p class="m-0">Developer: <a href="" class="text-dark"
                  style="text-decoration: underline !important; color: coral !important;">Fab&ndash;Hub</a> </p>
            <small><span style="color: coral;">Fab&ndash;Hub </span><i class="fa fa-copyright" aria-hidden="true"></i>
               <script>
                  var currentYear = new Date().getFullYear();
                  document.write(currentYear);
               </script> | All Right Reserved
            </small>
         </div>
      </footer>
   </div>

   <?php
   require_once "./inc/modals.php";
   include "./inc/footer.php";
   ?>

   <script>
      $(document).ready(function () {
         $('.btn-edit-product').on('click', function () {
            $('#edit-product-modal').modal('show');

            $tr = $(this).closest("tr");
            var data = $tr.children("td").map(function () {
               return $(this).text();
            }).get();
            // console.log(data);
            $('#product_id').val(data[0]);
            $('#product_price').val(data[5]);
            $('#product_name').val(data[6]);
            $('#product_category').val(data[7]);
            $('#product_color').val(data[8]);
            $('#product_special_offer').val(data[9]);
            $('#product_description').val(data[10]);
         });

         // $('.btn-edit-product-image').on('click', function () {
         //    $('#edit-product-image-modal').modal('show');

         //    $tr = $(this).closest("tr");
         //    var data = $tr.children("td").map(function () {
         //       return $(this).text();
         //    }).get();
         //    // console.log(data);
         //    $('#product_img_id').val(data[0]);
         //    $('#product_img_name').val(data[6]);
         //    $('#product_img_image1').val(data[2]);
         //    $('#product_img_image2').val(data[3]);
         //    $('#product_img_image3').val(data[4]);
         //    // $('#product_img_image4').val(data[5]);
         // });
      });
   </script>
</body>

</html>