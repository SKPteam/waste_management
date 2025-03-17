<?php 
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');

$db = new Database();

if (isset($_GET['country_id'])) {
    $country_id = $_GET['country_id'];

    $sql = "SELECT * FROM states WHERE country_id = :country_id";
    $query = $db->fetchAll($sql, ['country_id' => $country_id]);

    if (!empty($query)) {
        echo json_encode([
            'message' => 'Data retrieved successfully',
            'data' => $query
        ]);
    } else {
        echo json_encode([
            'message' => 'No data found',
            'data' => []
        ]);
    }
} else {
    echo json_encode([
        'message' => 'Invalid request. country_id is required',
        'data' => null
    ]);
}

exit;
