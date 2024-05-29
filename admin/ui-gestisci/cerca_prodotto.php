<?php
require '../../conn.php';

if (isset($_GET['q'])) {
    $query = mysqli_real_escape_string($conn, $_GET['q']);
    $sql = "SELECT id_prodotto, titolo, prezzo, varianti FROM prodotti WHERE titolo LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="#" class="list-group-item list-group-item-action" onclick="addProductToOrder(' . $row['id_prodotto'] . ', \'' . htmlspecialchars($row['titolo'], ENT_QUOTES) . '\', ' . $row['prezzo'] . ')">' . htmlspecialchars($row['titolo']) . ' - ' .htmlspecialchars($row['varianti']) . ' - ' . $row['prezzo'] . '€</a>';
        }
    } else {
        echo '<p class="list-group-item">Nessun prodotto trovato</p>';
    }
}
?>
