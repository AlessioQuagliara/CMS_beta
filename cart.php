<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';
    require_once 'cart_session.php'; // Assicura che il carrello sia caricato

    // Recuperiamo i dati del carrello dalla sessione
    $cartItems = $_SESSION['cart'] ?? [];
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

<?php
    if (function_exists('customNav')) {
        customNav();
    } else {
        echo "<p>Errore: funzione customNav non definita.</p>";
    }
?>

<br><br><br>

<div class="container mt-5">
    <h2 class="text-center mb-4">🛒 Il tuo Carrello</h2>

    <?php if (empty($cartItems)) : ?>
        <div class="alert alert-warning text-center">Il tuo carrello è vuoto.</div>
    <?php else : ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Immagine</th>
                    <th>Nome</th>
                    <th>Periodo</th>
                    <th>Slot</th>
                    <th>Spot</th>
                    <th>Prezzo</th>
                    <th>Quantità</th>
                    <th>Totale</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <?php 
                $totalAmount = 0;
                foreach ($cartItems as $key => $item) :
                    $subtotal = $item['price'] * $item['quantity'];
                    $totalAmount += $subtotal;
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" width="50"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['tipo_periodo']); ?></td>
                        <td><?php echo htmlspecialchars($item['slot']); ?></td>
                        <td><?php echo htmlspecialchars($item['spot']); ?></td>
                        <td>€<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>€<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <button class="btn btn-sm btn-danger remove-item" data-id="<?php echo $key; ?>">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-end">
            <h4>Totale: <strong>€<?php echo number_format($totalAmount, 2); ?></strong></h4>
            <button id="clear-cart" class="btn btn-danger mt-3"><i class="fa fa-trash-alt"></i> Svuota Carrello</button>
            <button class="btn btn-success mt-3"><i class="fa fa-shopping-cart"></i> Procedi al Pagamento</button>
        </div>
    <?php endif; ?>
</div>

<br><br><br><br><br><br><br><br><br><br><br>

<?php
    if (function_exists('customFooter')) {
        customFooter();
    } else {
        echo "<p>Errore: funzione customFooter non definita.</p>";
    }

    include('public/cookie_banner.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Rimozione di un singolo elemento dal carrello
    $(document).on('click', '.remove-item', function() {
        let uniqueId = $(this).data('id');

        console.log("🗑️ Tentativo di rimozione dal carrello:", uniqueId);

        $.post('remove_from_cart.php', { id: uniqueId }, function(response) {
            console.log("🔄 Risposta rimozione:", response);

            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Rimosso!',
                    text: 'Prodotto rimosso dal carrello.',
                    timer: 2000
                }).then(() => location.reload()); // Ricarica la pagina
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Errore',
                    text: 'Impossibile rimuovere il prodotto.'
                });
            }
        }, "json");
    });

    // Svuotare l'intero carrello
    $('#clear-cart').on('click', function() {
        Swal.fire({
            title: 'Sei sicuro?',
            text: "Questa operazione cancellerà tutti i prodotti dal carrello!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sì, svuota!',
            cancelButtonText: 'Annulla'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('clear_cart.php', function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Carrello svuotato!',
                            text: 'Tutti i prodotti sono stati rimossi.',
                            timer: 2000
                        }).then(() => location.reload());
                    }
                }, "json");
            }
        });
    });
});
</script>

</body>
</html>