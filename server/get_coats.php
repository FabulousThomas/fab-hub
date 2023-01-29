<?php
include "server/connection.php";

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='dresses' LIMIT 4");

$stmt->execute();

$coat_product = $stmt->get_result();
