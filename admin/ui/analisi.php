<?php
require ('../../app.php');
loggato();
require ('../../conn.php');

$selectedYear = isset($_GET['anno']) ? $_GET['anno'] : date('Y');

// Recupera i dati per le vendite
$query = "SELECT data_ordine, totale_ordine, paese FROM ordini WHERE YEAR(data_ordine) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
$totals = [];
$countries = [];

while ($row = $result->fetch_assoc()) {
    $month = date('F', strtotime($row['data_ordine']));
    if (!isset($totals[$month])) {
        $totals[$month] = 0;
    }
    $totals[$month] += $row['totale_ordine'];
}

$months = array_keys($totals);
$sales = array_values($totals);

$stmt->close();

// Recupera i dati per i visitatori
$query = "SELECT data_visita FROM visitatori WHERE YEAR(data_visita) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

$visitorCounts = [];

while ($row = $result->fetch_assoc()) {
    $month = date('F', strtotime($row['data_visita']));
    if (!isset($visitorCounts[$month])) {
        $visitorCounts[$month] = 0;
    }
    $visitorCounts[$month]++;
}

$visitorMonths = array_keys($visitorCounts);
$visitorData = array_values($visitorCounts);

$stmt->close();

// Recupera i dati per i lead
$query = "SELECT data_rec FROM leads WHERE YEAR(data_rec) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

$leadCounts = [];

while ($row = $result->fetch_assoc()) {
    $month = date('F', strtotime($row['data_rec']));
    if (!isset($leadCounts[$month])) {
        $leadCounts[$month] = 0;
    }
    $leadCounts[$month]++;
}

$leadMonths = array_keys($leadCounts);
$leadData = array_values($leadCounts);

$stmt->close();
$conn->close();
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
            <div class="col-sm-12">
                <div class="card">
                    <form method="GET" action="">
                        <div class="card-header">
                            <label for="anno">Seleziona Anno:</label>
                        </div>
                        <div class="card-body">
                            <select name="anno" class="form-select" id="anno" onchange="this.form.submit()">
                                <?php
                                $currentYear = date('Y');
                                for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                    echo "<option value=\"$year\"" . ($year == $selectedYear ? ' selected' : '') . ">$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <br>
            </div>
            
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Analisi Vendite
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        Leads
                    </div>
                    <div class="card-body">
                        <canvas id="leadChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br>
                <div class="card">
                    <div class="card-header">
                        Visitatori
                    </div>
                    <div class="card-body">
                        <canvas id="visitorChart" width="800" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <br>
                <div class="card">
                    <div class="card-header">
                        Utenti Registrati
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Chart per le vendite
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: '€ di Vendite',
                    data: <?php echo json_encode($sales); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(99, 255, 132, 0.2)',
                        'rgba(162, 54, 235, 0.2)',
                        'rgba(206, 255, 86, 0.2)',
                        'rgba(192, 75, 192, 0.2)',
                        'rgba(102, 153, 255, 0.2)',
                        'rgba(159, 255, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(99, 255, 132, 1)',
                        'rgba(162, 54, 235, 1)',
                        'rgba(206, 255, 86, 1)',
                        'rgba(192, 75, 192, 1)',
                        'rgba(102, 153, 255, 1)',
                        'rgba(159, 255, 64, 1)'
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

        // Chart per i visitatori
        var visitorCtx = document.getElementById('visitorChart').getContext('2d');
        var visitorChart = new Chart(visitorCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($visitorMonths); ?>,
                datasets: [{
                    label: 'Numero di Visitatori',
                    data: <?php echo json_encode($visitorData); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(99, 255, 132, 0.2)',
                        'rgba(162, 54, 235, 0.2)',
                        'rgba(206, 255, 86, 0.2)',
                        'rgba(192, 75, 192, 0.2)',
                        'rgba(102, 153, 255, 0.2)',
                        'rgba(159, 255, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(99, 255, 132, 1)',
                        'rgba(162, 54, 235, 1)',
                        'rgba(206, 255, 86, 1)',
                        'rgba(192, 75, 192, 1)',
                        'rgba(102, 153, 255, 1)',
                        'rgba(159, 255, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Chart per i leads
        var leadCtx = document.getElementById('leadChart').getContext('2d');
        var leadChart = new Chart(leadCtx, {
            type: 'scatter',
            data: {
                labels: <?php echo json_encode($leadMonths); ?>,
                datasets: [{
                    label: 'Numero di Lead',
                    data: <?php echo json_encode($leadData); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(99, 255, 132, 0.2)',
                        'rgba(162, 54, 235, 0.2)',
                        'rgba(206, 255, 86, 0.2)',
                        'rgba(192, 75, 192, 0.2)',
                        'rgba(102, 153, 255, 0.2)',
                        'rgba(159, 255, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(99, 255, 132, 1)',
                        'rgba(162, 54, 235, 1)',
                        'rgba(206, 255, 86, 1)',
                        'rgba(192, 75, 192, 1)',
                        'rgba(102, 153, 255, 1)',
                        'rgba(159, 255, 64, 1)'
                    ],
                    borderWidth: 1,
                    pointStyle: 'rectRot', // Esempio di stile del punto
                    pointRadius: 10
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        type: 'category'
                    },
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
