<?php
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
// echo "Hello world";
$fileName = ROOT_PATH . "backend/job/csv/8thDatabase.csv";
if (($handle = fopen($fileName, 'r')) !== false) {
    $headers = fgetcsv($handle);
    while (($data = fgetcsv($handle)) !== false) {
        $row = array_combine($headers, $data);
        // print_r($row); // or process each row
        $db->execute("INSERT INTO gmc (FirstName, LastName, Email, Country, Phone) VALUES (:FirstName,:LastName,:Email,:Country,:Phone)", [
            'FirstName' => $row['first_name'],
            'LastName' => $row['last_name'],
            'Email' => $row['email'],
            'Country' => $row['country'],
            'Phone' => $row['phone'],
        ]);
    }
    fclose($handle);
    echo "CSV imported successfully.";
} else {
    echo "Error in handling file";
}
