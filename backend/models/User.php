<?php
class User {
    private $conn;
    private $table = "users";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function register($name, $email, $password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO " . $this->table . " (name, email, password, role) VALUES (:name, :email, :password, 'student')";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        
        return $stmt->execute();
    }
    
    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    public function getProfile($user_id) {
        $query = "SELECT id, name, email, role, profile_image, created_at FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateProfile($user_id, $name, $email) {
        $query = "UPDATE " . $this->table . " SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $user_id);
        return $stmt->execute();
    }
}
?>
