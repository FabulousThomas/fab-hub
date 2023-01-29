<?php
include "server/connection.php";

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='featured' LIMIT 4");

$stmt->execute();

$featured_product = $stmt->get_result();
