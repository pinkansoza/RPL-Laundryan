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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; }


        
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

    @stack('scripts')
</body>
</html>