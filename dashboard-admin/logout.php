

<?php
require_once '../session/session.php';

$session = new SessionManager();
$session->destroyAdminSession();

header('Location: ../login/admin-login.php');
exit;