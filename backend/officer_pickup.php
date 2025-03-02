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

    if ($action == "update") {
        if ($neatness_score == "" || $comment == '' || $status == '') {
            $error_message = "Required field can not be empty";
            header("Location: ../officer_pickup.php?error=" . $error_message);
        }

        $updateData = $db->execute("UPDATE pickup_records SET neatness_score=:neatness_score,comment=:comment, status =:status WHERE id = :id", [
            "neatness_score" => $neatness_score,
            "comment" => $comment,
            "status" => $status,
            'id' => $id
        ]);
        $success_message = "Pickup Updated info updated";
        header("Location: ../officer_pickup.php?success=" . $success_message);
    } else {
        $error_message = "Action not define, contact support";
        header("Location: ../officer_pickup.php?error=" . $error_message);
    }
}
