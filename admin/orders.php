<?php include "./inc/head.php"; ?>
<title>Fab&dash;Hub | Admin&dash;Orders</title>

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

$sql = "SELECT * FROM orders ORDER BY order_id DESC LIMIT $start_from, $num_per_page";
$orders = $conn->query($sql);

// $i = 1;

$result = $conn->query("SELECT * FROM orders");
$entries = mysqli_num_rows($result);
$totalPages = ceil($entries / $num_per_page);


if(isset($_POST['btn-update-orders'])) {
   $order_id = $_POST['order_id'];
   $order_cost = $_POST['order_cost'];
   $order_status = $_POST['order_status'];

   $stmt = $conn->prepare("UPDATE orders SET order_cost=?, order_status=? WHERE order_id=? LIMIT 1");
   $stmt->bind_param("ssi", $order_cost, $order_status, $order_id);
   
   if($stmt->execute()) {
      flashMsg("message", "Order updated");
      redirect("orders.php?page=" . $page . "#orders");
      // echo "<script>alert('Order Updated');</script>";
   } else {
      echo "<h3>Something went wrong</h3>";
   }
} else if (isset($_POST['btn-delete-order'])) {
   $order_id = $_POST['order_id'];

   $stmt = $conn->prepare("DELETE FROM orders WHERE order_id=? LIMIT 1");
   $stmt->bind_param("i", $order_id);

   if (!$stmt->execute()) {
      echo "Something went wrong";
   } else {
    flashMsg("message", "order Deleted");
    redirect("orders.php?page=" . $page . "#orders");
}
}
?>


<body>

   <?php include "./inc/sidebar.php"; ?>

   <div class="main-content">
      <?php include "./inc/header.php"; ?>

      <main class="">
         <?php include "./inc/card.php"; ?>

         <div class=" my-5" id="orders">
            <div class="products">
            <p class="w-50">
                  <?php flashMsg("message"); ?>
               </p>
               <div class="card">
                  <div class="card-header">
                     <h4>Orders</h4>
                     <!-- <a class="btn-orange border-0">See all</a> -->
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table width="100%">
                           <thead>
                              <tr>
                                 <td>Order Id</td>
                                 <td>Price</td>
                                 <td>Order Status</td>
                                 <td>User Id</td>
                                 <td>Phone</td>
                                 <td>Email</td>
                                 <td>City</td>
                                 <td>Address</td>
                                 <td>Date</td>
                                 <td>Action</td>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ($orders) : ?>
                                 <?php foreach ($orders as $order) : ?>
                                    <tr class="align-items-center">
                                       <td><?= $order['order_id'] ?></td>
                                       <td><?= $order['order_cost'] ?></td>
                                       <td><span class="status <?php if (isset($order['order_status'])) {
                                           if ($order['order_status'] == 'not paid') {
                                               echo 'red';
                                           } elseif ($order['order_status'] == 'paid') {
                                               echo 'green';
                                           } else {
                                               echo 'purple';
                                           }
                                       } ?>"></span><?= $order['order_status'] ?></td>
                                       <td><?= $order['user_id'] ?></td>
                                       <td><?= $order['user_phone'] ?></td>
                                       <td><?= $order['user_email'] ?></td>
                                       <td><?= $order['user_city'] ?></td>
                                       <td><?= $order['user_address'] ?></td>
                                       <td><?= $order['order_date'] ?></td>
                                       <td>
                                          <div class="dropdown open bg-light">
                                             <a class="p-1 dropdown-toggle" type="button" data-toggle="dropdown">
                                                Admin
                                             </a>
                                             <div class="dropdown-menu shadow">
                                             <a value="<?= $order['order_id'] ?>"
                                                   class="dropdown-item btn-sm btn-edit-order" data-toggle="modal"
                                                   data-target="#edit-order-modal">Edit</a>

                                                <form action="" method="POST">
                                                   <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                                                   <input type="submit" name="btn-delete-order" value="Delete" class="dropdown-item btn-sm">
                                                </form>
                                             </div>
                                          </div>
                                       </td>
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
                                                                <?= '?page=' . $page - 1 . '#orders'; ?>
                                                            <?php endif; ?>" title="Previous page"><span>Previous</span>
                        </a>
                     </li>


                     <li class='page-item'><a class='page-link' href='?page=1#orders' title='Page 1'>1</a></li>
                     <li class='page-item'><a class='page-link' href='?page=2#orders' title='Page 2'>2</a></li>

                     <?php if ($page >= 3) : ?>
                        <li class='page-item'><a class='page-link' href='#' title='Page #'>...</a></li>
                        <li class='page-item'><a class='page-link' href='<?= "?page=" . $page . '#orders'; ?>' title='Page <?= $page ?>'><?= $page; ?></a></li>
                     <?php endif; ?>



                     <li class="page-item <?php if ($page >= $totalPages) {
                                             echo 'disabled';
                                          } ?>">
                        <a class="page-link" href="<?php if ($page >= $totalPages) : ?> 
                                                                <?= '#'; ?>
                                                            <?php else : ?>
                                                                <?= '?page=' . $page + 1 . '#orders'; ?>
                                                            <?php endif; ?>" title="Next page"><span>Next</span></a>
                     </li>

                  </ul>
               </nav>
            <?php } else {
            } ?>

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

   <?php
   require_once "./inc/modals.php";
   include "./inc/footer.php";
   ?>

   <script>
      $(document).ready(function () {
         $('.btn-edit-order').on('click', function () {
            $('#edit-order-modal').modal('show');

            $tr = $(this).closest("tr");
            var data = $tr.children("td").map(function () {
               return $(this).text();
            }).get();
            // console.log(data);
            $('#order_id').val(data[0]);
            $('#order_cost').val(data[1]);
            $('#order_status').val(data[2]);
            $('#user_id').val(data[3]);
            $('#user_phone').val(data[4]);
            $('#user_email').val(data[5]);
            $('#order_date').val(data[8]);
         });
      });
   </script>
</body>

</html>