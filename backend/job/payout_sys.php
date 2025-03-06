<?php
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_GET['customer_id']) && !empty($_GET['customer_id'])) {
    //Select all customer pick in the current month
    $customer_id = $_GET['customer_id'];
    $sql = "SELECT * FROM rewards
    WHERE customer_id =:customer_id AND status = 'pending' AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
        AND YEAR(created_at) = YEAR(CURRENT_DATE()) LIMIT 4";
    $rewards = $db->fetchAll($sql, [
        'customer_id' => $customer_id
    ]);

    if (!empty($rewards)) {
        $total_bonus = 0;
        foreach ($rewards as $reward) {
            $total_bonus += $reward['amount'];
        }
        if ($total_bonus == 10) {
            //Create a Payout 
            //allocate Reward for customer
            $db->execute("INSERT INTO payouts (customer_id, total_amount, transaction_month) VALUES (:customer_id, :total_amount, :transaction_month)", [
                'customer_id' => $customer_id,
                'total_amount' => $total_bonus,
                'transaction_month' => date('M'),
            ]);
            //update reward table for customer rewards
            foreach ($rewards as $reward) {
                $db->execute("UPDATE rewards SET status=:status WHERE id = :id", [
                    "status" => "released",
                    'id' => $reward['id']
                ]);
            }
            $success_message = "Pickup Updated info updated";
            header("Location: ../../officer_pickup.php?success=" . $success_message);
        } else {
            $success_message = "Pickup Updated info updated";
            header("Location: ../../officer_pickup.php?success=" . $success_message);
        }
    } else {
        $success_message = "Pickup Updated info updated";
        header("Location: ../../officer_pickup.php?success=" . $success_message);
    }
} else {
    $success_message = "Pickup Updated info updated";
    header("Location: ../../officer_pickup.php?success=" . $success_message);
}
