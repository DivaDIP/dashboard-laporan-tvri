<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Laporan Kegiatan Teknisi - TVRI Bengkulu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-tvri.svg') }}">
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-[#003366] text-white px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-6">
            <span class="font-bold text-lg tracking-wide">Laporan Staff Penyiaran & Produksi</span>
            <!-- Menu Navigasi Tambahan -->
            <div class="space-x-4 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="text-white font-bold border-b-2 border-white pb-1">Form Input</a>
                <a href="{{ route('reports.my') }}" class="text-blue-200 hover:text-white transition">Riwayat Saya</a>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded-lg font-bold transition">Logout</button>
            </form>
        </div>
    </nav>

    <div class="py-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header Form -->
            <div class="bg-[#003366] p-6 text-white">
                <h2 class="text-xl font-bold">Input Laporan Kegiatan Lapangan</h2>
                <p class="text-xs text-blue-100 mt-1">Silakan isi form di bawah ini dengan lengkap dan jujur.</p>
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
                <div class="m-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form (Diubah action-nya ke report.store) -->
            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" id="reportForm" class="p-6 space-y-5">
                @csrf

                <!-- Asal Teknisi / Bidang -->
                <div>
                    <label for="asal_teknisi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Bidang / Subkelompok Teknisi <span class="text-red-500">*</span></label>
                    <select id="asal_teknisi" name="asal_teknisi" required class="w-full text-sm border-gray-300 rounded-xl p-3 bg-gray-50 border focus:ring-2 focus:ring-[#003366] focus:bg-white transition">
                        <option value="" disabled selected>-- Pilih Bidang Teknisi --</option>
                        <option value="Switcher" {{ old('asal_teknisi') == 'Switcher' ? 'selected' : '' }}>Switcher</option>
                        <option value="Juru Kamera Liputan" {{ old('asal_teknisi') == 'Juru Kamera Liputan' ? 'selected' : '' }}>Juru Kamera Liputan</option>
                        <option value="Juru Kamera" {{ old('asal_teknisi') == 'Juru Kamera' ? 'selected' : '' }}>Juru Kamera</option>
                        <option value="Playout MCR" {{ old('asal_teknisi') == 'Playout MCR' ? 'selected' : '' }}>Playout MCR</option>
                        <option value="Playout" {{ old('asal_teknisi') == 'Playout' ? 'selected' : '' }}>Playout</option>
                        <option value="Penata Cahaya" {{ old('asal_teknisi') == 'Penata Cahaya' ? 'selected' : '' }}>Penata Cahaya</option>
                        <option value="Penata Suara" {{ old('asal_teknisi') == 'Penata Suara' ? 'selected' : '' }}>Penata Suara</option>
                        <option value="Character Generator" {{ old('asal_teknisi') == 'Character Generator' ? 'selected' : '' }}>Character Generator</option>
                        <option value="Teknisi IT" {{ old('asal_teknisi') == 'Teknisi IT' ? 'selected' : '' }}>Teknisi IT</option>
                    </select>
                    @error('asal_teknisi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis / Kategori Kegiatan -->
                <div>
                    <label for="kategori" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Kegiatan <span class="text-red-500">*</span></label>
                    <select id="kategori" name="kategori" required class="w-full text-sm border-gray-300 rounded-xl p-3 bg-gray-50 border focus:ring-2 focus:ring-[#003366] focus:bg-white transition">
                        <option value="" disabled selected>-- Pilih Waktu Kegiatan --</option>
                        <option value="Pagi" {{ old('kategori') == 'Pagi' ? 'selected' : '' }}>08:00 - 16:00</option>
                        <option value="Dinas" {{ old('kategori') == 'Dinas' ? 'selected' : '' }}>10:00 - 18:00</option>
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kegiatan -->
                <div>
                    <label for="tanggal_kegiatan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', date('Y-m-d')) }}" required class="w-full text-sm border-gray-300 rounded-xl p-3 bg-gray-50 border focus:ring-2 focus:ring-[#003366] focus:bg-white transition">
                    @error('tanggal_kegiatan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi Pengerjaan -->
                <div>
                    <label for="lokasi" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Lokasi Pengerjaan / Unit Kerja <span class="text-red-500">*</span></label>
                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required placeholder="Contoh: Stasiun Transmisi Bentiring / Ruang Server" class="w-full text-sm border-gray-300 rounded-xl p-3 bg-gray-50 border focus:ring-2 focus:ring-[#003366] focus:bg-white transition">
                    @error('lokasi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Isi Laporan / Kegiatan -->
                <div>
                    <label for="isi_laporan" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Isi Kegiatan / Deskripsi Pekerjaan <span class="text-red-500">*</span></label>
                    <textarea id="isi_laporan" name="isi_laporan" rows="4" required placeholder="Jelaskan detail perbaikan, pemeliharaan, atau kendala yang dihadapi..." class="w-full text-sm border-gray-300 rounded-xl p-3 bg-gray-50 border focus:ring-2 focus:ring-[#003366] focus:bg-white transition leading-relaxed">{{ old('isi_laporan') }}</textarea>
                    @error('isi_laporan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Pekerjaan -->
                <div>
                    <label for="status" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Status Hasil Pekerjaan <span class="text-red-500">*</span></label>
                    <select id="status" name="status" required onchange="toggleKendalaField()" class="w-full text-sm border-gray-300 rounded-xl p-3 bg-gray-50 border focus:ring-2 focus:ring-[#003366] focus:bg-white transition">
                        <option value="" disabled selected>-- Pilih Status --</option>
                        <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Normal / Berhasil</option>
                        <option value="Ada Kendala" {{ old('status') == 'Ada Kendala' ? 'selected' : '' }}>Ada Kendala</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Kendala (Muncul Otomatis saat Status "Ada Kendala") -->
                <div id="kendalaContainer" class="hidden">
                    <label for="deskripsi_kendala" class="block text-xs font-bold text-red-700 uppercase tracking-wider mb-2">Deskripsi Kendala yang Dihadapi <span class="text-red-500">*</span></label>
                    <textarea id="deskripsi_kendala" name="deskripsi_kendala" rows="3" placeholder="Rincikan kendala, alat rusak, atau sparepart yang dibutuhkan..." class="w-full text-sm border-red-200 rounded-xl p-3 bg-red-50/50 border focus:ring-2 focus:ring-red-500 focus:bg-white transition leading-relaxed">{{ old('deskripsi_kendala') }}</textarea>
                    @error('deskripsi_kendala')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Foto Bukti & Container Preview -->
                <div>
                    <label for="foto" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Upload Foto Bukti Lapangan (Opsional)</label>
                    <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/jpg" onchange="handleImagePreview(event)" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#003366] hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-xl bg-gray-50">
                    <p class="text-[11px] text-gray-400 mt-1">Format: JPG, JPEG, PNG (Maksimal 10 MB)</p>
                    
                    <!-- Alert Error Client-Side Foto -->
                    <p id="fotoError" class="text-red-500 text-xs mt-1 hidden"></p>

                    <!-- Preview Container -->
                    <div id="previewContainer" class="mt-3 hidden">
                        <span class="block text-xs font-semibold text-gray-600 mb-2">Preview Foto yang Dipilih:</span>
                        <div class="relative inline-block bg-gray-50 p-2 rounded-xl border border-gray-200">
                            <img id="imagePreview" src="#" alt="Preview Foto" class="max-h-56 w-auto rounded-lg shadow-sm object-cover">
                            <!-- Tombol Hapus Preview -->
                            <button type="button" onclick="removeImagePreview()" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow hover:bg-red-700 transition" title="Hapus foto">&times;</button>
                        </div>
                    </div>
                    
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="pt-3">
                    <button type="submit" id="submitBtn" class="w-full bg-[#003366] text-white font-bold text-sm py-3.5 px-4 rounded-xl hover:bg-blue-900 transition shadow-sm flex items-center justify-center gap-2">
                        <span>Kirim Laporan Teknisi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Preview & Validasi JavaScript -->
    <script>
        function toggleKendalaField() {
            const statusSelect = document.getElementById('status');
            const kendalaContainer = document.getElementById('kendalaContainer');
            const kendalaInput = document.getElementById('deskripsi_kendala');

            if (statusSelect.value === 'Ada Kendala') {
                kendalaContainer.classList.remove('hidden');
                kendalaInput.setAttribute('required', 'required');
            } else {
                kendalaContainer.classList.add('hidden');
                kendalaInput.removeAttribute('required');
                kendalaInput.value = '';
            }
        }

        // Cek status saat halaman dimuat (agar mendukung re-select dari nilai old)
        document.addEventListener('DOMContentLoaded', toggleKendalaField);

        function handleImagePreview(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const errorElement = document.getElementById('fotoError');

            // Reset error
            errorElement.innerText = '';
            errorElement.classList.add('hidden');

            if (file) {
                // Validasi Tipe File Client-side
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    errorElement.innerText = 'Format file tidak didukung! Harap unggah foto berformat JPG, JPEG, atau PNG.';
                    errorElement.classList.remove('hidden');
                    removeImagePreview();
                    return;
                }

                // Validasi Ukuran File Client-side (Maks 10MB = 10 * 1024 * 1024 bytes)
                const maxSize = 10 * 1024 * 1024;
                if (file.size > maxSize) {
                    errorElement.innerText = 'Ukuran file terlalu besar! Maksimal ukuran foto adalah 10 MB.';
                    errorElement.classList.remove('hidden');
                    removeImagePreview();
                    return;
                }

                // Render Preview Gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                removeImagePreview();
            }
        }

        function removeImagePreview() {
            const fileInput = document.getElementById('foto');
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');

            fileInput.value = ''; // Reset input file
            imagePreview.src = '#';
            previewContainer.classList.add('hidden');
        }

        // Prevent double submit saat menekan tombol kirim
        document.getElementById('reportForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            btn.innerHTML = '<span>Mengirim Laporan...</span>';
        });
    </script>
</body>
</html>