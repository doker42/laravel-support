<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
{{--    <meta name="description" content="Laravel Support & Maintenance Company">--}}
    <meta name="keywords" content="Laravel, Support, Maintenance, Web Development">
    <meta name="author" content="Laravel Support">

    <title>Laravel Support Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- SEO Meta Tags --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! JsonLd::generate() !!}

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/app-blue.css'])

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Laravel Business Support</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero" style="margin-top: 70px;">
    <div class="container">
        <h1 class="display-4">Laravel Support & Maintenance</h1>
        <p class="lead">We keep your Laravel project running fast and secure.</p>
        <a href="#contact" class="btn btn-primary btn-lg mt-3">Get a Free Consultation</a>
    </div>
</section>

<!-- About Us -->
<section id="about">
    <div class="container text-center">
        <h2>About Us</h2>
        <p class="mt-3">We specialize in maintaining Laravel projects of any size. Over 5 years of experience in web development. We work with Laravel, MySQL, Redis, Docker, Livewire, and more.</p>
    </div>
</section>

<!-- Services -->
<section id="services" class="bg-light">
    <div class="container">
        <h2 class="text-center">Our Services</h2>
        <div class="row text-center mt-4">
            <div class="col-md-4">
                <h5>Support & Maintenance</h5>
                <p>Monthly support for your Laravel site: updates, monitoring, and health checks.</p>
            </div>
            <div class="col-md-4">
                <h5>Performance & Security</h5>
                <p>Speed optimization, protection, backups, and vulnerability fixes.</p>
            </div>
            <div class="col-md-4">
                <h5>Development & Integrations</h5>
                <p>API integrations, new feature development, and full custom builds.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section id="pricing">
    <div class="container">
        <h2 class="text-center">Pricing Plans</h2>
        <div class="row mt-5 text-center pricing">
            <div class="col-md-4">
                <div class="card p-4">
                    <h4>Starter</h4>
                    <p class="display-6">$199/mo</p>
                    <ul class="list-unstyled">
                        <li>5 support hours</li>
                        <li>Laravel updates</li>
                        <li>Email support</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 border-primary border-2">
                    <h4>Pro</h4>
                    <p class="display-6">$399/mo</p>
                    <ul class="list-unstyled">
                        <li>10 support hours</li>
                        <li>Audit & monitoring</li>
                        <li>Priority support</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <h4>Enterprise</h4>
                    <p class="display-6">Custom</p>
                    <ul class="list-unstyled">
                        <li>Any workload</li>
                        <li>Dedicated manager</li>
                        <li>Telegram/Jira support</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Contact Us</h2>

        <!-- Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content contact-sent">
                    <div class="modal-body text-center">
                        {{ session('success') }}
                    </div>
                    <div class="text-center pb-3">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="/contact" class="mx-auto" style="max-width: 600px;">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <textarea name="message" rows="4" class="form-control" placeholder="Message" required></textarea>
            </div>
            <button class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="text-center">
    <p>&copy; {{ date('Y') }} Laravel Support Business Company. All rights reserved.</p>
    <div>
        <a href="mailto:you@example.com" class="text-white">laravel.support@acode.ovh</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success'))
    <script>
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    </script>
@endif

</body>
</html>