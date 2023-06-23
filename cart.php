<?php include "inc/head.php" ?>
<title>Fab&ndash;Hub | Cart</title>

<?php

if (isset($_POST['add_to_cart'])) {
    // if user has already added a product to cart
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], 'product_id');
        // checks if product already exist
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_image' => $_POST['product_image'],
                'product_price' => $_POST['product_price'],
                'product_qty' => $_POST['product_qty'],
                'product_special_offer' => $_POST['product_special_offer'],
            );

            $_SESSION['cart'][$_POST['product_id']] = $product_array;
        } else {
            echo "<script>alert('Product already added to cart')</script>";
        }
    } else {
        // if this is the first product
        $product_array = array(
            'product_id' => $_POST['product_id'],
            'product_name' => $_POST['product_name'],
            'product_image' => $_POST['product_image'],
            'product_price' => $_POST['product_price'],
            'product_qty' => $_POST['product_qty'],
            'product_special_offer' => $_POST['product_special_offer'],
        );

        $_SESSION['cart'][$_POST['product_id']] = $product_array;
    }
    // Calculate Cart Total
    calculateCartTotal();

    // Remove product from cart
} elseif (isset($_POST['remove_product'])) {
    unset($_SESSION['cart'][$_POST['product_id']]);
    echo "<script>alert('Product removed from cart')</script>";

    // Calculate Cart Total
    calculateCartTotal();
} elseif (isset($_POST['edit_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_qty = $_POST['product_qty'];

    $product_array = $_SESSION['cart'][$product_id];
    $product_array['product_qty'] = $product_qty;
    $_SESSION['cart'][$product_id] = $product_array;

    // echo "<script>alert('You updated this product quantity to $product_qty')</script>";
    // Calculate Cart Total
    calculateCartTotal();
} else {
    // header('Location: index.php');
}

function calculateCartTotal()
{
    $total = 0;
    $total_qty = 0;
    $total_offer = 0;
    $total_price = 0;

    foreach ($_SESSION['cart'] as $Key => $value) {
        $product = $_SESSION['cart'][$Key];

        $price = $product['product_price'];
        $qty = $product['product_qty'];
        $product_offer = $product['product_special_offer'];

        $total = $total + ($price * $qty);
        $total_offer = $total_offer + ($product_offer * $price * $qty) / 100;
        $total_qty = $total_qty + $qty;
        $total_price = $price * $qty;
        $total_product_offer = ($product_offer * $price * $qty) / 100;
        // $offer_total = $offer_total + $total_product_offer;
        $sum_total = $price + $total_offer;
    }

    $_SESSION['total'] = $total;
    $_SESSION['sum_total'] = $sum_total;
    $_SESSION['total_offer'] = $total_offer;
    $_SESSION['total_qty'] = $total_qty;
    $_SESSION['total_price'] = $total_price;
    $_SESSION['total_product_offer'] = $total_product_offer;
    // $_SESSION['offer_total'] = $offer_total;
    // die($total_product_offer);
}


?>

<body>
    <!-- NAVBAR -->
    <?php include "inc/nav.php" ?>

    <!-- CART -->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold text-uppercase">your cart</h2>
            <hr>
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

            <?php if (isset($_SESSION['cart'])) : ?>
                <?php foreach ($_SESSION['cart'] as $key => $value) : ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="assets/img/<?= $value['product_image'] ?>" alt="" class="">
                                <div>
                                    <p class="mb-0"><?= $value['product_name'] ?></p>
                                    <?php if ($value['product_special_offer']) : ?>
                                        <small class="font-weight-bold"><span>$</span><?= $_SESSION['total_product_offer'] ?>
                                        <?php else : ?>
                                            <small class="font-weight-bold"><span>$</span><?= $value['product_price'] ?>
                                            <?php endif; ?>
                                            <?php if (isset($value) && $value['product_special_offer'] > 0) : ?>
                                                <small class="m-0 text-danger"> &dash; <?= $value['product_special_offer'] ?>% Off sales</small>
                                            <?php endif ?>
                                            </small>
                                            <br>
                                            <form action="cart.php" method="POST">
                                                <input type="hidden" name="product_id" value="<?= $value['product_id'] ?>">
                                                <input type="submit" name="remove_product" class="btn-orange-outline" title="Remove" value="Remove">
                                            </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <form method="POST" class="cart-form">
                                <input type="hidden" name="product_id" value="<?= $value['product_id'] ?>">
                                <input type="number" name="product_qty" value="<?= $value['product_qty'] ?>" class="product_qty">
                                <input type="submit" class="btn-orange-outline" name="edit_quantity" value="Edit">
                            </form>
                        </td>
                        <td>
                            <span>$</span>
                            <?php if ($value['product_special_offer']) : ?>
                                <span class="product-price"><?= ($value['product_special_offer'] * $value['product_price'] * $value['product_qty']) / 100 ?></span>
                            <?php else : ?>
                                <span class="product-price"><?= $value['product_price'] * $value['product_qty'] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td>
                        <h3>Cart is empty</h3>
                        <a href="shop.php" class="text-center btn-orange">Continue Shopping</a>
                    </td>
                </tr>
            <?php endif; ?>

        </table>

        <?php if (isset($_SESSION['cart'])) : ?>
            <?php if (empty($_SESSION['cart'])) : ?>
                <div class="text-center pt-4">
                    <h3>Cart is empty</h3>
                    <a href="shop.php" class="text-center btn-orange">Continue Shopping</a>
                </div>
            <?php else : ?>
                <div class="cart-total">
                    <table>
                        <!-- <tr>
                            <td>Subtotal</td>
                            <td>$155.8</td>
                        </tr> -->
                        <tr>
                            <td>Total</td>
                            <td>$ <?= $_SESSION['total']; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="cart-checkout">
                    <form action="checkout.php" method="POST">
                        <input type="submit" name="checkout" value="Checkout" class="btn-orange">
                    </form>
                </div>
            <?php endif; ?>
        <?php else : ?>

        <?php endif; ?>


    </section>

    <!-- FOOTER -->
    <?php include "inc/footer.php" ?>

</body>

</html>