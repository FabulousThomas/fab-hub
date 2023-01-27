<?php

$stmt = $conn->prepare("SELECT COUNT(*)  AS product_total FROM products");
$stmt->execute();
$product_total = $stmt->get_result();

$stmt = $conn->prepare("SELECT COUNT(*)  AS order_total FROM orders");
$stmt->execute();
$order_total = $stmt->get_result();

$stmt = $conn->prepare("SELECT COUNT(*)  AS item_total FROM order_items");
$stmt->execute();
$item_total = $stmt->get_result();

$stmt = $conn->prepare("SELECT SUM(order_cost)  AS order_cost FROM orders");
$stmt->execute();
$order_cost = $stmt->get_result();

?>

<div class="cards">

   <div class="card-single">
      <div>
         <?php foreach ($product_total as $total) { ?>
            <h2><?= $total['product_total']; ?></h2>
         <?php } ?>
         <span>Products</span>
      </div>
      <div>
         <span class="las la-clipboard-list"></span>
      </div>
   </div>

   <div class="card-single">
      <div>
         <?php foreach ($item_total as $total) { ?>
            <h2><?= $total['item_total']; ?></h2>
         <?php } ?>
         <span>Order Items</span>
      </div>
      <div>
         <span class="las la-shopping-cart"></span>
      </div>
   </div>

   <div class="card-single">
      <div>
         <?php foreach ($order_total as $total) { ?>
            <h2><?= $total['order_total']; ?></h2>
         <?php } ?>
         <span>Orders</span>
      </div>
      <div>
         <span class="las la-shopping-bag"></span>
      </div>
   </div>

   <?php 
   
// echo $fmt->formatCurrency(1234567.891234567890000, "EUR")."\n";

// <?php $fmt = new NumberFormatter( 'ru_RU', NumberFormatter::CURRENCY ); ?>
            <!-- //  $fmt->formatCurrency($total['order_cost'], "EUR")."\n";  -->

   <div class="card-single">
      <div>
         <?php foreach ($order_cost as $total) { ?>
            <h2>$ <?= $total['order_cost'] ?></h2>
         <?php } ?>
         <span>Income</span>
      </div>
      <div>
         <span class="lab la-google-wallet"></span>
      </div>
   </div>
</div>