<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>


<!-- Popper JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- Personal Script -->
<script>
    function startLoading(event) {
            var button = document.getElementById('loadButton');
            button.disabled = true; // Disabilita il pulsante
            button.innerHTML = 'In Corso<span class="dots">...</span>';
            button.classList.add('loading-button');
            
            // Avvia il submit del form
            document.getElementById('updateForm').submit();
        }
</script>