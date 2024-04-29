<div class="p-3 mb-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
<?php
if ($namePage == 'home'){
  $visualizzaPagina = 'index';
} else if ($namePage == 'aboutus'){
  $visualizzaPagina = 'about_us';
} else if ($namePage == 'landing'){
  $visualizzaPagina = 'landing';
} else if ($namePage == 'prodotto'){
  $visualizzaPagina = 'product';
} else if ($namePage == 'catalogo'){
  $visualizzaPagina = 'catalog';
} else if ($namePage == 'services'){
  $visualizzaPagina = 'services';
} else if ($namePage == 'contacts'){
  $visualizzaPagina = 'contacts';
}
?>
        <h4>Modifica <?php echo $namePage;?></h4>
        <a href="<?php echo htmlspecialchars("../../" . $visualizzaPagina); ?>" target="__blank" class="btn btn-outline-grey"><i class="fa-solid fa-eye"></i> Visualizza online</a>
        <button id="save-btn" class="btn btn-outline-danger"><i class="fa-solid fa-floppy-disk"></i> Salva</button>
    </div>


        <div id="base" class="full" style="overflow: hidden">
        </div>
        
        <script type="text/javascript">
          var editor = grapesjs.init({
              container: '#base',
              fromElement: true,
              height: '900px',
              width: '100%',
              storageManager: false,
              // Qui sotto inizia la personalizzazione
              plugins: ['gjs-preset-webpage'], // Se hai incluso plugin aggiuntivi
              pluginsOpts: {
                'gjs-preset-webpage': {/* opzioni del plugin */}
              },
              canvas: {
                  styles: [
                      'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'
                    ],
                  scripts: [
                      'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
                    ]
                },
          });

          // Imposta il contenuto recuperato dal database come contenuto iniziale dell'editor
          var savedContent = <?php echo json_encode($savedContent); ?>;
          if (savedContent) {
    }
        editor.setComponents(savedContent);

          // Qui aggiungo tutti i blocchi
          // Sezioni
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

              // Navbar --------------------------------------------------------------------------------------------------------
                editor.BlockManager.add('bootstrap-navbar', {
                  label: 'Navbar Stile 1',
                  content: `
                  <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                  </nav>
                  `,
                  category: 'Navbar',
              });
              editor.BlockManager.add('bootstrap-navbar-logo', {
                label: 'Navbar Stile 2',
                content: `
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                </nav>
                `,
                category: 'Navbar',
            });
            editor.BlockManager.add('navbar-with-logo', {
              label: 'Navbar con Logo',
              content: `
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
              </nav>
              `,
              category: 'Navbar',
          });
          editor.BlockManager.add('navbar-with-centered-logo', {
            label: 'Navbar con Logo Centrale',
            content: `
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <div class="d-flex justify-content-center">
                        <a class="navbar-brand" href="#">
                            <img src="logo.png" alt="Logo" width="auto" height="50" class="d-inline-block align-top">
                        </a>
                    </div>
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
            </nav>
            `,
            category: 'Navbar',
        });
        editor.BlockManager.add('navbar-with-large-logo', {
          label: 'Navbar con Logo Grande',
          content: `
          <div class="block d-flex align-items-center justify-content-center">
              <img src="logo.png" alt="Logo" class="img-fluid">
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
          </nav>
          `,
          category: 'Navbar',
      });
          

          // Blocchi di testo -------------------------------------------------------------------------------------------------
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
                  



                  $(document).ready(function() {
                    $('#save-btn').click(function() {
                      var editorContent = editor.getHtml() + '<style>' + editor.getCss() + '</style>';

                      editorContent = cleanContent(editorContent);

                      var pageName = "<?php echo $namePage; ?>"; // Ottieni il nome della pagina
                
                      // Esegue la richiesta AJAX per salvare il contenuto
                      $.ajax({
                        type: "POST",
                        url: "../ui-gestisci/save_script.php",
                        data: {
                          namePage: pageName, // Include il nome della pagina nel payload della richiesta
                          content: editorContent // Include il contenuto dell'editor
                        },
                        success: function(data) {
                          alert('Contenuto salvato con successo!');
                        },
                        error: function(xhr, status, error) {
                          alert('Si è verificato un errore nel salvataggio: ' + error);
                        }
                      });
                    });
                  });
                </script>
