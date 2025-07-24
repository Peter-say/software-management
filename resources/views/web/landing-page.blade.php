<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Portfolio Preview</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Arnau Ros – Graphic Designer & Content Creator based in Barcelona. Available for freelance & collaborations. View projects, content, and get in touch.">
    <meta name="keywords"
        content="Arnau Ros, graphic designer, content creator, Barcelona, freelance, branding, web design, portfolio, Figma, Webflow">
    <meta name="author" content="Arnau Ros">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Arnau Ros – Graphic Designer & Content Creator">
    <meta property="og:description"
        content="Portfolio of Arnau Ros, Barcelona-based designer. Projects, content, and contact.">
    <meta property="og:image" content="{{ asset('web/images/og-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Arnau Ros – Graphic Designer & Content Creator">
    <meta name="twitter:description"
        content="Portfolio of Arnau Ros, Barcelona-based designer. Projects, content, and contact.">
    <meta name="twitter:image" content="{{ asset('web/images/og-image.jpg') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('web/css/landing-page.css') }}">
</head>

<body>

    <!-- Header -->
    <nav class="navbar navbar-light bg-white px-4 py-3 shadow-sm position-relative">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <span class="logo-circle">ar</span>
            <div class="d-none d-md-flex ms-auto" id="navbarLinks" style="font-weight: 600; font-size: 1.08rem;">
                <a href="#" class="text-decoration-none mx-3 nav-link-custom">Work</a>
                <a href="#" class="text-decoration-none mx-3 nav-link-custom">About</a>
                <a href="#" class="text-decoration-none mx-3 nav-link-custom">Contact</a>
            </div>
            <button class="navbar-toggler d-md-none border-0 ms-2" type="button" id="navbarToggleBtn"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <!-- Mobile menu -->
        <div class="d-md-none mobile-nav-collapse" id="mobileNav">
            <div class="bg-white px-4 py-3 shadow-sm d-flex flex-column align-items-center justify-content-center">
                <a href="#" class="mb-2 nav-link-custom">Work</a>
                <a href="#" class="mb-2 nav-link-custom">About</a>
                <a href="#" class="mb-2 nav-link-custom">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container py-5 bg-white my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="hero-text">I’m Arnau Ros, a graphic designer & content creator based in Barcelona.
                    <span>Available</span> for freelance & collaborations.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://picsum.photos/id/237/600/400" class="img-fluid" alt="Bird">
            </div>
        </div>


        <!-- Projects Section -->
        <div class="py-5 bg-white border-top">
            <h3 class="mb-4">Projects</h3>
            <div class="row">
                <div class="col-12 col-md-4 mb-4">
                    <h6>01 Example</h6>
                    <img src="https://picsum.photos/id/1011/600/400" class="project-img w-100" alt="Project 1">
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <h6>02 Example</h6>
                    <img src="https://picsum.photos/id/1015/600/400" class="project-img w-100" alt="Project 2">
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <h6>03 Example</h6>
                    <img src="https://picsum.photos/id/1016/600/400" class="project-img w-100" alt="Project 3">
                </div>
            </div>
        </div>



        <section class=" py-5">
            <h2 class="display-4 fw-bold">Content Creation</h2>
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <p class="lead">Join my YouTube channel where I show my design thinking, my process, and my
                        personality. The channel has helped over 200K designers become more proficient in the tools I
                        use everyday, Figma, Webflow & more. Join the journey!</p>
                    <a href="#" class="btn btn-link text-decoration-none text-dark d-flex align-items-center">
                        Get in contact about a sponsorship <i class="fas fa-arrow-down ms-2"></i>
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="video-container w-100">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/YOUR_VIDEO_ID"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </section>

        <section class=" py-5">
            <h2 class="display-5 fw-bold mb-4">About Me</h2>
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <p>I'm a product designer working on various projects on a wide range of clients. My skillset lies
                        on
                        creating branding packages & websites to deliver the full online experience for new and also
                        veteran
                        businesses.</p>
                    <p>You often find me creating videos about design over on YouTube, or sharing my thoughts on my
                        podcast,
                        Dialogue With Designers. I'm passionate about giving back and teaching what I know to the next
                        generation of designers.</p>
                </div>
                <div class="col-md-6">
                    <h3 class="h4 mb-3">Your one stop shop for:</h3>
                    <div class="accordion" id="accordionServices">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <span><span class="service-number">①</span> Branding / Logo</span>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionServices">
                                <div class="accordion-body">
                                    <p class="small text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing
                                        elit. Mi
                                        sed pulvinar dictum tempor. Etiam dui massa elementum. Etiam nec tristique.
                                        Lorem
                                        ipsum dolor sit amet, consectetur adipiscing elit. Mi sed pulvinar dictum
                                        tempor.
                                        Etiam dui massa elem. Sterring at c 2.450</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <span><span class="service-number">②</span> Packaging</span>
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionServices">
                                <div class="accordion-body">
                                    <p class="small text-muted">Content for Packaging service...</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    <span><span class="service-number">③</span> Websites</span>
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionServices">
                                <div class="accordion-body">
                                    <p class="small text-muted">Content for Websites service...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-4">
            <hr>
            <div class="d-flex flex-wrap justify-content-start align-items-center gap-3 footer-skills">
                <span class="text-muted">Languages</span>
                <span class="text-muted">•</span>
                <span class="text-muted">HTML</span>
                <span class="text-muted">•</span>
                <span class="text-muted">CSS</span>
                <span class="text-muted">•</span>
                <span class="text-muted">JavaScript</span>
                <span class="text-muted">•</span>
                <span class="text-muted">PHP</span>
                <span class="text-muted">•</span>
                <span class="text-muted">Blade</span>
                <span class="text-muted">•</span>
                <span class="text-muted">SQL</span>
                <span class="text-muted">•</span>
                <span class="text-muted">Sass</span>
            </div>
        </footer>

        <section id="testimonials" class="py-5">
            <div class="">
                <h2 class="text-center mb-4">What Clients Say</h2>
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-touch="true">
                    <div class="carousel-inner">
                        <div class="carousel-item active text-center">
                            <p class="lead">"I rehired Arnau to do some additional design work for my private label
                                brand. Again, he was creative and efficient in bringing my ideas to fruition. Thanks
                                Arnau"
                            </p>
                            <p class="fw-bold">- Ronald Weasley</p>
                            <p class="text-muted">CEO</p>
                        </div>
                        <div class="carousel-item text-center">
                            <p class="lead">"Arnau exceeded our expectations with his attention to detail and
                                creative approach. Highly recommended!"</p>
                            <p class="fw-bold">- Hermione Granger</p>
                            <p class="text-muted">Product Manager</p>
                        </div>
                        <div class="carousel-item text-center">
                            <p class="lead">"Professional, timely, and talented. Will definitely work with Arnau
                                again for future projects."</p>
                            <p class="fw-bold">- Harry Potter</p>
                            <p class="text-muted">Entrepreneur</p>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>

        <section id="contact" class="py-5 bg-light">
            <div class="">
                <h2 class="mb-4">Say Hello</h2>
                <div class="row">
                    <div class="col-md-6">
                        <p>Looking to start a new project or just want to say hi? Send me an email and I'll do my best
                            to
                            reply within 24 hrs!</p>
                        <p>If contact forms aren't your thing... send me an email at <a
                                href="mailto:hello@arnau.design">hello@arnau.design</a></p>
                    </div>
                    <div class="col-md-6">
                        <form action="https://formsubmit.io/send/hello@arnau.design" method="POST">
                            <input name="_redirect" type="hidden" id="redirect"
                                value="{{ url()->current() }}?success=1">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstName" class="form-label visually-hidden">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="First Name"
                                        placeholder="First Name*" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label visually-hidden">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="Last Name"
                                        placeholder="Last Name*" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="inquiry" class="form-label visually-hidden">Inquiry</label>
                                    <select class="form-select" id="inquiry" name="Inquiry">
                                        <option selected>Collab/Client</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label visually-hidden">Email</label>
                                    <input type="email" class="form-control" id="email" name="Email"
                                        placeholder="hello@arnaudesign" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label visually-hidden">Message</label>
                                    <textarea class="form-control" id="message" name="Message" rows="5" placeholder="Hello..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section id="recent-blogs" class="py-5">
            <div class="container">
                <hr class="mb-5 custom-hr">
                <h2 class="text-center mb-5">Recent Blogs</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="blog-card">
                            <h4 class="blog-title">The ULTIMATE Figma UI Kit (Tailwind-Figma)</h4>
                            <p class="blog-date">24.09.21</p>
                            <a href="#" class="blog-link">See Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="blog-card">
                            <h4 class="blog-title">The ULTIMATE Figma UI Kit (Tailwind-Figma)</h4>
                            <p class="blog-date">24.09.21</p>
                            <a href="#" class="blog-link">See Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="blog-card">
                            <h4 class="blog-title">The ULTIMATE Figma UI Kit (Tailwind-Figma)</h4>
                            <p class="blog-date">24.09.21</p>
                            <a href="#" class="blog-link">See Now <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="newsletter" class="py-5 bg-light-gray position-relative">
            <div class="container position-relative">
                <div class="wavy-divider-top"></div>
                <div class="text-center py-5">
                    <h2 class="mb-3">Join the Newsletter!</h2>
                    <p class="mb-4">You'll receive an email every once in a while about new products, courses, and
                        videos!
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-4">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="name@example.com"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <button class="btn btn-dark" type="button" id="button-addon2"><i
                                        class="fas fa-arrow-right"></i></button>
                            </div>
                            <small class="text-muted">We'll never share your details. See our Privacy Policy</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-4 footer-custom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <span class="footer-logo me-2">ar</span>
                        <span class="text-muted small">© 202X ArnauPots LLC. All rights reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" class="text-dark me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-dark me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('navbarToggleBtn');
                const mobileNav = document.getElementById('mobileNav');
                let isOpen = false;
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                        isOpen = !isOpen;
                        if (isOpen) {
                            mobileNav.classList.add('open');
                        } else {
                            mobileNav.classList.remove('open');
                        }
                    });
                }
                // Hide mobile nav on resize to md+
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) {
                        mobileNav.classList.remove('open');
                        isOpen = false;
                    }
                });
            });
        </script>
</body>

</html>
