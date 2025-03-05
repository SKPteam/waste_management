<?php
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

$id = $_SESSION['id'];
$sql = "SELECT bin_categories.category_name,officers.name, pickup_records.* FROM pickup_records
                                JOIN bin_categories on pickup_records.bin_category_id = bin_categories.id
                                JOIN officers on pickup_records.officer_id = officers.id
                                WHERE customer_id =:customer_id ORDER BY created_at ASC LIMIT 5";
$query = $db->fetchAll($sql, [
    'customer_id' => $id
]);
?>

<div class="row grid-margin">
    <div class="col-12">
        <div class="card card-statistics">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fa fa-user mr-2"></i>
                            Total Pickup
                        </p>
                        <h2>0</h2>
                    </div>
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fas fa-hourglass-half mr-2"></i>
                            Fines
                        </p>
                        <h2>0.00</h2>
                    </div>
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fas fa-cloud-download-alt mr-2"></i>
                            Reward
                        </p>
                        <h2>0.00</h2>
                    </div>
                    <div class="statistics-item">
                        <p>
                            <i class="icon-sm fas fa-check-circle mr-2"></i>
                            Payout Balance
                        </p>
                        <h2>0.00</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="fas fa-table"></i>
                    Recent Pickup Records
                </h4>
                <?php
                if (empty($query)) { ?>
                    <div class="alert alert-fill-danger" role="alert">
                        <i class="fa fa-exclamation-triangle"></i>
                        No Data available
                    </div>
                <?php } else {
                ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Officer</th>
                                    <th>Category</th>
                                    <th>Pickup Day</th>
                                    <th>Neatness</th>
                                    <th>Comment</th>
                                    <th>Created Date</th>
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
                                            <?= $result['officer_id'] != '' ? ucfirst($result['name']) : 'Not Yet Assigned' ?>
                                        </td>
                                        <td class="font-weight-bold">
                                            <?= ucfirst($result['category_name']) ?>
                                        </td>
                                        <td class="text-muted">
                                            <?= $result['pickup_day'] ?>
                                        </td>
                                        <td>
                                            <?= $result['neatness_score'] ?>
                                        </td>
                                        <td>
                                            <?= $result['comment'] == '' ? 'No comment' : $result['comment'] ?>
                                        </td>
                                        <td>
                                            <?= $result['created_at'] ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($result['status'] == 'pending') { ?>
                                                <label class="badge badge-warning badge-pill"><?= ucfirst($result['status']) ?></label>
                                            <?php } elseif ($result['status'] == 'completed') { ?>
                                                <label class="badge badge-success badge-pill"><?= ucfirst($result['status']) ?></label>
                                            <?php } elseif ($result['status'] == 'canceled') { ?>
                                                <label class="badge badge-danger badge-pill"><?= ucfirst($result['status']) ?></label>
                                            <?php } elseif ($result['status'] == 'missed') { ?>
                                                <label class="badge badge-success badge-pill"><?= ucfirst($result['status']) ?></label>
                                            <?php } else { ?>
                                                <label class="badge badge-info badge-pill">Not Define</label>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                                ?>


                            </tbody>
                        </table>
                    </div>
                <?php }
                ?>

            </div>
        </div>
    </div>
</div>