<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$page_title    = isset($page_title)    ? $page_title    : '';
$page_subtitle = isset($page_subtitle) ? $page_subtitle : '';
$brand_logo    = base_url('assets/home/logo.png');
$public_contact = isset($public_contact) ? $public_contact : array();
$public_phone  = !empty($public_contact['phone'])     ? $public_contact['phone']     : 'Contact Admin';
$public_address = !empty($public_contact['address'])  ? $public_contact['address']   : '';
$admin_name    = !empty($public_contact['full_name']) ? $public_contact['full_name'] : 'Admin';
$hide_page_hero = !empty($hide_page_hero);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#1f4f8f">
    <title><?php echo $page_title !== '' ? html_escape($page_title) . ' | ' : ''; ?>Cab Booking Fast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── Reset & Tokens ───────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }

        :root {
            --bg: #fbf8ee;
            --surface: #ffffff;
            --surface-soft: #fff6dc;
            --ink: #17355c;
            --ink-2: #476483;
            --muted: #6d7f96;
            --border: rgba(23, 53, 92, 0.10);
            --border-md: rgba(23, 53, 92, 0.18);
            --accent: #235ea7;
            --accent-dark: #163f72;
            --accent-light: #fff0ba;
            --header-bg: #ffffff;
            --shadow-xs: 0 1px 4px rgba(23, 53, 92, .06);
            --shadow-sm: 0 6px 18px rgba(23, 53, 92, .08);
            --shadow-md: 0 16px 40px rgba(23, 53, 92, .10);
            --r-sm: 10px;
            --r-md: 18px;
            --r-lg: 26px;
            --r-xl: 34px;
            --font-display: 'Fraunces', Georgia, serif;
            --font-body: 'Plus Jakarta Sans', system-ui, sans-serif;
        }

        body {
            min-height: 100vh;
            font-family: var(--font-body);
            font-size: 14px;
            line-height: 1.65;
            color: var(--ink);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        /* ── Layout ───────────────────────────────────────────────── */
        .wrap {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ── HEADER ───────────────────────────────────────────────── */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 500;
            background: linear-gradient(180deg, #fffdf5 0%, #fff9e9 100%);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 8px 22px rgba(23, 53, 92, .06);
        }

        .hrow {
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        /* Logo block */
        .hlogo {
            display: inline-flex;
            align-items: center;
            flex-shrink: 0;
            text-decoration: none;
        }

        .hlogo-img-wrap {
            width: 148px;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: visible;
        }

        .hlogo-img-wrap img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .hlogo-text {
            display: none;
        }

        .hlogo-brand {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 700;
            line-height: 1.1;
            color: var(--ink);
            letter-spacing: -0.02em;
        }

        .hlogo-tagline {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Admin contact pill */
        .hcontact {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px 12px 12px;
            background: linear-gradient(135deg, #fffef9 0%, #fff4cd 100%);
            border: 1px solid var(--border-md);
            border-radius: 999px;
            box-shadow: var(--shadow-xs);
        }

        .hcontact-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #235ea7 0%, #f1c14f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
        }

        .hcontact-info {
            display: flex;
            flex-direction: column;
        }

        .hcontact-name {
            font-family: var(--font-display);
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
            white-space: nowrap;
        }

        .hcontact-phone {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            margin-top: 2px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .hcontact-phone::before {
            content: '📞';
            font-size: 11px;
        }

        /* ── MAIN ─────────────────────────────────────────────────── */
        .main {
            padding: 32px 0 64px;
        }

        /* ── Page Hero ────────────────────────────────────────────── */
        .page-hero {
            margin-bottom: 24px;
            padding: 30px 32px;
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            background: linear-gradient(135deg, #fff 0%, var(--surface-soft) 100%);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 160px;
            height: 160px;
            background: radial-gradient(circle, rgba(35, 94, 167, .12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--accent);
        }

        .eyebrow::before {
            content: '';
            width: 18px;
            height: 2px;
            border-radius: 999px;
            background: currentColor;
        }

        .page-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 5vw, 48px);
            line-height: 1.06;
            color: var(--ink);
        }

        .page-subtitle {
            max-width: 680px;
            margin-top: 10px;
            font-size: 15px;
            color: var(--ink-2);
        }

        /* ── Flash Messages ───────────────────────────────────────── */
        .flash {
            margin-bottom: 16px;
            padding: 14px 18px;
            border-radius: var(--r-md);
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .flash-success {
            color: #14532d;
            background: #f0fdf4;
            border-color: #86efac;
        }

        .flash-error {
            color: #7f1d1d;
            background: #fff5f5;
            border-color: #fca5a5;
        }

        /* ── Cards ────────────────────────────────────────────────── */
        .section-card {
            margin-bottom: 24px;
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            background: var(--surface);
            box-shadow: var(--shadow-sm);
        }

        .section-card.accent-card {
            background: linear-gradient(135deg, #fffaf3 0%, #fff1e7 100%);
            color: var(--ink);
            border-color: rgba(35, 94, 167, .16);
            box-shadow: 0 12px 32px rgba(35, 94, 167, .10);
        }

        .card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .card-head h3 {
            font-family: var(--font-display);
            font-size: clamp(24px, 4vw, 40px);
            line-height: 1.08;
            letter-spacing: -0.02em;
        }

        .card-head p {
            margin-top: 8px;
            color: var(--ink-2);
            font-size: 14px;
        }

        .accent-card .card-head p {
            color: var(--ink-2);
        }

        .info-grid {
            display: grid;
            gap: 14px;
        }

        .feature-card {
            padding: 16px 18px;
            border-radius: var(--r-lg);
            border: 1px solid var(--border);
            background: var(--surface);
            box-shadow: var(--shadow-xs);
            display: grid;
            gap: 6px;
        }

        .feature-card strong {
            color: var(--ink);
            font-size: 14px;
        }

        .feature-card span {
            color: var(--ink-2);
            font-size: 13px;
            line-height: 1.65;
        }

        .accent-card .feature-card {
            background: rgba(255, 255, 255, .72);
            border-color: rgba(35, 94, 167, .14);
            box-shadow: none;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            overflow: hidden;
            background: var(--accent-light);
            border: 1px solid rgba(35, 94, 167, .16);
            color: var(--accent-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 700;
            box-shadow: var(--shadow-xs);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ── Buttons ──────────────────────────────────────────────── */
        .btn,
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 24px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: .15s ease;
        }

        .btn {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 4px 14px rgba(249, 115, 22, .30);
        }

        .btn:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--surface);
            border-color: var(--border-md);
            color: var(--ink);
        }

        .btn-secondary:hover {
            background: var(--surface-soft);
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* ── Forms ────────────────────────────────────────────────── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, minmax(0, 1fr));
            gap: 16px;
        }

        .form-grid>div {
            grid-column: span 6;
        }

        .form-grid>.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        input,
        select,
        textarea {
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1.5px solid var(--border-md);
            border-radius: var(--r-md);
            background: #fff;
            color: var(--ink);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, .12);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .helper {
            margin-top: 6px;
            font-size: 12px;
            color: var(--muted);
        }

        /* ── Split / Vehicle Grid ─────────────────────────────────── */
        .split-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(300px, 0.9fr);
            gap: 24px;
        }

        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .vehicle-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            background: #fff;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .18s, transform .18s;
        }

        .vehicle-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .vehicle-media {
            aspect-ratio: 16 / 10;
            background: var(--surface-soft);
        }

        .vehicle-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vehicle-media-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
        }

        .vehicle-empty-badge {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ede9e2;
            font-weight: 700;
        }

        .vehicle-empty-copy {
            font-size: 13px;
            color: var(--muted);
        }

        .vehicle-body {
            padding: 18px;
        }

        .vehicle-body h3 {
            font-family: var(--font-display);
            font-size: 24px;
            line-height: 1.1;
        }

        .vehicle-meta {
            margin-top: 6px;
            margin-bottom: 14px;
            color: var(--muted);
            font-size: 13px;
        }

        .spec-list {
            display: grid;
            gap: 10px;
            margin-bottom: 16px;
        }

        .spec-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
        }

        .spec-row span {
            color: var(--muted);
            font-size: 13px;
        }

        .spec-row strong {
            font-size: 13px;
            color: var(--ink);
        }

        .empty-state {
            padding: 32px 24px;
            border: 1.5px dashed var(--border-md);
            border-radius: var(--r-lg);
            text-align: center;
            color: var(--muted);
            background: #fff;
        }

        /* ── Responsive ───────────────────────────────────────────── */
        @media (max-width: 980px) {

            .split-grid,
            .vehicle-grid {
                grid-template-columns: 1fr;
            }

            .form-grid>div {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 700px) {
            .hrow {
                min-height: 72px;
                gap: 14px;
            }

            .hlogo-img-wrap {
                width: 118px;
                height: auto;
            }

            .hlogo-img-wrap img {
                width: 100%;
                height: auto;
            }

            .hcontact {
                padding: 8px 12px 8px 10px;
                gap: 10px;
            }

            .hcontact-avatar {
                width: 36px;
                height: 36px;
                font-size: 15px;
            }

            .hcontact-name {
                font-size: 14px;
            }

            .hcontact-phone {
                font-size: 11px;
            }

            .page-hero {
                padding: 22px 20px;
            }

            .section-card {
                padding: 20px 18px;
            }

            .card-head {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .wrap {
                padding: 0 16px;
            }

            .wrap {
                padding: 0 14px;
            }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════════════════════ HEADER -->
    <header class="site-header">
        <div class="wrap hrow">

            <!-- Logo + Brand Name -->
            <a class="hlogo" href="<?php echo base_url('dashboard'); ?>" aria-label="Go to Dashboard">
                <div class="hlogo-img-wrap">
                    <img src="<?php echo $brand_logo; ?>" alt="Cab Booking Fast Logo">
                </div>
            </a>

            <!-- Admin Contact Pill -->
            <div class="hcontact">
                <div class="hcontact-avatar">
                    <?php echo strtoupper(substr($admin_name, 0, 1)); ?>
                </div>
                <div class="hcontact-info">
                    <span class="hcontact-name"><?php echo html_escape($admin_name); ?></span>
                    <span class="hcontact-phone"><?php echo html_escape($public_phone); ?></span>
                </div>
            </div>

        </div>
    </header>
    <!-- ═══════════════════════════════════════════════════════════ /HEADER -->

    <main class="main">
        <div class="wrap">

            <?php if (!$hide_page_hero && ($page_title !== '' || $page_subtitle !== '')): ?>
                <section class="page-hero">
                    <?php if ($page_title !== ''): ?>
                        <h1 class="page-title"><?php echo html_escape($page_title); ?></h1>
                    <?php endif; ?>
                    <?php if ($page_subtitle !== ''): ?>
                        <p class="page-subtitle"><?php echo html_escape($page_subtitle); ?></p>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
