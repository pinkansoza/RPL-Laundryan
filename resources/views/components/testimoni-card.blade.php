<div class="w-[240px] md:w-[350px] flex-none group relative bg-gradient-to-br from-gray-50 to-white rounded-2xl md:rounded-3xl p-5 md:p-8 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md">
    <div class="flex text-primary mb-3 md:mb-5">
        @for($i = 0; $i < $item->bintang; $i++)
            <svg class="w-3.5 h-3.5 md:w-4 md:h-4 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endfor
    </div>
    
    <p class="text-gray-600 italic mb-6 md:mb-8 text-[11px] md:text-sm leading-relaxed line-clamp-3">
        "{{ $item->pesan }}"
    </p>

    <div class="flex items-center gap-3 md:gap-4 border-t border-gray-100 pt-4 md:pt-5">
        @if($item->foto_pelanggan)
            <img src="{{ asset('storage/' . $item->foto_pelanggan) }}" class="w-8 h-8 md:w-12 md:h-12 rounded-xl object-cover shadow-sm">
        @else
            <div class="w-8 h-8 md:w-12 md:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-xs md:text-base">
                {{ substr($item->nama_pelanggan, 0, 1) }}
            </div>
        @endif
        <div>
            <h5 class="font-bold text-gray-800 text-xs md:text-base leading-tight">
                {{ $item->nama_pelanggan }}
            </h5>
            <p class="text-primary text-[9px] md:text-xs font-semibold uppercase tracking-wider mt-0.5">
                Pelanggan
            </p>
        </div>
    </div>
</div>