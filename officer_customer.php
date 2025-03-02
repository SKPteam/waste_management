<?php
session_start();
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

$officer_id = $_SESSION['id'];
$sql = "SELECT * FROM officer_regions WHERE officer_id=:officer_id";
$officerRegion = $db->fetchAll($sql, [
    'officer_id' => $officer_id
]);
if (!$db->CheckLogin()) {
    header("Location: index.php");
}
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}

if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}
?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php require_once(ROOT_PATH . 'includes/top-nav.php');
        require_once(ROOT_PATH . 'includes/nav.php');
        ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">
                    </h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= (isset($_GET['action']) && $_GET['action'] == "update" ? "Update Pickup" : "My Pickups")
                                                ?></h4>
                        <div class="row">


                            <div class="col-12">
                                <?php
                                $id = $_SESSION['id'];
                                $sql = "SELECT * FROM officer_regions WHERE officer_id =:officer_id ORDER BY created_at ASC";
                                $query = $db->fetchAll($sql, [
                                    'officer_id' => $id
                                ]);
                                if (empty($query)) { ?>
                                    <div class="alert alert-fill-danger" role="alert">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        No Data available
                                    </div>
                                <?php } else { ?>
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th>S/N </th>
                                                    <th>Customer</th>
                                                    <th>Category Bin</th>
                                                    <th>Pickup Day</th>
                                                    <th>Neatness Score</th>
                                                    <th>Comment</th>
                                                    <th>Created At</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                // var_dump($query);
                                                // exit;
                                                $i = 1;
                                                foreach ($query as $result) { ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['officer_id'] ?? '' ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['customer_id'] ?? '' ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['preferred_pickup_day'] ?? '' ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['phone_number'] ?? '' ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['address'] ?? '' ?>
                                                        </td>
                                                        <td>
                                                            <?= date('d-m-Y', strtotime($result['created_at'])) ?>
                                                        </td>
                                                        <td>
                                                            <!-- <?php
                                                                    if ($result['status'] == 1) { ?>
                                                                <button class="badge badge-success"><?= ucfirst($result['status']) ?></button>
                                                            <?php } else { ?>
                                                                <button class="badge badge-danger">Disabled</button>
                                                            <?php } ?> -->

                                                        </td>

                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <?php require_once(ROOT_PATH . 'includes/footer.php') ?>;
            <script src="assets/js/data-table.js"></script>