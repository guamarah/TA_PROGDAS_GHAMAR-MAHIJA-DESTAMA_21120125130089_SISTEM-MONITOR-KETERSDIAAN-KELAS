<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center space-x-4">
            {{-- Tampilkan nama user --}}
            <div>
                <p class="text-lg font-medium">{{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
            </div>

            

        {{-- Tombol Sign Out dihapus --}}
    </x-filament::section>
</x-filament-widgets::widget>
