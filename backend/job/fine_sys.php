<?php
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
    //Select all customer pick in the current month
    $customer_id = $_GET['customer_id'];
    $sql = "SELECT * FROM pickup_records
    WHERE customer_id =:customer_id AND neatness_score = 0 AND status = 'completed' AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
        AND YEAR(created_at) = YEAR(CURRENT_DATE())";
    $query = $db->fetchAll($sql, [
        'customer_id' => $customer_id
    ]);

    if (!empty($query)) {
        if (count($query) >= 3) {

            //Check if customer have a fine this month or not
            $customer_id = $_GET['customer_id'];
            $sql = "SELECT * FROM pickup_records WHERE customer_id =:customer_id AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
            $existingFines = $db->fetchAll($sql, [
                'customer_id' => $customer_id
            ]);
            if (!empty($existingFines)) {
                //create a fine table
                $db->execute("INSERT INTO fines (customer_id, amount, fine_reason) VALUES (:customer_id,:amount,:fine_reason)", [
                    'customer_id' => $customer_id,
                    'amount' => 0,
                    'fine_reason' => 'You have score for 3 consecutively within a month'
                ]);
                header("Location: payout_sys.php?customer_id=" . $customer_id);
            } else {
                header("Location: payout_sys.php?customer_id=" . $customer_id);
            }
        } else {
            header("Location: payout_sys.php?customer_id=" . $customer_id);
        }
    } else {
        header("Location: payout_sys.php?customer_id=" . $customer_id);
    }
}
