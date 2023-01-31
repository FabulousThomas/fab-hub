<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Checkout</title>

<?php
require_once "function/helper.php";

if (empty($_SESSION['cart']) && !isset($_POST['checkout'])) {
    redirect('index.php');
} else {
    if (!isset($_SESSION['isLoggedIn'])) {
        flashMsg('login_to_continue', 'Please LogIn to continue', 'alert alert-info');
        redirect('login.php?login_to_continue');
    }
}
?>

<body>
    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- CHECKOUT -->
    <section class="my-5 py-5">
        <div class="container mt-3 pt-4 text-center">
            <h2 class="font-weight-bold">Checkout</h2>
            <hr class="mx-auto">
        </div>

        <div class="checkout container col-lg-8 col-12 mx-auto text-start">
            <form action="server/place_order.php" method="POST" id="form" enctype="multipart/form-data">
                <div class="form-group mb-2 row">
                    <div class="col-md-6">
                        <label for="name" class="m-0">Name</label>
                        <input type="name" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="m-0">Email</label>
                        <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" inputmode="email" required>
                    </div>
                </div>
                <div class="form-group mb-2 row">
                    <div class="col-md-6">
                        <label for="phone" class="m-0">Phone</label>
                        <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone Number" required>
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="m-0">City</label>
                        <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="address" class="m-0">Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                </div>

                <div class="form-group mb-2 text-end">
                    <small class="d-block font-weight-bold">Total amount: <span style="color: var(--bg-orange); font-weight: bolder;">$ <?= $_SESSION['total'] ?></span></small>
                    <input type="submit" class="btn-orange" name="place_order" value="Continue">
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <?php include "inc/footer.php"; ?>
</body>

</html>