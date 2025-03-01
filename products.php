<?php
session_start();
if (!file_exists('conn.php')) {
    header("Location: error");
    exit();
} else {
    require_once 'app.php';
    require 'visita.php';
    require 'conn.php';
    require 'config.php';

    // Controllo dello slug
    $slug = isset($_GET['slug']) ? htmlspecialchars($_GET['slug'], ENT_QUOTES, 'UTF-8') : 'home';

    // Se lo slug è 'dashboard', controlla la sessione utente
    if ($slug === 'dashboard') {
        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: /Login");
            exit();
        }
    }

    // Controlla se l'utente è autenticato (usato per il placeholder)
    $userPlaceholder = 'ospite';
    if (isset($_SESSION['user'])) {
        $userPlaceholder = htmlspecialchars($_SESSION['user']['nome'], ENT_QUOTES, 'UTF-8');
    }

    // Caricamento contenuto in base allo slug
    $stmt = $conn->prepare("SELECT * FROM seo WHERE slug = ?");
    if ($stmt) {
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $page = $result->fetch_assoc();

        if (!$page) {
            header("Location: error.php");
            exit();
        }

        // Sostituisci il placeholder nel contenuto
        if (isset($page['content'])) {
            $page['content'] = str_replace('{{ nome }}', $userPlaceholder, $page['content']);
        }

        $limit = 6;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        // Filtro per ricerca
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $mezzo_pubblicitario = isset($_GET['mezzo_pubblicitario']) ? trim($_GET['mezzo_pubblicitario']) : '';
        $genere = isset($_GET['genere']) ? trim($_GET['genere']) : '';
        $eta = isset($_GET['eta']) ? trim($_GET['eta']) : '';
        $concessionaria = isset($_GET['concessionaria']) ? trim($_GET['concessionaria']) : '';
        $tipo_periodo = isset($_GET['tipo_periodo']) ? trim($_GET['tipo_periodo']) : '';

        // Costruzione della query dinamica con filtri
        $query = "SELECT * FROM prodotti_pubblicitari WHERE 1=1";
        $params = [];
        $types = "";

        // Aggiunta dei filtri dinamicamente
        if ($search) {
            $query .= " AND (nome LIKE ? OR slug LIKE ? OR description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $types .= "sss";
        }

        if ($mezzo_pubblicitario) {
            $query .= " AND mezzo_pubblicitario = ?";
            $params[] = $mezzo_pubblicitario;
            $types .= "s";
        }

        if ($genere) {
            $query .= " AND genere = ?";
            $params[] = $genere;
            $types .= "s";
        }

        if ($eta) {
            $query .= " AND eta = ?";
            $params[] = $eta;
            $types .= "s";
        }

        if ($concessionaria) {
            $query .= " AND concessionaria = ?";
            $params[] = $concessionaria;
            $types .= "s";
        }

        if ($tipo_periodo) {
            $query .= " AND tipo_periodo = ?";
            $params[] = $tipo_periodo;
            $types .= "s";
        }

        // Aggiunta della paginazione
        $query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        // Preparazione ed esecuzione della query
        $stmt = $conn->prepare($query);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        // Conteggio totale per la paginazione
        $count_query = "SELECT COUNT(*) as total FROM prodotti_pubblicitari WHERE 1=1";
        $stmt_count = $conn->prepare($count_query);
        $stmt_count->execute();
        $count_result = $stmt_count->get_result();
        $total_products = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_products / $limit);


    } else {
        header("Location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title'] ?? 'Acquista'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page['description'] ?? 'Acquista ora i nostri prodotti pubblicitari'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page['keywords'] ?? 'DSP'); ?>">
    <link rel="shortcut icon" href="src/media_system/favicon_site.ico" type="image/x-icon">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page['title'] ?? 'Default Title'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page['description'] ?? 'Default Description'); ?>">
    <meta property="og:image" content="src/media_system/logo_site.png">
    <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include 'marketing/market_integration.php'; ?>
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
    <div class="container mt-4">
        <div class="row">
            <!-- Contenuto centrale: Prodotti -->
            <div class="col-md-9">
                <h1 class="text-center">Prodotti Pubblicitari</h1>
                <div class="row">
                    <?php while ($product = $result->fetch_assoc()): ?>
                        <?php
                        // Recupero l'immagine del prodotto
                        $stmt_img = $conn->prepare("SELECT image_url FROM product_images WHERE product_id = ? LIMIT 1");
                        $stmt_img->bind_param('i', $product['id']);
                        $stmt_img->execute();
                        $result_img = $stmt_img->get_result();
                        $image = $result_img->fetch_assoc();
                        $product_image = $image ? $image['image_url'] : 'src/media_system/placeholder.jpg';
                        ?>
                        <div class="col-md-4">
                            <div class="card shadow-sm mb-4">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['nome']); ?></h5>
                                    <img src="<?php echo htmlspecialchars($product_image); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['nome']); ?>">
                                    <p class="card-text"><strong>Mezzo:</strong> <?php echo htmlspecialchars($product['mezzo_pubblicitario']); ?></p>
                                    <p class="card-text"><strong>Genere:</strong> <?php echo htmlspecialchars($product['genere']); ?></p>
                                    <p class="card-text"><strong>Età Target:</strong> <?php echo htmlspecialchars($product['eta']); ?></p>
                                    <a href="product_details.php?slug=<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-sm btn-primary">Dettagli</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <!-- Paginazione -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>


                       <!-- Sidebar: Filtri a sinistra -->
                       <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-header">
                        Filtra Prodotti
                    </div>
                    <div class="card-body">
                        <!-- Form di Ricerca e Filtri -->
                        <form method="GET">
                            <div class="mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Cerca per nome, slug o descrizione" value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="mb-3">
                                <select name="mezzo_pubblicitario" class="form-select">
                                    <option value="">Mezzo Pubblicitario</option>
                                    <option value="Tv" <?php echo $mezzo_pubblicitario == 'Tv' ? 'selected' : ''; ?>>Tv</option>
                                    <option value="Radio" <?php echo $mezzo_pubblicitario == 'Radio' ? 'selected' : ''; ?>>Radio</option>
                                    <option value="Quotidiani" <?php echo $mezzo_pubblicitario == 'Quotidiani' ? 'selected' : ''; ?>>Quotidiani</option>
                                    <option value="Periodici" <?php echo $mezzo_pubblicitario == 'Periodici' ? 'selected' : ''; ?>>Periodici</option>
                                    <option value="Digital" <?php echo $mezzo_pubblicitario == 'Digital' ? 'selected' : ''; ?>>Digital</option>
                                    <option value="OOH" <?php echo $mezzo_pubblicitario == 'OOH' ? 'selected' : ''; ?>>OOH</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="genere" class="form-select">
                                    <option value="">Genere</option>
                                    <option value="Uomini" <?php echo $genere == 'Uomini' ? 'selected' : ''; ?>>Uomo</option>
                                    <option value="Donne" <?php echo $genere == 'Donne' ? 'selected' : ''; ?>>Donna</option>
                                    <option value="Entrambi" <?php echo $genere == 'Entrambi' ? 'selected' : ''; ?>>Entrambi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="eta" class="form-select">
                                    <option value="">Età Target</option>
                                    <option value="Meno di 30 anni" <?php echo $eta == 'Meno di 30 anni' ? 'selected' : ''; ?>>Meno di 30 anni</option>
                                    <option value="Tra i 30 ed i 50 anni" <?php echo $eta == 'Tra i 30 ed i 50 anni' ? 'selected' : ''; ?>>Tra i 30 ed i 50 anni</option>
                                    <option value="Oltre i 50 anni" <?php echo $eta == 'Oltre i 50 anni' ? 'selected' : ''; ?>>Oltre i 50 anni</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="concessionaria" class="form-select">
                                    <option value="">Seleziona Concessionaria</option>
                                    <option value="Sipra" <?php echo $concessionaria == 'Sipra' ? 'selected' : ''; ?>>Sipra</option>
                                    <option value="Publitalia 80" <?php echo $concessionaria == 'Publitalia 80' ? 'selected' : ''; ?>>Publitalia 80</option>
                                    <option value="Mediamond" <?php echo $concessionaria == 'Mediamond' ? 'selected' : ''; ?>>Mediamond</option>
                                    <option value="Manzoni" <?php echo $concessionaria == 'Manzoni' ? 'selected' : ''; ?>>Manzoni</option>
                                    <option value="Piemme" <?php echo $concessionaria == 'Piemme' ? 'selected' : ''; ?>>Piemme</option>
                                    <option value="Speed" <?php echo $concessionaria == 'Speed' ? 'selected' : ''; ?>>Speed</option>
                                    <option value="CairoRCS" <?php echo $concessionaria == 'CairoRCS' ? 'selected' : ''; ?>>CairoRCS</option>
                                    <option value="Pubbliesse" <?php echo $concessionaria == 'Pubbliesse' ? 'selected' : ''; ?>>Pubbliesse</option>
                                    <option value="IGPDecaux" <?php echo $concessionaria == 'IGPDecaux' ? 'selected' : ''; ?>>IGPDecaux</option>
                                    <option value="Digitalia 08" <?php echo $concessionaria == 'Digitalia 08' ? 'selected' : ''; ?>>Digitalia 08</option>
                                    <option value="RDS adv" <?php echo $concessionaria == 'RDS adv' ? 'selected' : ''; ?>>RDS adv</option>
                                    <option value="Open Space" <?php echo $concessionaria == 'Open Space' ? 'selected' : ''; ?>>Open Space</option>
                                    <option value="Wayap" <?php echo $concessionaria == 'Wayap' ? 'selected' : ''; ?>>Wayap</option>
                                    <option value="Carminati" <?php echo $concessionaria == 'Carminati' ? 'selected' : ''; ?>>Carminati</option>
                                    <option value="Salina" <?php echo $concessionaria == 'Salina' ? 'selected' : ''; ?>>Salina</option>
                                    <option value="Publiadige" <?php echo $concessionaria == 'Publiadige' ? 'selected' : ''; ?>>Publiadige</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Filtra</button>
                                <a href="products.php" class="btn btn-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
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
    <?php require_once 'cart_edit.php'; ?>
</body>
</html>