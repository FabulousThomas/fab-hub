<header class="">
   <h2 class="m-0">
      <label for="nav-toggle" class="m-0">
         <span class="las la-bars"></span>
      </label>
   </h2>
   <div class="search-wrapper">
      <span class="fas la-search"></span>
      <input type="search" placeholder="Search here...">
   </div>
   <div class="user-wrapper">
      <img src="img/prf.jpg" width="40px" height="40px" alt="Admin">

      <div class="dropdown open">
         <a class="p-1 dropdown-toggle" type="button" data-toggle="dropdown">
            Admin
         </a>
         <div class="dropdown-menu text-center border-0 shadow">
            <small>Supper Admin</small>
            <p class="m-0 border-bottom pb-1"><?php if (isset($_SESSION['user_name'])) {
            echo $_SESSION['user_name'];
            } ?></p>
            <button class="dropdown-item text-danger" onclick="window.location.href='logout.php?logout=1';">Logout</button>
         </div>
      </div>
   </div>
</header>