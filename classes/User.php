<?php
class User {
    private $conn;
    private $table = 'customers'; // ✅ Your actual table name

    // ✅ Constructor — gets PDO connection from Database class
    public function __construct($db) {
        $this->conn = $db;
    }

    // ✅ Register a new customer
    public function register($data) {
    // ✅ Check if email already exists
    $check = $this->findByEmail($data['email']);
    if ($check) {
        // Return 'duplicate' instead of throwing an exception
        return 'duplicate';
    }

    // ✅ Continue registration
    $sql = "INSERT INTO {$this->table} 
            (first_name, last_name, email, password, phone, address, city, state, zip_code, country, date_created) 
            VALUES 
            (:first_name, :last_name, :email, :password, :phone, :address, :city, :state, :zip_code, :country, NOW())";

    $stmt = $this->conn->prepare($sql);

    $success = $stmt->execute([
        ':first_name' => $data['first_name'],
        ':last_name'  => $data['last_name'],
        ':email'      => $data['email'],
        ':password'   => password_hash($data['password'], PASSWORD_BCRYPT),
        ':phone'      => $data['phone'],
        ':address'    => $data['address'],
        ':city'       => $data['city'],
        ':state'      => $data['state'],
        ':zip_code'   => $data['zip_code'],
        ':country'    => $data['country']
    ]);

    return $success ? true : false;
}


    // ✅ Fetch all customers (for users.php)
    public function getAllUsers() {
        $sql = "SELECT 
                    customer_id, 
                    first_name, 
                    last_name, 
                    email, 
                    phone, 
                    city, 
                    country, 
                    date_created 
                FROM {$this->table}
                ORDER BY date_created DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Find user by email
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Login check
    public function login($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

   // ✅ Set 2FA Code
public function setTwoFactor($email, $code, $expires) {
    $sql = "UPDATE {$this->table} SET twofa_code = :code, twofa_expires_at = :expires, twofa_verified = 0 WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        ':code' => $code,
        ':expires' => $expires,
        ':email' => $email
    ]);
}

// ✅ Verify 2FA
public function verifyTwoFactor($email, $code) {
    $sql = "SELECT twofa_code, twofa_expires_at FROM {$this->table} WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['twofa_code'] == $code && strtotime($user['twofa_expires_at']) > time()) {
        // Mark as verified
        $update = $this->conn->prepare("UPDATE {$this->table} SET twofa_verified = 1 WHERE email = :email");
        $update->execute([':email' => $email]);
        return true;
    }
    return false;
}


    // ✅ Reset (resend) 2FA code if needed
    public function resendTwoFactorCode($email) {
        $newCode = rand(100000, 999999);
        $expires = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $this->setTwoFactor($email, $newCode, $expires);

        // return new code for testing/demo
        return $newCode;
    }
}
