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
    <title>LinkBay - Editor Negozio</title>
    <?php include '../materials/head_content.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php
    $sidebar_cate = 'negozio'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-inline">Crea e Gestisci le tue pagine</h4>
                    <button onclick="openPage()" class="btn btn-danger" style="float: right;">Crea Nuova Pagina</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-inline">Imposta Navbar Fissa</h5>
                            <a href="edit_page?pagename=navbar&slug=navbar" target="__blank" class="btn btn-primary" style="float: right;">Imposta</a>
                            <hr>
                            <h5 class="d-inline">Imposta Footer Fisso</h5>
                            <a href="edit_page?pagename=footer&slug=footer" target="__blank" class="btn btn-primary" style="float: right;">Imposta</a>
                        </div>
                    </div>
                    <br>
                </div>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                if($row['page_name']=='home') { 
                                    $pagename = 'Home Page'; 
                                } elseif($row['page_name']=='aboutus') {
                                    $pagename = 'Chi Siamo';
                                } elseif($row['page_name']=='contacts') {
                                    $pagename = 'Contattaci';
                                } elseif($row['page_name']=='services') {
                                    $pagename = 'Servizi';
                                } elseif($row['page_name']=='landing') {
                                    $pagename = 'Landing Page';
                                } else {
                                    $pagename = $row['page_name'];
                                } 
                                ?>
                                <h2 class="card-title"><?php echo $pagename; ?></h2>
                                <h5 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="card-text"><small class="text-muted">Keywords: <?php echo htmlspecialchars($row['keywords']); ?></small></p>
                                <?php if($row['page_name'] != 'home' && $row['page_name'] != 'aboutus' && $row['page_name'] != 'contacts' && $row['page_name'] != 'services' && $row['page_name'] != 'landing' && $row['page_name'] != 'prodotto' && $row['page_name'] != 'cart' && $row['page_name'] != 'catalogs'): ?>
                                    <button class="btn btn-danger" onclick="modificaSEO(<?php echo $row['id']; ?>)" ><i class="fa-solid fa-pen-to-square"></i> Modifica SEO</button>
                                    <a href="edit_page?pagename=<?php echo htmlspecialchars($row['page_name']); ?>&slug=<?php echo htmlspecialchars($row['slug']); ?>" target="__blank" class="btn btn-primary"><i class="fa-solid fa-file-pen"></i> Modifica Pagina</a>
                                    <a href="../../<?php echo htmlspecialchars($row['page_name']); ?>?slug=<?php echo htmlspecialchars($row['slug']); ?>" target="__blank" class="btn btn-secondary"><i class="fa-solid fa-eye"></i> Visualizza Online</a>
                                    <button class="btn btn-danger" onclick="cancellaPagina(<?php echo $row['id']; ?>)"><i class="fa-solid fa-trash"></i></button>
                                <?php else : ?>
                                    <button class="btn btn-danger" onclick="modificaSEO(<?php echo $row['id']; ?>)" ><i class="fa-solid fa-pen-to-square"></i> Modifica SEO</button>
                                    <a href="edit_page?pagename=<?php echo htmlspecialchars($row['page_name']); ?>&slug=<?php echo htmlspecialchars($row['slug']); ?>" target="__blank" class="btn btn-primary"><i class="fa-solid fa-file-pen"></i> Modifica Pagina</a>
                                    <a href="../../<?php echo htmlspecialchars($row['page_name']); ?>?slug=<?php echo htmlspecialchars($row['slug']); ?>" target="__blank" class="btn btn-secondary"><i class="fa-solid fa-eye"></i> Visualizza Online</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <br>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 999;"></div>
    </main>

    <script>
        function modificaSEO(id){
            window.open('../ui-gestisci/modifica_seo?id=' + id, 'ModificaSEO', 'width=640,height=480');
        }
        function openPage(){
            window.open('../ui-gestisci/crea_pagina', 'CreaPagina', 'width=640,height=480');
        }
        function showAllert() {
            swal({
                title: "Funzione non consentita",
                text: "Solo i developer possono modificare il negozio.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.close(); // Chiude la finestra corrente
                }
            });
        }

        function cancellaPagina(id) {
            swal({
                title: "Sei sicuro?",
                text: "Una volta cancellata, non potrai recuperare questa pagina!",
                icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                window.location.href = '../ui-gestisci/cancella_pagina.php?id=' + id;
            }
        });
    }
    </script>
    
<?php include '../materials/script.php'; ?>
<script src="../materials/main_editor.js"></script>
</body>
</html>