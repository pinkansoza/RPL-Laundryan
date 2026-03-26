<footer id="alamat" class="bg-gray-800 text-gray-300 pt-10 md:pt-16 pb-8 font-sans text-left">
    <div class="container mx-auto px-5 md:px-6 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 text-left">
        
        <div class="text-left">
            <h4 class="text-white font-bold mb-5 md:mb-8 text-base md:text-xl tracking-tight">
                Hubungi Kami
            </h4>
            <ul class="space-y-4 md:space-y-6 text-xs md:text-sm">
                {{-- Alamat --}}
                <li class="flex items-start gap-4 group">
                    <div class="text-[#559dd4] bg-[#559dd4]/10 p-2 md:p-3 rounded-xl md:rounded-2xl group-hover:bg-[#559dd4] group-hover:text-white transition duration-300 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[22px] md:h-[22px]"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div class="pt-0.5 md:pt-1">
                        <p class="text-white font-semibold mb-0.5 md:mb-1 text-[10px] md:text-xs uppercase tracking-wider">Alamat</p>
                        <p class="text-gray-400 text-xs md:text-sm">{{ $kontak->alamat ?? 'Alamat belum diatur' }}</p>
                    </div>
                </li>

                {{-- WhatsApp --}}
                <li class="flex items-start gap-4 group">
                    <div class="text-[#559dd4] bg-[#559dd4]/10 p-2 md:p-3 rounded-xl md:rounded-2xl group-hover:bg-[#559dd4] group-hover:text-white transition duration-300 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[22px] md:h-[22px]"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div class="pt-0.5 md:pt-1">
                        <p class="text-white font-semibold mb-0.5 md:mb-1 text-[10px] md:text-xs uppercase tracking-wider">WhatsApp</p>
                        <a href="https://wa.me/{{ $kontak->whatsapp }}" target="_blank" class="hover:text-[#559dd4] transition font-bold text-xs md:text-sm">
                            {{ $kontak->whatsapp }}
                        </a>
                    </div>
                </li>

                {{-- Instagram --}}
                @if($kontak->instagram)
                <li class="flex items-start gap-4 group">
                    <div class="text-[#559dd4] bg-[#559dd4]/10 p-2 md:p-3 rounded-xl md:rounded-2xl group-hover:bg-[#559dd4] group-hover:text-white transition duration-300 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[22px] md:h-[22px]"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </div>
                    <div class="pt-0.5 md:pt-1">
                        <p class="text-white font-semibold mb-0.5 md:mb-1 text-[10px] md:text-xs uppercase tracking-wider">Instagram</p>
                        <a href="https://instagram.com/{{ $kontak->instagram }}" target="_blank" class="hover:text-[#559dd4] transition font-bold text-xs md:text-sm">
                            @<span>{{ $kontak->instagram }}</span>
                        </a>
                    </div>
                </li>
                @endif

                {{-- Jam Operasional --}}
                <li class="flex items-start gap-4 group">
                    <div class="text-[#559dd4] bg-[#559dd4]/10 p-2 md:p-3 rounded-xl md:rounded-2xl group-hover:bg-[#559dd4] group-hover:text-white transition duration-300 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="md:w-[22px] md:h-[22px]"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="pt-0.5 md:pt-1">
                        <p class="text-white font-semibold mb-0.5 md:mb-1 text-[10px] md:text-xs uppercase tracking-wider">Jam Operasional</p>
                        <p class="text-gray-400 text-xs md:text-sm">{{ $kontak->jam_operasional }}</p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="text-left">
            <h4 class="text-white font-bold mb-5 md:mb-8 text-base md:text-xl tracking-tight">
                Lokasi Kami
            </h4>
            <div class="w-full h-48 md:h-72 rounded-2xl md:rounded-[2.5rem] overflow-hidden shadow-2xl border border-gray-800 group bg-gray-800">
                <iframe 
                    src="{{ $kontak->url_gmaps }}" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-5 md:px-10">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
       </div>

    <div class="border-t border-gray-700"></div>

    <div class="mt-6 text-center">
      <p class="text-[10px] md:text-xs font-medium tracking-widest opacity-60 uppercase">
        © 2026 Laundry AK. All rights reserved.
      </p>
    </div>

  </div>
</footer>