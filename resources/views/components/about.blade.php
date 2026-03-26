<section id="tentang" class="py-14 md:py-24 bg-gradient-to-br from-[#7dbde8] to-[#a8d4f0] px-5 md:px-6 relative overflow-hidden">
    {{-- Background decorative elements --}}
    <div class="absolute top-0 left-0 w-72 h-72 bg-blue-300/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-72 h-72 bg-white/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto relative z-10">
        {{-- Section Header --}}
        <div class="text-center mb-8 md:mb-16">
            <h2 class="text-xl md:text-4xl font-extrabold text-white mb-3 text-center">Layanan & Promo</h2>
            <p class="text-xs md:text-base text-white">Pilih paket layanan yang sesuai dengan kebutuhan Anda</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-5 md:gap-8">

            @foreach($layanans as $item)
            <div class="group relative bg-gradient-to-br from-white to-blue-50/30 backdrop-blur-sm rounded-2xl md:rounded-3xl p-6 md:p-8 shadow-md hover:shadow-2xl border border-white/50 transition-all duration-500 hover:-translate-y-1 w-full sm:w-[calc(50%-1.25rem)] lg:w-[calc(25%-2rem)] max-w-sm">
                
                <div class="w-12 h-12 md:w-14 md:h-14 {{ $item->warna }} rounded-xl md:rounded-2xl flex items-center justify-center mb-4 md:mb-5 shadow-lg group-hover:scale-110 transition-transform duration-500">
                    <x-dynamic-component :component="$item->ikon" class="w-6 h-6 md:w-[26px] md:h-[26px] text-white" />
                </div>

                <h4 class="text-base md:text-xl font-bold text-gray-800 mb-1.5 md:mb-2">
                    {{ $item->nama }}
                </h4>
                
                <p class="text-gray-500 text-xs md:text-sm leading-relaxed">
                    {{ $item->deskripsi }}
                </p>

                <div class="mt-4 md:mt-5 flex items-center text-xs md:text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    {{-- Slot untuk interaksi tambahan --}}
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>