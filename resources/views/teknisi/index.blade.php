<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan Saya - TVRI Bengkulu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-tvri.svg') }}">
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 min-h-screen">

    <!-- Navbar -->
<nav class="bg-[#003366] text-white px-6 py-4 flex justify-between items-center shadow-md">
    <div class="flex items-center space-x-6">
        <span class="font-bold text-lg tracking-wide">Staf Teknisi TVRI</span>
        <div class="space-x-4 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="text-blue-200 hover:text-white transition">Form Input</a>
            <a href="{{ route('reports.my') }}" class="text-white font-bold border-b-2 border-white pb-1">Riwayat Saya</a>
        </div>
    </div>
    <div class="flex items-center space-x-4">
        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold transition">Logout</button>
        </form>
    </div>
</nav>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Filter -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Laporan Saya</h1>
                <p class="text-xs text-gray-500 mt-1">Daftar seluruh laporan kegiatan lapangan yang telah Anda kirimkan.</p>
            </div>
            
            <a href="{{ route('reports.create') }}" class="inline-flex items-center justify-center bg-[#003366] text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-blue-900 transition shadow-sm">
                + Tambah Laporan Baru
            </a>
        </div>

        <!-- Filter Bar Sederhana -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('reports.my') }}" class="flex flex-wrap items-center gap-3">
                <div class="w-full sm:w-auto">
                    <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg p-2.5 bg-gray-50 border focus:ring-1 focus:ring-[#003366]">
                        <option value="">-- Semua Status --</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="Ada Kendala" {{ request('status') == 'Ada Kendala' ? 'selected' : '' }}>Ada Kendala</option>
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()" class="text-xs border-gray-300 rounded-lg p-2 bg-gray-50 border focus:ring-1 focus:ring-[#003366]">
                </div>
                @if(request('status') || request('tanggal'))
                    <a href="{{ route('reports.my') }}" class="text-xs text-red-600 font-semibold hover:underline">Reset Filter</a>
                @endif
            </form>
        </div>

        <!-- Tabel Riwayat -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-50 text-gray-600 uppercase font-bold border-b border-gray-100">
                        <tr>
                            <th class="py-3.5 px-4">Tanggal & Waktu</th>
                            <th class="py-3.5 px-4">Bidang</th>
                            <th class="py-3.5 px-4">Lokasi</th>
                            <th class="py-3.5 px-4">Isi Kegiatan</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-center">Foto Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3.5 px-4 text-gray-500 whitespace-nowrap">
                                    {{ $report->created_at->format('d M Y, H:i') }} WIB
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-800 whitespace-nowrap">
                                    {{ $report->asal_teknisi }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-600">
                                    {{ $report->lokasi }}
                                </td>
                                <td class="py-3.5 px-4 text-gray-700 max-w-xs truncate">
                                    {{ $report->isi_laporan }}
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($report->status == 'Selesai')
                                        <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Selesai</span>
                                    @elseif($report->status == 'Dalam Proses')
                                        <span class="bg-yellow-100 text-yellow-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Dalam Proses</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Ada Kendala</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($report->foto)
                                        <a href="{{ asset('storage/' . $report->foto) }}" target="_blank" class="text-blue-600 hover:underline font-semibold">Lihat Foto</a>
                                    @else
                                        <span class="text-gray-400 font-normal">Tanpa Foto</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    Belum ada riwayat laporan dikirim.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            @if($reports->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>