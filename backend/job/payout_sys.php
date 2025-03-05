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
            # code...
        }
        var_dump($query);
    } else {
        var_dump($query);
    }
}
