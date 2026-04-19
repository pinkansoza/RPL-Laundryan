<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    <style>
        .custom-card {
            background-color: #fff;
            border: 1px solid #e5e7eb;
        }
        .custom-text-main { color: #111827; }
        .custom-text-sub { color: #6b7280; }

        .dark .custom-card {
            background-color: #18181b; /* gray-900 */
            border-color: rgba(255, 255, 255, 0.1);
        }
        .dark .custom-text-main { color: #fff; }
        .dark .custom-text-sub { color: #9ca3af; }
    </style>

    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-top: 1.5rem;">
        <!-- Card Pendapatan -->
        <div class="custom-card" style="flex: 1; min-width: 250px; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.75rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; background-color: rgba(22, 163, 74, 0.1); color: #16a34a;">
                    <x-heroicon-o-arrow-trending-up style="width: 32px; height: 32px;" stroke-width="2" />
                </div>
                <div>
                    <h3 class="custom-text-sub" style="font-size: 0.875rem; font-weight: 500; margin: 0;">Uang Masuk (Lunas)</h3>
                    <p class="custom-text-main" style="font-size: 1.5rem; font-weight: 700; margin: 0;">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Card Pengeluaran -->
        <div class="custom-card" style="flex: 1; min-width: 250px; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.75rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; background-color: rgba(220, 38, 38, 0.1); color: #dc2626;">
                    <x-heroicon-o-arrow-trending-down style="width: 32px; height: 32px;" stroke-width="2" />
                </div>
                <div>
                    <h3 class="custom-text-sub" style="font-size: 0.875rem; font-weight: 500; margin: 0;">Uang Keluar</h3>
                    <p class="custom-text-main" style="font-size: 1.5rem; font-weight: 700; margin: 0;">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Card Pendapatan Bersih -->
        <div class="custom-card" style="flex: 1; min-width: 250px; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.75rem; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; background-color: rgba(37, 99, 235, 0.1); color: #2563eb;">
                    <x-heroicon-o-currency-dollar style="width: 32px; height: 32px;" stroke-width="2" />
                </div>
                <div>
                    <h3 class="custom-text-sub" style="font-size: 0.875rem; font-weight: 500; margin: 0;">Pendapatan Bersih</h3>
                    <p style="font-size: 1.5rem; font-weight: 700; margin: 0; color: {{ $bersih >= 0 ? '#16a34a' : '#dc2626' }};">
                        Rp {{ number_format($bersih, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Component -->
    <div style="margin-top: 1.5rem;">
        @livewire(\App\Livewire\GrafikKeuangan::class, ['dari' => $dari_tanggal, 'sampai' => $sampai_tanggal], key(str()->random()))
    </div>
</x-filament-panels::page>
