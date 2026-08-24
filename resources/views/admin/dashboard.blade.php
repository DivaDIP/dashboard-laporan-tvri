<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TVRI Bengkulu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <!-- Navbar -->
    <nav class="bg-[#003366] text-white px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-3">
            <span class="font-bold text-lg tracking-wide">Panel Monitoring Admin Pokjawas</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium">{{ Auth::user()->name }} (Admin)</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold transition">Logout</button>
            </form>
        </div>
    </nav>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Cards Statistik Quick-View -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Laporan -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Laporan Masuk</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalReports }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#003366] flex items-center justify-center font-bold text-lg">
                    📊
                </div>
            </div>

            <!-- Laporan Selesai -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Laporan Selesai</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $statusSelesai }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                    ✅
                </div>
            </div>

            <!-- Dalam Proses -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Dalam Proses</p>
                    <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $statusProses }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-lg">
                    ⏳
                </div>
            </div>

            <!-- Ada Kendala -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Ada Kendala</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $statusKendala }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center font-bold text-lg">
                    ⚠️
                </div>
            </div>
        </div>

        <!-- Header & Filter & Export Buttons -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Rekapitulasi Laporan Teknisi</h1>
                <p class="text-xs text-gray-500">Monitoring real-time pengerjaan staf lapangan TVRI Bengkulu</p>
            </div>

            <!-- Form Filter & Tombol Export -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2">
                <select name="asal_teknisi" class="text-xs border-gray-300 rounded-lg p-2 bg-gray-50 border focus:ring-[#003366] focus:border-[#003366]">
                    <option value="">Semua Bidang</option>
                    <option value="Teknisi Transmisi & Pemancar" {{ request('asal_teknisi') == 'Teknisi Transmisi & Pemancar' ? 'selected' : '' }}>Transmisi</option>
                    <option value="Teknisi Studio & Produksi" {{ request('asal_teknisi') == 'Teknisi Studio & Produksi' ? 'selected' : '' }}>Studio</option>
                    <option value="Teknisi IT & Jaringan" {{ request('asal_teknisi') == 'Teknisi IT & Jaringan' ? 'selected' : '' }}>IT & Jaringan</option>
                    <option value="Teknisi Sarpras & Kelistrikan" {{ request('asal_teknisi') == 'Teknisi Sarpras & Kelistrikan' ? 'selected' : '' }}>Sarpras (ME)</option>
                </select>

                <select name="status" class="text-xs border-gray-300 rounded-lg p-2 bg-gray-50 border focus:ring-[#003366] focus:border-[#003366]">
                    <option value="">Semua Status</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="Ada Kendala" {{ request('status') == 'Ada Kendala' ? 'selected' : '' }}>Ada Kendala</option>
                </select>

                <button type="submit" class="bg-[#003366] text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-900 transition">Filter</button>

                <!-- Tombol Export Excel & PDF (Otomatis Ikut Filter Aktif) -->
                <a href="{{ route('admin.reports.export.excel', request()->all()) }}" class="bg-emerald-600 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-emerald-700 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="bg-red-600 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-red-700 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Export PDF
                </a>
            </form>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Laporan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Tanggal & Waktu</th>
                        <th class="p-4">Teknisi / Pelapor</th>
                        <th class="p-4">Bidang & Lokasi</th>
                        <th class="p-4">Isi Kegiatan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50/50 transition" id="report-row-{{ $report->id }}" 
                            data-report="{{ json_encode([
                                'id' => $report->id,
                                'formatted_date' => $report->created_at->format('d F Y, H:i') . ' WIB',
                                'user_name' => $report->user->name ?? 'Staf Teknisi',
                                'asal_teknisi' => $report->asal_teknisi,
                                'lokasi' => $report->lokasi,
                                'isi_laporan' => $report->isi_laporan,
                                'status' => $report->status,
                                'foto' => $report->foto
                            ]) }}">
                            <td class="p-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $report->created_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="p-4 font-semibold text-gray-800 whitespace-nowrap">
                                {{ $report->user->name ?? 'Staf Teknisi' }}
                            </td>
                            <td class="p-4">
                                <span class="block text-xs font-bold text-[#003366]">{{ $report->asal_teknisi }}</span>
                                <span class="text-xs text-gray-500">{{ $report->lokasi }}</span>
                            </td>
                            <td class="p-4 max-w-xs truncate text-xs text-gray-600">
                                {{ $report->isi_laporan }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($report->status == 'Selesai')
                                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Selesai</span>
                                @elseif($report->status == 'Dalam Proses')
                                    <span class="bg-yellow-100 text-yellow-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Dalam Proses</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Ada Kendala</span>
                                @endif
                            </td>
                            <td class="p-4 text-center whitespace-nowrap space-x-2">
                                <button type="button" onclick="openReportModal({{ $report->id }})" 
                                    class="text-xs text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                    Detail
                                </button>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-bold hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 text-sm">Belum ada data laporan teknisi yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- Modal Pop-up Detail Laporan -->
    <div id="reportDetailModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden transform transition-all">
            <div class="bg-[#003366] text-white p-5 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">Detail Laporan Teknisi</h3>
                    <p class="text-xs text-blue-100 mt-0.5">Monitoring Kegiatan Lapangan</p>
                </div>
                <button type="button" onclick="closeReportModal()" class="text-white hover:text-gray-300 text-2xl font-bold leading-none">&times;</button>
            </div>

            <div class="p-6 space-y-5 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                        <span class="block text-gray-400 font-medium mb-1">Tanggal & Waktu</span>
                        <span id="modal_tanggal" class="font-bold text-gray-800 text-sm"></span>
                    </div>
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                        <span class="block text-gray-400 font-medium mb-1">Teknisi / Pelapor</span>
                        <span id="modal_teknisi" class="font-bold text-gray-800 text-sm"></span>
                    </div>
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                        <span class="block text-gray-400 font-medium mb-1">Bidang Teknisi</span>
                        <span id="modal_bidang" class="font-bold text-[#003366] text-sm"></span>
                    </div>
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100">
                        <span class="block text-gray-400 font-medium mb-1">Lokasi Pengerjaan</span>
                        <span id="modal_lokasi" class="font-bold text-gray-800 text-sm"></span>
                    </div>
                </div>

                <div>
                    <span class="block text-xs text-gray-400 font-medium mb-1.5">Tugas / Kegiatan Dikerjakan</span>
                    <div id="modal_isi" class="text-xs text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100 leading-relaxed whitespace-pre-line min-h-[80px]"></div>
                </div>

                <div id="modal_foto_container">
                    <span class="block text-xs text-gray-400 font-medium mb-2">Foto Bukti Lapangan</span>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 inline-block">
                        <a id="modal_foto_link" href="#" target="_blank" class="block group">
                            <img id="modal_foto" src="" alt="Foto Bukti" class="max-h-60 w-auto rounded-lg shadow-sm group-hover:opacity-90 transition">
                            <span class="text-[11px] text-blue-600 font-semibold mt-2 text-center block group-hover:underline">Klik untuk membuka gambar penuh ↗</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
                <button type="button" onclick="closeReportModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-xl text-xs transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Script JavaScript Modal -->
    <script>
        function openReportModal(reportId) {
            const modal = document.getElementById('reportDetailModal');
            const tableRow = document.getElementById('report-row-' + reportId);
            const data = JSON.parse(tableRow.getAttribute('data-report'));

            document.getElementById('modal_tanggal').innerText = data.formatted_date;
            document.getElementById('modal_teknisi').innerText = data.user_name;
            document.getElementById('modal_bidang').innerText = data.asal_teknisi;
            document.getElementById('modal_lokasi').innerText = data.lokasi;
            document.getElementById('modal_isi').innerText = data.isi_laporan;

            const photoEl = document.getElementById('modal_foto');
            const photoLinkEl = document.getElementById('modal_foto_link');
            const photoContainer = document.getElementById('modal_foto_container');

            if (data.foto) {
                photoEl.src = '/storage/' + data.foto;
                photoLinkEl.href = '/storage/' + data.foto;
                photoContainer.classList.remove('hidden');
            } else {
                photoContainer.classList.add('hidden');
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeReportModal() {
            const modal = document.getElementById('reportDetailModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.getElementById('reportDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportModal();
            }
        });
    </script>
</body>
</html>