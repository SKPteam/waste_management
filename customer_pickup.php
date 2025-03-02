<?php
session_start();
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
$sql = "SELECT * FROM bin_categories WHERE status=:status";
$result = $db->fetchAll($sql, [
    'status' => 1
]);

$user_id = $_SESSION['id'];
$sql = "SELECT customers.*, regions.* FROM region_customers 
JOIN customers ON region_customers.customer_id = customer_id
JOIN regions ON region_customers.region_id = regions.id WHERE customer_id=:customer_id";
$userRegion = $db->fetch($sql, [
    'customer_id' => $user_id
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

                        <a href="customer_pickup.php?action=create" class="btn btn-info mr-2">Create Pickup</a>
                    </h3>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= isset($_GET['action']) && $_GET['action'] == "create"
                                                    ? "Create New Pickup"
                                                    : (isset($_GET['action']) && $_GET['action'] == "update" ? "Update Pickup" : "My Pickups")
                                                ?></h4>
                        <div class="row">
                            <?php if (isset($_GET['action']) && $_GET['action'] == "create") { ?>
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            if (isset($error_message)) { ?>
                                                <div class="alert alert-fill-danger" role="alert">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                    <?= $error_message ?>
                                                </div>
                                            <?php } elseif (isset($success_message)) { ?>

                                                <div class="alert alert-fill-success" role="alert">
                                                    <i class="fa fa-check-circle"></i>
                                                    <?= $success_message ?>
                                                </div>
                                            <?php } else { ?>
                                                <h4 class="card-title">Schedule Pickup</h4>
                                            <?php } ?>

                                            <form class="forms-sample" action="backend/customer_pickup.php" method="post">

                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Region name</label>
                                                    <select name="region_id" class="form-control form-control-lg" required>
                                                        <option value="<?= $userRegion['region_id'] ?>" selected><?= $userRegion['region_name'] ?></option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Pickup Day</label>
                                                    <select name="pickup_day" class="form-control form-control-lg" required>
                                                        <option value="<?= $userRegion['preferred_pickup_day'] ?>" selected><?= $userRegion['preferred_pickup_day'] ?></option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Category Bins</label>
                                                    <select name="bin_category_id" class="form-control form-control-lg" required>
                                                        <option value="" selected disabled>Select Category Bin</option>
                                                        <?php
                                                        foreach ($result as $region) { ?>
                                                            <option value="<?= $region['id'] ?>"><?= $region['category_name'] ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Home Address</label>
                                                    <input type="text" name="address" disabled value="<?= $userRegion['address'] ?>" required class="form-control" id="exampleInputUsername1" placeholder="Region name">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Phone Number</label>
                                                    <input type="text" name="address" disabled value="<?= $userRegion['phone_number'] ?>" required class="form-control" id="exampleInputUsername1" placeholder="Region name">
                                                </div>

                                                <input type="hidden" name="action" value="create">
                                                <input type="hidden" name="customer_id" value="<?= $user_id ?>">

                                                <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif (isset($_GET['action']) && $_GET['action'] == "update") { ?>
                                <div class="col-md-6 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            if (isset($error_message)) { ?>
                                                <div class="alert alert-fill-danger" role="alert">
                                                    <i class="fa fa-exclamation-triangle"></i>
                                                    <?= $error_message ?>
                                                </div>
                                            <?php } elseif (isset($success_message)) { ?>

                                                <div class="alert alert-fill-success" role="alert">
                                                    <i class="fa fa-check-circle"></i>
                                                    <?= $success_message ?>
                                                </div>
                                            <?php } else { ?>
                                                <h4 class="card-title">Update Region information</h4>
                                            <?php } ?>
                                            <?php
                                            $id = $_GET['id'];
                                            $sql = "SELECT region_name, region_code FROM regions WHERE id = :id";
                                            $query = $db->fetch($sql, ['id' => $id]);
                                            ?>
                                            <form class="forms-sample" action="backend/region.php" method="post">
                                                <div class="form-group">
                                                    <label for="exampleInputUsername1">Region name</label>
                                                    <input type="text" name="name" value="<?= $query['region_name'] ?? '' ?>" required class="form-control" id="exampleInputUsername1" placeholder="Region name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputCode">Region codes</label>
                                                    <input type="text" name="code" value="<?= $query['region_code'] ?? '' ?>" required class="form-control" placeholder="region code">
                                                </div>
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="id" value="<?= $id ?? '' ?>">

                                                <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-12">
                                <?php
                                $id = $_SESSION['id'];
                                $sql = "SELECT bin_categories.category_name,officers.name, pickup_records.* FROM pickup_records
                                JOIN bin_categories on pickup_records.bin_category_id = bin_category_id
                                JOIN officers on pickup_records.officer_id = officer_id
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
                                                    <th>Officer</th>
                                                    <th>Category Bin</th>
                                                    <th>Pickup Day</th>
                                                    <th>Neatness Score</th>
                                                    <th>Comment</th>
                                                    <th>Created At</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
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
                                                            <?= $result['officer_id'] != '' ? $result['name'] : 'Not Yet Assigned' ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['category_name'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['pickup_day'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['neatness_score'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $result['comment'] == "" ? "No comment" : $result['comment'] ?>
                                                        </td>
                                                        <td>
                                                            <?= date('d-m-Y', strtotime($result['created_at'])) ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($result['status'] == 'pending') { ?>
                                                                <button class="badge badge-info"><?= ucfirst($result['status']) ?></button>
                                                            <?php } elseif ($result['status'] == 'completed') { ?>
                                                                <button class="badge badge-success"><?= ucfirst($result['status']) ?></button>
                                                            <?php } elseif ($result['status'] == 'canceled') { ?>
                                                                <button class="badge badge-danger"><?= ucfirst($result['status']) ?></button>
                                                            <?php } elseif ($result['status'] == 'missed') { ?>
                                                                <button class="badge badge-danger">
                                                                    <?= ucfirst($result['status']) ?>
                                                                </button>
                                                            <?php } else { ?>
                                                                <button class="badge badge-dark">Not Define</button>
                                                            <?php } ?>

                                                        </td>
                                                        <td>
                                                            <a href="customer_pickup.php?action=update&id=<?= $result['id'] ?>" class="btn btn-outline-info">Action</a>
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