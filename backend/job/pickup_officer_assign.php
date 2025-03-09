<?php

require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();


//get pickup that is has not assigned

$query = $db->fetchAll("SELECT * FROM pickup_records WHERE officer_id IS NULL ");

if (!empty($query)) {
    foreach ($query as $pickup) {
        //get User region from pickup customer
        $customer = $db->fetch("SELECT id, region_id FROM customers WHERE id=:customer_id", [
            'customer_id' => $pickup['customer_id']
        ]);
        if (!empty($customer)) {
            $region_id = $customer['region_id'];
            //Check available officer using the region id
            $region_officer = $db->fetch("SELECT officer_id FROM officer_regions WHERE region_id=:region_id ORDER BY RAND() LIMIT 1", [
                'region_id' => $region_id
            ]);
            if (!empty($region_officer)) {

                //Create Officer Pick data
                $db->execute("INSERT INTO officer_pickups (officer_id, pickup_record_id) VALUES (:officer_id,:pickup_record_id)", [
                    'officer_id' => $region_officer['officer_id'],
                    'pickup_record_id' => $pickup['id'],
                ]);

                //Assign Officer to the Pick ups
                //Get Officer in the region
                $updateData = $db->execute("UPDATE pickup_records SET officer_id =:officer_id WHERE id = :id", [
                    'officer_id' => $region_officer['officer_id'],
                    'id' => $pickup['id']
                ]);
                $success_message = "New Pickup created";
                header("Location: ../../customer_pickup.php?success=" . $success_message);
            } else {
                $error_message = "Officer not found in your region, contact support";
                header("Location: ../../customer_pickup.php?error=" . $error_message);
            }
        } else {
            $error_message = "Customer not found on the system, contact support";
            header("Location: ../../customer_pickup.php?error=" . $error_message);
        }
    }
} else {
    $error_message = "Unable to assign officer, contact support";
    header("Location: ../../customer_pickup.php?error=" . $error_message);
}
