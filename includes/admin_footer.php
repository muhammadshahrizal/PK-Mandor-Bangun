        </main>
    </div>
    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
    
    <!-- JavaScript untuk Navigasi Mobile -->
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
</body>
</html>
