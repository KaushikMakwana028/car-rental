<?php
$booking = isset($booking) ? $booking : array();
$booking_photos = isset($booking_photos) ? $booking_photos : array();
$booking_photo_table_ready = !empty($booking_photo_table_ready);
?>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --brand: #1a56db;
        --brand-hover: #1749c0;
        --brand-light: #eff4ff;
        --brand-mid: #c7d9fd;
        --surface: #ffffff;
        --surface-2: #f8fafc;
        --surface-3: #f1f5f9;
        --border: #e2e8f2;
        --border-strong: #c9d5e8;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #94a3b8;
        --amber-bg: #fffbeb;
        --amber-border: #fcd34d;
        --amber-text: #92400e;
        --green-bg: #f0fdf4;
        --green-border: #86efac;
        --green-text: #15803d;
        --red-bg: #fef2f2;
        --red-border: #fca5a5;
        --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04);
        --shadow-md: 0 4px 16px rgba(15, 23, 42, 0.08), 0 1px 4px rgba(15, 23, 42, 0.04);
        --shadow-lg: 0 12px 40px rgba(15, 23, 42, 0.10), 0 2px 8px rgba(15, 23, 42, 0.05);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 18px;
        --radius-xl: 24px;
        --font: 'DM Sans', system-ui, sans-serif;
        --serif: 'Instrument Serif', Georgia, serif;
    }

    body,
    .bp-shell {
        font-family: var(--font);
        color: var(--text-primary);
    }

    /* ── Shell ── */
    .bp-shell {
        max-width: 1200px;
        margin: 0 auto;
        padding: 28px 20px 60px;
        background: var(--surface-2);
        min-height: 100vh;
    }

    /* ── Topbar ── */
    .bp-topbar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .bp-topbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .bp-topbar-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        background: var(--brand);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(26, 86, 219, 0.28);
    }

    .bp-topbar-icon svg {
        width: 22px;
        height: 22px;
        fill: none;
        stroke: #fff;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .bp-topbar-text h1 {
        font-size: 22px;
        font-weight: 600;
        color: var(--text-primary);
        letter-spacing: -0.3px;
        line-height: 1.2;
    }

    .bp-topbar-text p {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 3px;
    }

    .bp-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 16px;
        border-radius: var(--radius-md);
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        font-family: var(--font);
        transition: all 0.15s ease;
        box-shadow: var(--shadow-sm);
        white-space: nowrap;
    }

    .bp-back-btn:hover {
        border-color: var(--brand-mid);
        color: var(--brand);
        background: var(--brand-light);
        box-shadow: 0 2px 8px rgba(26, 86, 219, 0.1);
    }

    .bp-back-btn svg {
        width: 15px;
        height: 15px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* ── Two-column layout ── */
    .bp-grid {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 20px;
        align-items: start;
    }

    /* ── Cards ── */
    .bp-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .bp-card-head {
        padding: 20px 22px 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .bp-card-head-icon {
        width: 36px;
        height: 36px;
        border-radius: var(--radius-sm);
        background: var(--brand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .bp-card-head-icon svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: var(--brand);
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .bp-card-head-text h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .bp-card-head-text p {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 3px;
        line-height: 1.5;
    }

    /* ── Booking meta ── */
    .bp-booking-meta {
        padding: 4px 22px 18px;
    }

    .bp-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
    }

    .bp-meta-row:last-child {
        border-bottom: 0;
    }

    .bp-meta-label {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--text-secondary);
        font-size: 12.5px;
        font-weight: 400;
        flex-shrink: 0;
    }

    .bp-meta-label svg {
        width: 14px;
        height: 14px;
        fill: none;
        stroke: var(--text-muted);
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
        flex-shrink: 0;
    }

    .bp-meta-value {
        color: var(--text-primary);
        font-size: 13px;
        font-weight: 500;
        text-align: right;
        word-break: break-word;
    }

    .bp-booking-id {
        display: inline-flex;
        align-items: center;
        padding: 3px 9px;
        background: var(--brand-light);
        color: var(--brand);
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.3px;
    }

    /* ── Upload form ── */
    .bp-form {
        padding: 20px 22px;
    }

    .bp-form-group {
        margin-bottom: 18px;
    }

    .bp-form-group:last-of-type {
        margin-bottom: 20px;
    }

    .bp-form label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .bp-file-label {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 10px;
        padding: 28px 20px;
        border: 1.5px dashed var(--border-strong);
        border-radius: var(--radius-md);
        background: var(--surface-3);
        cursor: pointer;
        transition: all 0.18s ease;
        position: relative;
        overflow: hidden;
    }

    .bp-file-label:hover {
        border-color: var(--brand-mid);
        background: var(--brand-light);
    }

    .bp-file-label .drop-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        background: var(--surface);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
    }

    .bp-file-label .drop-icon svg {
        width: 18px;
        height: 18px;
        fill: none;
        stroke: var(--brand);
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .bp-file-label .drop-primary {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text-primary);
    }

    .bp-file-label .drop-sub {
        font-size: 12px;
        color: var(--text-muted);
    }

    .bp-file-label input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .bp-form textarea {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 12px 14px;
        font: 13px/1.6 var(--font);
        color: var(--text-primary);
        background: var(--surface);
        min-height: 90px;
        resize: vertical;
        transition: border-color 0.15s;
        outline: none;
    }

    .bp-form textarea::placeholder {
        color: var(--text-muted);
    }

    .bp-form textarea:focus {
        border-color: var(--brand-mid);
        box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.08);
    }

    .bp-submit-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 13px 20px;
        border: 0;
        border-radius: var(--radius-md);
        background: var(--brand);
        color: #fff;
        font: 14px/1 var(--font);
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
        box-shadow: 0 4px 12px rgba(26, 86, 219, 0.28);
        letter-spacing: 0.1px;
    }

    .bp-submit-btn:hover {
        background: var(--brand-hover);
        box-shadow: 0 6px 18px rgba(26, 86, 219, 0.34);
        transform: translateY(-1px);
    }

    .bp-submit-btn:active {
        transform: translateY(0);
    }

    .bp-submit-btn:disabled {
        background: var(--text-muted);
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    .bp-submit-btn svg {
        width: 17px;
        height: 17px;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .bp-help-txt {
        margin-top: 12px;
        display: flex;
        align-items: flex-start;
        gap: 7px;
        color: var(--text-muted);
        font-size: 11.5px;
        line-height: 1.6;
    }

    .bp-help-txt svg {
        width: 13px;
        height: 13px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ── Alert ── */
    .bp-alert {
        margin: 0 22px 18px;
        padding: 13px 16px;
        border-radius: var(--radius-md);
        background: var(--amber-bg);
        color: var(--amber-text);
        border: 1px solid var(--amber-border);
        font-size: 13px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        line-height: 1.5;
    }

    .bp-alert svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* ── Gallery section ── */
    .bp-gallery-card {
        margin-top: 22px;
    }

    .bp-gallery-head {
        padding: 20px 22px 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .bp-gallery-head-left {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .bp-photo-count {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--brand-light);
        color: var(--brand);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .bp-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 16px;
        padding: 20px 22px;
    }

    .bp-photo-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--surface);
        transition: box-shadow 0.18s, transform 0.18s, border-color 0.18s;
    }

    .bp-photo-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
        border-color: var(--brand-mid);
    }

    .bp-photo-card-thumb {
        position: relative;
        overflow: hidden;
        height: 185px;
        background: var(--surface-3);
    }

    .bp-photo-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .bp-photo-card:hover .bp-photo-card-thumb img {
        transform: scale(1.04);
    }

    .bp-photo-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.18s;
    }

    .bp-photo-card:hover .bp-photo-overlay {
        background: rgba(15, 23, 42, 0.28);
    }

    .bp-photo-overlay-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0.8);
        transition: opacity 0.18s, transform 0.18s;
    }

    .bp-photo-card:hover .bp-photo-overlay-icon {
        opacity: 1;
        transform: scale(1);
    }

    .bp-photo-overlay-icon svg {
        width: 16px;
        height: 16px;
        fill: none;
        stroke: var(--brand);
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .bp-photo-body {
        padding: 13px 14px;
    }

    .bp-photo-uploader {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .bp-uploader-avatar {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: var(--brand-light);
        color: var(--brand);
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .bp-uploader-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bp-photo-note {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.55;
        margin-bottom: 9px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .bp-photo-time {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        color: var(--text-muted);
    }

    .bp-photo-time svg {
        width: 12px;
        height: 12px;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* ── Empty state ── */
    .bp-empty {
        padding: 60px 20px;
        text-align: center;
    }

    .bp-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-lg);
        background: var(--surface-3);
        border: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .bp-empty-icon svg {
        width: 26px;
        height: 26px;
        fill: none;
        stroke: var(--text-muted);
        stroke-width: 1.5;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .bp-empty h4 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .bp-empty p {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.6;
        max-width: 280px;
        margin: 0 auto;
    }

    /* ── Responsive ── */
    @media (max-width: 820px) {
        .bp-grid {
            grid-template-columns: 1fr;
        }

        .bp-shell {
            padding: 16px 14px 48px;
        }

        .bp-topbar {
            gap: 12px;
        }

        .bp-topbar-text h1 {
            font-size: 18px;
        }

        .bp-back-btn span {
            display: none;
        }

        .bp-gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
            gap: 12px;
            padding: 14px 16px;
        }

        .bp-photo-card-thumb {
            height: 140px;
        }

        .bp-card-head,
        .bp-booking-meta,
        .bp-form,
        .bp-gallery-head {
            padding-left: 16px;
            padding-right: 16px;
        }

        .bp-alert {
            margin-left: 16px;
            margin-right: 16px;
        }

        .bp-gallery-card {
            margin-top: 16px;
        }
    }

    @media (max-width: 480px) {
        .bp-gallery-grid {
            grid-template-columns: 1fr 1fr;
        }

        .bp-topbar-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }
    }
</style>

<div class="bp-shell">

    <!-- ── Topbar ── -->
    <div class="bp-topbar">
        <div class="bp-topbar-left">
            <div class="bp-topbar-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M23 7l-7 5 7 5V7z" />
                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2" />
                </svg>
            </div>
            <div class="bp-topbar-text">
                <h1>Booking Car Photos</h1>
                <p>Upload &amp; manage handover condition photos for this booking</p>
            </div>
        </div>
        <a class="bp-back-btn" href="<?php echo base_url('admin/bookings'); ?>">
            <svg viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            <span>Back to Bookings</span>
        </a>
    </div>

    <!-- ── Main grid ── -->
    <div class="bp-grid">

        <!-- Left: Booking Summary -->
        <div class="bp-card">
            <div class="bp-card-head">
                <div class="bp-card-head-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>
                <div class="bp-card-head-text">
                    <h3>Booking Summary</h3>
                    <p>Details for this trip handover session</p>
                </div>
            </div>
            <div class="bp-booking-meta">
                <div class="bp-meta-row">
                    <span class="bp-meta-label">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 12V22H4V12" />
                            <path d="M22 7H2v5h20V7z" />
                            <path d="M12 22V7" />
                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z" />
                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" />
                        </svg>
                        Booking ID
                    </span>
                    <span class="bp-meta-value"><span class="bp-booking-id"><?php echo html_escape($booking['booking_code']); ?></span></span>
                </div>
                <div class="bp-meta-row">
                    <span class="bp-meta-label">
                        <svg viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Customer
                    </span>
                    <span class="bp-meta-value"><?php echo html_escape($booking['customer_name']); ?></span>
                </div>
                <div class="bp-meta-row">
                    <span class="bp-meta-label">
                        <svg viewBox="0 0 24 24">
                            <rect x="1" y="3" width="15" height="13" rx="2" />
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                            <circle cx="5.5" cy="18.5" r="2.5" />
                            <circle cx="18.5" cy="18.5" r="2.5" />
                        </svg>
                        Vehicle
                    </span>
                    <span class="bp-meta-value"><?php echo html_escape($booking['vehicle_name']); ?></span>
                </div>
                <div class="bp-meta-row">
                    <span class="bp-meta-label">
                        <svg viewBox="0 0 24 24">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                        Registration
                    </span>
                    <span class="bp-meta-value"><?php echo html_escape($booking['registration_no']); ?></span>
                </div>
                <div class="bp-meta-row">
                    <span class="bp-meta-label">
                        <svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        Trip Date
                    </span>
                    <span class="bp-meta-value"><?php echo html_escape($booking['trip_label']); ?></span>
                </div>
                <div class="bp-meta-row">
                    <span class="bp-meta-label">
                        <svg viewBox="0 0 24 24">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                        Route
                    </span>
                    <span class="bp-meta-value"><?php echo html_escape($booking['pickup_location'] . ' → ' . $booking['drop_location']); ?></span>
                </div>
            </div>
        </div>

        <!-- Right: Upload form -->
        <div class="bp-card">
            <div class="bp-card-head">
                <div class="bp-card-head-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                </div>
                <div class="bp-card-head-text">
                    <h3>Upload Car Photos</h3>
                    <p>No limit — upload as many photos as needed in multiple batches</p>
                </div>
            </div>

            <?php if (!$booking_photo_table_ready): ?>
                <div class="bp-alert">
                    <svg viewBox="0 0 24 24">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                    The booking photo table is not ready yet. Please run the database query first, then upload photos here.
                </div>
            <?php endif; ?>

            <form class="bp-form" method="post" action="<?php echo base_url('admin/bookings/photos/upload/' . (int) $booking['id']); ?>" enctype="multipart/form-data">

                <div class="bp-form-group">
                    <label>Choose Photos</label>
                    <label class="bp-file-label" id="drop-zone">
                        <div class="drop-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                                <circle cx="8.5" cy="8.5" r="1.5" />
                                <polyline points="21 15 16 10 5 21" />
                            </svg>
                        </div>
                        <span class="drop-primary" id="file-label-text">Click to browse or drag photos here</span>
                        <span class="drop-sub">JPG, JPEG, PNG, WEBP supported</span>
                        <input type="file" id="booking_photos" name="booking_photos[]" accept=".jpg,.jpeg,.png,.webp" multiple <?php echo !$booking_photo_table_ready ? 'disabled' : ''; ?> required>
                    </label>
                </div>

                <div class="bp-form-group">
                    <label for="note">Note for This Upload <span style="font-weight:400;color:var(--text-muted)">(optional)</span></label>
                    <textarea id="note" name="note" placeholder="e.g. Front bumper, left side, dashboard, fuel gauge, any scratches or dents observed…" <?php echo !$booking_photo_table_ready ? 'disabled' : ''; ?>></textarea>
                </div>

                <button class="bp-submit-btn" type="submit" <?php echo !$booking_photo_table_ready ? 'disabled' : ''; ?>>
                    <svg viewBox="0 0 24 24">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    Upload Photos
                </button>

                <div class="bp-help-txt">
                    <svg viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="16" x2="12" y2="12" />
                        <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    You can upload multiple photos at once and repeat as many times as needed for this booking.
                </div>
            </form>
        </div>
    </div>

    <!-- ── Gallery ── -->
    <div class="bp-card bp-gallery-card">
        <div class="bp-gallery-head">
            <div class="bp-gallery-head-left">
                <div class="bp-card-head-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                </div>
                <div class="bp-card-head-text">
                    <h3>Photo Gallery</h3>
                    <p>All car condition photos for this booking</p>
                </div>
            </div>
            <span class="bp-photo-count">
                <?php echo count($booking_photos); ?> photo<?php echo count($booking_photos) !== 1 ? 's' : ''; ?>
            </span>
        </div>

        <?php if (!empty($booking_photos)): ?>
            <div class="bp-gallery-grid">
                <?php foreach ($booking_photos as $photo):
                    $name = !empty($photo['uploaded_by_name']) ? $photo['uploaded_by_name'] : 'Admin';
                    $initials = implode('', array_map(fn($w) => strtoupper($w[0]), array_slice(explode(' ', trim($name)), 0, 2)));
                ?>
                    <div class="bp-photo-card">
                        <a href="<?php echo base_url($photo['file_path']); ?>" target="_blank" rel="noopener noreferrer" style="display:block;text-decoration:none;">
                            <div class="bp-photo-card-thumb">
                                <img src="<?php echo base_url($photo['file_path']); ?>" alt="Booking photo" loading="lazy">
                                <div class="bp-photo-overlay">
                                    <div class="bp-photo-overlay-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                            <polyline points="15 3 21 3 21 9" />
                                            <line x1="10" y1="14" x2="21" y2="3" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="bp-photo-body">
                            <div class="bp-photo-uploader">
                                <div class="bp-uploader-avatar"><?php echo html_escape($initials); ?></div>
                                <span class="bp-uploader-name"><?php echo html_escape($name); ?></span>
                            </div>
                            <p class="bp-photo-note"><?php echo !empty($photo['note']) ? nl2br(html_escape($photo['note'])) : '<span style="color:var(--text-muted);font-style:italic;">No note added</span>'; ?></p>
                            <div class="bp-photo-time">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                <?php echo !empty($photo['created_at']) ? date('d M Y, h:i A', strtotime($photo['created_at'])) : '—'; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bp-empty">
                <div class="bp-empty-icon">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                </div>
                <h4>No photos yet</h4>
                <p>Upload car condition photos above to build a visual record for this booking.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    (function() {
        var input = document.getElementById('booking_photos');
        var label = document.getElementById('file-label-text');
        var zone = document.getElementById('drop-zone');
        var MAX = 4;

        if (!input || !label) return;

        function validateFiles(files) {
            if (files.length > MAX) {
                label.textContent = 'Too many photos selected — max ' + MAX + ' allowed';
                label.style.color = '#be123c';
                input.value = '';
                return false;
            }
            label.style.color = '';
            if (files.length > 0) {
                label.textContent = files.length + ' photo' + (files.length > 1 ? 's' : '') + ' selected';
            } else {
                label.textContent = 'Click to browse or drag photos here';
            }
            return true;
        }

        input.addEventListener('change', function() {
            validateFiles(this.files);
        });

        /* Update the file input accept hint */
        var dropSub = zone.querySelector('.drop-sub');
        if (dropSub) dropSub.textContent = 'JPG, JPEG, PNG, WEBP · Max 4 photos per upload';

        ['dragover', 'dragenter'].forEach(function(evt) {
            zone.addEventListener(evt, function(e) {
                e.preventDefault();
                zone.style.borderColor = '#1a56db';
                zone.style.background = '#eff4ff';
            });
        });

        ['dragleave', 'drop'].forEach(function(evt) {
            zone.addEventListener(evt, function() {
                zone.style.borderColor = '';
                zone.style.background = '';
            });
        });

        /* Validate on form submit too */
        var form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (input.files.length > MAX) {
                    e.preventDefault();
                    label.textContent = 'Too many photos — max ' + MAX + ' allowed per upload';
                    label.style.color = '#be123c';
                    zone.style.borderColor = '#fca5a5';
                    zone.style.background = '#fef2f2';
                }
            });
        }
    })();
</script>