<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Laundry AK - Solusi jasa laundry bersih, wangi, dan terpercaya dengan layanan antar jemput.">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <title>Laundry AK</title> 
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#89b252',
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
        .modal-open { overflow: hidden; }
        
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #dad4d4ff; }
        ::-webkit-scrollbar-thumb { background: #8a8a8aff; border-radius: 10px; }

        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    {{-- Modal Pemesanan --}}
    <div id="order-modal" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal()"></div>

        <div class="relative bg-white w-full max-w-4xl rounded-[2rem] md:rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all animate-fade-in-up">
            <div class="flex justify-center items-center p-4 md:p-5 border-b bg-white sticky top-0 z-10 relative">
                <h3 class="text-lg md:text-xl font-bold text-gray-800 text-center w-full">Form Pemesanan Laundry</h3>
                <button onclick="toggleModal()" class="absolute right-6 text-gray-400 hover:text-rose-500 transition-colors p-2 bg-gray-50 hover:bg-rose-50 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-5 md:p-6 max-h-[80vh] overflow-y-auto lg:max-h-none lg:overflow-visible">
                @include('components.order-form')
            </div>
        </div>
    </div>

    <script>
        window.toggleModal = function() {
            const modal = document.getElementById('order-modal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                document.body.classList.add('modal-open');
            } else {
                modal.classList.add('hidden');
                document.body.classList.remove('modal-open');
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                const modal = document.getElementById('order-modal');
                if (!modal.classList.contains('hidden')) toggleModal();
            }
        });
    </script>

    @stack('scripts')
</body>
</html>