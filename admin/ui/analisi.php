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
    <title>LinkBay - Analisi</title>
    <?php include '../materials/head_content.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-color: #f1f1f1;">

    <?php
    $sidebar_cate = 'marketing'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <br>

        <div class="row">
            <div class="col-sm-6">

            <div class="card">
                <div class="card-header">
                    Analisi Vendite
                </div>
                <div class="card-body">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>

            </div>
            <div class="col-sm-6">

            <div class="card">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-outline-secondary">Go somewhere</a>
                </div>
            </div>

            </div>
        </div>

    </main>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile'], 
                datasets: [{
                    label: '# di Vendite',
                    data: [12, 19, 3, 5], 
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
<?php include '../materials/script.php'; ?>
</body>
</html>
