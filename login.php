<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Login</title>

<?php

require_once "server/connection.php";
require_once "function/helper.php";

session_start();

if (isset($_SESSION['isLoggedIn'])) {
    redirect('account.php');
}

if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $password);

    if ($stmt->execute()) {
        $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
        $stmt->store_result();

        if ($stmt->num_rows() == 1) {
            $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['isLoggedIn'] = true;
            flashMsg('success', 'Welcome ' . '-' . $_SESSION['user_name'] . '-');
            redirect('account.php');
        } else {
            flashMsg('error', 'Could not verify your account. Check your details', 'alert alert-danger');
        }
    } else {
        flashMsg('error', 'Something went wrong', 'alert alert-danger');
    }
}


?>

<body>

    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- LOGIN -->
    <section class="my-5 py-5">
        <div class="container mt-3 pt-2 text-center">
            <h2 class="font-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>

        <div class="container col-lg-5 col-12 mx-auto text-center">
            <form action="login.php" method="POST" id="form" enctype="multipart/form-data">
                <p><?php flashMsg('error'); ?></p>

                <?php if (isset($_GET['login_to_continue'])) : ?>
                    <p> <?php flashMsg('login_to_continue'); ?> </p>
                <?php endif; ?>
                <div class="form-group mb-2">
                    <label for="email" class="m-0">Email</label>
                    <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" inputmode="email" required>
                </div>
                <div class="form-group mb-2">
                    <label for="password" class="m-0">Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" inputmode="password" required>
                </div>
                <div class="form-group mb-2">
                    <input type="submit" class="btn-orange w-100" id="btn" name="btn-login" value="Login">
                </div>
                <div class="form-group">
                    <a href="register.php" class="btn-orange-outline">Don't have an account? Register</a>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <?php include "inc/footer.php"; ?>
</body>

</html>