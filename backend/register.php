<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {

    $name =  trim(htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"));
    $email =  trim(htmlspecialchars($_POST['email'], ENT_QUOTES, "UTF-8"));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
    $region =  trim(htmlspecialchars($_POST['region_id'], ENT_QUOTES, "UTF-8"));
    $address =  trim(htmlspecialchars($_POST['address'], ENT_QUOTES, "UTF-8"));
    $phone_number =  trim(htmlspecialchars($_POST['phone_number'], ENT_QUOTES, "UTF-8"));
    $pickup_date =  trim(htmlspecialchars($_POST['pickup_date'], ENT_QUOTES, "UTF-8"));

    if (
        $name == "" || $email == '' || $region == ''
        || $address == '' || $password == ''
        || $phone_number == '' || $pickup_date == ''
    ) {
        $error_message = "Required field can not be empty";
        header("Location: ../register.php?error=" . $error_message);
    } else {
        $sql = "SELECT email, password FROM admins WHERE email = :email";
        $query = $db->fetch($sql, ['email' => $email]);
        if (empty($$query)) {
            $insertData = $db->execute("INSERT INTO customers (name, region_id,email,password,address,phone_number,pickup_date) VALUES(:name, :region_id,:email,:password,:address,:phone_number,:pickup_date)", [
                "name" => $name,
                "region_id" => $region,
                "email" => $email,
                "password" => md5($password),
                "address" => $address,
                "phone_number" => $phone_number,
                "pickup_date" => $pickup_date,
            ]);

            if ($insertData) {
                $db->execute("INSERT INTO region_customers (customer_id, region_id) VALUES(:customer_id,:region_id)", [
                    "customer_id" => $db->lastInsertId(),
                    "region_id" => $region,
                ]);
                $success_message = "New region created";
                header("Location: ../index.php?success=" . $success_message);
            } else {
                $error_message = "Unable to create region, contact support";
                header("Location: ../register.php?error=" . $error_message);
            }
        } else {
            $error_message = "Email already exists";
            header("Location: ../register.php?error=" . $error_message);
        }
    }
}
