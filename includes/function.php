<?php
class Database
{
    private $host = "localhost";
    private $dbname = "waste_mgs";
    private $username = "root";
    private $password = "";
    private $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            $this->createRegionTable();
            $this->createBinCategoryTable();
            $this->createCustomerTable();
            $this->createOfficersTable();
            $this->createPickUpRecordsTable();
            $this->createRewardsTable();
            $this->createFinesTable();
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }


    // Create users table if it doesn't exist
    private function createRegionTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS regions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            region_name VARCHAR(255) NOT NULL,
            region_code VARCHAR(255) UNIQUE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    // Create users table if it doesn't exist
    private function createBinCategoryTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS bin_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            status BOOLEAN NOT NULL DEFAULT TRUE
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    // Create Customer table if it doesn't exist
    private function createCustomerTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS customers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                address VARCHAR(255) NOT NULL,
                phone_number VARCHAR(255)  NULL,
                pickup_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                status BOOLEAN NOT NULL DEFAULT TRUE
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $this->pdo->exec($sql);
    }

    // Create Customer table if it doesn't exist
    private function createOfficersTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS officers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                status BOOLEAN NOT NULL DEFAULT TRUE
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $this->pdo->exec($sql);
    }

    // Create PickUpRecords table if it doesn't exist
    private function createPickUpRecordsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS pickup_records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                officer_id INT NOT NULL,
                bin_category_id INT NOT NULL,
                pickup_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                neatness_score INT NOT NULL DEFAULT 1,
                comment VARCHAR(5000) NULL,
                status ENUM('pending', 'completed', 'canceled','missed') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $this->pdo->exec($sql);
    }

    // Create Rewards table if it doesn't exist
    private function createRewardsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS rewards (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                total_points INT NOT NULL DEFAULT 0,
                amount DOUBLE(10,2) NOT NULL DEFAULT 0,
                month_year VARCHAR(200) NULL,
                status ENUM('pending', 'completed', 'canceled','missed') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $this->pdo->exec($sql);
    }

    // Create Fines table if it doesn't exist
    private function createFinesTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS fines (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                date_of_fine TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                amount DOUBLE(10,2) NOT NULL DEFAULT 0,
                fine_reason VARCHAR(200) NULL,
                status ENUM('unpaid', 'paid', 'lifted') DEFAULT 'unpaid',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
        $this->pdo->exec($sql);
    }


    // Method to execute SELECT queries
    public function fetchAll($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Method to execute single row SELECT queries
    public function fetch($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // Method to execute INSERT, UPDATE, DELETE queries
    public function execute($query, $params = [])
    {
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($params);
    }

    // Get last inserted ID
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
