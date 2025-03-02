<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    # code...
    $region_id =  trim(htmlspecialchars($_POST['region_id'], ENT_QUOTES, "UTF-8"));
    $bin_category_id =  trim(htmlspecialchars($_POST['bin_category_id'], ENT_QUOTES, "UTF-8"));
    $pickup_day =  trim(htmlspecialchars($_POST['pickup_day'], ENT_QUOTES, "UTF-8"));
    $customer_id =  trim(htmlspecialchars($_POST['customer_id'], ENT_QUOTES, "UTF-8"));
    $action =  trim(htmlspecialchars($_POST['action'], ENT_QUOTES, "UTF-8"));

    if ($region_id == "" || $bin_category_id == '' || $action == '' || $pickup_day == '') {
        $error_message = "Required field can not be empty";
        header("Location: ../customer_pickup.php?error=" . $error_message);
    } else {
        if ($action == "create") {
            $insertData = $db->execute("INSERT INTO pickup_records (customer_id, bin_category_id,pickup_day) VALUES(:customer_id,:bin_category_id,:pickup_day)", [
                'customer_id' => $customer_id,
                'bin_category_id' => $bin_category_id,
                'pickup_day' => $pickup_day
            ]);
            if ($insertData) {

                //Insert to Bin Category
                $db->execute("INSERT INTO bin_category_pickups (bin_category_id, pickup_record_id) VALUES(:bin_category_id, :pickup_record_id)", [
                    'bin_category_id' => $bin_category_id,
                    'pickup_record_id' => $db->lastInsertId(),
                ]);

                //Customer Pick Up
                $db->execute("INSERT INTO customer_pickups (pickup_record_id, customer_id) VALUES(:pickup_record_id, :customer_id)", [
                    'pickup_record_id' => $db->lastInsertId(),
                    'customer_id' => $customer_id,
                ]);

                $success_message = "New Pickup created";
                header("Location: ../customer_pickup.php?success=" . $success_message);
            } else {
                $error_message = "Unable to create region, contact support";
                header("Location: ../customer_pickup.php?error=" . $error_message);
            }
        } elseif ($action == "update") {
            $id =  trim(htmlspecialchars($_POST['id'], ENT_QUOTES, "UTF-8"));

            $updateData = $db->execute("UPDATE pickup_records SET bin_category_id =:bin_category_id WHERE id = :id", [
                'bin_category_id' => $bin_category_id,
                'id' => $id
            ]);
            $success_message = "Region updated";
            header("Location: ../customer_pickup.php?success=" . $success_message);
        } else {
            header("Location: ../customer_pickup.php?error=" . $error_message);
            $error_message = "User action not define, contact support";
        }
    }
}
