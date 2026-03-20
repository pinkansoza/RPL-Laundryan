<section id="beranda" class="pt-6 md:pt-16 pb-12 md:pb-24 bg-gradient-to-b from-blue-50 to-white px-6">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center text-center md:text-left">
        
        <div class="order-first md:order-last px-4 md:px-0">
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-200 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition"></div>
                <img src="https://images.unsplash.com/photo-1545173168-9f1947eebb7f?q=80&w=1000&auto=format&fit=crop" 
                     class="relative rounded-3xl shadow-xl w-full h-48 md:h-96 object-cover rotate-0 md:rotate-3 hover:rotate-0 transition duration-500"
                     alt="Laundry UNNES">
            </div>
        </div>

        <div class="md:order-first">
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-800 leading-tight">
                Cucian Wangi <br class="hidden md:block"> <span class="text-blue-600">Tanpa Ribet!</span>
            </h2>
            <p class="mt-4 text-gray-600 text-sm md:text-lg">
                Bisa antar jemput radius 3km dari UNNES. <br class="hidden md:block"> 
                <span class="text-orange-600 font-bold">Murah, Bersih, dan Wangi.</span>
            </p>

            <div class="mt-6 block md:hidden">
                <button onclick="toggleModal()" class="w-full bg-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 active:scale-95 transition flex items-center justify-center gap-2">
                    <span>🧺</span> Pesan Sekarang
                </button>
            </div>
            
            <div class="mt-8 bg-white p-5 rounded-2xl shadow-lg border border-blue-50 mx-auto md:mx-0 max-w-sm">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">🔎 Cek Status Order</label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" placeholder="LDR-xxxx" 
                           class="flex-1 border-gray-200 rounded-xl p-3 text-sm focus:ring-blue-500 bg-gray-50 outline-none border focus:border-blue-300">
                    <button class="bg-orange-500 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-orange-600 transition shadow-md">
                        Cek
                    </button>
                </div>
            </div>
        </div>

    </div>
</section>