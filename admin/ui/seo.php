<?php 
require ('../../app.php');
loggato();
$result = $conn->query("SELECT * FROM seo");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - SEO</title>
    <?php include '../materials/head_content.php'; ?>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'marketing'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <h4>Gestisci La SEO</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title"><?php echo htmlspecialchars($row['page_name']); ?></h2>
                                <h5 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="card-text"><small class="text-muted">Keywords: <?php echo htmlspecialchars($row['keywords']); ?></small></p>
                                <button class="btn btn-danger" onclick="modificaSEO()" ><i class="fa-solid fa-file-pen"></i> Modifica</button>
                                <a href="../../<?php echo htmlspecialchars($row['page_name']); ?>?slug=<?php echo htmlspecialchars($row['slug']); ?>" target="__blank" class="btn btn-secondary"><i class="fa-solid fa-eye"></i> Visualizza Pagina</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
