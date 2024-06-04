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
                            <a class="nav-link active" aria-current="page" href="home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="aboutus">Chi Siamo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="catalog">Catalogo</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link"><i class="fa-solid fa-cart-shopping"></i></a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link"><i class="fa-solid fa-user"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"><i class="fa-solid fa-magnifying-glass"></i></a>
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
// Sezioni Personalizzate ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
editor.BlockManager.add('hero-section', {
        label: 'Hero',
        content: `
        <section class="hero-section py-5 bg-light text-center">
        <div class="container">
        <h1 class="display-4">Benvenuto su LinkBay!</h1>
        <p class="lead">Questo è un contenitore hero per presentare il tuo prodotto o servizio.</p>
        <a href="#" class="btn btn-primary btn-lg">Scopri di più</a>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
editor.BlockManager.add('testimonials', {
        label: 'Testimonianze',
        content: `
        <section class="testimonials-section py-5 bg-dark text-white">
        <div class="container">
        <h2 class="text-center">Cosa dicono di noi</h2>
        <div class="row">
        <div class="col-md-6">
        <blockquote class="blockquote">
        <p class="mb-0">Ottimo servizio e supporto eccezionale!</p>
        <br>
        <footer class="blockquote-footer text-white">Cliente soddisfatto</footer>
        </blockquote>
        </div>
        <div class="col-md-6">
        <blockquote class="blockquote">
        <p class="mb-0">Prodotto di alta qualità, consigliatissimo.</p>
        <br>
        <footer class="blockquote-footer text-white">Altro cliente soddisfatto</footer>
        </blockquote>
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
editor.BlockManager.add('grid-section', {
        label: 'Contenitore Gliglia',
        content: `
        <section class="grid-section py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="card-title">Titolo 1</h5>
                  <p class="card-text">Breve descrizione o contenuto del primo blocco.</p>
                  <a href="#" class="btn btn-primary">Leggi di più</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="card-title">Titolo 2</h5>
                  <p class="card-text">Breve descrizione o contenuto del secondo blocco.</p>
                  <a href="#" class="btn btn-primary">Leggi di più</a>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="card-title">Titolo 3</h5>
                  <p class="card-text">Breve descrizione o contenuto del terzo blocco.</p>
                  <a href="#" class="btn btn-primary">Leggi di più</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
        `,
        category: 'Sezioni',
    });
editor.BlockManager.add('services-section', {
        label: 'Servizi',
        content: `
        <section class="services-section py-5">
        <div class="container">
        <h2 class="text-center">I nostri servizi</h2>
        <div class="row">
        <div class="col-md-4">
        <div class="service-box text-center">
        <i class="bi bi-gear-fill display-4"></i>
        <h3>Servizio 1</h3>
        <p>Descrizione del primo servizio offerto.</p>
        </div>
        </div>
        <div class="col-md-4">
        <div class="service-box text-center">
        <i class="bi bi-brush-fill display-4"></i>
        <h3>Servizio 2</h3>
        <p>Descrizione del secondo servizio offerto.</p>
        </div>
        </div>
        <div class="col-md-4">
        <div class="service-box text-center">
        <i class="bi bi-laptop-fill display-4"></i>
        <h3>Servizio 3</h3>
        <p>Descrizione del terzo servizio offerto.</p>
        </div>
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
editor.BlockManager.add('portfolio', {
        label: 'Portfolio',
        content: `
        <section class="portfolio-section py-5 bg-light">
        <div class="container">
        <h2 class="text-center">Il nostro portfolio</h2>
        <div class="row">
        <div class="col-md-4">
        <div class="portfolio-item mb-4">
        <img src="img/portfolio1.jpg" class="img-fluid" alt="Portfolio 1">
        <h3 class="mt-3">Progetto 1</h3>
        <p>Descrizione del primo progetto realizzato.</p>
        </div>
        </div>
        <div class="col-md-4">
        <div class="portfolio-item mb-4">
        <img src="img/portfolio2.jpg" class="img-fluid" alt="Portfolio 2">
        <h3 class="mt-3">Progetto 2</h3>
        <p>Descrizione del secondo progetto realizzato.</p>
        </div>
        </div>
        <div class="col-md-4">
        <div class="portfolio-item mb-4">
        <img src="img/portfolio3.jpg" class="img-fluid" alt="Portfolio 3">
        <h3 class="mt-3">Progetto 3</h3>
        <p>Descrizione del terzo progetto realizzato.</p>
        </div>
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
editor.BlockManager.add('contact-form', {
        label: 'Contattaci',
        content: `
        <section class="contact-section py-5 bg-dark text-white">
        <div class="container">
        <h2 class="text-center">Contattaci</h2>
        <div class="row">
        <div class="col-md-6">
        <form method="post" action="public/form">
        <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="Il tuo nome">
        </div>
        <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input name="email" type="email" class="form-control" id="email" placeholder="La tua email">
        </div>
        <div class="mb-3">
        <label for="phone" class="form-label">Telefono</label>
        <input name="phone" type="phone" class="form-control" id="phone" placeholder="Il Tuo Telefono">
        </div>
        <div class="mb-3">
        <label for="message" class="form-label">Messaggio</label>
        <textarea name="message" class="form-control" id="message" rows="3" placeholder="Il tuo messaggio"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Invia</button>
        </form>
        </div>
        <div class="col-md-6">
        <h3 class="mt-3">Informazioni di contatto</h3>
        <p>Email: info@tuosito.com</p>
        <p>Telefono: +39 123 456 789</p>
        <p>Indirizzo: Via Esempio, 123, Città, Paese</p>
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
    editor.BlockManager.add('faq-section', {
        label: 'Sezione FAQ',
        content: `
        <section class="faq-section py-5">
        <div class="container">
        <h2 class="text-center">Domande Frequenti</h2>
        <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Domanda 1
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
            Risposta alla domanda 1.
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
            Risposta alla domanda 2.
            </div>
            </div>
            </div>
            <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            Domanda 3
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
            Risposta alla domanda 3.
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>
        `,
        category: 'Sezioni',
    });
    editor.BlockManager.add('team-section', {
        label: 'Team',
        content: `
        <section class="team-section py-5 bg-light">
        <div class="container">
        <h2 class="text-center">Il nostro Team</h2>
        <div class="row">
        <div class="col-md-4 text-center">
        <img src="img/team1.jpg" class="img-fluid rounded-circle mb-3" alt="Team Member 1">
        <h3>Nome 1</h3>
        <p>Ruolo 1</p>
        </div>
        <div class="col-md-4 text-center">
        <img src="img/team2.jpg" class="img-fluid rounded-circle mb-3" alt="Team Member 2">
        <h3>Nome 2</h3>
        <p>Ruolo 2</p>
        </div>
        <div class="col-md-4 text-center">
        <img src="img/team3.jpg" class="img-fluid rounded-circle mb-3" alt="Team Member 3">
        <h3>Nome 3</h3>
        <p>Ruolo 3</p>
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });    editor.BlockManager.add('blog-section', {
        label: 'Blog',
        content: `
        <section class="blog-section py-5">
        <div class="container">
        <h2 class="text-center">Ultimi Articoli</h2>
        <div class="row">
        <div class="col-md-4">
        <div class="card mb-4">
        <img src="img/blog1.jpg" class="card-img-top" alt="Blog 1">
        <div class="card-body">
        <h5 class="card-title">Titolo Articolo 1</h5>
        <p class="card-text">Breve descrizione dell'articolo 1.</p>
        <a href="#" class="btn btn-primary">Leggi di più</a>
        </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card mb-4">
        <img src="img/blog2.jpg" class="card-img-top" alt="Blog 2">
        <div class="card-body">
        <h5 class="card-title">Titolo Articolo 2</h5>
        <p class="card-text">Breve descrizione dell'articolo 2.</p>
        <a href="#" class="btn btn-primary">Leggi di più</a>
        </div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="card mb-4">
        <img src="img/blog3.jpg" class="card-img-top" alt="Blog 3">
        <div class="card-body">
        <h5 class="card-title">Titolo Articolo 3</h5>
        <p class="card-text">Breve descrizione dell'articolo 3.</p>
        <a href="#" class="btn btn-primary">Leggi di più</a>
        </div>
        </div>
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });    
    editor.BlockManager.add('cta-section', {
        label: 'Call To Action',
        content: `
        <section class="cta-section py-5 bg-primary text-white text-center">
        <div class="container">
        <h2>Non perdere l'occasione!</h2>
        <p>Iscriviti ora per ricevere offerte esclusive e aggiornamenti.</p>
        <a href="#" class="btn btn-light btn-lg">Iscriviti</a>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
    editor.BlockManager.add('customer-section', {
        label: 'Clienti',
        content: `
        <section class="clients-section py-5">
        <div class="container">
        <h2 class="text-center">I nostri clienti</h2>
        <div class="row text-center">
        <div class="col-md-2 col-4">
        <img src="img/client1.png" class="img-fluid mb-4" alt="Client 1">
        </div>
        <div class="col-md-2 col-4">
        <img src="img/client2.png" class="img-fluid mb-4" alt="Client 2">
        </div>
        <div class="col-md-2 col-4">
        <img src="img/client3.png" class="img-fluid mb-4" alt="Client 3">
        </div>
        <div class="col-md-2 col-4">
        <img src="img/client4.png" class="img-fluid mb-4" alt="Client 4">
        </div>
        <div class="col-md-2 col-4">
        <img src="img/client5.png" class="img-fluid mb-4" alt="Client 5">
        </div>
        <div class="col-md-2 col-4">
        <img src="img/client6.png" class="img-fluid mb-4" alt="Client 6">
        </div>
        </div>
        </div>
        </section>
        `,
        category: 'Sezioni',
    });
    editor.BlockManager.add('maps-section', {
        label: 'Maps',
        content: `
        <section class="map-section py-5">
        <div class="container">
        <h2 class="text-center">La nostra sede</h2>
        <div class="row">
        <div class="col-12">
        <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3163.0129331236756!2d-122.08424968469202!3d37.42199997982186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb5c4e4b1a3b3%3A0xdf37791f2f3eeb9b!2sGoogleplex!5e0!3m2!1sit!2sit!4v1631020672957!5m2!1sit!2sit" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            </div>
            </div>
            </div>
            </section>
        `,
        category: 'Sezioni',
    });
    editor.BlockManager.add('popular-products-section', {
    label: 'Prodotti Popolari',
    content: `
    <section class="popular-products-section py-5">
        <div class="container">
            <h2 class="text-center">Prodotti Popolari</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Prodotto 1">
                        <div class="card-body">
                            <h5 class="card-title">Prodotto 1</h5>
                            <p class="card-text">Descrizione breve del prodotto 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Prodotto 2">
                        <div class="card-body">
                            <h5 class="card-title">Prodotto 2</h5>
                            <p class="card-text">Descrizione breve del prodotto 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Prodotto 3">
                        <div class="card-body">
                            <h5 class="card-title">Prodotto 3</h5>
                            <p class="card-text">Descrizione breve del prodotto 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Sezioni',
});
editor.BlockManager.add('special-offers-section', {
    label: 'Offerte Speciali',
    content: `
    <section class="special-offers-section py-5">
        <div class="container">
            <h2 class="text-center">Offerte Speciali</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Offerta 1">
                        <div class="card-body">
                            <h5 class="card-title">Offerta 1</h5>
                            <p class="card-text">Descrizione breve dell'offerta 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Offerta 2">
                        <div class="card-body">
                            <h5 class="card-title">Offerta 2</h5>
                            <p class="card-text">Descrizione breve dell'offerta 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Offerta 3">
                        <div class="card-body">
                            <h5 class="card-title">Offerta 3</h5>
                            <p class="card-text">Descrizione breve dell'offerta 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Sezioni',
}); 
editor.BlockManager.add('services2-section', {
    label: 'Servizi 2',
    content: `
    <section class="services-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center">I Nostri Servizi</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Servizio 1</h5>
                            <p class="card-text">Descrizione breve del servizio 1.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Servizio 2</h5>
                            <p class="card-text">Descrizione breve del servizio 2.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Servizio 3</h5>
                            <p class="card-text">Descrizione breve del servizio 3.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Sezioni',
});
editor.BlockManager.add('carousel-section', {
    label: 'Carosello',
    content: `
    <section class="carousel-section">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Primo Slide</h5>
                        <p>Descrizione del primo slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="Slide 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Secondo Slide</h5>
                        <p>Descrizione del secondo slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x400" class="d-block w-100" alt="Slide 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Terzo Slide</h5>
                        <p>Descrizione del terzo slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    `,
    category: 'Sezioni',
});
// Blocchi Generici ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    editor.BlockManager.add('h1', {
        label: 'Titolo h1',
        content: '<h1>Titolo</h1>',
        category: 'Elementi',
    });
    editor.BlockManager.add('h2', {
        label: 'Titolo h2',
        content: '<h2>Titolo</h2>',
        category: 'Elementi',
    });
    editor.BlockManager.add('h4', {
        label: 'Titolo h4',
        content: '<h4>Titolo</h4>',
        category: 'Elementi',
    });
    editor.BlockManager.add('p', {
        label: 'Paragrafo',
        content: '<p>Paragrafo</p>',
        category: 'Elementi',
    });
    editor.BlockManager.add('button', {
        label: 'Pulsante',
        content: '<button type="button" class="btn btn-dark">Pulsante</button>',
        category: 'Elementi',
    });
    editor.BlockManager.add('image', {
        label: 'Immagine',
        content: '<img src="" alt="">',
        category: 'Elementi',
    });
// Blocchi Sezioni Vuote --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------    
editor.BlockManager.add('one-column-section', {
    label: 'Una Colonna',
    content: `
    <section class="one-column-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content">
                        <h2 class="text-center">Una Colonna</h2>
                        <p>Contenuto della colonna singola.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'sezioni vuote',
});
editor.BlockManager.add('two-column-section', {
    label: 'Due Colonne',
    content: `
    <section class="two-column-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="content">
                        <h2 class="text-center">Colonna 1</h2>
                        <p>Contenuto della prima colonna.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content">
                        <h2 class="text-center">Colonna 2</h2>
                        <p>Contenuto della seconda colonna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'sezioni vuote',
});
editor.BlockManager.add('three-column-section', {
    label: 'Tre Colonne',
    content: `
    <section class="three-column-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="content">
                        <h2 class="text-center">Colonna 1</h2>
                        <p>Contenuto della prima colonna.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content">
                        <h2 class="text-center">Colonna 2</h2>
                        <p>Contenuto della seconda colonna.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content">
                        <h2 class="text-center">Colonna 3</h2>
                        <p>Contenuto della terza colonna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'sezioni vuote',
});
editor.BlockManager.add('four-column-section', {
    label: 'Quattro Colonne',
    content: `
    <section class="four-column-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="content">
                        <h2 class="text-center">Colonna 1</h2>
                        <p>Contenuto della prima colonna.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content">
                        <h2 class="text-center">Colonna 2</h2>
                        <p>Contenuto della seconda colonna.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content">
                        <h2 class="text-center">Colonna 3</h2>
                        <p>Contenuto della terza colonna.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content">
                        <h2 class="text-center">Colonna 4</h2>
                        <p>Contenuto della quarta colonna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'sezioni vuote',
});
editor.BlockManager.add('mixed-column-section', {
    label: 'Colonne Miste',
    content: `
    <section class="mixed-column-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="content">
                        <h2 class="text-center">Colonna 1</h2>
                        <p>Contenuto della prima colonna.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content">
                        <h2 class="text-center">Colonna 2</h2>
                        <p>Contenuto della seconda colonna.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="content">
                        <h2 class="text-center">Colonna 3</h2>
                        <p>Contenuto della terza colonna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'sezioni vuote',
});
// Blocchi Negozio Online --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
                <div class="col-md-6"> <!-- TRASFORMA IN UN FORM -->
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
    editor.BlockManager.add('featured-products-section', {
    label: 'Prodotti in Primo Piano',
    content: `
    <section class="featured-products-section py-5">
    <div class="container">
    <h2 class="text-center">Prodotti in Primo Piano</h2>
    <div class="row">
    <div class="col-md-4">
    <div class="product-card">
    <img src="product1.jpg" class="img-fluid" alt="Prodotto 1">
    <h3>Prodotto 1</h3>
    <p>€29,99</p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="product-card">
    <img src="product2.jpg" class="img-fluid" alt="Prodotto 2">
    <h3>Prodotto 2</h3>
    <p>€39,99</p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="product-card">
    <img src="product3.jpg" class="img-fluid" alt="Prodotto 3">
    <h3>Prodotto 3</h3>
    <p>€49,99</p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    </div>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('new-arrivals-section', {
    label: 'Nuovi Arrivi',
    content: `
    <section class="new-arrivals-section py-5">
    <div class="container">
    <h2 class="text-center">Nuovi Arrivi</h2>
    <div class="row">
    <div class="col-md-4">
    <div class="product-card">
    <img src="new1.jpg" class="img-fluid" alt="Nuovo Arrivo 1">
    <h3>Nuovo Arrivo 1</h3>
    <p>€29,99</p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="product-card">
    <img src="new2.jpg" class="img-fluid" alt="Nuovo Arrivo 2">
    <h3>Nuovo Arrivo 2</h3>
    <p>€39,99</p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="product-card">
    <img src="new3.jpg" class="img-fluid" alt="Nuovo Arrivo 3">
    <h3>Nuovo Arrivo 3</h3>
    <p>€49,99</p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    </div>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('special-offers-section', {
    label: 'Offerte Speciali',
    content: `
    <section class="special-offers-section py-5">
    <div class="container">
    <h2 class="text-center">Offerte Speciali</h2>
    <div class="row">
    <div class="col-md-4">
    <div class="offer-card">
    <img src="offer1.jpg" class="img-fluid" alt="Offerta 1">
    <h3>Offerta 1</h3>
    <p>€19,99 <span class="text-muted"><s>€29,99</s></span></p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="offer-card">
    <img src="offer2.jpg" class="img-fluid" alt="Offerta 2">
    <h3>Offerta 2</h3>
    <p>€29,99 <span class="text-muted"><s>€39,99</s></span></p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    <div class="col-md-4">
    <div class="offer-card">
    <img src="offer3.jpg" class="img-fluid" alt="Offerta 3">
    <h3>Offerta 3</h3>
    <p>€39,99 <span class="text-muted"><s>€49,99</s></span></p>
    <a href="#" class="btn btn-primary">Acquista Ora</a>
    </div>
    </div>
    </div>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('customer-reviews-section', {
    label: 'Recensioni dei Clienti',
    content: `
    <section class="customer-reviews-section py-5">
    <div class="container">
    <h2 class="text-center">Recensioni dei Clienti</h2>
    <div class="row">
    <div class="col-md-4">
    <div class="review-card">
    <p>"Prodotti fantastici, qualità eccellente!"</p>
    <footer>- Giulia R.</footer>
    </div>
    </div>
    <div class="col-md-4">
    <div class="review-card">
    <p>"Servizio clienti impeccabile, consegna rapida."</p>
    <footer>- Marco T.</footer>
    </div>
    </div>
    <div class="col-md-4">
    <div class="review-card">
    <p>"Consiglio vivamente questo negozio online."</p>
    <footer>- Lucia P.</footer>
    </div>
    </div>
    </div>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('product-categories-section', {
    label: 'Categorie di Prodotti',
    content: `
    <section class="product-categories-section py-5">
    <div class="container">
    <h2 class="text-center">Categorie di Prodotti</h2>
    <div class="row">
    <div class="col-md-3">
    <div class="category-card">
    <img src="category1.jpg" class="img-fluid" alt="Categoria 1">
    <h3>Categoria 1</h3>
    <a href="#" class="btn btn-primary">Scopri di più</a>
    </div>
    </div>
    <div class="col-md-3">
    <div class="category-card">
    <img src="category2.jpg" class="img-fluid" alt="Categoria 2">
    <h3>Categoria 2</h3>
    <a href="#" class="btn btn-primary">Scopri di più</a>
    </div>
    </div>
    <div class="col-md-3">
    <div class="category-card">
    <img src="category3.jpg" class="img-fluid" alt="Categoria 3">
    <h3>Categoria 3</h3>
    <a href="#" class="btn btn-primary">Scopri di più</a>
    </div>
    </div>
    <div class="col-md-3">
    <div class="category-card">
    <img src="category4.jpg" class="img-fluid" alt="Categoria 4">
    <h3>Categoria 4</h3>
    <a href="#" class="btn btn-primary">Scopri di più</a>
    </div>
    </div>
    </div>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('newsletter-signup-section', {
    label: 'Registrazione alla Newsletter',
    content: `
    <section class="newsletter-signup-section py-5 bg-secondary text-white text-center">
    <div class="container">
    <h2>Iscriviti alla nostra Newsletter</h2>
    <p>Rimani aggiornato su tutte le novità e le offerte speciali.</p>
    <form>
    <div class="form-group">
    <input type="email" class="form-control" placeholder="Inserisci la tua email">
    </div>
    <button type="submit" class="btn btn-primary">Iscriviti</button>
    </form>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('shipping-returns-section', {
    label: 'Spedizioni e Resi',
    content: `
    <section class="shipping-returns-section py-5">
    <div class="container">
    <h2 class="text-center">Spedizioni e Resi</h2>
    <div class="row">
    <div class="col-md-6">
    <h3>Politica di Spedizione</h3>
    <p>Descrizione delle opzioni di spedizione disponibili, tempi di consegna e costi.</p>
    </div>
    <div class="col-md-6">
    <h3>Politica di Reso</h3>
    <p>Descrizione della politica di reso, come restituire un prodotto e termini e condizioni.</p>
    </div>
    </div>
    </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('product-header-section', {
    label: 'Intestazione del Prodotto',
    content: `
    <section class="product-header-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="display-4">Nome del Prodotto</h1>
                    <p class="lead">Sottotitolo o slogan del prodotto</p>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('product-images-section', {
    label: 'Immagini del Prodotto',
    content: `
    <section class="product-images-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500" class="img-fluid" alt="Immagine del Prodotto">
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500" class="img-fluid" alt="Immagine del Prodotto">
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('product-description-section', {
    label: 'Descrizione del Prodotto',
    content: `
    <section class="product-description-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Descrizione del Prodotto</h2>
                    <p>Dettagli completi del prodotto, caratteristiche principali, e benefici per il cliente.</p>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('technical-features-section', {
    label: 'Caratteristiche Tecniche',
    content: `
    <section class="technical-features-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Caratteristiche Tecniche</h2>
                    <ul>
                        <li>Caratteristica 1</li>
                        <li>Caratteristica 2</li>
                        <li>Caratteristica 3</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('cart-section', {
    label: 'Carrello',
    content: `
    <section class="cart-section py-5">
        <div class="container mt-5">
            <h2 class="mb-4">Your Shopping Cart</h2>
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Cart Items</h4>
                        </div>
                        <div class="card-body">
                            <!-- Item 1 -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="product1.jpg" class="img-fluid" alt="Product 1">
                                </div>
                                <div class="col-md-6">
                                    <h5>Product Name 1</h5>
                                    <p>Short description of the product.</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <p class="mb-0">$20.00</p>
                                    <button class="btn btn-outline-danger btn-sm mt-2">Remove</button>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img src="product2.jpg" class="img-fluid" alt="Product 2">
                                </div>
                                <div class="col-md-6">
                                    <h5>Product Name 2</h5>
                                    <p>Short description of the product.</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <p class="mb-0">$35.00</p>
                                    <button class="btn btn-outline-danger btn-sm mt-2">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p>Subtotal</p>
                                <p>$55.00</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Tax (10%)</p>
                                <p>$5.50</p>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5>Total</h5>
                                <h5>$60.50</h5>
                            </div>
                            <button class="btn btn-primary btn-block mt-3">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('customer-reviews-section', {
    label: 'Recensioni dei Clienti',
    content: `
    <section class="customer-reviews-section py-5">
        <div class="container">
            <h2 class="text-center">Recensioni dei Clienti</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="review">
                        <p>Recensione 1</p>
                        <p><strong>- Cliente 1</strong></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review">
                        <p>Recensione 2</p>
                        <p><strong>- Cliente 2</strong></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="review">
                        <p>Recensione 3</p>
                        <p><strong>- Cliente 3</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('faq-section', {
    label: 'Domande Frequenti',
    content: `
    <section class="faq-section py-5">
        <div class="container">
            <h2 class="text-center">Domande Frequenti</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Domanda 1
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Risposta alla domanda 1.
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
                                    Risposta alla domanda 2.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Domanda 3
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Risposta alla domanda 3.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    `,
    category: 'Negozio Online',
});
editor.BlockManager.add('three-images-description-section', {
    label: '3 Immagini con Descrizioni',
    content: `
    <section class="three-images-description-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/600" class="img-fluid mb-3" alt="Immagine 1">
                    <p>Descrizione dell'Immagine 1</p>
                </div>
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/600" class="img-fluid mb-3" alt="Immagine 2">
                    <p>Descrizione dell'Immagine 2</p>
                </div>
                <div class="col-md-4">
                    <img src="https://via.placeholder.com/600" class="img-fluid mb-3" alt="Immagine 3">
                    <p>Descrizione dell'Immagine 3</p>
                </div>
            </div>
        </div>
    </section>
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
