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
    <section class="py-5 bg-light">
    <div class="container">
        <!-- Titolo -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-warning">Missioni e Valori</h2>
        </div>

        <!-- Cards -->
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center py-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="mb-3">
                            <img src="path/to/your/icon1.png" alt="Icon 1" style="width: 50px;">
                        </div>
                        <h5 class="fw-bold text-primary">Lorem ybu</h5>
                        <p class="text-muted">
                            Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center py-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="mb-3">
                            <img src="path/to/your/icon2.png" alt="Icon 2" style="width: 50px;">
                        </div>
                        <h5 class="fw-bold text-primary">Lorem ybu</h5>
                        <p class="text-muted">
                            Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center py-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <div class="mb-3">
                            <img src="path/to/your/icon3.png" alt="Icon 3" style="width: 50px;">
                        </div>
                        <h5 class="fw-bold text-primary">Lorem ybu</h5>
                        <p class="text-muted">
                            Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    `,
});

editor.BlockManager.add('fondi-casse', {
    label: 'Fondi e Casse',
    content: `
<section class="py-5 bg-light">
    <div class="container">
        <!-- Titolo -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Lorem ipsum</h2>
            <p class="text-muted mx-auto" style="max-width: 800px;">
                Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
            </p>
        </div>

        <!-- Paragrafi superiori -->
        <div class="row text-center mb-5">
            <div class="col-md-6">
                <p>
                    Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
                </p>
            </div>
            <div class="col-md-6">
                <p>
                    At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                </p>
            </div>
        </div>

        <!-- Timeline -->
        <div class="position-relative">
            <div class="timeline-line position-absolute start-50 translate-middle bg-primary" style="height: 4px; width: 100%; top: 50%; z-index: 1;"></div>
            <div class="row text-center position-relative">
                <!-- Primo elemento -->
                <div class="col-md-3 mb-4">
                    <div class="timeline-item d-inline-block position-relative">
                        <div class="timeline-icon bg-warning text-white rounded-circle mb-2" style="width: 50px; height: 50px; line-height: 50px;">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <p class="fw-bold text-primary mb-0">BCC</p>
                        <p class="text-muted small">Lorem ipsum dolor sit amet, consectetur sadipscing elitr</p>
                        <p class="fw-bold">Anno</p>
                    </div>
                </div>

                <!-- Secondo elemento -->
                <div class="col-md-3 mb-4">
                    <div class="timeline-item d-inline-block position-relative">
                        <div class="timeline-icon bg-warning text-white rounded-circle mb-2" style="width: 50px; height: 50px; line-height: 50px;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <p class="fw-bold text-primary mb-0">Intesa San Paolo</p>
                        <p class="text-muted small">Lorem ipsum dolor sit amet, consectetur sadipscing elitr</p>
                        <p class="fw-bold">Anno</p>
                    </div>
                </div>

                <!-- Terzo elemento -->
                <div class="col-md-3 mb-4">
                    <div class="timeline-item d-inline-block position-relative">
                        <div class="timeline-icon bg-warning text-white rounded-circle mb-2" style="width: 50px; height: 50px; line-height: 50px;">
                            <i class="fas fa-comments"></i>
                        </div>
                        <p class="fw-bold text-primary mb-0">Banche di Trentino</p>
                        <p class="text-muted small">Lorem ipsum dolor sit amet, consectetur sadipscing elitr</p>
                        <p class="fw-bold">Anno</p>
                    </div>
                </div>

                <!-- Quarto elemento -->
                <div class="col-md-3 mb-4">
                    <div class="timeline-item d-inline-block position-relative">
                        <div class="timeline-icon bg-warning text-white rounded-circle mb-2" style="width: 50px; height: 50px; line-height: 50px;">
                            <i class="fas fa-archive"></i>
                        </div>
                        <p class="fw-bold text-primary mb-0">Ecc.</p>
                        <p class="text-muted small">Lorem ipsum dolor sit amet, consectetur sadipscing elitr</p>
                        <p class="fw-bold">Anno</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    `,
});

editor.BlockManager.add('eventi-seminari', {
    label: 'Eventi e Seminari',
    content: `
<section class="py-5 bg-light">
    <div class="container">
        <!-- Titolo -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-warning">Eventi e Seminari</h2>
            <p class="text-primary fs-5">Eventi imminenti</p>
        </div>

        <!-- Cards -->
        <div class="row g-4" id="eventi-container">
            <!-- Eventi caricati dinamicamente -->
        </div>

        <!-- Bottone -->
        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary btn-lg" style="border-radius: 25px;">Scopri di più</a>
        </div>
    </div>
</section>
    `,
});

editor.BlockManager.add('privacy-policy', {
    label: 'Privacy e Policy',
    content: `
   <header class="bg-primary text-white text-center py-4">
        <h1>Privacy Policy</h1>
        <p class="mb-0">AssoLabFondi si impegna a proteggere i tuoi dati personali</p>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <section class="mb-5">
            <h2 class="text-primary">1. Introduzione</h2>
            <p>Benvenuto su AssoLabFondi. La tua privacy è importante per noi e ci impegniamo a proteggere i tuoi dati personali in conformità con il GDPR e altre leggi applicabili.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">2. Chi Siamo</h2>
            <p>AssoLabFondi è un’associazione dedicata a fornire supporto operativo a fondi pensione, casse di previdenza e fondi sanitari. Per domande sulla privacy, contattaci a: <a href="mailto:privacy@assolabfondi.it">privacy@assolabfondi.it</a>.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">3. Quali Dati Raccogliamo</h2>
            <ul>
                <li><strong>Dati forniti dagli utenti:</strong> Nome, cognome, email, numero di telefono, dati di login.</li>
                <li><strong>Dati relativi all’utilizzo:</strong> Indirizzo IP, browser utilizzato, cronologia di navigazione.</li>
                <li><strong>Dati aggiuntivi:</strong> Informazioni relative agli eventi e ai seminari a cui partecipi.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">4. Come Utilizziamo i Dati</h2>
            <p>Utilizziamo i tuoi dati per:</p>
            <ul>
                <li>Fornire accesso ai nostri servizi e contenuti.</li>
                <li>Personalizzare la tua esperienza sulla piattaforma.</li>
                <li>Comunicare con te in relazione agli eventi e ai servizi.</li>
                <li>Adempiere a obblighi legali.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">5. Condivisione dei Dati</h2>
            <p>Non condividiamo i tuoi dati personali con terze parti, salvo nei seguenti casi:</p>
            <ul>
                <li>Fornitori di servizi che agiscono per nostro conto.</li>
                <li>Obblighi legali o richieste delle autorità competenti.</li>
                <li>Consenso esplicito da parte tua.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">6. Protezione dei Dati</h2>
            <p>Adottiamo misure di sicurezza tecniche e organizzative per proteggere i tuoi dati personali da accessi non autorizzati, perdite o divulgazioni.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">7. I Tuoi Diritti</h2>
            <p>Hai diritto a:</p>
            <ul>
                <li>Accedere ai tuoi dati personali.</li>
                <li>Richiedere la modifica o cancellazione dei dati.</li>
                <li>Revocare il consenso in qualsiasi momento.</li>
                <li>Presentare un reclamo presso l'autorità di protezione dei dati.</li>
            </ul>
            <p>Per esercitare i tuoi diritti, contattaci a: <a href="mailto:privacy@assolabfondi.it">privacy@assolabfondi.it</a>.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">8. Cookie e Tecnologie Simili</h2>
            <p>Utilizziamo cookie per migliorare la tua esperienza. Puoi gestire le tue preferenze sui cookie tramite le impostazioni del browser.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">9. Termini di Utilizzo</h2>
            <p>Accedendo alla piattaforma AssoLabFondi, accetti i nostri termini di utilizzo:</p>
            <ul>
                <li>Non caricare contenuti illeciti o offensivi.</li>
                <li>Non compromettere la sicurezza della piattaforma.</li>
            </ul>
        </section>
    </main>
    `,
});
editor.BlockManager.add('cookie-policy', {
    label: 'Cookie e Policy',
    content: `
   <!-- Header -->
    <header class="bg-warning text-white text-center py-4">
        <h1>Cookie Policy</h1>
        <p class="mb-0">Come utilizziamo i cookie sulla piattaforma AssoLabFondi</p>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <section class="mb-5">
            <h2 class="text-warning">1. Cosa Sono i Cookie?</h2>
            <p>I cookie sono piccoli file di testo che vengono salvati sul tuo dispositivo quando visiti un sito web. Servono a migliorare la tua esperienza utente, ricordando le tue preferenze o raccogliendo informazioni anonime sul tuo utilizzo del sito.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-warning">2. Tipi di Cookie Utilizzati</h2>
            <ul>
                <li><strong>Cookie Necessari:</strong> Essenziali per il funzionamento della piattaforma, ad esempio per il login e la navigazione sicura.</li>
                <li><strong>Cookie di Prestazione:</strong> Raccolgono dati anonimi sull’utilizzo del sito per migliorarne le funzionalità.</li>
                <li><strong>Cookie Funzionali:</strong> Ricordano le tue preferenze, come la lingua o la regione.</li>
                <li><strong>Cookie di Marketing:</strong> Utilizzati per mostrarti contenuti e pubblicità personalizzati.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h2 class="text-warning">3. Come Utilizziamo i Cookie?</h2>
            <p>Su AssoLabFondi utilizziamo i cookie per:</p>
            <ul>
                <li>Garantire il corretto funzionamento della piattaforma.</li>
                <li>Analizzare il traffico e migliorare l’esperienza utente.</li>
                <li>Mostrare contenuti pertinenti agli utenti registrati.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h2 class="text-warning">4. Gestione dei Cookie</h2>
            <p>Puoi gestire o eliminare i cookie in qualsiasi momento tramite le impostazioni del tuo browser. Disabilitare alcuni cookie potrebbe influire sull’esperienza di navigazione. Ecco alcune guide per i browser principali:</p>
            <ul>
                <li><a href="https://support.google.com/chrome/answer/95647" target="_blank">Google Chrome</a></li>
                <li><a href="https://support.mozilla.org/it/kb/attivare-disattivare-cookie" target="_blank">Mozilla Firefox</a></li>
                <li><a href="https://support.microsoft.com/it-it/microsoft-edge" target="_blank">Microsoft Edge</a></li>
                <li><a href="https://support.apple.com/it-it/guide/safari/sfri11471/mac" target="_blank">Apple Safari</a></li>
            </ul>
        </section>

        <section class="mb-5">
            <h2 class="text-warning">5. Cookie di Terze Parti</h2>
            <p>Potremmo utilizzare cookie di terze parti, ad esempio per analisi di traffico o per integrare funzionalità come video e social media. Questi cookie sono soggetti alle policy delle rispettive terze parti.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-warning">6. Aggiornamenti alla Cookie Policy</h2>
            <p>Questa policy potrebbe essere aggiornata per riflettere cambiamenti nelle leggi o nei nostri servizi. Ti invitiamo a controllare questa pagina periodicamente.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-warning">7. Contatti</h2>
            <p>Per qualsiasi domanda sulla nostra Cookie Policy, puoi contattarci via email a: <a href="mailto:privacy@assolabfondi.it">privacy@assolabfondi.it</a>.</p>
        </section>
    </main>
    `,
});
editor.BlockManager.add('terms-service', {
    label: 'Termini e condizioni',
    content: `
<header class="bg-primary text-white text-center py-4">
        <h1>Termini di Servizio</h1>
        <p class="mb-0">Leggi attentamente i termini prima di utilizzare la piattaforma AssoLabFondi</p>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <section class="mb-5">
            <h2 class="text-primary">1. Accettazione dei Termini</h2>
            <p>Utilizzando il sito web AssoLabFondi, accetti di rispettare i termini e le condizioni stabiliti in questa pagina. Se non accetti questi termini, ti invitiamo a non utilizzare il sito.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">2. Servizi Offerti</h2>
            <p>AssoLabFondi offre servizi informativi, formativi e operativi per fondi pensione, casse di previdenza e fondi sanitari. Tutti i servizi sono soggetti a modifiche senza preavviso.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">3. Registrazione Utente</h2>
            <p>Per accedere a determinati servizi, potrebbe essere necessario creare un account. Sei responsabile di mantenere la riservatezza delle credenziali e accetti di notificare immediatamente qualsiasi uso non autorizzato del tuo account.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">4. Contenuti Generati dagli Utenti</h2>
            <p>Gli utenti possono pubblicare contenuti, commenti o partecipare a discussioni. Tuttavia, non sono consentiti contenuti illegali, offensivi o che violino diritti di terze parti. Ci riserviamo il diritto di rimuovere tali contenuti senza preavviso.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">5. Proprietà Intellettuale</h2>
            <p>Tutti i contenuti del sito, inclusi testi, immagini, loghi e design, sono protetti da copyright e altre leggi sulla proprietà intellettuale. Non è consentito l'uso non autorizzato di tali materiali.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">6. Limitazione di Responsabilità</h2>
            <p>AssoLabFondi non sarà responsabile per eventuali danni diretti, indiretti o conseguenti derivanti dall'uso o dall'impossibilità di utilizzare i servizi forniti.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">7. Modifiche ai Termini</h2>
            <p>Ci riserviamo il diritto di aggiornare i termini di servizio in qualsiasi momento. Ti invitiamo a controllare questa pagina periodicamente per verificare eventuali modifiche.</p>
        </section>

        <section class="mb-5">
            <h2 class="text-primary">8. Contatti</h2>
            <p>Per domande sui termini di servizio, puoi contattarci via email a: <a href="mailto:info@assolabfondi.it">info@assolabfondi.it</a>.</p>
        </section>
    </main>
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

editor.BlockManager.add('storia-missioni-casse', {
    label: 'Fondicassepensioni',
    content: `
        <section class="py-5 bg-light">
    <div class="container text-center">
        <!-- Titolo -->
        <div class="mb-4">
            <h2 class="fw-bold text-primary">Fondi e Casse Previdenziali</h2>
        </div>

        <!-- Contenuto -->
        <div class="row g-4">
            <!-- Partner 1 -->
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="me-2" style="color: #007bff; font-size: 1.2rem;">•</span>
                        <h5 class="fw-bold text-primary mb-0">Partner</h5>
                    </div>
                    <p class="text-muted mt-2">
                        Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod.
                    </p>
                </div>
            </div>

            <!-- Partner 2 -->
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="me-2" style="color: #007bff; font-size: 1.2rem;">•</span>
                        <h5 class="fw-bold text-primary mb-0">Partner</h5>
                    </div>
                    <p class="text-muted mt-2">
                        Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod.
                    </p>
                </div>
            </div>

            <!-- Partner 3 -->
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="me-2" style="color: #007bff; font-size: 1.2rem;">•</span>
                        <h5 class="fw-bold text-primary mb-0">Partner</h5>
                    </div>
                    <p class="text-muted mt-2">
                        Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod.
                    </p>
                </div>
            </div>

            <!-- Partner 4 -->
            <div class="col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="me-2" style="color: #007bff; font-size: 1.2rem;">•</span>
                        <h5 class="fw-bold text-primary mb-0">Partner</h5>
                    </div>
                    <p class="text-muted mt-2">
                        Lorem ipsum dolor sit amet, consectetur sadipscing elitr, sed diam nonumy eirmod.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bottone -->
        <div class="mt-4">
            <a href="#" class="btn btn-primary btn-lg">Area Utente</a>
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
editor.BlockManager.add('home-hero-bg', {
    label: 'Hero Con BackGround',
    content: `
    <section class="position-relative text-center text-white" style="background: url('admin/materials/senior-couple-communicating-with-insurance-agent-while-having-consultations-with-him-office-focus-is-woman.png') center/cover no-repeat; height: 100vh;">
        <div class="position-absolute top-50 start-50 translate-middle" style="max-width: 800px;">
            <h1 class="display-4 fw-bold text-primary">Lorem ipsum dolor sit amet,<br>consetetur</h1>
            <p class="fs-5 text-primary mt-3">Lorem ipsum dolor sit amet, consetetur Lorem ipsum<br>dolor sit amet, consetetur</p>
            <div class="mt-4">
                <a href="#" class="btn text-white btn-lg me-3" style="background: #F08046;">Scopri di più</a>
                <a href="#" class="btn text-white btn-lg" style="background: #F08046;">Area personale</a>
            </div>
        </div>
    </section>
    `,
});

editor.BlockManager.add('aboutus-hero-bg', {
    label: 'Section why choose us?',
    content: `
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-4" style="color: #f07e46;">Storia e Missioni</h2>
        <div class="row">
            <!-- Colonna Storia -->
            <div class="col-md-6">
                <p class="text-primary">
                    AssoLabFondi nasce con l’obiettivo di rivoluzionare il settore previdenziale in Italia, offrendo 
                    supporto operativo e formazione su strumenti finanziari innovativi. L'associazione si pone come 
                    una realtà indipendente e completamente priva di influenze politiche o sindacali. La visione di 
                    AssoLabFondi è quella di essere un punto di riferimento per i cambiamenti e l’innovazione, creando 
                    opportunità per aziende e professionisti di diversificare i propri portafogli con soluzioni innovative.
                </p>
            </div>
            <!-- Colonna Perché scegliere noi -->
            <div class="col-md-6">
                <h5 class="text-primary fw-bold">PERCHÉ SCEGLIERE NOI?</h5>
                <ol class="text-primary">
                    <li>Operiamo con un approccio pratico e senza influenze politiche o sindacali.</li>
                    <li>Promuoviamo l’adozione di strumenti innovativi come private equity, infrastrutture e polizze catastrofali.</li>
                    <li>Ci impegniamo a fornire formazione e confronto diretto per creare valore reale nel settore previdenziale.</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    `,
});
editor.BlockManager.add('aboutus-conti-bg', {
    label: 'Who is Character?',
    content: `
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Immagine principale -->
            <div class="col-md-4 text-center">
                <div style="width: 200px; height: 200px; border-radius: 50%; overflow: hidden; background-color: #f1f1f1;">
                    <img src="" alt="Immagine di Sergio Carfizzi" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <!-- Testo principale -->
            <div class="col-md-8">
                <h2 class="fw-bold" style="color: #f07e46;">Sergio Carfizzi</h2>
                <p class="text-primary">
                    Sergio Carfizzi è un esperto di finanza internazionale con una carriera di oltre 20 anni nel settore 
                    della previdenza complementare. Ha ricoperto ruoli di spicco come Direttore Generale presso 
                    importanti fondi pensione e ha dedicato la sua vita a promuovere innovazione e inclusività, puntando 
                    sull'importanza del capitale umano, sia junior che senior. Il suo obiettivo è sempre stato quello 
                    di coniugare etica e performance, esplorando nuovi orizzonti di investimento come private equity, 
                    infrastrutture e polizze catastrofali.
                </p>
            </div>
        </div>
    </div>
</section>
    `,
});
editor.BlockManager.add('space', {
    label: 'SPACE',
    content: `
    <br>
    `,
});

editor.BlockManager.add('login', {
    label: 'Login',
    content: `
<section class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card p-4 shadow-sm" style="max-width: 400px; width: 100%;">
        <h2 class="text-center text-primary mb-4">Login</h2>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Accedi</button>
        </form>
        <p class="text-center mt-3">Non hai un account? <a href="Registrati" class="text-primary">Registrati</a></p>
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
                    <p class="text-muted">Benvenuto {{ nome }} nella tua area riservata.</p>
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
                            <a href="logout.php" class="btn btn-primary btn-sm">Logout</a>
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
        <!-- Form che invia i dati a register.php -->
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" id="cognome" name="cognome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrati</button>
        </form>
        <p class="text-center mt-3">Hai già un account? <a href="Login" class="text-primary">Accedi</a></p>
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
                    <div class="chat-container">
                        <div id="chat-messages" class="chat-messages" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                            <!-- I messaggi verranno caricati qui dinamicamente -->
                        </div>
                        <form id="chat-form" style="margin-top: 10px;">
                            <input type="text" id="user-message" placeholder="Scrivi un messaggio..." style="width: 80%; padding: 10px;" required>
                            <button type="submit" style="padding: 10px;">Invia</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    `,
});

editor.BlockManager.add('navbar', {
    label: 'Navbar',
    content: `
       <nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-body-tertiary">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                 <img src="" alt="Logo" width="150px"> 
            </a>
            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home"> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="About-us"> Chi Siamo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login"><i class="fa-solid fa-user"></i> Accedi</a>
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
<footer style="background-color: #003f88; color: #fff; padding: 40px 20px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <!-- Logo al centro -->
        <img src="" alt="Logo AssoLabFondi" style="width: 150px; height: auto;">
    </div>
    <div style="display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center;">
        <!-- Colonna 1: Info Legali -->
        <div style="flex: 1; min-width: 200px; margin: 10px;">
            <h3 style="margin-bottom: 10px;">Info Legali</h3>
            <p style="font-size: 0.9rem;">Privacy Policy</p>
            <p style="font-size: 0.9rem;">Termini e Condizioni</p>
            <p style="font-size: 0.9rem;">Cookie Policy</p>
        </div>
        <!-- Colonna 2: Link di Riferimento -->
        <div style="flex: 1; min-width: 200px; margin: 10px;">
            <h3 style="margin-bottom: 10px;">Link</h3>
            <p style="font-size: 0.9rem;"><a href="#" style="color: #fff; text-decoration: none;">Home</a></p>
            <p style="font-size: 0.9rem;"><a href="#" style="color: #fff; text-decoration: none;">Chi Siamo</a></p>
            <p style="font-size: 0.9rem;"><a href="#" style="color: #fff; text-decoration: none;">Contatti</a></p>
        </div>
        <!-- Colonna 3: Social -->
        <div style="flex: 1; min-width: 200px; margin: 10px;">
            <h3 style="margin-bottom: 10px;">Social</h3>
            <a href="#" style="margin: 0 5px; color: #fff; text-decoration: none; font-size: 1.5rem;">
                <i class="fab fa-linkedin"></i>
            </a>
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