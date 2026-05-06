<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$public_contact  = isset($public_contact)  ? $public_contact  : array();
$contact_name    = !empty($public_contact['full_name']) ? $public_contact['full_name'] : 'Admin';
$contact_phone   = !empty($public_contact['phone'])     ? $public_contact['phone']     : 'Not added yet';
$contact_email   = !empty($public_contact['email'])     ? $public_contact['email']     : '';
$contact_address = !empty($public_contact['address'])   ? $public_contact['address']   : '';
$current_year    = date('Y');
$swal_flash      = $this->session->flashdata('swal');
$flash_success   = $this->session->flashdata('success');
$flash_error     = $this->session->flashdata('error');
?>

</div><!-- /.wrap -->
</main><!-- /.main -->

<!-- ═══════════════════════════════════════════════════════════ FOOTER -->
<footer class="site-footer">
    <div class="wrap">

        <div class="footer-inner">

            <!-- Brand block -->
            <div class="footer-brand">
                <div class="footer-logo-row">
                    <div class="footer-logo-wrap">
                        <img src="<?php echo base_url('assets/home/logo.png'); ?>" alt="Logo">
                    </div>
                    <span class="footer-brand-name">Cab Booking Fast</span>
                </div>
                <p class="footer-tagline">Safe, fast & reliable cab booking<br>right at your fingertips.</p>
            </div>

            <!-- Contact block -->
            <div class="footer-contact">
                <p class="footer-contact-label">Get in touch</p>

                <a class="footer-contact-row" href="tel:<?php echo html_escape($contact_phone); ?>">
                    <span class="footer-contact-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </span>
                    <?php echo html_escape($contact_phone); ?>
                </a>

                <?php if ($contact_email !== ''): ?>
                    <a class="footer-contact-row" href="mailto:<?php echo html_escape($contact_email); ?>">
                        <span class="footer-contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                        <?php echo html_escape($contact_email); ?>
                    </a>
                <?php endif; ?>
                <?php if ($contact_address !== ''): ?>
                    <div class="footer-contact-row footer-contact-row-static">
                        <span class="footer-contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-4.35-6-10a6 6 0 1112 0c0 5.65-6 10-6 10z" />
                                <circle cx="12" cy="11" r="2.5" />
                            </svg>
                        </span>
                        <?php echo html_escape($contact_address); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div><!-- /.footer-inner -->

        <div class="footer-bottom">
            <span>&copy; <?php echo $current_year; ?> Cab Booking Fast. All rights reserved.</span>
            <span class="footer-bottom-dot">·</span>
            <span><?php echo html_escape($contact_name); ?></span>
        </div>

    </div><!-- /.wrap -->
</footer>
<!-- ═══════════════════════════════════════════════════════════ /FOOTER -->

<style>
    /* ── FOOTER STYLES ───────────────────────────────────────────────── */
    .site-footer {
        background: #fff;
        border-top: 1px solid rgba(28, 23, 18, .09);
        padding: 44px 0 28px;
        margin-top: 8px;
    }

    .footer-inner {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 36px;
        flex-wrap: wrap;
        padding-bottom: 32px;
        border-bottom: 1px solid rgba(28, 23, 18, .08);
    }

    /* Brand */
    .footer-brand {
        flex: 1 1 220px;
    }

    .footer-logo-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 14px;
    }

    .footer-logo-wrap {
        width: 118px;
        height: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: visible;
    }

    .footer-logo-wrap img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .footer-brand-name {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 22px;
        font-weight: 700;
        color: #1c1712;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .footer-tagline {
        font-size: 13px;
        color: #8c7e71;
        line-height: 1.6;
        max-width: 240px;
    }

    /* Contact */
    .footer-contact {
        flex: 0 1 240px;
    }

    .footer-contact-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: #235ea7;
        margin-bottom: 14px;
    }

    .footer-contact-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid rgba(28, 23, 18, .09);
        background: #f9f7f4;
        color: #1c1712;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 8px;
        transition: background .15s, border-color .15s;
    }

    .footer-contact-row:hover {
        background: #fff7dc;
        border-color: rgba(35, 94, 167, .22);
        color: #235ea7;
    }

    .footer-contact-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #fff;
        border: 1px solid rgba(28, 23, 18, .09);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #235ea7;
    }

    .footer-contact-row-static {
        cursor: default;
        align-items: flex-start;
        line-height: 1.6;
    }

    .footer-contact-row-static:hover {
        color: #1c1712;
    }

    /* Bottom bar */
    .footer-bottom {
        margin-top: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: #8c7e71;
        flex-wrap: wrap;
    }

    .footer-bottom-dot {
        opacity: .45;
    }

    @media (max-width: 620px) {
        .footer-inner {
            flex-direction: column;
            gap: 24px;
        }

        .footer-contact {
            width: 100%;
        }

        .site-footer {
            padding: 32px 0 24px;
        }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════ SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function() {
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

        if (!payload || typeof Swal === 'undefined') return;

        var html = '';
        if (payload.text) {
            html += '<div style="font-size:14px;color:#5b5347;line-height:1.65;">' + payload.text + '</div>';
        }

        if (payload.identity) {
            html += '<div style="margin-top:16px;padding:14px 16px;border-radius:14px;background:#f9f7f4;text-align:left;">';
            Object.keys(payload.identity).forEach(function(key) {
                if (!payload.identity[key]) return;
                html += '<div style="display:flex;justify-content:space-between;gap:12px;padding:6px 0;border-bottom:1px solid rgba(28,23,18,.08);">';
                html += '<strong style="color:#1c1712;font-size:13px;">' + key + '</strong>';
                html += '<span style="color:#6d6458;font-size:13px;">' + payload.identity[key] + '</span>';
                html += '</div>';
            });
            html += '</div>';
        }

        Swal.fire({
            icon: payload.icon || 'info',
            title: payload.title || 'Notice',
            html: html,
            confirmButtonText: 'OK',
            confirmButtonColor: '#f97316',
            background: '#fffdf9',
            color: '#1c1712'
        });
    })();
</script>
</body>

</html>