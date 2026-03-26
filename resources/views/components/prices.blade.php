<section id="harga" class="py-10 md:py-24 bg-gradient-to-b from-blue-50 to-white px-5 md:px-6 font-Inter">
    <div class="container mx-auto">
        
        <div class="text-center mb-8 md:mb-16">
            <h2 class="text-xl md:text-4xl font-extrabold text-gray-900 mb-3 text-center">List Harga</h2>
            <p class="text-xs md:text-base text-gray-500">Pilih paket layanan yang sesuai dengan kebutuhan Anda</p>
        </div>

        <div class="flex flex-wrap justify-center gap-5 md:gap-8">
            
            @foreach ($hargas as $harga)
            <div class="group relative bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 border border-[#89b252] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 w-full sm:w-[calc(50%-1.25rem)] lg:w-[calc(33.333%-2rem)] max-w-sm lg:max-w-none flex flex-col">
                
                <div class="text-center mb-6 border-b border-gray-50 pb-5">
                    <h3 class="text-lg md:text-2xl font-black text-[#89b252] uppercase tracking-widest mb-1">
                        {{ $harga->nama_paket }}
                    </h3>
                    <div class="bg-gray-50 text-gray-400 px-3 py-1 rounded-full inline-block text-[9px] md:text-xs font-bold tracking-wide border border-gray-100">
                        {{ $harga->estimasi }}
                    </div>
                </div>

                <div class="flex-grow">
                    @foreach ($harga->konten as $index => $kategori)
                        <div class="{{ !$loop->last ? 'mb-6' : '' }}">
                            <h4 class="text-sm md:text-lg font-extrabold text-gray-800 mb-3">
                                {{ $kategori['nama_kategori'] }}
                            </h4>
                            
                            <ul class="space-y-3 text-[12px] md:text-sm">
                                @foreach ($kategori['items'] as $item)
                                    <li class="flex justify-between items-center border-b border-gray-50 pb-1.5 transition-colors hover:border-green-50">
                                        <span class="text-gray-500 pr-4">{{ $item['nama_item'] }}</span>
                                        <span class="font-bold text-gray-900 whitespace-nowrap">{{ $item['harga_label'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @if (!$loop->last)
                            <div class="border-b-2 border-dashed border-gray-100 mb-6"></div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach

        </div> 
    </div> 
</section>