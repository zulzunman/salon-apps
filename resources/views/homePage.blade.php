<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Premium Hair Salon Services" />
    <meta name="author" content="" />
    <title>Elegant Hair Salon - Premium Beauty Services</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <!-- CSS File -->
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a class="navbar-brand" href="#home">Elegant Salon</a>
                <button class="nav-toggle" onclick="toggleNav()">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="nav-links" id="navLinks">
                    <li><a class="nav-link" href="#about">About</a></li>
                    <li><a class="nav-link" href="#services">Services</a></li>
                    <li><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li><a class="nav-link" href="#contact">Contact</a></li>
                    <li><a class="nav-link" href="#" onclick="openModal()">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Beauty Redefined</h1>
                <p class="hero-subtitle">Experience luxury hair care and styling at our premium salon. Where elegance
                    meets expertise.</p>
                <a class="btn-primary" href="{{ route('booking.datetime') }}">Book Your Appointment</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about-section" id="about">
        <div class="container">
            <h2 class="section-title">Our Booking Policy</h2>
            <p class="section-subtitle">Please read our guidelines before booking your appointment</p>
            <div class="policy-card">
                <ul class="policy-list">
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        Harap Masukan Nomor Telfon Anda Yang Aktif
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        Keterlambatan Melebihi 15 Menit Kami Anggap Cancel
                    </li>
                    <li>
                        <i class="fas fa-calendar-times"></i>
                        Batas Untuk Konfirmasi Cancel 30 Menit sebelum Waktu Appointment
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section services-section" id="services">
        <div class="container">
            <h2 class="section-title">Our Premium Services</h2>
            <p class="section-subtitle">Choose from our exclusive range of professional hair care services</p>

            @if ($services->count() > 0)
                <div class="services-grid">
                    @foreach ($services as $service)
                        <div class="service-card">
                            <div class="service-image">
                                <i class="fas fa-cut"></i>
                                @if ($loop->first)
                                    <div class="service-badge">Popular</div>
                                @elseif($loop->index == 1)
                                    <div class="service-badge">Premium</div>
                                @elseif($loop->index == 2)
                                    <div class="service-badge">New</div>
                                @else
                                    <div class="service-badge">Featured</div>
                                @endif
                            </div>
                            <div class="service-info">
                                <div class="service-name">{{ $service->name }}</div>
                                <div class="service-description">{{ $service->description }}</div>
                                <div class="service-duration">
                                    <i class="fas fa-clock"></i>
                                    {{ $service->duration }} mins
                                </div>
                            </div>
                            <div class="service-footer">
                                <div class="service-price">Rp
                                    {{ number_format($service->price, 0, ',', '.') }}</div>
                                <a href="{{ route('booking.datetime', ['service_id' => $service->id]) }}"
                                    class="btn-book">
                                    <i class="fas fa-calendar-plus"></i>
                                    Booking
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-services">
                    <p>No services available at the moment. Please check back later.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section gallery-section" id="gallery">
        <div class="container">
            <h2 class="section-title">Our Work Gallery</h2>
            <p class="section-subtitle">Discover the artistry and elegance of our salon transformations</p>

            <div class="gallery-grid">
                <div class="gallery-item">
                    <div class="gallery-text">
                        <div>
                            <h4>Signature Transformations</h4>
                            <p>Experience the artistry of our master stylists as they create stunning looks
                                tailored to
                                your unique style and personality.</p>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-image">
                        <i class="fas fa-palette"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-image">
                        <i class="fas fa-magic"></i>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-text"
                        style="background: linear-gradient(135deg, var(--rose-gold), var(--soft-pink)); color: var(--text-dark);">
                        <div>
                            <h4>Bridal Excellence</h4>
                            <p>Your special day deserves perfection. Our bridal specialists create breathtaking
                                looks
                                that complement your natural beauty.</p>
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-image">
                        <i class="fas fa-cut"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <h2 class="section-title" style="color: white;">Get In Touch</h2>
            <p class="section-subtitle" style="color: rgba(255,255,255,0.8);">Visit us today or contact us to
                schedule
                your appointment</p>

            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Visit Our Salon</h4>
                    <p>Jl. Kemang Raya No. 123<br>Jakarta Selatan 12560<br>Indonesia</p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p><a href="tel:+62215551234">+62 21 555 1234</a><br><a href="tel:+6281234567890">+62 812
                            3456
                            7890</a></p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h4>Email Us</h4>
                    <p><a href="mailto:info@elegantsalon.com">info@elegantsalon.com</a><br><a
                            href="mailto:booking@elegantsalon.com">booking@elegantsalon.com</a></p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Opening Hours</h4>
                    <p>Mon - Fri: 9:00 AM - 8:00 PM<br>Sat - Sun: 8:00 AM - 6:00 PM</p>
                </div>
            </div>

            <div class="social-links">
                <a href="#" class="social-link">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Elegant Hair Salon. All rights reserved. | Designed with ❤️ for beauty enthusiasts
            </p>
        </div>
    </footer>
    <!-- Include Login Modal -->
    @include('auth.login')
    <!-- Login Modal -->

    <!-- JavaScript File -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
