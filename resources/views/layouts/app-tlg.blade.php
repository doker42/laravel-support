<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Uptime Monitoring, Website Monitoring, Telegram Alerts, Downtime Notifications">
    <meta name="author" content="Site Monitor">

    <title>Telegram Website Monitoring Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- SEO Meta Tags --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! JsonLd::generate() !!}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">SiteMonitor</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero text-center" style="margin-top: 80px; padding: 80px 0;">
    <div class="container">
        <h1 class="display-4 fw-bold">Website Monitoring with Telegram Alerts</h1>
        <p class="lead">Instant notifications when your site is down. Simple. Reliable. Secure.</p>
        <a href="#pricing" class="btn btn-primary btn-lg mt-3">Start Monitoring Today</a>
    </div>
</section>

<!-- About -->
<section id="about" class="py-5 bg-light">
    <div class="container text-center">
        <h2>About Our Service</h2>
        <p class="mt-3">
            SiteMonitor keeps track of your websites 24/7 and notifies you in <strong>Telegram</strong> the moment downtime happens.
            No missed alerts, no complicated dashboards — just real-time updates straight to your phone.
        </p>
    </div>
</section>

<!-- Features -->
<section id="features" class="py-5">
    <div class="container">
        <h2 class="text-center">Key Features</h2>
        <div class="row text-center mt-4">
            <div class="col-md-4">
                <h5>24/7 Monitoring</h5>
                <p>We ping your sites every minute and track their uptime with millisecond precision.</p>
            </div>
            <div class="col-md-4">
                <h5>Telegram Notifications</h5>
                <p>Instant alerts to your Telegram channel when your site is <span class="text-danger">down</span> or back <span class="text-success">up</span>.</p>
            </div>
            <div class="col-md-4">
                <h5>Detailed Logs</h5>
                <p>Track status history, response times, and downtime analytics in one place.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section id="pricing" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center">Pricing Plans</h2>
        <div class="row mt-5 text-center pricing">

            @if (isset($plans))

                @foreach($plans as $plan)

                    <div class="col-md-4">
                        <div class="card p-4">
                            <h4>{{$plan->title}}</h4>
                            <p class="display-6">${{$plan->price}}/mo</p>
                            <p>
                                {{$plan->limit}} {!! $plan->description !!}
                            </p>
                        </div>
                    </div>

                @endforeach
            @else
                <div class="col-md-4">
                    <div class="card p-4">
                        <h4>Free</h4>
                        <p class="display-6">$0/mo</p>
                        <ul class="list-unstyled">
                            <li>1 monitored site</li>
                            <li>Telegram alerts</li>
                            <li>Status page</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 border-primary border-2">
                        <h4>Pro</h4>
                        <p class="display-6">$2/mo</p>
                        <ul class="list-unstyled">
                            <li>10 monitored sites</li>
                            <li>1 min checks</li>
                            <li>Priority support</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4">
                        <h4>Enterprise</h4>
                        <p class="display-6">Custom</p>
                        <ul class="list-unstyled">
                            <li>Unlimited sites</li>
                            <li>Custom intervals</li>
                            <li>Team integrations</li>
                        </ul>
                    </div>
                </div>

            @endif

        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Get in Touch</h2>

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
<footer class="text-center py-4 bg-dark text-white">
    <p>&copy; {{ date('Y') }} SiteMonitor. All rights reserved.</p>
    <div>
        <a href="mailto:support@acode.ovh" class="text-white">support@acode.ovh</a>
    </div>
</footer>


<!-- Modal -->
<div class="modal fade" id="devModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Notice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-5 fw-bold text-danger">🚧 The site is under development! 🚧</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var myModal = new bootstrap.Modal(document.getElementById('devModal'));
        myModal.show();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success'))
    <script>
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    </script>
@endif

</body>
</html>
