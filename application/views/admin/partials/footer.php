<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$swal_flash    = $this->session->flashdata('swal');
$flash_success = $this->session->flashdata('success');
$flash_error   = $this->session->flashdata('error');
?>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function () {
        var sidebar = document.querySelector('.js-sidebar');
        var backdrop = document.querySelector('.js-sidebar-backdrop');
        var toggles = document.querySelectorAll('.js-menu-toggle');
        var navLinks = document.querySelectorAll('.sidebar .nav-link');
        var navDropdownTriggers = document.querySelectorAll('.js-nav-dropdown-trigger');
        var profileDropdown = document.querySelector('.js-profile-dropdown');
        var profileTrigger = document.querySelector('.js-profile-trigger');

        function syncToggleState(isOpen) {
            toggles.forEach(function (toggle) {
                toggle.classList.toggle('active', isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        function openSidebar() {
            if (!sidebar || !backdrop || window.innerWidth > 980) {
                return;
            }

            sidebar.classList.add('open');
            backdrop.classList.add('open');
            document.body.classList.add('nav-open');
            syncToggleState(true);
        }

        function closeSidebar() {
            if (!sidebar || !backdrop) {
                return;
            }

            sidebar.classList.remove('open');
            backdrop.classList.remove('open');
            document.body.classList.remove('nav-open');
            syncToggleState(false);
        }

        function closeProfileDropdown() {
            if (!profileDropdown || !profileTrigger) {
                return;
            }

            profileDropdown.classList.remove('open');
            profileTrigger.setAttribute('aria-expanded', 'false');
        }

        if (toggles.length) {
            toggles.forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    if (sidebar && sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                });
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeSidebar);
        }

        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                if (link.classList.contains('js-nav-dropdown-trigger')) {
                    return;
                }
                closeSidebar();
            });
        });

        navDropdownTriggers.forEach(function (trigger) {
            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                var dropdown = trigger.closest('.nav-dropdown');
                if (!dropdown) {
                    return;
                }

                var isOpen = dropdown.classList.toggle('open');
                trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        });

        if (profileDropdown && profileTrigger) {
            profileTrigger.addEventListener('click', function (event) {
                event.stopPropagation();
                var isOpen = profileDropdown.classList.toggle('open');
                profileTrigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            document.addEventListener('click', function (event) {
                if (!profileDropdown.contains(event.target)) {
                    closeProfileDropdown();
                }
            });
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth > 980) {
                closeSidebar();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
                closeProfileDropdown();
            }
        });

        function runConfirm(targetUrl, options) {
            if (typeof Swal === 'undefined') {
                window.location.href = targetUrl;
                return;
            }

            Swal.fire({
                title: options.title || 'Are you sure?',
                text: options.text || '',
                icon: options.icon || 'warning',
                showCancelButton: true,
                confirmButtonText: options.confirmText || 'Continue',
                cancelButtonText: options.cancelText || 'Keep it',
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#cbd5e1',
                background: '#ffffff',
                color: '#1a202c',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = targetUrl;
                }
            });
        }

        document.querySelectorAll('.js-swal-confirm').forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                runConfirm(link.getAttribute('href'), {
                    title: link.getAttribute('data-swal-title'),
                    text: link.getAttribute('data-swal-text'),
                    confirmText: link.getAttribute('data-swal-confirm')
                });
            });
        });

        document.querySelectorAll('.js-swal-confirm-form').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                if (typeof Swal === 'undefined') {
                    form.submit();
                    return;
                }

                Swal.fire({
                    title: form.getAttribute('data-swal-title') || 'Are you sure?',
                    text: form.getAttribute('data-swal-text') || '',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: form.getAttribute('data-swal-confirm') || 'Continue',
                    cancelButtonText: 'Keep it',
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#cbd5e1',
                    background: '#ffffff',
                    color: '#1a202c',
                    reverseButtons: true
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        var payload = null;
        <?php if (!empty($swal_flash)): ?>
        payload = <?php echo json_encode($swal_flash); ?>;
        <?php elseif (!empty($flash_success)): ?>
        payload = {
            icon: 'success',
            title: 'Success',
            text: <?php echo json_encode($flash_success); ?>
        };
        <?php elseif (!empty($flash_error)): ?>
        payload = {
            icon: 'error',
            title: 'Something went wrong',
            text: <?php echo json_encode($flash_error); ?>
        };
        <?php endif; ?>

        if (payload && typeof Swal !== 'undefined') {
            Swal.fire({
                icon: payload.icon || 'info',
                title: payload.title || 'Notice',
                html: payload.text ? '<div style="font-size:14px;line-height:1.65;color:#475569;">' + payload.text + '</div>' : '',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2563eb',
                background: '#ffffff',
                color: '#1a202c'
            });
        }
    })();
</script>
</body>
</html>
