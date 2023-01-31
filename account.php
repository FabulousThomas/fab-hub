<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Account</title>

<?php
require_once "server/connection.php";
require_once "function/helper.php";

if (!isset($_SESSION['isLoggedIn'])) {
    redirect('login.php');
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['isLoggedIn'])) {
        unset($_SESSION['isLoggedIn']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_id']);

        redirect('login.php');
    }
}

if (isset($_POST['btn-change-password'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_email = $_SESSION['user_email'];

    if ($password !== $cpassword) {
        flashMsg('change_error', 'Passwords do not match', 'alert alert-danger');
        redirect('account.php?change_error');
    } else if (strlen($password) < 6) {
        flashMsg('change_error', 'Passwords must be at least 6 characters', 'alert alert-danger');
        redirect('account.php?change_error');
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email = ?");
        $stmt->bind_param('ss', md5($password), $user_email);

        if ($stmt->execute()) {
            flashMsg('change_success', 'Password updated successfully');
            redirect('account.php?change_success');
        } else {
            flashMsg('change_error', 'Could not update password', 'alert alert-danger');
            redirect('account.php?change_error');
        }
    }
}

if (isset($_SESSION['isLoggedIn'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ");
    $stmt->bind_param('i', $user_id);

    $stmt->execute();

    $orders = $stmt->get_result();
}

?>

<body>

    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- ACCOUNT -->
    <section class="my-5 py-5">
        <div class="row container mx-auto mt-3 pt-4">
            <div class="text-center col-lg-6 col-12">
                <h4><?php flashMsg('success'); ?></h4>
                <?php if (isset($_GET['payment_message'])) { ?>
                    <p><?php flashMsg('payment_message') ?></p>
                <?php } ?>
                <h3 class="">Account Information</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Name: <span><?php if (isset($_SESSION['user_name'])) {
                                        echo $_SESSION['user_name'];
                                    } ?></span></p>
                    <p>Email: <span><?php if (isset($_SESSION['user_email'])) {
                                        echo $_SESSION['user_email'];
                                    } ?></span></p>
                    <p><a href="#orders" class="btn-orange-outline">Your Orders</a></p>
                    <p><a href="account.php?logout=1" class="btn-orange-outline">Logout</a></p>
                </div>
            </div>
            <div class="text-center col-lg-6 col-12">
                <form action="account.php" method="POST" id="form">

                    <?php if (isset($_GET['change_success'])) : ?>
                        <p> <?php flashMsg('change_success'); ?> </p>
                    <?php elseif (isset($_GET['change_error'])) : ?>
                        <p> <?php flashMsg('change_error'); ?> </p>
                    <?php endif; ?>

                    <h4>Change Password</h4>
                    <hr class="mx-auto">

                    <div class="form-group mb-2">
                        <label for="password" class="m-0">Password</label>
                        <input type="password" id="account-password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="cpassword" class="m-0">Confirm Password</label>
                        <input type="password" id="account-cpassword" class="form-control" name="cpassword" placeholder="Confirm Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" id="btn" class="btn-orange w-100" name="btn-change-password" value="Change">
                    </div>
                </form>
            </div>
        </div>
    </section>


    <!-- ORDERS -->
    <section id="orders" class="orders container">
        <div class="container pt-lg-4 pt-0 text-center">
            <h2 class="font-weight-bold text-uppercase">your orders</h2>
            <hr class="mx-auto">
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Order Id</th>
                <th>Order Cost</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Order Details</th>
            </tr>

            <?php while ($row = $orders->fetch_assoc()) : ?>
                <tr>
                    <td>
                        <span><?= $row['order_id'] ?></span>
                    </td>
                    <td>
                        <span>$ <?= $row['order_cost'] ?></span>
                    </td>
                    <td>
                        <span><?= $row['order_status'] ?></span>
                    </td>
                    <td>
                        <span><?= $row['order_date'] ?></span>
                    </td>
                    <td>
                        <form method="POST" action="order_details.php">
                            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                            <input type="hidden" name="order_status" value="<?= $row['order_status'] ?>">
                            <input type="submit" class="btn btn-sm btn-order-details" name="btn-order-details" value="Details">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

    </section>



    <!-- FOOTER -->
    <?php include "inc/footer.php"; ?>
</body>

</html>