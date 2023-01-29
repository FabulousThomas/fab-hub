<?php

require_once "connection.php";
require_once "../function/helper.php";

if (isset($_GET['transaction_id']) && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $transaction_id = $_GET['transaction_id'];
    $order_status = 'paid';
    $user_id = $_SESSION['user_id'];
    $payment_date = date('Y-m-d H:i:s');

    // Change order status to "paid"
    $stmt = $conn->prepare("UPDATE orders SET order_status=? WHERE order_id = ?");
    $stmt->bind_param('si', $order_status, $order_id);

    if ($stmt->execute()) {
        flashMsg('change_success', 'Transaction completed');
        redirect('account.php');
    } else {
        flashMsg('change_error', 'Could not update password', 'alert alert-danger');
        redirect('account.php');
    }

    //   Save payment info
    $stmt1 = $conn->prepare("INSERT INTO payments (order_id, user_id,transaction_id,payment_date) VALUES (?,?,?,?)");
    $stmt1->bind_param("iiss", $order_id, $user_id, $transaction_id, $payment_date);

    $stmt1->execute();

    // Redirect to account page
    flashMsg('payment_message', 'Paid successfully! Thanks for shopping with us - ' . $_SESSION['user_name'], 'alert alert-success');
    redirect('../account.php?payment_message');
} else {
    redirect('../shop.php');
    exit;
}
