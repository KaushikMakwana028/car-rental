<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </main>
</div>
<script>
    (function () {
        var sidebar = document.querySelector('.js-sidebar');
        var backdrop = document.querySelector('.js-sidebar-backdrop');
        var toggles = document.querySelectorAll('.js-menu-toggle');
        var navLinks = document.querySelectorAll('.sidebar .nav-link');
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
                closeSidebar();
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
    })();
</script>
</body>
</html>
