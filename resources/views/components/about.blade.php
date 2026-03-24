<section id="tentang" class="py-14 md:py-24 bg-gradient-to-br from-[#7dbde8] to-[#a8d4f0] px-5 md:px-6 relative overflow-hidden">
    {{-- Background decorative elements --}}
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto relative z-10">
        {{-- Section Header --}}
        <div class="text-center mb-10 md:mb-16">
            <h3 class="text-2xl md:text-4xl font-extrabold text-white">Layanan Kami</h3>
        </div>
        
        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-8">

            {{-- Card 1: Cuci Kiloan --}}
            <div class="group relative bg-gradient-to-br from-white to-blue-50/30 backdrop-blur-sm rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-md hover:shadow-2xl border border-white/50 transition-all duration-500 hover:-translate-y-1">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-[#559dd4] to-blue-400 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-5 shadow-lg shadow-blue-200/50 group-hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[26px] md:h-[26px]">
                        <path d="M3 6h18"/>
                        <path d="M3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6"/>
                        <path d="M3 6l3-4h12l3 4"/>
                        <circle cx="12" cy="14" r="4"/>
                    </svg>
                </div>
                <h4 class="text-base md:text-xl font-bold text-gray-800 mb-1.5 md:mb-2">Cuci Kiloan</h4>
                <p class="text-gray-500 text-xs md:text-sm leading-relaxed">Layanan cuci hemat per kilogram, cocok untuk mahasiswa. Bersih, wangi, dan rapi dengan harga terjangkau.</p>
                <div class="mt-4 md:mt-5 flex items-center text-[#559dd4] text-xs md:text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <span>Mulai Rp 5.000/kg</span>
                </div>
            </div>

            {{-- Card 2: Cuci Satuan --}}
            <div class="group relative bg-gradient-to-br from-white to-blue-50/30 backdrop-blur-sm rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-md hover:shadow-2xl border border-white/50 transition-all duration-500 hover:-translate-y-1">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-[#89b252] to-green-400 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-5 shadow-lg shadow-green-200/50 group-hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[26px] md:h-[26px]">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <path d="m9 15 2 2 4-4"/>
                    </svg>
                </div>
                <h4 class="text-base md:text-xl font-bold text-gray-800 mb-1.5 md:mb-2">Cuci Satuan</h4>
                <p class="text-gray-500 text-xs md:text-sm leading-relaxed">Cuci per item untuk pakaian khusus seperti jaket, selimut, dan jas. Ditangani dengan teliti dan hati-hati.</p>
                <div class="mt-4 md:mt-5 flex items-center text-[#89b252] text-xs md:text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <span>Harga sesuai item</span>
                </div>
            </div>

            {{-- Card 3: Free Pickup --}}
            <div class="group relative bg-gradient-to-br from-white to-blue-50/30 backdrop-blur-sm rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-md hover:shadow-2xl border border-white/50 transition-all duration-500 hover:-translate-y-1">
                <div class="w-12 h-12 md:w-14 md:h-14 bg-gradient-to-br from-purple-500 to-violet-400 rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-5 shadow-lg shadow-purple-200/50 group-hover:scale-110 transition-transform duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[26px] md:h-[26px]">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/>
                        <path d="M15 18H9"/>
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/>
                        <circle cx="7" cy="18" r="2"/>
                        <circle cx="17" cy="18" r="2"/>
                    </svg>
                </div>
                <h4 class="text-base md:text-xl font-bold text-gray-800 mb-1.5 md:mb-2">Free Pickup</h4>
                <p class="text-gray-500 text-xs md:text-sm leading-relaxed">Gratis antar jemput radius 3 km dari UNNES. Tinggal hubungi via WhatsApp, kami yang jemput!</p>
                <div class="mt-4 md:mt-5 flex items-center text-purple-500 text-xs md:text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <span>Gratis ongkir!</span>
                </div>
            </div>

        </div>
    </div>
</section>