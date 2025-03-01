<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    # code...
    $name =  trim(htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"));
    $desc =  trim(htmlspecialchars($_POST['desc'], ENT_QUOTES, "UTF-8"));
    $action =  trim(htmlspecialchars($_POST['action'], ENT_QUOTES, "UTF-8"));
    // var_dump($name);

    if ($name == "" || $desc == '' || $action == '') {
        $error_message = "Required field can not be empty";
        header("Location: ../category_bin.php?error=" . $error_message);
    } else {
        if ($action == "create") {
            $insertData = $db->execute("INSERT INTO bin_categories (category_name, description) VALUES(:category_name, :description)", [
                'category_name' => $name,
                'description' => $desc
            ]);
            if ($insertData) {
                $success_message = "New Category created";
                header("Location: ../category_bin.php?success=" . $success_message);
            } else {
                $error_message = "Unable to create category, contact support";
                header("Location: ../category_bin.php?error=" . $error_message);
            }
        } elseif ($action == "update") {
            $id =  trim(htmlspecialchars($_POST['id'], ENT_QUOTES, "UTF-8"));

            $updateData = $db->execute("UPDATE bin_categories SET category_name =:category_name,description =:description WHERE id = :id", [
                'category_name' => $name,
                'description' => $desc,
                'id' => $id
            ]);


            $success_message = "Category updated";
            header("Location: ../category_bin.php?success=" . $success_message);
        } else {
            header("Location: ../category_bin.php?error=" . $error_message);
            $error_message = "User action not define, contact support";
        }
    }
}
