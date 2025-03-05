<?php
session_start();
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
$user_id = $_SESSION['id'];

if (!$db->CheckLogin()) {
    header("Location: index.php");
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

                        <!-- <a href="customer_pickup.php?action=create" class="btn btn-info mr-2">Create Pickup</a> -->
                    </h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">FInes</h4>
                        <div class="row">

                            <div class="col-12">
                                <?php
                                $id = $_SESSION['id'];
                                $sql = "SELECT * FROM fines
                                WHERE customer_id =:customer_id ORDER BY created_at ASC";
                                $query = $db->fetchAll($sql, [
                                    'customer_id' => $id
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
                                                    <th>Date of Fine</th>
                                                    <th>Reason</th>
                                                    <th>Created At</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($query as $result) { ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= date('Y-m-d', strtotime($result['date_of_fine'])) ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['fine_reason'] ?>
                                                        </td>
                                                        <td>
                                                            <?= date('Y-m-d', strtotime($result['created_at'])) ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            if ($result['status'] == 'unpaid') { ?>
                                                                <button class="badge badge-dark">Unresolved</button>
                                                            <?php } elseif ($result['status'] == 'paid') { ?>
                                                                <button class="badge badge-success">Resolved</button>
                                                            <?php } else { ?>
                                                                <button class="badge badge-dark">Not Define</button>
                                                            <?php } ?>

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