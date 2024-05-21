<?php 
require ('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Campagne</title>
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
                <h4>Configura i Tuoi Strumenti Per il Marketing</h4>
            </div>
        </div>
        <br>
        <div class="row">

        </div>
    </div>
    </main>

    <script>
        function modificaSEO(id){
            window.open('../ui-gestisci/inserisci ?id=' + id, 'ModificaSEO', 'width=640,height=480');
        }
        function showAllert() {
            swal({
                title: "Funzione non consentita",
                text: "Acquistare pacchetto integrativo per poter editare il negozio.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.close();
                }
            });
        }
    </script>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
