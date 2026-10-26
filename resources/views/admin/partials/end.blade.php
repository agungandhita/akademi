<!-- Global Admin Script Helpers -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle elements
    const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
    const sidebar = document.getElementById('admin-sidebar');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');

    if (sidebarToggleBtn && sidebar) {
        sidebarToggleBtn.addEventListener('click', function () {
            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                sidebarBackdrop?.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarBackdrop?.classList.add('hidden');
            }
        });
    }

    if (sidebarBackdrop && sidebar) {
        sidebarBackdrop.addEventListener('click', function () {
            sidebar.classList.add('-translate-x-full');
            sidebarBackdrop.classList.add('hidden');
        });
    }

    // Profile dropdown
    const profileBtn = document.getElementById('admin-profile-btn');
    const profileMenu = document.getElementById('admin-profile-menu');

    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });
    }

    // Notification dropdown
    const notifBtn = document.getElementById('notification-btn');
    const notifDropdown = document.getElementById('notification-dropdown');

    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notifDropdown.classList.toggle('hidden');
        });
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function () {
        profileMenu?.classList.add('hidden');
        notifDropdown?.classList.add('hidden');
    });
});

// Global SweetAlert2 Confirmation Dialog for Deletions
window.confirmDelete = function(event, title, message) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const target = event ? (event.currentTarget || event.target) : null;
    const form = target ? target.closest('form') : null;
    if (!form) return false;

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Hapus Data Pelatihan?',
            html: message || (title ? `Apakah Anda yakin ingin menghapus pelatihan <strong>"${title}"</strong>?<br><span style="font-size:12px;color:#6b7280;margin-top:6px;display:block;">Tindakan ini permanen dan akan menghapus data program serta sesi terkait.</span>` : 'Apakah Anda yakin ingin menghapus data ini?'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ba1a1a',
            cancelButtonColor: '#737780',
            confirmButtonText: 'Ya, Hapus Sekarang',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            customClass: {
                popup: 'rounded-2xl border border-outline-variant/60 shadow-xl',
                confirmButton: 'rounded-xl font-bold px-4 py-2.5',
                cancelButton: 'rounded-xl font-bold px-4 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    } else {
        if (confirm(title ? `Apakah Anda yakin ingin menghapus "${title}"?` : 'Apakah Anda yakin ingin menghapus data ini?')) {
            form.submit();
        }
        return false;
    }
};

// Auto intercept any form with .form-delete or [data-confirm-delete]
document.addEventListener('submit', function (e) {
    const form = e.target;
    if (form && (form.classList.contains('form-delete') || form.hasAttribute('data-confirm-delete'))) {
        if (form.dataset.confirmed === 'true') {
            return;
        }
        e.preventDefault();
        e.stopPropagation();

        const title = form.getAttribute('data-title') || 'data ini';
        const message = form.getAttribute('data-message');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Pelatihan?',
                html: message || `Apakah Anda yakin ingin menghapus <strong>"${title}"</strong>?<br><span style="font-size:12px;color:#6b7280;margin-top:6px;display:block;">Tindakan ini permanen dan tidak dapat dibatalkan.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ba1a1a',
                cancelButtonColor: '#737780',
                confirmButtonText: 'Ya, Hapus Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-2xl border border-outline-variant/60 shadow-xl',
                    confirmButton: 'rounded-xl font-bold px-4 py-2.5',
                    cancelButton: 'rounded-xl font-bold px-4 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'true';
                    form.submit();
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus "${title}"?`)) {
                form.dataset.confirmed = 'true';
                form.submit();
            }
        }
    }
});
</script>

@stack('scripts')
</body>

</html>
