@php
    $hargasList = $hargas ?? collect();
    $firstHarga = $hargasList->first();
    $firstKontenArray = [];
    if ($firstHarga) {
        $firstKontenArray = is_string($firstHarga->konten) ? json_decode($firstHarga->konten, true) : $firstHarga->konten;
        $firstKontenArray = is_array($firstKontenArray) ? $firstKontenArray : [];
    }
    
    $satuanItems = [];
    $firstLayanan = '';
    
    if(!empty($firstKontenArray)) {
        foreach($firstKontenArray as $kategori) {
            $isSatuanKategori = str_contains(strtolower($kategori['nama_kategori'] ?? ''), 'satuan');
            if(isset($kategori['items']) && is_array($kategori['items'])) {
                foreach($kategori['items'] as $index => $item) {
                    $namaItem = $item['nama_item'] ?? '';
                    if ($firstLayanan === '') $firstLayanan = $namaItem;
                    if ($isSatuanKategori) {
                        $satuanItems[] = $namaItem;
                    }
                }
            }
        }
    }
    
    $jamPickups = [];
    if (isset($kontak) && $kontak->jam_pickup) {
        $jamPickups = is_string($kontak->jam_pickup) ? json_decode($kontak->jam_pickup, true) : $kontak->jam_pickup;
        $jamPickups = is_array($jamPickups) ? $jamPickups : [];
    }
@endphp

<div x-data='{ 
        paket: @json($firstHarga->nama_paket ?? "Reguler"), 
        layanan: @json($firstLayanan ?: "Cuci Kering Setrika"), 
        pengiriman: "Antar Sendiri", 
        berat: 0,
        itemSatuan: 1,
        jamPicked: "",
        pickupLocationReady: false,
        showPickupWarning: false,

        prices: @json($parsedPrices ?? []),

        isSatuan() {
            let satuanList = @json($satuanItems);
            if(satuanList.length === 0) satuanList = ["Bedcover", "Selimut", "Sprei"];
            return satuanList.includes(this.layanan);
        },

        get totalHargaInt() {
            let hargaDasar = 0;
            if(this.prices[this.paket] && this.prices[this.paket][this.layanan]) {
                hargaDasar = this.prices[this.paket][this.layanan];
            }
            return this.isSatuan() ? (hargaDasar * this.itemSatuan) : (hargaDasar * this.berat);
        },

        get totalHarga() {
            let total = this.totalHargaInt;
            return total > 0 ? "Rp " + total.toLocaleString("id-ID") : "Rp 0";
        },

        validatePickup() {
            if (this.pengiriman !== "Pickup") return true;
            const alamatField = document.querySelector("textarea[name=detail_alamat]");
            const hasAlamat = alamatField && alamatField.value.trim().length > 0;
            if (!this.jamPicked || (!this.pickupLocationReady && !hasAlamat)) {
                this.showPickupWarning = true;
                return false;
            }
            this.showPickupWarning = false;
            return true;
        }
    }' class="w-full"> <!-- Container form bersih tanpa background atau kotak luar -->

    @if(session('success'))
        <div x-data="{ showSuccessModal: true }" @keydown.escape.window="showSuccessModal = false">
            <template x-teleport="body">
                <div class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-show="showSuccessModal" x-cloak>
                    <!-- Backdrop -->
                    <div class="absolute inset-0 backdrop-blur-sm bg-gray-900/40" x-show="showSuccessModal" x-transition.opacity @click="showSuccessModal = false"></div>
                    
                    <!-- Modal -->
                    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl relative z-10 overflow-hidden" @click.stop x-show="showSuccessModal" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 scale-90 translate-y-6" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                        
                        <!-- Green Header -->
                        <div class="bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-600 p-6 text-center text-white relative">
                            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                            <div class="relative z-10">
                                <div class="w-16 h-16 mx-auto bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-3 shadow-lg">
                                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h3 class="text-xl font-black tracking-tight">Pesanan Berhasil!</h3>
                                <p class="text-emerald-100 text-xs font-medium mt-1">Laundryanmu sudah tercatat di sistem kami</p>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="p-6 text-center">
                            <p class="text-xs text-gray-500 font-medium mb-1">Kode pesananmu adalah</p>
                            <div class="bg-gray-50 border-2 border-dashed border-emerald-300 rounded-xl px-6 py-3 inline-block mb-4">
                                <span class="text-2xl font-black text-emerald-600 tracking-wider">{{ session('kode_pesanan') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 leading-relaxed mb-5">Simpan kode ini baik-baik ya! Kamu bisa cek status laundryanmu kapan saja dari halaman Beranda.</p>

                            <div class="flex flex-col gap-2">
                                <a href="/?kode={{ session('kode_pesanan') }}" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    Cek Status Laundryanmu
                                </a>
                                <button @click="showSuccessModal = false" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-3 px-4 rounded-xl transition-colors">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    @endif

    <form action="{{ route('order.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-8 pt-1" x-on:submit="if(!validatePickup()) { $event.preventDefault(); }">
        @csrf
        
        <!-- Sisi Kiri: Data & Layanan -->
        <div class="flex flex-col space-y-3 lg:space-y-3">
            <h3 class="text-sm md:text-base font-semibold text-gray-800 border-l-4 border-[#559dd4] pl-3 mb-1">Identitas & Layanan</h3>
            
            <div>
                <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1 pl-1">Nama</label>
                <input type="text" name="nama" placeholder="Ketik nama anda..." required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs md:text-sm font-medium text-gray-900 placeholder-gray-400 focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1 pl-1">Nomor WhatsApp</label>
                <input type="number" name="wa" placeholder="08..." required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs md:text-sm font-medium text-gray-900 placeholder-gray-400 focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Paket</label>
                    <select name="paket" x-model="paket" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs md:text-sm font-semibold text-gray-900 focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all cursor-pointer">
                        @foreach($hargasList as $harga)
                            <option value="{{ $harga->nama_paket }}">{{ $harga->nama_paket }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Jenis Layanan</label>
                    <select name="layanan" x-model="layanan" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs md:text-sm font-semibold text-gray-900 focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all cursor-pointer">
                        @forelse($firstKontenArray as $kategori)
                            <optgroup label="{{ $kategori['nama_kategori'] ?? '' }}">
                                @if(isset($kategori['items']))
                                    @foreach($kategori['items'] as $item)
                                        <option value="{{ $item['nama_item'] ?? '' }}">{{ $item['nama_item'] ?? '' }}</option>
                                    @endforeach
                                @endif
                            </optgroup>
                        @empty
                            <optgroup label="Kiloan (Default)">
                                <option value="Cuci Kering Setrika">Cuci Kering Setrika</option>
                                <option value="Cuci Kering Lipat">Cuci Kering Lipat</option>
                            </optgroup>
                        @endforelse
                    </select>
                </div>
            </div>

            <!-- Smart Logic: Berat & Jumlah Item -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Berat (Kg)</label>
                    <input name="berat" x-model="berat" type="number" step="0.1" min="0.1" :disabled="isSatuan()" :required="!isSatuan()" placeholder="0"
                           class="w-full border rounded-xl px-3 py-2.5 text-xs md:text-sm font-semibold outline-none transition-all focus:ring-4" :class="isSatuan() ? 'bg-gray-100 border-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-50 border-gray-200 text-gray-900 focus:bg-white focus:border-[#559dd4] focus:ring-[#559dd4]/20'">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Jumlah Item (Pcs)</label>
                    <input name="itemSatuan" x-model="itemSatuan" type="number" min="1" :disabled="!isSatuan()" :required="isSatuan()" placeholder="1"
                           class="w-full border rounded-xl px-3 py-2.5 text-xs md:text-sm font-semibold outline-none transition-all focus:ring-4" :class="!isSatuan() ? 'bg-gray-100 border-gray-100 text-gray-400 cursor-not-allowed' : 'bg-gray-50 border-gray-200 text-gray-900 focus:bg-white focus:border-[#559dd4] focus:ring-[#559dd4]/20'">
                </div>
            </div>

            <!-- Catatan Pelanggan -->
            <div>
                <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Catatan</label>
                <textarea name="catatan" rows="2" placeholder="Contoh: Kantong enji, pakaian putih pisah..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs md:text-sm font-medium text-gray-900 placeholder-gray-400 focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all resize-none"></textarea>
            </div>

            <!-- Harga & Pembayaran (Sisi Kiri Bawah) -->
            <div class="mt-3 pt-4 lg:mt-4 lg:pt-4 border-t border-gray-100 flex justify-between items-center gap-4">
                <div>
                    <p class="text-[11px] md:text-xs font-bold text-gray-400 tracking-wide mb-0.5">Total Estimasi Harga</p>
                    <p class="text-xl md:text-2xl font-bold text-[#559dd4]" x-text="totalHarga"></p>
                    <input type="hidden" name="total_estimasi" :value="totalHargaInt">
                </div>
                <div class="min-w-[130px] md:min-w-[150px]">
                    <label class="block text-[11px] font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Pembayaran</label>
                    <select name="pembayaran" class="w-full bg-[#559dd4]/10 border border-[#559dd4]/30 text-[#3b7ba8] rounded-xl px-3 py-2.5 text-xs md:text-sm font-bold focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all cursor-pointer">
                        <option value="Cash">Cash</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Logistik & Waktu -->
        <div class="flex flex-col space-y-3 lg:space-y-3 shadow-sm md:shadow-none bg-gray-50/30 md:bg-transparent">
            <h3 class="text-sm md:text-base font-semibold text-gray-800 border-l-4 border-[#559dd4] pl-3 mb-1">Logistik Pengiriman</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1">Pengiriman</label>
                    <select name="pengiriman" x-model="pengiriman" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs md:text-sm font-semibold text-gray-900 focus:bg-white focus:border-[#559dd4] focus:ring-4 focus:ring-[#559dd4]/20 outline-none transition-all cursor-pointer">
                        <option value="Antar Sendiri">Antar ke Outlet</option>
                        <option value="Pickup">Kurir Jemput</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 tracking-wide mb-1.5 pl-1" x-text="pengiriman === 'Antar Sendiri' ? '-' : 'Jam Pickup'"></label>
                    <select name="jam" x-model="jamPicked" class="w-full border rounded-xl px-3 py-2.5 text-xs md:text-sm font-bold outline-none transition-all focus:ring-4" :disabled="pengiriman === 'Antar Sendiri'" :class="pengiriman === 'Antar Sendiri' ? 'bg-gray-100 border-gray-100 text-gray-400 cursor-not-allowed' : (showPickupWarning && !jamPicked ? 'bg-red-50 border-red-300 text-gray-900 focus:bg-white focus:border-red-400 focus:ring-red-200/50 cursor-pointer' : 'bg-gray-50 border-gray-200 text-gray-900 focus:bg-white focus:border-[#559dd4] focus:ring-[#559dd4]/20 cursor-pointer')">
                        <option value="" disabled selected>Pilih Jam...</option>
                        @forelse($jamPickups as $jam)
                            <option value="{{ $jam }}">{{ $jam }}</option>
                        @empty
                            <option value="08.00 - 08.30">08.00 - 08.30 (Default)</option>
                            <option value="08.30 - 09.00">08.30 - 09.00 (Default)</option>
                            <option value="09.00 - 09.30">09.00 - 09.30 (Default)</option>
                            <option value="09.30 - 10.00">09.30 - 10.00 (Default)</option>
                        @endforelse
                    </select>
                    <p x-show="showPickupWarning && !jamPicked" x-transition class="text-[10px] font-semibold text-red-500 mt-1 pl-1">⚠ Pilih jam pickup</p>
                </div>
            </div>

            <!-- Smart Logic: Area Alamat Fleksibel -->
            <div class="flex-grow w-full relative">
                
                <div x-show="pengiriman === 'Antar Sendiri'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="w-full h-full bg-gray-50 border border-gray-100 rounded-xl p-4 md:p-5 flex flex-col justify-center">
                    <p class="text-[11px] md:text-xs font-bold text-gray-500 tracking-wide mb-3">Lokasi Outlet Kami</p>
                    <div class="flex items-start gap-4 mb-3">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-[0_2px_10px_rgba(0,0,0,0.06)] shrink-0 text-lg">📍</div>
                        <div class="flex flex-col justify-center flex-1">
                            <p class="text-xs md:text-sm font-semibold text-gray-800 leading-snug">{{ $kontak->alamat ?? 'Jl. Laundry No. 123, Blok A' }}</p>
                            <p class="text-[11px] md:text-xs text-gray-500 mt-1">Silakan bawa pesanan ke outlet kami.</p>
                        </div>
                    </div>
                    @if($kontak->url_gmaps ?? false)
                        <div class="w-full h-[180px] rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                            <iframe src="{{ $kontak->url_gmaps }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                        </div>
                    @endif
                </div>
                
                <!-- Link Leaflet CSS & JS -->
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
                <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

                <div x-show="pengiriman === 'Pickup'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="h-full w-full flex flex-col relative" 
                     x-data="{ 
                        showMap: false, 
                        locationPinned: false, 
                        map: null, 
                        marker: null,
                        lat: -6.200000,
                        lng: 106.816666,
                        initMap() {
                            if(this.map) {
                                setTimeout(() => this.map.invalidateSize(), 200);
                                return;
                            }
                            this.map = L.map('pickup-map').setView([this.lat, this.lng], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; OpenStreetMap'
                            }).addTo(this.map);
                            
                            this.marker = L.marker([this.lat, this.lng], {draggable: true}).addTo(this.map);
                            
                            this.marker.on('dragend', (e) => {
                                const pos = e.target.getLatLng();
                                this.lat = pos.lat;
                                this.lng = pos.lng;
                            });

                            this.map.on('click', (e) => {
                                this.marker.setLatLng(e.latlng);
                                this.lat = e.latlng.lat;
                                this.lng = e.latlng.lng;
                            });
                        }
                     }" 
                     x-init="$watch('locationPinned', val => { pickupLocationReady = val; }); $watch('showMap', value => { if(value) { setTimeout(() => initMap(), 100); } })">
                    
                    <input type="hidden" name="pickup_lat" :value="lat">
                    <input type="hidden" name="pickup_lng" :value="lng">

                    <div class="flex items-center justify-between mb-1.5 text-[#559dd4] pl-1">
                        <label class="block text-xs font-bold text-gray-500 tracking-wide flex items-center gap-1.5">
                            Alamat Penjemputan
                        </label>
                        <button type="button" @click="showMap = !showMap" class="bg-[#559dd4]/10 hover:bg-[#559dd4]/20 text-[#4a8bc0] px-3 py-1 rounded-full text-[10px] md:text-xs font-bold flex items-center gap-1 transition border border-[#559dd4]/30" x-text="showMap ? 'Tutup Peta' : '📍 Buka Peta'"></button>
                    </div>
                    
                    <textarea name="detail_alamat" x-show="!showMap" rows="3" @input="pickupLocationReady = $el.value.trim().length > 0 || locationPinned" class="w-full h-[100px] bg-gray-50 px-3 py-2.5 rounded-xl border text-xs md:text-sm outline-none resize-none font-medium placeholder-gray-400 text-gray-900 focus:bg-white focus:ring-4 transition" :class="showPickupWarning && !pickupLocationReady ? 'border-red-300 focus:border-red-400 focus:ring-red-200/50' : 'border-gray-200 focus:border-[#559dd4] focus:ring-[#559dd4]/20'" placeholder="Ketikan detail jalan atau patokan rumah..."></textarea>
                    <p x-show="showPickupWarning && !pickupLocationReady && !showMap" x-transition class="text-[10px] font-semibold text-red-500 mt-1 pl-1">⚠ Isi alamat dan pilih titik di peta</p>
                    
                    <!-- Peta Interaktif Leaflet UI -->
                    <div x-show="showMap" style="display: none;" class="w-full h-[320px] rounded-xl overflow-hidden relative border border-[#559dd4]/30 mt-1">
                        <div id="pickup-map" class="absolute inset-0 z-0 bg-gray-100"></div>
                        <div class="absolute bottom-3 left-0 right-0 flex justify-center z-[1000] pointer-events-none">
                            <button type="button" @click="locationPinned = true; showMap = false" class="pointer-events-auto bg-gray-900 text-white text-[10px] md:text-xs font-black px-5 md:px-6 py-2.5 rounded-full shadow-lg hover:bg-[#559dd4] transition border hover:border-white flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Pilih Titik Ini
                            </button>
                        </div>
                    </div>

                    <!-- Indikator Pin Tersimpan -->
                    <div x-show="locationPinned && !showMap" style="display: none;" class="mt-2 flex items-center justify-between bg-emerald-50/50 px-4 py-3 rounded-xl border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse shrink-0"></div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-emerald-700 leading-tight">Titik Peta Disimpan</span>
                                <span class="text-[10px] font-medium text-emerald-600/80 mt-0.5" x-text="lat.toFixed(4) + ', ' + lng.toFixed(4)"></span>
                            </div>
                        </div>
                        <button type="button" @click="locationPinned = false" class="text-emerald-600/40 hover:text-emerald-700 p-2 bg-emerald-100/50 hover:bg-emerald-200 rounded-full transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Peringatan Pickup Belum Lengkap -->
            <div x-show="showPickupWarning" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="mt-2 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-amber-800">Lengkapi data pickup</p>
                    <p class="text-[10px] text-amber-600 mt-0.5">Pilih jam pickup dan isi alamat & tandai lokasi di peta sebelum melanjutkan.</p>
                </div>
                <button type="button" @click="showPickupWarning = false" class="ml-auto text-amber-400 hover:text-amber-600 shrink-0 p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Tombol Utama Super Kontras -->
            <button type="submit" class="w-full mt-4 md:mt-auto bg-[#559dd4] hover:bg-[#4a8bc0] text-white font-black py-4 border border-[#4a8bc0] rounded-2xl md:rounded-[20px] transition-all duration-300 uppercase tracking-[0.2em] text-xs md:text-sm hover:shadow-[0_12px_24px_rgba(85,157,212,0.3)] hover:-translate-y-1 flex items-center justify-center gap-3">
                <span>Laundry Sekarang</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

    </form>
</div>