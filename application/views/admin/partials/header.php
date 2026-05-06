<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$segment2 = $this->uri->segment(2);
$segment3 = $this->uri->segment(3);
$payments_open = ($segment2 === 'payments');
$current_name = !empty($current_user['full_name']) ? $current_user['full_name'] : 'Administrator';
$current_profile_image = !empty($current_user['profile_image']) ? $current_user['profile_image'] : '';
$current_initials = app_user_initials($current_name);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Panel'; ?> | Cab Booking Fast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f0f4fa;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --text: #1a202c;
            --muted: #64748b;
            --muted-light: #94a3b8;
            --border: #e2e8f0;
            --border-strong: #cbd5e1;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #eff6ff;
            --primary-muted: #dbeafe;
            --success: #166534;
            --success-bg: #f0fdf4;
            --success-border: #bbf7d0;
            --success-icon: #22c55e;
            --warn: #92400e;
            --warn-bg: #fffbeb;
            --warn-border: #fde68a;
            --danger: #991b1b;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --radius-sm: 8px;
            --radius-md: 10px;
            --radius-lg: 12px;
            --sidebar-w: 264px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: var(--text);
            background: var(--bg);
            line-height: 1.5;
        }

        body.nav-open {
            overflow: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        /* ── LAYOUT ── */
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR BACKDROP ── */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s ease;
            z-index: 1000;
        }

        .sidebar-backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 1002;
        }

        /* Brand */
        .brand {
            padding: 22px 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 82px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .brand-logo-wrap {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo {
            width: auto;
            height: 52px;
            object-fit: contain;
            transition: transform .2s ease;
            filter: drop-shadow(0 10px 20px rgba(37, 99, 235, .12));
        }

        .brand-logo:hover {
            transform: scale(1.03);
        }

        .brand-divider {
            height: 1px;
            background: #edf2f7;
        }

        .brand-info strong {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        .brand-info span {
            display: block;
            font-size: 12px;
            color: var(--muted-light);
            margin-top: 1px;
        }

        .brand-divider {
            height: 1px;
            background: var(--border);
            margin: 0;
            flex-shrink: 0;
        }

        /* Nav scroll area */
        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 12px 12px 0;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        /* Nav sections */
        .nav-group {
            margin-bottom: 4px;
        }

        .nav-label {
            padding: 10px 10px 6px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--muted-light);
        }

        /* Nav links */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            color: #475569;
            font-size: 13.5px;
            font-weight: 500;
            transition: background .15s ease, color .15s ease;
            margin-bottom: 2px;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            background: var(--surface-soft);
            color: var(--text);
        }

        .nav-link.active {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-dropdown {
            margin-bottom: 4px;
        }

        .nav-dropdown.open .nav-submenu {
            display: grid;
        }

        .nav-dropdown-trigger {
            position: relative;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }

        .nav-dropdown-trigger::after {
            content: '▾';
            font-size: 11px;
            color: var(--muted-light);
            margin-left: auto;
        }

        .nav-submenu {
            margin: 4px 0 8px 42px;
            padding-left: 10px;
            border-left: 1px solid var(--border);
            display: none;
            gap: 4px;
        }

        .nav-dropdown-trigger::after {
            content: '';
            width: 7px;
            height: 7px;
            border-right: 1.5px solid currentColor;
            border-bottom: 1.5px solid currentColor;
            font-size: 0;
            color: var(--muted-light);
            margin-left: auto;
            transform: rotate(45deg);
            transition: transform .18s ease;
        }

        .nav-dropdown.open .nav-dropdown-trigger::after {
            transform: rotate(225deg);
        }

        .nav-sublink {
            display: block;
            padding: 8px 10px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 600;
            color: var(--muted);
            transition: background .15s ease, color .15s ease;
        }

        .nav-sublink:hover {
            background: var(--surface-soft);
            color: var(--text);
        }

        .nav-sublink.active {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
            background: var(--surface-soft);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .nav-link.active .nav-icon {
            background: var(--primary-muted);
            color: var(--primary);
            border-color: #bfdbfe;
        }

        .nav-copy {
            flex: 1;
            min-width: 0;
        }

        .nav-copy strong {
            display: block;
            font-size: 13.5px;
            font-weight: 500;
        }

        .nav-copy span {
            display: block;
            font-size: 11px;
            color: var(--muted-light);
            margin-top: 1px;
        }

        .nav-link.active .nav-copy span {
            color: #93c5fd;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid var(--border);
            flex-shrink: 0;
        }

        .footer-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--primary);
            flex-shrink: 0;
            overflow: hidden;
        }

        .footer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .footer-info strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .footer-info span {
            display: block;
            font-size: 11px;
            color: var(--muted-light);
            margin-top: 1px;
        }

        /* ── MAIN ── */
        .main {
            flex: 1;
            min-width: 0;
            padding: 20px;
        }

        /* ── TOPBAR ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 12px 18px;
            margin-bottom: 20px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        /* Hamburger */
        .menu-toggle {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            flex-direction: column;
            gap: 4px;
            padding: 0;
        }

        .menu-toggle span {
            display: block;
            width: 16px;
            height: 1.5px;
            background: currentColor;
            border-radius: 2px;
            transition: transform .18s ease, opacity .18s ease;
        }

        .menu-toggle.active span:nth-child(1) {
            transform: translateY(5.5px) rotate(45deg);
        }

        .menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .menu-toggle.active span:nth-child(3) {
            transform: translateY(-5.5px) rotate(-45deg);
        }

        .topbar-copy h1 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-copy p {
            font-size: 12px;
            color: var(--muted-light);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            font-size: 15px;
        }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid var(--surface);
        }

        /* Profile pill */
        .profile-dropdown {
            position: relative;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 5px 14px 5px 5px;
            background: var(--surface);
            cursor: pointer;
            transition: border-color .15s;
        }

        .profile-trigger:hover {
            border-color: var(--border-strong);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: var(--primary);
            overflow: hidden;
            flex-shrink: 0;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-meta strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .profile-meta span {
            display: block;
            font-size: 11px;
            color: var(--muted-light);
            margin-top: 1px;
        }

        .profile-caret {
            font-size: 10px;
            color: var(--muted-light);
            margin-left: 2px;
            transition: transform .15s;
        }

        .profile-dropdown.open .profile-caret {
            transform: rotate(180deg);
        }

        /* Dropdown panel */
        .dropdown-panel {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 240px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            box-shadow: 0 8px 24px rgba(15, 23, 42, .10);
            padding: 8px;
            opacity: 0;
            transform: translateY(6px);
            pointer-events: none;
            transition: opacity .15s ease, transform .15s ease;
            z-index: 100;
        }

        .profile-dropdown.open .dropdown-panel {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .dropdown-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: var(--surface-soft);
            border-radius: var(--radius-sm);
            margin-bottom: 6px;
        }

        .dropdown-user .profile-avatar {
            width: 36px;
            height: 36px;
            font-size: 13px;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        .dropdown-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            color: #475569;
            transition: background .12s;
        }

        .dropdown-link:hover {
            background: var(--surface-soft);
            color: var(--text);
        }

        .dropdown-link.logout {
            color: #dc2626;
        }

        .dropdown-link.logout:hover {
            background: var(--danger-bg);
        }

        /* ── PAGE HERO ── */
        .page-hero {
            padding: 0 2px 18px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 6px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.15;
        }

        .page-subtitle {
            font-size: 13.5px;
            color: var(--muted);
            margin-top: 6px;
            max-width: 680px;
        }

        .page-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ── BUTTONS ── */
        .btn,
        .btn-secondary,
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 13.5px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, border-color .15s;
            white-space: nowrap;
        }

        .btn {
            background: var(--primary);
            color: #fff;
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--surface);
            border-color: var(--border-strong);
            color: var(--text);
        }

        .btn-secondary:hover {
            border-color: var(--border-strong);
            background: var(--surface-soft);
        }

        .btn-ghost {
            background: var(--surface-soft);
            border-color: var(--border);
            color: var(--muted);
        }

        .btn-ghost:hover {
            background: var(--border);
        }

        /* ── FLASH MESSAGES ── */
        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 16px;
            border: 1px solid transparent;
        }

        .flash-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .flash-success {
            background: var(--success-bg);
            border-color: var(--success-border);
            color: var(--success);
        }

        .flash-success .flash-icon {
            background: var(--success-icon);
        }

        .flash-error {
            background: var(--danger-bg);
            border-color: var(--danger-border);
            color: var(--danger);
        }

        .flash-error .flash-icon {
            background: #ef4444;
        }

        /* ── CARDS ── */
        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 22px;
            margin-bottom: 20px;
        }

        .card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }

        .card-head h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .card-head p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 18px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--muted-light);
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            margin: 12px 0 6px;
        }

        .stat-note {
            font-size: 13px;
            color: var(--muted);
        }

        .stat-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            background: var(--primary-soft);
            color: var(--primary);
        }

        /* ── TABLE ── */
        .table-wrap {
            overflow: auto;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        thead th {
            background: var(--surface-soft);
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: var(--surface-soft);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── BADGES ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: capitalize;
        }

        .badge-pending {
            background: var(--warn-bg);
            color: var(--warn);
        }

        .badge-confirmed,
        .badge-completed,
        .badge-available,
        .badge-approved {
            background: var(--success-bg);
            color: var(--success);
        }

        .badge-cancelled,
        .badge-rejected,
        .badge-missing {
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* ── FORMS ── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .full {
            grid-column: 1/-1;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #475569;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-strong);
            background: #fff;
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
        }

        .helper {
            font-size: 12px;
            color: var(--muted-light);
            margin-top: 5px;
        }

        /* ── SPLIT GRID ── */
        .split-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 28px;
            border: 1px dashed var(--border-strong);
            border-radius: var(--radius-md);
            background: var(--surface-soft);
            text-align: center;
            color: var(--muted);
            font-size: 13.5px;
        }

        /* ── MINI LIST ── */
        .mini-list {
            display: grid;
            gap: 10px;
        }

        .mini-item {
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--surface-soft);
        }

        .mini-item strong {
            display: block;
            font-size: 13.5px;
            font-weight: 500;
        }

        .mini-item span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .split-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 980px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform .22s ease;
                box-shadow: 4px 0 20px rgba(15, 23, 42, .10);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .menu-toggle {
                display: inline-flex;
            }

            .main {
                padding: 14px;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-wrap: wrap;
            }

            .profile-trigger {
                padding: 5px 10px 5px 5px;
            }

            .topbar {
                padding: 10px 12px;
                border-radius: 14px;
            }

            .topbar-left {
                flex: 1;
                min-width: 0;
            }

            /* Hide welcome text */
            .topbar-copy p {
                display: none;
            }

            /* Title smaller */
            .topbar-copy h1 {
                font-size: 15px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Only profile image show */
            .profile-trigger {
                padding: 0;
                border: none;
                background: transparent;
                gap: 0;
            }

            /* Hide admin name + role */
            .profile-meta,
            .profile-caret {
                display: none;
            }

            /* Bigger clean round image */
            .profile-avatar {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                border: 2px solid #dbeafe;
                box-shadow: 0 4px 14px rgba(37, 99, 235, 0.15);
            }

            .profile-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Dropdown align properly */
            .dropdown-panel {
                position: fixed;
                top: 68px;
                right: 12px;
                left: 12px;
                width: auto;
                max-width: calc(100vw - 24px);
                border-radius: 14px;
                overflow: hidden;
                z-index: 9999;
            }

            .dropdown-user {
                padding: 14px;
            }

            .dropdown-link {
                padding: 12px 14px;
                font-size: 14px;
            }

            .dropdown-user {
                display: none;
            }

            /* Remove extra top spacing */
            .dropdown-panel {
                padding-top: 6px;
            }


        }

        @media (max-width: 640px) {
            .page-hero {
                flex-direction: column;
            }

            .page-title {
                font-size: 22px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-actions {
                width: 100%;
            }

            .page-actions>* {
                flex: 1;
            }

            .topbar-right {
                flex-wrap: wrap;
            }

            .dropdown-panel {
                left: 0;
                right: auto;
                width: calc(100vw - 28px);
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-backdrop js-sidebar-backdrop"></div>
    <div class="app-shell">

        <!-- ══ SIDEBAR ══ -->
        <aside class="sidebar js-sidebar" aria-label="Admin navigation">

            <!-- Brand -->
            <div class="brand">
                <div class="brand-logo-wrap">
                    <img src="<?php echo base_url('assets/home/logo.png'); ?>" alt="Logo" class="brand-logo">
                </div>
            </div>
            <div class="brand-divider"></div>

            <!-- Nav -->
            <div class="sidebar-scroll">

                <div class="nav-group">
                    <div class="nav-label">Overview</div>
                    <a class="nav-link <?php echo ($segment2 === 'dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('admin/dashboard'); ?>">
                        <div class="nav-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="3" width="7" height="7" rx="1" />
                                <rect x="14" y="14" width="7" height="7" rx="1" />
                                <rect x="3" y="14" width="7" height="7" rx="1" />
                            </svg>
                        </div>
                        <div class="nav-copy">
                            <strong>Dashboard</strong>
                            <span>Summary &amp; insights</span>
                        </div>
                    </a>
                </div>

                <div class="nav-group">
                    <div class="nav-label">Operations</div>
                    <a class="nav-link <?php echo ($segment2 === 'bookings') ? 'active' : ''; ?>" href="<?php echo base_url('admin/bookings'); ?>">
                        <div class="nav-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                <path d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                        </div>
                        <div class="nav-copy">
                            <strong>Bookings</strong>
                            <span>Track reservations</span>
                        </div>
                    </a>
                    <a class="nav-link <?php echo ($segment2 === 'vehicles') ? 'active' : ''; ?>" href="<?php echo base_url('admin/vehicles'); ?>">
                        <div class="nav-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M5 17H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h13l4 5v5h-2" />
                                <circle cx="7.5" cy="17.5" r="2.5" />
                                <circle cx="17.5" cy="17.5" r="2.5" />
                            </svg>
                        </div>
                        <div class="nav-copy">
                            <strong>Vehicles</strong>
                            <span>Fleet &amp; pricing</span>
                        </div>
                    </a>
                    <div class="nav-dropdown <?php echo $payments_open ? 'open' : ''; ?>">
                        <button class="nav-link nav-dropdown-trigger js-nav-dropdown-trigger <?php echo ($segment2 === 'payments') ? 'active' : ''; ?>" type="button" aria-expanded="<?php echo $payments_open ? 'true' : 'false'; ?>">
                            <div class="nav-icon">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="5" width="20" height="14" rx="2" />
                                    <path d="M2 10h20" />
                                </svg>
                            </div>
                            <div class="nav-copy">
                                <strong>Payments</strong>
                                <span>Requests &amp; bank details</span>
                            </div>
                        </button>
                        <div class="nav-submenu">
                            <a class="nav-sublink <?php echo ($segment2 === 'payments' && $segment3 === 'settings') ? 'active' : ''; ?>" href="<?php echo base_url('admin/payments/settings'); ?>">Add Details</a>
                            <a class="nav-sublink <?php echo ($segment2 === 'payments' && $segment3 !== 'settings') ? 'active' : ''; ?>" href="<?php echo base_url('admin/payments/requests'); ?>">See Requests</a>
                        </div>
                    </div>
                    <a class="nav-link <?php echo ($segment2 === 'documents') ? 'active' : ''; ?>" href="<?php echo base_url('admin/documents'); ?>">
                        <div class="nav-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <div class="nav-copy">
                            <strong>Documents</strong>
                            <span>Review uploads</span>
                        </div>
                    </a>
                    <a class="nav-link <?php echo ($segment2 === 'customers') ? 'active' : ''; ?>" href="<?php echo base_url('admin/customers'); ?>">
                        <div class="nav-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <div class="nav-copy">
                            <strong>Customers</strong>
                            <span>Profiles &amp; history</span>
                        </div>
                    </a>
                </div>

            </div>

        </aside>

        <!-- ══ MAIN ══ -->
        <main class="main">

            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle js-menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">
                        <span></span><span></span><span></span>
                    </button>
                    <div class="topbar-copy">
                        <h1><?php echo isset($page_title) ? html_escape($page_title) : 'Dashboard'; ?></h1>
                        <p>Welcome back, <?php echo html_escape($current_name); ?></p>
                    </div>
                </div>

                <div class="topbar-right">
                    <div class="profile-dropdown js-profile-dropdown">
                        <button class="profile-trigger js-profile-trigger" type="button" aria-expanded="false">
                            <div class="profile-avatar">
                                <?php if ($current_profile_image): ?>
                                    <img src="<?php echo app_profile_image_url($current_profile_image); ?>" alt="<?php echo html_escape($current_name); ?>">
                                <?php else: ?>
                                    <?php echo html_escape($current_initials); ?>
                                <?php endif; ?>
                            </div>
                            <div class="profile-meta">
                                <strong><?php echo html_escape($current_name); ?></strong>
                                <span>Administrator</span>
                            </div>
                            <span class="profile-caret">▾</span>
                        </button>

                        <div class="dropdown-panel">
                            <div class="dropdown-user">
                                <div class="profile-avatar" style="width:36px;height:36px;font-size:13px;">
                                    <?php if ($current_profile_image): ?>
                                        <img src="<?php echo app_profile_image_url($current_profile_image); ?>" alt="<?php echo html_escape($current_name); ?>">
                                    <?php else: ?>
                                        <?php echo html_escape($current_initials); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="profile-meta">
                                    <strong><?php echo html_escape($current_name); ?></strong>
                                    <span><?php echo !empty($current_user['email']) ? html_escape($current_user['email']) : 'Admin account'; ?></span>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-link" href="<?php echo base_url('admin/profile'); ?>">
                                <span>My Profile</span>
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </a>
                            <a class="dropdown-link" href="<?php echo base_url('admin/profile'); ?>">
                                <span>Change Password</span>
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-link logout" href="<?php echo base_url('admin/logout'); ?>">
                                <span>Logout</span>
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page hero -->
            <div class="page-hero">
                <div>
                    <div class="eyebrow">Admin Panel</div>
                    <h2 class="page-title"><?php echo isset($page_title) ? html_escape($page_title) : 'Dashboard'; ?></h2>
                    <div class="page-subtitle">Manage your fleet, bookings, documents and daily rental operations from one clean workspace.</div>
                </div>
            </div>

            <!-- Flash messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="flash flash-success">
                    <div class="flash-icon">&#10003;</div>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="flash flash-error">
                    <div class="flash-icon">&#33;</div>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Page content injected here by individual view files -->