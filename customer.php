<?php
session_start();
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
$sql = "SELECT * FROM regions";
$result = $db->fetchAll($sql);
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
                        Customers
                    </h3>

                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data table</h4>
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $sql = "SELECT 
                                customers.id as id,
                                customers.name as name,
                                customers.email as email,
                                customers.phone_number as phone_number,
                                customers.address as address,
                                customers.preferred_pickup_day as preferred_pickup_day,
                                customers.created_at as created_at,
                                customers.status as status,
                                regions.region_name FROM customers 
                                JOIN regions ON customers.region_id = customers.region_id ORDER BY created_at ASC";
                                $query = $db->fetchAll($sql);
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
                                                    <th>Name</th>
                                                    <th>Region</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Pickup Day</th>
                                                    <th>Created At</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                // var_dump($query);
                                                $i = 1;
                                                foreach ($query as $result) { ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['name'] ?>
                                                        </td>

                                                        <td>
                                                            <?= $result['region_name'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['email'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['phone_number'] ?>
                                                        </td>
                                                        <!-- <td>
                                                            <?= $result['address'] ?>
                                                        </td> -->
                                                        <td>
                                                            <?= $result['preferred_pickup_day'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['created_at'] ?>
                                                        </td>
                                                        <td>
                                                            <button class="badge badge-success">Status</button>

                                                        </td>
                                                        <td>
                                                            <a href="customer.php?action=update&id=<?= $result['id'] ?>" class="btn btn-outline-info">Action</a>
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