</main>
    </div>
    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const wrapper = document.querySelector('.admin-wrapper');

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('is-open');
                    wrapper.classList.toggle('sidebar-is-open');
                });
            }
        });
    </script>

    <div id="delete-confirmation-modal" class="modal-overlay delete-modal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 id="delete-modal-title">Konfirmasi Hapus</h3>
            <p id="delete-modal-text">Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat diurungkan.</p>
            <div class="modal-buttons">
                <button id="cancel-delete-btn" class="btn-secondary">Batal</button>
                <form id="confirm-delete-form" action="process.php" method="POST" style="display:inline;">
                    </form>
                <button id="confirm-delete-btn" class="btn-delete-confirm">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('delete-confirmation-modal');
        if (!modal) return;

        const cancelBtn = document.getElementById('cancel-delete-btn');
        const confirmBtn = document.getElementById('confirm-delete-btn');
        const confirmForm = document.getElementById('confirm-delete-form');
        const modalTitle = document.getElementById('delete-modal-title');
        const modalText = document.getElementById('delete-modal-text');

        let originalFormToSubmit = null;

        // Delegasi event untuk semua tombol hapus di halaman
        document.body.addEventListener('click', function(e) {
            if (e.target.matches('.delete-trigger-btn')) {
                e.preventDefault();
                originalFormToSubmit = e.target.closest('form');
                
                // Ambil pesan kustom dari atribut data, jika ada
                const customMessage = e.target.getAttribute('data-message');
                if (customMessage) {
                    modalText.textContent = customMessage;
                } else {
                    modalText.textContent = 'Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat diurungkan.';
                }
                
                modal.classList.add('show');
            }
        });

        // Logika tombol "Ya, Hapus"
        confirmBtn.addEventListener('click', function() {
            if (originalFormToSubmit) {
                originalFormToSubmit.submit();
            }
        });

        // Logika untuk menyembunyikan modal
        cancelBtn.addEventListener('click', () => {
            modal.classList.remove('show');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('show');
            }
        });
    });
    </script>
</body>
</html>