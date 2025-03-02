<?php
class Database
{
    /**
     * host
     *
     * @var string
     */
    private $host = "localhost";
    /**
     * dbname
     *
     * @var string
     */
    private $dbname = "waste_mgs";
    /**
     * username
     *
     * @var string
     */
    private $username = "root";
    /**
     * password
     *
     * @var string
     */
    private $password = "";
    /**
     * pdo
     *
     * @var mixed
     */
    private $pdo;

    /**
     * __construct
     *
     * @return void
     */
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
            $this->createRegionCustomersTable();
            $this->createOfficersRegionsTable();
            $this->createCustomerPickUpsTable();
            $this->createOfficerPickUpsTable();
            $this->createBinCategoryPickUpsTable();
            $this->createStateStateTable();
            $this->createAdminsTable();
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }



    // Create admins table if it doesn't exist    

    /**
     * createRegionTable
     *
     * @return void
     */
    private function createAdminsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) UNIQUE NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }
    // Create regions table if it doesn't exist    
    /**
     * createRegionTable
     *
     * @return void
     */
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





    /**
     * createRegionTable
     *
     * @return void
     */
    private function createStateStateTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS state_regions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            region_id INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            code VARCHAR(255) UNIQUE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
        )";
        $this->pdo->exec($sql);
    }

    // Create users table if it doesn't exist    
    /**
     * createBinCategoryTable
     *
     * @return void
     */
    private function createBinCategoryTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS bin_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($sql);
    }

    // Create Customer table if it doesn't exist    
    /**
     * createCustomerTable
     *
     * @return void
     */
    private function createCustomerTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS customers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                region_id INT NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                address VARCHAR(255) NOT NULL,
                phone_number VARCHAR(255)  NULL,
                preferred_pickup_day VARCHAR(255) NOT NULL,
                status BOOLEAN DEFAULT TRUE,
                role ENUM('customer', 'admin') DEFAULT 'customer',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create Customer table if it doesn't exist    
    /**
     * createOfficersTable
     *
     * @return void
     */
    private function createOfficersTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS officers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                region_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                status BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create PickUpRecords table if it doesn't exist    
    /**
     * createPickUpRecordsTable
     *
     * @return void
     */
    private function createPickUpRecordsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS pickup_records (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                officer_id INT NULL,
                bin_category_id INT NOT NULL,
                pickup_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                neatness_score INT(10) DEFAULT 0,
                comment VARCHAR(5000) NULL,
                status ENUM('pending', 'completed', 'canceled','missed') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
                FOREIGN KEY (officer_id) REFERENCES officers(id) ON DELETE CASCADE,
                FOREIGN KEY (bin_category_id) REFERENCES bin_categories(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create Rewards table if it doesn't exist    
    /**
     * createRewardsTable
     *
     * @return void
     */
    private function createRewardsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS rewards (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                total_points INT DEFAULT 0,
                amount DECIMAL(10,2) DEFAULT 0,
                month_year VARCHAR(200) NULL,
                status ENUM('pending', 'released') DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create Fines table if it doesn't exist    
    /**
     * createFinesTable
     *
     * @return void
     */
    private function createFinesTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS fines (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                date_of_fine TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                amount DOUBLE(10,2) NOT NULL DEFAULT 0,
                fine_reason VARCHAR(200) NULL,
                status ENUM('unpaid', 'paid', 'lifted') DEFAULT 'unpaid',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create Region belongs to customer table if it doesn't exist    
    /**
     * createRegionCustomersTable
     *
     * @return void
     */
    private function createRegionCustomersTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS region_customers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT UNIQUE NOT NULL,
                region_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
                FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    // Create Region belongs to customer table if it doesn't exist    
    /**
     * createOfficersRegionsTable
     *
     * @return void
     */
    private function createOfficersRegionsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS officer_regions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                officer_id INT NOT NULL,
                region_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (officer_id) REFERENCES officers(id) ON DELETE CASCADE,
                FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    /**
     * createCustomerPickUpsTable
     *
     * @return void
     */
    private function createCustomerPickUpsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS customer_pickups (
                id INT AUTO_INCREMENT PRIMARY KEY,
                customer_id INT NOT NULL,
                pickup_record_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
                FOREIGN KEY (pickup_record_id) REFERENCES pickup_records(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    /**
     * createOfficerPickUpsTable
     *
     * @return void
     */
    private function createOfficerPickUpsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS officer_pickups (
                id INT AUTO_INCREMENT PRIMARY KEY,
                officer_id INT NOT NULL,
                pickup_record_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (officer_id) REFERENCES officers(id) ON DELETE CASCADE,
                FOREIGN KEY (pickup_record_id) REFERENCES pickup_records(id) ON DELETE CASCADE
            )";
        $this->pdo->exec($sql);
    }

    /**
     * createBinCategoryPickUpsTable
     *
     * @return void
     */
    private function createBinCategoryPickUpsTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS bin_category_pickups (
                id INT AUTO_INCREMENT PRIMARY KEY,
                bin_category_id INT NOT NULL,
                pickup_record_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (bin_category_id) REFERENCES bin_categories(id) ON DELETE CASCADE,
                FOREIGN KEY (pickup_record_id) REFERENCES pickup_records(id) ON DELETE CASCADE
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

    public function CheckLogin()
    {
        if (isset($_SESSION['last_login_time'])) {
            return true;
        } else {
            return false;
        }
    }
}
