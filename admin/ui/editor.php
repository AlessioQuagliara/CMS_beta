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

    editor.BlockManager.add('carousel-logos', {
    label: 'Carosello Loghi',
    category: 'Componenti',
    content: `
        <div class="container text-center my-4">
            <h2 class="fw-bold">ALCUNI NOSTRI PARTNER</h2>
            <div class="divider mx-auto mb-4" style="width: 50px; height: 3px; background-color: red;"></div>
            
            <div id="partnerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 1">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 2">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 3">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 4">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 5">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 6">
                    </div>
                    <div class="carousel-item">
                        <img src="https://via.placeholder.com/300x150" class="d-block mx-auto" alt="Logo 7">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#partnerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#partnerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    `,
});

  
    editor.BlockManager.add('section', {
            label: '<i class="fa-solid fa-border-top fa-4x"></i> Section',
            content: '<section class="py-5 bg-light">\n <div class="container">\n <h2 class="fw-bold text-dark text-center">Section Title</h2>\n <p class="text-center text-muted">\n Add your content here...</p>\n </div>\n </section>',
            category: 'Layout',
        });

        editor.BlockManager.add('full-section', {
            label: '<i class="fa-solid fa-expand fa-4x"></i> Full Section',
            content: '<section class="vh-100 d-flex align-items-center justify-content-center bg-dark text-white"><div class="container text-center"><h2 class="fw-bold">Full Width Section</h2><p>This section takes the full viewport height.</p></div></section>',
            category: 'Layout',
        });

        editor.BlockManager.add('container-layout', {
            label: '<i class="fa-solid fa-box fa-4x"></i> Container',
            content: '<section class="container py-5 bg-light"></section>',
            category: 'Layout',
        });

        editor.BlockManager.add('heading', {
            label: '<i class="fa-solid fa-heading fa-4x"></i> Heading',
            content: '<h2 class="fw-bold text-dark">Heading</h2>',
            category: 'Basic',
        });

        editor.BlockManager.add('image', {
            label: '<i class="fa-solid fa-image fa-4x"></i> Image',
            content: '<img src="https://via.placeholder.com/350x250" class="img-fluid"/>',
            category: 'Basic',
        });

        editor.BlockManager.add('text-editor', {
            label: '<i class="fa-solid fa-file-alt fa-4x"></i> Text Editor',
            content: '<div class="p-3">Write your text here...</div>',
            category: 'Basic',
        });

        editor.BlockManager.add('video', {
            label: '<i class="fa-solid fa-video fa-4x"></i> Video',
            content: '<video controls><source src="movie.mp4" type="video/mp4">Your browser does not support the video tag.</video>',
            category: 'Basic',
        });

        editor.BlockManager.add('button', {
            label: '<i class="fa-solid fa-hand-pointer fa-4x"></i> Button',
            content: '<button class="btn btn-primary">Click Me</button>',
            category: 'Basic',
        });

        editor.BlockManager.add('divider', {
            label: '<i class="fa-solid fa-grip-lines fa-4x"></i> Divider',
            content: '<hr class="my-4"/>',
            category: 'Basic',
        });

        editor.BlockManager.add('spacer', {
            label: '<i class="fa-solid fa-arrows-alt-v fa-4x"></i> Spacer',
            content: '<div style="height: 50px;"></div>',
            category: 'Basic',
        });

        editor.BlockManager.add('google-maps', {
            label: '<i class="fa-solid fa-map-marker-alt fa-4x"></i> Google Maps',
            content: '<iframe width="100%" height="300" frameborder="0" style="border:0" src="https://www.google.com/maps/embed" allowfullscreen></iframe>',
            category: 'Advanced',
        });

        editor.BlockManager.add('icon', {
            label: '<i class="fa-solid fa-icons fa-4x"></i> Icon',
            content: '<i class="fa-solid fa-star"></i>',
            category: 'Basic',
        });

        editor.BlockManager.add('form', {
            label: '<i class="fa-solid fa-envelope fa-4x"></i> Form',
            content: '<form><input type="text" placeholder="Your Name" class="form-control mb-2"/><input type="email" placeholder="Your Email" class="form-control mb-2"/><textarea placeholder="Your Message" class="form-control mb-2"></textarea><button class="btn btn-primary">Submit</button></form>',
            category: 'Forms',
        });

        editor.BlockManager.add('grid', {
            label: '<i class="fa-solid fa-th-large fa-4x"></i> Grid',
            content: '<div class="row"><div class="col-md-6 bg-light p-3">Column 1</div><div class="col-md-6 bg-dark text-white p-3">Column 2</div></div>',
            category: 'Layout',
        });

        editor.BlockManager.add('image-box', {
            label: '<i class="fa-solid fa-image fa-4x"></i> Image Box',
            content: '<div class="text-center"><img src="https://via.placeholder.com/150" class="img-fluid mb-2"/><h4>Title</h4><p>Description</p></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('icon-box', {
            label: '<i class="fa-solid fa-icons fa-4x"></i> Icon Box',
            content: '<div class="text-center"><i class="fa-solid fa-star fa-3x mb-2"></i><h4>Title</h4><p>Description</p></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('image-carousel', {
            label: '<i class="fa-solid fa-images fa-4x"></i> Image Carousel',
            content: '<div id="carouselExample" class="carousel slide" data-bs-ride="carousel"><div class="carousel-inner"><div class="carousel-item active"><img src="https://via.placeholder.com/800x400" class="d-block w-100"></div><div class="carousel-item"><img src="https://via.placeholder.com/800x400" class="d-block w-100"></div></div><button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button><button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('basic-gallery', {
            label: '<i class="fa-solid fa-th fa-4x"></i> Basic Gallery',
            content: '<div class="row"><div class="col-4"><img src="https://via.placeholder.com/150" class="img-fluid"></div><div class="col-4"><img src="https://via.placeholder.com/150" class="img-fluid"></div><div class="col-4"><img src="https://via.placeholder.com/150" class="img-fluid"></div></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('icon-list', {
            label: '<i class="fa-solid fa-list fa-4x"></i> Icon List',
            content: '<ul class="list-unstyled"><li><i class="fa-solid fa-check"></i> Item 1</li><li><i class="fa-solid fa-check"></i> Item 2</li><li><i class="fa-solid fa-check"></i> Item 3</li></ul>',
            category: 'Elements',
        });

        editor.BlockManager.add('counter', {
            label: '<i class="fa-solid fa-sort-numeric-up fa-4x"></i> Counter',
            content: '<div class="text-center"><h2 class="fw-bold">100</h2><p>Completed Projects</p></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('progress-bar', {
            label: '<i class="fa-solid fa-chart-line fa-4x"></i> Progress Bar',
            content: '<div class="progress"><div class="progress-bar" role="progressbar" style="width: 75%;">75%</div></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('testimonial', {
            label: '<i class="fa-solid fa-comment fa-4x"></i> Testimonial',
            content: '<blockquote class="blockquote"><p>"This is the best service I have ever used!"</p><footer class="blockquote-footer">John Doe</footer></blockquote>',
            category: 'Elements',
        });

        editor.BlockManager.add('tabs', {
            label: '<i class="fa-solid fa-folder fa-4x"></i> Tabs',
            content: '<ul class="nav nav-tabs"><li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1">Tab 1</a></li><li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2">Tab 2</a></li></ul><div class="tab-content"><div id="tab1" class="tab-pane fade show active p-3">Content 1</div><div id="tab2" class="tab-pane fade p-3">Content 2</div></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('accordion', {
            label: '<i class="fa-solid fa-bars fa-4x"></i> Accordion',
            content: '<div class="accordion" id="accordionExample"><div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Accordion Item #1</button></h2><div id="collapseOne" class="accordion-collapse collapse show"><div class="accordion-body">Content</div></div></div></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('toggle', {
            label: '<i class="fa-solid fa-toggle-on fa-4x"></i> Toggle',
            content: '<label class="switch"><input type="checkbox"><span class="slider round"></span></label>',
            category: 'Elements',
        });

        editor.BlockManager.add('rating', {
            label: '<i class="fa-solid fa-star-half-alt fa-4x"></i> Rating',
            content: '<div class="rating"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-alt"></i></div>',
            category: 'Elements',
        });

        editor.BlockManager.add('call-to-action', {
            label: '<i class="fa-solid fa-bullhorn fa-4x"></i> Call to Action',
            content: '<div class="text-center p-5 bg-primary text-white"><h2>Join Us Today!</h2><p>Sign up now and enjoy exclusive benefits.</p><button class="btn btn-light">Get Started</button></div>',
            category: 'Marketing',
        });

        editor.BlockManager.add('team-section', {
            label: '<i class="fa-solid fa-users fa-4x"></i> Team Section',
            content: '<div class="row text-center"><div class="col-md-4"><img src="https://via.placeholder.com/150" class="rounded-circle mb-2"><h4>Member Name</h4><p>Role</p></div><div class="col-md-4"><img src="https://via.placeholder.com/150" class="rounded-circle mb-2"><h4>Member Name</h4><p>Role</p></div><div class="col-md-4"><img src="https://via.placeholder.com/150" class="rounded-circle mb-2"><h4>Member Name</h4><p>Role</p></div></div>',
            category: 'Sections',
        });

        editor.BlockManager.add('timeline', {
            label: '<i class="fa-solid fa-stream fa-4x"></i> Timeline',
            content: '<ul class="timeline"><li><div class="timeline-badge"><i class="fa-solid fa-check"></i></div><div class="timeline-panel"><h4>Event Title</h4><p>Description of the event.</p></div></li><li><div class="timeline-badge"><i class="fa-solid fa-check"></i></div><div class="timeline-panel"><h4>Event Title</h4><p>Description of the event.</p></div></li></ul>',
            category: 'Advanced',
        });

        editor.BlockManager.add('pricing-table', {
            label: '<i class="fa-solid fa-table fa-4x"></i> Pricing Table',
            content: '<div class="row text-center"><div class="col-md-4"><div class="card"><div class="card-header">Basic</div><div class="card-body"><h4>$9.99/month</h4><p>Basic Features</p><button class="btn btn-primary">Choose Plan</button></div></div></div><div class="col-md-4"><div class="card"><div class="card-header">Standard</div><div class="card-body"><h4>$19.99/month</h4><p>Standard Features</p><button class="btn btn-primary">Choose Plan</button></div></div></div><div class="col-md-4"><div class="card"><div class="card-header">Premium</div><div class="card-body"><h4>$29.99/month</h4><p>Premium Features</p><button class="btn btn-primary">Choose Plan</button></div></div></div></div>',
            category: 'Business',
        });

        editor.BlockManager.add('faq-section', {
            label: '<i class="fa-solid fa-question-circle fa-4x"></i> FAQ Section',
            content: '<div class="accordion" id="faqAccordion"><div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">What is your return policy?</button></h2><div id="faq1" class="accordion-collapse collapse show"><div class="accordion-body">We accept returns within 30 days.</div></div></div><div class="accordion-item"><h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">How do I track my order?</button></h2><div id="faq2" class="accordion-collapse collapse"><div class="accordion-body">Track your order through our website.</div></div></div></div>',
            category: 'Support',
        });

        editor.BlockManager.add('newsletter-signup', {
            label: '<i class="fa-solid fa-envelope-open-text fa-4x"></i> Newsletter Signup',
            content: '<div class="text-center p-4 bg-light"><h3>Subscribe to our Newsletter</h3><p>Stay updated with our latest news and offers.</p><input type="email" placeholder="Enter your email" class="form-control mb-2"><button class="btn btn-primary">Subscribe</button></div>',
            category: 'Marketing',
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