<div id="sidebar" class="d-flex flex-column flex-shrink-0 sidebar collapse bg-dark text-white">
    <!-- Bottone Toggle per Mobile -->
    <button class="btn btn-danger d-md-none position-fixed top-0 start-0 m-2" id="toggleSidebar">
        <i class="fa-solid fa-bars"></i>
    </button>

    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    &nbsp;&nbsp;&nbsp;&nbsp; <img src="../materials/logo_sidebar.png" width="180px" alt="Logo">
    </a>

    <style>
        /* Animazioni e Responsive */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                height: 100%;
                width: 250px;
                transition: 0.3s ease-in-out;
                z-index: 1050;
            }

            #sidebar.show {
                left: 0;
            }

            #toggleSidebar {
                z-index: 1100;
            }
        }

        .nav-link {
            transition: transform 0.3s ease;
        }

        .nav-link:hover {
            transform: scale(1.1);
            transition: 0.3s ease;
        }

        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: whitesmoke !important;
            background-color: #ff5757 !important;
        }
    </style>

    <hr>

    <ul class="nav nav-pills flex-column mb-auto" style="padding: 0px 8px 0px 8px;">
        <li class="nav-item">
            <a href="homepage" class="nav-link text-white <?php echo ($currentPage == 'homepage.php') ? 'active' : ''; ?>">
                <i class="fa-solid fa-table-columns"></i>&nbsp; Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#gestioneClientiCollapse">
                <i class="fa-solid fa-users"></i>&nbsp; Clienti
            </a>
            <div class="collapse" id="gestioneClientiCollapse">
                <ul class="nav flex-column ms-3">
                    <li><a href="clienti" class="nav-link text-white">Lista Clienti</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#gestioneMarketingCollapse">
                <i class="fa-solid fa-chart-simple"></i>&nbsp; Marketing
            </a>
            <div class="collapse" id="gestioneMarketingCollapse">
                <ul class="nav flex-column ms-3">
                    <li><a href="analisi" class="nav-link text-white">Analisi</a></li>
                    <li><a href="leads" class="nav-link text-white">Leads</a></li>
                    <li><a href="campagne" class="nav-link text-white">Campagne</a></li>
                </ul>
            </div>
        </li>



 <!-- Applicazioni e Plugin -->
 <li class="nav-item">
            <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#gestioneAppCollapse" aria-expanded="false">
                <i class="fa-solid fa-square-plus"></i>&nbsp; Applicazioni e Plugin
            </a>
            <div class="collapse <?php echo ($sidebar_cate == 'App') ? 'show' : ''; ?>" id="gestioneAppCollapse">
                <ul class="nav flex-column ms-3">
                    <li><a href="chat_clienti" class="nav-link text-white <?php echo ($currentPage == 'chat_clienti.php') ? 'active' : ''; ?>">Chat con Clienti</a></li>
                    <li><a href="eventi" class="nav-link text-white <?php echo ($currentPage == 'eventi.php') ? 'active' : ''; ?>">Eventi per Clienti</a></li>
                    <li><a href="aggiunta_prodotti" class="nav-link text-white <?php echo ($currentPage == 'aggiunta_prodotti.php') ? 'active' : ''; ?>">Aggiunta Prodotti Digitali</a></li>
                </ul>
            </div>
        </li>

        <!-- Editor Sito Web -->
        <li class="nav-item">
            <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#gestioneNegozioCollapse" aria-expanded="false">
                <i class="fa-solid fa-store"></i>&nbsp; Editor Sito Web
            </a>
            <div class="collapse <?php echo ($sidebar_cate == 'negozio') ? 'show' : ''; ?>" id="gestioneNegozioCollapse">
                <ul class="nav flex-column ms-3">
                    <li><a href="editor_negozio" class="nav-link text-white <?php echo ($currentPage == 'editor_negozio.php') ? 'active' : ''; ?>">Modifica Sito Web</a></li>
                    <li><a href="brand_identity" class="nav-link text-white <?php echo ($currentPage == 'brand_identity.php') ? 'active' : ''; ?>">Brand identity</a></li>
                </ul>
            </div>
        </li>

        <!-- Impostazioni -->
        <li class="nav-item">
            <a class="nav-link text-white collapsed" data-bs-toggle="collapse" href="#gestioneSettingCollapse" aria-expanded="false">
                <i class="fa-solid fa-gear"></i>&nbsp; Impostazioni
            </a>
            <div class="collapse <?php echo ($sidebar_cate == 'impostazioni') ? 'show' : ''; ?>" id="gestioneSettingCollapse">
                <ul class="nav flex-column ms-3">
                    <li><a href="dettagli_negozio" class="nav-link text-white <?php echo ($currentPage == 'dettagli_negozio.php') ? 'active' : ''; ?>">Dettagli Sito Web</a></li>
                    <li><a href="utenti_ruoli" class="nav-link text-white <?php echo ($currentPage == 'utenti_ruoli.php') ? 'active' : ''; ?>">Utenti e Ruoli</a></li>
                    <li><a href="ore_assistenza" class="nav-link text-white <?php echo ($currentPage == 'ore_assistenza.php') ? 'active' : ''; ?>">Ore Assistenza</a></li>
                    <li><a href="piano_contratto" class="nav-link text-white <?php echo ($currentPage == 'piano_contratto.php') ? 'active' : ''; ?>">Piano/Contratto</a></li>
                    <li><a href="aggiornamento" class="nav-link text-white <?php echo ($currentPage == 'aggiornamento.php') ? 'active' : ''; ?>">Aggiornamento Software</a></li>
                </ul>
            </div>
        </li>
    </ul>

    <hr>

    <div class="dropdown">
        <a href="#" class="text-white text-decoration-none dropdown-toggle" style="padding: 15px;" data-bs-toggle="dropdown">
            <img src="https://www.linkbay.it/static/image/og-image.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong><?php echo $_SESSION['nome']; ?> <?php echo $_SESSION['cognome']; ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="utenti_ruoli">Impostazioni</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="../logout"><i class="fa-solid fa-right-from-bracket"></i>&nbsp; Esci</a></li>
        </ul>
        <br><br>
    </div>
</div>

<script>
    document.getElementById("toggleSidebar").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("show");
    });
</script>
