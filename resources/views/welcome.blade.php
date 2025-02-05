<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Welcome &mdash; Laravel - Stisla</title>

    <!-- Google Fonts (opsional) -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet"
    />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Style tambahan menggunakan Tailwind CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Animasi hover ringan untuk kartu/kontributor */
        .hover-lift:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Hero Section -->
    <header class="relative flex items-center justify-center min-h-screen bg-gradient-to-br from-indigo-600 to-purple-600 text-white">
        <!-- Latar belakang wave menggunakan SVG -->
        <div class="absolute inset-0 overflow-hidden">
            <svg class="absolute bottom-0 w-full h-auto text-white opacity-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="currentColor" fill-opacity="1" d="M0,256L24,256C48,256,96,256,144,234.7C192,213,240,171,288,160C336,149,384,171,432,160C480,149,528,107,576,90.7C624,75,672,85,720,85.3C768,85,816,75,864,96C912,117,960,171,1008,192C1056,213,1104,203,1152,202.7C1200,203,1248,213,1296,186.7C1344,160,1392,96,1416,64L1440,32L1440,320L1416,320C1392,320,1344,320,1296,320C1248,320,1200,320,1152,320C1104,320,1056,320,1008,320C960,320,912,320,864,320C816,320,768,320,720,320C672,320,624,320,576,320C528,320,480,320,432,320C384,320,336,320,288,320C240,320,192,320,144,320C96,320,48,320,24,320L0,320Z"></path>
            </svg>
        </div>

        <div class="relative z-10 px-6 text-center max-w-2xl">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-4 drop-shadow-lg animate-bounce">
                Welcome to Laravel 11
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl font-light mb-8">
                With a modern Stisla-based template for your next big project
            </p>
            <a
                href="{{ route('login') }}"
                class="inline-block px-8 py-3 bg-white text-indigo-600 rounded-full shadow-md hover:bg-gray-100 font-medium transition-transform transform hover:scale-105"
            >
                Get Started
            </a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-indigo-600">
                Features
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg p-6 shadow hover-lift">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Laravel 11</h3>
                    <p class="text-gray-600">
                        Explore the latest features and improvements in Laravel 11.
                    </p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-lg p-6 shadow hover-lift">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Stisla Bootstrap 5 Template
                    </h3>
                    <p class="text-gray-600">
                        Leverage the modern and responsive design of Stisla.
                    </p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-lg p-6 shadow hover-lift">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        Laravel Breeze Authentication
                    </h3>
                    <p class="text-gray-600">
                        Quick and easy authentication setup with Laravel Breeze.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contributors Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-indigo-600 mb-12">
                Contributors
            </h2>
            <!-- Grid Contributors -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Vicky Maulana -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/vickymaulana.png"
                        alt="Vicky Maulana"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Vicky Maulana</h5>
                    <a
                        href="https://github.com/vickymaulana"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Ahmad Dimas -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/anqois.png"
                        alt="Ahmad Dimas Aldian Al-furqon"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Ahmad Dimas Aldian Al-furqon</h5>
                    <a
                        href="https://github.com/anqois"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Abdillah Khalid -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/KhalidUnsri.png"
                        alt="Abdillah Khalid"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Abdillah Khalid</h5>
                    <a
                        href="https://github.com/KhalidUnsri"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Haikal Tirta -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/HaikalAlbanna.png"
                        alt="Haikal Tirta Albanna"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Haikal Tirta Albanna</h5>
                    <a
                        href="https://github.com/HaikalAlbanna"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Meta Berliana -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/Metabrln.png"
                        alt="Meta Berliana"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Meta Berliana</h5>
                    <a
                        href="https://github.com/Metabrln"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Imelda Triadmajaya -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/imeldatriajaya.png"
                        alt="Imelda Triadmajaya"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Imelda Triadmajaya</h5>
                    <a
                        href="https://github.com/imeldatriajaya"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Hilwa Izzatinnafisah -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/ksnwaa.png"
                        alt="Hilwa Izzatinnafisah"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Hilwa Izzatinnafisah</h5>
                    <a
                        href="https://github.com/ksnwaa"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Triyana Sugiyarti -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/TriyanaSgi.png"
                        alt="Triyana Sugiyarti"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Triyana Sugiyarti</h5>
                    <a
                        href="https://github.com/TriyanaSgi"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Adelia Isni Hendrawan Putri -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/lilisky07.png"
                        alt="Adelia Isni Hendrawan Putri"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Adelia Isni Hendrawan Putri</h5>
                    <a
                        href="https://github.com/lilisky07"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Siti Nur Azizah -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/sukasukajija.png"
                        alt="Siti Nur Azizah"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Siti Nur Azizah</h5>
                    <a
                        href="https://github.com/sukasukajija"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- M. Husaini Hasyim -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/son-alone.png"
                        alt="M. Husaini Hasyim"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">M. Husaini Hasyim</h5>
                    <a
                        href="https://github.com/son-alone"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Andre Satriawan -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/andresa11satriawan.png"
                        alt="Andre Satriawan"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Andre Satriawan</h5>
                    <a
                        href="https://github.com/andresa11satriawan"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Lathifah Putri Aresti -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/lathifahputri.png"
                        alt="Lathifah Putri Aresti"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Lathifah Putri Aresti</h5>
                    <a
                        href="https://github.com/lathifahputri"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- Sisca Amelia -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/siscaamelia.png"
                        alt="Sisca Amelia"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">Sisca Amelia</h5>
                    <a
                        href="https://github.com/siscaamelia"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
                <!-- M. Denny Tri Lisandi -->
                <div class="bg-white p-6 rounded-lg shadow hover-lift">
                    <img
                        src="https://github.com/Koutsura.png"
                        alt="M. Denny Tri Lisandi"
                        class="mx-auto rounded-full w-24 h-24 mb-4 ring-2 ring-gray-100"
                    />
                    <h5 class="font-semibold text-lg mb-2">M. Denny Tri Lisandi</h5>
                    <a
                        href="https://github.com/Koutsura"
                        target="_blank"
                        class="text-indigo-500 hover:text-indigo-700"
                    >
                        GitHub
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-indigo-600 text-white py-6">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-sm md:text-base">
                &copy; {{ date('Y') }} Laravel 11 with Stisla Template. All Rights Reserved.
            </p>
            <p class="text-xs md:text-sm mt-2">
                Contributors: Vicky Maulana and LLDIKTI 2 Division of Information System Development Interns.
            </p>
        </div>
    </footer>

</body>
</html>
