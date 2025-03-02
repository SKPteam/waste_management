<?php
session_start();
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$fun = new Database();
if (!$fun->CheckLogin()) {
    header("Location: index.php");
}
?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php require_once(ROOT_PATH . 'includes/top-nav.php');
        require_once(ROOT_PATH . 'includes/nav.php');
        ?>
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->

        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                        Dashboard
                    </h3>
                </div>
                <?php
                // echo $_SESSION['role'];
                if ($_SESSION['role'] == 'admin') {
                    require_once('admin_dashboard.php');
                } elseif ($_SESSION['role'] == 'officer') {
                    require_once('officer_dashboard.php');
                } else {
                    require_once('customer_dashboard.php');
                }
                ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                        <button class="btn btn-social-icon btn-facebook btn-rounded">
                                            <i class="fab fa-facebook-f"></i>
                                        </button>
                                        <div class="ml-4">
                                            <h5 class="mb-0">Facebook</h5>
                                            <p class="mb-0">0friends</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                        <button class="btn btn-social-icon btn-twitter btn-rounded">
                                            <i class="fab fa-twitter"></i>
                                        </button>
                                        <div class="ml-4">
                                            <h5 class="mb-0">Twitter</h5>
                                            <p class="mb-0">0 followers</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                        <button class="btn btn-social-icon btn-google btn-rounded">
                                            <i class="fab fa-google-plus-g"></i>
                                        </button>
                                        <div class="ml-4">
                                            <h5 class="mb-0">Google plus</h5>
                                            <p class="mb-0">0 friends</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-social-icon btn-linkedin btn-rounded">
                                            <i class="fab fa-linkedin-in"></i>
                                        </button>
                                        <div class="ml-4">
                                            <h5 class="mb-0">Linkedin</h5>
                                            <p class="mb-0">0 connections</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <?php require_once(ROOT_PATH . 'includes/footer.php');
