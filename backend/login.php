<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
    $role =  trim(htmlspecialchars($_POST['role'], ENT_QUOTES, "UTF-8"));
    // echo $_POST['role'];
    if ($email == "" || $password == "" || $role == "") {
        $error_message = "Required field can not be empty";
    } else {
        if ($role == "admin") {
            //Admin Login

            $sql = "SELECT id,email, password FROM admins WHERE email = :email";
            $query = $db->fetch($sql, ['email' => $email]);
            if (empty($query)) {
                $error_message = "Invalid credentials,Kindly check.";
                header("Location: ../index.php?error=" . $error_message);
            } else {
                if (!isset($_SESSION['last_login_time'])) {
                    $_SESSION['id'] = $query['id'];
                    $_SESSION['role'] = "admin";
                    $_SESSION['name'] = "Administrator";
                    $_SESSION['email'] = $query['email'];
                    $_SESSION['last_login_time'] = time();
                    header("Location: ../dashboard.php");
                } else {
                    header("Location: ../dashboard.php");
                }
                // var_dump($query);
            }
        } elseif ($role == "officer") {
            //Login to Officer
            $sql = "SELECT id,name,email, password FROM officers WHERE email = :email";
            $query = $db->fetch($sql, ['email' => $email]);
            if (empty($query)) {
                $error_message = "Invalid credentials,Kindly check.";
                header("Location: ../index.php?error=" . $error_message);
            } else {
                if (!isset($_SESSION['last_login_time'])) {
                    $_SESSION['id'] = $query['id'];
                    $_SESSION['role'] = "officer";
                    $_SESSION['name'] = $query['name'];
                    $_SESSION['email'] = $query['email'];
                    $_SESSION['last_login_time'] = time();
                    header("Location: ../dashboard.php");
                } else {
                    header("Location: ../dashboard.php");
                }
                // var_dump($query);
            }
        } elseif ($role == "customer") {
            $sql = "SELECT id,email, password FROM customers WHERE email = :email";
            $query = $db->fetch($sql, ['email' => $email]);
            if (empty($query)) {
                $error_message = "Invalid credentials,Kindly check.";
                header("Location: ../index.php?error=" . $error_message);
            } else {
                if (!isset($_SESSION['last_login_time'])) {
                    $_SESSION['id'] = $query['id'];
                    $_SESSION['role'] = "customer";
                    $_SESSION['name'] = $query['name'];
                    $_SESSION['email'] = $query['email'];
                    $_SESSION['last_login_time'] = time();
                    header("Location: ../dashboard.php");
                } else {
                    header("Location: ../dashboard.php");
                }
                // var_dump($query);
            }
        } else {
            $error_message = "Select an account type";
            header("Location: ../index.php?error=" . $error_message);
        }
    }
}
