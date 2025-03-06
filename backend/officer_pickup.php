<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    # code...
    $neatness_score =  trim(htmlspecialchars($_POST['neatness_score'], ENT_QUOTES, "UTF-8"));
    $comment =  trim(htmlspecialchars($_POST['comment'], ENT_QUOTES, "UTF-8"));
    $status =  trim(htmlspecialchars($_POST['status'], ENT_QUOTES, "UTF-8"));
    $id =  trim(htmlspecialchars($_POST['id'], ENT_QUOTES, "UTF-8"));
    $action =  trim(htmlspecialchars($_POST['action'], ENT_QUOTES, "UTF-8"));
    $customer_id =  trim(htmlspecialchars($_POST['customer_id'], ENT_QUOTES, "UTF-8"));

    if ($action == "update") {
        if ($neatness_score == "" || $comment == '' || $status == '') {
            $error_message = "Required field can not be empty";
            header("Location: ../officer_pickup.php?error=" . $error_message);
        }
        if ($status !== "completed") {
            $error_message = "You have allowed to complete the pickup";
            header("Location: ../officer_pickup.php?error=" . $error_message);
        } else {

            $updateData = $db->execute("UPDATE pickup_records SET neatness_score=:neatness_score,comment=:comment, status =:status WHERE id = :id", [
                "neatness_score" => $neatness_score,
                "comment" => $comment,
                "status" => $status,
                'id' => $id
            ]);

            //allocate Reward for customer
            $db->execute("INSERT INTO rewards (customer_id, total_points, amount, month_year) VALUES (:customer_id,:total_points,:amount,:month_year)", [
                'customer_id' => $customer_id,
                'total_points' => $neatness_score,
                'amount' => $neatness_score * 0.50,
                'month_year' => date('Y-m'),
            ]);
            header("Location: job/fine_sys.php?customer_id=" . $customer_id);
        }
    } else {
        $error_message = "Action not define, contact support";
        header("Location: ../officer_pickup.php?error=" . $error_message);
    }
}
