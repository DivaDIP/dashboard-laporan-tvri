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
        <p>Laporan Monitoring Pengerjaan Lapangan Pokjawas</p>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- ========================================== -->
    <!-- SECTION: TABEL REKAPITULASI LAPORAN -->
    <!-- ========================================== -->
    <table>
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="12%">Tanggal & Waktu</th>
                <th width="9%" class="text-center">Kategori</th>
                <th width="12%">Teknisi</th>
                <th width="8%">Lokasi</th>
                <th width="20%">Isi Kegiatan</th>
                <th width="14%">Detail Kendala</th>
                <th width="10%" class="text-center">Foto</th>
                <th width="8%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
                <tr>
                    <!-- KOLOM: NOMOR URUT -->
                    <td class="text-center">{{ $index + 1 }}</td>

                    <!-- KOLOM: TANGGAL & WAKTU SUBMIT -->
                    <td>
                        <strong>{{ $report->tanggal_kegiatan ? $report->tanggal_kegiatan->format('d/m/Y') : $report->created_at->format('d/m/Y') }}</strong>
                        <br>
                        <small style="color: #64748b; font-size: 7.5px;">{{ $report->created_at->format('H:i') }} WIB</small>
                    </td>

                    <!-- KOLOM: BADGE KATEGORI -->
                    <td class="text-center">
                        <span class="badge-kategori">{{ $report->kategori ?? '-' }}</span>
                    </td>

                    <!-- KOLOM: TEKNISI / PELAPOR -->
                    <td><strong>{{ $report->asal_teknisi }}</strong></td>

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

                    <!-- KOLOM: BADGE STATUS LAPORAN -->
                    <td class="text-center">
                        @if($report->status == 'Selesai')
                            <span class="status-badge status-selesai">Selesai</span>
                        @elseif($report->status == 'Dalam Proses')
                            <span class="status-badge status-proses">Proses</span>
                        @else
                            <span class="status-badge status-kendala">Kendala</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>