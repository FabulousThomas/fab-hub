<?php include "inc/head.php"; ?>
<title>Fab&ndash;Hub | Register</title>

<?php
require_once "server/connection.php";
require_once "function/helper.php";

if (isset($_SESSION['isLoggedIn'])) {
    redirect('account.php');
}

if (isset($_POST['btn-reg'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        flashMsg('error', 'Passwords do not match', 'alert alert-danger');
    } else if (strlen($password) < 6) {
        flashMsg('error', 'Passwords must be at least 6 characters', 'alert alert-danger');
    } else {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($num_rows);
        $stmt->store_result();
        $stmt->fetch();

        if ($num_rows != 0) {
            flashMsg('error', 'This email already exists', 'alert alert-danger');
        } else {
            $stmt1 = $conn->prepare("INSERT INTO users (user_name, user_email, user_password)
                                    VALUES (?,?,?)");
            $stmt1->bind_param('sss', $name, $email, md5($password));

            if ($stmt1->execute()) {
                $user_id = $stmt->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['isLoggedIn'] = true;
                flashMsg('success', 'Account created successfully');
                redirect('account.php');
            } else {
                flashMsg('error', 'Account could not be created at the moment');
            }
        }
    }
}


?>

<body>

    <!-- NAVBAR -->
    <?php include "inc/nav.php"; ?>

    <!-- REGISTER -->
    <section class="my-5 py-5">
        <div class="container mt-3 pt-5 text-center">
            <h2 class="font-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>

        <div class="container col-lg-5 col-12 mx-auto text-center">
            <form action="register.php" method="POST" id="form" enctype="multipart/form-data">
                <h5><?php flashMsg('error'); ?></h5>
                <div class="form-group mb-2">
                    <label for="name" class="m-0">Name</label>
                    <input type="name" class="form-control" id="reg-name" name="name" placeholder="Name" required>
                </div>
                <div class="form-group mb-2">
                    <label for="email" class="m-0">Email</label>
                    <input type="email" class="form-control" id="reg-email" name="email" placeholder="Email" inputmode="email" required>
                </div>
                <div class="form-group mb-2">
                    <label for="password" class="m-0">Password</label>
                    <input type="password" class="form-control" id="reg-password" name="password" placeholder="Password" inputmode="password" required>
                </div>
                <div class="form-group mb-2">
                    <label for="cpassword" class="m-0">Confirm Password</label>
                    <input type="password" class="form-control" id="reg-cpassword" name="cpassword" placeholder="Confirm Password" inputmode="password" required>
                </div>
                <div class="form-group mb-2">
                    <input type="submit" class="btn-orange w-100" id="btn" name="btn-reg" value="Register">
                </div>
                <div class="form-group">
                    <a href="login.php" class="btn-orange-outline">Do you have an account? Login</a>
                </div>
            </form>
        </div>
    </section>




    <!-- FOOTER -->
    <?php include "inc/footer.php"; ?>
</body>

</html>