<?php
include "server/connection.php";

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='shoes' LIMIT 4");

$stmt->execute();

$shoe_product = $stmt->get_result();
