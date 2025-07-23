<?php
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
// echo "Hello world";
$fileName = ROOT_PATH . "backend/job/csv/17th.csv";
if (($handle = fopen($fileName, 'r')) !== false) {
    $headers = fgetcsv($handle);
    while (($data = fgetcsv($handle)) !== false) {
        $row = array_combine($headers, $data);
        print_r($row); // or process each row
        $existingEmail = $db->fetch("SELECT * FROM gmc WHERE Email = :Email", ['Email' => $row['Email Address']]);
        if (empty($existingEmail)) {
            $db->execute("INSERT INTO gmc (FirstName, LastName, Email, Country, Phone) VALUES (:FirstName,:LastName,:Email,:Country,:Phone)", [
                'FirstName' => $row['First Name'],
                'LastName' => $row['Last Name'],
                'Email' => $row['Email Address'],
                'Country' => $row['Country'],
                'Phone' => $row['phone_number'] ?? null,
            ]);
        } else {
            print_r($existingEmail);
            continue;
        }
    }
    fclose($handle);
    echo "CSV imported successfully.";
} else {
    echo "Error in handling file";
}
