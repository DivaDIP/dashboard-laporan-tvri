<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staf Teknisi TVRI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-tvri.svg') }}">
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar Standar -->
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-3">
            <span class="font-bold text-[#003366] text-lg">Dashboard Staf Teknik Penyiaran & Produksi</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-red-600 hover:underline font-bold">Logout</button>
            </form>
        </div>
    </nav>

    <div class="py-10 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Identity -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
                <img src="{{ asset('logo-tvri.svg') }}" alt="TVRI Bengkulu" class="h-14 w-auto object-contain">
                <div>
                    <h1 class="text-2xl font-bold text-[#003366]">LPP TVRI Stasiun Bengkulu</h1>
                    <p class="text-sm text-gray-500 font-medium">Sistem Pengiriman Laporan Kegiatan Staf Teknisi</p>
                </div>
            </div>

            <!-- Card Form Laporan -->
            <div class="bg-white shadow-sm rounded-2xl border-t-4 border-[#003366] p-6 md:p-8">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Formulir Laporan Teknisi</h3>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-2">Lokasi Pengerjaan</label>
                            <input type="text" name="lokasi" placeholder="Contoh: Studio Utama / Stasiun Pemancar" required 
                                class="w-full border border-gray-300 rounded-xl shadow-sm text-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#003366]">
                        </div>

                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-2">Bidang / Asal Teknisi</label>
                            <select name="asal_teknisi" required class="w-full border border-gray-300 rounded-xl shadow-sm text-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#003366]">
                                <option value="" disabled selected>-- Pilih Bidang Teknisi --</option>
                                <option value="Teknisi Transmisi & Pemancar">Teknisi Transmisi & Pemancar</option>
                                <option value="Teknisi Studio & Produksi">Teknisi Studio & Produksi</option>
                                <option value="Teknisi IT & Jaringan">Teknisi IT & Jaringan</option>
                                <option value="Teknisi Sarpras & Kelistrikan">Teknisi Sarpras & Kelistrikan (ME)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-gray-700 mb-2">Tugas / Kegiatan yang Dikerjakan</label>
                        <textarea name="isi_laporan" rows="5" placeholder="Jelaskan secara rinci tugas atau pemeliharaan yang dilakukan..." required 
                            class="w-full border border-gray-300 rounded-xl shadow-sm text-sm p-4 focus:outline-none focus:ring-2 focus:ring-[#003366]"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-2">Status Pengerjaan</label>
                            <select name="status" required class="w-full border border-gray-300 rounded-xl shadow-sm text-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#003366]">
                                <option value="Selesai">Selesai</option>
                                <option value="Dalam Proses">Dalam Proses</option>
                                <option value="Ada Kendala">Ada Kendala</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-sm text-gray-700 mb-2">Foto Lapangan (Real-time)</label>
                            <input type="file" name="foto" accept="image/*" capture="environment" required 
                                class="w-full border border-gray-300 rounded-xl text-sm p-2.5 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#003366] file:text-white">
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" 
                            class="bg-[#003366] hover:bg-[#002244] text-white font-bold py-3.5 px-8 rounded-xl shadow-md transition duration-200 text-sm tracking-wider uppercase">
                            Kirim Laporan Teknisi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>
</html>