<!DOCTYPE html>
<html>
<head>
    <title>Rekap Laporan Teknisi TVRI Bengkulu</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #003366; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #003366; }
        .header p { margin: 2px 0; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #003366; color: #fff; text-transform: uppercase; font-size: 10px; }
        .status-selesai { color: green; font-weight: bold; }
        .status-proses { color: orange; font-weight: bold; }
        .status-kendala { color: red; font-weight: bold; }
        .foto-laporan { max-width: 100px; max-height: 100px; object-fit: cover; }
        .no-foto { color: #999; font-style: italic; font-size: 9px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>REKAPITULASI LAPORAN TEKNISI TVRI BENGKULU</h2>
        <p>Laporan Monitoring Pengerjaan Lapangan Pokjawas</p>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Waktu</th>
                <th width="15%">Teknisi</th>
                <th width="15%">Lokasi</th>
                <th>Isi Kegiatan</th>
                <th width="12%">Foto</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $report->asal_teknisi }}</strong></td>
                    <td>{{ $report->lokasi }}</td>
                    <td>{{ $report->isi_laporan }}</td>
                    <td style="text-align: center;">
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
                            <img src="{{ $fotoBase64 }}" class="foto-laporan">
                        @else
                            <span class="no-foto">Tidak ada foto</span>
                        @endif
                    </td>
                    <td>
                        @if($report->status == 'Selesai')
                            <span class="status-selesai">Selesai</span>
                        @elseif($report->status == 'Dalam Proses')
                            <span class="status-proses">Dalam Proses</span>
                        @else
                            <span class="status-kendala">Ada Kendala</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>