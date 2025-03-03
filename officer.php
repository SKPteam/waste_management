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
                        Officers
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
                                        <h4 class="card-title">Update Officer information</h4>
                                    <?php } ?>
                                    <?php

                                    $id = $_GET['id'];
                                    $sql = "SELECT name FROM officers WHERE id = :id";
                                    $query = $db->fetch($sql, ['id' => $id]);

                                    ?>
                                    <form class="forms-sample" action="backend/officer.php" method="post">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Officer name</label>
                                            <input type="text" name="name" value="<?= $query['name'] ?? '' ?>" required class="form-control" id="exampleInputUsername1" placeholder="Region name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputCode">Password</label>
                                            <input type="password" name="password" value="" class="form-control" placeholder="region code">
                                        </div>
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?= $id ?? '' ?>">
                                        <input type="hidden" name="region_id" value="<?= $query['region_id'] ?? '' ?>">
                                        <input type="hidden" name="email" value="<?= $query['email'] ?? '' ?>">

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
                                        <h4 class="card-title">Officer information</h4>
                                    <?php } ?>
                                    <form class="forms-sample" action="backend/officer.php" method="post">

                                        <div class="form-group">
                                            <select name="region_id" class="form-control form-control-lg" required>
                                                <option value="" selected disabled>Select region</option>
                                                <?php
                                                foreach ($result as $region) { ?>
                                                    <option value="<?= $region['id'] ?>"><?= $region['region_name'] ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Name</label>
                                            <input type="text" name="name" required class="form-control" id="exampleInputUsername1" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Email</label>
                                            <input type="email" name="email" required class="form-control" id="exampleInputUsername1" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputCode">Password</label>
                                            <input type="password" name="password" required class="form-control" placeholder="Password">
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
                $sql = "SELECT regions.region_name, officers.* FROM officers JOIN regions on officers.region_id = regions.id";
                $query = $db->fetchAll($sql);
                if (empty($query)) { ?>
                    <div class="alert alert-warning" role="alert">
                        No Data available
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <i class="fas fa-table"></i>
                                        Officers
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Region</th>
                                                    <th>created Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($query as $result) { ?>
                                                    <tr>
                                                        <td class="font-weight-bold">
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td class="font-weight-bold">
                                                            <?= ucfirst($result['name']) ?>
                                                        </td>
                                                        <td class="font-weight-bold">
                                                            <?= $result['email'] ?>
                                                        </td>
                                                        <td class="text-muted">
                                                            <?= $result['region_name'] ?>

                                                        </td>
                                                        <td>

                                                            <?= date('d-M-Y', strtotime($result['created_at'])) ?>
                                                        </td>
                                                        <td>
                                                            <a href="officer.php?action=update&id=<?= $result['id'] ?>" class="badge badge-success badge-pill">Action</a>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                ?>
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