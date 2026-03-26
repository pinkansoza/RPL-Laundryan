@php
    $statusRaw = $data->status ?? 'Diterima';
    if($statusRaw === 'Pending') $statusRaw = 'Diterima';
    if($statusRaw === 'Diproses') $statusRaw = 'Dicuci';
    
    $steps = [
        'Diterima' => ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'label' => 'Pesanan Diterima'],
        'Dicuci'   => ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'label' => 'Sedang Dicuci'],
        'Selesai'  => ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Selesai & Wangi'],
        'Diambil'  => ['icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'label' => 'Sudah Diambil'],
    ];
    
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($statusRaw, $stepKeys);
    if ($currentIndex === false) $currentIndex = 0; 
    
    $headlines = [
        'Diterima' => 'Pesananmu sudah kami terima dan siap diproses!',
        'Dicuci' => 'Pakaianmu sedang asyik mandi busa nih!',
        'Selesai' => 'Yeay! Pakaianmu sudah bersih, wangi, dan rapi!',
        'Diambil' => 'Terima kasih sudah mempercayakan laundryanmu!'
    ];
    $headline = $headlines[$statusRaw] ?? 'Yah, pesanan dibatalkan.';
    if($statusRaw === 'Dibatalkan') $currentIndex = -1;
@endphp

<!-- High Fidelity Modal Background -->
<div class="fixed inset-0 z-[100] flex items-center justify-center p-3 sm:p-6 transition-all duration-300" x-show="showTrackingModal" x-cloak>
    
    <!-- Backdrop, clicks outside will close modal -->
    <div class="absolute inset-0 backdrop-blur-sm bg-gray-900/40" x-show="showTrackingModal" x-transition.opacity @click="showTrackingModal = false; setTimeout(() => window.history.replaceState({}, '', window.location.pathname), 300);"></div>
    
    <!-- Modal Container -->
    <div class="bg-white rounded-2xl w-full max-w-2xl max-h-[95vh] overflow-hidden shadow-2xl relative border border-white/20 z-10" @click.stop x-show="showTrackingModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
        
        <!-- Animated Green Banner Background -->
        <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-br from-emerald-50 via-emerald-100/30 to-white opacity-60"></div>

        <!-- Close Button -->
        <button @click="showTrackingModal = false; setTimeout(() => window.history.replaceState({}, '', window.location.pathname), 300);" class="absolute top-4 right-4 sm:top-5 sm:right-5 w-8 h-8 bg-white hover:bg-gray-100 text-gray-400 hover:text-red-500 rounded-full flex items-center justify-center shadow-sm border border-gray-200 transition-colors z-20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="p-4 sm:p-6 relative z-10">
            <!-- Header Section -->
            <div class="mb-4 text-center">
                <span class="inline-block bg-emerald-100 text-emerald-800 text-[9px] font-black tracking-widest uppercase px-2.5 py-1 rounded-full mb-2">Live Tracking</span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">{{ $data->kode_pesanan }}</h2>
                <p class="text-[13px] sm:text-sm font-semibold text-gray-600 mt-0.5">{{ $headline }}</p>
            </div>

            <!-- Compact Progress Bar -->
            <div class="relative mb-6 w-full px-1 max-w-xl mx-auto">
                <!-- Background Line exactly bounded between the centers of the first (w-12 or 3rem -> half is 1.5rem = left-6) and last circles -->
                <div class="absolute top-5 left-6 right-6 h-1 z-0">
                    <div class="absolute inset-0 bg-gray-200 rounded-full"></div>
                    <!-- Green Fill Line -->
                    <div class="absolute top-0 left-0 bottom-0 bg-emerald-500 rounded-full transition-all duration-700 ease-out shadow-[0_0_8px_rgba(16,185,129,0.3)]" style="width: {{ $currentIndex === -1 ? '0%' : ($currentIndex * 33.33) . '%' }};"></div>
                </div>

                <!-- Nodes -->
                <div class="relative flex justify-between items-start w-full">
                    
                    @foreach($steps as $key => $stepData)
                        @php
                            $stepIndex = array_search($key, $stepKeys);
                            $isActive = $currentIndex === $stepIndex;
                            $isCompleted = $currentIndex > $stepIndex;
                        @endphp
                        
                        <!-- Circle Container set to exactly w-12 matches our left-6 line calculation -->
                        <div class="flex flex-col items-center gap-2 relative z-10 w-12">
                            <!-- Icon Circle -->
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex flex-shrink-0 items-center justify-center transition-all duration-500 relative 
                                {{ $isActive ? 'bg-emerald-500 text-white shadow-md scale-105' : 
                                  ($isCompleted ? 'bg-emerald-50 text-emerald-600 border-2 border-emerald-200' : 'bg-white text-gray-300 border-2 border-gray-100') }}">
                                
                                @if($isActive && $statusRaw !== 'Dibatalkan')
                                    <div class="absolute inset-0 rounded-full border border-emerald-400 animate-ping opacity-50"></div>
                                @endif
                                
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stepData['icon'] }}"></path></svg>
                                
                                <!-- Small check badge for completed -->
                                @if($isCompleted && $statusRaw !== 'Dibatalkan')
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 sm:w-5 sm:h-5 bg-emerald-500 rounded-full border-2 border-white flex items-center justify-center text-white shadow-sm">
                                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Label text -->
                            <span class="text-[10px] sm:text-[11px] font-bold text-center leading-tight whitespace-nowrap {{ $isActive ? 'text-emerald-700' : ($isCompleted ? 'text-gray-800' : 'text-gray-400') }}">
                                {!! str_replace(' ', '<br>', $stepData['label']) !!}
                            </span>
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Detail & Table Layout Container Compact -->
            <div class="bg-gray-50/50 rounded-xl p-3 sm:p-4 border border-gray-100 shadow-sm mt-3">
                
                <h3 class="text-xs font-black text-gray-800 mb-3 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#89b252]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Informasi Transaksi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-6 text-[11px] sm:text-[12px] font-medium text-gray-700 mb-4">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-24">Nama</span>
                            <span class="font-bold text-gray-900 text-right">{{ $data->nama_pelanggan }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-24">WhatsApp</span>
                            <span class="font-bold text-gray-900 text-right">{{ $data->nomor_whatsapp }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-24">Pengiriman</span>
                            <span class="font-bold text-gray-900 text-right">{{ $data->metode_pengiriman }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-24">Pembayaran</span>
                            <span class="font-bold text-gray-900 text-right">{{ strtoupper($data->metode_pembayaran) }}</span>
                        </div>
                        <div class="flex items-start justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-24 shrink-0">Catatan</span>
                            <span class="font-bold text-gray-900 text-right">{{ $data->catatan ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-28 shrink-0">Status Laundry</span>
                            <span class="font-bold {{ $statusRaw === 'Dibatalkan' ? 'text-red-600 bg-red-50' : 'text-emerald-700 bg-emerald-50' }} px-2 py-0.5 rounded">{{ $statusRaw }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-28 shrink-0">Status Pembayaran</span>
                            <span class="font-bold text-gray-900 text-right">{{ $statusRaw === 'Diambil' ? 'Lunas' : 'Belum Lunas' }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/50">
                            <span class="text-gray-500 w-28 shrink-0">Status Pengambilan</span>
                            <span class="font-bold text-gray-900 text-right">{{ $statusRaw === 'Diambil' ? 'Sudah Diambil' : 'Belum Diambil' }}</span>
                        </div>
                    </div>
                </div>


                <!-- Beautiful Table Layout Compact -->
                <div class="bg-white rounded-lg overflow-hidden border border-gray-200/80">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-200/80">
                                <th class="p-2 sm:p-3 text-[10px] sm:text-xs font-bold text-gray-500 uppercase text-center">Tgl Terima</th>
                                <th class="p-2 sm:p-3 text-[10px] sm:text-xs font-bold text-gray-500 uppercase text-center">Tgl Selesai</th>
                                <th class="p-2 sm:p-3 text-[10px] sm:text-xs font-bold text-gray-500 uppercase text-left">Layanan</th>
                                <th class="p-2 sm:p-3 text-[10px] sm:text-xs font-bold text-gray-500 uppercase text-center">B/Qty</th>
                                <th class="p-2 sm:p-3 text-[10px] sm:text-xs font-bold text-emerald-600 uppercase text-right bg-emerald-50/50">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-2 sm:p-3 text-[11px] sm:text-xs font-semibold text-gray-800 text-center border-r border-gray-100/50">{{ $data->created_at->format('d M y') }}</td>
                                <td class="p-2 sm:p-3 text-[11px] sm:text-xs font-semibold text-gray-800 text-center border-r border-gray-100/50">{{ $statusRaw === 'Selesai' || $statusRaw === 'Diambil' ? $data->updated_at->format('d M y') : '-' }}</td>
                                <td class="p-2 sm:p-3 text-[11px] sm:text-xs font-bold text-gray-800 border-r border-gray-100/50">
                                    <div class="flex flex-col">
                                        <span class="text-[#559dd4] leading-tight">{{ $data->paket }}</span>
                                        <span class="text-[10px] text-gray-500 leading-tight">{{ $data->jenis_layanan }}</span>
                                    </div>
                                </td>
                                <td class="p-2 sm:p-3 text-[11px] sm:text-xs font-black text-gray-800 text-center border-r border-gray-100/50">{{ $data->berat ? $data->berat.'Kg' : $data->jumlah_item.'Px' }}</td>
                                <td class="p-2 sm:p-3 text-[12px] sm:text-sm font-black text-emerald-600 text-right bg-emerald-50/30">Rp {{ number_format($data->total_estimasi_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
