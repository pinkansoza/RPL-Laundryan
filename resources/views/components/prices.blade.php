<section id="harga" class="py-10 md:py-24 bg-gradient-to-b from-blue-50 to-white px-5 md:px-6 font-Inter">
    <div class="container mx-auto">
        
        {{-- Section Header --}}
        <div class="text-center mb-8 md:mb-16">
            <h2 class="text-xl md:text-4xl font-bold text-gray-900 mb-3 text-center">List Harga</h2>
            <p class="text-xs md:text-base text-gray-500">Pilih paket layanan yang sesuai dengan kebutuhan Anda</p>
        </div>

        {{-- Tab Navigation --}}
        <div class="flex justify-center mb-8 md:mb-12">
            <div class="inline-flex flex-wrap justify-center gap-2 md:gap-3 bg-white/80 backdrop-blur-sm p-1.5 md:p-2 rounded-2xl shadow-lg border border-gray-100">
                @foreach ($hargas as $index => $harga)
                    <button
                        onclick="switchTab({{ $index }})"
                        id="tab-btn-{{ $index }}"
                        class="tab-btn px-4 md:px-6 py-2 md:py-3 rounded-xl text-[11px] md:text-sm font-bold transition-all duration-300 whitespace-nowrap
                            {{ $index === 0 ? 'bg-gradient-to-r from-[#559dd4] to-[#7dbde8] text-white shadow-lg shadow-blue-200/50 scale-105' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}"
                    >
                        {{ $harga->nama_paket }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Tab Content --}}
        @foreach ($hargas as $index => $harga)
            <div id="tab-content-{{ $index }}" class="tab-content transition-all duration-500 {{ $index === 0 ? '' : 'hidden' }}">
                
                {{-- Card Header --}}
                <div class="max-w-4xl mx-auto">
                    <div class="relative bg-gradient-to-br from-[#559dd4] to-[#3d7ab3] rounded-t-2xl md:rounded-t-3xl p-6 md:p-10 text-white overflow-hidden">
                        {{-- Decorative circles --}}
                        <div class="absolute top-0 right-0 w-32 h-32 md:w-48 md:h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 md:w-32 md:h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                        
                        <div class="relative z-10 text-center">
                            <h3 class="text-xl md:text-3xl font-black uppercase tracking-wider mb-2">
                                {{ $harga->nama_paket }}
                            </h3>
                            <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm px-4 py-1.5 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-4 md:h-4"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span class="text-[10px] md:text-xs font-semibold tracking-wide">{{ $harga->estimasi }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Price List Body --}}
                    <div class="bg-white rounded-b-2xl md:rounded-b-3xl shadow-xl shadow-gray-200/50 border border-t-0 border-gray-100 overflow-hidden">
                        @foreach ($harga->konten as $catIndex => $kategori)
                            {{-- Category Header --}}
                            <div class="bg-gradient-to-r from-gray-50 to-white px-5 md:px-10 py-3 md:py-4 border-b border-gray-100">
                                <h4 class="text-xs md:text-sm font-black text-[#559dd4] uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-[#559dd4] rounded-full"></span>
                                    {{ $kategori['nama_kategori'] }}
                                </h4>
                            </div>

                            {{-- Items --}}
                            <div class="divide-y divide-gray-50">
                                @foreach ($kategori['items'] as $itemIndex => $item)
                                    <div class="group flex justify-between items-center px-5 md:px-10 py-3 md:py-4 hover:bg-blue-50/30 transition-all duration-300">
                                        <div class="flex items-center gap-3">
                                            <span class="w-5 h-5 md:w-6 md:h-6 bg-blue-50 text-[#559dd4] rounded-lg flex items-center justify-center text-[9px] md:text-[10px] font-black group-hover:bg-[#559dd4] group-hover:text-white transition-all duration-300">
                                                {{ $itemIndex + 1 }}
                                            </span>
                                            <span class="text-gray-600 text-xs md:text-sm">{{ $item['nama_item'] }}</span>
                                        </div>
                                        <span class="font-black text-gray-900 text-xs md:text-sm whitespace-nowrap ml-4 bg-gray-50 group-hover:bg-blue-100/50 px-3 py-1 rounded-lg transition-all duration-300">
                                            {{ $item['harga_label'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            @if (!$loop->last)
                                <div class="mx-5 md:mx-10 border-b-2 border-dashed border-gray-100"></div>
                            @endif
                        @endforeach

                        {{-- Footer CTA --}}
                        <div class="bg-gradient-to-r from-blue-50/50 to-white px-5 md:px-10 py-4 md:py-6 border-t border-gray-100">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                <p class="text-[10px] md:text-xs text-gray-400 font-medium">
                                    * Harga dapat berubah sewaktu-waktu
                                </p>
                                <a href="https://wa.me/{{ $kontak->whatsapp ?? '' }}?text=Halo%20Laundry%20AK,%20saya%20ingin%20bertanya%20tentang%20paket%20{{ urlencode($harga->nama_paket) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white px-5 py-2.5 rounded-xl text-[11px] md:text-xs font-bold shadow-lg shadow-green-200/50 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

    </div>

    {{-- Tab Switching Script --}}
    <script>
        function switchTab(activeIndex) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });

            // Reset all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-[#559dd4]', 'to-[#7dbde8]', 'text-white', 'shadow-lg', 'shadow-blue-200/50', 'scale-105');
                btn.classList.add('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-50');
            });

            // Show active tab content
            const activeContent = document.getElementById('tab-content-' + activeIndex);
            if (activeContent) {
                activeContent.classList.remove('hidden');
            }

            // Highlight active tab button
            const activeBtn = document.getElementById('tab-btn-' + activeIndex);
            if (activeBtn) {
                activeBtn.classList.add('bg-gradient-to-r', 'from-[#559dd4]', 'to-[#7dbde8]', 'text-white', 'shadow-lg', 'shadow-blue-200/50', 'scale-105');
                activeBtn.classList.remove('text-gray-500', 'hover:text-gray-700', 'hover:bg-gray-50');
            }
        }
    </script>
</section>