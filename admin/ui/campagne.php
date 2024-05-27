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
        <div class="p-3 mb-2 bg-light rounded-3 border">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Configura i tuoi strumenti di Marketing</h4>
            </div>
        </div>

        <?php
        require '../../conn.php';
        $query = "SELECT * FROM marketing_tools";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $statusBadge = $row['status'] == 'active' ? 'bg-success' : 'bg-danger';
                $statusText = $row['status'] == 'active' ? 'Attivo' : 'Disattivo';
                $buttonText = $row['status'] == 'active' ? 'Gestisci' : 'Imposta';
                $icon = '';
                if ($row['tool'] == 'Google Tag Manager') {
                    $icon = '<img src="https://docs.bemob.com/google-adwords-logo.png" width="150px">';
                } else if ($row['tool'] == 'Facebook Pixel') {
                    $icon = '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Meta_Platforms_Inc._logo.svg/2560px-Meta_Platforms_Inc._logo.svg.png" width="120px">';
                } else if ($row['tool'] == 'Google Analytics') {
                    $icon = '<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Google_Analytics_Logo_2015.png/1200px-Google_Analytics_Logo_2015.png" width="150px">';
                }
                echo "<div id='tool{$row['tool']}' class='p-3 mb-2 bg-light rounded-3 d-flex justify-content-between align-items-center border'>";
                echo "<p class='d-none'>{$row['tool']}</p>";
                echo $icon;
                echo "<span class='badge {$statusBadge}'>{$statusText}</span>";
                echo "<button class='btn btn-danger' type='button' data-value='{$row['tool']}' onclick='apriModifica(this)'>{$buttonText} {$row['tool']}</button>";
                echo "</div>";
            }
        } else {
            echo "Nessuno strumento di marketing trovato.";
        }
        $conn->close();
        ?>
    </div>
</main>

<script>
    function apriModifica(button) {
        var tool = button.getAttribute('data-value'); 
        var url = "../ui-gestisci/campagna_id.php?tool=" + tool; 
        window.open(url, "Imposta ID", "width=800,height=600"); 
    }
</script>

    
<?php include '../materials/script.php'; ?>
</body>
</html>
