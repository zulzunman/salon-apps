<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Grayscale - Start Bootstrap Theme</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('stylish/assets/favicon.ico') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('stylish/css/styles.css') }}" rel="stylesheet" />
    <style>
        /* Improved Service Section Styles */
        .services-section {
            padding: 6rem 0;
            background: linear-gradient(to bottom, #121212, #232323);
            color: #fff;
        }

        .services-title {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }

        .services-title:after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #e83e8c, #6f42c1);
        }

        .services-subtitle {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .service-category-wrapper {
            margin-bottom: 3rem;
            /* Center the category content */
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .service-category {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
            color: #e83e8c;
            margin-bottom: 20px;
            letter-spacing: 2px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            /* Make the category header full width */
            width: 100%;
        }

        .service-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
            /* Center the grid */
            justify-content: center;
        }

        .service-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            /* To ensure consistent heights */
            display: flex;
            flex-direction: column;
        }

        .service-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .service-link {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: #fff;
            padding: 0;
            height: 100%;
        }

        .service-image-wrapper {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 200px;
            /* Increased height for better proportion */
        }

        .service-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            /* Centers the image focus */
            transition: transform 0.5s ease;
        }

        .service-item:hover .service-image {
            transform: scale(1.05);
        }

        .service-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(to right, #e83e8c, #6f42c1);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .service-details {
            padding: 20px;
            flex-grow: 1;
        }

        .service-name {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 8px;
            color: #fff;
        }

        .service-description {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .service-info {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #888;
        }

        .service-duration {
            display: flex;
            align-items: center;
            margin-right: 5px;
        }

        .details-link {
            color: #6f42c1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .details-link:hover {
            color: #e83e8c;
        }

        .dot {
            margin: 0 8px;
            color: #555;
        }

        .service-price-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .service-price {
            font-weight: 700;
            font-size: 18px;
            color: #fff;
        }

        .book-now-btn {
            background: linear-gradient(to right, #e83e8c, #6f42c1);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .book-now-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 10px rgba(232, 62, 140, 0.5);
        }

        .divider {
            height: 30px;
            background-color: transparent;
            width: 100%;
        }

        /* Improved centering for the entire service container */
        .col-md-10 {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .service-list {
                grid-template-columns: 1fr;
            }

            .services-title {
                font-size: 2rem;
            }

            .services-subtitle {
                font-size: 1rem;
            }

            .service-image-wrapper {
                height: 180px;
                /* Slightly reduced height for mobile */
            }
        }
    </style>
</head>

<body id="page-top">
    {{-- @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">Start Bootstrap</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#signup">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal"
                            data-bs-target="#Login">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                {{-- <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">Grayscale</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">A free, responsive, one page Bootstrap theme created by
                        Start Bootstrap.</h2>
                    <a class="btn btn-primary" href="#services">Booking</a>
                </div> --}}
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="about-section text-center" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-white mb-3">Our Registration Policy</h2>
                    <div class="text-white-50 text-center">
                        <p class="mb-1">Loyal Customer</p>
                        <p class="mb-2">"Silahkan Di Baca Terlebih Dahulu"</p>
                        <div class="policy-list" style="display: inline-block; text-align: left; margin-left: 10%;">
                            <p class="mb-1">- Harap Masukan Nomor Telfon Anda Yang Aktif</p>
                            <p class="mb-1">- Keterlambatan Melebihi 15 Menit Kami Anggap Cancel</p>
                            <p class="mb-6">- Batas Untuk Konfirmasi Cancel 30 Menit </p>
                        </div>
                    </div>
                </div>
                {{-- <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Gambar diperkecil dengan menambahkan class col-md-6 dan row justify-content-center -->
                    <img class="img-fluid" src="{{ asset('stylish/assets/img/ipad.png') }}" alt="..." />
                </div>
            </div> --}}
            </div>
    </section>

    <!-- Services-->
    <section class="services-section" id="services">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8">
                    <h2 class="text-center text-white mb-5 services-title">Layanan Kami</h2>
                    <p class="text-center text-white-50 mb-5 services-subtitle">Pilih layanan premium terbaik untuk gaya
                        rambut Anda</p>
                </div>
            </div>

            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10">
                    @if ($services->count() > 0)
                        <?php
                        // Group services by category
                        $serviceCategories = [
                            'HAIRCUT PACKAGE' => [],
                            'PERMING PACKAGE' => [],
                            'OTHER PACKAGE' => [],
                        ];

                        foreach ($services as $service) {
                            // Determine category based on service name
                            if (stripos($service->name, 'THIN') !== false || stripos($service->name, 'BOLD') !== false || stripos($service->name, 'SOLID') !== false) {
                                $categoryName = 'HAIRCUT PACKAGE';
                            } elseif (stripos($service->name, 'PERM') !== false) {
                                $categoryName = 'PERMING PACKAGE';
                            } else {
                                $categoryName = 'OTHER PACKAGE';
                            }

                            $serviceCategories[$categoryName][] = $service;
                        }

                        // Remove empty categories
                        $serviceCategories = array_filter($serviceCategories, function ($category) {
                            return !empty($category);
                        });
                        ?>

                        @foreach ($serviceCategories as $category => $servicesInCategory)
                            <div class="service-category-wrapper">
                                <div class="service-category">
                                    <i class="bi bi-scissors me-2"></i>{{ $category }}
                                </div>

                                <div class="service-list">
                                    @foreach ($servicesInCategory as $service)
                                        <div class="service-item">
                                            <!-- Menambahkan service_id ke URL datetime -->
                                            <a href="{{ route('booking.datetime') }}?service_id={{ $service->id }}"
                                                class="service-link">
                                                <div class="service-image-wrapper">
                                                    <img src="{{ asset('stylish/assets/img/ipad.png') }}"
                                                        alt="{{ $service->name }}" class="service-image">
                                                    <div class="service-badge">Popular</div>
                                                </div>

                                                <div class="service-details">
                                                    <div class="service-name">{{ $service->name }}</div>
                                                    <div class="service-description">{{ $service->description }}</div>
                                                    <div class="service-info">
                                                        <span class="service-duration">
                                                            <i class="bi bi-clock me-1"></i>
                                                            @if ($service->duration >= 60)
                                                                {{ floor($service->duration / 60) }} hr
                                                                @if ($service->duration % 60 > 0)
                                                                    {{ $service->duration % 60 }} mins
                                                                @endif
                                                            @else
                                                                {{ $service->duration }} mins
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="service-price-wrapper">
                                                    <div class="service-price">Rp
                                                        {{ number_format($service->price, 0, ',', '.') }}</div>
                                                    <div class="book-now-btn">Registration</div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                @if (!$loop->last)
                                    <div class="divider"></div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-dark">
                            Belum ada layanan yang tersedia saat ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Call to Action for general booking -->
            <div class="row gx-4 gx-lg-5 justify-content-center mt-5">
                <div class="col-lg-6 text-center">
                    <a href="{{ route('booking.datetime') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-calendar-plus me-2"></i>
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Projects-->
    <section class="projects-section bg-light" id="projects">
        <div class="container px-4 px-lg-5">
            <!-- Featured Project Row-->
            <div class="row gx-0 mb-4 mb-lg-5 align-items-center">
                <div class="col-xl-8 col-lg-7"><img class="img-fluid mb-3 mb-lg-0"
                        src="{{ asset('stylish/assets/img/bg-masthead.jpg') }}" alt="..." /></div>
                <div class="col-xl-4 col-lg-5">
                    <div class="featured-text text-center text-lg-left">
                        <h4>Shoreline</h4>
                        <p class="text-black-50 mb-0">Grayscale is open source and MIT licensed. This means you can use
                            it for any project - even commercial projects! Download it, customize it, and publish your
                            website!</p>
                    </div>
                </div>
            </div>
            <!-- Project One Row-->
            <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid"
                        src="{{ asset('stylish/assets/img/demo-image-01.jpg') }}" alt="..." />
                </div>
                <div class="col-lg-6">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-left">
                                <h4 class="text-white">Misty</h4>
                                <p class="mb-0 text-white-50">An example of where you can put an image of a project, or
                                    anything else, along with a description.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Project Two Row-->
            <div class="row gx-0 justify-content-center">
                <div class="col-lg-6"><img class="img-fluid"
                        src="{{ asset('stylish/assets/img/demo-image-02.jpg') }}" alt="..." />
                </div>
                <div class="col-lg-6 order-lg-first">
                    <div class="bg-black text-center h-100 project">
                        <div class="d-flex h-100">
                            <div class="project-text w-100 my-auto text-center text-lg-right">
                                <h4 class="text-white">Mountains</h4>
                                <p class="mb-0 text-white-50">Another example of a project with its respective
                                    description. These sections work well responsively as well!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup-->
    <section class="signup-section" id="signup">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-10 col-lg-8 mx-auto text-center">
                    <i class="far fa-paper-plane fa-2x mb-2 text-white"></i>
                    <h2 class="text-white mb-5">Subscribe to receive updates!</h2>
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form class="form-signup" id="contactForm" data-sb-form-api-token="API_TOKEN">
                        <!-- Email address input-->
                        <div class="row input-group-newsletter">
                            <div class="col"><input class="form-control" id="emailAddress" type="email"
                                    placeholder="Enter email address..." aria-label="Enter email address..."
                                    data-sb-validations="required,email" /></div>
                            <div class="col-auto"><button class="btn btn-primary disabled" id="submitButton"
                                    type="submit">Notify Me!</button></div>
                        </div>
                        <div class="invalid-feedback mt-2" data-sb-feedback="emailAddress:required">An email is
                            required.</div>
                        <div class="invalid-feedback mt-2" data-sb-feedback="emailAddress:email">Email is not valid.
                        </div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3 mt-2 text-white">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />
                                <a
                                    href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center text-danger mb-3 mt-2">Error sending message!</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact-->
    <section class="contact-section bg-black">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Address</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">4923 Market Street, Orlando FL</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-envelope text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Email</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50"><a href="#!">hello@yourdomain.com</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card py-4 h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-mobile-alt text-primary mb-2"></i>
                            <h4 class="text-uppercase m-0">Phone</h4>
                            <hr class="my-4 mx-auto" />
                            <div class="small text-black-50">+1 (555) 902-8832</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social d-flex justify-content-center">
                <a class="mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                <a class="mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                <a class="mx-2" href="#!"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer bg-black small text-center text-white-50">
        <div class="container px-4 px-lg-5">Copyright &copy; Your Website 2023</div>
    </footer>

    <!-- Include Login Modal -->
    @include('auth.login')
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('stylish/js/scripts.js') }}"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah perlu menampilkan modal login (setelah error)
            @if (session('show_login_modal'))
                var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            @endif

            // Auto-focus ke field email ketika modal muncul
            document.getElementById('loginModal').addEventListener('shown.bs.modal', function() {
                document.getElementById('email').focus();
            });
        });
    </script>
</body>

</html>
