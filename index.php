<?php
require_once('includes/config/path.php');
require_once(ROOT_PATH . 'includes/header.php');
require_once(ROOT_PATH . 'includes/function.php');
$admin = new Database();

//check if admin has an account
$sql = "SELECT * FROM admins";
$query = $admin->fetchAll($sql);
if (empty($query)) {
    $password = md5('0987654321');
    $sql2 = "INSERT INTO admins (email, password,created_at) VALUES('akinyemi4taiwo@gmail.com','$password', now())";
    $this->pdo->exec($sql2);
}

?>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-transparent text-left p-3">
                        <div class="brand-logo">
                            <img src="assets/images/logo.svg" alt="logo">
                        </div>
                        <h4>Welcome back!</h4>
                        <h6 class="font-weight-light">Happy to see you again!</h6>
                        <form class="pt-3" action="function/login.php" method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fa fa-user text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="email" name="email" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Email address" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail">Account Type</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fa fa-users text-primary"></i>
                                        </span>
                                    </div>
                                    <select name="role" id="" class="form-control form-control-lg" required>
                                        <option value=" customer" selected>Customer</option>
                                        <option value="officer">Officer</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                        <span class="input-group-text bg-transparent border-right-0">
                                            <i class="fa fa-lock text-primary"></i>
                                        </span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        <!-- Keep me signed in -->
                                    </label>
                                </div>
                                <a href="#" class="auth-link text-black">Forgot password?</a>
                            </div>
                            <div class="my-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">LOGIN</button>
                            </div>
                            <!-- <div class="text-center mt-4 font-weight-light">
                                Don't have an account? <a href="register-2.html" class="text-primary">Create</a>
                            </div> -->
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; 2018 All rights reserved.</p>
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