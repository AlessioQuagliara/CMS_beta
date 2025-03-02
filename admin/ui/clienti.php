<?php
session_start();
require('../../app.php');
loggato();

require_once '../../config.php';
require_once '../../models/user.php';

$userModel = new UserModel($pdo);
$users = $userModel->getAllUsers(); // Recupera tutti gli utenti
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Gestione Clienti</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">

    <?php 
    $sidebar_cate = 'clienti'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <br>
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fa fa-users"></i> Gestione Clienti</h5>
                <button class="btn btn-light btn-sm" onclick="location.reload();">
                    <i class="fa fa-sync-alt"></i> Aggiorna
                </button>
            </div>
            <div class="card-body">
                <?php if (!empty($users)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID Cliente</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Data Registrazione</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr style="cursor: pointer;" onclick="window.location.href='anagrafica_cliente.php?id=<?php echo $user['id_utente']; ?>'">
                                        <td><span class="badge bg-secondary">#<?php echo $user['id_utente']; ?></span></td>
                                        <td><?php echo htmlspecialchars($user['nome'] . ' ' . $user['cognome']); ?></td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['telefono']); ?></td>
                                        <td>
                                            <?php 
                                            $date = new DateTime($user['data_registrazione']);
                                            $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
                                            echo ucfirst($formatter->format($date));
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> Nessun cliente trovato.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../materials/script.php'; ?>

</body>
</html>