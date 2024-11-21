<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome &mdash; Laravel - Stisla</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
        .header {
            background: linear-gradient(45deg, #6c63ff, #3f3da1);
            color: white;
            text-align: center;
            padding: 80px 20px;
        }
        .header h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }
        .header p {
            font-size: 1.2rem;
        }
        .btn-custom {
            background: #3f3da1;
            color: white;
            padding: 10px 30px;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background: #2b2a82;
            transform: scale(1.1);
        }
        .features-section .card {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .features-section .card:hover {
            transform: translateY(-10px);
        }
        .contributors-section {
            background: #ffffff;
            padding: 60px 20px;
        }
        .contributors-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }
        .contributor-card {
            margin: 20px 0;
            transition: transform 0.3s ease;
        }
        .contributor-card:hover {
            transform: scale(1.1);
        }
        .contributor-card img {
            border: 3px solid #f0f0f0;
            border-radius: 50%;
            transition: box-shadow 0.3s ease;
        }
        .contributor-card img:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        footer {
            background: linear-gradient(45deg, #3f3da1, #6c63ff);
            color: white;
            text-align: center;
            padding: 20px 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1 class="animate__animated animate__fadeInDown">Welcome to Laravel 11 with Stisla Template</h1>
        <p class="animate__animated animate__fadeInUp">A modern, feature-rich template for your Laravel project</p>
        <a href="{{ route('login') }}" class="btn btn-custom animate__animated animate__zoomIn">Get Started</a>
    </div>

    <!-- Features Section -->
    <div class="container my-5 features-section">
        <h2 class="text-center mb-4" data-aos="fade-up">Features</h2>
        <div class="row">
            <div class="col-md-4" data-aos="zoom-in">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Laravel 11</h5>
                        <p class="card-text">Explore the latest features and improvements in Laravel 11.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Stisla Bootstrap 5 Template</h5>
                        <p class="card-text">Leverage the modern and responsive design of Stisla.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Laravel Breeze Authentication</h5>
                        <p class="card-text">Quick and easy authentication setup with Laravel Breeze.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Contributors Section -->
<div class="contributors-section text-center">
    <div class="container">
        <h2 data-aos="fade-down">Contributors</h2>
        <div class="row justify-content-center">
            <!-- Vicky Maulana -->
            <div class="col-md-3 contributor-card" data-aos="flip-left">
                <img src="https://github.com/vickymaulana.png" alt="Vicky Maulana" class="img-fluid mb-3" width="120" height="120">
                <h5>Vicky Maulana</h5>
                <a href="https://github.com/vickymaulana" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Ahmad Dimas -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="50">
                <img src="https://github.com/anqois.png" alt="Ahmad Dimas Aldian Al-furqon" class="img-fluid mb-3" width="120" height="120">
                <h5>Ahmad Dimas Aldian Al-furqon</h5>
                <a href="https://github.com/anqois" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Abdillah Khalid -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="100">
                <img src="https://github.com/KhalidUnsri.png" alt="Abdillah Khalid" class="img-fluid mb-3" width="120" height="120">
                <h5>Abdillah Khalid</h5>
                <a href="https://github.com/KhalidUnsri" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Haikal Tirta -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="150">
                <img src="https://github.com/HaikalAlbanna.png" alt="Haikal Tirta Albanna" class="img-fluid mb-3" width="120" height="120">
                <h5>Haikal Tirta Albanna</h5>
                <a href="https://github.com/HaikalAlbanna" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Meta Berliana -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="200">
                <img src="https://github.com/Metabrln.png" alt="Meta Berliana" class="img-fluid mb-3" width="120" height="120">
                <h5>Meta Berliana</h5>
                <a href="https://github.com/Metabrln" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Imelda Triadmajaya -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="250">
                <img src="https://github.com/imeldatriajaya.png" alt="Imelda Triadmajaya" class="img-fluid mb-3" width="120" height="120">
                <h5>Imelda Triadmajaya</h5>
                <a href="https://github.com/imeldatriajaya" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Hilwa Izzatinnafisah -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="300">
                <img src="https://github.com/ksnwaa.png" alt="Hilwa Izzatinnafisah" class="img-fluid mb-3" width="120" height="120">
                <h5>Hilwa Izzatinnafisah</h5>
                <a href="https://github.com/ksnwaa" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Triyana Sugiyarti -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="350">
                <img src="https://github.com/TriyanaSgi.png" alt="Triyana Sugiyarti" class="img-fluid mb-3" width="120" height="120">
                <h5>Triyana Sugiyarti</h5>
                <a href="https://github.com/TriyanaSgi" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Adelia Isni Hendrawan Putri -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="400">
                <img src="https://github.com/lilisky07.png" alt="Adelia Isni Hendrawan Putri" class="img-fluid mb-3" width="120" height="120">
                <h5>Adelia Isni Hendrawan Putri</h5>
                <a href="https://github.com/lilisky07" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Siti Nur Azizah -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="450">
                <img src="https://github.com/sukasukajija.png" alt="Siti Nur Azizah" class="img-fluid mb-3" width="120" height="120">
                <h5>Siti Nur Azizah</h5>
                <a href="https://github.com/sukasukajija" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- M. Husaini Hasyim -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="500">
                <img src="https://github.com/son-alone.png" alt="M. Husaini Hasyim" class="img-fluid mb-3" width="120" height="120">
                <h5>M. Husaini Hasyim</h5>
                <a href="https://github.com/son-alone" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Andre Satriawan -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="550">
                <img src="https://github.com/andresa11satriawan.png" alt="Andre Satriawan" class="img-fluid mb-3" width="120" height="120">
                <h5>Andre Satriawan</h5>
                <a href="https://github.com/andresa11satriawan" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Lathifah Putri Aresti -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="600">
                <img src="https://github.com/lathifahputri.png" alt="Lathifah Putri Aresti" class="img-fluid mb-3" width="120" height="120">
                <h5>Lathifah Putri Aresti</h5>
                <a href="https://github.com/lathifahputri" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- Sisca Amelia -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="650">
                <img src="https://github.com/siscaamelia.png" alt="Sisca Amelia" class="img-fluid mb-3" width="120" height="120">
                <h5>Sisca Amelia</h5>
                <a href="https://github.com/siscaamelia" target="_blank" class="text-primary">GitHub</a>
            </div>
            <!-- M. Denny Tri Lisandi -->
            <div class="col-md-3 contributor-card" data-aos="flip-left" data-aos-delay="700">
                <img src="https://github.com/Koutsura.png" alt="M. Denny Tri Lisandi" class="img-fluid mb-3" width="120" height="120">
                <h5>M. Denny Tri Lisandi</h5>
                <a href="https://github.com/Koutsura" target="_blank" class="text-primary">GitHub</a>
            </div>
        </div>
    </div>
</div>


    <!-- Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Laravel 11 with Stisla Template. All Rights Reserved.</p>
        <p>Contributors: Vicky Maulana and LLDIKTI 2 Division of Information System Development Interns.</p>
    </footer>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
