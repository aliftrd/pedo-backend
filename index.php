<?php
require_once('vendor/autoload.php');

use Models\Faq;

$faqs = Faq::get();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>PEDO Landing</title>
    <link rel="stylesheet" href="<?= base_url('assets/landing/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/landing/css/styles.min.css') ?>">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><img width="100" height="80" src="<?= base_url('assets/landing/img/logo.svg') ?>"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#service">Service</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonial</a></li>
                </ul><button class="btn btn-primary btn-dark" type="button">Download</button>
            </div>
        </div>
    </nav>
    <div id="hero">
        <div class="container py-4 py-xl-5">
            <div class="row gy-4 gy-md-0">
                <div class="col-md-6 text-center text-md-start d-flex d-sm-flex d-md-flex justify-content-center align-items-center justify-content-md-start align-items-md-center justify-content-xl-center">
                    <div style="max-width: 350px;">
                        <h1 class="text-uppercase hero-title">Dapatkan hewan peliharaanmu sekarang</h1>
                        <p class="paragraph my-3">Pet Adoption hadir dalam bentuk aplikasi yang dapat dengan mudah kamu unduh dengan tombol download dibawah<br></p><a class="btn btn-lg btn-dark me-2" role="button" href="#">Download</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="rounded img-fluid w-100 fit-cover" data-aos="zoom-out-left" data-aos-duration="1000" data-aos-offset="300" data-aos-easing="ease-in-sine" src="<?= base_url('assets/landing/img/hero-1.svg') ?>" style="pointer-events: none;">
                </div>
            </div>
        </div><img id="hero-bg" class="img-fluid fit-cover" src="<?= base_url('assets/landing/img/about-particle.svg') ?>">
    </div>
    <div id="about">
        <div class="container py-4 py-xl-5">
            <div class="row gy-4 gy-md-0 flex-row-reverse">
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="pl-5" style="max-width: 414px;">
                        <p class="pre-title my-3">About Us</p>
                        <h1 class="text-uppercase title">TENTANG PET ADOPTION</h1>
                        <p class="paragraph my-3">Kami membuat aplikasi ini untuk seluruh pecinta hewan yang ingin mempunyai hewan peliharaannya, dan juga untuk pemilik rumah hewan yang ingin hewannya diadopsi orang lain.<br></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <img class="rounded img-fluid w-100 fit-cover" data-aos="zoom-out-right" data-aos-duration="1000" data-aos-offset="300" data-aos-easing="ease-in-sine" src="<?= base_url('assets/landing/img/about.svg') ?>" style="pointer-events: none;">
                </div>
            </div>
        </div><img id="about-bg" class="img-fluid fit-cover w-auto" src="<?= base_url('assets/landing/img/bg-about.svg') ?>">
    </div>
    <div id="service">
        <div class="container py-4 py-xl-5">
            <div class="row gy-4 gy-md-0">
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="pl-5" style="max-width: 414px;">
                        <p class="pre-title my-3">Service</p>
                        <h1 class="text-uppercase title">LAYANAN YANG KAMI BERIKAN</h1>
                        <p class="paragraph my-3">Untuk membantu para pengguna aplikasi Pet Adoption. Kami memberikan beberapa pelayanan sehingga masalah yang dialami oleh pengguna dapat teratasi dan terselesaikan<br></p>
                    </div>
                </div>
                <div class="col-md-6 gap-3">
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <div class="card service-card m-3">
                                <div class="card-body text-center"><img class="img-fluid" src="<?= base_url('assets/landing/img/health_shield.svg') ?>" loading="lazy">
                                    <p class="fw-semibold mt-2">Jaminan Kesehatan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="card service-card m-3">
                                <div class="card-body text-center"><img class="img-fluid" src="<?= base_url('assets/landing/img/24_hours.svg') ?>" loading="lazy">
                                    <p class="fw-semibold mt-2">Costumer<br>Support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 p-0">
                            <div class="card service-card m-3">
                                <div class="card-body text-center"><img class="img-fluid" src="<?= base_url('assets/landing/img/articles.svg') ?>" loading="lazy">
                                    <p class="fw-semibold mt-2">Layanan<br>Edukasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 p-0">
                            <div class="card service-card m-3">
                                <div class="card-body text-center"><img class="img-fluid" src="<?= base_url('assets/landing/img/credit_fill.svg') ?>" loading="lazy">
                                    <p class="fw-semibold mt-2">Pembayaran<br>Anti Ribet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><img id="service-bg" class="img-fluid fit-cover w-auto" src="<?= base_url('assets/landing/img/bg-faq.svg') ?>">
    </div>
    <div id="faq">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="pre-title">FAQ</p>
                    <h2 class="text-uppercase title">BEBERAPA PERTANYAAN YANG SERING MUNCUL</h2>
                    <p class="paragraph">Banyak dari mereka bertanya-tanya tentang Pet Adoption, kami sudah memilih pertanyaan<br>yang sering ditanyakan di antara lain<br></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="accordion" role="tablist" id="accordion-2">
                        <?php foreach ($faqs as $faq) : ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" role="tab"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-2 .item-<?= $faq->id ?>" aria-expanded="true" aria-controls="accordion-2 .item-<?= $faq->id ?>"><?= $faq->title ?><br></button></h2>
                                <div class="accordion-collapse collapse item-<?= $faq->id ?>" role="tabpanel" data-bs-parent="#accordion-2">
                                    <div class="accordion-body">
                                        <p class="mb-0"><?= $faq->description ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="testimonials">
        <div class="container py-4 py-xl-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="pre-title">Testimonials</p>
                    <h2 class="text-uppercase title">APA KATA MEREKA</h2>
                    <p class="paragraph">Banyak dari mereka bertanya-tanya tentang Pet Adoption, kami sudah memilih pertanyaan<br>yang sering ditanyakan di antara lain<br></p>
                </div>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                <div class="col">
                    <div class="card testimonials-card">
                        <div class="card-body p-4">
                            <p class="card-text paragraph">Terimakasih berkat aplikasi ini saya mendapat hewan peliharaan yang sehat dan dapat menjadi teman dirumah<br></p>
                            <div class="d-flex testimonials-profile"><img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50" height="50" src="<?= base_url('assets/landing/img/user-1.png') ?>">
                                <p class="testimonials-user mb-0">Lutfi Arimawan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card testimonials-card">
                        <div class="card-body p-4">
                            <p class="card-text paragraph">Saya suka dengan aplikasi pet adoption, karena saya dapat mengadopsi hewan dengan sistem COD jadinya tidak takut ditipu<br></p>
                            <div class="d-flex testimonials-profile"><img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50" height="50" src="<?= base_url('assets/landing/img/user-2.png') ?>">
                                <p class="user-testi mb-0">Jessica Widyanto</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card testimonials-card">
                        <div class="card-body p-4">
                            <p class="card-text paragraph">Dari pet Adoption ini saya juga dapat membaca informasi dari hewan sehingga saya dapat mengetahui apa yang terbaik untuk hewan saya<br></p>
                            <div class="d-flex testimonials-profile"><img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50" height="50" src="<?= base_url('assets/landing/img/user-3.png') ?>">
                                <p class="user-testi mb-0">Vannesa Christian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="reff-section" class="p-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="text-uppercase title">Ayo Bergabung Dengan Kami Sekarang</h2>
                    <p>Dapatkan anabulmu yang lucu dengan mudah, ayo bergabung sekarang.<br></p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <a href="#">
                            <img class="w-100 p-3" src="<?= base_url('assets/landing/img/google-play.png') ?>">
                        </a>
                        <a href="#">
                            <img class="w-100 p-3" src="<?= base_url('assets/landing/img/app-store.png') ?>">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center bg-dark">
        <div class="container text-white py-4 py-lg-5">
            <ul class="list-inline">
                <li class="list-inline-item me-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-facebook text-light">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                    </svg></li>
                <li class="list-inline-item me-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-twitter text-light">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
                    </svg></li>
                <li class="list-inline-item"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-instagram text-light">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                    </svg></li>
            </ul>
            <p class="mb-0">Copyright © 2022 PEDO | All Right Reserved</p>
        </div>
    </footer>
    <script src="<?= base_url('assets/landing/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="<?= base_url('assets/landing/js/script.min.js') ?>"></script>
    <script type="text/javascript">
        AOS.init();
    </script>
</body>

</html>