<?php
class Auth {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function currentUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function isAdmin() {
        return !empty($_SESSION['is_admin']);
    }

    public function login($userId, $isAdmin = false) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['is_admin'] = $isAdmin;
    }

    public function logout() {
        session_destroy();
    }
}
?>
