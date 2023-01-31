<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Payment</title>
<?php
// session_start();
require_once "function/helper.php";

if (!isset($_SESSION['isLoggedIn'])) {
    redirect('login.php');
    exit;
}

if (isset($_POST['btn-pay-order'])) {
    // $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];
    $order_total_price = $_POST['order_total_price'];
}
?>


<body>
    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- CHECKOUT -->
    <section class="my-5 py-5 d-flex flex-column align-items-center justify-content-center">
        <div class="container mt-3 pt-4 text-center">
            <h2 class="font-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>

        <div class="checkout container col-lg-8 col-12 mx-auto text-center">

            <?php if (isset($_POST['order_status']) && $_POST['order_status'] == 'not paid') { ?>
                <?php $amount = strval($_POST['order_total_price']); ?>
                <?php $order_id = $_POST['order_id']; ?>
                <h2>You have an unpaid order</h2>
                <h4>Your payment:
                    <span style="color: var(--bg-orange); font-weight: bolder;">$ <?= $_POST['order_total_price'] ?></span>
                </h4>

                <!-- Set up a container element for the button -->
                <div class="py-4" id="paypal-button-container"></div>

            <?php } else if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
                <?php $amount = strval($_SESSION['total']); ?>
                <?php $order_id = $_SESSION['order_id']; ?>
                <h2>Your order is placed successfully!</h2>
                <h4>Your payment:
                    <span style="color: var(--bg-orange); font-weight: bolder;">$ <?= $_SESSION['total'] ?></span>
                </h4>

                <!-- Set up a container element for the button -->
                <div class="py-4 text-center" id="paypal-button-container"></div>

            <?php } else { ?>
                <h2>You don't have an order</h2>
                <button class="btn-orange mt-4" type="button" onclick="window.location.href='order_details.php#orders';">Your Orders</button>
                <div class="text-center pt-4">
                    <button class="btn-orange" type="button" onclick="window.location.href='shop.php';">Continue Shopping</button>
                </div>
            <?php } ?>

        </div>
    </section>


    <!-- PAYPAL PAYMENT INTEGRATION -->
    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=Ae_d_PYfdXSPRDd9fFkX28vsbb9HOfqY5--5GpT7SfaPh97osu3aBzXBNxDTW8zPjTYpHFU0NweN7uvp&currency=USD"></script>

    <script>
        paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $amount; ?>' // Can also reference a variable or function
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);

                    window.location.href = "server/complete_payment.php?transaction_id=" + transaction.id + "&order_id=" + <?= $order_id ?>;
                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }
        }).render('#paypal-button-container');
    </script>

    <!-- FOOTER -->
    <?php include "inc/footer.php"; ?>
</body>

</html>