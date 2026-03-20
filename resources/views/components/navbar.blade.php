<nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-xl md:text-2xl font-bold text-blue-600 flex items-center gap-3">
            <img src="{{ asset('img/Logo FMI - Hitam@4x.png') }}" alt="Logo" class="w-8 h-8 md:w-10 md:h-10 object-contain">
            <img src="{{ asset('img/Screenshot 2026-03-21 003634.png') }}" alt="Text Logo" class="h-6 md:h-8 w-auto object-contain">
        </a>
        
        <div class="hidden md:flex items-center space-x-8 text-gray-600 font-medium text-sm">
            <a href="#beranda" class="relative hover:text-blue-600 transition after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-600 after:opacity-0 hover:after:opacity-100 after:transition-opacity">Beranda</a>
            <a href="#tentang" class="relative hover:text-blue-600 transition after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-600 after:opacity-0 hover:after:opacity-100 after:transition-opacity">Tentang</a>
            <a href="#layanan" class="relative hover:text-blue-600 transition after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-600 after:opacity-0 hover:after:opacity-100 after:transition-opacity">Layanan</a>
            <a href="#alamat" class="relative hover:text-blue-600 transition after:absolute after:left-0 after:-bottom-1 after:w-full after:h-0.5 after:bg-blue-600 after:opacity-0 hover:after:opacity-100 after:transition-opacity">Alamat</a>
            <button onclick="toggleModal()" class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold hover:bg-blue-700 shadow-md transition transform hover:scale-105 active:scale-95">
                Pesan Sekarang
            </button>
        </div>

        <div class="md:hidden flex items-center">
            <button id="menu-btn" class="relative w-10 h-10 text-gray-600 focus:outline-none bg-gray-50 rounded-lg flex items-center justify-center">
                <div class="block w-5 absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <span id="line-1" class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out -translate-y-1.5"></span>
                    <span id="line-2" class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out"></span>
                    <span id="line-3" class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out translate-y-1.5"></span>
                </div>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-t mt-4 space-y-1 p-4 pb-6 shadow-xl rounded-b-2xl">
        <a href="#beranda" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-blue-50 rounded-xl transition">Beranda</a>
        <a href="#tentang" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-blue-50 rounded-xl transition">Tentang</a>
        <a href="#layanan" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-blue-50 rounded-xl transition">Layanan & Harga</a>
        <a href="#alamat" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-blue-50 rounded-xl transition">Alamat</a>
    </div>
</nav>

<script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');
    const line1 = document.getElementById('line-1');
    const line2 = document.getElementById('line-2');
    const line3 = document.getElementById('line-3');

    const closeMenu = () => {
        menu.classList.add('hidden');
        line1.classList.remove('rotate-45', 'translate-y-0');
        line1.classList.add('-translate-y-1.5');
        line2.classList.remove('opacity-0');
        line3.classList.remove('-rotate-45', 'translate-y-0');
        line3.classList.add('translate-y-1.5');
    };

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        line1.classList.toggle('rotate-45');
        line1.classList.toggle('-translate-y-1.5');
        line1.classList.toggle('translate-y-0');
        line2.classList.toggle('opacity-0');
        line3.classList.toggle('-rotate-45');
        line3.classList.toggle('translate-y-1.5');
        line3.classList.toggle('translate-y-0');
    });

    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
</script>