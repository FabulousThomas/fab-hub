<?php
include "server/connection.php";

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='headphones' LIMIT 4");

$stmt->execute();

$headphone_product = $stmt->get_result();
