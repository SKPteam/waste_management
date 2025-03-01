<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    # code...
    $region =  trim(htmlspecialchars($_POST['region_id'], ENT_QUOTES, "UTF-8"));
    $name =  trim(htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"));
    $email =  trim(htmlspecialchars($_POST['email'], ENT_QUOTES, "UTF-8"));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
    $action =  trim(htmlspecialchars($_POST['action'], ENT_QUOTES, "UTF-8"));


    if ($action == "create") {
        if ($name == "" || $email == '' || $action == '' || $password == '' || $region == '') {
            $error_message = "Required field can not be empty";
            header("Location: ../officer.php?error=" . $error_message);
        }

        $sql = "SELECT email, password FROM officers WHERE email = :email";
        $query = $db->fetch($sql, ['email' => $email]);
        if (!empty($query)) {
            $error_message = "Officer already with email";
            header("Location: ../officer.php?error=" . $error_message);
        }
        $insertData = $db->execute("INSERT INTO officers (region_id,email,name, password) VALUES(:region_id,:email,:name,:password)", [
            "region_id" => $region,
            "email" => $email,
            "name" => $name,
            "password" => md5($password)
        ]);
        if ($insertData) {
            //Officer region
            $db->execute("INSERT INTO officer_regions (officer_id, region_id) VALUES(:officer_id,:region_id)", [
                "officer_id" => $db->lastInsertId(),
                "region_id" => $region,
            ]);
            $success_message = "New Officer created";
            header("Location: ../officer.php?success=" . $success_message);
        } else {
            $error_message = "Unable to create officer, contact support";
            header("Location: ../officer.php?error=" . $error_message);
        }
    } elseif ($action == "update") {
        $id =  trim(htmlspecialchars($_POST['id'], ENT_QUOTES, "UTF-8"));
        $sql = "SELECT password FROM officers WHERE id = :id";
        $query = $db->fetch($sql, ['id' => $id]);
        $passWord = isset($password) ? md5($password) : $query['password'];
        $updateData = $db->execute("UPDATE officers SET name=:name,password=:password WHERE id = :id", [
            "name" => $name,
            "password" => $passWord,
            'id' => $id
        ]);
        $success_message = "Officer info updated";
        header("Location: ../officer.php?success=" . $success_message);
    } else {
        $error_message = "Action not define, contact support";
        header("Location: ../office.php?error=" . $error_message);
    }
}
