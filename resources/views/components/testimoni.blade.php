<section id="testimoni" class="py-14 md:py-24 bg-white-200 overflow-hidden relative"
    x-data="{ 
        intervalR: null, 
        intervalL: null,
        
        init() {
            // Beri waktu sejenak agar DOM render sempurna sebelum hitung lebar
            this.$nextTick(() => {
                // Baris 2 (ke kiri) mulai dari tengah agar tidak mentok saat mundur
                this.$refs.barisL.scrollLeft = this.$refs.barisL.scrollWidth / 2;
                this.startAll();
            });
        },
        startAll() {
            // Baris Atas: Ke Kanan (Normal)
            this.intervalR = setInterval(() => {
                this.$refs.barisR.scrollLeft += 1;
                if (this.$refs.barisR.scrollLeft >= this.$refs.barisR.scrollWidth / 2) {
                    this.$refs.barisR.scrollLeft = 0;
                }
            }, 30);

            // Baris Bawah: Ke Kiri (Terbalik)
            this.intervalL = setInterval(() => {
                this.$refs.barisL.scrollLeft -= 1;
                if (this.$refs.barisL.scrollLeft <= 0) {
                    this.$refs.barisL.scrollLeft = this.$refs.barisL.scrollWidth / 2;
                }
            }, 30);
        },
        stopAll() {
            clearInterval(this.intervalR);
            clearInterval(this.intervalL);
        }
    }">
    
    <div class="container mx-auto relative z-10">
        <div class="text-center mb-12 px-5">
            <h2 class="text-xl md:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">Apa Kata Pelanggan?</h2>
            <p class="text-xs md:text-base text-gray-500">Kepuasan kamu adalah prioritas kami</p>
        </div>

        {{-- BARIS 1: Gerak ke Kanan --}}
        <div class="mb-6 relative">
            <div x-ref="barisR" 
                 @mouseenter="stopAll()" @mouseleave="startAll()"
                 class="flex overflow-x-auto gap-6 scrollbar-hide px-5">
                {{-- Kita bagi data testimoninya agar tidak menumpuk semua --}}
                @foreach($testimonis as $item)
                    @include('components.testimoni-card', ['item' => $item])
                @endforeach
                {{-- Duplikat untuk loop --}}
                @foreach($testimonis as $item)
                    @include('components.testimoni-card', ['item' => $item])
                @endforeach
            </div>
        </div>

        {{-- BARIS 2: Gerak ke Kiri --}}
        <div class="relative">
            <div x-ref="barisL" 
                 @mouseenter="stopAll()" @mouseleave="startAll()"
                 class="flex overflow-x-auto gap-6 scrollbar-hide px-5">
                {{-- Gunakan data yang sama atau dibalik urutannya --}}
                @foreach($testimonis->reverse() as $item)
                    @include('components.testimoni-card', ['item' => $item])
                @endforeach
                {{-- Duplikat untuk loop --}}
                @foreach($testimonis->reverse() as $item)
                    @include('components.testimoni-card', ['item' => $item])
                @endforeach
            </div>
        </div>
    </div>
</section>