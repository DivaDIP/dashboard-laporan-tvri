<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Menampilkan Riwayat Laporan Pribadi (Khusus User / Teknisi)
     */
    public function myReports(Request $request)
    {
        $query = Report::where('user_id', Auth::id())->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kegiatan', $request->tanggal);
        }

        $reports = $query->paginate(10)->withQueryString();

        return view('teknisi.index', compact('reports'));
    }

    /**
     * Menyimpan Laporan Baru dari Form Teknisi
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'kategori'         => 'required|string',
            'asal_teknisi'      => 'required|string',
            'lokasi'            => 'required|string',
            'isi_laporan'       => 'required|string',
            'status'            => 'required|string',
            'deskripsi_kendala' => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('reports', 'public');
        }

        Report::create([
            'user_id'          => Auth::id(),
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'kategori'         => $request->kategori,
            'asal_teknisi'     => $request->asal_teknisi,
            'lokasi'           => $request->lokasi,
            'isi_laporan'      => $request->isi_laporan,
            'status'           => $request->status,
            'deskripsi_kendala'=> $request->deskripsi_kendala,
            'foto'             => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Menampilkan Dashboard Admin
     */
    public function adminDashboard(Request $request)
    {
        $totalReports  = Report::count();
        $statusSelesai = Report::where('status', 'Selesai')->count();
        $statusProses  = Report::where('status', 'Dalam Proses')->count();
        $statusKendala = Report::where('status', 'Ada Kendala')->count();

        $query = Report::with('user')->latest();

        if ($request->filled('asal_teknisi')) {
            $query->where('asal_teknisi', $request->asal_teknisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

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