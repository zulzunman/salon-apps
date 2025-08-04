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
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- CSS File -->
    <link rel="stylesheet" href="/homepage/homepage.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a class="navbar-brand" href="#home">
                    <i class="fas fa-cut brand-icon"></i>
                    Brownis Salon
                </a>
                <button class="nav-toggle" onclick="toggleNav()">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
                <ul class="nav-links" id="navLinks">
                    <li><a class="nav-link" href="#about">Tentang</a></li>
                    <li><a class="nav-link" href="#services">Layanan</a></li>
                    <li><a class="nav-link" href="#gallery">Galeri</a></li>
                    <li><a class="nav-link" href="#contact">Kontak</a></li>
                    <li><a class="nav-link login-btn" href="#" onclick="openLoginModal()">
                            <i class="fas fa-user"></i> Login
                        </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-overlay"></div>
        <div class="hero-background"></div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">Pengalaman Salon Premium</div>
                <h1 class="hero-title">
                    Tampil Beda? <span class="highlight">Boleh Banget!</span>
                </h1>
                <p class="hero-subtitle">Berani coba gaya baru? Rambut warna bold atau potongan anti-mainstream, kita
                    bisa bantu. Di Brownis Salon, kamu bebas ekspresiin gaya tanpa batas.</p>
                <div class="hero-buttons">
                    <a class="btn-primary" href="#services">
                        <i class="fas fa-calendar-alt"></i>
                        Antri Sekarang, Yuk!
                    </a>
                    <a class="btn-secondary" href="#about">
                        <i class="fas fa-play"></i>
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                <div class="hero-features">
                    <div class="feature-item">
                        <i class="fas fa-award"></i>
                        <span>Penata Gaya Bersertifikat</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-gem"></i>
                        <span>Produk Premium</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-clock"></i>
                        <span>Jam Kerja Fleksibel</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about-section" id="about">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">Aturan Antrean</div>
                <h2 class="section-title">Aturan Antrian Brownis Salon</h2>
                <p class="section-subtitle">Sebelum melakukan antrian, harap perhatikan ketentuan berikut untuk
                    pengalaman terbaik</p>
            </div>

            <div class="policy-container">
                <div class="policy-card">
                    <div class="policy-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="policy-content">
                        <h4>Email Aktif</h4>
                        <p>Gunakan email aktif agar notifikasi antrian dapat diterima dengan tepat waktu.</p>
                    </div>
                </div>

                <div class="policy-card">
                    <div class="policy-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="policy-content">
                        <h4>Waktu Kedatangan</h4>
                        <p>Setelah menerima email pemanggilan, harap datang maksimal dalam 15 menit. Jika melebihi,
                            antrian akan otomatis dibatalkan.</p>
                    </div>
                </div>

                <div class="policy-card">
                    <div class="policy-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="policy-content">
                        <h4>Periksa Email</h4>
                        <p>Jika email dari kami tidak muncul di kotak masuk utama, harap periksa folder spam, promosi,
                            atau sosial.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section services-section" id="services">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">Keahlian Kami</div>
                <h2 class="section-title">Layanan Premium Kami</h2>
                <p class="section-subtitle">Pilih dari rangkaian layanan perawatan rambut profesional eksklusif kami</p>
            </div>

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
                                    <div class="service-img-placeholder">
                                        <i class="fas fa-cut"></i>
                                    </div>
                                @endif

                                @if ($loop->first)
                                    <div class="service-badge popular">Populer</div>
                                @elseif($loop->index == 1)
                                    <div class="service-badge premium">Premium</div>
                                @elseif($loop->index == 2)
                                    <div class="service-badge new">Baru</div>
                                @else
                                    <div class="service-badge featured">Unggulan</div>
                                @endif

                                <div class="service-overlay">
                                    <button class="btn-view-details"
                                        onclick="openImageModal('{{ asset('assets/img/service/' . $service->picture) }}', '{{ $service->name }}')">Lihat
                                        Gambar</button>
                                </div>
                            </div>
                            <div class="service-content">
                                <div class="service-header">
                                    <h3 class="service-name">{{ $service->name }}</h3>
                                    <div class="service-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="service-description">{{ $service->description }}</p>
                                <div class="service-details">
                                    <div class="service-duration">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $service->duration }} mins</span>
                                    </div>
                                    <div class="service-price">Rp {{ number_format($service->price, 0, ',', '.') }}
                                    </div>
                                </div>
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
                    <div class="no-services-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3>Tidak Ada Layanan yang Tersedia</h3>
                    <p>Tidak ada layanan yang tersedia saat ini. Silakan periksa kembali nanti.</p>
                    <a href="#contact" class="btn-outline">Hubungi kami</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section gallery-section" id="gallery">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">Galeri Kami</div>
                <h2 class="section-title">Galeri Hasil Styling Kami</h2>
                <p class="section-subtitle">Intip berbagai transformasi cantik dari pelanggan kami</p>
                <p class="section-subtitle"> mulai dari styling harian, hair coloring, hingga perawatan rambut untuk
                    tampil makin percaya diri</p>
            </div>

            <div class="gallery-container">
                <div class="gallery-grid">
                    <div class="gallery-item" onclick="openGalleryModal(0)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/1-cukur_rambut_pria.jpg');">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h4>Potongan Rambut Pria</h4>
                                    <p>Penataan gaya profesional untuk pria</p>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item" onclick="openGalleryModal(1)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/2-cukur_rambut_wanita.jpg');">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h4>Potongan Rambut Wanita</h4>
                                    <p>Potongan elegan untuk wanita</p>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item" onclick="openGalleryModal(2)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/7-smoothing.jfif');">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h4>Pelurusan Rambut</h4>
                                    <p>Hasil yang sangat halus</p>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item" onclick="openGalleryModal(3)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/4-creambath.jpg');">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h4>Creambath</h4>
                                    <p> Perawatan rambut yang menenangkan</p>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item" onclick="openGalleryModal(4)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/5-hair_mask.jpg');">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h4>Masker Rambut</h4>
                                    <p>Perawatan rambut yang sehat</p>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item" onclick="openGalleryModal(5)">
                        <div class="gallery-image"
                            style="background-image: url('assets/img/homepage/6-coloring_rambut.jfif');">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <h4>Pewarnaan Rambut</h4>
                                    <p>Transformasi warna cerah</p>
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section contact-section" id="contact">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">Hubungi Kami</div>
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle">Silakan datang langsung ke lokasi atau hubungi kami melalui kontak berikut
                    untuk informasi lebih lanjut.</p>
            </div>

            <div class="contact-container">
                <div class="contact-info">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Lokasi Kami</h4>
                            <p>Jl. Lapang Tembak Sel. kp mekarsari 9<br>
                                Padasuka, Kec. Cimahi Tengah<br>
                                Kota Cimahi, Jawa Barat 40523</p>
                            <a href="https://maps.app.goo.gl/1uDXtg97C785V3XN7" target="_blank" class="contact-link">
                                <i class="fas fa-external-link-alt"></i>
                                Lihat di Peta
                            </a>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Hubungi Kami</h4>
                            <p>Siap membantu Anda memesan janji temu</p>
                            <a href="tel:+6289671875340" class="contact-link">
                                <i class="fas fa-phone"></i>
                                +62 896 7187 5340
                            </a>
                        </div>
                    </div>

                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Ikuti Kami</h4>
                            <p>Tetap update dengan karya dan penawaran terbaru kami</p>
                            <div class="social-links-inline">
                                <a href="https://www.instagram.com/bronis.salon" target="_blank" class="social-link">
                                    <i class="fab fa-instagram"></i>
                                    @bronis.salon
                                </a>
                                <a href="https://www.tiktok.com/@bronissalon" target="_blank" class="social-link">
                                    <i class="fab fa-tiktok"></i>
                                    @bronissalon
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-visual">
                    <div class="contact-image">
                        <div class="contact-overlay">
                            <h3>Kunjungi Salon Cantik Kami</h3>
                            <p>Rasakan kemewahan di lingkungan yang nyaman dan modern</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <img class="modal-image" id="modalImage">
            <div class="modal-caption" id="modalCaption"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <h3>Brownis Salon</h3>
                    <p>Dimana keindahan bertemu dengan keunggulan</p>
                </div>
                <div class="footer-links">
                    <a href="#about">Tentang</a>
                    <a href="#services">Layanan</a>
                    <a href="#gallery">Galeri</a>
                    <a href="#contact">Kontak</a>
                </div>
                <div class="footer-social">
                    <a href="https://www.instagram.com/bronis.salon" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/@bronissalon" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Brownis Salon. All rights reserved. | Designed with ❤️ for beauty enthusiasts</p>
            </div>
        </div>
    </footer>

    @include('auth.login')

    <!-- JavaScript -->
    <script>
        function toggleNav() {
            const navLinks = document.getElementById('navLinks');
            const navToggle = document.querySelector('.nav-toggle');
            navLinks.classList.toggle('active');
            navToggle.classList.toggle('active');
        }

        function openLoginModal() {
            const modal = document.getElementById('loginModal');
            if (modal) {
                modal.classList.add('show');
            }
        }

        function closeModal() {
            const modal = document.getElementById('loginModal');
            if (modal) {
                modal.classList.remove('show');
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (modal && event.target == modal) {
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

        // Gallery Modal functionality
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

            if (modal && modalImage && modalCaption) {
                modalImage.src = images[index];
                modalCaption.textContent = titles[index];
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        // Image Modal functionality for service images
        function openImageModal(imageSrc, imageTitle) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalCaption = document.getElementById('modalCaption');

            if (modal && modalImage && modalCaption) {
                modalImage.src = imageSrc;
                modalCaption.textContent = imageTitle;
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        }

        // Close image modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
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

            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                });
            }

            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                        document.body.style.overflow = 'auto';
                    }
                });
            }

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (modal && modal.classList.contains('show') && e.key === 'Escape') {
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll indicator animation
        window.addEventListener('scroll', function() {
            const scrollIndicator = document.querySelector('.scroll-indicator');
            if (window.scrollY > 100) {
                scrollIndicator.style.opacity = '0';
            } else {
                scrollIndicator.style.opacity = '1';
            }
        });
    </script>
</body>

</html>
