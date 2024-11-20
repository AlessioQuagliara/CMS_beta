<style>
    .centered-fixed {
        position: fixed;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1300;
        padding: 5px 10px;
    }
</style>
<div class="mb-2 bg-light rounded-3 d-flex justify-content-center align-items-center centered-fixed border">
    <span>
        <h4>Modifica <?php echo $namePage; ?>&nbsp; &nbsp; &nbsp; </h4>
    </span>
    <a href="<?php echo htmlspecialchars("../../" . $visualizzaPagina); ?>" target="__blank" class="btn btn-secondary btn-sm"><i class="fa-solid fa-eye"></i> Visualizza online</a>&nbsp;
    <span>
        <button id="save-btn" class="btn btn-success btn-sm"><i class="fa-solid fa-floppy-disk"></i> Salva</button>
        <button id="delete-btn" class="btn btn-danger btn-sm"><i class="fa-solid fa-floppy-disk"></i> Cancella tutto</button>
    </span>
</div>

<div id="base" class="full" style="overflow: hidden">
</div>

<script type="text/javascript">
    var visualizzaPagina = '<?php echo $visualizzaPagina; ?>';

    var editor = grapesjs.init({
        container: '#base',
        fromElement: true,
        height: '1080px',
        width: '100%',
        storageManager: false,
        plugins: ['gjs-preset-webpage'],
        pluginsOpts: {
            'gjs-preset-webpage': {}
        },
        canvas: {
            styles: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css'
            ],
            scripts: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
            ]
        },
    });

    var savedContent = <?php echo json_encode($savedContent); ?>;
    if (savedContent) {
        editor.setComponents(savedContent);
    }

  
    editor.BlockManager.add('missioni-valori', {
    label: 'Missioni e Valori',
    content: `
        <section style="text-align:center; padding: 20px; background-color: #f8f8f8;">
            <h2>Missioni e Valori</h2>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <img src="https://via.placeholder.com/50" alt="Icon 1" style="margin-bottom: 10px;">
                    <h3>Valore 1</h3>
                    <p>Descrizione breve del valore.</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <img src="https://via.placeholder.com/50" alt="Icon 2" style="margin-bottom: 10px;">
                    <h3>Valore 2</h3>
                    <p>Descrizione breve del valore.</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <img src="https://via.placeholder.com/50" alt="Icon 3" style="margin-bottom: 10px;">
                    <h3>Valore 3</h3>
                    <p>Descrizione breve del valore.</p>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('fondi-casse', {
    label: 'Fondi e Casse',
    content: `
        <section style="text-align:center; padding: 20px; background-color: #ffffff;">
            <h2>Fondi e Casse Previdenziali</h2>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                <div style="background: #f1f1f1; padding: 20px; border-radius: 8px; flex: 1;">
                    <h3>Partner 1</h3>
                    <p>Descrizione breve del partner.</p>
                </div>
                <div style="background: #f1f1f1; padding: 20px; border-radius: 8px; flex: 1;">
                    <h3>Partner 2</h3>
                    <p>Descrizione breve del partner.</p>
                </div>
                <div style="background: #f1f1f1; padding: 20px; border-radius: 8px; flex: 1;">
                    <h3>Partner 3</h3>
                    <p>Descrizione breve del partner.</p>
                </div>
                <div style="background: #f1f1f1; padding: 20px; border-radius: 8px; flex: 1;">
                    <h3>Partner 4</h3>
                    <p>Descrizione breve del partner.</p>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('eventi-seminari', {
    label: 'Eventi e Seminari',
    content: `
        <section style="text-align:center; padding: 20px; background-color: #f9f9f9;">
            <h2>Eventi e Seminari</h2>
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <img src="https://via.placeholder.com/150" alt="Event 1" style="margin-bottom: 10px; width: 100%;">
                    <h3>Evento 1</h3>
                    <p>Dettagli evento.</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <img src="https://via.placeholder.com/150" alt="Event 2" style="margin-bottom: 10px; width: 100%;">
                    <h3>Evento 2</h3>
                    <p>Dettagli evento.</p>
                </div>
                <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <img src="https://via.placeholder.com/150" alt="Event 3" style="margin-bottom: 10px; width: 100%;">
                    <h3>Evento 3</h3>
                    <p>Dettagli evento.</p>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('storia-missioni', {
    label: 'Storia e Missioni',
    content: `
        <section class="py-5">
            <div class="container">
                <h2 class="text-center text-orange mb-4">Storia e Missioni</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy euismod tempor 
                        incididunt ut labore et dolore magna aliquam erat volutpat. At vero eos et accusam et justo 
                        duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-blue">PERCHÈ SCEGLIERE NOI?</h5>
                        <ol>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                            <li>Incidunt ut labore et dolore magna aliquam erat volutpat.</li>
                            <li>At vero eos et accusam et justo duo dolores et ea rebum.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('sergio', {
    label: 'Sergio',
    content: `
        <section class="py-5">
            <div class="container text-center">
                <h2 class="text-orange">Sergio</h2>
                <p class="text-blue">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy 
                euismod tempor incidunt ut labore et dolore magna aliquam erat, sed diam volutpat.</p>
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="circle me-3" style="width: 50px; height: 50px; background: #ccc; border-radius: 50%;"></div>
                            <p><strong>Nome</strong><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="circle me-3" style="width: 50px; height: 50px; background: #ccc; border-radius: 50%;"></div>
                            <p><strong>Nome</strong><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('associazioni-partnership', {
    label: 'Associazioni e Partnership',
    content: `
        <section class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="text-orange mb-4">Associazioni e Partnership</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="square" style="width: 100%; padding-top: 100%; background: #ccc; border-radius: 8px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="square" style="width: 100%; padding-top: 100%; background: #ccc; border-radius: 8px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="square" style="width: 100%; padding-top: 100%; background: #ccc; border-radius: 8px;"></div>
                    </div>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('login', {
    label: 'Login',
    content: `
        <section class="d-flex justify-content-center align-items-center vh-100 bg-light">
            <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
                <h2 class="text-center text-primary mb-4">Login</h2>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Inserisci la tua email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Inserisci la tua password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Accedi</button>
                </form>
                <p class="text-center mt-3">Non hai un account? <a href="#" class="text-primary">Registrati</a></p>
            </div>
        </section>
    `,
});

editor.BlockManager.add('logout', {
    label: 'Logout',
    content: `
        <section class="d-flex justify-content-center align-items-center vh-100 bg-light">
            <div class="text-center">
                <h2 class="text-danger mb-4">Sei sicuro di voler uscire?</h2>
                <form action="/logout" method="POST">
                    <button type="submit" class="btn btn-danger me-2">Logout</button>
                    <a href="/dashboard" class="btn btn-secondary">Annulla</a>
                </form>
            </div>
        </section>
    `,
});

editor.BlockManager.add('dashboard', {
    label: 'Dashboard',
    content: `
        <section class="container py-5">
            <div class="row mb-4">
                <div class="col text-center">
                    <h2 class="text-primary">Dashboard</h2>
                    <p class="text-muted">Benvenuto nella tua area riservata.</p>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-user fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">Profilo Utente</h5>
                            <p class="card-text">Gestisci le informazioni del tuo profilo.</p>
                            <a href="#" class="btn btn-primary btn-sm">Vai</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-cog fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">Impostazioni</h5>
                            <p class="card-text">Configura le tue preferenze.</p>
                            <a href="#" class="btn btn-primary btn-sm">Vai</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-sign-out-alt fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">Logout</h5>
                            <p class="card-text">Esci dal tuo account in modo sicuro.</p>
                            <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('sign-in', {
    label: 'Sign-In',
    content: `
        <section class="d-flex justify-content-center align-items-center vh-100 bg-light">
            <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
                <h2 class="text-center text-primary mb-4">Sign-In</h2>
                <form>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="firstName" placeholder="Inserisci il tuo nome">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Cognome</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Inserisci il tuo cognome">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Inserisci la tua email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Inserisci la tua password">
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Conferma Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Conferma la tua password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrati</button>
                </form>
                <p class="text-center mt-3">Hai già un account? <a href="#" class="text-primary">Accedi</a></p>
            </div>
        </section>
    `,
});

editor.BlockManager.add('chat-card-section', {
    label: 'Chat in Card',
    content: `
        <section class="py-5" style="background-color: #f8f8f8;">
            <div class="container text-center">
                <h2 class="text-orange mb-4">Sergio è a tua disposizione</h2>
                <div class="card mx-auto shadow-sm" style="max-width: 400px; border-radius: 15px; padding: 20px;">
                    <h4 class="text-orange mb-3">Per saperne di più</h4>
                    <form id="chat-form">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="last-name" placeholder="Cognome">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="first-name" placeholder="Nome">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" placeholder="E-mail">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" id="message" rows="3" placeholder="Scrivi qui il tuo messaggio..."></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-orange" style="flex: 1; margin-right: 5px;">Parla con un esperto</button>
                            <button type="button" class="btn btn-orange" style="flex: 1; margin-left: 5px;">Richiedi una consulenza</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('navbar', {
    label: 'Navbar',
    content: `
       <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <i class="fa-solid fa-briefcase"></i> AssoLabFondi
            </a>
            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-house"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-flag"></i> Missioni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-building"></i> Fondi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-calendar"></i> Eventi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-envelope"></i> Contatti</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    `,
});


editor.BlockManager.add('footer', {
    label: 'Footer',
    content: `
        <footer style="background-color: #003f88; color: #fff; padding: 20px 0;">
            <div style="display: flex; justify-content: space-around; flex-wrap: wrap;">
                <!-- Colonna 1 -->
                <div style="flex: 1; min-width: 200px; text-align: center;">
                    <h3 style="margin-bottom: 10px;">AssoLabFondi</h3>
                    <p style="font-size: 0.9rem;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vehicula nisl at lorem tincidunt varius.</p>
                </div>
                <!-- Colonna 2 -->
                <div style="flex: 1; min-width: 200px; text-align: center;">
                    <h3 style="margin-bottom: 10px;">Contatti</h3>
                    <p style="font-size: 0.9rem;">Email: info@assolabfondi.com</p>
                    <p style="font-size: 0.9rem;">Telefono: +39 012 345 6789</p>
                </div>
                <!-- Colonna 3 -->
                <div style="flex: 1; min-width: 200px; text-align: center;">
                    <h3 style="margin-bottom: 10px;">Social</h3>
                    <a href="#" style="margin: 0 5px; color: #fff; text-decoration: none;">Facebook</a>
                    <a href="#" style="margin: 0 5px; color: #fff; text-decoration: none;">LinkedIn</a>
                    <a href="#" style="margin: 0 5px; color: #fff; text-decoration: none;">Twitter</a>
                </div>
            </div>
            <div style="text-align: center; margin-top: 20px; font-size: 0.8rem; border-top: 1px solid #fff; padding-top: 10px;">
                <p>&copy; 2024 AssoLabFondi. Tutti i diritti riservati.</p>
            </div>
        </footer>
    `,
});

</script>

<!-- SCRIPT PER IL SALVATAGGIO -->
<script type="text/javascript">
    function cleanContent(htmlContent) {
        // Rimuovi i tag <head> e il loro contenuto
        htmlContent = htmlContent.replace(/<head[^>]*>[\s\S]*<\/head>/gi, '');

        // Rimuovi i tag <body> mantenendo il contenuto interno
        htmlContent = htmlContent.replace(/<\/?body[^>]*>/gi, '');

        return htmlContent;
    }

    function showAlert(title, text, icon, dangerMode = false, callback = null) {
        swal({
            title: title,
            text: text,
            icon: icon,
            buttons: true,
            dangerMode: dangerMode,
        }).then((willClose) => {
            if (willClose) {
                if (callback) {
                    callback();
                } else {
                    location.reload(); // Aggiorna la pagina
                }
            }
        });
    }

    $(document).ready(function() {
        $('#save-btn').click(function() {
            var editorContent = editor.getHtml() + '<style>' + editor.getCss() + '</style>';
            editorContent = cleanContent(editorContent);
            var pageName = "<?php echo $namePage; ?>";

            $.ajax({
                type: "POST",
                url: "../ui-gestisci/save_script.php",
                data: {
                    namePage: pageName,
                    content: editorContent
                },
                success: function(data) {
                    showAlert("Pagina Salvata", "La tua pagina è stata salvata e le modifiche sono ora visibili.", "success");
                },
                error: function(xhr, status, error) {
                    showAlert("Errore", "C'è stato un errore imprevisto nella richiesta.", "error", true);
                }
            });
        });

        $('#delete-btn').click(function() {
            var pageName = "<?php echo $namePage; ?>";

            $.ajax({
                type: "POST",
                url: "../ui-gestisci/delete_script.php",
                data: {
                    namePage: pageName
                },
                success: function(data) {
                    showAlert("Pagina Cancellata", "La tua pagina è stata cancellata con successo.", "success");
                },
                error: function(xhr, status, error) {
                    showAlert("Errore", "C'è stato un errore imprevisto nella richiesta.", "error", true);
                }
            });
        });
    });
</script>