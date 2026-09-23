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

    <!-- Navbar Utama -->
    <nav class="bg-[#003366] text-white px-4 sm:px-6 py-4 shadow-md relative z-40">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <!-- Logo / Judul Kiri -->
            <span class="font-bold text-xs sm:text-base md:text-lg tracking-wide truncate pr-2">Laporan Staff Penyiaran & Produksi</span>
            
            <!-- Tombol Hamburger (Hanya tampil di Mobile) -->
            <button id="menu-btn" class="md:hidden text-white focus:outline-none p-1 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Menu Desktop (Tampil normal di layar besar) -->
            <div class="hidden md:flex items-center space-x-6">
                <div class="flex items-center space-x-4 text-sm font-medium">
                    <a href="{{ route('dashboard') }}" class="text-blue-200 hover:text-white transition">Form Input</a>
                    <a href="{{ route('reports.my') }}" class="text-white font-bold border-b-2 border-white pb-1">Riwayat Saya</a>
                </div>
                <div class="flex items-center space-x-4 border-l border-blue-800 pl-6">
                    <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold transition">Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </nav>

    <!-- Overlay Gelap di Belakang Sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity opacity-0"></div>

    <!-- Panel Sidebar Mobile (Geser dari Samping) -->
    <div id="mobile-sidebar" class="fixed top-0 left-0 bottom-0 w-4/5 max-w-xs bg-white text-gray-900 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-2xl">
        
        <!-- Bagian Atas Sidebar -->
        <div>
            <!-- Header Sidebar (Tombol Close & Judul/Logo) -->
            <div class="p-5 flex justify-between items-center border-b border-gray-100">
                <span class="font-bold text-sm text-[#003366] tracking-wide">Menu Navigasi</span>
                <button id="close-btn" class="text-gray-500 hover:text-gray-800 text-2xl font-bold leading-none p-1 focus:outline-none">&times;</button>
            </div>

            <!-- Daftar Link Menu -->
            <div class="flex flex-col py-2">
                <a href="{{ route('dashboard') }}" class="px-6 py-3.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">Form Input</a>
                <a href="{{ route('reports.my') }}" class="px-6 py-3.5 text-sm font-bold text-[#003366] bg-blue-50/50 border-l-4 border-[#003366]">Riwayat Saya</a>
            </div>
        </div>

        <!-- Bagian Bawah Sidebar (Info User & Logout) -->
        <div class="p-5 border-t border-gray-100 bg-gray-50 space-y-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-[#003366] text-white flex items-center justify-center font-bold text-xs shrink-0">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <span class="block text-xs font-bold text-gray-800 truncate">{{ Auth::user()->name }}</span>
                    <span class="block text-[11px] text-gray-400">Staf Penyiaran</span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition shadow-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Konten Utama Riwayat -->
    <div class="py-6 sm:py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Riwayat Laporan Saya</h1>
                <p class="text-xs text-gray-500 mt-1">Daftar seluruh laporan kegiatan lapangan yang telah Anda kirimkan.</p>
            </div>
            
            <a href="{{ route('reports.create') }}" class="inline-flex items-center justify-center bg-[#003366] text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-blue-900 transition shadow-sm shrink-0">
                + Tambah Laporan Baru
            </a>
        </div>

        <!-- Filter Bar Responsif -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('reports.my') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="w-full sm:w-auto">
                    <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto text-xs border-gray-300 rounded-lg p-2.5 bg-gray-50 border focus:ring-1 focus:ring-[#003366]">
                        <option value="">-- Semua Status --</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="Ada Kendala" {{ request('status') == 'Ada Kendala' ? 'selected' : '' }}>Ada Kendala</option>
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()" class="w-full sm:w-auto text-xs border-gray-300 rounded-lg p-2.5 bg-gray-50 border focus:ring-1 focus:ring-[#003366]">
                </div>
                @if(request('status') || request('tanggal'))
                    <div>
                        <a href="{{ route('reports.my') }}" class="inline-block text-xs text-red-600 font-semibold hover:underline py-1">Reset Filter</a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Bagian Tabel & Card Responsif -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <!-- Tampilan Tabel untuk Layar Medium ke Atas (md+) -->
            <div class="hidden md:block overflow-x-auto">
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

            <!-- Tampilan Card Khusus untuk Layar HP / Mobile (< md) agar mudah dibaca -->
            <div class="block md:hidden divide-y divide-gray-100">
                @forelse($reports as $report)
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <span class="text-[11px] text-gray-400 block">{{ $report->created_at->format('d M Y, H:i') }} WIB</span>
                                <span class="font-bold text-sm text-gray-800">{{ $report->asal_teknisi }}</span>
                            </div>
                            <div>
                                @if($report->status == 'Selesai')
                                    <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Selesai</span>
                                @elseif($report->status == 'Dalam Proses')
                                    <span class="bg-yellow-100 text-yellow-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Dalam Proses</span>
                                @else
                                    <span class="bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-full text-[10px]">Ada Kendala</span>
                                @endif
                            </div>
                        </div>

                        <div class="text-xs space-y-1 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <p><strong class="text-gray-600">Lokasi:</strong> {{ $report->lokasi }}</p>
                            <p><strong class="text-gray-600">Kegiatan:</strong> {{ $report->isi_laporan }}</p>
                        </div>

                        <div class="flex justify-between items-center pt-1 text-xs">
                            @if($report->foto)
                                <a href="{{ asset('storage/' . $report->foto) }}" target="_blank" class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                    🖼️ Lihat Foto Bukti
                                </a>
                            @else
                                <span class="text-gray-400">Tanpa Foto</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-gray-400 text-xs">
                        Belum ada riwayat laporan dikirim.
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            @if($reports->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Script JavaScript untuk Animasi Sidebar Overlay -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const closeBtn = document.getElementById('close-btn');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            mobileSidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            setTimeout(() => sidebarOverlay.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            mobileSidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('opacity-0');
            setTimeout(() => {
                sidebarOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        }

        if(menuBtn) menuBtn.addEventListener('click', openSidebar);
        if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if(sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>