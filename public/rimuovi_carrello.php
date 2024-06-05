<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['titolo']) && isset($_SESSION['carrello'])) {
        $titolo = htmlspecialchars($_POST['titolo'], ENT_QUOTES, 'UTF-8');
        foreach ($_SESSION['carrello'] as $index => $item) {
            if ($item['titolo'] === $titolo) {
                unset($_SESSION['carrello'][$index]);
                $_SESSION['carrello'] = array_values($_SESSION['carrello']); // Re-indicizza l'array
                break;
            }
        }
    }
}

header("Location: ../cart");
exit();
?>