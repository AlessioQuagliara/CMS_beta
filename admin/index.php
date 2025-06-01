

<?php
require_once '../session/session.php';

$session = new SessionManager();

if ($session->getAdminSession()) {
    header('Location: ../dashboard-admin/home.php');
    exit;
}

if ($session->getUserSession()) {
    header('Location: ../dashboard-user/home.php');
    exit;
}

header('Location: ../login/admin-login.php');
exit;