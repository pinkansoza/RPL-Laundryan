<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryKu - @yield('title')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <div id="order-modal" class="fixed inset-0 z-[99] hidden flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="toggleModal()"></div>

        <div class="relative bg-white w-full max-w-xl rounded-[2rem] md:rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all animate-fade-in-up">
            <div class="flex justify-between items-center p-6 border-b bg-white sticky top-0 z-10">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🧺</span>
                    <h3 class="text-xl font-bold text-gray-800">Form Order Online</h3>
                </div>
                <button onclick="toggleModal()" class="text-gray-400 hover:text-red-500 transition-colors p-2 bg-gray-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 md:p-8 max-h-[75vh] overflow-y-auto">
                @include('components.order-form')
            </div>
        </div>
    </div>

    <script>
        // Fungsi Global Toggle Modal
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

        // Tutup dengan ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                const modal = document.getElementById('order-modal');
                if (!modal.classList.contains('hidden')) toggleModal();
            }
        });
    </script>
</body>
</html>