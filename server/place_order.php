<?php
session_start();
require_once "connection.php";
require_once "../function/helper.php";

// if(!isset($_SESSION['isLoggedIn']))  {
//    redirect('login.php');
//    exit;
// }

if (isset($_POST['place_order'])) {

   // 1. get users info and store to database
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $city = $_POST['city'];
   $address = $_POST['address'];
   $order_cost = $_SESSION['total'];
   $order_status = 'not paid';
   $user_id = $_SESSION['user_id'];
   $order_date = date('Y-m-d H:i:s');

   $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_email, user_city, user_address, order_date)
                           VALUES (?,?,?,?,?,?,?,?)");
   $stmt->bind_param('isiissss', $order_cost, $order_status, $user_id, $phone, $email, $city, $address, $order_date);
   $stmt->execute();

   $order_id = $stmt->insert_id;


   // 2. get products from cart [from SESSION]
   foreach ($_SESSION['cart'] as $key => $value) {
      $product = $_SESSION['cart'][$key];

      $product_id = $product['product_id'];
      $product_name = $product['product_name'];
      $product_image = $product['product_image'];
      $product_price = $product['product_price'];
      $product_qty = $product['product_qty'];

      $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_qty, user_id, order_date)
                           VALUES (?,?,?,?,?,?,?,?)");
      $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_qty, $user_id, $order_date);
      $stmt1->execute();
   }

   $_SESSION['order_id'] = $order_id;
   redirect('../payment.php');

   // header('Location: ../payment.php?order_status=Order is placed successfully!');
}
