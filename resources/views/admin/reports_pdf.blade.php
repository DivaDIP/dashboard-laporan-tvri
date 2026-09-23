<!DOCTYPE html>
<html>
<head>
    <title>Rekap Laporan Teknisi TVRI Bengkulu</title>
    <!-- Memanggil file CSS eksternal via absolute path system -->
    <link rel="stylesheet" href="{{ resource_path('css/report.css') }}">
</head>
<body>

    <!-- ========================================== -->
    <!-- SECTION: HEADER DOKUMEN CETAK / PDF -->
    <!-- ========================================== -->
    <div class="header">
        <h2>REKAPITULASI LAPORAN TEKNISI TVRI BENGKULU</h2>
        <p>Laporan Monitoring Pengerjaan Lapangan Teknisi Produksi & Penyiaran</p>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- ========================================== -->
    <!-- SECTION: TABEL REKAPITULASI LAPORAN -->
    <!-- ========================================== -->
    <table>
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="9%">Tanggal & Waktu</th>
                <th width="11%" class="text-center">Jam Kegiatan</th>
                <th width="13%">Nama Teknisi</th>
                <th width="12%">Tugas</th>
                <th width="8%">Lokasi</th>
                <th width="14%">Kegiatan</th>
                <th width="10%">Detail Kendala</th>
                <th width="8%" class="text-center">Status</th>
                <th width="8%" class="text-center">Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
                <tr>
                    <!-- KOLOM: NOMOR URUT -->
                    <td class="text-center">{{ $index + 1 }}</td>

                    <!-- KOLOM: TANGGAL & WAKTU SUBMIT -->
                    <td>
                        <strong>{{ $report->tanggal_kegiatan ? \Carbon\Carbon::parse($report->tanggal_kegiatan)->format('d/m/Y') : $report->created_at->format('d/m/Y') }}</strong>
                        <br>
                        <small style="color: #64748b; font-size: 7.5px;">{{ $report->created_at->format('H:i') }} WIB</small>
                    </td>

                    <!-- KOLOM: JAM KEGIATAN -->
                    <td class="text-center">
                        <span class="badge-kategori">
                            @if($report->kategori == 'Pagi')
                                08:00 - 16:00
                            @elseif($report->kategori == 'Dinas')
                                10:00 - 18:00
                            @else
                                {{ $report->kategori ?? '-' }}
                            @endif
                        </span>
                    </td>

                    <!-- KOLOM: NAMA TEKNISI -->
                    <td>
                        <strong>{{ $report->nama_teknisi ?? 'Staf Teknisi' }}</strong>
                    </td>

                    <!-- KOLOM: ROLE / TUGAS (ASAL TEKNISI) -->
                    <td>
                        <span style="color: #003366; font-weight: bold;">{{ $report->asal_teknisi }}</span>
                    </td>

                    <!-- KOLOM: LOKASI PENGERJAAN -->
                    <td>{{ $report->lokasi }}</td>

                    <!-- KOLOM: ISI KEGIATAN LAPORAN -->
                    <td>{{ $report->isi_laporan }}</td>

                    <!-- KOLOM: DETAIL KENDALA -->
                    <td>
                        @if(!empty($report->deskripsi_kendala))
                            <span class="text-kendala">{{ $report->deskripsi_kendala }}</span>
                        @else
                            <div class="text-empty">-</div>
                        @endif
                    </td>

                    <!-- KOLOM: BADGE STATUS LAPORAN -->
                    <td class="text-center">
                        @if($report->status == 'Selesai')
                            <span class="status-badge status-selesai">Berjalan Normal</span>
                        @elseif($report->status == 'Dalam Proses')
                            {{-- <span class="status-badge status-proses">Proses</span> --}}
                        @else
                            <span class="status-badge status-kendala">Terjadi Kendala</span>
                        @endif
                    </td>

                    <!-- KOLOM: PRATINJAU FOTO BUKTI (BASE64 ENCODING) -->
                    <td class="text-center">
                        @php
                            $fotoBase64 = null;
                            if (!empty($report->foto)) {
                                $fullPath = storage_path('app/public/' . $report->foto);
                                if (file_exists($fullPath)) {
                                    $type = pathinfo($fullPath, PATHINFO_EXTENSION);
                                    $data = file_get_contents($fullPath);
                                    $fotoBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                }
                            }
                        @endphp

                        @if($fotoBase64)
                            <div class="foto-container">
                                <img src="{{ $fotoBase64 }}" class="foto-laporan">
                            </div>
                        @else
                            <span class="no-foto">Tidak ada</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>