<?php

class SessionManager {
    private $adminKey = 'admin_session';
    private $userKey = 'user_session';

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function createAdminSession(array $data) {
        $_SESSION[$this->adminKey] = $data;
    }

    public function createUserSession(array $data) {
        $_SESSION[$this->userKey] = $data;
    }

    public function getAdminSession() {
        return $_SESSION[$this->adminKey] ?? null;
    }

    public function getUserSession() {
        return $_SESSION[$this->userKey] ?? null;
    }

    public function destroyAdminSession() {
        unset($_SESSION[$this->adminKey]);
    }

    public function destroyUserSession() {
        unset($_SESSION[$this->userKey]);
    }

    public function destroyAllSessions() {
        session_unset();
        session_destroy();
    }
}
