<?php
namespace App\Auth;
use App\Models\User;
use App\Database;

class Auth {
    private \PDO $db;
    private User $userModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->userModel = new User();
    }

    public function register(array $data): int {
        $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->userModel->create($data);
    }

    public function login(string $email, string $password): ?array {
        $user = $this->userModel->findByEmail($email);
        if (!$user) return null;
        if (!password_verify($password, $user['password_hash'])) return null;
        return $user;
    }
}
