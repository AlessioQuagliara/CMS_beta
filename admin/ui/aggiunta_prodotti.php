<?php 
require ('../../app.php');
loggato();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <!-- Meta tags, title, and Bootstrap 5 CSS -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkBay - Aggiunta Prodotti</title>
    <?php include '../materials/head_content.php'; ?>
    <!-- Assicurati di includere Bootstrap Icons se non già presenti -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Stile per il badge (se necessario) */
        #notification-badge {
            font-weight: bold;
            text-align: center;
            display: none;
        }
        /* Eventuali stili per la selezione drag sulle righe */
        #product-table tbody tr.selected {
            background-color: #e9ecef;
        }
        /* Arrotondamento dei bordi della tabella */
        #product-table {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body style="background-color: #f1f1f1;">
    
    <?php 
    $sidebar_cate = 'App'; 
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php'; 
    ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- Barra di controllo -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <div class="btn-group" role="group" aria-label="Toolbar">
            <button type="button" id="btn-create" class="btn btn-dark" title="Crea">
                <i class="bi bi-plus"></i>
            </button>
            <button type="button" id="btn-select" class="btn btn-dark" title="Seleziona Tutto">
                <i class="bi bi-check2-square"></i>
            </button>
            <button type="button" id="btn-delete" class="btn btn-dark" title="Cancella">
                <i class="bi bi-trash"></i>
            </button>
            <button type="button" id="btn-search" class="btn btn-dark" title="Cerca">
                <i class="bi bi-search"></i>
            </button>
            <button type="button" id="btn-import" class="btn btn-dark" title="Importa">
                <i class="bi bi-upload"></i>
            </button>
        </div>
    </div>

    <!-- Tabella dei prodotti -->
    <div class="table-responsive">
        <table id="product-table" class="table table-bordered table-hover rounded">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><input type="checkbox" id="select-all"></th>
                    <th scope="col">Nome</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Mezzo</th>
                    <th scope="col">Dimensione</th>
                    <th scope="col">Concessionaria</th>
                    <th scope="col">Genere</th>
                    <th scope="col">Età</th>
                </tr>
            </thead>
            <tbody>
                <!-- Le righe verranno caricate tramite Ajax -->
            </tbody>
        </table>
    </div>
</main>

<?php include '../materials/script.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function loadProducts() {
        fetch('../../function/ajax_load_products.php')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#product-table tbody');
                tbody.innerHTML = ''; 
                data.forEach(product => {
                    const tr = document.createElement('tr');
                    tr.dataset.id = product.id;
                    tr.addEventListener('dblclick', () => {
                        window.location.href = 'modifica_prodotto.php?id=' + product.id;
                    });
                    tr.innerHTML = `
                        <td><input type="checkbox" class="row-checkbox" value="${product.id}"></td>
                        <td>${product.nome}</td>
                        <td>${product.slug}</td>
                        <td>${product.mezzo_pubblicitario}</td>
                        <td>${product.dimensione}</td>
                        <td>${product.concessionaria}</td>
                        <td>${product.genere}</td>
                        <td>${product.eta}</td>
                    `;
                    tbody.appendChild(tr);
                });
                attachRowSelection();
            })
            .catch(error => {
                Swal.fire("Errore!", "Errore nel caricamento dei prodotti.", "error");
                console.error('Errore nel caricamento dei prodotti:', error);
            });
    }

    function attachRowSelection() {
        let isDragging = false;
        const rows = document.querySelectorAll('#product-table tbody tr');
        rows.forEach(row => {
            row.addEventListener('mousedown', () => {
                isDragging = true;
                row.classList.add('selected');
                row.querySelector('.row-checkbox').checked = true;
            });
            row.addEventListener('mouseenter', () => {
                if (isDragging) row.querySelector('.row-checkbox').checked = true;
            });
        });
        document.addEventListener('mouseup', () => isDragging = false);
    }

    document.getElementById('btn-create').addEventListener('click', function() {
        fetch('../../function/ajax_create_product.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Successo!", "Prodotto creato con successo.", "success");
                loadProducts();
            } else {
                Swal.fire("Errore!", "Errore nella creazione del prodotto.", "error");
            }
        })
        .catch(error => console.error('Errore:', error));
    });

    document.getElementById('btn-select').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        checkboxes.forEach(cb => cb.checked = !allChecked);
    });

    document.getElementById('btn-delete').addEventListener('click', function() {
        const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            Swal.fire("Attenzione!", "Seleziona almeno un prodotto da cancellare.", "warning");
            return;
        }

        Swal.fire({
            title: "Sei sicuro?",
            text: "Questa azione è irreversibile!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sì, elimina!",
            cancelButtonText: "Annulla"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../../function/ajax_delete_product.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ ids: selected })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Eliminato!", "Prodotti eliminati con successo.", "success");
                        loadProducts();
                    } else {
                        Swal.fire("Errore!", "Errore nella cancellazione.", "error");
                    }
                })
                .catch(error => console.error('Errore:', error));
            }
        });
    });

    document.getElementById('btn-search').addEventListener('click', function() {
        Swal.fire({
            title: "Cerca un prodotto",
            input: "text",
            inputPlaceholder: "Inserisci il termine di ricerca...",
            showCancelButton: true,
            confirmButtonText: "Cerca",
            cancelButtonText: "Annulla"
        }).then((result) => {
            if (result.value) {
                fetch('../../function/ajax_search_product.php?q=' + encodeURIComponent(result.value))
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#product-table tbody');
                    tbody.innerHTML = '';
                    data.forEach(product => {
                        const tr = document.createElement('tr');
                        tr.dataset.id = product.id;
                        tr.addEventListener('dblclick', () => {
                            window.location.href = 'modifica_prodotto.php?id=' + product.id;
                        });
                        tr.innerHTML = `
                            <td><input type="checkbox" class="row-checkbox" value="${product.id}"></td>
                            <td>${product.nome}</td>
                            <td>${product.slug}</td>
                            <td>${product.mezzo_pubblicitario}</td>
                            <td>${product.dimensione}</td>
                            <td>${product.concessionaria}</td>
                            <td>${product.genere}</td>
                            <td>${product.eta}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                    attachRowSelection();
                })
                .catch(error => console.error('Errore:', error));
            }
        });
    });

    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    document.addEventListener('DOMContentLoaded', loadProducts);
</script>
</body>
</html>