<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </div>
</main>
<script>
    (function () {
        var drawer = document.querySelector('.js-mobile-drawer');
        var backdrop = document.querySelector('.js-mobile-backdrop');
        var toggles = document.querySelectorAll('.js-menu-toggle');
        var navLinks = document.querySelectorAll('.js-mobile-drawer .nav-link');
        var profileDropdown = document.querySelector('.js-profile-dropdown');
        var profileTrigger = document.querySelector('.js-profile-trigger');

        function syncToggleState(isOpen) {
            toggles.forEach(function (toggle) {
                toggle.classList.toggle('active', isOpen);
                toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        function openDrawer() {
            if (!drawer || !backdrop || window.innerWidth > 1024) {
                return;
            }

            drawer.classList.add('open');
            backdrop.classList.add('open');
            document.body.classList.add('nav-open');
            syncToggleState(true);
        }

        function closeDrawer() {
            if (!drawer || !backdrop) {
                return;
            }

            drawer.classList.remove('open');
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
                    if (drawer && drawer.classList.contains('open')) {
                        closeDrawer();
                    } else {
                        openDrawer();
                    }
                });
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', closeDrawer);
        }

        navLinks.forEach(function (link) {
            link.addEventListener('click', function () {
                closeDrawer();
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
            if (window.innerWidth > 1024) {
                closeDrawer();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeDrawer();
                closeProfileDropdown();
            }
        });
    })();
</script>
</body>
</html>
