<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Account</title>

<?php
require_once "server/connection.php";
require_once "function/helper.php";

if (isset($_POST['btn-order-details']) && isset($_POST['order_id'])) {

   $order_id = $_POST['order_id'];
   $order_status = $_POST['order_status'];

   $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ? ");
   $stmt->bind_param('i', $order_id);
   $stmt->execute();

   $order_details = $stmt->get_result();

   $order_total_price = calculateOrderTotalPrice($order_details);
} else {
   redirect('account.php');
}


function calculateOrderTotalPrice($order_details)
{
   $total = 0;

   foreach ($order_details as $row) {

      $price = $row['product_price'];
      $qty = $row['product_qty'];

      $total = $total + ($price * $qty);
   }

   return $total;
}

?>

<body>

   <!-- NAVBAR -->
   <?php include "inc/nav.php"; ?>


   <!-- ORDER DETAILS -->
   <section id="orders" class="orders container mt-5 pt-5">
      <div class="container pt-4 pt-0 text-center">
         <h2 class="font-weight-bold text-uppercase">Order Details</h2>
         <hr class="mx-auto">
      </div>
      <table class="mt-5 pt-5">
         <tr>
            <th>Product</th>
            <th>Name</th>
            <th>Price</th>
            <th class="text-start">Quantity</th>
         </tr>

         <?php foreach ($order_details as $row) : ?>
            <tr>
               <td>
                  <img src="assets/img/<?= $row['product_image'] ?>" alt="">
               </td>
               <td>
                  <p class="mb-0"><?= $row['product_name'] ?></p>
               </td>
               <td>
                  <span>$ <?= $row['product_price'] ?></span>
               </td>
               <td class="text-start">
                  <span><?= $row['product_qty'] ?></span>
               </td>
               <!-- <td>
                  <form class="">
                     <input type="submit" class="btn btn-sm btn-order-details" name="" value="Details">
                  </form>
               </td> -->
            </tr>
         <?php endforeach; ?>

      </table>

      <?php if ($order_status == 'not paid') : ?>
         <form class="text-end" action="payment.php" method="POST">
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <input type="hidden" name="order_total_price" value="<?= $order_total_price ?>">
            <input type="hidden" name="order_status" value="<?= $order_status ?>">
            <input type="submit" name="btn-pay-order" class="btn-orange" value="Pay Now">
         </form>
      <?php else : ?>
         <div class="text-end">
            <a onclick="window.location.href='account.php#orders'" class="btn-orange">Your orders</a>
         </div>
      <?php endif; ?>

   </section>












   <!-- FOOTER -->
   <?php include "inc/footer.php"; ?>
</body>

</html>