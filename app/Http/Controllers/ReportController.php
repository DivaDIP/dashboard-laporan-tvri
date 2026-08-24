<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'asal_teknisi' => 'required',
            'lokasi' => 'required',
            'isi_laporan' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('reports', 'public');
        }

        Report::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'asal_teknisi' => $request->asal_teknisi,
            'lokasi' => $request->lokasi,
            'isi_laporan' => $request->isi_laporan,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    public function adminDashboard(Request $request)
    {
        // Hitung total statistik (keseluruhan data)
        $totalReports = Report::count();
        $statusSelesai = Report::where('status', 'Selesai')->count();
        $statusProses = Report::where('status', 'Dalam Proses')->count();
        $statusKendala = Report::where('status', 'Ada Kendala')->count();

        // Query data tabel dengan filter
        $query = Report::with('user')->latest();

        if ($request->filled('asal_teknisi')) {
            $query->where('asal_teknisi', $request->asal_teknisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // withQueryString() memastikan filter tidak hilang saat berpindah halaman pagination
        $reports = $query->paginate(10)->withQueryString();

        return view('admin.dashboard', compact(
            'reports',
            'totalReports',
            'statusSelesai',
            'statusProses',
            'statusKendala'
        ));
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus!');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new ReportsExport($request), 'rekap-laporan-teknisi-' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Report::with('user')->latest();

        if ($request->filled('asal_teknisi')) {
            $query->where('asal_teknisi', $request->asal_teknisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->get();

        $pdf = Pdf::loadView('admin.reports_pdf', compact('reports'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('rekap-laporan-teknisi-' . date('Y-m-d') . '.pdf');
    }
}