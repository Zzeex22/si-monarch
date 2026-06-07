<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Proyek') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 mb-2">
                                    {{ $project->contract->nomor_kontrak ?? 'No Kontrak' }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 line-clamp-1" title="{{ $project->nama_proyek }}">
                                    {{ $project->nama_proyek }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Klien: {{ $project->contract->nama_klien ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progres Pekerjaan</span>
                                <span class="text-sm font-bold {{ $project->persentase == 100 ? 'text-green-600 dark:text-green-400' : 'text-blue-600 dark:text-blue-400' }}">{{ $project->persentase }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="{{ $project->persentase == 100 ? 'bg-green-600' : 'bg-blue-600' }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $project->persentase }}%"></div>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                Mulai: {{ \Carbon\Carbon::parse($project->contract->tgl_mulai)->format('d/m/Y') }}
                            </div>
                            <a href="{{ route('proyek.show', $project->id) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition">
                                Lihat Detail &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white dark:bg-gray-800 p-8 text-center rounded-xl border border-gray-200 dark:border-gray-700">
                    <p class="text-gray-500 dark:text-gray-400">Belum ada proyek yang berjalan lek. Buat kontrak baru dulu supaya proyek otomatis terbuat.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>