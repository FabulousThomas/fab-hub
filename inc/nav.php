
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
       <div class="container">
          <!-- <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt=""></a> -->
          <a class="navbar-brand" href="index.php">
             <h3 class="text-capitalize mb-0"><span style="color: coral;">Fab&ndash;Hub</span></h3>
          </a>
          <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                   <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="#">Blog</a>
                </li>
                <li class="nav-item">
                   <a class="nav-link" href="contact.html">Contact Us</a>
                </li>
             </ul>
             <ul class="navbar-nav ms-auto mb-0 d-flex flex-row">
                <li class="nav-item">
                   <a class="nav-link me-lg-0 pe-lg-1" href="cart.php">
                      <i class="fas fa-shopping-bag position-relative">
                         <?php if (isset($_SESSION['total_qty']) && $_SESSION['total_qty'] != 0) { ?>
                            <span class="position-absolute top-25 start-100 translate-middle badge rounded-pill bg-danger ms-1">
                               <?= $_SESSION['total_qty'] ?>
                            </span>
                         <?php } ?>

                      </i>
                   </a>
                </li>
                <li class="nav-item ms-2">
                   <a class="nav-link" href="account.php"><i class="fas fa-user"></i></a>
                </li>
             </ul>
          </div>
       </div>
    </nav>