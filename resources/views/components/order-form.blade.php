<div x-data="{ 
        // State Utama
        paket: 'Reguler', 
        layanan: 'Cuci Kering Setrika', 
        pengiriman: 'Antar Sendiri', 
        berat: 0,
        itemSatuan: 1,

        // Data Harga (Sesuai List Kamu)
        prices: {
            'Reguler': { 'Cuci Kering Setrika': 6000, 'Cuci Kering Lipat': 4000, 'Setrika Saja': 3000, 'Bedcover': 30000, 'Selimut': 20000, 'Sprei': 15000 },
            'Kilat': { 'Cuci Kering Setrika': 8000, 'Cu kering Lipat': 6000, 'Setrika Saja': 5000, 'Bedcover': 40000, 'Selimut': 30000, 'Sprei': 20000 },
            'Express': { 'Cuci Kering Setrika': 12000, 'Cuci Kering Lipat': 10000, 'Setrika Saja': 8000, 'Bedcover': 55000, 'Selimut': 45000, 'Sprei': 30000 }
        },

        // Helper untuk cek tipe layanan
        isSatuan() {
            return ['Bedcover', 'Selimut', 'Sprei'].includes(this.layanan);
        },

        // Kalkulasi Real-time
        get totalHarga() {
            let hargaDasar = this.prices[this.paket][this.layanan] || 0;
            let total = this.isSatuan() ? (hargaDasar * this.itemSatuan) : (hargaDasar * this.berat);
            return total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : 'Rp 0';
        }
    }" class="max-w-5xl mx-auto p-6 bg-white rounded-3xl shadow-2xl shadow-blue-100">

    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
        
        <div class="space-y-6">
            <h3 class="text-xs font-black text-[#559dd4] uppercase tracking-[0.2em] mb-4">01. Data & Layanan</h3>
            
            <div class="border-b border-gray-100 focus-within:border-[#559dd4] transition duration-300">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Tulis nama..." class="w-full py-2 bg-transparent outline-none text-sm text-gray-900">
            </div>

            <div class="border-b border-gray-100 focus-within:border-[#559dd4] transition duration-300">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">WhatsApp</label>
                <input type="number" name="wa" placeholder="08..." class="w-full py-2 bg-transparent outline-none text-sm text-gray-900">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="border-b border-gray-100 focus-within:border-[#559dd4] transition duration-300">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Paket Kecepatan</label>
                    <select x-model="paket" class="w-full py-2 bg-transparent outline-none text-sm text-gray-900 font-bold">
                        <option value="Reguler">Reguler (3 Hari)</option>
                        <option value="Kilat">Kilat (2 Hari)</option>
                        <option value="Express">Express (1 Hari)</option>
                    </select>
                </div>
                <div class="border-b border-gray-100 focus-within:border-[#559dd4] transition duration-300">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis Layanan</label>
                    <select x-model="layanan" class="w-full py-2 bg-transparent outline-none text-sm text-gray-900 font-bold">
                        <optgroup label="Kiloan">
                            <option value="Cuci Kering Setrika">Cuci Kering Setrika</option>
                            <option value="Cuci Kering Lipat">Cuci Kering Lipat</option>
                            <option value="Setrika Saja">Setrika Saja</option>
                        </optgroup>
                        <optgroup label="Satuan">
                            <option value="Bedcover">Bedcover</option>
                            <option value="Selimut">Selimut</option>
                            <option value="Sprei">Sprei</option>
                        </optgroup>
                    </select>
                </div>
            </div>

            <div class="border-b border-gray-100 transition duration-300 focus-within:border-[#559dd4]">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1" 
                       x-text="isSatuan() ? 'Jumlah Item (Pcs)' : 'Estimasi Berat (Kg)'"></label>
                <input x-model="isSatuan() ? itemSatuan : berat" type="number" 
                       class="w-full py-2 bg-transparent outline-none text-sm text-gray-900 font-bold">
            </div>
        </div>

        <div class="space-y-6">
            <h3 class="text-xs font-black text-[#559dd4] uppercase tracking-[0.2em] mb-4">02. Logistik & Waktu</h3>

            <div class="border-b border-gray-100 focus-within:border-[#559dd4] transition duration-300">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Metode Pengiriman</label>
                <select x-model="pengiriman" class="w-full py-2 bg-transparent outline-none text-sm text-gray-900 font-bold">
                    <option value="Antar Sendiri">Antar Sendiri ke Outlet</option>
                    <option value="Pickup">Pickup (Kurir Jemput)</option>
                </select>
            </div>

            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 min-h-[120px]">
                <template x-if="pengiriman === 'Antar Sendiri'">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Lokasi Outlet Kami</p>
                        <p class="text-xs text-gray-600 leading-relaxed">📍 Jl. Laundry No. 123, Blok A (Dekat Indomaret).<br>Buka 08:00 - 21:00</p>
                    </div>
                </template>
                <template x-if="pengiriman === 'Pickup'">
                    <div>
                        <label class="block text-[10px] font-black text-[#559dd4] uppercase mb-2">Alamat Lengkap Penjemputan</label>
                        <textarea rows="3" class="w-full bg-transparent text-xs outline-none resize-none" placeholder="Contoh: Perum Indah No. 4, Belakang Satpam..."></textarea>
                    </div>
                </template>
            </div>

            <div class="border-b border-gray-100 focus-within:border-[#559dd4] transition duration-300">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jam Jemput / Antar</label>
                <input type="time" class="w-full py-2 bg-transparent outline-none text-sm text-gray-900">
            </div>
        </div>

        <div class="md:col-span-2 flex flex-col md:flex-row justify-between items-center bg-gray-50 p-6 rounded-2xl mt-4 gap-6">
            <div class="flex gap-8">
                <div class="text-center md:text-left">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Estimasi</p>
                    <p class="text-3xl font-black text-gray-900" x-text="totalHarga"></p>
                </div>
                <div class="text-center md:text-left border-l pl-8 border-gray-200">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Metode Bayar</p>
                    <p class="text-sm font-bold text-gray-600">Cash / QRIS</p>
                </div>
            </div>
            
            <button type="submit" class="w-full md:w-auto px-12 bg-gray-900 text-white font-black py-4 rounded-xl hover:bg-[#559dd4] transition-all duration-300 uppercase tracking-widest text-xs shadow-lg shadow-gray-200">
                Laundry Sekarang 🚀
            </button>
        </div>
    </form>
</div>