<form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
    <div class="md:col-span-2 text-center mb-2">
        <p class="text-xs md:text-sm text-gray-500 font-medium">Lengkapi data untuk penjemputan</p>
    </div>

    <div class="md:col-span-2">
        <label class="block text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
        <input type="text" name="nama" placeholder="Nama kamu" 
               class="w-full p-3 md:p-4 rounded-xl md:rounded-2xl bg-gray-50 border border-gray-100 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition text-sm">
    </div>

    <div class="col-span-1">
        <label class="block text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-widest mb-1">WhatsApp</label>
        <input type="number" name="wa" placeholder="08..." 
               class="w-full p-3 md:p-4 rounded-xl md:rounded-2xl bg-gray-50 border border-gray-100 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition text-sm">
    </div>

    <div class="col-span-1">
        <label class="block text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Layanan</label>
        <select name="layanan" 
                class="w-full p-3 md:p-4 rounded-xl md:rounded-2xl bg-gray-50 border border-gray-100 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition text-sm cursor-pointer">
            <option>Cuci Komplit</option>
            <option>Cuci Kering</option>
            <option>Setrika Saja</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-[10px] md:text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Alamat Jemput</label>
        <textarea name="alamat" rows="2" placeholder="Nama Kos / No Rumah" 
                  class="w-full p-3 md:p-4 rounded-xl md:rounded-2xl bg-gray-50 border border-gray-100 focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition text-sm"></textarea>
    </div>

    <div class="md:col-span-2 mt-2">
        <button type="submit" 
                class="w-full bg-blue-600 text-white font-extrabold py-3.5 md:py-5 rounded-xl md:rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 active:scale-95 transition duration-300 text-sm md:text-base">
            🚀 Kirim Pesanan
        </button>
        <p class="text-[9px] md:text-[11px] text-center text-gray-400 mt-3">Data akan langsung dikirim ke WhatsApp Admin</p>
    </div>
</form>