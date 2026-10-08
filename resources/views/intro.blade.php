<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido - El Rincón del Vinilo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#111111] h-screen w-screen m-0 overflow-hidden relative font-sans selection:bg-[#C49A5C] selection:text-white">

    <!-- Video de fondo a pantalla completa -->
    <video id="logo-video" class="absolute inset-0 w-full h-full object-cover opacity-60" autoplay muted playsinline>
        <source src="{{ asset('El rincon del Vinillo (Video).mp4') }}" type="video/mp4">
        Tu navegador no soporta videos.
    </video>

    <!-- Overlay y Botón -->
    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none bg-black/30 backdrop-blur-sm z-10">
        
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-40 md:h-56 mix-blend-screen rounded-full mb-12 shadow-[0_0_50px_rgba(196,154,92,0.3)]">

        <div id="enter-btn-container" class="opacity-0 transition-all duration-1000 transform translate-y-8 pointer-events-auto">
            <a href="{{ route('tienda') }}" class="inline-block bg-[#C49A5C] hover:bg-white text-white hover:text-[#111111] text-sm md:text-base font-bold py-4 px-12 rounded-full transition-colors uppercase tracking-[0.2em] shadow-lg hover:shadow-[#C49A5C]/50">
                Explorar Catálogo
            </a>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById("logo-video");
            const btnContainer = document.getElementById("enter-btn-container");

            video.addEventListener("ended", function() {
                btnContainer.classList.remove("opacity-0", "translate-y-8");
                btnContainer.classList.add("opacity-100", "translate-y-0");
            });
            
            setTimeout(() => {
                btnContainer.classList.remove("opacity-0", "translate-y-8");
                btnContainer.classList.add("opacity-100", "translate-y-0");
            }, 5000);
        });
    </script>
</body>
</html>
