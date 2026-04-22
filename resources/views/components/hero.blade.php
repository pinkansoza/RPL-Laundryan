<section id="beranda" class="pt-4 md:pt-16 pb-10 md:pb-24 bg-gradient-to-b from-blue-50 to-white px-5 md:px-6">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 items-center text-center md:text-left">
        
        <div class="order-first md:order-last px-2 md:px-0">
            <div class="relative">
                <img src="{{ ($beranda && $beranda->gambar) ? asset('storage/' . $beranda->gambar) : asset('img/6.png') }}" 
                     class="relative w-full h-auto max-h-[220px] md:max-h-[500px] object-contain transition-all duration-500 drop-shadow-lg" 
                     alt="Laundry UNNES">
            </div>
        </div>

        <div class="md:order-first space-y-5 md:space-y-6">
            <div>
                <h2 class="text-2xl md:text-5xl font-bold text-gray-800 leading-snug md:leading-tight">
                    {!! $beranda->judul ?? 'Solusi Cerdas untuk <br> <span class="text-[#559dd4]">Pakaian Berkualitas</span>' !!}
                </h2>
                
                <p class="mt-3 md:mt-4 text-gray-600 text-xs md:text-lg leading-relaxed">
                    {!! nl2br($beranda->slogan ?? "Bisa antar jemput radius 3 km dari Laundry AK. \n <span class='text-[#89b252] font-bold'>Murah, Bersih, dan Wangi.</span>") !!}
                </p>
            </div>

            
            <div class="bg-white p-4 md:p-5 rounded-xl md:rounded-2xl shadow-md md:shadow-lg border border-gray-100 mx-auto md:mx-0 max-w-sm w-full">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Cek Status Laundryanmu</label>
                <form action="{{ route('home') }}#beranda" method="GET" class="flex gap-2">
                    <input type="text" name="kode" value="{{ request('kode') }}" placeholder="Contoh: 0407.19042026.0001" 
                           class="flex-1 w-full border-gray-200 rounded-lg md:rounded-xl p-2.5 md:p-3 text-sm focus:ring-[#559dd4] bg-gray-50 outline-none border focus:border-[#559dd4]/50">
                    <button type="submit" class="bg-[#89b252] text-white px-5 py-2.5 md:py-3 rounded-lg md:rounded-xl font-bold text-sm hover:bg-green-600 transition shadow-md">
                        Cek
                    </button>
                </form>
                
                @if(request()->filled('kode'))
                    @if($trackingResult)
                        <!-- Call Alpine Modal -->
                        <div x-data="{ showTrackingModal: true }" @keydown.escape.window="showTrackingModal = false; setTimeout(() => window.history.replaceState({}, '', window.location.pathname), 300);">
                            <template x-teleport="body">
                                <div>
                                    @include('components.cekstatuslaundry', ['data' => $trackingResult])
                                </div>
                            </template>
                        </div>
                    @else
                        <div class="mt-4 p-4 rounded-xl border bg-red-50 border-red-200">
                            <p class="font-bold text-sm text-red-700">Pesanan tidak ditemukan!</p>
                            <p class="text-[11px] text-red-500 mt-1 leading-tight">Pastikan kode yang kamu masukkan benar (Contoh: 0407.19042026.0001).</p>
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</section>