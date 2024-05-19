<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installazione LinkBay</title>
    <link rel="shortcut icon" href="../admin/materials/favicon_link.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            <br>
            <h2>Installazione LinkBay</h2>
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
            updateProgressBar(25, 5, 'Creazione del Database', () => {
                updateProgressBar(50, 10, 'Download dei pacchetti', () => {
                updateProgressBar(99, 20, 'Installazione..', () => {
                    updateProgressBar(100, 5, 'Installazione completa, verrai reinderizzato', () => {
                        setTimeout(() => {
                            window.location.href = '../admin/subscribe';
                        }, 5000); // Aspetta 5 secondi prima di reindirizzare
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
