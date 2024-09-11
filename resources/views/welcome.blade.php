<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <title>Landing Page</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>
<body class="bg-[#1b1b1b] flex flex-col lg:flex-row justify-center items-center">
    
    <!-- Overlay Animasi -->
    <div class="overlay" id="overlay">
        <div id="overlayText" class="typing-effect-overlay anek-latin-thin"></div>
    </div>
    
    <!-- kiri -->
    <div class="kiri relative flex h-screen lg:w-1/2 rounded-r-[6vw] h-[75vh] overflow-hidden">
    <!-- py-[0.1vw] pr-[0.1vw] bg-white -->
        <!-- Video pesawat -->
        <video autoplay muted loop class="object-cover h-full w-full">
            <source src="{{ asset('videos/pesawat_terbang.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
        </video>

        <!-- Teks Indonesia dengan Animasi -->
        <div class="absolute inset-0 flex justify-center items-center">
            <h1 class="text-white text-5xl lg:text-7xl anek-latin-thin typing-effect-video" id="videoText"></h1>
        </div>
    </div>
    
    <!-- kanan -->
    <div class="kanan flex flex-col h-screen w-full lg:w-1/2">
        <div class="flex flex-col h-full justify-center items-center">    
            <!-- bagian atas -->
            <div class="flex w-full justify-center items-center text-white text-2xl lg:text-4xl anek-latin-thin py-4">
                Selamat Datang <span class="anek-latin-extrabold ml-2">Pejuang IAK</span>
            </div>
            <!-- bagian bawah -->
            <div class="flex w-full pb-10 px-5 lg:px-10">
                <div class="bg-white w-full h-full p-5 lg:p-10 anek-latin-thin rounded-[5vw] lg:rounded-[2vw]">
                    @if (Route::has('login'))
                        <nav class="flex flex-col items-center space-y-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-[#522b5b] text-white text-xl lg:text-2xl px-4 py-2 rounded-xl hover:bg-[#BEC753] hover:scale-[1.05] hover:transition duration-100 ease-in-out w-full flex justify-center items-center">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="bg-[#522b5b] text-white text-xl lg:text-2xl px-4 py-2 rounded-xl hover:bg-red-600 hover:scale-[1.05] hover:transition duration-100 ease-in-out w-full flex justify-center items-center">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-[#1b1b1b] text-white text-xl lg:text-2xl px-4 py-2 rounded-xl hover:bg-[#BEC753] hover:scale-[1.05] hover:transition duration-100 ease-in-out w-full flex justify-center items-center">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animasi mengetik overlay
        const overlayTexts = ["Selamat datang GUYSS !!!🔥"];
        let overlayCount = 0;
        let overlayIndex = 0;
        let overlayCurrentText = '';
        let overlayLetter = '';

        (function typeOverlay() {
            if (overlayCount === overlayTexts.length) {
                overlayCount = 0;
            }
            overlayCurrentText = overlayTexts[overlayCount];
            overlayLetter = overlayCurrentText.slice(0, ++overlayIndex);

            document.getElementById('overlayText').textContent = overlayLetter;

            if (overlayLetter.length === overlayCurrentText.length) {
                setTimeout(() => {
                    document.getElementById('overlay').classList.add('hidden');
                }, 1000);  // Delay sebelum menghilang
            } else {
                setTimeout(typeOverlay, 50);  // Kecepatan efek mengetik
            }
        }());

        // Animasi mengetik video
        const videoTexts = ["INDONESIA.", "TRANSPORT.", "PESAWAT.", "KAPAL."];
        let videoCount = 0;
        let videoIndex = 0;
        let videoCurrentText = '';
        let videoLetter = '';

        (function typeVideo() {
            if (videoCount === videoTexts.length) {
                videoCount = 0;
            }
            videoCurrentText = videoTexts[videoCount];
            videoLetter = videoCurrentText.slice(0, ++videoIndex);

            document.getElementById('videoText').textContent = videoLetter;

            if (videoLetter.length === videoCurrentText.length) {
                videoCount++;
                videoIndex = 0;
                setTimeout(typeVideo, 1000);  // Delay sebelum beralih ke teks berikutnya
            } else {
                setTimeout(typeVideo, 200);  // Kecepatan efek mengetik
            }
        }());
        
        // Menampilkan overlay dan memulai animasi mengetik
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.getElementById('overlay').classList.remove('hidden');
            }, 100);  // Delay sebelum overlay muncul
        });
    </script>

</body>
</html>
