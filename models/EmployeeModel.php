<?php
/**
 * FILE: models/EmployeeModel.php
 * FUNGSI: Berisi semua operasi database untuk tabel employees
 */
class EmployeeModel {
    private $conn;
    private $table_name = "employees";

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // METHOD 1: Read semua employees
    public function getAllEmployees() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create employee baru
    public function createEmployee($data) {
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name,
            email, department, position, salary, hire_date) VALUES (:first_name, :last_name,
            :email, :department, :position, :salary, :hire_date)";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":first_name", $data['first_name']);
        $stmt->bindParam(":last_name", $data['last_name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":department", $data['department']);
        $stmt->bindParam(":position", $data['position']);
        $stmt->bindParam(":salary", $data['salary']);
        $stmt->bindParam(":hire_date", $data['hire_date']);
        
        return $stmt->execute();
    }

    // METHOD 3: Update employee
    public function updateEmployee($id, $data) {
        $query = "UPDATE " . $this->table_name . "
                  SET first_name = :first_name, last_name = :last_name,
                      email = :email, department = :department,
                      position = :position, salary = :salary, hire_date = :hire_date
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":first_name", $data['first_name']);
        $stmt->bindParam(":last_name", $data['last_name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":department", $data['department']);
        $stmt->bindParam(":position", $data['position']);
        $stmt->bindParam(":salary", $data['salary']);
        $stmt->bindParam(":hire_date", $data['hire_date']);
        
        return $stmt->execute();
    }

    // METHOD 4: Delete employee
    public function deleteEmployee($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // METHOD 5: Get single employee by ID
    public function getEmployeeById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // METHOD 6: Get data dari VIEW employee_summary
    public function getEmployeeSummary() {
        $query = "SELECT * FROM employee_summary";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 7: Get data dari VIEW department_stats
    public function getDepartmentStats() {
        $query = "SELECT * FROM department_stats";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 8: Get data dari MATERIALIZED VIEW dashboard_summary
    public function getDashboardSummary() {
        $query = "SELECT * FROM dashboard_summary";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // METHOD 9: Refresh materialized view
    public function refreshDashboard() {
        $query = "REFRESH MATERIALIZED VIEW dashboard_summary";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }
    
    // METHOD 10: Menampilkan Rata-rata gaji, gaji tertinggi, gaji terendah per departemen
    public function getSalaryStat(): mixed
    {
        $query = "SELECT department,
                    ROUND (AVG(salary), 2) as avg_salary,
                    MAX (salary) as max_salary,
                    MIN(salary) as min_salary
                    FROM employees
                    GROUP BY department
                    ORDER BY department DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>