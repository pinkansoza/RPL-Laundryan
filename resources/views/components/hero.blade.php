<section id="beranda" class="pt-4 md:pt-16 pb-10 md:pb-24 bg-gradient-to-b from-blue-50 to-white px-5 md:px-6">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 items-center text-center md:text-left">
        
        <div class="order-first md:order-last px-2 md:px-0">
            <div class="relative">
                <img src="{{ asset('img/6.png') }}" class="relative w-full h-auto max-h-[220px] md:max-h-[500px] object-contain transition-all duration-500 drop-shadow-lg" alt="Laundry UNNES">
            </div>
        </div>

        <div class="md:order-first space-y-5 md:space-y-6">
            <div>
                <h2 class="text-2xl md:text-5xl font-extrabold text-gray-800 leading-snug md:leading-tight">
                    Solusi Cerdas untuk <br> <span class="text-[#559dd4]">Pakaian Berkualitas</span>
                </h2>
                <p class="mt-3 md:mt-4 text-gray-600 text-xs md:text-lg leading-relaxed">
                    Bisa antar jemput radius 3 km dari UNNES. <br class="hidden md:block"> 
                    <span class="text-[#89b252] font-bold">Murah, Bersih, dan Wangi.</span>
                </p>
            </div>

            <div class="block md:hidden max-w-sm mx-auto md:mx-0">
                <button onclick="toggleModal()" class="w-full bg-[#559dd4] text-white font-bold py-2.5 rounded-lg shadow-md active:scale-95 transition-transform flex items-center justify-center gap-2 text-sm">
                    Laundry Sekarang
                </button>
            </div>
            
            <div class="bg-white p-4 md:p-5 rounded-xl md:rounded-2xl shadow-md md:shadow-lg border border-gray-100 mx-auto md:mx-0 max-w-sm">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Cek Status Order</label>
                <div class="flex gap-2">
                    <input type="text" placeholder="LDR-xxxx" 
                           class="flex-1 border-gray-200 rounded-lg md:rounded-xl p-2.5 md:p-3 text-sm focus:ring-blue-500 bg-gray-50 outline-none border focus:border-blue-300">
                    <button class="bg-[#89b252] text-white px-5 py-2.5 md:py-3 rounded-lg md:rounded-xl font-bold text-sm hover:bg-green-600 transition shadow-md">
                        Cek
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>
