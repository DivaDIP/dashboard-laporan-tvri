<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TVRI Bengkulu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- icon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-tvri.svg') }}">
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <!-- ========================================== -->
    <!-- SECTION: NAVBAR (HEADER UTAMA) -->
    <!-- ========================================== -->
    <nav class="bg-[#003366] text-white px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-3">
            <span class="font-bold text-lg tracking-wide">Monitoring Teknik Produksi & Penyiaran</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <!-- BUTTON: LOGOUT -->
                <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold transition">Logout</button>
            </form>
        </div>
    </nav>

    <!-- CONTAINER UTAMA -->
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- ========================================== -->
        <!-- SECTION: STATISTIK / QUICK-VIEW CARDS -->
        <!-- ========================================== -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- CARD: TOTAL LAPORAN -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Total Laporan Masuk</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalReports }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#003366] flex items-center justify-center font-bold text-lg">
                    📊
                </div>
            </div>

            <!-- CARD: LAPORAN SELESAI -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Laporan Selesai</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $statusSelesai }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                    ✅
                </div>
            </div>

            <!-- CARD: DALAM PROSES -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500">Dalam Proses</p>
                    <h3 class="text-2xl font-bold text-amber-500 mt-1">{{ $statusProses }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-lg">
                    ⏳
                </div>
            </div>

            <!-- CARD: ADA KENDALA -->
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

        <!-- ========================================== -->
        <!-- SECTION: FILTER, ACTION BUTTONS & HEADER DASHBOARD -->
        <!-- ========================================== -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Rekapitulasi Laporan Teknisi</h1>
                <p class="text-xs text-gray-500">Monitoring real-time pengerjaan staf lapangan TVRI Bengkulu</p>
            </div>

            <!-- FORM FILTER & TOMBOL EXPORT -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2">
                <!-- DROPDOWN FILTER STATUS -->
                <select name="status" class="text-xs border-gray-300 rounded-lg p-2 bg-gray-50 border focus:ring-[#003366] focus:border-[#003366]">
                    <option value="">Semua Status</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dalam Proses" {{ request('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                    <option value="Ada Kendala" {{ request('status') == 'Ada Kendala' ? 'selected' : '' }}>Ada Kendala</option>
                </select>

                <!-- BUTTON: SUBMIT FILTER -->
                <button type="submit" class="bg-[#003366] text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-900 transition">Filter</button>

                <!-- BUTTON: RESET FILTER -->
                @if(request()->hasAny(['status', 'tanggal_mulai', 'tanggal_selesai']))
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-2 rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                @endif

                <!-- BUTTON: EXPORT PDF -->
                <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="bg-red-600 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-red-700 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    Export PDF
                </a>
            </form>
        </div>

        <!-- NOTIFIKASI PESAN SUKSES -->
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- ========================================== -->
        <!-- SECTION: TABEL DATA LAPORAN -->
        <!-- ========================================== -->
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
                                'formatted_date' => $report->tanggal_kegiatan 
                                    ? \Carbon\Carbon::parse($report->tanggal_kegiatan)->format('d M Y') . ', ' . $report->created_at->format('H:i') . ' WIB'
                                    : $report->created_at->format('d M Y, H:i') . ' WIB',
                                'user_name' => $report->user->name ?? 'Staf Teknisi',
                                'asal_teknisi' => $report->asal_teknisi,
                                'lokasi' => $report->lokasi,
                                'isi_laporan' => $report->isi_laporan,
                                'status' => $report->status,
                                'deskripsi_kendala' => $report->deskripsi_kendala,
                                'foto' => $report->foto
                            ]) }}">
                            
                            <!-- KOLOM: TANGGAL & WAKTU -->
                            <td class="p-4 whitespace-nowrap text-xs text-gray-500">
                                @if($report->tanggal_kegiatan)
                                    {{ \Carbon\Carbon::parse($report->tanggal_kegiatan)->format('d M Y') }}, {{ $report->created_at->format('H:i') }} WIB
                                @else
                                    {{ $report->created_at->format('d M Y, H:i') }} WIB
                                @endif
                            </td>

                            <!-- KOLOM: NAMA TEKNISI -->
                            <td class="p-4 font-semibold text-gray-800 whitespace-nowrap">
                                {{ $report->user->name ?? 'Staf Teknisi' }}
                            </td>
                            
                            <!-- KOLOM: BIDANG & LOKASI -->
                            <td class="p-4">
                                <span class="block text-xs font-bold text-[#003366]">{{ $report->asal_teknisi }}</span>
                                <span class="text-xs text-gray-500">{{ $report->lokasi }}</span>
                            </td>
                            
                            <!-- KOLOM: ISI LAPORAN -->
                            <td class="p-4 max-w-xs truncate text-xs text-gray-600">
                                {{ $report->isi_laporan }}
                            </td>

                            <!-- KOLOM: BADGE STATUS -->
                            <td class="p-4 whitespace-nowrap">
                                @if($report->status == 'Selesai')
                                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Selesai</span>
                                @elseif($report->status == 'Dalam Proses')
                                    <span class="bg-yellow-100 text-yellow-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Dalam Proses</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-[11px] font-bold px-2.5 py-1 rounded-full">Ada Kendala</span>
                                @endif
                            </td>

                            <!-- KOLOM: AKSI (DETAIL & HAPUS) -->
                            <td class="p-4 text-center whitespace-nowrap space-x-2">
                                <!-- BUTTON: DETAIL LAPORAN -->
                                <button type="button" onclick="openReportModal({{ $report->id }})" 
                                    class="text-xs text-blue-600 hover:text-blue-800 font-bold hover:underline">
                                    Detail
                                </button>
                                <span class="text-gray-300">|</span>
                                <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <!-- BUTTON: HAPUS LAPORAN -->
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

        <!-- ========================================== -->
        <!-- SECTION: PAGINASI TABEL -->
        <!-- ========================================== -->
        <div class="mt-4">
            {{ $reports->appends(request()->all())->links() }}
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION: MODAL POP-UP DETAIL LAPORAN -->
    <!-- ========================================== -->
    <div id="reportDetailModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 overflow-hidden transform transition-all">
            <!-- MODAL HEADER -->
            <div class="bg-[#003366] text-white p-5 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">Detail Laporan Teknisi</h3>
                    <p class="text-xs text-blue-100 mt-0.5">Monitoring Kegiatan Lapangan</p>
                </div>
                <!-- BUTTON: CLOSE MODAL (SILANG) -->
                <button type="button" onclick="closeReportModal()" class="text-white hover:text-gray-300 text-2xl font-bold leading-none">&times;</button>
            </div>

            <!-- MODAL BODY -->
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

                <!-- SUB-SECTION MODAL: DESKRIPSI KENDALA -->
                <div id="modal_kendala_container" class="hidden">
                    <span class="block text-xs font-bold text-red-600 mb-1.5 flex items-center gap-1">
                        ⚠️ Detail Kendala Lapangan
                    </span>
                    <div id="modal_kendala" class="text-xs text-red-700 bg-red-50 p-4 rounded-xl border border-red-200 leading-relaxed whitespace-pre-line min-h-[60px]"></div>
                </div>

                <!-- SUB-SECTION MODAL: FOTO BUKTI LAPANGAN -->
                <div id="modal_foto_container">
                    <span class="block text-xs text-gray-400 font-medium mb-2">Foto Bukti Lapangan</span>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 inline-block">
                        <!-- LINK/BUTTON: PRATINJAU GAMBAR PENUH -->
                        <a id="modal_foto_link" href="#" target="_blank" class="block group">
                            <img id="modal_foto" src="" alt="Foto Bukti" class="max-h-60 w-auto rounded-lg shadow-sm group-hover:opacity-90 transition">
                            <span class="text-[11px] text-blue-600 font-semibold mt-2 text-center block group-hover:underline">Klik untuk membuka gambar penuh ↗</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- MODAL FOOTER -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
                <!-- BUTTON: TUTUP MODAL -->
                <button type="button" onclick="closeReportModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-5 rounded-xl text-xs transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION: JAVASCRIPT LOGIC (MODAL) -->
    <!-- ========================================== -->
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

            const kendalaContainer = document.getElementById('modal_kendala_container');
            const kendalaText = document.getElementById('modal_kendala');

            if (data.status === 'Ada Kendala' || data.deskripsi_kendala) {
                kendalaText.innerText = data.deskripsi_kendala || 'Tidak ada catatan tambahan kendala.';
                kendalaContainer.classList.remove('hidden');
            } else {
                kendalaContainer.classList.add('hidden');
            }

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