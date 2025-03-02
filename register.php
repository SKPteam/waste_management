<?php
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
$sql = "SELECT * FROM regions";
$result = $db->fetchAll($sql);
?>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">
                        <div class="brand-logo">
                            <img src="assets/images/logo.svg" alt="logo">
                        </div>

                        <?php
                        if (isset($error_message)) { ?>
                            <div class="alert alert-fill-danger" role="alert">
                                <i class="fa fa-exclamation-triangle"></i>
                                <?= $error_message ?>
                            </div>
                        <?php } else { ?>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                        <?php } ?>

                        <form class="pt-3" action="backend/register.php" method="POST">
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
                                <input type="text" name="name" required class="form-control form-control-lg" placeholder="Full name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" required class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email" required>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" required class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input type="text" name="address" required class="form-control form-control-lg" placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone_number" required class="form-control form-control-lg" placeholder="Phone Number" required>
                            </div>
                            <div class="form-group">
                                <select name="preferred_pickup_day" class="form-control form-control-lg" required>
                                    <option value="" selected disabled>Select Pickup day</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input" required>
                                        I agree to all Terms & Conditions
                                    </label>
                                </div>
                            </div>
                            <div class="mt-3">
                                <!-- <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="submit">SIGN UP</button> -->
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit" name="submit">LOGIN</button>

                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Already have an account? <a href="index.php" class="text-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<?php
require_once(ROOT_PATH . 'includes/footer.php');
?>