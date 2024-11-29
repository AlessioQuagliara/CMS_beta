<?php
require('../../app.php');
loggato()
?>
<!DOCTYPE html>
<html lang="it">
    
    <head>
        <!-- Meta tags, title, and Bootstrap 5 CSS -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LinkBay - Leads</title>
        <?php include '../materials/head_content.php'; ?>
    </head>
    
    <body style="background-color: #f1f1f1;">
        
        <?php
    $sidebar_cate = 'App';
    $currentPage = basename($_SERVER['PHP_SELF']);
    include '../materials/sidebar.php';
    ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <!-- TABELLA CONTENUTI -->
    <div class="container my-4">
        
        <!-- Card per le funzioni della tabella -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Gestione Eventi</h5>
                <div>
                    <button class="btn btn-dark btn-sm mx-1" title="Aggiungi Evento" id="add-event-btn">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <button class="btn btn-dark btn-sm mx-1" title="Edita Evento" id="edit-event-btn">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    
                    <button class="btn btn-dark btn-sm mx-1 delete-selected" title="Elimina Selezionati">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tabella Eventi -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col"><input type="checkbox" id="select-all-checkbox"></th>
                        <th scope="col">#</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Descrizione</th>
                        <th scope="col">Luogo</th>
                        <th scope="col">Data</th>
                        <th scope="col">Ora</th>
                        <th scope="col">Pubblicato</th>
                    </tr>
                </thead>
                <tbody id="event-table-body">
                    <!-- I dati verranno caricati dinamicamente -->
                </tbody>
            </table>
        </div>
    </div>
</main>
    
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const eventTableBody = document.getElementById('event-table-body');
    const deleteSelectedBtn = document.querySelector('.delete-selected');
    const editEventBtn = document.getElementById('edit-event-btn'); // Bottone per modificare evento
    const addEventBtn = document.getElementById('add-event-btn'); // Bottone per aggiungere evento
    const loadingIndicator = document.createElement('div'); // Indicatore di caricamento
    loadingIndicator.textContent = 'Caricamento in corso...';
    loadingIndicator.style.textAlign = 'center';

    // Funzione per creare una riga della tabella
    const createEventRow = (event) => {
        return `
            <tr data-event-id="${event.id_evento}">
                <td><input type="checkbox" class="row-checkbox"></td>
                <td>${event.id_evento}</td>
                <td>${event.titolo}</td>
                <td>${event.descrizione}</td>
                <td>${event.categoria}</td>
                <td>${event.data_evento}</td>
                <td>${event.ora_evento}</td>
                <td>
                    <select class="form-select publish-select" data-event-id="${event.id_evento}">
                        <option value="1" ${event.pubblicato ? 'selected' : ''}>Sì</option>
                        <option value="0" ${!event.pubblicato ? 'selected' : ''}>No</option>
                    </select>
                </td>
            </tr>
        `;
    };

    // Funzione per caricare gli eventi
    const loadEvents = () => {
        eventTableBody.innerHTML = ''; // Svuota la tabella
        eventTableBody.appendChild(loadingIndicator); // Mostra l'indicatore di caricamento

        fetch('../ui-gestisci/load_eventi.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Errore nel caricamento degli eventi');
                }
                return response.json();
            })
            .then(events => {
                eventTableBody.innerHTML = ''; // Rimuovi l'indicatore di caricamento
                events.forEach(event => {
                    eventTableBody.innerHTML += createEventRow(event);
                });
            })
            .catch(error => {
                console.error('Errore:', error);
                eventTableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; color: red;">Errore nel caricamento degli eventi</td></tr>';
            });
    };

    // Carica eventi iniziali
    loadEvents();

    // Funzione per aggiungere evento
    addEventBtn.addEventListener('click', () => {
        Swal.fire({
            title: 'Crea Evento',
            html: `
                <input type="text" id="event-title" class="swal2-input" placeholder="Titolo">
                <textarea id="event-description" class="swal2-textarea" placeholder="Descrizione"></textarea>
                <input type="text" id="event-category" class="swal2-input" placeholder="Luogo">
                <input type="date" id="event-date" class="swal2-input">
                <input type="time" id="event-time" class="swal2-input">
                <input type="file" id="event-image" class="swal2-input" accept="image/*">
                <img id="image-preview" style="margin-top: 10px; max-width: 100%; max-height: 150px; display: none;">
            `,
            confirmButtonText: 'Salva',
            showCancelButton: true,
            cancelButtonText: 'Annulla',
            preConfirm: () => {
                const titolo = document.getElementById('event-title').value.trim();
                const descrizione = document.getElementById('event-description').value.trim();
                const categoria = document.getElementById('event-category').value.trim();
                const data_evento = document.getElementById('event-date').value.trim();
                const ora_evento = document.getElementById('event-time').value.trim();
                const immagine = document.getElementById('event-image').files[0];

                // Validazione dei campi
                if (!titolo || !descrizione || !categoria || !data_evento || !ora_evento) {
                    Swal.showValidationMessage('Tutti i campi sono obbligatori!');
                    return false;
                }
                if (!immagine) {
                    Swal.showValidationMessage('Seleziona un\'immagine per l\'evento!');
                    return false;
                }

                return { titolo, descrizione, categoria, data_evento, ora_evento, immagine };
            }
        }).then(result => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('titolo', result.value.titolo);
                formData.append('descrizione', result.value.descrizione);
                formData.append('categoria', result.value.categoria);
                formData.append('data_evento', result.value.data_evento);
                formData.append('ora_evento', result.value.ora_evento);
                formData.append('immagine', result.value.immagine);

                fetch('../ui-gestisci/add_event.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Successo', 'Evento aggiunto con successo!', 'success');
                        loadEvents(); // Ricarica la tabella degli eventi
                    } else {
                        Swal.fire('Errore', 'Impossibile aggiungere l\'evento.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Errore durante la richiesta:', error);
                    Swal.fire('Errore', 'Si è verificato un problema durante l\'aggiunta dell\'evento.', 'error');
                });
            }
        });

        // Anteprima immagine
        document.getElementById('event-image').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.getElementById('image-preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Funzione per modificare evento selezionato
    const editSelectedEvent = () => {
        const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        if (selectedCheckboxes.length !== 1) {
            Swal.fire('Errore', 'Seleziona un solo evento da modificare.', 'warning');
            return;
        }

        const selectedRow = selectedCheckboxes[0].closest('tr');
        const eventId = selectedRow.getAttribute('data-event-id');

        // Ottieni i dati dell'evento dalla riga selezionata
        const titolo = selectedRow.cells[2].innerText.trim();
        const descrizione = selectedRow.cells[3].innerText.trim();
        const categoria = selectedRow.cells[4].innerText.trim();
        const data_evento = selectedRow.cells[5].innerText.trim();
        const ora_evento = selectedRow.cells[6].innerText.trim();

        // Mostra SweetAlert con i campi precompilati
        Swal.fire({
            title: 'Modifica Evento',
            html: `
                <input type="text" id="edit-title" class="swal2-input" placeholder="Titolo" value="${titolo}">
                <textarea id="edit-description" class="swal2-textarea" placeholder="Descrizione">${descrizione}</textarea>
                <input type="text" id="edit-category" class="swal2-input" placeholder="Luogo" value="${categoria}">
                <input type="date" id="edit-date" class="swal2-input" value="${data_evento}">
                <input type="time" id="edit-time" class="swal2-input" value="${ora_evento}">
            `,
            confirmButtonText: 'Salva',
            showCancelButton: true,
            cancelButtonText: 'Annulla',
            preConfirm: () => {
                const updatedTitle = document.getElementById('edit-title').value.trim();
                const updatedDescription = document.getElementById('edit-description').value.trim();
                const updatedCategory = document.getElementById('edit-category').value.trim();
                const updatedDate = document.getElementById('edit-date').value.trim();
                const updatedTime = document.getElementById('edit-time').value.trim();

                // Validazione
                if (!updatedTitle || !updatedDescription || !updatedCategory || !updatedDate || !updatedTime) {
                    Swal.showValidationMessage('Tutti i campi sono obbligatori!');
                    return false;
                }

                return {
                    id_evento: eventId,
                    titolo: updatedTitle,
                    descrizione: updatedDescription,
                    categoria: updatedCategory,
                    data_evento: updatedDate,
                    ora_evento: updatedTime
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../ui-gestisci/edit_event.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result.value)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Successo', 'Evento modificato con successo!', 'success');
                            loadEvents(); // Ricarica la tabella
                        } else {
                            Swal.fire('Errore', data.message || 'Impossibile modificare l\'evento.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Errore durante la modifica:', error);
                        Swal.fire('Errore', 'Si è verificato un problema durante la modifica dell\'evento.', 'error');
                    });
            }
        });
    };

    // Assegna la funzione al pulsante "Modifica Evento"
    editEventBtn.addEventListener('click', editSelectedEvent);

    // Funzione per eliminare eventi selezionati
    const deleteSelectedEvents = () => {
        const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            Swal.fire('Errore', 'Seleziona almeno un evento da eliminare.', 'warning');
            return;
        }

        const eventIds = Array.from(selectedCheckboxes).map(checkbox =>
            checkbox.closest('tr').getAttribute('data-event-id')
        );

        Swal.fire({
            title: 'Sei sicuro?',
            text: "Questa azione eliminerà gli eventi selezionati!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sì, elimina!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../ui-gestisci/delete_event.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ event_ids: eventIds })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Eliminato!', data.message, 'success');
                            loadEvents();
                        } else {
                            Swal.fire('Errore', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Errore', 'Errore durante l\'eliminazione degli eventi.', 'error');
                        console.error(error);
                    });
            }
        });
    };

    // Assegna la funzione al pulsante "Elimina Selezionati"
    deleteSelectedBtn.addEventListener('click', deleteSelectedEvents);
});

document.addEventListener('DOMContentLoaded', function () {
    const eventTableBody = document.getElementById('event-table-body');

    // Funzione per aggiornare lo stato "Pubblicato" via AJAX
    const updatePublishState = (eventId, publishState) => {
        fetch('../ui-gestisci/update_publish_state.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_evento: eventId, pubblicato: publishState })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Successo', 'Stato pubblicazione aggiornato con successo!', 'success');
                } else {
                    Swal.fire('Errore', 'Impossibile aggiornare lo stato di pubblicazione.', 'error');
                }
            })
            .catch(error => {
                console.error('Errore durante l\'aggiornamento:', error);
                Swal.fire('Errore', 'Si è verificato un problema durante l\'aggiornamento dello stato.', 'error');
            });
    };

    // Gestione del cambio di stato "Pubblicato" tramite il select
    eventTableBody.addEventListener('change', function (e) {
        if (e.target.classList.contains('publish-select')) {
            const eventId = e.target.getAttribute('data-event-id');
            const publishState = e.target.value;

            Swal.fire({
                title: 'Conferma modifica',
                text: 'Vuoi aggiornare lo stato di pubblicazione?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sì, aggiorna!',
                cancelButtonText: 'Annulla'
            }).then(result => {
                if (result.isConfirmed) {
                    updatePublishState(eventId, publishState);
                } else {
                    // Ripristina il valore precedente se l'utente annulla
                    e.target.value = e.target.value === '1' ? '0' : '1';
                }
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const eventTableBody = document.getElementById('event-table-body');

    // Funzione per aggiornare lo stato "Pubblicato" via AJAX
    const updatePublishState = (eventId, publishState) => {
        fetch('../ui-gestisci/update_publish_state.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_evento: eventId, pubblicato: publishState })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Successo', 'Stato pubblicazione aggiornato con successo!', 'success');
                    location.reload();
                } else {
                    Swal.fire('Errore', 'Impossibile aggiornare lo stato di pubblicazione.', 'error');
                }
            })
            .catch(error => {
                console.error('Errore durante l\'aggiornamento:', error);
                Swal.fire('Errore', 'Si è verificato un problema durante l\'aggiornamento dello stato.', 'error');
            });
    };

    // Gestione del cambio di stato "Pubblicato" tramite il select
    eventTableBody.addEventListener('change', function (e) {
        if (e.target.classList.contains('publish-select')) {
            const eventId = e.target.getAttribute('data-event-id');
            const publishState = e.target.value;

            Swal.fire({
                title: 'Conferma modifica',
                text: 'Vuoi aggiornare lo stato di pubblicazione?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sì, aggiorna!',
                cancelButtonText: 'Annulla'
            }).then(result => {
                if (result.isConfirmed) {
                    updatePublishState(eventId, publishState);
                } else {
                    // Ripristina il valore precedente se l'utente annulla
                    e.target.value = e.target.value === '1' ? '0' : '1';
                }
            });
        }
    });
});
</script>

<?php include '../materials/script.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>