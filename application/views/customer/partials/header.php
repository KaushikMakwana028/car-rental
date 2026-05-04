<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$segment2 = $this->uri->segment(2);
$segment3 = $this->uri->segment(3);
$current_name = !empty($current_user['full_name']) ? $current_user['full_name'] : 'Customer';
$current_profile_image = !empty($current_user['profile_image']) ? $current_user['profile_image'] : '';
$current_initials = app_user_initials($current_name);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? $page_title : 'Customer Portal'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg:#f8fafc;--surface:#fff;--surface-soft:#f5f7fb;--text:#101828;--muted:#667085;
            --border:#e4e7ec;--border-strong:#d0d5dd;--primary:#16a34a;--primary-dark:#15803d;--primary-soft:#dcfce7;
            --success:#16a34a;--success-soft:#dcfce7;--warn:#d97706;--warn-soft:#ffedd5;--danger:#dc2626;--danger-soft:#fee2e2;
        }
        *{box-sizing:border-box} html{scroll-behavior:smooth}
        body{margin:0;font-family:'Manrope',sans-serif;color:var(--text);background:var(--bg)}
        body.nav-open{overflow:hidden} a{text-decoration:none;color:inherit} button,input,select,textarea{font:inherit}
        .container{max-width:1280px;margin:0 auto;padding:0 18px}
        .site-header{position:sticky;top:0;z-index:1001;background:rgba(248,250,252,.95);backdrop-filter:blur(8px);border-bottom:1px solid var(--border)}
        .header-row{height:78px;display:flex;align-items:center;justify-content:space-between;gap:16px}
        .brand{display:flex;align-items:center;gap:12px}
        .brand-mark{width:44px;height:44px;border-radius:14px;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800}
        .brand-copy strong{display:block;font-size:24px;line-height:1;font-weight:800;letter-spacing:-.02em;color:#14532d}
        .brand-copy span{display:block;font-size:11px;color:#166534;margin-top:2px}
        .top-nav{display:flex;align-items:center;gap:8px}
        .top-nav .nav-link{padding:10px 14px;border-radius:999px;border:1px solid transparent;font-size:13px;font-weight:700;color:#344054}
        .top-nav .nav-link:hover{background:var(--surface-soft);border-color:var(--border)}
        .top-nav .nav-link.active{background:var(--primary-soft);color:#166534;border-color:#bbf7d0}
        .header-right{display:flex;align-items:center;gap:10px}
        .icon-button,.menu-toggle{width:40px;height:40px;border-radius:12px;border:1px solid var(--border);background:#fff;color:#667085;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;position:relative}
        .menu-toggle{display:none}
        .notification-dot{position:absolute;top:6px;right:6px;min-width:16px;height:16px;border-radius:999px;background:#ef4444;color:#fff;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;padding:0 4px}
        .profile-dropdown{position:relative}
        .profile-trigger{display:flex;align-items:center;gap:10px;padding:4px 10px 4px 4px;border-radius:999px;border:1px solid var(--border);background:#fff;cursor:pointer;min-width:208px}
        .profile-avatar{width:34px;height:34px;border-radius:50%;overflow:hidden;background:var(--primary-soft);display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--primary)}
        .profile-avatar img{width:100%;height:100%;object-fit:cover;display:block}
        .profile-meta{min-width:0;flex:1;text-align:left}
        .profile-meta strong{display:block;font-size:13px;font-weight:800;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .profile-meta span{display:block;font-size:11px;color:var(--muted)}
        .profile-caret{font-size:11px;color:#98a2b3;transition:transform .18s ease}
        .profile-dropdown.open .profile-caret{transform:rotate(180deg)}
        .dropdown-panel{position:absolute;top:calc(100% + 10px);right:0;width:260px;padding:10px;border-radius:14px;border:1px solid var(--border);background:#fff;box-shadow:0 18px 40px rgba(16,24,40,.12);opacity:0;transform:translateY(8px);pointer-events:none;transition:all .18s ease}
        .profile-dropdown.open .dropdown-panel{opacity:1;transform:translateY(0);pointer-events:auto}
        .dropdown-head{display:flex;align-items:center;gap:10px;padding:10px;border-radius:12px;background:var(--surface-soft);margin-bottom:8px}
        .dropdown-links{display:grid;gap:6px}
        .dropdown-link{display:flex;align-items:center;justify-content:space-between;padding:10px 12px;border-radius:10px;border:1px solid transparent;font-size:13px}
        .dropdown-link:hover{background:var(--surface-soft);border-color:var(--border)}
        .dropdown-link.logout-link{color:#b91c1c;background:#fff5f5}
        .mobile-backdrop{position:fixed;inset:0;background:rgba(15,23,42,.45);opacity:0;pointer-events:none;transition:opacity .2s ease;z-index:999}
        .mobile-backdrop.open{opacity:1;pointer-events:auto}
        .mobile-drawer{position:fixed;top:0;left:0;width:290px;max-width:88vw;height:100vh;background:#fff;border-right:1px solid var(--border);padding:20px 14px;transform:translateX(-100%);transition:transform .22s ease;z-index:1000}
        .mobile-drawer.open{transform:translateX(0)}
        .mobile-drawer .top-nav{display:grid;gap:8px}
        .mobile-drawer .nav-link{display:block;border-radius:12px}
        .main{padding:22px 0}
        .page-hero{display:flex;align-items:flex-start;justify-content:space-between;gap:18px;margin-bottom:20px}
        .eyebrow{font-size:11px;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:var(--primary);margin-bottom:6px}
        .page-title{margin:0;font-size:42px;line-height:1.04;font-weight:800;letter-spacing:-.03em}
        .page-subtitle{margin-top:8px;color:var(--muted);font-size:15px;max-width:760px}
        .btn,.btn-secondary,.btn-ghost{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 16px;border-radius:12px;font-weight:800;border:1px solid transparent;cursor:pointer}
        .btn{background:var(--primary);color:#fff;box-shadow:0 8px 18px rgba(22,163,74,.22)} .btn:hover{background:var(--primary-dark)}
        .btn-secondary{background:#fff;border-color:var(--border-strong);color:var(--text)} .btn-ghost{background:var(--surface-soft);border-color:var(--border);color:var(--muted)}
        .flash{padding:14px 16px;border-radius:12px;margin-bottom:16px;border:1px solid transparent;font-weight:600}
        .flash-success{background:var(--success-soft);border-color:#bbf7d0;color:#166534} .flash-error{background:var(--danger-soft);border-color:#fecaca;color:#991b1b}
        .section-card{background:#fff;border:1px solid var(--border);border-radius:20px;box-shadow:0 10px 26px rgba(16,24,40,.05);padding:22px;margin-bottom:20px}
        .card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px;margin-bottom:16px}
        .card-head h3{margin:0;font-size:30px;font-weight:800;letter-spacing:-.02em} .card-head p{margin:6px 0 0;color:var(--muted);font-size:14px}
        .stats-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-bottom:20px}
        .stat-card{background:linear-gradient(180deg,#fff 0%,#f9fafb 100%);border:1px solid var(--border);border-radius:16px;padding:18px}
        .stat-top{display:flex;align-items:center;justify-content:space-between;gap:8px}
        .stat-label{font-size:12px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--muted)}
        .stat-chip{font-size:11px;padding:6px 10px;border-radius:999px;background:var(--primary-soft);color:#166534;font-weight:800}
        .stat-value{font-size:34px;font-weight:800;margin:12px 0 8px} .stat-note{color:var(--muted);font-size:14px}
        .split-grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}
        .table-wrap{overflow:auto;border:1px solid var(--border);border-radius:14px}
        table{width:100%;border-collapse:collapse;background:#fff}
        thead th{background:#f8fafc;color:#667085;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:13px 14px;text-align:left;border-bottom:1px solid var(--border)}
        tbody td{padding:14px;border-bottom:1px solid #edf1f6;font-size:14px;vertical-align:middle}
        tbody tr:hover{background:#fcfdff} tbody tr:last-child td{border-bottom:none}
        .badge{display:inline-flex;align-items:center;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:800;text-transform:capitalize}
        .badge-pending{background:var(--warn-soft);color:var(--warn)} .badge-confirmed,.badge-completed,.badge-available,.badge-approved{background:var(--success-soft);color:var(--success)}
        .badge-booked,.badge-cancelled,.badge-service,.badge-rejected,.badge-missing{background:var(--danger-soft);color:var(--danger)}
        .form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px} .full{grid-column:1/-1}
        label{display:block;margin-bottom:8px;font-size:12px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:#475467}
        input,select,textarea{width:100%;padding:12px 13px;border-radius:12px;border:1px solid var(--border-strong);background:#fff;color:var(--text);outline:none;transition:.18s ease}
        input:focus,select:focus,textarea:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(22,163,74,.12)}
        .helper{font-size:13px;color:var(--muted);margin-top:6px}
        .empty-state{padding:28px;border:1px dashed var(--border-strong);border-radius:14px;background:#fafcff;text-align:center;color:var(--muted)}
        .mini-list{display:grid;gap:12px} .mini-item{padding:14px 16px;border:1px solid var(--border);border-radius:14px;background:var(--surface-soft)}
        .mini-item strong{display:block;font-size:14px} .mini-item span{display:block;font-size:13px;color:var(--muted);margin-top:4px}
        .vehicle-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
        .vehicle-card{border:1px solid var(--border);border-radius:16px;background:#fff;padding:16px;box-shadow:0 8px 20px rgba(16,24,40,.04)}
        .docs-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .doc-card{border:1px solid var(--border);border-radius:14px;background:#fff;padding:16px;display:flex;align-items:center;justify-content:space-between;gap:14px}
        .doc-left{display:flex;align-items:center;gap:14px}
        .doc-icon{width:40px;height:40px;border-radius:12px;background:var(--primary-soft);display:flex;align-items:center;justify-content:center;font-weight:900;color:#166534}
        .doc-meta strong{display:block;font-size:15px}.doc-meta span{display:block;font-size:13px;color:var(--muted);margin-top:4px}
        .progress-shell{display:flex;align-items:center;gap:16px}
        .progress-bar{width:160px;height:8px;border-radius:999px;background:#e4e7ec;overflow:hidden}
        .progress-fill{height:100%;background:linear-gradient(90deg,#16a34a,#22c55e)}
        .upload-panel{border:2px dashed var(--border-strong);border-radius:16px;background:#fafcff;padding:22px}
        .vehicle-card h3,.vehicle-card h4{margin:0 0 6px} .vehicle-meta{color:var(--muted);font-size:13px;margin-bottom:14px}
        .spec-row{display:flex;justify-content:space-between;gap:10px;font-size:14px;margin:8px 0}
        @media (max-width:1200px){.stats-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.split-grid,.vehicle-grid,.docs-grid{grid-template-columns:1fr 1fr}}
        @media (max-width:1024px){.top-nav{display:none}.menu-toggle{display:inline-flex}}
        @media (max-width:900px){.form-grid{grid-template-columns:1fr}.profile-trigger{min-width:0}.profile-meta strong{max-width:110px}.page-hero{flex-direction:column}}
        @media (max-width:640px){.container{padding:0 12px}.header-row{height:72px}.brand-copy strong{font-size:20px}.topbar-right{justify-content:space-between}.dropdown-panel{left:0;right:auto;width:100%}.page-title{font-size:30px}.page-subtitle{font-size:14px}.section-card{padding:16px}.stats-grid,.vehicle-grid,.docs-grid{grid-template-columns:1fr}.btn,.btn-secondary,.btn-ghost{width:100%}}
    </style>
</head>
<body>
<div class="mobile-backdrop js-mobile-backdrop"></div>
<header class="site-header">
    <div class="container header-row">
        <div class="brand">
            <div class="brand-mark"><?php echo html_escape($current_initials); ?></div>
            <div class="brand-copy"><strong>DriveEase</strong><span>Self-drive rentals</span></div>
        </div>
        <nav class="top-nav">
            <a class="nav-link <?php echo ($segment2 === 'dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('customer/dashboard'); ?>">Dashboard</a>
            <a class="nav-link <?php echo ($segment2 === 'vehicles') ? 'active' : ''; ?>" href="<?php echo base_url('customer/vehicles'); ?>">Cars</a>
            <a class="nav-link <?php echo ($segment2 === 'bookings' && $segment3 !== 'create') ? 'active' : ''; ?>" href="<?php echo base_url('customer/bookings'); ?>">Bookings</a>
            <a class="nav-link <?php echo ($segment2 === 'documents') ? 'active' : ''; ?>" href="<?php echo base_url('customer/documents'); ?>">Documents</a>
            <a class="nav-link <?php echo ($segment2 === 'bookings' && $segment3 === 'create') ? 'active' : ''; ?>" href="<?php echo base_url('customer/bookings/create'); ?>">Book Vehicle</a>
        </nav>
        <div class="header-right">
            <button class="menu-toggle js-menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            </button>
            <button class="icon-button" type="button" aria-label="Notifications">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 7h18s-3 0-3-7"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="notification-dot">3</span>
            </button>
            <div class="profile-dropdown js-profile-dropdown">
                <button class="profile-trigger js-profile-trigger" type="button" aria-expanded="false">
                    <div class="profile-avatar">
                        <?php if ($current_profile_image): ?><img src="<?php echo app_profile_image_url($current_profile_image); ?>" alt="<?php echo html_escape($current_name); ?>"><?php else: ?><?php echo html_escape($current_initials); ?><?php endif; ?>
                    </div>
                    <div class="profile-meta"><strong><?php echo html_escape($current_name); ?></strong><span>Customer</span></div>
                    <div class="profile-caret">&#9662;</div>
                </button>
                <div class="dropdown-panel">
                    <div class="dropdown-head">
                        <div class="profile-avatar"><?php if ($current_profile_image): ?><img src="<?php echo app_profile_image_url($current_profile_image); ?>" alt="<?php echo html_escape($current_name); ?>"><?php else: ?><?php echo html_escape($current_initials); ?><?php endif; ?></div>
                        <div class="profile-meta"><strong><?php echo html_escape($current_name); ?></strong><span><?php echo !empty($current_user['email']) ? html_escape($current_user['email']) : 'Customer account'; ?></span></div>
                    </div>
                    <div class="dropdown-links">
                        <a class="dropdown-link" href="<?php echo base_url('customer/profile'); ?>"><span>My Profile</span><strong>&rsaquo;</strong></a>
                        <a class="dropdown-link logout-link" href="<?php echo base_url('customer/logout'); ?>"><span>Logout</span><strong>&rsaquo;</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<aside class="mobile-drawer js-mobile-drawer" aria-label="Customer navigation">
    <nav class="top-nav">
        <a class="nav-link <?php echo ($segment2 === 'dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('customer/dashboard'); ?>">Dashboard</a>
        <a class="nav-link <?php echo ($segment2 === 'vehicles') ? 'active' : ''; ?>" href="<?php echo base_url('customer/vehicles'); ?>">Cars</a>
        <a class="nav-link <?php echo ($segment2 === 'bookings' && $segment3 !== 'create') ? 'active' : ''; ?>" href="<?php echo base_url('customer/bookings'); ?>">Bookings</a>
        <a class="nav-link <?php echo ($segment2 === 'documents') ? 'active' : ''; ?>" href="<?php echo base_url('customer/documents'); ?>">Documents</a>
        <a class="nav-link <?php echo ($segment2 === 'bookings' && $segment3 === 'create') ? 'active' : ''; ?>" href="<?php echo base_url('customer/bookings/create'); ?>">Book Vehicle</a>
    </nav>
</aside>
<main class="main">
    <div class="container">
        <div class="page-hero">
            <div>
                <div class="eyebrow">DriveEasy Rentals</div>
                <h2 class="page-title"><?php echo isset($page_title) ? $page_title : 'Customer Dashboard'; ?></h2>
                <div class="page-subtitle">Find the right car, plan your trip, submit documents, and manage bookings in one smooth rental website experience.</div>
            </div>
        </div>
        <?php if ($this->session->flashdata('success')): ?><div class="flash flash-success"><?php echo $this->session->flashdata('success'); ?></div><?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?><div class="flash flash-error"><?php echo $this->session->flashdata('error'); ?></div><?php endif; ?>
