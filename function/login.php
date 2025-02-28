<?php
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}

if (isset($_POST['submit'])) {
    $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
    $role =  trim(htmlspecialchars($_POST['role'], ENT_QUOTES, "UTF-8"));

    if ($email == "" || $password == "" || $role == "") {
        $error_message = "Required field can not be empty";
    } else {
        if ($role == "admin") {
            //Admin Login
            var_dump($role);
            exit();

            $sql = "SELECT email, password, role FROM admins WHERE email = :email";
            $query = $db->fetch($sql, ['email' => $email]);
            var_dump($query);
        } elseif ($role == "officers") {
            //Login to Officer
        } elseif ($role == "customer") {
            //Login as Customer
        } else {
            $error_message = "Select an account type";
        }
    }
}
