       function openReportModal(reportId) {
            const modal = document.getElementById('reportDetailModal');
            const tableRow = document.getElementById('report-row-' + reportId);
            const data = JSON.parse(tableRow.getAttribute('data-report'));

            document.getElementById('modal_tanggal').innerText = data.formatted_date;
            document.getElementById('modal_teknisi').innerText = data.user_name;
            document.getElementById('modal_bidang').innerText = data.asal_teknisi;
            document.getElementById('modal_lokasi').innerText = data.lokasi;
            document.getElementById('modal_isi').innerText = data.isi_laporan;

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
