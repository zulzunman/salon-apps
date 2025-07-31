<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Premium Hair Salon Services" />
    <title>Brownis Salon</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- CSS File -->
    <link rel="stylesheet" href="css/homepage.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a class="navbar-brand" href="#home">Brownis Salon</a>
                <button class="nav-toggle" onclick="toggleNav()">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="nav-links" id="navLinks">
                    <li><a class="nav-link" href="#about">About</a></li>
                    <li><a class="nav-link" href="#services">Services</a></li>
                    <li><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li><a class="nav-link" href="#contact">Contact</a></li>
                    <li><a class="nav-link login-btn" href="#" onclick="openLoginModal()">Login</a></li>
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
                <a class="btn-primary" href="#services">Register Now</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about-section" id="about">
        <div class="container">
            <h2 class="section-title">Our Register Policy</h2>
            <p class="section-subtitle">Please read our guidelines before register your appointment</p>
            <div class="policy-card">
                <ul class="policy-list">
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span>Harap Masukan Nomor Telfon Anda Yang Aktif</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>Keterlambatan Melebihi 30 Menit Kami Anggap Cancel</span>
                    </li>
                    <li>
                        <i class="fas fa-calendar-times"></i>
                        <span>Batas Untuk Konfirmasi Cancel 30 Menit sebelum Waktu Appointment</span>
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
                                @if ($service->picture && file_exists(public_path('assets/img/service/' . $service->picture)))
                                    <img src="{{ asset('assets/img/service/' . $service->picture) }}"
                                        alt="{{ $service->name }}" class="service-img clickable-image"
                                        data-full-image="{{ asset('assets/img/service/' . $service->picture) }}"
                                        data-title="{{ $service->name }}">
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif

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
                                <a href="{{ route('register.form-add', ['service_id' => $service->id]) }}"
                                    class="btn-book">
                                    <i class="fas fa-calendar-plus"></i>
                                    Pendaftaran
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

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal">
        <span class="modal-close">&times;</span>
        <img class="modal-image" id="modalImage">
        <div class="modal-caption" id="modalCaption"></div>
    </div>

    <!-- Gallery Section -->
    <section class="section gallery-section" id="gallery">
        <div class="container">
            <h2 class="section-title">Our Work Gallery</h2>
            <p class="section-subtitle">Discover the artistry and elegance of our salon transformations</p>

            <div class="gallery-slider-container">
                <div class="gallery-slider" id="gallerySlider">
                    <!-- Gallery Slides -->
                    <div class="gallery-slide" onclick="openGalleryModal(0)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/1-cukur_rambut_pria.jpg');"></div>
                    </div>

                    <div class="gallery-slide" onclick="openGalleryModal(1)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/2-cukur_rambut_wanita.jpg');"></div>
                    </div>

                    <div class="gallery-slide" onclick="openGalleryModal(2)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/7-smoothing.jfif');"></div>
                    </div>

                    <div class="gallery-slide" onclick="openGalleryModal(3)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/4-creambath.jpg');"></div>
                    </div>

                    <div class="gallery-slide" onclick="openGalleryModal(4)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/5-hair_mask.jpg');"></div>
                    </div>

                    <div class="gallery-slide" onclick="openGalleryModal(5)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/6-coloring_rambut.jfif');"></div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button class="slider-nav prev" onclick="moveSlide(-1)">❮</button>
                <button class="slider-nav next" onclick="moveSlide(1)">❯</button>
            </div>

            <!-- Dots Indicator -->
            <div class="slider-dots" id="sliderDots"></div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <p class="section-subtitle">Visit us today or contact us to schedule your appointment</p>

            <div class="contact-grid">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Visit Our Salon</h4>
                    <p>Jl. Lapang Tembak Sel. kp mekarsari 9<br>
                        Padasuka, Kec. Cimahi Tengah<br>
                        Kota Cimahi, Jawa Barat 40523</p>
                    <a href="https://maps.app.goo.gl/1uDXtg97C785V3XN7" target="_blank">View on Maps</a>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h4>Call Us</h4>
                    <p><a href="tel:+6289671875340">+62 896 7187 5340</a></p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fab fa-tiktok"></i>
                    </div>
                    <h4>TikTok</h4>
                    <p><a href="https://www.tiktok.com/@bronissalon" target="_blank">@bronissalon</a></p>
                </div>

                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fab fa-instagram"></i>
                    </div>
                    <h4>Instagram</h4>
                    <p><a href="https://www.instagram.com/bronis.salon" target="_blank">@bronis.salon</a></p>
                </div>
            </div>

            <div class="social-links">
                <a href="https://www.instagram.com/bronis.salon" class="social-link" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@bronissalon" class="social-link" target="_blank">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Brownis Salon. All rights reserved. | Designed with ❤️ for beauty enthusiasts</p>
        </div>
    </footer>
    @include('auth.login')
    <!-- JavaScript -->
    <script>
        function toggleNav() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        // Fungsi untuk membuka login modal - nama diubah untuk menghindari konflik
        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('show');
        }

        function closeModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('show');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target == modal) {
                modal.classList.remove('show');
            }
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Image Modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');
            const closeBtn = document.querySelector('.modal-close');
            const clickableImages = document.querySelectorAll('.clickable-image');

            // Add click event to each service image
            clickableImages.forEach((img) => {
                img.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openImageModal(img.dataset.fullImage, img.dataset.title);
                });
            });

            function openImageModal(imageSrc, imageTitle) {
                modalImage.src = imageSrc;
                modalCaption.textContent = imageTitle;
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeImageModal() {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto'; // Restore scrolling
            }

            // Close modal events
            closeBtn.addEventListener('click', closeImageModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeImageModal();
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (modal.classList.contains('show') && e.key === 'Escape') {
                    closeImageModal();
                }
            });
        });

        // Fungsi untuk membuka gallery modal
        function openGalleryModal(index) {
            const images = [
                'assets/img/homepage/1-cukur_rambut_pria.jpg',
                'assets/img/homepage/2-cukur_rambut_wanita.jpg',
                'assets/img/homepage/7-smoothing.jfif',
                'assets/img/homepage/4-creambath.jpg',
                'assets/img/homepage/5-hair_mask.jpg',
                'assets/img/homepage/6-coloring_rambut.jfif'
            ];

            const titles = [
                'Cukur Rambut Pria',
                'Cukur Rambut Wanita',
                'Smoothing',
                'Creambath',
                'Hair Mask',
                'Coloring Rambut'
            ];

            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');

            modalImage.src = images[index];
            modalCaption.textContent = titles[index];
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        // Gallery Slider functionality
        let currentSlide = 0;
        const slider = document.getElementById('gallerySlider');
        const slides = document.querySelectorAll('.gallery-slide');
        const totalSlides = slides.length;
        const slidesToShow = window.innerWidth <= 768 ? 1 : window.innerWidth <= 1024 ? 2 : 3;
        const maxSlides = totalSlides - slidesToShow;

        // Create dots
        function createDots() {
            const dotsContainer = document.getElementById('sliderDots');
            dotsContainer.innerHTML = '';

            for (let i = 0; i <= maxSlides; i++) {
                const dot = document.createElement('div');
                dot.className = 'dot';
                if (i === 0) dot.classList.add('active');
                dot.onclick = () => goToSlide(i);
                dotsContainer.appendChild(dot);
            }
        }

        // Update dots
        function updateDots() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        // Move slide function
        function moveSlide(direction) {
            currentSlide += direction;

            if (currentSlide > maxSlides) {
                currentSlide = 0;
            } else if (currentSlide < 0) {
                currentSlide = maxSlides;
            }

            updateSlider();
        }

        // Go to specific slide
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            updateSlider();
        }

        // Update slider position
        function updateSlider() {
            const slideWidth = slides[0].offsetWidth + 20; // width + margin
            const translateX = -currentSlide * slideWidth;
            slider.style.transform = `translateX(${translateX}px)`;
            updateDots();
        }

        // Initialize
        createDots();

        // Handle window resize
        window.addEventListener('resize', () => {
            createDots();
            currentSlide = 0;
            updateSlider();
        });

        // Touch/swipe support for mobile
        let startX = 0;
        let endX = 0;

        slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        slider.addEventListener('touchend', (e) => {
            endX = e.changedTouches[0].clientX;
            const diffX = startX - endX;

            if (Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    moveSlide(1); // Swipe left - next slide
                } else {
                    moveSlide(-1); // Swipe right - previous slide
                }
            }
        });
    </script>
</body>

</html>
