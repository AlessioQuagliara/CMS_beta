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
    <?php
    if ($namePage == 'home') {
        $visualizzaPagina = '';
    } else if ($namePage == 'aboutus') {
        $visualizzaPagina = 'aboutus';
    } else if ($namePage == 'landing') {
        $visualizzaPagina = 'landing';
    } else if ($namePage == 'prodotto') {
        $visualizzaPagina = 'prodotti/prodotto-esempio';
    } else if ($namePage == 'catalogo') {
        $visualizzaPagina = 'catalog';
    } else if ($namePage == 'services') {
        $visualizzaPagina = 'services';
    } else if ($namePage == 'contacts') {
        $visualizzaPagina = 'contacts';
    } else if ($namePage == 'cart') {
        $visualizzaPagina = 'carrello';
    } else if ($namePage == 'footer') {
        $visualizzaPagina = 'footer';
    } else if ($namePage == 'navbar') {
        $visualizzaPagina = 'navbar';
    }
    ?>
    <span>
        <h4>Modifica <?php echo $namePage; ?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </h4> 
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
        height: '900px',
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
    
    if( visualizzaPagina === 'footer'){
        editor.BlockManager.add('pretty-footer', {
            label: 'Pretty Footer',
            content: `
            <footer class="bg-dark text-white text-center text-lg-start">
            <div class="container p-4">
            <!-- Section: Social media -->
            <section class="mb-4">
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
            <i class="fab fa-facebook-f"></i>
            </a>
            
            <!-- Twitter -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
            <i class="fab fa-twitter"></i>
            </a>
            
            <!-- Google -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
            <i class="fab fa-google"></i>
            </a>
            
            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
            <i class="fab fa-instagram"></i>
            </a>
            
            <!-- Linkedin -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
            <i class="fab fa-linkedin-in"></i>
            </a>
            
            <!-- Github -->
            <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button">
            <i class="fab fa-github"></i>
            </a>
            </section>
            <!-- Section: Social media -->
            
            <!-- Section: Links -->
            <section class="mb-4">
            <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Link Utili</h5>
            
            <ul class="list-unstyled mb-0">
            <li>
            <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 4</a>
            </li>
            </ul>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Link Utili</h5>
            
            <ul class="list-unstyled mb-0">
            <li>
            <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 4</a>
            </li>
            </ul>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Link Utili</h5>
            
            <ul class="list-unstyled mb-0">
            <li>
            <a href="#!" class="text-white">Link 1</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 2</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 3</a>
            </li>
            <li>
            <a href="#!" class="text-white">Link 4</a>
            </li>
            </ul>
            </div>
            </div>
            </section>
            </div><div class="text-center p-3 bg-secondary">&copy; 2024 Copyright:<a class="text-white" href="https://linkbay.it/">LinkBay</a></div></footer>
                        `,
            category: 'Footer',
        });
        
        editor.BlockManager.add('complex-footer', {
            label: 'Complex Footer',
            content: `
            <footer class="bg-dark text-white text-center text-lg-start">
                <div class="container p-4">
                    <section class="mb-4">
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-google"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i class="fab fa-github"></i></a>
                    </section>
                    <section class="mb-4">
                        <form action="">
                            <div class="row d-flex justify-content-center">
                                <div class="col-auto">
                                    <p class="pt-2"><strong>Sign up for our newsletter</strong></p>
                                </div>
                                <div class="col-md-5 col-12">
                                    <div class="form-outline mb-4">
                                        <input type="email" id="form5Example24" class="form-control" />
                                        <label class="form-label" for="form5Example24">Email address</label>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-outline-light mb-4">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section class="mb-4">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt distinctio earum repellat quaerat voluptatibus placeat nam, commodi optio pariatur est quia magnam eum harum corrupti dicta, aliquam sequi voluptate quas.</p>
                    </section>
                    <section class="d-flex justify-content-center">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                                <h5 class="text-uppercase">Links</h5>
                                <ul class="list-unstyled mb-0">
                                    <li><a class="text-white" href="#!">Link 1</a></li>
                                    <li><a class="text-white" href="#!">Link 2</a></li>
                                    <li><a class="text-white" href="#!">Link 3</a></li>
                                    <li><a class="text-white" href="#!">Link 4</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                                <h5 class="text-uppercase">Links</h5>
                                <ul class="list-unstyled mb-0">
                                    <li><a class="text-white" href="#!">Link 1</a></li>
                                    <li><a class="text-white" href="#!">Link 2</a></li>
                                    <li><a class="text-white" href="#!">Link 3</a></li>
                                    <li><a class="text-white" href="#!">Link 4</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                                <h5 class="text-uppercase">Links</h5>
                                <ul class="list-unstyled mb-0">
                                    <li><a class="text-white" href="#!">Link 1</a></li>
                                    <li><a class="text-white" href="#!">Link 2</a></li>
                                    <li><a class="text-white" href="#!">Link 3</a></li>
                                    <li><a class="text-white" href="#!">Link 4</a></li>
                                </ul>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="text-center p-3 bg-secondary">
                    &copy; 2024 Copyright: <a class="text-white" href="">LinkBay</a>
                </div>
            </footer>
            `,
            category: "Footer",
        }),
        editor.BlockManager.add('footer-3', {
            label: 'Simple Footer',
            content: `
                <footer class="bg-light text-center text-lg-start">
                    <div class="text-center p-3">
                    &copy; 2024 LinkBay. Tutti i diritti riservati.
                    </div>
                </footer>
        `,
            category: 'Footer',
        });
    } else if( visualizzaPagina === 'navbar'){
    // Navbar --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    editor.BlockManager.add('bootstrap-navbar', {
        label: 'Navbar Stile 1',
        content: `
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Brand</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about_us">Chi Siamo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Catalogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Carrello</a>
                        </li>
                    </ul>
                </div>
            </div>
            <style>
                body {
                    padding-top: 56px; /* Altezza della navbar */
                }
            </style>
        </nav>
                  `,
        category: 'Navbar',
    });
    editor.BlockManager.add('bootstrap-navbar-logo', {
        label: 'Navbar Stile 2',
        content: `
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="path/to/your/logo.png" alt="Logo" width="30" height="24">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="index">Home</a>
                            <a class="nav-link" href="about_us">Chi siamo</a>
                            <a class="nav-link" href="#">Catalogo</a>
                            <a class="nav-link disabled">Carrello</a>
                        </div>
                    </div>
                </div>
                <!-- Aggiungi questo stile per compensare l'altezza della navbar -->
                <style>
                    body {
                        padding-top: 56px; /* Altezza della navbar */
                    }
                </style>
            </nav>
                `,
        category: 'Navbar',
    });
    editor.BlockManager.add('navbar-with-logo', {
        label: 'Navbar con Logo',
        content: `
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="logo.png" alt="Logo" width="auto" height="30" class="d-inline-block align-top">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Aggiungi questo stile per compensare l'altezza della navbar -->
                <style>
                    body {
                        padding-top: 56px; /* Altezza della navbar */
                    }
                </style>
            </nav>
              `,
        category: 'Navbar',
    });
    editor.BlockManager.add('navbar-with-centered-logo', {
        label: 'Navbar con Logo Centrale',
        content: `
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <a class="navbar-brand" href="#">
                        <img src="logo.png" alt="Logo" width="auto" height="50" class="d-inline-block align-top">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Aggiungi questo stile per compensare l'altezza della navbar -->
            <style>
                body {
                    padding-top: 70px; /* Altezza della navbar */
                }
            </style>
        </nav>
            `,
        category: 'Navbar',
    });
    editor.BlockManager.add('navbar-with-large-logo', {
        label: 'Navbar con Logo Grande',
        content: `
        <!-- Contenitore per logo e navbar -->
            <div class="fixed-top bg-light">
                <div class="container d-flex justify-content-center py-3">
                    <a class="navbar-brand" href="#">
                        <img src="path/to/your/logo.png" alt="Logo" width="auto" height="50" class="d-inline-block align-top">
                    </a>
                </div>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Catalogo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Chi Siamo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fas fa-search"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fas fa-user"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- Aggiungi questo stile per compensare l'altezza della navbar e del logo -->
                <style>
                    body {
                        padding-top: 150px; /* Altezza del logo + navbar */
                    }
                </style>
            </div>
          `,
        category: 'Navbar',
    });
    } else {
// Funzioni di base negozio online -----------------------------------------------------------------------------------------------------------------------------------------------------------------------        

// everything else -----------------------------------------------------------------------------------------------------------------------------------------------------------------------  
    editor.BlockManager.add('hero-section', {
        label: 'Hero Section',
        content: `
                <section class="p-5 text-center bg-dark text-light">
                  <div class="container">
                    <h1>Benvenuto su LinkBay!</h1>
                    <p>La tua piattaforma per connetterti e condividere con il mondo.</p>
                    <a href="" class="btn btn-dark btn-lg">Scopri di più</a>
                  </div>
                </section>
              `,
        category: 'Layout',
    });
    editor.BlockManager.add('about-us-section', {
        label: 'Chi Siamo',
        content: `
                  <section class="py-5">
                    <div class="container">
                      <div class="row align-items-center">
                        <div class="col-md-6">
                          <h2>Chi Siamo</h2>
                          <p>Siamo un team di appassionati che crede nel potere della condivisione e della connessione.</p>
                          <p>Dal nostro inizio nel 2021, abbiamo lavorato per creare la migliore piattaforma possibile per i nostri utenti, consentendo loro di scoprire, condividere e crescere. Che tu stia cercando di imparare qualcosa di nuovo o di condividere la tua conoscenza, sei nel posto giusto.</p>
                        </div>
                        <div class="col-md-6">
                          <img src="" class="img-fluid" alt="Immagine rappresentativa del team">
                        </div>
                      </div>
                    </div>
                  </section>
                `,
        category: 'Layout',
    });
    editor.BlockManager.add('our-brands-section', {
        label: 'I Nostri Brand',
        content: `
                    <section class="py-5 bg-light">
                      <div class="container text-center">
                        <h2 class="mb-4">I Nostri Brand</h2>
                        <div class="row justify-content-center">
                          <div class="col-6 col-md-4">
                            <img src="path/to/brand1.jpg" alt="Brand 1" class="img-fluid mb-3">
                          </div>
                          <div class="col-6 col-md-4">
                            <img src="path/to/brand2.jpg" alt="Brand 2" class="img-fluid mb-3">
                          </div>
                          <div class="col-6 col-md-4">
                            <img src="path/to/brand3.jpg" alt="Brand 3" class="img-fluid mb-3">
                          </div>
                        </div>
                      </div>
                    </section>
                  `,
        category: 'Layout',
    });
    editor.BlockManager.add('testimonials-section', {
        label: 'Sezione Testimonianze',
        content: `
                  <section class="bg-dark text-light p-5">
                      <div class="container">
                          <h2 class="text-center mb-4">Cosa Dicono di Noi</h2>
                          <div class="row justify-content-center">
                              <div class="col-md-4 mb-4">
                                  <div class="card bg-transparent border-light">
                                      <div class="card-body text-light">
                                          <h5 class="card-title">Nome Persona</h5>
                                          <p class="card-text">"Questo prodotto ha cambiato il modo in cui vedo le cose. Non posso più farne a meno!"</p>
                                          <footer class="blockquote-footer">Nome Cognome, <cite title="Source Title">Ruolo Aziendale</cite></footer>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4 mb-4">
                                  <div class="card bg-transparent border-light">
                                      <div class="card-body text-light">
                                          <h5 class="card-title">Nome Persona</h5>
                                          <p class="card-text">"L'assistenza clienti è stata fenomenale. Risposte rapide e soluzioni efficaci."</p>
                                          <footer class="blockquote-footer">Nome Cognome, <cite title="Source Title">Ruolo Aziendale</cite></footer>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-4 mb-4">
                                  <div class="card bg-transparent border-light">
                                      <div class="card-body text-light">
                                          <h5 class="card-title">Nome Persona</h5>
                                          <p class="card-text">"Sono davvero impressionato dalla qualità del servizio. Altamente raccomandato!"</p>
                                          <footer class="blockquote-footer ">Nome Cognome, <cite title="Source Title">Ruolo Aziendale</cite></footer>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </section>
                  `,
        category: 'Layout',
    });
    editor.BlockManager.add('services-section', {
        label: 'Sezione Servizi',
        content: `
                <section class="bg-light py-5">
                    <div class="container">
                        <h2 class="text-center mb-4">I Nostri Servizi</h2>
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Servizio 1</h5>
                                        <p class="card-text">Descrizione breve del servizio offerto.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Servizio 2</h5>
                                        <p class="card-text">Descrizione breve del servizio offerto.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">Servizio 3</h5>
                                        <p class="card-text">Descrizione breve del servizio offerto.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                `,
        category: 'Layout',
    });
    editor.BlockManager.add('contact-section', {
        label: 'Sezione Contatti',
        content: `
              <section class="bg-dark text-light py-5">
                  <div class="container">
                      <div class="row">
                          <div class="col-lg-8 mx-auto text-center">
                              <h2 class="display-4 mb-4">Contattaci</h2>
                              <p class="lead">Hai domande o vuoi saperne di più sui nostri servizi? Contattaci utilizzando il modulo sottostante o tramite i nostri recapiti.</p>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-lg-6 mx-auto">
                              <form>
                                  <div class="mb-3">
                                      <label for="name" class="form-label">Nome</label>
                                      <input type="text" class="form-control" id="name" placeholder="Inserisci il tuo nome">
                                  </div>
                                  <div class="mb-3">
                                      <label for="email" class="form-label">Email</label>
                                      <input type="email" class="form-control" id="email" placeholder="Inserisci la tua email">
                                  </div>
                                  <div class="mb-3">
                                      <label for="message" class="form-label">Messaggio</label>
                                      <textarea class="form-control" id="message" rows="3" placeholder="Inserisci il tuo messaggio"></textarea>
                                  </div>
                                  <button type="submit" class="btn btn-light">Invia Messaggio</button>
                              </form>
                          </div>
                      </div>
                  </div>
              </section>
              `,
        category: 'Layout',
    });
    editor.BlockManager.add('faq-section', {
        label: 'Sezione FAQ',
        content: `
            <section class="py-5">
                <div class="container">
                    <h2 class="text-center mb-4">Domande Frequenti</h2>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Domanda 1
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Risposta alla Domanda 1.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Domanda 2
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Risposta alla Domanda 2.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            `,
        category: 'Layout',
    });

// Contenitore -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    editor.BlockManager.add('first-container', {
        label: 'first-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        Column
                    </div>
                </div>
            </div>
        </section>
`,
        category: 'Contenitore',

    });
    editor.BlockManager.add('second-container', {
        label: 'second-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        Column
                    </div>
                    <div class="col-md-6">
                        Column
                    </div>
                </div>
            </div>
        </section>
        `,
        category: 'Contenitore',

    });
    editor.BlockManager.add('third-container', {
        label: 'third-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        Column
                    </div>
                    <div class="col-md-4">
                        Column
                    </div>
                    <div class="col-md-4">
                        Column
                    </div>
                </div>
            </div>
        </section>
        `,
        category: 'Contenitore',

    });
    editor.BlockManager.add('fourth-container', {
        label: 'fourth-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        1 of 2
                    </div>
                    <div class="col-md-6">
                        2 of 2
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        1 of 3
                    </div>
                    <div class="col-md-4">
                        2 of 3
                    </div>
                    <div class="col-md-4">
                        3 of 3
                    </div>
                </div>
            </div>
        </section>
        `,
        category: 'Contenitore',

    });
    editor.BlockManager.add('fifth-container', {
        label: 'fifth-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row row-cols-2">
                    <div class="col-md-6">Column</div>
                    <div class="col-md-6">Column</div>
                    <div class="col-md-6">Column</div>
                    <div class="col-md-6">Column</div>
                </div>
            </div>
        </section>
        `,
        category: 'Contenitore',

    });
// Contenitori con link ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    editor.BlockManager.add('small-link-container', {
        label: 'small-link-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <a class="text-decoration-none fw-bold" href="#">Link 1</a>
                    </div>
                    <div class="col-md-6">
                        <a class="text-decoration-none fw-bold" href="#">Link 2</a>
                    </div>
                </div>
            </div>
        </section>
        `,
        category: 'Contenitore',

    });

    editor.BlockManager.add('link-container', {
        label: 'link-container',
        content: `
        <section class="py-3 text-center">
            <div class="container">
                <div class="row row-cols-2">
                    <div class="col-md-6"><a class="text-decoration-none fw-bold" href="#">Link 1</a></div>
                    <div class="col-md-6"><a class="text-decoration-none fw-bold" href="#">Link 2</a></div>
                    <div class="col-md-6"><a class="text-decoration-none fw-bold" href="#">Link 3</a></div>
                    <div class="col-md-6"><a class="text-decoration-none fw-bold" href="#">Link 4</a></div>
                </div>
            </div>
        </section>
        `,
        category: 'Contenitore',

    });

// Blocchi di testo ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    editor.BlockManager.add('h1', {
        label: 'Titolo h1',
        content: '<h1>Titolo</h1>',
        category: 'Testi',
    });
    editor.BlockManager.add('h2', {
        label: 'Titolo h2',
        content: '<h2>Titolo</h2>',
        category: 'Testi',
    });
    editor.BlockManager.add('h4', {
        label: 'Titolo h4',
        content: '<h4>Titolo</h4>',
        category: 'Testi',
    });
    editor.BlockManager.add('p', {
        label: 'Paragrafo',
        content: '<p>Paragrafo</p>',
        category: 'Testi',
    });
    // Blocchi Pulsanti ------------------------------------------------------------------------------------------------
    editor.BlockManager.add('button', {
        label: 'Pulsante',
        content: '<button type="button" class="btn btn-dark">Pulsante</button>',
        category: 'Pulsanti',
    });
// Prodotto --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        editor.BlockManager.add('bootstrap-navbar', {
        label: 'Prodotto stile 1',
        content: `
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <img id="mainImage" src="https://via.placeholder.com/500" class="img-fluid" alt="{{ProductTitle}}">
                    </div>
                    <div class="d-flex flex-column">
                        <img src="https://via.placeholder.com/100" class="img-thumbnail mb-2" alt="{{ProductTitle}} 1">
                        <img src="https://via.placeholder.com/100" class="img-thumbnail mb-2" alt="{{ProductTitle}} 2">
                        <img src="https://via.placeholder.com/100" class="img-thumbnail mb-2" alt="{{ProductTitle}} 3">
                        <img src="https://via.placeholder.com/100" class="img-thumbnail mb-2" alt="Customer Photo">
                    </div>
                </div>
                <div class="col-md-6">
                    <h2>{{ProductTitle}}</h2>
                    <p>{{ProductCollection}}</p>
                    <p class="text-muted">€ {{ProductPrice}}</p>
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-warning text-dark">4.5 di 5 stelle</span>
                        <span class="ms-2">(722 recensioni)</span>
                    </div>
                    <div class="mb-3">
                        <p><span class="badge text-bg-secondary">{{ProductVariant}}</span></p>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantità</label>
                        <input type="number" class="form-control" id="quantity" min="1" value="1">
                    </div>
                    <button class="btn btn-dark w-100 mb-2">Acquista Ora</button>
                    <button class="btn btn-outline-dark w-100 mb-4">Aggiungi al carrello</button>
                    
                    <div class="accordion" id="productDetails">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Dettagli Prodotto
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#productDetails">
                                <div class="accordion-body">
                                    <p>{{ProductDescription}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Stylist Notes
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#productDetails">
                                <div class="accordion-body">
                                    <p>Notes from the stylist...</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Size & Fit
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#productDetails">
                                <div class="accordion-body">
                                    <p>Information about the size and fit...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                  `,
        category: 'Negozio Online',
    });
}
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
