<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- 1. TAMBAHKAN INI (Untuk hilangkan error Undefined Storage)

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Report::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal berdasarkan tanggal kegiatan dari form teknisi
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_kegiatan', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_kegiatan', '<=', $request->tanggal_selesai);
        }

        // 2. URUTKAN BERDASARKAN TANGGAL KEGIATAN TERBARU
        $reports = $query->orderBy('tanggal_kegiatan', 'desc')->paginate(10);

        $totalReports  = Report::count();
        $statusSelesai = Report::where('status', 'Selesai')->count();
        $statusProses  = Report::where('status', 'Dalam Proses')->count();
        $statusKendala = Report::where('status', 'Ada Kendala')->count();

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

        if ($report->foto && Storage::disk('public')->exists($report->foto)) {
            Storage::disk('public')->delete($report->foto);
        }

        $report->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }
}