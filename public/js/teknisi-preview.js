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