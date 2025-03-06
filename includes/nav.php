<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="assets/images/faces/face5.jpg" alt="image" />
                </div>
                <div class="profile-name">
                    <p class="name">
                        Welcome <?= $_SESSION['role'] == 'admin' ? 'Admin' : ucfirst($_SESSION['name']) ?>
                    </p>
                    <p class="designation">
                        <?= $_SESSION['role'] == 'admin' ? 'Administrator' : ucfirst($_SESSION['role']) ?>
                    </p>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <?php
        $role = $_SESSION['role'];
        if ($role == "admin") { ?>

            <li class="nav-item">
                <a class="nav-link" href="region.php">
                    <i class="fa fa-puzzle-piece menu-icon"></i>
                    <span class="menu-title">Regions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="customer.php">
                    <i class="fa fa-users menu-icon"></i>
                    <span class="menu-title">Customer</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="category_bin.php">
                    <i class="fa fa-suitcase menu-icon"></i>
                    <span class="menu-title">Category Bins</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="officer.php">
                    <i class="fa fa-user-circle menu-icon"></i>
                    <span class="menu-title">Officers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_reward.php">
                    <i class="far fa-credit-card menu-icon"></i>
                    <span class="menu-title">Rewards</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admin_pickup.php">
                    <i class="fa fa-truck menu-icon"></i>
                    <span class="menu-title">Pickups</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admin_fine.php">
                    <i class="fa fa-bullhorn menu-icon"></i>
                    <span class="menu-title">Fines</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="admin_payout.php">
                    <i class="fa fa-file-pdf menu-icon"></i>
                    <span class="menu-title">Payouts</span>
                </a>
            </li>
        <?php } elseif ($role == "officer") { ?>

            <!-- <li class="nav-item">
                <a class="nav-link" href="officer_customer.php">
                    <i class="fa fa-puzzle-piece menu-icon"></i>
                    <span class="menu-title">Customer</span>
                </a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link" href="officer_pickup.php">
                    <i class="fa fa-truck menu-icon"></i>
                    <span class="menu-title">Pickups</span>
                </a>
            </li>


        <?php } else { ?>

            <li class="nav-item">
                <a class="nav-link" href="customer_pickup.php">
                    <i class="fa fa-truck menu-icon"></i>
                    <span class="menu-title">Pickups</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="customer_reward.php">
                    <i class="fa fa-credit-card menu-icon"></i>
                    <span class="menu-title">Rewards</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="customer_fine.php">
                    <i class="fa fa-bullhorn menu-icon"></i>
                    <span class="menu-title">Fines</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="customer_payout.php">
                    <i class="far fa-file-pdf menu-icon"></i>
                    <span class="menu-title">Payouts</span>
                </a>
            </li>
        <?php }
        ?>

    </ul>
</nav>