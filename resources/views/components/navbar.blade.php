<nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 p-3">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-xl md:text-2xl font-bold text-cyan-600 flex items-center gap-3">
            <img src="{{ asset('img/1.png') }}" alt="Logo" class="w-10 h-10 md:w-14 md:h-14 object-contain">
            <img src="{{ asset('img/2.png') }}" alt="Text Logo" class="h-8 md:h-10 w-auto object-contain">
        </a>
        
        <div class="hidden lg:flex items-center space-x-4 text-gray-600 font-medium text-sm">
            <a href="#beranda" class="px-4 py-2 rounded-lg hover:bg-[#559dd4] hover:text-white transition-all duration-300">Beranda</a>
            <a href="#tentang" class="px-4 py-2 rounded-lg hover:bg-[#559dd4] hover:text-white transition-all duration-300">Layanan</a>
            <a href="#layanan" class="px-4 py-2 rounded-lg hover:bg-[#559dd4] hover:text-white transition-all duration-300">Harga</a>
            <a href="#alamat" class="px-4 py-2 rounded-lg hover:bg-[#559dd4] hover:text-white transition-all duration-300">Kontak</a>
            <button onclick="toggleModal()" class="bg-[#559dd4] text-white px-6 py-2 rounded-full font-bold hover:bg-cyan-600 shadow-md transition transform hover:scale-105 active:scale-95">
                Laundry Sekarang
            </button>
        </div>

        <div class="lg:hidden flex items-center">
            <button id="menu-btn" class="relative w-10 h-10 text-gray-600 focus:outline-none bg-gray-50 rounded-lg flex items-center justify-center">
                <div class="block w-5 absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2">
                    <span id="line-1" class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out -translate-y-1.5"></span>
                    <span id="line-2" class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out"></span>
                    <span id="line-3" class="block absolute h-0.5 w-5 bg-current transform transition duration-500 ease-in-out translate-y-1.5"></span>
                </div>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden bg-white border-t mt-4 space-y-2 p-4 pb-6 shadow-xl rounded-b-2xl">
        <a href="#beranda" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-[#559dd4] hover:text-white hover:translate-x-2 transform transition-all duration-300 rounded-xl">Beranda</a>
        <a href="#tentang" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-[#559dd4] hover:text-white hover:translate-x-2 transform transition-all duration-300 rounded-xl">Layanan</a>
        <a href="#layanan" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-[#559dd4] hover:text-white hover:translate-x-2 transform transition-all duration-300 rounded-xl">Harga</a>
        <a href="#alamat" class="mobile-link block p-4 text-gray-700 font-semibold hover:bg-[#559dd4] hover:text-white hover:translate-x-2 transform transition-all duration-300 rounded-xl">Kontak</a>
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