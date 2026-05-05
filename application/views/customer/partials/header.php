<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$segment2 = $this->uri->segment(2);
$segment3 = $this->uri->segment(3);
$current_name          = !empty($current_user['full_name'])      ? $current_user['full_name']      : 'Customer';
$current_profile_image = !empty($current_user['profile_image'])  ? $current_user['profile_image']  : '';
$current_initials      = app_user_initials($current_name);
$is_customer_logged_in = isset($is_customer_logged_in)
    ? (bool) $is_customer_logged_in
    : (!empty($current_user['id']) && isset($current_user['role']) && (int) $current_user['role'] === 0);
$page_title    = isset($page_title)    ? $page_title    : 'Customer Area';
$page_subtitle = isset($page_subtitle) ? $page_subtitle : 'Explore the fleet, manage bookings, upload documents, and keep your profile updated.';
$brand_logo    = base_url('assets/home/logo.png');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo html_escape($page_title); ?> | Cab Booking Fast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ─── TOKENS ──────────────────────────────────── */
        :root {
            --bg: #f7f5f2;
            --bg2: #edeae4;
            --sur: #ffffff;
            --bdr: #e4e0d8;
            --bdr2: #d3cdc2;
            --ink: #18150f;
            --ink2: #3a3226;
            --ink3: #6b6050;
            --ink4: #9c8f7e;
            --gold: #b8750a;
            --gold-h: #9a600a;
            --gold-bg: #fef6e7;
            --gold-mid: #f0d49a;
            --forest: #1c3d35;
            --forest2: #254f45;
            --ok: #166534;
            --ok-bg: #dcfce7;
            --warn: #92400e;
            --warn-bg: #fef3c7;
            --err: #991b1b;
            --err-bg: #fee2e2;
            --r1: 4px;
            --r2: 8px;
            --r3: 12px;
            --r4: 18px;
            --r5: 24px;
            --r6: 999px;
            --s1: 0 1px 3px rgba(0, 0, 0, .06);
            --s2: 0 3px 10px rgba(0, 0, 0, .07);
            --s3: 0 6px 20px rgba(0, 0, 0, .09);
            --s4: 0 16px 48px rgba(0, 0, 0, .11);
            --s5: 0 28px 72px rgba(0, 0, 0, .13);
            --hh: 64px;
            --fd: 'Fraunces', Georgia, serif;
            --fb: 'Inter', system-ui, sans-serif;
        }

        /* ─── RESET ───────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%
        }

        body {
            font-family: var(--fb);
            font-size: 14px;
            line-height: 1.6;
            color: var(--ink);
            background: var(--bg);
            min-height: 100vh
        }

        body.nav-open {
            overflow: hidden
        }

        a {
            text-decoration: none;
            color: inherit
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
            border: none;
            background: none
        }

        img {
            max-width: 100%;
            display: block
        }

        /* ─── LAYOUT ──────────────────────────────────── */
        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 22px
        }

        /* ─── HEADER ──────────────────────────────────── */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 500;
            height: var(--hh);
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(18px) saturate(160%);
            -webkit-backdrop-filter: blur(18px) saturate(160%);
            border-bottom: 1px solid var(--bdr);
            box-shadow: var(--s1);
        }

        .hrow {
            height: var(--hh);
            display: flex;
            align-items: center;
        }

        /* logo */
        .hlogo {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            margin-right: 28px;
        }

        .hlogo-mark {
            width: 36px;
            height: 36px;
            border-radius: var(--r2);
            background: linear-gradient(135deg, #fef0cc, #e8c060);
            border: 1px solid rgba(184, 117, 10, .18);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(184, 117, 10, .18);
            flex-shrink: 0;
        }

        .hlogo-mark img {
            width: 22px;
            height: 22px;
            object-fit: contain
        }

        .hlogo-txt b {
            display: block;
            font-family: var(--fd);
            font-size: 17px;
            font-weight: 600;
            color: var(--ink2);
            line-height: 1.1;
            letter-spacing: -.01em;
        }

        .hlogo-txt small {
            display: block;
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--ink4);
            margin-top: 1px;
        }

        /* nav */
        .hnav {
            display: flex;
            align-items: center;
            gap: 1px;
            flex: 1
        }

        .hnav a {
            padding: 7px 12px;
            border-radius: var(--r2);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink3);
            white-space: nowrap;
            transition: background .12s, color .12s;
        }

        .hnav a:hover {
            background: var(--bg2);
            color: var(--ink2)
        }

        .hnav a.active {
            background: var(--gold-bg);
            color: var(--gold);
            font-weight: 600
        }

        .hnav a.ncta {
            margin-left: 8px;
            padding: 7px 18px;
            background: var(--gold);
            color: #fff;
            font-weight: 600;
            border-radius: var(--r6);
            box-shadow: 0 2px 8px rgba(184, 117, 10, .28);
            transition: background .12s, transform .12s, box-shadow .12s;
        }

        .hnav a.ncta:hover {
            background: var(--gold-h);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(184, 117, 10, .38);
            color: #fff
        }

        .hnav a.ncta.active {
            background: var(--gold-h);
            color: #fff
        }

        /* right zone */
        .hright {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto
        }

        /* hamburger */
        .hburger {
            display: none;
            width: 36px;
            height: 36px;
            border: 1px solid var(--bdr2);
            border-radius: var(--r2);
            background: var(--sur);
            color: var(--ink3);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .12s;
        }

        .hburger:hover {
            background: var(--bg2)
        }

        .hburger svg {
            display: block
        }

        /* profile pill */
        .prof {
            position: relative
        }

        .prof-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 4px 10px 4px 4px;
            border: 1px solid var(--bdr);
            border-radius: var(--r6);
            background: var(--sur);
            cursor: pointer;
            box-shadow: var(--s1);
            transition: border-color .12s, box-shadow .12s;
        }

        .prof-btn:hover {
            border-color: var(--bdr2);
            box-shadow: var(--s2)
        }

        .av {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fde8a8, #dba83a);
            color: var(--gold-h);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 11.5px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .av img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .prof-inf {
            min-width: 0
        }

        .prof-inf b {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink2);
            max-width: 110px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            line-height: 1.2;
        }

        .prof-inf small {
            display: block;
            font-size: 11px;
            color: var(--ink4);
            margin-top: 1px
        }

        .pcaret {
            color: var(--ink4);
            font-size: 9px;
            margin-left: 2px;
            transition: transform .17s;
            flex-shrink: 0
        }

        .prof.open .pcaret {
            transform: rotate(180deg)
        }

        /* dropdown */
        .pdrop {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 228px;
            padding: 5px;
            border: 1px solid var(--bdr);
            border-radius: var(--r4);
            background: var(--sur);
            box-shadow: var(--s4);
            opacity: 0;
            pointer-events: none;
            transform: translateY(6px) scale(.97);
            transform-origin: top right;
            transition: opacity .16s, transform .16s;
            z-index: 600;
        }

        .prof.open .pdrop {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0) scale(1)
        }

        .pdh {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            border-radius: var(--r3);
            background: var(--gold-bg);
            margin-bottom: 4px;
        }

        .pdh .av {
            width: 36px;
            height: 36px;
            font-size: 13px
        }

        .pdh b {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink2);
            line-height: 1.2
        }

        .pdh small {
            display: block;
            font-size: 11.5px;
            color: var(--ink3);
            margin-top: 2px;
            word-break: break-all
        }

        .pda {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            border-radius: var(--r2);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink2);
            transition: background .11s;
        }

        .pda:hover {
            background: var(--bg)
        }

        .pda .arr {
            color: var(--ink4);
            font-size: 16px;
            line-height: 1
        }

        .pd-sep {
            height: 1px;
            background: var(--bdr);
            margin: 4px 0
        }

        .pda.out {
            color: var(--err)
        }

        .pda.out:hover {
            background: var(--err-bg)
        }

        /* auth buttons */
        .hbtn {
            display: inline-flex;
            align-items: center;
            height: 34px;
            padding: 0 15px;
            border-radius: var(--r6);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all .12s;
        }

        .hbtn-ol {
            border: 1px solid var(--bdr2);
            color: var(--ink2);
            background: var(--sur)
        }

        .hbtn-ol:hover {
            background: var(--bg2)
        }

        .hbtn-fl {
            background: var(--gold);
            color: #fff;
            box-shadow: 0 2px 8px rgba(184, 117, 10, .26)
        }

        .hbtn-fl:hover {
            background: var(--gold-h);
            transform: translateY(-1px)
        }

        /* ─── MOBILE DRAWER ───────────────────────────── */
        .mob-bg {
            position: fixed;
            inset: 0;
            background: rgba(8, 6, 3, .52);
            backdrop-filter: blur(3px);
            opacity: 0;
            pointer-events: none;
            transition: opacity .22s;
            z-index: 490;
        }

        .mob-bg.open {
            opacity: 1;
            pointer-events: auto
        }

        .mob-drawer {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 495;
            width: 276px;
            max-width: 86vw;
            height: 100dvh;
            overflow-y: auto;
            background: var(--sur);
            border-right: 1px solid var(--bdr);
            box-shadow: var(--s5);
            transform: translateX(-100%);
            transition: transform .24s cubic-bezier(.3, .6, .3, 1);
            display: flex;
            flex-direction: column;
        }

        .mob-drawer.open {
            transform: translateX(0)
        }

        .mdtop {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 14px 12px;
            border-bottom: 1px solid var(--bdr);
            flex-shrink: 0;
        }

        .mdclose {
            width: 32px;
            height: 32px;
            border: 1px solid var(--bdr);
            border-radius: var(--r1);
            background: var(--bg);
            color: var(--ink3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mdnav {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 10px 8px;
            flex-shrink: 0
        }

        .mdnav a {
            display: flex;
            align-items: center;
            padding: 11px 13px;
            border-radius: var(--r3);
            font-size: 14px;
            font-weight: 500;
            color: var(--ink2);
            transition: background .11s;
        }

        .mdnav a:hover {
            background: var(--bg2)
        }

        .mdnav a.active {
            background: var(--gold-bg);
            color: var(--gold);
            font-weight: 600
        }

        .mdnav a.ncta {
            background: var(--gold);
            color: #fff;
            font-weight: 600;
            justify-content: center;
            margin-top: 4px;
        }

        .mdnav a.ncta:hover {
            background: var(--gold-h);
            color: #fff
        }

        .mdfoot {
            margin-top: auto;
            padding: 12px 8px 20px;
            border-top: 1px solid var(--bdr);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mdfoot a {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 42px;
            border-radius: var(--r3);
            font-size: 13.5px;
            font-weight: 600;
        }

        .mdf-ghost {
            background: var(--bg2);
            color: var(--ink2);
            border: 1px solid var(--bdr)
        }

        .mdf-ghost:hover {
            background: var(--bg)
        }

        .mdf-err {
            background: var(--err-bg);
            color: var(--err)
        }

        .mdf-err:hover {
            background: #fecaca
        }

        /* ─── MAIN ────────────────────────────────────── */
        .main {
            position: relative;
            z-index: 1;
            padding: 26px 0 56px
        }

        /* ─── PAGE HERO ───────────────────────────────── */
        .page-hero {
            position: relative;
            overflow: hidden;
            padding: 34px 38px;
            border-radius: var(--r5);
            border: 1px solid var(--bdr);
            background: var(--sur);
            box-shadow: var(--s2);
            margin-bottom: 22px;
        }

        .page-hero::after {
            content: '';
            position: absolute;
            top: -70px;
            right: -70px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(184, 117, 10, .07) 0%, transparent 70%);
            pointer-events: none;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .eyebrow::before {
            content: '';
            width: 16px;
            height: 2px;
            border-radius: 2px;
            background: currentColor;
            display: block;
        }

        .page-title {
            font-family: var(--fd);
            font-size: 48px;
            font-weight: 600;
            line-height: 1.05;
            letter-spacing: -.02em;
            color: var(--ink);
            max-width: 580px;
        }

        .page-subtitle {
            margin-top: 10px;
            font-size: 14.5px;
            line-height: 1.75;
            color: var(--ink3);
            max-width: 540px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px
        }

        /* ─── FLASH ───────────────────────────────────── */
        .flash {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 15px;
            border-radius: var(--r3);
            border: 1px solid transparent;
            font-size: 13.5px;
            font-weight: 500;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .flash-success {
            background: var(--ok-bg);
            border-color: #86efac;
            color: #14532d
        }

        .flash-error {
            background: var(--err-bg);
            border-color: #fca5a5;
            color: #7f1d1d
        }

        /* ─── BUTTONS ─────────────────────────────────── */
        .btn,
        .btn-secondary,
        .btn-ghost,
        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            height: 42px;
            padding: 0 20px;
            border-radius: var(--r6);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all .12s;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .btn {
            background: var(--gold);
            color: #fff;
            box-shadow: 0 2px 8px rgba(184, 117, 10, .28)
        }

        .btn:hover {
            background: var(--gold-h);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(184, 117, 10, .36)
        }

        .btn-secondary {
            background: var(--sur);
            border-color: var(--bdr2);
            color: var(--ink2)
        }

        .btn-secondary:hover {
            background: var(--bg2)
        }

        .btn-ghost {
            background: var(--bg2);
            color: var(--ink2)
        }

        .btn-ghost:hover {
            background: var(--bg)
        }

        .btn-danger {
            background: var(--err-bg);
            color: var(--err)
        }

        .btn-danger:hover {
            background: #fecaca
        }

        .btn-forest {
            background: var(--forest);
            color: #fff;
            box-shadow: 0 2px 8px rgba(28, 61, 53, .22)
        }

        .btn-forest:hover {
            background: var(--forest2);
            transform: translateY(-1px)
        }

        /* ─── SECTION CARD ────────────────────────────── */
        .section-card {
            background: var(--sur);
            border: 1px solid var(--bdr);
            border-radius: var(--r4);
            padding: 24px;
            box-shadow: var(--s1);
            margin-bottom: 20px;
        }

        .section-card.accent-card {
            background: linear-gradient(145deg, var(--forest), #122e27);
            border-color: transparent;
            color: rgba(255, 255, 255, .92);
            box-shadow: 0 8px 28px rgba(28, 61, 53, .22);
        }

        .card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
        }

        .card-head h3 {
            font-family: var(--fd);
            font-size: 28px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.1;
            letter-spacing: -.01em;
        }

        .accent-card .card-head h3 {
            color: #fff
        }

        .card-head p {
            margin-top: 6px;
            font-size: 13.5px;
            color: var(--ink3);
            line-height: 1.65;
            max-width: 640px
        }

        .accent-card .card-head p {
            color: rgba(255, 255, 255, .58)
        }

        .accent-card .eyebrow {
            color: rgba(255, 255, 255, .45)
        }

        .accent-card .eyebrow::before {
            background: rgba(255, 255, 255, .35)
        }

        .text-muted {
            color: var(--ink3)
        }

        /* ─── STATS ───────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px
        }

        .stat-card {
            background: var(--sur);
            border: 1px solid var(--bdr);
            border-radius: var(--r4);
            padding: 20px 22px;
            box-shadow: var(--s1);
            position: relative;
            overflow: hidden;
            transition: box-shadow .14s, transform .14s;
        }

        .stat-card:hover {
            box-shadow: var(--s3);
            transform: translateY(-2px)
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), var(--gold-mid));
            border-radius: var(--r4) var(--r4) 0 0;
        }

        .stat-label {
            display: block;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--ink4);
            margin-bottom: 12px;
        }

        .stat-value {
            display: block;
            font-family: var(--fd);
            font-size: 42px;
            font-weight: 600;
            line-height: 1;
            color: var(--ink);
        }

        .stat-note {
            display: block;
            margin-top: 7px;
            font-size: 12.5px;
            color: var(--ink3);
            line-height: 1.55
        }

        /* ─── SPLIT ───────────────────────────────────── */
        .split-grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 20px
        }

        /* ─── FEATURE / MINI GRIDS ───────────────────── */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px
        }

        .feature-card,
        .mini-item {
            padding: 16px 18px;
            border: 1px solid var(--bdr);
            border-radius: var(--r3);
            background: var(--bg);
            transition: box-shadow .12s;
        }

        .feature-card:hover,
        .mini-item:hover {
            box-shadow: var(--s2)
        }

        .feature-card strong,
        .mini-item strong {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink2)
        }

        .feature-card span,
        .mini-item span {
            display: block;
            margin-top: 5px;
            font-size: 13px;
            color: var(--ink3);
            line-height: 1.6
        }

        /* forest metrics */
        .metric-strip {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px
        }

        .metric-tile {
            padding: 16px 18px;
            border-radius: var(--r3);
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .09);
        }

        .metric-tile strong {
            display: block;
            font-family: var(--fd);
            font-size: 26px;
            color: #f5d782;
            line-height: 1;
        }

        .metric-tile span {
            display: block;
            margin-top: 4px;
            font-size: 12.5px;
            color: rgba(255, 255, 255, .56);
            line-height: 1.55
        }

        /* glass */
        .glass-panel {
            padding: 16px 18px;
            border: 1px solid var(--bdr);
            border-radius: var(--r3);
            background: rgba(255, 255, 255, .6);
        }

        /* ─── TABLE ───────────────────────────────────── */
        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--bdr);
            border-radius: var(--r4);
            background: var(--sur);
            box-shadow: var(--s1);
        }

        table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse
        }

        thead th {
            padding: 12px 15px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--ink4);
            background: var(--bg);
            border-bottom: 1px solid var(--bdr);
        }

        tbody td {
            padding: 14px 15px;
            border-bottom: 1px solid var(--bdr);
            font-size: 13.5px;
            color: var(--ink2);
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none
        }

        tbody tr:hover {
            background: #fafaf7
        }

        .table-title {
            display: block;
            font-weight: 600;
            color: var(--ink)
        }

        .table-note {
            display: block;
            margin-top: 3px;
            font-size: 12.5px;
            color: var(--ink4);
            line-height: 1.55
        }

        /* ─── BADGES ──────────────────────────────────── */
        .badge,
        .pill {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: var(--r6);
            font-size: 11.5px;
            font-weight: 600;
            line-height: 1.4;
        }

        .pill {
            background: var(--bg2);
            color: var(--ink3)
        }

        .badge-pending {
            background: var(--warn-bg);
            color: var(--warn)
        }

        .badge-confirmed,
        .badge-completed,
        .badge-available,
        .badge-approved {
            background: var(--ok-bg);
            color: var(--ok)
        }

        .badge-cancelled,
        .badge-rejected,
        .badge-missing,
        .badge-booked,
        .badge-service {
            background: var(--err-bg);
            color: var(--err)
        }

        /* ─── FORMS ───────────────────────────────────── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px
        }

        .full {
            grid-column: 1/-1
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .10em;
            text-transform: uppercase;
            color: var(--ink3);
        }

        input,
        select,
        textarea {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            border-radius: var(--r3);
            border: 1px solid var(--bdr2);
            background: var(--sur);
            color: var(--ink);
            font-size: 14px;
            outline: none;
            transition: border-color .12s, box-shadow .12s;
        }

        textarea {
            min-height: 100px;
            resize: vertical
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(184, 117, 10, .12);
        }

        input::placeholder,
        textarea::placeholder {
            color: var(--ink4)
        }

        .helper {
            font-size: 12px;
            color: var(--ink4);
            line-height: 1.55;
            margin-top: 5px
        }

        /* ─── VEHICLE CARDS ───────────────────────────── */
        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px
        }

        .vehicle-card {
            border: 1px solid var(--bdr);
            border-radius: var(--r4);
            background: var(--sur);
            overflow: hidden;
            box-shadow: var(--s1);
            transition: box-shadow .14s, transform .14s;
        }

        .vehicle-card:hover {
            box-shadow: var(--s4);
            transform: translateY(-3px)
        }

        .vehicle-media {
            height: 220px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            overflow: hidden;
        }

        .vehicle-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .vehicle-media.vehicle-media-empty {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .vehicle-empty-badge {
            width: 70px;
            height: 70px;
            border-radius: 24px;
            background: rgba(255, 255, 255, .78);
            color: var(--gold-h);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--fd);
            font-size: 28px;
            font-weight: 700;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .04);
        }

        .vehicle-empty-copy {
            max-width: 190px;
            color: var(--ink3);
            font-size: 12px;
            line-height: 1.55;
        }

        .vehicle-body {
            padding: 18px
        }

        .vehicle-card h3 {
            font-family: var(--fd);
            font-size: 22px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.1;
        }

        .vehicle-meta {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--ink4);
            margin-top: 3px;
        }

        .spec-list {
            margin: 14px 0 16px;
            display: flex;
            flex-direction: column;
            gap: 9px
        }

        .spec-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 9px;
            border-bottom: 1px solid var(--bdr);
            font-size: 13px;
        }

        .spec-row:last-child {
            border-bottom: none;
            padding-bottom: 0
        }

        .spec-row span {
            color: var(--ink3)
        }

        .spec-row strong {
            color: var(--ink2);
            font-weight: 600
        }

        /* ─── DOCS ────────────────────────────────────── */
        .docs-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px
        }

        .doc-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border: 1px solid var(--bdr);
            border-radius: var(--r3);
            background: var(--sur);
            transition: box-shadow .12s;
        }

        .doc-card:hover {
            box-shadow: var(--s2)
        }

        .doc-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0
        }

        .doc-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--r2);
            background: linear-gradient(135deg, var(--gold-bg), var(--gold-mid));
            color: var(--gold-h);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
        }

        .doc-meta strong {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink2)
        }

        .doc-meta span {
            display: block;
            margin-top: 3px;
            font-size: 12px;
            color: var(--ink4);
            line-height: 1.5
        }

        .progress-shell {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap
        }

        .progress-bar {
            width: 140px;
            height: 7px;
            background: var(--bg2);
            border-radius: var(--r6);
            overflow: hidden
        }

        .progress-fill {
            height: 100%;
            border-radius: var(--r6);
            background: linear-gradient(90deg, var(--gold), var(--gold-mid))
        }

        /* ─── UPLOAD / EMPTY ──────────────────────────── */
        .upload-panel {
            padding: 22px;
            border: 2px dashed var(--bdr2);
            border-radius: var(--r4);
            background: var(--gold-bg);
            text-align: center;
        }

        .empty-state {
            padding: 32px 20px;
            border: 2px dashed var(--bdr);
            border-radius: var(--r4);
            text-align: center;
            color: var(--ink3);
            font-size: 13.5px;
            line-height: 1.7;
            background: var(--bg);
        }

        /* ─── FOOTER ──────────────────────────────────── */
        .footer-wrap {
            padding-bottom: 26px;
            position: relative;
            z-index: 1
        }

        .footer-panel {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 20px;
            padding: 28px 32px;
            border-radius: var(--r5);
            background: linear-gradient(145deg, var(--forest), #0f2520);
            color: rgba(255, 255, 255, .88);
            box-shadow: 0 20px 56px rgba(15, 37, 32, .22);
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 14px
        }

        .footer-logo {
            width: 46px;
            height: 46px;
            border-radius: var(--r2);
            background: linear-gradient(135deg, #fef0cc, #e8c060);
            box-shadow: 0 4px 16px rgba(184, 117, 10, .20);
            padding: 6px;
            flex-shrink: 0;
        }

        .footer-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain
        }

        .footer-brand strong {
            display: block;
            font-family: var(--fd);
            font-size: 24px;
            font-weight: 600;
            color: #fff;
            line-height: 1;
        }

        .footer-brand span {
            display: block;
            margin-top: 4px;
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .38);
        }

        .footer-note {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px
        }

        .footer-note strong {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .15em;
            text-transform: uppercase;
            color: #f5d782;
        }

        .footer-note p {
            font-size: 13.5px;
            color: rgba(255, 255, 255, .56);
            line-height: 1.7
        }

        /* ─── RESPONSIVE ──────────────────────────────── */
        @media(max-width:1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .vehicle-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .split-grid {
                grid-template-columns: 1fr
            }

            .footer-panel {
                grid-template-columns: 1fr
            }
        }

        @media(max-width:900px) {
            .hnav {
                display: none
            }

            .hburger {
                display: inline-flex
            }

            .hlogo {
                margin-right: 0
            }

            .page-title {
                font-size: 38px
            }
        }

        @media(max-width:680px) {

            .form-grid,
            .docs-grid,
            .metric-strip {
                grid-template-columns: 1fr
            }

            .page-hero {
                padding: 24px 20px
            }

            .hero-title,
            .page-title {
                font-size: 32px
            }

            .section-card {
                padding: 18px
            }
        }

        @media(max-width:520px) {
            .wrap {
                padding: 0 14px
            }

            .stats-grid,
            .vehicle-grid,
            .info-grid {
                grid-template-columns: 1fr
            }

            .prof-inf,
            .pcaret {
                display: none
            }

            .footer-panel {
                padding: 20px 18px
            }

            .hero-actions {
                display: grid
            }

            .hero-actions .btn,
            .hero-actions .btn-secondary {
                width: 100%
            }

            .pdrop {
                left: auto;
                right: 0;
                width: 220px
            }
        }
    </style>
</head>

<body>

    <div class="mob-bg js-mob-bg"></div>

    <!-- ══ HEADER ══════════════════════════════════ -->
    <header class="site-header">
        <div class="wrap hrow">

            <a class="hlogo" href="<?php echo base_url('customer/dashboard'); ?>">
                <div class="hlogo-mark">
                    <img src="<?php echo $brand_logo; ?>" alt="Cab Booking Fast">
                </div>
                <div class="hlogo-txt">
                    <b>Cab Booking Fast</b>
                    <small>Customer Area</small>
                </div>
            </a>

            <nav class="hnav" aria-label="Main">
                <a href="<?php echo base_url('customer/dashboard'); ?>"
                    class="<?php echo $segment2 === 'dashboard' ? 'active' : ''; ?>">Home</a>
                <a href="<?php echo base_url('customer/vehicles'); ?>"
                    class="<?php echo $segment2 === 'vehicles' ? 'active' : ''; ?>">Cars</a>
                <a href="<?php echo base_url('customer/bookings'); ?>"
                    class="<?php echo ($segment2 === 'bookings' && $segment3 !== 'create') ? 'active' : ''; ?>">Bookings</a>
                <a href="<?php echo base_url('customer/payments'); ?>"
                    class="<?php echo $segment2 === 'payments' ? 'active' : ''; ?>">Payments</a>
                <a href="<?php echo base_url('customer/documents'); ?>"
                    class="<?php echo $segment2 === 'documents' ? 'active' : ''; ?>">Documents</a>
                <a href="<?php echo base_url('customer/bookings/create'); ?>"
                    class="ncta <?php echo ($segment2 === 'bookings' && $segment3 === 'create') ? 'active' : ''; ?>">Book a Car</a>
            </nav>

            <div class="hright">
                <button class="hburger js-hburger" type="button" aria-label="Open menu" aria-expanded="false">
                    <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                        <path d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                </button>

                <?php if ($is_customer_logged_in): ?>
                    <div class="prof js-prof">
                        <button class="prof-btn js-prof-btn" type="button" aria-haspopup="true" aria-expanded="false">
                            <div class="av">
                                <?php if ($current_profile_image): ?>
                                    <img src="<?php echo app_profile_image_url($current_profile_image); ?>" alt="<?php echo html_escape($current_name); ?>">
                                <?php else: ?>
                                    <?php echo html_escape($current_initials); ?>
                                <?php endif; ?>
                            </div>
                            <div class="prof-inf">
                                <b><?php echo html_escape($current_name); ?></b>
                                <small>Customer</small>
                            </div>
                            <span class="pcaret">&#9660;</span>
                        </button>

                        <div class="pdrop" role="menu">
                            <div class="pdh">
                                <div class="av" style="width:36px;height:36px;font-size:13px">
                                    <?php if ($current_profile_image): ?>
                                        <img src="<?php echo app_profile_image_url($current_profile_image); ?>" alt="<?php echo html_escape($current_name); ?>">
                                    <?php else: ?>
                                        <?php echo html_escape($current_initials); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <b><?php echo html_escape($current_name); ?></b>
                                    <small><?php echo !empty($current_user['email']) ? html_escape($current_user['email']) : 'Customer Account'; ?></small>
                                </div>
                            </div>
                            <a class="pda" href="<?php echo base_url('customer/bookings'); ?>" role="menuitem">
                                <span>My Bookings</span><span class="arr">›</span>
                            </a>
                            <a class="pda" href="<?php echo base_url('customer/documents'); ?>" role="menuitem">
                                <span>My Documents</span><span class="arr">›</span>
                            </a>
                            <a class="pda" href="<?php echo base_url('customer/profile'); ?>" role="menuitem">
                                <span>My Profile</span><span class="arr">›</span>
                            </a>
                            <div class="pd-sep"></div>
                            <a class="pda out" href="<?php echo base_url('customer/logout'); ?>" role="menuitem">
                                <span>Log Out</span><span class="arr">›</span>
                            </a>
                        </div>
                    </div>

                <?php else: ?>
                    <a class="hbtn hbtn-ol" href="<?php echo base_url('customer/login'); ?>">Log In</a>
                    <a class="hbtn hbtn-fl" href="<?php echo base_url('register'); ?>">Sign Up</a>
                <?php endif; ?>
            </div>

        </div>
    </header>

    <!-- ══ MOBILE DRAWER ═══════════════════════════ -->
    <aside class="mob-drawer js-mob-drawer" aria-label="Mobile navigation">
        <div class="mdtop">
            <a class="hlogo" href="<?php echo base_url('customer/dashboard'); ?>" style="margin-right:0">
                <div class="hlogo-mark" style="width:32px;height:32px;border-radius:7px">
                    <img src="<?php echo $brand_logo; ?>" alt="Cab Booking Fast" style="width:20px;height:20px">
                </div>
                <div class="hlogo-txt">
                    <b style="font-size:15px">Cab Booking Fast</b>
                    <small>Customer Area</small>
                </div>
            </a>
            <button class="mdclose js-mob-close" aria-label="Close menu">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="mdnav">
            <a href="<?php echo base_url('customer/dashboard'); ?>"
                class="<?php echo $segment2 === 'dashboard' ? 'active' : ''; ?>">Home</a>
            <a href="<?php echo base_url('customer/vehicles'); ?>"
                class="<?php echo $segment2 === 'vehicles' ? 'active' : ''; ?>">Cars</a>
            <a href="<?php echo base_url('customer/bookings'); ?>"
                class="<?php echo ($segment2 === 'bookings' && $segment3 !== 'create') ? 'active' : ''; ?>">Bookings</a>
            <a href="<?php echo base_url('customer/payments'); ?>"
                class="<?php echo $segment2 === 'payments' ? 'active' : ''; ?>">Payments</a>
            <a href="<?php echo base_url('customer/documents'); ?>"
                class="<?php echo $segment2 === 'documents' ? 'active' : ''; ?>">Documents</a>
            <a href="<?php echo base_url('customer/bookings/create'); ?>"
                class="ncta <?php echo ($segment2 === 'bookings' && $segment3 === 'create') ? 'active' : ''; ?>">Book a Car</a>
        </nav>

        <div class="mdfoot">
            <?php if ($is_customer_logged_in): ?>
                <a class="mdf-ghost" href="<?php echo base_url('customer/profile'); ?>">My Profile</a>
                <a class="mdf-err" href="<?php echo base_url('customer/logout'); ?>">Log Out</a>
            <?php else: ?>
                <a class="mdf-ghost" href="<?php echo base_url('customer/login'); ?>">Log In</a>
                <a class="mdf-err" href="<?php echo base_url('register'); ?>">Sign Up</a>
            <?php endif; ?>
        </div>
    </aside>

    <!-- ══ MAIN ════════════════════════════════════ -->
    <main class="main">
        <div class="wrap">

            <section class="page-hero">
                <div class="eyebrow">Cab Booking Fast</div>
                <h1 class="page-title"><?php echo html_escape($page_title); ?></h1>
                <p class="page-subtitle"><?php echo html_escape($page_subtitle); ?></p>
            </section>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="flash flash-success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="flash flash-error"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <!-- page views inject content here — wrap .wrap is intentionally left open -->

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var q = function(s) {
                        return document.querySelector(s)
                    };
                    var bg = q('.js-mob-bg'),
                        dr = q('.js-mob-drawer'),
                        ob = q('.js-hburger'),
                        cb = q('.js-mob-close');

                    function open() {
                        dr && dr.classList.add('open');
                        bg && bg.classList.add('open');
                        document.body.classList.add('nav-open');
                        ob && ob.setAttribute('aria-expanded', 'true')
                    }

                    function close() {
                        dr && dr.classList.remove('open');
                        bg && bg.classList.remove('open');
                        document.body.classList.remove('nav-open');
                        ob && ob.setAttribute('aria-expanded', 'false')
                    }
                    ob && ob.addEventListener('click', open);
                    cb && cb.addEventListener('click', close);
                    bg && bg.addEventListener('click', close);

                    var pw = q('.js-prof'),
                        pb = q('.js-prof-btn');
                    if (pw && pb) {
                        pb.addEventListener('click', function(e) {
                            e.stopPropagation();
                            var o = pw.classList.toggle('open');
                            pb.setAttribute('aria-expanded', o ? 'true' : 'false')
                        });
                        document.addEventListener('click', function(e) {
                            if (!pw.contains(e.target)) {
                                pw.classList.remove('open');
                                pb.setAttribute('aria-expanded', 'false')
                            }
                        });
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                pw.classList.remove('open');
                                pb.setAttribute('aria-expanded', 'false');
                                pb.focus()
                            }
                        });
                    }
                });
            </script>
