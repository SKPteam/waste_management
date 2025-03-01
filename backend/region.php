<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    # code...
    $name =  trim(htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"));
    $code =  trim(htmlspecialchars($_POST['code'], ENT_QUOTES, "UTF-8"));
    $action =  trim(htmlspecialchars($_POST['action'], ENT_QUOTES, "UTF-8"));
    // var_dump($name);

    if ($name == "" || $code == '' || $action == '') {
        $error_message = "Required field can not be empty";
        header("Location: ../region.php?error=" . $error_message);
    } else {
        if ($action == "create") {
            $insertData = $db->execute("INSERT INTO regions (region_name, region_code) VALUES(:region_name, :region_code)", [
                'region_name' => $name,
                'region_code' => $code
            ]);
            if ($insertData) {
                $success_message = "New region created";
                header("Location: ../region.php?success=" . $success_message);
            } else {
                $error_message = "Unable to create region, contact support";
                header("Location: ../region.php?error=" . $error_message);
            }
        } elseif ($action == "update") {
            $id =  trim(htmlspecialchars($_POST['id'], ENT_QUOTES, "UTF-8"));

            $updateData = $db->execute("UPDATE regions SET region_name =:region_name,region_code =:region_code WHERE id = :id", [
                'region_name' => $name,
                'region_code' => $code,
                'id' => $id
            ]);


            $success_message = "Region updated";
            header("Location: ../region.php?success=" . $success_message);
        } else {
            header("Location: ../region.php?error=" . $error_message);
            $error_message = "User action not define, contact support";
        }
    }
}
