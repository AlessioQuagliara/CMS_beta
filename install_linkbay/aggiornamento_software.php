<?php

$projectDir = realpath(__DIR__ . '/../');
$tempDir = sys_get_temp_dir() . '/backup';
$token = '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'; 

// URL del file zip del repository
$repoUrl = "https://$token:x-oauth-basic@api.github.com/repos/AlessioSpotex/CMS_beta/zipball/main";

// Assicurati che la directory temporanea esista
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0777, true);
}

// Funzione per scaricare il file
function downloadZip($url, $dest) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $data = curl_exec($ch);
    if ($data === false) {
        throw new Exception(curl_error($ch));
    }
    curl_close($ch);
    file_put_contents($dest, $data);
}

// Funzione per estrarre il file zip
function extractZip($zipFile, $dest) {
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === true) {
        $zip->extractTo($dest);
        $zip->close();
    } else {
        throw new Exception("Unable to open zip file");
    }
}

// Scarica il file zip
try {
    $zipFile = $tempDir . '/repo.zip';
    downloadZip($repoUrl, $zipFile);
    error_log("Download del repository completato");

    // Estrai il file zip
    extractZip($zipFile, $tempDir);
    error_log("Estrazione del repository completata");

} catch (Exception $e) {
    error_log("Errore durante il download o l'estrazione del repository: " . $e->getMessage());
    echo "Errore durante il download o l'estrazione del repository: " . $e->getMessage();
    exit;
}

function copyFiles($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                if ($file !== 'src' && $file !== 'install_linkbay') {
                    copyFiles($src . '/' . $file, $dst . '/' . $file);
                }
            } else {
                if ($file !== 'conn.php' && $file !== 'aggiornamento.php') {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
    }
    closedir($dir);
}

// Trova la directory estratta (dovrebbe essere la prima directory nella cartella temporanea)
$extractedDir = glob($tempDir . '/*' , GLOB_ONLYDIR)[0] ?? null;

if ($extractedDir === null) {
    error_log("Errore: Directory estratta non trovata");
    echo "Errore: Directory estratta non trovata";
    exit;
}

// Copia i file dalla directory estratta al progetto
copyFiles($extractedDir, $projectDir);

// Elimina la directory temporanea
exec("rm -rf $tempDir");

$stato_aggiornamento = "Aggiornamento completato con successo.";
error_log($stato_aggiornamento);

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiornamento Software</title>
    <link rel="shortcut icon" href="../admin/materials/favicon_link.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../admin/materials/login.css">
    <style>
        body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('../admin/materials/background.webp') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
        }
        #message {
            margin-bottom: 20px;
        }
        #loadingImage {
            width: 32px;
            height: 32px;
            animation: rotation 2s infinite linear;
        }
        @keyframes rotation {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="card bg-light text-dark w-25">
        <div class="card-header text-center">
            <img src="../admin/materials/linkbay_logo.png" width="150px" alt="">
            <br><br>
            <h2 class="h3 mb-3 fw-normal">Aggiornamento LinkBay</h2>
        </div>
        <div class="card-body">
            <br>
            <div class="row justify-content-center">
                <div id="loadingDiv" class="col-12 d-flex justify-content-center align-items-center">
                    <img id="loadingImage" src="../admin/materials/favicon_link-legacy.ico" alt="Loading">
                </div>
            </div>
            <br>
            <div class="progress">
                <div id="progressBar" class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="message" class="text-center">Inizializzazione...</div>
        </div>
    </div>
    <script>
        function updateProgressBar(percentage, duration, message, callback) {
            document.getElementById('message').innerText = message;
            const progressBar = document.getElementById('progressBar');
            let width = parseInt(progressBar.style.width);
            const intervalTime = 50; // Millisecondi
            const totalSteps = duration * 1000 / intervalTime;
            const increment = (percentage - width) / totalSteps;

            let currentStep = 0;

            const interval = setInterval(() => {
                if (currentStep >= totalSteps) {
                    clearInterval(interval);
                    if (callback) callback();
                } else {
                    width += increment;
                    progressBar.style.width = width + '%';
                    progressBar.setAttribute('aria-valuenow', width);
                    currentStep++;
                }
            }, intervalTime);
        }

        function startLoading() {
            updateProgressBar(25, 10, 'Backup dei dati esistenti', () => {
                updateProgressBar(50, 5, 'Download dei pacchetti', () => {
                updateProgressBar(99, 10, 'Installazione..', () => {
                    updateProgressBar(100, 5, '<?php echo $stato_aggiornamento; ?>', () => {
                        setTimeout(() => {
                            window.location.href = '../admin/ui/aggiornamento';
                        }, 5000);
                    });
                  });
                });
            });
        }

        document.addEventListener('DOMContentLoaded', startLoading);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>