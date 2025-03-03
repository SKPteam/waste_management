<?php
session_start();
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
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
                        Regions
                    </h3>

                </div>
                <div class="row">
                    <?php if (isset($_GET['action']) && $_GET['action'] == "update") { ?>
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
                    <?php } else { ?>
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
                                        <h4 class="card-title">Add Region information</h4>
                                    <?php } ?>
                                    <form class="forms-sample" action="backend/region.php" method="post">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Region name</label>
                                            <input type="text" name="name" required class="form-control" id="exampleInputUsername1" placeholder="Region name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputCode">Region codes</label>
                                            <input type="text" name="code" required class="form-control" placeholder="region code">
                                        </div>
                                        <input type="hidden" name="action" value="create">

                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <?php
                $sql = "SELECT * FROM regions";
                $query = $db->fetchAll($sql);
                if (empty($query)) { ?>
                    <div class="alert alert-fill-danger" role="alert">
                        <i class="fa fa-exclamation-triangle"></i>
                        No Data available
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <i class="fas fa-table"></i>
                                        Regions
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Region Name</th>
                                                    <th>region Code</th>
                                                    <th>created Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($query as $result) { ?>
                                                    <tr>
                                                        <td class="font-weight-bold">
                                                            <?= $result['region_name'] ?>
                                                        </td>
                                                        <td class="text-muted">
                                                            <?= $result['region_code'] ?>

                                                        </td>
                                                        <td>
                                                            <?= date('d-M-Y', strtotime($result['created_at'])) ?>
                                                        </td>
                                                        <td>
                                                            <a href="region.php?action=update&id=<?= $result['id'] ?>" class="badge badge-success badge-pill">Action</a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>

                                                <!-- <tr>
                                                    <td class="font-weight-bold">
                                                        Mary Payne
                                                    </td>
                                                    <td class="text-muted">
                                                        ST456
                                                    </td>
                                                    <td>
                                                        520
                                                    </td>
                                                    <td>
                                                        <label class="badge badge-warning badge-pill">Processing</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">
                                                        Adelaide Blake
                                                    </td>
                                                    <td class="text-muted">
                                                        CS789
                                                    </td>
                                                    <td>
                                                        830
                                                    </td>
                                                    <td>
                                                        <label class="badge badge-danger badge-pill">Failed</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">
                                                        Adeline King
                                                    </td>
                                                    <td class="text-muted">
                                                        LP908
                                                    </td>
                                                    <td>
                                                        579
                                                    </td>
                                                    <td>
                                                        <label class="badge badge-primary badge-pill">Delivered</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bold">
                                                        Bertie Robbins
                                                    </td>
                                                    <td class="text-muted">
                                                        HF675
                                                    </td>
                                                    <td>
                                                        790
                                                    </td>
                                                    <td>
                                                        <label class="badge badge-info badge-pill">On Hold</label>
                                                    </td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>
            <!-- content-wrapper ends -->
            <?php require_once(ROOT_PATH . 'includes/footer.php') ?>;